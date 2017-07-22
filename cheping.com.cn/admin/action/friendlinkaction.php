<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class friendlinkAction extends action{
    var $page=array( #页面
            "1"=>"产品库首页"
        );
    var $link_type=array(
        "1"=>"友情链接",
        "2"=>"合作伙伴"
    );

    function __construct(){
      $this->checkAuth(802, 'sys_module', 'A');
      $this->friendlink = new cp_friendlink();
      parent::__construct();
    }

    function doDefault(){
      $this->tpl_file = "cp_friendlink";
      $this->page_title = "友情链接";
      $pagetype = intval($_POST["pagetype"]) ? intval($_POST["pagetype"]) : 1;
      $type = intval($_POST["type"]) ? intval($_POST["type"]) : 1;
      if($pagetype && $type){
           $this->friendlink->order = array("queen"=>"ASC","id"=>"DESC");
           $this->friendlink->where = "pagetype='$pagetype' and type='$type'";
           $list = $this->friendlink->getResult(2);
           $this->tpl->assign('list', $list);
           $this->tpl->assign('types', $type);
           $this->tpl->assign('pagetypes', $pagetype);
      }elseif($pagetype && !$type){
          $this->friendlink->order = array("queen"=>"ASC","id"=>"DESC");
          $this->friendlink->where = "pagetype='$pagetype'";
          $list = $this->friendlink->getResult(2);
          $this->tpl->assign('list', $list);
          $this->tpl->assign('pagetypes', $pagetype);
      }elseif(!$pagetype && $type){
          $this->friendlink->order = array("queen"=>"ASC","id"=>"DESC");
          $this->friendlink->where = "type='$type'";
          $list = $this->friendlink->getResult(2);
          $this->tpl->assign('list', $list);
          $this->tpl->assign('types', $type);
      }

      $this->tpl->assign('pagetype', $this->page);
      $this->tpl->assign('type', $this->link_type);
      $this->tpl->assign('page_title', $this->page_title);

      $this->template();
    }

    function doAddLink(){
        $this->tpl_file = "cp_friendlinkadd";
        $this->page_title = "添加链接";
        
        if($_POST){
            $ufields = array();
            $ufields["name"] = $_POST["name"];
            $ufields["link"] = $_POST["link"];
            $ufields["pagetype"] = $_POST["page"];
            $ufields["queen"] = $_POST["queen"];
            $ufields["state"] = $_POST["state"];
            $ufields["type"] = $_POST["type"];
            $ufields["nofollow"] = $_POST["nofollow"];
            $ufields["created"] = time();
            $this->friendlink->ufields = $ufields;
            $msg = "";
            if($_POST["id"]){
                $id = intval($_POST["id"]);
                $this->friendlink->where = "id='$id'";
                $ret = $this->friendlink->update();
                if($ret){
                    $msg = "修改成功!";
                }else{
                    $msg = "修改失败!";
                }
            }else{
                $id = $this->friendlink->insert();
                if($id){
                    $msg = "添加成功!";
                }else{
                    $msg = "添加失败!";
                }
            }

            //图片
            $filename = "";
            if($_FILES["pic"]&&$id){
                $brand_file_path = ATTACH_DIR."images/friendlink/";
                @file::forcemkdir($brand_file_path);
                $filename = $id.".".file::extname($_FILES['pic']['name']);
                //移动文件
                $mret = move_uploaded_file($_FILES['pic']['tmp_name'], $brand_file_path.$filename);
                if($mret){
                    $this->friendlink->ufields = array("pic"=>$filename);
                    $this->friendlink->where = "id='$id'";
                    $ret = $this->friendlink->update();
                }
            }
            $this->doDefault();
            echo "<script>alert('$msg');</script>";exit;
        }else if($_GET["id"]){
            $id = intval($_GET["id"]);
            $this->friendlink->where = "id='$id'";
            $link = $this->friendlink->getResult(1);
            $this->tpl->assign('link', $link);
        }

        $this->tpl->assign('pagetype', $this->page);
        $this->tpl->assign('page_title', $this->page_title);

        $this->template();
        
    }
    
    function doDel(){
        $id = $_GET['id'];
        $this->friendlink->where = "id={$id}";
        $r = $this->friendlink->del();
        
        if($r){
            $msg = "成功";
        }else{
            $msg = "失败";
        }
        $message = array(
            'type' => 'js',
            'act' => 3,
            'message' => "友情链接删除{$msg}!",
            'url' => $_ENV['PHP_SELF']
        );
        $this->alert($message);
    }

    function doImgCode() {
        echo "<img width=80 height=60 src='" . RELAT_DIR . UPLOAD_DIR . urldecode(base64_decode($_GET['code'])) . "'>";
        exit;
    }

    //生成首页 友情链接
    function doSsi_Indexlink(){
        $this->tpl_file = "ssi_cpindexlink";

        $this->friendlink->order = array("queen"=>"ASC","id"=>"DESC");
        $this->friendlink->where = "pagetype='1' and state=2";
        $list = $this->friendlink->getResult(2);
        $this->tpl->assign('linklist', $list);
        $html = $this->fetch($this->tpl_file);
        $html = $this->replaceAttachServer($html);
        echo $html;
    }

    function checkAuth($id, $module_type = 'sys_module', $type_value = "A"){
      global $adminauth, $login_uid;
      $adminauth->checkAuth($login_uid, $module_type, $id, 'A');
    }
    
}