<?php
class dealerpriceAction extends action {
    var $dealerprice;
    function __construct() {
      parent::__construct();
      $this->dealer = new dealer();
      $this->cardbmodel = new cardbModel();
      $this->dealerprice = new dealerprice();
      $this->history = new dpriceHistory();
      $this->city = new city();
    }
    
    function doDefault() {
        $this->doList();
    }
    function doList() {
        $this->checkAuth(301, 'sys_module', 'R');
        $limit = 20;
        $where = 1;
        $condition = '';
        $tpl_name = 'dealerprice_list';
        $this->brand = new brand();
        $state = $_GET['state'] ? $_GET['state'] : $_POST['state'];
        $page = max(1, intval($_GET['page']));
        $offset = ($page - 1) * $limit;          
        $this->factory = new factory();
        $this->series = new series();
        $this->model = new cardbModel();
        $this->brand = new brand();                                      
        $this->dealer = new dealer();           
        $receiverArr = array('province_id', 'city_id', 'brand_id', 'factory_id', 'series_id', 'model_id', 'dealer_name', 'state');
        $receiver = receiveArray($receiverArr);
        foreach($receiver as $k => $v) {
            if($v) {
                $condition .= "&$k=$v";
                $conditionArr[$k] = $v;
            }
        }
        $phpSelf = $_ENV['PHP_SELF'].'list';                        
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $factory = $this->factory->getAllFactory("f.brand_id='{$conditionArr['brand_id']}' and f.brand_id=b.brand_id", array('f.letter' => 'asc'), 20);
        $series = $this->series->getAllSeries("s.factory_id='{$conditionArr['factory_id']}' and s.factory_id=f.factory_id and f.brand_id=b.brand_id and (s.state=3 or s.state=7 or s.state=8 or s.state=11)", array('s.letter' => 'asc'), 50);
        $model = $this->model->getAllModel("m.series_id='{$conditionArr['series_id']}' and m.series_id=s.series_id and s.factory_id=f.factory_id and f.brand_id=b.brand_id and m.state=3", array(), 200);    
        $city = $this->city->getCity($conditionArr['province_id']);
        if(!empty($city)) {
            foreach($city as $k => $v) {                    
                $c[$k]['id'] = $v['id'];
                $c[$k]['name'] = $v['name'];
                $c[$k]['letter'] = strtoupper(substr($v['letter'], 0, 1));             
            }               
        }
        $list = $this->dealerprice->getList($receiver, $limit, $offset);
        $page_bar = $this->multi($this->dealerprice->total, $limit, $page, $phpSelf.$condition);
        $this->tpl->assign('conditionArr', $conditionArr);
        $this->tpl->assign('state',$state);
        $this->tpl->assign('brand', $brand);
        $this->tpl->assign('factory', $factory);
        $this->tpl->assign('series', $series);
        $this->tpl->assign('model', $model);
        $this->tpl->assign('city', $c);
        $this->tpl->assign('condition', $condition.'&page='.$page);
        $this->tpl->assign('list', $list);
        $this->tpl->assign('page_bar', $page_bar);
        $this->tpl->assign('total',$this->dealerprice->total);
        $this->template($tpl_name);        
    }
    
    function doGetDealerById() {    
        $this->checkAuth(301, 'sys_module', 'R');    
        $dealer = $this->dealerprice->getDealers();
        foreach($dealer as $k => $v) {
            $outdealer[$k]['dealer_name'] = iconv('gbk', 'utf-8', $v['dealer_name']);            
            $outdealer[$k]['dealer_id'] = $v['dealer_id'];
        }
        $outdealer = json_encode($outdealer);
        echo $outdealer;
    }
    
    function doCity() {
        $this->checkAuth(301, 'sys_module', 'R');
        $pid = intval($_GET['pid']);
        $city = $this->city->getCity($pid);
        foreach($city as $k => $v) {                    
            $c[$k]['id'] = $v['id'];
            $c[$k]['name'] = iconv('gbk', 'utf-8', $v['name']);
            $c[$k]['letter'] = strtoupper(substr($v['letter'], 0, 1));             
        }
        $c = json_encode($c);
        echo $c;
    }
    
    function doDelete() {
        $this->checkAuth(301, 'sys_module');
        $condition = '';
        $receiver = receiveArray(array('state','province_id', 'city_id', 'brand_id', 'factory_id', 'series_id', 'model_id','page'));
        foreach($receiver as $k => $v) {
            if($v) $condition .= "&$k=$v";
        }
        $id = intval($_GET['id']);
        $dealer_id=intval($_GET['dealer_id']);
        $model_id = intval($_GET['modelid']);
        $series_id = intval($_GET['seriesid']);
        if($id) $this->dealerprice->delDealerPrice($id);
        $this->history->where = "dealer_id=$dealer_id and model_id=$model_id";
        $this->history->ufields = array('submit'=>0);
        $this->history->update();
        $this->dealerprice->updatePrice($model_id,$series_id);
        $url = $_ENV['PHP_SELF'].'list'.$condition;
        echo '<script>';
        echo 'location.href="'.$url.'"';
        echo '</script>';
    }
    
    function doEdit() {
        global $action; 
        $this->checkAuth(301, 'sys_module');
        $tpl_name = 'dealerprice_edit';
        $id = intval($_GET['id']);
        if(!empty($_POST)) {              
            //接收的表达名称
            $state = $_POST['state'];
            $receier_arr = array('dealer_id', 'series_id', 'model_id', 'bingo_price', 'inventory','drive','remark', 'start_time', 'end_time', 'color', 'state');
            $receiver = receiveArray($receier_arr);
            $this->dealerprice->editDealerPrice($receiver, $id);
            $receier_his = array('dealer_id', 'series_id', 'model_id', 'bingo_price', 'inventory','drive','remark', 'color','state');
            $receiver_his = receiveArray($receier_his);
            $dealer_id = $receiver_his['dealer_id'];
            $model_id = $receiver_his['model_id'];
            $series_id = $receiver_his['series_id'];
            $receiver_his['updated'] = time();
            $twhere ="dealer_id=$dealer_id and model_id=$model_id and submit=1" ;
            $state = $receiver_his['state'];

            switch ($state){
                case 1:
                    $receiver_his['state']=1;
                    $receiver_his['submit']=1;break;
                case 3:
                    $receiver_his['state']=0;
                    $receiver_his['submit']=2;break;
                case 4:
                    $receiver_his['state']=2;
                    $receiver_his['submit']=1;break;
            }
            $this->history->where = $twhere;
            $this->history->ufields = $receiver_his;
            $this->history->update();
            $this->dealerprice->updatePrice($model_id,$series_id);

            $this->dealer->where = "dealer_id=$dealer_id";
            $this->dealer->ufields = array('last_pricetime'=>time());
            $this->dealer->update();

            $url = $_ENV['PHP_SELF'].'list&state=1';
            echo '<script>';
            echo 'alert("修改成功！");';
            echo 'location.href="'.$url.'";';
            echo '</script>';
        }
        else {
            $phpself = $_ENV['PHP_SELF'].'edit&id='.$id;
            $type = $action == 'edit' ? '修改' : '添加';
            $this->factory = new factory();
            $this->series = new series();
            $this->model = new cardbModel();
              $this->brand = new brand();                                      
            $this->dealer = new dealer();
            $list = $this->dealerprice->getPriceDetail($id);
            $pid = intval($list['province_id']);
            $cid = intval($list['city_id']);
            $factory = $this->factory->getAllFactory("f.brand_id='{$list['brand_id']}' and f.brand_id=b.brand_id", array('f.letter' => 'asc'), 20);
            $series = $this->series->getAllSeries("s.factory_id='{$list['factory_id']}' and s.factory_id=f.factory_id and f.brand_id=b.brand_id and (s.state=3 or s.state=7 or s.state=8 or s.state=11)", array('s.letter' => 'asc'), 50);
            $model = $this->model->getAllModel("m.series_id='{$list['series_id']}' and m.series_id=s.series_id and s.factory_id=f.factory_id and f.brand_id=b.brand_id and (m.state=3 or m.state=7 or m.state=8)", array(), 200);
              $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);                        
            $city = $this->city->getCity($pid);
            if($city){
                foreach($city as $k => $v) {
                    $c[$k]['id'] = $v['id'];
                    $c[$k]['name'] = $v['name'];
                    $c[$k]['letter'] = strtoupper(substr($v['letter'], 0, 1));
                }
            }
            $dealer = $this->dealer->getDealer('dealer_id, dealer_name', "province_id = $pid AND city_id = $cid");            
            $this->tpl->assign('phpself', $phpself);
            $this->tpl->assign('brand', $brand);
            $this->tpl->assign('factory', $factory);
            $this->tpl->assign('series', $series);
            $this->tpl->assign('model', $model);            
            $this->tpl->assign('dealer', $dealer);
            $this->tpl->assign('city', $c);
            $this->tpl->assign('list', $list);   
            $this->tpl->assign('type', $type);
            $this->tpl->assign('id', $id);
            $this->template($tpl_name);            
        }        
    }
    function doAdd() {        
        global $action;  
        $this->checkAuth(301, 'sys_module');
                      
        $tpl_name = 'dealerprice_edit';
        $dealer_id = intval($_GET['dealer_id']);
        if($dealer_id) {
            $this->dealer = new dealer();            
            $dealer = $this->dealer->getDealer('dealer_id, province_id, city_id, dealer_name', "dealer_id = $dealer_id");    
            $province_id = $dealer[0]['province_id'];
            $city_id = $dealer[0]['city_id'];
            $dealerInfo = $this->dealer->getDealer('dealer_id, dealer_name', "province_id = $province_id AND city_id = $city_id");            
            $city = $this->city->getCity($province_id);
            if(!empty($city)) {
                foreach($city as &$row) {
                    $row['letter'] = strtoupper(substr($row['letter'], 0, 1));
                }                
            }
            $this->tpl->assign('city', $city);
            $this->tpl->assign('list', $dealer[0]);
            $this->tpl->assign('dealer', $dealerInfo);
        }

        if(!empty($_POST)) {
            $receier_arr = array('dealer_id', 'series_id', 'model_id', 'bingo_price', 'inventory','drive','remark', 'start_time', 'end_time', 'color', 'state');
            $receiver = receiveArray($receier_arr);
            $dealerid = $receiver['dealer_id'];
            $modelid = $receiver['model_id'];
            $seriesid = $receiver['series_id'];
            $receier_his = array('dealer_id', 'brand_id', 'series_id', 'model_id', 'bingo_price', 'inventory','drive','remark', 'color','state');
            $receiver_his = receiveArray($receier_his);
            $tmp = $this->cardbmodel->getModel($modelid);
            $a = $this->dealerprice->getDealerPrice($dealerid,$modelid);
            $receiver_his['model_price'] = $tmp['model_price'];
            $receiver['model_price'] = $tmp['model_price'];
            $receiver['created'] = time();
            if($a){
                echo "<script>alert('该经销商已对此款车进行报价！')</script>";
            }else{
                $this->dealerprice->addDealerPrice($receiver);
                $this->dealerprice->updatePrice($modelid,$seriesid);
                $twhere ="dealer_id=$dealerid and model_id=$modelid and submit=1" ;
                $state = $receiver_his['state'];
                $receiver_his['created']=time();
                $receiver_his['updated']= time();
                switch ($state){
                    case 1:
                        $receiver_his['state']=1;
                        $receiver_his['submit']=1;break;
                    case 3:
                        $receiver_his['state']=0;
                        $receiver_his['submit']=2;break;
                    case 4:
                        $receiver_his['state']=2;
                        $receiver_his['submit']=1;break;
                }
                $this->history->where = $twhere;
                $this->history->ufields = $receiver_his;
                $this->history->insert();
                $this->dealer->where = "dealer_id=$dealerid";
                $this->dealer->ufields = array('last_pricetime'=>time());
                $this->dealer->update();
                echo "<script>alert('经销商报价添加成功！')</script>";
            }
            
        }       
        $this->brand = new brand();
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);        
        $type = $action == 'edit' ? '修改' : '添加';
        $phpself = $_ENV['PHP_SELF'].'add';
        $this->tpl->assign('brand', $brand);
        $this->tpl->assign('type', $type);
        $this->template($tpl_name);
    }

    function doUpdate(){
        $this->checkAuth(301, 'sys_module');
        $receier_id = array('id','dealer_id','seriesid', 'modelid', 'type');
        $arrwhere = receiveArray($receier_id);
        $receiver = receiveArray(array('state','province_id', 'city_id', 'brand_id', 'factory_id', 'series_id','model_id','page'));
        foreach($receiver as $k => $v) {
            if($v) $condition .= "&$k=$v";
        }
        $type = $arrwhere['type'];
        $dealer_id = $arrwhere['dealer_id'];
        $model_id = $arrwhere['modelid'];
        $series_id = $arrwhere['seriesid'];
        $where = 1;
        foreach($arrwhere as $k => $v) {
            if($v && $k!='type') $where .= " and $k=$v";
        }
        $where = str_replace('modelid', 'model_id', $where);
        $where = str_replace('seriesid', 'series_id', $where);
        $this->dealerprice->where = $where;
        $this->dealerprice->ufields = array('state'=>$type,'updated'=>time());
        $this->dealerprice->update();
        $this->dealerprice->updatePrice($model_id,$series_id);
        $hwhere ="dealer_id=$dealer_id and model_id=$model_id and submit<>0" ;
        switch ($type){
            case 1:
                $state=1;
                $ufields['submit'] = 1;
                break;
            case 3:
                $state=0;break;
            case 4:
                $state=2;break;
            case 6:
                $state=4;break;
        }
        $ufields['state'] = $state;
        $ufields['updated'] = time();
        $this->history->where = $hwhere;
        $this->history->ufields = $ufields;
        $this->history->update();
        $this->dealer->where = "dealer_id=$dealer_id";
        $this->dealer->ufields = array('last_pricetime'=>time());
        $this->dealer->update();

        echo "<script>alert('经销商报价修改成功！')</script>";
        $url = $_ENV['PHP_SELF'].'list'.$condition;
        echo '<script>';
        echo 'location.href="'.$url.'"';
        echo '</script>';
    }
    
    function checkAuth($id, $module_type = 'sys_module', $type_value = "A"){
      global $adminauth, $login_uid;
      $adminauth->checkAuth($login_uid, $module_type, $id, $type_value);
    }

     /*
     * 首页 最新10款车系 的最低车款
     */
    function doSsinewcars(){
        $this->checkAuth(301, 'sys_module');
        $this->tpl_file = "ssi_cpindex_newmodels";
        $result=$this->dealerprice->getNewsprice(" p.state=1 ",array("p.created"=>"DESC"));
        $this->tpl->assign('models', $result);
        $html = $this->fetch($this->tpl_file);
        $html = $this->replaceAttachServer($html);
        echo $html;
    }

    /*
     * 首页 特价车型
     */
    function doSsihotmodels(){
        $this->checkAuth(301, 'sys_module');
        $this->tpl_file = "ssi_cpindex_hotmodels";
        $result=$this->dealerprice->getTop10("discount>0 and state=0",array("discount"=>"asc"),6);
        $this->tpl->assign('models', $result);
        $html = $this->fetch($this->tpl_file);
        $html = $this->replaceAttachServer($html);
        echo $html;
    }


     function doModelprice() {
        $this->checkAuth(301, 'sys_module', 'R');
        $model_id = intval($_GET['model_id']);
        $model_price = '';
        if($model_id) {
            $modelprice = $this->cardbmodel->getModel($model_id);
            $json = json_encode($modelprice['model_price']);
            echo $json;
        }
        else echo -4;
    }


}

?>
