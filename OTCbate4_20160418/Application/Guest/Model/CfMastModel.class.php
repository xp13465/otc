<?php
namespace Guest\Model;

use Think\Log;
use Think\Model;

class CfMastModel extends Model
{
	public $error="";
		// );
	

/**
 * 未完成的产品列表
 */
public function getUnfinishProduct(){

  
}


	//投资产品管理列表
	//  1 待审核 2待发布 3审核失败  4待销售 5 销售中 6已售罄
    public function getlist($where){
      // $data['total']=$this->field('*')->where($where)->count();
      $data['items'] = M('cf_mast')->field('otc_cf_mast.*,count(otc_cl_ivs.cod_cf_id) as allp,sum(otc_cl_ivs.amt_ivs) as allm')
      ->join("otc_cl_ivs on otc_cf_mast.id=otc_cl_ivs.cod_cf_id")
      ->where($where)
      ->group('otc_cf_mast.id')
      ->page(I('page',1),I('limit',10))->select();
      foreach ($data['items'] as $key => $value) {
      	$data['items'][$key]['amt_ct']-=$data['items'][$key]['allm'];
      }
      $data['total']=count($data['items']);
      return $data;
    }

    //获取具体的投资管理进度
//    public function pschedule($id){
//    	$data=M('cf_mast_audit_log')->field('*')->where('cf_id='.$id)->select();
//    	return $data;
//    }

    /*
     * 获取某一条产品投资记录得详情-lj
     */
    public  function getThisDetail($where){
        $data['items']=M('cf_ivs')
                        ->alias('a')
                        ->field("a.*,b.nam_cust_real,b.cod_cust_id_no")
                        ->join('__CUST_PERSON__ b on a.cod_cust_id=b.cod_cust_id')
                        ->where($where)
//                        ->page($curpage,$limit)
                        ->find();
        $data['total']=count($data['items']);
        return $data;
    }
    /**
     * 具体某期的投资记录
     */
    public function getThisList($where){
      $data['items']=M('cf_ivs')
                    ->alias('a')
                    ->field('a.cod_cust_id,a.amt_ivs,a.ctl_ivs_cnt,a.amt_int_total,a.amt_fee_total,b.nam_cust_real,a.dat_create')
                    ->join('__CUST_PERSON__ b on b.cod_cust_id=a.cod_cust_id','left')
                    ->where($where)
                    ->page(I('post.page',1),I('post.limit',10))
                    ->select();
        foreach($data['items'] as $k=>$v){
             $data['items'][$k]['nam_cust_real']=do_codcutname($v['nam_cust_real']);
        }
      $data['total']=count($data['items']);
      return $data;

    }
   
}