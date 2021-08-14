<?php
/**
 * ONEXIN BIG DATA For Other 1.4+
 * ============================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * @package    onexin_bigdata
 * @module	   zblog
 * @date	   2017-08-30
 * @author	   King
 * @copyright  Copyright (c) 2017 Onexin Platform Inc. (http://www.onexin.com)
 */
 
if(!defined('OBD_CONTENT')) {
	exit('Access Denied');
}

/*
//--------------Tall us what you think!----------------------------------
*/
//set_time_limit(60);
ignore_user_abort();

//-----------------------------VEST--------------------------------------------
$vest = addslashes(bigdata_randone($_OBD['portal_users']));
$member = DB::fetch_first("SELECT mem_ID,mem_Name FROM ".DB::table('member')." WHERE `mem_Name` = '$vest' LIMIT 1");
$userid = !empty($member['id']) ? $member['id'] : 1;
//$username = $vest;//$member['mem_Name'];

//-----------------------------FROM URL/SITENAME--------------------------------------------

	//if($_OBD['from_style2']){
		$_OBD['from_style2'] = str_replace(
			array('{occurl}', '{occsite}', '{occtitle}'), array($_POST['occurl'], $_POST['occsite'], $_POST['title']), 
				$_OBD['from_style2']);
		$_POST['content'] = str_replace('{OCC}', $_OBD['from_style2'], $_POST['content']);
	//}
	
//-----------------------------SUBMIT--------------------------------------------

		// video	
		$_POST['content'] = preg_replace("/(\s|　)*\[flash\](.*?)\[\/flash\]/", '<embed width="480" height="400" src="\\2" class="obd-video" allowFullScreen="true" quality="high" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>', $_POST['content']);	
		// <!--more-->
		$_POST['content'] = preg_replace("/\<hr\>$/", '', $_POST['content']);	
		//if(!$_OBD['isdelimiter'])
		$_POST['content'] = str_replace('<hr>', '#p#', $_POST['content']);
		
		// views
		$views = '1';
		if($_OBD['origviews']){
			if(preg_match("/^(\d+).*?(\d+)$/", $_OBD['origviews'], $match)){
				$origviews = rand($match[1], $match[2]);
				$views = intval($origviews);
			}
		}

//----------------------------------------------------------------------
$catid = explode('|', $_POST['catid']);
$_POST['type_id'] = intval($catid[0]);//cate_id
$_POST['parentid'] = 1;//parentid
$_POST['seo_description'] = _summary(stripslashes($_POST['content']));
$_POST['article_order'] = 255;//文章排序，数字越大越靠前
$_POST['focos'] = 1;// 普通资讯     头条资讯     焦点新闻     推荐资讯    

$action = 'insert';
/** save data */
if (in_array($action, array('insert'))) {

		$title          = htmlspecialchars(trim($_POST['title']));
		$type_id         = intval($_POST['type_id']);
		$userid       = intval($userid);
		$content        = addslashes(trim($_POST['content']));
		$description    = trim($_POST['seo_description']);
		$addtime        = time();

		$sql = "INSERT INTO ".DB::table('post')." (log_Title,log_CateID,log_AuthorID,log_Intro,log_Content,log_PostTime,log_ViewNums) VALUES ('$title','$type_id','$userid','$description','$content','$addtime','$views')";
		$res = $db->query($sql);
		$art_id = $db->insert_id();
        
		//_msgbox('文章编辑成功！');
}

	if($art_id) {
		DB::query("UPDATE ".DB::table('plugin_onexin_bigdata')." SET `status` = '1', `ip` = 'zblog|".$art_id."' WHERE `k` = '$_POST[k]'");
	}
	
	//print_r($art_id);exit;
				
bigdata_output("200", array("id"=>$art_id));
exit;

//-----------------------------End--------------------------------------------

function _msgbox($string, $num = "200"){
	echo $string;
	bigdata_output("200", $string);
	exit();
}

function _summary($message, $length = 200) {
	$message = str_replace('　', '', $message);
	$message = preg_replace(array("/\[flash\].*?\[\/flash\]/", "/\[attach\].*?\[\/attach\]/", "/\&[a-z]+\;/i", "/\<script.*?\<\/script\>/"), '', $message);
	$message = preg_replace("/\[.*?\]/", '', $message);
	$message = _cutstr(strip_tags($message), $length);
	return $message;
}

function _cutstr($string, $length, $dot = ' ...') {
	if(strlen($string) <= $length) {
		return $string;
	}

	$pre = chr(1);
	$end = chr(1);
	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), $string);

	$strcut = '';
	if(strtolower(CHARSET) == 'utf-8') {

		$n = $tn = $noc = 0;
		while($n < strlen($string)) {

			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t <= 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}

			if($noc >= $length) {
				break;
			}

		}
		if($noc > $length) {
			$n -= $tn;
		}

		$strcut = substr($string, 0, $n);

	} else {
		$_length = $length - 1;
		for($i = 0; $i < $length; $i++) {
			if(ord($string[$i]) <= 127) {
				$strcut .= $string[$i];
			} else if($i < $_length) {
				$strcut .= $string[$i].$string[++$i];
			}
		}
	}

	$strcut = str_replace(array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

	$pos = strrpos($strcut, chr(1));
	if($pos !== false) {
		$strcut = substr($strcut,0,$pos);
	}
	return $strcut.$dot;
}