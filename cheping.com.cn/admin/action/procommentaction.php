<?php
  /**
  * pro comment action
  * $Id: procommentaction.php 1791 2016-03-24 08:40:44Z wangchangjiang $
  * @author David.Shaw
  */
  
  class proCommentAction extends action{
    var $factory;
    var $brand;
    var $series;
    
    function __construct(){
      global $adminauth, $login_uid;
      $adminauth->checkAuth($login_uid, 'sys_module', 205, 'A');
      
      parent::__construct();
      $this->factory = new factory();
      $this->brand = new brand();
      $this->series = new series();
    }
    
    function doDefault(){
      $this->doList();
    }
    
    function doList(){
      $this->tpl_file = "procomment_list";
      $this->page_title = "专家评论列表";
      $extra = $brand_id = $factory_id = $keyword = $rkeyword = null;
      
      $page = $_GET['page'];
      $father_id = $_GET['fatherId'];
      $extra = "&fatherId={$father_id}";
      
      $this->checkAuth($father_id, 'factory');
      
      $brand_id = $_GET['brand_id'] ? $_GET['brand_id'] : $_POST['brand_id'];
      $factory_id = $_GET['factory_id'] ? $_GET['factory_id'] : $_POST['factory_id'];
      $keyword = $_GET['keyword'] ? urldecode(trim($_GET['keyword'])) : $_POST['keyword'];
      $rkeyword = urldecode($keyword);
      
      $page = max(1, $page);
      $page_size = 20;
      $page_start = ($page-1)*$page_size;
      $where = "s.state=3 and f.state=3 and b.state=3 and s.brand_id=b.brand_id and f.factory_id=s.factory_id" . ($father_id ? " and s.factory_id='{$father_id}'" : "");
      if($factory_id){
        $where .= " and s.brand_id='{$brand_id}' and s.factory_id='{$factory_id}'";
        $extra .= "&brand_id={$brand_id}&factory_id={$factory_id}";
        
        $factory_list = $this->factory->getAllFactory("f.brand_id=b.brand_id and f.brand_id='{$brand_id}'", array('f.letter' => 'asc'), 100);
        
        $this->tpl->assign('factory_list', $factory_list);
        $this->tpl->assign('factory_id', $factory_id);
      }
      if($keyword){
        $where .= " and s.series_name like '%{$keyword}%'";
        $extra .= "&keyword={$rkeyword}";
      }
      
      $tmp = $this->series->getAllSeries($where, array('s.series_id' => 'asc'), $page_size, $page_start);
      foreach ($tmp as $k => $v) {
        $v['score_str'] =  $this->series->getScoreStr($v['score']);
        $list[] = $v;
      }
      $page_bar = $this->multi($this->series->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);
      
      $brand_list = $this->brand->getAllBrand("state=3", array('letter' => 'asc'), 300);
      
      $this->tpl->assign('page_title', $this->page_title);
      $this->tpl->assign('list', $list);
      $this->tpl->assign('brand', $brand_list);
      $this->tpl->assign('page_bar', $page_bar);
      $this->tpl->assign('brand_id', $brand_id);
      $this->tpl->assign('fatherId', $father_id);
      $this->tpl->assign('keyword', $keyword);
      $this->tpl->assign('rkeyword', $rkeyword);
      $this->template();
    }
    
    function doAdd(){
      $this->tpl_file = "procomment_add";
      $this->page_title = "添加车系评论";
      
      if($_POST){
        $id = $_POST['series_id'];
        $name = $_POST['series_name'];
        $pros = $_POST['pros'];
        $cons = $_POST['cons'];
        $intro = $_POST['series_intro'];
        $p1 = intval($_POST['p1']);
        $p2 = intval($_POST['p2']);
        $p3 = intval($_POST['p3']);
        $p4 = intval($_POST['p4']);
        $p5 = intval($_POST['p5']);
        $av_score = sprintf('%.1f', ($p1+$p2+$p3+$p4+$p5)/5 );
        $this->series->ufields = array(
          'series_intro' => $intro,
          'pros' => $pros,
          'cons' => $cons,
          'score' => "{$p1}||{$p2}||{$p3}||{$p4}||{$p5}||{$av_score}",
        );
        $this->series->where = "series_id='{$id}'";
        $ret = $this->series->update();
        
        if(!$ret){
          #var_dump($this->series->sql);exit;
          $this->alert("车系评论失败！", 'js', 3, $_ENV['PHP_SELF']);
        }else{
          $arr = array(
            'type' => 'confirm',
            'message' => "车系评论成功！是否要继续添加新车系评论信息？\\n按“确定”继续添加，“取消”返回车系评论信息列表。",
            'urly' => $_ENV['PHP_SELF'] . "add",
            'urln' => $_ENV['PHP_SELF'],
          );
          $this->alert($arr);
        }          
        
      }else{
        if($_GET['series_id']){
          $series = $this->series->getSeries($_GET['series_id']);
          $tmp = explode('||', $series['score']);
          $score = array(
            'p1' => $tmp[0],
            'p2' => $tmp[1],
            'p3' => $tmp[2],
            'p4' => $tmp[3],
            'p5' => $tmp[4],
            'av_score' => $tmp[5],
          );
          $this->tpl->assign('series', $series);
        }else{
          $score = array(
            'p1' => 0,
            'p2' => 0,
            'p3' => 0,
            'p4' => 0,
            'p5' => 0,
            'av_score' => 0,
          );
        }
        
        $brand = $this->brand->getAllBrand("state=3", array('letter' => 'asc'), 300);
        $this->tpl->assign('brand', $brand);
        $this->tpl->assign('score', $score);
        $this->template();
      }
    }
    
    function doEdit(){
      $this->doAdd();
    }
    
    function doDel(){
      
    }
    
    function checkAuth(){
      
    }
    
  }
?>
