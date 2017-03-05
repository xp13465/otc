<?php
namespace Admin\Model;
use Think\Log;
use Think\Model;

class TokenModel extends Model{
	protected $_validate=array(
		// array('borrower','require','请填写借款人姓名'),
		// array('cod_card_no','require','请填写证件号码'),
	);
	protected $_auto=array(

	); 
	protected $_table=array(
		"kh"=>"KhDbf",
		"rj"=>"RjDbf",
		"gh"=>"GhDbf"
	);
	protected $stepbeforeStrArr=array(
		"kh"=>"1",
		"rj"=>"11",
		"gh"=>"4"
	);
	protected $restartstepbeforeStrArr=array(
		"kh"=>"5",
		"rj"=>"14",
		"gh"=>"9"
	);
	protected $stepStrArr=array(
		"kh"=>"2",
		"rj"=>"12",
		"gh"=>"6"
	);
	
	protected $redemptionstepbeforeStrArr=array(
		"kh"=>"0",
		"rj"=>"8",
		"gh"=>"4"
	);
	protected $messageArr=array(
		"kh"=>"开户文件资料",
		"rj"=>"入金文件资料",
		"gh"=>"过户文件资料"
	);
	 
	/**
     * 获取TOKEN
     */
	public function getToken($token=false,$debug=false)
	{
		$tokenobj=$this->where("expirestime > '".date("Y-m-d H:i:s")."'")->order("expirestime desc ")->find();
		if(!$tokenobj||$token){
			$tokenxmlobj = C('OTC_API_TOOKEN');
			$url = C('OTC_API_URL'); 
			$keyname = "GetAccessToken"; 
			$api = new \Common\Lib\Otcapi();//实例化对象
			$tokenobj = $api->otc_toapi($url,$keyname,$tokenxmlobj);
			if($debug){
				dump($url);
				dump($keyname);
				dump($tokenxmlobj);
				dump($tokenobj);
			}
			if($tokenobj){
				$data = array();
				$data['accesstoken'] = $tokenobj['AccessToken'];
				$data['expirestime'] = date("Y-m-d H:i:s",strtotime($tokenobj['ExpiresTime']));
				$data['errorcode'] = $tokenobj['ErrorCode'];
				$data['errormsg'] = $tokenobj['ErrorMsg']; 
				
				
				$id = 0;
				if($this->create($data)){
				  $id = $this->add();
				}
				if($tokenobj->ErrorCode ==0&&$id>0){	
					return $data['accesstoken'];
				}else{
					return "";
				}
			}else{
				return "";
			}
		}
		return $tokenobj['accesstoken']; 
	}
	// 确权文件上传借口
	// @param  $id   确权文件表ID
	// @param  $type   确权文件类型
	// @param  $type2   确权类型 1投资确权  2赎回确权
	public function ftp_upload($id,$type,$type2=1){ 
		$filrResult = D($this->_table[$type])->where(array("id"=>$id))->find();
		if(!$filrResult)return false;
		
		$ftp = new \Common\Lib\Ftp();//实例化对象 
		$FTP_config = C('OTC_FTP');
		
		 if($ftp->start($FTP_config))
		 {	
			//对入金文件进行额外附件上传
			/* if($type=="rj"){
				$ivsData=D("CfIvs")->alias("a")
				->join("__RJ_DBF__ b on a.id =b.cf_ivs_id","inner")
				->field("a.pos_order,a.pos_file,a.dat_create")
				->where(["b.rj_file"=>$filrResult['rj_file']])
				->select();
				foreach($ivsData as $key=>$val){
					$pos_order = $val['pos_order'];
					$pos_file =ROOT_PATH.$val['pos_file'];
					$extension = end(explode('.', $val['pos_file'])); 
					$toPosFile="/POS/".date("Ymd",strtotime($val['dat_create']))."_".$pos_order."_1.".$extension;
					$putresult=$ftp->put($toPosFile,$pos_file);
					// dump([file_exists($pos_file),$pos_file,$toPosFile,$putresult]);
				}
			} */
			// 远程连接成功;
			$localfile=ROOT_PATH.$filrResult[$type.'_file'];
			$remotefile='/'.basename($filrResult[$type.'_file']);
		   if( $ftp->put($remotefile,$localfile))
		   { 
			   // /* 上传文件成功! */ 
			   $return = $this->FileUploadFinished($id,$type,false,$type2);
			   
				if($return ==="1005"){
					return $this->FileUploadFinished($id,$type,true,$type2);
				}else{
					return $return;
				} 
		   }
		 }else{
			 return false;
		 }
		 //别忘了关闭ftp资源
		$ftp->close();
		return false;
	}
	
	//文件上传成功通知第三方接口
	public function FileUploadFinished($id,$type,$token=false,$type2=1){
		$filrResult = D($this->_table[$type])->where(array("id"=>$id))->find();
		$Token=$this->getToken($token);
		if($filrResult&&$Token){ 
			$xmldata= array(
				"AccessToken"=>$Token,
				"OrgCode"=>C('OTC_API_TOOKEN')['orgcode'],
				"FileID"=>$filrResult['id'],
				"FileName"=>basename($filrResult[$type.'_file']),
				"FileSize"=>filesize(ROOT_PATH.$filrResult[$type.'_file']),
				"MD5Code"=>md5_file(ROOT_PATH.$filrResult[$type.'_file']),
			);
			$logmodel = M("ApiUploadfileLog");
			
			// echo 3333;
			
			$optApi = new \Common\Lib\Otcapi();//实例化对象
			$url = C('OTC_API_URL');
			$apu_result =$optApi->otc_toapi($url,"FileUploadFinished",$xmldata);
			// dump($apu_result);
			if(in_array($apu_result['ReceiveFlag'],array("1102","1101"))){
				$result = D($this->_table[$type])->field($type."_file")->where(array("id"=>$id))->find();
				//更新开户文件/过户文件 记录状态为已发送
				D($this->_table[$type])->where(array($type."_file"=>$result[$type.'_file']))->save(array("status"=>"2"));
				
				//开户文件发送成功更新为2  过户文件发送成功更新为6
				if($type2==2){
					$stepStr=$this->stepStrArr[$type];
					$stepbeforeStr=$this->redemptionstepbeforeStrArr[$type];
					$restartstepbeforeStr=$this->restartstepbeforeStrArr[$type];
					$message="赎回".$this->messageArr[$type];
				}else{
					$stepStr=$this->stepStrArr[$type];
					$stepbeforeStr=$this->stepbeforeStrArr[$type];
					$restartstepbeforeStr=$this->restartstepbeforeStrArr[$type];
					$message=$this->messageArr[$type];
				}
				
				//更新开户确权记录状态为开户资料提交
				 $updateSQL= "update otc_cf_ivs_right a set  a.step = {$stepStr},a.status = 1  WHERE  a.step ='{$stepbeforeStr}' and a.id in ( SELECT cf_ivs_right_id FROM `otc_{$type}_dbf` where {$type}_file = '{$result[$type.'_file']}' )";
				if( M('')->execute($updateSQL)){
					//更新文件相关所有确权记录状态为 资料提交
					D('CfIvsRightLog')->addRightLogsByFilename($result[$type.'_file'],$stepbeforeStr,$stepStr,1,1,0,$message."提交成功"); 
				}
				 $restartupdateSQL= "update otc_cf_ivs_right a set  a.step = {$stepStr},a.status = 1  WHERE  a.status = 3 and a.step ='{$restartstepbeforeStr}' and a.id in ( SELECT cf_ivs_right_id FROM `otc_{$type}_dbf` where {$type}_file = '{$result[$type.'_file']}' )";
				if( M('')->execute($restartupdateSQL)){
					//更新文件相关所有确权记录状态为 资料提交
					D('CfIvsRightLog')->addRightLogsByFilename($result[$type.'_file'],$stepbeforeStr,$stepStr,1,1,0,$message."重新提交成功"); 
				}
			}
			
			if($apu_result){
				$xmldata['createtime']=date("Y-m-d H:i:s",time());
				$xmldata =array_merge($xmldata,$apu_result);
			}
			
			if($logmodel->create($xmldata)){
				$logmodel->add();
			}
			if(empty($apu_result)||in_array(trim($apu_result['ReceiveFlag']),array("1005","0"))){
				return "1005";//$apu_result['ReceiveFlag'];
			}
			return true;
		}else{
			return false;
		}
	}
	
	//文件下载成功通知第三方接口FileDownloadFinished
	public function FileDownloadFinished($id,$type,$token=false)
	{
		$table=array("kb"=>"KbDbf","rjhb"=>"RjhbDbf","gb"=>"GbDbf","dz"=>"DzDbf");
		 
		$filrResult = D($table[$type])->where(array("id"=>$id))->find();
		$Token=$this->getToken($token);
		if($filrResult){ 
			$xmldata= array(
				"AccessToken"=>$Token,
				"OrgCode"=>C('OTC_API_TOOKEN')['orgcode'],
				"FileID"=>$filrResult['otc_file_id'],
				"FileName"=>basename($filrResult[$type.'_file']),
				"CheckFlag"=>0,
			);
			$logmodel = M("ApiDownfileLog");
			
			
			$optApi = new \Common\Lib\Otcapi();//实例化对象
			$url = C('OTC_API_URL');
			$apu_result =$optApi->otc_toapi($url,"FileDownloadFinished",$xmldata);
			// var_dump($apu_result);
			// var_dump($apu_result['RecieveFlag']);
			if(in_array($apu_result['RecieveFlag'],array("0"))){
				$result = D($table[$type])->field($type."_file")->where(array("id"=>$id))->find();
				// echo D($table[$type])->getLastSql();
				// var_dump($result);
				//更新开户文件/过户文件 记录状态为已发送
				D($table[$type])->where(array($type."_file"=>$result[$type.'_file']))->save(array("status"=>"3"));
				 
			}
			
			if($apu_result){
				$xmldata['createtime']=date("Y-m-d H:i:s",time());
				$xmldata =array_merge($xmldata,$apu_result);
			}
			
			if($logmodel->create($xmldata)){
				$logmodel->add();
			}
			if(empty($apu_result)||in_array($apu_result['ReceiveFlag'],array("1005","0"))){
				return "1005";//$apu_result['ReceiveFlag'];
			}
			return true;
		}else{
			return false;
		}
	}
}