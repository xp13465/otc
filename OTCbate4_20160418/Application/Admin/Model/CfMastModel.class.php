<?php
namespace Admin\Model;

use Think\Log;
use Think\Model;

class CfMastModel extends Model
{
	public $error="";
	public $rule="";
    protected $_validate = array(
        array('amt_cf_inv_min', 'require', '最小投资金额必填',1),
        array('amt_cf_inv_max', 'require', '最大投资金额必填',1),
        array('rat_cf_inv_min', 'require', '年化收益利率必填',1),
        // array('amt_cf_inv_each', 'require', '每份投资金额必填',1),
        // array('amt_ct_min', 'require', '最小投资份数必填',1),
        // array('amt_ct_max', 'require', '最大投资份数必填',1),
		array('each_amt','require','每期金额必填',1),
		//array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
		array('amt_cf_inv_min','insert_create','最小投资金额为必须20万以上的整万倍',1,'function'),
		array('amt_cf_inv_max','max_check','最大投资金额应不小于最小投资金额,且为一万的整数倍,零为无限',3,'callback',3,array("amt_cf_inv_min")),
		array('rat_cf_inv_min','currency','年化收益利率必须为数字',1),
		// array('amt_cf_inv_each', '1','每份投资金额必须为数字1',1,'equal'),
		// array('amt_ct_min','insert_create','最小投资份数为必须20万以上的整万倍',1,'function'),
		// array('amt_ct_max','max_check','最大投资份数应不小于最小投资份数,且为一万的的整数倍,零为无限',1,'callback',3,array("amt_ct_min")),
        array('title', 'require', '产品名称必填',1),
		array('each_amt','insert_create','每期金额为必须20万以上的整万倍',1,'function'),
    );
    protected $_auto = array(
        array('dat_modify', 'date', 3, 'function', 'Y-m-d H:i:s'),
    );
	/*字段验证callback*/
	protected function max_check($str,$min){
		if(!is_null($str)){
			if(is_float($str) || is_numeric($str)){
				if($str >= I('post.'.$min)){
					if($str%10000==0)
					{
						return true;
					}else{
						return false;
					}
				}elseif($str == 0){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}

	}
	/**
     * 债权列表搜索状态选项值
     */
	static $status_select = array(
		    '0'=>'未完成',
			'6'=>'待审核',
			'3'=>'审核退回',
			'4'=>'待发布',
			'1'=>'正常',
			'2'=>'暂停销售',
			'10'=>'发布退回',
	);
	/**最新债权状态-lj
	 * @var array
	 *
	 */
	static  $debt_status=array(
		0=>'未完成',
		1=>'待审核',
		7=>'待OTC审核',
		8=>'OTC审核中',
		9=>'OTC审核失败',
		2=>'待发布',
		3=>'审核退回',
		4=>'待销售',
		5=>'销售中',
		6=>'已售罄',
		10=>'发布退回',
	);


     /**
	  * 投资产品列表页 标的状态 bidstatus
	  * 0未完成 6待审核 （ 7OTC审核准备 8OTC审核中 9OTC审核失败）  3审核失败 4待发布 1正常 2暂停销售
	  */
	 static $bidstatus_select = array(
		 0=>'未完成',
		 1=>'正常',
		 2=>'暂停销售',
		 3=>'审核退回',
		 4=>'待发布',
		 6=>'待审核',
		 7=>'OTC审核准备',
		 8=>'OTC审核中',
		 9=>'OTC审核失败',
	 	);
	/**
	 * 对应债权清单 发布时间
	 */
	static $debt_value = array(
			'0'=>'不限',
			'1'=>'1周内',
			'2'=>'1个月内',
			'3'=>'3个月内',
			'4'=>'3个月以上',
	); 
	/*模式*/
	static $model_select = array(
		'1' => '债权转让基金1',
		'2' => '收益权转让基金1',
		'3' => '债权转让基金2',
		'4' => '收益权转让基金2'
	);
	
	/*投资状态*/
	static $ivs_status = array(
		'-1' => '已作废',
		'0' => '待确认',
		'1' => '已成交',
		'2' => '已赎回',
	);

	/**
	*添加投资产品(未完成投资产品)
	*/
    public function cfmast_add($data){
//		$data=I('post.');
	    $data['cod_cf_status']="0";
        $data['dat_create']=date('Y-m-d H:i:s');
        $data['usr_create']=session('user_info.id');
        $data['dat_modify']=date('Y-m-d H:i:s');
        $data['usr_modify']=session('user_info.id');
		return $this->add($data);

//		return M()->_sql();
    }

   /**
	* 提交投资产品
	*/
    public function cfmast_commit($cfm_id){
        $res=$this->field('capitalid,cod_cf_status')->where(array('id'=>$cfm_id,"cod_is_delete"=>'0'))->find();
			//发布的时候查询选择的基金是否已被其他产品挂住 且那个产品状态不为未完成即：cod_cf_status!=0
//		if ($res['capitalid']==0) {
//			$this->error="提交产品必须选择对应资产包";
//			return false;
//		}
//		$g = M('capitalpool')->getFieldById($res['capitalid'],'cf_mast_id');
		
//		if ($g) {
//			$mastname = M('cf_mast')->getFieldById($g,'title');
//			$this->error="产品所选资产包已经被【{$mastname}】使用,请重新选择";
//			return false;
//			}
		if(!$res){
			$this->error="没有找到此ID的投资产品";
			return false;
        }elseif($res['cod_cf_status']=='4'){
			$this->error="此投资产品已经提交";
			return false;
		}
		$r= $this->where(array('id'=>$cfm_id,'status'=>array("in","0,3,10")))->save(array("cod_cf_status"=>'6'));
//		$data['cf_mast_id']=$cfm_id;
//		$c=M('capitalpool')->where('id='.$res['capitalid'])->save($data);
//		dump($r);
		if($r===false){
			$this->where(array('id'=>$cfm_id,'status'=>array("in","0,3,10")))->save(array("cod_cf_status"=>$res['cod_cf_status']));
			$this->error="提交失败";
			return false;
		}else{
			$this->error="提交成功";
			return true;
		}


    }

	/**
	*修改投资产品
	*/
    public function cfmast_update($id){
        	$data=array();
			$data = I('post.');
	        $data['dat_modify']=date('Y-m-d H:i:s');
	        $data['usr_modify']=session('user_info.id');
			if(!$data['dat_cf_inv_begin']){
                $data['dat_cf_inv_begin']="0000-00-00 00:00:00";
            }
            if(!$data['dat_cf_inv_end']){
                $data['dat_cf_inv_end']="0000-00-00 00:00:00";
            }
	        $res=$this->where(['id'=>$id])->save($data);
			if($res!==false){
				return true;
			}else{
				$this->error="数据修改失败";
				return false;
			}
    }

	/*发布退回*/
	public function cfmast_pb($cfm_id){
		$data['cod_cf_status']=10;//发布退回 状态为10
		$condition['id']=$cfm_id;
		$condition['cod_cf_status']=4;
		$res=M('cf_mast')->where($condition)->save($data);
		if($res!==false){
			return true;
		}else{
			$this->error='发布退回失败';
			return false;
		}
	}
	/**
	*发布投资产品
	*/
    public function cfmast_fb($cfm_id){
		$r=$this->field('cod_cf_status')->where(array('id'=>$cfm_id,"cod_is_delete"=>'0'))->find();

		if(!$r){
			$this->error="没有找到此ID的投资产品";
			return false;
        }elseif($r['cod_cf_status']=='1'){
			$this->error="此投资产品已经是发布的状态";
			return false;
		}elseif($r['cod_cf_status']!=4){
			$this->error="此投资产品状态不允许发布";
			return false;
		}
		$r= $this->where(array('id'=>$cfm_id))->save(array("cod_cf_status"=>'1'));

		if($r===false){
			$this->error="数据保存出错";
			return false;
		}elseif($r==0){
			$this->error="数据没有发生改变";
			return false;
		}else{
			$r=$this->updateCapacity($cfm_id);
			return $r;
		}
    }

	/**
	 *投资产品启动 2016-01-25 lj
	 */
	public function cfmast_qd($cfm_id){
		$res=$this->field('cod_cf_status')->where(array('id'=>$cfm_id,"cod_is_delete"=>'0'))->find();
//		return $r;
		if(!$res){
			$this->error="没有找到此ID的投资产品";
			return false;
		}elseif($res['cod_cf_status']!=2){
			$this->error="此投资产品不能启动";
			return false;
		}
		$r= $this->where(array('id'=>$cfm_id))->save(array("cod_cf_status"=>'1'));
//		return M()->_sql();
		if($r===false){
			$this->error="数据保存出错";
			return false;
		}elseif($r==0){
			$this->error="数据没有发生改变";
			return false;
		}elseif($r){
			$this->error='投资产品启动成功';
			return true;
		}
	}

	/**
	*下架投资产品
	*/
    public function cfmast_shelf($cfm_id){
		//amt_ct_last 剩余金额 ctr_cr_finish=100
		$r=$this->field('cod_cf_status,each_amt')->where(array('id'=>$cfm_id,"cod_is_delete"=>'0'))->find();
		$ctl=M('cf_ctl')->alias("a")
			->field('a.id,a.amt_ct_last,a.ctr_ct_finish,b.capitalid,b.cod_cf_inv_type')
			->join('__CF_MAST__ b on b.id=a.cf_mast_id',"inner")
			->where(' a.cf_mast_id='.$cfm_id.' and a.ctr_ct_finish < 100')->find();
		//dump($ctl);
		//echo M()->_sql();
		$arr=[1,2];
		if( !in_array($r['cod_cf_status'],$arr)){
			$this->error="此投资产品不能下架";
			return false;
		}
		if(!$r){
			$this->error="没有找到此ID的投资产品";
			return false;
        }elseif($r['cod_cf_status']=='4'){
			$this->error="此投资产品已经是下架的状态";
			return false;
		}

		$r= $this->where(array('id'=>$cfm_id))->save(array("cod_cf_status"=>'4'));
		if($r===false){
			$this->error="数据保存出错";
			return false;
		}elseif($r==0){
			$this->error="数据没有发生改变";
			return false;
		}else{
			//dump($ctl);
			//把下架后的钱佳慧资金池,把完成度改成100%
			//$dat['amt_ct_last']=$ctl['amt_ct_last'];
			//$re=M('capitalpool')->where('id= '.$ctl['capitalid'].' and investment_type='.$ctl['cod_cf_inv_type'])->setInc('surplus_amount',$ctl['amt_ct_last']);
			if($ctl){
			$data['ctr_ct_finish']=100;
			$res=M('cf_ctl')->where('id='.$ctl['id'])->save($data);//把完成度改成100%
			}
			return $r;
		}
    }
	
	/**
	*暂停销售投资产品
	*/
    public function cfmast_pause($cfm_id){
		$r=$this->field('cod_cf_status')->where(array('id'=>$cfm_id,"cod_is_delete"=>'0'))->find();
		if($r['cod_cf_status']!=1){
			$this->error="此投资产品不能暂停";
			return false;
		}
		if(!$r){
			$this->error="没有找到此ID的投资产品";
			return false;
        }elseif($r['cod_cf_status']=='2'){
			$this->error="此投资产品已经是暂停销售的状态";
			return false;
		}
		$r= $this->where(array('id'=>$cfm_id))->save(array("cod_cf_status"=>'2'));
		if($r===false){
			$this->error="数据保存出错";
			return false;
		}elseif($r==0){
			$this->error="数据没有发生改变";
			return false;
		}else{
			return $r;
		}
    }
	/*capitalbags
 	*
 	* */
	public function capitalbags($where){
		$data['total']=M('capitalpool')
			->alias('a')->where($where)
			->join('__CF_MAST__ cm on a.cf_mast_id=cm.id','inner')->count();
		$data['items']=M('capitalpool')->alias('a')
			->field('a.*,sum(IFNULL(c.amt_ct_last,0))as total_amount ,(case when cm.capitalid=a.id then 1 else 0 end) as isshow')
			->join('__CF_MAST__ cm on a.cf_mast_id=cm.id','inner')
			->join('__CF_CTL__ c on c.capitalid=a.id','left')
			->where($where)
			->page(I('post.page'),I('post.limit'))
			->group('a.id')
			->order('a.dat_create asc')
			->select();

		return $data;
	}
	/**
     * 投资产品发布后更新期数表
     */
	public function updateCapacity($id,$r)
	{
		//获取已发布的投资产品同时没有生效中的投资产品期数记录
		$result =$this->field("d.*")
		->table('__' . strtoupper('Cf_mast'). '__ as d')
		->join('__' . strtoupper('Cf_ctl'). '__ as e ON d.id = e.cf_mast_id','left')
		->where("d.id = {$id} and  ((d.cod_cf_status =1 and d.cod_is_delete=0)	or e.id is null) ")
		->find();
//		dump($result);
//		die;
		$res=M('cf_ctl')
			->alias('c')
			->field('c.id,c.ctr_ct_last,c.ctr_ct,c.ctr_ct_last,c.cod_period')
			->where('c.cf_mast_id='.$id." and c.ctr_ct_finish<100")
			->find();
		if($res['id']) {
			return true;
		}else{

			if($result['cod_cf_inv_type'] && $result['capitalid'])
			{
				$rig = M('Capitalpool')
					->field('id,surplus_amount,investment_type')
					->where("investment_type=".$result['cod_cf_inv_type']." and id=".$result['capitalid'].' and cf_mast_id='.$id." and status=2 and validflag=1")
					->order('dat_modify desc')
					->find();
				$minYQje=0;
				if($rig['surplus_amount']&&$rig['surplus_amount']>=$result['amt_cf_inv_min']){
					// $data['each_amt']=min($rig['surplus_amount'],$result['amt_cf_inv_min']);
					$minYQje=min($rig['surplus_amount'],$result['each_amt']);
					$capitalid = $rig['id'];
					$status = M('Capitalpool')->where("id='{$rig['id']}' and investment_type='{$rig['investment_type']}' and surplus_amount >= '{$minYQje}'  ")->setDec('surplus_amount',$minYQje);
					if(!$status){
						//回滚发布状态
						$data = array(
							'cod_cf_status' => 4,
						);
						$s = $this->where("id = {$id}")->save($data);
						$this->error="当前资产包余额不足，发布失败";
						return false;
					}
				}else{
					$map=array(
						"a.id"=>$result['id'],
						"b.status"=>2,
						"b.surplus_amount"=>array("exp"," > a.amt_cf_inv_min"),
						"b.id"=>array("exp"," <> a.capitalid"),
					);
					$rig2 = D("CfMast")->alias("a")
							->join("__CAPITALPOOL__ b on b.cf_mast_id = a.id","inner")
							->where($map)
							->order("b.dat_modify asc")
							->find();
							
					if($rig2){
						// $data['each_amt']=min($rig2['surplus_amount'],$result['amt_cf_inv_min']);
						$data['cod_cf_inv_type']=$rig2['investment_type'];
						$data['capitalid']=$rig2['id']; 
						$minYQje=min($rig2['surplus_amount'],$result['each_amt']);
						$capitalid = $rig2['id'];
						
						$status = M('Capitalpool')->where("id='{$rig2['id']}' and investment_type='{$rig2['investment_type']}' and surplus_amount >= '{$minYQje}'  ")->setDec('surplus_amount',$minYQje);
						if($status){
							$res=M('cf_mast')->where('id='.$id)->save($data);
							if($res){
								$data = array(
									'dat_modify'=>date("Y-m-d H:i:s",time())
								);
								$s = $this->where("id = {$id}")->save($data);
	//							return true;
							}else{
								$status = M('Capitalpool')->where("id='{$rig2['id']}' ")->setInc('surplus_amount',$minYQje);
								//回滚发布状态
								$data = array(
									'cod_cf_status' => 4,
								);
								$s = $this->where("id = {$id}")->save($data);
								$this->error="发布失败";
								return false;
							}
						}else{
							//回滚发布状态
							$data = array(
								'cod_cf_status' => 4,
							);
							$s = $this->where("id = {$id}")->save($data);
							$this->error="发布失败";
							return false;
						}
						
					}else{
						//回滚发布状态
						$data = array(
							'cod_cf_status' => 4,
						);
						$s = $this->where("id = {$id}")->save($data);
						$this->error="没有合适的备用资产包";
						return false;
					}
				}
			}else{
				//回滚发布状态
				$data = array(
					'cod_cf_status' => 4,
				);
				$s = $this->where("id = {$id}")->save($data);
				$this->error="没有合适的资产包";
				return false; 
			}

			$data=array();
			$data['cf_mast_id']=$id;
			$cod_period=M('cf_ctl')->alias('c')->field('max(c.cod_period)+1 as num')->where('c.cf_mast_id='.$id)->find();
			
			$data['cod_period']=$cod_period['num']?$cod_period['num']:1;
			$data['amt_ct']=$minYQje;
			$data['ctr_ct']='200';
			$data['amt_ct_last']=$minYQje;
			$data['ctr_ct_last']='199';
			$data['ctr_ct_finish']='0';
			$data['dat_modify']=date("Y-m-d H:i:s",time());
			$data['ctr_updat_srlno']='0';
			$data['capitalid']=$capitalid;
			$data['type']=0;
			$model = D("cf_ctl");
			$status=$model->add($data);
			if($status ){//&& $status2
				return true;
			}else{
				$status = M('Capitalpool')->where("id='{$data['capitalid']}'  ")->setInc('surplus_amount',$minYQje);
				//回滚发布状态
				$data = array(
					'cod_cf_status' => 4,
				);
				$s = $this->where("id = {$id}")->save($data);
				$this->error="生成期数表出错，回滚发布状态";
				return false;
			}
		}


		//echo $this->getLastSql();
//		if($result){
//			$data=array();
//			$data['cf_mast_id']=$id;
//			$data['cod_period']='1';
//			$data['amt_ct']='0';
//			$data['ctr_ct']='200';
//			$data['amt_ct_last']='0';
//			$data['ctr_ct_last']='200';
//			$data['ctr_ct_finish']='0';
//			$data['dat_modify']=date("Y-m-d H:i:s",time());
//			$data['ctr_updat_srlno']='0';
//			$model = D("cf_ctl");
//			$status=$model->add($data);
////			$data['type']=2;
////			$status2=$model->add($data);
//			if($status ){//&& $status2
//				return true;
//			}else{
//				//回滚发布状态
//				$data = array(
//						'cod_cf_status' => 0,
//				);
//				$s = $this->where("id = {$id}")->save($data);
//				$this->error="生成期数表出错，回滚发布状态";
//				return false;
//			}
//		}else{
//			return true;
//		}
		
	}

	/**修改生成两种
	 * @param $id,
	 * @return mixed
	 */
	public function updateCapacity2($id)
	{
		//获取已发布的投资产品同时没有生效中的投资产品期数记录
		$result =$this->field("d.*")
			->table('__' . strtoupper('Cf_mast'). '__ as d')
			->join('__' . strtoupper('Cf_ctl'). '__ as e ON d.id = e.cf_mast_id','left')
			->where("d.id = {$id} and d.cod_cf_status =1 and d.cod_is_delete=0	and (e.id is null) ")
			->find();
		if($result){
			$data=array();
			$data['cf_mast_id']=$id;
			$data['cod_period']='1';
			$data['amt_ct']='0';
			$data['ctr_ct']='200';
			$data['amt_ct_last']='0';
			$data['ctr_ct_last']='200';
			$data['ctr_ct_finish']='0';
			$data['dat_modify']=date("Y-m-d H:i:s",time());
			$data['ctr_updat_srlno']='0';
			$data['type']=1;//1债权转让 2收益权转让
			$model = D("cf_ctl");
			$status=$model->add($data);
			$data['type']=2;
			$status2=$model->add($data);
			if($status && $status2){
				return true;
			}else{
				//回滚发布状态
				$data = array(
					'cod_cf_status' => 0,
				);
				$status = $this->where("id = {$id}")->save($data);
				$this->error="生成期数表出错，回滚发布状态";
				return false;
			}
		}else{
			return true;
		}

	}

    public function cfmast_del($where){

			$res['status']=$this->where($where)->save(array("cod_is_delete"=>'1'));
//			$res['sql']=M()->_sql();
			return $res;
    }
	/**
	*获取投资产品列表
	*/
    public function getlist($where,$curpage,$limit,$group=''){
		/*前端售卖显示*/
		$data=array();
		$data['total']=M('cf_mast')
			->alias('a')
			->field('a.id')
			// ->join('__CF_IVS__ c on a.id=c.cod_cf_id','left')
			->where($where)
			// ->group($group)
			->count();
//		 $data['sql']=M()->_sql();
		/*					sum(case c.cod_ivs_type when 1 then 1 else 0 end)as allp,*/
//					sum(case c.cod_ivs_type when 2 then 1 else 0 end)as allp2,
		$sql='select * from (
SELECT
( case t2.ctr_ct_finish when 100 then 2  else 1 end) as openorclose,
	 t2.amt_ct_last,
	 (t2.amt_ct- t2.amt_ct_last)  as curr_amt,
	t1.*, t2.id AS period_id,
	t2.cod_period,
	t2.ctr_ct_finish,
	t2.ctr_ct, 
	t2.ctr_ct_last
	 

FROM
	otc_cf_mast t1
LEFT JOIN otc_cf_ctl t2 ON t1.id = t2.cf_mast_id 
WHERE
	t1.cod_cf_status IN (1, 2)

AND t1.cod_is_delete = 0
AND t2.ctr_ct_finish <=100
 
order by t1.rat_cf_inv_min asc,openorclose asc,t1.dat_modify asc,t2.cod_period desc
) as c
group by rat_cf_inv_min 
';
		$list=M('')->query($sql);
		$arrid=[0];
		foreach($list as $k=>$v){
			$arrid[]=$v['id'];
		}
		$str="(".implode(",",$arrid).")";
		$data['items']=M('cf_mast')
					->alias('a')
					->field('a.id,a.title,a.cod_cf_status,
					count(c.id) as allp,
					case when a.id in'.$str.' then 1 else 0 end as isshow,
					a.rat_cf_inv_min,a.amt_time,
					a.dat_create,
					sum(case when c.cod_ivs_status=1 then c.amt_int_total else 0 end) as amt_ct
					')
					->join('__CF_IVS__ c on a.id=c.cod_cf_id','left')
					->where($where)
					->group($group)
					->order('a.dat_create desc')
					->page($curpage,$limit)
					->select();
		// $data['sql']=M()->_sql();
		foreach($data['items'] as $k =>$v){
			$data['items'][$k]['cod_cf_status_code']=$v['cod_cf_status'];
			$data['items'][$k]['cod_cf_status']=self::$status_select[$v['cod_cf_status']];
			if(is_null($data['items'][$k]['amt_ct']))
			{
				$data['items'][$k]['amt_ct']=0;
			}
		}
		
		// $data['total']=count($test);
//		$data['sql']=M()->_sql();
		return $data;
    }
	/**
	 *获取所有投资产品列表
	 */
	public function getalllist($where,$curpage,$limit){
		$data=array();
		$data['total']=$this->alias('a')->where($where)->count();
		$sql='SELECT	t2.amt_ct_last,	t1.*, t2.id AS period_id,	t2.cod_period,	t2.ctr_ct_finish,	t2.ctr_ct,
t2.ctr_ct_last FROM	otc_cf_mast t1 LEFT JOIN otc_cf_ctl t2 ON t1.id = t2.cf_mast_id WHERE t1.cod_cf_status IN (1, 2) and
t1.dat_modify in (SELECT 	min(tt1.dat_modify) FROM	otc_cf_mast tt1
LEFT JOIN otc_cf_ctl tt2 ON tt1.id = tt2.cf_mast_id
WHERE
	tt1.cod_cf_status IN (1, 2)

AND tt1.cod_is_delete = 0
AND tt2.ctr_ct_finish < 100
group by rat_cf_inv_min)


AND t1.cod_is_delete = 0
AND t2.ctr_ct_finish < 100
group by rat_cf_inv_min
order by t1.rat_cf_inv_min asc,t1.dat_modify asc';
		$list=M('')->query($sql);
		$arrid=[0];
		foreach($list as $k=>$v){
			$arrid[]=$v['id'];
		}
		 $str="(".implode(",",$arrid).")";
		$data['items']=$this
			->alias('a')
			->field("a.id,a.dat_create,a.title,
			a.dat_create,a.cod_cf_status,a.amt_ct,
			case when a.id in".$str." then 1 else 0 end as isshow,
			a.rat_cf_inv_min,a.amt_time,
			date_format(a.dat_create,'%Y-%m-%d') as dat_create")
			->where($where)
			->order('a.dat_create desc')
			->page($curpage,$limit)
			->select();
//	 $data['sql']=M()->_sql();
		foreach($data['items'] as $k =>$v){
			$data['items'][$k]['cod_cf_status_code']=$v['cod_cf_status'];
			$data['items'][$k]['cod_cf_status']=self::$status_select[$v['cod_cf_status']];
		}
		return $data;
	}
	  /**
	 * 获取管理端-具体某产品上传的文件列表model
	 * @param cfid 产品id
	 */
	public function getFileList($id){
		$data['items']=M('cf_mast_file')
			->alias('a')
			->field('a.id,a.file,a.filename')
			->where('a.cf_id='.$id.' and a.validflag=1')
			->select();
		$data['code']=M('cf_mast')->getFieldById($id,'code');
		foreach($data['items'] as $k=>$v){
			$data['items'][$k]['file']=substr($data['items'][$k]['file'],1);
		}
		$data['total']=count($data['items']);
		return $data;
	}

	/**
	 * 管理端-删除具体某产品上传的文件model
	 * @param cfid 产品id
	 */
	public function delFiles($cfid,$fileid)
	{
		$path = M('cf_mast_file')
				->field('file,id')
				->where('cf_id='.$cfid.' and id in '.$fileid.' and validflag=1')
				->select();
//		return APP_PATH.$path[0]['file'];
//		die;
		foreach (@$path as $k => $v){
					$res=M('cf_mast_file')->where("id=".$v['id'])->save(array('validflag'=>0));
					if($res!==false){
						return true;
					}else{
						$this->error="此文件已经删除";
						return false;
					}

		}

	}



    /**
	 * 投资管理产品基本信息获取
	 * @param $id 产品具体id
	 * $where
	 */
	public function getTdetail($id){
		$data=M('cf_mast')->alias('a')->field('a.id,d.total_amount as totalmoney,
		a.cod_cf_inv_type,a.amt_cf_inv_min,a.amt_cf_inv_each,
		a.amt_ct_min,a.amt_ct_max,
		a.capitalid as did,
		d.name as capitalid,
		a.formula,
		a.each_amt,
		a.amt_cf_inv_max,a.title,a.cod_cf_status,
		a.rat_cf_inv_min,a.dat_cf_inv_begin,
		a.amt_time,a.dat_cf_inv_end,count(c.cod_cf_id) as allp,
		d.surplus_amount as amt_ct')
      ->join("__CL_CTL__ b on a.cod_cf_inv_type=b.type",'left')//查询债权总钱数
      ->join('__CF_IVS__ c on a.id=c.cod_cf_id','left')//查询人数
      ->join('__CAPITALPOOL__ d on a.cod_cf_inv_type=d.investment_type and a.capitalid=d.id ','left')
      ->where("a.id=".$id)
      ->group('a.id')
      ->find();
		if(!$data['cod_cf_inv_type']){
			unset($data['cod_cf_inv_type']);
		}
	  $data['allm']=$data['totalmoney']-$data['amt_ct'];//已投额度
	  $data['overplustime']=strtotime($data['dat_cf_inv_end'])-strtotime(date('Y-m-d H:i:s'));//s剩余时间
	  $data['overplustime'] = $this->Sec2Time($data['overplustime']);
      return $data;
	}


	/**
	 * 秒转天时分秒
	 */
	public function Sec2Time($time){
		if($time<=0){
			return 0;
		}
    if(is_numeric($time)){
    $value = array(
      "years" => 0, "days" => 0, "hours" => 0,
      "minutes" => 0, "seconds" => 0,
    );
    if($time >= 31556926){
      $value["years"] = floor($time/31556926);
      $time = ($time%31556926);
    }
    if($time >= 86400){
      $value["days"] = floor($time/86400);
      $time = ($time%86400);
    }
    if($time >= 3600){
      $value["hours"] = floor($time/3600);
      $time = ($time%3600);
    }
    if($time >= 60){
      $value["minutes"] = floor($time/60);
      $time = ($time%60);
    }
    $value["seconds"] = floor($time);
    //return (array) $value;
    $t=$value["years"] ."年". $value["days"] ."天"." ". $value["hours"] ."小时". $value["minutes"] ."分".$value["seconds"]."秒";
    Return $t;

     }else{
    return (bool) FALSE;
    }
 }
	/**债权详细信息
	 * @param $where
	 */
public function getClaimsInfo($where){
	$data=M('cl_mast')->where($where )->find();
	return $data;
}
/*
	 * 	
	 * 对应债权清单-lj  2016-01-15 cl_ivs 为债权投资记录表 cl_ctl 债权进度控制 cl_mast 融资债权表
	 * $where
	 */
	public function getDebtList($where,$page,$limit,$cf_ctl_id)
	{
		$data['pname']=M('cf_ctl')
			->alias('b')
			->field('concat(a.title,b.cod_period,"期") as title')
							->join('__CF_MAST__ a on a.id=b.cf_mast_id')
							->where('b.id="'.$cf_ctl_id.'"')
							->find()['title'];

		$data['items']=M('cf_ivs')
			->alias('a')
			->field("a.id,a.cod_ivs_status,(CASE count(a.id) WHEN 1 THEN CASE
		WHEN a.cod_ivs_status =- 1 THEN
			'已作废'	WHEN oci.id IS NULL THEN '未确认' 	ELSE b.product_name
		END  ELSE	concat(b.product_name, '等')	END	) AS product_name,group_concat(b.product_name) AS product_name_list,oci.cod_cl_id,a.cod_ivs_type,cp.nam_cust_real,cp.cod_cust_id,
		a.amt_int_total AS amt_ivs,a.cod_cf_id,
		case when a.cod_ivs_status=-1 then '已作废' when oci.id is null then '未购买' else 0 end as product_name1,a.dat_modify,p.name as capitalname")
			->join('__CL_IVS__ oci on  a.id=oci.cod_cf_ivs_id','left')
			->join('__CAPITALPOOL__ p on a.capitalid=p.id')
			->join('__'.strtoupper('cl_mast').'__ b ON oci.cod_cl_id = b.id','left')
			->join('__'.strtoupper('cust_person').'__ cp ON a.cod_cust_id = cp.cod_cust_id')
			->where($where)
			->group('a.id')
			->page($page,$limit)
			->select();
		$data['total']=M('cf_ivs')
			->alias('a')
			->join('__CAPITALPOOL__ p on a.capitalid=p.id')
			->join('__'.strtoupper('cust_person').'__ cp ON a.cod_cust_id = cp.cod_cust_id')
			->where($where)
			->count();
		$data['total_ok_account']=M('cf_ivs')->alias("a")->where("a.cod_ctl_id=".$cf_ctl_id." and a.cod_ivs_status= 1")->sum("a.amt_int_total");
	if(!$data['total_ok_account'])$data['total_ok_account']=0;
		foreach ($data['items'] as $key => $value) {
			$data['items'][$key]['statusnum']=$data['items'][$key]['cod_ivs_status'];
			$data['items'][$key]['status']=$this::$ivs_status[$data['items'][$key]['statusnum']];
		}

		return $data;
	}

	/**
	 * 具体某个债权投资记录
	 */
	public function  getClaimsRecord($where,$page,$limit)
	{
		$data['items']=M('cl_ivs')
			->alias('a')
			->field('a.dat_create,a.amt_ivs,c.nam_cust_real,c.cod_cust_id_no,b.product_name,concat(d.title,e.cod_period) as bidname')
			->join('__CL_MAST__ b on a.cod_cl_id=b.id','left')
			->join('__CUST_PERSON__ c on a.cod_cust_id=c.cod_cust_id','left')
			->join('__CF_MAST__ d on a.cod_cf_id=d.id','left')
			->join('__CF_CTL__ e on a.cod_cf_ctl_id=e.id')
			->where($where)
			->page($page,$limit)
			->select();
		// echo M()->_sql();
		$data['total']=M('cl_ivs')
					->alias('a')
					->field('a.dat_create')
					->join('__CL_MAST__ b on a.cod_cl_id=b.id','left')
					->join('__CUST_PERSON__ c on a.cod_cust_id=c.cod_cust_id','left')
					->join('__CF_MAST__ d on a.cod_cf_id=d.id','left')
					->join('__CF_CTL__ e on a.cod_cf_ctl_id=e.id')
					->where($where)
					->count();
//		$data['sql']=M()->_sql();
		foreach($data['items'] as $k=>$v){
			$data['items'][$k]['cod_cust_id_no']=do_codcustidno($data['items'][$k]['cod_cust_id_no']);
			$data['items'][$k]['bidname']=$data['items'][$k]['bidname']."期";
		}
		return $data;
	}
	/**
	 * 查看债权
	 */
	public function viewClaimsInfo($where){

		$data['items']=M('cl_mast')
						->alias('b')
						->field('b.product_name,b.borrower,
						b.city,
						b.telephone,b.startdate,b.enddate,
						b.period,b.amt_cf_inv_price,
						b.rat_cf_inv_min,
						b.repay,b.cod_card_no,
						a.amt_ivs,
						c.amt_ct,
						c.amt_ct_last,
						a.cod_cust_id,
						d.nam_cust_real,
						b.use
						')
						->join('__CL_CTL__ c on b.id=c.cod_cl_id','left')
						->join('__CL_IVS__ a on b.id=a.cod_cl_id','left')
						->join('__CUST_PERSON__ d on a.cod_cust_id=d.cod_cust_id')
						->where($where)
						->select();

//		$data['sql']=M()->_sql();
		foreach($data['items'] as $k=>$key){
			$data['items'][$k]['investmoney']=$data['items'][$k]['amt_ct']-$data['items'][$k]['amt_ct_last'];//已投资金额
		}
		return $data;
	}


	/**
	 * @投资产品详情页
	 *@param $id 产品id
	 */

	public function getPdetail($where,$page,$limit){
		$data['total']=M('cf_ctl')
					  ->alias('c')
					  ->field('c.id')
					  ->join('__CF_MAST__ a on c.cf_mast_id=a.id','left')
					  ->join('__CF_IVS__  d on c.id=d.cod_cf_id','left')
						->join('__CAPITALPOOL__ p on c.capitalid=p.id','left')
					  ->where($where)
					  ->count();
		//			sum(case d.cod_ivs_type when 1 then 1 else 0 end) as allp,
//			sum(case d.cod_ivs_type when 2 then 1 else 0 end) as allp2,
		$data['items']=M('cf_ctl')
			->alias('c')
			->field('c.id,date_format(c.dat_modify,"%Y-%m-%d") as dat_modify,c.ctr_ct_finish,
			c.ctr_ct,a.title,c.cod_period,
			count(d.id) as allp,
			a.cod_cf_status,
			p.name as capitalname,
			c.amt_ct,
			c.amt_ct_last
			')
			->join('__CF_MAST__ a on c.cf_mast_id=a.id','left')
			->join('__CF_IVS__ d on c.id=d.cod_ctl_id','left')
			->join('__CAPITALPOOL__ p on c.capitalid=p.id','left')
			->where($where)
			->page($page,$limit)
			->group('c.id')
			->order('c.cod_period Desc')
			->select();
	// $data['sql']=M()->_Sql();
	foreach($data['items'] as $k=>$v){

		if($data['items'][$k]['cod_period']){
			$data['items'][$k]['bidname']=$data['items'][$k]['title'].$data['items'][$k]['cod_period'].'期';
		}
		if($data['items'][$k]['cod_cf_status']==1 &&$data['items'][$k]['ctr_ct_finish']>=0 && $data['items'][$k]['ctr_ct_finish']<100 )
		{
			$data['items'][$k]['ctr_ct_finish']='销售中';
		}elseif( $data['items'][$k]['ctr_ct_finish']==100){
			$data['items'][$k]['ctr_ct_finish']='已售罄';
		}else{
			$data['items'][$k]['ctr_ct_finish']='未销售';
		}
		$data['items'][$k]['cod_cf_status']=$this::$bidstatus_select[$data['items'][$k]['cod_cf_status']];
		if(!$data['items'][$k]['id']){
			unset($data['items']);
		}
	}

//echo M()->_sql();
		return $data;

	}



	public function cfmast_start($cfm_id){
		$r=$this->field('cod_cf_status')->where(array('id'=>$cfm_id,"cod_is_delete"=>'0'))->find();
		if($r['cod_cf_status']!=2 ){
			$this->error="此投资产品不能启动";
			return false;
		}
		if(!$r){
			$this->error="没有找到此ID的投资产品";
			return false;
		}elseif($r['cod_cf_status']=='1'){
			$this->error="此投资产品已经启动";
			return false;
		}
		$r= $this->where(array('id'=>$cfm_id))->save(array("cod_cf_status"=>'4'));
		if($r===false){
			$this->error="数据保存出错";
			return false;
		}elseif($r==0){
			$this->error="数据没有发生改变";
			return false;
		}else{
			return $r;
		}
	}
	
	/**
	 * 具体某个债权投资记录
	 */
	public function  getPosList($where,$page,$limit)
	{
		$field ="	a.`id` AS `id`,
			b.`nam_cust_real` AS `nam_cust_real`,
			b.`cod_cust_id_no` AS `cod_cust_id_no`,
			e.`realname` AS `user_name`,
			f.`name` AS `department_name`,
			concat(
				c.`title`,
				d.`cod_period`,
				'期'
			) AS `bid`,
			a.`pos_order` AS `pos_order`,
			a.`pos_file` AS `pos_file`,
			concat(
				'http://139.196.190.181',
				a.`pos_file`
			) AS `url_pos_file`,
			a.`amt_ivs` AS `amt_ivs`,
			a.`ctl_ivs_cnt` AS `ctl_ivs_cnt`,
			a.`amt_int_total` AS `amt_int_total`,
			a.`dat_modify` AS `dat_modify`,
			e.`city` ,
			e.`yingyequ` ,
			e.`yewubu` ,
			e.`shequmendian`,
			a.`sales`,
			a.`usr_arrival`,
			(case a.`usr_arrival` when 0 then '' else a.`dat_arrival` end) as dat_arrival,
			(case a.`usr_arrival` when 0 then '' else a.`arrivaldate` end) as arrivaldate,
			g.`realname` as arrivaluname
	
	";
	$where["a.cod_ivs_status"]=1;
		if($page&&$limit){
			
			$data['items'] = D("cf_ivs")->alias("a")->field($field)
			->join("__CUST_PERSON__ b on a.cod_cust_id = b.cod_cust_id")
			->join("__CF_MAST__ c on a.cod_cf_id = c.id")
			->join("__CF_CTL__ d on a.cod_ctl_id = d.id")
			->join("__USER__ e on a.usr_create = e.id")
			->join("__DEPARTMENT__ f on e.department_id = f.id")
			->join("__USER__ g on a.usr_arrival = g.id","left")
			->where($where)->page($page,$limit)->order("a.dat_modify desc" )->select();
			
		}else{
			$data['items'] = D("cf_ivs")->alias("a")->field($field)
			->join("__CUST_PERSON__ b on a.cod_cust_id = b.cod_cust_id")
			->join("__CF_MAST__ c on a.cod_cf_id = c.id")
			->join("__CF_CTL__ d on a.cod_ctl_id = d.id")
			->join("__USER__ e on a.usr_create = e.id")
			->join("__DEPARTMENT__ f on e.department_id = f.id")
			->join("__USER__ g on a.usr_arrival = G.id","left")
			->where($where)->order("a.dat_modify desc" )->select();
		}
		
		
		
		$data['total'] = D("cf_ivs")->alias("a")->field($field)
		->join("__CUST_PERSON__ b on a.cod_cust_id = b.cod_cust_id")
		->join("__CF_MAST__ c on a.cod_cf_id = c.id")
		->join("__CF_CTL__ d on a.cod_ctl_id = d.id")
		->join("__USER__ e on a.usr_create = e.id")
		->join("__DEPARTMENT__ f on e.department_id = f.id")
		->where($where)->page()->order("a.dat_modify desc" )->count();
		// $data['total']=D("IvsView")->where($where)->count();
		// $data['items']=D("IvsView")->where($where)->page($page,$limit)->order("dat_modify desc")->select();
		// $data['sql']=D("IvsView")->getLastSql();
		return $data;
	}
}