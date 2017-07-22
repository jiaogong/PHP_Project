<?php

/**
 * cntv article interface
 * $Id: articlelogs.php 1059 2015-10-27 07:04:44Z xiaodawei $
 */
class articlelogs  extends model {
    var $total;
    function __construct() {
        $this->table_name = "cp_article_logs";
        parent::__construct();
    }

    function formateDate($arr) {
        foreach ($arr as $k => $v) {
            $created = $v['created'];
            $arr[$k]['ym'] = date('Ym', $created);
            $arr[$k]['d'] = date('d', $created);
        }
        return $arr;
    }

    function ssiIndexarticles() {
        $this->fields = 'id, title, title2, pic, created';
        $this->where = "pic <> '' AND ishot = 1";
        $this->order = array('updated' => 'DESC');
        $hotArticle[] = $this->getResult();
        $this->where = 'ishot <> 1';
        $this->order = array('created' => 'DESC');
        $this->limit = 6;
        $articles = $this->getResult(2);
        $articles = array(
            'hotArticle' => $this->formateDate($hotArticle),
            $this->table_name => $this->formateDate($articles)
        );
        return $articles;
    }

    function getarticle($id) {
        $this->where = "id={$id}";
        $this->fields = '*';
        return $this->getResult();
    }
    function getIndexFootarticle($fields, $where, $type = 2, $order = '', $limit) {
        $this->tables = array(
            $this->table_name => 'a',
            'article_channel' => 'ac'
        );
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        $this->limit = $limit;
        $result = $this->joinTable($type);
        foreach($result as $k => $row) {
            $title = $row['title'] . ' ' . $row['title2'];
            $result[$k]['full_title'] = $title;
            $result[$k]['short_title'] = dstring::get_str($title, 36);
        }
        return $result;
    }    
    
    function getArticleList($where, $fields = "*", $limit = 20, $offset = 0, $order = array(), $type = 2){
        $this->fields = "count(id)";
        $this->where = $where ? $where : 1;
        $this->total = $this->getResult(3);
        
        $this->fields = $fields ? $fields : "*";
        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;
        
        return $this->getResult($type);
    }
    
    function getarticles($fields, $where, $order = null, $tables = array(), $type = 2) {
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        $this->tables = $tables;
        return $this->joinTable($type);
    }
    function getArticleFields($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }
}

?>
