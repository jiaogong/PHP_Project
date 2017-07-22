<?php

/**
 * 文章车系表model
 * $Id: articleseries.php 969 2015-10-22 04:05:17Z xiaodawei $
 */
class articleSeries extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = 'cp_article_series';
    }

    function getArticleSeries($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }

    /**
     * 查询管理文章
     */
    function getCountSeries($fields, $where, $flag) {
        $this->tables = array(
            'cp_article' => 'ca',
            'cp_article_series' => 'cas'
        );
        $this->fields = "$fields";
        $this->where = "$where";
        $ret = $this->joinTable($flag);
        return $ret;
    }

}

?>
