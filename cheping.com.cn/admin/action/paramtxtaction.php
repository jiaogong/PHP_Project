<?php
  /**
  * paramtxt action
  * $Id: paramtxtaction.php 1792 2016-03-28 01:59:03Z wangchangjiang $
  * @author David.Shaw
  */
  class paramtxtAction extends action{
    var $paramtxt;
    var $paramtype;
    var $brand;
    var $factory;
    var $series;
    var $model;
    
    function __construct(){
      global $adminauth, $login_uid;
      $adminauth->checkAuth($login_uid, 'sys_module', 207, 'A');
      
      parent::__construct();
      $this->paramtxt = new paramtxt();
      $this->paramtype = new paramType();
    }
    
    function doDefault(){
      $this->doList();
    }
    
    function doList(){
      $this->tpl_file = "paramtxt_list";
      $this->page_title = "文本参数列表";
      $extra = "";
      $page = $_GET['page'];
      $page = max(1, $page);
      $page_size = 20;
      $page_start = ($page-1)*$page_size;
      $state = $_GET['state'] ? $_GET['state'] : $_POST['state'];
      
      $pcategory = $_GET['pcategory'] ? $_GET['pcategory'] : $_POST['pcategory'];
      $model_id = $_GET['model_id'] ? $_GET['model_id'] : $_POST['model_id'];
      $keyword = $_GET['keyword'] ? urldecode(trim($_GET['keyword'])) : $_POST['keyword'];
      $rkeyword = urldecode($keyword);
      
      $where = "pt.pt_id=3 and pt.state='{$state}'";
      if($state){
        $state = 1;
        $extra .= "&state={$state}";
      }else{
        $state = 0;
      }
      #$extra .= "pcategory={$pcategory}&model_id={$model_id}&keyword={$keyword}";
      if($pcategory){
        $extra .= "&pcategory={$pcategory}";
        $where .= " and pt.pid='{$pcategory}'";
      }
      
      if($model_id){
        $extra .= "&model_id={$model_id}";
        $where .= " and pt.model_id='{$model_id}'";
        
        $this->factory = new factory();
        $this->series = new series();
        $this->model = new cardbModel();
        
        $model_r = $this->model->getModel($model_id);
        $factory = $this->factory->getAllFactory("f.brand_id='{$model_r['brand_id']}' and f.brand_id=b.brand_id", array('f.letter' => 'asc'), 20);
        $series = $this->series->getAllSeries("s.factory_id='{$model_r['factory_id']}' and s.factory_id=f.factory_id and f.brand_id=b.brand_id", array('s.letter' => 'asc'), 20);
        $model = $this->model->getAllModel("m.series_id='{$model_r['series_id']}' and m.series_id=s.series_id and s.factory_id=f.factory_id and f.brand_id=b.brand_id and m.state=3", array(), 100);
        
        $this->tpl->assign('factory', $factory);
        $this->tpl->assign('series', $series);
        $this->tpl->assign('model', $model);
        $this->tpl->assign('model_r', $model_r);
      }
      
      if($keyword){
        $where .= " and pt.value like '%{$keyword}%'";
        $extra .= "&keyword={$rkeyword}";
      }
      
      $paramtype = $this->paramtype->getParamTypeByPid(3);
      
      $order = array("pt.id" => 'desc');
      
      $list = $this->paramtxt->getAllParamtxt($where, $order, $page_size, $page_start);
      $page_bar = $this->multi($this->paramtxt->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);
      
      $this->brand = new brand();
      $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
      
      $this->tpl->assign('brand', $brand);
      $this->tpl->assign('page_bar', $page_bar);
      $this->tpl->assign('paramtype', $paramtype);
      $this->tpl->assign('list', $list);
      $this->tpl->assign('pcategory', $pcategory);
      $this->tpl->assign('keyword', $keyword);
      $this->tpl->assign('rkeyword', $rkeyword);
      $this->tpl->assign('state', $state);
      $this->tpl->assign('extra', base64_encode($extra . "&page={$page}"));
      
      $this->template();
    }
    
    function doAdd(){
      $this->tpl_file = "paramtxt_add";
      $this->page_title = "文本参数内容添加";
      
      $this->brand = new brand();
      $this->factory = new factory();
      $this->series = new series();
      
      $paramtype = $this->paramtype->getParamTypeByPid(3);
      
      if($_POST){
        $model_id = $_POST['model_id'];
        
        $pid = $_POST['param_type'];
        $v = $_POST['paramtxt'];
          
        $this->paramtxt->where = "model_id='{$model_id}' and pid='{$pid}'";
        $this->paramtxt->fields = "count(id)";
        $cnt = $this->paramtxt->getResult(3);
        
        $pt = $this->paramtype->getParamType($pid);
        
        $this->paramtxt->ufields = array(
          'model_id' => $model_id,
          'pname' => $pt['name'],
          'pid' => $pt['id'],
          'pt_id' => $pt['pid'],
          'value' => $v,
          'state' => $_POST['state']
        );
        
        if($cnt){
          $this->paramtxt->update();
        }else{
          $this->paramtxt->insert();
        } 
        
        $this->alert('文本参数添加成功！', 'js', 3, $_ENV['PHP_SELF'] . "add");
      }else{
        $brand = $this->brand->getAllBrand(1, array('letter' => 'asc'), 200);
        $this->tpl->assign('list', $paramtype);
        $this->tpl->assign('brand', $brand);
        $this->template();
      }
      
    }
    
    function doEdit(){
      $this->tpl_file = "paramtxt_edit";
      $this->page_title = "文本参数内容修改";
      
      $this->brand = new brand();
      $this->factory = new factory();
      $this->series = new series();
      $this->model = new cardbModel();
      $paramtype = $this->paramtype->getParamTypeByPid(3);
      
      if($_POST['id']){
        $extra = base64_decode($_POST['extra']);
        $this->paramtxt->ufields = array(
          'value' => $_POST['val']
        );
        $this->paramtxt->where = "id='{$_POST['id']}'";
        $ret = $this->paramtxt->update();
        
        $pt = $this->paramtxt->getParamtxt($_POST['id']);
        if($ret){
          $msg = "成功";
        }else{
          $msg = "失败";
        }
        $this->alert("文本参数更新{$msg}！", 'js', 3, $_ENV['PHP_SELF'] . '&' . $extra);
      }else{
        $id = $_GET['id'];
        
        $px = $this->paramtxt->getParamtxt($id);
        $px_model = $this->model->getModel($px['model_id']);
        $px_val = $this->paramtxt->getParamtxtByModel($px['model_id']);
        
        
        $this->tpl->assign('paramtxt', $px);
        $this->tpl->assign('px_val', $px_val);
        $this->tpl->assign('model', $px_model);
        $this->tpl->assign('list', $paramtype);
        $this->tpl->assign('extra', $_GET['extra']);
        $this->template();
      }
    }
    
    function doDel(){
      $id = $_GET['id'];
      $this->paramtxt->where = "id='{$id}'";
      $ret = $this->paramtxt->del();
      if($ret){
        $msg = "成功";
      }else{
        $msg = "失败";
      }
      $this->alert("文本参数删除{$msg}！", 'js', 3, $_ENV['PHP_SELF']);
    }
  }
?>
