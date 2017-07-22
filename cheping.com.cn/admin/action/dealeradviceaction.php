<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class dealeradviceAction extends action{
    function __construct(){
      parent::__construct();
      $this->dealeradvice =new dealeradvice();
      $this->dealer=new dealer();
    }
    
    function doDefault(){
      $this->doDealerAdviceList();
    }
    
    //经销商反馈列表
    function doDealerAdviceList(){
      $this->checkLoginAuth();
      $this->page_title = " 经销商反馈";
      $template_name = "dealeradvice_list";
      $phpSelf = $_ENV['PHP_SELF'].'';
      $receiver = array( 'start_time', 'end_time');
      $receiverArr = receiveArray($receiver);

      $keyword = $_GET['keyword'] ? urldecode(trim($_GET['keyword'])) : $_POST['keyword'];
      $state = $_GET['state']=='0' ? $_GET['state'] : $_POST['state'];
      $start_time = $receiverArr['start_time'];
      $end_time = $receiverArr['end_time'];
      if(strpos($start_time,'-')){
          $start_time = strtotime($start_time);
      }
      if(strpos($end_time,'-')){
          $end_time = strtotime($end_time)+60*60*24;
      }

      $rkeyword = urldecode($keyword);
      $page = $_GET['page'];
      $page = max(1, $page);
      $page_size = 18;
      $page_start = ($page-1)*$page_size;
      $where=" 1 ";
      
      if($state!="" && isset ($state)) {
          $where.=" and state=$state";
          $this->tpl->assign('s', $state);
          $extra .= "&state=$state";
      }
      if(!empty($_POST["id"])) {
          $where.=" and id='".$_POST["id"]."'";
      }
      if($keyword) {
          $where .= " and message like '%{$keyword}%'";
          $extra .= "&keyword={$rkeyword}";
          $this->tpl->assign('keyword', $rkeyword);
      }
      if($start_time &&$end_time){
           $where .= " and created between $start_time  and $end_time";
           $extra .= "&start_time={$start_time}&end_time={$end_time}";
      }
      $advice = $this->dealeradvice->getAdviceList($where,array("id"=>"DESC"),$page_size,$page_start);
      if($advice){
          foreach($advice as $key=>$val){
              $id = $val['dealer_id'];
              $d = $this->dealer->getDetail($id);
              $advice[$key]['dealer_name'] = $d['dealer_name'];
          }
      }
      $page_bar = $this->multi($this->dealeradvice->total, $page_size, $page, $phpSelf. $extra,0,4);
      $this->tpl->assign('advice',$advice);
      $this->tpl->assign('phpSelf', $phpSelf);
      $this->tpl->assign('page_bar', $page_bar);
      $this->tpl->assign('start_time',$start_time);
      $this->tpl->assign('end_time',$end_time);
      $this->tpl->assign('advice',$advice);
      $this->tpl->assign('page', $page);
      $this->tpl->assign('page_title', $this->page_title);
      $this->tpl->display($template_name);
    }
    
    //经销商反馈
    function doDealerAdvice(){
      $this->checkLoginAuth();
      $this->page_title = "经销商反馈";
      $template_name = "dealeradvice";
      $phpSelf = $_ENV['PHP_SELF'];
      $id=$_GET['id'];
      if($id){
          $advice = $this->dealeradvice->getAdvice($id);
          $d = $this->dealer->getDetail($advice['dealer_id']);
          $advice['dealer_name'] = $d['dealer_name'];
          $this->dealeradvice->where = "id=$id";
          $this->dealeradvice->ufields=array('state' => 1);
          $this->dealeradvice->update();
          $this->tpl->assign('advice',$advice);
          $this->tpl->assign('phpSelf', $phpSelf);
          $this->tpl->assign('province',$pname);
          $this->tpl->assign('city',$cname);
      }
      if($_POST){
        $id=intval($_POST['id']);
        $answer = $_POST['answer'];

        $this->dealeradvice->where ="id=$id";
        $this->dealeradvice->ufields = array('answer'=>$answer,'state'=>1,'answertime'=>time());
        $this->dealeradvice->update();
        echo '<script>alert("回复成功！");location.href="index.php?action=dealeradvice-dealeradvicelist";</script>';die;
      }
      $this->tpl->assign('page_title', $this->page_title);
      $this->tpl->display($template_name);
    }

    
    function checkLoginAuth(){
      global $adminauth, $login_uid;
      $adminauth->checkAuth($login_uid, 'sys_module', 301, 'R');
    }

}

?>
