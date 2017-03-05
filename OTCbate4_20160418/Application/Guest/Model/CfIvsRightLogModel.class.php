<?php
namespace Guest\Model;

use Think\Log;
use Think\Model;

class CfIvsRightLogModel extends Model{
	static $errorArray=array(
		"0"=>"",
		"1"=>"份额余额不足",
		"2"=>"账户已冻结",
		"3"=>"账户已挂失",
		"6"=>"非开放日不受理",
		"10"=>"其他原因失败",
		"13"=>"投资人已注册结算所账号",
		"16"=>"交易账户不存在",
		"20"=>"冻结原因非法",
		"21"=>"在对方代理人处未开立交易账号或交易账号超过１个",
		"104"=>"结算帐号非法",
		"105"=>"代理人非法（无记录）",
		"940"=>"业务类型不正确",
		"944"=>"申请日期无效", 
		"945"=>"申请单号无效", 
		"946"=>"投资人名无效",
		"947"=>"投资人证件类型无效",
		"948"=>"投资人证件号码无效",
		"949"=>"通讯地址无效",
		"950"=>"邮政编码无效",
		"965"=>"销售代理人代码错误",
		"976"=>"结算账号有份额，不允许注销",
		"1000"=>"获取AccessToken成功",
		"1001"=>"没有找到OrgCode",
		"1002"=>"OrgCode与InterfaceCode不匹配",
		"1003"=>"OrgCode与目前使用IP不匹配",
		"1004"=>"AccessToken不存在",
		"1005"=>"AccessToken与OrgCode不匹配",
		"1006"=>"AccessToken与目前使用IP不匹配",
		"1007"=>"AccessToken已超时",
		"1101"=>"第一次收到请求",
		"1102"=>"此文件已提交过，已更新信息",
		"1103"=>"文件不存在",
		"1104"=>"文件大小不对",
		"1105"=>"文件MD5不匹配",
		"1106"=>"文件错误无法访问",
		"1107"=>"文件类型不支持，请参考接口文档使用规范文件名",
		"1108"=>"数据导入失败",
		"1199"=>"文件检查成功，可以继续处理",
		"1201"=>"文件格式有误，读取失败",
		"1202"=>"处理失败",
		"1299"=>"文件处理成功",
		"2101"=>"无交易账号",
		"2102"=>"无证件类型",
		"2103"=>"无证件编号",
		"2104"=>"证件编号内容不符合规范",
		"2105"=>"无投资人姓名",
		"2106"=>"无结算所账号",
		"2107"=>"开户时结算所账号已存在",
		"2108"=>"结算所帐号非法",
		"5201"=>"资金不足，认购无效",
		"5210"=>"不在认购时间段内，拒绝认购",
		"5221"=>"产品代码不存在",
		"5222"=>"持仓小于卖出数量",
		"7001"=>"代理人业务限制",
		"7003"=>"结算账号已注销，不允许开户",
		"7004"=>"无效的协议号",
		"9999"=>"找不到客户持仓数据",
	);
	 
	// 添加确权日志
	// @param list  多条交易记录
	// $param mid   业务员操作ID 
	public function addRightLog($filename,$step_before,$step_after,$status_before,$status_after,$error_code=0,$error_msg=""){
		$datetime =date("Y-m-d H:i:s",time());
		if($error_code>0){
			$error_msg.="失败原因：".self::$errorArray[$error_code];
		}
		// $updateSql="insert into otc_cf_ivs_right_log(ivs_id,ivs_right_id,step_before,step_after,status_before,status_after,error_code,error_msg,usr_create,dat_modify)"
		$updateSql="select a.cf_ivs_id as ivs_id ,a.id as ivs_right_id, '{$step_before}' as step_before , '{$step_after}' as step_after, '{$status_before}' as status_before , '{$status_after}' as status_after,'{$error_code}' as error_code,'{$error_msg}' as error_msg,'{$datetime}' as dat_create,'{$datetime}' as dat_modify from otc_cf_ivs_right a   WHERE a.id in ( SELECT cf_ivs_right_id FROM `otc_kh_dbf` where kh_file like '%{$filename}' )";
		// print_r($updateSql);
		$list =  M('')->query($updateSql);	
		D('cf_ivs_right_log')->addAll($list);
		
	}

	// 添加确权日志
	// @param list  多条交易记录
	// $param mid   业务员操作ID 
	public function addRightLogsByFilename($filename,$step_before,$step_after,$status_before,$status_after,$error_code=0,$error_msg=""){
		list($action,$data)=D("Tjotc")->get_khid($filename);
		if($error_code>0){
			$error_msg.="失败原因：".self::$errorArray[$error_code];
		}
		// var_dump($action);
		if($action!="err"){
			// echo $action;
			$datetime =date("Y-m-d H:i:s",time());
			// $updateSql="insert into otc_cf_ivs_right_log(ivs_id,ivs_right_id,step_before,step_after,status_before,status_after,error_code,error_msg,usr_create,dat_modify)"
			$updateSql="select a.cf_ivs_id as ivs_id ,a.id as ivs_right_id, '{$step_before}' as step_before , '{$step_after}' as step_after, '{$status_before}' as status_before , '{$status_after}' as status_after,'{$error_code}' as error_code,'{$error_msg}' as error_msg,'{$datetime}' as dat_create,'{$datetime}' as dat_modify from otc_cf_ivs_right a   WHERE a.id in ( SELECT cf_ivs_right_id FROM `otc_{$action}_dbf` where {$action}_file like '%{$filename}' )";
			// print_r($updateSql);
			$list =  M('')->query($updateSql);	
			D('cf_ivs_right_log')->addAll($list);
		}
		
	}
	
	// 添加确权日志
	// @param rid  确权记录单ID
	// $param mid   业务员操作ID 
	public function addRightLogByRid($rid,$step_before,$step_after,$status_before,$status_after,$error_code=0,$error_msg=""){
		if($error_code>0){
			$error_msg.="失败原因：".self::$errorArray[$error_code];
		}
		$datetime =date("Y-m-d H:i:s",time());
		// $updateSql="insert into otc_cf_ivs_right_log(ivs_id,ivs_right_id,step_before,step_after,status_before,status_after,error_code,error_msg,usr_create,dat_modify)"
		$updateSql="select a.cf_ivs_id as ivs_id ,a.id as ivs_right_id, '{$step_before}' as step_before , '{$step_after}' as step_after, '{$status_before}' as status_before , '{$status_after}' as status_after,'{$error_code}' as error_code,'{$error_msg}' as error_msg,'{$datetime}' as dat_create,'{$datetime}' as dat_modify from otc_cf_ivs_right a   WHERE a.id  ='{$rid}'";
		// print_r($updateSql);
		$list =  M('')->query($updateSql);	
		D('cf_ivs_right_log')->addAll($list);
		
	}
	
	/**
	 *  //获取具体的确权进度
	 */
    public function rschedule($id){
    	$data['items']=M('cf_ivs_right')
    		->alias('cir')
    		->field('cirl.dat_create,cirl.error_msg')
    		->join('__CF_IVS_RIGHT_LOG__ as cirl on cirl.ivs_right_id=cir.id')
    		->where('cir.cf_ivs_id='.$id)
    		->order("cirl.dat_create asc")
    		->select();
    		//$cs=D('cf_ivs_right');
    		// foreach ($data['items'] as $key => $value) {
    		// 	$value['step_before']=$cs::$status[$value['step_before']];
    		// 	$value['step_after']=$cs::$status[$value['step_after']];
    		// }
    	return $data;
    }
	 
	
}

?>