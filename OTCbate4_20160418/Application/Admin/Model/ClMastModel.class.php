<?php
namespace Admin\Model;
use Think\Log;
use Think\Model;

class ClMastModel extends Model{
	protected $_validate=array(
		array('product_name','require','请填写债权名称'),
		array('borrower','require','请填写借款人姓名'),
		array('cod_card_no','require','请填写证件号码'),
		array('amt_cf_inv_price','/^[-\+]?\d+(\.\d+)?$/','请填写正确的债权金额'),
		array('type',array(1,2),'请选择投资模式',1,'in'),
		array('rat_cf_inv_min', '/^[-\+]?\d+(\.\d+)?$/', '请输入正确的年化收益率'),
        array('product_name','checklength','债权名称不能超过255个字符',0,'callback',3,[0,255]),
        array('use','checklength','债权用途不能超过255个字符',0,'callback',3,[0,255]),
		// array('startdate', 'require', '请输入开始日期',1),
        // array('enddate', 'require', '请输入结束日期',1),
	);
	protected $_auto=array(

	);
    function checklength($str, $min, $max) {
        preg_match_all("/./u", $str, $matches);
        $len = count($matches[0]);
        if ($len < $min || $len > $max) {
            return false;
        } else {
            return true;
        }
    }
	/**
     * 债权列表搜索录入期限选项值
     */
	static $createdate_select = array(
			'0'=>'不限',
			'1'=>'一周内',
			'2'=>'一个月内',
			'3'=>'三个月内',
			'4'=>'三个月以上',
	); 
	/**
     * 债权列表搜索录入期限选项对应时间值
     */
	static $createdate_value = array(
			'0'=>'',
			'1'=>'-1 week',
			'2'=>'-1 month',
			'3'=>'-3 month',
			'4'=>'-3 month',
	); 
	/**
     * 债权列表搜索状态选项值
     */
	static $status_select = array(
		    '0'=>'未完成',
			'1'=>'待审核',
			'2'=>'待发布',
			'3'=>'审核退回',
			'4'=>'待销售',
			'5'=>'销售中',
			'6'=>'已售罄',
            '10'=>'发布退回',
	);
	/**
     * 投资模式选项
     */
	static $type_select = array(
		    '1'=>'债权资产',
			'2'=>'收益权资产',
	);
	
	/*投资状态*/
	static $ivs_status = array(
		'1' => '已成交',
		'2' => '已赎回',
	);
	/**
     * 债权发布后更新可用额度
     */
	public function updateCapacity($id,$userid)
	{
		//获取已发布的债权同时没有生效中的债权进度记录  
		$result =$this->field("d.*")
		->table('__' . strtoupper('Cl_mast'). '__ as d')
		->join('__' . strtoupper('Cl_ctl'). '__ as e ON d.id = e.cod_cl_id','left')
		->where("d.id = {$id} and d.status =4 and (e.id is null ) ")
		->find(); 
		// $result=$this->where(array('id'=>$id))->find();
		if($result){
	/*		$data['amt_ct']=$result['amt_cf_inv_price'];
			$data['amt_ct_last']=$result['amt_cf_inv_price'];
			$data['ctr_ct_finish']=0;
			$data['validflag']=1;
			$data['cod_cl_id']=$result['id'];;
			$data['cod_cf_id']=$result['cf_mast_id'];
			$data['dat_modify']=date("Y-m-d H:i:s",time()); */
			$data['amt_ct']=$result['amt_cf_inv_price'];
			$data['amt_ct_last']=$result['amt_cf_inv_price'];
			$data['ctr_ct_finish']=0;
			$data['validflag']=1;
            $data['capitalid']=$result['capitalid'];
			$data['cod_cl_id']=$result['id'];
			$data['type']=$result['type'];
			$data['dat_modify']=date("Y-m-d H:i:s",time());
			$model = M("ClCtl");
			if(!$model->create($data)){
				return false;
			}else{
				$clid=$model->add();
				if($clid){
					$status = $this->changeCapacity($result['type'],$result['amt_cf_inv_price'],$result['capitalid']);
					if($status){
						//更新发布时间
						$data = array(
							'dat_modify' => date('Y-m-d H:i:s'),
							'usr_modify' =>$userid ,
						);
						// echo $count=M("ClMast")->where(array("cf_mast_id"=>$result['cf_mast_id'],"status"=>"5"))->count();
						// if($count == 0){
							// $data['status'] = 5;
						// }
						$status =  M("ClMast")->where("id = {$id}")->save($data); 
						return true;
					}else{
						//回滚发布状态
						$data = array(
							'status' => 2,
						);
						M("ClCtl")->where("id = {$clid}")->delete();
						$status =  M("ClMast")->where("id = {$id}")->save($data);
						return false;
					}
				}else{
					//回滚发布状态
					$data = array(
						'status' => 2,
					);
					$status =  M("ClMast")->where("id = {$id}")->save($data);
					return false;
				}
			}
		}else{
			//回滚发布状态
			$data = array(
				'status' => 2,
			);
			$status = M("ClMast")->where("id = {$id}")->save($data);
			return false;
		}
		
	}
	/**
     * 债权down后更新可用额度
     */
	 
	public function down2updateCapacity($id,$userid)
	{
		$result =$this->field("d.*,e.amt_ct,e.id as ctlid")
		->table('__' . strtoupper('Cl_mast'). '__ as d')
		->join('__' . strtoupper('Cl_ctl'). '__ as e ON d.id = e.cod_cl_id','inner')
		->where("d.id = {$id} and d.status =2  and e.ctr_ct_finish = 0 ")
		->find();
	   // $result=$this->where(array('id'=>$id))->select();
		if($result){
			$status = $this->changeCapacity($result['type'],"-".$result['amt_cf_inv_price'],$result['capitalid']);
			if($status){
				//更新发布时间
				$data = array(
					'dat_modify' => date('Y-m-d H:i:s'),
					'usr_modify' =>$userid ,
				);
				$status =  M("ClMast")->where("id = {$id}")->save($data);
				$status =  M("ClCtl")->where("cod_cl_id = {$result['id']}")->delete();
				return true;
			}else{
				//回滚发布状态
				$data = array(
					'status' => 4,
				);
				$status = M("ClMast")->where("id = {$id}")->save($data);
				return false;
			}
		}else{
			 
			//回滚发布状态
			$data = array(
				'status' => 4,
			);
			$status = M("ClMast")->where("id = {$id}")->save($data);
			return false;
			
		}
   
	} 
	
	/**
     * 调整可用额度
     */
	public function changeCapacity($type,$price,$capitalid='')
	{
	/*	if($price>=0){
			return M("CfMast")->where('id='.$id)->setInc("amt_ct",abs($price));
		}else{
			return M("CfMast")->where('id='.$id)->setDec("amt_ct",abs($price));
		}*/
		$m=M('capitalpool');
	  if($price>=0){
		   //开始事务
		   $m->startTrans();
		       $total=$m->where(array('investment_type'=>$type,id=>$capitalid))->setInc("total_amount",abs($price));      //save(array("total_amount"=>(total_amount+$price)));  //);

		       $free=$m->where(array('investment_type'=>$type,id=>$capitalid))->setInc("surplus_amount",abs($price));                 // save(array("surplus_amount"=>"surplus_amount+$price"));                   //

		  if($total&&$free){
			  $m->commit();
			  return true;
		  }else{
			   //huigun
			  $m->rollback();
			  return false;
		  }
	  }else{
		      //下回前确认金额
		     $price=abs($price);
		     $result=$m->execute("UPDATE otc_capitalpool SET  total_amount=total_amount-{$price},surplus_amount=surplus_amount-{$price} WHERE id={$capitalid} AND investment_type={$type} AND surplus_amount-{$price}>=0");
		  if($result){
			  return true;
		  }else{
			  return false;
		  }
	  }



	}


	
}