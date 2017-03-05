<?php
namespace Guest\Model;

use Think\Log;
use Think\Model;

class CfIvsModel extends Model
{

	static $cl_mast_status=array(
		 '1'=>'待审核',
		 '2'=>'待发布' ,
		 '3'=>'审核失败',
		 '4'=>'待销售',
		 '5'=>'销售中',
		 '6'=>'已售罄'
		);
	static $cl_dat_modify=array(
			"1"=>'1周内',
			"2"=>'一个月内',
			"3"=>'三个月内',
			"4"=>'三个月以上'
		);


/**
     * 确权列表搜索录入期限选项值
     */
	static $createdate_select = array(
			'0'=>'不限',
			'1'=>'一周内',
			'2'=>'一个月内',
			'3'=>'三个月内',
			'4'=>'三个月以上',
	); 
	/**
     * 确权列表搜索录入期限选项对应时间值
     */
	static $createdate_value = array(
			'0'=>'',
			'1'=>'-1 week',
			'2'=>'-1 month',
			'3'=>'-3 month',
			'4'=>'-3 month',
	); 
	/**
     * 确权列表搜索状态选项值
     */
	static $status_select = array(
			'1'=>'待审核',
			'2'=>'待发布',
			'3'=>'审核失败',
			'4'=>'待销售',
			'5'=>'销售中',
			'6'=>'已售罄',
	);

		/**
	 * 对应债权清单->投资记录 发布时间
	 */
	static $investlist_value = array(
			'0'=>'不限',
			'1'=>'1周内',
			'2'=>'1个月内',
			'3'=>'3个月内',
			'4'=>'3个月以上',
	); 


	// 投资操作
	// @param  $data post的数据  id【盒子ID】 type【投资方式1债权转让2收益权转让】 amt_ivs【投资金额(债权转让)】 ctl_ivs_cnt【投资份数（收益权转让方式）】 cf_ctl_id【期数ID】  password【用户密码】
	// @param  $cod_cust_id  客户uid   
	// @param  $mid   业务员ID
	public function doInvest($data,$cod_cust_id,$mid){
		
		while(true){
			//判断用户密码是否正确
            if(!(D('cust_person')->cust_logincheck($data['password'],$cod_cust_id))){
				$result = array('status'=>0,'msg'=>'密码错误');
				break;
			}

			//判断盒子是否存在
			$data['id'] = intval($data['id']);
			$map = array('a.cod_cf_status'=>1,'a.cod_is_delete'=>0,'a.id'=>$data['id']);
			$mast_list = M('cf_mast')->alias("a")->field("a.*,b.otc_code,b.investment_type")->join("__CAPITALPOOL__ b on a.capitalid = b.id","inner")->where($map)->find();
			if(empty($mast_list)){
				$result = array('status'=>0,'msg'=>'产品不存在或已被删除');
				break;
			}
			// if($mast_list['cod_cf_inv_type']!=$data['type']){
				// $result = array('status'=>0,'msg'=>'投资模式错误');
				// break;
			// }
			// print_r($mast_list);
			// exit;
			//债权转让方式购买
			if($mast_list['investment_type'] == '1'||$mast_list['investment_type'] == '2'){
				//金额必须存在且为数字
				if(empty($data['amt_ivs']) || !is_numeric($data['amt_ivs'])){
					$result = array('status'=>0,'msg'=>'金额必须为数字');
					break;
				}
				
				//判断此金额是否可投资该盒子
				if($mast_list['amt_cf_inv_min']>0 && $data['amt_ivs']<$mast_list['amt_cf_inv_min']){
					$result = array('status'=>0,'msg'=>'该产品最低投资金额为'.$mast_list['amt_cf_inv_min']);
					break;
				}
				if($mast_list['amt_cf_inv_max']>0 && $data['amt_ivs']>$mast_list['amt_cf_inv_max']){
					$result = array('status'=>0,'msg'=>'该产品最大投资金额为'.$mast_list['amt_cf_inv_max']);
					break;
				}
				$min_tzje=$mast_list['amt_cf_inv_min'];
				$data['ctl_ivs_cnt'] = 1;  //份数为1
				$data['amt_int_total'] = $data['amt_ivs'];
				$data['amt_fee_total'] = $data['amt_ivs'];
			// }else if($mast_list['cod_cf_inv_type'] == '2'){
				//收益权转让方式购买
				//份数必须存在且为数字
				/*
				if(empty($data['ctl_ivs_cnt']) || !is_numeric($data['ctl_ivs_cnt'])){
					$result = array('status'=>0,'msg'=>'投资份数必须为数字');
					break;
				}
				//判断此份数是否可投资该盒子
				if($mast_list['amt_ct_min']>0 && $data['ctl_ivs_cnt']<$mast_list['amt_ct_min']){
					$result = array('status'=>0,'msg'=>'该产品最低投资份数为'.$mast_list['amt_ct_min']);
					break;
				}
				if($mast_list['amt_ct_max']>0 && $data['ctl_ivs_cnt']>$mast_list['amt_ct_max']){
					$result = array('status'=>0,'msg'=>'该产品最大投资份数为'.$mast_list['amt_ct_max']);
					break;
				}
				$min_tzje=$mast_list['amt_ct_min']*$mast_list['amt_cf_inv_each'];
				$data['amt_ivs'] = $mast_list['amt_cf_inv_each']; //每份投资金额
				$data['amt_int_total'] = $mast_list['amt_cf_inv_each']*$data['ctl_ivs_cnt'];
				$data['amt_fee_total'] = $mast_list['amt_cf_inv_each']*$data['ctl_ivs_cnt'];
				*/
			}else{
				$result = array('status'=>0,'msg'=>'请填写正确的投资类型');
				break;
			}
			
			
			//判断是否为可投资时间
			$now = time();
			/* if($now<strtotime($mast_list['dat_cf_inv_begin'])){
				$result = array('status'=>0,'msg'=>'该产品还未到开始投资时间');
				break;
			}
			if($now>strtotime($mast_list['dat_cf_inv_end'])){
				$result = array('status'=>0,'msg'=>'该产品投资已结束');
				break;
			} */
			
			//验证投资的期数ID
			$data['cf_ctl_id'] = intval($data['cf_ctl_id']);
			$res = D('CfCtl')->checkCfCtl($mast_list['id'],$data['cf_ctl_id'],$mast_list['investment_type'],$data['amt_int_total'],$min_tzje);
			if(!$res['status']){
				$result = $res;
				break;
			}
			
			/* print_r($res);
			exit;
			$curr_amt_ct = M('Capitalpool')->where("id='{$mast_list['capitalid']}' and investment_type='{$mast_list['cod_cf_inv_type']}' ")->getField('surplus_amount');   //债权总额度

			//判断债权金额是否充足
			if($data['amt_int_total']>$curr_amt_ct){
				$result = array('status'=>0,'msg'=>'该产品剩余可投资资金为'.$curr_amt_ct);
				break;
			} */
			
			
			
			//期号
			$cod_period = $res['data']['cod_period'];
			if($cod_period<10){
				$cod_period='00'.$cod_period;
			}else if($cod_period<100){
				$cod_period='0'.$cod_period;
			}
			
			 //amt_ct   cod_cf_inv_type
			//占用金额
			// $status = M('Capitalpool')->where("investment_type='{$data['type']}' and surplus_amount >= '{$data['amt_int_total']}'")->setDec('surplus_amount',$data['amt_int_total']);
			// if($status){ 
				//创建投资记录（只占用额度,cod_ivs_status=0）
				$cf_ivs_data = array(
					'cod_cf_id'=>$mast_list['id'],
					'cod_ctl_id'=>$data['cf_ctl_id'],
					'cod_cust_id'=>$cod_cust_id,
					'ivs_order'=>str_pad($cod_cust_id,6, '0', STR_PAD_LEFT).date('YmdHis').mt_rand(100000, 999999),
					'capitalid'=>$mast_list['capitalid'],
					'amt_ivs'=>$data['amt_ivs'],
					'amt_time'=>$mast_list['amt_time'],
					'ctl_ivs_cnt'=>$data['ctl_ivs_cnt'],
					'amt_int_total'=>$data['amt_int_total'],
					'amt_fee_total'=>$data['amt_fee_total'],
					'product_code'=>$mast_list['otc_code']."A".$cod_period,   //待确认
					'rat_cf_inv_min'=>$mast_list['rat_cf_inv_min'],
					'cod_ivs_type'=>$mast_list['investment_type'],
					'cod_ivs_status'=>0,
					'dat_create'=>date("Y-m-d H:i:s",time()),
					'usr_create'=>$mid,
					'dat_modify'=>date("Y-m-d H:i:s",time()),
					'usr_modify'=>$mid,
				);

				$add_id = $this->add($cf_ivs_data); 
				$result = array('status'=>1,'msg'=>'申购成功','id'=>$add_id);
			// }else{
				// $result = array('status'=>0,'msg'=>'该产品剩余可投资额度不足');
			// }
			break;
		}
		return  $result;
	}
	
	//取消投资
	// @param  $cf_ivs_id  投资记录ID
	// @param  $mid   业务员ID
	public function cancelInvest($cf_ivs_id,$mid){
		$map['a.id'] = $cf_ivs_id;
		$map['a.cod_ivs_status'] = 0;
		$cf_ivs_list = $this->field('a.*')->alias('a')->join("__CF_MAST__ b on a.cod_cf_id = b.id")->where($map)->find();//,b.capitalid
		
		if(!empty($cf_ivs_list)){
			// print_r($cf_ivs_list);exit;
			//更改投资记录状态为-1
			$map = array('id'=>$cf_ivs_list['id'],'cod_ivs_status'=>0);
			$status = $this->where($map)->save(array(
				'cod_ivs_status'=>-1,
				'dat_modify'=>date("Y-m-d H:i:s",time()),
				'usr_modify'=>$mid,
			));
			
			//释放金额
			if($status){
				// $zjcmap = array('investment_type'=>$cf_ivs_list['cod_ivs_type'],'id'=>$cf_ivs_list['capitalid']);
				// M('Capitalpool')->where($zjcmap)->setInc('surplus_amount',$cf_ivs_list['amt_int_total']);
				$zjcmap = array('id'=>$cf_ivs_list['cod_ctl_id']);
				M('cf_ctl')->where($zjcmap)->setInc('amt_ct_last',$cf_ivs_list['amt_int_total']);
				$this->where($map)->save(array( 
					'dat_modify'=>date("Y-m-d H:i:s",time()),
					'usr_modify'=>$mid,
				));
				$result = array('status'=>1,'msg'=>'操作成功');
			}else{
				$this->where($map)->save(array( 
					'cod_ivs_status'=>0,
				));
				$result = array('status'=>0,'msg'=>'取消失败');
			}
			
		}else{
			$result = array('status'=>0,'msg'=>'数据不存在或已被操作过');
		}
		return $result;
	}
	//赎回交易投资
	// @param  $cf_ivs_id  投资记录ID
	// @param  $mid   业务员ID
	public function redemptionInvest($cf_ivs_id,$mid,$password){
		$map['a.id'] = $cf_ivs_id;
		$map['a.cod_ivs_status'] = 1;
		$cf_ivs_list = $this->field('a.*')->alias('a')->join("__CF_MAST__ b on a.cod_cf_id = b.id")->where($map)->find();//,b.capitalid
		// dump($cf_ivs_list);
		if(!$cf_ivs_list){
			$result = array('status'=>0,'msg'=>'数据不存在或已被操作过');
			return $result;
		}
		// echo $password;
		
		//判断用户密码是否正确
        if(!(D('cust_person')->cust_logincheck($password,$cf_ivs_list['cod_cust_id']))){
			$result = array('status'=>0,'msg'=>'密码错误');
			return $result;
		}
		
		$time = strtotime("+ {$cf_ivs_list['amt_time']} month -1 day",strtotime($cf_ivs_list['dat_modify']));
		
		if(time > strtotime(date("Y-m-d 23:59:59",$time))){
			$result = array('status'=>0,'msg'=>'已超过可赎回日期');
			return $result;
		}
		if($cf_ivs_list['operating']!=1){
			$result = array('status'=>0,'msg'=>'不可回购！');
			return $result;
		}
		 
		// exit;$
		$redemption_sales=I('post.redemption_sales');
		$redemption_order=I('post.redemption_order'); 
		if(empty($redemption_order)){
			$result = array('status'=>0,'msg'=>'pos单号必填');
			return $result;
		}
		if(empty($redemption_sales)){
			$result = array('status'=>0,'msg'=>'销售经理必填');
			return $result;
		}
		$cf_ivs_oid=M('cf_ivs')->where("id != '{$cf_ivs_id}'")->getFieldByRedemption_order($redemption_order,'id');//查询是否已经存在pos单号
		// echo M('cf_ivs')->getLastSql();
		if($cf_ivs_oid){
			$result = array('status'=>0,'msg'=>'pos单号已被使用,请确认');
			return $result;
		}
		$cf_ivs_oid=M('cf_ivs')->getFieldByPos_order($redemption_order,'id');//查询是否已经存在pos单号
		// echo M('cf_ivs')->getLastSql();
		if($cf_ivs_oid){
			$result = array('status'=>0,'msg'=>'pos单号已被使用,请确认！');
			return $result;
		}
		
		if(!empty($cf_ivs_list)){
			$this->where(['id'=>$cf_ivs_list['id']])->save(array(
				'redemption_order'=>$redemption_order,
				'redemption_sales'=>$redemption_sales,
			));
			// echo $this->getLastSql();
			if(empty($cf_ivs_list['redemption_file']) || !file_exists(ROOT_PATH.$cf_ivs_list['redemption_file'])){
				$result = array('status'=>0,'msg'=>'缺少POS单扫描件');
				return $result;
			}
			// $result = array('status'=>0,'msg'=>'缺少POS单扫描件');
			// return $result;
			
			$cl_ivs_list = $this->field('b.*')->alias('a')->join("__CL_IVS__ b  on a.id = b.cod_cf_ivs_id")->where($map)->select();
			$clivs_redemption_ids = array();
			foreach($cl_ivs_list as $cl_ivs){
				$data = $cl_ivs;
				$data['cod_cl_ivs_id']=$cl_ivs['id'];
				$data['dat_modify']=date("Y-m-d H:i:s",time());
				$data['dat_create']=date("Y-m-d H:i:s",time()); 
				$data['usr_create']=$mid;
				$data['usr_modify']=$mid;
				unset($data['id']); 
				$clivs_redemption_ids[] =M("cl_ivs_redemption")->add($data);
			}
			//回购债券记录生成数量对等
			if(count($clivs_redemption_ids)>0 && count($clivs_redemption_ids)==count($cl_ivs_list)){
				$cl_save_count = M("cl_ivs")->where(['cod_cf_ivs_id'=>$cf_ivs_list['id'],'cod_ivs_status'=>'1'])->save(["cod_ivs_status"=>'2']);
				//回购更新条数对等
				if($cl_save_count == count($cl_ivs_list)){
					$data = $cf_ivs_list;
					$data['cod_cf_ivs_id']=$cf_ivs_list['id'];
					$data['ivs_order']="SH".$data['ivs_order'];
					$data['sales']=$redemption_sales;
					$data['pos_order']=$redemption_order;
					$data['pos_file']=$data['redemption_file'];
					$data['dat_modify']=date("Y-m-d H:i:s",time());
					$data['dat_create']=date("Y-m-d H:i:s",time()); 
					$data['usr_create']=$mid;
					$data['usr_modify']=$mid;
					unset($data['id']);
					$clivs_redemption_id = M("cf_ivs_redemption")->add($data);
					if($clivs_redemption_id){
						
						$cf_save_count = $this->where(['id'=>$cf_ivs_list['id'],'cod_ivs_status'=>'1'])->save(["cod_ivs_status"=>'2']);
						if($cf_save_count==1){
							 
							//恢复当期额度给其他客户购买 则恢复额度 
							$cpqmap = array('id'=>$cf_ivs_list['cod_ctl_id']);
							M('cf_ctl')->where($cpqmap)->setInc('amt_ct_last',$cf_ivs_list['amt_int_total']);
							$sql="update   otc_cf_ctl a  set a.ctr_ct_finish = floor((1-(amt_ct_last/amt_ct))*100) where id = {$cf_ivs_list['cod_ctl_id']} and ctr_ct_finish !=100";
							M('')->execute($sql);
							// 恢复债券额度
							$redemption_cl_ivs_list = M("cl_ivs_redemption")->where(["id"=>["IN",join(",",$clivs_redemption_ids)]])->select();
							foreach($redemption_cl_ivs_list as $cl_ivs){
								$zqqmap = array('id'=>$cl_ivs['cod_cl_ctl_id']);
								$data = array();
								$data['amt_ct_last'] =  array('exp','amt_ct_last + '.$cl_ivs['amt_ivs']); 
								$data['ctr_ct_finish'] = array('exp','((amt_ct - (amt_ct_last)) / amt_ct)*100'); 
								
								M('cl_ctl')->where($zqqmap)->save($data);
								$sql = "update otc_cl_mast a inner join  otc_cl_ctl b on a.id =b.cod_cl_id set a.status =(case b.ctr_ct_finish when 0 then 4 when 100 then 6 else 5 end ) where a.id ={$cl_ivs['cod_cl_id']}";
								M('')->execute($sql);
										
							} 
							
							// $this->where(['id'=>$cf_ivs_list['id']])->save(array( 
								// 'dat_modify'=>date("Y-m-d H:i:s",time()),
								// 'usr_modify'=>$mid,
							// ));
							$result = array('status'=>1,'msg'=>'赎回成功');
							
						}else{
							M("cf_ivs_redemption")->delete($clivs_redemption_id);
							//撤销赎回状态更新
							M("cl_ivs")->where(['cod_cf_ivs_id'=>$cf_ivs_list['id'],'cod_ivs_status'=>'2'])->save(["cod_ivs_status"=>'1']);
							//删除赎回记录
							M("cl_ivs_redemption")->delete(join(",",$clivs_redemption_ids));
							$result = array('status'=>0,'msg'=>'赎回失败');
							return $result;
						}
						
					}else{
						//撤销赎回状态更新
						M("cl_ivs")->where(['cod_cf_ivs_id'=>$cf_ivs_list['id'],'cod_ivs_status'=>'2'])->save(["cod_ivs_status"=>'1']);
						//删除赎回记录
						M("cl_ivs_redemption")->delete(join(",",$clivs_redemption_ids));
						$result = array('status'=>0,'msg'=>'赎回失败');
						return $result;
					}
					
					
				}else{
					//撤销赎回状态更新
					M("cl_ivs")->where(['cod_cf_ivs_id'=>$cf_ivs_list['id'],'cod_ivs_status'=>'2'])->save(["cod_ivs_status"=>'1']);
					//删除赎回记录
					M("cl_ivs_redemption")->delete(join(",",$clivs_redemption_ids));
					$result = array('status'=>0,'msg'=>'赎回失败');
					return $result;
				}
			}else{
				//删除赎回记录
				M("cl_ivs_redemption")->delete(join(",",$clivs_redemption_ids));
				$result = array('status'=>0,'msg'=>'赎回失败');
				return $result;
			}
			 
			
		}else{
			$result = array('status'=>0,'msg'=>'数据不存在或已被操作过');
		}
		return $result;
	}
	
	//确认投资
	// @param  $pos_order   POS单号
	// @param  $cf_ivs_id  投资记录ID
	// @param  $mid   业务员ID
	public function finishInvest($pos_order,$cf_ivs_id,$mid){
		$sales=I('post.sales');
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
		$cf_ivs_oid=M('cf_ivs')->where("id != '{$cf_ivs_id}'")->getFieldByPos_order($pos_order,'id');//查询是否已经存在pos单号
		// echo M('cf_ivs')->getLastSql();
		if($cf_ivs_oid){
			$result = array('status'=>0,'msg'=>'pos单号已被使用,请确认');
			return $result;
		}
		
		
		$cf_ivs_oid=M('cf_ivs')->getFieldByRedemption_order($pos_order,'id');//查询是否已经存在pos单号
		// echo M('cf_ivs')->getLastSql();
		if($cf_ivs_oid){
			$result = array('status'=>0,'msg'=>'pos单号已被使用,请确认!');
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
			
			
			
			if(!empty($cf_ivs_list['pos_file']) && file_exists(ROOT_PATH.$cf_ivs_list['pos_file'])){
				//更改投资记录状态为1
				$map = array('id'=>$cf_ivs_list['id']);
				$this->where($map)->save(array(
					'cod_ivs_status'=>1,
					'pos_order'=>$pos_order,
				));
				
				//根据申购额度 来匹配债权
				$res = D('cl_ctl')->getClCtl($cf_ivs_list['investment_type'],$cf_ivs_list['amt_int_total'],$cf_ivs_list['capitalid']);
				
				if(!$res['status']){
					$result = $res;
					$this->where($map)->save(array(
						'cod_ivs_status'=>0,
					));
				}else{
					foreach($res['data'] as $v){
						//更新债权进度表
						// $map = array('id'=>$v['id']);
						// $data = array(
							// 'amt_ct_last'=>$v['amt_ct_last'],
						// );
						
						// $data['ctr_ct_finish'] = floor((($v['amt_ct']-$v['amt_ct_last'])/$v['amt_ct'])*100);

						M('cl_ctl')->where($map)->save($data);
						
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
							'dat_create'=>date("Y-m-d H:i:s",time()),
							'usr_create'=>$mid,
							'dat_modify'=>date("Y-m-d H:i:s",time()),
							'usr_modify'=>$mid,
						);
						
						M('cl_ivs')->add($data);
						
						//更新债权主表的债权状态   flag 0 全额占用  1 非全额占用
						// $map = array('id'=>$v['cod_cl_id']);
						// if($v['flag']){
							// $data = array('status'=>5);
						// }else{
							// $data = array('status'=>6);
						// }
						M('cl_mast')->where($map)->save($data);
						$sql = "update otc_cl_mast a inner join  otc_cl_ctl b on a.id =b.cod_cl_id set a.status =(case b.ctr_ct_finish when 0 then 4 when 100 then 6 else 5 end ) where a.id ={$v['cod_cl_id']}";
						M('')->execute($sql);
						
							
					}
					
					$result = array('status'=>1,'msg'=>'确认购买成功');
					$map['id'] = $cf_ivs_id;
					$this->where($map)->save(array(
						'dat_modify'=>date("Y-m-d H:i:s",time()),
						'usr_modify'=>$mid,
					));
				}
		   }else{
			   $result = array('status'=>0,'msg'=>'缺少POS单扫描件');
		   }
		}else{
			$result = array('status'=>0,'msg'=>'数据不存在或已被操作过');
		}
		return $result;
	}
		
	public function getInvestContractData($ivsid){
		$where["a.id"]=$ivsid;
		$data = $this
		->alias("a")
		// group_concat(c.product_name) as z_product_name,group_concat(c.address) as z_address,group_concat(c.borrower) as z_borrower,group_concat(c.cod_card_type) as z_cod_card_type,group_concat(c.cod_card_no) as z_cod_card_no,group_concat(c.telephone) as z_telephone
		->field("g.*,
		concat(f.title,i.cod_period,'期') as periodname, f.formula,
		a.*,(c.startdate) as z_startdate,(c.enddate) as z_enddate,(c.period) as z_period,
		(c.amt_cf_inv_price) as z_amt_cf_inv_price,(c.product_name) as z_product_name,(c.address) as z_address,(c.borrower) as z_borrower,(c.cod_card_type) as z_cod_card_type,c.attr,(c.cod_card_no) as z_cod_card_no,(c.telephone) as z_telephone,
		c.needpay,c.account,c.accbank,c.accountno,c.amt_cf_inv_price,c.transdebt,c.startdate,c.enddate,c.use,d.nam_cust_real as k_nam_cust_real,d.cod_cust_id_type as k_cod_cust_id_type,d.cod_cust_id_no as k_cod_cust_id_no,e.address as k_address,d.tel as k_tel")
		
		->join("__CL_IVS__ b on a.id =b.cod_cf_ivs_id","inner")
		->join("__CF_MAST__ f on b.cod_cf_id =f.id","inner")
		->join("__CF_CTL__ i on b.cod_cf_ctl_id =i.id","inner")
		->join("__CL_MAST__ c on b.cod_cl_id =c.id","inner")
		->join("__CUST_PERSON__ d on d.cod_cust_id =a.cod_cust_id","inner")
		->join("__CUST_CRM__ e on e.cod_cust_id =a.cod_cust_id","inner")
		->join("__CAPITALPOOL__ g on a.capitalid =g.id","inner")
		->where($where)
		//->group("a.id")
		->select();

		foreach ($data as $key => $value) {
			// $data[$key]['leftmonth'] = 
			 $time = max(strtotime($value['startdate']),strtotime(date('Y-m-d')));

			 if(strtotime($value['enddate'])< strtotime(date('Y-m-d')))
			 	{
            		$data[$key]['leftmonth']=0;
		        }else{
		           $data[$key]['leftmonth'] = abs(date('Y',strtotime($value['enddate']))-
		                 date('Y',$time))*12+
		                (date('m',strtotime($value['enddate']))-date('m',$time));
		        }

		       // $data[$key]['totaltrans'] += $data[$key]['transdebt'];
		       // $data[$key]['totalneed'] += $data[$key]['needpay'];
			# code...
		}

		return $data;
	}
	/**
	*  还款计算公式
	*  param float $touzibenjin  投资本金
	*  param date  $touziriqi    投资日期
	*  param float $chanpinlilv  产品利率
	*  param int   $chanpinqishu  产品期数
	*/
	public function InterestCalculation($touzibenjin,$touziriqi,$chanpinlilv,$chanpinqishu,$gongshi="1"){
		/* //尊享年盈表格基础测试
		$touzibenjin='1000000';
		$touziriqi='2016-01-21';
		$chanpinlilv='13.50';
		$chanpinqishu='18';
		$gongshi='1';
		
		//年盈表格基础测试
		$touzibenjin='500000';
		$touziriqi='2015-12-08';
		$chanpinlilv='12.50';
		$chanpinqishu='12';
		$gongshi='1';
		
		//季盈表格基础测试
		$touzibenjin='100000';
		$touziriqi='2015-12-08';
		$chanpinlilv='7.50';
		$chanpinqishu='3';
		$gongshi='1';
		
		//年瑞/尊享年瑞表格基础测试
		$touzibenjin='100000';
		$touziriqi='2015-12-08';
		$chanpinlilv='11.50';
		$chanpinqishu='12';
		$gongshi='1';
		
		//年喜/尊享年喜表格基础测试
		$touzibenjin='100000';
		$touziriqi='2015-12-08';
		$chanpinlilv='9';
		$chanpinqishu='6';
		$gongshi='1';
		
		// 月满盈表格基础测试
		$touzibenjin='100000';
		$touziriqi='2015-04-01';
		$chanpinlilv='6';
		$chanpinqishu='1';
		$gongshi='3';
		
		// 月月盈表格基础测试
		$touzibenjin='100000';
		$touziriqi='2015-12-08';
		$chanpinlilv='10.8';
		$chanpinqishu='12';
		$gongshi='2'; */
		
		$daozhangriqi=date("Y-m-d",strtotime($touziriqi));//dat_modify出借日期
		
		// $daozhangriqi ='2015-04-16';
		$day = date("d",strtotime($daozhangriqi));
		
		$data=[]; 
		switch($gongshi){
			case 1://标准计算法   复利计算法  结算日为 15号 或30号（2月为最后天）
				$baogaoday=$day<=15?"15":"30";//每月出账单报告日
				$shangyuezongshouyi= 0;
				$changhuanbenjin = $touzibenjin/$chanpinqishu;
				$nianqishu =$chanpinqishu>12 ? 12 :$chanpinqishu;
				for($i=1;$i<=$chanpinqishu;$i++){
					$data[$i]["touzibenjin"]=number_format($touzibenjin,2,".","");
					$data[$i]["touziyuefen"]=$i;
					$data[$i]["zlilv"]=$chanpinlilv;
					$data[$i]['zhouqistartday'] = date("Y-m-d",strtotime("+ ".($i-1)." Months",strtotime($daozhangriqi)));
					$data[$i]['zhouqiendday'] = date("Y-m-d",strtotime("+ {$i} month -1 day",strtotime($daozhangriqi)));
					
					if($i>12&&$i%12==1){
						$nianqishu = ($chanpinqishu- $i +1)>12?12:$chanpinqishu- $i +1;
					}
					//全期总利率（最大12月）
					$quanqizongshouyilv = $chanpinlilv*($nianqishu/12);
					$data[$i]["quanqizongshouyilv"]=number_format($quanqizongshouyilv,2,".","");
					$endtime = strtotime(" + {$i} month",strtotime($daozhangriqi));//开 
					if($baogaoday == 30 && date("m",$endtime)==2){
						$data[$i]["baogaori"] = (date("Y-m-t",$endtime));
					}else{
						$data[$i]["baogaori"] = (date("Y-m-$baogaoday",$endtime));
					}

					//报告日
					$data[$i]['reportday'] = $baogaoday;
					//偿还本金
					$data[$i]["changhuanbenjin"]= number_format($changhuanbenjin,2,".","");
					//月利率
					$yuelilv = pow((($quanqizongshouyilv/100)+1),(1/$nianqishu))-1; 
					$yuelilv= $yuelilv*100; 
					$data[$i]["ylilv"]= number_format($yuelilv,4,".",""); 
					//到期本息合计
					$zhouqiyuestep = $i%12?$i%12:12;
					$benxiheji = ($touzibenjin*pow((1+($yuelilv/100)),$zhouqiyuestep));
					if($i>12){
						//新周期的本息合计累加上一周期最后的总收益
						$benxiheji = $benxiheji+$data[$i-$zhouqiyuestep]['zongshouyi'];
					}
					$data[$i]["benxiheji"]= number_format($benxiheji,2,".",""); 
					
					//总收益
					$zongshouyi = $benxiheji - $touzibenjin;
					$data[$i]["zongshouyi"]= number_format($zongshouyi,2,".",""); 
					//当月收益
					$dangyueshouyi = $zongshouyi -  $shangyuezongshouyi;
					$shangyuezongshouyi =  $zongshouyi;
					$data[$i]["dangyueshouyi"]= number_format($dangyueshouyi,2,".",""); 
					//当月应还金额
					$dangyueyinghuan = $changhuanbenjin + $dangyueshouyi;
					$data[$i]["dangyueyinghuan"] = number_format($dangyueyinghuan,2,".",""); 
					
				}
				break;
			case 2://月月盈计算法  每月等额利息（无复利） 固定下月一日派息 首月收益比例：（当月总天数-投资天数）/当月总天数  借款人应还款=偿还本金  累计收益字段暂无
				$baogaoday="30";//每月出账单报告日 
				$changhuanbenjin = $touzibenjin/$chanpinqishu;
				$zongshouyi = 0;
				$nianqishu =$chanpinqishu>12 ? 12 :$chanpinqishu;
				for($i=1;$i<=$chanpinqishu;$i++){
					$data[$i]["touzibenjin"]=number_format($touzibenjin,2,".","");
					$data[$i]["touziyuefen"]=$i;
					$data[$i]["zlilv"]=$chanpinlilv;
					$data[$i]['zhouqistartday'] = date("Y-m-01",strtotime("+ ".($i-1)." Months",strtotime($daozhangriqi)));
					$data[$i]['zhouqiendday'] = date("Y-m-t",strtotime("+ ".($i-1)." Months",strtotime($daozhangriqi)));
					
					if($i>12&&$i%12==1){
						$nianqishu = ($chanpinqishu- $i +1)>12?12:$chanpinqishu- $i +1;
					}
					$quanqizongshouyilv = $chanpinlilv*($nianqishu/12);
					$data[$i]["quanqizongshouyilv"]=number_format($quanqizongshouyilv,2,".","");
					$endtime = strtotime("+ ".($i-1)." month",strtotime($daozhangriqi));//开 
					if(date("m",$endtime)==2){
						$data[$i]["baogaori"] = (date("Y-m-t",$endtime));
					}else{
						$data[$i]["baogaori"] = (date("Y-m-$baogaoday",$endtime));
					}

					//报告日
					$data[$i]['reportday'] = $baogaoday;
					//偿还本金
					$data[$i]["changhuanbenjin"]= number_format($changhuanbenjin,2,".","");
					//月利率
					$yuelilv = $chanpinlilv/12; 
					$yuelilv= $yuelilv; 
					$data[$i]["ylilv"]= number_format($yuelilv,4,".",""); 
					//当月收益
					if($i==1){
						$startday = date("d",strtotime($daozhangriqi));
						$monthday = date("t",strtotime($daozhangriqi));
						$shijitian = $monthday - $startday + 1;
						$dangyueshouyi = $touzibenjin*$yuelilv/100; 
						$dangyueshouyi = $dangyueshouyi*$shijitian/$monthday;
						$data[$i]['zhouqistartday'] = date("Y-m-{$startday}",strtotime($daozhangriqi));
					}else{
						$dangyueshouyi = $touzibenjin*$yuelilv/100; 
						$data[$i]["dangyueshouyi"]= number_format($dangyueshouyi,2,".",""); 
					} 
					//最后个月补齐收益
					if($i==$chanpinqishu){
						$dangyueshouyi=$dangyueshouyi+($dangyueshouyi-$data[1]['dangyueshouyi']);
						$data[$i]['zhouqiendday'] = date("Y-m-d",strtotime("+ ".($i)." Months -1 day",strtotime($daozhangriqi)));
					}
					$data[$i]["dangyueshouyi"]= number_format($dangyueshouyi,2,".",""); 
					
					//总收益
					$zongshouyi = $zongshouyi + $dangyueshouyi;
					$data[$i]["zongshouyi"]= number_format($zongshouyi,2,".","");  
					//到期本息合计
					
					$benxiheji = $touzibenjin + $zongshouyi;
					$data[$i]["benxiheji"]= number_format($benxiheji,2,".","");  
				}
				break;
			case 3://月满盈计算法  固定一月利益 结算日为+1月（不考虑月天数） 
				$changhuanbenjin = $touzibenjin/$chanpinqishu;
				$zongshouyi = 0;
				$nianqishu =$chanpinqishu>12 ? 12 :$chanpinqishu;
				for($i=1;$i<=1;$i++){
					$data[$i]["touzibenjin"]=number_format($touzibenjin,2,".","");
					$data[$i]["touziyuefen"]=$i;
					$data[$i]["zlilv"]=$chanpinlilv;
					$data[$i]['zhouqistartday'] = date("Y-m-d",strtotime("+ ".($i-1)." Months",strtotime($daozhangriqi)));
					$data[$i]['zhouqiendday'] = date("Y-m-d",strtotime("+ {$i} month -1 day",strtotime($daozhangriqi)));
					
					if($i>12&&$i%12==1){
						$nianqishu = ($chanpinqishu- $i +1)>12?12:$chanpinqishu- $i +1;
					}
					$quanqizongshouyilv = $chanpinlilv*($nianqishu/12);
					$data[$i]["quanqizongshouyilv"]=number_format($quanqizongshouyilv,2,".","");
					$endtime = strtotime("+ ".($i-1)." month",strtotime($daozhangriqi));//开 
					
					$data[$i]["baogaori"] = "无";
					//报告日
					$data[$i]['reportday'] = "无";
					//偿还本金
					$data[$i]["changhuanbenjin"]= number_format($changhuanbenjin,2,".","");
					//月利率
					$yuelilv = $chanpinlilv/12; 
					$yuelilv= $yuelilv; 
					$data[$i]["ylilv"]= number_format($yuelilv,4,".",""); 
					//当月收益
					
					$dangyueshouyi = $touzibenjin*$yuelilv/100; 
					$data[$i]["dangyueshouyi"]= number_format($dangyueshouyi,2,".",""); 
					 
					
					//总收益
					$zongshouyi = $zongshouyi + $dangyueshouyi;
					$data[$i]["zongshouyi"]= number_format($zongshouyi,2,".","");  
					//到期本息合计
					$benxiheji = $touzibenjin + $zongshouyi; 
					$data[$i]["benxiheji"]= number_format($benxiheji,2,".","");  
				} 
				break;
		}
		
	    return $data;
		
	}


	
}



?>