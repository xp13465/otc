<?php
namespace Admin\Model;
use Think\Log;
use Think\Model;
class CfCtlModel extends Model
{
    public function checkCfCtl($cf_mast_id, $cf_ctl_id, $type, $amt, $min_tzje)
    {
        //获取该期的数据
        $map = array('id' => $cf_ctl_id, 'cf_mast_id' => $cf_mast_id);//2种模式统一用一个期
        $list = $this->where($map)->order("cod_period")->find();
        // print_r($amt);
        // exit;
        if (empty($list)) {
            $result = array('status' => 0, 'msg' => '数据错误！');
        } else {
            //验证该期是否可投资
                if ($list['amt_ct_last'] >= $amt) {
                    //剩余可投资份数大于0 可投资
                    //更新期数数据
                    $data = array(
                        'amt_ct_last' => array('exp', "amt_ct_last - {$amt}"),
                    );
                    $status = $this->where(array('id' => $list['id'], "amt_ct_last" => array("EGT", $amt)))->save($data);
                    if (!$status) {
						echo  $this->getLastSql();
                        $result = array('status' => 0, 'msg' => '购买失败，请刷新页面');
                    }else{
                        $result = array('status'=>1,'msg'=>'OK','data'=>$list);
                    }
                } else {
                    $result = array('status' => 0, 'msg' => '当期剩余金额不足，请重新再试');
                }

        }

        return $result;
    }
}