<?php
namespace Guest\Model;
class TjotcModel
{
	/**
	*	插入dbf数据到数据库
	*/
	public function dbf_save_db($dbname,$v,$cf_ivs_id='',$cf_ivs_right_id='',$file_uri=''){ 
		$v["cf_ivs_right_id"]=$cf_ivs_right_id;
		$v["cf_ivs_id"]=$cf_ivs_id;
		$v["file_uri"]=$file_uri; 
		return D($dbname)->add($v);
	}
	/**
	*	读取dbf文件，返回数组
	*/
	public function readfileftp($furi){
		$db = dbase_open($furi, 0);
		if ($db) {
		  $r=array();
		  $record_numbers = dbase_numrecords($db);
		  for ($i = 1; $i <= $record_numbers; $i++) {
			  $row = dbase_get_record_with_names($db, $i);
			  foreach($row as $k=>$v){
				  $row[$k]=iconv('GBK', 'UTF-8', $row[$k]); 
			  }
			  $r[]=($row);
		  }
		  dbase_close($db);
		  return $r;
		}
		return false;
	}
	/**
	* 	检查cf_right，确认是否确权成功
	*	如果kh gh  kb  gb  dz 都有，就变更状态
	*	待完成
	*/
	public function check_cf_right($id){
		$r=D('cf_ivs_right')->field('otc_cf_ivs_right.id')->join('1otc_kh_dbf1 kh on kh.cf_ivs_right_id=otc_cf_ivs_right.id and kh.status=3')
						->join('1otc_gh_dbf1 gh on gh.cf_ivs_right_id=otc_cf_ivs_right.id and gh.status=3')
						->join('1otc_kb_dbf1 kb on kb.cf_ivs_right_id=otc_cf_ivs_right.id and kb.status=3')
						->join('1otc_gb_dbf1 gb on gb.cf_ivs_right_id=otc_cf_ivs_right.id and gb.status=3')
						->join('1otc_dz_dbf1 dz on dz.cf_ivs_right_id=otc_cf_ivs_right.id and dz.status=3')
						->where('!isnull(kh.id) and !isnull(gh.id) and !isnull(kb.id) and !isnull(gb.id) and !isnull(dz.id) and otc_cf_ivs_right.id="'.(int)$id.'"')->find();
		if($r&&$r['id']){
			//表示确权成功
			$tr=D('cf_ivs_right')->where(array("status"=>['in','1,3'],"id"=>$r['id']))->save(array("status"=>'2'));
			if($tr==1){
				return 1;
			}elseif($tr===false){
				return 0;
			}else{
				return -1;
			}
		}
		return 2;
	}
	/**
	*	发送确认接收 文件完毕 通知 结算所
	*/
	public function file_down_over_toOTC($ParValue){
		  $newtoken=D('token')->field('accesstoken')->order('id desc')->find();
		// 通过
		$tokenxmlobj = array(	'AccessToken'=>$newtoken['accesstoken'],
								'OrgCode'=>$ParValue['OrgCode'],
								'FileID'=>$ParValue['FileID'],
								'FileName'=>$ParValue['FileName'],
								'CheckFlag'=>"1");
		$url = C('OTC_API_URL'); 
		$keyname = "FileDownloadFinished"; 
		$api = new \Common\Lib\Otcapi();//实例化对象
		$tokenobj = $api->otc_toapi($url,$keyname,$tokenxmlobj);   
		//需要记录log?
		print_r($tokenobj);
	}
	/**
	* 	下载文件并放到指定目录
	*	返回文件存放完整地址
	*/
	public function get_file_ftp($fname){
		
		$ftp = new \Common\Lib\Ftp();
		$FTP_config = C('OTC_FTP');
		 if($ftp->start($FTP_config))
		 {
			$fr=explode(".",end(explode('_',$fname)));
			$localfile=ROOT_PATH."Uploads/".$fr[0]."/".date('Ymd')."/".$fname;
			createDir(ROOT_PATH."Uploads/".$fr[0]);
			$dirname = pathinfo($localfile, PATHINFO_DIRNAME);
			createDir($dirname);
			// mkdir($dirname,'0777',true);
			// echo 31213;exit;
			$remotefile='/'.basename($fname);
		   if($ftp->get($remotefile,$localfile))
		   {
			   $ftp->close();
			   return  $localfile;
		   }else{
			   echo $ftp->get_error();
			   return false;
		   }
		 }else{
			 $ftp->close();
			 return false;
		 }
		return false;
	}
	/**
	*	跟据FileName获取kh or gh 并 获取kh or gh的id
	*	TJC_SEZB004_TJC999_20151012_KH.DBF
	*	['kh',['id,cf_ivs_right_id']]
	*/
	public function get_khid($fname){ 
		$fr=end(explode('_',$fname));
		if(in_array($fr,['KH.DBF','kh.DBF'])){
			$r=D('kh_dbf')->field('id,cf_ivs_right_id')->where(array("kh_file"=>['LIKE',"%".$fname]))->select();//"status"=>['in','2,4'],
			if(!$r)return ['err','kh_dbf没找到数据'];
			return ['kh',$r];
		}elseif(in_array($fr,['GH.DBF','gh.DBF'])){
			$r=D('gh_dbf')->field('id,cf_ivs_right_id')->where(array("gh_file"=>['LIKE',"%".$fname]))->select();//"status"=>['in','2,4'],
			if(!$r)return ['err','gh_dbf没找到数据'];
			return ['gh',$r];
		}elseif(in_array($fr,['RJ.DBF','rj.DBF'])){
			$r=D('rj_dbf')->field('id,cf_ivs_right_id')->where(array("rj_file"=>['LIKE',"%".$fname]))->select();//"status"=>['in','2,4'],
			if(!$r)return ['err','gh_dbf没找到数据'];
			return ['rj',$r];
		}
		return ['err','不识别的结尾'];
	}
	
}