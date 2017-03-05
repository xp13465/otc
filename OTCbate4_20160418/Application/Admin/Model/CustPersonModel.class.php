<?php
namespace Admin\Model;

use Think\Log;
use Think\Model;

class CustPersonModel extends Model
{
    protected $_validate = array(
        array('nam_cust_real', 'require', '用户真实姓名必填',1),
        array('cod_cust_id_no','', '身份证号已注册',1, 'unique',1),
        array('cod_cust_id_no','/^(\d{18,18}|\d{15,15}|\d{17,17}x)$/', '身份证号格式不正确',1, 'regex'),
        array('tel', '/^\d{9,18}$/', '手机号填写出错',1),
        array('password', 'require', '密码必填',1),
        array('repassword','password','确认密码不正确',1,'confirm'),
        array('crm_file','require','请确认上传crm图片'),
    );
    protected $_auto = array(
        array('dat_modify', 'date', 3, 'function', 'Y-m-d H:i:s'),
    );
    public function cust_add(){
        $cno=I("post.cod_cust_id_no/s",0,'/^(\d{18,18}|\d{15,15}|\d{17,17}x)$/');
        $cod_cust_id= $this->add(array("cod_cust_id_type"=>'1',
                                        "cod_cust_id_no"=>$cno,
                                        "nam_cust_real"=>I('post.nam_cust_real'),
                                        "password"=>md5(I('post.password')),
                                        "crm_file"=>(I('post.crm_file')),
                                        "tel"=>I("post.tel/s",0)));
        if(!$cod_cust_id)return false;
        $r=D('CustCrm')->crmadd($cod_cust_id,$cno);
        return $r;
    }
    public function getlist($where){
        return $this->field('cod_cust_id,nam_cust_real,cod_cust_id_no')->where($where)->page(I('page',1),I('rows',10))->select();
    }
    public function cust_login(){
        $post=$_POST;
        return $this->where("cod_cust_id_no = '%s' and password = '%s'", [$post['cod_cust_id_no'], md5($post['password'])])->find();
    }
}