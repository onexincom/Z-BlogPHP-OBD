<?php

#注册插件
RegisterPlugin("OnexinBigData", "ActivePlugin_OnexinBigData");

function ActivePlugin_OnexinBigData()
{

    Add_Filter_Plugin('Filter_Plugin_Admin_LeftMenu', 'OnexinBigData_AddLeftMenu');
    //Add_Filter_Plugin('Filter_Plugin_Admin_SettingMng_SubMenu', 'OnexinBigData_AddSettingMng_SubMenu');
}

function OnexinBigData_AddLeftMenu(&$m)
{
    global $zbp;
    $plugin = array();
    $plugin['id'] = 'OnexinBigData';
    $plugin['name'] = 'OBD大数据采集';
    if ($zbp->CheckPlugin($plugin['id'])) {
        $m[] = MakeLeftMenu('root', $plugin['name'], $zbp->host . 'zb_users/plugin/' . $plugin['id'] . '/main.php', 'nav_' . $plugin['id'], $plugin['id'], $zbp->host . "zb_system/image/admin/none.gif", "icon-clipboard-data");
    }
    //echo '<a href="' . $zbp->host . 'zb_users/plugin/OnexinBigData/main.php"><span class="m-left">①大数据量采集</span></a>';
}

function OnexinBigData_AddSettingMng_SubMenu()
{
    global $zbp;
    echo '<a href="' . $zbp->host . 'zb_users/plugin/OnexinBigData/main.php"><span class="m-left">OBD大数据采集</span></a>';
}

function InstallPlugin_OnexinBigData()
{
    global $zbp;

    $charset_collate = "DEFAULT CHARACTER SET " . ( !empty($zbp->option['ZC_MYSQL_CHARSET']) ? $zbp->option['ZC_MYSQL_CHARSET'] : "utf8");
    //$charset_collate .= " COLLATE ".( !empty($zbp->option['ZC_MYSQL_COLLATE']) ? $zbp->option['ZC_MYSQL_COLLATE'] : "utf8_general_ci");

    $my_sql = " CREATE TABLE IF NOT EXISTS `%s`(
			`bid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
			`name` varchar(255) DEFAULT NULL,
			`url` text NOT NULL,
			`k` varchar(32) NOT NULL DEFAULT '',
			`catid` varchar(20) NOT NULL DEFAULT '',
			`i` varchar(32) NOT NULL DEFAULT '',
			`resid` varchar(20) NOT NULL DEFAULT '',
			`dateline` int(10) unsigned NOT NULL DEFAULT '0',
			`cronpublishdate` int(10) unsigned NOT NULL DEFAULT '0',
			`ip` varchar(20) NOT NULL DEFAULT '',
			`status` tinyint(1) NOT NULL DEFAULT '0',
			PRIMARY KEY (`bid`)
		) $charset_collate;";

    $sql = sprintf($my_sql, $zbp->option['ZC_MYSQL_PRE'] . "plugin_onexin_bigdata");
    $zbp->db->Query($sql);
}

function UninstallPlugin_OnexinBigData()
{
    global $zbp;

    $table_name = $zbp->option['ZC_MYSQL_PRE'] . "plugin_onexin_bigdata";
    $sql = "DROP TABLE $table_name;";
    $zbp->db->Query($sql);
}
