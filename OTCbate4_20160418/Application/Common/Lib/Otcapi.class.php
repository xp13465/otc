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

class Otcapi {
     
    /**
     * 生成XML String
     * return XML string
    */
    public function createXmlStr($xmlFields = array()){
        $xmlStr='<?xml%20version="1.0"%20encoding="gbk"?>';
        $xmlStr .="<root>";
        foreach($xmlFields as $key=>$val){
            $xmlStr .="<{$key}>{$val}</{$key}>";
        }
        $xmlStr .="</root>";
        return $xmlStr;
    }
    /**
     * 根据String 生成XML数组  
    * return 正确格式返回array
    */
    public function xmlArrayByString($string){
		$string = str_replace("gbk","utf8",$string);
        return @simplexml_load_string($string)?(array)@simplexml_load_string($string):array();
    }
    /**
     * 调用OTC 的API
     * return 成功返回对应XML 数组
    */
    public function otc_toapi($url, $keyname, $xmlFields = null) {
        $xmlStr = $this->createXmlStr($xmlFields);
        $url = $url."?ParName=".$keyname."&ParValue=".$xmlStr;
        // var_dump($url); 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.1)');
        curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT,5);
        curl_setopt($ch, CURLOPT_FAILONERROR, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         
        $reponse = curl_exec($ch);
        //return curl_getinfo($ch);
        /* if (curl_errno($ch)) {
            throw new Exception(curl_error($ch),0);
        }
        else {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 !== $httpStatusCode) {
                // throw new Exception($reponse,$httpStatusCode);
            }
        } */
		// var_dump($reponse) ;
	
        return  $this->xmlArrayByString($reponse);
         
	}
       
     
}
  

