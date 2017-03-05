<?php
namespace Guest\Model;

use Think\Log;
use Think\Model;

class ClCtlModel extends Model
{
	//根据申购额度 匹配债权
	// @param  $cod_ivs_type  投资类型 
	// @param  $amt_ivs  申购金额
	// @param  $capitalid  资金表ID
	public function getClCtl($cod_ivs_type,$amt_ivs,$capitalid){
		
		$this->startTrans();
		$map['type'] = $cod_ivs_type;
		$map['capitalid'] = $capitalid;
		$map['validflag'] = 1;
		$map['amt_ct_last']  = array('GT',0);
		$cl_ctl_list = $this->lock(true)->where($map)->order('dat_modify ASC')->select();
		// dump($map);
		// dump($cl_ctl_list);
		//记录总债权金额
		$total = $flag =0;
		$break =0;
		$use_list = array();
		foreach($cl_ctl_list as $v){
			$data = array();
			$savemap = array('id'=>$v['id']);
			
			$total+=$v['amt_ct_last'];
			//如果总债权金额大于等于申购金额  跳出循环
			if($total>=$amt_ivs){
				$flag = 1;
				if($total == $amt_ivs){
					$amt_ct_use = $v['amt_ct_last'];
					$data['amt_ct_last'] =  array('exp','amt_ct_last - '.$amt_ct_use); 
					$data['ctr_ct_finish'] = array('exp','((amt_ct - (amt_ct_last)) / amt_ct)*100'); //.($v['amt_ct_last']-($total-$amt_ivs)));floor((($v['amt_ct']-$data['amt_ct_last'])/$v['amt_ct'])*100);
					$savemap['amt_ct_last']  = array('EGT',$amt_ct_use);
					if($this->where($savemap)->save($data)){
						$use_list[] = array('id'=>$v['id'],'cod_cl_id'=>$v['cod_cl_id'],'amt_ct'=>$v['amt_ct'],'amt_ct_use'=>$v['amt_ct_last'],'amt_ct_last'=>0,'flag'=>0);
						$break = 1;
					}else{
						$total-=$v['amt_ct_last'];
					}
				}else{
					//最后一个债权未被全额占用
					$amt_ct_use = $v['amt_ct_last']-($total-$amt_ivs);
					$data['amt_ct_last'] =  array('exp','amt_ct_last - '.$amt_ct_use); 
					$data['ctr_ct_finish'] = array('exp','((amt_ct - (amt_ct_last)) / amt_ct)*100'); //.($v['amt_ct_last']-($total-$amt_ivs)));floor((($v['amt_ct']-$data['amt_ct_last'])/$v['amt_ct'])*100);
					$savemap['amt_ct_last']  = array('EGT',$amt_ct_use);
					if($this->where($savemap)->save($data)){
						$use_list[] = array('id'=>$v['id'],'cod_cl_id'=>$v['cod_cl_id'],'amt_ct'=>$v['amt_ct'],'amt_ct_use'=>$amt_ct_use,'amt_ct_last'=>$total-$amt_ivs,'flag'=>1);
						$break = 1;
					}else{
						$total-=$v['amt_ct_last'];
					}
				}
				
			}else{
				//记录占用的债权  
				//id【债权进度主键ID】 cod_cl_id【债权ID】 amt_ct【债权总金额】 amt_ct_use【此次占用额度】   amt_ct_last【占用后债权剩余金额】 flag 【0全额占用，1未全额占用】
				$amt_ct_use = $v['amt_ct_last'];
				$data['amt_ct_last'] =  array('exp','amt_ct_last - '.$amt_ct_use); 
				$data['ctr_ct_finish'] = array('exp','((amt_ct - (amt_ct_last)) / amt_ct)*100'); //.($v['amt_ct_last']-($total-$amt_ivs)));floor((($v['amt_ct']-$data['amt_ct_last'])/$v['amt_ct'])*100);
				$savemap['amt_ct_last']  = array('EGT',$amt_ct_use);
				if($this->where($savemap)->save($data)){
					$use_list[] = array('id'=>$v['id'],'cod_cl_id'=>$v['cod_cl_id'],'amt_ct'=>$v['amt_ct'],'amt_ct_use'=>$v['amt_ct_last'],'amt_ct_last'=>0,'flag'=>0);
				}else{
					$total-=$v['amt_ct_last'];
				}
			}
			
			if($break){
				break;
			} 
		}
		
		if($flag==1){
			$this->commit();
			$result = array('status'=>1,'msg'=>'OK','data'=>$use_list);
			
		}else{
			//系统错误，债权额度不足
			$this->rollback();
			if($flag==2){
				$result = array('status'=>0,'msg'=>'确认签署失败，请重试！');
			}else{
				$result = array('status'=>0,'msg'=>'系统错误，债权额度不足');
			}
		}		
		return $result;
	}


	
}


?>