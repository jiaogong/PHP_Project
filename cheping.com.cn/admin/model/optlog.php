<?php
  /**
  * user operation logger model
  * @author David.Shaw
  * $Id: optlog.php 1789 2016-03-24 08:39:22Z wangchangjiang $
  */
  
  class optLog extends model{
    var $total;
    
    function __construct(){
      $this->table_name = "opt_log";
      parent::__construct();      
    }
    
    function getLog(){
      if($this->getall || $this->limit > 1) $func = "getAll";
      else $func = "getRow";
      $this->getSQL();
      return $this->db->$func($this->sql);
    }
    
    function getList($where = '', $limit = 1, $offset = 0){
      $this->limit = 1;
      $this->where = $where;
      $this->fields = "count(id)";
      $this->total = $this->getResult(3);
      
      $this->fields = "*";
      $this->limit = $limit;
      $this->offset = $offset;
      $this->order = array('created' => 'desc');
      
      $ret = $this->getResult(2);
      return $ret;
    }
    
    function writeLog($module_name = '', $memo = '', $uname = ''){
      global $timestamp, $login_uname, $login_uid, $module_code;
      if(!$module_code && !$module_name) return false;
      
      if(!$module_name && $module_code){
        $this->table_name = "sys_module";
        $this->fields = "module_name";
        $this->where = "module_code='{$module_code}'";
        $module_name = $this->getResult(3);
        $this->table_name = "opt_log";
        $this->fields = "*";
        $this->where = "";
      }
      $username = $uname ? $uname : $login_uname;
      $user_id = $login_uid;
      $ip = util::getip();
      $this->ufields = array(
        'user_id' => $user_id,
        'username' => $username,
        'module_name' => $module_name,
        'memo' => $memo,
        'ip' => $ip,
        'created' => $timestamp
      );
      return $this->insert();
    }
  }
?>
