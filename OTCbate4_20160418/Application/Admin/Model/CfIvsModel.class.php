<?php
namespace Admin\Model;
use Think\Log;
use Think\Model;
class CfIvsModel extends Model
{
    public function doInvest($data, $cod_cust_id, $mid,$amt_ivs)
    {
        while (true) {
            //判断用户密码是否正确
            if (!(D('Guest/cust_person')->cust_logincheck('123456', $cod_cust_id))) {
                $result = array('status' => 0, 'msg' => '密码错误');
                break;
            }
            //判断盒子是否存在
            $data['cf_ctl_id']=$data['id'];
            $data['id'] = intval($data['cf_mast_id']);
            $map = array('a.cod_is_delete' => 0, 'a.id' => $data['cf_mast_id']);
            $mast_list = M('cf_mast')->alias("a")->field("a.*,b.otc_code,b.investment_type")->join("__CAPITALPOOL__ b on a.capitalid = b.id")->where($map)->find();

            if (empty($mast_list)) {
                $result = array('status' => 0, 'msg' => '产品不存在或已被删除');
                break;
            }

            //债权转让方式购买
            if ($data['investment_type'] == '1' || $data['investment_type'] == '2') {
                //金额必须存在且为数字
                if (empty($amt_ivs) || !is_numeric($amt_ivs)) {
                    $result = array('status' => 0, 'msg' => '金额必须为数字');
                    break;
                }

                $min_tzje = $mast_list['amt_cf_inv_min'];
                $data['ctl_ivs_cnt'] = 1;  //份数为1
                $data['amt_int_total'] = $amt_ivs;
                $data['amt_fee_total'] = $amt_ivs;
                // }else if($mast_list['cod_cf_inv_type'] == '2'){
                //收益权转让方式购买
                //份数必须存在且为数字
            } else {
                $result = array('status' => 0, 'msg' => '请填写正确的投资类型');
                break;
            }
            //判断是否为可投资时间
            $now = time();
            //验证投资的期数ID
            $data['cf_ctl_id'] = intval($data['cf_ctl_id']);
            $res = D('CfCtl')->checkCfCtl($data['cf_mast_id'], $data['cf_ctl_id'], $data['investment_type'], $data['amt_int_total'], $min_tzje);
            if (!$res['status']) {
                $result = $res;
                break;
            }
            //期号
            $cod_period = $res['data']['cod_period'];
            if ($cod_period < 10) {
                $cod_period = '00' . $cod_period;
            } else if ($cod_period < 100) {
                $cod_period = '0' . $cod_period;
            }
            //创建投资记录（只占用额度,cod_ivs_status=0）
            $cf_ivs_data = array(
                'cod_cf_id' => $data['cf_mast_id'],
                'cod_ctl_id' => $data['cf_ctl_id'],
                'cod_cust_id' => $cod_cust_id,
                'ivs_order' => str_pad($cod_cust_id, 6, '0', STR_PAD_LEFT) . date('YmdHis') . mt_rand(100000, 999999),
                'capitalid' => $data['capitalid'],
                'amt_ivs' => $amt_ivs,
                'amt_time' => $mast_list['amt_time'],
                'ctl_ivs_cnt' => $data['ctl_ivs_cnt'],
                'amt_int_total' => $data['amt_int_total'],
                'amt_fee_total' => $data['amt_fee_total'],
                'product_code' => $mast_list['otc_code'] . "A" . $cod_period,   //待确认
                'rat_cf_inv_min' => $mast_list['rat_cf_inv_min'],
                'cod_ivs_type' => $data['investment_type'],
                'cod_ivs_status' => 0,
                'operating' => 2,
                'dat_create' => date("Y-m-d H:i:s", time()),
                'usr_create' => $mid,
                'dat_modify' => date("Y-m-d H:i:s", time()),
                'usr_modify' => $mid,
            );
            $add_id = $this->add($cf_ivs_data);
            $result = array('status' => 1, 'msg' => '申购成功', 'id' => $add_id);
            break;
        }
        return $result;
    }


//确认投资
    // @param  $pos_order   POS单号
    // @param  $cf_ivs_id  投资记录ID
    // @param  $mid   业务员ID
    public function finishInvest($pos_order,$cf_ivs_id,$mid,$Trans = true){
        $sales='系统回购';
        $map['a.id'] = $cf_ivs_id;
        $map['a.cod_ivs_status'] = 0;
        if(empty($pos_order)){
            $result = array('status'=>0,'msg'=>'pos单号必填');
            return $result;
        }
        if(empty($sales)){
            $result = array('status'=>0,'msg'=>'销售经理必填');
            return $result;
        }
        
        $cf_ivs_list = $this->field('a.*,b.investment_type')->alias('a')->join("__CAPITALPOOL__ b on a.capitalid = b.id")->where($map)->find();//,b.capitalid
        // dump($cf_ivs_list);
        if(!empty($cf_ivs_list)){
            $map = array('id'=>$cf_ivs_list['id']);
            $this->where($map)->save(array(
                'pos_order'=>$pos_order,
                'sales'=>$sales,
            ));
                //更改投资记录状态为1
                $map = array('id'=>$cf_ivs_list['id']);
                $this->where($map)->save(array(
                    'cod_ivs_status'=>1,
                    'pos_order'=>$pos_order,
                ));

                //根据申购额度 来匹配债权
                $res = D('cl_ctl')->getClCtl($cf_ivs_list['investment_type'],$cf_ivs_list['amt_int_total'],$cf_ivs_list['capitalid'],$Trans);

                if(!$res['status']){
                    $result = $res;
                    $this->where($map)->save(array(
                        'cod_ivs_status'=>0,
                    ));
                }else{
                    foreach($res['data'] as $v){
                        //更新债权进度表
                       // M('cl_ctl')->where($map)->save($data);
                        //插入债权投资记录表
                        $data = array(
                            'cod_cf_id'=>$cf_ivs_list['cod_cf_id'],
                            'cod_cl_id'=>$v['cod_cl_id'],
                            'cod_cl_ctl_id'=>$v['id'],
                            'cod_cust_id'=>$cf_ivs_list['cod_cust_id'],
                            'cod_cf_ctl_id'=>$cf_ivs_list['cod_ctl_id'],
                            'cod_cf_ivs_id'=>$cf_ivs_list['id'],
                            'capitalid'=>$cf_ivs_list['capitalid'],
                            'investment_type'=>$cf_ivs_list['investment_type'],
                            'amt_ivs'=>$v['amt_ct_use'],
                            'rat_cf_inv_min'=>$cf_ivs_list['rat_cf_inv_min'],
                            'cod_ivs_status'=>1,
							'operating' => 2,
                            'dat_create'=>date("Y-m-d H:i:s",time()),
                            'usr_create'=>$mid,
                            'dat_modify'=>date("Y-m-d H:i:s",time()),
                            'usr_modify'=>$mid,
                        );

                        M('cl_ivs')->add($data);

                        //更新债权主表的债权状态   flag 0 全额占用  1 非全额占用
                        $map = array('id'=>$v['cod_cl_id']);
                        if($v['flag']){
                            $data = array('status'=>5);
                        }else{
                            $data = array('status'=>6);
                        }
                        M('cl_mast')->where($map)->save($data);

                    }

                    $result = array('status'=>1,'msg'=>'确认购买成功');
                    $map['id'] = $cf_ivs_id;
                    $this->where($map)->save(array(
                        'dat_modify'=>date("Y-m-d H:i:s",time()),
                        'usr_modify'=>$mid,
                    ));
                }

        }else{
            $result = array('status'=>0,'msg'=>'数据不存在或已被操作过');
        }
        return $result;
    }
}