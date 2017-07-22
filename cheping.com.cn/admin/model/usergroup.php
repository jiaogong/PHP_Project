<?php
  /**
  * user group
  * $Id: usergroup.php 2 2015-06-03 04:39:17Z xiaodawei $
  */    
  class userGroup extends model{
    function __construct(){
      $this->table_name = "admin_user_group";
      parent::__construct();      
    }
    
    function getGroup($gid){
      $this->where = "group_id='{$gid}'";
      $this->fields = "*";
      $ret = $this->getResult();
      return $ret;
    }
    
    function getAllGroup(){
      $this->fields = "*";
      return $this->getResult(2);
    }
    
    function getGroupAssoc(){
      $this->fields = "group_id,group_name";
      return $this->getResult(4);
    }
    
    function getGroupAuth($gid){
      $this->fields = "group_default_auth";
      $this->where = "group_id='{$gid}'";
      $groupauth = $this->getResult(3);
      if(empty($groupauth)) return '';
      
      $tmp = explode(',', $groupauth);
      foreach ($tmp as $key => $value) {
        $tmp2 = explode('||', $value);
        $__ga[$tmp2[0]] = $tmp2[1];
      }
      return $__ga;
    }
  }
?>
