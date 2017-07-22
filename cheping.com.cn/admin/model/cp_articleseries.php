<?php
/**
* 
* $Id: cp_articleseries.php 1789 2016-03-24 08:39:22Z wangchangjiang $
*/

class cp_articleSeries extends model{
    function __construct() {
        parent::__construct();
        $this->table_name = 'cardb_article_series';
    }
    function getArticleSeries($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }
}
?>
