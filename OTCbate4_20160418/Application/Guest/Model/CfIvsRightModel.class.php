<?php
namespace Guest\Model;

use Think\Log;
use Think\Model;

class CfIvsRightModel extends Model{
	public $status=array(
		"1"=>"开户准备",  //脚本自动跑 需要开户状态记录 （确认签署后 开户确权  or 开户失败）
		"2"=>"开户资料提交",   //KH文件发送成功后状态
		"3"=>"待开户",  //OTC确认KH文件收到后状态
		"11"=>"入金准备（开户成功）", //OTC脚本自动KB   开户成功后状态    脚本自动跑  需要入金状态记录  （OTC开户成功后 准备入金 or 入金失败）
		"5"=>"开户失败", //OTC脚本自动KB   开户失败后状态
		"12"=>"入金资料提交", //RJ文件发送成功后状态
		"13"=>"待入金", //OTC确认RJ文件收到后状态
		"14"=>"入金失败", //OTC脚本自动RB   入金失败后状态
		"4"=>"过户准备（入金成功）", //OTC脚本自动RB   开户成功后状态    脚本自动跑  需要过户状态记录  （OTC开户成功后 准备过户 or 过户失败）
		"6"=>"过户资料提交", 	//GH文件发送成功后状态
		"7"=>"待过户", //OTC确认GH文件收到后状态
		"8"=>"待对账(过户成功)",   //OTC脚本自动GB   过户成功后状态
		"9"=>"过户失败",  //OTC脚本自动GB    过户失败后状态
		"10"=>"确权成功", //确权函生成
	);
	static $right_status=array(
		'0'=>'待确权',
		'1'=>'确权中',
		'2'=>'确权成功',
		'3'=>'确权失败'
		);
	 
	//  确权开始 开户操作
	// @param list  多条交易记录
	// $param mid   业务员操作ID 
	public function startIvsRightByKh($list,$mid,$tempCust=array()){
		//获取KH文件序号
		$temp = $tempCust;
		$kh_file_no = D('kh_dbf')->getFileNo(); 
		$rjlist=[];
		foreach($list as $item=> $cf_ivs_list){
			$ivs_right_result= $this->field("id,step,errornum")->where(array('cf_ivs_id'=>$cf_ivs_list['id']))->find();
			if($ivs_right_result){//已有确权记录 
				if($ivs_right_result['step'] ==1||$ivs_right_result['step'] ==5){ //处于开户准备状态 或者开户失败
					$cf_ivs_right_id = $ivs_right_result['id'];
				}else{ //跳过非开户准备的记录
					continue;
				}
			}else{//新确权
				$data = array(
					'cf_ivs_id'=>$cf_ivs_list['id'],
					'status'=>1,
					'step'=>1,
					'qqh_file'=>'',
					'usr_create'=>$mid,
					'dat_create'=>date("Y-m-d H:i:s",time()),
					'usr_modify'=>$mid,
					'dat_modify'=>date("Y-m-d H:i:s",time()),
				);
				$rules = array( 
					array('cf_ivs_id','','帐号名称已经存在！',1,'unique',1), // 在新增的时候验证name字段是否唯一 
				);
				if(!$this->validate($rules)->create()){
					$cf_ivs_right_id = $this->add($data);
					if(!$cf_ivs_right_id)continue;
				}else{
					continue;
				}
				
				
			}
			//清楚历史开户的作废记录
			// D("KhDbf")->clearGhData($cf_ivs_right_id,1);
			
			//获取客户信息
			$map['cod_cust_id'] = $cf_ivs_list['cod_cust_id'];
			$user = M('cust_person')->where($map)->find();
			//获取客户额外信息
			$info = M('cust_crm')->where($map)->find();
			
			$isupdate=false;
			if(in_array($cf_ivs_list['cod_cust_id'],$tempCust)){
				$isupdate=true;
			}else{
				$count=M("KhDbf")->where(["KHJYZH"=>$cf_ivs_list['cod_cust_id'],'status'=>"2"])->count();
				if($count>0){
					$isupdate = true;
				}
				$tempCust[] = $cf_ivs_list['cod_cust_id'];
			}
			// 若已开户忽略开户动作 归入直接入金队列
			if($user['otc_jszh']){
				D('cf_ivs_right')->where(array("id"=>$cf_ivs_right_id))->save(array("step"=>'11',"status"=>'1')); //OTC确认收到阶段
				D('CfIvsRightLog')->addRightLogByRid($cf_ivs_right_id,1,11,1,1,0,"已开户,直接入动入金！");
				$rjlist[]=$cf_ivs_list;
			}else {
				if($isupdate&&!empty($temp)){
					continue;
				} 
				//处理KHDBF
				$temp_kh_dbf_id = D('kh_dbf')->createDbf($cf_ivs_list,$cf_ivs_right_id,$user,$info,$kh_file_no,$isupdate,$ivs_right_result['errornum']); 
				$kh_dbf_id = $temp_kh_dbf_id?$temp_kh_dbf_id:$kh_dbf_id; 
			}
			
		} 
		// echo "<hr>";
		if($kh_dbf_id){
			return ["status"=>D("Admin/Token")->ftp_upload($kh_dbf_id,"kh"),"tempCust"=>$tempCust,"rjlist"=>$rjlist];
		}else{
			return ["status"=>false,"tempCust"=>$tempCust,"rjlist"=>$rjlist];
		}
		 
	} 
	
	// 确权开始 入金操作
	// @param list  多条交易记录
	// $param mid   业务员操作ID 
	// $param type   1 投资确权  2赎回确权 
	public function startIvsRightByRj($list,$mid,$type=1){
		// dump($list);
		
		//获取KH文件序号
		$gh_file_no = D('rj_dbf')->getFileNo(); 
		
		foreach($list as $cf_ivs_list){
			if($type==2){
				$ivs_right_result= $this->field("id,step,errornum")->where(array('cf_ivs_id'=>$cf_ivs_list['cod_cf_ivs_id']))->find();
			}else{
				$ivs_right_result= $this->field("id,step,errornum")->where(array('cf_ivs_id'=>$cf_ivs_list['id']))->find();
			}
			
			 			
			
			if($ivs_right_result){//已有确权记录 
				if($type==1&&($ivs_right_result['step'] ==11||$ivs_right_result['step'] ==14)){ //处于入金准备状态 或者入金失败
					$cf_ivs_right_id = $ivs_right_result['id'];
				}else if($type==2&&($ivs_right_result['step'] ==8)){ //处于入金准备状态 或者入金失败
					$this->where(array('id'=>$ivs_right_result['id'],'cf_ivs_id'=>$cf_ivs_list['cod_cf_ivs_id']))->save(array("cf_ivs_redemption_id"=>$cf_ivs_list['id']));
					$cf_ivs_right_id = $ivs_right_result['id'];
				}else{ //跳过非过户准备的记录
					continue;
				} 
			}else{  
				continue;
			}
			//清楚历史过户的作废记录
			// D("RjDbf")->clearGhData($cf_ivs_right_id,1);
			
			//获取客户信息
			$map['cod_cust_id'] = $cf_ivs_list['cod_cust_id'];
			$user = M('cust_person')->where($map)->find();
			
			//获取客户额外信息
			$info = M('cust_crm')->where($map)->find();
			//处理GHDEF
			$temp_rj_dbf_id = D('rj_dbf')->createDbf($cf_ivs_list,$cf_ivs_right_id,$user,$info,$gh_file_no,$type,$ivs_right_result['errornum']);
			$rj_dbf_id = $temp_rj_dbf_id?$temp_rj_dbf_id:$rj_dbf_id; 
		} 
		// dump($rj_dbf_id);
		// exit;
		if($rj_dbf_id){
			return D("Admin/Token")->ftp_upload($rj_dbf_id,"rj",$type);
		}else{
			return false;
		}
	} 
	
	// 确权开始 过户操作
	// @param list  多条交易记录
	// $param mid   业务员操作ID 
	public function startIvsRightByGh($list,$mid,$type=1){
		//获取KH文件序号
		$gh_file_no = D('gh_dbf')->getFileNo(); 
		
		foreach($list as $cf_ivs_list){
			if($type==2){
				$ivs_right_result= $this->field("id,step,errornum")->where(array('cf_ivs_id'=>$cf_ivs_list['cod_cf_ivs_id']))->find();
			}else{
				$ivs_right_result= $this->field("id,step,errornum")->where(array('cf_ivs_id'=>$cf_ivs_list['id']))->find();
			}
			 
			if($ivs_right_result){//已有确权记录 
				if($ivs_right_result['step'] ==4||$ivs_right_result['step'] ==9){ //处于过户准备状态 或者过户失败
					$cf_ivs_right_id = $ivs_right_result['id'];
				}else{ //跳过非过户准备的记录
					continue;
				} 
			}else{  
				continue;
			}
			//清楚历史过户的作废记录
			// D("GhDbf")->clearGhData($cf_ivs_right_id,1);
			
			//获取客户信息
			$map['cod_cust_id'] = $cf_ivs_list['cod_cust_id'];
			$user = M('cust_person')->where($map)->find();
			
			//获取客户额外信息
			$info = M('cust_crm')->where($map)->find();
			 
			//处理GHDEF
			$temp_gh_dbf_id = D('gh_dbf')->createDbf($cf_ivs_list,$cf_ivs_right_id,$user,$info,$gh_file_no,$type,$ivs_right_result['errornum']);
			$gh_dbf_id = $temp_gh_dbf_id?$temp_gh_dbf_id:$gh_dbf_id; 
		}
		if($gh_dbf_id){
			return D("Admin/Token")->ftp_upload($gh_dbf_id,"gh",$type);
		}else{
			return false;
		}
	} 
	
	
		/**
	 * 获取确权列表
	 */

	public function getRightList($condition,$curpage,$limit){
		$data['total'] =M('cf_ivs')
			->alias('a')->field('od.name as department_name,ou.realname as user_name,
		a.id,a.cod_ctl_id,cod_period,a.amt_ivs,a.ctl_ivs_cnt,a.amt_int_total,
		a.amt_fee_total,a.pos_order,a_right.status,e.step,a.dat_modify,IFNULL(e.cf_ivs_redemption_id,0) as cf_ivs_redemption_id,
		c.title,c.code,d.cod_period,b.nam_cust_real,b.cod_cust_id_no')
			->join('__CUST_PERSON__ b on a.cod_cust_id=b.cod_cust_id')
			->join('__CF_MAST__ c on a.cod_cf_id=c.id')
			->join('__CF_CTL__ d on a.cod_ctl_id=d.id','left')
			->join('__CF_IVS_RIGHT__ e on a.id=e.cf_ivs_id','left')
			->join('__USER__ as ou on ou.id=a.usr_create')//查用户名
			->join('__DEPARTMENT__ as od on ou.department_id= od.id')
			->where($condition)
			->count();
	$data['items'] = M('cf_ivs')
		->alias('a')->field('od.name as department_name,ou.realname as user_name,
		a.id,a.cod_ctl_id,cod_period,a.amt_ivs,a.ctl_ivs_cnt,a.amt_int_total,
		a.amt_fee_total,a.pos_order,e.status,e.step,a.dat_modify,ifnull(rf.file,e.qqh_file) as loc_qqh_file,e.qqh_file as qqh_file,IFNULL(e.cf_ivs_redemption_id,0) as cf_ivs_redemption_id,
		c.title,c.code,d.cod_period,b.nam_cust_real,b.cod_cust_id_no')
		->join('__CUST_PERSON__ b on a.cod_cust_id=b.cod_cust_id')
		->join('__CF_MAST__ c on a.cod_cf_id=c.id')
		->join('__CF_CTL__ d on a.cod_ctl_id=d.id','left')
		->join('__CF_IVS_RIGHT__ e on a.id=e.cf_ivs_id','left')
		->join('__CF_IVS_RIGHT_FILE__ rf ON rf.cf_ivs_right_id = e.id  and rf.validflag = 1','left')
		->join('__USER__ as ou on ou.id=a.usr_create')//查用户名
		->join('__DEPARTMENT__ as od on ou.department_id= od.id')
		->order('a.dat_modify desc')
		->where($condition)
		->page($curpage,$limit)
		->select();
	 // $data['sql']=M()->_sql();
		foreach($data['items'] as $k=>$v){
    		$data['items'][$k]['product_code']=$data['items'][$k]['title'].$data['items'][$k]['cod_period']."期";
			if(is_null($data['items'][$k]['status']))
			{
				$data['items'][$k]['status']=0;
			}
			if(is_null($data['items'][$k]['step']))
				$data['items'][$k]['step']=0;
    		}
		

		return $data;
	}

	/*
	 *开发一个自动下载备份确权函功能
要求
1 满足OTC方多次更新确权函后 历史确权函记录文件照样保存
功能模块2个
1个定时任务  每日更新下载（未下载过确权函的）确权成功记录
2一个更新任务  在，每次确权函通知一条（同客户同产品期的新确权记录）确权函生成时调用  调用后下载新确权函 更新绑定同客户同产品期的其他确权记录  历史记录回收存档

可以写成一个通用底层功能模块  一种定时任务触发  一种确权触发
	 * */
	public  function  DownNewFile($data,$mid){
		//未下载的文件
//		$data=D('cf_ivs_right')->alias('a')
//			->field('a.id,group_concat(a.id) as aids,a.cf_ivs_id,a.qqh_file,b.id as bid,c.id as ivs_id,c.cod_cust_id,c.cod_ctl_id')
//			->join('__CF_IVS_RIGHT_FILE__ b on a.id=b.cf_ivs_right_id','left')
//			->join('__CF_IVS__ c on a.cf_ivs_id=c.id','left')
//			->where('a.validflag=1 and b.id is null and a.status=1 and a.step=8')//2he8
//			->group('a.qqh_file')
//			->select();

		foreach($data as $k=>$v){
			if($v['bid']){
				M('cf_ivs_right_file')->where('id = '.$v['bid'])->save(array('validflag'=>'0'));
			}
			
			$insertdata['otc_url']=$v['qqh_file'];
			$insertdata['dat_create']=date('Y-m-d H:i:s');
			$insertdata['cust_id']=$v['cod_cust_id'];
			$insertdata['cf_ctl_id']=$v['cod_ctl_id'];
			$localadd=$this->http_get_data($v['qqh_file']);
			if($localadd['filename']){
				$insertdata['filename']=$localadd['filename'];
				$insertdata['file']=$localadd['file'];
				//同文件的未下载的多次确权记录 插入
				$rightArr=isset($v['aids'])&&$v['aids']?explode(",",$v['aids']):[$v['id']];
				foreach($rightArr as $rid){
					$insertdata['cf_ivs_right_id']=$rid;
					$res[]=D('cf_ivs_right_file')->add($insertdata);
				}
				//查询历史同文件下载情况
				//			$cf_ctl_id=87;
				//        	$cust_id=63;
				//			$oldid=[];
				//$res 新插入的id ,$cf_ctl_id,$cust_id
				
				$cf_ctl_id=$v['cod_ctl_id'];
				$cust_id=$v['cod_cust_id'];
				$this->updateSameOne($cf_ctl_id,$cust_id,$localadd,$res);
			}
			
			
		}
		$msg='the end';
		return $msg;

}

	
	public function updateSameOne($cf_ctl_id,$cust_id,$localadd,$res=array(0)){
		if($res){
			$oid="(".join(',',$res).")";
		}else{
			$oid="(0)";
		}
		
		$updateDAtA=D('cf_ivs_right_file')
			->alias('b')
			->field('b.*')
			->where("b.cf_ctl_id={$cf_ctl_id} and b.cust_id={$cust_id} and b.id not in {$oid} and b.validflag = 1")//已往的成功的
			->select();
		foreach($updateDAtA  as $k=>$data ){
			//回收旧的
			M('cf_ivs_right_file')->where('id = '.$data['id'])->save(array('validflag'=>'0'));
			$newdata =$data;
			unset($newdata['id']);
			$newdata['dat_create']=date("Y-m-d H:i:s");
//			$newdata['otc_url'] = $v['qqh_file'];
			$newdata['file']=$localadd['file'];
			$newdata['filename']=$localadd['filename'];
			M('cf_ivs_right_file')->add($newdata);
		}

	}


	/*
     * curl 下载pdf
     * */

	function http_get_data($url) {
		//创建保存目录
		$save_dir="/Uploads/confirmfile/".date('Y-m-d');
		if(!file_exists(ROOT_PATH.$save_dir)&&!mkdir(ROOT_PATH.$save_dir,0777,true)){
			return false;
		}
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		ob_start ();
		curl_exec ( $ch );
		$return_content = ob_get_contents ();
		ob_end_clean ();
		$return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
		$filename=time().rand(1000,9999).'.pdf';
		$fp= @fopen(ROOT_PATH.$save_dir.'/'.$filename,"a"); //将文件绑定到流
		fwrite($fp,$return_content); //写入文件
//		echo curl_error();
		$res['filename']=basename($url);
		$res['file']=$save_dir.'/'.$filename;

		return $res;
	}
	
}

?>