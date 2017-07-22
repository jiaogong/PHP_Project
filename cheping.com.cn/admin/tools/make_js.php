<?php
  /**
  * make js
  * $Id: make_js.php 2 2015-06-03 04:39:17Z xiaodawei $
  */
  
  error_reporting(7);
  require_once("../include/common_na.inc.php");
  $_SESSION[COOKIE_PRE . 'user_id'] = 0;
  $_SESSION[COOKIE_PRE . 'user_name'] = 'admin';

  class makeJs extends action{
    var $id;
    function __construct(){
      parent::__construct();
    }
    
    function doDefault(){
      $obj = null;
      $tmp = array();
      
      $opt = $this->getOpt();
      if(!empty($opt['o'])){
        $tmp = explode('-', $opt['o']);
        if(count($tmp)>1){
          $action_class = $tmp[0] . "action";
          $_GET['action'] = $tmp[1];
          $action_func = "do" . $_GET['action'];
          
          $obj = new $action_class;
          $id = $opt['d'];
          $obj->{$action_func}($id);
        }else{
          $_GET['action'] = $opt['o'];
          $action = "do" . $_GET['action'];
          $id = $opt['d'];
          $this->{$action}($id);
        }
      }
    }
    
    function doMakeJs($id){
      $static = new cardbStatic();
      $st = $static->getStatic($id);
      $ret = $this->action2File($st['url'], WWW_ROOT . $st['savepath']);
      if($ret){
        echo $st['savepath'] . " make ok\n";
      }else{
        echo $st['savepath'] . "make err\n";
      }
    }
  }
  
  $tc = new makeJs();
  $tc->doDefault();
  
?>
