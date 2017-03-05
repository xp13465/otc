<?php
namespace Guest\Model;

use Think\Log;
use Think\Model;

class UserModel extends Model
{
    protected $_validate = array(
        array('email', 'email', '邮箱格式错误'),
        array('email', '', '邮箱地址已被占用', 2, 'unique', 3),
        array('password', 'require', '请填写密码'),
        //array('password', 5,'密码长度必须大于5位', 'length', 3),
        array('realname', 'require', '请填写姓名'),
        array('department_id', 'number', '请填选择部门'),
        array('position_id', 'number', '请填选择职位'),
        //array('leader_id','number','请填选择分管领导'),
    );
    protected $_auto = array(
        array('add_time', 'date', 1, 'function', 'Y-m-d H:i:s'),
        array('update_time', 'date', 2, 'function', 'Y-m-d H:i:s'),
        array('password', 'md5', 3, 'function'),

    );

    public function checkLogin($post)
    {
        return $this->where("email = '%s' and password = '%s' and status = 1", [$post['email'], md5($post['password'])])->find();
    }

    /**
     * 获取用户信息
     * @param $email
     * @return array $info
     */
    public function getUserInfo($email)
    {
        if ($email) {
            $where['email'] = trim($email);
            $info = $this->where($where)->find();
            return $info;
        }
        return false;
    }

    /**
     * 获取用户角色
     * @param $uid
     * @return array $RoleIds
     */
    public function getUserRole($uid)
    {

        $roles = M('AuthAccess')->field('role_id')->where('uid = ' . intval($uid))->select();
        if ($roles) {
            foreach ($roles as $k => $role) {
                $RoleIds[] = $role['role_id'];
            }
            return $RoleIds;
        }
        return false;
    }

    /**
     * 获取角色节点
     * @param $role
     * @param $level
     * @return array $data
     */
    public function getRoleNodeList($role, $level = 0)
    {

        if (is_array($role) && !empty($role)) {
            $where['r.role_id'] = array('in', $role);

        } else if (intval($role)) {
            $where['r.role_id'] = $role;
        }
        if ($level == 1) {
            $where['n.pid'] = 0;
        }
		$where['n.type'] = 2;
        $data = M('AuthRoleNode')->field('DISTINCT r.node_id,n.name,n.pid,n.module,n.iconCls,n.group ,n.url'/*superone 加入url字段*/)
            ->table('__AUTH_ROLE_NODE__ as r')
            ->join('__AUTH_NODE__ as n on n.id = r.node_id')
            ->where($where)
            ->order('n.sort asc, n.id desc')
            ->select();
        //echo M('AuthRoleNode')->getLastSql();
        return $data;
    }

    /**
     * 获取角色权限列表
     * @param $role
     * @return array $data
     */
    public function getRolePermissionList($role,$field="permission_code")
    {

        if (is_array($role) && !empty($role)) {
            $where['r.role_id'] = array('in', $role);
        } else if (intval($role)) {
            $where['r.role_id'] = $role;
        }
		
		$permission_codeStr="n.`{$field}`";
		if(C('URL_CASE_INSENSITIVE')== true){
			$permission_codeStr ="lower({$permission_codeStr}) as permission_code";
		}
        $data = M('AuthRolePermission')->field('DISTINCT r.permission_id,n.permission_name,'.$permission_codeStr)
            ->table('__AUTH_ROLE_PERMISSION__ as r')
            ->join('__AUTH_PERMISSION__ as n on n.permission_id = r.permission_id')
            ->where($where)
            ->select();
        // echo  M('AuthRolePermission')->getLastSql();
        return $data;
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
				if(C('URL_CASE_INSENSITIVE')== true){
					$permission_code =strtolower($permission_code);
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
     * 获取用户所有操作权限
     */
    protected function getUserPermissionAll()
    {
        $data = array();
		$user = session('user_info');		
        if ($user['id']) {
            $role_info = $this->getUserRole($user['id']);
            if ($role_info) {
                $data = $this->getRolePermissionList($role_info,"module-controller-action");
                return $data;
            }
        }
        return $data;
    }
}