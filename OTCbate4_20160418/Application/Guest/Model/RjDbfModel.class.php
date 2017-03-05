<?php
namespace Guest\Model;

use Think\Log;
use Think\Model;

class RjDbfModel extends Model{
	
	// 创建GH DBF信息
	// @param cf_ivs_list 交易记录
	// @param  cf_ivs_right_id  确权记录ID
	// @param  user  用户主信息
   //  @param  info  用户额外信息数据	
   //  @param  file_no   文件序号   
   // $param type   1交易确权   2赎回确权 
	public function  createDbf($cf_ivs_list,$cf_ivs_right_id,$user,$info = array(),$file_no,$type = 1,$errornum=0){
		$now = time();
		createDir('./Uploads/RJ');
		$dir = './Uploads/RJ/'.date('Ymd',$now);
		createDir($dir);
		
		//生成DBF文件
		$filename = 'TJC_'.C('OTC_API_TOOKEN.orgcode').'_'.C('OTC_TACODE').'_'.date('Ymd',$now).'_'.$file_no.'_RJ.DBF';
		$file = $dir.'/'.$filename;
		
		$obj = new \Common\Lib\Otcdbf();//实例化对象
		
		if(!file_exists($file)){
			$flag = $obj->createDBF($file,'RJ');
		}else{
			$flag = true;
		} 
		// dump($user);
		// dump($info);
		if($flag){
			if($type==2){
				$dbf_data = array(
					C('OTC_API_TOOKEN.orgcode'),  //销售代理人代码 * 
					'TJC10000000501',                        //结算账户 *
					'1',                       //交易账户 *
					date("Ymd",strtotime($cf_ivs_list['dat_modify'])),          //入金日期   YYYYMMDD
					$cf_ivs_list['pos_order'], //入金流水单号 *
					'POS',                       //入金方式 *
					$cf_ivs_list['amt_int_total'],      //入金金额 * 
					$cf_ivs_list['ivs_order']."_".$errornum,   //对应过户申请单号    *          
					'',                  //备用标志 	 
				);
			}else{
				$dbf_data = array(
					C('OTC_API_TOOKEN.orgcode'),  //销售代理人代码 * 
					$user['otc_jszh'],                        //结算账户 *
					$user['cod_cust_id'],                       //交易账户 *
					date("Ymd",strtotime($cf_ivs_list['dat_modify'])),          //入金日期   YYYYMMDD
					$cf_ivs_list['pos_order'], //入金流水单号 *
					'POS',                       //入金方式 *
					$cf_ivs_list['amt_int_total'],      //入金金额 * 
					$cf_ivs_list['ivs_order']."_".$errornum,   //对应过户申请单号    *          
					'',                  //备用标志 	 
				);
			}
			
			$obj->writeDbf($file,$dbf_data);
			$dbfdata = array_combine($obj->RJ_KEY,$dbf_data);
			// var_dump($dbfdata);
			if($type==2){
				$data = array(
					'cf_ivs_id'=>$cf_ivs_list['cod_cf_ivs_id'],
					'cf_ivs_redemption_id'=>$cf_ivs_list['id'],
					'cf_ivs_right_id'=>$cf_ivs_right_id,
					'rj_file'=>$file,
					'file_no'=>$file_no,
					'createdate'=>date('Y-m-d',$now),
					'createtime'=>date("Y-m-d H:i:s",$now),
				);
			}else{
				$data = array(
					'cf_ivs_id'=>$cf_ivs_list['id'],
					'cf_ivs_right_id'=>$cf_ivs_right_id,
					'rj_file'=>$file,
					'file_no'=>$file_no,
					'createdate'=>date('Y-m-d',$now),
					'createtime'=>date("Y-m-d H:i:s",$now),
				);
			}
			
			$data = array_merge($data,$dbfdata);
			$dbf_id = $this->add($data);
		}
		return $dbf_id?$dbf_id:0;
	}
	/**
	* 清理入金生成文件&记录
	*@param  ivs_right_id  确权记录ID
	*@param  status  文件状态 
	*/
	public function clearGhData($ivs_right_id,$status = 0){ 
		$where = array("cf_ivs_right_id"=>$ivs_right_id);
		if($status)$where['status']=$status;
		$result = $this->where($where)->select();
		foreach($result as $data){
			$file = ROOT_PATH.$data['rj_file'];
			if(file_exists($file)){
				@unlink(ROOT_PATH.$data['rj_file']); 
			}
			
		}
		$this->where($where)->delete();
	}
	/** 
	* 获取最新过户文件序号
	*
	*/
	public function getFileNo(){
		//获取文件序号
		$map['createdate'] = date('Y-m-d',time());
		$list = $this->where($map)->order('file_no DESC')->limit(1)->find();
		if(!empty($list)){
			$file_no = $list['file_no']+1;
		}else{
			$file_no = 1;
		}
		return $file_no;
	}
	
}

?>