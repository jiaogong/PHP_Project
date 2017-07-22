<?php

/**
 * $Id: counteraction.php 1136 2015-11-02 05:52:18Z wangqin $
 */
class counterAction extends action {

    function __construct() {
        parent::__construct();
       
        $this->counter = new counter();
        $this->pagedate = new pageData();
        $this->category = new category();
   
    }

    function doDefault() {
        $this->dolist();
    }

  
    function dolist() {
        $this->doArticle();
    }
    //每隔14天计算一下文章的浏览记录
    function doArticle(){
        $arr = array("1"=>"article","2"=>"video");
        $arrname =array("1"=>"文章",2=>"视频");
        foreach($arr as $k=>$v){
                $day = date("Ymd",time());
                $dayend = strtotime($day);
                $daystart = $dayend-3600*24*15-1;    
                $fields ="*,sum(pv) as pv_num";
                $limit =10;
                $order =array("pv"=>"desc");
                $group = "c3";
                $where ="cname='$v' and timeline between $daystart  and $dayend ";
            $list =  $this->counter ->getArticlelist($fields,$where,2,$order,$group,$limit);
                $this->pagedate ->ufields =array(
                    "name"=>"$v",
                    "value"=>  serialize($list),
                    "created"=>time(),
                    "updated"=>time(),
                    'notice'=>"$arrname[$k] 的浏览记录统计",
                );
                $id =  $this->pagedate ->getSomePagedata("id","name='$v'",3);
                if($id){
                    $this->pagedate ->where="name='$v'";
                    unset($this->pagedate ->ufields['created']);
                    $this->pagedate ->update();
                }else{
                    $this->pagedate ->insert();
                }

        }
       
    }
   
     //每隔14天计算一下频道浏览记录
     function doevalu(){
         $arr =array("1"=>"evalu",2=>"shopping");
         $arrname =array("1"=>"车评",2=>"导购");
         $article_id_str ='';
         //要排除的内容
         $parr = array(1=>"article",2=>"video");
         foreach($parr as $K=>$v){
             $value =  $this->pagedate ->getSomePagedata("value","name='$v'",3);
             $content = unserialize($value);
             foreach($content as  $kk=>$vv){
                 $article_id_str .=$vv[c3].',';
             }
         }
         
         $article_id_str = rtrim($article_id_str,',');
         
         foreach($arrname as $k=>$v){
            $c1= $this->category->getlist("id","category_name='$v' and parentid=0 and state=1",3);
            $day = date("Ymd",time());
            $dayend = strtotime($day);
            $daystart = $dayend-3600*24*15-1;    
            $fields ="*,sum(pv) as pv_num";
            $limit =2;
            $order =array("pv"=>"desc");
            $group = "c1";
            $where ="cname='article' and c3 not in($article_id_str) and  timeline between $daystart  and $dayend ";
            $list =  $this->counter ->getArticlelist($fields,$where,2,$order,$group,$limit);
            $this->pagedate ->ufields =array(
                    "name"=>"$arr[$k]",
                    "value"=>  serialize($list),
                    "created"=>time(),
                    "updated"=>time(),
                    'notice'=>"$v 频道浏览记录统计",
                );
                $id =  $this->pagedate ->getSomePagedata("id","name='$arr[$k]'",3);
                if($id){
                    $this->pagedate ->where="name='$arr[$k]'";
                    unset($this->pagedate ->ufields['created']);
                    $this->pagedate ->update();
                }else{
                    $this->pagedate ->insert();
                }
         }
     }
     
     //每隔14天计算一下标签的浏览记录
     function doTag(){
         
            $day = date("Ymd",time());
            $dayend = strtotime($day);
            $daystart = $dayend-3600*24*15-1;    
            $fields ="*,sum(pv) as pv_num";
            $limit =20;
            $order =array("pv"=>"desc");
            $group = "c2";
            $where ="cname='tag' and   timeline between $daystart  and $dayend ";
            $list =  $this->counter ->getArticlelist($fields,$where,2,$order,$group,$limit);
            $this->pagedate ->ufields =array(
                    "name"=>"tag",
                    "value"=>  serialize($list),
                    "created"=>time(),
                    "updated"=>time(),
                    'notice'=>"标签浏览记录统计",
                );
                $id =  $this->pagedate ->getSomePagedata("id","name='tag'",3);
                if($id){
                    $this->pagedate ->where="name='tag'";
                    unset($this->pagedate ->ufields['created']);
                    $this->pagedate ->update();
                }else{
                    $this->pagedate ->insert();
                }
     }
    
    //每天取十条访问量最多的文章和视频存入counter表
    function doArticleNum(){
        $arr = array(1=>"article",2=>"video");
        foreach($arr as $k=>$v){
                $day = date("Ymd",time());
                $daystart = strtotime($day);
                $dayend = $daystart+3600*24-1;
                $fields ="*,count(c3) as pv";
                $limit =10;
                $order =array("pv"=>"desc");
                $group = "c3";
                $where ="cname='$v' and timeline between $daystart  and $dayend ";
                $list =  $this->counter ->getwherelist($fields,$where,2,$order,$group,$limit,$day);

                if($list){
                    foreach($list as $key=>$value){
                        unset($value['os']);
                        unset($value['browser']);
                        unset($value['sid']);
                        $ufields =$value;    
                        $this->counter->addCounter($ufields); 
                    }
                }
        }
     

    }
    
       //每天取十条访问量最多的标签存入counter表
    function doTagNum(){
  
                $day = date("Ymd",time());
                $daystart = strtotime($day);
                $dayend = $daystart+3600*24-1;
                $fields ="*,count(c2) as pv";
                $limit =20;
                $order =array("pv"=>"desc");
                $group = "c2";
                $where ="cname='tag' and timeline between $daystart  and $dayend ";
                $list =  $this->counter ->getwherelist($fields,$where,2,$order,$group,$limit,$day);
                if($list){
                    foreach($list as $key=>$value){
                        unset($value['os']);
                        unset($value['browser']);
                        unset($value['sid']);
                        $ufields =$value;    
                        $this->counter->addCounter($ufields); 
                    }
                }
    }
 
 
    function checkAuth($id, $module_type = 'sys_module', $type_value = "A") {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, $module_type, $id, 'A');
    }

}

?>
