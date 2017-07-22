<?php

/**
 * mySQL db class 
 * @author David.Shaw <tudibao@163.com>
 * $Id: db_mysql.class.php 2687 2016-05-16 09:25:38Z david $
 * attention: Dont use "Nested Function" in HHVM
 */
class db_mysql {

    private $_db;
    private $_result;
    private $fetch_mode;

    function __construct($dsn) {
        #$_dsn = $this->parseDSN($dsn);
        $func = $dsn['persistent'] ? "mysql_pconnect" : "mysql_connect";
        $dsn['host'] = $dsn['port'] ? $dsn['host'] . ':' . $dsn['port'] : $dsn['host'];
        $this->_db = @$func($dsn['host'], $dsn['user'], $dsn['pass']);
        if (!$this->_db) {
            die("DB Connect Error!");
        }
        $this->selectDb($dsn['dbname']);
        $this->result('set names "' . $dsn['param']['charset'] . '"');
        $this->setFetchMode($dsn['param']['fetchmode']);
    }

    function connect($dsn) {
        #use __construct()
    }

    function selectDb($dbname) {
        mysql_select_db($dbname, $this->_db);
    }

    function getOne($sql) {
        $this->_result = $this->result($sql);
        if ($this->_result) {
            $row = mysql_fetch_row($this->_result);
            return $row[0];
        }
        return FALSE;
    }

    function getRow($sql) {
        $this->_result = $this->result($sql);
        return $this->_result ? mysql_fetch_array($this->_result, $this->fetch_mode) : FALSE;
    }

    function getAssoc($sql) {
        $result = array();
        $field_count = 0;
        $this->_result = $this->result($sql);
        if ($this->_result) {
            $row_count = $this->numRows();
            while ($row = mysql_fetch_array($this->_result, $this->fetch_mode)) {
                if (!$field_count) {
                    $field_count = count($row);
                }
                
                if ($field_count > 2) {
                    $key_v = array_shift($row);
                    $result[$key_v] = $row;
                }
                //
                else {
                    $key_v = array_values($row);
                    if ($field_count == 2) {
                        $result[$key_v[0]] = $key_v[1];
                    } elseif ($row_count > 1) {
                        $result[] = $key_v[0];
                    } else {
                        return $key_v[0];
                    }
                }
            }
            return $result;
        }
        return FALSE;
    }

    function getAll($sql) {
        $result = array();
        $this->_result = $this->result($sql);
        if ($this->_result) {
            while ($row = mysql_fetch_array($this->_result, $this->fetch_mode)) {
                $result[] = $row;
            }
            return $result;
        }
        return FALSE;
    }

    function result($sql) {
        $this->_result = mysql_query($sql, $this->_db);
        #if(!$this->_result){
        #    die("Query Error!");
        #}
        return $this->_result;
    }

    function setFetchMode($mode) {
        $this->fetch_mode = intval($mode);
    }

    function error() {
        return (($this->_db) ? mysql_error($this->_db) : mysql_error());
    }

    function errno() {
        return intval(($this->_db) ? mysql_errno($this->_db) : mysql_errno());
    }

    function close() {
        return mysql_close($this->_db);
    }

    function numRows() {
        $numRows = mysql_num_rows($this->_result);
        return $numRows;
    }

    function insertId() {
        return mysql_insert_id($this->_db);
    }

    function affectedRows() {
        return mysql_affected_rows($this->_db);
    }

}
