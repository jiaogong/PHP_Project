<?php
  /**
  * article channel model
  * $Id: articlechannel.php 2 2015-06-03 04:39:17Z xiaodawei $
  */
  
  class articleChannel extends model{
    function __construct(){
      parent::__construct();
      $this->table_name = "article_channel";
    }
    
    function getArticleChannel($id){
      $this->fields = "*";
      $this->where = "id='{$id}'";
      return $this->getResult();
    }
    
    function checkExist($article_id, $channel_id){
      $this->fields = "*";
      $this->where = "article_id='{$article_id}' and channel_id='{$channel_id}'";
      return $this->getResult();
    }
    
    function getChannelByArticle($id){
      $this->where = "article_id='{$id}'";
      $this->fields = "*";
      return $this->getResult(2);
    }
    
    function getAllArticleChannel(){
      return $this->getResult(2);
    }
  }
?>
