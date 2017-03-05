<?php

/**
 * Class CommonController
 * @package Home\Controller
 */
namespace Guest\Controller;

use Think\Controller;

/**
 * 前台公共控制器
 * Class AdminController
 * @package Admin\Controller
 */
class TjotcapiController extends Controller
{
	//此为测试使用
    public function showform($ac,$arr){
		echo "<hr><h1>/Guest/Tjotcapi/".$ac."</h1>";
        echo '<form class="form" method="get" enctype="multipart/form-data" action="/Guest/Tjotcapi/'.$ac.'">';
        foreach($arr as $k=>$v){
            $vd='';
            if(!is_numeric($k)){
                $vd=$v;$v=$k;
            }
			$vr=explode('：',$v);
			if(count($vr)==2){
				$sm=$vr[0];$v=$vr[1];
			}else{
				$sm=$vr[0];
			}
            list($v,$v2,$v3)=explode('.',$v);
			if($v2&&$v2=='textarea'){
				echo reset(explode('.',$sm)).":<br><textarea name='".$v."' style='width:500px;height:300px;'>".$vd."</textarea><br>";
			}else{
				echo reset(explode('.',$sm)).":<input type='".($v2?$v2:'text')."' name='".$v."' value='".$vd."'><br>";
			}
        }
        echo "<input type='submit'>";
        echo "</form>";
    }
    public function aaa(){ 
		/* ob_start();
		ob_implicit_flush(1);
		for( $i = 0; $i <10; $i ++ ){
		 sleep(1);
		 print "Content-type: text/plain\n\n";
		 print "Part $i\t";
		 echo str_repeat('X', 1024*4);
		 print "--endofsection\n";
		 
		 ob_flush();
		 flush();
	  }exit; */
		
		$this->display('Index/try'); 
		$b ='<?xml version="1.0" encoding="gbk"?><root><OrgCode>SEZB004</OrgCode><FileID>2806</FileID><FileName>TJC_TJC999_SEZB004_20160219_110339_RJHB.DBF</FileName><FileSize>698</FileSize><MD5Code>53451A1C5DFA68620483E9B924443F7F</MD5Code></root>';
		$this->showform('otcapi',['type'=>'2','ParName'=>'FileReady','ParValue.textarea'=>$b]);
		 
	
    }
	public function bbb(){
		$tjotc=new \Guest\Model\TjotcModel();
		$uri="TJC_TJC999_SEZB004_20151013_KB.DBF";

		$a=$tjotc->readfileftp($uri);
		print_r($a);
		foreach($a as $v){
			$v["cf_ivs_right_id"]="10";
			$v["cf_ivs_id"]="10";
			$v["file_uri"]=$uri;
			D('api_kb_save')->add($v);
		}
	}
	//---------------------------------------------------------------------------------------------------------
	//---------------------------------------------------------------------------------------------------------
	//---------------------------------------------------------------------------------------------------------
	//---------------------------------------------------------------------------------------------------------
	/**
	*	kh文件检查完成后的操作
	*/
	private function filecheck_kh($c,$ids,$rids,$my_note){
		if($c['CheckFlag']=='0'){
			$my_note.=",{$c['FileName']}检查成功";
			$r=D('kh_dbf')->where(array("status"=>['in','2,4'],"id"=>['in',implode(',',$ids)]))->save(array("status"=>'3'));
			if($r>=1){
				$my_note.=",kh_dbf表修改成功";
				$r=D('cf_ivs_right')->where(array("status"=>['in','1'],"id"=>['in',implode(',',$rids)],"step"=>"2"))->save(array("status"=>'1',"step"=>'3')); //OTC确认收到阶段
				if($r>=1){
					D('CfIvsRightLog')->addRightLogsByFilename($c['FileName'],2,3,1,1,0,"开户文件资料审核机构已收到:".$c['CheckDescription']); 
					$my_note.=",cf_ivs_right表修改成功";
				}else{
					$my_note.=",cf_ivs_right表修改失败";
				}
			}else{$my_note.=",kh_dbf表修改失败";}
		}else{
			$my_note.=",{$c['FileName']}检查失败";
			$r=D('kh_dbf')->where(array("status"=>['in','2,4'],"id"=>['in',implode(',',$ids)]))->save(array("status"=>'4'));
			if($r>=1){
				$my_note.=",kh_dbf表修改成功";
				$r=D('cf_ivs_right')->where(array("status"=>['in','1'],"id"=>['in',implode(',',$rids)],"step"=>"2"))->save(array("status"=>'1',"step"=>'1')); //恢复开户材料重新发送阶段
				if($r==1){
					D('CfIvsRightLog')->addRightLogsByFilename($c['FileName'],2,1,1,1,0,"开户文件资料审核机构未收到:".$c['CheckDescription']); 
					$my_note.=",cf_ivs_right表修改成功";
				}else{
					$my_note.=",cf_ivs_right表修改失败";
				}
			}else{
				$my_note.=",kh_dbf表修改失败";
			}
		}
		return [$my_note];
	}
	/**
	*	rj文件检查完成后的操作
	*/
	private function filecheck_rj($c,$ids,$rids,$my_note){
		
		if($c['CheckFlag']=='0'){
						$my_note.=",{$c['FileName']}检查成功";
						$r=D('rj_dbf')->where(array("status"=>['in','2,4'],"id"=>['in',implode(',',$ids)]))->save(array("status"=>'3'));
						if($r>=1){
							$my_note.=",rj_dbf表修改成功";
							$r=D('cf_ivs_right')->where(array("status"=>['in','1'],"id"=>['in',implode(',',$rids)],"step"=>"12"))->save(array("status"=>'1',"step"=>'13')); //OTC确认收到阶段
							if($r>=1){
								D('CfIvsRightLog')->addRightLogsByFilename($c['FileName'],12,13,1,1,0,"入金文件资料审核机构已收到:".$c['CheckDescription']); 
								$my_note.=",cf_ivs_right表修改成功";
							}else{
								$my_note.=",cf_ivs_right表修改失败";
							}
						}else{$my_note.=",rj_dbf表修改失败";}
		}else{
						$my_note.=",{$c['FileName']}检查失败";
						$r=D('rj_dbf')->where(array("status"=>['in','2,4'],"id"=>['in',implode(',',$ids)]))->save(array("status"=>'4'));
						if($r>=1){
							$my_note.=",rj_dbf表修改成功";
							$r=D('cf_ivs_right')->where(array("status"=>['in','1'],"id"=>['in',implode(',',$rids)],"step"=>"12"))->save(array("status"=>'1',"step"=>'11')); //恢复入金材料重新发送阶段
							if($r>=1){
								D('CfIvsRightLog')->addRightLogsByFilename($c['FileName'],12,11,1,1,0,"入金文件资料审核机构未收到:".$c['CheckDescription']); 
								$my_note.=",cf_ivs_right表修改成功";
							}else{
								$my_note.=",cf_ivs_right表修改失败";
							}
						}else{$my_note.=",rj_dbf表修改失败";}
		}
		return [$my_note];
	}
	/**
	*	gh文件检查完成后的操作
	*/
	private function filecheck_gh($c,$ids,$rids,$my_note){
		if($c['CheckFlag']=='0'){
						$my_note.=",{$c['FileName']}检查成功";
						$r=D('gh_dbf')->where(array("status"=>['in','2,4'],"id"=>['in',implode(',',$ids)]))->save(array("status"=>'3'));
						if($r>=1){
							$my_note.=",gh_dbf表修改成功";
							$r=D('cf_ivs_right')->where(array("status"=>['in','1'],"id"=>['in',implode(',',$rids)],"step"=>"6"))->save(array("status"=>'1',"step"=>'7')); //OTC确认收到阶段
							if($r>=1){
								// print_r($c);
								D('CfIvsRightLog')->addRightLogsByFilename($c['FileName'],6,7,1,1,0,"过户文件资料审核机构已收到:".$c['CheckDescription']); 
								$my_note.=",cf_ivs_right表修改成功";
							}else{
								$my_note.=",cf_ivs_right表修改失败";
							}
						}else{$my_note.=",gh_dbf表修改失败";}
		}else{
						$my_note.=",{$c['FileName']}检查失败";
						$r=D('gh_dbf')->where(array("status"=>['in','2,4'],"id"=>['in',implode(',',$ids)]))->save(array("status"=>'4'));
						if($r>=1){
							$my_note.=",gh_dbf表修改成功";
							$r=D('cf_ivs_right')->where(array("status"=>['in','1'],"id"=>['in',implode(',',$rids)],"step"=>"6"))->save(array("status"=>'1',"step"=>'4')); //恢复过户材料重新发送阶段
							if($r>=1){
								D('CfIvsRightLog')->addRightLogsByFilename($c['FileName'],6,4,1,1,0,"过户文件资料审核机构未收到:".$c['CheckDescription']); 
								$my_note.=",cf_ivs_right表修改成功";
							}else{
								$my_note.=",cf_ivs_right表修改失败";
							}
						}else{$my_note.=",gh_dbf表修改失败";} 
		}
		return [$my_note];
	}
	/**
	*	kb通知下载后的操作
	*/
	private function fileready_kb($c,$tjotc,&$my_note){
		$t1 = microtime(true);
		$rml=$tjotc->get_file_ftp($c['FileName']);//下载文件，并返回本地位置
		$t2 = microtime(true);
		$time2 = number_format($t2-$t1,3);
		if($rml){$my_note.=",文件下载成功".$time2."秒";}else{$my_note.=",文件下载失败".$time2."秒";return;}
		if (md5_file($rml) == $c['MD5Code']){		//文件校验
			$my_note.=",文件校验成功";
		}else{
			// $my_note.=",文件校验失败";return;
		}
		$content=$tjotc->readfileftp($rml);	   //读取文件，返回内容数组
		$my_note.=",共含有KB数据".count($content)."条";
		$new_in_ids=array();
		$list  = array();
		// print_r($content);
		// exit;
		$isture = true;
		foreach($content as $thv){
			//KBSQDH  申请编号=交易编号
			$bh=trim($thv['KBSQDH']);
			$bh = explode("_",$bh);
			$bh = $bh[0];
			$KBJSZH=trim($thv['KBJSZH']);//OTC客户编号
			$KBJYZH=trim($thv['KBJYZH']);//客户ID
			
			//跟据申请编号查找ivs_id
			$ivs=D('cf_ivs')->where(['ivs_order'=>$bh])->find();
			if(!$ivs){$my_note.=",cf_ivs失败";continue;}
			//跟据ivs_id查找ivs_right_id
			$ivs_right=D('cf_ivs_right')->field('id')->where(['status'=>'1','cf_ivs_id'=>$ivs['id']])->find();
			
			if(!$ivs_right){$my_note.=",cf_ivs_right失败";continue;}
			
			//插入otc_kb_dbf
			$kb_data=['cf_ivs_id'=>$ivs['id'],'cf_ivs_right_id'=>$ivs_right['id'],
											  'kb_file'=>$rml,'otc_file_id'=>$c['FileID'],'validflag'=>'1',
											  'status'=>'2','createdate'=>date("Y-m-d"),'createtime'=>date("Y-m-d H:i:s")];
			$kb_data = array_merge($kb_data,$thv);
			$temp_kb_id=D('kb_dbf')->add($kb_data);
			if($temp_kb_id){
				$new_in_id = $temp_kb_id;
				$new_in_ids[] = $new_in_id;	
			}
			
			
			if(trim($thv['KBFHDM'])!="0"){//表示确权出错 
				//更新开户确权记录状态为开户失败
				$r=D('cf_ivs_right')->where(array("status"=>['in','1'],"id"=>$ivs_right['id'],"step"=>"3"))->save(array("status"=>'3',"step"=>'5')); //OTC开户失败,"errornum"=>['exp',"errornum+1"]
					
				if($r==1){
					$my_note.=",".$thv['KBSQDH']."开户出错";
					D('CfIvsRightLog')->addRightLogByRid($ivs_right['id'],3,5,1,3,trim($thv['KBFHDM']),"开户回报审核失败");
				}else{
					$my_note.=",cf_ivs_right表修改失败";
				}
				continue;
			}
			if($KBJSZH){
				D('cust_person')->where(['cod_cust_id'=>$ivs['cod_cust_id']])->save(["otc_jszh"=>$KBJSZH]);
			}
			// echo D('cust_person')->getLastSql();echo "|{$KBJSZH}<br/>";
			//更新开户确权记录状态为开户成功
			$r=D('cf_ivs_right')->where(array("status"=>['in','1'],"id"=>$ivs_right['id'],"step"=>"3"))->save(array("status"=>'1',"step"=>'11')); //OTC开户成功
			if($r==1){
				D('CfIvsRightLog')->addRightLogByRid($ivs_right['id'],3,11,1,1,0,"开户回报审核成功");
				// $list[]=$ivs['id'];
				$list[]=array_merge($ivs,array("ivs_right_id"=>$ivs_right['id']));
			}else{
				$step = D('cf_ivs_right')->where(array("id"=>$ivs_right['id']))->getField('step');
				if($step!=11){
					$isture=false;
				}
				
			}
			
			
			
			
				
			
			// continue;

						
			
			//更新用户表
			// D('cust_person')->where(['cod_cust_id'=>$KBJYZH])->save(["otc_jszh"=>$KBJSZH]);
			
			
			//插入dbf save记录
			// $tjotc->dbf_save_db('api_kb_save',$thv,$ivs['id'],$ivs_right['id'],$rml);
			//判断是否确权成功
			// $tjotc->check_cf_right($ivs_right['id']);
			
		}
		// print_r($list); 
		// if($list){
			// $list = D('CfIvs')
									// ->field('t1.*,t2.id as ivs_right_id')
									// ->table('__' . strtoupper('Cf_ivs'). '__ as t1')
									// ->join('__' . strtoupper('cf_ivs_right'). '__ as t2 ON  t1.id=t2.cf_ivs_id','left') 
									// ->where(["t1.id"=>$list]) //or t2.step = 5 开户失败状态
									// ->order()->select();  
									
			D('Cf_ivs_right')->startIvsRightByRj($list,0);
			$my_note.=",共含有可以入金数据".count($list)."条";
		// }
		
		// $tjotc->file_down_over_toOTC($c);		//确认文件已经下载通知
		if(isset($new_in_id)&&$isture){
			//确认文件已经下载通知
			$return = D("Admin/Token")->FileDownloadFinished($new_in_id,"kb");
			if($return === "1005"){
				D("Admin/Token")->FileDownloadFinished($new_in_id,"kb",true);
			}
		}
		return [$new_in_ids];
	}
	/**
	*	rjhb通知下载后的操作
	*/
	private function fileready_rjhb($c,$tjotc,&$my_note){
		
		$t1 = microtime(true);
		$rml=$tjotc->get_file_ftp($c['FileName']);//下载文件，并返回本地位置
		$t2 = microtime(true);
		$time2 = number_format($t2-$t1,3);
		if($rml){$my_note.=",文件下载成功".$time2."秒";}else{$my_note.=",文件下载失败".$time2."秒";return;} 
		if (md5_file($rml) == $c['MD5Code']){		//文件校验
			$my_note.=",文件校验成功";
		}else{
			// $my_note.=",文件校验失败";return;
		}
		$content=$tjotc->readfileftp($rml);	   //读取文件，返回内容数组
		$my_note.=",共含有RJHB数据".count($content)."条";
		$new_in_ids=array();
		$list  = array();
		$list2  = array();
		// print_r($content);
		$isture = true;
		foreach($content as $thv){//RJHBGHDH  申请编号=交易编号
			$bh=trim($thv['RJHBGHDH']);
			$bh = explode("_",$bh);
			$bh = $bh[0];
			// var_dump("A".$bh."B");
			// dump($shuhui);
			
			$shuhui=substr($bh,0,2);
			$title=$shuhui =="SH"?"赎回":"";
			$msg='';
			//跟据申请编号查找ivs_id
			if($shuhui=="SH"){
				$ivs=D('cf_ivs_redemption')->where(['ivs_order'=>$bh])->find();
				if(!$ivs){$msg.=",cf_ivs失败";$my_note.=$msg;continue;}
				//跟据ivs_id查找ivs_right_id
				$ivs_right=D('cf_ivs_right')->field('id')->where(['status'=>'1','cf_ivs_id'=>$ivs['cod_cf_ivs_id'],'cf_ivs_redemption_id'=>$ivs['id']])->find();
				if(!$ivs_right){$my_note.=",cf_ivs_right失败";$my_note.=$msg;continue;}
			}else{
				$ivs=D('cf_ivs')->where(['ivs_order'=>$bh])->find();
				if(!$ivs){$msg.=",cf_ivs失败";$my_note.=$msg;continue;}
				//跟据ivs_id查找ivs_right_id
				$ivs_right=D('cf_ivs_right')->field('id')->where(['status'=>'1','cf_ivs_id'=>$ivs['id']])->find();
				if(!$ivs_right){$msg.=",cf_ivs_right失败";$my_note.=$msg;continue;}
			}
			
			
			
			//插入otc_gb_dbf
			$rjhb_data=['cf_ivs_id'=>$ivs['id'],'cf_ivs_right_id'=>$ivs_right['id'],'msg'=>$msg,
							'rjhb_file'=>$rml,'otc_file_id'=>$c['FileID'],'validflag'=>'1',
							'status'=>'2','createdate'=>date("Y-m-d"),'createtime'=>date("Y-m-d H:i:s")];
			if($shuhui=="SH"){
				$rjhb_data['cf_ivs_id']=$ivs['cod_cf_ivs_id'];
				$rjhb_data['cf_ivs_redemption_id']=$ivs['id'];
			}
			$rjhb_data = array_merge($rjhb_data,$thv);
			$temp_rjhb_id=D('rjhb_dbf')->add($rjhb_data);  
			if($temp_rjhb_id){
				$new_in_id = $temp_rjhb_id;
				$new_in_ids[] = $new_in_id;	
			}
			
			if(trim($thv['RJHBFHDM'])!="0"){//表示确权出错 
				//更新开户确权记录状态为过失败
				$r=D('cf_ivs_right')->where(array("status"=>['in','1'],"id"=>$ivs_right['id'],"step"=>"13"))->save(array("status"=>'3',"step"=>'14')); //OTC入金失败,"errornum"=>['exp',"errornum+1"]
				
				if($r==1){
					$my_note.=",".$thv['RJHBGHDH']."入金出错";
					D('CfIvsRightLog')->addRightLogByRid($ivs_right['id'],13,14,1,3,$thv['RJHBFHDM'],$title."入金回报审核失败");
				}else{
					$my_note.=",cf_ivs_right表修改失败";
				}
				continue;
			}
			
			$r=D('cf_ivs_right')->where(array("status"=>['in','1'],"id"=>$ivs_right['id'],"step"=>"13"))->save(array("status"=>'1',"step"=>'4')); //OTC入金成功
			if($r==1){ 
				D('CfIvsRightLog')->addRightLogByRid($ivs_right['id'],13,4,1,1,0,$title."入金回报审核成功");
				// $list[]= $ivs['id'];
				if($shuhui=="SH"){
					$list2[]=array_merge($ivs,array("ivs_right_id"=>$ivs_right['id']));
				}else{
					$list[]=array_merge($ivs,array("ivs_right_id"=>$ivs_right['id']));
				}
				
			}else{
				$step = D('cf_ivs_right')->where(array("id"=>$ivs_right['id']))->getField('step');
				if($step!=4){
					$isture=false;
				}
			}
			
			
			
			//插入dbf save记录
			// $tjotc->dbf_save_db('api_gb_save',$thv,$ivs['id'],$ivs_right['id'],$rml);
			//判断是否确权成功
			// $tjotc->check_cf_right($ivs_right['id']);
		}
		
		
		// if($list){
			// $list = D('CfIvs')
									// ->field('t1.*,t2.id as ivs_right_id')
									// ->table('__' . strtoupper('Cf_ivs'). '__ as t1')
									// ->join('__' . strtoupper('cf_ivs_right'). '__ as t2 ON  t1.id=t2.cf_ivs_id','left') 
									// ->where(["t1.id"=>$list]) //or t2.step = 5 开户失败状态
									// ->order()->select();  
			D('Cf_ivs_right')->startIvsRightByGh($list,0);
			$my_note.=",共含有可以过户数据".count($list)."条";
			D('Cf_ivs_right')->startIvsRightByGh($list2,0,2);
			$my_note.=",共含有可以赎回过户数据".count($list2)."条";
		// }
		// $tjotc->file_down_over_toOTC($c);		//确认文件已经下载通知 
        if(isset($new_in_id)&&$isture){
			//确认文件已经下载通知
			$return = D("Admin/Token")->FileDownloadFinished($new_in_id,"rjhb"); 
			if($return === "1005"){
				D("Admin/Token")->FileDownloadFinished($new_in_id,"rjhb",true);
			}
		}
		
		return [$new_in_ids];
	}
	/**
	*	gb通知下载后的操作
	*/
	private function fileready_gb($c,$tjotc,&$my_note){
		$t1 = microtime(true);
		$rml=$tjotc->get_file_ftp($c['FileName']);//下载文件，并返回本地位置
		$t2 = microtime(true);
		$time2 = number_format($t2-$t1,3);
		if($rml){$my_note.=",文件下载成功".$time2."秒";}else{$my_note.=",文件下载失败".$time2."秒";return;} 
		if (md5_file($rml) == $c['MD5Code']){		//文件校验
			$my_note.=",文件校验成功";
		}else{
			// $my_note.=",文件校验失败";return;
		}
		$content=$tjotc->readfileftp($rml);	   //读取文件，返回内容数组
		$my_note.=",共含有GB数据".count($content)."条";
		$new_in_ids=array();
		// print_r($content);
		$isture = true;
		foreach($content as $thv){//GBSQDH  申请编号=交易编号
			$bh=trim($thv['GBSQDH']);
			$bh = explode("_",$bh);
			$bh = $bh[0];
			
			// var_dump("A".$bh."B");
			$shuhui=substr($bh,0,2);
			$title=$shuhui =="SH"?"赎回":"";
			if($shuhui =="SH"){
				if(trim($thv['GBCJFX'])=="B"){
					continue;
				}
				$bh=trim($thv['GBSQDH']);
				$bh = explode("S_",$bh);
				$bh = $bh[0];
			}else{
				if(trim($thv['GBCJFX'])=="S"){
					continue;
				}
			}
			 
			$msg="";
			if($shuhui=="SH"){
				$ivs=D('cf_ivs_redemption')->where(['ivs_order'=>$bh])->find();
				if(!$ivs){$msg.=",cf_ivs失败";$my_note.=$msg;continue;}
				//跟据ivs_id查找ivs_right_id
				$ivs_right=D('cf_ivs_right')->field('id')->where(['status'=>'1','cf_ivs_id'=>$ivs['cod_cf_ivs_id'],'cf_ivs_redemption_id'=>$ivs['id']])->find();
				if(!$ivs_right){$msg.=",cf_ivs_right失败";$my_note.=$msg;continue;}
			}else{
				$ivs=D('cf_ivs')->where(['ivs_order'=>$bh])->find();
				if(!$ivs){$msg.=",cf_ivs失败";$my_note.=$msg;continue;}
				//跟据ivs_id查找ivs_right_id
				$ivs_right=D('cf_ivs_right')->field('id')->where(['status'=>'1','cf_ivs_id'=>$ivs['id']])->find();
				if(!$ivs_right){$msg.=",cf_ivs_right失败";$my_note.=$msg;continue;}
			}
			
			
			
			
			
			
			//插入otc_gb_dbf
			$gb_data=['cf_ivs_id'=>$ivs['id'],'cf_ivs_right_id'=>$ivs_right['id'],'msg'=>$msg,
							'gb_file'=>$rml,'otc_file_id'=>$c['FileID'],'validflag'=>'1',
							'status'=>'2','createdate'=>date("Y-m-d"),'createtime'=>date("Y-m-d H:i:s")];
			if($shuhui=="SH"){
				$gb_data['cf_ivs_id']=$ivs['cod_cf_ivs_id'];
				$gb_data['cf_ivs_redemption_id']=$ivs['id'];
			}
			$gb_data = array_merge($gb_data,$thv);
			$temp_gb_id=D('gb_dbf')->add($gb_data);  
			if($temp_gb_id){
				$new_in_id = $temp_gb_id;
				$new_in_ids[] = $new_in_id;	
			}
			
			if(trim($thv['GBFHDM'])!="0"){//表示确权出错 
				//更新开户确权记录状态为过失败
				$r=D('cf_ivs_right')->where(array("status"=>['in','1'],"id"=>$ivs_right['id'],"step"=>"7"))->save(array("status"=>'3',"step"=>'9')); //OTC过户失败,"errornum"=>['exp',"errornum+1"]
				$my_note.=$r.trim($thv['GBFHDM']);
				if($r){
					$my_note.=",".$bh."过户出错";
					D('CfIvsRightLog')->addRightLogByRid($ivs_right['id'],7,9,1,3,trim($thv['GBFHDM']),$title."过户回报审核失败");
				}else{
					$my_note.=",cf_ivs_right表修改失败";
				}
				continue;
			}
			$qqh_url=C('OTC_QQH_PATH');
			$qqh_url.="/{$ivs['product_code']}/".C('OTC_API_TOOKEN')['orgcode']."/".strtoupper(md5($ivs['cod_cust_id']))."{$ivs['product_code']}.pdf";
			$r=D('cf_ivs_right')->where(array("status"=>['in','1'],"id"=>$ivs_right['id'],"step"=>"7"))->save(array("status"=>'1',"step"=>'8',"qqh_file"=>$qqh_url)); //OTC过户成功
			if($r==1){ 
				D('CfIvsRightLog')->addRightLogByRid($ivs_right['id'],7,8,1,1,0,$title."过户回报审核成功");
			}else{
				$step = D('cf_ivs_right')->where(array("id"=>$ivs_right['id']))->getField('step');
				if($step!=8){
					$isture=false;
				}
			} 
			
			
			//插入dbf save记录
			// $tjotc->dbf_save_db('api_gb_save',$thv,$ivs['id'],$ivs_right['id'],$rml);
			//判断是否确权成功
			// $tjotc->check_cf_right($ivs_right['id']);
		}
		// $tjotc->file_down_over_toOTC($c);		//确认文件已经下载通知 
        if(isset($new_in_id)&&$isture){
			//确认文件已经下载通知
			$return = D("Admin/Token")->FileDownloadFinished($new_in_id,"gb"); 
			if($return === "1005"){
				D("Admin/Token")->FileDownloadFinished($new_in_id,"gb",true);
			}
		}
		
		return [$new_in_ids];
	}
	/**
	*	dz通知下载后的操作
	*/
	private function fileready_dz($c,$tjotc,&$my_note,$type=""){
		// echo 1213231;exit;
		$t1 = microtime(true);
		$rml=$tjotc->get_file_ftp($c['FileName']);//下载文件，并返回本地位置
		$t2 = microtime(true);
		$time2 = number_format($t2-$t1,3);
		if($rml){$my_note.=",文件下载成功".$time2."秒";}else{$my_note.=",文件下载失败".$time2."秒";return;}
		if (md5_file($rml) == $c['MD5Code']){		//文件校验
			$my_note.=",文件校验成功";
		}else{
			// $my_note.=",文件校验失败";return;
		}
		$content=$tjotc->readfileftp($rml);	   //读取文件，返回内容数组
		$my_note.=",共含有DZ{$type}数据".count($content)."条";
		
		$new_in_ids=array();
		// if( ACTION_NAME =='otcapidemo'){
			// dump($content);exit;
		// }
		
		foreach($content as $thv){//KBSQDH  申请编号=交易编号
			$DZCPDM=trim($thv['DZCPDM']);
			$DZJSZH=trim($thv['DZJSZH']);//结算账户
			$DZJYZH=trim($thv['DZJYZH']);//交易账户
			$DZCYFE=trim($thv['DZCYFE']);//持有份额
			 
			$map =[
					"b.product_code"=>$DZCPDM,
					"b.cod_cust_id"=>$DZJYZH,
					"a.step"=>8,
					"a.status"=>array("IN","1,2"),
				];
			$ivs_right_list=D('cf_ivs_right')->alias("a")->join("__CF_IVS__ b on b.id  = a.cf_ivs_id")
			->field('a.id,a.status,a.cf_ivs_redemption_id')->where($map)->select();
			
			
			// dump($ivs_right_list);
			
			$msg="(".count($ivs_right_list).")";
			//有查询到对应相关的确权交易记录
			if($ivs_right_list&&$type=="BD"){
				$map["b.cod_ivs_status"]=1;
				//所有确权走到8的确权总额
				$all_quequanchenggongSum=D('cf_ivs_right')->alias("a")->join("__CF_IVS__ b on b.id  = a.cf_ivs_id")->where($map)->sum("b.amt_int_total");
				$all_quequanchenggongSum=$all_quequanchenggongSum?$all_quequanchenggongSum:0;
				
				$map["a.status"]="2";
				$map["b.cod_ivs_status"]=array("IN","1,2");
				$map = "b.product_code = '{$DZCPDM}' AND b.cod_cust_id = '{$DZJYZH}' AND
				((a.step = 8 AND a. STATUS = '2' and a.cf_ivs_redemption_id =0) or (a.cf_ivs_redemption_id !=0 and a. STATUS = '1'))
				AND b.cod_ivs_status IN ('1', '2')";
				//所有确权走到8的并且已经结束确权总额
				$all_quequanjieshuSum=D('cf_ivs_right')->alias("a")->join("__CF_IVS__ b on b.id  = a.cf_ivs_id")->where($map)->sum("b.amt_int_total");
				$all_quequanjieshuSum=$all_quequanjieshuSum?$all_quequanjieshuSum:0;
				// echo D('cf_ivs_right')->getLastSql();
				$msg.="||当前对账金额($DZCYFE)_{$DZJYZH}_{$DZCPDM}";
				$msg.="||所有确权走到8的确权总额($all_quequanchenggongSum)".($DZCYFE==$all_quequanchenggongSum?"true":"false");
				$msg.="||所有确权走到8的并且已经结束确权总额($all_quequanjieshuSum)".($DZCYFE!=$all_quequanjieshuSum?"true":"false"); 
				//当前对账金额 与 所有确权走到8的并且已经结束确权总额 不等（说明需要更新）
			   //并且当前对账金额 与 所有确权走到8的确权总额相等（说明可以更新）
				$my_note.=$msg;
				if( $DZCYFE==$all_quequanchenggongSum &&( $DZCYFE!=$all_quequanjieshuSum )){
					$asyncDown = true;
					foreach($ivs_right_list as $key=>$ivs_right){
						if($ivs_right["status"]==1){
							$r=D('cf_ivs_right')->where(array("id"=>$ivs_right['id']))->save(array("status"=>'2')); //OTC过户失败
							if($r>=0){
								if($ivs_right['cf_ivs_redemption_id']==0){
									$asyncDown = false;
								}
								$msg_str=$ivs_right['cf_ivs_redemption_id']!=0?"更新":"生成";
								D('CfIvsRightLog')->addRightLogByRid($ivs_right['id'],1,2,8,8,0,"确权函已{$msg_str}！");
							}else{
								$my_note.=",{$DZJYZH}_{$DZCPDM}确权函生成失败";
							}
						}else if($ivs_right["status"]==2){
							D('CfIvsRightLog')->addRightLogByRid($ivs_right['id'],2,2,8,8,0,"确权函已更新！");
						}
					}
					//满足条件异步下载/更新确权函
					if($asyncDown == true&&$ivs_right_list){
						$url ="http://{$_SERVER['HTTP_HOST']}/Guest/Regularly/DownNewFile/rid/".$ivs_right_list[0]['id'];
						$status=$this->asyncExecute($url);
						// $my_note.=",{$DZJYZH}_{$DZCPDM}确权函异步更新($status})";
					}
				}
				
			}else if($type=="BD"){
				$my_note.=",{$DZJYZH}_{$DZCPDM}确权记录关联失败";
			}
			// continue;
			//跟据申请编号查找ivs_id
		/* 	
			$dmArr = explode("A",$DZCPDM)
			$cfmast=D('cf_mast')->field('id')->where(['code'=>$dmArr[0]])->find();
			if(!$cfmast){$my_note.=",cf_mast失败";continue;}
			  */
			
			// if(trim($thv['KBFHDM'])!="0"){//表示确权出错
				// $r=D('cf_ivs_right')->where(array("status"=>['in','1,3'],"id"=>$ivs_right['id']))->save(array("status"=>'3'));
				// if($r==1){$my_note.=",".$thv['KBSQDH']."确权出错";}else{$my_note.=",cf_ivs_right表修改失败";}
				// continue;
			// }
			
			// $r=D('cf_ivs_right')->where(array("status"=>['in','1'],"id"=>$ ['id'],"step"=>"8"))->save(array("status"=>'2',"step"=>'10')); //OTC对账成功
			
			//插入otc_dz_dbf
			$dz_data=['cf_mast_id'=>0,'cust_id'=>$DZJYZH,'msg'=>$msg,
							  'dz_file'=>$rml,'otc_file_id'=>$c['FileID'],'validflag'=>'1',
							  'status'=>'2','createdate'=>date("Y-m-d"),'createtime'=>date("Y-m-d H:i:s")];
			$dz_data = array_merge($dz_data,$thv);
			$temp_dz_id=D('dz_dbf')->add($dz_data);  
			if($temp_dz_id){
				$new_in_id = $temp_dz_id;
				$new_in_ids[] = $new_in_id;	
			}
			//插入dbf save记录
			// $tjotc->dbf_save_db('api_dz_save',$thv,$ivs['id'],$ivs_right['id'],$rml);
			//判断是否确权成功
			// $tjotc->check_cf_right($ivs_right['id']);
		}
		// echo $new_in_id;
		if(isset($new_in_id)){
			//确认文件已经下载通知
			$return = D("Admin/Token")->FileDownloadFinished($new_in_id,"dz"); 
			
			if($return === "1005"){
				D("Admin/Token")->FileDownloadFinished($new_in_id,"dz",true);
			}
		}
		// $tjotc->file_down_over_toOTC($c);		//确认文件已经下载通知
		return [$new_in_ids];
	}
	/**
	*天津otc回调接口
	*/
	public function otcapidemo($type="1",$pid='0',$logid=0){
		 
		$time1=time();
		$t1 = microtime(true);
		$a=new \Common\Lib\Otcapi();//实例化对象 
		$_GET['ParValue']='<?xml version="1.0" encoding="gbk"?><root><OrgCode>SEZB004</OrgCode><FileID>3895</FileID><FileName>TJC_TJC999_SEZB004_20160219_101441_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>5039379EE5D4626961B16FCD2DF2289B</MD5Code></root>';
		$value=M("api_log")->where(["id"=>$logid])->getField("ParValue");
		
		if($value){
			$c=$a->xmlArrayByString($value);
		}else{
			exit;
		}
		if($type==1&&$_GET['ParName']=="FileReady"){
			ignore_user_abort(false);
			$my_note="异步：";
			// print_r($c);
			$where["FileName"]=$c['FileName'];
			$where['FileID']=$c['FileID'];
			$count = M("api_downfile_log")->where($where)->count();
			// dump($count);
			$pid = date("YmdHis").rand(1000,9999);
			$url ="http://{$_SERVER['HTTP_HOST']}/Guest/Tjotcapi/otcapi?type=2&pid=".$pid."&ParName={$_GET['ParName']}&ParValue=".$a->createXmlStr($c);
			$fr=end(explode('_',$c['FileName']));
			if($count>1&&$fr!="DZBD.DBF"){
				$my_note .="{$c['FileName']}<{$c['FileID']}>已下载处理过{$count}次，忽略处理；";
			}else{
				$my_note .="调用同步状态：({$pid})";
				// echo file_get_contents($url);
				// exit;
				$status=$this->asyncExecute($url);
				$my_note .="($status)；";
			}
			$clientip = get_client_ip();
			$t2 = microtime(true);
			$time2 = number_format($t2-$t1,3);
			$apilog_id=D('api_log')->add(
					array(	'ParValue'=>$_GET['ParValue'],'ParName'=>$_GET['ParName'],
							'add_time'=>date('Y-m-d H:i:s'),'my_note'=>"执行时间：".$time2."秒||".($my_note),'clientip'=>$clientip,'_SERVER'=>serialize($_SERVER)));
			
		}
		if($type==2||$_GET['ParName']=="FileCheckStatus"){
			set_time_limit(0);
			ignore_user_abort(true);
			$my_note="同步：({$pid})";
			 
			$clientip = get_client_ip();
			$t2 = microtime(true);
			$time2 = number_format($t2-$t1,3);
			$apilog_id=D('api_log')->add(array(	'ParValue'=>$_GET['ParValue'],'ParName'=>$_GET['ParName'],
												'add_time'=>date('Y-m-d H:i:s'),'my_note'=>$my_note."执行时间：".$time2."秒||正在处理...",'clientip'=>$clientip,'_SERVER'=>serialize($_SERVER)));
												
			$tjotc=new \Guest\Model\TjotcModel();
			
			switch($_GET['ParName']){
				case 'FileCheckStatus'://文件检查接口
					$my_note.="api检查完毕通知我方";
					list($action,$data)=$tjotc->get_khid($c['FileName']);
					$ids=array();
					$rids=array();
					foreach($data as $d){
						$ids[]=$d['id'];
						$rids[]=$d['cf_ivs_right_id'];
					}
					if($action=='kh'){
						//kh文件检查完成后的操作
						list($my_note)=$this->filecheck_kh($c,$ids,$rids,$my_note);
					}elseif($action=='rj'){
						//gh文件检查完成后的操作
						list($my_note)=$this->filecheck_rj($c,$ids,$rids,$my_note);
					}elseif($action=='gh'){
						//gh文件检查完成后的操作
						list($my_note)=$this->filecheck_gh($c,$ids,$rids,$my_note);
					}else{
						$my_note.=",FileName没有找到正确数据(".$action.",".$data.")";
					}
				break;
				case 'FileReady'://结算所 通知第三方 下载 文件接口 
					$my_note.="api通知我方下载"; 
					$fr=end(explode('_',$c['FileName']));
					
					switch(strtoupper($fr)){
						case "KB.DBF":
							list($new_in_ids)=$this->fileready_kb($c,$tjotc,$my_note);
						break;
						case "RJHB.DBF":
							list($new_in_ids)=$this->fileready_rjhb($c,$tjotc,$my_note);
						break;
						case "GB.DBF":
							list($new_in_ids)=$this->fileready_gb($c,$tjotc,$my_note);
						break;
						case "DZ.DBF":
							list($new_in_ids)=$this->fileready_dz($c,$tjotc,$my_note,"");
						break;
						case "DZBD.DBF":
							list($new_in_ids)=$this->fileready_dz($c,$tjotc,$my_note,"BD");
						break;
						default:
							$my_note.=",FileName不是正确数据(".strtoupper($fr).")";
					}
				break;
			} 
			
			$clientip = get_client_ip();
			$t2 = microtime(true);
			$time2 = number_format($t2-$t1,3);
			D('api_log')->where(["id"=>$apilog_id])->save(array('ParValue'=>$_GET['ParValue'],'ParName'=>$_GET['ParName'],
												'add_time'=>date('Y-m-d H:i:s'),'my_note'=>"执行时间：".$time2."秒||".($my_note),'clientip'=>$clientip,'_SERVER'=>serialize($_SERVER)));
			
			switch($_GET['ParName']){
				case 'FileCheckStatus':
					D('api_filecheck_log')->add(array(	'OrgCode'=>$c['OrgCode'],'FileID'=>$c['FileID'],
													'FileName'=>$c['FileName'],'CheckFlag'=>$c['CheckFlag'],
													'CheckDescription'=>$c['CheckDescription'],'flog_id'=>$apilog_id,
													'flie_actione'=>isset($action)?$action:'','flie_id'=>isset($ids)?implode(',',$ids):''
													));
				break;
				case 'FileReady':
				$str=isset($new_in_ids)?implode(',',$new_in_ids):"";
				$fileids=substr($str,0,7000);
					D('api_fileready_log')->add(array(	'OrgCode'=>$c['OrgCode'],'FileID'=>$c['FileID'],
													'FileName'=>$c['FileName'],'FileSize'=>$c['FileSize'],
													'MD5Code'=>$c['MD5Code'],'flog_id'=>$apilog_id,
													'flie_actione'=>isset($fr)?$fr:'','flie_ids'=>$fileids,
													));

				break;
			}
		}
		$xmldata= array( 
			"RecieveFlag"=>0,
			"RecieveInfo"=>"",
		);
		echo $a->createXmlStr($xmldata);
		//isset($new_in_ids)?implode(',',$new_in_ids):"";
		
	}
	/**
	*天津otc回调接口
	*/
	public function otcapi($type="1",$pid='0'){
		
		$time1=time();
		$t1 = microtime(true);
		$a=new \Common\Lib\Otcapi();//实例化对象 
		
		$c=$a->xmlArrayByString($_GET['ParValue']);
		if($type==1&&$_GET['ParName']=="FileReady"){
			ignore_user_abort(true);
			$my_note="异步：";
			// print_r($c);
			$where["FileName"]=$c['FileName'];
			$where['FileID']=$c['FileID'];
			$count = M("api_downfile_log")->where($where)->count();
			// dump($count);
			$pid = date("YmdHis").rand(1000,9999);
			$url ="http://{$_SERVER['HTTP_HOST']}/Guest/Tjotcapi/otcapi?type=2&pid=".$pid."&ParName={$_GET['ParName']}&ParValue=".$a->createXmlStr($c);
			$fr=end(explode('_',$c['FileName']));
			if($count>1&&$fr!="DZBD.DBF"){
				$my_note .="{$c['FileName']}<{$c['FileID']}>已下载处理过{$count}次，忽略处理；";
			}else{
				$my_note .="调用同步状态：({$pid})";
				$status=$this->asyncExecute($url);
				$my_note .="($status)；";
			}
			$clientip = get_client_ip();
			$t2 = microtime(true);
			$time2 = number_format($t2-$t1,3);
			$apilog_id=D('api_log')->add(
					array(	'ParValue'=>$_GET['ParValue'],'ParName'=>$_GET['ParName'],
							'add_time'=>date('Y-m-d H:i:s'),'my_note'=>"执行时间：".$time2."秒||".($my_note),'clientip'=>$clientip,'_SERVER'=>serialize($_SERVER)));
			
		}
		if($type==2||$_GET['ParName']=="FileCheckStatus"){
			set_time_limit(0);
			ignore_user_abort(true);
			$my_note="同步：({$pid})";
			 
			$clientip = get_client_ip();
			$t2 = microtime(true);
			$time2 = number_format($t2-$t1,3);
			$apilog_id=D('api_log')->add(array(	'ParValue'=>$_GET['ParValue'],'ParName'=>$_GET['ParName'],
												'add_time'=>date('Y-m-d H:i:s'),'my_note'=>$my_note."执行时间：".$time2."秒||正在处理...",'clientip'=>$clientip,'_SERVER'=>serialize($_SERVER)));
												
			$tjotc=new \Guest\Model\TjotcModel();
			
			switch($_GET['ParName']){
				case 'FileCheckStatus'://文件检查接口
					$my_note.="api检查完毕通知我方";
					list($action,$data)=$tjotc->get_khid($c['FileName']);
					$ids=array();
					$rids=array();
					foreach($data as $d){
						$ids[]=$d['id'];
						$rids[]=$d['cf_ivs_right_id'];
					}
					if($action=='kh'){
						//kh文件检查完成后的操作
						list($my_note)=$this->filecheck_kh($c,$ids,$rids,$my_note);
					}elseif($action=='rj'){
						//gh文件检查完成后的操作
						list($my_note)=$this->filecheck_rj($c,$ids,$rids,$my_note);
					}elseif($action=='gh'){
						//gh文件检查完成后的操作
						list($my_note)=$this->filecheck_gh($c,$ids,$rids,$my_note);
					}else{
						$my_note.=",FileName没有找到正确数据(".$action.",".$data.")";
					}
				break;
				case 'FileReady'://结算所 通知第三方 下载 文件接口 
					$my_note.="api通知我方下载"; 
					$fr=end(explode('_',$c['FileName']));
					switch(strtoupper($fr)){
						case "KB.DBF":
							list($new_in_ids)=$this->fileready_kb($c,$tjotc,$my_note);
						break;
						case "RJHB.DBF":
							list($new_in_ids)=$this->fileready_rjhb($c,$tjotc,$my_note);
						break;
						case "GB.DBF":
							list($new_in_ids)=$this->fileready_gb($c,$tjotc,$my_note);
						break;
						case "DZ.DBF":
							list($new_in_ids)=$this->fileready_dz($c,$tjotc,$my_note,"");
						break;
						case "DZBD.DBF":
							list($new_in_ids)=$this->fileready_dz($c,$tjotc,$my_note,"BD");
						break;
						default:
							$my_note.=",FileName不是正确数据(".strtoupper($fr).")";
					}
				break;
			} 
			
			$clientip = get_client_ip();
			$t2 = microtime(true);
			$time2 = number_format($t2-$t1,3);
			D('api_log')->where(["id"=>$apilog_id])->save(array('ParValue'=>$_GET['ParValue'],'ParName'=>$_GET['ParName'],
												'add_time'=>date('Y-m-d H:i:s'),'my_note'=>"执行时间：".$time2."秒||".mb_substr($my_note,0,7000),'clientip'=>$clientip,'_SERVER'=>serialize($_SERVER)));
			
			switch($_GET['ParName']){
				case 'FileCheckStatus':
					D('api_filecheck_log')->add(array(	'OrgCode'=>$c['OrgCode'],'FileID'=>$c['FileID'],
													'FileName'=>$c['FileName'],'CheckFlag'=>$c['CheckFlag'],
													'CheckDescription'=>$c['CheckDescription'],'flog_id'=>$apilog_id,
													'flie_actione'=>isset($action)?$action:'','flie_id'=>isset($ids)?implode(',',$ids):''
													));
				break;
				case 'FileReady':
				$str=isset($new_in_ids)?implode(',',$new_in_ids):"";
				$fileids=substr($str,0,7000);
					D('api_fileready_log')->add(array(	'OrgCode'=>$c['OrgCode'],'FileID'=>$c['FileID'],
													'FileName'=>$c['FileName'],'FileSize'=>$c['FileSize'],
													'MD5Code'=>$c['MD5Code'],'flog_id'=>$apilog_id,
													'flie_actione'=>isset($fr)?$fr:'','flie_ids'=>$fileids,
													));

				break;
			}
		}
		$xmldata= array( 
			"RecieveFlag"=>0,
			"RecieveInfo"=>"",
		);
		echo $a->createXmlStr($xmldata);
		//isset($new_in_ids)?implode(',',$new_in_ids):"";
		
	}
	/**
	 * [asyncExecute PHP异步执行任务]
	 * @param  string $url       执行任务的url地址
	 * @param  array  $post_data 需要post提交的数据POST
	 * @param  array  $cookie    cookie数据用于登录等的设置
	 * @return boole
	 */
	function asyncExecute($url, $post_data = array(), $cookie = array()) {
		$method = "GET";
		$url_array = parse_url($url);
		$port = isset($url_array['port']) ? $url_array['port'] : 80;

		$fp = fsockopen($url_array['host'], $port, $errno, $errstr, 30);
		if (!$fp) {
			return FALSE;
		}
		$getPath = isset($url_array['path']) ? $url_array['path'] : '/';
		if (isset($url_array['query'])) {
			$getPath .= "?" . $url_array['query'];
		}
		if (!empty($post_data)) {
			$method = "POST";
		}
		$header = $method . " /" . $getPath;
		$header .= " HTTP/1.1\r\n";
		$header .= "Host: " . $url_array['host'] . "\r\n";

		$header .= "Connection: Close\r\n";
		if (!empty($cookie)) {
			$_cookie = strval(NULL);
			foreach ($cookie as $k => $v) {
				$_cookie .= $k . "=" . $v . "; ";
			}
			$cookie_str = "Cookie: " . base64_encode($_cookie) . " \r\n";
			$header .= $cookie_str;
		}
		if (!empty($post_data)) {
			$_post = strval(NULL);
			$atComma = '';
			foreach ($post_data as $k => $v) {
				$_post .= $atComma . $k . "=" . $v;
				$atComma = '&';
			}
			$post_str = "Content-Type: application/x-www-form-urlencoded\r\n";
			$post_str .= "Content-Length: " . strlen($_post) . "\r\n";
			$post_str .= "\r\n".$_post . "\r\n";
			$header .= $post_str;
		}
		$header .= "\r\n";
		fwrite($fp, $header);
		fclose($fp);
		return true;
	}
}

?>