<?php

/**
 * advice interface
 * $Id: advice.php 1558 2015-12-11 09:36:24Z cuiyuanxin $
 */
class advice extends model {

    function __construct() {
        $this->table_name = "cp_advice";
        parent::__construct();
    }

    /**
     * 根据where条件，查询并返回文章相关字段的数据
     * 
     * @param string $fields 需要返回的字段
     * @param string $where 查询条件
     * @param interger $flag 查询方法;1=返回单行结果，2=返回匹配的多行结果，3=返回单列结果，4=返回关联数组
     * @return array 文章结果数组
     */
    function getAdvice($fields, $where, $flag) {
        $this->fields = "count(id)";
        $this->where = $where ? $where : 1;
        $this->total = $this->getResult(3);

        $this->fields = $fields ? $fields : "*";
        $result = $this->getResult($flag);
        return $result;
    }
    
    /**
     * 根据where条件，查询并返回文章相关字段的数据
     * 
     * @param string $fields 需要返回的字段
     * @param string $where 查询条件
     * @param interger $flag 查询方法;1=返回单行结果，2=返回匹配的多行结果，3=返回单列结果，4=返回关联数组
     * @return array 文章结果数组
     */
    function getList($fields, $where, $flag) {
        $this->where = $where ? $where : 1;
        $this->fields = $fields ? $fields : "*";
        $result = $this->getResult($flag);
        return $result;
    }
}

?>
