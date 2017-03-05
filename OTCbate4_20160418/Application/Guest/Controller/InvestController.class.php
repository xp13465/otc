<?php
namespace Guest\Controller;
use Think\Controller;

/**
 * 投资控制器
 * Class InvestController
 * @package Guest\Controller
 * @author by shenjian
 */
class InvestController extends GuestController {
	
	public $cod_cust_id;



	
	public function __construct(){
		parent::__construct();
		$this->cod_cust_id = session('cod_cust_id');
		if(in_array(ACTION_NAME,("doInvest"))&&empty($this->cod_cust_id)){
			//if(IS_AJAX){
				$this->setError('客户账户未登陆',-2);
			//}else{
			//	$this->redirect('Guest/index/index');
			//}
		}
	}
	
	//投资操作
	public function doInvest(){
		$result = D('cf_ivs')->doInvest(I('post.'),$this->cod_cust_id,$this->mid);
		$this->printJson($result);
	}
	
	//确认投资
	public function finishInvest(){
		$result = D('cf_ivs')->finishInvest(I('post.pos_order'),I('post.id',0,'intval'),$this->mid);
		$this->printJson($result);
	}
	//赎回投资
	public function redemptionInvest(){
		$result = D('cf_ivs')->redemptionInvest(I('post.id',0,'intval'),$this->mid,I('post.password'));
		// dump($result);
		$this->printJson($result);
	}
	
	//取消投资
	public function cancelInvest(){
		// 
		$result = D('cf_ivs')->cancelInvest(I('post.id',0,'intval'),$this->mid);
		$this->printJson($result);
	}

		/*
    * 获取确权搜索 确权状态
    * 
    */  

    public function getRightSelect()
    {
        $right=D('cf_ivs');
        $rightSelect=$right::$status_select;
        $this->printJson($rightSelect);
    }

    /**
     * 获取确权的成交时间搜索下拉值
     */
    public function getRightDtime()
    {
        $right=D('cf_ivs'); 
        $rightDtimeSelect=$right::$createdate_select;
        $this->printJson($rightDtimeSelect);

    }

	/**
	*  下载合同
	*   
	*/
	public function downContractpdf($ivsid="0"){
		$where["a.id"]=$ivsid;
		$ivsData=D("CfIvs")->getInvestContractData($ivsid);
		
		$this->export_contractpdf($ivsData,"contract_".$ivsData[0]['ivs_order'],'D');
	}
	/**
	*  查看合同
	*   
	*/
	public function previewContractpdf($ivsid="0"){
		
		$where["a.id"]=$ivsid;
		$ivsData=D("CfIvs")->getInvestContractData($ivsid);
		 // dump($ivsData);exit;
		$this->export_contractpdf($ivsData,"contract_".$ivsData[0]['ivs_order'],'I');
	}
	/*
	债权出让及受让协议
	*/
	public function downDetailpdf($ivsid="0"){

		$where["a.id"]=$ivsid;
		$ivsData=D("CfIvs")->getInvestContractData($ivsid); 
		
		$this->export_Detailpdf($ivsData,"contract_".$ivsData[0]['ivs_order'],'D');
		
	}
	public function prewDetailpdf($ivsid="0"){

		$where["a.id"]=$ivsid;
		 $ivsData=D("CfIvs")->getInvestContractData($ivsid);
	
//		$ivsData = 1;
		// $ivsData[0]['ivs_order']=2011;
		// dump($ivsData);exit;
		// $data = D("CfIvs")->InterestCalculation($ivsData[0]['amt_int_total'],$ivsData[0]['dat_modify'],$ivsData[0]['rat_cf_inv_min'],$ivsData[0]['amt_time'],$ivsData[0]['formula']);
		    // dump($data);exit;
			
		$this->export_Detailpdf($ivsData,"contract_".$ivsData[0]['ivs_order'],'I');
	}



	/**
	 * 资金报告模板-R 2016-4-11
	 */
	public function downLoanpdf($ivsid="0"){

		$where["a.id"]=$ivsid;
		$times=I('param.times',1);
		$ivsData=D("CfIvs")->getInvestContractData($ivsid);
		$this->export_Loanpdf($ivsData,"contract_".$ivsData[0]['ivs_order'],'I',$times);
	}
	
	public function prewLoanpdf($ivsid="0"){

		$where["a.id"]=$ivsid;
		$times=I('param.times',1);
		$ivsData=D("CfIvs")->getInvestContractData($ivsid);
		$this->export_Loanpdf($ivsData,"contract_".$ivsData[0]['ivs_order'],'I',$times);
	}

	/**
	 * 债权出让款项到账确认函 -2016-04-12
	 * @param 产品投资记录id
	 */

	public function prewCheckacc($ivsid="0"){

		$where["a.id"]=$ivsid;
		// $times=I('param.times',1);
		$ivsData=D("CfIvs")->getInvestContractData($ivsid);

		$this->export_accountpdf($ivsData,"contract_".$ivsData[0]['ivs_order'],'I');//$times
	}
	/**
	 * 债权出让款项到账确认函 数据形成
	 */
	 private function export_accountpdf($ivsData=array(),$fileName='Newfile',$showType ='D',$times=1){
		set_time_limit(120);
		if( empty($ivsData)) $this->error("导出的数据为空！");
		vendor("tcpdf.tcpdf");
		// require_cache(VENDOR_PATH . 'tcpdf/examples/lang/eng.php');		 
		
		$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);//新建pdf文件
		    
		$nbsp="                                      ";
		//$title=$data['cod_ivs_type']==1?"合同":"协议";
		$title='债权出让款项到账确认函';
        $pdf->SetHeaderData("LOGO.png", 45, '',$nbsp.$title.'编号：'.$ivsData[0]['ivs_order'],array(0,0,0), array(0,0,0));
        $pdf->setHeaderFont(Array("stsongstdlight", '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);//设置默认等宽字体
        $pdf->SetMargins(25, 24, 25);//设置页面边幅
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, 20);//设置自动分页符
		$pdf->setFooterData(array(0,0,0), array(255,255,255));
		// $pdf->setPageBuffer("1","1");
        // $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		// $pdf->setLanguageArray($l);
		$this->times=$times;
		
		$this->assign('ivsData', $ivsData);
		// echo "<pre>";  print_r($ivsData);exit;
		foreach($ivsData as $item=>$data){
			if($item<1){
				$data['amt_int_total'] =  cny($data['amt_int_total']);
				$data['dat_arrival'] = date('Y 年 m 月 d 日',strtotime($data['dat_arrival']));
				$this->assign('data', $data);
				$this->assign('zcount', count($ivsData));
					// $title ="债权出让及受让协议";
				$Page = $this->fetch('Common:InvestCheckaccount');
				$pdf->AddPage();
				$pdf->SetFont('stsongstdlight', 'B', 24);  
				$pdf->Ln(8);
				$pdf->Cell(0, 15, $title, 0, false, 'C', 0, '', 0, false, 'M', 'M'); 
				$pdf->Ln(12);
				$pdf->SetFont('stsongstdlight','','10');
				$pdf->writeHTMLCell(0, 0, '', '', $Page, 0, 4, 0, true, '', true);
			
				/*
				w h x y content,右边距,与下一个单元格的位置,是否填充颜色,是否重置高度,文本对齐方式,是否自动
				*/
				
			}else{
				continue;
			}
		}
		$pdf->Output("{$fileName}.pdf", $showType);
        exit;
	}

	/**
	*  客户资金出借情况报告-2016-04-11 author-lj
	*  $showType= 'I';//PDF输出的方式。I，在浏览器中打开；D，以文件形式下载；F，保存到服务器中；S，以字符串形式输出；E：以邮件的附件输出。
	*/
    private function export_Loanpdf($ivsData=array(),$fileName='Newfile',$showType ='D',$times=1){
		set_time_limit(120);
		if( empty($ivsData)) $this->error("导出的数据为空！");
		vendor("tcpdf.tcpdf");
		$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);//新建pdf文件
		$nbsp="                                      ";
		$title='客户资金出借情况报告';
        $pdf->SetHeaderData("LOGO.png", 45, '',$nbsp.$title.'编号：'.$ivsData[0]['ivs_order'],array(0,0,0), array(0,0,0));
        $pdf->setHeaderFont(Array("stsongstdlight", '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);//设置默认等宽字体
        $pdf->SetMargins(25, 24, 25);//设置页面边幅
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, 20);//设置自动分页符
		$pdf->setFooterData(array(0,0,0), array(255,255,255));
		// dump($ivsData);
		$data = D('cf_ivs')->InterestCalculation($ivsData[0]['amt_int_total'],$ivsData[0]['dat_modify'],$ivsData[0]['rat_cf_inv_min'],$ivsData[0]['amt_time']);
		  // dump($data);
		 // die;
		$this->assign('times',$times-1);
		$this->assign("data",$data);//传输数组
		$this->assign("ivsData",$ivsData);

		$Page = $this->fetch('Common:InvestLoanReport');
		$pdf->AddPage();
		$pdf->SetFont('stsongstdlight', 'B', 24);  
		$pdf->Ln(8);
		$pdf->Cell(0, 15, $title, 0, false, 'C', 0, '', 0, false, 'M', 'M'); 
		$pdf->Ln(12);
		$pdf->SetFont('stsongstdlight','','10');
		$pdf->writeHTMLCell(0, 0, '', '', $Page, 0, 4, 0, true, '', true);
		/*
		w h x y content,右边距,与下一个单元格的位置,是否填充颜色,是否重置高度,文本对齐方式,是否自动
		*/
		
		$pdf->Output("{$fileName}.pdf", $showType);
        exit;
	}

	/**
	*  生成债权出让及受让协议-2016-03-31 author-lj
	*  $showType= 'I';//PDF输出的方式。I，在浏览器中打开；D，以文件形式下载；F，保存到服务器中；S，以字符串形式输出；E：以邮件的附件输出。
	*/
    private function export_Detailpdf($ivsData=array(),$fileName='Newfile',$showType ='D'){
		set_time_limit(120);
		if( empty($ivsData)) $this->error("导出的数据为空！");
		vendor("tcpdf.tcpdf");
		// require_cache(VENDOR_PATH . 'tcpdf/examples/lang/eng.php');		 
		
		$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);//新建pdf文件
        //设置页眉页脚
		$nbsp="               ";
		//$title=$data['cod_ivs_type']==1?"合同":"协议";
		$title='债权出让及受让协议';
        $pdf->SetHeaderData("LOGO.png", 45, '',$nbsp.$title.'编号：'.$ivsData[0]['ivs_order'],array(0,0,0), array(0,0,0));
        $pdf->setHeaderFont(Array("stsongstdlight", '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);//设置默认等宽字体
        $pdf->SetMargins(25, 24, 25);//设置页面边幅
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, 20);//设置自动分页符
		$pdf->setFooterData(array(0,0,0), array(255,255,255));
		// $pdf->setPageBuffer("1","1");
        // $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		// $pdf->setLanguageArray($l);
		
		foreach ($ivsData as $key => $value) {
			# code...
			if(date('d',strtotime($value['dat_modify']))<=15){
				$ivsData[$key]['nextday'] = date('Y-m-15',strtotime('+1 Month',strtotime($value['dat_modify'])));
			}else{
				// if(date('t',))
					$big = date('t',strtotime('+1 Month',strtotime($value['dat_modify'])));
					if($big>=30){
					$ivsData[$key]['nextday'] = date('Y-m-30',strtotime('+1 Month',strtotime($value['dat_modify'])));
					}else{
						$ivsData[$key]['nextday'] = date('Y-m-28',strtotime('+1 Month',strtotime($value['dat_modify'])));
					}
				
			}
			
		}
  //       dump($ivsData);
		// die;

		$this->assign('ivsData', $ivsData);
		// echo "<pre>";  print_r($ivsData);exit;
		foreach($ivsData as $item=>$data){
			if($item<1){

				$this->assign('data', $data);
				$this->assign('zcount', count($ivsData));
					// $title ="债权出让及受让协议";
				$Page = $this->fetch('Common:InvestDetailPage');
				$pdf->AddPage();
				
				$pdf->SetFont('stsongstdlight', 'B', 24);  
				$pdf->Ln(8);
				$pdf->Cell(0, 15, $title, 0, false, 'C', 0, '', 0, false, 'M', 'M'); 
				$pdf->Ln(12);
				$pdf->SetFont('stsongstdlight','','10');
				$pdf->writeHTMLCell(0, 0, '', '', $Page, 0, 4, 0, true, '', true);
			
				/*
				w h x y content,右边距,与下一个单元格的位置,是否填充颜色,是否重置高度,文本对齐方式,是否自动
				*/
				
			}else{
				continue;
			}
		}
		
		$pdf->Output("{$fileName}.pdf", $showType);
        exit;
	}


	/**
	*  生成合同
	*  $showType= 'I';//PDF输出的方式。I，在浏览器中打开；D，以文件形式下载；F，保存到服务器中；S，以字符串形式输出；E：以邮件的附件输出。
	*/
    private function export_contractpdf($ivsData=array(),$fileName='Newfile',$showType ='D'){
		set_time_limit(120);
		if( empty($ivsData)) $this->error("导出的数据为空！");
		vendor("tcpdf.tcpdf");
		// require_cache(VENDOR_PATH . 'tcpdf/examples/lang/eng.php');
		
		 
		
		$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);//新建pdf文件
		    
		  //设置文件信息
		// $pdf->SetCreator(PDF_CREATOR);
		// $pdf->SetAuthor("Author");
		// $pdf->SetTitle("pdf test");
		// $pdf->SetSubject('TCPDF Tutorial');
		// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');		
        //设置页眉页脚
		// dump(PDF_MARGIN_HEADER);exit;
		$nbsp="                                      ";
		$title=$data['cod_ivs_type']==1?"合同":"协议";
        $pdf->SetHeaderData("LOGO.png", 45, '',$nbsp.$title.'编号：'.$ivsData[0]['ivs_order'],array(0,0,0), array(0,0,0));
        $pdf->setHeaderFont(Array("stsongstdlight", '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);//设置默认等宽字体
        $pdf->SetMargins(25, 24, 25);//设置页面边幅
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, 20);//设置自动分页符
		$pdf->setFooterData(array(0,0,0), array(255,255,255));
		// $pdf->setPageBuffer("1","1");
        // $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		// $pdf->setLanguageArray($l);
		
        
		$this->assign('ivsData', $ivsData);
		// echo "<pre>";  print_r($ivsData);exit;
		foreach($ivsData as $item=>$data){
			if($item<1){
				$this->assign('data', $data);
				$this->assign('zcount', count($ivsData));
				// $data['cod_ivs_type']=2;
				switch($data['cod_ivs_type'])
				{
					case 1:
					$title ="债权资产权益转让协议";
					$Page1 = $this->fetch('Common:InvestContract1Page1');
					$Page2 = $this->fetch('Common:InvestContract1Page2');
					$Page3 = $this->fetch('Common:InvestContract1Page3');
					break;
					case 2:
					$title ="基础资产收益权转让协议";
					$Page1 = $this->fetch('Common:InvestContractPage1');
					$Page2 = $this->fetch('Common:InvestContractPage2');
					$Page3 = $this->fetch('Common:InvestContractPage3');
					break;
				}
				$pdf->AddPage();
				// $pdf->SetFont('stsongstdlight','','10');
				// $pdf->writeHTMLCell(0, 0, '140', '13', "合同编号：123456789012345", 0, 1, 0, false, '', false);
				// $pdf->Ln(13);
				$pdf->SetFont('stsongstdlight', 'B', 24);  
				$pdf->Ln(8);
				$pdf->Cell(0, 15, $title, 0, false, 'C', 0, '', 0, false, 'M', 'M'); 
				$pdf->Ln(12);
				$pdf->SetFont('stsongstdlight','','10');
				$pdf->writeHTMLCell(0, 0, '', '', $Page1, 0, 4, 0, true, '', true);
				if($data['cod_ivs_type']==1){
					$pdf->AddPage();
				}
				$pdf->writeHTMLCell(0, 0, '', '', $Page2, 0, 4, 0, true, '', true);
				if($data['cod_ivs_type']==2){
					// $pdf->AddPage();
				}
				$pdf->writeHTMLCell(0, 0, '', '', $Page3, 0, 4, 0, true, '', true);
				/*
				w h x y content,右边距,与下一个单元格的位置,是否填充颜色,是否重置高度,文本对齐方式,是否自动
				*/
				
			}else{
				continue;
			}
		}
		
		
		
        $pdf->Output("{$fileName}.pdf", $showType);
        exit;
	}
	public  function purchaseUplodFile(){
		//交易记录id
		if(I('post.ivsid')&&is_numeric(I('post.ivsid'))) {
			$Model = M('cf_ivs');
			$where['id'] = I('post.ivsid');
			$data = $Model->field('cod_ivs_status')->where($where)->find();
			
			if (!in_array($data['cod_ivs_status'],[0,1])) $this->setError('当前状态不允许上传');
			
			$file_field=$data['cod_ivs_status']==1?"redemption_file":"pos_file";
			$order_field=$data['cod_ivs_status']==1?"redemption_order":"pos_order";
			//有附件，没有pos机单号
			if (!empty($_FILES['file']['tmp_name']) && empty(I('post.{$order_field}'))) {
								$config = array(
									'maxSize' => 3145728,
									'rootPath' => './Uploads/',
									'savePath' => 'posfile/',
									'exts' => array('jpg', 'gif', 'png', 'jpeg','doc','docx','xls','xlsx','pdf','bmp')
								);
								$upload = new \Think\Upload($config);// 实例化上传类
								$info = $upload->uploadOne($_FILES['file']);
								if (!$info) {
									$return_data = array (
										'suc' => 0,
										'msg' => "文件上传失败",
										'data' => array ()
									);
									$this->printJson($return_data);
								} else {
									//附件地址
									$map[$file_field] = '/Uploads'.'/'.$info['savepath'] . $info['savename'];
									if($Model->where($where)->save($map)){
									   $return_data = array(
                                           'suc'=>1,
										   'msg'=>'文件上传成功',
										   'file_url'=>$map[$file_field]

									   );
									}else{
										$return_data = array (
											'suc' => 0,
											'msg' => "文件上传失败，没有成功插入数据库",
											'data'=>array()
										);
									}
									$this->printJson($return_data);
								}
				//有pos机单号,没有附件
			} elseif (!empty(I('post.{$order_field}')) && empty($_FILES['file']['tmp_name'])) {
				$pos_order = I('post.{$order_field}');
				$Model -> where($where)->save(array($order_field => $pos_order)) ? $this->success('操作成功') : $this->error('操作失败');
			} else {  
							$config = array(
								'maxSize' => 3145728,
								'rootPath' => './Uploads/',
								'savePath' => 'posfile/',
								'exts' => array('jpg', 'gif', 'png', 'jpeg')
							);
							$upload = new \Think\Upload($config);// 实例化上传类
							$info = $upload->uploadOne($_FILES['file']);
							if (!$info) {
								$return_data = array (
									'suc' => 0,
									'msg' => "文件上传失败",
									'data' => array ()
								);
								$this->printJson($return_data);
							} else {
								//附件地址
								$map[$file_field] ='/Uploads'.'/'.$info['savepath'] . $info['savename'];
								if (!$Model->where($where)->save($map)) $this->setError('操作失败');
								$pos_order = I('post.{$order_field}');
								if($Model > where($where)->save(array($order_field => $pos_order))){
									$return_data = array (
										'suc' => 1,
										'msg' => "文件成功上传,pos单号更新成功",
										'file_url' => $map[$file_field]
									);
								}else{
									$return_data = array (
										'suc' => 1,
										'msg' => "文件成功上传,pos单号更新失败",
										'file_url' => $map[$file_field]
									);
								}
								$this->printJson($return_data);
							}
			}

		}else{
			$return_data = array (
				'suc' => 0,
				'msg' => "非POST提交或参数错误",
				'data' => array ()
			);
			$this->printJson($return_data);


		}
	}



	
	    /**
     * 获取确权管理列表
     */

    public function clivslist()
    {	
		$id=$this->mid;//登录mid
		$res=A("Admin/Admin")->checkUserPermission('guest.allreader');
		$where='operating = 1';
		if(!$res){
			$pos_id=M('user')->getFieldById($id,'position_id');//2
			//先查自己是不是别人的领导
			$belongs=M('user')->field('id')->where('leader_id='.$pos_id)->select();
			$ivs_id="(";
			foreach ($belongs as $key => $value) {
				$ivs_id.=$value['id'].",";
			}
			$ivs_id.=$id.")";

			$where.= " and a.usr_create in ".$ivs_id;
		}

		$cod_cf_status=I('post.status');// 盒子状态
//		return $cod_cf_status;
		$where.=' and (a.cod_ivs_status = 1 or (a.cod_ivs_status = 2 and e.cf_ivs_redemption_id is not null)) ';
        if(in_array($cod_cf_status,array(0))){
			$where.=' and e.status is null ';
        }elseif(in_array($cod_cf_status,array(1,2,3))){
		   $where.=' and e.status='.$cod_cf_status;
	   }elseif(in_array($cod_cf_status,array(-999))){
//			$where.=' and a_right.status is null ';
		}
		$curpage=I('post.page',1);
		$limit=I('post.limit',10);

		$date_cls= I('post.date_cls');
		//申购时间
		if($date_cls&& in_array($date_cls,['1','2','3','4','5'])){
			if($date_cls == '1'){
				//10分钟内
				$where.=" and a.dat_modify>='".date("Y-m-d H:i:s",time()-10*60)."'";
			}else if($date_cls == '2'){
				//30分钟内
				$where.=" and a.dat_modify>='".date("Y-m-d H:i:s",time()-30*60)."'";
			}else if($date_cls == '3'){
				//1小时内
				$where.=" and a.dat_modify>='".date("Y-m-d H:i:s",time()-60*60)."'";
			}else if($date_cls == '4'){
				//1小时内
				$where.=" and a.dat_modify>='".date("Y-m-d H:i:s",time()-24*60*60)."'";
			}else if($date_cls == '5'){
				//一天以上
				$where.=" and a.dat_modify<='".date("Y-m-d H:i:s",time()-24*60*60)."'";
			}
		}

        if(I('post.keyword','0'))
        {
           $where.=" and concat(b.nam_cust_real,b.cod_cust_id_no) like '%".I('post.keyword')."%' ";
        }

         $cl=D('cf_ivs_right');
         $list=$cl->getRightList($where,$curpage,$limit);
         $this->printJson($list);

    }
	/*
     * 确权管理->确权进度
     * 
     */
    public function getRightSchedule()
    {
    $right_id=I('post.right_id');//确权id
		//$right_id=40;
    if(!$right_id){$this->setError('确权id必填');}
    $d= D('cf_ivs_right_log');
    $data=$d->rschedule($right_id);
     $this->printJson($data);
    }
	 /*
     * 重试确权
     * 
     */
    public function restartIvsRight($ivsid)
    {
     
		$status = D('CfIvs')->where(["id"=>$ivsid])->getField("cod_ivs_status");
		// dump($status);
		if($status==1){
			$list = D('CfIvs')
                            ->field('t1.*,t2.step,t2.status,t2.id as rightid')
                            ->table('__' . strtoupper('Cf_ivs'). '__ as t1')
                            ->join('__' . strtoupper('cf_ivs_right'). '__ as t2 ON  t1.id=t2.cf_ivs_id','left') 
                            ->where("t1.cod_ivs_status  = 1  and t1.id = '{$ivsid}' and t2.status = 3") //or t2.step = 5 开户失败状态
                            ->order()->select();  
		}elseif($status==2){
			$list = D('CfIvs')
							->field('b.*,c.step,c.status,t2.id as rightid')
							->table('__' . strtoupper('Cf_ivs'). '__ as a')
							->join('__' . strtoupper('cf_ivs_redemption'). '__ as b ON  a.id = b.cod_cf_ivs_id','left') 
							->join('__' . strtoupper('cf_ivs_right'). '__ as c ON  a.id = c.cf_ivs_id and c.status = 3 ','inner') 
							
							->where("a.cod_ivs_status=2 and a.id = '{$ivsid}' ") //or t2.step = 5 开户失败状态
							->order()->select();  
		}else{
			echo $this->setError('数据错误');
		}
		// dump($list);
		$title=$status==2?"赎回":"投资";
		if(!empty($list)&&in_array($list[0]['step'],[5,9,14])){
			// print_r($list);
			if($list[0]['step']==5&&$status == 1){
				$rjreturn = D('Cf_ivs_right')->startIvsRightByKh($list,0);
				if($rjreturn)echo $this->setSuccess("重新发起{$title}确权成功");
			}elseif($list[0]['step']==14){
				$rjreturn = D('Cf_ivs_right')->startIvsRightByRj($list,0,$status);
				if($rjreturn)echo $this->setSuccess("重新发起{$title}确权成功");
			}elseif($list[0]['step']==9){
				// D('cf_ivs_right')->where(array("status"=>['in','3'],"id"=>$list[0]['rightid'],"step"=>"9"))->save(array("status"=>'3',"step"=>'14'));
				// $rjreturn = D('Cf_ivs_right')->startIvsRightByRj($list,0,$status);
				// if($rjreturn)echo $this->setSuccess("重新发起{$title}确权成功");
				$rjreturn = D('Cf_ivs_right')->startIvsRightByGh($list,0,$status);
				if($rjreturn)echo $this->setSuccess("重新发起{$title}确权成功");
				
			}
			
		}else{
			echo $this->setError('数据错误');
		}
		
		 
	}
}
