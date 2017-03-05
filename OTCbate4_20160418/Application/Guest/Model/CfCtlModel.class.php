<?php
namespace Guest\Model;

use Think\Log;
use Think\Model;

class CfCtlModel extends Model
{
	//验证盒子的期数ID
	// @param  $cf_mast_id  盒子ID  $cf_ctl_id  期数ID   $type  投资类型 1债权转让  2收益权转让 $amt  投资金额  $min_tzje 产品最小投资金额
	public function checkCfCtl($cf_mast_id,$cf_ctl_id,$type,$amt,$min_tzje){
		//获取该期的数据
		// $map = array('id'=>$cf_ctl_id,'cf_mast_id'=>$cf_mast_id,'type'=>$type);//2种模式分开操作期数
		$map = array('id'=>$cf_ctl_id,'cf_mast_id'=>$cf_mast_id);//2种模式统一用一个期
		$list = $listold= $this->where($map)->order("cod_period desc")->find();
		// print_r($amt);
		 // exit;
		if(empty($list)){
			$result = array('status'=>0,'msg'=>'数据错误！');
		}else{
			//验证该期是否可投资 
			if($list['ctr_ct_last']>0&&$list['ctr_ct_finish']<100){
				if($list['amt_ct_last']>=$amt){
					//剩余可投资份数大于0 可投资
					//更新期数数据
					$data = array(
						'amt_ct_last'=>array('exp',"amt_ct_last - {$amt}"),
						'ctr_ct_last'=>array('exp','ctr_ct_last - 1'),
						// 'ctr_ct_finish'=>array('exp','floor((1-(ctr_ct_last/ctr_ct))*100)'),//floor((1-($list['ctr_ct_last']-1)/$list['ctr_ct'])*100),
						'ctr_ct_finish'=>array('exp','floor((1-(amt_ct_last/amt_ct))*100)'),//floor((1-($list['ctr_ct_last']-1)/$list['ctr_ct'])*100),
						// 'dat_modify'=>date("Y-m-d H:i:s",time()),
					);
					$status = $this->where(array('id'=>$list['id'],"ctr_ct_last"=>array("EGT","1"),"amt_ct_last"=>array("EGT",$amt)))->save($data);
					if(!$status){
						$result = array('status'=>0,'msg'=>'购买失败，请刷新页面');
					}else{ 
						$map = array('b.id'=>$cf_mast_id);
						$mast_list = M('capitalpool')->alias("a")
						->join("__CF_MAST__ b on a.id =b.capitalid","inner")
						->join("__CF_CTL__ c  on b.id = c.cf_mast_id","inner")
						->field("a.total_amount,a.surplus_amount, sum(c.amt_ct) as shiyong, (a.total_amount- sum(c.amt_ct) ) as shengyu,b.each_amt,b.*")
						->where($map)
						->find(); 
						if(!$mast_list){
							$result = array('status'=>0,'msg'=>'数据错误');
						}else{ 
							// if($mast_list['cod_cf_inv_type'] == "1"){
								// $min_tzje=$mast_list['amt_cf_inv_min'];
							// }else if($mast_list['cod_cf_inv_type'] == "2"){
								// $min_tzje=$mast_list['amt_ct_min']*$mast_list['amt_cf_inv_each']; 
							// }
							$min_tzje=$mast_list['amt_cf_inv_min'];
							$meiqijine=min($mast_list['each_amt'],$mast_list['surplus_amount']);
							//资金表剩余支持最小投资 以及 (如果剩余份数为0 或剩余金额不足当前继续投资 ) 开启新一期
							
							$map = array('id'=>$cf_ctl_id,'cf_mast_id'=>$cf_mast_id);//2种模式统一用一个期
							$list = $this->where($map)->order("cod_period desc")->find();
							// $dqshengyu = $list['amt_ct_last']-$amt;
							$dqshengyu = $list['amt_ct_last'];
							
							// dump($dqshengyu);
							// dump($min_tzje);
							$data = array( 
								'ctr_ct_finish'=>array('exp','100'),
								// 'dat_modify'=>date("Y-m-d H:i:s",time()),
							); 
							$closestatus = $this->where("id = {$list['id']} and (amt_ct_last < {$min_tzje} or ctr_ct_last < 1 )")->save($data);
							
							$result = array('status'=>1,'msg'=>'OK','data'=>$list); 
							 
							if(($listold['ctr_ct_last']-1<=0||$dqshengyu<=0||$dqshengyu-$min_tzje<0||$closestatus)){
								$beiyongZCB=$this->getCanUseCapital($mast_list['id']);
								if($meiqijine>=$min_tzje||$beiyongZCB){
									$data = array(
										'cf_mast_id'=>$cf_mast_id,
										// 'type'=>$type,//2种模式分开操作期数
										'type'=>0,//2种模式统一用一个期
										'cod_period'=>$list['cod_period']+1,
										'capitalid'=>$mast_list['capitalid'],
										'amt_ct'=>$meiqijine,
										'amt_ct_last'=>$meiqijine,
										'ctr_ct'=>200,
										'ctr_ct_last'=>0,
										'ctr_ct_finish'=>101,
										'dat_modify'=>date("Y-m-d H:i:s",time()),
									);  
									$newid = $this->add($data);
									if($newid){
										// $status = M('Capitalpool')->where("status = 2 and id='{$mast_list['capitalid']}' and investment_type='{$mast_list['cod_cf_inv_type']}' and surplus_amount >= '{$meiqijine}'  and {$newid} = (SELECT id FROM `otc_cf_ctl`  where cf_mast_id ={$mast_list['id']} and capitalid = {$mast_list['capitalid']}  and (ctr_ct_finish =101 or ctr_ct_finish <100  ) limit 1) ")->setDec('surplus_amount',$meiqijine);
										$status = M('Capitalpool')->where("status = 2 and id='{$mast_list['capitalid']}' and investment_type='{$mast_list['cod_cf_inv_type']}' and surplus_amount >= '{$meiqijine}'  and {$newid} = (SELECT id FROM `otc_cf_ctl`  where cf_mast_id ={$mast_list['id']} and capitalid = {$mast_list['capitalid']}   order by cod_period desc,id asc limit 1) ")->setDec('surplus_amount',$meiqijine);
										// echo M('Capitalpool')->getLastSql(); 
										if($status&&$meiqijine>=$min_tzje){ //成功则更新新期
											// echo M('Capitalpool')->getLastSql();  
											$this->where(["id"=>$newid])->save(["ctr_ct_finish"=>0,"ctr_ct_last"=>199]);
										}else{ //失败则删除新期 
											$delstatus = $this->delete($newid); 
											 
											
											// 当前资产包是否资产不足 并非备用资产包存在
											// dump($beiyongZCB);
											
											//判断当前资产包是否资产足够 1为足够  0为不足
											$count = M('Capitalpool')->where("id='{$mast_list['capitalid']}' and investment_type='{$mast_list['cod_cf_inv_type']}' and surplus_amount >= '{$meiqijine}' and surplus_amount >'{$min_tzje}'   ")->count();
											
												
											// break;
											if($beiyongZCB&&$count==0&&$meiqijine<$min_tzje){
												
												$newMeiqijine = min($beiyongZCB['surplus_amount'],$mast_list['each_amt']);
												$data = array(
													'cf_mast_id'=>$cf_mast_id,
													// 'type'=>$type,//2种模式分开操作期数
													'type'=>0,//2种模式统一用一个期
													'cod_period'=>$list['cod_period']+1,
													'capitalid'=>$beiyongZCB['id'],
													'amt_ct'=>$newMeiqijine,
													'amt_ct_last'=>$newMeiqijine,
													'ctr_ct'=>200,
													'ctr_ct_last'=>0,
													'ctr_ct_finish'=>101,
													'dat_modify'=>date("Y-m-d H:i:s",time()),
												);
												 
												$newid = $this->add($data);
												
												//得到新资产包支持的新一期额度
												
												// echo $newid;
												 $newstatus = M('Capitalpool')->where("id='{$beiyongZCB['id']}' and investment_type='{$beiyongZCB['investment_type']}' and surplus_amount >= '{$newMeiqijine}'  and {$newid} = (SELECT id FROM `otc_cf_ctl`  where cf_mast_id ={$mast_list['id']} and capitalid = {$beiyongZCB['id']}  and (ctr_ct_finish =101 or ctr_ct_finish <100  ) limit 1) ")->setDec('surplus_amount',$newMeiqijine);
												// echo M('Capitalpool')->getLastSql();
												if($newstatus){//新的资产包金额扣除成功
													$data=array(
														"capitalid"=>$beiyongZCB['id'],
														"cod_cf_inv_type"=>$beiyongZCB['investment_type'],
													);
													$cfmaststatus = M("CfMast")->where(["id"=>$mast_list['id']])->save($data);//,"capitalid"=>array("neq",$beiyongZCB['id'])
													$cfctldata=array(
														"amt_ct"=>$newMeiqijine,
														"amt_ct_last"=>$newMeiqijine,
														"capitalid"=>$beiyongZCB['id'],
													);
													 
													$cfctlstatus = $this->where(["id"=>$newid])->save($cfctldata);
													if($cfmaststatus>=0&&$cfctlstatus>=0){//产品挂钩新资产包成功 并新期内容更新成功
														 
														$this->where(["id"=>$newid])->save(["ctr_ct_finish"=>0,"ctr_ct_last"=>199]);
													}else{
														
														$data=array(
															"capitalid"=>$mast_list['capitalid'],
															"cod_cf_inv_type"=>$mast_list['cod_cf_inv_type'],
														);
														M("CfMast")->where(["id"=>$mast_list['id']])->save($data);
														M('Capitalpool')->where("id='{$beiyongZCB['id']}' and investment_type='{$beiyongZCB['investment_type']}' ")->setInc('surplus_amount',$newMeiqijine);
														$this->delete($newid); 
													}
												}else{
													$this->delete($newid); 
												}
												
											} 
											// $result = array('status'=>0,'msg'=>'该产品剩余可生期不足');
										}
									}else{
									 
									}
								}
							}
							
						}
					}
				}else{
					$result = array('status'=>0,'msg'=>'当期剩余金额不足，请重新再试');
				}
			}else{
				$result = array('status'=>0,'msg'=>'当期份数已满，请刷新页面');
			}
		}
		
		return $result;
	}
	
	//获取当前产品备用的第一个满足条件的资产包
	
	public function getCanUseCapital($cfmastid){
		$map=array(
			"a.id"=>$cfmastid,
			"b.status"=>2,
			"b.surplus_amount"=>array("exp"," > a.amt_cf_inv_min"),
			"b.id"=>array("exp"," <> a.capitalid"),
		);
		$data = D("CfMast")->alias("a")
				->join("__CAPITALPOOL__ b on b.cf_mast_id = a.id","inner")
				->where($map)
				->order("b.dat_modify asc")
				->find();
		 // D("CfMast")->getLastSql();
		return $data;
	}
	
	

}

?>