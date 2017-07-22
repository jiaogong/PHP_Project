<?php
  /**
  * article type model
  * $Id: articletype.php 2 2015-06-03 04:39:17Z xiaodawei $
  */
  
  class articletype extends model{
    function __construct(){
      $this->table_name = "article_category";
      parent::__construct();
    }
    
    function getArticleType($id){
      $this->where = "id='{$id}'";
      $this->fields = "*";
      return $this->getResult();
    }
    
    function getAllArticleType($where){
      $this->where = $where;
      $this->fields = "*";
      return $this->getResult(2);
    }
    
    function getArticleTypeAssoc(){
      $this->fields = "id, name";
      return $this->getResult(4);
    }
    
    function getParticelType(){
      $all = $this->getArticleTypeAssoc();
      $ret = $this->getAllArticleType('1');
      $tmp = array();
      foreach ($ret as $key => $value) {
        if(array_key_exists($value['pid'], $all)){
          $value['pname'] = $all[$value['pid']];
        }else{
          $value['pname'] = '';
        }
        $tmp[] = $value;
      }
      return $tmp;
    }
    
  }
?>
