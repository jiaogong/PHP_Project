<?php
/**
* 
* $Id: articleseries.php 59 2015-07-03 06:01:02Z yinliuhui $
*/

class articleSeries extends model{
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
    function getCountSeries($fields,$where,$flag){
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
