<?php

/**
 * 文章栏目表 article_category
 * $Id: category.php 970 2015-10-22 04:09:08Z xiaodawei $
 */
class category extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = 'cp_article_category';
    }

    function getlist($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }

    /**
     * 自链接查询
     */
    function getParentCategoryName($fields, $where, $flag) {
        $this->tables = array(
            'ca' => 'cp_article_category',
            'pca' => 'cp_article_category'
        );

        $this->fields = "$fields";
        $this->where = "$where";
        $ret = $this->joinTable($flag, 1);
        return $ret;
    }

    function getFields($fields, $where) {
        $this->tables = array(
            'ca' => 'cp_article_category',
            'pca' => 'cp_article_category'
        );
        $this->fields = $fields;
        $this->where = $where;
        return $this->joinTable(2, 1);
    }

    /**
     * 根据文章栏目ID，返回单行数据数组
     * 
     * @param interger $cid
     * @return array 文章栏目数组，单行
     */
    function getCategory($cid) {
        $this->where = "id='{$cid}'";
        $this->fields = "parentid";
        return $this->getResult(1);
    }

    /**
     * 根据栏目ID，返回父ID
     * 
     * @param interger $cid 文章栏目ID
     * @return interger 文章栏目父ID
     */
    function getParentId($cid) {
        $category = $this->getCategory($cid);
        return $category['parentid'];
    }

}

?>
