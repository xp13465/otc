<?php
namespace Guest\Controller;
use Think\Controller;
class CustController extends GuestController{
	//此为测试使用
    public function showform($ac,$arr){
		echo "<hr><h1>/Guest/Cust/".$ac."</h1>";
        echo '<form class="form" method="post" enctype="multipart/form-data" action="/Guest/Cust/'.$ac.'">';
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
            echo $sm.":<input type='".($v2?$v2:'text')."' name='".$v."' value='".$vd."'><br>";
        }
        echo "<input type='submit'>";
        echo "</form>";
    }
    public function aaa(){
		
		//print_r ($_SERVER); 
		 
		
        $this->display('Index/try');
		
		$this->showform('myivs_dnf',[]);
		$this->showform('setcrm/uid/34',['图片地址：crm_file','客户来源：source','客户名称：custname','顾问：consultant','所属团队：team','门店经理：storemanager',
								  '门店：store','分部：division','区域经理：areamanager','产品类型：producttype','收款日期：receiptdate',
								  '合同金额：contractamount','合同编号：contractno','收款金额：receivablesamount','年化收益率：rateofreturn',
								  '期数：installments','收款方式：paymentmethod','续投与否：iscontinued','预计出款日：plandate',
								  '出款金额（本金）：outprincipal','出款金额（利息）：outinterest','实收管理费：realmanagementfee',
								  '违约金费率：breakcontractamountrate','违约金额：breakcontractamount','客户生日：birthday','联系电话：tel',
								  '邮编：bizcode','地址：address','银行账户：bankaccount','开户行：bankopen','资料邮寄方式：informationbypost',
								  '备注：memo']);
		$this->showform('getcustinfo',[]);
		$this->showform('login',['cod_cust_id_no','password']);
		$this->showform('add',['cod_cust_id_no','tel','nam_cust_real','password','repassword']);
		$this->showform('custcheck',['password']);
		$this->showform('userlist',['keyword','b_time','e_time','page','limit','date_cls']);
		
		
		

		echo "<hr><h1>/Guest/Cust/uploadcrm_pic</h1>";
        echo '<form method="post" enctype="multipart/form-data" action="/Guest/Cust/uploadcrm_pic">';
        echo "file:<input type='file' name='aa' value=''><br>";
        echo "<input type='submit'>";
        echo "</form>";
    }
    /**
	*用户开户接口
	*/
    public function add(){
        if(IS_POST){
                $c=D('cust_person');
                $data = I('post.');
				$data['dat_cust_birthday']=substr($data['cod_cust_id_no'],6,8);//初始化身份证号
				$data['cod_cust_zip']='200000';//初始化邮编
				$sex=substr($data['cod_cust_id_no'],-1,1)%2;
				if($sex){
					$data['cod_cust_gender']=1;//男生
				}else{
					$data['cod_cust_gender']=0;//女生
				}
//			dump($data);
                if(!$c->create($data,1)){
					$result = array('status'=>0,'msg'=>$c->getError());
                }else {
                    $r = $c->cust_add($data);
                    if($r){
                        session("cod_cust_id",$r);
                        //$this->redirect("Cust/add2/uid/".$r);
						$result = array('status'=>1,'msg'=>'数据插入成功','uid'=>$r);
                    }else{
						$result = array('status'=>0,'msg'=>'数据插入失败');
					}
                }
				$this->echoJson($result);
        }
    }
	/**
	*用密码确认，当前用户是登录的
	*/
	public function custcheck(){
        if(IS_POST){
            $c=D('cust_person');
            $r = $c->cust_logincheck(I('post.password'),session("cod_cust_id"));
			if($r){
				session("cod_cust_candonext","1");
				$result = array('status'=>1,'msg'=>'验证通过');
			}else{
				$result = array('status'=>0,'msg'=>'验证失败');
			}
			$this->echoJson($result);
        }
	}
	/**
	*获取当前登录用户的基本信息
	*/
	public function getcustinfo(){
		if(session("cod_cust_id")){
			$r=D('cust_person')->getcustinfo(session("cod_cust_id"));
			$a=M('cust_crm')->field('address,bizcode')->where('cod_cust_id='.$r['cod_cust_id'])->find();
			if(!$a['address'] && !$a['bizcode']){
				$msg="您的住所,邮编未填充，不能申购";
				$this->setError($msg);
			}elseif(!$a['address']){
				$msg="您的住所未填充，不能申购";
				$this->setError($msg);
			}elseif(!$a['bizcode']){
				$msg="您的邮编未填充，不能申购";
				$this->setError($msg);
			}
			$where=array("cod_cust_id"=>session("cod_cust_id"),"cod_ivs_status"=>'0',"usr_create"=>$this->mid);
			$d=D('cf_ivs')->where($where)->count();
			$r['had_dnf_ivs']=$d>0?true:false;
			
			$r['cod_cust_id_no']=do_codcustidno($r['cod_cust_id_no']);
			if($r){
				$result = array('status'=>1,'msg'=>'数据读取成功','data'=>$r);
			}else{
				$result = array('status'=>0,'msg'=>'数据读取失败');
			}
		}else{
			$result = array('status'=>-1,'msg'=>'没有用户登录');
		}
		$this->echoJson($result);
	}
    /**
	*用户获取crm信息接口
	*/
	public function getcrm($uid=0){
		if($uid==0)$uid=session("cod_cust_id");
        $r = D('cust_crm')->getcrm($uid);
        if($r){
			$result = array('status'=>1,'msg'=>'数据读取成功','data'=>$r);
		}else{
			$result = array('status'=>0,'msg'=>'数据读取失败');
		}
		$this->echoJson($result);
	}
	
    /**
	*用户输入crm信息图片
	*/
	public function uploadcrm_pic(){
		$error='';
		if(!$error){
			 if (!empty($_FILES)) {
				$data=array();
				$config = array(
						'maxSize'    =>    3145728,
						'rootPath'   =>    './Uploads/',
						'savePath'   =>    'cust_crm/',
						'exts'       =>    array('jpg', 'gif', 'png', 'jpeg')
					);
				$upload = new \Think\Upload($config);// 实例化上传类
				$info   =   $upload->upload();
				if(!$info) {// 上传错误提示错误信息
					$error=$upload->getError();
				}else{// 上传成功 获取上传文件信息
					$kk="";
					foreach($info as $k=>$v){$kk=$k;break;}
					$info=$info[$kk];
					echo "/Uploads/".$info['savepath'].$info['savename'];
				}
			}else{
				$error="没有文件上传";
			}
		}
		echo $error;
		exit();
	}
	
    /**
	*用户输入crm信息接口
	*/
    public function setcrm($uid){
		$error='';
		if(!$uid){//!=session("cod_cust_id")
			$error="没有用户ID";
		}
		if(!$error&&isset($_FILES['crm_file'])&&isset($_FILES['crm_file']['name'])&&$_FILES['crm_file']['name']){
            $config = array(
                    'maxSize'    =>    3145728,
                    'rootPath'   =>    './Uploads/',
                    'savePath'   =>    'cust_crm/',
                    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg')
                );
            $upload = new \Think\Upload($config);// 实例化上传类
            $info   =   $upload->uploadOne($_FILES['crm_file']);
            if(!$info) {// 上传错误提示错误信息
				$error=$upload->getError();
            }else{// 上传成功 获取上传文件信息
                $_POST['crm_file']= '/Uploads/'.$info['savepath'].$info['savename'];
			}
		}
		if(!$error){
			$c=D('cust_crm');
            $data = I('post.');
            if(!$c->create($data)){
				$result = array('status'=>0,'msg'=>$c->getError());
            }else {
                $r = $c->crm_set($uid);
                if($r>=0){
					$result = array('status'=>1,'msg'=>'客户信息修改成功');
                }else{
					$result = array('status'=>0,'msg'=>'客户信息修改失败');
				}
            }
		}else{
			$result = array('status'=>0,'msg'=>$error);
		}
		$this->echoJson($result);
    }
    /**
	*用户登录接口
	*/
    public function login(){
        if(IS_POST){
            $c=D('cust_person');
            $r = $c->cust_login();
            if($r){
                session("cod_cust_id",$r['cod_cust_id']);
				$result = array('status'=>1,'msg'=>'登录成功','uid'=>session("cod_cust_id"),'name'=>$r['nam_cust_real']);
            }else{
				$result = array('status'=>0,'msg'=>'用户名或密码错误');
			}
			$this->echoJson($result);
        }
    }
    /**
	*用户登出接口
	*/
    public function custlogout(){
        session("cod_cust_id",null);
		$result = array('status'=>1,'msg'=>'用户登出成功');
		$this->echoJson($result);
    }
    /**
	*已开户用户列表
	*/
    public function userlist(){
        $cc=D('cust_person');
		$where="accounttype = 0";
		$id=$this->mid;//登录mid
		$res=A("Admin/Admin")->checkUserPermission('guest.allreader');
		if(!$res){
			$pos_id=M('user')->getFieldById($id,'position_id');//2
			//先查自己是不是别人的领导
			$belongs=M('user')->field('id')->where('leader_id='.$pos_id)->select();
			$ivs_id="(";
			foreach ($belongs as $key => $value) {
				$ivs_id.=$value['id'].",";
			}
			$ivs_id.=$id.")";

			$where.= " and t.add_usr in ".$ivs_id;
		}

		if(I('post.keyword')){
			$where.=" and (t.nam_cust_real like '%".I('keyword')."%' or t.cod_cust_id_no like '%".I('keyword')."%' or tel like '%".I('keyword')."%')";
		}

		if(I('post.date_cls')&&in_array(I('date_cls'),['0','1','2','3','4'])){
			$c=(int)I('post.date_cls');
			$b_arr=array("0","-1 week","-1 Month","-3 Month","0");
			$b_time=in_array($c,[0,4])?"0000-00-00 00:00:00":date("Y-m-d 00:00:00",strtotime($b_arr[$c]));
			$e_arr=array("now","now","now","now","-3 Month");
			$e_time=date("Y-m-d 23:59:59",strtotime($e_arr[$c]));
			$where.=" and t.add_time>='".$b_time."'";
			$where.=" and t.add_time<='".$e_time."'";
		}
        $l=$cc->getlist($where);
		$this->printJson($l);
    }
	/**
	*查看当前用户所有投资在一步的列表
	*sid:  0待支付 1已完成 -1已作废
	*/
	public function myivs_dnf(){
		$id=$this->mid;//登录mid
		$res=A("Admin/Admin")->checkUserPermission('guest.allreader');
		$condition='operating = 1';
		if(!$res){
			$pos_id=M('user')->getFieldById($id,'position_id');//2
			//先查自己是不是别人的领导
			$belongs=M('user')->field('id')->where('leader_id='.$pos_id)->select();
			$ivs_id="(";
			foreach ($belongs as $key => $value) {
				$ivs_id.=$value['id'].",";
			}
			$ivs_id.=$id.")";

			$condition.= " and ci.usr_create in ".$ivs_id;
		}

		$poststatus = I('post.status');
		if($poststatus!='-999'&&is_numeric($poststatus)){
			 $condition.=" and 	ci.cod_ivs_status='{$poststatus}'";
		}
		$curpage=I('page',1);
		$limit=I('limit',10);
		// $code_ivs_status
		
		//产品名称
		if(I('post.keyword')){
			// $condition.=" and otc_cf_mast.title like '%".I('post.keyword')."%' ";
			$condition.=" and concat(b.nam_cust_real,b.cod_cust_id_no) like '%".I('post.keyword')."%' ";
		}
		 
		$date_cls= I('post.date_cls');
		//申购时间
		if($date_cls&& in_array($date_cls,['1','2','3','4','5'])){
			if($date_cls == '1'){
				//10分钟内
				$condition.=" and ci.dat_create>='".date("Y-m-d H:i:s",time()-10*60)."'";
			}else if($date_cls == '2'){
				//30分钟内
				$condition.=" and ci.dat_create>='".date("Y-m-d H:i:s",time()-30*60)."'";
			}else if($date_cls == '3'){
				//1小时内
				$condition.=" and ci.dat_create>='".date("Y-m-d H:i:s",time()-60*60)."'";
			}else if($date_cls == '4'){
				//1小时内
				$condition.=" and ci.dat_create>='".date("Y-m-d H:i:s",time()-24*60*60)."'";
			}else if($date_cls == '5'){
				//一天以上
				$condition.=" and ci.dat_create<='".date("Y-m-d H:i:s",time()-24*60*60)."'";
			}
		}
		$cust=D('CustCrm');
		$data=$cust->ivslist($condition,$curpage,$limit);
		// echo M()->_sql();
		$this->printJson($data);
		
	}
	/**
	*	重新发送某条确权失败的交易的确权
	*	id cf_ivs交易id
	*/
	public function sendConfirm(){
		$sql = "select t1.* from ".C('DB_PREFIX')."cf_ivs t1 inner join ".C('DB_PREFIX')."cf_ivs_right t2 on t1.id=t2.cf_ivs_id
		where t1.id='".I('post.id')."' t1.cod_ivs_status=1 and t2.status=3 and t1.usr_create='".(int)$this->mid."'";
		$list = M('')->query($sql);
		if(!empty($list)){
			D('Cf_ivs_right')->createIvsRight($list,$this->mid);
		}
	}
	/**
	*	查看投资记录详情
	*	id
	*/
	public function ivsinfo(){
		$sql = "select t1.*,t2.nam_cust_real from ".C('DB_PREFIX')."cf_ivs t1 inner join ".C('DB_PREFIX')."cust_person t2 on t1.cod_cust_id=t2.cod_cust_id where 
		 t1.id=".I('post.id',0,'intval')." and t1.usr_create='".(int)$this->mid."'";
		$info = M('')->query($sql);
		$info=$info[0];
		
        if($info){
			$result = array('status'=>1,'msg'=>'数据读取成功','data'=>$info);
		}else{
			$result = array('status'=>0,'msg'=>'数据读取失败');
		}
		$this->echoJson($result);
	}
	



        /**
         * 用户密码修改
         * @param oldpwd 旧密码
         * @param newpwd 新密码
         * @param tel 用于验证是否是乱输入
         */

        public function userModifyPwd()
        {
        	// $this->printJson(session('user_info'));
        	$user_info=session('user_info');
        	if(!$user_info['id'])
        	{
				$r= array('status'=>1,'msg'=>'用户未登录');
				$this->echoJson($r);
        	}else if($user_info['status']!=1){//1:启用,2:禁用,3:待审核,4:注销',
        		$r= array('status'=>2,'msg'=>'用户未启用');
				$this->echoJson($r);
        	}	

        	$nam_cust_real=I('post.nam_cust_real');//客户姓名
        	$cod_cust_id_no=I('post.cod_cust_id_no');//身份证号
        	if(!$nam_cust_real || !$cod_cust_id_no){
        		$r= array('status'=>4,'msg'=>'客户姓名或身份证号必填');
				$this->echoJson($r);
        	}
        	// 密码长度应该在6-16个字符之间（字母，数字，特殊符号），区分大小写
	     	$lnewpwd=strlen(I('post.newpwd'));
        	$newpwd=base64_encode(I('post.newpwd'));
        	$newpwd2=base64_encode(I('post.newpwd2'));
        	if($lnewpwd<6 || $lnewpwd>16)
        	{
        		$r= array('status'=>5,'msg'=>'密码长度应该在6-16个字符之间（字母，数字，特殊符号），区分大小写');
				$this->echoJson($r);
        	}

        	if(!$newpwd || !$newpwd2)
        	{
   
        		$r= array('status'=>6,'msg'=>'参数错误:密码必填写');
				$this->echoJson($r);
        	}

        	if($newpwd!==$newpwd2){
  
        		$r= array('status'=>7,'msg'=>'参数错误:新密码与确认新密码不一致');
				$this->echoJson($r);
        	}


           $res=M('cust_person')
			   		->alias('cp')
		            ->field('cp.cod_cust_id,cp.add_usr,cp.password,
		            cp.nam_cust_real,cp.cod_cust_id,u.leader_id,u.position_id')
			   		->join('__USER__ u on u.id=cp.add_usr','left')
		        	->where("cp.nam_cust_real='".$nam_cust_real."' and cp.cod_cust_id_no='".$cod_cust_id_no."'")
		        	->find();

		        	if($res['add_usr']!=$user_info['id'] && $user_info['id']!=$res['position_id'] )
		        	{
		        		$r= array('status'=>3,'msg'=>'该客户不隶属于您');
						$this->echoJson($r);
		        	}
		        	if($res['cod_cust_id'])
		        	{
		        		$r=D('cust_person');
		        		$result=$r->modifyPwd($newpwd,$res['cod_cust_id']);

		        		if($result!==false)
		        		{
		        			$r = array('status'=>1,'msg'=>'密码修改成功');
							$this->echoJson($r);
		        		}else{
		        			$r = array('status'=>0,'msg'=>'密码修改失败');
							$this->echoJson($r);
		        		}
	        		}else{
	        			$r= array('status'=>0,'msg'=>'用户不存在');
						$this->echoJson($r);
					}
			}//eof userModifyPwd

		       
        }//eof class