<?php

/**
 * ONEXIN BIG DATA For Other 6.0+
 * ============================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * @package    onexin_bigdata
 * @module     api
 * @date       2018-03-23
 * @author     King
 * @copyright  Copyright (c) 2018 Onexin Platform Inc. (http://www.onexin.com)
 */

/*
//--------------Tall us what you think!----------------------------------
*/

//----------------CRON--------------------------------

    $url = "http://we.onexin.com/apiocc.php?oid=" . intval($_GET['oid']) . "&_=" . time();

    $ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
$content = curl_exec($ch);
curl_close($ch);

    echo "";
//trim($content, 1);
    exit();
