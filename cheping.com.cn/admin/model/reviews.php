<?php

/**
 * cntv reviews interface
 * $Id: reviews.php 615 2015-08-20 11:10:00Z cuiyuanxin $
 */
class reviews extends model {
    var $total;
    function __construct() {
        $this->table_name = "cp_review";
        parent::__construct();
    }
    
    function getTagList($where, $fields = "*", $limit = 20, $offset = 0, $order = array(), $type = 2){
        $this->fields = "count(id)";
        $this->where = $where ? $where : 1;
        $this->total = $this->getResult(3);
        
        $this->fields = $fields ? $fields : "*";
        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;
        
        return $this->getResult($type);
    }
    
    function getTag($id) {
        $this->where = "id={$id}";
        $this->fields = '*';
        return $this->getResult(1);
    }
    
    /**
    * 联表查询
    **/
    function getPriceAndModelA($where, $limit = 20, $offset = 0, $order = array(), $type = 2){
	$this->tables = array(
            'cp_article' => 'ca',
            'cp_review' => 'cr',
	);
        $this->where = "1";
        $this->fields = "count(id)";
        $this->total = $this->getResult(3);
        //var_dump($res);
        $this->where = $where?$where:"cr.article_id=ca.id";
        $this->fields = "cr.id,cr.content,cr.type_name,cr.parentid,ca.title,cr.uname,cr.created,cr.ip,cr.state";
        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;
	$res = $this->joinTable($type);

	if($res)
            return $res;
	else
            return false;
    }
    
    
}

?>
