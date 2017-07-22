<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class dealerarticle extends model{
    function  __construct() {
        $this->table_name = "dealer_article";
        parent::__construct();
    }

    function getArticle($fields="*",$where=" 1 ",$order=array(),$limit,$offset) {
        $this->reset();
        $this->tables=array("dealer_article"=>"da","dealer_info"=>"di");
        $this->fields = 'da.*,di.dealer_name';
        $this->where = 'da.dealer_id=di.dealer_id '.$where;
        $this->fields = "count(id)";
        $this->total = $this->joinTable(2);
        
        $this->tables=array("dealer_article"=>"da","dealer_info"=>"di");
        $this->fields = 'da.*,di.dealer_name';
        $this->where = 'da.dealer_id=di.dealer_id '.$where;
        $this->order = array('created'=>'DESC');
        $this->limit = $limit;
        $this->offset = $offset;
        $onearticle = $this->joinTable(2);
        return $this->joinTable(2);
    }

    function getArticleById($id) {
        $this->where = "id='{$id}'";
        $this->fields = "*";
        return $this->getResult();
    }
}

?>
