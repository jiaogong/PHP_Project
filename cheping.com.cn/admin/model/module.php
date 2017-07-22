<?php
  /**
  * module
  * $Id: module.php 2 2015-06-03 04:39:17Z xiaodawei $
  */
  class module extends model{
    function __construct(){
      $this->table_name = "sys_module";
      parent::__construct();
    }
    
    function getModule($id){
      $this->fields = "*";
      $this->where = "module_id='{$id}'";
      return $this->getResult();
    }
    
    function getAllModule(){
      $this->fields = "*";
      $this->order = array('module_code' => 'asc');
      return $this->getResult(2);
    }
    
    /**
    * test join table
    * 
    * @param mixed $uid
    */
    function getUserModule($uid){
      $this->tables = array(
        'admin_user' => 'u',
        'admin_auth' => 'a',
        'admin_user_group' => 'g',
        'sys_module' => 'm'
      );
      $this->fields = "u.*";
      $this->where = "u.uid={$uid} and u.gid=g.group_id and u.uid=a.uid and a.auth_type='sys_module' and a.type_id=m.module_id";
      $ret = $this->joinTable(2);
      #var_dump($this->sql);
      return $ret;
    }
    
  }
?>
