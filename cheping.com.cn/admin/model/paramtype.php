<?php
  /**
  * 参数分类
  * $Id: paramtype.php 1250 2015-11-13 09:08:46Z xiaodawei $
  * @author David.Shaw
  */
  
  class paramType extends model{
    
    var $parent_category = array(
      1 => '参数库分类',
      2 => '安全性分类',
      3 => '配置库分类',
    );
    
    function __construct(){
      $this->table_name = "cardb_paramtype";
      parent::__construct();
    }
    
    function getParamType($id){
      $this->fields = "*";
      $this->where = "id='{$id}'";
      return $this->getResult();
    }
    
    function getParamTypeByPid($pid, $order = array()){
      $this->where = "pid='{$pid}'";
      if(empty($order)){
        $this->order = array('type_order' => 'asc');
      }else{
        $this->order = $order;
      }      
      $this->fields = "*";
      $ret = $this->getResult(2);
      return $ret;
    }
    
    function getParamTypeAssoc(){
      $this->fields = "*";
      $this->getall = 1;
      $ret = $this->getResult(2);
      $cate = array();
      foreach ($ret as $key => $value) {
        $value['pname'] = $this->parent_category[$value['pid']];
        $cate[$value['id']] = $value;
      }
      return $cate;
    }
    
    function getAllParamType($where = '1', $order = array(), $limit = 1, $offset = 0){
      $this->where = $where;
      $this->fields = "count(id)";
      $this->total = $this->getResult(3);
      $this->order = $order;
      $this->limit = $limit;
      $this->offset = $offset;
      $this->fields = "*";
      
      $ret = array();
      $category = $this->getResult(2);
      foreach ($category as $key => $value) {
        $value['pname'] = $this->parent_category[$value['pid']];
        $ret[] = $value;
      }
      return $ret;
    }
    
  }
?>
