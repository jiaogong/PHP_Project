<?php
  /**
  * cachedata action
  * $Id: cachedataaction.php 2 2012-10-08 03:01:42Z xiaodawei $
  * $Author: xiaodawei $
  */
  
  class cachedataAction extends action{
    var $cache;
    
    function __construct(){
      global $_cache;
      parent::__construct();
      $this->cache = $_cache;
      
      $this->checkAuth();
    }
    
    function doDefault(){
      $this->doList();
    }
    
    function doList(){
      $this->tpl_file = "cache_list";
      $q = $this->postValue('q')->String();
      $nq = $this->postValue('nq')->String();
      $tk = $this->postValue('tk')->String();
      $data = $this->cache->getcache('cache_list_name_srv');
      $cache_list = array();
      if($q){
        if($data){
          foreach ($data as $k => $v) {
            if(
            ($tk == 'not' &&
            ((strpos($k, $q) !== false && $nq && strpos($k, $nq) === false)
            || (strpos($k, $q) !== false && !$nq))
            )
            || ($tk == 'and' && 
            (($q && $nq && strpos($k, $q) !== false  && strpos($k, $nq) !== false) ||
            (!$nq && strpos($k, $q) !== false) || (!$q && strpos($k, $nq) !== false))
            )
            )
            $cache_list[] = array(
              'name' => $k,
              'value' => $v,
            );
          }
        }
      }
      $this->vars('q', $q);
      $this->vars('nq', $nq);
      $this->vars('tk', $tk);
      $this->vars('data', $cache_list);
      $this->vars('total', count($data));
      $this->template();
    }
    
    function doDel(){
      $keyname = $this->getValue('k')->String();
      $r = $this->cache->removeCache($keyname);
      if($r){
        $msg = "成功";
      }else{
        $msg = "失败";
      }
      
      $this->alert(array(
        'type' => 'js',
        'message' => '删除缓存' . $msg,
        'url' => $_ENV['PHP_SELF'],
        'act' => 3,
      ));
    }
    
    function doView(){
      
    }
    
    function checkAuth(){
      global $adminauth, $login_uid;
      $adminauth->checkAuth($login_uid, 'sys_module', 1104, 'A');
    }
  }
?>
