<?php
/**
 * ONEXIN BIG DATA For Discuz!Q 1.0+
 * ============================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * @package    onexin_bigdata
 * @module	   onexin_bigdata
 * @date	   2016-11-26
 * @author	   King
 * @copyright  Copyright (c) 2016 Onexin Platform Inc. (http://www.onexin.com)
 */

/*
//--------------Tall us what you think!----------------------------------
*/
if(!defined('OBD_CONTENT')) {
	exit('Access Denied');
}

$_GET = bigdata_charset($_GET);
$_POST = bigdata_charset($_POST);

$timestamp = time();
$baseurl = '?page=onexin-bigdata.php';
$bid = !empty($_GET['bid']) ? intval($_GET['bid']) : 0;
$_GET['op'] = isset($_GET['op']) ? $_GET['op'] : "";

//-------------------------------------------------------------------------

	// check admin
	$user_id = '1';//get_current_user_id();
	if( $user_id != '1' ){
		$_GET['op'] = 'readme';		
	}

if($_GET['op'] == 'settings') {
	
	### Form Processing
	if(bigdata_submitcheck('optionssubmit')) {
		//check_admin_referer( 'onexin-bigdata_settings' );
		$options = array(
			  'isopen'             => '1'
			, 'isdelimiter'        => '1'
			, 'title_prefix'       => $_POST['title_prefix']
			, 'title_suffix'       => $_POST['title_suffix']
			, 'filter_title'       => $_POST['filter_title']
			, 'filter_content'	   => $_POST['filter_content']
			, 'worktime' 		   => '23|00|01|02|03|04|05|06|07'
			, 'ignore' 		       => '1'
			, 'perpv' 		       => '1'
		);
		
		if(isset($_POST['isopen'])) $options['isopen'] = (int)$_POST['isopen'];
//		if(isset($_POST['isdelimiter'])) $options['isdelimiter'] = (int)$_POST['isdelimiter'];
		if(isset($_POST['from_style2'])) $options['from_style2'] = $_POST['from_style2'];
		if(isset($_POST['portal_users'])) $options['portal_users'] = $_POST['portal_users'];
		if(isset($_POST['origviews'])) $options['origviews'] = $_POST['origviews'];
		if(isset($_POST['worktime'])) $options['worktime'] = $_POST['worktime'];
		
		if(isset($_POST['perpv'])) $options['perpv'] = (int)$_POST['perpv'];
		if(isset($_POST['oid']))   $options['oid'] = (int)$_POST['oid'];
		if(isset($_POST['token'])) $options['token'] = $_POST['token'];
		
		$update_views_queries = array();
		$update_views_text = array();
		$options = bigdata_charset($options, true);	
		bigdata_setcache( 'onexin_bigdata_options', $options );
		
		//echo '<div class="updated fade"><p>' . __( 'Updated' )  . '</p></div>';
	}else{
		$options = bigdata_getcache( 'onexin_bigdata_options' );
		$options = array_merge((array)$_OBD, (array)$options);
	}
	
	include bigdata_template('onexin_bigdata:settings');
	exit();	
		
}elseif($_GET['op'] == 'manage') {
	
	if(bigdata_submitcheck('managesubmit')){	
		// for all
		//$_POST = bigdata_stripslashes($_POST);
	
		$url = !empty($_POST['url']) ? addslashes($_POST['url']) : '';
		$name = !empty($_POST['name']) ? addslashes($_POST['name']) : '';
		$catid = !empty($_POST['catid']) ? addslashes($_POST['catid']) : 0;
		$i = !empty($_POST['i']) ? addslashes($_POST['i']) : '';
		$status = !empty($_POST['status']) ? intval($_POST['status']) : 0;
		
		$url = str_replace('&amp;', '&', $url);	
		
		// 检查bid是否存在
		if($bid > 0) {
			DB::query("UPDATE ".DB::table('plugin_onexin_bigdata')." SET name = '$name', url = '$url', catid = '$catid', i = '$i', status = '$status' WHERE bid='$bid'");			
		}else{
			$dateline = $timestamp;
			$k = md5($url);
			
			// <bookmark 添加书签
			$arr = explode("\n", trim($url));
			$data = array();
			foreach($arr as $val){
				$val = trim($val);
				if(preg_match("/^http/", $val)) {
					$v = explode('###', $val);
					$ks = md5($v[0]);
					$data[$ks]['name'] = addslashes($v[1]);
					$data[$ks]['url'] = addslashes($v[0]);
					$data[$ks]['k'] = $ks;
				}
			}
			
			$ids = bigdata_implode(array_keys($data));
			$query = DB::fetch_all("SELECT k FROM ".DB::table('plugin_onexin_bigdata')." WHERE k IN ($ids)");
			foreach($query as $value) {
				unset($data[$value['k']]);
			}
			
			$urls = array();	
			foreach($data as $key => $val){
				if(!empty($val['url'])) $urls[] = "('$val[name]', '$val[url]', '$val[k]', '$status', '$dateline', '$catid', '$i')";		
			}
			if(!empty($urls)) {
				DB::query("INSERT INTO ".DB::table('plugin_onexin_bigdata')." (`name`, `url`, `k`, `status`, `dateline`, `catid`, `i`) VALUES ".implode(',', $urls).";");
			}
			// bookmark>
			//print_r($ids);print_r($data);exit;
			
			//DB::query("INSERT INTO ".DB::table('plugin_onexin_bigdata')." (name, dateline, url, i, catid, status, k) VALUES ('$name', '$dateline', '$url', '$i', '$catid', '$status', '$k')");
		}
		
		bigdata_output("200");
	}else{
		$res = DB::fetch_first("SELECT * FROM ".DB::table('plugin_onexin_bigdata')." WHERE bid='$bid'");	
		$res = bigdata_charset($res, true);	
		$res = bigdata_htmlspecialchars($res);
		$res['url'] = str_replace('&amp;', '&', $res['url']);
		$res = array_merge(array('name'=>'','url'=>'','i'=>'','catid'=>'','status'=>'','cronpublishdate'=>''), (array)$res);
	}
	
	include bigdata_template('onexin_bigdata:manage');
	exit();	
    
}elseif($_GET['op'] == 'logout'){
    $_SESSION['obd'] = 0;    
    echo '<script>location.href=\'?op=login\'</script>';
    exit;
		
}elseif($_GET['op'] == 'readme') {
	
	include bigdata_template('onexin_bigdata:readme');
    
}elseif($_GET['op'] == 'delete') {
	
	// delete	
	DB::query("DELETE FROM ".DB::table('plugin_onexin_bigdata')." WHERE bid='$bid'");
	
	bigdata_output("200");
	exit();
		
}elseif($_GET['op'] == 'bigdata') {
	
	$bids = !empty($_POST['bidarray']) ? bigdata_implode($_POST['bidarray']) : "'0'";
		
	if(bigdata_submitcheck('bigdatasubmit')) {

		// deletes
		DB::query("DELETE FROM ".DB::table('plugin_onexin_bigdata')." WHERE bid IN ($bids)");
		
	} elseif(bigdata_submitcheck('bigdatasubmit3')) {
		
		DB::query("UPDATE ".DB::table('plugin_onexin_bigdata')." SET status = '3' WHERE bid IN ($bids)");
		
	} elseif(bigdata_submitcheck('bigdatasubmit0')) {
		
		DB::query("UPDATE ".DB::table('plugin_onexin_bigdata')." SET status = '0' WHERE bid IN ($bids)");
		
	}

	bigdata_output("200");
	exit();
	
}else{
	
	if($_GET['op'] != 'stats') {
		$_GET['status'] = ($_GET['status']!='') ? (int)$_GET['status'] : '0';
	}
		
	$daynum = !empty($_OBD['daynum'])?$_OBD['daynum']:365;
	$wheresql = '1=1 ';
		$starttime	= !empty($_GET['starttime']) ? strtotime($_GET['starttime']) : $timestamp-$daynum*24*3600;
		$endtime	= !empty($_GET['endtime']) ? strtotime($_GET['endtime']) : $timestamp;	
	$wheresql .= ($bid>0) ? " AND bid='$bid'" : '';
	$wheresql .= ($_GET['status']!='') ? " AND status = '$_GET[status]'" : '';	
	$wheresql .= (!empty($_GET['name'])) ? " AND (name like '%$_GET[name]%' OR url like '%$_GET[name]%' OR ip like '%$_GET[name]%')" : '';	
	$wheresql .= (!empty($_GET['resid'])) ? " AND resid = '$_GET[resid]'" : '';	
	$wheresql .= ($_GET['stats'] != '0') ? " AND dateline>='$starttime' AND dateline<'$endtime'" : "";

	// page
	$page = empty($_GET['paged'])?0:intval($_GET['paged']);
	if($page<1) $page=1;
	
	$perpage = empty($_GET['perpage'])?30:intval($_GET['perpage']);
	$start = ($page-1)*$perpage;
			
	//ckstart($start, $perpage);
	$list = array();
	$multi = "";
	$count = DB::result_first("SELECT COUNT(*) FROM ".DB::table('plugin_onexin_bigdata')." WHERE $wheresql");	
	if($count) {	
		$result = DB::fetch_all("SELECT * FROM ".DB::table('plugin_onexin_bigdata')." WHERE $wheresql ORDER BY bid DESC LIMIT $start, $perpage");
		foreach($result as $value) {
			$value['link'] = ($value['status']=='1') ? bigdata_iplink($value['ip']) : "";
			$list[] = $value;
		}
		$list = bigdata_charset($list, true);	
		$list = bigdata_htmlspecialchars($list);
		$multi = bigdata_multi($count, $perpage, $page, $baseurl."&op=stats"
			.(($_GET['op']=='stats') ? "&op=stats" : "")
			.(($_GET['name']) ? "&name=".urlencode($_GET['name']) : "")
			.(($_GET['status']) ? "&status=".intval($_GET['status']) : "")
			.(($bid>0) ? "&bid=$bid" : "")
			.(($starttime) ? "&starttime=".date('Y-m-d H:i', $starttime) : "")
			.(($endtime) ? "&endtime=".date('Y-m-d H:i', $endtime) : "")
			);
	
	}
		$_GET = bigdata_charset($_GET, true);	
			
	include bigdata_template('onexin_bigdata:stats');	
	$options = bigdata_getcache( 'onexin_bigdata_options' );
	$options = array_merge((array)$_OBD, (array)$options);
	include bigdata_template('onexin_bigdata:doing');
		
}

//------------------------------------------------------------------------------------------

function bigdata_multi($num, $perpage, $curpage, $mpurl) {
	global $_G;
	
	$totalpages = @ceil($num / $perpage);
		
	$mpurl .= strpos($mpurl, '?') !== FALSE ? '&amp;' : '?';
	
	$paginate_links = '<div class="pagination tablenav-pages"><ul>
<li><span class="displaying-num">'.$num.' items</span>
<li><span class="pagination-links"><a class="first-page disabled" title="Go to the first page" href="'.$mpurl.'paged=1">«</a>
<li><a class="prev-page disabled" title="Go to the previous page" href="'.$mpurl.'paged='.($curpage > 2 ? $curpage-1 : 1).'">‹</a>
<li><span class="paging-input"><input title="Current page" class="input-mini" type="text" name="paged" value="'.$curpage.'" size="2" onkeydown="if(event.keyCode==13) {window.location=\''.$mpurl.'paged=\'+this.value;}" /> of <span class="total-pages">'.$totalpages.'</span></span>
';
	if($curpage+1 <= $totalpages){
	$paginate_links .= ' <li><a class="next-page" title="Go to the next page" href="'.$mpurl.'paged='.($curpage+1).'">›</a>
<li><a class="last-page" title="Go to the last page" href="'.$mpurl.'paged='.$totalpages.'">»</a></span>';
	}
	$paginate_links .= '</ul></div><!--// end .pagination -->';
	
	return $paginate_links;
}

function bigdata_template($str){
	return OBD_CONTENT_DIR.'/tpl/'.str_replace('onexin_bigdata:', '', $str).'.tpl.php';
}

function bigdata_submitcheck($str){
	return isset($_REQUEST[$str]) ? true : false;
}

function bigdata_htmlspecialchars($string){
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = bigdata_htmlspecialchars($val);
		}
	}else{
		$string = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string);
		if(strpos($string, '&amp;#') !== false) {
			$string = preg_replace('/&amp;((#(\d{3,6}|x[a-fA-F0-9]{4}));)/', '&\\1', $string);
		}
	}
	return $string;
}