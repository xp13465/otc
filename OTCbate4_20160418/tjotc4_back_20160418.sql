/*
Navicat MySQL Data Transfer

Source Server         : 139.196.190.181_3306
Source Server Version : 50621
Source Host           : 139.196.190.181:3306
Source Database       : tjotc4

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2016-04-18 13:54:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for otc_api_downfile_log
-- ----------------------------
DROP TABLE IF EXISTS `otc_api_downfile_log`;
CREATE TABLE `otc_api_downfile_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `AccessToken` varchar(256) DEFAULT '',
  `OrgCode` varchar(256) DEFAULT '' COMMENT '机构编码(由结算所发放)',
  `FileID` int(11) DEFAULT '0' COMMENT '第三方机构对上传文件的编号',
  `FileName` varchar(256) DEFAULT '' COMMENT '文件名',
  `CheckFlag` int(11) DEFAULT '0' COMMENT '检查结果编号',
  `ReceiveFlag` int(11) DEFAULT '0' COMMENT '对应完全的log,otc_api_log',
  `ReceiveInfo` varchar(256) DEFAULT '' COMMENT '对应动做,gh/kh',
  `createtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FileID` (`FileID`) USING BTREE,
  KEY `CheckFlag` (`CheckFlag`) USING BTREE,
  KEY `ReceiveFlag` (`ReceiveFlag`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='下载文件成功后，检查完成后的回调(子)日志';

-- ----------------------------
-- Records of otc_api_downfile_log
-- ----------------------------
INSERT INTO `otc_api_downfile_log` VALUES ('1', '71D41E82-13E4-40DF-9C75-A4499991179C', 'SEZB004', '4014', 'TJC_TJC999_SEZB004_20160219_173118_DZBD.DBF', '0', '0', '', '0000-00-00 00:00:00');
INSERT INTO `otc_api_downfile_log` VALUES ('2', '71D41E82-13E4-40DF-9C75-A4499991179C', 'SEZB004', '4024', 'TJC_TJC999_SEZB004_20160219_221837_DZBD.DBF', '0', '0', '', '0000-00-00 00:00:00');
INSERT INTO `otc_api_downfile_log` VALUES ('3', '71D41E82-13E4-40DF-9C75-A4499991179C', 'SEZB004', '4026', 'TJC_TJC999_SEZB004_20160219_221938_DZBD.DBF', '0', '0', '', '0000-00-00 00:00:00');
INSERT INTO `otc_api_downfile_log` VALUES ('4', '71D41E82-13E4-40DF-9C75-A4499991179C', 'SEZB004', '4028', 'TJC_TJC999_SEZB004_20160219_222039_DZBD.DBF', '0', '0', '', '0000-00-00 00:00:00');
INSERT INTO `otc_api_downfile_log` VALUES ('5', 'F2D17CDC-C55A-4393-803A-804FB9CAB389', 'SEZB004', '4046', 'TJC_TJC999_SEZB004_20160219_153829_DZBD.DBF', '0', '0', '', '0000-00-00 00:00:00');
INSERT INTO `otc_api_downfile_log` VALUES ('6', 'F2D17CDC-C55A-4393-803A-804FB9CAB389', 'SEZB004', '4048', 'TJC_TJC999_SEZB004_20160219_154229_DZBD.DBF', '0', '0', '', '0000-00-00 00:00:00');
INSERT INTO `otc_api_downfile_log` VALUES ('7', 'F2D17CDC-C55A-4393-803A-804FB9CAB389', 'SEZB004', '4050', 'TJC_TJC999_SEZB004_20160219_155331_DZBD.DBF', '0', '0', '', '0000-00-00 00:00:00');
INSERT INTO `otc_api_downfile_log` VALUES ('8', '93DC4BA8-49AB-408D-A4BD-FD59C0D831AC', 'SEZB004', '4089', 'TJC_TJC999_SEZB004_20160219_100307_DZBD.DBF', '0', '0', '', '0000-00-00 00:00:00');
INSERT INTO `otc_api_downfile_log` VALUES ('9', '93DC4BA8-49AB-408D-A4BD-FD59C0D831AC', 'SEZB004', '4091', 'TJC_TJC999_SEZB004_20160219_100904_DZBD.DBF', '0', '0', '', '0000-00-00 00:00:00');
INSERT INTO `otc_api_downfile_log` VALUES ('10', '93833249-35EB-4C92-AC65-0ED81D0694B8', 'SEZB004', '4151', 'TJC_TJC999_SEZB004_20160219_172608_DZBD.DBF', '0', '0', '', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for otc_api_filecheck_log
-- ----------------------------
DROP TABLE IF EXISTS `otc_api_filecheck_log`;
CREATE TABLE `otc_api_filecheck_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OrgCode` varchar(200) DEFAULT '' COMMENT '机构编码(由结算所发放)',
  `FileID` int(11) DEFAULT '0' COMMENT '第三方机构对上传文件的编号',
  `FileName` varchar(200) DEFAULT '' COMMENT '文件名',
  `CheckFlag` int(11) DEFAULT '0' COMMENT '检查结果编号',
  `CheckDescription` varchar(200) DEFAULT '' COMMENT '检查结果描述',
  `flog_id` int(8) DEFAULT '0' COMMENT '对应完全的log,otc_api_log',
  `flie_actione` varchar(10) DEFAULT '' COMMENT '对应动做,gh/kh',
  `flie_id` int(8) DEFAULT '0' COMMENT '对应编号kh/gh表里的id',
  PRIMARY KEY (`id`),
  KEY `FileID` (`FileID`) USING BTREE,
  KEY `CheckFlag` (`CheckFlag`) USING BTREE,
  KEY `flog_id` (`flog_id`) USING BTREE,
  KEY `flie_id` (`flie_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='上传文件成功后，检查完成后的回调(子)日志';

-- ----------------------------
-- Records of otc_api_filecheck_log
-- ----------------------------
INSERT INTO `otc_api_filecheck_log` VALUES ('1', 'SEZB004', '17126', 'TJC_SEZB004_TJC999_20160406_53_KH.DBF', '0', '文件检查成功，可以继续处理', '21', 'err', '0');

-- ----------------------------
-- Table structure for otc_api_fileready_log
-- ----------------------------
DROP TABLE IF EXISTS `otc_api_fileready_log`;
CREATE TABLE `otc_api_fileready_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OrgCode` varchar(200) DEFAULT '' COMMENT '机构编码(由结算所发放)',
  `FileID` int(11) DEFAULT '0' COMMENT '结算所文件编号',
  `FileName` varchar(256) DEFAULT '' COMMENT '文件名',
  `FileSize` int(11) DEFAULT '0' COMMENT '文件大小，单位字节',
  `MD5Code` varchar(256) DEFAULT '' COMMENT '文件 MD5 校验码',
  `flog_id` int(11) DEFAULT '0' COMMENT '对应完全的log,otc_api_log',
  `flie_actione` varchar(200) DEFAULT '',
  `flie_ids` text,
  PRIMARY KEY (`id`),
  KEY `FileID` (`FileID`) USING BTREE,
  KEY `FileSize` (`FileSize`) USING BTREE,
  KEY `flog_id` (`flog_id`) USING BTREE,
  FULLTEXT KEY `FileName` (`FileName`),
  FULLTEXT KEY `OrgCode` (`OrgCode`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of otc_api_fileready_log
-- ----------------------------
INSERT INTO `otc_api_fileready_log` VALUES ('1', 'SEZB004', '4014', 'TJC_TJC999_SEZB004_20160219_173118_DZBD.DBF', '915', '9F4188716CD15D16C346286795C864EC', '2', 'DZBD.DBF', '1,2');
INSERT INTO `otc_api_fileready_log` VALUES ('2', 'SEZB004', '4024', 'TJC_TJC999_SEZB004_20160219_221837_DZBD.DBF', '915', 'DD4188FAC771D90739448F99568AD6AB', '4', 'DZBD.DBF', '3,4');
INSERT INTO `otc_api_fileready_log` VALUES ('3', 'SEZB004', '4026', 'TJC_TJC999_SEZB004_20160219_221938_DZBD.DBF', '915', 'DD4188FAC771D90739448F99568AD6AB', '6', 'DZBD.DBF', '5,6');
INSERT INTO `otc_api_fileready_log` VALUES ('4', 'SEZB004', '4028', 'TJC_TJC999_SEZB004_20160219_222039_DZBD.DBF', '915', 'DD4188FAC771D90739448F99568AD6AB', '8', 'DZBD.DBF', '7,8');
INSERT INTO `otc_api_fileready_log` VALUES ('5', 'SEZB004', '4046', 'TJC_TJC999_SEZB004_20160219_153829_DZBD.DBF', '915', '9F4188716CD15D16C346286795C864EC', '10', 'DZBD.DBF', '9,10');
INSERT INTO `otc_api_fileready_log` VALUES ('6', 'SEZB004', '4048', 'TJC_TJC999_SEZB004_20160219_154229_DZBD.DBF', '915', '9F4188716CD15D16C346286795C864EC', '12', 'DZBD.DBF', '11,12');
INSERT INTO `otc_api_fileready_log` VALUES ('7', 'SEZB004', '4050', 'TJC_TJC999_SEZB004_20160219_155331_DZBD.DBF', '915', '563765435E3EBDABE946EE241BC04BE2', '14', 'DZBD.DBF', '13,14');
INSERT INTO `otc_api_fileready_log` VALUES ('8', 'SEZB004', '4089', 'TJC_TJC999_SEZB004_20160219_100307_DZBD.DBF', '915', 'C8EDFC0FCC516743FFF2154A10930A7A', '16', 'DZBD.DBF', '15,16');
INSERT INTO `otc_api_fileready_log` VALUES ('9', 'SEZB004', '4091', 'TJC_TJC999_SEZB004_20160219_100904_DZBD.DBF', '915', 'A2149FC0E63DF26E694A5C9C5EEE0FB5', '18', 'DZBD.DBF', '17,18');
INSERT INTO `otc_api_fileready_log` VALUES ('10', 'SEZB004', '4151', 'TJC_TJC999_SEZB004_20160219_172608_DZBD.DBF', '915', '8F80033558AED322251F05FAC5F0A957', '20', 'DZBD.DBF', '19,20');
INSERT INTO `otc_api_fileready_log` VALUES ('11', 'SEZB004', '4328', 'TJC_TJC999_SEZB004_20160219_94935_KB.DBF', '2385', '67C64F6ADC9C6C997D307EEEA722FD17', '23', 'KB.DBF', '');
INSERT INTO `otc_api_fileready_log` VALUES ('12', 'SEZB004', '4326', 'TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF', '915', '0731105ACF21ADE57B5DFA6E1341C399', '25', 'DZBD.DBF', '');
INSERT INTO `otc_api_fileready_log` VALUES ('13', 'SEZB004', '4326', 'TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF', '915', '0731105ACF21ADE57B5DFA6E1341C399', '27', 'DZBD.DBF', '');
INSERT INTO `otc_api_fileready_log` VALUES ('14', 'SEZB004', '4326', 'TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF', '915', '0731105ACF21ADE57B5DFA6E1341C399', '29', 'DZBD.DBF', '');
INSERT INTO `otc_api_fileready_log` VALUES ('15', 'SEZB004', '4326', 'TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF', '915', '0731105ACF21ADE57B5DFA6E1341C399', '31', 'DZBD.DBF', '');
INSERT INTO `otc_api_fileready_log` VALUES ('16', 'SEZB004', '4328', 'TJC_TJC999_SEZB004_20160219_94935_KB.DBF', '2385', '67C64F6ADC9C6C997D307EEEA722FD17', '33', 'KB.DBF', '');
INSERT INTO `otc_api_fileready_log` VALUES ('17', 'SEZB004', '4326', 'TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF', '915', '0731105ACF21ADE57B5DFA6E1341C399', '35', 'DZBD.DBF', '');
INSERT INTO `otc_api_fileready_log` VALUES ('18', 'SEZB004', '4326', 'TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF', '915', '0731105ACF21ADE57B5DFA6E1341C399', '37', 'DZBD.DBF', '');
INSERT INTO `otc_api_fileready_log` VALUES ('19', 'SEZB004', '4326', 'TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF', '915', '0731105ACF21ADE57B5DFA6E1341C399', '39', 'DZBD.DBF', '');
INSERT INTO `otc_api_fileready_log` VALUES ('20', 'SEZB004', '4326', 'TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF', '915', '0731105ACF21ADE57B5DFA6E1341C399', '41', 'DZBD.DBF', '');
INSERT INTO `otc_api_fileready_log` VALUES ('21', 'SEZB004', '4326', 'TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF', '915', '0731105ACF21ADE57B5DFA6E1341C399', '43', 'DZBD.DBF', '');
INSERT INTO `otc_api_fileready_log` VALUES ('22', 'SEZB004', '4328', 'TJC_TJC999_SEZB004_20160219_94935_KB.DBF', '2385', '67C64F6ADC9C6C997D307EEEA722FD17', '45', 'KB.DBF', '');
INSERT INTO `otc_api_fileready_log` VALUES ('23', 'SEZB004', '4326', 'TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF', '915', '0731105ACF21ADE57B5DFA6E1341C399', '47', 'DZBD.DBF', '');
INSERT INTO `otc_api_fileready_log` VALUES ('24', 'SEZB004', '4328', 'TJC_TJC999_SEZB004_20160219_94935_KB.DBF', '2385', '67C64F6ADC9C6C997D307EEEA722FD17', '49', 'KB.DBF', '');

-- ----------------------------
-- Table structure for otc_api_log
-- ----------------------------
DROP TABLE IF EXISTS `otc_api_log`;
CREATE TABLE `otc_api_log` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `ParName` varchar(500) DEFAULT '' COMMENT '对应参数',
  `ParValue` varchar(8000) DEFAULT '' COMMENT '对应值',
  `my_note` longtext,
  `add_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `clientip` varchar(20) DEFAULT '' COMMENT 'IP',
  `_SERVER` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COMMENT='tjotc接口回调日志';

-- ----------------------------
-- Records of otc_api_log
-- ----------------------------
INSERT INTO `otc_api_log` VALUES ('1', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4014</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_173118_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>9F4188716CD15D16C346286795C864EC</MD5Code></root>', '执行时间：0.004秒||异步：调用同步状态：(201603251732011231)(1)；', '2016-03-25 17:32:01', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:366:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4014%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_173118_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E9F4188716CD15D16C346286795C864EC%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:364:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4014%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_173118_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E9F4188716CD15D16C346286795C864EC%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:5:\"19370\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1458898321.2698181;s:12:\"REQUEST_TIME\";i:1458898321;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('2', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4014</FileID><FileName>TJC_TJC999_SEZB004_20160219_173118_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>9F4188716CD15D16C346286795C864EC</MD5Code></root>', '执行时间：1.667秒||同步：(201603251732011231)api通知我方下载,文件下载成功1.331秒,共含有DZBD数据2条,1_ZB001确权记录关联失败,1_ZB002确权记录关联失败', '2016-03-25 17:32:02', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:321:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201603251732011231&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4014</FileID><FileName>TJC_TJC999_SEZB004_20160219_173118_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>9F4188716CD15D16C346286795C864EC</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:320:\"//Guest/Tjotcapi/otcapi?type=2&pid=201603251732011231&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4014</FileID><FileName>TJC_TJC999_SEZB004_20160219_173118_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>9F4188716CD15D16C346286795C864EC</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"13209\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1458898321.2767429;s:12:\"REQUEST_TIME\";i:1458898321;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('3', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4024</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_221837_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>DD4188FAC771D90739448F99568AD6AB</MD5Code></root>', '执行时间：0.003秒||异步：调用同步状态：(201603252219221731)(1)；', '2016-03-25 22:19:22', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:366:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4024%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_221837_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3EDD4188FAC771D90739448F99568AD6AB%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:364:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4024%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_221837_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3EDD4188FAC771D90739448F99568AD6AB%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:5:\"24940\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1458915562.1873181;s:12:\"REQUEST_TIME\";i:1458915562;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('4', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4024</FileID><FileName>TJC_TJC999_SEZB004_20160219_221837_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>DD4188FAC771D90739448F99568AD6AB</MD5Code></root>', '执行时间：0.601秒||同步：(201603252219221731)api通知我方下载,文件下载成功0.383秒,共含有DZBD数据2条,1_ZB002确权记录关联失败,1_ZB001确权记录关联失败', '2016-03-25 22:19:22', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:321:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201603252219221731&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4024</FileID><FileName>TJC_TJC999_SEZB004_20160219_221837_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>DD4188FAC771D90739448F99568AD6AB</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:320:\"//Guest/Tjotcapi/otcapi?type=2&pid=201603252219221731&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4024</FileID><FileName>TJC_TJC999_SEZB004_20160219_221837_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>DD4188FAC771D90739448F99568AD6AB</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"14185\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1458915562.193615;s:12:\"REQUEST_TIME\";i:1458915562;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('5', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4026</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_221938_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>DD4188FAC771D90739448F99568AD6AB</MD5Code></root>', '执行时间：0.003秒||异步：调用同步状态：(201603252220235006)(1)；', '2016-03-25 22:20:23', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:366:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4026%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_221938_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3EDD4188FAC771D90739448F99568AD6AB%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:364:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4026%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_221938_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3EDD4188FAC771D90739448F99568AD6AB%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:5:\"24968\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1458915623.345885;s:12:\"REQUEST_TIME\";i:1458915623;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('6', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4026</FileID><FileName>TJC_TJC999_SEZB004_20160219_221938_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>DD4188FAC771D90739448F99568AD6AB</MD5Code></root>', '执行时间：0.649秒||同步：(201603252220235006)api通知我方下载,文件下载成功0.462秒,共含有DZBD数据2条,1_ZB002确权记录关联失败,1_ZB001确权记录关联失败', '2016-03-25 22:20:24', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:321:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201603252220235006&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4026</FileID><FileName>TJC_TJC999_SEZB004_20160219_221938_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>DD4188FAC771D90739448F99568AD6AB</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:320:\"//Guest/Tjotcapi/otcapi?type=2&pid=201603252220235006&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4026</FileID><FileName>TJC_TJC999_SEZB004_20160219_221938_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>DD4188FAC771D90739448F99568AD6AB</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"14197\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1458915623.351548;s:12:\"REQUEST_TIME\";i:1458915623;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('7', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4028</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_222039_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>DD4188FAC771D90739448F99568AD6AB</MD5Code></root>', '执行时间：0.003秒||异步：调用同步状态：(201603252221248674)(1)；', '2016-03-25 22:21:24', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:366:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4028%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_222039_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3EDD4188FAC771D90739448F99568AD6AB%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:364:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4028%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_222039_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3EDD4188FAC771D90739448F99568AD6AB%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:5:\"24990\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1458915684.4028981;s:12:\"REQUEST_TIME\";i:1458915684;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('8', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4028</FileID><FileName>TJC_TJC999_SEZB004_20160219_222039_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>DD4188FAC771D90739448F99568AD6AB</MD5Code></root>', '执行时间：0.641秒||同步：(201603252221248674)api通知我方下载,文件下载成功0.457秒,共含有DZBD数据2条,1_ZB002确权记录关联失败,1_ZB001确权记录关联失败', '2016-03-25 22:21:25', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:321:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201603252221248674&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4028</FileID><FileName>TJC_TJC999_SEZB004_20160219_222039_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>DD4188FAC771D90739448F99568AD6AB</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:320:\"//Guest/Tjotcapi/otcapi?type=2&pid=201603252221248674&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4028</FileID><FileName>TJC_TJC999_SEZB004_20160219_222039_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>DD4188FAC771D90739448F99568AD6AB</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"14208\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1458915684.4088099;s:12:\"REQUEST_TIME\";i:1458915684;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('9', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4046</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_153829_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>9F4188716CD15D16C346286795C864EC</MD5Code></root>', '执行时间：0.004秒||异步：调用同步状态：(201603281539335793)(1)；', '2016-03-28 15:39:33', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:366:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4046%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_153829_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E9F4188716CD15D16C346286795C864EC%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:364:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4046%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_153829_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E9F4188716CD15D16C346286795C864EC%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:5:\"40745\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459150773.5532191;s:12:\"REQUEST_TIME\";i:1459150773;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('10', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4046</FileID><FileName>TJC_TJC999_SEZB004_20160219_153829_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>9F4188716CD15D16C346286795C864EC</MD5Code></root>', '执行时间：1.246秒||同步：(201603281539335793)api通知我方下载,文件下载成功0.485秒,共含有DZBD数据2条,1_ZB001确权记录关联失败,1_ZB002确权记录关联失败', '2016-03-28 15:39:34', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:321:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201603281539335793&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4046</FileID><FileName>TJC_TJC999_SEZB004_20160219_153829_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>9F4188716CD15D16C346286795C864EC</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:320:\"//Guest/Tjotcapi/otcapi?type=2&pid=201603281539335793&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4046</FileID><FileName>TJC_TJC999_SEZB004_20160219_153829_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>9F4188716CD15D16C346286795C864EC</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"26832\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459150773.561141;s:12:\"REQUEST_TIME\";i:1459150773;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('11', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4048</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_154229_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>9F4188716CD15D16C346286795C864EC</MD5Code></root>', '执行时间：0.005秒||异步：调用同步状态：(201603281543336151)(1)；', '2016-03-28 15:43:33', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:366:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4048%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_154229_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E9F4188716CD15D16C346286795C864EC%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:364:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4048%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_154229_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E9F4188716CD15D16C346286795C864EC%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:5:\"40832\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459151013.5721581;s:12:\"REQUEST_TIME\";i:1459151013;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('12', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4048</FileID><FileName>TJC_TJC999_SEZB004_20160219_154229_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>9F4188716CD15D16C346286795C864EC</MD5Code></root>', '执行时间：0.640秒||同步：(201603281543336151)api通知我方下载,文件下载成功0.452秒,共含有DZBD数据2条,1_ZB001确权记录关联失败,1_ZB002确权记录关联失败', '2016-03-28 15:43:34', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:321:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201603281543336151&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4048</FileID><FileName>TJC_TJC999_SEZB004_20160219_154229_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>9F4188716CD15D16C346286795C864EC</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:320:\"//Guest/Tjotcapi/otcapi?type=2&pid=201603281543336151&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4048</FileID><FileName>TJC_TJC999_SEZB004_20160219_154229_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>9F4188716CD15D16C346286795C864EC</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"26853\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459151013.5819471;s:12:\"REQUEST_TIME\";i:1459151013;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('13', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4050</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_155331_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>563765435E3EBDABE946EE241BC04BE2</MD5Code></root>', '执行时间：0.004秒||异步：调用同步状态：(201603281554366368)(1)；', '2016-03-28 15:54:36', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:366:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4050%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_155331_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E563765435E3EBDABE946EE241BC04BE2%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:364:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4050%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_155331_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E563765435E3EBDABE946EE241BC04BE2%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:5:\"41054\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459151676.2703531;s:12:\"REQUEST_TIME\";i:1459151676;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('14', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4050</FileID><FileName>TJC_TJC999_SEZB004_20160219_155331_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>563765435E3EBDABE946EE241BC04BE2</MD5Code></root>', '执行时间：0.647秒||同步：(201603281554366368)api通知我方下载,文件下载成功0.445秒,共含有DZBD数据2条,1_ZB001确权记录关联失败,1_ZB002确权记录关联失败', '2016-03-28 15:54:36', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:321:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201603281554366368&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4050</FileID><FileName>TJC_TJC999_SEZB004_20160219_155331_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>563765435E3EBDABE946EE241BC04BE2</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:320:\"//Guest/Tjotcapi/otcapi?type=2&pid=201603281554366368&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4050</FileID><FileName>TJC_TJC999_SEZB004_20160219_155331_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>563765435E3EBDABE946EE241BC04BE2</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"26898\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459151676.2775011;s:12:\"REQUEST_TIME\";i:1459151676;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('15', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4089</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_100307_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>C8EDFC0FCC516743FFF2154A10930A7A</MD5Code></root>', '执行时间：0.004秒||异步：调用同步状态：(201603291004177190)(1)；', '2016-03-29 10:04:17', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:366:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4089%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_100307_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3EC8EDFC0FCC516743FFF2154A10930A7A%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:364:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4089%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_100307_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3EC8EDFC0FCC516743FFF2154A10930A7A%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:5:\"62389\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459217057.489166;s:12:\"REQUEST_TIME\";i:1459217057;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('16', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4089</FileID><FileName>TJC_TJC999_SEZB004_20160219_100307_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>C8EDFC0FCC516743FFF2154A10930A7A</MD5Code></root>', '执行时间：3.518秒||同步：(201603291004177190)api通知我方下载,文件下载成功0.488秒,共含有DZBD数据2条,1_ZB002确权记录关联失败,1_ZB001确权记录关联失败', '2016-03-29 10:04:21', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:321:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201603291004177190&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4089</FileID><FileName>TJC_TJC999_SEZB004_20160219_100307_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>C8EDFC0FCC516743FFF2154A10930A7A</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:320:\"//Guest/Tjotcapi/otcapi?type=2&pid=201603291004177190&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4089</FileID><FileName>TJC_TJC999_SEZB004_20160219_100307_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>C8EDFC0FCC516743FFF2154A10930A7A</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"32913\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459217057.4989071;s:12:\"REQUEST_TIME\";i:1459217057;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('17', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4091</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_100904_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>A2149FC0E63DF26E694A5C9C5EEE0FB5</MD5Code></root>', '执行时间：0.004秒||异步：调用同步状态：(201603291010142366)(1)；', '2016-03-29 10:10:14', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:366:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4091%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_100904_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3EA2149FC0E63DF26E694A5C9C5EEE0FB5%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:364:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4091%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_100904_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3EA2149FC0E63DF26E694A5C9C5EEE0FB5%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:5:\"62516\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459217414.9771581;s:12:\"REQUEST_TIME\";i:1459217414;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('18', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4091</FileID><FileName>TJC_TJC999_SEZB004_20160219_100904_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>A2149FC0E63DF26E694A5C9C5EEE0FB5</MD5Code></root>', '执行时间：0.695秒||同步：(201603291010142366)api通知我方下载,文件下载成功0.488秒,共含有DZBD数据2条,1_ZB001确权记录关联失败,1_ZB002确权记录关联失败', '2016-03-29 10:10:15', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:321:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201603291010142366&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4091</FileID><FileName>TJC_TJC999_SEZB004_20160219_100904_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>A2149FC0E63DF26E694A5C9C5EEE0FB5</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:320:\"//Guest/Tjotcapi/otcapi?type=2&pid=201603291010142366&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4091</FileID><FileName>TJC_TJC999_SEZB004_20160219_100904_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>A2149FC0E63DF26E694A5C9C5EEE0FB5</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"32964\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459217414.9848809;s:12:\"REQUEST_TIME\";i:1459217414;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('19', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4151</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_172608_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>8F80033558AED322251F05FAC5F0A957</MD5Code></root>', '执行时间：0.004秒||异步：调用同步状态：(201603301727283863)(1)；', '2016-03-30 17:27:28', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:366:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4151%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_172608_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E8F80033558AED322251F05FAC5F0A957%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:364:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4151%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_172608_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E8F80033558AED322251F05FAC5F0A957%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:5:\"41278\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459330048.970681;s:12:\"REQUEST_TIME\";i:1459330048;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('20', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4151</FileID><FileName>TJC_TJC999_SEZB004_20160219_172608_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>8F80033558AED322251F05FAC5F0A957</MD5Code></root>', '执行时间：0.878秒||同步：(201603301727283863)api通知我方下载,文件下载成功0.543秒,共含有DZBD数据2条,1_ZB002确权记录关联失败,1_ZB001确权记录关联失败', '2016-03-30 17:27:29', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:321:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201603301727283863&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4151</FileID><FileName>TJC_TJC999_SEZB004_20160219_172608_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>8F80033558AED322251F05FAC5F0A957</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:320:\"//Guest/Tjotcapi/otcapi?type=2&pid=201603301727283863&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4151</FileID><FileName>TJC_TJC999_SEZB004_20160219_172608_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>8F80033558AED322251F05FAC5F0A957</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"41220\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459330048.9789591;s:12:\"REQUEST_TIME\";i:1459330048;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('21', 'FileCheckStatus', '<?xml version=\"1.0\" encoding=\"gbk\"?>\n<item>\n<OrgCode>SEZB004</OrgCode>\n<FileID>17126</FileID>\n<FileName>TJC_SEZB004_TJC999_20160406_53_KH.DBF</FileName>\n<CheckFlag>0</CheckFlag>\n<CheckDescription>文件检查成功，可以继续处理</CheckDescription>\n</item>', '执行时间：0.010秒||同步：(0)api检查完毕通知我方,FileName没有找到正确数据(err,kh_dbf没找到数据)', '2016-04-06 09:50:40', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:476:\"s=/Guest/Tjotcapi/otcapi&ParName=FileCheckStatus&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%0A%3Citem%3E%0A%3COrgCode%3ESEZB004%3C/OrgCode%3E%0A%3CFileID%3E17126%3C/FileID%3E%0A%3CFileName%3ETJC_SEZB004_TJC999_20160406_53_KH.DBF%3C/FileName%3E%0A%3CCheckFlag%3E0%3C/CheckFlag%3E%0A%3CCheckDescription%3E%E6%96%87%E4%BB%B6%E6%A3%80%E6%9F%A5%E6%88%90%E5%8A%9F%EF%BC%8C%E5%8F%AF%E4%BB%A5%E7%BB%A7%E7%BB%AD%E5%A4%84%E7%90%86%3C/CheckDescription%3E%0A%3C/item%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:474:\"/Guest/Tjotcapi/otcapi?ParName=FileCheckStatus&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%0A%3Citem%3E%0A%3COrgCode%3ESEZB004%3C/OrgCode%3E%0A%3CFileID%3E17126%3C/FileID%3E%0A%3CFileName%3ETJC_SEZB004_TJC999_20160406_53_KH.DBF%3C/FileName%3E%0A%3CCheckFlag%3E0%3C/CheckFlag%3E%0A%3CCheckDescription%3E%E6%96%87%E4%BB%B6%E6%A3%80%E6%9F%A5%E6%88%90%E5%8A%9F%EF%BC%8C%E5%8F%AF%E4%BB%A5%E7%BB%A7%E7%BB%AD%E5%A4%84%E7%90%86%3C/CheckDescription%3E%0A%3C/item%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:4:\"7903\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907440.1973979;s:12:\"REQUEST_TIME\";i:1459907440;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('22', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4328</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_94935_KB.DBF</FileName>	<FileSize>2385</FileSize>	<MD5Code>67C64F6ADC9C6C997D307EEEA722FD17</MD5Code></root>', '执行时间：0.004秒||异步：调用同步状态：(201604060950434829)(1)；', '2016-04-06 09:50:43', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:364:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4328%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94935_KB.DBF%3C/FileName%3E%09%3CFileSize%3E2385%3C/FileSize%3E%09%3CMD5Code%3E67C64F6ADC9C6C997D307EEEA722FD17%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:362:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4328%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94935_KB.DBF%3C/FileName%3E%09%3CFileSize%3E2385%3C/FileSize%3E%09%3CMD5Code%3E67C64F6ADC9C6C997D307EEEA722FD17%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:4:\"7913\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907443.230006;s:12:\"REQUEST_TIME\";i:1459907443;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('23', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4328</FileID><FileName>TJC_TJC999_SEZB004_20160219_94935_KB.DBF</FileName><FileSize>2385</FileSize><MD5Code>67C64F6ADC9C6C997D307EEEA722FD17</MD5Code></root>', '执行时间：0.349秒||同步：(201604060950434829)api通知我方下载,文件下载失败0.339秒', '2016-04-06 09:50:43', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:319:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201604060950434829&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4328</FileID><FileName>TJC_TJC999_SEZB004_20160219_94935_KB.DBF</FileName><FileSize>2385</FileSize><MD5Code>67C64F6ADC9C6C997D307EEEA722FD17</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:318:\"//Guest/Tjotcapi/otcapi?type=2&pid=201604060950434829&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4328</FileID><FileName>TJC_TJC999_SEZB004_20160219_94935_KB.DBF</FileName><FileSize>2385</FileSize><MD5Code>67C64F6ADC9C6C997D307EEEA722FD17</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"16972\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907443.2372169;s:12:\"REQUEST_TIME\";i:1459907443;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('24', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4326</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.004秒||异步：调用同步状态：(201604060952263458)(1)；', '2016-04-06 09:52:26', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:365:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:363:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:4:\"7974\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907546.425266;s:12:\"REQUEST_TIME\";i:1459907546;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('25', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.350秒||同步：(201604060952263458)api通知我方下载,文件下载失败0.342秒', '2016-04-06 09:52:26', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:320:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201604060952263458&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:319:\"//Guest/Tjotcapi/otcapi?type=2&pid=201604060952263458&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"17058\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907546.4331911;s:12:\"REQUEST_TIME\";i:1459907546;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('26', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4326</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.003秒||异步：调用同步状态：(201604060953279722)(1)；', '2016-04-06 09:53:27', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:365:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:363:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:4:\"8017\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907607.650351;s:12:\"REQUEST_TIME\";i:1459907607;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('27', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.368秒||同步：(201604060953279722)api通知我方下载,文件下载失败0.363秒', '2016-04-06 09:53:28', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:320:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201604060953279722&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:319:\"//Guest/Tjotcapi/otcapi?type=2&pid=201604060953279722&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"17078\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907607.6560221;s:12:\"REQUEST_TIME\";i:1459907607;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('28', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4326</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.003秒||异步：调用同步状态：(201604060954284414)(1)；', '2016-04-06 09:54:28', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:365:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:363:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:4:\"8047\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907668.7100551;s:12:\"REQUEST_TIME\";i:1459907668;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('29', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.357秒||同步：(201604060954284414)api通知我方下载,文件下载失败0.347秒', '2016-04-06 09:54:29', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:320:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201604060954284414&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:319:\"//Guest/Tjotcapi/otcapi?type=2&pid=201604060954284414&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"17093\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907668.716552;s:12:\"REQUEST_TIME\";i:1459907668;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('30', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4326</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.004秒||异步：调用同步状态：(201604060955295124)(1)；', '2016-04-06 09:55:29', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:365:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:363:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:4:\"8088\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907729.9219179;s:12:\"REQUEST_TIME\";i:1459907729;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('31', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.372秒||同步：(201604060955295124)api通知我方下载,文件下载失败0.355秒', '2016-04-06 09:55:30', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:320:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201604060955295124&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:319:\"//Guest/Tjotcapi/otcapi?type=2&pid=201604060955295124&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"17108\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907729.9286439;s:12:\"REQUEST_TIME\";i:1459907729;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('32', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4328</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_94935_KB.DBF</FileName>	<FileSize>2385</FileSize>	<MD5Code>67C64F6ADC9C6C997D307EEEA722FD17</MD5Code></root>', '执行时间：0.004秒||异步：调用同步状态：(201604060955295374)(1)；', '2016-04-06 09:55:29', '117.78.9.192', 'a:31:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:364:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4328%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94935_KB.DBF%3C/FileName%3E%09%3CFileSize%3E2385%3C/FileSize%3E%09%3CMD5Code%3E67C64F6ADC9C6C997D307EEEA722FD17%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:362:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4328%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94935_KB.DBF%3C/FileName%3E%09%3CFileSize%3E2385%3C/FileSize%3E%09%3CMD5Code%3E67C64F6ADC9C6C997D307EEEA722FD17%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:4:\"8088\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907729.987864;s:12:\"REQUEST_TIME\";i:1459907729;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('33', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4328</FileID><FileName>TJC_TJC999_SEZB004_20160219_94935_KB.DBF</FileName><FileSize>2385</FileSize><MD5Code>67C64F6ADC9C6C997D307EEEA722FD17</MD5Code></root>', '执行时间：0.366秒||同步：(201604060955295374)api通知我方下载,文件下载失败0.345秒', '2016-04-06 09:55:30', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:319:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201604060955295374&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4328</FileID><FileName>TJC_TJC999_SEZB004_20160219_94935_KB.DBF</FileName><FileSize>2385</FileSize><MD5Code>67C64F6ADC9C6C997D307EEEA722FD17</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:318:\"//Guest/Tjotcapi/otcapi?type=2&pid=201604060955295374&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4328</FileID><FileName>TJC_TJC999_SEZB004_20160219_94935_KB.DBF</FileName><FileSize>2385</FileSize><MD5Code>67C64F6ADC9C6C997D307EEEA722FD17</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"17114\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907729.9951429;s:12:\"REQUEST_TIME\";i:1459907729;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('34', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4326</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.003秒||异步：调用同步状态：(201604060956317783)(1)；', '2016-04-06 09:56:31', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:365:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:363:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:4:\"8139\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907791.075458;s:12:\"REQUEST_TIME\";i:1459907791;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('35', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.343秒||同步：(201604060956317783)api通知我方下载,文件下载失败0.336秒', '2016-04-06 09:56:31', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:320:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201604060956317783&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:319:\"//Guest/Tjotcapi/otcapi?type=2&pid=201604060956317783&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"17129\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907791.0810549;s:12:\"REQUEST_TIME\";i:1459907791;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('36', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4326</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.004秒||异步：调用同步状态：(201604060957322914)(1)；', '2016-04-06 09:57:32', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:365:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:363:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:4:\"8169\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907852.1235781;s:12:\"REQUEST_TIME\";i:1459907852;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('37', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.361秒||同步：(201604060957322914)api通知我方下载,文件下载失败0.341秒', '2016-04-06 09:57:32', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:320:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201604060957322914&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:319:\"//Guest/Tjotcapi/otcapi?type=2&pid=201604060957322914&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"17143\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907852.1304519;s:12:\"REQUEST_TIME\";i:1459907852;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('38', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4326</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.003秒||异步：调用同步状态：(201604060958307440)(1)；', '2016-04-06 09:58:30', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:365:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:363:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:4:\"8255\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907910.607089;s:12:\"REQUEST_TIME\";i:1459907910;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('39', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.434秒||同步：(201604060958307440)api通知我方下载,文件下载失败0.412秒', '2016-04-06 09:58:31', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:320:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201604060958307440&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:319:\"//Guest/Tjotcapi/otcapi?type=2&pid=201604060958307440&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"17159\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907910.6131411;s:12:\"REQUEST_TIME\";i:1459907910;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('40', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4326</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.003秒||异步：调用同步状态：(201604060959476043)(1)；', '2016-04-06 09:59:47', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:365:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:363:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:4:\"8346\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907987.783915;s:12:\"REQUEST_TIME\";i:1459907987;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('41', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.354秒||同步：(201604060959476043)api通知我方下载,文件下载失败0.337秒', '2016-04-06 09:59:48', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:320:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201604060959476043&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:319:\"//Guest/Tjotcapi/otcapi?type=2&pid=201604060959476043&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"17178\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459907987.790359;s:12:\"REQUEST_TIME\";i:1459907987;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('42', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4326</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.003秒||异步：调用同步状态：(201604061000369616)(1)；', '2016-04-06 10:00:36', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:365:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:363:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:4:\"8375\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459908036.081701;s:12:\"REQUEST_TIME\";i:1459908036;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('43', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.366秒||同步：(201604061000369616)api通知我方下载,文件下载失败0.348秒', '2016-04-06 10:00:36', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:320:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201604061000369616&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:319:\"//Guest/Tjotcapi/otcapi?type=2&pid=201604061000369616&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"17190\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459908036.087985;s:12:\"REQUEST_TIME\";i:1459908036;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('44', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4328</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_94935_KB.DBF</FileName>	<FileSize>2385</FileSize>	<MD5Code>67C64F6ADC9C6C997D307EEEA722FD17</MD5Code></root>', '执行时间：0.005秒||异步：调用同步状态：(201604061000363502)(1)；', '2016-04-06 10:00:36', '117.78.9.192', 'a:31:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:364:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4328%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94935_KB.DBF%3C/FileName%3E%09%3CFileSize%3E2385%3C/FileSize%3E%09%3CMD5Code%3E67C64F6ADC9C6C997D307EEEA722FD17%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:362:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4328%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94935_KB.DBF%3C/FileName%3E%09%3CFileSize%3E2385%3C/FileSize%3E%09%3CMD5Code%3E67C64F6ADC9C6C997D307EEEA722FD17%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:4:\"8375\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459908036.198324;s:12:\"REQUEST_TIME\";i:1459908036;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('45', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4328</FileID><FileName>TJC_TJC999_SEZB004_20160219_94935_KB.DBF</FileName><FileSize>2385</FileSize><MD5Code>67C64F6ADC9C6C997D307EEEA722FD17</MD5Code></root>', '执行时间：0.332秒||同步：(201604061000363502)api通知我方下载,文件下载失败0.325秒', '2016-04-06 10:00:36', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:319:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201604061000363502&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4328</FileID><FileName>TJC_TJC999_SEZB004_20160219_94935_KB.DBF</FileName><FileSize>2385</FileSize><MD5Code>67C64F6ADC9C6C997D307EEEA722FD17</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:318:\"//Guest/Tjotcapi/otcapi?type=2&pid=201604061000363502&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4328</FileID><FileName>TJC_TJC999_SEZB004_20160219_94935_KB.DBF</FileName><FileSize>2385</FileSize><MD5Code>67C64F6ADC9C6C997D307EEEA722FD17</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"17196\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459908036.2058811;s:12:\"REQUEST_TIME\";i:1459908036;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('46', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4326</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName>	<FileSize>915</FileSize>	<MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.004秒||异步：调用同步状态：(201604061001384567)(1)；', '2016-04-06 10:01:38', '117.78.9.192', 'a:32:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:365:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:363:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4326%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94106_DZBD.DBF%3C/FileName%3E%09%3CFileSize%3E915%3C/FileSize%3E%09%3CMD5Code%3E0731105ACF21ADE57B5DFA6E1341C399%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:4:\"8419\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:10:\"Keep-Alive\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459908098.171392;s:12:\"REQUEST_TIME\";i:1459908098;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('47', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>', '执行时间：0.405秒||同步：(201604061001384567)api通知我方下载,文件下载失败0.398秒', '2016-04-06 10:01:38', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:320:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201604061001384567&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:319:\"//Guest/Tjotcapi/otcapi?type=2&pid=201604061001384567&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4326</FileID><FileName>TJC_TJC999_SEZB004_20160219_94106_DZBD.DBF</FileName><FileSize>915</FileSize><MD5Code>0731105ACF21ADE57B5DFA6E1341C399</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"17208\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459908098.178993;s:12:\"REQUEST_TIME\";i:1459908098;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('48', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root>	<OrgCode>SEZB004</OrgCode>	<FileID>4328</FileID>	<FileName>TJC_TJC999_SEZB004_20160219_94935_KB.DBF</FileName>	<FileSize>2385</FileSize>	<MD5Code>67C64F6ADC9C6C997D307EEEA722FD17</MD5Code></root>', '执行时间：0.003秒||异步：调用同步状态：(201604061001385444)(1)；', '2016-04-06 10:01:38', '117.78.9.192', 'a:31:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:364:\"s=/Guest/Tjotcapi/otcapi&ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4328%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94935_KB.DBF%3C/FileName%3E%09%3CFileSize%3E2385%3C/FileSize%3E%09%3CMD5Code%3E67C64F6ADC9C6C997D307EEEA722FD17%3C/MD5Code%3E%3C/root%3E\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:362:\"/Guest/Tjotcapi/otcapi?ParName=FileReady&ParValue=%3C?xml%20version=%221.0%22%20encoding=%22gbk%22?%3E%3Croot%3E%09%3COrgCode%3ESEZB004%3C/OrgCode%3E%09%3CFileID%3E4328%3C/FileID%3E%09%3CFileName%3ETJC_TJC999_SEZB004_20160219_94935_KB.DBF%3C/FileName%3E%09%3CFileSize%3E2385%3C/FileSize%3E%09%3CMD5Code%3E67C64F6ADC9C6C997D307EEEA722FD17%3C/MD5Code%3E%3C/root%3E\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:12:\"117.78.9.192\";s:11:\"REMOTE_PORT\";s:4:\"8419\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:11:\"HTTP_ACCEPT\";s:70:\"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\";s:20:\"HTTP_ACCEPT_LANGUAGE\";s:13:\"zh-CN,zh;q=0.\";s:19:\"HTTP_ACCEPT_CHARSET\";s:23:\"GBK,utf-8;q=0.7,*;q=0.3\";s:15:\"HTTP_USER_AGENT\";s:30:\"User-Agent:Chrome/14.0.835.202\";s:17:\"HTTP_CONTENT_TYPE\";s:33:\"application/x-www-form-urlencoded\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459908098.2232029;s:12:\"REQUEST_TIME\";i:1459908098;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');
INSERT INTO `otc_api_log` VALUES ('49', 'FileReady', '<?xml version=\"1.0\" encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4328</FileID><FileName>TJC_TJC999_SEZB004_20160219_94935_KB.DBF</FileName><FileSize>2385</FileSize><MD5Code>67C64F6ADC9C6C997D307EEEA722FD17</MD5Code></root>', '执行时间：0.365秒||同步：(201604061001385444)api通知我方下载,文件下载失败0.341秒', '2016-04-06 10:01:38', '139.196.190.181', 'a:27:{s:4:\"USER\";s:3:\"www\";s:4:\"HOME\";s:12:\"/alidata/www\";s:9:\"FCGI_ROLE\";s:9:\"RESPONDER\";s:15:\"SCRIPT_FILENAME\";s:36:\"/alidata/www/default_bate4/index.php\";s:12:\"QUERY_STRING\";s:319:\"s=/Guest/Tjotcapi/otcapi&type=2&pid=201604061001385444&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4328</FileID><FileName>TJC_TJC999_SEZB004_20160219_94935_KB.DBF</FileName><FileSize>2385</FileSize><MD5Code>67C64F6ADC9C6C997D307EEEA722FD17</MD5Code></root>\";s:14:\"REQUEST_METHOD\";s:3:\"GET\";s:12:\"CONTENT_TYPE\";s:0:\"\";s:14:\"CONTENT_LENGTH\";s:0:\"\";s:11:\"SCRIPT_NAME\";s:10:\"/index.php\";s:11:\"REQUEST_URI\";s:318:\"//Guest/Tjotcapi/otcapi?type=2&pid=201604061001385444&ParName=FileReady&ParValue=<?xml%20version=\"1.0\"%20encoding=\"gbk\"?><root><OrgCode>SEZB004</OrgCode><FileID>4328</FileID><FileName>TJC_TJC999_SEZB004_20160219_94935_KB.DBF</FileName><FileSize>2385</FileSize><MD5Code>67C64F6ADC9C6C997D307EEEA722FD17</MD5Code></root>\";s:12:\"DOCUMENT_URI\";s:10:\"/index.php\";s:13:\"DOCUMENT_ROOT\";s:26:\"/alidata/www/default_bate4\";s:15:\"SERVER_PROTOCOL\";s:8:\"HTTP/1.1\";s:17:\"GATEWAY_INTERFACE\";s:7:\"CGI/1.1\";s:15:\"SERVER_SOFTWARE\";s:11:\"nginx/1.6.2\";s:11:\"REMOTE_ADDR\";s:15:\"139.196.190.181\";s:11:\"REMOTE_PORT\";s:5:\"17214\";s:11:\"SERVER_ADDR\";s:15:\"139.196.190.181\";s:11:\"SERVER_PORT\";s:2:\"80\";s:11:\"SERVER_NAME\";s:9:\"localhost\";s:15:\"REDIRECT_STATUS\";s:3:\"200\";s:9:\"HTTP_HOST\";s:15:\"139.196.190.181\";s:15:\"HTTP_CONNECTION\";s:5:\"Close\";s:8:\"PHP_SELF\";s:10:\"/index.php\";s:18:\"REQUEST_TIME_FLOAT\";d:1459908098.2303619;s:12:\"REQUEST_TIME\";i:1459908098;s:9:\"PATH_INFO\";s:15:\"Tjotcapi/otcapi\";}');

-- ----------------------------
-- Table structure for otc_api_uploadfile_log
-- ----------------------------
DROP TABLE IF EXISTS `otc_api_uploadfile_log`;
CREATE TABLE `otc_api_uploadfile_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `AccessToken` varchar(256) DEFAULT '',
  `OrgCode` varchar(256) DEFAULT '' COMMENT '机构编码(由结算所发放)',
  `FileID` int(11) DEFAULT '0' COMMENT '第三方机构对上传文件的编号',
  `FileName` varchar(256) DEFAULT '' COMMENT '文件名',
  `FileSize` int(11) DEFAULT '0' COMMENT '检查结果编号',
  `MD5Code` varchar(256) DEFAULT '' COMMENT '检查结果描述',
  `ReceiveFlag` int(11) DEFAULT '0' COMMENT '对应完全的log,otc_api_log',
  `ReceiveInfo` varchar(256) DEFAULT '' COMMENT '对应动做,gh/kh',
  `createtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FileID` (`FileID`) USING BTREE,
  KEY `FileSize` (`FileSize`) USING BTREE,
  KEY `ReceiveFlag` (`ReceiveFlag`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='上传文件成功后，检查完成后的回调(子)日志';

-- ----------------------------
-- Records of otc_api_uploadfile_log
-- ----------------------------

-- ----------------------------
-- Table structure for otc_auth_access
-- ----------------------------
DROP TABLE IF EXISTS `otc_auth_access`;
CREATE TABLE `otc_auth_access` (
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `role_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户组id',
  KEY `idx_uid` (`uid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of otc_auth_access
-- ----------------------------
INSERT INTO `otc_auth_access` VALUES ('2', '1');
INSERT INTO `otc_auth_access` VALUES ('46', '1');
INSERT INTO `otc_auth_access` VALUES ('1', '65');
INSERT INTO `otc_auth_access` VALUES ('1', '73');
INSERT INTO `otc_auth_access` VALUES ('1', '70');
INSERT INTO `otc_auth_access` VALUES ('1', '69');
INSERT INTO `otc_auth_access` VALUES ('1', '68');
INSERT INTO `otc_auth_access` VALUES ('1', '67');
INSERT INTO `otc_auth_access` VALUES ('1', '66');
INSERT INTO `otc_auth_access` VALUES ('2', '66');
INSERT INTO `otc_auth_access` VALUES ('2', '67');
INSERT INTO `otc_auth_access` VALUES ('3', '67');
INSERT INTO `otc_auth_access` VALUES ('1', '77');
INSERT INTO `otc_auth_access` VALUES ('1', '76');
INSERT INTO `otc_auth_access` VALUES ('1', '75');
INSERT INTO `otc_auth_access` VALUES ('1', '74');
INSERT INTO `otc_auth_access` VALUES ('8', '74');
INSERT INTO `otc_auth_access` VALUES ('9', '75');
INSERT INTO `otc_auth_access` VALUES ('10', '76');
INSERT INTO `otc_auth_access` VALUES ('11', '77');
INSERT INTO `otc_auth_access` VALUES ('4', '73');
INSERT INTO `otc_auth_access` VALUES ('5', '68');
INSERT INTO `otc_auth_access` VALUES ('6', '69');
INSERT INTO `otc_auth_access` VALUES ('7', '70');
INSERT INTO `otc_auth_access` VALUES ('12', '75');
INSERT INTO `otc_auth_access` VALUES ('13', '68');
INSERT INTO `otc_auth_access` VALUES ('14', '78');
INSERT INTO `otc_auth_access` VALUES ('15', '67');
INSERT INTO `otc_auth_access` VALUES ('19', '68');
INSERT INTO `otc_auth_access` VALUES ('19', '69');
INSERT INTO `otc_auth_access` VALUES ('19', '70');
INSERT INTO `otc_auth_access` VALUES ('19', '73');
INSERT INTO `otc_auth_access` VALUES ('18', '77');
INSERT INTO `otc_auth_access` VALUES ('18', '76');
INSERT INTO `otc_auth_access` VALUES ('18', '75');
INSERT INTO `otc_auth_access` VALUES ('18', '74');
INSERT INTO `otc_auth_access` VALUES ('23', '67');
INSERT INTO `otc_auth_access` VALUES ('23', '66');
INSERT INTO `otc_auth_access` VALUES ('22', '67');
INSERT INTO `otc_auth_access` VALUES ('21', '66');
INSERT INTO `otc_auth_access` VALUES ('20', '67');
INSERT INTO `otc_auth_access` VALUES ('17', '68');
INSERT INTO `otc_auth_access` VALUES ('17', '69');
INSERT INTO `otc_auth_access` VALUES ('17', '70');
INSERT INTO `otc_auth_access` VALUES ('17', '73');
INSERT INTO `otc_auth_access` VALUES ('16', '66');
INSERT INTO `otc_auth_access` VALUES ('21', '67');
INSERT INTO `otc_auth_access` VALUES ('16', '67');
INSERT INTO `otc_auth_access` VALUES ('14', '67');
INSERT INTO `otc_auth_access` VALUES ('14', '66');
INSERT INTO `otc_auth_access` VALUES ('1', '78');
INSERT INTO `otc_auth_access` VALUES ('1', '79');
INSERT INTO `otc_auth_access` VALUES ('24', '82');
INSERT INTO `otc_auth_access` VALUES ('24', '81');
INSERT INTO `otc_auth_access` VALUES ('24', '80');
INSERT INTO `otc_auth_access` VALUES ('1', '82');
INSERT INTO `otc_auth_access` VALUES ('1', '81');
INSERT INTO `otc_auth_access` VALUES ('1', '80');
INSERT INTO `otc_auth_access` VALUES ('25', '79');
INSERT INTO `otc_auth_access` VALUES ('26', '80');
INSERT INTO `otc_auth_access` VALUES ('26', '74');
INSERT INTO `otc_auth_access` VALUES ('26', '75');
INSERT INTO `otc_auth_access` VALUES ('26', '77');
INSERT INTO `otc_auth_access` VALUES ('26', '81');
INSERT INTO `otc_auth_access` VALUES ('26', '70');
INSERT INTO `otc_auth_access` VALUES ('26', '73');
INSERT INTO `otc_auth_access` VALUES ('26', '76');
INSERT INTO `otc_auth_access` VALUES ('26', '82');
INSERT INTO `otc_auth_access` VALUES ('26', '78');
INSERT INTO `otc_auth_access` VALUES ('27', '68');
INSERT INTO `otc_auth_access` VALUES ('27', '73');
INSERT INTO `otc_auth_access` VALUES ('26', '67');

-- ----------------------------
-- Table structure for otc_auth_node
-- ----------------------------
DROP TABLE IF EXISTS `otc_auth_node`;
CREATE TABLE `otc_auth_node` (
  `id` smallint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `pid` smallint(8) unsigned NOT NULL DEFAULT '0' COMMENT '自定:层级关系',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '规则中文描述',
  `module` varchar(80) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识',
  `url` varchar(200) NOT NULL DEFAULT '' COMMENT '连接地址',
  `iconcls` varchar(20) NOT NULL DEFAULT '' COMMENT '图标',
  `group` varchar(20) NOT NULL DEFAULT '' COMMENT '组',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1:后台管理节点，2:销售端节点',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序 优先级从小到大',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否有效(1:有效 ,2:无效)',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_pid` (`pid`) USING BTREE,
  KEY `idx_name` (`name`) USING BTREE,
  KEY `idx_type` (`type`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=179 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of otc_auth_node
-- ----------------------------
INSERT INTO `otc_auth_node` VALUES ('111', '110', '产品录入', 'product_add', '', '', 'summmarys.sysmodify', '1', '0', '1', '2016-01-01 16:46:00');
INSERT INTO `otc_auth_node` VALUES ('115', '118', '菜单节点管理', 'node', '', 'process-status-icon', '', '1', '0', '1', '2016-01-12 15:38:21');
INSERT INTO `otc_auth_node` VALUES ('118', '0', '系统管理', 'sysmodify', '', 'sys-set-icon', 'summarys', '1', '0', '1', '2016-01-25 08:48:06');
INSERT INTO `otc_auth_node` VALUES ('119', '118', '账号管理', 'user', '', 'xiaoxitongzhi-icon', '', '1', '0', '1', '0000-00-00 00:00:00');
INSERT INTO `otc_auth_node` VALUES ('120', '118', '机构管理', 'organization', '', 'process-table-icon', '', '1', '0', '1', '0000-00-00 00:00:00');
INSERT INTO `otc_auth_node` VALUES ('121', '118', '部门管理', 'department', '', 'notebook-icon', '', '1', '0', '1', '2016-01-23 13:08:58');
INSERT INTO `otc_auth_node` VALUES ('122', '118', '职位管理', 'position', '', 'notebook-icon', '', '1', '0', '1', '2016-01-23 13:09:00');
INSERT INTO `otc_auth_node` VALUES ('123', '118', '角色管理', 'role', '', 'process-table-icon', '', '1', '0', '1', '0000-00-00 00:00:00');
INSERT INTO `otc_auth_node` VALUES ('124', '0', '菜单节点管理', 'node', '', 'process-table-icon', '', '1', '0', '1', '2016-01-12 15:33:23');
INSERT INTO `otc_auth_node` VALUES ('137', '0', '通讯录', 'addressbook', '', 'notebook-icon', '', '1', '0', '2', '2016-01-23 13:06:32');
INSERT INTO `otc_auth_node` VALUES ('138', '0', '注册帐号审核', 'accountaudit', '', 'xiaoxitongzhi-icon', '', '1', '0', '1', '0000-00-00 00:00:00');
INSERT INTO `otc_auth_node` VALUES ('148', '169', '债权录入', 'claimsAdd', '', 'claims-add-icon', '', '1', '1', '1', '2016-02-03 10:21:41');
INSERT INTO `otc_auth_node` VALUES ('149', '118', '权限管理', 'permission', '', 'process-shenhe-icon', '', '1', '0', '1', '0000-00-00 00:00:00');
INSERT INTO `otc_auth_node` VALUES ('150', '169', '债权审核', 'claimsaudit', '', 'claims-audit-icon', '', '1', '2', '1', '2016-02-03 10:21:26');
INSERT INTO `otc_auth_node` VALUES ('151', '169', '债权发布', 'claimspublish', '', 'claims-publish-icon', '', '1', '3', '1', '2016-02-03 10:21:14');
INSERT INTO `otc_auth_node` VALUES ('152', '169', '债权管理', 'claimsmanage', '', 'claims-manage-icon', '', '1', '4', '1', '2016-02-03 10:12:52');
INSERT INTO `otc_auth_node` VALUES ('153', '172', '投资产品管理', 'investmentproducts', '', 'inv-manage-icon', '', '1', '4', '1', '2016-02-03 10:39:07');
INSERT INTO `otc_auth_node` VALUES ('155', '0', '新客户开户', 'custcreate', '', '', '', '2', '0', '1', '0000-00-00 00:00:00');
INSERT INTO `otc_auth_node` VALUES ('156', '0', '客户登录', 'custlogin', '', '', '', '2', '0', '1', '0000-00-00 00:00:00');
INSERT INTO `otc_auth_node` VALUES ('157', '0', '客户资料区', 'custlist', '', '', '', '2', '0', '1', '0000-00-00 00:00:00');
INSERT INTO `otc_auth_node` VALUES ('158', '0', '确权管理', 'ivsrightmanage', '', '', '', '2', '0', '1', '0000-00-00 00:00:00');
INSERT INTO `otc_auth_node` VALUES ('159', '0', '申购管理', 'ivsmanage', '', '', '', '2', '0', '1', '0000-00-00 00:00:00');
INSERT INTO `otc_auth_node` VALUES ('161', '0', '客户密码管理', 'custpwdchange', '', '', '', '2', '0', '1', '0000-00-00 00:00:00');
INSERT INTO `otc_auth_node` VALUES ('162', '0', '销售业务端', 'Guestindex', '/Guest', 'sales-icon', '', '1', '0', '1', '2016-01-19 16:26:54');
INSERT INTO `otc_auth_node` VALUES ('164', '0', '登出', 'test', '/Admin/Common/Loginout', 'user-node-icon', '', '1', '0', '2', '2016-02-01 17:16:09');
INSERT INTO `otc_auth_node` VALUES ('165', '172', '投资产品录入', 'investmentproductadd', '', 'inv-add-icon', '', '1', '1', '1', '2016-02-03 10:38:58');
INSERT INTO `otc_auth_node` VALUES ('166', '172', '投资产品审核', 'investmentproductaudit', '', 'inv-audit-icon', '', '1', '2', '1', '2016-02-03 10:38:50');
INSERT INTO `otc_auth_node` VALUES ('167', '0', '测试确权脚本', 'bat', '/Guest/Regularly/sendConfirm', 'process-table-icon', '', '1', '0', '1', '2016-01-24 00:44:40');
INSERT INTO `otc_auth_node` VALUES ('168', '172', '投资产品发布', 'investmentproductpublish', '', 'inv-publish-icon', '', '1', '3', '1', '2016-02-03 10:38:40');
INSERT INTO `otc_auth_node` VALUES ('169', '0', '债权工作台', 'claimsmanage', '', 'claims-platform-icon', 'summarys', '1', '0', '1', '2016-02-03 10:53:29');
INSERT INTO `otc_auth_node` VALUES ('170', '0', '测试回收30分钟未签署的记录脚本', 'bat', '/Guest/Regularly/cancelInvest', 'process-table-icon', '', '1', '0', '1', '2016-01-24 00:44:40');
INSERT INTO `otc_auth_node` VALUES ('172', '0', '投资产品工作台', 'investmentproductmanage', '', 'inv-platform-icon', 'summarys', '1', '0', '1', '2016-02-03 10:38:00');
INSERT INTO `otc_auth_node` VALUES ('173', '0', 'POS记录', 'ivslist', '', 'poslist-icon', '', '1', '1', '1', '2016-02-03 10:38:58');
INSERT INTO `otc_auth_node` VALUES ('178', '175', '资产包审核', 'foundationcheck', '', 'zijinshenhe-icon', '', '1', '2', '1', '2016-02-18 14:24:51');
INSERT INTO `otc_auth_node` VALUES ('175', '0', '资产包工作台', 'foundationmanage', '', 'fdtworktable-icon', 'summarys', '1', '0', '1', '2016-02-18 14:18:53');
INSERT INTO `otc_auth_node` VALUES ('176', '175', '资产包录入', 'foundationworktable', '', 'zijinluru-icon', '', '1', '1', '1', '2016-02-18 14:26:03');
INSERT INTO `otc_auth_node` VALUES ('177', '175', '资产包管理', 'foundationlist', '', 'zijinguanli-icon', '', '1', '3', '1', '2016-02-18 14:25:28');

-- ----------------------------
-- Table structure for otc_auth_permission
-- ----------------------------
DROP TABLE IF EXISTS `otc_auth_permission`;
CREATE TABLE `otc_auth_permission` (
  `permission_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限点ID',
  `permission_code` varchar(255) NOT NULL DEFAULT '' COMMENT '权限点代号',
  `permission_name` varchar(255) NOT NULL DEFAULT '' COMMENT '权限名称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:有效 ,2:无效',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `module-controller-action` varchar(255) DEFAULT '' COMMENT '模块-控制器-动作  用来判断入口',
  PRIMARY KEY (`permission_id`),
  UNIQUE KEY `permission_code` (`permission_code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=246 DEFAULT CHARSET=utf8 COMMENT='权限节点表';

-- ----------------------------
-- Records of otc_auth_permission
-- ----------------------------
INSERT INTO `otc_auth_permission` VALUES ('6', 'Guest-Cust-add', '销售端-客户-开户', '1', '0000-00-00 00:00:00', 'Guest-Cust-add');
INSERT INTO `otc_auth_permission` VALUES ('7', 'Guest-Cust-getcrm', '销售端-客户资料区-查看信息', '1', '0000-00-00 00:00:00', 'Guest-Cust-getcrm');
INSERT INTO `otc_auth_permission` VALUES ('8', 'Guest-Cust-setcrm', '销售端-客户资料区-保存信息', '1', '0000-00-00 00:00:00', 'Guest-Cust-setcrm');
INSERT INTO `otc_auth_permission` VALUES ('9', 'Guest-Cust-login', '销售端-客户-登录', '1', '0000-00-00 00:00:00', 'Guest-Cust-login');
INSERT INTO `otc_auth_permission` VALUES ('10', 'Guest-Cust-custlogout', '销售端-客户-登出', '1', '0000-00-00 00:00:00', 'Guest-Cust-custlogout');
INSERT INTO `otc_auth_permission` VALUES ('11', 'Guest-Cust-userlist', '销售端-客户资料区-列表', '1', '0000-00-00 00:00:00', 'Guest-Cust-userlist');
INSERT INTO `otc_auth_permission` VALUES ('12', 'Guest-Cust-custcheck', '销售端-客户-登录验证', '1', '0000-00-00 00:00:00', 'Guest-Cust-custcheck');
INSERT INTO `otc_auth_permission` VALUES ('13', 'Guest-Cust-getcustinfo', '销售端-客户-获取当前客户信息', '1', '0000-00-00 00:00:00', 'Guest-Cust-getcustinfo');
INSERT INTO `otc_auth_permission` VALUES ('14', 'Guest-Cust-uploadcrm_pic', '销售端-客户资料区-上传图片', '1', '0000-00-00 00:00:00', 'Guest-Cust-uploadcrm_pic');
INSERT INTO `otc_auth_permission` VALUES ('15', 'Guest-Cust-myivs_dnf', '销售端-申购管理-列表', '1', '0000-00-00 00:00:00', 'Guest-Cust-myivs_dnf');
INSERT INTO `otc_auth_permission` VALUES ('16', 'Admin-Cfmast-add', '管理端-投资产品-添加', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-add');
INSERT INTO `otc_auth_permission` VALUES ('18', 'Admin-Cfmast-releasemast', '管理端-投资产品-发布', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-releasemast');
INSERT INTO `otc_auth_permission` VALUES ('19', 'Admin-Cfmast-pausemast', '管理端-投资产品-暂停销售', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-pausemast');
INSERT INTO `otc_auth_permission` VALUES ('20', 'Admin-Cfmast-shelfmast', '管理端-投资产品-下架', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-shelfmast');
INSERT INTO `otc_auth_permission` VALUES ('21', 'Admin-Cfmast-update', '管理端-投资产品-编辑', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-update');
INSERT INTO `otc_auth_permission` VALUES ('23', 'Admin-Claims-getClaimslist', '管理端-债权-录入列表', '1', '0000-00-00 00:00:00', 'Admin-Claims-getClaimslist');
INSERT INTO `otc_auth_permission` VALUES ('24', 'Admin-Claims-getClaimsinfo', '管理端-债权-基本信息', '1', '0000-00-00 00:00:00', 'Admin-Claims-getClaimsinfo');
INSERT INTO `otc_auth_permission` VALUES ('25', 'Admin-Claims-saveClaims', '管理端-债权-新增编辑', '1', '0000-00-00 00:00:00', 'Admin-Claims-saveClaims');
INSERT INTO `otc_auth_permission` VALUES ('26', 'Admin-Claims-getClaimsAuditList', '管理端-债权-审核列表', '1', '0000-00-00 00:00:00', 'Admin-Claims-getClaimsAuditList');
INSERT INTO `otc_auth_permission` VALUES ('27', 'Admin-Claims-auditClaims', '管理端-债权-审核', '1', '0000-00-00 00:00:00', 'Admin-Claims-auditClaims');
INSERT INTO `otc_auth_permission` VALUES ('28', 'Admin-Claims-getClaimsReleaseList', '管理端-债权-发布列表', '1', '0000-00-00 00:00:00', 'Admin-Claims-getClaimsReleaseList');
INSERT INTO `otc_auth_permission` VALUES ('29', 'Admin-Claims-releaseClaims', '管理端-债权-发布', '1', '0000-00-00 00:00:00', 'Admin-Claims-releaseClaims');
INSERT INTO `otc_auth_permission` VALUES ('30', 'Admin-Claims-downClaims', '管理端-债权-下架', '1', '0000-00-00 00:00:00', 'Admin-Claims-downClaims');
INSERT INTO `otc_auth_permission` VALUES ('31', 'Admin-Claims-recyClaims', '管理端-债权-删除', '1', '0000-00-00 00:00:00', 'Admin-Claims-recyClaims');
INSERT INTO `otc_auth_permission` VALUES ('32', 'Guest-Product-getInvestList', '销售端-可投资产品列表', '1', '0000-00-00 00:00:00', 'Guest-Product-getInvestList');
INSERT INTO `otc_auth_permission` VALUES ('33', 'Guest-Product-getInvestInfo', '销售端-可投资产品列表-产品详情', '1', '0000-00-00 00:00:00', 'Guest-Product-getInvestInfo');
INSERT INTO `otc_auth_permission` VALUES ('35', 'Guest-Invest-doInvest', '销售端-可投资产品列表-产品详情-发起申购', '1', '0000-00-00 00:00:00', 'Guest-Invest-doInvest');
INSERT INTO `otc_auth_permission` VALUES ('36', 'Guest-Invest-finishInvest', '销售端-申购管理-确认申购', '1', '0000-00-00 00:00:00', 'Guest-Invest-finishInvest');
INSERT INTO `otc_auth_permission` VALUES ('37', 'Guest-Invest-cancelInvest', '销售端-申购管理-取消申购', '1', '0000-00-00 00:00:00', 'Guest-Invest-cancelInvest');
INSERT INTO `otc_auth_permission` VALUES ('38', 'Admin-Claims-claimsManager', '管理端-债权-管理列表', '1', '0000-00-00 00:00:00', 'Admin-Claims-claimsManager');
INSERT INTO `otc_auth_permission` VALUES ('39', 'Admin-User-updateSelfPassword', '管理端-系统-用户修改密码', '1', '0000-00-00 00:00:00', 'Admin-User-updateSelfPassword');
INSERT INTO `otc_auth_permission` VALUES ('41', 'Admin-Claims-claimRecord', '管理端-债权-产品投资记录', '1', '0000-00-00 00:00:00', 'Admin-Claims-claimRecord');
INSERT INTO `otc_auth_permission` VALUES ('42', 'Guest-Invest-clivslist', '销售端-确权管理-列表', '1', '0000-00-00 00:00:00', 'Guest-Invest-clivslist');
INSERT INTO `otc_auth_permission` VALUES ('43', 'Admin-Cfmast-tlist', '管理端-投资产品-管理列表', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-tlist');
INSERT INTO `otc_auth_permission` VALUES ('44', 'Admin-Cfmast-tdetail', '管理端-投资产品-基本信息', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-tdetail');
INSERT INTO `otc_auth_permission` VALUES ('45', 'Admin-Cfmast-productdetail', '管理端-投资产品-投资产品详情', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-productdetail');
INSERT INTO `otc_auth_permission` VALUES ('47', 'Admin-Cfmast-debtlist', '管理端-投资产品-投资产品详情-投资记录', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-debtlist');
INSERT INTO `otc_auth_permission` VALUES ('49', 'Guest-Cust-userModifypwd', '销售端-客户-修改密码', '1', '0000-00-00 00:00:00', 'Guest-Cust-userModifypwd');
INSERT INTO `otc_auth_permission` VALUES ('50', 'Admin-User-checkUser', '管理端-系统-用户审核', '1', '0000-00-00 00:00:00', 'Admin-User-checkUser');
INSERT INTO `otc_auth_permission` VALUES ('51', 'Admin-User-getUserInfoDetail', '管理端-系统-用户详情', '1', '0000-00-00 00:00:00', 'Admin-User-getUserInfoDetail');
INSERT INTO `otc_auth_permission` VALUES ('53', 'Admin-User-getUserList', '管理端-系统-用户列表', '1', '0000-00-00 00:00:00', 'Admin-User-getUserList');
INSERT INTO `otc_auth_permission` VALUES ('54', 'Admin-User-changeUser', '管理端-系统-用户启用or注销', '1', '0000-00-00 00:00:00', 'Admin-User-changeUser');
INSERT INTO `otc_auth_permission` VALUES ('57', 'Admin-User-saveUser', '管理端-系统-用户编辑', '1', '0000-00-00 00:00:00', 'Admin-User-saveUser');
INSERT INTO `otc_auth_permission` VALUES ('58', 'Admin-User-getUserRoleList', '管理端-获取当前用户角色', '1', '0000-00-00 00:00:00', 'Admin-User-getUserRoleList');
INSERT INTO `otc_auth_permission` VALUES ('59', 'Admin-User-userSetting', '管理端-用户个性化设置', '1', '0000-00-00 00:00:00', 'Admin-User-userSetting');
INSERT INTO `otc_auth_permission` VALUES ('60', 'Admin-User-getUserSetting', '管理端-获取用户个性化设置', '1', '0000-00-00 00:00:00', 'Admin-User-getUserSetting');
INSERT INTO `otc_auth_permission` VALUES ('61', 'Admin-User-resetPassword', '管理端-系统-重置用户密码', '1', '0000-00-00 00:00:00', 'Admin-User-resetPassword');
INSERT INTO `otc_auth_permission` VALUES ('63', 'Admin-System-getDepartmentInfo', '管理端-系统-获取部门信息', '1', '0000-00-00 00:00:00', 'Admin-System-getDepartmentInfo');
INSERT INTO `otc_auth_permission` VALUES ('64', 'Admin-System-getdepartmentList', '管理端-系统-部门列表', '1', '0000-00-00 00:00:00', 'Admin-System-getdepartmentList');
INSERT INTO `otc_auth_permission` VALUES ('65', 'Admin-System-saveDepartment', '管理端-系统-保存部门信息（添加或修改）', '1', '0000-00-00 00:00:00', 'Admin-System-saveDepartment');
INSERT INTO `otc_auth_permission` VALUES ('66', 'Admin-System-changeDepartment', '管理端-系统-部门启用、禁用、注销', '1', '0000-00-00 00:00:00', 'Admin-System-changeDepartment');
INSERT INTO `otc_auth_permission` VALUES ('67', 'Admin-System-getPositionList', '管理端-系统-职位列表', '1', '0000-00-00 00:00:00', 'Admin-System-getPositionList');
INSERT INTO `otc_auth_permission` VALUES ('68', 'Admin-System-getPositionInfo', '管理端-系统-职位信息', '1', '0000-00-00 00:00:00', 'Admin-System-getPositionInfo');
INSERT INTO `otc_auth_permission` VALUES ('69', 'Admin-System-savePosition', '管理端-系统-保存职位信息（添加或修改）', '1', '0000-00-00 00:00:00', 'Admin-System-savePosition');
INSERT INTO `otc_auth_permission` VALUES ('70', 'Admin-System-getRoleList', '管理端-系统-系统角色列表', '1', '0000-00-00 00:00:00', 'Admin-System-getRoleList');
INSERT INTO `otc_auth_permission` VALUES ('71', 'Admin-System-getRoleInfo', '管理端-系统-系统角色信息', '1', '0000-00-00 00:00:00', 'Admin-System-getRoleInfo');
INSERT INTO `otc_auth_permission` VALUES ('72', 'Admin-System-saveRole', '管理端-系统-保存角色（添加或修改）', '1', '0000-00-00 00:00:00', 'Admin-System-saveRole');
INSERT INTO `otc_auth_permission` VALUES ('73', 'Admin-System-saveNode', '管理端-系统-保存节点（添加或修改）', '1', '0000-00-00 00:00:00', 'Admin-System-saveNode');
INSERT INTO `otc_auth_permission` VALUES ('74', 'Admin-System-deleteNode', '管理端-系统-删除节点（删除）', '1', '0000-00-00 00:00:00', 'Admin-System-deleteNode');
INSERT INTO `otc_auth_permission` VALUES ('75', 'Admin-System-getNodeList', '管理端-系统-节点列表', '1', '0000-00-00 00:00:00', 'Admin-System-getNodeList');
INSERT INTO `otc_auth_permission` VALUES ('76', 'Admin-System-getNodeInfo', '管理端-系统-查看节点', '1', '0000-00-00 00:00:00', 'Admin-System-getNodeInfo');
INSERT INTO `otc_auth_permission` VALUES ('77', 'Admin-System-changeNode', '管理端-系统-节点 启用、禁用 切换', '1', '0000-00-00 00:00:00', 'Admin-System-changeNode');
INSERT INTO `otc_auth_permission` VALUES ('78', 'Admin-System-saveOrganization', '管理端-系统-保存机构', '1', '0000-00-00 00:00:00', 'Admin-System-saveOrganization');
INSERT INTO `otc_auth_permission` VALUES ('79', 'Admin-System-getOrganizationList', '管理端-系统-机构列表', '1', '0000-00-00 00:00:00', 'Admin-System-getOrganizationList');
INSERT INTO `otc_auth_permission` VALUES ('80', 'Admin-System-getOrganizationInfo', '管理端-系统-机构信息', '1', '0000-00-00 00:00:00', 'Admin-System-getOrganizationInfo');
INSERT INTO `otc_auth_permission` VALUES ('81', 'Admin-System-cancelOrganization', '管理端-系统-注销机构', '1', '0000-00-00 00:00:00', 'Admin-System-cancelOrganization');
INSERT INTO `otc_auth_permission` VALUES ('82', 'Admin-System-changeOrganization', '管理端-系统-机构 启用、禁用 切换', '1', '0000-00-00 00:00:00', 'Admin-System-changeOrganization');
INSERT INTO `otc_auth_permission` VALUES ('83', 'Admin-System-changePosition', '管理端-系统-职位 启用、禁用 切换', '1', '0000-00-00 00:00:00', 'Admin-System-changePosition');
INSERT INTO `otc_auth_permission` VALUES ('84', 'Admin-System-getOperationList', '管理端-系统-后台用户操作日志列表', '1', '0000-00-00 00:00:00', 'Admin-System-getOperationList');
INSERT INTO `otc_auth_permission` VALUES ('85', 'Admin-System-savePermission', '管理端-系统-权限添加、编辑', '1', '0000-00-00 00:00:00', 'Admin-System-savePermission');
INSERT INTO `otc_auth_permission` VALUES ('86', 'Admin-System-getPermissionInfo', '管理端-系统-获取权限信息', '1', '0000-00-00 00:00:00', 'Admin-System-getPermissionInfo');
INSERT INTO `otc_auth_permission` VALUES ('87', 'Admin-System-changePermission', '管理端-系统-权限启用、禁用 切换', '1', '0000-00-00 00:00:00', 'Admin-System-changePermission');
INSERT INTO `otc_auth_permission` VALUES ('88', 'Admin-System-getPermissionList', '管理端-系统-权限列表', '1', '0000-00-00 00:00:00', 'Admin-System-getPermissionList');
INSERT INTO `otc_auth_permission` VALUES ('89', 'Admin-System-getRoleNodeList', '管理端-系统-指定角色拥有的节点', '1', '0000-00-00 00:00:00', 'Admin-System-getRoleNodeList');
INSERT INTO `otc_auth_permission` VALUES ('90', 'Admin-System-getRolePermissionList', '管理端-系统-指定角色拥有的权限列表', '1', '0000-00-00 00:00:00', 'Admin-System-getRolePermissionList');
INSERT INTO `otc_auth_permission` VALUES ('91', 'Admin-System-cacheDepartment', '管理端-系统-缓存部门数据', '1', '0000-00-00 00:00:00', 'Admin-System-cacheDepartment');
INSERT INTO `otc_auth_permission` VALUES ('92', 'Admin-Claims-cfMastSelect', '管理端-债权-投资产品种类选项', '1', '0000-00-00 00:00:00', 'Admin-Claims-cfMastSelect');
INSERT INTO `otc_auth_permission` VALUES ('93', 'Admin-Claims-claimFileUpload', '管理端-债权-审核-证明文件及代码上传', '1', '0000-00-00 00:00:00', 'Admin-Claims-claimFileUpload');
INSERT INTO `otc_auth_permission` VALUES ('94', 'Admin-Claims-claimSubmit', '管理端-债权-提交', '1', '0000-00-00 00:00:00', 'Admin-Claims-claimSubmit');
INSERT INTO `otc_auth_permission` VALUES ('95', 'Admin-Cfmast-auditProduct', '管理端-投资产品-审核', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-auditProduct');
INSERT INTO `otc_auth_permission` VALUES ('96', 'Admin-Cfmast-productFileUpload', '管理端-投资产品-审核-证明文件及代码上传', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-productFileUpload');
INSERT INTO `otc_auth_permission` VALUES ('97', 'Admin-Cfmast-commit', '管理端-投资产品-提交', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-commit');
INSERT INTO `otc_auth_permission` VALUES ('100', 'Guest-Invest-getRightSchedule', '销售端-确权管理-确权进度', '1', '0000-00-00 00:00:00', 'Guest-Invest-getRightSchedule');
INSERT INTO `otc_auth_permission` VALUES ('101', 'Guest-Invest-purchaseUplodFile', '销售端-申购记录POS单附件上传功能', '1', '0000-00-00 00:00:00', 'Guest-Invest-purchaseUplodFile');
INSERT INTO `otc_auth_permission` VALUES ('102', 'Admin-Cfmast-getProductField', '管理端-投资产品-获取自定义字段内容', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-getProductField');
INSERT INTO `otc_auth_permission` VALUES ('103', 'Admin-Cfmast-saveProductSelfField', '管理端-投资产品-添加/编辑自定义字段', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-saveProductSelfField');
INSERT INTO `otc_auth_permission` VALUES ('104', 'Admin-Cfmast-saveProductSelfFieldValue', '管理端-投资产品-编辑自定义字段内容', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-saveProductSelfFieldValue');
INSERT INTO `otc_auth_permission` VALUES ('105', 'Admin-Cfmast-delProductSelfField', '管理端-投资产品-删除自定义字段', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-delProductSelfField');
INSERT INTO `otc_auth_permission` VALUES ('106', 'Guest-Product-getThisRecord', '销售端-可投资产品列表-产品详情-当期投资记录', '1', '0000-00-00 00:00:00', 'Guest-Product-getThisRecord');
INSERT INTO `otc_auth_permission` VALUES ('107', 'Guest-Invest-previewContractpdf', '销售端-申购管理-查看合同', '1', '0000-00-00 00:00:00', 'Guest-Invest-previewContractpdf');
INSERT INTO `otc_auth_permission` VALUES ('108', 'Guest-Invest-downContractpdf', '销售端-申购管理-下载合同', '1', '0000-00-00 00:00:00', 'Guest-Invest-downContractpdf');
INSERT INTO `otc_auth_permission` VALUES ('109', 'Admin-Claims-getInsertSelect', '管理端-债权-录入时间选项', '1', '0000-00-00 00:00:00', 'Admin-Claims-getInsertSelect');
INSERT INTO `otc_auth_permission` VALUES ('110', 'Admin-Claims-getStatusSelect', '管理端-债权-状态选项', '1', '0000-00-00 00:00:00', 'Admin-Claims-getStatusSelect');
INSERT INTO `otc_auth_permission` VALUES ('111', 'Admin-Claims-saveClaimSelfField', '管理端-债权-自定义字段新增编辑', '1', '0000-00-00 00:00:00', 'Admin-Claims-saveClaimSelfField');
INSERT INTO `otc_auth_permission` VALUES ('112', 'Admin-Claims-delClaimSelfField', '管理端-债权-自定义字段删除', '1', '0000-00-00 00:00:00', 'Admin-Claims-delClaimSelfField');
INSERT INTO `otc_auth_permission` VALUES ('113', 'Admin-User-updateSelfPasswordt', '管理端-个人设置-修改密码', '1', '0000-00-00 00:00:00', 'Admin-User-updateSelfPasswordt');
INSERT INTO `otc_auth_permission` VALUES ('114', 'Guest-Product-getThisDetail', '销售端-申购管理-投资详情', '1', '0000-00-00 00:00:00', 'Guest-Product-getThisDetail');
INSERT INTO `otc_auth_permission` VALUES ('115', 'Admin-Cfmast-getUncheckProduct', '管理端-投资产品-审核列表', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-getUncheckProduct');
INSERT INTO `otc_auth_permission` VALUES ('116', 'Admin-Cfmast-getUnfinishProduct', '管理端-投资产品-录入列表', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-getUnfinishProduct');
INSERT INTO `otc_auth_permission` VALUES ('117', 'Admin-Cfmast-getUnpublicProduct', '管理端-投资产品-发布列表', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-getUnpublicProduct');
INSERT INTO `otc_auth_permission` VALUES ('118', 'Guest-Invest-restartIvsRight', '销售端-确权管理-重新确权', '1', '0000-00-00 00:00:00', 'Guest-Invest-restartIvsRight');
INSERT INTO `otc_auth_permission` VALUES ('119', 'Admin-Cfmast-getClaimsInfo', '管理端-投资产品-债权基本信息', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-getClaimsInfo');
INSERT INTO `otc_auth_permission` VALUES ('120', 'Admin-Claims-claimAllUploadFile', '管理端-债权-上传文件列表', '1', '0000-00-00 00:00:00', 'Admin-Claims-claimAllUploadFile');
INSERT INTO `otc_auth_permission` VALUES ('121', 'Admin-Claims-claimDelUploadFile', '管理端-债权-删除上传文件', '1', '0000-00-00 00:00:00', 'Admin-Claims-claimDelUploadFile');
INSERT INTO `otc_auth_permission` VALUES ('122', 'Admin-Cfmast-delFiles', '管理端-投资产品-删除附件', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-delFiles');
INSERT INTO `otc_auth_permission` VALUES ('123', 'Admin-Cfmast-getFileList', '管理端-投资产品-附件列表', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-getFileList');
INSERT INTO `otc_auth_permission` VALUES ('124', 'Guest-Product-getCapitalpool', '销售端-可投资产品列表-投资方式', '1', '0000-00-00 00:00:00', 'Guest-Product-getCapitalpool');
INSERT INTO `otc_auth_permission` VALUES ('125', 'Admin-Cfmast-del', '管理端-投资产品-删除', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-del');
INSERT INTO `otc_auth_permission` VALUES ('127', 'Admin-Cfmast-getStatusSelect', '管理端-投资产品-状态选项', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-getStatusSelect');
INSERT INTO `otc_auth_permission` VALUES ('128', 'Admin-Claims-claimCapitalpool', '管理端-债权-投资模式', '1', '0000-00-00 00:00:00', 'Admin-Claims-claimCapitalpool');
INSERT INTO `otc_auth_permission` VALUES ('129', 'Admin-Cfmast-start', '管理端-投资产品-启动销售', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-start');
INSERT INTO `otc_auth_permission` VALUES ('132', 'Admin-Cfmast-getInsertSelect', '管理端-投资产品-时间选项', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-getInsertSelect');
INSERT INTO `otc_auth_permission` VALUES ('135', 'Admin-Cfmast-ViewClaimsInfo', '管理端-投资产品-投资产品详情-投资记录-关联债权', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-ViewClaimsInfo');
INSERT INTO `otc_auth_permission` VALUES ('136', 'Admin-Cfmast-productEdit', '管理端-投资产品-管理编辑', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-productEdit');
INSERT INTO `otc_auth_permission` VALUES ('137', 'Admin-Cfmast-publicBack', '管理端-投资产品-发布退回', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-publicBack');
INSERT INTO `otc_auth_permission` VALUES ('138', 'Admin-Claims-claimSendBack', '管理端-债权-发布退回', '1', '0000-00-00 00:00:00', 'Admin-Claims-claimSendBack');
INSERT INTO `otc_auth_permission` VALUES ('139', 'Admin-Cfmast-downfile', '管理端-投资产品-审核下载文件', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-downfile');
INSERT INTO `otc_auth_permission` VALUES ('140', 'Admin-Claims-downfile', '管理端-债权审核下载文件', '1', '0000-00-00 00:00:00', 'Admin-Claims-downfile');
INSERT INTO `otc_auth_permission` VALUES ('141', 'user-check', '用户审核', '1', '2016-01-27 11:40:48', '');
INSERT INTO `otc_auth_permission` VALUES ('142', 'user-edit', '用户编辑', '1', '2016-01-27 11:40:35', '');
INSERT INTO `otc_auth_permission` VALUES ('143', 'msg-add', '消息添加', '1', '2016-01-27 11:40:38', '');
INSERT INTO `otc_auth_permission` VALUES ('144', 'msg-del', '消息删除', '1', '2016-01-27 11:40:50', '');
INSERT INTO `otc_auth_permission` VALUES ('145', 'msg-edit', '消息编辑', '1', '2016-01-27 11:40:53', '');
INSERT INTO `otc_auth_permission` VALUES ('146', 'user-add', '用户添加', '1', '2016-01-27 11:40:55', '');
INSERT INTO `otc_auth_permission` VALUES ('148', 'role.add', '角色新增', '1', '2016-01-16 14:02:46', '');
INSERT INTO `otc_auth_permission` VALUES ('149', 'role.edit', '角色编辑', '1', '2016-01-16 14:02:46', '');
INSERT INTO `otc_auth_permission` VALUES ('150', 'role.start', '角色启用', '1', '2016-01-12 11:36:05', '');
INSERT INTO `otc_auth_permission` VALUES ('151', 'role.cancel', '角色禁用', '1', '2016-01-12 11:36:05', '');
INSERT INTO `otc_auth_permission` VALUES ('152', 'role.view', '角色查看', '1', '2016-01-16 14:02:46', '');
INSERT INTO `otc_auth_permission` VALUES ('153', 'organization.view', '机构查看', '1', '2016-01-16 13:27:12', '');
INSERT INTO `otc_auth_permission` VALUES ('154', 'organization.edit', '机构编辑', '3', '2016-01-27 21:00:49', '');
INSERT INTO `otc_auth_permission` VALUES ('156', 'organization.add', '机构新增', '1', '2016-01-16 13:35:27', '');
INSERT INTO `otc_auth_permission` VALUES ('157', 'organization.start', '机构启用', '1', '2016-01-16 13:37:10', '');
INSERT INTO `otc_auth_permission` VALUES ('158', 'organization.stop', '机构禁用', '1', '2016-01-16 13:37:27', '');
INSERT INTO `otc_auth_permission` VALUES ('159', 'organization.logoff', '机构注销', '1', '2016-01-16 13:39:47', '');
INSERT INTO `otc_auth_permission` VALUES ('160', 'department.view', '部门查看', '1', '2016-01-16 13:43:02', '');
INSERT INTO `otc_auth_permission` VALUES ('161', 'department.add', '部门新增', '1', '2016-01-16 13:43:14', '');
INSERT INTO `otc_auth_permission` VALUES ('162', 'department.edit', '部门编辑', '1', '2016-01-16 13:43:25', '');
INSERT INTO `otc_auth_permission` VALUES ('163', 'department.start', '部门启用', '1', '2016-01-16 13:43:32', '');
INSERT INTO `otc_auth_permission` VALUES ('164', 'department.stop', '部门禁用', '1', '2016-01-16 13:43:49', '');
INSERT INTO `otc_auth_permission` VALUES ('165', 'department.logoff', '部门注销', '1', '2016-01-16 13:43:58', '');
INSERT INTO `otc_auth_permission` VALUES ('166', 'position.view', '职位查看', '1', '2016-01-16 13:44:30', '');
INSERT INTO `otc_auth_permission` VALUES ('167', 'position.add', '职位新增', '1', '2016-01-16 13:44:45', '');
INSERT INTO `otc_auth_permission` VALUES ('168', 'position.edit', '职位编辑', '1', '2016-01-16 13:45:00', '');
INSERT INTO `otc_auth_permission` VALUES ('169', 'position.start', '职位启用', '1', '2016-01-16 13:45:15', '');
INSERT INTO `otc_auth_permission` VALUES ('170', 'position.stop', '职位禁用', '1', '2016-01-16 13:45:30', '');
INSERT INTO `otc_auth_permission` VALUES ('171', 'position.logoff', '职位注销', '1', '2016-01-16 13:45:48', '');
INSERT INTO `otc_auth_permission` VALUES ('172', 'user.view', '账号查看', '1', '2016-01-16 13:47:31', '');
INSERT INTO `otc_auth_permission` VALUES ('173', 'user.add', '账号新增', '1', '2016-01-16 13:47:46', '');
INSERT INTO `otc_auth_permission` VALUES ('174', 'user.edit', '账号编辑', '1', '2016-01-16 13:48:00', '');
INSERT INTO `otc_auth_permission` VALUES ('175', 'user.start', '账号启用', '1', '2016-01-16 13:48:14', '');
INSERT INTO `otc_auth_permission` VALUES ('176', 'user.stop', '账号禁用', '1', '2016-01-16 13:48:41', '');
INSERT INTO `otc_auth_permission` VALUES ('177', 'user.logoff', '账号注销', '1', '2016-01-16 13:49:14', '');
INSERT INTO `otc_auth_permission` VALUES ('182', 'role.stop', '角色禁用', '1', '2016-01-16 13:56:15', '');
INSERT INTO `otc_auth_permission` VALUES ('183', 'role.logoff', '角色注销', '1', '2016-01-16 13:56:34', '');
INSERT INTO `otc_auth_permission` VALUES ('184', 'node.view', '节点查看', '1', '2016-01-16 13:58:09', '');
INSERT INTO `otc_auth_permission` VALUES ('185', 'node.add', '节点新增', '1', '2016-01-16 13:58:20', '');
INSERT INTO `otc_auth_permission` VALUES ('186', 'node.edit', '节点编辑', '1', '2016-01-16 13:58:33', '');
INSERT INTO `otc_auth_permission` VALUES ('187', 'node.start', '节点启用', '1', '2016-01-16 13:58:45', '');
INSERT INTO `otc_auth_permission` VALUES ('188', 'node.stop', '节点禁用', '1', '2016-01-16 13:58:59', '');
INSERT INTO `otc_auth_permission` VALUES ('189', 'node.logoff', '节点注销', '1', '2016-01-16 13:59:12', '');
INSERT INTO `otc_auth_permission` VALUES ('190', 'permission.view', '权限查看', '1', '2016-01-16 13:59:51', '');
INSERT INTO `otc_auth_permission` VALUES ('191', 'permission.add', '权限新增', '1', '2016-01-16 14:00:07', '');
INSERT INTO `otc_auth_permission` VALUES ('192', 'permission.edit', '权限编辑', '1', '2016-01-16 14:00:18', '');
INSERT INTO `otc_auth_permission` VALUES ('193', 'permission.start', '权限启用', '1', '2016-01-16 14:00:34', '');
INSERT INTO `otc_auth_permission` VALUES ('194', 'permission.stop', '权限禁用', '1', '2016-01-16 14:00:46', '');
INSERT INTO `otc_auth_permission` VALUES ('195', 'permission.logoff', '权限注销', '1', '2016-01-16 14:01:01', '');
INSERT INTO `otc_auth_permission` VALUES ('196', 'accountaudit.apportion', '注册审核角色分配', '1', '2016-01-16 16:07:10', '');
INSERT INTO `otc_auth_permission` VALUES ('197', 'accountaudit.refuse', '注册审核拒绝', '1', '2016-01-16 16:07:49', '');
INSERT INTO `otc_auth_permission` VALUES ('198', 'announcement.add', '公告新增', '1', '2016-01-16 16:50:12', '');
INSERT INTO `otc_auth_permission` VALUES ('199', 'announcement.view', '公告查看', '1', '2016-01-16 16:50:29', '');
INSERT INTO `otc_auth_permission` VALUES ('200', 'announcement.cancel', '公告撤销', '1', '2016-01-20 22:12:26', '');
INSERT INTO `otc_auth_permission` VALUES ('201', 'announcement.delete', '公告删除', '1', '2016-01-16 16:51:17', '');
INSERT INTO `otc_auth_permission` VALUES ('202', 'announcement.return', '公告还原', '1', '2016-01-16 16:51:36', '');
INSERT INTO `otc_auth_permission` VALUES ('203', 'role.fenpei', '角色分配权限', '1', '2016-01-27 14:06:16', '');
INSERT INTO `otc_auth_permission` VALUES ('204', 'role.fenpeinode', '角色分配菜单', '1', '2016-01-27 14:06:38', '');
INSERT INTO `otc_auth_permission` VALUES ('205', 'dosomething.view', '待办事项查看', '1', '2016-01-27 20:54:39', '');
INSERT INTO `otc_auth_permission` VALUES ('206', 'dosomething.delete', '待办事项删除', '1', '2016-01-27 20:55:51', '');
INSERT INTO `otc_auth_permission` VALUES ('207', 'announcement.edit', '公告编辑', '1', '2016-01-27 21:10:20', '');
INSERT INTO `otc_auth_permission` VALUES ('208', 'announcement.issue', '公告发布', '1', '2016-02-03 15:28:23', '');
INSERT INTO `otc_auth_permission` VALUES ('209', 'Guest.allreader', '销售端查看所有', '1', '2016-02-03 21:58:48', '');
INSERT INTO `otc_auth_permission` VALUES ('210', 'Admin-Cfmast-poslist', '管理端-投资记录-列表', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-poslist');
INSERT INTO `otc_auth_permission` VALUES ('211', 'Admin-Cfmast-outpos2excel', '管理端-投资记录-导出EXCEL', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-outpos2excel');
INSERT INTO `otc_auth_permission` VALUES ('213', 'Admin-Cfmast-downposfile', '管理端-投资记录-POS扫描件下载', '1', '2016-03-02 09:04:08', 'Admin-Cfmast-downposfile');
INSERT INTO `otc_auth_permission` VALUES ('214', 'Admin-Cfmast-ZipPosFiles', '管理端-投资记录-POS扫描件打包下载', '1', '2016-03-02 09:04:18', 'Admin-Cfmast-ZipPosFiles');
INSERT INTO `otc_auth_permission` VALUES ('215', 'Admin-Foundation-allFoundation', '管理端-债权-根据投资模式返回资产包', '1', '2016-02-17 10:55:32', 'Admin-Claims-allFoundation');
INSERT INTO `otc_auth_permission` VALUES ('216', 'Admin-Foundation-foundationList', '管理端-资产包-管理列表', '1', '2016-02-17 10:55:24', 'Admin-Claims-foundationList');
INSERT INTO `otc_auth_permission` VALUES ('217', 'Admin-Foundation-recyFoundation', '管理端-资产包-删除', '1', '2016-02-17 10:55:15', 'Admin-Claims-recyFoundation');
INSERT INTO `otc_auth_permission` VALUES ('218', 'Admin-Foundation-editFoundation', '管理端-资产包-编辑', '1', '2016-02-17 10:55:07', 'Admin-Claims-editFoundation');
INSERT INTO `otc_auth_permission` VALUES ('219', 'Admin-Foundation-viewFoundation', '管理端-资产包-查看', '1', '2016-02-17 10:54:59', 'Admin-Claims-viewFoundation');
INSERT INTO `otc_auth_permission` VALUES ('220', 'Admin-Foundation-addFoundation', '管理端-资产包-新增', '1', '2016-02-17 10:54:48', 'Admin-Claims-addFoundation');
INSERT INTO `otc_auth_permission` VALUES ('221', 'Admin-Cfmast-allFoundation', '管理端-投资产品-资产包清单', '1', '2016-03-02 09:04:54', 'Admin-Cfmast-allFoundation');
INSERT INTO `otc_auth_permission` VALUES ('222', 'Admin-Foundation-auditFoundation', '管理端-资产包-审核通过', '1', '0000-00-00 00:00:00', 'Admin-Foundation-auditFoundation');
INSERT INTO `otc_auth_permission` VALUES ('223', 'Admin-Foundation-allHolder', '管理端-资产包-持有人列表', '1', '0000-00-00 00:00:00', 'Admin-Foundation-allHolder');
INSERT INTO `otc_auth_permission` VALUES ('224', 'Admin-Foundation-foundationSubmit', '管理端-资产包-提交到待审核', '1', '0000-00-00 00:00:00', 'Admin-Foundation-foundationSubmit');
INSERT INTO `otc_auth_permission` VALUES ('225', 'Admin-Foundation-foundAllClaims', '管理端-资产包-债权清单', '1', '0000-00-00 00:00:00', 'Admin-Foundation-foundAllClaims');
INSERT INTO `otc_auth_permission` VALUES ('226', 'Admin-Foundation-FoundAllUploadFile', '管理端-资产包-附件列表', '1', '0000-00-00 00:00:00', 'Admin-Foundation-FoundAllUploadFile');
INSERT INTO `otc_auth_permission` VALUES ('227', 'Admin-Foundation-foundationFileUpload', '管理端-资产包-上传文件', '1', '0000-00-00 00:00:00', 'Admin-Foundation-foundationFileUpload');
INSERT INTO `otc_auth_permission` VALUES ('228', 'Admin-Foundation-FoundDelUploadFile', '管理端-资产包-删除上传文件', '1', '0000-00-00 00:00:00', 'Admin-Foundation-FoundDelUploadFile');
INSERT INTO `otc_auth_permission` VALUES ('229', 'Admin-Foundation-downFile', '管理端-资产包-下载文件', '1', '0000-00-00 00:00:00', 'Admin-Foundation-downFile');
INSERT INTO `otc_auth_permission` VALUES ('230', 'Admin-Foundation-getBufferFound', '管理端-资产包-录入列表', '1', '0000-00-00 00:00:00', 'Admin-Foundation-getBufferFound');
INSERT INTO `otc_auth_permission` VALUES ('231', 'Admin-Foundation-getFundsAuditList', '管理端-资产包-待审核列表', '1', '0000-00-00 00:00:00', 'Admin-Foundation-getFundsAuditList');
INSERT INTO `otc_auth_permission` VALUES ('232', 'Admin-Foundation-foundSendBack', '管理端-资产包-审核退回', '1', '0000-00-00 00:00:00', 'Admin-Foundation-foundSendBack');
INSERT INTO `otc_auth_permission` VALUES ('233', 'Admin-Foundation-cfMastSelect', '管理端-资产包-产品列表接口', '1', '0000-00-00 00:00:00', 'Admin-Foundation-cfMastSelect');
INSERT INTO `otc_auth_permission` VALUES ('234', 'Admin-Foundation-allFoundStatus', '管理端-资产包-资产包状态接口', '1', '0000-00-00 00:00:00', 'Admin-Foundation-allFoundStatus');
INSERT INTO `otc_auth_permission` VALUES ('235', 'Admin-Cfmast-capitalbags', '管理端-投资产品-资产包查看', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-capitalbags');
INSERT INTO `otc_auth_permission` VALUES ('236', 'Admin-Foundation-pauseFound', '管理端-资产包-暂停使用', '1', '0000-00-00 00:00:00', 'Admin-Foundation-pauseFound');
INSERT INTO `otc_auth_permission` VALUES ('237', 'Admin-Foundation-resumeFound', '管理端-资产包-恢复使用', '1', '0000-00-00 00:00:00', 'Admin-Foundation-resumeFound');
INSERT INTO `otc_auth_permission` VALUES ('238', 'Guest-Invest-redemptionInvest', '销售端-申购管理-赎回', '1', '0000-00-00 00:00:00', 'Guest-Invest-redemptionInvest');
INSERT INTO `otc_auth_permission` VALUES ('239', 'Admin-Foundation-repurchase', '管理端-资产包-回购', '1', '0000-00-00 00:00:00', 'Admin-Foundation-repurchase');
INSERT INTO `otc_auth_permission` VALUES ('240', 'Guest-Invest-prewDetailpdf', '销售端-查看债权受让及出让协议', '1', '0000-00-00 00:00:00', 'Guest-Invest-prewDetailpdf');
INSERT INTO `otc_auth_permission` VALUES ('241', 'Guest-Invest-prewLoanpdf', '销售端-查看客户资金出借情况报告', '1', '0000-00-00 00:00:00', 'Guest-Invest-prewLoanpdf');
INSERT INTO `otc_auth_permission` VALUES ('242', 'Admin-Cfmast-confirmArrival', '管理端-投资记录-确认到账', '1', '0000-00-00 00:00:00', 'Admin-Cfmast-confirmArrival');
INSERT INTO `otc_auth_permission` VALUES ('243', 'Guest-Invest-prewCheckacc', '销售端-债权出让款项到账确认函', '1', '0000-00-00 00:00:00', 'Guest-Invest-prewCheckacc');
INSERT INTO `otc_auth_permission` VALUES ('244', 'Guest-Invest-downDetailpdf', '销售端-下载债权受让及出让协议', '1', '0000-00-00 00:00:00', 'Guest-Invest-downDetailpdf');
INSERT INTO `otc_auth_permission` VALUES ('245', 'Guest-Invest-downLoanpdf', '销售端-下载客户资金出借情况报告', '1', '0000-00-00 00:00:00', 'Guest-Invest-downLoanpdf');

-- ----------------------------
-- Table structure for otc_auth_role
-- ----------------------------
DROP TABLE IF EXISTS `otc_auth_role`;
CREATE TABLE `otc_auth_role` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '自定:描述信息',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '角色状态：为1正常，2为删除,为3禁用',
  `sort` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加、更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of otc_auth_role
-- ----------------------------
INSERT INTO `otc_auth_role` VALUES ('65', '系统管理员', '系统管理员', '1', '0', '2016-01-12 15:01:25');
INSERT INTO `otc_auth_role` VALUES ('66', '销售业务经理', '销售业务经理', '1', '0', '2016-01-19 11:40:29');
INSERT INTO `otc_auth_role` VALUES ('67', '客服专员', '客服专员', '1', '0', '2016-03-30 17:52:06');
INSERT INTO `otc_auth_role` VALUES ('68', '债权录入员', '债权录入员', '1', '0', '2016-01-19 11:41:36');
INSERT INTO `otc_auth_role` VALUES ('69', '债权审核员', '债权审核员', '1', '0', '2016-01-19 11:41:31');
INSERT INTO `otc_auth_role` VALUES ('70', '债权发布员', '债权发布员', '1', '0', '2016-01-19 11:41:25');
INSERT INTO `otc_auth_role` VALUES ('73', '债权管理员', '债权管理员', '1', '0', '2016-01-19 13:10:58');
INSERT INTO `otc_auth_role` VALUES ('74', '投资产品管理员', '投资产品管理员', '1', '0', '2016-01-19 13:22:15');
INSERT INTO `otc_auth_role` VALUES ('75', '投资产品录入员', '投资产品录入员', '1', '0', '2016-01-21 12:00:38');
INSERT INTO `otc_auth_role` VALUES ('76', '投资产品审核员', '投资产品审核员', '1', '0', '2016-01-21 12:00:47');
INSERT INTO `otc_auth_role` VALUES ('77', '投资产品发布员', '投资产品发布员', '1', '0', '2016-01-21 12:00:54');
INSERT INTO `otc_auth_role` VALUES ('78', '客服主管', '客服主管', '1', '0', '2016-03-30 17:50:41');
INSERT INTO `otc_auth_role` VALUES ('79', '财务', '财务', '1', '0', '2016-02-04 10:12:50');
INSERT INTO `otc_auth_role` VALUES ('80', '资产包录入员', '资产包录入员', '1', '0', '2016-02-17 19:04:20');
INSERT INTO `otc_auth_role` VALUES ('81', '资产包审核员', '资产包审核员', '1', '0', '2016-02-17 19:04:28');
INSERT INTO `otc_auth_role` VALUES ('82', '资产包管理员', '资产包管理员', '1', '0', '2016-02-17 19:04:39');

-- ----------------------------
-- Table structure for otc_auth_role_node
-- ----------------------------
DROP TABLE IF EXISTS `otc_auth_role_node`;
CREATE TABLE `otc_auth_role_node` (
  `node_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '0',
  `role_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角度节点关系表';

-- ----------------------------
-- Records of otc_auth_role_node
-- ----------------------------
INSERT INTO `otc_auth_role_node` VALUES ('1', '3');
INSERT INTO `otc_auth_role_node` VALUES ('1', '1');
INSERT INTO `otc_auth_role_node` VALUES ('2', '3');
INSERT INTO `otc_auth_role_node` VALUES ('3', '3');
INSERT INTO `otc_auth_role_node` VALUES ('3', '1');
INSERT INTO `otc_auth_role_node` VALUES ('5', '1');
INSERT INTO `otc_auth_role_node` VALUES ('123', '65');
INSERT INTO `otc_auth_role_node` VALUES ('122', '65');
INSERT INTO `otc_auth_role_node` VALUES ('121', '65');
INSERT INTO `otc_auth_role_node` VALUES ('120', '65');
INSERT INTO `otc_auth_role_node` VALUES ('119', '65');
INSERT INTO `otc_auth_role_node` VALUES ('118', '65');
INSERT INTO `otc_auth_role_node` VALUES ('115', '65');
INSERT INTO `otc_auth_role_node` VALUES ('148', '65');
INSERT INTO `otc_auth_role_node` VALUES ('149', '65');
INSERT INTO `otc_auth_role_node` VALUES ('150', '65');
INSERT INTO `otc_auth_role_node` VALUES ('151', '65');
INSERT INTO `otc_auth_role_node` VALUES ('152', '65');
INSERT INTO `otc_auth_role_node` VALUES ('153', '65');
INSERT INTO `otc_auth_role_node` VALUES ('154', '65');
INSERT INTO `otc_auth_role_node` VALUES ('160', '65');
INSERT INTO `otc_auth_role_node` VALUES ('159', '65');
INSERT INTO `otc_auth_role_node` VALUES ('158', '65');
INSERT INTO `otc_auth_role_node` VALUES ('157', '65');
INSERT INTO `otc_auth_role_node` VALUES ('156', '65');
INSERT INTO `otc_auth_role_node` VALUES ('155', '65');
INSERT INTO `otc_auth_role_node` VALUES ('160', '67');
INSERT INTO `otc_auth_role_node` VALUES ('159', '67');
INSERT INTO `otc_auth_role_node` VALUES ('158', '67');
INSERT INTO `otc_auth_role_node` VALUES ('157', '67');
INSERT INTO `otc_auth_role_node` VALUES ('156', '67');
INSERT INTO `otc_auth_role_node` VALUES ('155', '67');
INSERT INTO `otc_auth_role_node` VALUES ('161', '66');
INSERT INTO `otc_auth_role_node` VALUES ('162', '65');
INSERT INTO `otc_auth_role_node` VALUES ('162', '67');
INSERT INTO `otc_auth_role_node` VALUES ('162', '66');
INSERT INTO `otc_auth_role_node` VALUES ('164', '65');
INSERT INTO `otc_auth_role_node` VALUES ('165', '65');
INSERT INTO `otc_auth_role_node` VALUES ('166', '65');
INSERT INTO `otc_auth_role_node` VALUES ('167', '65');
INSERT INTO `otc_auth_role_node` VALUES ('168', '65');
INSERT INTO `otc_auth_role_node` VALUES ('169', '65');
INSERT INTO `otc_auth_role_node` VALUES ('170', '65');
INSERT INTO `otc_auth_role_node` VALUES ('171', '65');
INSERT INTO `otc_auth_role_node` VALUES ('172', '65');
INSERT INTO `otc_auth_role_node` VALUES ('169', '68');
INSERT INTO `otc_auth_role_node` VALUES ('169', '69');
INSERT INTO `otc_auth_role_node` VALUES ('169', '70');
INSERT INTO `otc_auth_role_node` VALUES ('169', '73');
INSERT INTO `otc_auth_role_node` VALUES ('152', '73');
INSERT INTO `otc_auth_role_node` VALUES ('151', '70');
INSERT INTO `otc_auth_role_node` VALUES ('150', '69');
INSERT INTO `otc_auth_role_node` VALUES ('148', '68');
INSERT INTO `otc_auth_role_node` VALUES ('172', '74');
INSERT INTO `otc_auth_role_node` VALUES ('153', '74');
INSERT INTO `otc_auth_role_node` VALUES ('165', '75');
INSERT INTO `otc_auth_role_node` VALUES ('172', '75');
INSERT INTO `otc_auth_role_node` VALUES ('172', '77');
INSERT INTO `otc_auth_role_node` VALUES ('168', '77');
INSERT INTO `otc_auth_role_node` VALUES ('164', '77');
INSERT INTO `otc_auth_role_node` VALUES ('164', '76');
INSERT INTO `otc_auth_role_node` VALUES ('164', '75');
INSERT INTO `otc_auth_role_node` VALUES ('164', '74');
INSERT INTO `otc_auth_role_node` VALUES ('164', '73');
INSERT INTO `otc_auth_role_node` VALUES ('164', '70');
INSERT INTO `otc_auth_role_node` VALUES ('164', '69');
INSERT INTO `otc_auth_role_node` VALUES ('164', '68');
INSERT INTO `otc_auth_role_node` VALUES ('164', '67');
INSERT INTO `otc_auth_role_node` VALUES ('166', '76');
INSERT INTO `otc_auth_role_node` VALUES ('172', '76');
INSERT INTO `otc_auth_role_node` VALUES ('162', '78');
INSERT INTO `otc_auth_role_node` VALUES ('173', '79');
INSERT INTO `otc_auth_role_node` VALUES ('174', '65');
INSERT INTO `otc_auth_role_node` VALUES ('175', '65');
INSERT INTO `otc_auth_role_node` VALUES ('176', '65');
INSERT INTO `otc_auth_role_node` VALUES ('177', '65');
INSERT INTO `otc_auth_role_node` VALUES ('178', '65');
INSERT INTO `otc_auth_role_node` VALUES ('176', '80');
INSERT INTO `otc_auth_role_node` VALUES ('177', '80');
INSERT INTO `otc_auth_role_node` VALUES ('178', '81');
INSERT INTO `otc_auth_role_node` VALUES ('176', '81');
INSERT INTO `otc_auth_role_node` VALUES ('175', '82');
INSERT INTO `otc_auth_role_node` VALUES ('176', '82');
INSERT INTO `otc_auth_role_node` VALUES ('151', '83');
INSERT INTO `otc_auth_role_node` VALUES ('168', '83');
INSERT INTO `otc_auth_role_node` VALUES ('177', '83');
INSERT INTO `otc_auth_role_node` VALUES ('166', '83');
INSERT INTO `otc_auth_role_node` VALUES ('178', '83');
INSERT INTO `otc_auth_role_node` VALUES ('165', '83');
INSERT INTO `otc_auth_role_node` VALUES ('176', '83');
INSERT INTO `otc_auth_role_node` VALUES ('111', '83');
INSERT INTO `otc_auth_role_node` VALUES ('169', '83');
INSERT INTO `otc_auth_role_node` VALUES ('175', '83');
INSERT INTO `otc_auth_role_node` VALUES ('172', '83');
INSERT INTO `otc_auth_role_node` VALUES ('162', '83');
INSERT INTO `otc_auth_role_node` VALUES ('150', '83');

-- ----------------------------
-- Table structure for otc_auth_role_permission
-- ----------------------------
DROP TABLE IF EXISTS `otc_auth_role_permission`;
CREATE TABLE `otc_auth_role_permission` (
  `role_id` int(10) unsigned NOT NULL DEFAULT '0',
  `permission_id` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `role_permission` (`role_id`,`permission_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限节点表';

-- ----------------------------
-- Records of otc_auth_role_permission
-- ----------------------------
INSERT INTO `otc_auth_role_permission` VALUES ('1', '1');
INSERT INTO `otc_auth_role_permission` VALUES ('1', '2');
INSERT INTO `otc_auth_role_permission` VALUES ('2', '4');
INSERT INTO `otc_auth_role_permission` VALUES ('2', '4');
INSERT INTO `otc_auth_role_permission` VALUES ('3', '2');
INSERT INTO `otc_auth_role_permission` VALUES ('3', '3');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '1');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '2');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '3');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '4');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '41');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '43');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '44');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '45');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '47');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '48');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '49');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '50');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '51');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '53');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '54');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '57');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '58');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '59');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '60');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '61');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '63');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '64');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '65');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '66');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '67');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '68');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '69');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '70');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '71');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '72');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '73');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '74');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '75');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '76');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '77');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '78');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '79');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '80');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '81');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '82');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '83');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '84');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '85');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '86');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '87');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '88');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '89');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '90');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '91');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '141');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '142');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '143');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '144');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '145');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '146');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '148');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '149');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '150');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '151');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '152');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '153');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '156');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '157');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '158');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '159');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '160');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '161');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '162');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '163');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '164');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '165');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '166');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '167');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '168');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '169');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '170');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '171');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '172');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '173');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '174');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '175');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '176');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '177');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '182');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '183');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '184');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '185');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '186');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '187');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '188');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '189');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '190');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '191');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '192');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '193');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '194');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '195');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '196');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '197');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '198');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '199');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '200');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '201');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '202');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '203');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '204');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '205');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '206');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '207');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '208');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '215');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '216');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '217');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '218');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '219');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '220');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '221');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '222');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '223');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '224');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '225');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '226');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '227');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '228');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '229');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '230');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '231');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '232');
INSERT INTO `otc_auth_role_permission` VALUES ('65', '235');
INSERT INTO `otc_auth_role_permission` VALUES ('66', '49');
INSERT INTO `otc_auth_role_permission` VALUES ('66', '113');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '6');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '7');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '8');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '9');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '10');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '11');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '12');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '13');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '14');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '15');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '32');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '33');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '34');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '35');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '36');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '37');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '42');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '99');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '100');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '101');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '106');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '107');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '108');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '114');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '118');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '124');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '126');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '238');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '243');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '244');
INSERT INTO `otc_auth_role_permission` VALUES ('67', '245');
INSERT INTO `otc_auth_role_permission` VALUES ('68', '23');
INSERT INTO `otc_auth_role_permission` VALUES ('68', '24');
INSERT INTO `otc_auth_role_permission` VALUES ('68', '25');
INSERT INTO `otc_auth_role_permission` VALUES ('68', '31');
INSERT INTO `otc_auth_role_permission` VALUES ('68', '92');
INSERT INTO `otc_auth_role_permission` VALUES ('68', '94');
INSERT INTO `otc_auth_role_permission` VALUES ('68', '109');
INSERT INTO `otc_auth_role_permission` VALUES ('68', '110');
INSERT INTO `otc_auth_role_permission` VALUES ('68', '111');
INSERT INTO `otc_auth_role_permission` VALUES ('68', '112');
INSERT INTO `otc_auth_role_permission` VALUES ('68', '120');
INSERT INTO `otc_auth_role_permission` VALUES ('68', '128');
INSERT INTO `otc_auth_role_permission` VALUES ('68', '140');
INSERT INTO `otc_auth_role_permission` VALUES ('68', '215');
INSERT INTO `otc_auth_role_permission` VALUES ('69', '24');
INSERT INTO `otc_auth_role_permission` VALUES ('69', '26');
INSERT INTO `otc_auth_role_permission` VALUES ('69', '27');
INSERT INTO `otc_auth_role_permission` VALUES ('69', '92');
INSERT INTO `otc_auth_role_permission` VALUES ('69', '93');
INSERT INTO `otc_auth_role_permission` VALUES ('69', '109');
INSERT INTO `otc_auth_role_permission` VALUES ('69', '110');
INSERT INTO `otc_auth_role_permission` VALUES ('69', '120');
INSERT INTO `otc_auth_role_permission` VALUES ('69', '121');
INSERT INTO `otc_auth_role_permission` VALUES ('69', '128');
INSERT INTO `otc_auth_role_permission` VALUES ('69', '140');
INSERT INTO `otc_auth_role_permission` VALUES ('69', '215');
INSERT INTO `otc_auth_role_permission` VALUES ('70', '24');
INSERT INTO `otc_auth_role_permission` VALUES ('70', '28');
INSERT INTO `otc_auth_role_permission` VALUES ('70', '29');
INSERT INTO `otc_auth_role_permission` VALUES ('70', '92');
INSERT INTO `otc_auth_role_permission` VALUES ('70', '110');
INSERT INTO `otc_auth_role_permission` VALUES ('70', '120');
INSERT INTO `otc_auth_role_permission` VALUES ('70', '128');
INSERT INTO `otc_auth_role_permission` VALUES ('70', '138');
INSERT INTO `otc_auth_role_permission` VALUES ('70', '140');
INSERT INTO `otc_auth_role_permission` VALUES ('70', '215');
INSERT INTO `otc_auth_role_permission` VALUES ('73', '19');
INSERT INTO `otc_auth_role_permission` VALUES ('73', '24');
INSERT INTO `otc_auth_role_permission` VALUES ('73', '30');
INSERT INTO `otc_auth_role_permission` VALUES ('73', '38');
INSERT INTO `otc_auth_role_permission` VALUES ('73', '41');
INSERT INTO `otc_auth_role_permission` VALUES ('73', '92');
INSERT INTO `otc_auth_role_permission` VALUES ('73', '109');
INSERT INTO `otc_auth_role_permission` VALUES ('73', '110');
INSERT INTO `otc_auth_role_permission` VALUES ('73', '128');
INSERT INTO `otc_auth_role_permission` VALUES ('73', '129');
INSERT INTO `otc_auth_role_permission` VALUES ('73', '140');
INSERT INTO `otc_auth_role_permission` VALUES ('73', '215');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '19');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '20');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '43');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '44');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '45');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '47');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '48');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '102');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '103');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '104');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '105');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '119');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '123');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '127');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '132');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '135');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '136');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '139');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '221');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '225');
INSERT INTO `otc_auth_role_permission` VALUES ('74', '235');
INSERT INTO `otc_auth_role_permission` VALUES ('75', '16');
INSERT INTO `otc_auth_role_permission` VALUES ('75', '21');
INSERT INTO `otc_auth_role_permission` VALUES ('75', '44');
INSERT INTO `otc_auth_role_permission` VALUES ('75', '97');
INSERT INTO `otc_auth_role_permission` VALUES ('75', '102');
INSERT INTO `otc_auth_role_permission` VALUES ('75', '103');
INSERT INTO `otc_auth_role_permission` VALUES ('75', '104');
INSERT INTO `otc_auth_role_permission` VALUES ('75', '105');
INSERT INTO `otc_auth_role_permission` VALUES ('75', '116');
INSERT INTO `otc_auth_role_permission` VALUES ('75', '125');
INSERT INTO `otc_auth_role_permission` VALUES ('75', '127');
INSERT INTO `otc_auth_role_permission` VALUES ('75', '132');
INSERT INTO `otc_auth_role_permission` VALUES ('75', '139');
INSERT INTO `otc_auth_role_permission` VALUES ('75', '221');
INSERT INTO `otc_auth_role_permission` VALUES ('75', '235');
INSERT INTO `otc_auth_role_permission` VALUES ('76', '44');
INSERT INTO `otc_auth_role_permission` VALUES ('76', '95');
INSERT INTO `otc_auth_role_permission` VALUES ('76', '96');
INSERT INTO `otc_auth_role_permission` VALUES ('76', '115');
INSERT INTO `otc_auth_role_permission` VALUES ('76', '122');
INSERT INTO `otc_auth_role_permission` VALUES ('76', '123');
INSERT INTO `otc_auth_role_permission` VALUES ('76', '127');
INSERT INTO `otc_auth_role_permission` VALUES ('76', '132');
INSERT INTO `otc_auth_role_permission` VALUES ('76', '139');
INSERT INTO `otc_auth_role_permission` VALUES ('76', '221');
INSERT INTO `otc_auth_role_permission` VALUES ('76', '235');
INSERT INTO `otc_auth_role_permission` VALUES ('77', '18');
INSERT INTO `otc_auth_role_permission` VALUES ('77', '44');
INSERT INTO `otc_auth_role_permission` VALUES ('77', '45');
INSERT INTO `otc_auth_role_permission` VALUES ('77', '117');
INSERT INTO `otc_auth_role_permission` VALUES ('77', '123');
INSERT INTO `otc_auth_role_permission` VALUES ('77', '127');
INSERT INTO `otc_auth_role_permission` VALUES ('77', '132');
INSERT INTO `otc_auth_role_permission` VALUES ('77', '137');
INSERT INTO `otc_auth_role_permission` VALUES ('77', '139');
INSERT INTO `otc_auth_role_permission` VALUES ('77', '221');
INSERT INTO `otc_auth_role_permission` VALUES ('77', '235');
INSERT INTO `otc_auth_role_permission` VALUES ('78', '36');
INSERT INTO `otc_auth_role_permission` VALUES ('78', '37');
INSERT INTO `otc_auth_role_permission` VALUES ('78', '42');
INSERT INTO `otc_auth_role_permission` VALUES ('78', '49');
INSERT INTO `otc_auth_role_permission` VALUES ('78', '100');
INSERT INTO `otc_auth_role_permission` VALUES ('78', '101');
INSERT INTO `otc_auth_role_permission` VALUES ('78', '106');
INSERT INTO `otc_auth_role_permission` VALUES ('78', '107');
INSERT INTO `otc_auth_role_permission` VALUES ('78', '108');
INSERT INTO `otc_auth_role_permission` VALUES ('78', '114');
INSERT INTO `otc_auth_role_permission` VALUES ('78', '118');
INSERT INTO `otc_auth_role_permission` VALUES ('78', '124');
INSERT INTO `otc_auth_role_permission` VALUES ('78', '209');
INSERT INTO `otc_auth_role_permission` VALUES ('79', '210');
INSERT INTO `otc_auth_role_permission` VALUES ('79', '211');
INSERT INTO `otc_auth_role_permission` VALUES ('79', '213');
INSERT INTO `otc_auth_role_permission` VALUES ('79', '214');
INSERT INTO `otc_auth_role_permission` VALUES ('79', '242');
INSERT INTO `otc_auth_role_permission` VALUES ('80', '217');
INSERT INTO `otc_auth_role_permission` VALUES ('80', '218');
INSERT INTO `otc_auth_role_permission` VALUES ('80', '219');
INSERT INTO `otc_auth_role_permission` VALUES ('80', '220');
INSERT INTO `otc_auth_role_permission` VALUES ('80', '223');
INSERT INTO `otc_auth_role_permission` VALUES ('80', '224');
INSERT INTO `otc_auth_role_permission` VALUES ('80', '226');
INSERT INTO `otc_auth_role_permission` VALUES ('80', '229');
INSERT INTO `otc_auth_role_permission` VALUES ('80', '230');
INSERT INTO `otc_auth_role_permission` VALUES ('80', '233');
INSERT INTO `otc_auth_role_permission` VALUES ('80', '234');
INSERT INTO `otc_auth_role_permission` VALUES ('81', '219');
INSERT INTO `otc_auth_role_permission` VALUES ('81', '222');
INSERT INTO `otc_auth_role_permission` VALUES ('81', '226');
INSERT INTO `otc_auth_role_permission` VALUES ('81', '227');
INSERT INTO `otc_auth_role_permission` VALUES ('81', '228');
INSERT INTO `otc_auth_role_permission` VALUES ('81', '229');
INSERT INTO `otc_auth_role_permission` VALUES ('81', '231');
INSERT INTO `otc_auth_role_permission` VALUES ('81', '232');
INSERT INTO `otc_auth_role_permission` VALUES ('81', '233');
INSERT INTO `otc_auth_role_permission` VALUES ('81', '234');
INSERT INTO `otc_auth_role_permission` VALUES ('82', '216');
INSERT INTO `otc_auth_role_permission` VALUES ('82', '219');
INSERT INTO `otc_auth_role_permission` VALUES ('82', '223');
INSERT INTO `otc_auth_role_permission` VALUES ('82', '225');
INSERT INTO `otc_auth_role_permission` VALUES ('82', '226');
INSERT INTO `otc_auth_role_permission` VALUES ('82', '229');
INSERT INTO `otc_auth_role_permission` VALUES ('82', '233');
INSERT INTO `otc_auth_role_permission` VALUES ('82', '234');
INSERT INTO `otc_auth_role_permission` VALUES ('82', '236');
INSERT INTO `otc_auth_role_permission` VALUES ('82', '237');
INSERT INTO `otc_auth_role_permission` VALUES ('82', '239');

-- ----------------------------
-- Table structure for otc_capitalpool
-- ----------------------------
DROP TABLE IF EXISTS `otc_capitalpool`;
CREATE TABLE `otc_capitalpool` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '' COMMENT '资产包名称',
  `cf_mast_id` int(11) DEFAULT '0' COMMENT '产品ID 暂不用',
  `holder` int(11) DEFAULT '0' COMMENT '持有人',
  `otc_code` varchar(255) DEFAULT '' COMMENT '代码',
  `investment_type` tinyint(1) DEFAULT '0' COMMENT '投资方式 1债权转让  2收益权转让',
  `all_amount` decimal(22,2) DEFAULT '0.00' COMMENT '总募规模',
  `expected_amount` decimal(22,2) DEFAULT '0.00' COMMENT '采购规模',
  `total_amount` decimal(22,2) DEFAULT '0.00' COMMENT '总金额',
  `surplus_amount` decimal(22,2) DEFAULT '0.00' COMMENT '剩余金额',
  `status` tinyint(4) DEFAULT '0' COMMENT '资产包状态 0暂存 1待审核 2审核通过  3审核失败 4暂停使用',
  `validflag` tinyint(4) DEFAULT '1' COMMENT '回收状态',
  `issuer` varchar(255) DEFAULT '' COMMENT '发行方',
  `manager` varchar(255) DEFAULT '' COMMENT '管理人',
  `memo` varchar(2000) DEFAULT '' COMMENT '项目介绍',
  `zjtgf` varchar(2000) DEFAULT '' COMMENT '资金托管方',
  `dbgs` varchar(255) DEFAULT '' COMMENT '担保公司',
  `dbfjs` varchar(2000) DEFAULT '' COMMENT '担保方介绍',
  `fxts` varchar(2000) DEFAULT NULL COMMENT '风险提示',
  `zjaq` varchar(2000) DEFAULT NULL COMMENT '资金安全',
  `zqgz` varchar(2000) DEFAULT '' COMMENT '债权规则',
  `zcaq` varchar(2000) DEFAULT NULL COMMENT '资产安全',
  `qqjg` varchar(255) DEFAULT '' COMMENT '确权机构',
  `syfpr` varchar(255) DEFAULT '' COMMENT '收益分配日',
  `tzfw` varchar(255) DEFAULT '' COMMENT '投资范围',
  `startdate` date DEFAULT '0000-00-00' COMMENT '募集开始日期',
  `endtime` date DEFAULT '0000-00-00' COMMENT '募集结束日期',
  `usr_create` int(11) DEFAULT '0' COMMENT '创建人员',
  `dat_create` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `usr_modify` int(11) DEFAULT '0' COMMENT '维护人员',
  `dat_modify` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '维护时间',
  PRIMARY KEY (`id`),
  KEY `name` (`name`) USING BTREE,
  KEY `cf_mast_id` (`cf_mast_id`) USING BTREE,
  KEY `holder` (`holder`) USING BTREE,
  KEY `otc_code` (`otc_code`) USING BTREE,
  KEY `investment_type` (`investment_type`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `validflag` (`validflag`) USING BTREE,
  KEY `usr_create` (`usr_create`) USING BTREE,
  KEY `dat_create` (`dat_create`) USING BTREE,
  KEY `usr_modify` (`usr_modify`) USING BTREE,
  KEY `dat_modify` (`dat_modify`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8 COMMENT='资金池表';

-- ----------------------------
-- Records of otc_capitalpool
-- ----------------------------

-- ----------------------------
-- Table structure for otc_capitalpool_file
-- ----------------------------
DROP TABLE IF EXISTS `otc_capitalpool_file`;
CREATE TABLE `otc_capitalpool_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `capitalid` int(11) DEFAULT '0' COMMENT '资产包ID',
  `filename` varchar(255) DEFAULT '' COMMENT '文件名',
  `file` varchar(255) DEFAULT '' COMMENT '附件地址',
  `type` tinyint(1) DEFAULT '1' COMMENT '附件类型 0其他附件 1审核附件  ',
  `validflag` tinyint(1) DEFAULT '1' COMMENT '回收状态',
  `usr_create` int(11) DEFAULT '0' COMMENT '创建人员',
  `dat_create` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `capitalid` (`capitalid`) USING BTREE,
  KEY `filename` (`filename`) USING BTREE,
  KEY `file` (`file`) USING BTREE,
  KEY `type` (`type`) USING BTREE,
  KEY `validflag` (`validflag`) USING BTREE,
  KEY `usr_create` (`usr_create`) USING BTREE,
  KEY `dat_create` (`dat_create`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=380 DEFAULT CHARSET=utf8 COMMENT='资产包相关附件';

-- ----------------------------
-- Records of otc_capitalpool_file
-- ----------------------------

-- ----------------------------
-- Table structure for otc_cf_ctl
-- ----------------------------
DROP TABLE IF EXISTS `otc_cf_ctl`;
CREATE TABLE `otc_cf_ctl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cf_mast_id` int(11) DEFAULT '0' COMMENT '盒子ID',
  `capitalid` int(11) DEFAULT '0' COMMENT '资金表ID',
  `type` int(11) DEFAULT '0' COMMENT '投资方式 1债权转让 2收益权转让  0兼容一期',
  `cod_period` int(11) DEFAULT '0' COMMENT '期号',
  `amt_ct` decimal(22,2) DEFAULT '0.00' COMMENT '每期金额',
  `amt_ct_last` decimal(22,2) DEFAULT '0.00' COMMENT '每期剩余金额',
  `ctr_ct` int(11) DEFAULT '0' COMMENT '融资份数',
  `ctr_ct_last` int(11) DEFAULT '0' COMMENT '剩余融资份数',
  `ctr_ct_finish` int(11) DEFAULT '0' COMMENT '完成百分比',
  `dat_modify` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '维护时间',
  `ctr_updat_srlno` int(11) DEFAULT '0' COMMENT '更新序号',
  PRIMARY KEY (`id`),
  KEY `cod_cf_id` (`cf_mast_id`) USING BTREE,
  KEY `capitalid` (`capitalid`) USING BTREE,
  KEY `type` (`type`) USING BTREE,
  KEY `cod_period` (`cod_period`) USING BTREE,
  KEY `amt_ct` (`amt_ct`) USING BTREE,
  KEY `amt_ct_last` (`amt_ct_last`) USING BTREE,
  KEY `ctr_ct` (`ctr_ct`) USING BTREE,
  KEY `ctr_ct_last` (`ctr_ct_last`) USING BTREE,
  KEY `ctr_ct_finish` (`ctr_ct_finish`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=329 DEFAULT CHARSET=utf8 COMMENT='融资-投资期数控制';

-- ----------------------------
-- Records of otc_cf_ctl
-- ----------------------------

-- ----------------------------
-- Table structure for otc_cf_ivs
-- ----------------------------
DROP TABLE IF EXISTS `otc_cf_ivs`;
CREATE TABLE `otc_cf_ivs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_cf_id` int(11) DEFAULT '0' COMMENT '投资产品ID',
  `cod_ctl_id` int(11) DEFAULT '0' COMMENT '产品分期表ID',
  `cod_cust_id` int(11) DEFAULT '0' COMMENT '客户ID',
  `capitalid` int(11) DEFAULT '0' COMMENT '资金表ID',
  `product_code` varchar(64) DEFAULT '' COMMENT '产品代码',
  `ivs_order` varchar(128) DEFAULT '' COMMENT '订单号',
  `sales` varchar(50) DEFAULT '' COMMENT '销售经理',
  `pos_order` varchar(64) DEFAULT '' COMMENT 'pos机单号',
  `pos_file` varchar(255) DEFAULT '' COMMENT 'POS单扫描件',
  `redemption_sales` varchar(50) DEFAULT '' COMMENT '赎回销售',
  `redemption_order` varchar(64) DEFAULT '' COMMENT '赎回单号',
  `redemption_file` varchar(255) DEFAULT '' COMMENT '赎回扫描件',
  `cod_ivs_type` tinyint(1) DEFAULT '1' COMMENT '投资模式 1债权转让方式购买(按金额)  2收益权转让方式购买（按f份数）',
  `flg_ivs_margin` tinyint(1) DEFAULT '1' COMMENT '是否保证金投资',
  `amt_ivs` decimal(22,2) DEFAULT '0.00' COMMENT '投资金额',
  `ctl_ivs_cnt` int(11) DEFAULT '1' COMMENT '投资份数',
  `amt_int_total` decimal(22,2) DEFAULT '0.00' COMMENT '投资总金额',
  `amt_fee_total` decimal(22,2) DEFAULT '0.00' COMMENT '投资金额(总费用)',
  `rat_cf_inv_min` decimal(22,2) DEFAULT '0.00' COMMENT '年化收益利率',
  `amt_time` int(11) DEFAULT '0' COMMENT '投资周期(月)',
  `cod_ivs_status` tinyint(4) DEFAULT '0' COMMENT '投资状态 -1已作废 0待确认 1已完成 2已赎回',
  `cod_channel_code` varchar(32) DEFAULT '' COMMENT '渠道编号',
  `cod_tran_seq` varchar(64) DEFAULT '' COMMENT '渠道流水',
  `operating` tinyint(4) DEFAULT '1' COMMENT '操作方式 1销售端购买  2管理端回购',
  `dat_create` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `usr_create` int(11) DEFAULT '0' COMMENT '创建人员',
  `dat_modify` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '维护时间',
  `usr_modify` int(11) DEFAULT '0' COMMENT '维护人员',
  `arrivaldate` date DEFAULT '0000-00-00' COMMENT '到账日期',
  `dat_arrival` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '到账确认时间',
  `usr_arrival` int(11) DEFAULT '0' COMMENT '到账确认人',
  PRIMARY KEY (`id`),
  KEY `cod_ctl_id` (`cod_ctl_id`) USING BTREE,
  KEY `cod_cf_id` (`cod_cf_id`) USING BTREE,
  KEY `cod_cust_id` (`cod_cust_id`) USING BTREE,
  KEY `capitalid` (`capitalid`) USING BTREE,
  KEY `product_code` (`product_code`) USING BTREE,
  KEY `ivs_order` (`ivs_order`) USING BTREE,
  KEY `pos_order` (`pos_order`) USING BTREE,
  KEY `cod_ivs_type` (`cod_ivs_type`) USING BTREE,
  KEY `cod_ivs_status` (`cod_ivs_status`) USING BTREE,
  KEY `usr_create` (`usr_create`) USING BTREE,
  KEY `usr_modify` (`usr_modify`) USING BTREE,
  KEY `dat_create` (`dat_create`) USING BTREE,
  KEY `dat_modify` (`dat_modify`) USING BTREE,
  KEY `cod_cust_id, cod_cf_id, cod_ctl_id, capitalid` (`cod_cust_id`,`cod_cf_id`,`cod_ctl_id`,`capitalid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COMMENT='融资-投资记录表';

-- ----------------------------
-- Records of otc_cf_ivs
-- ----------------------------

-- ----------------------------
-- Table structure for otc_cf_ivs_redemption
-- ----------------------------
DROP TABLE IF EXISTS `otc_cf_ivs_redemption`;
CREATE TABLE `otc_cf_ivs_redemption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_cf_ivs_id` int(11) DEFAULT '0' COMMENT '交易记录ID',
  `cod_cf_id` int(11) DEFAULT '0' COMMENT '投资产品ID',
  `cod_ctl_id` int(11) DEFAULT '0' COMMENT '产品分期表ID',
  `cod_cust_id` int(11) DEFAULT '0' COMMENT '客户ID',
  `capitalid` int(11) DEFAULT '0' COMMENT '资金表ID',
  `product_code` varchar(64) DEFAULT '' COMMENT '产品代码',
  `ivs_order` varchar(128) DEFAULT '' COMMENT '订单号',
  `sales` varchar(50) NOT NULL DEFAULT '' COMMENT '销售经理',
  `pos_order` varchar(64) DEFAULT '' COMMENT 'pos机单号',
  `pos_file` varchar(255) DEFAULT '' COMMENT 'POS单扫描件',
  `redemption_sales` varchar(50) DEFAULT '' COMMENT '赎回销售',
  `redemption_order` varchar(64) DEFAULT '' COMMENT '赎回单号',
  `redemption_file` varchar(255) DEFAULT '' COMMENT '赎回扫描件',
  `cod_ivs_type` tinyint(1) DEFAULT '1' COMMENT '投资模式 1债权转让方式购买(按金额)  2收益权转让方式购买（按f份数）',
  `flg_ivs_margin` tinyint(1) DEFAULT '1' COMMENT '是否保证金投资',
  `amt_ivs` decimal(22,2) DEFAULT '0.00' COMMENT '赎回金额',
  `ctl_ivs_cnt` int(11) DEFAULT '1' COMMENT '赎回份数',
  `amt_int_total` decimal(22,2) DEFAULT '0.00' COMMENT '赎回总金额',
  `amt_fee_total` decimal(22,2) DEFAULT '0.00' COMMENT '投资金额(总费用)',
  `rat_cf_inv_min` decimal(22,2) DEFAULT '0.00' COMMENT '年化收益利率',
  `amt_time` int(11) DEFAULT '0' COMMENT '投资周期(月)',
  `cod_ivs_status` tinyint(4) DEFAULT '0' COMMENT '投资状态 -1已作废 0待确认 1已完成 2已赎回',
  `cod_channel_code` varchar(32) DEFAULT '' COMMENT '渠道编号',
  `cod_tran_seq` varchar(64) DEFAULT '' COMMENT '渠道流水',
  `operating` tinyint(4) DEFAULT '1' COMMENT '操作方式 1销售端购买  2管理端回购',
  `dat_create` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `usr_create` int(11) DEFAULT '0' COMMENT '创建人员',
  `dat_modify` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '维护时间',
  `usr_modify` int(11) DEFAULT '0' COMMENT '维护人员',
  PRIMARY KEY (`id`),
  KEY `cod_ctl_id` (`cod_ctl_id`) USING BTREE,
  KEY `cod_cf_id` (`cod_cf_id`) USING BTREE,
  KEY `cod_cust_id` (`cod_cust_id`) USING BTREE,
  KEY `capitalid` (`capitalid`) USING BTREE,
  KEY `product_code` (`product_code`) USING BTREE,
  KEY `ivs_order` (`ivs_order`) USING BTREE,
  KEY `pos_order` (`pos_order`) USING BTREE,
  KEY `cod_ivs_type` (`cod_ivs_type`) USING BTREE,
  KEY `cod_ivs_status` (`cod_ivs_status`) USING BTREE,
  KEY `usr_create` (`usr_create`) USING BTREE,
  KEY `usr_modify` (`usr_modify`) USING BTREE,
  KEY `dat_create` (`dat_create`) USING BTREE,
  KEY `dat_modify` (`dat_modify`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='融资-投资记录赎回表';

-- ----------------------------
-- Records of otc_cf_ivs_redemption
-- ----------------------------

-- ----------------------------
-- Table structure for otc_cf_ivs_right
-- ----------------------------
DROP TABLE IF EXISTS `otc_cf_ivs_right`;
CREATE TABLE `otc_cf_ivs_right` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cf_ivs_id` int(11) DEFAULT '0' COMMENT '产品投资记录表ID',
  `cf_ivs_redemption_id` int(11) DEFAULT '0' COMMENT '赎回ID',
  `qqh_file` varchar(255) DEFAULT '' COMMENT '确权函地址',
  `status` tinyint(1) DEFAULT '1' COMMENT '1发起确权  2确权成功 3确权失败 0为待确权',
  `step` int(11) DEFAULT '1' COMMENT '1 开户准备,2开户资料提交,3 待开户,11 入金准备,5 开户失败,12 入金资料提交,13 待入金,14 入金失败, 4 过户准备（入金成功）,6 过户资料提交, 7 待过户,8 待对账(过户成功),9 过户失败,10 确权成功 ',
  `errornum` int(11) DEFAULT '0' COMMENT '错误次数',
  `validflag` tinyint(1) DEFAULT '1' COMMENT '回收状态',
  `usr_create` int(11) DEFAULT '0' COMMENT '创建人员',
  `dat_create` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `usr_modify` int(11) DEFAULT NULL COMMENT '维护人员',
  `dat_modify` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '维护时间',
  PRIMARY KEY (`id`),
  KEY `cf_ivs_id` (`cf_ivs_id`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `step` (`step`) USING BTREE,
  KEY `validflag` (`validflag`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='融资-投资记录确权表';

-- ----------------------------
-- Records of otc_cf_ivs_right
-- ----------------------------

-- ----------------------------
-- Table structure for otc_cf_ivs_right_file
-- ----------------------------
DROP TABLE IF EXISTS `otc_cf_ivs_right_file`;
CREATE TABLE `otc_cf_ivs_right_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cf_ctl_id` int(11) DEFAULT '0' COMMENT '投资产品期数ID',
  `cust_id` int(11) DEFAULT '0' COMMENT '客户ID',
  `cf_ivs_right_id` int(11) DEFAULT '0' COMMENT '确权记录ID',
  `filename` varchar(255) DEFAULT '' COMMENT '文件名',
  `file` varchar(255) DEFAULT '' COMMENT '附件地址',
  `otc_url` varchar(255) DEFAULT '' COMMENT '源地址',
  `type` tinyint(1) DEFAULT '1' COMMENT '附件类型 0其他附件 1审核附件  ',
  `validflag` tinyint(1) DEFAULT '1' COMMENT '回收状态',
  `usr_create` int(11) DEFAULT '0' COMMENT '创建人员',
  `dat_create` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`) USING BTREE,
  KEY `validflag` (`validflag`) USING BTREE,
  KEY `filename` (`filename`) USING BTREE,
  KEY `file` (`file`) USING BTREE,
  KEY `usr_create` (`usr_create`) USING BTREE,
  KEY `cf_ctl_id` (`cf_ctl_id`) USING BTREE,
  KEY `cust_id` (`cust_id`),
  KEY `cf_ivs_right_id` (`cf_ivs_right_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COMMENT='投资产品相关附件';

-- ----------------------------
-- Records of otc_cf_ivs_right_file
-- ----------------------------

-- ----------------------------
-- Table structure for otc_cf_ivs_right_log
-- ----------------------------
DROP TABLE IF EXISTS `otc_cf_ivs_right_log`;
CREATE TABLE `otc_cf_ivs_right_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ivs_id` int(11) DEFAULT '0' COMMENT '交易记录ID',
  `ivs_right_id` int(11) DEFAULT '0' COMMENT '确权记录ID',
  `step_before` tinyint(4) DEFAULT '0' COMMENT '从*阶段',
  `step_after` tinyint(4) DEFAULT '0' COMMENT '到*阶段',
  `status_before` tinyint(4) DEFAULT '0' COMMENT '从*状态',
  `status_after` tinyint(4) DEFAULT '0' COMMENT '到*状态',
  `error_code` int(11) DEFAULT '0' COMMENT '错误状态',
  `error_msg` varchar(2000) DEFAULT '' COMMENT '描述',
  `validflag` tinyint(1) DEFAULT '1' COMMENT '回收状态',
  `usr_create` int(11) DEFAULT '0' COMMENT '创建人员',
  `dat_create` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `usr_modify` int(11) DEFAULT '0' COMMENT '维护人员',
  `dat_modify` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '维护时间',
  PRIMARY KEY (`id`),
  KEY `ivs_id` (`ivs_id`) USING BTREE,
  KEY `ivs_right_id` (`ivs_right_id`) USING BTREE,
  KEY `step_before` (`step_before`) USING BTREE,
  KEY `step_after` (`step_after`) USING BTREE,
  KEY `status_before` (`status_before`) USING BTREE,
  KEY `status_after` (`status_after`) USING BTREE,
  KEY `error_code` (`error_code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='融资-投资记录确权日志表';

-- ----------------------------
-- Records of otc_cf_ivs_right_log
-- ----------------------------

-- ----------------------------
-- Table structure for otc_cf_mast
-- ----------------------------
DROP TABLE IF EXISTS `otc_cf_mast`;
CREATE TABLE `otc_cf_mast` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `cod_cf_inv_type` tinyint(1) DEFAULT '0' COMMENT '投资模式 1债权转让方式购买(按金额)  2收益权转让方式购买（按份数）',
  `capitalid` int(11) DEFAULT '0' COMMENT '资金表ID',
  `title` varchar(250) DEFAULT '' COMMENT '投资产品标题',
  `code` varchar(64) DEFAULT '' COMMENT '投资产品OTC代码',
  `formula` tinyint(1) NOT NULL DEFAULT '0' COMMENT '计息公式规则',
  `amt_ct` decimal(22,2) DEFAULT '0.00' COMMENT '融资金额',
  `each_amt` decimal(22,2) DEFAULT '0.00' COMMENT '每期金额',
  `cod_is_delete` tinyint(1) DEFAULT '0' COMMENT '是否删除',
  `cod_cf_status` tinyint(1) DEFAULT '0' COMMENT '产品状态 0暂存 6待审核 （ 7OTC审核准备 8OTC审核中 9OTC审核失败）  3审核失败 4待发布 1正常 2暂停销售  10发布退回',
  `cod_cf_status_process` varchar(32) DEFAULT '' COMMENT '融资审核方式',
  `cod_cf_grt` varchar(32) DEFAULT '' COMMENT '主要担保方式',
  `amt_cf_inv_each` decimal(22,2) DEFAULT '0.00' COMMENT '每份投资金额',
  `amt_ct_min` int(11) DEFAULT '0' COMMENT '最小投资份数',
  `amt_ct_max` int(11) DEFAULT '0' COMMENT '最大投资份数',
  `amt_cf_inv_min` decimal(22,2) DEFAULT '0.00' COMMENT '最小投资金额',
  `amt_cf_inv_max` decimal(22,2) DEFAULT '0.00' COMMENT '最大投资金额',
  `rat_cf_inv_min` decimal(22,2) DEFAULT '0.00' COMMENT '年化收益利率',
  `amt_time` int(11) DEFAULT '0' COMMENT '投资周期(月)',
  `dat_cf_inv_begin` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '投资开始时间',
  `dat_cf_inv_end` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '投资结束时间',
  `cod_process_id` varchar(32) DEFAULT '' COMMENT '审批流程ID',
  `dat_tran` date DEFAULT '0000-00-00' COMMENT '移植日期',
  `cod_channel_code` varchar(32) DEFAULT '' COMMENT '渠道编号',
  `cod_tran_seq` varchar(64) DEFAULT '' COMMENT '渠道流水',
  `auditmemo` varchar(255) DEFAULT '' COMMENT '审核备注',
  `dat_create` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `usr_create` int(11) DEFAULT '0' COMMENT '创建人员',
  `dat_modify` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '维护时间',
  `usr_modify` int(11) DEFAULT '0' COMMENT '维护人员',
  PRIMARY KEY (`id`),
  KEY `cod_cf_inv_type` (`cod_cf_inv_type`) USING BTREE,
  KEY `capitalid` (`capitalid`) USING BTREE,
  KEY `title` (`title`) USING BTREE,
  KEY `code` (`code`) USING BTREE,
  KEY `cod_cf_status` (`cod_cf_status`) USING BTREE,
  KEY `cod_is_delete` (`cod_is_delete`) USING BTREE,
  KEY `usr_create` (`usr_create`) USING BTREE,
  KEY `usr_modify` (`usr_modify`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8 COMMENT='投资产品';

-- ----------------------------
-- Records of otc_cf_mast
-- ----------------------------
INSERT INTO `otc_cf_mast` VALUES ('103', '0', '0', '测试A', '', '1', '0.00', '10000000.00', '0', '4', '', '', '0.00', '0', '0', '200000.00', '990000.00', '8.00', '12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0000-00-00', '', '', '', '2016-03-28 17:29:53', '1', '2016-03-28 17:30:21', '1');
INSERT INTO `otc_cf_mast` VALUES ('104', '0', '0', '123', '', '1', '0.00', '10000000.00', '0', '0', '', '', '0.00', '0', '0', '230000.00', '990000.00', '8.00', '3', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0000-00-00', '', '', '', '2016-03-28 17:31:45', '1', '2016-03-28 17:31:45', '1');

-- ----------------------------
-- Table structure for otc_cf_mast_file
-- ----------------------------
DROP TABLE IF EXISTS `otc_cf_mast_file`;
CREATE TABLE `otc_cf_mast_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cf_id` int(11) DEFAULT '0' COMMENT '投资产品ID',
  `filename` varchar(255) DEFAULT '' COMMENT '文件名',
  `file` varchar(255) DEFAULT '' COMMENT '附件地址',
  `type` tinyint(1) DEFAULT '1' COMMENT '附件类型 0其他附件 1审核附件  ',
  `validflag` tinyint(1) DEFAULT '1' COMMENT '回收状态',
  `usr_create` int(11) DEFAULT '0' COMMENT '创建人员',
  `dat_create` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `cf_id` (`cf_id`) USING BTREE,
  KEY `type` (`type`) USING BTREE,
  KEY `validflag` (`validflag`) USING BTREE,
  KEY `filename` (`filename`) USING BTREE,
  KEY `file` (`file`) USING BTREE,
  KEY `usr_create` (`usr_create`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='投资产品相关附件';

-- ----------------------------
-- Records of otc_cf_mast_file
-- ----------------------------

-- ----------------------------
-- Table structure for otc_cf_mast_self_field
-- ----------------------------
DROP TABLE IF EXISTS `otc_cf_mast_self_field`;
CREATE TABLE `otc_cf_mast_self_field` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增字段',
  `cf_id` int(11) unsigned DEFAULT '0' COMMENT '产品id',
  `field_name` varchar(100) DEFAULT '' COMMENT '字段描述',
  `field_en_name` varchar(100) DEFAULT '' COMMENT '字段英文名称',
  `field_type` tinyint(1) unsigned DEFAULT '1' COMMENT '1:输入框 2下拉菜单 3单选 4多选 5富文本',
  `field_option` varchar(255) DEFAULT '' COMMENT '客户可选择的选择项',
  `update_time` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `cf_id` (`cf_id`) USING BTREE,
  KEY `field_type` (`field_type`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='投资产品专有字段名称';

-- ----------------------------
-- Records of otc_cf_mast_self_field
-- ----------------------------

-- ----------------------------
-- Table structure for otc_cf_mast_self_field_value
-- ----------------------------
DROP TABLE IF EXISTS `otc_cf_mast_self_field_value`;
CREATE TABLE `otc_cf_mast_self_field_value` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cf_id` int(11) DEFAULT '0' COMMENT '产品id',
  `field_id` int(11) unsigned DEFAULT '0' COMMENT '参数ID',
  `field_name` varchar(255) DEFAULT '' COMMENT '参数名',
  `field_value` varchar(255) DEFAULT '' COMMENT '参数值',
  `update_time` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `cf_id` (`cf_id`) USING BTREE,
  KEY `field_id` (`field_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='投资产品专有属性的属性值';

-- ----------------------------
-- Records of otc_cf_mast_self_field_value
-- ----------------------------

-- ----------------------------
-- Table structure for otc_cl_ctl
-- ----------------------------
DROP TABLE IF EXISTS `otc_cl_ctl`;
CREATE TABLE `otc_cl_ctl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_cl_id` int(11) DEFAULT '0' COMMENT '债权ID',
  `type` tinyint(11) DEFAULT '0' COMMENT '投资模式',
  `capitalid` int(11) DEFAULT '0' COMMENT '资金表ID',
  `amt_ct` decimal(22,2) DEFAULT '0.00' COMMENT '债权金额',
  `amt_ct_last` decimal(22,2) DEFAULT '0.00' COMMENT '剩余债权金额',
  `ctr_ct_finish` int(11) DEFAULT '0' COMMENT '完成百分比',
  `validflag` tinyint(1) DEFAULT '1' COMMENT '回收状态',
  `dat_modify` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '维护时间',
  `ctr_updat_srlno` int(11) DEFAULT '0' COMMENT '更新序号',
  PRIMARY KEY (`id`),
  KEY `type` (`type`) USING BTREE,
  KEY `cod_cl_id` (`cod_cl_id`) USING BTREE,
  KEY `capitalid` (`capitalid`) USING BTREE,
  KEY `ctr_ct_finish` (`ctr_ct_finish`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8 COMMENT='债权进度控制';

-- ----------------------------
-- Records of otc_cl_ctl
-- ----------------------------

-- ----------------------------
-- Table structure for otc_cl_ivs
-- ----------------------------
DROP TABLE IF EXISTS `otc_cl_ivs`;
CREATE TABLE `otc_cl_ivs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_cf_id` int(11) DEFAULT '0' COMMENT '投资产品表ID',
  `cod_cl_id` int(11) DEFAULT '0' COMMENT '债权表ID',
  `cod_cf_ctl_id` int(11) DEFAULT '0' COMMENT '投资产品期数表ID',
  `cod_cl_ctl_id` int(11) DEFAULT '0' COMMENT '债权进度控制表ID',
  `cod_cf_ivs_id` int(11) DEFAULT '0' COMMENT '投资交易记录表ID',
  `capitalid` int(11) DEFAULT '0' COMMENT '资产包ID',
  `cod_cust_id` int(11) DEFAULT '0' COMMENT '客户ID',
  `cod_ivs_type` tinyint(1) DEFAULT '1' COMMENT '投资模式 1债权转让方式购买(按金额)  2收益权转让方式购买（按f份数）',
  `flg_ivs_margin` tinyint(1) DEFAULT '1' COMMENT '是否保证金投资(冗余)',
  `amt_ivs` decimal(22,2) DEFAULT '0.00' COMMENT '投资占用债权金额',
  `cod_ivs_status` tinyint(4) DEFAULT '1' COMMENT '投资状态',
  `cod_channel_code` varchar(32) DEFAULT '' COMMENT '渠道编号(冗余)',
  `cod_tran_seq` varchar(64) DEFAULT '' COMMENT '渠道流水(冗余)',
  `operating` tinyint(4) DEFAULT '1' COMMENT '操作方式 1销售端购买  2管理端回购',
  `usr_create` int(11) DEFAULT '0' COMMENT '创建人员',
  `dat_create` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `usr_modify` int(11) DEFAULT '0' COMMENT '维护人员',
  `dat_modify` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '维护时间',
  `arrivaldate` date DEFAULT '0000-00-00' COMMENT '到账日期',
  `dat_arrival` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '到账确认时间',
  `usr_arrival` int(11) DEFAULT '0' COMMENT '到账确认人',
  PRIMARY KEY (`id`),
  KEY `cod_ctl_id` (`cod_cl_ctl_id`) USING BTREE,
  KEY `cod_cf_id` (`cod_cf_id`) USING BTREE,
  KEY `cod_cl_id` (`cod_cl_id`) USING BTREE,
  KEY `cod_cf_ctl_id` (`cod_cf_ctl_id`) USING BTREE,
  KEY `cod_cf_ivs_id` (`cod_cf_ivs_id`) USING BTREE,
  KEY `capitalid` (`capitalid`) USING BTREE,
  KEY `cod_cust_id` (`cod_cust_id`) USING BTREE,
  KEY `cod_ivs_type` (`cod_ivs_type`) USING BTREE,
  KEY `cod_ivs_status` (`cod_ivs_status`) USING BTREE,
  KEY `usr_create` (`usr_create`) USING BTREE,
  KEY `usr_modify` (`usr_modify`) USING BTREE,
  KEY `dat_create` (`dat_create`) USING BTREE,
  KEY `dat_modify` (`dat_modify`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COMMENT='债权投资记录';

-- ----------------------------
-- Records of otc_cl_ivs
-- ----------------------------

-- ----------------------------
-- Table structure for otc_cl_ivs_redemption
-- ----------------------------
DROP TABLE IF EXISTS `otc_cl_ivs_redemption`;
CREATE TABLE `otc_cl_ivs_redemption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_cl_ivs_id` int(11) DEFAULT '0' COMMENT '债权记录ID',
  `cod_cf_id` int(11) DEFAULT '0' COMMENT '投资产品表ID',
  `cod_cl_id` int(11) DEFAULT '0' COMMENT '债权表ID',
  `cod_cf_ctl_id` int(11) DEFAULT '0' COMMENT '投资产品期数表ID',
  `cod_cl_ctl_id` int(11) DEFAULT '0' COMMENT '债权进度控制表ID',
  `cod_cf_ivs_id` int(11) DEFAULT '0' COMMENT '投资交易记录表ID',
  `capitalid` int(11) DEFAULT '0' COMMENT '资产包ID',
  `cod_cust_id` int(11) DEFAULT '0' COMMENT '客户ID',
  `cod_ivs_type` tinyint(1) DEFAULT '1' COMMENT '投资模式 1债权转让方式购买(按金额)  2收益权转让方式购买（按f份数）',
  `flg_ivs_margin` tinyint(1) DEFAULT '1' COMMENT '是否保证金投资(冗余)',
  `amt_ivs` decimal(22,2) DEFAULT '0.00' COMMENT '赎回占用债权金额',
  `cod_ivs_status` tinyint(4) DEFAULT '1' COMMENT '投资状态',
  `cod_channel_code` varchar(32) DEFAULT '' COMMENT '渠道编号(冗余)',
  `cod_tran_seq` varchar(64) DEFAULT '' COMMENT '渠道流水(冗余)',
  `operating` tinyint(4) DEFAULT '1' COMMENT '操作方式 1销售端购买  2管理端回购',
  `usr_create` int(11) DEFAULT '0' COMMENT '创建人员',
  `dat_create` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `usr_modify` int(11) DEFAULT '0' COMMENT '维护人员',
  `dat_modify` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '维护时间',
  PRIMARY KEY (`id`),
  KEY `cod_ctl_id` (`cod_cl_ctl_id`) USING BTREE,
  KEY `cod_cf_id` (`cod_cf_id`) USING BTREE,
  KEY `cod_cl_id` (`cod_cl_id`) USING BTREE,
  KEY `cod_cf_ctl_id` (`cod_cf_ctl_id`) USING BTREE,
  KEY `cod_cf_ivs_id` (`cod_cf_ivs_id`) USING BTREE,
  KEY `capitalid` (`capitalid`) USING BTREE,
  KEY `cod_cust_id` (`cod_cust_id`) USING BTREE,
  KEY `cod_ivs_type` (`cod_ivs_type`) USING BTREE,
  KEY `cod_ivs_status` (`cod_ivs_status`) USING BTREE,
  KEY `usr_create` (`usr_create`) USING BTREE,
  KEY `usr_modify` (`usr_modify`) USING BTREE,
  KEY `dat_create` (`dat_create`) USING BTREE,
  KEY `dat_modify` (`dat_modify`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='债权投资记录';

-- ----------------------------
-- Records of otc_cl_ivs_redemption
-- ----------------------------

-- ----------------------------
-- Table structure for otc_cl_mast
-- ----------------------------
DROP TABLE IF EXISTS `otc_cl_mast`;
CREATE TABLE `otc_cl_mast` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `type` tinyint(4) DEFAULT '0' COMMENT '投资模式 1债权转让方式购买(按金额)  2收益权转让方式购买（按份数）',
  `capitalid` int(11) DEFAULT '0' COMMENT '资金表ID',
  `product_name` varchar(255) DEFAULT '' COMMENT '债权名称',
  `code` varchar(255) DEFAULT '' COMMENT '债权OTC代码',
  `borrower` varchar(64) DEFAULT '' COMMENT '借款人姓名',
  `cod_card_type` tinyint(1) DEFAULT '0' COMMENT '证件类型',
  `cod_card_no` varchar(64) DEFAULT '' COMMENT '证件号码',
  `prov` int(11) DEFAULT '0' COMMENT '所在省份',
  `city` varchar(32) DEFAULT '' COMMENT '所在城市',
  `district` int(11) DEFAULT '0' COMMENT '所在区县',
  `period` varchar(32) DEFAULT '' COMMENT '期数（这个债权几个月）',
  `address` varchar(100) DEFAULT '' COMMENT '住所',
  `telephone` varchar(32) DEFAULT '' COMMENT '联系方式',
  `use` varchar(255) DEFAULT '' COMMENT '用途',
  `startdate` date DEFAULT '0000-00-00' COMMENT '开始日期',
  `enddate` date DEFAULT '0000-00-00' COMMENT '结束日期 ',
  `status` tinyint(4) DEFAULT '0' COMMENT '债权状态 0暂存  1 待审核 （7待OTC审核 8OTC审核中 9OTC审核失败 ）2待发布 3审核失败  4待销售 5销售中 6已售罄   10发布退回',
  `auditmemo` varchar(255) DEFAULT '' COMMENT '审核备注',
  `validflag` tinyint(1) DEFAULT '0' COMMENT '回收状态',
  `amt_cf_inv_price` decimal(22,2) DEFAULT '0.00' COMMENT '金额',
  `rat_cf_inv_min` decimal(22,2) DEFAULT '0.00' COMMENT '年化收益利率',
  `repay` varchar(32) DEFAULT '' COMMENT '还款方式',
  `mortgageassets` varchar(255) DEFAULT '' COMMENT '资产抵押信息',
  `assetholders` varchar(255) DEFAULT '' COMMENT '资产持有人',
  `usr_create` int(11) DEFAULT '0' COMMENT '创建人员',
  `dat_create` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `usr_modify` int(11) DEFAULT '0' COMMENT '维护人员',
  `dat_modify` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '维护时间',
  `transdebt` decimal(22,2) DEFAULT '0.00' COMMENT '本次转让债权价值',
  `needpay` decimal(22,2) DEFAULT '0.00' COMMENT '需支付对价',
  `account` varchar(255) DEFAULT '' COMMENT '账户',
  `accbank` varchar(255) DEFAULT '' COMMENT '开户行',
  `accountno` varchar(20) DEFAULT '' COMMENT '账号',
  `attr` varchar(255) DEFAULT '' COMMENT '借款属性',
  PRIMARY KEY (`id`),
  KEY `type` (`type`) USING BTREE,
  KEY `capitalid` (`capitalid`) USING BTREE,
  KEY `product_name` (`product_name`) USING BTREE,
  KEY `code` (`code`) USING BTREE,
  KEY `borrower` (`borrower`) USING BTREE,
  KEY `cod_card_no` (`cod_card_no`) USING BTREE,
  KEY `cod_card_type` (`cod_card_type`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `validflag` (`validflag`) USING BTREE,
  KEY `usr_create` (`usr_create`) USING BTREE,
  KEY `usr_modify` (`usr_modify`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=290 DEFAULT CHARSET=utf8 COMMENT='债权表';

-- ----------------------------
-- Records of otc_cl_mast
-- ----------------------------
INSERT INTO `otc_cl_mast` VALUES ('288', '1', '0', '资邦年瑞', '', '曹林娣', '1', '320222194702287563', '0', '', '0', '12', '江苏省无锡市新区鸿运苑356-1101', '88993761', '资金周转', '2016-04-01', '2017-03-31', '0', '', '1', '80000.00', '11.50', '转账', '', '', '27', '2016-04-01 10:51:38', '27', '2016-04-01 10:59:21', '80000.00', '80000.00', '曹林娣', '中国建设银行无锡鸿山支行', '6217001240010990013', '');
INSERT INTO `otc_cl_mast` VALUES ('289', '1', '0', '14', '', '14', '1', '14', '0', '', '0', '1414', '1144', '14', '', '2016-04-13', '2016-04-22', '0', '', '0', '1415.00', '1414.00', '', '', '', '1', '2016-04-01 16:13:47', '1', '2016-04-01 16:14:11', '0.00', '0.00', '', '', '', '14145555');

-- ----------------------------
-- Table structure for otc_cl_mast_file
-- ----------------------------
DROP TABLE IF EXISTS `otc_cl_mast_file`;
CREATE TABLE `otc_cl_mast_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_id` int(11) DEFAULT '0' COMMENT '债权产品ID',
  `filename` varchar(255) DEFAULT '' COMMENT '文件名',
  `file` varchar(255) DEFAULT '' COMMENT '附件地址',
  `type` tinyint(1) DEFAULT '1' COMMENT '附件类型 0其他附件 1审核附件  ',
  `validflag` tinyint(1) DEFAULT '1' COMMENT '回收状态',
  `usr_create` int(11) DEFAULT '0' COMMENT '创建人员',
  `dat_create` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `cl_id` (`cl_id`) USING BTREE,
  KEY `filename` (`filename`) USING BTREE,
  KEY `file` (`file`) USING BTREE,
  KEY `type` (`type`) USING BTREE,
  KEY `validflag` (`validflag`) USING BTREE,
  KEY `usr_create` (`usr_create`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=354 DEFAULT CHARSET=utf8 COMMENT='债权相关附件';

-- ----------------------------
-- Records of otc_cl_mast_file
-- ----------------------------

-- ----------------------------
-- Table structure for otc_cl_mast_self_field
-- ----------------------------
DROP TABLE IF EXISTS `otc_cl_mast_self_field`;
CREATE TABLE `otc_cl_mast_self_field` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增字段',
  `cl_id` int(11) unsigned DEFAULT '0' COMMENT '债权管理id',
  `field_name` varchar(100) DEFAULT '' COMMENT '字段描述',
  `field_en_name` varchar(100) DEFAULT '' COMMENT '字段英文名称',
  `field_type` tinyint(1) unsigned DEFAULT '1' COMMENT '1:输入框 2下拉菜单 3单选 4多选 5富文本',
  `field_option` varchar(255) DEFAULT '' COMMENT '客户可选择的选择项',
  `update_time` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `cl_id` (`cl_id`) USING BTREE,
  KEY `field_type` (`field_type`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='债权专有字段名称';

-- ----------------------------
-- Records of otc_cl_mast_self_field
-- ----------------------------

-- ----------------------------
-- Table structure for otc_cl_mast_self_field_value
-- ----------------------------
DROP TABLE IF EXISTS `otc_cl_mast_self_field_value`;
CREATE TABLE `otc_cl_mast_self_field_value` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cl_id` int(11) DEFAULT NULL,
  `field_id` int(11) unsigned DEFAULT '0' COMMENT '参数ID',
  `field_name` varchar(255) DEFAULT '' COMMENT '参数名',
  `field_value` varchar(255) DEFAULT '' COMMENT '参数值',
  `update_time` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `cl_id` (`cl_id`) USING BTREE,
  KEY `field_id` (`field_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='债权专有属性的属性值';

-- ----------------------------
-- Records of otc_cl_mast_self_field_value
-- ----------------------------

-- ----------------------------
-- Table structure for otc_cust_crm
-- ----------------------------
DROP TABLE IF EXISTS `otc_cust_crm`;
CREATE TABLE `otc_cust_crm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_cust_code` varchar(64) DEFAULT '' COMMENT '客户编号',
  `cod_cust_id` int(11) DEFAULT '0',
  `source` varchar(255) DEFAULT '' COMMENT '客户来源',
  `custname` varchar(255) DEFAULT '' COMMENT '客户名称',
  `consultant` varchar(255) DEFAULT '' COMMENT '顾问',
  `team` varchar(255) DEFAULT '' COMMENT '所属团队',
  `store` varchar(255) DEFAULT '' COMMENT '门店',
  `storemanager` varchar(255) DEFAULT '' COMMENT '门店经理',
  `division` varchar(255) DEFAULT '' COMMENT '分部',
  `areamanager` varchar(255) DEFAULT '' COMMENT '区域经理',
  `producttype` varchar(255) DEFAULT '' COMMENT '产品类型',
  `receiptdate` varchar(255) DEFAULT '' COMMENT '收款日期',
  `receivablesamount` varchar(255) DEFAULT '' COMMENT '收款金额',
  `years` varchar(255) DEFAULT '' COMMENT '年华',
  `rateofreturn` varchar(255) DEFAULT '' COMMENT '收益率',
  `installments` varchar(255) DEFAULT '' COMMENT '期数',
  `paymentmethod` varchar(255) DEFAULT '' COMMENT '收款方式',
  `iscontinued` varchar(255) DEFAULT '' COMMENT '续投与否',
  `plandate` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '预计出款日',
  `outprincipal` varchar(255) DEFAULT '' COMMENT '出账本金',
  `outinterest` varchar(255) DEFAULT '' COMMENT '出账利息',
  `realmanagementfee` decimal(10,2) DEFAULT '0.00' COMMENT '实收管理费',
  `breakcontractamount` decimal(10,2) DEFAULT '0.00' COMMENT '违约金',
  `breakcontractamountrate` decimal(10,2) DEFAULT '0.00' COMMENT '违约金费率',
  `birthday` date DEFAULT '0000-00-00' COMMENT '客户生日',
  `tel` varchar(20) DEFAULT '' COMMENT '联系电话',
  `bizcode` varchar(20) DEFAULT '' COMMENT '邮编',
  `address` varchar(255) DEFAULT '' COMMENT '地址',
  `bankopen` varchar(255) DEFAULT '' COMMENT '开户行',
  `bankaccount` varchar(50) DEFAULT '' COMMENT '银行账户',
  `informationbypost` varchar(50) DEFAULT '' COMMENT '资料邮寄方式',
  `memo` varchar(255) DEFAULT '' COMMENT '备注',
  `usr_modify` varchar(32) DEFAULT '' COMMENT '维护人员',
  `dat_modify` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '维护时间',
  `contractamount` varchar(255) DEFAULT '' COMMENT '合同金额',
  `contractno` varchar(255) DEFAULT '' COMMENT '合同编号',
  `crm_file` varchar(2000) DEFAULT '' COMMENT 'crm照片，多图用分融符',
  PRIMARY KEY (`id`),
  KEY `cod_cust_id` (`cod_cust_id`) USING BTREE,
  KEY `usr_modify` (`usr_modify`) USING BTREE,
  KEY `dat_modify` (`dat_modify`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8 COMMENT='客户-个人信息';

-- ----------------------------
-- Records of otc_cust_crm
-- ----------------------------
INSERT INTO `otc_cust_crm` VALUES ('1', '', '1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0000-00-00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '');

-- ----------------------------
-- Table structure for otc_cust_person
-- ----------------------------
DROP TABLE IF EXISTS `otc_cust_person`;
CREATE TABLE `otc_cust_person` (
  `cod_cust_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '客户编号',
  `cod_cust_id_type` varchar(32) DEFAULT '' COMMENT '证件类型',
  `cod_cust_id_no` varchar(64) DEFAULT '' COMMENT '证件号码',
  `password` varchar(100) DEFAULT '',
  `tel` varchar(100) DEFAULT '',
  `otc_jszh` varchar(255) DEFAULT '' COMMENT 'OTC客户编号（结算账户）',
  `crm_file` varchar(300) DEFAULT '',
  `flg_cust_employee` varchar(32) DEFAULT '0' COMMENT '是否内部员工',
  `cod_cust_gender` varchar(1) DEFAULT '' COMMENT '性别',
  `nam_cust_real` varchar(128) DEFAULT '' COMMENT '会员真实姓名',
  `cod_cust_marr` varchar(32) DEFAULT NULL COMMENT '婚姻状况',
  `cod_cust_edu` varchar(32) DEFAULT NULL COMMENT '最高学历',
  `cod_cust_job` varchar(32) DEFAULT NULL COMMENT '职业',
  `amt_cust_mon` float DEFAULT NULL COMMENT '月收入',
  `dat_cust_birthday` date DEFAULT NULL COMMENT '生日',
  `cod_cust_fax` varchar(32) DEFAULT NULL COMMENT '传真',
  `cod_cust_web` varchar(128) DEFAULT NULL COMMENT '个人主页',
  `cod_cust_add_reg` varchar(256) DEFAULT NULL COMMENT '户口所在地',
  `cod_cust_house` varchar(32) DEFAULT NULL COMMENT '住房条件',
  `cod_cust_prov` int(11) DEFAULT NULL COMMENT '所在省份',
  `cod_cust_city` int(11) DEFAULT NULL COMMENT '所在城市',
  `cod_cust_district` int(11) DEFAULT NULL COMMENT '所在区县',
  `cod_cust_add` varchar(256) DEFAULT NULL COMMENT '住址',
  `cod_cust_zip` varchar(6) DEFAULT NULL COMMENT '邮政编码',
  `cod_cust_qq` varchar(64) DEFAULT NULL COMMENT 'QQ',
  `cod_cust_wangwang` varchar(64) DEFAULT NULL COMMENT '旺旺',
  `cod_cust_alipay` varchar(64) DEFAULT NULL COMMENT '支付宝账号',
  `cod_cust_thirdpay` varchar(64) DEFAULT NULL COMMENT '第三方支付账号',
  `cod_cust_inschool` varchar(4) DEFAULT NULL COMMENT '入学年份',
  `nam_cust_school` varchar(64) DEFAULT NULL COMMENT '毕业院校',
  `flg_cust_child` tinyint(1) DEFAULT NULL COMMENT '有无子女',
  `flg_cust_house` tinyint(1) DEFAULT NULL COMMENT '是否有房',
  `flg_cust_houseloan` tinyint(1) DEFAULT NULL COMMENT '有无房贷',
  `flg_cust_car` tinyint(1) DEFAULT NULL COMMENT '是否购车',
  `flg_cust_carloan` tinyint(1) DEFAULT NULL COMMENT '有无车贷',
  `txt_cust_remarks` varchar(256) DEFAULT NULL COMMENT '描述',
  `accounttype` tinyint(4) DEFAULT '0' COMMENT '账号类型 1持有人客户 0购买客户',
  `dat_modify` datetime DEFAULT NULL COMMENT '维护时间',
  `usr_modify` int(11) DEFAULT '0' COMMENT '维护人员',
  `add_time` datetime DEFAULT NULL COMMENT '添加时间',
  `add_usr` int(11) DEFAULT '0' COMMENT '录入员',
  PRIMARY KEY (`cod_cust_id`),
  KEY `cod_cust_id` (`cod_cust_id`) USING BTREE,
  KEY `cod_cust_id_type` (`cod_cust_id_type`) USING BTREE,
  KEY `add_usr` (`add_usr`) USING BTREE,
  KEY `add_time` (`add_time`) USING BTREE,
  KEY `usr_modify` (`usr_modify`) USING BTREE,
  KEY `dat_modify` (`dat_modify`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8 COMMENT='客户-个人信息';

-- ----------------------------
-- Records of otc_cust_person
-- ----------------------------
INSERT INTO `otc_cust_person` VALUES ('1', '0', 'zillionfortune', 'MTIzNDU2', '', 'TJC10000000942', '', '0', '', '系统持有人', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, '0', null, '0');

-- ----------------------------
-- Table structure for otc_department
-- ----------------------------
DROP TABLE IF EXISTS `otc_department`;
CREATE TABLE `otc_department` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '上级部门id 0为顶级部门',
  `organization_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '机构ID 默认1 为资邦财富',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '部门名称',
  `description` varchar(128) NOT NULL DEFAULT '' COMMENT '部门描述',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1有效 2无效 3注销',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='部门表';

-- ----------------------------
-- Records of otc_department
-- ----------------------------
INSERT INTO `otc_department` VALUES ('1', '3', '1', '战略发展的1', '战略发展部门', '1', '2016-01-05 14:52:19');
INSERT INTO `otc_department` VALUES ('2', '0', '1', '产品部11', '产品部都是大神', '1', '2015-12-30 16:27:34');
INSERT INTO `otc_department` VALUES ('3', '0', '1', '投资部', '投资部', '3', '2016-01-05 14:44:45');
INSERT INTO `otc_department` VALUES ('7', '0', '1', 'wwww', '', '1', '2016-01-05 14:57:18');
INSERT INTO `otc_department` VALUES ('8', '0', '1', '市场部', '', '1', '2016-01-05 15:02:39');
INSERT INTO `otc_department` VALUES ('9', '0', '3', '资邦财盈总部', '', '1', '2016-02-03 21:35:03');
INSERT INTO `otc_department` VALUES ('10', '9', '3', '上海门店', '', '1', '2016-02-03 21:35:16');
INSERT INTO `otc_department` VALUES ('11', '9', '3', '广东门店', '', '1', '2016-02-03 21:35:30');
INSERT INTO `otc_department` VALUES ('12', '9', '3', '温州门店', '', '1', '2016-02-03 21:35:47');
INSERT INTO `otc_department` VALUES ('13', '9', '3', '职能部门', '', '1', '2016-02-03 21:36:13');
INSERT INTO `otc_department` VALUES ('14', '0', '3', '资邦财盈总部', '', '3', '2016-02-03 21:48:31');
INSERT INTO `otc_department` VALUES ('15', '9', '3', '资邦财盈总部', '', '1', '2016-02-03 21:49:01');
INSERT INTO `otc_department` VALUES ('16', '9', '3', '财务部', '', '1', '2016-03-31 09:55:54');
INSERT INTO `otc_department` VALUES ('17', '9', '3', '客服部', '', '1', '2016-03-31 09:56:06');
INSERT INTO `otc_department` VALUES ('18', '9', '3', '风控部', '', '1', '2016-03-31 09:56:17');

-- ----------------------------
-- Table structure for otc_dz_dbf
-- ----------------------------
DROP TABLE IF EXISTS `otc_dz_dbf`;
CREATE TABLE `otc_dz_dbf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cust_id` int(11) NOT NULL COMMENT '交易记录ID',
  `cf_mast_id` int(11) NOT NULL COMMENT '确权记录表ID',
  `dz_file` varchar(255) NOT NULL COMMENT '对账文件地址',
  `otc_file_id` int(11) NOT NULL DEFAULT '0' COMMENT '当日文件序号',
  `validflag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '回收状态',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '2下载 3OTC确认',
  `createdate` date NOT NULL COMMENT '创建日期',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `TADM` varchar(8) DEFAULT '',
  `DZGLRM` varchar(32) DEFAULT '',
  `DZDLRM` varchar(32) DEFAULT '',
  `DZCPDM` varchar(16) DEFAULT '',
  `DZJSZH` varchar(16) DEFAULT '',
  `DZJYZH` varchar(16) DEFAULT '',
  `DZCYFE` decimal(18,2) DEFAULT '0.00',
  `DZDJFE` decimal(18,2) DEFAULT '0.00',
  `DZHSFE` decimal(18,2) DEFAULT '0.00',
  `DZGHRQ` varchar(8) DEFAULT '',
  `DZFSRQ` varchar(8) DEFAULT '',
  `DZJRBH` varchar(16) DEFAULT '',
  `DZBYBZ` varchar(10) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cust_id` (`cust_id`) USING BTREE,
  KEY `cf_mast_id` (`cf_mast_id`) USING BTREE,
  KEY `dz_file` (`dz_file`) USING BTREE,
  KEY `otc_file_id` (`otc_file_id`) USING BTREE,
  KEY `validflag` (`validflag`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `DZCPDM` (`DZCPDM`) USING BTREE,
  KEY `DZJYZH` (`DZJYZH`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='对账回报文件';

-- ----------------------------
-- Records of otc_dz_dbf
-- ----------------------------
INSERT INTO `otc_dz_dbf` VALUES ('1', '1', '0', './Uploads/DZBD/20160325/TJC_TJC999_SEZB004_20160219_173118_DZBD.DBF', '4014', '1', '3', '2016-03-25', '2016-03-25 17:32:02', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB001           ', 'TJC10000000501  ', '1               ', '199600000.00', '0.00', '0.00', '20160323', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('2', '1', '0', './Uploads/DZBD/20160325/TJC_TJC999_SEZB004_20160219_173118_DZBD.DBF', '4014', '1', '3', '2016-03-25', '2016-03-25 17:32:02', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB002           ', 'TJC10000000501  ', '1               ', '200000000.00', '0.00', '0.00', '20160321', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('3', '1', '0', './Uploads/DZBD/20160325/TJC_TJC999_SEZB004_20160219_221837_DZBD.DBF', '4024', '1', '3', '2016-03-25', '2016-03-25 22:19:22', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB002           ', 'TJC10000000501  ', '1               ', '200000000.00', '0.00', '0.00', '20160321', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('4', '1', '0', './Uploads/DZBD/20160325/TJC_TJC999_SEZB004_20160219_221837_DZBD.DBF', '4024', '1', '3', '2016-03-25', '2016-03-25 22:19:22', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB001           ', 'TJC10000000501  ', '1               ', '199600000.00', '0.00', '0.00', '20160323', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('5', '1', '0', './Uploads/DZBD/20160325/TJC_TJC999_SEZB004_20160219_221938_DZBD.DBF', '4026', '1', '3', '2016-03-25', '2016-03-25 22:20:23', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB002           ', 'TJC10000000501  ', '1               ', '200000000.00', '0.00', '0.00', '20160321', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('6', '1', '0', './Uploads/DZBD/20160325/TJC_TJC999_SEZB004_20160219_221938_DZBD.DBF', '4026', '1', '3', '2016-03-25', '2016-03-25 22:20:23', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB001           ', 'TJC10000000501  ', '1               ', '199600000.00', '0.00', '0.00', '20160323', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('7', '1', '0', './Uploads/DZBD/20160325/TJC_TJC999_SEZB004_20160219_222039_DZBD.DBF', '4028', '1', '3', '2016-03-25', '2016-03-25 22:21:24', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB002           ', 'TJC10000000501  ', '1               ', '200000000.00', '0.00', '0.00', '20160321', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('8', '1', '0', './Uploads/DZBD/20160325/TJC_TJC999_SEZB004_20160219_222039_DZBD.DBF', '4028', '1', '3', '2016-03-25', '2016-03-25 22:21:24', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB001           ', 'TJC10000000501  ', '1               ', '199600000.00', '0.00', '0.00', '20160323', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('9', '1', '0', './Uploads/DZBD/20160328/TJC_TJC999_SEZB004_20160219_153829_DZBD.DBF', '4046', '1', '3', '2016-03-28', '2016-03-28 15:39:34', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB001           ', 'TJC10000000501  ', '1               ', '199600000.00', '0.00', '0.00', '20160323', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('10', '1', '0', './Uploads/DZBD/20160328/TJC_TJC999_SEZB004_20160219_153829_DZBD.DBF', '4046', '1', '3', '2016-03-28', '2016-03-28 15:39:34', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB002           ', 'TJC10000000501  ', '1               ', '200000000.00', '0.00', '0.00', '20160321', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('11', '1', '0', './Uploads/DZBD/20160328/TJC_TJC999_SEZB004_20160219_154229_DZBD.DBF', '4048', '1', '3', '2016-03-28', '2016-03-28 15:43:34', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB001           ', 'TJC10000000501  ', '1               ', '199600000.00', '0.00', '0.00', '20160323', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('12', '1', '0', './Uploads/DZBD/20160328/TJC_TJC999_SEZB004_20160219_154229_DZBD.DBF', '4048', '1', '3', '2016-03-28', '2016-03-28 15:43:34', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB002           ', 'TJC10000000501  ', '1               ', '200000000.00', '0.00', '0.00', '20160321', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('13', '1', '0', './Uploads/DZBD/20160328/TJC_TJC999_SEZB004_20160219_155331_DZBD.DBF', '4050', '1', '3', '2016-03-28', '2016-03-28 15:54:36', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB001           ', 'TJC10000000501  ', '1               ', '199600000.00', '0.00', '0.00', '20160323', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('14', '1', '0', './Uploads/DZBD/20160328/TJC_TJC999_SEZB004_20160219_155331_DZBD.DBF', '4050', '1', '3', '2016-03-28', '2016-03-28 15:54:36', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB002           ', 'TJC10000000501  ', '1               ', '195140000.00', '0.00', '0.00', '20160321', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('15', '1', '0', './Uploads/DZBD/20160329/TJC_TJC999_SEZB004_20160219_100307_DZBD.DBF', '4089', '1', '3', '2016-03-29', '2016-03-29 10:04:18', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB002           ', 'TJC10000000501  ', '1               ', '200000000.00', '0.00', '0.00', '20160321', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('16', '1', '0', './Uploads/DZBD/20160329/TJC_TJC999_SEZB004_20160219_100307_DZBD.DBF', '4089', '1', '3', '2016-03-29', '2016-03-29 10:04:18', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB001           ', 'TJC10000000501  ', '1               ', '200000000.00', '0.00', '0.00', '20160323', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('17', '1', '0', './Uploads/DZBD/20160329/TJC_TJC999_SEZB004_20160219_100904_DZBD.DBF', '4091', '1', '3', '2016-03-29', '2016-03-29 10:10:15', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB001           ', 'TJC10000000501  ', '1               ', '400000000.00', '0.00', '0.00', '20160217', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('18', '1', '0', './Uploads/DZBD/20160329/TJC_TJC999_SEZB004_20160219_100904_DZBD.DBF', '4091', '1', '3', '2016-03-29', '2016-03-29 10:10:15', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB002           ', 'TJC10000000501  ', '1               ', '400000000.00', '0.00', '0.00', '20160217', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('19', '1', '0', './Uploads/DZBD/20160330/TJC_TJC999_SEZB004_20160219_172608_DZBD.DBF', '4151', '1', '3', '2016-03-30', '2016-03-30 17:27:29', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB002           ', 'TJC10000000501  ', '1               ', '200000000.00', '0.00', '0.00', '20160217', '20160219', '                ', '          ');
INSERT INTO `otc_dz_dbf` VALUES ('20', '1', '0', './Uploads/DZBD/20160330/TJC_TJC999_SEZB004_20160219_172608_DZBD.DBF', '4151', '1', '3', '2016-03-30', '2016-03-30 17:27:29', 'TJC999  ', '                                ', 'SEZB004                         ', 'ZB001           ', 'TJC10000000501  ', '1               ', '200000000.00', '0.00', '0.00', '20160217', '20160219', '                ', '          ');

-- ----------------------------
-- Table structure for otc_gb_dbf
-- ----------------------------
DROP TABLE IF EXISTS `otc_gb_dbf`;
CREATE TABLE `otc_gb_dbf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cf_ivs_id` int(11) NOT NULL DEFAULT '0' COMMENT '交易记录ID',
  `cf_ivs_redemption_id` int(11) DEFAULT '0' COMMENT '赎回投资ID',
  `cf_ivs_right_id` int(11) NOT NULL DEFAULT '0' COMMENT '确权记录表ID',
  `gb_file` varchar(255) DEFAULT '' COMMENT '过户回报文件地址',
  `otc_file_id` int(11) DEFAULT '0' COMMENT '当日文件序号',
  `validflag` tinyint(1) DEFAULT '1' COMMENT '回收状态',
  `status` tinyint(1) DEFAULT '1' COMMENT '2下载 3OTC确认',
  `createdate` date DEFAULT '0000-00-00' COMMENT '创建日期',
  `createtime` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `TADM` varchar(8) DEFAULT '',
  `GBDLRM` varchar(32) DEFAULT '',
  `GBHBRQ` varchar(8) DEFAULT '',
  `GHHBDH` varchar(32) DEFAULT '',
  `GBCPDM` varchar(16) DEFAULT '',
  `GBJSZH` varchar(16) DEFAULT '',
  `GBJYZH` varchar(16) DEFAULT '',
  `GBSQRQ` varchar(8) DEFAULT '',
  `GBSQDH` varchar(32) DEFAULT '',
  `GBCJFX` varchar(2) DEFAULT '',
  `GBCJJG` varchar(32) DEFAULT '',
  `GBCJSL` varchar(32) DEFAULT '',
  `GBCJJE` varchar(32) DEFAULT '',
  `GBBCYE` varchar(32) DEFAULT '',
  `GBFSRQ` varchar(8) DEFAULT '',
  `GBJRBH` varchar(16) DEFAULT '',
  `GBFHDM` varchar(4) DEFAULT '',
  `GBBYBZ` varchar(10) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cf_ivs_id` (`cf_ivs_id`) USING BTREE,
  KEY `cf_ivs_right_id` (`cf_ivs_right_id`) USING BTREE,
  KEY `gb_file` (`gb_file`) USING BTREE,
  KEY `otc_file_id` (`otc_file_id`) USING BTREE,
  KEY `validflag` (`validflag`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='过户回报文件';

-- ----------------------------
-- Records of otc_gb_dbf
-- ----------------------------

-- ----------------------------
-- Table structure for otc_gh_dbf
-- ----------------------------
DROP TABLE IF EXISTS `otc_gh_dbf`;
CREATE TABLE `otc_gh_dbf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cf_ivs_id` int(11) DEFAULT '0' COMMENT '交易记录ID',
  `cf_ivs_redemption_id` int(11) DEFAULT '0' COMMENT '赎回投资ID',
  `cf_ivs_right_id` int(11) DEFAULT '0' COMMENT '确权记录表ID',
  `gh_file` varchar(255) DEFAULT '' COMMENT '过户文件地址',
  `file_no` int(11) DEFAULT '0' COMMENT '当日文件序号',
  `validflag` tinyint(1) DEFAULT '1' COMMENT '回收状态',
  `status` tinyint(1) DEFAULT '1' COMMENT '1生成 2发送 3OTC确认',
  `createdate` date DEFAULT '0000-00-00' COMMENT '创建日期',
  `createtime` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `GHDLRM` varchar(32) DEFAULT '' COMMENT '销售代理人代码',
  `GHCPDM` varchar(16) DEFAULT '' COMMENT '产品代码',
  `GHJSZH` varchar(16) DEFAULT '' COMMENT '结算账户',
  `GHJYZH` varchar(16) DEFAULT '' COMMENT '交易账户',
  `GHSQRQ` varchar(8) DEFAULT '' COMMENT '申请日期',
  `GHSQDH` varchar(32) DEFAULT '' COMMENT '申请单号',
  `GHCJFX` varchar(2) DEFAULT '' COMMENT '买卖方向 B买入  S卖出',
  `GHCJJG` decimal(12,4) DEFAULT '0.0000' COMMENT '成交价格',
  `GHCJSL` decimal(16,2) DEFAULT '0.00' COMMENT '成交数量',
  `GHCJJE` decimal(16,2) DEFAULT '0.00' COMMENT '成交金额',
  `GHFSRQ` varchar(8) DEFAULT '' COMMENT '发送日期   YYYYMMDD ',
  `GHJRBH` varchar(16) DEFAULT '' COMMENT '经纪人编号',
  `GHBYBZ` varchar(10) DEFAULT '' COMMENT '备用标志',
  PRIMARY KEY (`id`),
  KEY `cf_ivs_id` (`cf_ivs_id`) USING BTREE,
  KEY `gh_file` (`gh_file`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `validflag` (`validflag`) USING BTREE,
  KEY `file_no` (`file_no`) USING BTREE,
  KEY `cf_ivs_right_id` (`cf_ivs_right_id`) USING BTREE,
  KEY `GHSQDH` (`GHSQDH`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=618 DEFAULT CHARSET=utf8 COMMENT='过户文件';

-- ----------------------------
-- Records of otc_gh_dbf
-- ----------------------------

-- ----------------------------
-- Table structure for otc_kb_dbf
-- ----------------------------
DROP TABLE IF EXISTS `otc_kb_dbf`;
CREATE TABLE `otc_kb_dbf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cf_ivs_id` int(11) DEFAULT '0' COMMENT '交易记录ID',
  `cf_ivs_right_id` int(11) DEFAULT '0' COMMENT '确权记录表ID',
  `kb_file` varchar(255) DEFAULT '' COMMENT '开户文件地址',
  `otc_file_id` int(11) DEFAULT '0' COMMENT 'OTC文件ID',
  `validflag` tinyint(1) DEFAULT '1' COMMENT '回收状态',
  `status` tinyint(1) DEFAULT '1' COMMENT '2下载 3OTC确认',
  `createdate` date DEFAULT '0000-00-00' COMMENT '创建日期',
  `createtime` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `TADM` varchar(8) DEFAULT '' COMMENT '结算所代码',
  `KBHBRQ` varchar(8) DEFAULT '' COMMENT '确认日期',
  `KBHBDH` varchar(32) DEFAULT '' COMMENT '确认单号',
  `KBDLRM` varchar(32) DEFAULT '' COMMENT '销售代理人代码',
  `KBSQRQ` varchar(8) DEFAULT '' COMMENT '申请日期',
  `KBSQDH` varchar(32) DEFAULT '' COMMENT '申请单号',
  `KBJSZH` varchar(16) DEFAULT '' COMMENT '结算账户',
  `KBYWLX` varchar(3) DEFAULT '' COMMENT '业务类型',
  `KBJYZH` varchar(16) DEFAULT '' COMMENT '交易账户',
  `KBTZRM` varchar(250) DEFAULT '' COMMENT '投资人名',
  `KBTZJC` varchar(64) DEFAULT '' COMMENT '投资人民简称',
  `KBTRZL` varchar(2) DEFAULT '' COMMENT '投资人证件类型',
  `KBTRZH` varchar(30) DEFAULT '' COMMENT '投资人证件号码',
  `KBCSRQ` varchar(8) DEFAULT '' COMMENT '出生日期',
  `KBTRXB` varchar(1) DEFAULT '' COMMENT '性别',
  `KBTRXL` varchar(2) DEFAULT '' COMMENT '学历',
  `KBTRZY` varchar(2) DEFAULT '' COMMENT '职业',
  `KBDWMC` varchar(60) DEFAULT '' COMMENT '单位名称',
  `KBZZDH` varchar(24) DEFAULT '' COMMENT '住宅电话',
  `KBSJHM` varchar(24) DEFAULT '' COMMENT '手机号码',
  `KBDWDH` varchar(24) DEFAULT '' COMMENT '单位电话',
  `KBCZHM` varchar(24) DEFAULT '' COMMENT '传真号码',
  `KBDZYJ` varchar(40) DEFAULT '' COMMENT '电子邮件',
  `KBYZBM` varchar(6) DEFAULT '' COMMENT '邮政编码',
  `KBTXDZ` varchar(250) DEFAULT '' COMMENT '通讯地址',
  `KBFRXM` varchar(20) DEFAULT '' COMMENT '法人代表姓名',
  `KBFRZL` varchar(2) DEFAULT '' COMMENT '法人代表证件类型',
  `KBFRZH` varchar(30) DEFAULT '' COMMENT '法人代表证件号码',
  `KBJRXM` varchar(20) DEFAULT '' COMMENT '经办人姓名',
  `KBJRZL` varchar(2) DEFAULT '' COMMENT '经办人证件类型',
  `KBJRZH` varchar(30) DEFAULT '' COMMENT '经办人证件号码',
  `KBFHDM` varchar(4) DEFAULT '' COMMENT '返回代码',
  `KBKHZT` varchar(2) DEFAULT '' COMMENT '客户状态',
  `KBFSRQ` varchar(8) DEFAULT '' COMMENT '发送日期',
  `KBFXJB` varchar(8) DEFAULT '' COMMENT '客户风险级别',
  `KBFXCN` varchar(1) DEFAULT '' COMMENT '客户风险承诺函',
  `KBJRBH` varchar(16) DEFAULT '' COMMENT '经纪人编号',
  `KBBYBZ` varchar(10) DEFAULT '' COMMENT '备用标志',
  PRIMARY KEY (`id`),
  KEY `cf_ivs_id` (`cf_ivs_id`) USING BTREE,
  KEY `cf_ivs_right_id` (`cf_ivs_right_id`) USING BTREE,
  KEY `kb_file` (`kb_file`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `validflag` (`validflag`) USING BTREE,
  KEY `otc_file_id` (`otc_file_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='开户回报文件表';

-- ----------------------------
-- Records of otc_kb_dbf
-- ----------------------------

-- ----------------------------
-- Table structure for otc_kh_dbf
-- ----------------------------
DROP TABLE IF EXISTS `otc_kh_dbf`;
CREATE TABLE `otc_kh_dbf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cf_ivs_id` int(11) DEFAULT '0' COMMENT '交易记录ID',
  `cf_ivs_right_id` int(11) DEFAULT '0' COMMENT '确权记录表ID',
  `kh_file` varchar(255) DEFAULT '' COMMENT '开户文件地址',
  `file_no` int(11) DEFAULT '0' COMMENT '当日文件序号',
  `validflag` tinyint(1) DEFAULT '1' COMMENT '回收状态',
  `status` tinyint(1) DEFAULT '1' COMMENT '1生成 2发送 3OTC确认',
  `createdate` date DEFAULT '0000-00-00' COMMENT '创建日期',
  `createtime` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `KHDLRM` varchar(32) DEFAULT '' COMMENT '销售代理人代码',
  `KHSQRQ` varchar(8) DEFAULT '' COMMENT '申请日期',
  `KHSQDH` varchar(32) DEFAULT '' COMMENT '申请单号',
  `KHJSZH` varchar(16) DEFAULT '' COMMENT '结算账户',
  `KHYWLX` varchar(3) DEFAULT '' COMMENT '业务类型',
  `KHJYZH` varchar(16) DEFAULT '' COMMENT '交易账户',
  `KHTZRM` varchar(250) DEFAULT '' COMMENT '投资人名',
  `KHTZJC` varchar(64) DEFAULT '' COMMENT '投资人名-简称 ',
  `KHTRZL` varchar(2) DEFAULT '' COMMENT '投资人证件类型',
  `KHTRZH` varchar(30) DEFAULT '' COMMENT '投资人证件号码',
  `KHCSRQ` varchar(8) DEFAULT '' COMMENT '出生日期',
  `KHTRXB` varchar(1) DEFAULT '' COMMENT '性别',
  `KHTRXL` varchar(2) DEFAULT '' COMMENT '学历',
  `KHTRZY` varchar(2) DEFAULT '' COMMENT '职业',
  `KHDWMC` varchar(60) DEFAULT '' COMMENT '单位名称',
  `KHZZHD` varchar(24) DEFAULT '' COMMENT '住宅电话',
  `KHSJHM` varchar(24) DEFAULT '' COMMENT '手机号码',
  `KHDWDH` varchar(24) DEFAULT '' COMMENT '单位电话',
  `KHCZHM` varchar(24) DEFAULT '' COMMENT '传真号码',
  `KHDZYJ` varchar(40) DEFAULT '' COMMENT '电子邮件',
  `KHYZBM` varchar(6) DEFAULT '' COMMENT '邮政编码',
  `KHTXDZ` varchar(250) DEFAULT '' COMMENT '通讯地址',
  `KHFRXM` varchar(20) DEFAULT '' COMMENT '法人代表姓名',
  `KHFRZL` varchar(2) DEFAULT '' COMMENT '法人代表证件类型',
  `KHFRZH` varchar(30) DEFAULT '' COMMENT '法人代表证件号码',
  `KHJRXM` varchar(20) DEFAULT '' COMMENT '经办人姓名',
  `KHJRZL` varchar(2) DEFAULT '' COMMENT '经办人证件类型',
  `KHJRZH` varchar(30) DEFAULT '' COMMENT '经办人证件号码',
  `KHFSRQ` varchar(8) DEFAULT '' COMMENT '发送日期',
  `KHFXJB` varchar(8) DEFAULT '' COMMENT '客户风险级别',
  `KHFXCN` varchar(1) DEFAULT '' COMMENT '客户风险承诺函',
  `KHJRBH` varchar(16) DEFAULT '' COMMENT '经纪人编号',
  `KHBYBZ` varchar(10) DEFAULT '' COMMENT '备用标志',
  PRIMARY KEY (`id`),
  KEY `cf_ivs_id` (`cf_ivs_id`) USING BTREE,
  KEY `cf_ivs_right_id` (`cf_ivs_right_id`) USING BTREE,
  KEY `kh_file` (`kh_file`) USING BTREE,
  KEY `file_no` (`file_no`) USING BTREE,
  KEY `validflag` (`validflag`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `KHSQDH` (`KHSQDH`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=965 DEFAULT CHARSET=utf8 COMMENT='开户文件表';

-- ----------------------------
-- Records of otc_kh_dbf
-- ----------------------------

-- ----------------------------
-- Table structure for otc_operation_log
-- ----------------------------
DROP TABLE IF EXISTS `otc_operation_log`;
CREATE TABLE `otc_operation_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作用户ID',
  `content` varchar(3000) NOT NULL DEFAULT '' COMMENT '日志内容',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='操作日志表';

-- ----------------------------
-- Records of otc_operation_log
-- ----------------------------
INSERT INTO `otc_operation_log` VALUES ('1', '1', '录入新产品！', '2015-12-16 14:49:57');
INSERT INTO `otc_operation_log` VALUES ('2', '7', '添加产品,产品编号为:', '2015-12-21 15:37:03');
INSERT INTO `otc_operation_log` VALUES ('3', '7', '添加产品,产品编号为:1', '2015-12-21 15:41:48');
INSERT INTO `otc_operation_log` VALUES ('4', '7', '添加产品,产品编号为:2', '2015-12-21 15:45:03');
INSERT INTO `otc_operation_log` VALUES ('5', '7', '添加产品,产品编号为:3', '2015-12-21 15:45:04');
INSERT INTO `otc_operation_log` VALUES ('6', '7', '添加产品,产品编号为:4', '2016-01-01 16:25:08');
INSERT INTO `otc_operation_log` VALUES ('7', '1', '用户：系统管理员 部门： , 修改登陆密码。', '2016-01-19 10:23:13');
INSERT INTO `otc_operation_log` VALUES ('8', '1', '用户：系统管理员 部门： , 修改登陆密码。', '2016-01-19 10:47:09');
INSERT INTO `otc_operation_log` VALUES ('9', '1', '用户：系统管理员 部门： , 修改登陆密码。', '2016-01-19 10:47:11');
INSERT INTO `otc_operation_log` VALUES ('10', '1', '用户：系统管理员 部门： , 修改登陆密码。', '2016-01-19 10:47:12');
INSERT INTO `otc_operation_log` VALUES ('11', '1', '用户：系统管理员 部门： , 修改登陆密码。', '2016-01-19 10:48:15');
INSERT INTO `otc_operation_log` VALUES ('12', '1', '用户：系统管理员 部门： , 修改登陆密码。', '2016-01-19 10:48:54');
INSERT INTO `otc_operation_log` VALUES ('13', '1', '用户：系统管理员 部门： , 修改登陆密码。', '2016-01-19 10:50:35');
INSERT INTO `otc_operation_log` VALUES ('14', '1', '用户：系统管理员 部门： , 修改登陆密码。', '2016-01-19 10:52:40');
INSERT INTO `otc_operation_log` VALUES ('15', '1', '用户：系统管理员 部门： , 修改登陆密码。', '2016-01-19 10:52:42');
INSERT INTO `otc_operation_log` VALUES ('16', '1', '用户：系统管理员 部门： , 修改登陆密码。', '2016-01-19 10:52:42');
INSERT INTO `otc_operation_log` VALUES ('17', '1', '用户：系统管理员 部门： , 修改登陆密码。', '2016-01-19 10:52:43');
INSERT INTO `otc_operation_log` VALUES ('18', '1', '用户：系统管理员 部门： , 修改登陆密码。', '2016-01-19 11:11:02');
INSERT INTO `otc_operation_log` VALUES ('19', '1', '系统管理员：创建用户帐号【xieyuling@zb.com】', '2016-02-03 21:51:49');
INSERT INTO `otc_operation_log` VALUES ('20', '1', '系统管理员：创建用户帐号【chenbo@zb.com】', '2016-02-03 21:52:46');
INSERT INTO `otc_operation_log` VALUES ('21', '1', '系统管理员：创建用户帐号【zhangpu@zb.com】', '2016-02-03 21:53:19');
INSERT INTO `otc_operation_log` VALUES ('22', '1', '系统管理员：创建用户帐号【xianglizhi@zb.com】', '2016-02-03 21:54:36');
INSERT INTO `otc_operation_log` VALUES ('23', '1', '系统管理员：创建用户帐号【wuyuhai@zb.com】', '2016-02-03 21:55:00');
INSERT INTO `otc_operation_log` VALUES ('24', '1', '系统管理员：创建用户帐号【miaoxiaofeng@zb.com】', '2016-02-03 21:56:25');
INSERT INTO `otc_operation_log` VALUES ('25', '1', '系统管理员：创建用户帐号【yuegang@zb.com】', '2016-02-03 21:57:17');
INSERT INTO `otc_operation_log` VALUES ('26', '1', '系统管理员：创建用户帐号【zhoumeng@zb.com】', '2016-02-03 21:57:58');
INSERT INTO `otc_operation_log` VALUES ('27', '1', '系统管理员：创建用户帐号【xiaowen@zb.com】', '2016-02-03 21:58:28');
INSERT INTO `otc_operation_log` VALUES ('28', '1', '系统管理员：创建用户帐号【lijie@zb.com】', '2016-02-03 21:59:13');
INSERT INTO `otc_operation_log` VALUES ('29', '16', '用户：张璞 部门：上海门店 , 修改登陆密码。', '2016-02-03 22:13:47');
INSERT INTO `otc_operation_log` VALUES ('30', '16', '用户：张璞 部门：上海门店 , 修改登陆密码。', '2016-02-03 22:14:10');
INSERT INTO `otc_operation_log` VALUES ('31', '1', '系统管理员：编辑用户帐号【】', '2016-02-25 17:55:08');
INSERT INTO `otc_operation_log` VALUES ('32', '1', '系统管理员：编辑用户帐号【】', '2016-02-25 17:55:09');
INSERT INTO `otc_operation_log` VALUES ('33', '1', '系统管理员：编辑用户帐号【】', '2016-02-25 17:55:16');
INSERT INTO `otc_operation_log` VALUES ('34', '1', '系统管理员：编辑用户帐号【】', '2016-02-26 08:40:48');
INSERT INTO `otc_operation_log` VALUES ('35', '1', '系统管理员：编辑用户帐号【】', '2016-02-26 11:27:13');
INSERT INTO `otc_operation_log` VALUES ('36', '1', '系统管理员：创建用户帐号【wuyunfeng@zb.com】', '2016-03-31 10:00:07');
INSERT INTO `otc_operation_log` VALUES ('37', '1', '系统管理员：创建用户帐号【qianshushu@zb.com】', '2016-03-31 10:02:23');
INSERT INTO `otc_operation_log` VALUES ('38', '1', '系统管理员：创建用户帐号【dingjingwei@zb.com】', '2016-03-31 10:05:53');
INSERT INTO `otc_operation_log` VALUES ('39', '1', '系统管理员：编辑用户帐号【】', '2016-03-31 10:08:41');

-- ----------------------------
-- Table structure for otc_organization
-- ----------------------------
DROP TABLE IF EXISTS `otc_organization`;
CREATE TABLE `otc_organization` (
  `organization_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `organization_name` varchar(255) NOT NULL DEFAULT '' COMMENT '机构简称',
  `organization_full_name` varchar(255) NOT NULL DEFAULT '' COMMENT '机构全称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:启用 2：禁用 3:注销',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`organization_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='机构表';

-- ----------------------------
-- Records of otc_organization
-- ----------------------------
INSERT INTO `otc_organization` VALUES ('1', '资邦财富', '资邦财富投资管理有限公司', '1', '2015-12-25 18:05:08');
INSERT INTO `otc_organization` VALUES ('2', '3434', '3434', '2', '2016-02-02 09:28:57');
INSERT INTO `otc_organization` VALUES ('3', '资邦财盈', '资邦财盈资产管理有限公司', '1', '2016-02-03 21:28:50');

-- ----------------------------
-- Table structure for otc_position
-- ----------------------------
DROP TABLE IF EXISTS `otc_position`;
CREATE TABLE `otc_position` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级ID',
  `organization_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '机构ID 默认1 资邦财富',
  `department_id` int(10) NOT NULL COMMENT '部门id',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '职位名称',
  `description` varchar(128) NOT NULL DEFAULT '' COMMENT '职位描述',
  `if_leader` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 普通职员 1 部门leader',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1有效 2无效 3注销',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='职位表';

-- ----------------------------
-- Records of otc_position
-- ----------------------------
INSERT INTO `otc_position` VALUES ('1', '2', '1', '1', '开发者', '开发者', '0', '1', '0000-00-00 00:00:00');
INSERT INTO `otc_position` VALUES ('2', '0', '1', '1', '开发经理', '开发经理', '1', '1', '0000-00-00 00:00:00');
INSERT INTO `otc_position` VALUES ('3', '2', '1', '1', '前端开发', '前端开发', '0', '1', '0000-00-00 00:00:00');
INSERT INTO `otc_position` VALUES ('4', '1', '1', '1', 'UI设计师1', '效果图设计', '0', '1', '2015-12-30 20:12:14');
INSERT INTO `otc_position` VALUES ('5', '2', '1', '1', 'UI设计师', '效果图设计', '0', '1', '0000-00-00 00:00:00');
INSERT INTO `otc_position` VALUES ('6', '0', '1', '2', '产品专员', '产品专员', '0', '1', '0000-00-00 00:00:00');
INSERT INTO `otc_position` VALUES ('7', '0', '1', '2', '产品总监', '产品总监', '1', '1', '0000-00-00 00:00:00');
INSERT INTO `otc_position` VALUES ('8', '0', '3', '12', '销售', '', '0', '1', '2016-02-03 21:36:52');
INSERT INTO `otc_position` VALUES ('9', '0', '3', '12', '温州门店经理', '', '1', '1', '2016-02-03 21:43:48');
INSERT INTO `otc_position` VALUES ('10', '0', '3', '11', '销售', '', '0', '1', '2016-02-03 21:39:44');
INSERT INTO `otc_position` VALUES ('11', '0', '3', '10', '销售', '', '0', '1', '2016-02-03 21:39:56');
INSERT INTO `otc_position` VALUES ('12', '0', '3', '11', '广东门店经理', '', '1', '1', '2016-02-03 21:43:33');
INSERT INTO `otc_position` VALUES ('13', '0', '3', '10', '上海门店经理', '', '1', '1', '2016-02-03 21:43:23');
INSERT INTO `otc_position` VALUES ('14', '0', '3', '15', '销售总监', '', '1', '1', '2016-02-03 21:49:15');
INSERT INTO `otc_position` VALUES ('15', '0', '3', '16', '财务专员', '', '0', '1', '2016-03-31 09:58:20');
INSERT INTO `otc_position` VALUES ('16', '0', '3', '18', '风控专员', '', '0', '1', '2016-03-31 09:58:11');
INSERT INTO `otc_position` VALUES ('17', '0', '3', '17', '客服', '', '0', '1', '2016-03-31 09:58:38');

-- ----------------------------
-- Table structure for otc_public_message
-- ----------------------------
DROP TABLE IF EXISTS `otc_public_message`;
CREATE TABLE `otc_public_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发送人UID',
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `source` varchar(255) NOT NULL DEFAULT '' COMMENT '来源',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT ' 1 正常 2 无效 3 草稿 4撤销',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '发送时间',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `clock_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '定时发布时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='公共消息表';

-- ----------------------------
-- Records of otc_public_message
-- ----------------------------
INSERT INTO `otc_public_message` VALUES ('1', '1', '消息111', '消息111消息111消息111消息111消息111消息111消息111', '', '1', '2015-12-14 18:24:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `otc_public_message` VALUES ('2', '2', '消息222', '消息222消息222消息222', '', '1', '2015-12-14 18:24:47', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `otc_public_message` VALUES ('3', '1', '消息333', '消息33333333333', '', '1', '2015-12-14 18:50:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for otc_public_message_log
-- ----------------------------
DROP TABLE IF EXISTS `otc_public_message_log`;
CREATE TABLE `otc_public_message_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公共消息ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作消息的用户ID',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '操作类型 1: 伪删除 2:真删除',
  `handle_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='公共消息操作记录表';

-- ----------------------------
-- Records of otc_public_message_log
-- ----------------------------
INSERT INTO `otc_public_message_log` VALUES ('1', '1', '1', '1', '2015-12-14 18:25:04');
INSERT INTO `otc_public_message_log` VALUES ('2', '2', '1', '1', '2015-12-14 18:29:21');
INSERT INTO `otc_public_message_log` VALUES ('3', '3', '1', '1', '2016-02-03 19:42:52');
INSERT INTO `otc_public_message_log` VALUES ('4', '3', '16', '1', '2016-02-03 22:15:16');
INSERT INTO `otc_public_message_log` VALUES ('5', '3', '22', '1', '2016-02-03 22:43:59');
INSERT INTO `otc_public_message_log` VALUES ('6', '3', '14', '1', '2016-02-03 23:00:24');
INSERT INTO `otc_public_message_log` VALUES ('7', '2', '14', '1', '2016-02-03 23:00:26');
INSERT INTO `otc_public_message_log` VALUES ('8', '2', '15', '1', '2016-02-03 23:39:18');
INSERT INTO `otc_public_message_log` VALUES ('9', '3', '15', '1', '2016-02-03 23:39:21');

-- ----------------------------
-- Table structure for otc_rj_dbf
-- ----------------------------
DROP TABLE IF EXISTS `otc_rj_dbf`;
CREATE TABLE `otc_rj_dbf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cf_ivs_id` int(11) NOT NULL DEFAULT '0' COMMENT '交易记录ID',
  `cf_ivs_redemption_id` int(11) DEFAULT '0' COMMENT '赎回投资ID',
  `cf_ivs_right_id` int(11) NOT NULL DEFAULT '0' COMMENT '确权记录表ID',
  `rj_file` varchar(255) NOT NULL DEFAULT '' COMMENT '入金文件地址',
  `file_no` int(11) NOT NULL DEFAULT '0' COMMENT '当日文件序号',
  `validflag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '回收状态',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1生成 2发送 3OTC确认',
  `createdate` date NOT NULL DEFAULT '0000-00-00' COMMENT '创建日期',
  `createtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `RJCYRM` varchar(32) DEFAULT '',
  `RJJSZH` varchar(16) DEFAULT '',
  `RJJYZH` varchar(16) DEFAULT '',
  `RJSQRQ` varchar(8) DEFAULT '',
  `RJSQDH` varchar(32) DEFAULT '',
  `RJRJFS` varchar(32) DEFAULT '',
  `RJFSJE` decimal(18,2) DEFAULT '0.00',
  `RJGHDH` varchar(32) DEFAULT '',
  `RJBYBZ` varchar(10) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cf_ivs_id` (`cf_ivs_id`) USING BTREE,
  KEY `cf_ivs_right_id` (`cf_ivs_right_id`) USING BTREE,
  KEY `file_no` (`file_no`) USING BTREE,
  KEY `validflag` (`validflag`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `createdate` (`createdate`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=442 DEFAULT CHARSET=utf8 COMMENT='过户文件';

-- ----------------------------
-- Records of otc_rj_dbf
-- ----------------------------

-- ----------------------------
-- Table structure for otc_rjhb_dbf
-- ----------------------------
DROP TABLE IF EXISTS `otc_rjhb_dbf`;
CREATE TABLE `otc_rjhb_dbf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cf_ivs_id` int(11) NOT NULL DEFAULT '0' COMMENT '交易记录ID',
  `cf_ivs_redemption_id` int(11) DEFAULT '0' COMMENT '赎回投资ID',
  `cf_ivs_right_id` int(11) NOT NULL DEFAULT '0' COMMENT '确权记录表ID',
  `rjhb_file` varchar(255) NOT NULL DEFAULT '' COMMENT '入金回报文件地址',
  `otc_file_id` int(11) NOT NULL DEFAULT '0' COMMENT '当日文件序号',
  `validflag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '回收状态',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1生成 2发送 3OTC确认',
  `createdate` date NOT NULL DEFAULT '0000-00-00' COMMENT '创建日期',
  `createtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `TADM` varchar(8) DEFAULT NULL,
  `RJHBRQ` varchar(8) DEFAULT NULL,
  `RJHBDH` varchar(32) DEFAULT NULL,
  `RJHBCYRM` varchar(32) DEFAULT NULL,
  `RJHBJSZH` varchar(16) DEFAULT NULL,
  `RJHBJYZH` varchar(16) DEFAULT NULL,
  `RJHBSQRQ` varchar(8) DEFAULT NULL,
  `RJHBSQDH` varchar(32) DEFAULT NULL,
  `RJHBRJFS` varchar(32) DEFAULT NULL,
  `RJHBFSJE` decimal(18,2) DEFAULT NULL,
  `RJHBGHDH` varchar(32) DEFAULT NULL,
  `RJHBFHDM` varchar(4) DEFAULT NULL,
  `RJHBBYBZ` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`) USING BTREE,
  KEY `validflag` (`validflag`) USING BTREE,
  KEY `otc_file_id` (`otc_file_id`) USING BTREE,
  KEY `rjhb_file` (`rjhb_file`) USING BTREE,
  KEY `cf_ivs_right_id` (`cf_ivs_right_id`) USING BTREE,
  KEY `cf_ivs_id` (`cf_ivs_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='入金回报文件';

-- ----------------------------
-- Records of otc_rjhb_dbf
-- ----------------------------

-- ----------------------------
-- Table structure for otc_system_setting
-- ----------------------------
DROP TABLE IF EXISTS `otc_system_setting`;
CREATE TABLE `otc_system_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '个性化操作类型 1:桌面设置 ',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '设置的内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1 有效 2 无效 ',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统自定义设置表';

-- ----------------------------
-- Records of otc_system_setting
-- ----------------------------

-- ----------------------------
-- Table structure for otc_token
-- ----------------------------
DROP TABLE IF EXISTS `otc_token`;
CREATE TABLE `otc_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accesstoken` varchar(512) DEFAULT '' COMMENT 'token',
  `expirestime` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '有效期',
  `errorcode` int(11) DEFAULT '0' COMMENT '错误编码',
  `errormsg` varchar(256) DEFAULT '' COMMENT '错误信息',
  PRIMARY KEY (`id`),
  KEY `expirestime` (`expirestime`) USING BTREE,
  KEY `errorcode` (`errorcode`) USING BTREE,
  FULLTEXT KEY `accesstoken` (`accesstoken`)
) ENGINE=InnoDB AUTO_INCREMENT=905 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of otc_token
-- ----------------------------
INSERT INTO `otc_token` VALUES ('887', '4F95ED3F-D084-4041-B20F-73F9245EA4A7', '2016-03-04 23:10:55', '0', '正常交易(允许客户自行转让)');
INSERT INTO `otc_token` VALUES ('888', 'E25EA83D-B68B-4567-B8C2-A73EC7CE4D58', '2016-03-05 04:48:25', '0', '正常交易(允许客户自行转让)');
INSERT INTO `otc_token` VALUES ('889', '340386EB-EE3A-4BDC-84ED-EE2BA6175EE2', '2016-03-09 01:52:05', '0', '正常交易(允许客户自行转让)');
INSERT INTO `otc_token` VALUES ('890', '47A71BC7-1301-4B38-A127-2D888E807F22', '2016-03-09 20:25:17', '0', '正常交易(允许客户自行转让)');
INSERT INTO `otc_token` VALUES ('891', '8363E2F4-6033-4AC9-A6CC-4AA42A823D45', '2016-03-10 21:15:36', '0', '正常交易(允许客户自行转让)');
INSERT INTO `otc_token` VALUES ('892', '32E2D6E7-D032-4913-9C4F-C23908289130', '2016-03-17 21:52:25', '0', '正常交易(允许客户自行转让)');
INSERT INTO `otc_token` VALUES ('893', '6B648C26-4151-4203-A8F6-331597C574D5', '2016-03-17 22:35:10', '0', '正常交易(允许客户自行转让)');
INSERT INTO `otc_token` VALUES ('894', '2C887141-F650-4F5E-A052-424C04DA05A8', '2016-03-18 21:04:42', '0', '正常交易(允许客户自行转让)');
INSERT INTO `otc_token` VALUES ('895', '5BDB79FB-1C5B-4B0A-80B7-2D8778AC8496', '2016-03-22 01:44:46', '0', '正常交易(允许客户自行转让)');
INSERT INTO `otc_token` VALUES ('896', '7BCBBC29-5C45-4E54-A661-21BF89AB5A9B', '2016-03-23 01:28:19', '0', '正常交易(允许客户自行转让)');
INSERT INTO `otc_token` VALUES ('897', 'FEF196DE-6CCD-407D-82CB-93ACD09BF489', '2016-03-24 05:55:19', '0', '正常交易(允许客户自行转让)');
INSERT INTO `otc_token` VALUES ('898', '14998A3B-2448-4EF0-A27B-61A0BAF1EE5A', '2016-03-25 02:51:28', '0', '正常交易(允许客户自行转让)');
INSERT INTO `otc_token` VALUES ('899', '71D41E82-13E4-40DF-9C75-A4499991179C', '2016-03-26 05:31:21', '0', '正常交易(允许客户自行转让)');
INSERT INTO `otc_token` VALUES ('900', 'F2D17CDC-C55A-4393-803A-804FB9CAB389', '2016-03-29 03:38:32', '0', '正常交易(允许客户自行转让)');
INSERT INTO `otc_token` VALUES ('901', '93DC4BA8-49AB-408D-A4BD-FD59C0D831AC', '2016-03-29 22:03:12', '0', '正常交易(允许客户自行转让)');
INSERT INTO `otc_token` VALUES ('902', '93833249-35EB-4C92-AC65-0ED81D0694B8', '2016-03-31 05:26:11', '0', '正常交易(允许客户自行转让)');
INSERT INTO `otc_token` VALUES ('903', '', '1970-01-01 08:00:00', '1003', 'OrgCode与目前使用IP不匹配');
INSERT INTO `otc_token` VALUES ('904', '', '1970-01-01 08:00:00', '1003', 'OrgCode与目前使用IP不匹配');

-- ----------------------------
-- Table structure for otc_user
-- ----------------------------
DROP TABLE IF EXISTS `otc_user`;
CREATE TABLE `otc_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(32) NOT NULL DEFAULT '' COMMENT '邮箱',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '密码',
  `realname` varchar(32) NOT NULL DEFAULT '' COMMENT '真实名称',
  `organization_id` mediumint(5) unsigned NOT NULL COMMENT '所属机构ID',
  `department_id` mediumint(5) NOT NULL COMMENT '部门id',
  `position_id` mediumint(5) NOT NULL COMMENT '职位id',
  `leader_id` mediumint(5) unsigned NOT NULL COMMENT '领导',
  `city` varchar(50) NOT NULL DEFAULT '' COMMENT '城市',
  `yingyequ` varchar(50) NOT NULL DEFAULT '' COMMENT '营业区',
  `yewubu` varchar(50) NOT NULL DEFAULT '' COMMENT '业务部',
  `shequmendian` varchar(50) NOT NULL DEFAULT '' COMMENT '社区门店',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '3' COMMENT '1:启用,2:禁用,3:待审核,4:注销',
  `check_remark` text COMMENT '审核不通过的备注',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `register_mode` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '注册方式 1：前台注册 2：后台创建',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`) USING BTREE,
  KEY `leader_id` (`leader_id`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `organization_id` (`organization_id`) USING BTREE,
  KEY `department_id` (`department_id`) USING BTREE,
  KEY `add_time` (`add_time`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of otc_user
-- ----------------------------
INSERT INTO `otc_user` VALUES ('1', 'zb@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '系统管理员', '1', '1', '2', '0', '账号城市1', '账号营业区1', '账号业务部1', '账号门店1', '1', '', '2015-12-04 15:41:53', '2016-02-26 11:27:13', '1');
INSERT INTO `otc_user` VALUES ('2', 'ywjl@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '业务经理', '1', '1', '1', '0', '', '', '', '', '1', '', '2015-12-04 15:41:53', '2016-01-12 15:24:04', '1');
INSERT INTO `otc_user` VALUES ('3', 'ywy@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '业务员', '1', '1', '2', '1', '', '', '', '', '1', '', '2015-12-04 15:41:53', '2016-01-12 15:24:04', '1');
INSERT INTO `otc_user` VALUES ('4', 'zqgl@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '债权管理人', '1', '1', '1', '0', '', '', '', '', '1', '', '2015-12-04 15:41:53', '2016-01-12 15:24:04', '1');
INSERT INTO `otc_user` VALUES ('5', 'zqll@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '债权录入人', '1', '1', '1', '0', '', '', '', '', '1', '', '2015-12-04 15:41:53', '2016-01-12 15:24:04', '1');
INSERT INTO `otc_user` VALUES ('6', 'zqsh@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '债权审核人', '1', '1', '1', '0', '', '', '', '', '1', '', '2015-12-04 15:41:53', '2016-01-12 15:24:04', '1');
INSERT INTO `otc_user` VALUES ('7', 'zqfb@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '债权发布人', '1', '1', '1', '0', '', '', '', '', '1', '', '2015-12-04 15:41:53', '2016-01-12 15:24:04', '1');
INSERT INTO `otc_user` VALUES ('8', 'cpgl@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '投资产品管理员', '1', '1', '1', '0', '', '', '', '', '1', '', '2015-12-04 15:41:53', '2016-01-12 15:24:04', '1');
INSERT INTO `otc_user` VALUES ('9', 'cpll@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '投资产品录入人', '1', '1', '1', '0', '', '', '', '', '1', '', '2015-12-04 15:41:53', '2016-01-12 15:24:04', '1');
INSERT INTO `otc_user` VALUES ('10', 'cpsh@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '投资产品审核人', '1', '1', '1', '0', '', '', '', '', '1', '', '2015-12-04 15:41:53', '2016-01-12 15:24:04', '1');
INSERT INTO `otc_user` VALUES ('11', 'cpfb@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '投资产品发布人', '1', '1', '1', '0', '', '', '', '', '1', '', '2015-12-04 15:41:53', '2016-01-12 15:24:04', '1');
INSERT INTO `otc_user` VALUES ('12', 'cpll2@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '投资产品录入人2', '1', '1', '1', '0', '', '', '', '', '1', '', '2015-12-04 15:41:53', '2016-01-12 15:24:04', '1');
INSERT INTO `otc_user` VALUES ('13', 'zqll2@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '债权录入人2', '1', '1', '1', '0', '', '', '', '', '1', '', '2015-12-04 15:41:53', '2016-01-12 15:24:04', '1');
INSERT INTO `otc_user` VALUES ('14', 'xieyuling@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '谢玉玲', '3', '15', '14', '14', '', '', '', '', '1', null, '2016-02-03 21:51:49', '0000-00-00 00:00:00', '2');
INSERT INTO `otc_user` VALUES ('15', 'chenbo@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '陈波', '3', '10', '11', '13', '', '', '', '', '1', null, '2016-02-03 21:52:46', '0000-00-00 00:00:00', '2');
INSERT INTO `otc_user` VALUES ('16', 'zhangpu@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '张璞', '3', '10', '13', '14', '', '', '', '', '1', null, '2016-02-03 21:53:19', '2016-02-03 22:14:10', '2');
INSERT INTO `otc_user` VALUES ('17', 'xianglizhi@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '向荔枝', '3', '13', '15', '14', '', '', '', '', '1', null, '2016-02-03 21:54:36', '2016-02-03 22:09:11', '2');
INSERT INTO `otc_user` VALUES ('18', 'wuyuhai@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '吴玉海', '3', '13', '16', '14', '', '', '', '', '1', null, '2016-02-03 21:55:00', '2016-02-03 22:07:21', '2');
INSERT INTO `otc_user` VALUES ('19', 'miaoxiaofeng@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '缪小峰', '3', '13', '15', '14', '', '', '', '', '1', null, '2016-02-03 21:56:25', '2016-02-03 22:06:17', '2');
INSERT INTO `otc_user` VALUES ('20', 'yuegang@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '岳刚', '3', '12', '8', '9', '', '', '', '', '1', null, '2016-02-03 21:57:17', '2016-02-03 22:08:40', '2');
INSERT INTO `otc_user` VALUES ('21', 'zhoumeng@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '周蒙', '3', '12', '9', '14', '', '', '', '', '1', null, '2016-02-03 21:57:58', '2016-02-03 22:08:11', '2');
INSERT INTO `otc_user` VALUES ('22', 'xiaowen@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '肖文', '3', '11', '10', '12', '', '', '', '', '1', null, '2016-02-03 21:58:28', '2016-02-03 22:07:50', '2');
INSERT INTO `otc_user` VALUES ('23', 'lijie@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '李杰', '3', '11', '12', '14', '', '', '', '', '1', null, '2016-02-03 21:59:13', '0000-00-00 00:00:00', '2');
INSERT INTO `otc_user` VALUES ('24', 'clh@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '陈琳辉', '3', '15', '14', '9', '1', '2', '3', '4', '1', null, '2016-02-17 19:26:00', '2016-02-25 17:55:16', '2');
INSERT INTO `otc_user` VALUES ('25', 'wuyunfeng@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '吴云丰', '3', '16', '15', '0', '', '', '', '', '1', null, '2016-03-31 10:00:07', '2016-03-31 10:08:41', '2');
INSERT INTO `otc_user` VALUES ('26', 'qianshushu@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '钱姝曙', '3', '17', '17', '0', '上海', '陆家嘴世纪金融门店', '上海业务部', '上海社区', '1', null, '2016-03-31 10:02:23', '0000-00-00 00:00:00', '2');
INSERT INTO `otc_user` VALUES ('27', 'dingjingwei@zb.com', 'e10adc3949ba59abbe56e057f20f883e', '丁经纬', '3', '18', '16', '0', '', '', '', '', '1', null, '2016-03-31 10:05:53', '2016-03-31 10:06:19', '2');

-- ----------------------------
-- Table structure for otc_user_message
-- ----------------------------
DROP TABLE IF EXISTS `otc_user_message`;
CREATE TABLE `otc_user_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `title` varchar(255) NOT NULL COMMENT '消息标题',
  `content` text NOT NULL COMMENT '内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT ' 1 有效 2 无效',
  `is_view` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1 未查看 2已查看',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `handle_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='用户消息表';

-- ----------------------------
-- Records of otc_user_message
-- ----------------------------
INSERT INTO `otc_user_message` VALUES ('1', '1', '用户申请通知', '用户申请通知，请您尽快审核', '1', '1', '2015-12-14 20:55:24', '0000-00-00 00:00:00');
INSERT INTO `otc_user_message` VALUES ('2', '1', '密码修改成功', '亲爱的用户，您好！你的密码已经修改为:654321, 请您牢记新密码。', '1', '1', '2016-01-19 10:23:13', '0000-00-00 00:00:00');
INSERT INTO `otc_user_message` VALUES ('3', '1', '密码修改成功', '亲爱的用户，您好！你的密码已经修改为:654321, 请您牢记新密码。', '1', '1', '2016-01-19 10:47:09', '0000-00-00 00:00:00');
INSERT INTO `otc_user_message` VALUES ('4', '1', '密码修改成功', '亲爱的用户，您好！你的密码已经修改为:654321, 请您牢记新密码。', '1', '1', '2016-01-19 10:47:11', '0000-00-00 00:00:00');
INSERT INTO `otc_user_message` VALUES ('5', '1', '密码修改成功', '亲爱的用户，您好！你的密码已经修改为:654321, 请您牢记新密码。', '1', '1', '2016-01-19 10:47:12', '0000-00-00 00:00:00');
INSERT INTO `otc_user_message` VALUES ('6', '1', '密码修改成功', '亲爱的用户，您好！你的密码已经修改为:654321, 请您牢记新密码。', '1', '1', '2016-01-19 10:48:15', '0000-00-00 00:00:00');
INSERT INTO `otc_user_message` VALUES ('7', '1', '密码修改成功', '亲爱的用户，您好！你的密码已经修改为:654321, 请您牢记新密码。', '1', '1', '2016-01-19 10:48:53', '0000-00-00 00:00:00');
INSERT INTO `otc_user_message` VALUES ('8', '1', '密码修改成功', '亲爱的用户，您好！你的密码已经修改为:654321, 请您牢记新密码。', '1', '1', '2016-01-19 10:50:35', '0000-00-00 00:00:00');
INSERT INTO `otc_user_message` VALUES ('9', '1', '密码修改成功', '亲爱的用户，您好！你的密码已经修改为:654321, 请您牢记新密码。', '1', '2', '2016-01-19 10:52:40', '2016-02-03 20:14:16');
INSERT INTO `otc_user_message` VALUES ('10', '1', '密码修改成功', '亲爱的用户，您好！你的密码已经修改为:654321, 请您牢记新密码。', '1', '2', '2016-01-19 10:52:42', '2016-02-04 00:39:20');
INSERT INTO `otc_user_message` VALUES ('11', '1', '密码修改成功', '亲爱的用户，您好！你的密码已经修改为:654321, 请您牢记新密码。', '1', '2', '2016-01-19 10:52:42', '2016-02-03 19:53:30');
INSERT INTO `otc_user_message` VALUES ('12', '1', '密码修改成功', '亲爱的用户，您好！你的密码已经修改为:654321, 请您牢记新密码。', '1', '2', '2016-01-19 10:52:43', '2016-02-03 20:37:13');
INSERT INTO `otc_user_message` VALUES ('13', '1', '密码修改成功', '亲爱的用户，您好！你的密码已经修改为:123456, 请您牢记新密码。', '1', '2', '2016-01-19 11:11:02', '2016-02-04 00:37:29');
INSERT INTO `otc_user_message` VALUES ('14', '16', '密码修改成功', '亲爱的用户，您好！你的密码已经修改为:1234567, 请您牢记新密码。', '1', '2', '2016-02-03 22:13:47', '2016-02-03 22:15:22');
INSERT INTO `otc_user_message` VALUES ('15', '16', '密码修改成功', '亲爱的用户，您好！你的密码已经修改为:123456, 请您牢记新密码。', '1', '2', '2016-02-03 22:14:10', '2016-02-03 23:46:29');
