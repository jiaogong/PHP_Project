<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class articlepic extends model{

    function  __construct() {
        $this->table_name = "cardb_file";
        parent::__construct();
    }
 
    function getArticle($where, $limit = 20, $offset = 0, $order = array(), $type = 2) {
        $this->tables = array(
            'cp_article' => 'ca',
            'cp_article_category' => 'cac',
            'cardb_file' => 'cf'
        );

        $this->where = "ca.pic_org_id=cf.type_id and ca.category_id=cac.id GROUP BY cf.type_id";
        $this->fields = "count(ca.id)";
        $this->total = count($this->joinTable(2));
        $this->fields = "ca.id,ca.title,ca.title2,ca.title3,ca.pic,ca.pic_org_id,ca.category_id,cf.id,cf.name,cf.file_type,cf.type_name,cf.type_id,cf.memo,cf.created,cf.updated,cac.category_name";
        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;
	$res = $this->joinTable($type);
	if($res)
            return $res;
	else
            return false;
    }
    
    function getCount($where,$order = array(),$type =2){
        $this->tables = array(
            'cp_article' => 'ca',
            //'cp_article_category' => 'cac',
            'cardb_file' => 'cf'
        );
        $this->where = $where;
        $this->fields = "ca.id,ca.title,ca.title2,ca.title3,ca.pic,ca.pic_org_id,cf.id,cf.name,cf.file_type,cf.type_name,cf.type_id,cf.memo,cf.created,cf.updated";
        $this->order = $order;
        return $this->joinTable($type);
    }

    function getlist($fields, $where,$type =2){
        $this->where = $where;
        $this->fields = $fields;
        return $this->getResult($type);
    }

}

?>
