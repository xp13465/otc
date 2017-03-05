<?php 
namespace Guest\Controller;

use Think\Controller;

/**
 * 自动脚本控制器
 * Class ProductController
 * @package Guest\Controller
 * @author by shenjian
 */
class RegularlyController extends Controller {
	
	
	public function demojob($type=1){
		ignore_user_abort(false);
		set_time_limit(0);
		for($i=0;$i<=2000;$i++){
			sleep(1);
			M("ApiLog")->where(['id'=>'1'])->save(['my_note'=>"已执行".$i."秒"]);
			echo "已执行".$i."秒<br/>";
			
		}
		
		exit;
		echo D("Admin/Token")->getToken(false,true);
		
		$ftp = new \Common\Lib\Ftp();//实例化对象 
		$FTP_config = C('OTC_FTP');
		dump($FTP_config);
		 if($ftp->start($FTP_config))
		 {	
			echo "链接成功！";
			echo $localfile=ROOT_PATH."1.png";
			$remotefile='/1.png';
		   if( $ftp->put($remotefile,$localfile))
			{ 
			    echo "上传成功！";
		   }else{
			    echo $ftp->get_error();
		   }
			
			
		 }else{
			echo "链接失败！";
			 echo $ftp->get_error();
		 }
		 //别忘了关闭ftp资源
		$ftp->close();
		
		exit;
		$url ="http://{$_SERVER['HTTP_HOST']}/Guest/Regularly/sendConfirm/type/".$type;
		echo file_get_contents($url);
		exit;
	}
	
	//取消60分钟 未确认申购的 订单
	public function cancelInvest(){
		$map['cod_ivs_status'] = 0;
		$map['dat_create'] = array('LT',date("Y-m-d H:i:s",time()-60*60));
		$list = M('cf_ivs')->field('id')->where($map)->select();
		// print_r($map);
		// print_r($list);
		foreach($list as $v){
			D('cf_ivs')->cancelInvest($v['id'],0);
		}
		echo date("Y-m-d H:i:s",time());
		echo "Auto Close Ivs_data is OK! ";
		echo "回收60分钟未签署的记录脚本.\n\r";
	}
	
	/**
	*发送确权文件  
	* param $type integer 1确权开始   2入金确权拾回和过户确权拾回   3赎回确权
	*/
	public function sendConfirm($type=1,$limit="1000",$selectlimit="10000"){ 
		ignore_user_abort(false);
		set_time_limit(0);
		$selectlimit=$selectlimit?$selectlimit:10000;
		$limit=$limit?$limit:1000;
		header("Content-type: text/html;charset=utf-8");
		//无确权记录的交易记录  
		$datetime =date("Y-m-d H:i:s",time());
		
		if($type==2){
			$page=1;
			// while($page>0){
				//过户准备（入金成功）的交易记录   
				$list = D('CfIvs')
									->field('t1.*')
									->table('__' . strtoupper('Cf_ivs'). '__ as t1')
									->join('__' . strtoupper('cf_ivs_right'). '__ as t2 ON  t1.id=t2.cf_ivs_id','left') 
									->where("(t2.step = 4  ) and t1.cod_ivs_status=1 and t1.operating = 1 ") //or t2.step = 9 过户失败状态
									->order()->page($page)->limit($selectlimit)->group("t1.id")->select();  
				
				if(!empty($list)){
					foreach( array_chunk($list,$limit) as $key=>$val ){ 
						$ghreturn =  D('Cf_ivs_right')->startIvsRightByGh($val,0);
						if($ghreturn)echo "对".count($val)."条交易记录进行OTC发起确权过户提交<br/>";
						
					}
					$page = 0;
				}else{
					$page = 0;
				}
			// }
			$page=1;
			// while($page>0){
				//入金准备（开户成功）的交易记录   
				$list = D('CfIvs')
									->field('t1.*')
									->table('__' . strtoupper('Cf_ivs'). '__ as t1')
									->join('__' . strtoupper('cf_ivs_right'). '__ as t2 ON  t1.id=t2.cf_ivs_id','left') 
									->where("( t2.step = 11   ) and t1.cod_ivs_status=1  and t1.operating = 1 ") //or t2.step = 14 入金失败状态
									->order()->page($page)->limit($selectlimit)->group("t1.id")->select();  
				// echo count($list);
				// dump($list);
				// exit;
				if(!empty($list)){
					foreach( array_chunk($list,$limit) as $key=>$val ){
						$rjreturn = D('Cf_ivs_right')->startIvsRightByRj($val,0);
						if($rjreturn)echo "对".count($val)."条交易记录进行OTC发起确权入金提交<br/>";
						
					}
					$page = 0;
				}else{
					$page = 0;
				}
				
			// }
		}
		
		if($type==1){
			$page=1;
			// while($page>0){
				$list = D('CfIvs')
								->field('t1.*')
								->table('__' . strtoupper('Cf_ivs'). '__ as t1')
								->join('__' . strtoupper('cf_ivs_right'). '__ as t2 ON  t1.id=t2.cf_ivs_id','left') 
								->where("(t2.id is null or t2.step = 1 ) and t1.cod_ivs_status=1  and t1.operating = 1") //or t2.step = 5 开户失败状态
								->order()->page($page)->limit($selectlimit)->group("t1.id")->select();   
				if(!empty($list)){
					$tempCust = array();
					foreach( array_chunk($list,$limit) as $key=>$val ){
						$khreturn = D('Cf_ivs_right')->startIvsRightByKh($val,0,$tempCust); 
						$tempCust=$khreturn["tempCust"];
						if($khreturn["status"])echo "对".count($val)."条交易记录进行OTC发起确权开户提交<br/>";
						if($khreturn["rjlist"]){
							$rjreturn = D('Cf_ivs_right')->startIvsRightByRj($khreturn["rjlist"],0);
							if($rjreturn)echo "对".count($khreturn["rjlist"])."条已开户客户交易记录进行OTC发起确权入金提交<br/>";

						}
						
					}
					$page = 0;
				}else{
					$page = 0;
				}
				
			// }
			
		}
		
		if($type==3){
			$page=1;
			// while($page>0){
				$list = D('CfIvs')
									->field('b.*')
									->table('__' . strtoupper('Cf_ivs'). '__ as a')
									->join('__' . strtoupper('cf_ivs_redemption'). '__ as b ON  a.id = b.cod_cf_ivs_id','left') 
									->join('__' . strtoupper('cf_ivs_right'). '__ as c ON  a.id = c.cf_ivs_id and c.step = 8 and c.cf_ivs_redemption_id = 0 ','inner') 
									->group("b.id")
									->where("a.cod_ivs_status=2  and a.operating = 1") //or t2.step = 5 开户失败状态
									->order()->page($page)->limit($selectlimit)->select();  
				
				if(!empty($list)){
					foreach( array_chunk($list,$limit) as $key=>$val ){
						$rjreturn = D('Cf_ivs_right')->startIvsRightByRj($val,0,2);
						if($rjreturn)echo "对".count($val)."条交易记录进行OTC发起赎回确权入金提交<br/>";
						
					}
					$page = 0;
				}else{
					$page = 0;
				}
			// }
		}
		
	}
	/*
	 * for the idot
	 * 下载新的确权函
	 * */
	public function DownNewFile($rid=0){
		$ridStr=$rid?" ( b.cf_ivs_right_id = '{$rid}' and b.validflag = 1)":"";
		if($ridStr){
			$where="a.validflag=1 and ( {$ridStr} )and a.status=2 and a.step=8";
		}else{
			$where="a.validflag=1 and (b.id is null )and a.status=2 and a.step=8";
		}
		$data=D('cf_ivs_right')->alias('a')
			->field('a.id,group_concat(a.id) as aids,a.cf_ivs_id,a.qqh_file,b.id as bid,c.id as ivs_id,c.cod_cust_id,c.cod_ctl_id')
			->join('__CF_IVS_RIGHT_FILE__ b on a.id=b.cf_ivs_right_id','left')
			->join('__CF_IVS__ c on a.cf_ivs_id=c.id','left')
			->where($where)//2he8
			->group('a.qqh_file')
			->select();
		// dump($data);
		$data=D('cf_ivs_right')->DownNewFile($data,0);
		//$list,$mid
		dump($data);
	}
	
	public function dzRedress(){
		$sql = "SELECT a.id,b.cod_cust_id,b.product_code,c.DZCYFE,
				(select sum(aa.amt_int_total) from otc_cf_ivs aa where aa.cod_cust_id=b.cod_cust_id and aa.product_code=b.product_code and aa.cod_ivs_status = 1) as sum
				from otc_cf_ivs_right a
				inner join otc_cf_ivs b on a.cf_ivs_id = b.id
				left join otc_dz_dbf c on b.cod_cust_id = c.cust_id and b.product_code = c.DZCPDM
				 where a.status = 1 and a.step = 8";
		$list = M('')->query($sql);
		dump(count($list));
		dump(($list));
		foreach($list as $k=>$v){
			if($v['dzcyfe']==$v['sum']){
				$r=D('cf_ivs_right')->where(array("id"=>$v['id']))->save(array("status"=>'2'));
				if($r>=0){ 
					D('CfIvsRightLog')->addRightLogByRid($v['id'],1,2,8,8,0,"确权函已生成！");
				}
			}
		}
	}
}


?>