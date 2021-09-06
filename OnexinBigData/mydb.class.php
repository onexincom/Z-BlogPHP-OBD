<?php

/**
 * ONEXIN BIG DATA For Other 5.5+
 * ============================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * @package    onexin_bigdata
 * @module     other
 * @date       2018-01-18
 * @author     King
 * @copyright  Copyright (c) 2018 Onexin Platform Inc. (http://www.onexin.com)
 */

/*
//--------------Tall us what you think!----------------------------------
*/

if (!defined('OBD_CONTENT')) {
    die('Access Denied');
}

class mydb
{


    var $link = null;
    var $settings = array();
    var $queryCount = 0;
    var $queryTime = '';
    var $queryLog = array();
    var $error_message = array();
    var $version = '';

    function __construct($dbhost, $dbuser, $dbpw, $dbname = '', $pconnect = 0, $quiet = 0)
    {
        global $dbcharset;
        $this->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect, $quiet);
    }

    function connect($dbhost, $dbuser, $dbpw, $dbname = '', $pconnect = 0, $quiet = 0)
    {
        global $dbcharset;
        if (!$this->link = mysqli_connect('p:' . $dbhost, $dbuser, $dbpw, $dbname)) {
            if (!$quiet) {
                $this->halt("Can't Connect MySQL Server($dbhost)!");
            }
            return false;
        }

        if ($this->version() > '4.1') {
            if ($dbcharset) {
                $this->link->set_charset($dbcharset);
            }

            if ($this->version() > '5.0.1') {
                $this->link->query("SET sql_mode=''");
            }
        }
    }

    function query($sql, $type = '')
    {
        global $table;
        if ($this->queryCount++ <= 99) {
            $this->queryLog[] = $sql;
        }

        $resultmode = $type == 'UNBUFFERED' ? MYSQLI_USE_RESULT : MYSQLI_STORE_RESULT;
        if (!($query = $this->link->query($sql, $resultmode)) && $type != 'SILENT') {
            $this->error_message[]['message'] = 'MySQL Query Error';
            $this->error_message[]['sql'] = str_replace($table, '[dbpre]', $sql);
            $this->error_message[]['error'] = $this->error();
            $this->error_message[]['errno'] = $this->errno();
            $this->halt();
        }

        return $query;
    }

    function insert_id()
    {
        return mysqli_insert_id($this->link);
    }

    function error()
    {
        return mysqli_error();
    }

    function errno()
    {
        return mysqli_errno();
    }

    function version()
    {
        return $this->link->server_info;
    }

    function escape($str)
    {
        return $this->link->escape_string($str);
    }

    function close()
    {
        return $this->link->close();
    }

    function halt($message = '', $sql = '')
    {
        if ($message) {
            echo "$message\n\n";
        } else {
            echo "<b>MySQL server error report:";
            print_r($this->error_message);
        }
        exit;
    }

    function fetch_array($query, $result_type = MYSQLI_ASSOC)
    {
        return $query ? $query->fetch_array($result_type) : null;
    }

    function fetch_row($query)
    {
        $query = $query ? $query->fetch_row() : null;
        return $query;
    }

    function getAll($sql)
    {
        $res = $this->query($sql);
        if ($res !== false) {
            $arr = array();
            while ($row = $this->fetch_array($res)) {
                $arr[] = $row;
            }
            return $arr;
        } else {
            return false;
        }
    }

    function getRow($sql, $limited = false)
    {
        if ($limited == true) {
            $sql = trim($sql . ' LIMIT 1');
        }

        $res = $this->query($sql);
        if ($res !== false) {
            return $this->fetch_array($res);
        } else {
            return false;
        }
    }

    function getCol($sql)
    {
        $res = $this->query($sql);
        if ($res !== false) {
            $arr = array();
            while ($row = $this->fetch_row($res)) {
                $arr[] = $row[0];
            }
            return $arr;
        } else {
            return false;
        }
    }

    function getOne($sql, $limited = false)
    {
        return reset($this->getCol($sql));
    }
}
