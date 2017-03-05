<?php
namespace Guest\Model;

use Think\Log;
use Think\Model;

class KhDbfModel extends Model{
	
	/** 创建KH DBF信息
	*@param cf_ivs_list 交易记录
	*@param  cf_ivs_right_id  确权记录ID
	*@param  user  用户主信息
	*@param  info  用户额外信息数据	
	*@param  file_no   文件序号
	*/
	public function  createDbf($cf_ivs_list,$cf_ivs_right_id,$user,$info = array(),$file_no,$isupdate=false,$errornum=0){
		$now = time();
		createDir('./Uploads/KH');
		$dir = './Uploads/KH/'.date('Ymd',$now);
		createDir($dir);
		
		//生成DBF文件
		$filename = 'TJC_'.C('OTC_API_TOOKEN.orgcode').'_'.C('OTC_TACODE').'_'.date('Ymd',$now).'_'.$file_no.'_KH.DBF';
		$file = $dir.'/'.$filename;
		$obj = new \Common\Lib\Otcdbf();//实例化对象
		
		if(!file_exists($file)){
			$flag = $obj->createDBF($file,'KH');
		}else{
			$flag = true;
		}
		// print_r($user['dat_cust_birthday']);
		// echo $info['birthday'];
		// echo date("Ymd",strtotime($user['dat_cust_birthday']));
		if($flag){
			if($user['otc_jszh']||$isupdate==true){
				//老用户 调取012字段
				$dbf_data = array(
					C('OTC_API_TOOKEN.orgcode'),                        //销售代理人代码 (011-0x)*    (011-2x)*  (012)*
					date("Ymd",strtotime($cf_ivs_list['dat_modify'])),  //申请日期  YYYYMMDD  (011-0x)* (011-2x)*  (012)*
					$cf_ivs_list['ivs_order']."_".$errornum,                //申请单号  (011-0x)* (011-2x)*  (012)*
					$user['otc_jszh'],                         //结算账户                  (012)*
					'012',                                     //业务类型  (011-0x)*  (011-2x)*  (012)*
					$user['cod_cust_id'],              //交易账户 *   (011-0x)* (011-2x)*
					mb_convert_encoding($user['nam_cust_real'], 'gbk', 'utf-8'),                   //投资人名   (011-0x)* (011-2x)*  (012)*
					mb_convert_encoding($user['nam_cust_real'], 'gbk', 'utf-8'),                                      //投资人名-简称  
					'00',                                   //投资人证件类型   (011-0x)* (011-2x)*  (012)*
					$user['cod_cust_id_no'],              //投资人证件号码   (011-0x)* (011-2x)*   (012)*
					'',//date("Ymd",strtotime($user['dat_cust_birthday'])),//出生日期  YYYYMMDD
					$user['cod_cust_gender'],  //性别
					'',  //学历
					'',  //职业
					'', //单位名称
					'', //住宅电话
					'',//$user['tel'], //手机号码
					'', //单位电话
					'', //传真号码
					'', //电子邮件
					$info['bizcode'],  //邮政编码     (011-0x)* (011-2x)*
					mb_convert_encoding($info['address'], 'gbk', 'utf-8'),//通讯地址     (011-0x)* (011-2x)*
					'', //法人代表姓名     (011-2x)*
					'',  //法人代表证件类型  (011-2x)*
					'', //法人代表证件号码  (011-2x)*
					'', //经办人姓名        (011-2x)*
					'',  //经办人证件类型    (011-2x)*
					'', //经办人证件号码     (011-2x)*
					date("Ymd",$now),  //发送日期     YYYYMMDD    (011-0x)*  (011-2x)*  (012)*
					"",  //客户风险级别  结算所提供？
				    '',  //客户风险承诺函  0未签署  1已签署
				    '', //经纪人编号
				    '', //备用标志
				);
				
				
			}else{
				//新用户 调取011 字段
				$dbf_data = array(
					C('OTC_API_TOOKEN.orgcode'),                       //销售代理人代码 (011-0x)*    (011-2x)*  (012)*
					date("Ymd",strtotime($cf_ivs_list['dat_modify'])), //申请日期  YYYYMMDD  (011-0x)* (011-2x)*  (012)*
					$cf_ivs_list['ivs_order']."_".$errornum,               //申请单号  (011-0x)* (011-2x)*  (012)*
					'',                        //结算账户 *
					'011',                             //业务类型  (011-0x)*  (011-2x)*  (012)*
					$user['cod_cust_id'],              //交易账户 *   (011-0x)* (011-2x)*
					mb_convert_encoding($user['nam_cust_real'], 'gbk', 'utf-8'),  //投资人名   (011-0x)* (011-2x)*  (012)*
					mb_convert_encoding($user['nam_cust_real'], 'gbk', 'utf-8'),                     //投资人名-简称  
					'00',             //投资人证件类型   (011-0x)* (011-2x)*  (012)*
					$user['cod_cust_id_no'],   //投资人证件号码   (011-0x)* (011-2x)*   (012)*
					'',//date("Ymd",strtotime($user['dat_cust_birthday'])),                           //出生日期  YYYYMMDD
					$user['cod_cust_gender'],  //性别
					'',  //学历
					'',  //职业
					'', //单位名称tel
					'', //住宅电话
					'',//$user['tel'], //手机号码
					'', //单位电话
					'', //传真号码
					'', //电子邮件
					$info['bizcode'],  //邮政编码     (011-0x)* (011-2x)*
					mb_convert_encoding($info['address'], 'gbk', 'utf-8'),//通讯地址     (011-0x)* (011-2x)*
					'', //法人代表姓名     (011-2x)*
					'',  //法人代表证件类型  (011-2x)*
					'', //法人代表证件号码  (011-2x)*
					'', //经办人姓名        (011-2x)*
					'',  //经办人证件类型    (011-2x)*
					'', //经办人证件号码     (011-2x)*
					date("Ymd",$now),  //发送日期     YYYYMMDD    (011-0x)*  (011-2x)*  (012)*
					"",  //客户风险级别  结算所提供？
				    '',  //客户风险承诺函  0未签署  1已签署
				    '', //经纪人编号
				    '', //备用标志
				);
			}
			$obj->writeDbf($file,$dbf_data);
			
			$dbfdata = array_combine($obj->KH_KEY,$dbf_data);
			$dbfdata['KHTZRM']=mb_convert_encoding($dbfdata['KHTZRM'], 'utf-8', 'gbk');
			$dbfdata['KHTZJC']=mb_convert_encoding($dbfdata['KHTZJC'], 'utf-8', 'gbk');
			$dbfdata['KHTXDZ']=mb_convert_encoding($dbfdata['KHTXDZ'], 'utf-8', 'gbk');
			// var_dump($dbfdata);
			// echo 321;
			$data = array(
				'cf_ivs_id'=>$cf_ivs_list['id'],
				'cf_ivs_right_id'=>$cf_ivs_right_id,
				'kh_file'=>$file,
				'file_no'=>$file_no,
				'createdate'=>date('Y-m-d',$now),
				'createtime'=>date("Y-m-d H:i:s",$now),
			);
			$data = array_merge($data,$dbfdata);
			$dbf_id = $this->add($data);	
		}
		return $dbf_id?$dbf_id:0;
	}
	/**
	* 清理开户生成文件&记录
	*@param  ivs_right_id  确权记录ID
	*@param  status  文件状态 
	*/
	public function clearGhData($ivs_right_id,$status = 0){ 
		$where = array("cf_ivs_right_id"=>$ivs_right_id);
		if($status)$where['status']=$status;
		$result = $this->where($where)->select();
		foreach($result as $data){
			$file = ROOT_PATH.$data['kh_file'];
			if(file_exists($file)){
				@unlink(ROOT_PATH.$data['kh_file']); 
			}
			
		}
		$this->where($where)->delete();
	}
	
	/** 
	* 获取最新开户文件序号
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