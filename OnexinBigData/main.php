<?php
require '../../../zb_system/function/c_system_base.php';

require '../../../zb_system/function/c_system_admin.php';

$zbp->Load();

$action = 'root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}

if (!$zbp->CheckPlugin('OnexinBigData')) {$zbp->ShowError(48);die();}

$blogtitle = '①大数据量采集';

if (count($_POST) > 0) {
	//
}

    //Redirect('./index.php');

require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';

// 配置页面
	
?>
<div id="divMain">
<?php

	//include_once __DIR__.'/index.inc.php';
	include_once __DIR__.'/load.other.php';

//----------------CHECK ADMIN--------------------------------------
    
$options = bigdata_getcache( 'onexin_bigdata_options' );

if ($_SESSION['obd'] != '1') {
    $_GET['op'] = 'faq';
}

//----------------FUNCTION--------------------------------

$translations = bigdata_getcache('onexin-bigdata-zh_CN');

//if(!function_exists('__')) {
function __($string = "", $id = ""){
	global $translations;
	return isset($translations[$string]) ? $translations[$string] : $string;	
}
//}

//----------------ACTION----------------------------------

	include_once __DIR__.'/onexin_bigdata.inc.php';

?>  
</div>

<?php
require $blogpath . 'zb_system/admin/admin_footer.php';

RunTime();
?>