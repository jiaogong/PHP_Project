<?php

/**
 * model base class
 * $Id: model.class.php 1187 2015-11-05 08:34:00Z xiaodawei $
 * @author David Shaw <tudibao@163.com>
 */
/**
 * @var int 返回一条记录数组
 */
define('DB_RESULT_ROW', 1);

/**
 * @var int 返回满足条件的所有记录的多维数组
 */
define('DB_RESULT_ALL', 2);

/**
 * @var int 返回一列数据值
 */
define('DB_RESULT_ONE', 3);

/**
 * @var int 数据以关联数组形式返回，数组键值为指定的第一个字段
 */
define('DB_RESULT_ASSOC', 4);

class model extends object {

    /**
     * 数据表名称
     * @var string 
     */
    var $table_name;

    /**
     * 排序字段，数组
     * array(字段1=>排序方式,字段2=>排序方式....)
     * 
     * @var array
     */
    var $order;
    var $where;
    var $sql;
    var $fields = "*"; //select fields
    var $ufields = array(); //update fields
    var $limit = 1;
    var $offset = 0;
    var $getall = 0;
    var $group;
    var $db;
    var $db2;
    var $tpl;
    var $debug = 0;
    var $errormsg = '';
    var $tables = array();
    var $vars_bak = array();
    var $affectedrows = 0;
    var $logging = 0;

    function __construct() {
        parent::__construct();
        $this->initDb();
        $this->initDb2();
        if (empty($this->vars_bak)) {
            $this->vars_bak = array(
                /* 'table_name' => $this->table_name, */
                'order' => $this->order,
                'where' => $this->where,
                'sql' => $this->sql,
                'fields' => $this->fields,
                'ufields' => $this->ufields,
                'limit' => $this->limit,
                'offset' => $this->offset,
                'getall' => $this->getall,
                'group' => $this->group,
            );
        }
        $this->logging = LOGGING;
    }

    function initDb() {
        $dsn = DBTYPE . "://" . DBUSER . ":" . DBPASS . "@" . DBHOST . "/" . DBNAME;
        $this->db = & DB::connect($dsn);
        if (DB::IsError($this->db)) {
            die($this->db->GetMessage());
        }
        $this->db->query('set names "' . DB_CHARSET . '"');
        $this->db->setFetchMode(DB_FETCHMODE_ASSOC);
    }

    function initDb2() {
        if (!defined('DBUSER_S')) {
            $dsn = DBTYPE . "://" . DBUSER . ":" . DBPASS . "@" . DBHOST . "/" . DBNAME;
        } else {
            $dsn = DBTYPE . "://" . DBUSER_S . ":" . DBPASS_S . "@" . DBHOST_S . "/" . DBNAME_S;
        }

        $this->db2 = & DB::connect($dsn);
        if (DB::IsError($this->db2)) {
            die($this->db2->GetMessage());
        }
        $this->db2->query('set names "' . DB_CHARSET . '"');
        $this->db2->setFetchMode(DB_FETCHMODE_ASSOC);
    }

    /**
     * 组织用于数据库操作的SQL语句
     * 
     * @return string SQL语句
     */
    function getSQL() {
        $this->table_name || die('undefined object->table_name');
        if (empty($this->fields)) {
            $this->fields = "id";
        }
        $this->sql = "select {$this->fields} from {$this->table_name} " . (empty($this->where) ? "" : " where " . $this->where);
        if ($this->group) {
            $this->sql .= " group by {$this->group} ";
        }
        if (!empty($this->order) && is_array($this->order)) {
            $this->sql .= " order by ";
            foreach ($this->order as $key => $value) {
                $this->sql .= " {$key} {$value},";
            }
            $this->sql = rtrim($this->sql, ",");
        }

        if (!$this->getall)
            $this->sql .= " limit {$this->offset}, {$this->limit}";
    }

    /**
     * insert 方法
     * 
     * @param object $db 数据库连接对象
     * @return boolean 插入成功后返回的为新插入自增ID，大于1，否则为插入失败
     */
    function insert($db = "db2") {
        $this->sql = "insert into {$this->table_name} set ";
        $fields = '';
        foreach ($this->ufields as $key => $value) {
            $fields .= " {$key}='{$value}',";
        }
        $this->sql .= $fields;
        $this->ufields = array();
        $this->sql = rtrim($this->sql, ",");
        $result = $this->$db->query($this->sql);

        if (DB::isError($result)) {
            $this->errormsg = $result;
            return false;
        } else {
            $this->errormsg = '';
            $insert_id = $this->$db->getOne('select LAST_INSERT_ID()');
            $this->logging('insert', $this->table_name, '', $fields, $insert_id);
            return $insert_id;
        }
    }

    /**
     * 更新数据库方法
     * 
     * @param object $db 数据库连接对象
     * @return boolean 当更新操作正常时，返回影响的记录行数，否则返回False
     */
    function update($db = "db2") {
        $this->sql = "update {$this->table_name} set ";
        $fields = '';
        foreach ($this->ufields as $key => $value) {
            $fields .= " {$key}='{$value}',";
        }
        $this->sql .= $fields;
        $this->ufields = array();
        $this->sql = rtrim($this->sql, ",");
        $this->sql .= $this->where ? " where {$this->where}" : "";
        $result = $this->$db->query($this->sql);
        $this->debug && $this->errorMsg();
        //return affected Rows
        $this->affectedrows = $this->$db->affectedRows();
        $this->getall = 0;
        if (DB::isError($result)) {
            $this->errormsg = $result;
            return false;
        } else {
            $this->errormsg = '';
            $this->logging('update', $this->table_name, $this->where, $fields, $this->affectedrows);
            return $this->affectedrows;
        }
    }

    /**
     * 删除数据库方法
     * @param object $db  数据库连接对象
     * @return boolean  删除操作成功返回影响的记录行数，失败返回False
     */
    function del($db = "db2") {
        if (!$this->where)
            return false;
        $this->sql = "delete from {$this->table_name} where {$this->where}";
        if ($this->limit)
            $this->sql .= " limit {$this->limit}";
        $r = $this->$db->query($this->sql);
        $this->debug && $this->errorMsg();
        //return affected Rows
        $this->affectedrows = $this->$db->affectedRows();
        $this->getall = 0;
        if (DB::isError($r)) {
            $this->errormsg = $r;
            return FALSE;
        } else {
            $this->errormsg = '';
            $this->logging('delete', $this->table_name, $this->where, '', $this->affectedrows);
            return $this->affectedrows;
        }
    }

    /**
     * DDL记录入库
     * 
     * @param string $opt_type 操作类型
     * @param string $opt_table  操作表名
     * @param string $opt_condition 操作条件
     * @param string $opt_fields 操作的字段
     * @param integer $affected_rownum 影响的行数,insert操作代表last_insert_id()
     */
    function logging($opt_type, $opt_table, $opt_condition, $opt_fields, $affected_rownum, $db = "db2") {
        if ($this->logging) {
            $__opt_type = array(
                'delete' => '删除',
                'update' => '修改',
                'insert' => '插入',
            );
            $opt_table = addslashes($opt_table);
            $opt_condition = addslashes($opt_condition);
            $opt_fields = addslashes($opt_fields);
            $opt_position = get_class($this);

            $__sql = "insert into cardb_optlog set opt_type='{$__opt_type[$opt_type]}',opt_table='{$opt_table}',";
            $__sql.= "opt_condition='{$opt_condition}',opt_fields='{$opt_fields}', affected_rownum='{$affected_rownum}',";
            $__sql.= "ip='" . util::getIP() . "',created='" . $this->timestamp . "',opt_position='{$opt_position}'";
            $r = $this->$db->query($__sql);
            #error_log($__sql . "\n", 3, 'opt_log.txt');
        } else {
            #error_log("error\n", 3, 'opt_log.txt');
        }
    }

    /**
     * 查询数据方法
     * 
     * @param int $type 查询方法;1=返回单行结果，2=返回匹配的多行结果，3=返回单列结果，4=返回关联数组
     * @return mixed 返回查询的结果，数组或单个字段值
     */
    function getResult($type = 1, $multi = 0) {
        switch ($type) {
            case 1:
                $func = "getRow";
                break;
            case 2:
                $func = "getAll";
                break;
            case 3:
                $func = "getOne";
                break;
            case 4:
                $func = "getAssoc";
                break;
        }

        if ($type != 1 && $type != 3) {
            if ($this->limit == 1) {
                $this->getall = 1;
            }
        }
        if (!$multi)
            $this->getSQL();
        $result = $this->db->$func($this->sql);
        $this->getall = 0;
        if (DB::isError($result)) {
            $this->errormsg = $result;
            return FALSE;
        } else {
            $this->errormsg = '';
            return $result;
        }
    }

    /**
     * 左关联查询方法（left join），根据数据库特性，可能结果中有空记录项
     * $this->table_name = 第一个表名;
     * $this->tables = array() 第二个表及以后的表和表别名数组;
     * $this->join_condition = array('table1.column = table2.column', ...);
     *
     * @param int $type 定义查询方式, 1单行记录数组，2多行记录数组，3单列字段结果，4多行关联数组
     * @see joinTable方法，getResult方法
     */
    function leftJoin($type = 1, $reverse = 0) {
        $k = 0;
        $tables = $this->tables;
        $join_condition = $this->join_condition;
        if (strpos($this->table_name, ' ') !== false) {
            list($table, $alias) = explode(' ', $this->table_name);
        } else {
            list($table, $alias) = each($tables);
            array_shift($tables);
        }
        if (!$reverse) {
            $this->sql = "SELECT {$this->fields} FROM $table $alias";
            foreach ($tables as $table => $alias) {
                $this->sql .= " LEFT JOIN $table $alias ON {$join_condition[$k++]} ";
            }
        } else {
            $this->sql = "SELECT {$this->fields} FROM $alias $table";
            foreach ($tables as $table => $alias) {
                $this->sql .= " LEFT JOIN $alias $table ON {$join_condition[$k++]} ";
            }
        }
        $this->sql .= ' WHERE ' . $this->where;
        if ($this->group){
            $this->sql .= " GROUP BY {$this->group} ";
        }
        if (!empty($this->order) && is_array($this->order)) {
            $this->sql .= ' ORDER BY ';
            foreach ($this->order as $key => $value) {
                $this->sql .= " {$key} {$value},";
            }
            $this->sql = rtrim($this->sql, ",");
        }
        switch ($type) {
            case 1:
                $this->getall = 0;
                $this->limit = 1;
                break;

            case 2:
                if ($this->limit > 1) {
                    $this->getall = 0;
                } else {
                    $this->getall = 1;
                }
                break;

            case 3:
                $this->getall = 0;
                break;

            case 4:
                if ($this->limit > 1) {
                    $this->getall = 0;
                } else {
                    $this->getall = 1;
                }
                break;
        }
        if (!$this->getall)
            $this->sql .= " limit {$this->offset}, {$this->limit}";

        return $this->getResult($type, 1);
    }

    /**
     * 数据表之间的关联查询操作，等同于join操作，非left/right join
     * var $tables is array
     * sample: array(
     *   table_name1 => table_alias_name1,
     *   table_name2 => table_alias_name2,
     * )
     * 
     * @param int $type 定义查询方式, 1单行记录数组，2多行记录数组，3单列字段结果，4多行关联数组
     * @param int $reverse 翻转表数组，1翻转，0不翻转，由于数组键值不能重复，解决同表子查询问题
     * @see 与getResult方法相同
     */
    function joinTable($type = 1, $revers = 0) {
        if (!$this->where)
            return false;

        $this->sql = "select {$this->fields} from ";
        if (!$revers) {
            foreach ($this->tables as $table => $alias) {
                $this->sql .= "{$table} {$alias},";
            }
        } else {
            foreach ($this->tables as $table => $alias) {
                $this->sql .= "{$alias} {$table},";
            }
        }
        $this->sql = rtrim($this->sql, ',') . ' where ' . $this->where;
        if ($this->group) {
            $this->sql .= " group by {$this->group} ";
        }
        if (!empty($this->order) && is_array($this->order)) {
            $this->sql .= " order by ";
            foreach ($this->order as $key => $value) {
                $this->sql .= " {$key} {$value},";
            }
            $this->sql = rtrim($this->sql, ",");
        }

        switch ($type) {
            case 1:
                $this->getall = 0;
                $this->limit = 1;
                break;

            case 2:
                if ($this->limit > 1) {
                    $this->getall = 0;
                } else {
                    $this->getall = 1;
                }
                break;

            case 3:
                $this->getall = 0;
                break;

            case 4:
                if ($this->limit > 1) {
                    $this->getall = 0;
                } else {
                    $this->getall = 1;
                }
                break;
        }
        if (!$this->getall)
            $this->sql .= " limit {$this->offset}, {$this->limit}";

        return $this->getResult($type, 1);
    }

    /**
     * 重置所有数据表相关的自定义信息
     */
    function reset() {
        if (!empty($this->vars_bak))
            foreach ($this->vars_bak as $key => $value) {
                $this->$key = $value;
            }
    }

    /**
     * 打印错误信息
     * 
     * @param int $show_sql 错误信息中是否显示最近执行的sql语句
     * @param int $stop 打印完错误信息是否要求中止程序
     * @return void 
     */
    function errorMsg($show_sql = 0, $stop = 0) {
        echo $this->errormsg;
        if ($show_sql) {
            echo "<br>\n" . $this->sql;
        }
        if ($stop) {
            exit;
        }
    }

    /**
     * 返回最近执行的数据库操作状态
     * 
     * @return boolean True有错误，False正常，没错误
     */
    function isError() {
        return !empty($this->errormsg);
    }

}

?>
