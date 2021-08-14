<?php
/**
 * ONEXIN BIG DATA For Other 5.5+
 * ============================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * @package    onexin_bigdata
 * @module	   other
 * @date	   2018-01-18
 * @author	   King
 * @copyright  Copyright (c) 2018 Onexin Platform Inc. (http://www.onexin.com)
 */

/*
//--------------Tall us what you think!----------------------------------
*/
error_reporting(0);

//GZIP
//ob_end_clean();

/*function_exists('ob_gzhandler') ? ob_start('ob_gzhandler') : ob_start();
header('Pragma: no-cache');*/

//----------------Initialization---------------------------------

if(!defined('OBD_CONTENT')) {
	define('OBD_CONTENT',		TRUE);
	define('OBD_CONTENT_DIR',	__DIR__);
}
if(!defined('ZBP_PATH')) {
	define('OBD_QUOTES_GPC', function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc());
    //define('ROOT_PATH', '../../../');

	$dbinfo = include_once '../../../zb_users/c_option.php';	
    include_once OBD_CONTENT_DIR . '/mydb.class.php';
  
	$dbcharset = $dbinfo['ZC_MYSQL_CHARSET'];
	$table = $dbinfo['ZC_MYSQL_PRE'];
	$db = new mydb($dbinfo['ZC_MYSQL_SERVER'], $dbinfo['ZC_MYSQL_USERNAME'], $dbinfo['ZC_MYSQL_PASSWORD'], $dbinfo['ZC_MYSQL_NAME'], '1');
	unset($dbinfo);    
}else{
	$_SESSION['obd'] = 1;
	define('OBD_QUOTES_GPC', function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc());
    //define('ROOT_PATH', '../../../');

	$dbinfo = $GLOBALS['option'];
    include_once OBD_CONTENT_DIR . '/mydb.class.php';
  
	$dbcharset = $dbinfo['ZC_MYSQL_CHARSET'];
	$table = $dbinfo['ZC_MYSQL_PRE'];
	$db = new mydb($dbinfo['ZC_MYSQL_SERVER'], $dbinfo['ZC_MYSQL_USERNAME'], $dbinfo['ZC_MYSQL_PASSWORD'], $dbinfo['ZC_MYSQL_NAME'], '1');
	unset($dbinfo);	
}

if(!defined('CHARSET')) {
	define('CHARSET',			'utf-8');
}
include_once OBD_CONTENT_DIR.'/load.config.php';
include_once OBD_CONTENT_DIR.'/onexin_bigdata.function.php';

		if(OBD_QUOTES_GPC) {
			$_GET = bigdata_stripslashes($_GET);
			$_POST = bigdata_stripslashes($_POST);
			$_COOKIE = bigdata_stripslashes($_COOKIE);
		}

//----------------FUNCTION FOR YOUR PHP---------------------------------

function bigdata_setcache($key, $val, $expire = 300) {
	$dir = "./data/";
	$file = $dir . $key . ".cache.php";
	if(!is_dir($dir)) {
		@mkdir($dir);
	}
	//$data = array("expire" => time() + $expire, "data" => $val);
	
	$code = "<?php\n\rif(!defined('OBD_CONTENT')) { exit('Access Denied'); }\n\r//". date('Y-m-d H:i:s')." Created\n\r\$_OBD_SET = ". var_export($val, true). ";";
	file_put_contents($file, $code);			
}

function bigdata_getcache($key) {	
	$file = "./data/" . $key . ".cache.php";
	if(file_exists($file)){
		$_OBD_SET = array();
		include $file;
		return $_OBD_SET;
	}else{
		return array();
	}
}

//if(!function_exists('bigdata_iplink')) {
function bigdata_iplink($str){
	$s = explode('|', $str);
		
	$url = '';
	switch ($s[0]) {
		case 'zblog':
			// cms|123  
			return array("../?id=".$s[1], 
						"../zb_system/admin/edit.php?act=ArticleEdt&id=".$s[1]);
			break;
		default:
			// other|123		
			return '';
			break;
	}	
	
	return $url;	
}
//}

//----------------DATEBASE FOR YOUR PHP---------------------------------
 
//if(!class_exists('DB')) {
class DB {	

	public static function table($name) {
		global $db, $table;
		return $table.$name;
	}

	public static function query($query) {
		global $db;
		return $db->query($query);
	}
		
	public static function fetch_all($sql){
		global $db;
		return $db->getAll($sql);
	}
	
	public static function fetch_first($sql){
		global $db;
		return $db->getRow($sql);
	}
	
	public static function result_first($sql){
		global $db;
		return $db->getOne($sql);
	}

	public static function escape($str) {
		global $db;
		return $db->escape($str);		
	}
	
}
//}
