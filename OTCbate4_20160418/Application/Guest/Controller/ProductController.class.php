<?php 
namespace Guest\Controller;

use Think\Controller;

/**
 * 投资控制器
 * Class ProductController
 * @package Guest\Controller
 * @author by shenjian
 */
class ProductController extends GuestController {
	
		//此为测试使用
    public function showform($ac,$arr){
		echo "<hr><h1>/Guest/Invest/".$ac."</h1>";
        echo '<form method="post" enctype="multipart/form-data" action="/Guest/Invest/'.$ac.'">';
        foreach($arr as $k=>$v){
            $vd='';
            if(!is_numeric($k)){
                $vd=$v;$v=$k;
            }
            list($v,$v2,$v3)=explode('.',$v);
            echo $v.":<input type='".($v2?$v2:'text')."' name='".$v."' value='".$vd."'><br>";
        }
        echo "<input type='submit'>";
        echo "</form>";
    }
    public function aaa(){
        $this->display('Index/try');
		$this->showform('doInvest',['id','amt_ivs','cf_ctl_id','password']);
		$this->showform('cancelInvest',['id']);	
		$this->showform('finishInvest',['id','pos_order']);	
	}	
	
	 /**
     * 产品进度
     */
//    public function getProductSchedule(){
//        $cf_id=I('post.cf_id');
//        $d=D("cf_mast");
//        $data=$d->pschedule($cf_id);
//        $this->printJson($data);
//    }

    /**
     * 获取产品具体一期投资记录
     *
     */
    public function getThisRecord()
    {
        $cf_id=I("post.cfid");//产品id
        $where='true';
        $ctl_id=I('post.ctlid');//当前产品期数
		//测试数据
//		$cf_id=70;
// 		$ctl_id=57;
        if(!$cf_id && !$ctl_id){
            $this->setError('产品id和产品期数必填');
        }else{ 
            $where.=" and a.cod_cf_id=".$cf_id." and a.cod_ctl_id=".$ctl_id.'
             and a.cod_ivs_status=1';
            $p=D('cf_mast');
            $data=$p->getThisList($where);
            $this->printJson($data);
        }
    }
	//投资列表
	public function getInvestList(){
//		$type=I('post.investment_type');
		// $capitalid=I('post.capitalid'); 
//		$res=M('capitalpool')->field('surplus_amount')->where('investment_type='.$type)->find();
//		$surplus_amount=$res['surplus_amount'];
//		$sql = "select t2.amt_ct_last,t2.amt_ct,t1.*,t2.id as period_id,t2.cod_period,t2.ctr_ct_finish,t2.ctr_ct,t2.ctr_ct_last from ".C('DB_PREFIX')."cf_mast t1 left join ".C('DB_PREFIX')."cf_ctl t2
//		on t1.id=t2.cf_mast_id where t1.cod_cf_status in (1,2) and t1.cod_is_delete=0  and t2.ctr_ct_finish<100 group by t1.rat_cf_inv_min order by t1.dat_modify asc";
		$sql="
select * from (
SELECT
( case t2.ctr_ct_finish when 100 then 2  else 1 end) as openorclose,
	 t2.amt_ct_last,
	 (t2.amt_ct- t2.amt_ct_last)  as curr_amt,
	t1.*, t2.id AS period_id,
	t2.cod_period,
	t2.ctr_ct_finish,
	t2.ctr_ct, 
	t2.ctr_ct_last
	 

FROM
	otc_cf_mast t1
LEFT JOIN otc_cf_ctl t2 ON t1.id = t2.cf_mast_id 
WHERE
	t1.cod_cf_status IN (1, 2)

AND t1.cod_is_delete = 0
AND t2.ctr_ct_finish <=100
 
order by t1.rat_cf_inv_min asc,openorclose asc,t1.dat_modify asc,t2.cod_period desc
) as c
group by rat_cf_inv_min 

";
		$list = M('')->query($sql);

//		echo $sql;
//		dump($list);
		foreach($list as $k=>$v){
			$list[$k]['amt_cf_inv_min'] = $v['amt_cf_inv_min']/10000;
			$list[$k]['amt_cf_inv_max'] = $v['amt_cf_inv_max']/10000;
			// $list[$k]['num'] = $v['ctr_ct']-$v['ctr_ct_last']-1;
			 
			$list[$k]['num'] = M('cf_ivs')->where(["cod_ivs_status"=>1,"cf_mast_id"=>$v['id'],"cod_ctl_id"=>$v['period_id']])->count();
			$list[$k]['num']=$list[$k]['num']?$list[$k]['num']:0;
			
			
			$map['cod_cf_id'] = $v['id'];
			if($v['amt_ct_last']<$v['amt_cf_inv_min']||$v['ctr_ct_finish']==100){
				$list[$k]['cod_cf_status']=-1;//已售罄
			}
			if(is_null($v['cod_period'])){
				$list[$k]['cod_period']=0;
			}
			if(is_null($v['ctr_ct_finish'])){
				$list[$k]['ctr_ct_finish']=0;
			}
			$map['cod_ivs_status'] = array('in','1,2');
			$list[$k]['product_amt'] = intval(M('cf_ivs')->where($map)->sum('amt_int_total'));
		}
				
		$this->printJson($list);
	}
	
	//可投资列表项目详情
	public function getInvestInfo(){		
		$sql = "select t1.*,(t2.amt_ct- t2.amt_ct_last)  as curr_amt,t2.ctr_ct,t2.ctr_ct_last,t2.id as period_id,t2.amt_ct as ctl_amt_ct,t2.amt_ct_last as ctl_amt_ct_last,t2.cod_period,t2.ctr_ct_finish,t3.name,t3.cf_mast_id,t3.holder,t3.otc_code,t3.investment_type,
t3.expected_amount,t3.total_amount,t3.surplus_amount,t3.status,t3.validflag,t3.issuer,t3.manager,t3.qqjg,t3.tzfw,
 t3.memo,t3.zjtgf,t3.dbfjs,t3.fxts,t3.zjaq,t3.zqgz,t3.zcaq,t3.usr_create,t3.dat_create,t3.usr_modify,t3.dat_modify from ".C('DB_PREFIX')."cf_mast t1 inner join ".C('DB_PREFIX')."cf_ctl t2
		on t1.id=t2.cf_mast_id left join ".C('DB_PREFIX')."capitalpool t3 on t2.capitalid=t3.id where t1.cod_cf_status=1 and t1.cod_is_delete=0 and t1.id=".I('get.id',0,'intval')." and t2.ctr_ct_last>0 and ctr_ct_finish <100 order by t1.rat_cf_inv_min asc,t2.cod_period desc";

		$list = M('')->query($sql);
		$list = $list[0];
		
		if($list){
			$list['amt_cf_inv_min'] = $list['amt_cf_inv_min']/10000;
			$list['amt_cf_inv_max'] = $list['amt_cf_inv_max']/10000;
			// $list['num'] = $list['ctr_ct']-$list['ctr_ct_last']-1;
			$list['num'] = M('cf_ivs')->where(["cod_ivs_status"=>1,"cf_mast_id"=>$list['id'],"cod_ctl_id"=>$list['period_id']])->count();
			$list['num']=$list['num']?$list['num']:0;
			$map['cod_cf_id'] = $list['id'];
			$map['cod_ivs_status'] = 1;
			$list['product_amt'] = M('cf_ivs')->where($map)->sum('amt_int_total');
			if(is_null($list['product_amt'])){
				$list['product_amt']=0;
			}
			$this->printJson($list);
		}else{
			$this->setError('项目不存在或已被删除');
		}
	}
	
	//最近10条的投资详情
	public function investDetail(){
		$sql = "select t1.*,t2.nam_cust_real from ".C('DB_PREFIX')."cf_ivs t1 inner join ".C('DB_PREFIX')."cust_person t2 on t1.cod_cust_id=t2.cod_cust_id where 
		t1.cod_ivs_status=1 and t1.cod_cf_id=".I('post.id',0,'intval')." limit 10";
		$list = M('')->query($sql);
		foreach($list as $k=>$v){
			$list[$k]['nam_cust_real'] = mb_substr($v['nam_cust_real'],0,1,'utf-8').'**';
		}
		$this->printJson($list);
	}


	/*
	 * 获取一条投资记录的详情-lj
	 * */
	public  function  getThisDetail(){
		$ivs_id=I('post.ivsid',0,'intval');
		//测试数据
//		$ivs_id=1926;
		if(!$ivs_id){
			$this->setError("投资记录id必填");
		}
//		$page=I('post.curpage',1);
//		$limit=I('post.limit',10);
		$where="true";
		$where.=" and a.id=".$ivs_id;

		$i=D('cf_mast');
		$data=$i->getThisDetail($where);
		$this->printJson($data);
	}
	/**
     * 获取投资方式
     */
    public function getCapitalpool(){
		// $list = M('capitalpool')->select();  
		$list=array(
			[
			"investment_type" => "1",
			"capitalid" => "1",
			"memo" => "按金额方式购买",
			"name" => "债权转让"
			],
			[
			"investment_type" => "2",
			"capitalid" => "2",
			"memo" => "按份数方式购买",
			"name" => "收益权转让"
			]
		);
		if($list){ 
			$this->printJson($list);
		}else{
			$this->setError('无购买方式');
		}
    }
	
	
}




?>