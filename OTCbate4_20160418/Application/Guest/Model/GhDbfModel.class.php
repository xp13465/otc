<?php
namespace Guest\Model;

use Think\Log;
use Think\Model;

class GhDbfModel extends Model{
	
	// 创建GH DBF信息
	// @param cf_ivs_list 交易记录
	// @param  cf_ivs_right_id  确权记录ID
	// @param  user  用户主信息
   //  @param  info  用户额外信息数据	
   //  @param  file_no   文件序号   
	public function  createDbf($cf_ivs_list,$cf_ivs_right_id,$user,$info = array(),$file_no,$type=1,$errornum=0){
		// print_r($user);
		$now = time();
		createDir('./Uploads/GH');
		$dir = './Uploads/GH/'.date('Ymd',$now);
		createDir($dir);
		
		//生成DBF文件
		$filename = 'TJC_'.C('OTC_API_TOOKEN.orgcode').'_'.C('OTC_TACODE').'_'.date('Ymd',$now).'_'.$file_no.'_GH.DBF';
		$file = $dir.'/'.$filename;
		
		$obj = new \Common\Lib\Otcdbf();//实例化对象
		
		if(!file_exists($file)){
			$flag = $obj->createDBF($file,'GH');
		}else{
			$flag = true;
		}
		$map = array('a.id'=>$cf_ivs_list['cod_cf_id']);
		$mast_list = M('cf_mast')->alias("a")->field("a.*,b.otc_code")->join("__CAPITALPOOL__ b on a.capitalid = b.id","inner")->where($map)->find();
		$ChuShiId = 1;
		$ChuShiChiYouRen=M("CustPerson")->where(["cod_cust_id"=>$ChuShiId])->getField("otc_jszh");
		
		if($flag&&$mast_list){
			$dbf_data = array(
				C('OTC_API_TOOKEN.orgcode'),  //销售代理人代码 *
				($type==2?$cf_ivs_list['product_code']:$mast_list["otc_code"]),                        //产品代码 *
				$ChuShiChiYouRen,                        //结算账户 *
				$ChuShiId,                       //交易账户 *
				date("Ymd",strtotime($cf_ivs_list['dat_modify'])),          //申请日期   YYYYMMDD
				$cf_ivs_list['ivs_order'].($type==2?"":'S')."_".$errornum, //申请单号 *
				($type==2?"B":'S'),                       //买卖方向 B买入  S卖出 *
				$cf_ivs_list['ctl_ivs_cnt'],      //成交价格 *
				$cf_ivs_list['amt_ivs'],      //成交数量   *
				$cf_ivs_list['amt_int_total'],   //成交金额    *
				date("Ymd",$now),      //发送日期   YYYYMMDD  *
				date("His",strtotime($cf_ivs_list['dat_modify'])),                  //经纪人编号               
				($type==2?$mast_list["otc_code"]:''),                  //备用标志 	 
			);
			
			$obj->writeDbf($file,$dbf_data);
			
			$dbf_data = array(
				C('OTC_API_TOOKEN.orgcode'),  //销售代理人代码 *
				($type==2?$cf_ivs_list['product_code']:$mast_list["otc_code"]),                       //产品代码 *
				$user['otc_jszh'],                        //结算账户 *
				$user['cod_cust_id'],                       //交易账户 *
				date("Ymd",strtotime($cf_ivs_list['dat_modify'])),          //申请日期   YYYYMMDD
				$cf_ivs_list['ivs_order'].($type==2?"S":'')."_".$errornum, //申请单号 *
				($type==2?"S":'B'),                       //买卖方向 B买入  S卖出 *
				$cf_ivs_list['ctl_ivs_cnt'],      //成交价格 *
				$cf_ivs_list['amt_ivs'],      //成交数量   *
				$cf_ivs_list['amt_int_total'],   //成交金额    *
				date("Ymd",$now),      //发送日期   YYYYMMDD  *
				date("His",strtotime($cf_ivs_list['dat_modify'])),                  //经纪人编号               
				($type==2?"":substr($cf_ivs_list['product_code'],0,10)),                   //备用标志 	 
			);
			$obj->writeDbf($file,$dbf_data);
			$dbfdata = array_combine($obj->GH_KEY,$dbf_data);
			// var_dump($dbfdata);
			
			if($type==2){
				$data = array(
					'cf_ivs_id'=>$cf_ivs_list['cod_cf_ivs_id'],
					'cf_ivs_redemption_id'=>$cf_ivs_list['id'],
					'cf_ivs_right_id'=>$cf_ivs_right_id,
					'gh_file'=>$file,
					'file_no'=>$file_no,
					'createdate'=>date('Y-m-d',$now),
					'createtime'=>date("Y-m-d H:i:s",$now),
				);
			}else{
				$data = array(
					'cf_ivs_id'=>$cf_ivs_list['id'],
					'cf_ivs_right_id'=>$cf_ivs_right_id,
					'gh_file'=>$file,
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
	* 清理开户生成文件&记录
	*@param  ivs_right_id  确权记录ID
	*@param  status  文件状态 
	*/
	public function clearGhData($ivs_right_id,$status = 0){ 
		$where = array("cf_ivs_right_id"=>$ivs_right_id);
		if($status)$where['status']=$status;
		$result = $this->where($where)->select();
		foreach($result as $data){
			$file = ROOT_PATH.$data['gh_file'];
			if(file_exists($file)){
				@unlink(ROOT_PATH.$data['gh_file']); 
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