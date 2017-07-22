<?php
  /**
  * cardb_type
  * $Id: cardbtype.php 448 2015-08-07 15:26:23Z xiaodawei $
  */
  
  class cardbType extends model{
    function __construct(){
      parent::__construct();
      $this->table_name = "cardb_type";
    }
    
    function getType($id){
      $this->fields = "*";
      $this->where = "type_id='{$id}'";
      return $this->getResult();
    }
    
    function getAllType(){
      $this->fields = "*";
      $cartype = $this->getResult(2);
      return $cartype;
    }
    
    function getAllTypeAssoc(){
      $this->fields = "type_id,type_name";
      return $this->getResult(4);
    }
  }
?>
