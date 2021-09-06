<?php

/**
 * ONEXIN BIG DATA For Other 5.5+
 * ============================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * @package    onexin_bigdata
 * @module     api
 * @date       2016-11-26
 * @author     King
 * @copyright  Copyright (c) 2016 Onexin Platform Inc. (http://www.onexin.com)
 */

/*
//--------------Tall us what you think!----------------------------------
*/

// DEBUG
//bigdata_output("300");

//if(!defined('OBD_CONTENT')) {
    include_once __DIR__ . '/load.other.php';
//}

//------------------------------------------------------------------------
//@header("Content-type: text/html; charset=utf-8");
//include_once OBD_CONTENT_DIR.'/onexin_bigdata.function.php';

        $settings = bigdata_getcache('onexin_bigdata_options');
$_OBD = array_merge((array)$_OBD, (array)$settings);
// for all
//$_POST = bigdata_stripslashes($_POST);

$_GET = bigdata_charset($_GET);
$_POST = bigdata_charset($_POST);
if (!empty($_POST['k'])) {
    $_POST['k'] = addslashes($_POST['k']);
}
if (!empty($_POST['import'])) {
    $_POST['import'] = addslashes($_POST['import']);
}

// CHECK TOKEN
//if($_OBD['istoken']) {
$k = trim($_GET['occhash']);
$t = trim($_GET['occtime']);
if ($k != md5(md5($_OBD['token']) . $t) || empty($_OBD['token']) || empty($t)) {
    $contentStr = empty($t) ? "Error signature" : "Invalid signature";
    bigdata_output("100", $contentStr);
}
//}

//-----------------------------URL------------------------------------------

// save url
if (empty($_POST['bigdata'])) {
    if (empty($_POST['urls'])) {
        $wheresql = "`status` = '0'";
        if (!empty($_GET['rids'])) {
            $rids = bigdata_implode(explode(',', $_GET['rids']));
            $wheresql .= " AND `resid` IN ($rids)";
        }
        $urls = DB::fetch_all("SELECT url,k,catid,i,resid FROM " . DB::table('plugin_onexin_bigdata') . " WHERE $wheresql ORDER BY bid ASC LIMIT 0,10");
        $urls = bigdata_charset($urls, true);
        if (!empty($urls)) {
            bigdata_output("200", $urls);
        } else {
            echo json_encode(array("status" => "400"));
        }
        exit;
    }
    $_POST['urls'] = json_decode($_POST['urls'], true);
    $_POST['urls'] = bigdata_charset($_POST['urls']);
    if (!is_array($_POST['urls'])) {
        bigdata_output("100", "Unknow json");
    }

    $_POST['ks'] = array_keys($_POST['urls']);
//json_decode($_POST['ks'], true);
    $_POST = bigdata_addslashes($_POST);
    $ids = bigdata_implode($_POST['ks']);
    $urls = DB::fetch_all("SELECT k FROM " . DB::table('plugin_onexin_bigdata') . " WHERE k IN ($ids)");
    foreach ($urls as $value) {
        unset($_POST['urls'][$value['k']]);
    }

    $timestamp = time();
    $catid = $_POST['catid'];
    $import = $_POST['import'];
    $urls = $inserts = array();
    foreach ($_POST['urls'] as $key => $val) {
        $catid = !empty($val['catid']) ? $val['catid'] : $_POST['catid'];
        if (!empty($val['url'])) {
            $urls[] = "('$val[name]', '$val[url]', '$val[k]', '$val[resid]', '$timestamp', '$catid', '$import')";
        }
    }

    if (!empty($urls)) {
        krsort($urls);
        DB::query("INSERT INTO " . DB::table('plugin_onexin_bigdata') . " (`name`, `url`, `k`, `resid`, `dateline`, `catid`, `i`) VALUES " . implode(',', $urls) . ";");
    }
    echo json_encode(array("status" => "300"));
    exit;
}

//-----------------------------POST------------------------------------------
// never post
if (!empty($_POST['k'])) {
    if (empty($_POST['title']) || empty($_POST['content'])) {
    //DB::update('plugin_onexin_bigdata', array('status' => 3), array('k' => $_POST['k']));
        DB::query("UPDATE " . DB::table('plugin_onexin_bigdata') . " SET status = '3' WHERE `k` = '$_POST[k]'");
        echo json_encode(array("status" => "500"));
        exit;
    }

        DB::query("UPDATE " . DB::table('plugin_onexin_bigdata') . " SET status = '2', `name` = '" . addslashes($_POST['title']) . "' WHERE `k` = '$_POST[k]'");
//DB::update('plugin_onexin_bigdata', array('status' => 2), array('k' => $_POST['k']));

    // check subject repeat
    //if($_OBD['check_subject']){
        // check url
        $count = DB::result_first("SELECT COUNT(*) FROM " . DB::table('plugin_onexin_bigdata') . " WHERE `name` = '" . addslashes($_POST['title']) . "'");
    if ($count > 1) {
        DB::query("UPDATE " . DB::table('plugin_onexin_bigdata') . " SET status = '3' WHERE `k` = '$_POST[k]'");
    //DB::update('plugin_onexin_bigdata', array('status' => 3), array('k' => $_POST['k']));
        echo json_encode(array("status" => "500"));
        exit;
    }
    //}

    // filter
    if ($_OBD['filter_title']) {
        $_POST['title'] = bigdata_filter($_POST['title'], $_OBD['filter_title']);
//$_POST['title'] = str_replace(explode('|', $_OBD['filter_title']), '', $_POST['title']);
    }
    if ($_OBD['filter_content']) {
        $_POST['content'] = bigdata_filter($_POST['content'], $_OBD['filter_content']);
//$_POST['content'] = str_replace(explode('|', $_OBD['filter_content']), '', $_POST['content']);
    }

    // fix title
    if ($_OBD['title_prefix']) {
        $_POST['title'] = bigdata_randone($_OBD['title_prefix']) . $_POST['title'];
    }
    if ($_OBD['title_suffix']) {
        $_POST['title'] = $_POST['title'] . bigdata_randone($_OBD['title_suffix']);
    }

    // cronpublishdate
}

// publish
if (!empty($_POST['import'])) {
    $yourself_file = OBD_CONTENT_DIR . '/soeasy/publish.' . $_POST['import'] . '.php';
    if (file_exists($yourself_file)) {
        include_once $yourself_file;
    }
}
exit;
