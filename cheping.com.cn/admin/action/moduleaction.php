<?php
  /**
  * module action
  * $Id: moduleaction.php 1170 2015-11-04 14:58:47Z xiaodawei $
  */
  
  class moduleAction extends action{
    var $module;
    function __construct(){
      parent::__construct();
      $this->module = new module();
    }
    
    function doDefault(){
      $this->doList();
    }
    
    function doList(){
      $this->page_title = "权限模块列表";
      $this->checkAuth();
      $template_name = "module_list";      
      $allmodule = $this->module->getAllModule();
      $this->vars('allmodule', $allmodule);
      $this->vars('page_title', $this->page_title);
      $this->tpl->display($template_name);
    }
    
    function doAdd(){
      $this->checkAuth();
      $template_name = "module_add";
      $module_code = $this->postValue('module_code')->Val();
      if($module_code){
        $this->module->ufields = array(
          'module_code' => $module_code,
          'module_name' => $this->postValue('module_name')->Val(),
          'module_link' => $this->postValue('module_link')->Val(),
          'module_memo' => $this->postValue('module_memo')->Val(),
        );
        $module_id = $this->postValue('module_id')->Int();
        if($module_id){
          $message = "修改权限模块";
          $this->module->where = "module_id='{$module_id}'";
          $ret = $this->module->update();
        }else{
          $message = "添加权限模块";
          $ret = $this->module->insert();
        }
        if($ret){
          $message .= '成功！';
        }else{
          $message .= '失败！';
        }
        $this->alert($message, 'js', 3, $_ENV['PHP_SELF']);
      }
      $id = $this->getValue('id')->Int();
      if($id){
        $this->page_title = "修改权限模块";
        $module = $this->module->getModule($this->getValue('id')->Int());
        $this->vars('module', $module);
        $edit = 1;
      }else{
        $this->page_title = "添加权限模块";
        $edit = 0;
      }
      
      $allmodule = $this->module->getAllModule();
      
      $this->vars('edit', $edit);
      $this->vars('allmodule', $allmodule);
      $this->vars('page_title', $this->page_title);
      $this->tpl->display($template_name);
    }
    
    function doEdit(){
      $this->doAdd();
    }
    
    function doDel(){
      $this->checkAuth();
      $this->module->where = "module_id='{$this->getValue('id')->Int()}'";
      $ret = $this->module->del();
      if($ret){
        $message = "权限模块删除成功！";
      }else{
        $message = "权限模块删除失败！";
      }
      $this->alert($message, 'js', 3, $_ENV['PHP_SELF']);
    }
    
    function doGetUserModule(){
      $uid = $this->getValue('uid')->Int();
      $ret = $this->module->getUserModule($uid);
      print_r($ret);
    }
    
    function checkAuth(){
      global $adminauth, $login_uid;
      $adminauth->checkAuth($login_uid, 'sys_module', 102, 'W');
    }
  }
?>
