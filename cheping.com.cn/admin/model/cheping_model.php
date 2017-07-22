<?php
/**
 * Created by PhpStorm.
 * User: Yi
 * Date: 2016/4/19
 * Time: 18:28
 * $Id: cheping_model.php 2307 2016-04-28 02:51:02Z wangchangjiang $
 */

//tobing数据库的表移动
class cheping_model extends model {

    function cheping_model($table) {
        parent::__construct();
        $this->table_name = $table;
    }

    /**
     * 查询指定条数据的数据
     *
     * @param int $offset 获取启始数据数
     * @param int $limit  获取每次取的条数
     * @param int $flag 查询状态数字
     */
    function getLimitResult($offset = 0, $limit = 1, $flag=2) {
        $this->fields = "*";
        $this->offset = $offset;
        $this->limit = $limit;
        return $this->getResult($flag);
    }

    /**
     * 返回表数据总条数
     */
    function getDataNum(){
        $this->fields = "count(*)";
        return $this->getResult(3);
    }
    
    /**
     * 插入数据
     * @param array $ufileds 插入数据的字段名
     */
    function insertData($ufileds = array()){
        $this->ufields = $ufileds;
        return $this->insert();
    }

    /**
     * 查询表名是否存在
     */
    function selectTab(){
        $this->fields = "*";
        $this->limit = 1;
        return $this->getResult(1);
    }
    

    /**
     * 插入数据
     * @param string $table1 被插入数据的表名
     * @param string $table2 数据源的表名
     * @param string $fields 要插入的字段集名
     * @param int $offset 获取启始数据数
     * @param int $limit  获取每次取的条数
     * 
     */

    function insertFileData($table1, $table2, $fields='', $offset = 0, $limit = 1){

        $sql = "INSERT INTO $table1 ($fields)
                SELECT $fields
                FROM $table2 ORDER BY id DESC LIMIT " . $offset . ", " . $limit;
        $this->db->result($sql);
    }

    /**
     * 获取重复数据的条件字段值数组
     * @param string $table 表名
     * @param string $field 指定重复数据的字段名
     * @return array $rows 重复数据的条件字段值数组
     */
    function getRepeatData($field){
        $table = $this->table_name;
        $sql ="select type_id,pos,ppos,s1
                from $table
                where type_name='". $field ."'
                GROUP BY type_name,type_id,pos,ppos,s1
                HAVING count(id)>1";
        $rows = $this->db->getAll($sql);
        return $rows;
    }

    /**
     * 获取同一条件下重复数据的被删除id
     * @param array $fields 条件数组
     * @return int $rows id
     */
    function getRepeatDataId($fields){
        $this->fields = "min(id)";
        $wheres='';
        foreach($fields as $k=>$v) {
            $wheres .= "$k=$v AND ";
        }
        $wheres = rtrim($wheres,'AND ');
        $this->where = $wheres;
        return $this->getResult(3);
    }

    /**
     * 删除重复数据
     * @param string $id 要删除的数据id
     * @return int 删除的条数成功返回1 失败返回false
     */
    function delRepeatData($id){
        $this->where = "id = $id";
        return $this->del();
    }
    

}