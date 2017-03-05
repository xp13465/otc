<?php
namespace Guest\Model;

use Think\Log;
use Think\Model;

class CustPersonModel extends Model
{
    protected $_validate = array(
        array('nam_cust_real', 'require', '用户真实姓名必填',1),
        array('cod_cust_id_no','', '身份证号已注册',1, 'unique',1),
        array('cod_cust_id_no','/^(\d{18,18}|\d{15,15}|\d{17,17}[x,X])$/', '身份证号格式不正确',1, 'regex'),
        array('tel', '/^\d{9,18}$/', '手机号填写出错',1),
        array('password', 'require', '密码必填',1),
        array('repassword','password','确认密码不正确',1,'confirm'),
        //array('crm_file','require','请确认上传crm图片'),
    );
    protected $_auto = array(
        array('dat_modify', 'date', 3, 'function', 'Y-m-d H:i:s'),
    );
	/**
	*添加新用户 2016-01-16(更改为base64加密方式lj)
	*/
    public function cust_add($data){
        $cno=I("post.cod_cust_id_no",0,'/^(\d{18,18}|\d{15,15}|\d{17,17}[x,X])$/');
        $cod_cust_id= $this->add(array("cod_cust_id_type"=>'1',
                                        "cod_cust_id_no"=>$cno,
                                        "nam_cust_real"=>I('post.nam_cust_real'),
                                        "dat_cust_birthday"=>$data['dat_cust_birthday'],
										"cod_cust_zip"=>$data['cod_cust_zip'],
										"cod_cust_gender"=>$data['cod_cust_gender'],
                                        "password"=>base64_encode(I('post.password')),//64位加密
                                        //"crm_file"=>(I('post.crm_file')),
                                        "dat_modify"=>date('Y-m-d H:i:s'),
                                        "usr_modify"=>session('user_info.id'),
                                        "add_time"=>date('Y-m-d H:i:s'),
                                        "add_usr"=>session('user_info.id'),
                                        "tel"=>I("post.tel/s",0)));
        if(!$cod_cust_id)return false;
        $r=D('CustCrm')->crmadd($cod_cust_id,$data);
        return $cod_cust_id;
    }
	/**
	*更新维护信息
	*/
	public function custmodify($uid){
		$this->where(array('cod_cust_id'=>$uid))->save(array(
                                        "dat_modify"=>date('Y-m-d H:i:s'),
                                        "usr_modify"=>session('user_info.id')
										));
	}
	/**
	*获取当前登录用户的基本信息
	*/
	public function getcustinfo($uid){
		return $this->field('cod_cust_id,nam_cust_real,cod_cust_id_no,tel,add_time,dat_modify')->where("cod_cust_id = '%s'", [$uid])->find();
	}
	/**
	*获取查找用户列表
	*/
    public function getlist($where){
		$data=array();
		$data['total']=M('cust_person')
			->alias('t')
			->field('ou.realname as user_name,t.add_usr,t.cod_cust_id,t.nam_cust_real,t.cod_cust_id_no,t.tel,t.add_time,t.dat_modify,od.name as department_name')
			->join('__USER__ as ou on ou.id=t.add_usr','left')
			->join('__DEPARTMENT__ as od on od.id=ou.department_id','left')
			->where($where)
			->count();
		$data['items']=M('cust_person')
			->alias('t')
			->field('ou.realname as user_name,t.add_usr,t.cod_cust_id,t.nam_cust_real,t.cod_cust_id_no,t.tel,t.add_time,t.dat_modify,od.name as department_name')
			->join('__USER__ as ou on ou.id=t.add_usr','left')
			->join('__DEPARTMENT__ as od on od.id=ou.department_id','left')
			->where($where)
			->page(I('page',1),I('limit',10))->order('t.add_time DESC')->select();
	/*	foreach($data['items'] as $k=>$v){
			$data['items'][$k]['cod_cust_id_no']=do_codcustidno($data['items'][$k]['cod_cust_id_no']);
		}*/
		// $data['sql']=M()->_sql();
		return $data;
    }
	/**
	*用密码判断当前用户登录 2016-01-16(更改为base64加密方式lj)
	*/
	public function cust_logincheck($pass,$uid){
		// return $this->where("cod_cust_id = '%s' and password = '%s'", [$uid, md5($pass)])->find();//
        return $this->where("cod_cust_id = '%s' and password = '%s'", [$uid, base64_encode($pass)])->find();
	}
	/**
	*用户登录判断 2016-01-16(更改为base64加密方式lj)
	*/
    public function cust_login(){
        $post=$_POST;
        // return $this->where("cod_cust_id_no = '%s' and password = '%s'", [$post['cod_cust_id_no'], md5($post['password'])])->find();
         return $this->where("cod_cust_id_no = '%s' and password = '%s'", [$post['cod_cust_id_no'], 
            base64_encode($post['password'])])->find();
    }
    /**
     * 修改密码 2016-01-18 lj
     * @param password 新密码
     * @param $id 修改的客户id
     */
    public function modifyPwd($pwd,$id){
        $data['password']=$pwd;
        $result=M('cust_person')->where('cod_cust_id='.$id)->save($data);
        return $result;
    }
}