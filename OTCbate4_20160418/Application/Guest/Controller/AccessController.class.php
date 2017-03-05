<?php
namespace Guest\Controller;

use Think\Controller;

/**
 * 权限管理控制器
 * Class MessageController
 * @package Admin\Controller
 * @author xiaowen
 */
class AccessController extends GuestController
{
	public function __construct(){
        // parent::__construct();
		$user = session('user_info');
		if(empty($user)){
			if(IS_AJAX){
				$result = array('status'=>-1,'msg'=>'请登录');
				$this->ajaxReturn($result);
			}else{
				$this->redirect('Admin/common/login');
			}
		}
		$this->mid = $user['id'];
	}
	
    public function index()
    {

    }

    /**
     * 获取用户菜单节点
     */
    public function getUserNodeList()
    {
        $user_info = $this->getUserInfo();
        if ($user_info) {
            $role_info = D('Guest/User')->getUserRole($user_info['id']);
            if ($role_info) {
                $node_list = D('Guest/User')->getRoleNodeList($role_info);
                //生成树形结构
                $node_list = GetTree($node_list, 0, 'node_id', 'pid');
                $this->printJson($node_list);
            }
            $this->setError('当前用户未分配角色');
        }
        $this->setError('无法获取登陆用户信息');
    }

    /**
     * 获取用户操作权限
     */
    public function getUserPermissionList()
    {
        //$user_info = $this->getUserInfo();
        if ($this->mid) {
            $role_info = D('Guest/User')->getUserRole($this->mid);
            //print_r($role_info);
            if ($role_info) {
                $node_list = D('Guest/User')->getRolePermissionList($role_info);
                $this->printJson($node_list);
            }
        }
        $this->setError('无法获取登陆用户信息');
    }

    /**
     * 检查用户是否拥有该权限
     */
    public function checkPermission($permission_code="")
    {
        $permission_code = $permission_code?$permission_code:I('post.permission_code');
        if ($permission_code) {
			
            $permission_all = $this->getUserPermissionAll(); 
			// print_r($permission_all);
            if ($permission_all) {
                $codeArr = array();
                foreach ($permission_all as $k => $v) {
                    $codeArr[] = $v['permission_code'];
                }
                $status = in_array($permission_code, $codeArr) ? true : false;
                if ($status) {
					return true;
                    // $this->setSuccess('权限验证通过');
                } else {
                    // $this->setError('没有此操作权限');
                }
            }
        }
		
		return false;
        // $this->setError('参数有误');
    }

    /**
     * 获取用户桌面操作节点（暂取一级菜单节点）
     */
    public function getUserDesktopList()
    {
        $user_info = $this->getUserInfo();
        if ($user_info) {
            $role_info = D('Guest/User')->getUserRole($user_info['id']);
            if ($role_info) {
                $node_list = D('Guest/User')->getRoleNodeList($role_info, 1);
                $this->printJson($node_list);
            }
        }
        $this->setError('无法获取登陆用户信息');
    }

    /**
     * 保存权限（添加或修改）
     * @return bool
     */
    public function savePermission()
    {
        $data = I('post.');
        $model = D('AuthPermission');
        if (!$model->create($data)) {
            $this->setError($model->getError());
        } else {
            if (isset($data['id']) && intval($data['id']) > 0) {
                $status = $model->save();
            } else {
                $status = $model->add();
            }
            if ($status > 0) {
                //保存成功 更新缓存文件
                $this->cachePermission();
                $this->setSuccess('操作成功');
            } else {
                $this->setError('操作失败');
            }
        }

    }

    /**
     * 分配角色
     */
    public function setRole()
    {
        $uid = I('post.uid');
        $role_id = I('post.role_id');
//        $uid = 1;
//        $role_id = '1,3';
        if ($uid && $role_id) {
            $role_id = trim($role_id, ',');
            $role_id_arr = explode(',', $role_id);
            $status = true;
            foreach($role_id_arr as $k=>$rid){
                $data = array(
                    'uid' => $uid,
                    'role_id' => $rid,
                );
                $info = M('AuthAccess')->where($data)->find();
                if(empty($info)){
                    $status = M('AuthAccess')->add($data);
                }
            }
            if($status) {
                $this->setSuccess('操作成功');
            } else {
                $this->setError('操作失败');
            }
        }
        $this->setError('参数有误');
    }
    /**
     * 删除用户已有角色
     */
    public function delRole()
    {
        $uid = I('post.uid');
        $role_id = I('post.role_id');
        if ($uid && $role_id) {
            $role_id = trim($role_id, ',');
            $role_id_arr = explode(',', $role_id);
            $where = array(
                'uid' => $uid,
                'role_id' => array('in', $role_id_arr),
            );
            //将用户帐号状态更改为启用
            //M('Guest/User')->where('id = ' . $uid)->save(array('status'=>1));
            $info = M('AuthAccess')->where($where)->find();
            if(!empty($info)){
                $status = M('AuthAccess')->where($where)->delete();
                if ($status) {
                    $this->setSuccess('操作成功');
                } else {
                    $this->setError('操作失败');
                }
            }else{
                $this->setError('该用户没有此角色，无法删除');
            }
        }
        $this->setError('参数有误');
    }
    /**
     * 给角色分配节点
     */
    public function setRoleNode()
    {
        $node_id = I('post.node_id');
        $role_id = I('post.role_id');
        $node_id = explode(',', $node_id);
        if ($node_id && $role_id) {
            $data = array();
            if(is_array($node_id) && !empty($node_id)){
                foreach($node_id as $k=>$nid){
                    $data[] = array(
                        'node_id' => $nid,
                        'role_id' => $role_id,
                    );
                }
            }
            $where['role_id'] = intval($role_id);
            $where['node_id'] = array('in', $node_id);
            //删除该角色已经包含的节点，再插入新节点数据
            M('AuthRoleNode')->where($where)->delete();
            $status = M('AuthRoleNode')->addAll($data);
            if ($status) {
                $this->setSuccess('操作成功');
            } else {
                $this->setError('操作失败');
            }
        }
        $this->setError('参数有误');
    }
    /**
     * 给指定角色删除权限
     */
    public function delRoleNode()
    {
        $node_id = I('post.node_id');
        $role_id = I('post.role_id');
        $node_id_arr = explode(',', $node_id);
        if(!$role_id){
            $this->setError('请指定角色');

        }else if(!$node_id){
            $this->setError('未指定节点');

        }else if($node_id_arr && $role_id){
            //$data = array();
            $where['role_id'] = $role_id;
            $where['node_id'] = array('in', $node_id_arr);
            $status = M('AuthRoleNode')->where($where)->delete();
            //$status = M('AuthRolePermission')->addAll($data);
            if ($status) {
                $this->setSuccess('操作成功');
            } else {
                $this->setError('操作失败');
            }
        }else{
            $this->setError('参数有误');
        }
    }
    /**
     * 给指定角色删除权限
     */
    public function delRolePermission()
    {
        $permission_id = I('post.permission_id');
        $role_id = I('post.role_id');
        $permission_arr = explode(',', $permission_id);

        if(!$role_id){
            $this->setError('请指定角色');

        }else if(!$permission_id){
            $this->setError('未指定权限列表');

        }else if($permission_id && $role_id){
            $where['role_id'] = $role_id;
            $where['permission_id'] = array('in', $permission_arr);
            $status = M('AuthRolePermission')->where($where)->delete();
            if ($status) {
                $this->setSuccess('操作成功');
            } else {
                $this->setError('操作失败');
            }
        }else{
            $this->setError('参数有误');
        }
    }
    /**
     * 给角色分配操作权限
     */
    public function setRolePermission()
    {
        $permission_id = I('post.permission_id');
        $role_id = I('post.role_id');
        $permission_id = explode(',', $permission_id);
        if ($permission_id && $role_id) {
            if(is_array($permission_id) && !empty($permission_id)){
                foreach($permission_id as $k=>$id){
                    $data[] = array(
                        'permission_id' => $id,
                        'role_id' => $role_id,
                    );
                }
            }
            //删除此角色老的权限数据，再插入新的权限数据
            $where['role_id'] =  intval($role_id);
            $where['permission_id'] =  array('in', $permission_id);
            M('AuthRolePermission')->where($where)->delete();
            $status = M('AuthRolePermission')->addAll($data);
            if ($status) {
                $this->setSuccess('操作成功');
            } else {
                $this->setError('操作失败');
            }
        }
        $this->setError('参数有误');
    }

    /**
     * 获取节点数据
     * @return boolean
     */
    public function getNodeData()
    {
        $data = $this->getCacheFile('admin_node');
        if (!$data) {
            $data = M('AuthNode')->where('status = 1')->select();
        }
        return $data;
    }

    /**
     * 缓存节点数据
     * @return boolean
     */
    public function cacheNode()
    {
        $data = M('AuthNode')->where('status = 1')->select();
        return $this->setCacheFile('admin_node', $data);
    }

    /**
     * 缓存权限节点数据
     * @return boolean
     */
    public function cachePermission()
    {
        $data = M('AuthPermission')->where('status = 1')->select();
        return $this->setCacheFile('admin_auth_Permission', $data);
    }

    /**
     * 获取用户所有操作权限
     */
    protected function getUserPermissionAll()
    {
        $data = array(); 
        if ($this->mid) {
            $role_info = D('Guest/User')->getUserRole($this->mid);
            if ($role_info) {
                $data = D('Guest/User')->getRolePermissionList($role_info);
                return $data;
            }
        }
        return $data;
    }
	
}