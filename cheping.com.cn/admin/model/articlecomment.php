<?php
/**
* 
* $Id: articlecomment.php 39 2015-06-19 09:51:51Z yinliuhui $
*/

class articlecomment extends model{
    function __construct() {
        parent::__construct();
        $this->table_name = 'cp_article_comment';
    }
    function getArticleSeries($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }
}
?>
