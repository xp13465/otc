<?php
namespace Admin\Model;

use Think\Log;
use Think\Model;

class CustCrmModel extends Model
{
    protected $_validate = array(
        array('cod_cust_id', 'require', '����дcod_cust_id')
    );
    protected $_auto = array(
        array('dat_modify', 'date', 3, 'function', 'Y-m-d H:i:s'),
    );
    public function crmadd($cod_cust_id,$cod_cust_id_no){
        return $this->add(array("cod_cust_id"=>$cod_cust_id));
    }
    public function getcrm($uid){
        return $this->where(array('cod_cust_id'=>$uid))->find();
    }
}