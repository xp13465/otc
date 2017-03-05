<?php
namespace Guest\Model;

use Think\Log;
use Think\Model;

class CustCrmModel extends Model
{
// 客户来源：source
// 客户名称：custname
// 顾问：consultant
// 所属团队：team
// 门店经理：storemanager
// 门店：store
// 分部：division
// 区域经理：areamanager
// 产品类型：producttype
// 收款日期：receiptdate
// 合同金额：contractamount
// 合同编号：contractno
// 收款金额：receivablesamount
// 年化收益率：rateofreturn
// 期数：installments
// 收款方式：paymentmethod
// 续投与否：iscontinued
// 预计出款日：plandate
// 出款金额（本金）：outprincipal
// 出款金额（利息）：outinterest
// 实收管理费：realmanagementfee
// 违约金费率：breakcontractamountrate
// 违约金额：breakcontractamount
// 客户生日：birthday
// 联系电话：tel
// 邮编：bizcode
// 地址：address
// 银行账户：bankaccount
// 开户行：bankopen
// 资料邮寄方式：informationbypost
// 备注：memo
    protected $_validate = array(
        array('cod_cust_id', 'require', 'cod_cust_id为空')
    );
    protected $_auto = array(
        array('dat_modify', 'date', 3, 'function', 'Y-m-d H:i:s'),
    );
    /**
     * 申购管理的状态-lj
     */
    static $code_ivs_status=array(
    		'-1'=>'已作废',
			'0'=>'待确认',
			'1'=>'已完成',
			'2'=>'不限'
			);

	/**
	*crm的添加
	*理应在用户开户时即自动添加
	*/
    public function crmadd($cod_cust_id,$data=array()){
		/*"cod_cust_id_no"=>$cno,
                                        "nam_cust_real"=>I('post.nam_cust_real'),
                                        "dat_cust_birthday'"=>$data['dat_cust_birthday'],
										"cod_cust_zip"=>$data['cod_cust_zip'],
										"cod_cust_gender"=>$data['cod_cust_gender'],*/
        return $this->add(array("cod_cust_id"=>$cod_cust_id,
								"custname"=>$data['nam_cust_real'],
								"birthday"=>$data['dat_cust_birthday'],
								"bizcode"=>$data['cod_cust_zip']
								));
    }
	/**
	*获取用户crm
	*/
    public function getcrm($uid){
        return $this->where(array('cod_cust_id'=>(int)$uid))->find();
    }
	/**
	*通过表单重新设制用户crm
	*/
	public function crm_set($uid){
		$r=$this->where(array('cod_cust_id'=>$uid))->save(I('post.'));
		if($r){
			//更新维护信息
			D('cust_person')->custmodify($uid);
		}
		return $r;
	}

	/*申购管理页面*/
	public function ivslist($condition,$curpage,$limit){
		$data['items'] = M('cf_ivs')
			->alias('ci')
			->field('ci.id,ci.cod_ctl_id,ci.product_code,ci.amt_ivs,ci.ctl_ivs_cnt,
			ci.amt_int_total,ci.pos_order,ci.cod_ivs_status,ci.dat_create as dat_modify,c.title,c.code,ci.amt_time,
			d.cod_period,b.nam_cust_real,b.cod_cust_id_no,ou.realname as user_name,od.name as department_name')
			->join('__CUST_PERSON__ b on ci.cod_cust_id=b.cod_cust_id')
			->join('__CF_MAST__ c on ci.cod_cf_id=c.id')
			->join('__CF_CTL__ d on ci.cod_ctl_id=d.id')
			->join('__USER__ as ou on ou.id=ci.usr_create','left')
			->join('__DEPARTMENT__ as od on od.id=ou.department_id','left')
			->where($condition)->order('ci.dat_create desc')->page($curpage,$limit)->select();
			//$data['sql']=M('')->getLastSql();
		$data['total'] = M('cf_ivs')
			->alias('ci')->field('ci.id,ci.cod_ctl_id,ci.product_code,
		ci.amt_ivs,ci.ctl_ivs_cnt,ci.amt_int_total,
		ci.pos_order,ci.cod_ivs_status,ci.dat_modify,ci.amt_time,
		c.title,c.code,d.cod_period,b.nam_cust_real,b.cod_cust_id_no,ou.realname as user_name,od.name as department_name')
			->join('__CUST_PERSON__ b on ci.cod_cust_id=b.cod_cust_id')
			->join('__CF_MAST__ c on ci.cod_cf_id=c.id')
			->join('__CF_CTL__ d on ci.cod_ctl_id=d.id')
			->join('__USER__ as ou on ou.id=ci.usr_create','left')
			->join('__DEPARTMENT__ as od on od.id=ou.department_id','left')
			->where($condition)->count();
		

		foreach($data['items'] as $k=>$v){
		//	$data['items'][$k]['cod_cust_id_no']=do_codcustidno($data['items'][$k]['cod_cust_id_no']);
			$data['items'][$k]['product_code']=$data['items'][$k]['title'].$data['items'][$k]['cod_period'].'期';
			$data['items'][$k]['dobuy']=D('User')->checkPermission("Guest-Invest-finishInvest")?1:0;
			$data['items'][$k]['cancel']=D('User')->checkPermission("Guest-Invest-cancelInvest")?1:0;
			$time = strtotime("+ {$v['amt_time']} month -1 day",strtotime($v['dat_modify']));  
			if(time > strtotime(date("Y-m-d 23:59:59",$time))){
				$data['items'][$k]['redemption']=0;
			}else{
				$data['items'][$k]['redemption']=D('User')->checkPermission("Guest-Invest-redemptionInvest")?1:0;
			}
			
			
		}
		return $data;
	}
}