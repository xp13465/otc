<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: pengyong <i@pengyong.info>
// +----------------------------------------------------------------------
namespace Common\Lib;

class Otcdbf {
	public $KH;
	public $GH;
	public $RJ;
	
	public  $KH_KEY = array( 
		"KHDLRM",
	    "KHSQRQ",
	    "KHSQDH",
	    "KHJSZH",
	    "KHYWLX",
	    "KHJYZH",
	    "KHTZRM",
	    "KHTZJC",
	    "KHTRZL",
	    "KHTRZH",
	    "KHCSRQ",
	    "KHTRXB",
	    "KHTRXL",
	    "KHTRZY",
	    "KHDWMC",
	    "KHZZDH",
	    "KHSJHM",
	    "KHDWDH",
	    "KHCZHM",
	    "KHDZYJ",
	    "KHYZBM",
	    "KHTXDZ",
	    "KHFRXM",
	    "KHFRZL",
	    "KHFRZH",
	    "KHJRXM",
	    "KHJRZL",
	    "KHJRZH",
	    "KHFSRQ",
	    "KHFXJB",
	    "KHFXCN",
	    "KHJRBH",
	    "KHBYBZ",
	);
	public  $GH_KEY = array( 
		"GHDLRM",
	    "GHCPDM",
	    "GHJSZH",
	    "GHJYZH",
	    "GHSQRQ",
	    "GHSQDH",
	    "GHCJFX",
	    "GHCJJG",
	    "GHCJSL",
	    "GHCJJE",
	    "GHFSRQ",
	    "GHJRBH",
	    "GHBYBZ",
	);
	public  $RJ_KEY = array( 
		"RJCYRM",
	    "RJJSZH",
	    "RJJYZH",
	    "RJSQRQ",
	    "RJSQDH",
	    "RJRJFS",
	    "RJFSJE",
	    "RJGHDH",
	    "RJBYBZ",
	);
	
	public function __construct(){
		$this->KH = array(
			  array("KHDLRM",     "C", 32), //销售代理人代码 (011-0x)*    (011-2x)*  (012)*
			  array("KHSQRQ",     "N", 8,0),  //申请日期  YYYYMMDD  (011-0x)* (011-2x)*  (012)*
			  array("KHSQDH",     "C", 32), //申请单号  (011-0x)* (011-2x)*  (012)*
			  array("KHJSZH",     "C", 16), //结算账户                  (012)*
			  array("KHYWLX",     "C", 3),  //业务类型  (011-0x)*  (011-2x)*  (012)*     011 注册新的结算所账户 012 更新已注册结算所账户的资料 015 注销结算所账户 008 增加交易账户 009 撤销交易账户
			  array("KHJYZH",     "C", 32), //交易账户   (011-0x)* (011-2x)*
			  array("KHTZRM",     "C", 250),//投资人名   (011-0x)* (011-2x)*  (012)*
			  array("KHTZJC",     "C", 64), //投资人名-简称  
			  array("KHTRZL",     "C", 2),  //投资人证件类型   (011-0x)* (011-2x)*  (012)*
			  array("KHTRZH",     "C", 30), //投资人证件号码   (011-0x)* (011-2x)*   (012)*
			  array("KHCSRQ",     "N", 8,0),  //出生日期  YYYYMMDD
			  array("KHTRXB",     "C", 1),  //性别
			  array("KHTRXL",     "C", 2),  //学历
			  array("KHTRZY",     "C", 2),  //职业
			  array("KHDWMC",     "C", 60), //单位名称
			  array("KHZZDH",     "C", 24), //住宅电话
			  array("KHSJHM",     "C", 24), //手机号码
			  array("KHDWDH",     "C", 24), //单位电话
			  array("KHCZHM",     "C", 24), //传真号码
			  array("KHDZYJ",     "C", 40), //电子邮件
			  array("KHYZBM",     "C", 6),  //邮政编码     (011-0x)* (011-2x)*
			  array("KHTXDZ",     "C", 250),//通讯地址     (011-0x)* (011-2x)*
			  array("KHFRXM",     "C", 20), //法人代表姓名     (011-2x)*
			  array("KHFRZL",     "C", 2),  //法人代表证件类型  (011-2x)*
			  array("KHFRZH",     "C", 30), //法人代表证件号码  (011-2x)*
			  array("KHJRXM",     "C", 20), //经办人姓名        (011-2x)*
			  array("KHJRZL",     "C", 2),  //经办人证件类型    (011-2x)*
			  array("KHJRZH",     "C", 30), //经办人证件号码     (011-2x)*
			  array("KHFSRQ",     "N", 8,0),  //发送日期     YYYYMMDD    (011-0x)*  (011-2x)*  (012)*
			  array("KHFXJB",     "N", 8,0),  //客户风险级别  结算所提供？
			  array("KHFXCN",     "C", 1),  //客户风险承诺函  0未签署  1已签署
			  array("KHJRBH",     "C", 16), //经纪人编号
			  array("KHBYBZ",     "C", 10), //备用标志
		);
		
		$this->GH = array(
			  array("GHDLRM",     "C", 32), //销售代理人代码 *
			  array("GHCPDM",     "C", 16), //产品代码 *
			  array("GHJSZH",     "C", 16), //结算账户 *
			  array("GHJYZH",     "C", 32), //交易账户 *
			  array("GHSQRQ",     "N", 8,0), //申请日期   YYYYMMDD
			  array("GHSQDH",     "C", 32), //申请单号 *
			  array("GHCJFX",     "C", 2), //买卖方向 B买入  S卖出 *
			  array("GHCJJG",     "N", 12,4), //成交价格 *
			  array("GHCJSL",     "N", 16,2), //成交数量   *
			  array("GHCJJE",     "N", 16,2), //成交金额    *
			  array("GHFSRQ",     "N", 8,0), //发送日期   YYYYMMDD  *
			  array("GHJRBH",     "C", 16), //经纪人编号               
			  array("GHBYBZ",     "C", 10), //备用标志 	  
		);
		$this->RJ = array(
			  array("RJCYRM",     "C", 32), //销售代理人代码 *
			  array("RJJSZH",     "C", 16), //结算账户 *
			  array("RJJYZH",     "C", 32), //交易账户 *
			  array("RJSQRQ",     "N", 8,0), //入金日期 *  YYYYMMDD
			  array("RJSQDH",     "C", 32), //入金流水单号   
			  array("RJRJFS",     "C", 32), //入金方式 *
			  array("RJFSJE",     "N", 18,2), //入金金额 *
			  array("RJGHDH",     "C", 32), //对应过户申请单号 *
			  array("RJBYBZ",     "C", 10), //备用标志   * 
		);
	}

	public function createDBF($file,$type){
		if (!dbase_create($file, $this->$type)) {
		   echo "Error, can't create the database\n";
		   return false;
		}
		return true;
	}
	
	public function writeDbf($file,$data){
		$db = dbase_open($file, 2);
		dbase_add_record($db,$data);
		dbase_close($db);
	}
        
   

}