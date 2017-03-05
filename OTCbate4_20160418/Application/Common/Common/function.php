<?php
/**
 * 项目公共函数库
 */
//function sendEmail($toemail, $title, $content){
//    $title = trim($title) == '' ? '资邦投资云平台' : $title;
//    $config = C('EMAIL_SERVER');
//    $Email = new \Common\Lib\Email($config);
//    $Email->setMail($title,$content);
//    $status = true;
//    if(is_array($toemail)){
//        foreach($toemail as $mail){
//            $status = $Email->sendMail($mail);
//            if($status == false){
//                //$status = false;
//                \Think\Log::write($mail . ':发送邮件失败！标题：' . $title . ', 内容：' . $content . '。【错误信息】:' . $Email->getError());
//            }
//        }
//    }else{
//        $status = $Email->sendMail($toemail);
//    }
//    return $status;
//}
/**
 * /**
 * 文件上传
 *  默认七牛云上传
 * @param $file
 * @return array
 */
function fileUplode(){
    $config = C('UPLOAD_SITEIMG_QINIU');
    $uplode = new \Think\Upload($config);
    $info = $uplode->upload($_FILES);
    $result = array();
    if(!$info){
        $result = array('status'=>'0', 'error'=>$uplode->getError());
    }else{
        $result['status'] = 1;
        foreach($info as $k=>$value){
            //$url[] = $value['url'];
            $result['info'][$k]['url'] = $value['url'];
            $result['info'][$k]['type'] = $value['ext'];
            $result['info'][$k]['name'] = $_FILES[$value['key']]['name'];
        }
    }
    return $result;
}
function Qiniu_Encode($str) // URLSafeBase64Encode
{
    $find = array('+', '/');
    $replace = array('-', '_');
    return str_replace($find, $replace, base64_encode($str));
}
function Qiniu_Sign($url) {//$info里面的url
    $setting = C('UPLOAD_SITEIMG_QINIU');
    $duetime = NOW_TIME + 86400;//下载凭证有效时间
    $DownloadUrl = $url . '?e=' . $duetime;
    $Sign = hash_hmac( 'sha1', $DownloadUrl, $setting["driverConfig"]["secretKey"], true );
    $EncodedSign = Qiniu_Encode ($Sign);
    $Token = $setting ["driverConfig"] ["accessKey"] . ':' . $EncodedSign;
    $RealDownloadUrl = $DownloadUrl . '&token=' . $Token;
    return $RealDownloadUrl;
}
function showMessage($type = 1){
   $message = C('MESSAGE_TYPE');
    if(isset($message[$type])){
        return $message[$type];
    }
    return;
}
// utf8 解决反序列化数据时 返回的false问题
function mb_unserialize($serial_str) {
    $serial_str= preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
    $serial_str= str_replace("\r", "", $serial_str);
    return unserialize($serial_str);
}
/**
 * 获取文件扩展名
 * @param string $filename 文件名称
 * @return string 文件类型
 */
function getFileType($filename) {
    $info = pathinfo($filename);
    return strtolower($info['extension']);
}

function createDir($dir){
	if(!file_exists($dir))
		mkdir($dir);
}

function getStatusName($status = 0){
    $statusArr = array(
        1 => '启用',
        2 => '禁用',
        3 => '注销',
    );
    if($status){
        return $statusArr[$status];
    }else{
        return $statusArr;
    }
}

/**
 * 生成树形结构
 * @param array $arr 数组
 * @param int $id 父级ID 0为从最顶级开始
 * @param string $key 关联ID
 * @param string $pkey 父级ID
 * @param string $child 子级key
 * @return array
 */
function GetTree($arr, $id = 0, $key='id', $pkey = 'pid', $child='child'){
    $data = array();
    foreach($arr as $k=>$v){
        if($v[$pkey] == $id){
            $v[$child] = GetTree($arr, $v[$key]);
            if(empty($v[$child])){
                unset($v[$child]);
            }
            $data[] = $v;
        }
    }
    return $data;
}

/**
* 身份证打* 号
*/
function do_codcustidno($str){
	return substr_replace($str,"******",9,6);
}

/*姓名打*号
 *
 * */

function do_codcutname($user_name){
    /**
     * 只保留字符串首尾字符，隐藏中间用*代替（两个字符时只显示第一个）
     * @param string $user_name 姓名
     * @return string 格式化后的姓名
     */

        $strlen     = mb_strlen($user_name, 'utf-8');
        $firstStr     = mb_substr($user_name, 0, 1, 'utf-8');
        $lastStr     = mb_substr($user_name, -1, 1, 'utf-8');
        return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) : $firstStr . str_repeat("*", $strlen - 1);

}
/**
 * 数字转换为中文
 * @param  string|integer|float  $num  目标数字
 * @param  integer $mode 模式[true:金额（默认）,false:普通数字表示]
 * @param  boolean $sim 使用小写（默认）
 * @return string
 */
 function number2chinese($num,$mode = true,$sim = true){
    if(!is_numeric($num)) return '含有非数字非小数点字符！';
    $char    = $sim ? array('零','一','二','三','四','五','六','七','八','九')
                : array('零','壹','贰','叁','肆','伍','陆','柒','捌','玖');
    $unit    = $sim ? array('','十','百','千','','万','亿','兆')             
                : array('','拾','佰','仟','','萬','億','兆');
    $retval  = $mode ? '元':'点';
 
    //小数部分
    if(strpos($num, '.')){
        list($num,$dec) = explode('.', $num);
        $dec = strval(round($dec,2));
        if($mode){
            $retval .= "{$char[$dec['0']]}角{$char[$dec['1']]}分";
        }else{
            for($i = 0,$c = strlen($dec);$i < $c;$i++) {
                $retval .= $char[$dec[$i]];
            }
        }
    }
    //整数部分
    $str = $mode ? strrev(intval($num)) : strrev($num);
    for($i = 0,$c = strlen($str);$i < $c;$i++) {
        $out[$i] = $char[$str[$i]];
        if($mode){
            $out[$i] .= $str[$i] != '0'? $unit[$i%4] : '';
            if($i>1 and $str[$i]+$str[$i-1] == 0){
                $out[$i] = '';
            }
            if($i%4 == 0){
                $out[$i] .= $unit[4+floor($i/4)];
            }
        }
    }
    $retval = join('',array_reverse($out)) . $retval;
    return $retval;
 }
function cny($ns){
	static $cnums = array("零", "壹", "贰", "叁", "肆", "伍", "陆", "柒", "捌", "玖");
	$cnyunits = array("圆", "角", "分");
	$grees = array("拾", "佰", "仟", "万", "拾", "佰", "仟", "亿");
	list($ns1, $ns2) = explode(".", $ns, 2);
	$ns2 = array_filter(array($ns2[1], $ns2[0]));
	$ret = array_merge($ns2, array(implode("", _cny_map_unit(str_split($ns1), $grees)), ""));
	$ret = implode("", array_reverse(_cny_map_unit($ret, $cnyunits)));
	return str_replace(array_keys($cnums), $cnums, $ret);
	}

	function _cny_map_unit($list, $units){
	$ul = count($units);
	$xs = array();
	foreach (array_reverse($list) as $x) {
	$l = count($xs);
	if ($x != "0" || !($l % 4)) $n = ($x == '0' ? '' : $x) . ($units[($l - 1) % $ul]);
	else $n = is_numeric($xs[0][0]) ? $x : '';
	array_unshift($xs, $n);
	}
	return $xs;
}

/*字段验证*/
function insert_create($str){
    if(!is_null($str)){
        if(is_float($str) || is_numeric($str)){
            if($str >= 200000 || $str == 0){
                if($str%10000==0)
                {
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
    }else{
        return false;
    }
}

/**
 * 获取并解析前端传过来的json数据
 * return array $data
 */
function getPostJson(){
    $json = trim(trim(file_get_contents("php://input")), ',');
    $data = json_decode($json, true);
    return $data;
}
function check_int($id){
    if(empty($id)){
        return false;
    }else{
        if(preg_match("/^[1-9]\d*$/", $id))
        {
            return true;
        }else{
            return false;
        }
    }
}

/**
 * 部门对应的合同来源 默认返回允许上传合同的部门ID 数组
 * @param int $dp
 * @return array
 */
function ContractDepartment($dp = 0){
    $dpArr = array(
        55 => 1, //来源产品部
        57 => 2,//来源法务部
    );
    if(in_array($dp, array_keys($dpArr))){
        return $dpArr[$dp];
    }
    return array_keys($dpArr);
}


function addZero($v){
  return $v.'.00';
}





