<?php

class promotionAction extends action
{
	

	function __construct()
	{
		parent::__construct();
                $this->brand = new brand();
                $this->promotion = new cardbpromotion();
                $this->models = new cardbModel();
                $this->series = new series();
                $this->factory = new factory();
	}
        
        function doDefault() {
            
            $this->doPromotionList();
           // $this->doCatchPromotion();
            
           // exit;
            
        }

        function doPromotionList(){
             $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
            $this->tpl->assign('brand', $brand);
            $tpl_name ="promotion_list";
            $page = $_GET['page'];
            $page = max(1, $page);
            $extra ="page=".$page;
            $page_size = 20;
            $page_start = ($page-1)*$page_size; 
            $where ="1";
             if($_REQUEST[series_id]){
                $model = $this->cardbmodel->chkModel("model_id,model_name","series_id=$_REQUEST[series_id] and state=3",'',2);
                $this->vars("model",$model);
                $where .=" and series_id=$_REQUEST[series_id]";
                $this->vars("series_id", $_REQUEST[series_id]);
                $extra .="&series_id=".$_REQUEST[series_id];
            }
            if($_REQUEST[factory_id]){
                $series = $this->series->getSeriesFields("series_id,series_name","factory_id=$_REQUEST[factory_id] and state=3",2);
                $this->vars("series",$series);
                $where .=" and factory_id=$_REQUEST[factory_id]";
                $this->vars("factory_id", $_REQUEST[factory_id]);
                $extra .="&factory_id=".$_REQUEST[factory_id];
            }
             if($_REQUEST[brand_id]){
                $factory = $this->factory->getFactorylist("factory_id,factory_name","brand_id=$_REQUEST[brand_id] and state=3",2);
                $this->vars("factory",$factory);
                $where .=" and brand_id=$_REQUEST[brand_id]";
                $this->vars("brand_id", $_REQUEST[brand_id]);
                $extra .="&brand_id=".$_REQUEST[brand_id];
            }
             if($_REQUEST[model_id]){
                $where .=" and model_id=$_REQUEST[model_id]";
                $this->vars("model_id", $_REQUEST[model_id]);
                $extra .="&model_id=".$_REQUEST[model_id];
            }


            if($_REQUEST[start_date]){
                $start_time=strtotime($_REQUEST[start_date]);
                $this->vars("start_date", $start_time);
                $where .=" and start_date>$start_time";
                $extra .="&start_date=".$_REQUEST[start_date];
            }
            if($_REQUEST[end_date]){
                $end_time=strtotime($_REQUEST[end_date]);
                $this->vars("end_date", $end_time);
                $where .=" and end_date<$end_time";
                $extra .="&end_date=".$_REQUEST[end_date];
            }
           
            $total = $this->promotion->getWhereList("count(id)",$where,3);
            $result = $this->promotion->getPromotionList($where,$order,$page_start,$page_size);
            $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'].'promotionlist&' . $extra);
            $this->vars('page_bar', $page_bar);
            $this->vars("list",$result);
            $extra = serialize($extra);
            $this->vars('extra',$extra);
            $this->template($tpl_name);
        }
        
        function doUpdate(){
            $id = $_GET['id'];
            $url =$_GET['rurl'];
            $tpl_name ="promotion_edit";
            $result = $this->promotion->getWhereList("*","id=$id",1);
            if($_POST){
                
                  $sid =$_POST['id'];
                  $rurl =  unserialize($_POST['url']);
                  $s_times = strtotime($_POST['start_date']);
                  $e_times = strtotime($_POST['end_date']);
                 $this->promotion->ufields = array(
                        "brand_name"  => $_POST['brand_name'],
                        "model_name" => $_POST['model_name'],
                        "series_name" => $_POST['series_name'],
                        "factory_name" => $_POST['factory_name'],
                        "model_price" => $_POST['model_price'],
                        "rate_price" => $_POST['rate_price'],
                        "saler" => $_POST['saler'],
                        "saler_tel" => $_POST['saler_tel'],
                        "saler_gender" => $_POST['saler_gender'],
                        "content" => $_POST['content'],
                        "title" => $_POST['title'],
                        "dealer_name" => $_POST['title'],
                        "dealer_area" => $_POST['title'],
                        "from_link" => $_POST['title'],
                        "start_date" => "$s_times",
                        "end_date" => "$e_times",
                        "from_name" => $_POST['title'],
                        "updated" => time(),
                );
                $this->promotion->where ="id=$sid";
                $tag = $this->promotion->update();
                if($tag){
                    $this->alert("更新成功", "js", 3,$_ENV['PHP_SELF'] .$rurl);
                }else{
                    $this->alert("更新成功", "js", 3,$_ENV['PHP_SELF']);
                }
            }
            $this->vars('list', $result);
            $this->vars("url",$url);
            $this->template($tpl_name);
        }
        
        //导出
        function doImportant(){
            $template_name ="promotion_important";
            $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
            $this->tpl->assign('brand', $brand);
            
            $this->template($template_name);
        }
        function doImportantEdit(){
      
               set_time_limit(0);
             $where ="1";
             if($_REQUEST[series_id]){
                $where .=" and series_id=$_REQUEST[series_id]";
            }
            if($_REQUEST[factory_id]){
                $where .=" and factory_id=$_REQUEST[factory_id]";
            }
             if($_REQUEST[brand_id]){
                $where .=" and brand_id=$_REQUEST[brand_id]";
            }
             if($_REQUEST[model_id]){
                $where .=" and model_id=$_REQUEST[model_id]";
            }

            if($_REQUEST[start_date]){
                $start_time=strtotime($_REQUEST[start_date]);
                $where .=" and start_date>$start_time";

            }
            if($_REQUEST[end_date]){
                $end_time=strtotime($_REQUEST[end_date]);
                $where .=" and end_date<$end_time";
 
            }
             if($_REQUEST[s_created]){
                $s_created=strtotime($_REQUEST[s_created]);
                $where .=" and created>$s_created";

            }
            if($_REQUEST[e_created]){
                $e_created=strtotime($_REQUEST[e_created]);
                $where .=" and created<$e_created";
 
            }

            $result = $this->promotion->getWhereList("*",$where,2);
               
              $title1 ="抓取日期,品牌,厂商,车系,车款,指导价,优惠幅度,标题名称,促销开始日期,促销结束日期,内容,经销商名称,销售人员获取渠道(冰狗渠道/汽车之家渠道),获取日期(本经销商暗访数据库内最近一次的销售人员数据),销售名称,销售性别,手机号,经销商地址,链接,是否未新经销商";
              $str =$title1."\n";
              foreach($result as $key=>$value){
                  $created =date("Y-m-d",$value['created']);
                  $start_date =date("Y-m-d",$value['start_date']);
                  $end_date =date("Y-m-d",$value['end_date']);
                  $last_from_date =date("Y-m-d",$value['last_from_date']);
                  if($value['saler_gender']==1){
                      $sex ="男";
                  }  else if($value['saler_gender']==0) {
                      $sex ="女";
                  }else{
                      $sex =' ';
                  }
                   if($value['is_new']==1){
                      $is ="是";
                  }  else if($value['is_new']==2) {
                      $is ="否";
                  }else{
                      $is =' ';
                  }
                  $brand_name = $value['brand_name']?$value['brand_name']:' '; 
                  $series_name =$value['series_name']?$value['series_name']:' '; 
                  $factory_name = $value['factory_name']?$value['factory_name']:' '; 
                  $title = str_replace("\n", ' ', $value['title']); 
                  $content = str_replace("\n", ' ', $value['content']);  
                 $str .=$created.','.$brand_name.','.$factory_name.','.$series_name.','.$value['model_name'].','.$value['model_price'].','.$value['rate_price'].','.$title.','.$start_date.','.$end_date.','.$content.','.$value['dealer_name'].','.$value['from_type'].','.$last_from_date.','.$value['saler'].','.$sex.','.$value['saler_tel'].','.$value['dealer_area'].','.$value['from_link'].','.$is;

                 $str .= "\n";
              }
              
              $str = gzencode($str);
              Header("Content-type: application/x-gzip-compressed");
              Header("Content-Disposition: attachment; filename= promotionlist.csv.gz");
              echo $str;
//
//              Header("Content-type: application/vnd.ms-excel");
//              Header("Content-Disposition: attachment; filename= promotionlist.csv"); 
//              echo $str;
              
            
              
        }
        
        //抓取促销信息数据
        function doCatchPromotion(){
            #抓取汽车之家(北京地区)经销商
            include SITE_ROOT . 'lib/webclient.class.php';
            include SITE_ROOT . 'model/catchdata.php';
            set_time_limit(0);
            $temptime =$_GET['created']; //格式2014-06-13
            //$temptime ='2014-06-13'; //格式
            $dealerHome = 'http://dealer.autohome.com.cn/';
            $catchData = new CatchData();
            $dealer = new dealer();
            $models = new cardbModel();
            $pricelog = new cardbPriceLog();
            $promotion = new cardbpromotion();
            $num = 1;
            if($temptime){
                  $timestamp = $temptime;
            }else{
                 $timestamp = date("Y-m-d", time());
            }
           
            $page = 1;
            $catchData->catchResult($dealerHome . 'beijing/');
            $pageMatches = $catchData->pregMatch("/<span class='page-item-info'>共(\d+)页<\/span>/sim");
            if ($pageMatches)
                $page = max($pageMatches[1]);

            for ($i = 1; $i <= $page; $i++) {

                $catchData->catchResult($dealerHome . 'beijing/0_0_0_0_' . $i . '.html');
                //echo $dealerHome . 'beijing/0_0_0_0_' . $i . '.html';
                $nameMatches = $catchData->pregMatch('/js-did="(\d+)" js-darea=\"北京\" js-haspro=\"\d+\">([^<]+)<\/a><\/h3>/sim');
                $dealerMatches = $catchData->pregMatch('%title="([^"]+)">地址：%sim');
               // var_dump($nameMatches);
               // var_dump($dealerMatches);
          
                foreach ($nameMatches[1] as $key => $value) {
                    $dealer_id = $dealer->getDealerInfo("dealer_id", "src_id=$value", 1);
                    $dealer_name = $nameMatches[2][$key];
                    $dealer_area = $dealerMatches[1][$key];
                    $dealer_n = $dealer->getDealerInfo("dealer_id", "dealer_name='$dealer_name' and dealer_area='$dealer_area'", 1);

                    if ($dealer_id || $dealer_n) {
                        if ($dealer_n) {
                            $dealer->editDealer(array("src_id" => "$value"), $dealer_n['dealer_id']);
                        }
                    } else {

                        $dealer->catchDealerFUN($value, 3, 19, $list['id']);
                    }

               
                    $n_url = $dealerHome . $value . "/newslist_c2_s0.html";
                    $catchData->catchResult($n_url);
                    $new_time = $catchData->pregMatch('/<dd class=\"fr\">([^<]+)<\/dd>/sim');

                    $new_title = $catchData->pregMatch('/<a target=\"_blank\" href=\"\/([^"]+)\">([^<]+)<\/a>/sim');
                  
                    if ($new_time[1]) {
                        foreach ($new_time[1] as $k => $v) {
                            if ($timestamp == $v) {
                                $content_url = $dealerHome . $new_title[1][$k];
                                $catchData->catchResult($content_url);
                                //$new_content = $catchData->pregMatch('/<p><span class=\"red\">促销时间：([^<]+)<\/span><br \/>[&nbsp;]+([^<]+)<\/p>/sim');
                                $new_content = $catchData->pregMatch('/><p class=\"cont-time\">促销时间([^<]+)<\/p><p>([^<]+)<\/p>/sim');
                                //$new_series_name = $catchData->pregMatch('/<strong>([^<]+) 本店最新价格变化报价及优惠<\/strong>/sim');
                                $new_series_name = $catchData->pregMatch('/<th colspan=\"7\">([^<]+)车型最新价格变化报价<\/th>/sim');
                               // $new_model_name = $catchData->pregMatch('/<span class="tit-icn">' . $new_series_name[1][0] . '([^<]+)<\/span>/sim');
                                $new_model_name = $catchData->pregMatch('/>'. $new_series_name[1][0] . '([^<]+)<\/td>/sim');
                                //$new_hui = $catchData->pregMatch('/↘([^<]+)<\/td>/sim');
                                $new_hui = $catchData->pregMatch('/<i class=\"char-down\">&darr;<\/i>([^<]+)</sim');
                                $timesArr = explode('-', $new_content[1][0]);
                                $s_times = strtotime(str_replace('.', '-', $timesArr[0]));
                                $e_times = strtotime(str_replace('.', '-', $timesArr[1]));
                                
                                //var_dump($new_content);
                                // var_dump($new_series_name);
                                 // var_dump($new_hui);
                            //  var_dump($content_url);
                                $fields = array(
                                    "content" => $new_content[2][0],
                                    "title" => $new_title[2][$k],
                                    "dealer_name" => $nameMatches[2][$key],
                                    "dealer_area" => $dealerMatches[1][$key],
                                    "from_link" => "$content_url",
                                    "start_date" => "$s_times",
                                    "end_date" => "$e_times",
                                    "from_name" => "汽车之家",
                                    "created" => time(),
                                    "updated" => time(),
                                );
                                
                                if ($dealer_id || $dealer_n) {
                                    $fields["is_new"] = "2";
                                    $fields["dealer_id"] = $dealer_id['dealer_id'] ? $dealer_id['dealer_id'] : $dealer_n['dealer_id'];
                                } else {
                                    $fields["is_new"] = "1";
                                }
                              //  var_dump($new_model_name);
                                if ($new_model_name[1]) {
                                    foreach ($new_model_name[1] as $kk => $vv) {
                                        $model_anme = trim($vv);
                                        $series_name = trim($new_series_name[1][0]);
                                        $modellist = $models->getSimp("model_id,factory_id,brand_id,series_id,model_name,series_name,factory_name,brand_name,model_price", "model_name='$model_anme' and series_name='$series_name'", 1);
                                        $fields["rate_price"] = $new_hui[1][0];
                                        if ($modellist) {
                                            $priceloglist = $pricelog->getPrices("saler,saler_gender,saler_tel,get_time,price_type", "price_type=0 and model_id=$modellist[model_id] order by get_time desc", 1);
                                            $fields["model_name"] = $modellist[model_name];
                                            $fields["brand_name"] = $modellist[brand_name];
                                            $fields["model_id"] = $modellist[model_id];
                                            $fields["factory_name"] = $modellist[factory_name];
                                            $fields["series_name"] = $modellist[series_name];
                                            $fields["model_price"] = $modellist[model_price];
                                            $fields["factory_id"] = $modellist[factory_id];
                                            $fields["series_id"] = $modellist[series_id];
                                            $fields["brand_id"] = $modellist[brand_id];

                                            if ($priceloglist) {
                                                $fields["saler"] = $priceloglist[saler];
                                                $fields["saler_gender"] = $priceloglist[saler_gender];
                                                $fields["saler_tel"] = $priceloglist[saler_tel];
                                                $fields["last_from_date"] = $priceloglist[get_time];
                                                $fields["from_type"] = '冰狗渠道';
                                            } else {
                                              $fields["from_type"] = '汽车之家渠道';
                                            }

                                            $promotion->ufields=$fields;
                                            $promotion->insert();
                                            $num++;

                                            

                                        } else {
                                            continue;
                                        }


                                    }
                                }
                            } else {
                                continue;
                            }
                        }
                    }
                }

            }
            echo "共抓取" . $num . "条";
            echo '抓取完成！';
        }
        
        

}
?>