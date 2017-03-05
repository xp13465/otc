<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 系统管理控制器
 * Class MessageController
 * @package Admin\Controller
 */
class ClaimsController extends AdminController {
    /**
     * 系统管理初始页
     */
    public function index(){
		echo 31;
		$Tcpdf = new \Common\Lib\Tcpdf();
		var_dump($Tcpdf);
		exit;
		echo $token = D("Token")->getToken();
		$rightid=1;
		D("CfIvsRight")->where()->find();
		$localfile='D:/WEB/demo/user.dbf';
		$remotefile='/user.dbf';
		// if(D("Token")->ftp_upload($remotefile,$localfile)){
			// D("Token")->FileUploadFinished("1","kh");
		// }
		var_dump(D("Token")->ftp_upload("125","gh")); 
		 
			
    }
    /**
     * 获取债权信息
     */
    public function getClaimsinfo(){
        $id = I('post.id');
        // $id = 27;
        if(!$id){
            $this->setError('参数有误');
        }
        $where = " and id = " . intval($id);
        $data = M('ClMast')->where('validflag = 1 '.$where )->find();
         //资产包名称
        $capiname=M('capitalpool')->field('name')->where(['id'=>$data['capitalid']])->find();
        $data['capitalpool_name']=$capiname['name'];
//        $data['enddate'] = '2016-03-31';
//        $data['startdate'] = '2015-10-29';
        $time = max(strtotime($data['startdate']),strtotime(date('Y-m-d')));
        if(strtotime($data['enddate'])< strtotime(date('Y-m-d'))){
            $data['leftmonth']=0;
        }else{
           $data['leftmonth'] = abs(date('Y',strtotime($data['enddate']))-
                   date('Y',$time))*12+
                (date('m',strtotime($data['enddate']))-date('m',$time));
        }

        if(!$data['leftmonth']){
            $data['leftmonth']=0;
        }
        $this->printJson($data);
    }
	/**
     * 获取债权录入列表
     */
    public function getClaimslist(){
        $page['page'] = I('post.page') ? I('post.page') : 1;
        $page['limit'] = I('post.limit') ? I('post.limit') : 20;
        $where['validflag']='1';
		$sumwhere = array();
		if(I('post.cf_id')){
            $where ['cf_mast_id']=2;//I('post.cf_id');
			$sumwhere['cf_mast_id'] = 2;
        }
		if(I('post.cod_cf_inv_type')&&is_numeric(I('post.cod_cf_inv_type'))){
            $where['cod_cf_inv_type']=I('post.cod_cf_inv_type');
        }
		 
        //债权状态
        if(isset($_POST['status'])&&$_POST['status']!=''){
            $where ['status']=I('post.status');
        }
		//债权关键字
/*		if(I('post.keyword')){
            $keyword=I('post.keyword');
			$where['cod_card_no|borrower'] = array('LIKE',"%".$keyword."%");
        }*/
		$ClMast= D('ClMast');
		//债权录入时间范围
		/* if(I('post.createdate')){
			$creatrkey=I('post.createdate'); 
			
			$cdatearr = $ClMast::$createdate_value; 
			$createdate =date('Y-m-d H:i:s',strtotime($cdatearr[$creatrkey],time()));
			// print_r($createdate);
			if(in_array($creatrkey,array(1,2,3))){
				$where ['dat_create']=array('EGT',$createdate);
			}elseif(in_array($creatrkey,array(4))){
				$where ['dat_create']=array('ELT',$createdate);
			}
            // $where ['dat_create']=array('EGT',I('post.createdate'));
        } */
		$start_date=I('post.start_date'); 
		$end_date=I('post.end_date');  
		if($strattime=strtotime($start_date)){
			$start_date=date("Y-m-d",$strattime);
            $where ['dat_create'][]=array('EGT',$start_date);
        }
		if($endtime=strtotime($end_date)){
			$end_date=date("Y-m-d 23:59:59",$endtime);
            $where ['dat_create'][]=array('ELT',$end_date);
        }
		$where ['usr_create'] = $this->uid;
        //债权名称
        if (I('post.keyword')) {
            $where['d.product_name|d.borrower'] = array('LIKE', "%" . I('post.keyword') . "%");
        }
		
		$data['Sum_last'] = D("cl_ctl")->where($sumwhere)->Sum("amt_ct_last");
        $data['total'] = D('ClMast')->table('__' . strtoupper('Cl_mast'). '__ as d')->where($where)->count();
        
        $data['items'] = D('ClMast')
                            ->field('d.*')
                            ->table('__' . strtoupper('Cl_mast'). '__ as d')
                            ->where($where)
                            // ->join('__' . strtoupper('organization'). '__ as o ON d.organization_id = o.organization_id','left')
                            // ->join('__' . strtoupper('department'). '__ as dp ON d.pid = dp.id', 'left')
                            ->order('id desc')->page($page['page'],$page['limit'])->select();
        foreach($data['items'] as $k =>$v){
				$data['items'][$k]['status_code']=$data['items'][$k]['status'];
				$data['items'][$k]['status']=$ClMast::$status_select[$v['status']];
		}
		$this->printJson($data);
    }

	 
    /**
     * 保存债权申请信息（添加或修改）
     * @return bool
     */
    public function saveClaims(){
		if(IS_POST ){
			$model =  D('ClMast');
			$data = I('post.');
            unset($data['left']);
			$data['status']=0;
			$data['validflag']=1;
			$data['dat_create'] = date('Y-m-d H:i:s');
			$data['usr_create'] = $this->uid ;
			$data['dat_modify'] = date('Y-m-d H:i:s');
			$data['usr_modify'] = $this->uid ;
            $data['startdate']=strtotime($data['startdate'])?$data['startdate']:'0000-00-00';
            $data['enddate']=strtotime($data['enddate'])?$data['enddate']:'0000-00-00';
			if(isset($data['id']) && intval($data['id']) > 0){
				unset($data['dat_create']);
				unset($data['usr_create']);
                unset($data['status']);
			}
			//$model =  D('ClMast');
			if(!$model->create($data)){
				$this->setError($model->getError());
			}else{
				if(isset($data['id']) && intval($data['id']) > 0){
					$status = $model->where("id = {$data['id']} and status in(0,3)")->save();
				}else{
					$status = $model->add();
				}
				if($status > 0){ 
					$this->setSuccess('操作成功');
				}else{
					$this->setError('操作失败');
				}
			}
		}
    }

	/**
     * 获取债权待审核列表
     */
    public function getClaimsAuditList()
	{
		 
        $page['page'] = I('post.page') ? I('post.page') : 1;
        $page['limit'] = I('post.limit') ? I('post.limit') : 20;
		
        $where['validflag']='1';
        $where['status']='1';
        
		
		//债权关键字
		if (I('post.keyword')) {
            $where['d.product_name|d.borrower'] = array('LIKE', "%" . I('post.keyword') . "%");
        }
		/* //债权录入时间范围
		if(I('post.createdate')){
			$creatrkey=I('post.createdate'); 
			$ClMast= D('ClMast');
			$cdatearr = $ClMast::$createdate_value; 
			$createdate =date('Y-m-d H:i:s',strtotime($cdatearr[$creatrkey],time()));
			if(in_array($creatrkey,array(1,2,3))){
				$where ['dat_create']=array('EGT',$createdate);
			}elseif(in_array(I('post.createdate'),array(4))){
				$where ['dat_create']=array('ELT',$createdate);
			}
        }
		//债权起始时间
		if(I('post.startdate')){
            $where ['startdate']=array('EGT',I('post.startdate'));
        }
		//债权终止时间
		if(I('post.enddate')){
            $where ['enddate']=array('ELT',I('post.enddate'));
        } 
		 */
		$start_date=I('post.start_date'); 
		$end_date=I('post.end_date');  
		if($strattime=strtotime($start_date)){
			$start_date=date("Y-m-d",$strattime);
            $where ['dat_create'][]=array('EGT',$start_date);
        }
		if($endtime=strtotime($end_date)){
			$end_date=date("Y-m-d 23:59:59",$endtime);
            $where ['dat_create'][]=array('ELT',$end_date);
        }
        $data['total'] = D('ClMast')->table('__' . strtoupper('Cl_mast'). '__ as d')->where($where)->count();
        $data['items'] = D('ClMast')
                            ->field('d.*')
                            ->table('__' . strtoupper('Cl_mast'). '__ as d')
                            ->where($where)
                            ->order('id desc')->select();
 
        $this->printJson($data);
    }
	
    /**
     * 债权审核
     */
    public function auditClaims(){
        $id = I('post.id');
        $auditstatus =  in_array(I('post.status'), array(2, 3)) ? I('post.status') : 0;//2审核通过 3审核退回
        $memo =  I('post.memo');//审核描述内容
		$id = intval($id);
        $where['id'] = $id;
		$where['status'] =1;//必须为待审核状态才能通过审核
		$curdata= M("ClMast")
		->table('__' . strtoupper('Cl_mast'). '__ as d')->join('__' . strtoupper('user'). '__ as u ON d.usr_create = u.id','inner')
		->field("d.borrower,d.product_name,u.realname,u.email")
		->where(array("d.id"=>$id))
		->find();
        //必须上传文件和code
     /*    if($auditstatus!=3) {
            $file = M("cl_mast_file")->field('file')->where(array('cl_id' => $id, 'validflag' => 1))->select();
            $code = M("ClMast")->where(array('id' => $id))->getField('code');
            if (empty($file) || empty($code)) {
                $this->setError('必须上传文件和code');
            }
        }*/
        if($id &&$curdata && $auditstatus>0){
            $model = D('ClMast');
            $data = array(
                'status' => $auditstatus,
                'auditmemo' => $memo,
                'dat_modify' => date('Y-m-d H:i:s'),
                'usr_modify' =>$this->uid ,
            );
            $status = $model->where($where)->save($data);
            if($status){
				if($auditstatus==3){//退回发送邮件
					$data = array(
						'realname' => $curdata['realname'],
						'productname' =>$curdata['product_name'] ,
						'auditmemo' => $memo, 
					);
					$this->assign('data', $data);
					$content = $this->fetch('Common:claims_auditfalse');
					if($curdata['email']){
						$status = @$this->sendMail($curdata['email'], '您的债权申请审核失败', $content);
					}
                    // if ($status) {
                        // $this->setSuccess('邮件发送成功');
                    // } else {
                        // $this->setError('邮件发送失败');
                    // }
				}
                $this->setSuccess('操作成功');
            }else{
                $this->setError('操作失败');
            }
        }
        $this->setError('参数错误');
    }
	
	/**
     * 获取债权待发布列表
     */
    public function getClaimsReleaseList(){
        $page['page'] = I('post.page') ? I('post.page') : 1;
        $page['limit'] = I('post.limit') ? I('post.limit') : 20;
		
        $where['validflag']='1';
        $where['status']='2';
        $ClMast=D('ClMast');
		//债权关键字
		if(I('post.keyword')){
			 $where['d.product_name|d.borrower'] = array('LIKE', "%" . I('post.keyword') . "%");
        }
		/* //债权录入时间范围 
        if (I('post.dat_create')) {
            //$were['a.dat_create']=I('post.dat_create');
            $creatrkey = I('post.dat_create');
            $cdatearr = $ClMast::$createdate_value;
            $createdate = date('Y-m-d H:i:s', strtotime($cdatearr[$creatrkey], time()));
            if (in_array($creatrkey, array(1, 2, 3))) {
                $where ['dat_create'] = array('EGT', $createdate);
            } elseif (in_array(I('post.dat_create'), array(4))) {
                $where ['dat_create'] = array('ELT', $createdate);
            }
        } */
		$start_date=I('post.start_date'); 
		$end_date=I('post.end_date');  
		if($strattime=strtotime($start_date)){
			$start_date=date("Y-m-d",$strattime);
            $where ['dat_create'][]=array('EGT',$start_date);
        }
		if($endtime=strtotime($end_date)){
			$end_date=date("Y-m-d 23:59:59",$endtime);
            $where ['dat_create'][]=array('ELT',$end_date);
        }
		
        
		//债权起始时间
		if(I('post.startdate')){
            $where ['startdate']=array('EGT',I('post.startdate'));
        }
		//债权终止时间
		if(I('post.enddate')){
            $where ['enddate']=array('ELT',I('post.enddate'));
        } 
		
        $data['total'] = $ClMast->table('__' . strtoupper('Cl_mast'). '__ as d')->where($where)->count();
        
        $data['items'] = $ClMast
                            ->field('d.*')
                            ->table('__' . strtoupper('Cl_mast'). '__ as d')
                            ->where($where)
                            // ->join('__' . strtoupper('organization'). '__ as o ON d.organization_id = o.organization_id','left')
                            // ->join('__' . strtoupper('department'). '__ as dp ON d.pid = dp.id', 'left')
                            ->order('id desc')->select();
		foreach($data['items'] as $k =>$v){
            $data['items'][$k]['status']=$ClMast::$status_select[$v['status']];
        }
        $this->printJson($data);
    }
	/**
     * 债权发布
     */
    public function releaseClaims(){
        //债权id
        $id = I('post.id');
        $auditstatus = 4;
		//测试数据
		// $id = "27"; 
		$id = intval($id);
        $model = D('ClMast');
        $capitalpool=M('capitalpool');
        $capitalid=$model->field('capitalid')->where(['id'=>$id])->find();
        $status=$capitalpool->field('status')->where(['id'=>$capitalid['capitalid']])->find();
        if($status['status']==2){
            $this->setError('资产包已通过审核,无法发布');
        }
        if($id && $auditstatus){
            $where['id'] =$id;
            $where['status'] =2;//必须为待发布状态才能发布
           //$where['cf_mast_id']=array('NEQ','0');//必须为待审核状态才能通过审核
            $data = array(
                'status' => $auditstatus,
            );
            $status = $model->where($where)->save($data);
            if($status){
				if($model->where(array('id'=>$id))->getField('status')==4){//更新可用额度
					$return = $model->updateCapacity($id,$this->uid);
					if($return){
						$this->setSuccess('发布成功');
					}else{
						$this->setError('发布失败,数据不匹配！');
					}
				}
            }else{
                $this->setError('发布失败');
            }
        }
        $this->setError('参数错误');
    }
	//发布退回
    public function claimSendBack(){
        if(I('post.id')&&is_numeric(I('post.id'))){
             $cl_mast=M('cl_mast');
             $id=I('post.id');
             $status=$cl_mast->where(array('id'=>$id))->find();
              //判断是否为待发布状态
             if(!empty($status)&&$status['status']==2){
                 $cl_mast->where(array('id'=>$id))->save(array('status'=>10));
                 $suc=1;
                 $msg='操作成功';
             }else{
                 $suc=0;
                 $msg='参数错误,或不是待发布状态';
             }
            $return_data=array(
                 'success'=>$suc,
                 'msg'=>$msg
            );
             $this->printJson($return_data);
        }else{
            $return_data=array(
                'success'=>0,
                 'msg'=>'非post提交，或参数错误'
            );
            $this->printJson($return_data);
        }



    }



	/**
     * 债权下架
     * @return bool
     */
	 
    public function downClaims()
    {
        $id = I('post.id');
        $model = D('ClMast');
		//测试数据
		// $id = 27;
        $status = 0;
		$id = intval($id);
        if ($id ){
            $where['id'] = $id;
            $where['status'] = array('in','4');
			$data = array(
                'status' => 2,
            );
            $status = $model->where($where)->save($data);
            if ($status > 0) {
				//同步更新下架额度
				$changestatus = $model->down2updateCapacity($id,$this->uid);
				if($changestatus){
					$this->setSuccess('操作成功');
				}else{
					$this->setError('操作失败');
				}
            } else {
                $this->setError('操作失败');
            }
        }
		$this->setError('参数错误');
    }
	
    /**
     * 删除债权（回收）
     * @return bool
     */
	 
    public function recyClaims()
    {
      /*  $id = I('post.id');
        //$validflag =  in_array(I('post.validflag'), array(2)) ? I('post.validflag') : 1;
        $validflag =  0;
        $model = D('ClMast');
		//测试数据
		// $id = 25;
        $status = 0;
		$id = intval($id);
        if ($id){
            $where['id'] = $id;
            $where['status'] = array('in','0,3');
			$data = array(
                'validflag' => $validflag,
                'dat_modify' => date('Y-m-d H:i:s'),
                'usr_modify' => $this->uid ,
            );
            $status = $model->where($where)->save($data);
			
			
            if ($status > 0) {
				//同步更新发布记录的有效性
				// $model->recy2updateCapacity($id);
                $this->setSuccess('操作成功');
            } else {
                $this->setError('操作失败');
            }
        }*/
        //单条删除
        if (I('post.id') && is_numeric(I('post.id'))){
            $clmast=M('ClMast');
            $status=$clmast->where(['id'=>I('post.id')])->find();
            if(!in_array($status['status'],[0,3,10]))$this->setError('必须为未完成或审核退回或者发布退回才能删除');
            if($clmast->where(['id'=>I('post.id'),'status'=>['in','0,3,10']])->save(['validflag'=>0,'usr_modify'=>$this->uid,'dat_modify' => date('Y-m-d H:i:s')])){
                $this->setSuccess('删除成功');
            }else{
                $this->setError('删除失败');
            }
            //批量删除
        }elseif(I('post.id')&&is_string(I('post.id'))){
            $clmast=M('ClMast');
            $arr=explode(',',I('post.id'));
            $where['id']=array('IN',$arr);
            //判断是否所有资产包状态
            $data=$clmast->field('status')->where($where)->select();
            foreach($data as $key=>$value)
            {
                if(!in_array($value['status'],[0,3,10]))$this->setError('所有资产包均为未完成或审核退回或者发布退回才能删除');
            }
            if($clmast->where($where)->save(['validflag'=>0,'usr_modify'=>$this->uid,'dat_modify' => date('Y-m-d H:i:s')])){
                $this->setSuccess('删除成功');
            }else{
                $this->setError('删除失败');
            }
        }

    }
	
	/**
     * 获取确权列表
     */
	/*
    public function getClaimslist(){
        $page['page'] = I('post.page') ? I('post.page') : 1;
        $page['limit'] = I('post.limit') ? I('post.limit') : 20;
        $where = '';
        // if(I('post.name')){
            // $where .= " d.name like '%" . I('post.name') ."%' and ";
        // }
        $data['total'] = D('ClMast')->table('__' . strtoupper('Cl_ctl'). '__ as d')->where($where)->count();
        // if(I('post.option') == 1 && I('post.organization_id') > 0){
            // $page['limit'] = $data['total'];
            // $organization_id = I('post.organization_id');
            // $where .= " d.organization_id = " . $organization_id . " and ";
            // if(I('post.pid')){
                // $pid = intval(I('post.pid'));
                // $where .= " d.pid = " . $pid . ' and ';
            // }
        // }
        $data['items'] = D('ClMast')
                            ->field('d.*')
                            ->table('__' . strtoupper('Cl_ctl'). '__ as d')
                            // ->where($where . ' d.status <> 3')
                            // ->join('__' . strtoupper('organization'). '__ as o ON d.organization_id = o.organization_id','left')
                            // ->join('__' . strtoupper('department'). '__ as dp ON d.pid = dp.id', 'left')
                            ->order('id desc')->select();
 
        $this->printJson($data);
    }*/
    
    /**
     * 缓存部门数据
     * @return boolean
     */
    // public function cacheDepartment(){
        // $data = M('department')->where('status = 1')->select();
        // return $this->setCacheFile('admin_department', $data);
    // }
	
	/**
     * 获取录入日期选项
     * @return boolean
     */
    public function getInsertSelect($type='')
    {  
        $ClMast= D('ClMast');
		$createdate_select = $type==1?array(['','不限']):array();
		foreach( $ClMast::$createdate_select as $key=>$val){
			$createdate_select[]=[$key,$val];
		}
        $this->printJson($createdate_select);
    }
	
	/**
     * 获取产品状态选项
     * @return 
     */
    public function getStatusSelect($type='',$exclude="")
    {  
        $ClMast= D('ClMast'); 
		$status_select = $type==1?array(['','不限']):array();
		foreach( $ClMast::$status_select as $key=>$val){
		
			if($exclude!=""){
				$exclude = explode(",",$exclude);
				if(in_array($key,$exclude)){
					continue;
				}
			}
			$status_select[]=[$key,$val];
		}
        $this->printJson($status_select);
    }
	
    /*
     * 获取标的状态
     * @return array
     */
    public function getBidSelect()
    {  
        $ClMast= D('CfMast');
        $bidstatus = $ClMast::$status_select; 
        $this->printJson($bidstatus);
    }
   

	/*
     * 债券管理列表
     * @return array
     */
    
    public function  claimsManager()
    {
        //$page['page'] = I('post.page') ? I('post.page') : 1;
        //$page['limit'] = I('post.limit') ? I('post.limit') : 20;
		// $where['a.status']=["NEQ","0"];
        if ($_SERVER ['REQUEST_METHOD'] == 'POST' || $_SERVER ['REQUEST_METHOD'] == 'GET') {
			$ClMast = D('ClMast');
            $capitalpool= M('capitalpool') ;
            //回收状态

            //投资模式
            if (I('post.type')) {
                $where['b.investment_type'] = I('post.type');
                //返回可投资余额
                $surplus_amount=$capitalpool->field('surplus_amount')->where(array('investment_type'=>I('post.type')))->select();
                if($surplus_amount[0]['surplus_amount']>0)$surplus_amount[0]['surplus_amount']=$surplus_amount[0]['surplus_amount'].'元';
            }else{
                //返回总的可投资余额
                $surplus_amount=$capitalpool->field('sum(surplus_amount) as surplus_amount')->select();
                if($surplus_amount[0]['surplus_amount']>0)$surplus_amount[0]['surplus_amount']=$surplus_amount[0]['surplus_amount'].'元';
            }
            //债权状态

           if (isset($_POST['status'])&&$_POST['status']!='') {
                $where['a.status'] = I('post.status');
				// $where['a.status']=array(["EQ",I('post.status')],["NEQ","0"],"and");
           }
            //剩余金额
            if (I('post.amt_ct_last')) {
                $where['c.amt_ct_last'] = I('post.amt_ct_last');
				
            }
            //录入时间
			
            /* if (I('post.dat_create')) {
                //$were['a.dat_create']=I('post.dat_create');
                $creatrkey = I('post.dat_create');
                $cdatearr = $ClMast::$createdate_value;
                $createdate = date('Y-m-d H:i:s', strtotime($cdatearr[$creatrkey], time()));
                if (in_array($creatrkey, array(1, 2, 3))) {
                    $where ['a.dat_create'] = array('EGT', $createdate);
                } elseif (in_array(I('post.dat_create'), array(4))) {
                    $where ['a.dat_create'] = array('ELT', $createdate);
                }
            } */
			$start_date=I('post.start_date'); 
			$end_date=I('post.end_date');  
			if($strattime=strtotime($start_date)){
				$start_date=date("Y-m-d",$strattime);
				$where ['c.dat_modify'][]=array('EGT',$start_date);
			}
			if($endtime=strtotime($end_date)){
				$end_date=date("Y-m-d 23:59:59",$endtime);
				$where ['c.dat_modify'][]=array('ELT',$end_date);
			}
            //债权关键字
            if (I('post.keyword')) {
                $where['a.product_name|a.borrower'] = array('LIKE', "%" . I('post.keyword') . "%");
            }
            //有分页时要返回总条数
            $current_page = I('post.page') ? I('post.page') : 1;
            $page_size = I('post.limit') ? I('post.limit') : 20;
           // $current_page = I('post.current_page') ? I('post.current_page') : 1;
            //$page_size = I('post.page_size') ? I('post.page_size') : 20;
            //分页条件也必有是数字
            $page_size = is_numeric($page_size) ? $page_size : 20;
            //$limit_1 = ($current_page - 1) * $page_size;
            $limit_1=I('post.start');
            $Model = M('cl_mast');
            $total_num = $Model->alias('a')->field("a.type,a.id,a.product_name,a.status,ifnull(c.amt_ct_last,a.amt_cf_inv_price) as amt_ct_last,ifnull((c.dat_modify),'--') as dat_create")->join('LEFT JOIN __CAPITALPOOL__  b ON a.capitalid=b.id')->join('LEFT JOIN __CL_CTL__ c ON a.id=c.cod_cl_id')->where($where)->count();
            $data = $Model->alias('a')->field("b.status as zcb_status_code,a.type,a.id,a.borrower,a.product_name,a.status,b.investment_type,ifnull(c.amt_ct_last,a.amt_cf_inv_price) as amt_ct_last,ifnull((c.dat_modify),'--') as dat_create")->join('LEFT JOIN __CAPITALPOOL__ b ON a.capitalid=b.id')->join('LEFT JOIN __CL_CTL__ c ON a.id=c.cod_cl_id')->where($where)->limit("$limit_1,$page_size")->order("c.dat_modify desc")->select();
          //  echo $Model->getLastSql();
			foreach($data as $k =>$v){
				$data[$k]['status_code']=$data[$k]['status'];
				$data[$k]['status']=$ClMast::$status_select[$v['status']];
			} 
			foreach($data as $k =>$v){
				$data[$k]['type_code']=$data[$k]['type'];
				$data[$k]['type']=$ClMast::$type_select[$v['type']];
			}
			$return_data = array(
                'success' => 1,
                'msg' => '成功',
                'items' => $data,
                'total' => $total_num,
                'surplus_amount'=>$surplus_amount[0]['surplus_amount']
            );
        }else{
            $return_data = array (
                'success' => 0,
                'msg' => "异常请求",
                'data' => array ()
            );
        }
        $this->printJson($return_data);
    }
    //债权基本信息查询
/*    public function  claimView(){
        if(I('post.id')&&is_numeric(I('post.id'))){
            $where['id'] = I('post.id');
            $Model = M('cl_mast');
            $data=$Model->where($where)->select();
            $return_data=array(
                'success'=>1,
                'msg'=>'成功',
                'data'=>$data
            );
        }else{
            $return_data = array (
                'success' => 0,
                'msg' => "非POST提交或参数错误",
                'data' => array ()
            );
        }

        $this->printJson($return_data);
    }*/
    //债权投资模式
    public function claimCapitalpool(){
        if ($_SERVER ['REQUEST_METHOD'] == 'POST' || $_SERVER ['REQUEST_METHOD'] == 'GET') {
               $capitalpool=M('capitalpool');
               $data=$capitalpool->field('investment_type,name')->select();
               //$data=array_unshift($data['items'],array('a'=>'b'));
               $data[count($data)]=array('investment_type'=>'','name'=>'不限');
               $data=array_reverse($data);
               $return_data = array(
                'success' => 1,
                'msg' => '成功',
                'items' => $data,
            );
        }else{
            $return_data = array (
                'success' => 0,
                'msg' => "异常请求",
                'data' => array ()
            );
        }
       // print_r($return_data);
          $this->printJson($return_data);
    }
    //债权投资记录
    public function  claimRecord(){
        if(I('post.cod_cl_id')&&is_numeric(I('post.cod_cl_id'))){
            //有分页时要返回总条数
            $page = I('post.page') ? I('post.page') : 1;
            $limit = I('post.limit') ? I('post.limit') : 25;
            $cod_ivs_status = I('post.cod_ivs_status') ;
            //分页条件也必有是数字
            $page = is_numeric($page) ? $page : 1;
            $limit = is_numeric($limit) ? $limit : 25;
            // $limit_1 = I('post.start');
            $where['a.cod_cl_id'] = I('post.cod_cl_id');
            $Model = M('cl_ivs');
            //成交时间
            $ClMast= D('ClMast');
            if (I('post.dealtime')) {
                //$were['a.dat_create']=I('post.dat_create');
                $creatrkey = I('post.dealtime');
                $cdatearr = $ClMast::$createdate_value;
                $createdate = date('Y-m-d H:i:s', strtotime($cdatearr[$creatrkey], time()));
                if (in_array($creatrkey, array(1, 2, 3))) {
                    $where ['a.dat_create'] = array('EGT', $createdate);
                } elseif (in_array(I('post.dealtime'), array(4))) {
                    $where ['a.dat_create'] = array('ELT', $createdate);
                }
            }
            //客户名称
            if(I('post.keyword')){
                  $keyword=I('post.keyword');
                  $where['b.nam_cust_real']= array('LIKE',"%".$keyword."%");
            }
			if($cod_ivs_status != ''){
				 $where['a.cod_ivs_status']= $cod_ivs_status;
			}
            $total_num=$Model->alias('a')->join('LEFT JOIN __CUST_PERSON__ b ON a.cod_cust_id=b.cod_cust_id')
                                         ->join('LEFT JOIN __CF_MAST__ c ON a.cod_cf_id=c.id')
                                         ->join('LEFT JOIN __CF_CTL__ d ON a.cod_cf_ctl_id=d.id')
                                         ->where($where)->count();
            $data=$Model->alias('a')->field('a.id,a.cod_ivs_status,b.nam_cust_real,b.cod_cust_id_no,a.amt_ivs,a.dat_create,concat(c.title,d.cod_period,"期") as title,d.cod_period')->join('LEFT JOIN __CUST_PERSON__ b ON a.cod_cust_id=b.cod_cust_id')
                                    ->join('LEFT JOIN __CF_MAST__ c ON a.cod_cf_id=c.id')
                                    ->join('LEFT JOIN __CF_CTL__ d ON a.cod_cf_ctl_id=d.id')
                                    ->where($where)->page($page,$limit)->select();
			foreach ($data as $key => $value) {
				$data[$key]['status']=$ClMast::$ivs_status[$data[$key]['cod_ivs_status']];
			}


			$otc_cl_ctl=M('cl_ctl');
            $otc_cl_mast=M('cl_mast');
            $basic_info=$otc_cl_ctl->field('amt_ct,amt_ct_last')->where(array('cod_cl_id'=>I('post.cod_cl_id')))->find();
            //已投资金额
            $alred_invested=$basic_info['amt_ct']-$basic_info['amt_ct_last'];
            $product_name=$otc_cl_mast->field('product_name')->where(array('id'=>I('post.cod_cl_id')))->find();
            $return_data=array(
                'success'=>1,
                'msg'=>'成功',
                'items'=>$data,
                'total'=>$total_num,
                'amt_ct'=>$basic_info['amt_ct'],
                'amt_ct_last'=>$basic_info['amt_ct_last'],
                'alred_invested'=>$alred_invested,
                'product_name'=>$product_name['product_name']
            );
        }else{
            $return_data = array (
                'success' => 0,
                'msg' => "非POST提交或参数错误",
                'data' => array ()
            );
        }
        $this->printJson($return_data);
    }
    /**
     *添加/编辑 债权管理自增字段
     */
    public function saveClaimSelfField($cl_mast_id = 0)
    {
        $cl_mast_id = $cl_mast_id ? $cl_mast_id : I('param.product_id');
        $field_id = I('param.field_id') ? intval(I('param.field_id')) : 0;
        if ($cl_mast_id) {
            $data['product_id'] = $cl_mast_id;
            $data['field_name'] = I('param.field_name');
            $data['field_type'] = I('param.field_type');
            $data['field_option'] = I('param.field_option');
            $data['update_time'] = date('Y-m-d H:i:s');
            if ($field_id) {
                $data['id'] = $field_id;
                unset($data['field_type']);
                unset($data['field_option']);
                $status = M('product_self_field')->save($data);
                $where['product_id'] = $cl_mast_id;
                $where['field_id'] = $field_id;
                $value_data = array(
                    'field_name' => $data['field_name'],
                );
                M('product_self_field_value')->where($where)->save($value_data);
            } else {
                //插入成功后 $status 是新插入的field_id
                $status = M('product_self_field')->add($data);
                $value_data = array(
                    'product_id' => $cl_mast_id,
                    'field_id' => $status,
                    'field_name' => $data['field_name'],
                );
                //给新字段初始一个空值
                M('product_self_field_value')->add($value_data);
                $field_id = $status;
            }
            if ($status) {
                $this->setSuccess('产品字段保存成功！', array('field_id' => $field_id));
            } else {
                $this->setError('产品字段保存失败！');
            }
        }
        $this->setError('参数有误');
    }

    /**
     * 删除债权管理自身字段信息a
     */
    public function delClaimSelfField()
    {
        $field_id = I('param.field_id') ? intval(I('param.field_id')) : 0;
        $cl_mast_id = I('param.product_id') ? intval(I('param.product_id')) : 0;
        if ($field_id && $cl_mast_id) {
            $where['product_id'] = $cl_mast_id;
            $where['id'] = $field_id;
            $status = M('product_self_field')->where($where)->delete();
            $where['field_id'] = $field_id;
            unset($where['id']);
            M('product_self_field_value')->where($where)->delete();
            if ($status) {
                $this->setSuccess('删除成功');
            } else {
                $this->setError('删除失败');
            }
        }
        $this->setError('参数有误');
    }
    //产品列表接口
    public  function cfMastSelect(){
        if ($_SERVER ['REQUEST_METHOD'] == 'POST' || $_SERVER ['REQUEST_METHOD'] == 'GET') {
        $Model=M('cf_mast');
        $where['status']=1;
        if(I('post.cf_inv_type')&&is_numeric(I('post.cf_inv_type')))$where['cod_cf_inv_type']=I('post.cf_inv_type');
        $data=$Model->field('id,title')->where($where)->select();
        $return_data=array(
            'success'=>1,
            'msg'=>'成功',
            'items'=>$data,
        );
        }else{
            $return_data = array (
                'success' => 0,
                'msg' => "异常请求",
                'items' => array ()
            );
        }
        $this->printJson($return_data);
    }
     //债权提交审核
    public function claimSubmit(){
        $id=I('post.id');
        $Model=M('cl_mast');
        $capitalid = $Model->getFieldById($id,'capitalid');
//        capitalid
        if(!$capitalid){
            $this->setError('只有选择了资产包的债权才能提交');
        }
        $where['status']=array('IN','0,3,10');
        $where['id']=$id;
        //$data['status']=1;
        $data=array("status"=>'1');

        if($Model->where($where)->save($data)){
            $this->setSuccess('操作成功');
        }else{
            $this->setError('操作失败');
        }
    }
   //债权审核证明文件及返回代码上传
    public  function  claimFileUpload(){
        if(I('post.cl_id')&&is_numeric(I('post.cl_id'))) {
            $Model = M('cl_mast_file');
            //审核文件不为空，无返回代码
            if(!empty($_FILES['file']['tmp_name'])) {
                                $config = array(
                                    'maxSize' => 3145728,
                                    'rootPath' => './Uploads/',
                                    'savePath' => 'ClaimsFile/',
                                    'exts' => array('jpg', 'gif', 'png', 'jpeg','doc','docx','xls','xlsx','pdf')
                                );
                                $file_url='';
                                $upload = new \Think\Upload($config);// 实例化上传类
                                $info = $upload->uploadOne($_FILES['file']);
                                if (!$info) {
                                    $return_data = array (
                                        'success' => false,
                                        'msg' => "文件上传失败",
                                        'data' => array ()
                                    );
                                    $this->printJson($return_data);
                                } else {
                                    //附件地址
                                    $data['file'] = '/Uploads'.'/'.$info['savepath'] . $info['savename'];
                                    $data['status'] = 0;
                                    $data['type'] = 1;
                                    $data['dat_create'] = date('Y-m-d H:i:s');
                                    $data['validflag'] = 1;
                                    $data['usr_create'] = $this->uid;
                                    $data['cl_id'] = I('post.cl_id');
                                    $data['filename']=$_FILES['file']['name'];
                                    if($Model->add($data)){
                                        $suc=true;
                                        $msg="文件成功上传";
                                        $file_url=$data['file'];
                                    }else{
                                        $return_data = array (
                                            'success' => false,
                                            'msg' => "文件上传失败，没有成功插入数据库",
                                            'data'=>array()
                                        );
                                      $this->printJson($return_data);
                                    }
                                }
            //审核文件为空，有返回代码
            }
            if(!empty(trim($_POST['code']))){
                                $code=I('post.code');
                                $where['id']=I('post.cl_id');
                                $Model=M('cl_mast');
                                $code_old=$Model->field('code')->where($where)->find();
                                if($code==$code_old['code']){
                                    $suc=true;
                                    $msg=empty($msg)?'保存成功':$msg;
                                }
                                else{
                                            if ($Model->where($where)->save(array('code' => $code))) {
                                                $suc = true;
                                                $msg = $msg . 'code更新成功';
                                            } else {

                                                $suc = false;
                                                $msg = $msg . 'code更新失败';
                                            }
                                }
            }
            $return_data=array(
                  'success'=>$suc,
                  'msg'=>$msg,
                  'file_url'=>$file_url,
                  'data' => array ()
            );
             $this->printJson($return_data);
        }else{
            $return_data = array (
                'success' => false,
                'msg' => "非POST提交或参数错误",
                'data' => array ()
            );
            $this->printJson($return_data);
        }
    }
    //获取所有上传文件列表
    public  function  claimAllUploadFile()
    {
        if (I('post.cl_id') && is_numeric(I('post.cl_id'))) {
                $Model=M('cl_mast_file');
                $where['cl_id']=I('post.cl_id');
                $where['validflag']=1;
                $data=$Model->field('id,file,type,filename')->where($where)->select();
                $code=M('cl_mast')->field('code')->where(array('id'=>I('post.cl_id')))->find();
         /*       foreach($data as $k=>$v){
                    $filename=basename($v['file']);
                    $data[$k]['filename']=$filename;
                }*/
                $return_data=array(
                    'success'=>1,
                    'msg'=>'成功',
                    'items' => $data,
                    'code' => $code['code'],
                );
                $this->printJson($return_data);
        }else{
            $return_data = array (
                'success' => 0,
                'msg' => "非POST提交或参数错误",
                'data' => array ()
            );
            $this->printJson($return_data);
        }
 }
     //删除上传资料接口
      public function  claimDelUploadFile(){
          if (I('post.cl_id') && is_numeric(I('post.cl_id')) &&I('post.file_url')){
              $Model=M('cl_mast_file');
              $where['cl_id']=I('post.cl_id');
              $where['file']=I('post.file_url');
              $Model->where($where)->save(array('validflag'=>0))?$this->setSuccess('删除成功'):$this->setError('删除失败');
          }else{
              $return_data = array (
                  'success' => 0,
                  'msg' => "非POST提交或参数错误",
                  'data' => array ()
              );
              $this->printJson($return_data);
          }
      }
     //下载文件并重命名
     public  function  downFile()
     {
         header("Content-type:text/html;charset=utf-8");
         if (I('get.id') && is_numeric(I('get.id'))) {

             $id = I('get.id');
             $data = M('cl_mast_file')->where(array('id' => $id))->field('filename,file')->find();
             $filename = ROOT_PATH . $data['file'];
             $out_filename = $data['filename'];
			 $encoded_filename = urlencode($out_filename);
			 $encoded_filename = str_replace("+", "%20", $encoded_filename);
			 $ua = $_SERVER["HTTP_USER_AGENT"];
			 // print_r($ua);exit;
             if (!file_exists($filename)) {
      /*           $return_data = array(
                     'success' => 0,
                     'msg' => "文件不存在",
                 );*/
             //    $this->printJson($return_data);

                 echo '文件不存在';
             } else {
                 // We'll be outputting a file
                 header('Accept-Ranges: bytes');
                 header('Accept-Length: ' . filesize($filename));
                 // It will be called
                 header('Content-Transfer-Encoding: binary');
                 // header('Content-type: application/octet-stream');
                 // header('Content-Disposition: attachment; filename=' . $out_filename);
                 // header('Content-Type: application/octet-stream; name=' . $out_filename);
					header('Content-Type: application/octet-stream');
					// if (preg_match("/MSIE/", $ua)) {  
					
					// } else 
					if (preg_match("/Firefox/", $ua)) {
						header('Content-Disposition: attachment; filename*="utf8\'\'' . $out_filename . '"');
					} else {  
					// header('Content-Disposition: attachment; filename="' . $out_filename . '"');
						header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
					} 
                 // The source is in filename
                 if (is_file($filename) && is_readable($filename)) {
                     $file = fopen($filename, "r");
                     echo fread($file, filesize($filename));
                     fclose($file);
                 }
                 exit;
             }


         }else{
             echo '非get提交或参数错误';

       }
     }
   //根据投资模式返回对应所有基金
  /*  public  function  allFoundation(){
        if (I('post.type') && is_numeric(I('post.type'))){
            $capitalpool=M('capitalpool');
            $data=$capitalpool->field('id,name')->where(['investment_type'=>I('post.type'),'status'=>2])->select();
            $return_data=array(
                'success'=>1,
                'msg'=>'成功',
                'items'=>$data,
            );
             $this->printJson($return_data);
        }else{
            $return_data = array (
                'success' => 0,
                'msg' => "非POST提交或参数错误",
                'data' => array ()
            );
            $this->printJson($return_data);
        }
    }
  //基金管理-返回所有基金
    public function  foundationList(){
        if ($_SERVER ['REQUEST_METHOD'] == 'POST' || $_SERVER ['REQUEST_METHOD'] == 'GET') {
            $capitalpool = M('capitalpool');
            $data = $capitalpool->field('id,name,holder,investment_type,total_amount,surplus_amount,memo,usr_create,dat_create')->select();
            foreach ($data as $k => $v) {
                $data[$k]['investment_type'] = $v['investment_type'] == 1 ? '按债权转让' : '按收益权转让';
            }
            $return_data=array(
                'success'=>1,
                'msg'=>'成功',
                'items'=>$data,
            );
        }else{
            $return_data=array(
                'success'=>1,
                'msg'=>'异常请求',
                'items'=>array(),
                );
        }
         $this->printJson($return_data);
    }
    //删除基金
    public function recyFoundation(){
        if (I('post.id') && is_numeric(I('post.id'))){





        }




    }
    //编辑基金
    public function editFoundation(){
        if (I('post.id') && is_numeric(I('post.id'))){
               $capitalpool=M('capitalpool');
               $data['name']=I('post.name');
               $data['holder']=I('post.holder');
               $data['investment_type']=I('post.investment_type');
               $data['total_amount']=I('post.total_amount');
               $data['surplus_amount']=I('post.surplus_amount');
               $data['memo']=I('post.memo');
               $data['usr_modify']=I('post.usr_modify');
               $data['dat_modify']=I('post.dat_modify');
               if($capitalpool->where(['id'=>I('post.id')])->save($data)){
                   $this->setSuccess('操作成功');
               }else{
                   $this->setError('操作失败');
               }
        }else{
                $return_data=array(
                    'success'=>1,
                    'msg'=>'异常请求',
                    'items'=>array(),
                );
            $this->printJson($return_data);
        }
    }
    //查看基金
    public function viewFoundation(){
        if (I('post.id') && is_numeric(I('post.id'))){
            $capitalpool=M('capitalpool');
            $data=$capitalpool->where(['id'=>I('post.id')])->select();
            $return_data=array(
                'success'=>1,
                'msg'=>'成功',
                'items'=>$data,
            );
        }else{
            $return_data=array(
                'success'=>1,
                'msg'=>'异常请求',
                'items'=>array(),
            );
        }
        $this->printJson($return_data);
    }
    //新增基金
    public function  addFoundation(){
        if ($_SERVER ['REQUEST_METHOD'] == 'POST'){
            $capitalpool=M('capitalpool');
            $data['name']=I('post.name');
            $data['holder']=I('post.holder');
            $data['investment_type']=I('post.investment_type');
            $data['total_amount']=I('post.total_amount');
            $data['surplus_amount']=I('post.surplus_amount');
            $data['memo']=I('post.memo');
            $data['usr_create']=I('post.usr_create');
            $data['dat_create']=I('post.dat_create');
            $data['usr_modify']=I('post.usr_modify');
            $data['dat_modify']=I('post.dat_modify');
            if($capitalpool->add($data)){
                $this->setSuccess('操作成功');
            }else{
                $this->setError('操作失败');
            }
        }else{
            $return_data=array(
                'success'=>1,
                'msg'=>'异常请求',
                'items'=>array(),
            );
            $this->printJson($return_data);
        }



    }*/
}
