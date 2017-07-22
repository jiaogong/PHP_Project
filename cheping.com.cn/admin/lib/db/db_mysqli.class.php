<?php

/**
 * mySQLi db class 
 * Require PHP 5.0+
 * 
 * @author David.Shaw <tudibao@163.com>
 * $Id: db_mysqli.class.php 2687 2016-05-16 09:25:38Z david $
 * attention: Dont use "Nested Function" in HHVM
 */
class db_mysqli {

    private $_db;
    private $_result;
    private $fetch_mode;

    function __construct($dsn) {
        #$_dsn = $this->parseDSN($dsn);
        #$func = $dsn['persistent'] ? "mysql_pconnect" : "mysql_connect";
        $dsn['port'] = $dsn['port'] ? $dsn['port'] : '3306';
        $this->_db = new mysqli($dsn['host'], $dsn['user'], $dsn['pass'], $dsn['dbname'], $dsn['port']);
        #trigger_error("Connect Error", E_USER_ERROR);
        if ($this->errno()) {
            die("DB Connect Error!" . $this->error());
        }
        $this->result('set names "' . $dsn['param']['charset'] . '"');
        #$this->setFetchMode($dsn['param']['fetchmode']);
    }

    function getOne($sql) {
        $this->_result = $this->result($sql);
        if ($this->_result) {
            $row = $this->_result->fetch_row();
            return $row[0];
        }
        return false;
    }

    function getRow($sql) {
        $this->_result = $this->result($sql);
        return $this->_result ? $this->_result->fetch_assoc() : false;
    }

    function getAssoc($sql) {
        $result = array();
        $field_count = 0;
        $this->_result = $this->result($sql);
        if ($this->_result) {
            $row_count = $this->numRows();
            while ($row = $this->_result->fetch_assoc()) {
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
        return false;
    }

    function getAll($sql) {
        $result = array();
        $this->_result = $this->result($sql);
        if ($this->_result) {
            $result = array();
            while ($row = $this->_result->fetch_assoc()) {
                $result[] = $row;
            }
            return $result;
        }
        return false;
    }

    function result($sql) {
        $this->_result = $this->_db->query($sql);
        return $this->_result;
    }

    function setFetchMode($mode) {
        $this->fetch_mode = intval($mode);
    }

    function error() {
        return $this->_db->connect_errno ? $this->_db->connect_error : $this->_db->error;
    }

    function errno() {
        return $this->_db->connect_errno ? $this->_db->connect_errno : $this->_db->errno;
    }

    function close() {
        return $this->_db->close();
    }

    function numRows() {
        $numRows = $this->_result->num_rows;
        return $numRows;
    }

    function affectedRows() {
        return $this->_db->affected_rows;
    }

    function insertId() {
        return $this->_db->insert_id;
    }

}
