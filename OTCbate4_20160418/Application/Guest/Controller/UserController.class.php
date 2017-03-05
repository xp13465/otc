<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 用户管理控制器
 * Class UserController
 * @package Admin\Controller
 */
class UserController extends AdminController {


    /**
    *用户修改密码
    */
    public function updateSelfPassword(){
        
      $old_password = I('post.old_password');//旧密码
      $new_password = I('post.new_password');//新密码
      $new_passwordc= I('post.new_passwordc');//确认密码
      if($old_password && $new_password && $new_passwordc){
        if($new_password !== $new_passwordc){
            $this->setError('两次输入的密码不一致，请重新输入！');
         }
          $user_info = $this->getUserInfo();
          $roldpwd=M('user')->getFieldById($this->uid,'password');
          if($roldpwd==md5($old_password))
         {
            $data['id'] = $this->uid;
            $data['password'] = md5($new_password);
            $data['update_time'] = date('Y-m-d H:i:s');
            $status = D('User')->save($data);
            if($status!==false){
                $user_info['password']=md5($new_password);
              //密码修改成功后，发送提示信息
              $this->sendUserMessage('密码修改成功', '亲爱的用户，您好！你的密码已经修改为:' . $new_password . ', 请您牢记新密码。', $user_info['email']);
              //生成操作日志
              $content = '用户：'.$user_info['realname'].' 部门：' . $this->getDpName() . ' , 修改登陆密码。';
              $this->createOperationLog($content);
              $this->setSuccess('密码修改成功');
            }else{
              $this->setError('密码修改失败');
            }
          }else {
            $this->setError('原密码不正确');
          }
      }
      $this->setError('参数有误');
    }


}
