<?php
  /**
  * $Id: seriestypeAction.php 2421 2013-08-13 02:56:16Z 
  */
  
  
  class seriestypeAction extends action{


    function __construct(){
      parent::__construct();
      $this->seriestype = new seriestype();
      $this->brand = new brand();
      $this->series = new series();
      $this->factory = new factory();

    }
    
    function doDefault(){
      $this->doSeriesList();
    }
    function doSeriesList() {
        $tpl_name = "seriestype";
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $this->tpl->assign('brand', $brand);
        $series_type = $this->seriestype->series_type;
       // var_dump($_POST);
       // 统计
       $seriestype = $this->seriestype->getseriesTypelist("*","series_id<>0",2);

       $type1 =$type2 =$type3 =$type4=0;
       foreach($seriestype as $key=>$value){
           if($value['type1']==1||$value['type2']==1||$value['type3']==1||$value['type4']==1||$value['type5']==1){
               $type1 ++; 
           }
           if($value['type1']==2||$value['type2']==2||$value['type3']==2||$value['type4']==2||$value['type5']==2){
               $type2 ++; 
           }
           if($value['type1']==3||$value['type2']==3||$value['type3']==3||$value['type4']==3||$value['type5']==3){
               $type3 ++; 
           }
           if($value['type1']==4||$value['type2']==4||$value['type3']==4||$value['type4']==4||$value['type5']==4){
               $type4 ++; 
           }
         
       }
      $this->vars('type1', $type1);
      $this->vars('type2', $type2);
      $this->vars('type3', $type3);
      $this->vars('type4', $type4);
        $where ="cs.state=3 ";
        if($_REQUEST['brand_id']){
           $where .=" and cs.brand_id =$_REQUEST[brand_id]"; 
           $this->vars('brand_id', $_REQUEST['brand_id']);
        }
        if($_REQUEST['state']==10){
            $where .=" and (cst.type1 <1 and cst.type2 <1 and cst.type3 <1 and cst.type4 <1 and cst.type5 <1 )"; 
            $this->vars('state', $_REQUEST['state']);
        }
        if($_REQUEST['state']&&$_REQUEST['state']!=10){
            $where .=" and (cst.type1 =$_REQUEST[state] or cst.type2 =$_REQUEST[state] or cst.type3 =$_REQUEST[state] or cst.type4 =$_REQUEST[state] or cst.type5 =$_REQUEST[state] )"; 
            $this->vars('state', $_REQUEST['state']);
        }
        if($_REQUEST['series_name']){
           $where .=" and cs.series_name like '%$_REQUEST[series_name]%'"; 
           $this->vars('series_name', $_REQUEST['series_name']);
        }
        $where .=" order by cs.brand_id asc";
        $result =$this->series->getSeriesType($where);
        $this->vars('result', $result);
      //  echo $this->series->sql;
       // var_dump($result);
        $this->vars('series_type', $series_type);
        $this->template($tpl_name);
    }
    
    function doUpdate(){
        $ret ="";
        if($_REQUEST['brand_id']){
           $ret .="&brand_id=$_REQUEST[brand_id]"; 
           
        }
        if($_REQUEST['state']){
            $ret .="&state=$_REQUEST[state]"; 
           
        }
        if($_REQUEST['series_name']){
           $ret .="&series_name=$_REQUEST[series_name]";  
         
        }
        $type1 =$_POST['type1'];
        $type2 =$_POST['type2'];
        $type3 =$_POST['type3'];
        $type4 =$_POST['type4'];
        $type5 =$_POST['type5'];
        foreach($type1 as $key=>$value){
            $arr = $this->series->getSeriesdata("brand_id,factory_id","series_id=$key",1);
       
            $this->seriestype->ufields = array(
                'series_id' => $key,
                'brand_id' => $arr['brand_id'],
                'factory_id' => $arr['factory_id'],
                'type1' => $value,
                'type2' => $type2[$key],
                'type3' => $type3[$key],
                'type4' => $type4[$key],
                'type5' => $type5[$key]
                );
            $str = $this->seriestype->getseriesTypelist("id","series_id=$key",3);
            if($str){
                $this->seriestype->where="id=$str";
                $this->seriestype->update();
            }else{
                $this->seriestype->insert(); 
            }
           
        }
        
        $this->alert("修改完成", 'js', 3, $_ENV['PHP_SELF'].$ret);
    }
      
  //导入配置排序
   function  doSeriesimportant(){
       $template_name ="seriestype_important";
       $this->template($template_name);
   }
   //导出
   function doSerieslive(){
        set_time_limit(0);
        //$dir = SITE_ROOT.'data/model';
       // file::forcemkdir($dir);
       // @unlink(SITE_ROOT.'data/model/sereistype.csv');
        $serieslist = $this->seriestype->getSeriesType("cs.state=3");
        $title1 ="品牌,厂商,车系,缩写,家用舒适,个性运动,商务行政,SUV/MPV";
        $str =$title1."\n";
        foreach($serieslist as $key=>$value){
           $str .=$value['brand_name'].','.$value['factory_name'].','.$value['series_name'].','.$value['series_alias'].','.$value['type1'].','.$value['type2'].','.$value['type3'].','.$value['type4'].',';
    
           rtrim($str,',');
           $str .= "\n";
        }

        //@file_put_contents(SITE_ROOT.'data/model/sereistype.csv', $str, FILE_APPEND);
        Header("Content-type: application/vnd.ms-excel");
        Header("Content-Disposition: attachment; filename= sereistype.csv");
      //  trim($str);
        echo $str;
   }
    //导入
     function  doSeriesimportantList(){

        set_time_limit(0);
        $uploadName = 'dealer_price';
        $ext = end(explode('.', $_FILES[$uploadName]['name']));
        if ($ext != 'csv')
                $this->alert('文件类型不正确,请上传csv文件！', 'js', 3, $_ENV['PHP_SELF'] . 'Seriesimportant');
        $groupbuy = new groupbuy();
        $dir = 'dealerprice';
        $path = $groupbuy->uploadPic($uploadName, $dir);
        $str = file_get_contents(ATTACH_DIR . 'images/' . $path);
        //var_dump($str);exit;
        $arr = explode("\r\n", $str);
        array_pop($arr);
        $type = $_POST['type'];
        if($type==1){
             foreach ($arr as $key=>$row)
            {
                    $dprice = explode(',', $row);
                    if($key==0){
                         if (($dprice[0] != '品牌' && $dprice[2] != '车系'))
                        {
                                
                                $this->alert("导入配置排序的格式有误，请检查后重试", 'js', 3, $_ENV['PHP_SELF'] . 'Seriesimportant');
                        }
                    }

                    if (empty($dprice[0]))
                            continue;
                    if ($dprice[0]=='品牌')
                           continue;
                    $series_list =$this->series->getSeriesdata("series_id,factory_id,brand_id,s3,brand_name,series_name","brand_name='$dprice[0]' and series_name='$dprice[2]' and state=3",1);

                    if($series_list){
                         if($dprice[7]==1||$dprice[7]==4){
                              $type4=4;
                          }else{
                              if($series_list['s3']=='SUV'||$series_list['s3']=='MPV'){
                                $type4=4;
                                }else{
                                    $type4='';
                                }
                          }                     
                          if($dprice[4]==1){
                              $type1=1;
                          }else{
                              $type1='';
                          }
                          if($dprice[5]==1||$dprice[5]==2){
                              $type2=2;
                          }else{
                              $type2='';
                          }
                          if($dprice[6]==1||$dprice[6]==3){
                              $type3=3;
                          }else{
                              $type3='';
                          }
                         
                          $this->seriestype->ufields=array(
                              "series_id"=>$series_list['series_id'],
                              "brand_id"=>$series_list['brand_id'],
                              "factory_id"=>$series_list['factory_id'],
                              "type1"=>$type1,
                              "type2"=>$type2,
                              "type3"=>$type3,
                              "type4"=>$type4,
                              );
                
                    $id = $this->seriestype->getseriesTypelist("id","series_id=$series_list[series_id]",3);           
                    if($id){
                         $this->seriestype->where="id=$id";
                         $this->seriestype->update();
                        
                    }else{
                        $this->seriestype->insert();
                    }
                    
                }
                   

                   
            }
        }elseif($type==2){
             foreach ($arr as $key=>$row)
            {
                    $dprice = explode(',', $row);
                    if($key==0){
                         if (($dprice[0] != '品牌' && $dprice[1] != '品牌缩写'))
                        {
                                
                                $this->alert("导入配置排序的格式有误，请检查后重试", 'js', 3, $_ENV['PHP_SELF'] . 'Seriesimportant');
                        }
                    }

                    if (empty($dprice[0]))
                            continue;
                    if ($dprice[1]=='品牌缩写')
                           continue;
                    $brand_id =$this->brand->getBrandlist("brand_id","brand_name='$dprice[0]' and state=3",3);
                    
                    if($brand_id){    
                          $this->brand->ufields=array("brand_alias"=>$dprice[1]);
                          $this->brand->where ="brand_id=$brand_id";
                          $this->brand->update();
                    }
                    
            }
        }elseif($type==3){
             foreach ($arr as $key=>$row)
            {
                    $dprice = explode(',', $row);
                    if($key==0){
                         if (($dprice[1] != '厂商' && $dprice[2] != '厂商缩写'))
                        {
                                
                                $this->alert("导入配置排序的格式有误，请检查后重试", 'js', 3, $_ENV['PHP_SELF'] . 'Seriesimportant');
                        }
                    }

                    if (empty($dprice[0]))
                            continue;
                    if ($dprice[2]=='厂商缩写')
                           continue;
                    $factory_id =$this->factory->getFactorylist("factory_id","brand_name='$dprice[0]' and factory_name='$dprice[1]' and state=3",3);
                    
                    if($factory_id){    
                           $this->factory->ufields=array("factory_alias"=>$dprice[2]);
                           $this->factory->where ="factory_id=$factory_id";
                           $this->factory->update();
                    }
                    
            }
        }elseif($type==4){
             foreach ($arr as $key=>$row)
            {
                    $dprice = explode(',', $row);
                    if($key==0){
                         if (($dprice[0] != '品牌' && $dprice[2] != '车系'))
                        {
                                
                                $this->alert("导入配置排序的格式有误，请检查后重试", 'js', 3, $_ENV['PHP_SELF'] . 'Seriesimportant');
                        }
                    }

                    if (empty($dprice[0]))
                            continue;
                    if ($dprice[3]=='缩写')
                           continue;
                     $series_id =$this->series->getSeriesdata("series_id","brand_name='$dprice[0]' and series_name='$dprice[2]' and state=3",3);
                    
                    if($series_id){    
                          $this->series->ufields=array("series_alias"=>$dprice[3]);
                          $this->series->where ="series_id=$series_id";
                         $this->series->update();
                    }
                    
            }
        }
       

       $this->doSeriesList();
   }
  }
?>