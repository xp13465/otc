<?php
namespace Admin\Controller;
use Think\Controller;
//基金控制器,存放所有关于基金的操作
class  FoundationController extends  AdminController{
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
    //根据投资模式返回对应所有待审核的资产包
    public  function  allFoundation(){
        if (I('post.type') && is_numeric(I('post.type'))){
            $capitalpool=M('capitalpool');
            $data=$capitalpool->field('id,name')->where(['investment_type'=>I('post.type'),'status'=>1,'validflag'=>1])->select();
            $return_data=array(
                'success'=>1,
                'msg'=>'成功',
                'items'=>$data,
            );
          //  echo $capitalpool->getLastSql();
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
    //资产包管理-返回所有资产包
    public function  foundationList(){
        if ($_SERVER ['REQUEST_METHOD'] == 'POST' || $_SERVER ['REQUEST_METHOD'] == 'GET') {
            $where['a.validflag']='1';
            $capitalpool = M('capitalpool');
            //投资模式
            if(I('post.investment_type')){
                $where['a.investment_type']=I('post.investment_type');
            }
            //资产包状态
            if(isset($_POST['status'])&&$_POST['status']!=''&&$_POST['status']!=-1){
                $where['a.status']=I('post.status');
            }
            //资产包名称
            if(I('post.keyword')){
                $keyword=I('post.keyword');
                $where['a.name'] = array('LIKE',"%".$keyword."%");
            }
            //录入时间
            if(I('post.add_time')){
                $creatrkey=I('post.add_time');
                $ClMast= D('ClMast');
                $cdatearr = $ClMast::$createdate_value;
                $createdate =date('Y-m-d H:i:s',strtotime($cdatearr[$creatrkey],time()));
                if(in_array($creatrkey,array(1,2,3))){
                    $where ['a.dat_create']=array('EGT',$createdate);
                }elseif(in_array(I('post.add_time'),array(4))){
                    $where ['a.dat_create']=array('ELT',$createdate);
                }
            }
            //分页
            $page_size = I('post.limit') ? I('post.limit') : 20;
            $page_size = is_numeric($page_size) ? $page_size : 20;
            $limit_1=I('post.start');
			
			
			$sql='select * from (
SELECT
( case t2.ctr_ct_finish when 100 then 2  else 1 end) as openorclose,
	 t2.amt_ct_last,
	 t1.capitalid as capid, 
	 (t2.amt_ct- t2.amt_ct_last)  as curr_amt,
	t1.*, t2.id AS period_id,
	t2.cod_period,
	t2.ctr_ct_finish,
	t2.ctr_ct, 
	t2.ctr_ct_last
	 

FROM
	otc_cf_mast t1
LEFT JOIN otc_cf_ctl t2 ON t1.id = t2.cf_mast_id 
WHERE
	t1.cod_cf_status IN (1, 2)

AND t1.cod_is_delete = 0
AND t2.ctr_ct_finish <=100
 
order by t1.rat_cf_inv_min asc,openorclose asc,t1.dat_modify asc,t2.cod_period desc
) as c
group by rat_cf_inv_min ';
		$list=M('')->query($sql);
		// dump($list);
		$arrid=[0];
		foreach($list as $k=>$v){
			$arrid[]=$v['capid'];
		}
		 $str="(".implode(",",$arrid).")";
			
			
			
			
			
			
			
			$canhuigouField = "(case
		WHEN c.amt_cf_inv_min is null  THEN 0
		when a.surplus_amount >c.amt_cf_inv_min then 0
		WHEN a.status !=2 THEN 0			
		when (sum(b.ctr_ct_finish)/count(b.id)) != 100 then 0
		when sum(b.amt_ct_last) = 0 then 0
		when (select count(1) from otc_cf_ivs temp where temp.capitalid = a.id and temp.cod_ivs_status = 0)!=0 then 0
	else 1
	end ) as canhuigou,";
			$field = $canhuigouField.'a.id,a.name,a.holder,a.investment_type,a.total_amount,a.surplus_amount,a.status,a.memo,a.usr_create,a.dat_create';
            
			
			
			
			
			
			$total=$capitalpool->field($field)->alias("a")  
			->where($where)->count();
			// echo $capitalpool->getLastSql();
            $data = $capitalpool
			->alias("a")
			->join("__CF_CTL__ b on a.id = b.capitalid","left")
			->join("__CF_MAST__ c on b.cf_mast_id = c.id","left")
			->join("__CF_MAST__ e on e.id = a.cf_mast_id","left")
			->field($field.",e.title,case when a.id in".$str." then 1 else 0 end as isshow")//,(case when c.cod_cf_status in(1,2) then 1 else 0 end) as isshow 
			->where($where)
			->group("a.id")
			->order("a.id desc")
			->limit("$limit_1,$page_size")->select();
            // echo $capitalpool->getLastSql();
			foreach ($data as $k => $v) {
                $data[$k]['investment_type'] = $v['investment_type'] == 1 ? '债权转让' : '收益权转让';
            }
            $return_data=array(
                'success'=>1,
                'msg'=>'成功',
                'total' => $total,
                'items'=>$data,
            );
        }else{
            $return_data=array(
                'success'=>0,
                'msg'=>'异常请求',
                'items'=>array(),
            );
        }
        $this->printJson($return_data);
    }
    //删除资产包(回收)
    public function recyFoundation(){
        //单条删除
        if (I('post.id') && is_numeric(I('post.id'))){
               $capitalpool=M('capitalpool');
               $status=$capitalpool->where(['id'=>I('post.id')])->find();
               if(!in_array($status['status'],[0,3]))$this->setError('必须为未完成或审核失败才能删除');
              if($capitalpool->where(['id'=>I('post.id'),'status'=>['in','0,3']])->save(['validflag'=>0,'usr_modify'=>$this->uid,'dat_modify' => date('Y-m-d H:i:s')])){
                   $this->setSuccess('删除成功');
               }else{
                   $this->setError('删除失败');
               }
            //批量删除
        }elseif(I('post.id')&&is_string(I('post.id'))){
              $capitalpool=M('capitalpool');
              $arr=explode(',',I('post.id'));
              $where['id']=array('IN',$arr);
              //判断是否所有资产包状态
              $data=$capitalpool->field('status')->where($where)->select();
              foreach($data as $key=>$value)
              {
                  if(!in_array($value['status'],[0,3]))$this->setError('所有资产包均为未完成或审核失败才能删除');
              }
            if($capitalpool->where($where)->save(['validflag'=>0,'usr_modify'=>$this->uid,'dat_modify' => date('Y-m-d H:i:s')])){
                $this->setSuccess('删除成功');
            }else{
                $this->setError('删除失败');
            }
        }else{
			$this->setError('数据错误');
		}
    }
    //编辑资产包
    public function editFoundation(){
        if (I('post.id') && is_numeric(I('post.id'))){
            $capitalpool=D('capitalpool');
            $data['name']=I('post.name');
            $data['holder']=1;
            $data['investment_type']=I('post.investment_type');
            $data['memo']=I('post.memo');
            $data['expected_amount']=I('post.expected_amount');
            $data['issuer']=I('post.issuer');
            $data['manager']=I('post.manager');
            $data['syfpr']=I('post.syfpr');
            $data['tzfw']=I('post.tzfw');
            $data['startdate']=I('post.startdate');
            $data['endtime']=I('post.endtime');
            $data['all_amount']=I('post.all_amount');
            $data['zjtgf']=I('post.zjtgf');
            $data['dbfjs']=I('post.dbfjs');
            $data['cf_mast_id']=I('post.cf_mast_id');
            $data['fxts']=I('post.fxts');
            $data['zjaq']=I('post.zjaq');
            $data['zqgz']=I('post.zqgz');
            $data['zcaq']=I('post.zcaq');
            $data['qqjg']=I('post.qqjg');
			$data['dbgs']=I('post.dbgs');
            $data['usr_modify']=$this->uid;
            $data['dat_modify']=date('Y-m-d H:i:s');
            if(!$capitalpool->create()){
                $this->setError($capitalpool->getError());
            }
            if($capitalpool->where(['id'=>I('post.id'),'status'=>['in','0,3']])->save($data)){
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
    //查看资产包
    public function viewFoundation(){
        if (I('post.id') && is_numeric(I('post.id'))){
            $capitalpool=M('capitalpool');
            $data=$capitalpool->where(['id'=>I('post.id')])->find();
            //根据产品id返回产品名称
            $product_name=M('cf_mast')->field('title')->where(['id'=>$data['cf_mast_id']])->find();
            $data['product_name']=$product_name['title'];
            $return_data=$data;
        }else{
            $return_data=array(
                'success'=>0,
                'msg'=>'异常请求',
                'items'=>array(),
            );
        }
        $this->printJson($return_data);
    }
    //新增资产包
    public function  addFoundation(){
        if ($_SERVER ['REQUEST_METHOD'] == 'POST'){
            $capitalpool=D('capitalpool');
            //保存为未完成状态
            $data['status']=0;
            $data['name']=I('post.name');
            $data['investment_type']=I('post.investment_type');
            $data['total_amount']=0;
            $data['surplus_amount']=0;
            $data['expected_amount']=I('post.expected_amount');
            $data['memo']=I('post.memo');
            $data['holder']=1;
            $data['issuer']=I('post.issuer');
            $data['manager']=I('post.manager');
            $data['zjtgf']=I('post.zjtgf');
            $data['dbfjs']=I('post.dbfjs');
            $data['fxts']=I('post.fxts');
            $data['zjaq']=I('post.zjaq');
            $data['zqgz']=I('post.zqgz');
            $data['zcaq']=I('post.zcaq');
            $data['qqjg']=I('post.qqjg');
            $data['dbgs']=I('post.dbgs');
            $data['syfpr']=I('post.syfpr');
            $data['tzfw']=I('post.tzfw');
            $data['startdate']=I('post.startdate');
            $data['endtime']=I('post.endtime');
            $data['all_amount']=I('post.all_amount');
            $data['cf_mast_id']=I('post.cf_mast_id');
            $data['usr_create']=$this->uid;
            $data['dat_create']=date('Y-m-d H:i:s');
            $data['usr_modify']=$this->uid;
            $data['dat_modify']=date('Y-m-d H:i:s');
            if(!$capitalpool->create()){
                $this->setError($capitalpool->getError());
            }
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
    }
	//资产包提交到待审核
    public function  foundationSubmit(){
        if (I('post.id') && is_numeric(I('post.id'))) {
            $id = I('post.id');
            $Model = M('capitalpool');
            $cf_mast_id = $Model->getFieldById($id,'cf_mast_id');
            if(!$cf_mast_id)
            {
                    $this->setError('只有选择了产品的资产包才能提交');
            }
            $where['status'] = array('IN', '0,3');
            $where['id'] = $id;
            $data = array("status" => '1');
            if ($Model->where($where)->save($data)) {
                $this->setSuccess('操作成功');
            } else {
                $this->setError('只有未完成或审核失败才能提交');
            }
        }else{
            $this->setError('非post提交或参数错误');
        }
    }
    //审核通过
	public function auditFoundation(){
		 $id = I('post.id');
		 $capitalpool=M('capitalpool');
		 $data=$capitalpool->where(['id'=>$id])->find();
		 if(empty($data)||$data['status']!=1){
			 $this->setError('资产包必须为待审核状态');
		 }
		 $file = M("capitalpool_file")->field('file')->where(array('capitalid' => $id, 'validflag' => 1))->select();
		 $code =  $capitalpool->where(array('id' => $id))->getField('otc_code');
		 if (empty($file) || empty($code)) {
			 $this->setError('必须上传文件和code');
		 }
        if (strlen($code)!=5) {
            $this->setError('code长度必须为5位');
        }

		 $messg =0;
		 //总金额和规模金额必须相等
		 if($data['total_amount']!=$data['expected_amount']){
			 $this->setError('实际金额与备案金额不符');
		 }
		 //投资产品－资金表ID,投资模式是否为0
		  $cf_mast=M('cf_mast');
		  $info=$cf_mast->field('id,cod_cf_inv_type,each_amt,amt_cf_inv_min,capitalid,cod_cf_status,title')->where(['id'=>$data['cf_mast_id']])->find();
		 if($info['cod_cf_inv_type']==0&&$info['capitalid']==0){
			   $cf_mast->where(['id'=>$data['cf_mast_id']])->save(['cod_cf_inv_type'=>$data['investment_type'],capitalid=>$id]);
		  }else{
			   //产品已发布状态,没有新的一期
			  $res=M('cf_ctl')->field('id,ctr_ct_last,ctr_ct,cod_period')->where('cf_mast_id='.$data['cf_mast_id'].' and capitalid='.$info['capitalid']." and (ctr_ct_finish<100 or ctr_ct_finish=101) ")->find();
			 //当前挂的资产包钱已经用完
			  $surplus_amount=$capitalpool->field('id,surplus_amount')->where(['id'=>$info['capitalid']])->find();
			  
			  if($info['cod_cf_status']==1&&empty($res['id'])&&$surplus_amount['surplus_amount']<$info['amt_cf_inv_min']){
				  
				  //开新的一期
				  $each_amt=min($info['each_amt'],$data['surplus_amount']);
				  if($each_amt>$info['amt_cf_inv_min']) {
					  //期号
							  $cod_period=M('cf_ctl')->field('cod_period')->where(['cf_mast_id'=>$data['cf_mast_id']])->order("cod_period desc")->find();
							  $data_new = array();
							  $data_new['cf_mast_id'] = $data['cf_mast_id'];
							  $data_new['capitalid'] = $id;
							  $data_new['type'] = 0;
							  $data_new['cod_period'] = !empty($cod_period['cod_period']) ? $cod_period['cod_period']+1 : 1;
							  $data_new['amt_ct'] = $each_amt;
							  $data_new['amt_ct_last'] = $each_amt;
							  $data_new['ctr_ct'] = '200';
							  $data_new['ctr_ct_last'] = '0';
							  $data_new['ctr_ct_finish'] = '101';
							  $data_new['dat_modify'] = date("Y-m-d H:i:s", time());
							  $data_new['ctr_updat_srlno'] = '0';
							  $model = D("cf_ctl");
							  $new_id=$model->add($data_new);
					  //$newstatus = $capitalpool->where("id='{$beiyongZCB['id']}' and investment_type='{$beiyongZCB['investment_type']}'  and {$newid} = (SELECT id FROM `otc_cf_ctl`  where cf_mast_id ={$mast_list['id']} and capitalid = {$beiyongZCB['id']}  and (ctr_ct_finish =101 or ctr_ct_finish <100  ) limit 1) ")->setDec('surplus_amount',$newMeiqijine);
					  if($new_id){
							 // $status=$capitalpool->execute("UPDATE otc_capitalpool SET surplus_amount=surplus_amount-{$each_amt} WHERE id={$id}");
							 $status = M('Capitalpool')->where("id='{$id}' and investment_type='{$data['investment_type']}' and surplus_amount >= '{$each_amt}' ")->setDec('surplus_amount',$each_amt);
											
							 if($status) {
								 $messg=1;
								 //资产包赋值
								$cf_mast->where(['id'=>$data['cf_mast_id']])->save(['capitalid'=>$id,'cod_cf_inv_type'=>$data['investment_type']]);
								$model->where(["id" => $new_id])->save(["ctr_ct_finish" => 0, "ctr_ct_last" => 199]);
							 }else{
								 $model->delete($new_id);
							 }
				   }else{
							  $model->delete($new_id);
					  }

				  }
			  }
		  }
		 //审核通过记录相关信息
		 $memo =  I('post.memo');
		 $data = array(
			 'status' => 2,
			 'auditmemo' => $memo,
			 'dat_modify' => date('Y-m-d H:i:s'),
			 'usr_modify' =>$this->uid ,
		 );
		 if($capitalpool->where(['id'=>$id])->save($data)){
			 if($messg)$this->setSuccess('审核成功，并为'.$info['title'].'产品开放新的一期销售');
			 $this->setSuccess('操作成功');
		 }else{
			 $this->setError('操作失败');
		 }
	 }
	//审核退回
	public function   foundSendBack(){
		if(I('post.id')&&is_numeric(I('post.id'))){
			$capitalpool=M('capitalpool');
			$id=I('post.id');
			$status=$capitalpool->where(array('id'=>$id))->find();
			//判断是否为待审核状态
			if(!empty($status)&&$status['status']==1){
				$capitalpool->where(array('id'=>$id))->save(array('status'=>3));
				$suc=1;
				$msg='操作成功';
			}else{
				$suc=0;
				$msg='参数错误,或不是待审核状态';
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
	//上传附件和更新代码
	public function foundationFileUpload(){
		if(I('post.cap_id')&&is_numeric(I('post.cap_id'))&&(!empty($_FILES['file']['tmp_name'])||!empty(trim($_POST['code'])))) {
			$Model = M('capitalpool_file');
			//审核文件不为空，无返回代码
			if(!empty($_FILES['file']['tmp_name'])) {
                if(!empty(trim($_POST['code']))&&strlen($_POST['code'])!=5)$this->setError('code必须为5位!');
				$config = array(
					'maxSize' => 3145728,
					'rootPath' => './Uploads/',
					'savePath' => 'FoundFile/',
					'exts' => array('jpg', 'gif', 'png', 'jpeg','doc','docx','xls','xlsx','pdf','bmp')
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
				  //  $data['status'] = 0;
					$data['type'] = 1;
					$data['dat_create'] = date('Y-m-d H:i:s');
					$data['validflag'] = 1;
					$data['usr_create'] = $this->uid;
					$data['capitalid'] = I('post.cap_id');
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
                if(strlen($code)!=5)$this->setError('code必须为5位!');
				$where['id']=I('post.cap_id');
				$Model = M('capitalpool');
				$code_old=$Model->field('otc_code')->where($where)->find();
				if($code==$code_old['otc_code']){
					$suc=true;
					$msg=empty($msg)?'保存成功':$msg;
				}
				else{
					if ($Model->where($where)->save(array('otc_code' => $code))) {
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
			if(!empty($_FILES['file']['tmp_name'])||!empty(trim($_POST['code']))){
				$msg = "非POST提交或参数错误！";
			}else{
				$msg = "请输入代码或上传文件！";
			}
			$return_data = array (
				'success' => false,
				'msg' => $msg,
				'data' => array ()
			);
			$this->printJson($return_data);
		}
	}
    //返回所有持有人列表
    public function  allHolder()
    {
        if ($_SERVER ['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD']=='GET'){
             $otc_cust_person=M('cust_person');
             $data=$otc_cust_person->field('cod_cust_id,nam_cust_real')->where(['accounttype'=>1])->select();
             $return_data = array(
                  'success' => 1,
                  'msg' =>'成功',
                  'items'=>$data
             );
        }else{
            $return_data = array (
                'success' => 0,
                'msg' => "非法操作",
                'data' => array ()
            );
        }
           $this->printJson($return_data);
    }
    //返回资产包下挂的所有债权
	public function foundAllClaims()
	{
       if (I('post.id') && is_numeric(I('post.id'))){
            $cl_mast=M('cl_mast');
            $where['a.capitalid']= I('post.id');
            $where['a.validflag']=1;
            if(I('post.status'))$where['a.status']=I('post.status');
            if(I('post.keyword'))$where['a.product_name']=array('LIKE', "%" . I('post.keyword') . "%");
            $data=$cl_mast->alias('a')->field('a.id,a.type,a.status,b.amt_ct,b.amt_ct_last,a.product_name')->join('LEFT JOIN __CL_CTL__ b ON a.id=b.cod_cl_id')->where($where)->select();
           //返回债权剩余金额
             $total_amount=$cl_mast->alias('a')->field('sum(b.amt_ct_last) as surplus_amount')->join('LEFT JOIN __CL_CTL__ b ON a.id=b.cod_cl_id')->where($where)->select();
            //返回资产包剩余金额
           // $capitalpool=M('capitalpool');
            //surplus_amount
            //$total_amount=$capitalpool->field('surplus_amount')->where(['id'=>I('post.id')])->find();
            $return_data = array (
               'success' => 1,
               'msg' => "成功",
               'items' => $data,
               'total_amount' => $total_amount[0]['surplus_amount']?$total_amount[0]['surplus_amount']:0
           );
       }else{
           $return_data = array (
               'success' => 0,
               'msg' => "非法操作",
               'data' => array ()
           );
       }
        $this->printJson($return_data);
	}
    //获取所有上传文件列表
    public  function  FoundAllUploadFile()
    {
        if (I('post.capitalid') && is_numeric(I('post.capitalid'))) {
            $Model=M('capitalpool_file');
            $where['capitalid']=I('post.capitalid');
            $where['validflag']=1;
            $data=$Model->field('id,file,type,filename')->where($where)->select();
            $code=M('capitalpool')->field('otc_code')->where(array('id'=>I('post.capitalid')))->find();
            $return_data=array(
                'success'=>1,
                'msg'=>'成功',
                'items' => $data,
                'code' => $code['otc_code'],
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

    public function  FoundDelUploadFile(){
        if (I('post.id') && is_numeric(I('post.id'))){
            $Model=M('capitalpool_file');
            $where['id']=I('post.id');
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
            $data = M('capitalpool_file')->where(array('id' => $id))->field('filename,file')->find();
            $filename = ROOT_PATH . $data['file'];
            $out_filename = $data['filename'];
            $encoded_filename = urlencode($out_filename);
            $encoded_filename = str_replace("+", "%20", $encoded_filename);
            $ua = $_SERVER["HTTP_USER_AGENT"];
            if (!file_exists($filename)) {
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
    //获取未完成列表
    public function  getBufferFound()
    {
        if ($_SERVER ['REQUEST_METHOD'] == 'POST' || $_SERVER ['REQUEST_METHOD'] == 'GET') {
            $where['validflag']='1';
            $where ['usr_create'] = $this->uid;
            $capitalpool = M('capitalpool');
            //分页
            $page_size = I('post.limit') ? I('post.limit') : 20;
            $page_size = is_numeric($page_size) ? $page_size : 20;
            $limit_1=I('post.start');
            //资产包名称
            if(I('post.keyword')){
                $keyword=I('post.keyword');
                $where['name'] = array('LIKE',"%".$keyword."%");
            }
            //录入时间
            if(I('post.add_time')){
                $creatrkey=I('post.add_time');
                $ClMast= D('ClMast');
                $cdatearr = $ClMast::$createdate_value;
                $createdate =date('Y-m-d H:i:s',strtotime($cdatearr[$creatrkey],time()));
                if(in_array($creatrkey,array(1,2,3))){
                    $where ['dat_create']=array('EGT',$createdate);
                }elseif(in_array(I('post.add_time'),array(4))){
                    $where ['dat_create']=array('ELT',$createdate);
                }
            }
            if(isset($_POST['status'])&&$_POST['status']!=''&&$_POST['status']!=-1){
                $where['status']=I('post.status');
            }
            $total=$data = $capitalpool->field('id,name,holder,investment_type,total_amount,surplus_amount,status,memo,usr_create,dat_create')->where($where)->select();
            $data = $capitalpool->field('id,name,holder,investment_type,total_amount,surplus_amount,status,memo,usr_create,dat_create')->where($where)->limit("$limit_1,$page_size")->select();
            foreach ($data as $k => $v) {
                $data[$k]['investment_type'] = $v['investment_type'] == 1 ? '按债权转让' : '按收益权转让';
            }
            $return_data=array(
                'success'=>1,
                'msg'=>'成功',
                'total' => $total,
                'items'=>$data,
            );
            $this->printJson($return_data);
        }
    }


   //获取待审核列表
    public function getFundsAuditList()
    {
        $page['page'] = I('post.page') ? I('post.page') : 1;
        $page['limit'] = I('post.limit') ? I('post.limit') : 20;
        $where['validflag']='1';
        $where['status']='1';
        //资产包名称
        if(I('post.keyword')){
            $keyword=I('post.keyword');
            $where['name'] = array('LIKE',"%".$keyword."%");
        }
        //录入时间
        if(I('post.add_time')){
            $creatrkey=I('post.add_time');
            $ClMast= D('ClMast');
            $cdatearr = $ClMast::$createdate_value;
            $createdate =date('Y-m-d H:i:s',strtotime($cdatearr[$creatrkey],time()));
            if(in_array($creatrkey,array(1,2,3))){
                $where ['dat_create']=array('EGT',$createdate);
            }elseif(in_array(I('post.add_time'),array(4))){
                $where ['dat_create']=array('ELT',$createdate);
            }
        }
        //债权关键字
        if(I('post.keyword')){
            $keyword=I('post.keyword');
            $where['product_name'] = array('LIKE',"%".$keyword."%");
        }
        //债权录入时间范围
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
        $data['total'] = D('capitalpool')->table('__' . strtoupper('capitalpool'). '__ as d')->where($where)->count();
        $data['items'] = D('capitalpool')
            ->field('d.*')
            ->table('__' . strtoupper('capitalpool'). '__ as d')
            ->where($where)
            ->order('id desc')->select();
        $this->printJson($data);
    }
    //产品列表接口
    public  function cfMastSelect(){
        if ($_SERVER ['REQUEST_METHOD'] == 'POST' || $_SERVER ['REQUEST_METHOD'] == 'GET') {
            $Model=M('cf_mast');
            $where['cod_cf_status']=array('NEQ',0);
            // if(I('post.cf_inv_type')&&is_numeric(I('post.cf_inv_type')))$where['cod_cf_inv_type']=I('post.cf_inv_type');
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
	
		
	//资产包状态接口
	 public function allFoundStatus($type='',$exclude="")
    {  
        $Capitalpool= D('Capitalpool'); 
		$status_select = $type==1?array(['','不限']):array();
		foreach( $Capitalpool::$status_select as $key=>$val){
		
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
	
	
	//暂停使用资产包
	public function pauseFound(){
		$id=(int)I('post.id');
		if(!$id||($id."")!=I('post.id')){
			$result = array('status'=>0,'msg'=>'参数错误！');
		}else{
			$m=D('capitalpool');
			$r=$m->Found_pause($id);
			if(!$r){
				$result = array('status'=>0,'msg'=>$m->error);
			}else{
				$result = array('status'=>1,'msg'=>'暂停使用成功');
			}
		}
		$this->echoJson($result);
		
	}
	
	    /**
     * 恢复使用资产包
     */
    public function resumeFound(){
        $id=I('post.id');//资产包
        if(!$id){
            $this->setError('参数错误！');
        }
        $s=D('capitalpool');
        $d=$s->Found_resume($id);
        if($d){
            $res=array('status'=>'1','msg'=>'恢复使用成功');
        }else{
            $res=array('status'=>'0','msg'=>$s->error);
        }
      $this->echoJson($res);
    }

	//回购资产包剩余债权
	public function repurchase(){
		$id=I('post.id');//资产包
		$repurchaseNum=I('post.repurchaseNum');//回购金额
		$result = D("capitalpool")->repurchase($id,$repurchaseNum,$this->uid);
        // print_r($result);
		
		$return_data = array (
            'success' => $result["status"],
            'msg' => $result["msg"] 
        );
        $this->printJson($return_data);
		
		
		
		// $this->echoJson($return_data);
	}

}