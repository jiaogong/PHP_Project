<?php

/**
 * rss action
 * $Id: rssaction.php 1485 2015-12-02 07:12:11Z david $
 */

class rssAction extends action {
    var $article;
    var $category;
    function __construct() {
        parent::__construct();
        $this->article = new article();
        $this->category = new category();
        //$this->checkAuth(701);
    }
    
    function doDefault() {
        $this->doRssList();
    }
    
    function doRssList() {
        global $local_host;
        $template_name = "rss";
        $this->page_title = "ams车评 RSS订阅";

        $where = "type_id=1 and state=3 and CURDATE()-30 order by uptime desc";
        $list = $this->article->getArticleFields('*', $where, 2);
        foreach ($list as $key => $val) {
            //$list[$key][url] = "/html/article/".data('Ym/d',$val[uptime])."/".$val[id].".html";
            $list[$key]['title'] = htmlspecialchars($val['title']);
            $list[$key]['contents'] = htmlspecialchars($val['content']);
            $list[$key]['p_category_id'] = $this->category->getParentId($list[$key]['category_id']);
            $list[$key]['url'] = htmlspecialchars($this->article->getRewriteUrl($list[$key]));
            unset($list[$key][content]);
        }
        #var_dump($list);
        $this->vars('list',$list);
        $this->vars('title',$this->page_title);
        
        $this->vars('startpage',$local_host);
        $this->vars('current_date',$this->timestamp);
        $xml = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
        $xml .= $this->fetch($template_name);
        echo $xml;
    }
    
}

?>