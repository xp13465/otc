<?php
namespace Admin\Controller;
use Think\Controller;
class CfmastController extends AdminController{
	//此为测试使用
    public function showform($ac,$arr){
		echo "<hr><h1>/Admin/Cfmast/".$ac."</h1>";
        echo '<form class="form" method="post" enctype="multipart/form-data" action="/Admin/Cfmast/'.reset(explode(':',$ac)).'">';
        foreach($arr as $k=>$v){
            $vd='';
            if(!is_numeric($k)){
                $vd=$v;$v=$k;
            }
            list($v,$v2,$v3)=explode('.',$v);
            echo $v.":<input type='".($v2?$v2:'text')."' name='".$v."' value='".$vd."'><br>";
        }
        echo "<input type='submit' />";
        echo "</form>";
    }
    public function aaa(){
        $this->display('Index/try');
//        $this->showform('add:新添加投资产品',["amt_cf_inv_min","amt_cf_inv_max","rat_cf_inv_min","title","amt_time"]);
//        $this->showform('update:修改投资产品',["cfm_id","amt_cf_inv_min","amt_cf_inv_max","rat_cf_inv_min","title","amt_time"]);
//        $this->showform('tlist:投资产品列表',["page","limit","keyword"]);
//		$this->showform('releasemast:发布投资产品',["cfm_id"]);
//		$this->showform('pausemast:暂停销售投资产品',["cfm_id"]);
//		$this->showform('shelfmast:下架投资产品',["cfm_id"]);
//        $this->showform('del:删除投资产品',["cfm_id"]);
        $this->showform('productFileUpload:上传文件',["cf_id","file.file"]);
    }

    /**
     * 投资产品管理->基本信息
     * 
     */
    public function tdetail(){
    
        $id=I('post.id');//具体产品id
//       $id=70;
        if(!$id){
            $this->setError("产品id必填");
        }
        $td=D('cf_mast');
        $res=$td->getTdetail($id);
        $this->printJson($res);
    }  
      /*
     * 获取债权清单->投资记录发布时间
     * @return array
     */
    public function getInvestSelect()
    {
        $ClMast= D('CfMast');
        $investlist_value = $ClMast::$investlist_value; 
        $this->printJson($investlist_value);
    }

    /*
    * 获取投资模式 - 2016-02-15
    * @return array
    */
    public function getModelSelect()
    {
        $CfMast= D('CfMast');
        $model_select = $CfMast::$model_select;
        $status_select=array();
        foreach($model_select as $key=>$val){
            $status_select[]=["$key",$val];
        }
        $this->printJson($status_select);
    }
        /*
         *根据投资模式返回对应所有基金
         * */

    public  function  Fundname(){
        if (I('post.type') && is_numeric(I('post.type'))){
            $capitalpool=M('capitalpool');
            $data=$capitalpool->where(['investment_type'=>I('post.type')])->getField('id,name');
//            $return_data=array(
//                'success'=>1,
//                'msg'=>'成功',
//                'items'=>$data,
//            );
            $status_select=array();
            foreach($data as $key=>$val){
                $status_select[]=[$key,$val];
            }
            $this->printJson($status_select);
        }else{
            $return_data = array (
                'success' => 0,
                'msg' => "非POST提交或参数错误",
                'data' => array ()
            );
            $this->printJson($return_data);
        }
    }
    /**
     * 2016-01-27 新原型-查看债权
     */
    public function viewClaimsInfo(){
        $cod_cf_ivs_id=I('post.cod_cf_ivs_id');//投资记录id
        //测试数据
//        $cod_cf_ivs_id=1926;
        if(!$cod_cf_ivs_id){
            $this->setError('投资记录id必填');
       }
        $where='';
        $where.='a.cod_cf_ivs_id='.$cod_cf_ivs_id;
        $v=D('cf_mast');
        $data=$v->viewClaimsInfo($where);
        $this->printJson($data);
    }


    /**
     * 投资记录-lj:2016-02-15
     */
    public function debtlist(){
        $where='true';
        $dat_modify=I('post.ptime');
        $page=I('post.page',1);
        $limit=I('post.limit',10);
        /*添加投资模式*/
        $status=I('post.status');
//        $type=2;
        if($status!=''){
            $where.=' and a.cod_ivs_status='.$status;
        }
        switch ($dat_modify) {
            case '0':
                   break;
            case '1':
            $where.=' and unix_timestamp(b.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-1 week')));
                   break;
            case '2':
            $where.=' and unix_timestamp(b.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-1 month')));
            break;
            case '3':
            $where.=' and unix_timestamp(b.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-3 months')));
            break;
             case '4':
            $where.=' and unix_timestamp(b.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-3 months -1 hour -1 seconds')));
            break;
            default:
                break;
        }
        $keyword=I('post.keyword');//客户名字
        if($keyword)
        {
            $where.=" and cp.nam_cust_real like '%".$keyword."%'";//
        }
       $cf_ctl_id=I('post.cf_ctl_id');//产品期数id
       //测试数据
//        $cf_ctl_id=57;
       if(!$cf_ctl_id){
            $result=array('status'=>2,'message'=>'产品期数id必填');
            $this->printJson($result);
        }
         $where.=' and a.cod_ctl_id="'.$cf_ctl_id.'"';
         $res=D('cf_mast');
         $list=$res->getDebtList($where,$page,$limit,$cf_ctl_id);
         $this->printJson($list);

    }


	/**
	* 新添加投资产品（未完成投资产品）
	*/
    public function add(){
        if(IS_POST){
                $c=D('cf_mast');
                $data = I('post.');
//            dump($data);
                if(!$data['dat_cf_inv_begin']){
                     $data['dat_cf_inv_begin']="0000-00-00 00:00:00";
                 }
                if(!$data['dat_cf_inv_end']){
                    $data['dat_cf_inv_end']="0000-00-00 00:00:00";
                }
				/*
               $res=M('capitalpool')->Field('investment_type,surplus_amount')->where('id='.$data['capitalid'])->find();
               $data['cod_cf_inv_type']=$res['investment_type'];
               if($data['each_amt']>$res['surplus_amount']){
                   $result = array('status'=>0,'msg'=>'当前资金模式余额不足');
                   $this->echoJson($result);
//                   $this->setError('当前资金模式余额不足');
               }
			   */
                if(!$c->create($data,1)){
					$result = array('status'=>0,'msg'=>$c->getError());
                }else {
                    $r = $c->cfmast_add($data);
					$result = array('status'=>$r?1:0,'msg'=>"数据插入".($r?"成功":"失败"));
                }
				$this->echoJson($result);
        }
    }

    /**
     * 真正的保存投资产品
     */

    public function realAdd(){

        if(IS_POST){
                $c=D('cf_mast');
                $data = I('post.');
                if(!$c->create($data,1)){
                    $result = array('status'=>0,'msg'=>$c->getError());
                }else {
                    $r = $c->cfmast_add();
                    $result = array('status'=>$r?1:0,'msg'=>"数据插入".($r?"成功":"失败"));
                }
                $this->echoJson($result);
        }
    }

    //根据投资模式返回对应所有基金
    public  function  allFoundation(){
        if (I('post.type') && is_numeric(I('post.type'))){
            $capitalpool=M('capitalpool');
//            ['investment_type'=>I('post.type'),'status'=>2]
//            $data=$capitalpool->alias('a')->field('a.id,a.name')->
//                join('__CF_MAST__ b on a.id=b.capitalid','inner')->
//                where('a.investment_type='.I('post.type')." and a.status=2 and b.cod_cf_status=0")
//                ->select();//不能为审核通过的基金 不能被产品挂住的基金
            $data=$capitalpool->where('investment_type='.I('post.type')." and status=2 and cf_mast_id=0 and validflag=1")->select();
//echo M()->_sql();
//            dump($data);
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
    /**
     * 投资产品管理->审核方法
     */
    public function auditProduct(){
        $id = I('post.id');//产品id
        if(!$id){
            $this->setError("产品的id必填");
        }
        /*
        if(I('post.status')!=3){
            //先查询是否已经上传文件
            $fileid=M('cf_mast_file')->where('cf_id='.$id.' and validflag=1')->getField('id');//$id
            $code=M('cf_mast')->getFieldById($id,'code');//产品代码
            if(!$fileid){
                $this->setError("没有上传的文件");
            }elseif(!$code){
                $this->setError("没有产品代码");
            }
        }*/
        $auditstatus =  in_array(I('post.status'), array(4,3)) ? I('post.status') : 0;//4审核通过 3审核失败（退回）
        $memo =  I('post.memo');//审核描述内容
        $id = intval($id);
        $where['id'] = $id;
        $where['status'] =6;//必须为待审核状态才能通过审核

        $curdata= M("cf_mast")
            ->alias('d')
            ->field("d.usr_create,u.email,u.realname,d.title,d.capitalid,d.cod_cf_status")
//            ->join('__CAPITALPOOL__ b on b.id=d.capitalid','inner')
            ->join('__' . strtoupper('user'). '__ as u ON d.usr_create = u.id','left')
            ->where("d.id=".$id)
            ->find();

        if($id && !empty($curdata) && $auditstatus>0){
            $model = D('CfMast');
            
            $data = array(
                'cod_cf_status' => $auditstatus,
                'auditmemo' => $memo,
                'dat_modify' => date('Y-m-d H:i:s'),
                'usr_modify' =>$this->uid ,
            );
            $status = $model->where($where)->save($data);
        // dump($status);
            if($status){
//                if($auditstatus==3){//退回发送邮件
//                    $data = array(
//                        'realname' => $curdata['realname'],
//                        'productname' =>$curdata['title'] ,
//                        'auditmemo' => $memo,
//                    );
//                    $this->assign('data', $data);
//                    $content = $this->fetch('Common:cfmast_auditfalse');
//                    $s= @$this->sendMail($curdata['email'], '您的产品申请审核失败', $content);
//                }
                $this->setSuccess('操作成功');
            }else{
                $this->setError('操作失败');
            }
        }else{
            $this->setError('参数有误');
        }

    }


        /*投资产品管理()编辑
        *
        */
    public function productEdit(){
        $admit_status=array(2);
        return $this->_update($admit_status);
     }
    /**
     *上传文件
     */
    //债权审核证明文件及返回代码上传
    public  function  productFileUpload(){
            if(!I('post.cf_id')){
            $this->setError('产品id必填');
            }
            if(I('post.code')){
            $data['code']=I('post.code');
            $r=M('cf_mast')->where('id='.I('post.cf_id'))->save($data);
            }else{
                $data['code']='';
                $r=M('cf_mast')->where('id='.I('post.cf_id'))->save($data);
//                dump($r);
            }
//        dump($_FILES);
            $config = array(
                'maxSize' => 3145728,
                'rootPath' => './Uploads/',
                'savePath' => 'ProductFiles/',
                'exts' => array('jpg', 'gif', 'png', 'jpeg','bmp','doc','xlsx','docx','pdf','ppt','xls')
            );
            $upload = new \Think\Upload($config);// 实例化上传类
            $info = $upload->uploadOne($_FILES['file']);
           if(!$info){
               if($_FILES['file']['error']!=4){
                   $this->setError($upload->getError());
               }
            }else{
               $Model=M('cf_mast_file');
               //附件地址substr($config['rootPath'],1).
               $data['file']=$config['rootPath'].$info['savepath'].$info['savename'];
               $data['status'] = 0;
               $data['type'] = 1;
               $data['dat_create'] = date('Y-m-d H:i:s');
               $data['validflag']=1;
               $data['usr_create']=$this->uid;
               $data['cf_id']=I('post.cf_id');
//               $str=explode('.',$info['savename']);
               $data['filename']=$_FILES['file']['name'];//$str[0];
               $id=$Model->add($data);
              if($id)
               {
                  $result=array('success'=>true,'msg'=>'产品文件保存成功');

               }else{
                  $result=array('success'=>false,'msg'=>'产品文件保存失败');
               }

            }
        if($_FILES['file']['error']!=4 && I('post.code')) {
            if ($r!==false && $id) {
                $result = array('success' => true, 'msg' => '保存成功');
            } elseif ($r===false && !$id) {
                $result = array('success' => false, 'msg' => '保存失败');
            } elseif ($r!==false && !$id) {
                $result = array('success' => false, 'msg' => '产品代码保存成功,产品文件保存失败');
            } elseif ($r===false && $id) {
                $result = array('success' => false, 'msg' => '产品代码保存失败,产品文件保存成功');
            }
        }elseif(I('post.code')){
            if($r!==false){
                $result = array('success' => true, 'msg' => '产品代码保存成功');
            }else{
                $result = array('success' => false, 'msg' => '产品代码保存失败');
            }
        }elseif($_FILES['file']['error']!=4){
            if($id){
                $result = array('success' => true, 'msg' => '产品文件保存成功');
            }else{
                $result = array('success' => false, 'msg' => '产品文件保存失败');
            }
        }else{
            if($r!==false){
                $result = array('success' => true, 'msg' => '产品代码保存成功');
            }else{
                $result = array('success' => false, 'msg' => '产品代码保存失败');
            }
        }

        $this->echoJson($result);
    }
    /*产品文件附件下载*/

    public  function  downfile()
    {
        header("content-type:text/html;charset=utf-8");
        if (I('get.id') && is_numeric(I('get.id'))) {
            $id=I('get.id');
            $data = M('cf_mast_file')->where(array('id' => $id))->field('filename,file')->find();
            $filename = ROOT_PATH . $data['file'];
            $out_filename = $data['filename'];
			$encoded_filename = urlencode($out_filename);
			$encoded_filename = str_replace("+", "%20", $encoded_filename);
			$ua = $_SERVER["HTTP_USER_AGENT"];
            if (!file_exists($filename)) {
               echo "文件不存在";
            } else {
                // We'll be outputting a file
                header('Accept-Ranges: bytes');
                header('Accept-Length: ' . filesize($filename));
                // It will be called
                header('Content-Transfer-Encoding: binary');
                header('Content-type: application/octet-stream');
                // header('Content-Disposition: attachment; filename=' . $out_filename);
                // header('Content-Type: application/octet-stream; name=' . $out_filename);
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
        } else {
                echo "请求参数错误";
            }
    }
    /**
     * 测试上传图片
     */
    public function testup(){
        $this->display();
    }
    /**
     * 获取管理端-具体某产品上传的文件列表
     * @param cfid 产品id
     */
    public function getFileList(){
        $id=I('post.cfid');//产品id
        //测试数据
//        $id=70;
        if(!$id){$this->setError('产品id必填啊');}
        $fl=D('cf_mast');
        $data=$fl->getFileList($id);
        $this->printJson($data);

    }

    /**
     * 管理端-删除具体某产品上传的文件
     * @param cfid 产品id
     */
    public function delFiles(){
        $cfid=I('post.cfid');//产品id
        $inprison=I('post.fileid');//文件id 1,2,3
//        $cfid=19;$inprison=306;
        if(!$cfid){
            $this->setError('产品id必填');
        }
        if(!$inprison){
            $this->setError('文件id必填');
        }
        //测试数据
        //$cfid=2;
        $fileid='('.$inprison.')';
        $fl=D('cf_mast');
        $data=$fl->delFiles($cfid,$fileid);
        if($data){
            $r=array('status'=>'1','msg'=>'删除成功');
        }else{
            $r=array('status'=>'0','msg'=>$fl->error);
        }
        $this->printJson($r);
//       $this->echoJson($data);

    }

    /**
     * 获取债权信息
     */
    public function getClaimsinfo(){
        $id = I('post.cod_cl_id');
//       $id = 47;
        if(!$id){
            $this->setError('债权id必填');
        }
        $where = "id = " . intval($id);
        $d = D('cf_mast');
        $data=$d->getClaimsInfo($where);
        $this->printJson($data);
    }
    
        /*
     * 获取债权清单发布时间
     * @return array
     */
    public function getdebtSelect()
    {  
        $ClMast= D('CfMast');
        $debtvalue = $ClMast::$debt_value; 
        $this->printJson($debtvalue);
    }
    
     /**
     * 读取产品基本字段信息
     */
    public function getProductField()
    {
        // $shift_arr = ['id', 'add_time', 'update_time'];
        $id=I('post.id',0,int);
        $new_field = [];
        $product_fields = M('cf_mast')->field('*')->where('id='.$id)->select();
        foreach ($product_fields as $v) {
              array_push($new_field, $v);
        }
        return $new_field;
    }


    /**
     * 读取产品新增字段信息
     */
    public function NewColumnsShow()
    {
    	$id=I('post.cf_id',0,'intval');//产品id
//        $id=70;
        if(!$id){
            $this->setError('产品id必填');
        }
    	$res=M('cf_mast_self_field')
    		->alias('cmsf')
    		->field('cmsf.id,cmsf.field_type,cmsfv.field_name')
    		->join('__CF_MAST_SELF_FIELD_VALUE__ as cmsfv on cmsf.id=cmsfv.field_id','left')
    		->where('cmsf.cf_id='.$id)
    		->select();
    	$this->printJson($res);
    }


 /**
     *添加/编辑 产品自增字段
     */
    public function saveProductSelfField()
    {
        $product_id=I('param.cf_id');
        $product_id = $product_id ? $product_id : I('param.cf_id');
        $field_id = I('param.field_id') ? intval(I('param.field_id')) : 0;
        if ($product_id) {
            $data['cf_id'] = $product_id;
            $data['field_name'] = I('param.field_name');
            $data['field_type'] = I('param.field_type');
            $data['field_option'] = I('param.field_option');
            $data['update_time'] = date('Y-m-d H:i:s');
            if ($field_id) {
                $data['id'] = $field_id;
                unset($data['field_type']);
                unset($data['field_option']);
                $status = M('cf_mast_self_field')->save($data);
                $where['cf_id'] = $product_id;
                $where['field_id'] = $field_id;
                $value_data = array(
                    'field_name' => $data['field_name'],
                );
                M('cf_mast_self_field_value')->where($where)->save($value_data);
            } else {
                //插入成功后 $status 是新插入的field_id
                $status = M('cf_mast_self_field')->add($data);
                $value_data = array(
                    'cf_id' => $product_id,
                    'field_id' => $status,
                    'field_name' => $data['field_name'],
                );
                //给新字段初始一个空值
                M('cf_mast_self_field_value')->add($value_data);
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
     * 删除产品新增字段信息
     */
    public function delProductSelfField()
    {
        $field_id = I('param.field_id') ? intval(I('param.field_id')) : 0;
        $product_id = I('param.cf_id') ? intval(I('param.cf_id')) : 0;
        if ($field_id && $product_id) {
            $where['cf_id'] = $product_id;
            $where['id'] = $field_id;
            $status = M('cf_mast_self_field')->where($where)->delete();
            $where['field_id'] = $field_id;
            unset($where['id']);
            M('cf_mast_self_field_value')->where($where)->delete();
            if ($status) {
                $this->setSuccess('删除成功');
            } else {
                $this->setError('删除失败');
            }
        }
        $this->setError('参数有误');
    }

    /**
     * 保存产品自身新增字段信息
     * @param array $dataSelfFieldValue
     * @return boolean $status
     */
    public function saveProductSelfFieldValue($dataSelfFieldValue = array())
    {
        //获取传递过来的json数据 数据结构应为 array(
        //                                    0 =>array('field_id'=>1, product_id'=>1, 'field_name'=>name, 'field_value'=>field_value),
        //                                    1 =>array('field_id'=>1, product_id'=>1, 'field_name'=>name, 'field_value'=>field_value)
        //                                      )
        $data = empty($dataSelfFieldValue) ? getPostJson() : $dataSelfFieldValue;
        if (!empty($data)) {
            $status = true;
            foreach ($data as $key => $value) {
                $where['cf_id'] = $value['cf_id'];
                $where['field_id'] = $value['field_id'];
                $data['field_name'] = $value['field_name'];
                $data['field_value'] = $value['field_value'];
                $data['update_time'] = date('Y-m-d H:i:s');
                $s = M('cf_self_field_value')->where($where)->save($data);
                $status = $status && $s;
            }
            if (count($dataSelfFieldValue)) {
                return $status ? true : false;
            }
            if ($status) {
                $this->setSuccess('保存成功');
            } else {
                $this->setError('保存失败');
            }
        }
        $this->setError('获取参数出错');
    }

    /**
     * 修改投资产品
     */
        public function update(){
            $admit_status = array(0,3,10);
            return $this->_update($admit_status);
        }
	/**
	* 修改投资产品
	*/
    private function _update($admit_status){

        if(IS_POST) {
            $id = (int)I('post.id');
            if (!$id || ($id . "") != I('post.id')) {
                $result = array('status' => 0, 'msg' => '请输入正确的投资产品ID');
            } else {
                $origin_status = M('cf_mast')->getFieldById($id, 'cod_cf_status');

                if (in_array($origin_status, $admit_status)) {
                    $c = D('cf_mast');
                    $data = I('post.');
                    if(!$data['dat_cf_inv_begin']){
                        $data['dat_cf_inv_begin']="0000-00-00 00:00:00";
                    }
                    if(!$data['dat_cf_inv_end']){
                        $data['dat_cf_inv_end']="0000-00-00 00:00:00";
                    }
//                    dump($data);
                    if (!$c->create($data)) {
                        $result = array('status' => 0, 'msg' => $c->error);
                    } else {
                        $r = $c->cfmast_update($id);
                        if ($r) {
                            $result = array('status' => 1, 'msg' => "数据修改成功");
                        } else {
                            $result = array('status' => 0, 'msg' => $c->error);
                        }
                    }
                } else {
                    $result = array('status' => 0, 'msg' => "当前状态下不允许编辑");
                }
            }
            $this->echoJson($result);
        }
    }
    /**
     * 投资产品管理->产品详情
     * 
     */
    public function productdetail(){
        $where='';
        $id=I('post.id');//具体产品id
//        $id=70;
        if($id){
            $where.='a.id='.$id;
        }else{
            $this->setError('产品id必填');
        }
		$page=I('post.page',1,'intval');
        $limit=I('post.limit',25,'intval');
        $dat_modify=I('post.dat_modify');
        switch ($dat_modify) {
            case '0':
                break;
            case '1':
                $where.=' and unix_timestamp(a.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-1 week')));
                break;
            case '2':
                $where.=' and unix_timestamp(a.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-1 month')));
                break;
            case '3':
                $where.=' and unix_timestamp(a.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-3 months')));
                break;
            case '4':
                $where.=' and unix_timestamp(a.dat_modify)<='.strtotime(date('Y-m-d',strtotime('-3 months -1 hour -1 seconds')));
                break;
            default:
                break;
        }
        //产品状态查询
        $cod_cf_status=I('post.status');
        if($cod_cf_status!==""&& $cod_cf_status>=0){
            $where.=' and a.cod_cf_status='.$cod_cf_status;
        }
        //标的状态
        $bid_cf_status=I('bid_cf_status');
        switch($bid_cf_status){
            case 0:
                break;
            case 1:
            $where.=" and c.ctr_ct_finish >= 0 and c.ctr_ct_finish < 100";//销售中
                break;
            case 2:
            $where.=" and c.ctr_ct_finish=100";//已售罄
                break;
            case 3:
             $where.=" and a.cod_cf_status!=1";
                break;
        }
        if(I('post.keyword'))
        {
            $where.=' and concat(p.name,a.title,c.cod_period,"期") like "%'.I('post.keyword').'%"';
        }
        if(!$id){$this->setError('产品id必填');}
        $td=D('cf_mast');
        $res=$td->getPdetail($where,$page,$limit);
        $this->printJson($res);

    }

    /**
     * 未完成的产品列表
     */
    public function getUnfinishProduct(){
        $where='true';
        // $where.=" and a.cod_cf_status in (0,3)";
        $dat_modify=I('post.createdate',0,'intval');//交易成功时间
        $curpage=I('post.page',1,'intval');
        $limit=I('post.limit',10);
        $where.=' and a.usr_create='.$this->getUserInfo()['id'];
        switch ($dat_modify) {
            case '0':
                break;
            case '1':
                $where.=' and unix_timestamp(a.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-1 week')));
                break;
            case '2':
                $where.=' and unix_timestamp(a.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-1 month')));
                break;
            case '3':
                $where.=' and unix_timestamp(a.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-3 months')));
                break;
            case '4':
                $where.=' and unix_timestamp(a.dat_modify)<='.strtotime(date('Y-m-d',strtotime('-3 months -1 hour -1 seconds')));
                break;
            default:
                break;
        }

        $keyword=I('post.keyword');
		$status=I('post.status');
		if($status!='' &&$status>=0){
			 $where.=' and cod_cf_status ="'.$status.'"';
		}
        if($keyword){
            $where.= " and (a.title like '%".I('post.keyword')."%') and cod_is_delete=0";
        }else{
            $where.= " and a.cod_is_delete=0";
        }
        $c=D('cf_mast');
        $l=$c->getalllist($where,$curpage,$limit);

        $this->printJson($l);
    }


    /**
     * 待审核的产品列表
     */
    public function getUncheckProduct(){
        $where='';
        $where.="a.cod_cf_status=6";
        $dat_modify=I('post.createdate');//交易成功时间
        $curpage=I('post.page',1,'intval');
        $limit=I('post.limit',10);
        switch ($dat_modify) {
            case '0':
                break;
            case '1':
                $where.=' and unix_timestamp(a.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-1 week')));
                break;
            case '2':
                $where.=' and unix_timestamp(a.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-1 month')));
                break;
            case '3':
                $where.=' and unix_timestamp(a.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-3 months')));
                break;
            case '4':
                $where.=' and unix_timestamp(a.dat_modify)<='.strtotime(date('Y-m-d',strtotime('-3 months -1 hour -1 seconds')));
                break;
            default:

                break;
        }
		
        $keyword=I('post.keyword');
        if($keyword){
            $where.= " and (a.title like '%".I('post.keyword')."%') and cod_is_delete=0";
        }else{
            $where.= " and a.cod_is_delete=0";
        }
        $c=D('cf_mast');
        $l=$c->getalllist($where,$curpage,$limit);

        $this->printJson($l);

    }
    /*
     * 发布退回
     * @param cf_id：产品id
     * return bool true or false
     */
    public function publicBack(){
        $cf_id=I('post.cfm_id');
        //只有=4的才能发布退回
        $pb=D('cf_mast');
        $msg=$pb->cfmast_pb($cf_id);
        if($msg){
            $res=array('status'=>1,'msg'=>'发布退回成功');
        }else{
            $res=array('status'=>0,'msg'=>'发布退回失败');
        }
        $this->echoJson($res);
    }

       /**
     * 待发布的产品列表
     */
    public function getUnpublicProduct(){

        $where='true';
        $where.=" and a.cod_cf_status =4";
        $dat_modify=I('post.createdate');//交易成功时间
        $curpage=I('post.page',1,'intval');
        $limit=I('post.limit',10);
        switch ($dat_modify) {
            case '0':
                break;
            case '1':
                $where.=' and unix_timestamp(a.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-1 week')));
                break;
            case '2':
                $where.=' and unix_timestamp(a.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-1 month')));
                break;
            case '3':
                $where.=' and unix_timestamp(a.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-3 months')));
                break;
            case '4':
                $where.=' and unix_timestamp(a.dat_modify)<='.strtotime(date('Y-m-d',strtotime('-3 months -1 hour -1 seconds')));
                break;
            default:

                break;
        }

        $keyword=I('post.keyword');
        if($keyword){
            $where.= " and (a.title like '%".I('post.keyword')."%') and cod_is_delete=0";
        }else{
            $where.= " and a.cod_is_delete=0";
        }
        $c=D('cf_mast');
        $l=$c->getalllist($where,$curpage,$limit);

        $this->printJson($l);

    }

    /**
    * 获取投资产品列表(融资主信息表)（投资产品管理）
    *投资产品状态 1正常 2暂停销售  3下架' 
    */  
    public function tlist(){
        $where='true';
        $usr_create=$this->mid;

        $cod_cf_status=I('post.status');//1正常 2暂停销售  3下架'
        if($cod_cf_status!=""&&$cod_cf_status>=0)
        {
           $where.=" and a.cod_cf_status=".$cod_cf_status;//." and otc_cf_mast.usr_create=".$usr_create;
        }
        if($usr_create==9){
            $where.=" and a.usr_create=".$usr_create;
        }
        $curpage=I('post.page',1,'intval');
        $limit=I('post.limit',25,'intval');
        $dat_modify=I('post.dealstime');//交易成功时间
        switch ($dat_modify) {
            case '0':
                   break;
            case '1':
            $where.=' and unix_timestamp(a.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-1 week')));
                   break;
            case '2':
            $where.=' and unix_timestamp(a.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-1 month')));
            break;
            case '3':
            $where.=' and unix_timestamp(a.dat_modify)>='.strtotime(date('Y-m-d',strtotime('-3 months')));
            break;
             case '4':
            $where.=' and unix_timestamp(a.dat_modify)<='.strtotime(date('Y-m-d',strtotime('-3 months -1 hour -1 seconds')));
            break;
            default:
                
                break;
        }

        $keyword=I('post.keyword');
        if($keyword){
            $where.= " and (a.title like '%".I('post.keyword')."%') and cod_is_delete=0";
        }else{
            $where.= " and a.cod_is_delete=0";
        }
        $c=D('cf_mast');
        $l=$c->getlist($where,$curpage,$limit,"a.id");

        $this->printJson($l);
    }



	/**
	*发布投资产品
	*/
    public function releasemast(){
		$id=(int)I('post.cfm_id');
//        $id=2;
		if(!$id||($id."")!=I('post.cfm_id')){
			$result = array('status'=>0,'msg'=>'请输入正确的投资产品ID');
		}else{
			$m=D('cf_mast');
			$r=$m->cfmast_fb(I('post.cfm_id'));
			if(!$r){
				$result = array('status'=>0,'msg'=>$m->error);
			}else{
				$result = array('status'=>1,'msg'=>'发布投资产品成功');
			}
		}
		$this->echoJson($result);
    }
    /**
     * 提交投资产品
     * @param 成功返回 true 失败是false
     */
    public function commit()
    {
        $cf_id=I('post.cf_id',0,'intval');
//       $cf_id=18;
        if(!$cf_id){
            $this->setError('产品id必填');
        }
        $r=D('cf_mast');
        $res=$r->cfmast_commit($cf_id);
    if($res){
        $this->setSuccess("修改成功");
    }else{
        $this->setError($r->error);
    }

    }
	/**
	*下架投资产品
	*/
    public function shelfmast(){
		$id=(int)I('post.cfm_id');
		if(!$id||($id."")!=I('post.cfm_id')){
			$result = array('status'=>0,'msg'=>'请输入正确的投资产品ID');
		}else{
			$m=D('cf_mast');
			$r=$m->cfmast_shelf($id);
			if(!$r){
				$result = array('status'=>0,'msg'=>$m->error);
			}else{
				$result = array('status'=>1,'msg'=>'下架投资产品成功');
			}
		}
		$this->echoJson($result);
    }
	/**
	*暂停发布投资产品
	*/
    public function pausemast(){
		$id=(int)I('post.cfm_id');
		if(!$id||($id."")!=I('post.cfm_id')){
			$result = array('status'=>0,'msg'=>'请输入正确的投资产品ID');
		}else{
			$m=D('cf_mast');
			$r=$m->cfmast_pause($id);
			if(!$r){
				$result = array('status'=>0,'msg'=>$m->error);
			}else{
				$result = array('status'=>1,'msg'=>'暂停发布投资产品成功');
			}
		}
		$this->echoJson($result);
    }

    /**
     * 启动发布产品
     */
    public function start(){
        $cfm_id=I('post.cfm_id');//产品id
        if(!$cfm_id){
            $this->setError('产品id必填');
        }
        $s=D('cf_mast');
        $d=$s->cfmast_qd($cfm_id);
        if($d){
            $res=array('status'=>'1','msg'=>'投资产品启动成功');
        }else{
            $res=array('status'=>'0','msg'=>$s->error);
        }
      $this->echoJson($res);
    }
	/**
	*删除投资产品
	*/
    public function del(){
        $cfm_id=I('post.cfm_id');//是一个数组
//        $cfm_id='1,2,3';
        if(!$cfm_id){
            $this->setError('产品id必填');
        }
        $s=array(0,3,10);//能删除的状态
        $str="(".$cfm_id.")";
        $un='';
        $status=M('cf_mast')->Field('id,cod_cf_status')->where("id in ".$str)->select();
        if(!empty($status)){
            foreach($status as $k=>$v){
                if(!in_array($v['cod_cf_status'],$s)){
                    $un.=$v['id'].",";
                }
              }
            if(substr_count($un,',')==1){$un=substr($un,0,-1);}
            if($un){
                $this->setError("以下id: ".$un." 不能删除");
            }
        }
        $where='';
        $where.='id in '.$str." and cod_is_delete=0 and cod_cf_status in (0,3,10)";
        $r=D('cf_mast')->cfmast_del($where);
        if(!$r){
            $result =array('status'=>0,'msg'=>$r->error);
        }else{
            $result = array('status'=>1,'msg'=>'删除投资产品成功');
        }
        $this->echoJson($result);
    }


	/**
     * 获取产品状态选项
     * @return 
     */
    public function getStatusSelect($type='')
    {  
        $CfMast= D('CfMast');
		$status_select = $type==1?array(['','不限']):array();
		foreach($CfMast::$status_select as $key=>$val){
			$status_select[]=[$key,$val];
		}
        $this->printJson($status_select);
    }
	
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
    *  POS交易记录列表
    *  
    */  
    public function poslist(){
        $where = [];
		$page=I('post.page',1,'intval');
        $limit=I('post.limit',25,'intval'); 
		$startdate=I('post.startdate');
		$enddate=I('post.enddate');
		if($startdate){
			$startdate=str_replace("T00:00:00","",$startdate);
			$where['a.dat_modify']=array("EGT",$startdate." 00:00:00");
		}
        if($enddate){
			$enddate=str_replace("T00:00:00","",$enddate);
			$where['a.dat_modify']=array("ELT",$enddate." 23:59:59");
		}
		$custname=I('post.custname');
        $username=I('post.username');
        $salesname=I('post.salesname');
        $productname=I('post.productname');
		if($custname){
			$where['b.nam_cust_real']=array("LIKE","%{$custname}%");
		}
		if($username){
			$where['e.realname']=array("LIKE","%{$username}%");
		}
		if($salesname){
			$where['a.sales']=array("LIKE","%{$salesname}%");
		}
		if($productname){
			$where['concat(c.title,d.cod_period,"期")']=array("LIKE","%{$productname}%");
		}
        $data= D("CfMast")->getPosList($where,$page,$limit);
		foreach($data['items'] as $k=>$v){
			$data['items'][$k]['cod_cust_id_no']=do_codcustidno($v['cod_cust_id_no']);
		}
        $this->printJson($data);
    }

    /*
 * 资产包选择
     * cf_mast_id :产品id:
 * */
    public function capitalbags(){
        $cf_mast_id=I('post.cf_mast_id');
        //测试数据
//        $cf_mast_id=91;
        if(!$cf_mast_id){
            $this->setError('产品id必填');
        }
        $where='';
        $where.='a.cf_mast_id='.$cf_mast_id;
        $keyword=I('post.keyword');
        if($keyword){
            $where.=' and a.name like "%'.$keyword.'%"';
        }
        $investment_type=I('post.status')?I('post.status'):null;
        if(!is_null($investment_type)){
            $where.=' and a.investment_type='.$investment_type;
        }
        $data=D('cf_mast')->capitalbags($where);
        $this->printJson($data);
    }
	/**
	*导出POS交易记录列表
	*/
     public function outpos2excel($type="excel")
     {
		 
		 
		    Vendor("PHPExcel");
            Vendor("PHPExcel.IOFactory");
            Vendor("PHPExcel.Reader.Excel5");
			
		/* 	$inputFileName ="./1.csv";
			// $inputFileName ="./1.xls";
			$inputFileName ="./2.xls";
            $objReader = \PHPExcel_IOFactory::createReader('Excel5'); 
			try{
				$objPHPExcel = $objReader->load($inputFileName);
			}catch(Exception $e){}
			
			 // if(!isset($PHPReader)) return array("error"=>0,'message'=>'read error!');
			// $allWorksheets = $PHPReader->getAllSheets();
			  // $objPHPExcel = $PHPReader->load($inputFileName);
         $loadedSheetNames = $objPHPExcel->getSheetNames();
          
         foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
             $objPHPExcel->setActiveSheetIndexByName($loadedSheetName);
             $sheetDataArr[] = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
         }
		dump($sheetDataArr);
		exit;
		 */
		$where = [];
		$startdate=I('get.startdate');
		$enddate=I('get.enddate');
		$title="";
		if($startdate){
			$startdate=str_replace("T00:00:00","",$startdate);
			$where['a.dat_modify']=array("EGT",$startdate." 00:00:00");
			$title.="从".$startdate;
		}
        if($enddate){
			$enddate=str_replace("T00:00:00","",$enddate);
			$where['a.dat_modify']=array("ELT",$enddate." 23:59:59");
			if($startdate){
				$title.="至".$enddate;
			}else{
				$title.=$enddate."以前";
			}
		}else{
			if($startdate){
				$title.="至今";
			}else{
				$title.="所有记录";
			}
		}
		
		$custname=I('get.custname');
        $username=I('get.username');
        $salesname=I('get.salesname');
        $productname=I('get.productname');
		if($custname){
			$where['b.nam_cust_real']=array("LIKE","%{$custname}%");
		}
		if($username){
			$where['e.realname']=array("LIKE","%{$username}%");
		}
		if($salesname){
			$where['a.sales']=array("LIKE","%{$salesname}%");
		}
		if($productname){
			$where['concat(c.title,d.cod_period,"期")']=array("LIKE","%{$productname}%");
		}
		
		
		$IvsList = D("CfMast")->getPosList($where,"","")['items'];
		
        if($IvsList&&$type=="csv"){
			
			$str = "客户姓名,客户身份证号,标的名称,每份金额,份数,投资金额,成交时间,POS单号,POS扫描件,部门,城市,营业区,业务部,社区门店,销售经理,录入人\n";
			foreach($IvsList as $k => $v)
            { 	 
                $str.="".$v["nam_cust_real"];
                $str.="\t,".do_codcustidno($v['cod_cust_id_no']);
                $str.="\t,".$v["bid"];
				$str.="\t,".$v["amt_int_total"];
                $str.="\t,".$v["ctl_ivs_cnt"];
                $str.="\t,".$v["amt_ivs"];
                $str.="\t,".$v["dat_modify"];
				$str.="\t,".$v["pos_order"];
                $str.="\t,".$v["url_pos_file"];
				$str.="\t,".$v["department_name"];
				$str.="\t,".$v["city"];
				$str.="\t,".$v["yingyequ"];
				$str.="\t,".$v["yewubu"];
				$str.="\t,".$v["shequmendian"];
				$str.="\t,".$v["sales"]; 
				$str.="\t,".$v["user_name"];
				$str.="\t\n";
            }
			
			// echo str_replace("\n","<br/>",$str);
			// exit;
			$filename = 'POS记录表('.date('Y-m-d H:i:s').').csv';
			$str = mb_convert_encoding($str, 'gbk', 'utf-8');   
			$this->export_csv($filename,$str);
			
        }else if($IvsList&&$type=="excel"){
			// dump($IvsList);
            // exit;
            Vendor("PHPExcel");
            Vendor("PHPExcel.IOFactory");
            Vendor("PHPExcel.Reader.Excel5");
            
            $objPHPExcel = new \PHPExcel;
			
            //设置一列的宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);

            // $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(50);

            $objPHPExcel->getActiveSheet()->getDefaultStyle('A1')->getFont()->setSize(15);

            //设置单元格背景颜色
            //$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->getStartColor()->setARGB('FF808080');
            
            //设置加粗
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
			 

            //设置水平居中 
            // $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
            $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
            $objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
            $objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('J1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('K1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $objPHPExcel->setActiveSheetIndex(0)
                       //设置表的名称标题
                       ->setCellValue('A1',"客户姓名")
                       ->setCellValue('B1',"客户身份证号")
                       ->setCellValue('C1',"标的名称")
                       ->setCellValue('D1',"每份金额")
                       ->setCellValue('E1',"份数")
                       ->setCellValue('F1',"投资金额")
                       ->setCellValue('G1',"成交时间")
					    ->setCellValue('H1',"POS单号")
                       ->setCellValue('I1',"POS扫描件")
                       ->setCellValue('J1',"部门")
					   ->setCellValue('K1',"城市")
					   ->setCellValue('L1',"营业区")
					   ->setCellValue('M1',"业务部")
					   ->setCellValue('N1',"社区门店")
					   ->setCellValue('O1',"销售经理")
					   ->setCellValue('P1',"录入人")
					   ;
			$row=1;
			// print_r($_SERVER['HTTP_HOST']);EXIT;
            foreach($IvsList as $k => $v)
            { 	$row++;
			// dump(PHPExcel_Cell_DataType);exit;
                 $objPHPExcel->setActiveSheetIndex(0)
                 //Excel的第A列，uid是你查出数组的键值，下面以此类推
                 ->setCellValueExplicit('A'.$row,$v["nam_cust_real"],'s')
                 ->setCellValueExplicit('B'.$row,do_codcustidno($v['cod_cust_id_no']),'s')
                 ->setCellValueExplicit('C'.$row,$v["bid"],'s')
				 ->setCellValueExplicit('D'.$row,$v["amt_int_total"],'s')
                 ->setCellValueExplicit('E'.$row,$v["ctl_ivs_cnt"],'s')
                 ->setCellValueExplicit('F'.$row,$v["amt_ivs"],'s')
                 ->setCellValueExplicit('G'.$row,$v["dat_modify"],'s')
				 ->setCellValueExplicit('H'.$row,$v["pos_order"],'s')
                 ->setCellValueExplicit('I'.$row,$v["url_pos_file"])
				 ->setCellValueExplicit('J'.$row,$v["department_name"],'s')
				 ->setCellValueExplicit('K'.$row,$v["city"],'s')
				 ->setCellValueExplicit('L'.$row,$v["yingyequ"],'s')
				 ->setCellValueExplicit('M'.$row,$v["yewubu"],'s')
				 ->setCellValueExplicit('N'.$row,$v["shequmendian"],'s')
				 ->setCellValueExplicit('O'.$row,$v["sales"],'s') 
				 ->setCellValueExplicit('P'.$row,$v["user_name"],'s');
                
				 
				 
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, "下载");
				$objPHPExcel->getActiveSheet()->getCell('I'.$row)->getHyperlink()->setUrl("http://".$_SERVER['HTTP_HOST']."/Admin/Cfmast/downposfile/id/".$v["id"]);
				$objPHPExcel->getActiveSheet()->getCell('I'.$row)->getHyperlink()->setTooltip($v["pos_file"]); 
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->getFont()->getColor()->setRGB('0000FF');
            }
			 //设置边框
            $objPHPExcel->getActiveSheet()->getStyle('A1:K'.$row)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN); 
             //  sheet命名
            $objPHPExcel->getActiveSheet()->setTitle($title);  

            // Set active sheet index to the first sheet, so Excel opens this as the first sheet  
            $objPHPExcel->setActiveSheetIndex(0);  
            
			$filename = 'POS记录表('.date('Y-m-d H:i:s').').xls';
            $this->OutExcel($objPHPExcel,$filename);
        }else{
             $this->setError('无数据');
        }
		exit;
    }
	/**
	* 导出EXCEL
	*/
	private function OutExcel($objPHPExcel,$filename){
		// excel头参数  
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');  //日期为文件名后缀  
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  //excel5为xls格式，excel2007为xlsx格式  
        $objWriter->save('php://output');
		
	}
	/**
	* 导出CSV
	*/
	private function export_csv($filename,$data)   
	{   
		header("Content-type:text/csv");   
		header("Content-Disposition:attachment;filename=".$filename);   
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');   
		header('Expires:0');   
		header('Pragma:public');   
		echo $data;   
	} 
	/**
	*导出POS交易记录列表
	*/
     public function ZipPosFiles()
     {
		$where = [];
		$startdate=I('get.startdate');
		$enddate=I('get.enddate');
		$title="";
		if($startdate){
			$startdate=str_replace("T00:00:00","",$startdate);
			$where['a.dat_modify']=array("EGT",$startdate." 00:00:00");
		}
        if($enddate){
			$enddate=str_replace("T00:00:00","",$enddate);
			$where['a.dat_modify']=array("ELT",$enddate." 23:59:59");
		}
		$custname=I('get.custname');
        $username=I('get.username');
        $salesname=I('get.salesname');
        $productname=I('get.productname');
		if($custname){
			$where['b.nam_cust_real']=array("LIKE","%{$custname}%");
		}
		if($username){
			$where['e.realname']=array("LIKE","%{$username}%");
		}
		if($salesname){
			$where['a.sales']=array("LIKE","%{$salesname}%");
		}
		if($productname){
			$where['concat(c.title,d.cod_period,"期")']=array("LIKE","%{$productname}%");
		}
		
		$IvsList = D("CfMast")->getPosList($where,"","")['items'];
        if($IvsList){ 
			 $files=array();
			 foreach($IvsList as $k=>$v){
				 $extension = end(explode('.', $v["pos_file"])); 
				 $files[$v["pos_order"]."_".$v["id"].".".$extension]=ROOT_PATH.$v["pos_file"];
				 
			 }
			 // dump($IvsList);
			 // dump($files);
			$archive  =  new \Common\Lib\PHPZip();
			$archive->ZipAndDownloadFiles($files);
	   
        }else{
             $this->setError('无数据');
        }
    }
	/**
	* 下载POS扫描件
	*/
	public  function  downposfile()
    {    
		 
        header("content-type:text/html;charset=utf-8");
        if (I('get.id') && is_numeric(I('get.id'))) {
            $id=I('get.id');
            $data = M('cf_ivs')->where(array('id' => $id))->field('pos_file,pos_order')->find();
            $filename = ROOT_PATH . $data['pos_file'];
			$extension = end(explode('.', $filename)); 
            $out_filename = $data['pos_order'].".".$extension;
			
			$encoded_filename = urlencode($out_filename);
			$encoded_filename = str_replace("+", "%20", $encoded_filename);
			$ua = $_SERVER["HTTP_USER_AGENT"];
            if (!file_exists($filename)) {
               echo "文件不存在";
            } else {
                // We'll be outputting a file
                header('Accept-Ranges: bytes');
                header('Accept-Length: ' . filesize($filename));
                // It will be called
                header('Content-Transfer-Encoding: binary');
                header('Content-Type: application/octet-stream');
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
        } else {
                echo "请求参数错误";
            }
    }
 	/**
     * 管理端-确认到账
     * @param id 投资记录ID
     */
    public function confirmArrival(){
        $ivsid=I('post.id');//产品id
        $arrivaldate=I('post.arrivaldate');//产品id
		if(!$time=strtotime($arrivaldate)){
			$this->setError('到账日期格式错误！');
		}
		$ivsdata=M("CfIvs")->field("arrivaldate,dat_arrival,usr_arrival")->where(['id'=>$ivsid])->find();
		if(!$ivsdata){
            $this->setError('投资记录不存在');
        }
		if($ivsdata['usr_arrival']){
			$this->setError('该投资已确认到账！');
		} 
		$arrivaldate=date("Y-m-d",$time);
		
		$data=[
			'arrivaldate'=>$arrivaldate,
			'dat_arrival'=>date("Y-m-d H:i:s",time()),
			'usr_arrival'=>$this->uid,
		];
		
		$status = M("CfIvs")->where(['id'=>$ivsid])->save($data);
        if($status>=0){
            $r=array('success'=>'1','msg'=>'确认到账成功！');
        }else{
			$r=array('success'=>'0','msg'=>'确认到账失败！'); 
        } 
        $this->printJson($r); 

    }
  

}