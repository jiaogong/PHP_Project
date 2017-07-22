<?php
  /**
  * $Id: staticaction.php 2421 2013-08-13 02:56:16Z 
  */
  
  
  class preferCarAction extends action{


    function __construct(){
      parent::__construct();
      $this->cardbmodel = new cardbModel();
      $this->brand = new brand();
      $this->series = new series();
      $this->factory = new factory();
      $this->oldcarval = new oldCarVal();
      $this->priceerrorlog = new priceerrorlog();
     
    }
    
    function doDefault(){
      $this->doPreferList();
    }
    function doPreferErrorlog() {
      $where = 'type = 1';
      $page = max($_GET['page'], 1);
      $limit = 20;
      $offset = ($page - 1) * $limit;
      $creator = $_POST['creator'] ? $_POST['creator'] : $_GET['creator'];
      if($creator) $where .= " AND creator = '$creator'";
      $startTime = $_POST['start_time'] ? $_POST['start_time'] : $_GET['start_time'];
      $endTime = $_POST['end_time'] ? $_POST['end_time'] : $_GET['end_time'];
      if($startTime) {
        $startDate = strtotime($startTime);
        $where .= " AND created >= $startDate";
      }
      if($endTime) {
        $endDate = strtotime($endTime);
        $where .= " AND created <= $endDate";
      }
      $list = $this->priceerrorlog->getErrorlog($where, array('created' => 'DESC'), $offset, $limit);
      $page_bar = $this->multi($list['total'], $limit, $page, 'index.php?action=prefercar-prefererrorlog&creator=' . $creator . '&start_time=' . $startTime . '&end_time=' . $endTime);      
      $tpl_name = 'prefer_errorlog';
      $this->vars('result', $list['res']);
      $this->vars('page_bar', $page_bar);
      $this->template($tpl_name);
    }
    function doPreferList() {
        $tpl_name ="prefer_list";
        $page = $_GET[page]?$_GET[page]:1;
        $page_size =20;
        $page_state =($page-1)*$page_size;
        $where = 1;
        if($_REQUEST[factory_name]){
            $factory_name=trim($_REQUEST[factory_name]);
            $where .=" and factory_name like '%$factory_name%'";
            $this->vars("factory_name", $factory_name);
            $extra .="&factory_name=".$factory_name;
        }
        if($_REQUEST[model_name]){
            $model_name=trim($_REQUEST[model_name]);
            $where .=" and model_name like '%$model_name%'";
            $this->vars("model_name", $model_name);
            $extra .="&model_name=".$model_name;
        }
        if($_REQUEST[series_name]){
            $series_name=trim($_REQUEST[series_name]);
            $where .=" and series_name like '%$series_name%'";
            $this->vars("series_name", $series_name);
            $extra .="&series_name=".$series_name;
        }

         if($_REQUEST[model_price]){

            if($_REQUEST[model_price]=='10'){
                $where .=" and model_price<$_REQUEST[model_price]";
            }elseif($_REQUEST[model_price]==30) {
                $where .=" and model_price>$_REQUEST[model_price]";
            }else{
                 $model_price = explode('-', $_REQUEST[model_price]);
                 $where .=" and model_price>$model_price[0] and model_price<$model_price[1]";
            }
            $this->vars("model_price", $_REQUEST[model_price]);
            $extra .="&model_price=".$_REQUEST[model_price];
        }
         if($_REQUEST[car_prize]){
            $car_prize = explode('-', $_REQUEST[car_prize]);
            $where .=" and car_prize>$car_prize[0] and car_prize<$car_prize[1]";
            $this->vars("car_prize", $_REQUEST[car_prize]);
            $extra .="&car_prize=".$_REQUEST[car_prize];
        }
        $total = $this->oldcarval->getOlds("count(id)",$where,3);
        $arr = $this->oldcarval->getList("*",$where,$page_state,$page_size);
        //echo $this->oldcarval->sql;
        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'].'PreferList&' . $extra);
        $this->vars("extra",$extra);
        $this->vars("list",$arr);
        $this->vars('page_bar', $page_bar);
        $this->template($tpl_name);
    }
      
     function doPreferUpdate(){
         if($_POST){
                 $modelArr = $this->cardbmodel->getSimp("factory_name,series_name,model_name,model_price","model_id=$_POST[model_id]",1);
                 $ufields=array(
                    "factory_name"=>$modelArr[factory_name],
                    "model_name"=>$modelArr[model_name],
                    "series_name"=>$modelArr[series_name],
                    "model_price"=>$modelArr[model_price],
                     "car_prize"=>$_POST[car_prize],
                     "start_date"=>strtotime($_POST[start_date]),
                     "end_date"=>strtotime($_POST[end_date]),
                     "model_id"=>$_POST[model_id]
                 );
                if($_POST[id]){
                      $ufields[updated]=time();
                      $r = $this->oldcarval->updateOlds($ufields,$_POST[id]);
                      if($r){
                          $this->alert('操作成功', 'js', 3,$_ENV['PHP_SELF'].'PreferList&' . $_POST[url]);
                      }else{
                         $this->alert('操作失败，请查看所选的是否为车款', 'js', 2);
                      }
                }else{
                      $ufields[created]=time();
                      $r = $this->oldcarval->addOlds($ufields);
                      if($r){
                          $this->alert('添加成功', 'js', 3,$_ENV['PHP_SELF'].'PreferList&' . $_POST[url]);
                      }else{
                         $this->alert('添加失败，请查看所选的是否为车款', 'js', 2);
                      }
                }

           }else{
                $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
                $this->tpl->assign('brand', $brand);
                $tpl_name ="prefer_update";
                
                if($_GET[id]){
                   $id=$_GET[id];
                   $url=$_GET[url];
                   $title_name ="数据编辑";
                   $list = $this->oldcarval->getOlds("*","id=$id",1);
                   if($list[model_id]){
                       $modellist = $this->cardbmodel ->getSimp("brand_id,factory_id,series_id","model_id=$list[model_id]",1);
                       $factory = $this->factory->getFactorylist("factory_id,factory_name","brand_id=$modellist[brand_id] and state=3",2);
                       $series = $this->series->getSeriesFields("series_id,series_name","factory_id=$modellist[factory_id] and state=3",2);
                       $model = $this->cardbmodel->chkModel("model_id,model_name","series_id=$modellist[series_id] and state=3",'',2);
                       $this->vars("modellist", $modellist);
                       $this->vars('factory',$factory);
                       $this->vars('series',$series);
                       $this->vars('model',$model);
                   }
                   $this->vars('url',$url);
                }else{
                    $title_name ="数据添加";
                }
               $this->vars('title_name',$title_name);
         }
       
         
         $this->vars('list',$list);
         $this->template($tpl_name);
         
     }
     
    
     function doPreferAdd(){
        global $timestamp;
         $tpl_name ="prefer_add";
         if($_FILES){
               set_time_limit(0);
               $name = "prefer_list";
               $ext = end(explode('.', $_FILES[$name]['name']));
               if($ext != 'csv'){
                  $this->alert('文件类型不正确,请上传csv文件！', 'js', 3, $_ENV['PHP_SELF'] . 'PreferAdd');
               }else{
                    $groupbuy = new groupbuy();
                    $dir = 'prefer';
                    $path = $groupbuy->uploadPic($name, $dir);
                    $str = file_get_contents(ATTACH_DIR . 'images/' . $path);
                    $arr = explode("\n", $str);
                    array_pop($arr);
                    //array_shift($arr);
                    $column = array('厂商名称', '车款名称', '厂商指导价', '奖励金额', '有效期', '品牌', '厂商', '车系', '车款', '车款ID');
                    $update =$add =$false =0;
                    $falseList='';         
                    if(!empty($arr)) {
                      foreach($arr as $key=>$value){
                          $str = explode(',', $value);
                          if($key==0){
                            foreach($column as $k => $v) {
                              if(trim($str[$k]) != $v) $this->alert('表格格式不对，本次操作没有新增和修改任何数据', 'js', 3, $_ENV['PHP_SELF'] . 'PreferAdd');
                            }
                            continue;
                          }
                          
                          $modelPrice = str_replace('万元', '', $str[2]);
                          $car_prize=str_replace('元','',$str[3]);
                          $timeArr = explode('至', $str[4]);
                          $start_date=strtotime($timeArr[0]);
                          $end_date=strtotime($timeArr[1]);
                          $factory_name = trim($str[6]);
                          $series_name = trim($str[7]);
                          $model_name = trim($str[8]);
                          $errUfields = array(
                            'csv_name' => $_FILES[$name]['name'],
                            'creator' => session('username'),
                            'excel_row' => $key + 1,
                            'created' => $timestamp,
                            'type' => 1
                          );
                          $ifContinue = false;
                          for($i=0; $i<7; $i++) {
                            if(!$str[$i]) {
                              $errUfields['content'] = 'CSV每列内容不能为空';
                              $this->priceerrorlog->insertErrorLog($errUfields);
                              $ifContinue = true;
                              break;
                            }
                          }
                          if($ifContinue) continue;
                          $modellist = $this->cardbmodel->chkModel('brand_name,factory_name,series_name,model_name,model_price,model_id', "state in (3, 7, 8) and model_id=$str[9]", array(), 1);
                         // var_dump($modellist);
                          if(!$modellist) {
                            $errUfields['content'] = '车系车款厂商指导价与本站对应失败';
                            $this->priceerrorlog->insertErrorLog($errUfields);
                            $ifContinue = true;
                          }
                          if($ifContinue) continue;

                          $ufields=array(
                              "car_prize"=>$car_prize,
                              "start_date"=>$start_date,
                              "end_date"=>$end_date, 
                           );
                            
                          if($modellist){
                              $ufields[model_price]=$modellist[model_price];
                              $ufields[brand_name]=$modellist[brand_name];
                              $ufields[model_name]=$modellist[model_name];
                              $ufields[factory_name]=$modellist[factory_name];
                              $ufields[series_name]=$modellist[series_name];
                              $ufields[model_id]=$modellist[model_id];
                              //$r = $this->oldcarval->getolds("id","car_prize=$car_prize and model_id=$model_id",3);
                              $r = $this->oldcarval->getolds("id","model_id=$modellist[model_id] AND start_date = $start_date AND end_date = $end_date",3);
                              if($r){
                                  //$ufields[updated]=time();
                                  //$this->oldcarval->updateOlds($ufields,$r);
                                  //++$update;
                                  $errUfields['content'] = '该条为重复数据';
                                  $this->priceerrorlog->insertErrorLog($errUfields);
                              }else{
                                  $ufields[updated]=$ufields[created] =time();
                                  $this->oldcarval->addOlds($ufields);
                                  ++$add;
                              }
                           }
                           
                          }
                        
                    }
                     // $content = "导入完成：修改".$update."条；增加".$add."条；出错".$false."条。出错列表:".$falseList;
                      $content = "导入完成：修改".$update."条；增加".$add."条";
                     // echo $content;exit;
                     $this->alert($content, 'js', 3, $_ENV['PHP_SELF'] . 'Preferlist');
                   
               }
             
         }
        
         $this->template($tpl_name);
     }
    /**
     * 抓取北京老旧机车淘汰管理数据
     */

     function doGetprefer(){
            include SITE_ROOT.'lib/webclient.class.php';
            set_time_limit(0);
            $url = "http://bjtgc.cbeex.com.cn/icar/user/prefer-car-list.action";
            $catchData = new CatchData();
            $catchData->catchResult($url);
            $catchData->result = iconv('utf-8','gbk', $catchData->result);
            $str = "厂商名称,车款名称,厂商指导价,奖励金额,有效期"."\n";
            $pages = $catchData->pregMatch('/>(\d+)<\/option>\s*<\/select>/sim');
            $page = $pages[1][0];

            for($i=1;$i<$page;$i++){
                //取分页
                $catchData->setPostVars(array('page.pageNo' => $i,'select'=>"$i","PreferMoney"=>"qxz","SellPrice"=>"qxz"));
                $catchData->catchResult($url);
                $catchData->result = iconv('utf-8','gbk', $catchData->result);
                $factorys = $catchData->pregMatch('/<tr>\s*<td align="center"[^>]*>([^<]+)<\/td>/sim');
                $models = $catchData->pregMatch('/target="_blank">\s*([^<]+)\s*<\/a>\s*<\/td>/sim');
                $model_prices = $catchData->pregMatch('%([\d\.]+)万元<\/td>%sim');
                $prices = $catchData->pregMatch('/(\d+)元<\/td>/sim');
                $times = $catchData->pregMatch('/(\d{4}-\d{2}-\d{2})\s*至\s*(\d{4}-\d{2}-\d{2})/sim');
                foreach($factorys[1] as $key=>$value){

                  $modelName = trim($models[1][$key]);
                          $str .="$value".','.$modelName.','.$model_prices[1][$key].'万元,'.$prices[1][$key].'元,'.$times[1][$key].'至'.$times[2][$key]."\n";
                   }
                }
            Header("Content-type: application/vnd.ms-excel");
            Header("Content-Disposition: attachment; filename=北京老旧机车淘汰更新管理数据列表.csv");
            echo $str;
         
      }
  }
?>