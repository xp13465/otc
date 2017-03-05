<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends AdminController {
    public function index(){
        $this->assign('system_name', C('SYSTEM_NAME'));
        $this->display();
    }

}