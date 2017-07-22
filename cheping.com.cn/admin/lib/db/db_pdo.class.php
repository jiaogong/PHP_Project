<?php

/**
 * common db driver
 * Require PHP 5.1+
 * Require defined const DBTYPE
 * eg: define('DBTYPE', "pdomysql");
 * 
 * @author David.Shaw <tudibao@163.com>
 * $Id$
 * attention: Dont use "Nested Function" in HHVM
 */
class db_pdo extends PDO {

    private $_st;
    private $affected_rows = 0;
    private $_errstr = '';
    private $autocommit;

    public function __construct($dsn) {
        #$_dsn = $this->parseDSN($dsn);
        $dsn_str = "{$dsn['db']}:host={$dsn['host']};dbname={$dsn['dbname']};";
        $dsn_str .= $dsn['port'] ? "port={$dsn['port']};" : '';

        $this->autocommit = isset($dsn['autocommit']) ? $dsn['autocommit'] : 1;
        $options = array(
            PDO::ATTR_AUTOCOMMIT => $this->autocommit,
            PDO::ATTR_PERSISTENT => !empty($dsn['persistent']),
        );

        if (version_compare(PHP_VERSION, '5.3.6', '<') && $dsn['db'] == 'mysql') {
            $options[PDO::MYSQL_ATTR_INIT_COMMAND] = "set names {$dsn['param']['charset']}";
        } else {
            $dsn_str .= 'charset=' . $dsn['param']['charset'];
        }

        try {
            parent::__construct($dsn_str, $dsn['user'], $dsn['pass'], $options);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo("DB Connect Error!" . $e->getMessage());
            exit;
        }

        if (!$this->autocommit) {
            $this->beginTransaction();
        }
    }

    public function getOne($sql) {
        try {
            $this->_st = $this->prepare($sql);
            $this->_st->execute();
            $col = $this->_st->fetchColumn();
        } catch (PDOException $e) {
            $this->_errstr = $e->getMessage();
            $col = FALSE;
        }
        return $col;
    }

    public function getRow($sql) {
        try {
            $this->_st = $this->prepare($sql);
            $this->_st->execute();
            $row = $this->_st->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->_errstr = $e->getMessage();
            $row = false;
        }
        return $row;
    }

    public function getAssoc($sql) {
        $result = array();
        $field_count = 0;
        try {
            $this->_st = $this->prepare($sql);
            $this->_st->execute();
            $row_count = $this->numRows();

            while ($row = $this->_st->fetch(PDO::FETCH_ASSOC)) {
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
        } catch (PDOException $e) {
            $this->_errstr = $e->getMessage();
            $result = FALSE;
        }
        return $result;
    }

    public function getAll($sql) {
        try {
            $this->_st = $this->prepare($sql);
            $this->_st->execute();
            $result = $this->_st->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->_errstr = $e->getMessage();
            $result = false;
        }
        return $result;
    }

    public function result($sql) {
        try {
            $this->_st = $this->prepare($sql);
            $this->_st->execute();
            $this->_commit();
            $ret = $this->affected_rows = $this->numRows();
        } catch (PDOException $e) {
            $this->_errstr = $e->getMessage();
            $ret = false;
        }
        return $ret;
    }

    private function _commit() {
        if (!$this->autocommit) {
            return $this->commit();
        }
    }

    private function _rollback() {
        if (!$this->autocommit) {
            return $this->rollBack();
        }
    }

    public function error() {
        return $this->errorCode === '00000' ? '' : $this->errorInfo;
    }

    public function errno() {
        return $this->errorCode === '00000' ? '' : $this->errorCode;
    }

    public function close() {
        $this->_st->closeCursor();
        $this->_errstr = NULL;
    }

    public function numRows() {
        return $this->_st->rowCount();
    }

    public function affectedRows() {
        return $this->affected_rows;
    }

    public function insertId() {
        return $this->lastInsertId();
    }

}
