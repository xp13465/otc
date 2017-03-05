<?php
namespace Admin\Model;
use Think\Log;
use Think\Model;
class  CapitalpoolModel extends  Model{
	protected    $_validate = array(
			array('name','require','资产名称不能为空!'),
			array('issuer','require','发行方不能为空'),
			array('manager','require','管理人不能为空'),
			array('zjtgf','require','资金手写方不能为空'),
			array('all_amount','require','总募规模不能为空'),
//			array('cf_mast_id','require','产品名称不能为空'),
			array('issuer','checklength','发行方不能超过255个字符',0,'callback',3,[0,255]),
			array('manager','checklength','管理人不能超过255个字符',0,'callback',3,[0,255]),
			array('memo','checklength','项目介绍不能超过2000个字符',0,'callback',3,[0,2000]),
			array('zjtgf','checklength','资金托管方不能超过2000个字符',0,'callback',3,[0,2000]),
			array('dbgs','checklength','担保公司不能超过255个字符',0,'callback',3,[0,255]),
			array('dbfjs','checklength','担保方介绍不能超过2000个字符',0,'callback',3,[0,2000]),
			array('fxts','checklength','风险提示不能超过2000个字符',0,'callback',3,[0,2000]),
			array('zjaq','checklength','资金安全不能超过2000个字符',0,'callback',3,[0,2000]),
			array('zqgz','checklength','债权规则不能超过2000个字符',0,'callback',3,[0,2000]),
			array('zcaq','checklength','资产安全不能超过2000个字符',0,'callback',3,[0,2000]),
			array('qqjg','checklength','确权机构不能超过255个字符',0,'callback',3,[0,255]),
			array('dbfjs','checklength','担保方介绍不能超过2000个字符',0,'callback',3,[0,2000]),
			array('syfpr','checklength','收益分配日不能超过255个字符',0,'callback',3,[0,255]),
			array('tzfw','checklength','投资范围不能超过255个字符',0,'callback',3,[0,255]),
		);
	
	static $status_select = array(
			'0'=>'未完成',
			'1'=>'待审核',
			'2'=>'审核通过',
			'3'=>'审核退回',
			'4'=>'暂停使用',
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
	 * 	恢复使用资产包
	 */
	public function Found_resume($id){
		$res=$this->field('status')->where(array('id'=>$id,"validflag"=>'1'))->find();
//		return $r;
		if(!$res){
			$this->error="资产包不存在";
			return false;
		}elseif($res['status']!=4){
			$this->error="资产包未暂停使用";
			return false;
		}
		$r= $this->where(array('id'=>$id,'status'=>'4'))->save(array("status"=>'2'));
//		return M()->_sql();
		if($r===false){
			$this->error="恢复使用失败";
			return false;
		}elseif($r==0){
			$this->error="资产包已恢复使用";
			return false;
		}else{
			return $r;
		}
	}
	
	/**
	*  暂停使用资产包
	*/
    public function Found_pause($id){
		$r=$this->field('status')->where(array('id'=>$id,"validflag"=>'1'))->find();
		if(!$r){
			$this->error="资产包不存在";
			return false;
		}else if($r['status']!=2){
			$this->error="资产包还未使用";
			return false;
		}elseif($r['status']=='4'){
			$this->error="此投资产品已经是暂停销售的状态";
			return false;
		} 
		$r= $this->where(array('id'=>$id,'status'=>'2'))->save(array("status"=>'4'));
		if($r===false){
			$this->error="暂停使用失败";
			return false;
		}elseif($r==0){
			$this->error="资产包已暂停使用";
			return false;
		}else{
			return $r;
		}
    }
	
	//回购资产包剩余债权
    //$id资产包id,
    //$repurchaseNum回购金额
	public function repurchase($id,$repurchaseNum,$mid){
		$map=[];
		$map["a.id"]=$id;
        // $amt_cf_inv_min=M('cf_mast')->field('amt_cf_inv_min')->where(['capitalid'=>$id])->find();
		$map["a.surplus_amount"]=array("exp"," < c.amt_cf_inv_min");//array('lt',$amt_cf_inv_min['amt_cf_inv_min']);
		$data = $this->alias("a")->field("b.*,a.investment_type")
		->join("__CF_CTL__ b on a.id = b.capitalid ")
		->join("__CF_MAST__ c on a.cf_mast_id = c.id ")
		->order("cod_period desc")
		->where($map)->select();
		// echo $this->getLastSql();
		if(!$data){
			$result = array('status'=>0,'msg'=>'当前资产包不可回购');
			return $result;
		}
		if(!$repurchaseNum){
			$result = array('status'=>0,'msg'=>'请输入回购金额！');
			return $result;
		}
		if(($repurchaseNum%10000)>0){
			$result = array('status'=>0,'msg'=>'请输入正确的回购金额，单位万');
			return $result;
		}
        //有未确认交易
        //cod_ivs_status
         $info=M('cf_ivs')->field('cod_ivs_status')->where(['capitalid'=>$id,cod_ivs_status=>0])->select();
        if(!empty($info)){
            $result = array('status'=>0,'msg'=>'当前资产包有未确认交易');
            return $result;
        }

		//资产包对应开放的期数
		//echo count($data);
		//已结束的期数
		 $endCount= M("cf_ctl")->where(["capitalid"=>$id,"ctr_ct_finish"=>'100'])->count();
		if(count($data)!=$endCount){
			$result = array('status'=>0,'msg'=>'当前资产包未售罄');
			return $result;
		}
		$endNum= M("cf_ctl")->where(["capitalid"=>$id,"ctr_ct_finish"=>'100'])->sum("amt_ct_last");
		if($repurchaseNum > $endNum){
			$result = array('status'=>0,'msg'=>'当前资产包可回购余额不足');
			return $result;
		}
		$tempNum=$repurchaseNum;
		$doresult_Arr = $finishresult_Arr = []; 
		//循环每期
		M()->startTrans();
		foreach($data as  $cf_ctl){
			//以系统持有客户1 回购每期剩余金额 CF_ivs  cf_ctl对应更新
			if($cf_ctl['amt_ct_last']>0){
				$jine = min ($tempNum ,$cf_ctl['amt_ct_last']);
				$doresult=D('cf_ivs')->doInvest($cf_ctl,1,$mid,$jine);
				$doresult["dofinish"]="0";
				$tempNum-=$jine;
				if($doresult["status"]=="0"){
					$result = array('status'=>0,'msg'=>'回购失败！！');
					$this->rollback();
					return $doresult;
				}else{
					$doresult_Arr[]=$doresult;
				}
				if($tempNum<=0)break; 
			}
			
		}
		$rollback=false;
		foreach($doresult_Arr as $item=>$doresult) {
			$finishresult = D('cf_ivs')->finishInvest("-1",$doresult['id'],$mid,false);
			$finishresult['id']=$doresult['id'];
			$finishresult_Arr[] = $finishresult;
			if($finishresult["status"]==0){
				$rollback = true;
				break;
			}else{
				$doresult_Arr[$item]["dofinish"]=1;
			}
			 		
		}
		
		//如果回滚为真
		if($rollback){
			// foreach($doresult_Arr as $item=>$doresult) {
				// if($doresult["dofinish"]==1){
					
				// }else if($doresult["dofinish"] == 0){
					// D("Guest/CfIvs")->cancelInvest($doresult['id'],$this->uid);		
				// }	
			// }
			
			$this->rollback();
			$result = array('status'=>0,'msg'=>'回购失败！');
		}else {
			$this->commit();
			$result = array('status'=>1,'msg'=>'回购成功！');
			
		}
		return $result;
        // dump($doresult_Arr);
        // dump($finishresult_Arr);
		exit; 
	}







}