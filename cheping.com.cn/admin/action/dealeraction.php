<?php
class dealerAction extends action {
    var $dealer;
    function __construct() {
      parent::__construct();
      $this->dealer = new dealer();
      $this->dealerapply = new dealerapply();
      $this->service = new service();
      $this->city = new City();
      $this->province = new cp_Province();
      $this->county = new County();
      $this->series = new series();
      $this->factory = new factory();
      $this->chkAuth(1301, 'sys_module', 'R');
    }
    
    function doDefault() {
        $this->doList();
    }
    function doArticleDealer() {
        $idList = $_GET['idList'];
        $pid = $_GET['pid'];
        $cid = $_GET['cid'];
        $cyid = $_GET['cyid'];
        $dealer = $this->dealer->getArticleDealer($idList, $pid, $cid, $cyid);
        echo json_encode($dealer);
    }
    
    function doList() {
        $limit = 20;
        $condition = '';
        $tpl_name = 'dealer_list';
        $page = max(1, intval($_GET['page']));
        $offset = ($page - 1) * $limit;     
        $receiverArr = array('brand_id', 'factory_id', 'series_id', 'province', 'city', 'county', 'dealer_name', 'state');
        $receiver = receiveArray($receiverArr);
		$srcId = is_numeric($_POST['src_id']) ? $_POST['src_id'] : $_GET['src_id'];
		if($srcId == '1'){
			$receiver['src_id'] = "src_id>0";
			$srcId = 1;
		}elseif($srcId === '0'){
			$receiver['src_id'] = "src_id<1";
			$srcId = 0;
		}
		$condition .= "&state={$receiver['state']}&src_id=$srcId";
		//var_dump($receiver);exit;
        $temp1 = $temp2 = $temp3 = '';
        $this->factory = new factory();
        $this->series = new series();
        $this->brand = new brand(); 
        $province = $this->province->getProvince();
        if($receiver['province']){
            $tempProvince = $receiver['province'];
            $temp1 = explode('|', $receiver['province']);
            $temp2 = explode('|', $receiver['city']);            
            $receiver['province'] = $temp1[0];
            $pId = $this->province->getProvinceByName($temp1[1]);
            $this->tpl->assign('pid', $pId);
            $cId = $this->city->getCityByName($temp2[1]);
            $city = $this->city->getCity($pId['id']);
            $this->tpl->assign('city', $city);
            $this->tpl->assign('cid', $cId);
            $condition .= "&province=$tempProvince";
        }
        if($receiver['city']){
            $tempCity = $receiver['city'];
            $receiver['city'] = $temp2[0];
            $temp3 = explode('|', $receiver['county']);
            $countyId = $this->county->getCountyByName($temp3[1]);
            $county = $this->county->getCounty($cId['id']);
            $this->tpl->assign('county', $county);
            $this->tpl->assign('countyId', $countyId);
            $condition .= "&city=$tempCity";
        }
        if($receiver['county']){
            $tempCounty = $receiver['county'];
            $receiver['county'] = $temp3[0];
            $condition .= "&county=$tempCounty";
        }
        if($receiver['brand_id']){
            $this->tpl->assign('brand_id', $receiver['brand_id']);
            $factory = $this->factory->getAllFactory("f.brand_id='{$receiver['brand_id']}' and f.brand_id=b.brand_id", array('f.letter' => 'asc'), 20);
            $this->tpl->assign('factory', $factory);
            $condition .= "&brand_id={$receiver['brand_id']}";
        }
        if($receiver['factory_id']){
            $this->tpl->assign('factory_id', $receiver['factory_id']);
            $series = $this->series->getAllSeries("s.factory_id='{$receiver['factory_id']}' and s.factory_id=f.factory_id and f.brand_id=b.brand_id and (s.state=3 or s.state=7 or s.state=8 or s.state=11)", array('s.letter' => 'asc'), 50);
            $this->tpl->assign('series', $series);
            $condition .= "&factory_id={$receiver['factory_id']}";
        }
        if($receiver['series_id']){
            $this->tpl->assign('series_id', $receiver['series_id']);
            $condition .= "&series_id={$receiver['series_id']}";
        }
        $phpSelf = $_ENV['PHP_SELF'].'list';
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $list = $this->dealer->getDealerList($receiver, $limit, $offset);
		//echo $this->dealer->sql;
//        foreach($list as $key=>$val){
//            if($val['last_pricetime']){
//                $day = round((time()-$val['last_pricetime'])/3600/24);
//                $list[$key]['day'] = $day;
//            }else{
//                $list[$key]['day'] = '未报价';
//            }
//        }
        $page_bar = $this->multi($this->dealer->total, $limit, $page, $phpSelf.$condition);
        $this->tpl->assign('condition', $condition.'&page='.$page);
        $this->tpl->assign('state', $receiver['state']);
        $this->tpl->assign('src_id', $srcId);
        $this->tpl->assign('brand', $brand);
        $this->tpl->assign('province', $province);
        $this->tpl->assign('data', $receiver);
        $this->tpl->assign('lists', $list);        
        $this->tpl->assign('page_bar', $page_bar);        
        $this->template($tpl_name,true,false);
    }
    
   function doProvince(){
        $province = $this->province->getProvince();
        foreach ($province as $k => $list){
            $province[$k]['name'] = iconv('gbk', 'utf-8', $list['name']);
        }
        echo json_encode($province);
    }
    function doCity() {
        $pid = explode('|', $_GET['pid']);
        $city = $this->city->getCity($pid[0]);
//        foreach($city as $k => $v) {
////            $city[$k]['name'] = iconv('gbk', 'utf-8', $v['name']);
//            $city[$k]['name'] = $v['name'];
//        }
        echo json_encode($city);
    }
    function doPic(){
      $id = $_GET['dealer_id'];
      if(!$id){
          echo 'no pic';
          exit;
      }
      $num = $_GET['num'];
      $dealerInfo = $this->dealer->getDetail($id);
      $dealerPicArr = explode('|',$dealerInfo['dealer_pic']);
      $dealerPic = $dealerPicArr[$num];
      echo "<img src='$dealerPic' width=200>";
////      exit;
//      if(!file_exists($dealerPic)){
//        echo "file not found!";
//      }else{
//        echo "<img src='$dealerPic' width=200>";
//      }
    }
    function doCounty(){
        $cid = explode('|', $_GET['cid']);
        $county = $this->county->getCounty($cid[0]);
        if(empty($county)){
            echo json_encode (array());
            exit;
        }
//        foreach($county as $k => $v) {
//            $county[$k]['name'] = iconv('gbk', 'utf-8', $v['name']);
//        }
        echo json_encode($county);
    }
    
    function doDealer() {
        $pid = intval($_GET['pid']);        
        $cid = intval($_GET['cid']);
        $fields = 'dealer_id, dealer_name';
        if($pid) $dealerInfo = $this->dealer->getDealer($fields, "province_id = $pid");
        if($cid) $dealerInfo = $this->dealer->getDealer($fields, "city_id = $cid");
        if(!empty($dealerInfo)) {
            foreach($dealerInfo as $k => $v) {                    
                $dealer[$k]['id'] = $v['dealer_id'];
//                $dealer[$k]['name'] = iconv('gbk', 'utf-8', $v['dealer_name']);
                $dealer[$k]['name'] = $v['dealer_name'];
            }
        }
        $dealerJson = json_encode($dealer);
        echo $dealerJson;
    }
    
    function doDelete() {
        $condition = '';
        $receiver = receiveArray(array('page', 'province_id', 'city_id', 'dealer_name'));
        foreach($receiver as $k => $v) {
            if($v) $condition .= "&$k=$v";
        }
        $id = intval($_GET['id']);
        if($id) $this->dealer->delDealer($id);
        if($id) $this->service->delete_service($id);
        $url = $_ENV['PHP_SELF'].'list'.$condition;
        header("Location:$url");
    }
    function doEdit() {
        global $db;
        $tpl_name = 'dealer_edit';
        $id = intval($_GET['id']);
        
        if(!empty($_POST)) {
            $receier_arr = array('dealer_name', 'dealer_name2', 'dealer_alias', 'dealer_memo' , 'province_id', 'city_id', 'county_id', 'dealer_area', 'dealer_tel', 'dealer_linkman', 'manage_user', 'manage_pass', 'link_man', 'link_tel','dealer_id','state');
            $receiver = receiveArray($receier_arr);            
            $maxservice = $_POST['maxservice'] + 1;
            $serviceArr = array();
            $service_id = $_POST['service_id'];
            
            $this->dealer->table_name = 'dealer_info';
            $this->dealer->fields = 'dealer_id';
            $this->dealer->where = "dealer_name = '$receiver[dealer_name]' and dealer_id<>$id and state<>1";
            $dn = $this->dealer->getResult(3);
            if(empty($_POST[dealer_id])){
                if($dn){
                    echo '<script>alert("添加失败，经销商名称已存在！");history.go(-1);</script>';die;
                }
                if(!empty($receiver[dealer_alias])){
                  $this->dealer->where = "dealer_alias = '$receiver[dealer_alias]' and dealer_id<>$id and state<>1";
                  $da = $this->dealer->getResult(3);
                  if($da){
                      echo '<script>alert("添加失败，经销商简称已存在！");history.go(-1);</script>';die;
                  }
                }
                if($receiver['state']==0){
                    $this->dealer->where = "manage_user = '$receiver[manage_user]' and dealer_id<>$id and state<>1";
                    $mu = $this->dealer->getResult(3);
                    if($mu){
                        echo '<script>alert("添加失败，用户名已存在！");history.go(-1);</script>';die;
                    }
                }
            }
            
            
            $oldPic = $_POST['old_pic'];
            $oldPicArr = explode("|", $oldPic);
            $oldPicArr = array_filter($oldPicArr);
            
            $upload_dir = "../" . UPLOAD_DIR . "images/dealer_img/".$id;
            if(!is_dir($upload_dir) && !empty($upload_dir)){
                file::forcemkdir($upload_dir);
            }
            foreach ($_FILES as $k => $v) {
                $dir_pre = substr(WWW_ROOT, 0, -3);
                if($v['name']){
                    if($k == 'pic1'){
                        $oldPicArr[0] = substr($upload_dir, 2).'/tp_'.$this->timestamp . rand(1000,9999).'.jpg';
                        move_uploaded_file($v['tmp_name'], $dir_pre . '..' . $oldPicArr[0]);
                    }
                    if($k == 'pic2'){
                        $oldPicArr[1] = substr($upload_dir, 2).'/tp_'.$this->timestamp . rand(1000,9999).'.jpg';
                        @move_uploaded_file($v['tmp_name'], $dir_pre . '..' . $oldPicArr[1]);
                    }
                    if($k == 'pic3'){
                        $oldPicArr[2] = substr($upload_dir, 2).'/tp_'.$this->timestamp . rand(1000,9999).'.jpg';
                        @move_uploaded_file($v['tmp_name'], $dir_pre . '..' . $oldPicArr[2]);
                    }
//                    @copy($v['tmp_name'], $upload_dir .'/tp_'.$time.'jpg');
                }
            }
            /*foreach ($oldPicArr as $key => $list){
                $oldPicArr[$key] = substr($list, 2);
            }*/
            $dealer_pic_alt =$_POST[pic_alt1].'|'.$_POST[pic_alt2].'|'.$_POST[pic_alt3];
            if(count($oldPicArr)==1)
                $oldPic = $oldPicArr[0] . '|';
            else
                $oldPic = implode('|', $oldPicArr);
            $provinceId = $receiver['province_id'];
            $cityId = $receiver['city_id'];
            $this->dealer->editDealer(array('dealer_pic' => $oldPic,'dealer_pic_alt'=>$dealer_pic_alt,'province_id' => $provinceId, 'city_id' => $cityId, 'county_id' => $receiver['county_id'], 'state'=>$receiver['state']), $_POST['dealer_id']);
          
            $main_com = $factory_name= '';
            //var_dump($service_id);exit;
            if(!empty($service_id)) {
               $dealer_cmap= $this->dealer->getDealerInfo("dealer_cmap","dealer_id=$_POST[dealer_id]",3);
               foreach($service_id as $sid) {
                    $ufields = array(
                        'brand_id' => $_POST['brand_id'.$sid]
                    );
                    $bname = 'brand_id'.$sid;
                    $fname = 'factory_id'.$sid;
                    $sname = 'series_id'.$sid;                
                    $brand_id = $_POST[$bname];
                    $factory_id = $_POST[$fname];
                    $series_id = $_POST[$sname];    
                    //同步dealer_info的主营
                    $factoryNames =  $this->factory->getFactorylist("factory_name","factory_id=$factory_id",3);
                    if($dealer_cmap&&$factoryNames){
                        if(strpos($dealer_cmap,$factoryNames)===false){
                             $factory_name .=$factoryNames.',';
                             $dealer_cmap .=$factoryNames.',';
                        }
                    }
                    
                       
                    $service = new Service();
                    
                    $chk_id = $service->chk_service_id($sid);
                    if($chk_id) {
                        $main_com = true;
                        $ufields = array(
                            'brand_id' => $brand_id,
                            'factory_id' => $factory_id,
                            'series_id' => $series_id
                        );                    
                        $service->update_service($ufields, $sid);
                    }
                    else {
                      if($factory_id){
                        $ufields = array(
                            'brand_id' => $brand_id,
                            'factory_id' => $factory_id,
                            'series_id' => $series_id,
                            'dealer_id' => $id
                        );                    
                        $service->insert_service($ufields);
                        $main_com = $series_id;
                      }
                    }                       
                }                
            }
            
            if(empty($service_id) || !$main_com){
              echo '<script>alert("添加失败，主营不能为空！");history.go(-1);</script>';die;
            }
            $factory_name = rtrim($factory_name,',');
            $receiver[dealer_camp]=$factory_name;
            $this->dealer->editDealer($receiver, $id);
           
  
            $url = $_ENV['PHP_SELF'].'list';            
            echo '<script>';
            echo 'alert("修改成功！");';
            echo 'location.href="'.$url.'"';
            echo '</script>';
        }
        else {
            global $action, $db;
            $maxservice = 0;
            $this->brand = new brand();                                            
            $this->factory = new factory();        
            $this->series = new series();
            $list = $this->dealer->getDetail($id);
            $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
            $service = $this->service->getService($id);
            $province = $this->province->getProvince();
            $city = $this->city->getCity($list['province_id']);
            $county = $this->county->getCounty($list['city_id']);
//            $maxservice = $db->getOne("SELECT max(service_id) FROM service");
            if($list[dealer_pic_alt]){
                foreach(explode('|', $list[dealer_pic_alt]) as $k=>$v){
                    $n = $k+1;
                    $list[pic_alt.$n]=$v;
                }
            }
            if(!empty($service)) {
                foreach($service as $v) {
                    $autoconfig[$v['service_id']]['brand'] = $brand;
                    $autoconfig[$v['service_id']]['factory'] = $this->factory->getAllFactory("f.brand_id='{$v['brand_id']}' and f.brand_id=b.brand_id", array('f.letter' => 'asc'), 20);
                    $autoconfig[$v['service_id']]['series'] = $this->series->getAllSeries("s.factory_id='{$v['factory_id']}' and s.factory_id=f.factory_id and f.brand_id=b.brand_id and (s.state=3 or s.state=7 or s.state=8 or s.state=11)", array('s.letter' => 'asc'), 50);
                }                
            }else{
                 //主要厂商检测
                $dealer_id = $id?$id:$_POST[dealer_id];
                $dealer_camp = $this->dealer->getDealerInfo("dealer_camp","dealer_id=$dealer_id",3);
                if($dealer_camp){
                    $dealer_camp = str_replace(",", "','", $dealer_camp);
                    $dealerA =  $this->factory->getFactorylist("brand_id,factory_id","factory_name in('$dealer_camp')",2);
                    if($dealerA){
                        foreach($dealerA as $key=>$v){
                            $r = $this->service->getServiceList("service_id","dealer_id=$dealer_id and factory_id=$v[factory_id]",2);
                            if(!$r){
                                $fields = array(
                                    "dealer_id"=>$dealer_id,
                                    "brand_id"=>$v[brand_id],
                                    "factory_id"=>$v[factory_id],
                                  );
                                $this->service->insert_service($fields);
                            }
                            
                             $autoconfig[$v['service_id']]['brand'] = $brand;
                             $autoconfig[$v['service_id']]['factory'] = $this->factory->getAllFactory("f.brand_id='{$v['brand_id']}' and f.brand_id=b.brand_id", array('f.letter' => 'asc'), 20);
                             $autoconfig[$v['service_id']]['series'] = $this->series->getAllSeries("s.factory_id='{$v['factory_id']}' and s.factory_id=f.factory_id and f.brand_id=b.brand_id and (s.state=3 or s.state=7 or s.state=8 or s.state=11)", array('s.letter' => 'asc'), 50);
                 
                        }
                    }

                }
            }            
            /*if(!empty($city)) {
                foreach($city as $k => $v) {                    
                    $c[$k]['id'] = $v['id'];
                    $c[$k]['name'] = $v['name'];
                    $c[$k]['letter'] = strtoupper(substr($v['letter'], 0, 1));             
                }                   
            }*/
			//var_dump($county);exit;
            $type = $action == 'edit' ? '修改' : '增加';
            $this->tpl->assign('autoconfig', $autoconfig);
            $this->tpl->assign('province', $province);
            $this->tpl->assign('city', $city);
            $this->tpl->assign('county', $county);
            $this->tpl->assign('brand', $brand);
            $this->tpl->assign('service', $service);
            $this->tpl->assign('maxservice', $maxservice);
            $this->tpl->assign('list', $list); 
            $this->tpl->assign('type', $type);
            $this->tpl->assign('phpself', $_ENV['PHP_SELF'].'list');
            $this->template($tpl_name);            
        }        
    }
    
    function doAdd() { 
        global $action;       
        
        $tpl_name = 'dealer_edit';        
        if(!empty($_POST)) {
            $receier_arr = array('dealer_name', 'dealer_alias', 'dealer_memo' , 'province_id', 'city_id', 'county_id', 'dealer_area', 'dealer_tel', 'dealer_linkman', 'manage_user', 'manage_pass', 'link_man', 'link_tel','dealer_id','state');
            $receiver = receiveArray($receier_arr);
            $maxservice = $_POST['maxservice'] + 1;
            $serviceArr = array();

            $this->dealer->table_name = 'dealer_info';
            $this->dealer->fields = 'dealer_id';
            $this->dealer->where = "dealer_name = '$receiver[dealer_name]' and state<>1";
            $dn = $this->dealer->getResult(3);
            if($dn){
                echo '<script>alert("添加失败，经销商名称已存在！");history.go(-1);</script>';die;
            }
            if(!empty($receiver[dealer_alias])){
              $this->dealer->where = "dealer_alias = '$receiver[dealer_alias]' and state<>1";
              $da = $this->dealer->getResult(3);
              if($da){
                  echo '<script>alert("添加失败，经销商简称已存在！");history.go(-1);</script>';die;
              }
            }
            if($receiver['state']==0){
                $this->dealer->where = "manage_user = '$receiver[manage_user]' and state<>1";
                $mu = $this->dealer->getResult(3);
                if($mu){
                    echo '<script>alert("添加失败，用户名已存在！");history.go(-1);</script>';die;
                }
            }
            
            $main_com = '';
            for($i=1; $i < $maxservice; $i++) {
              $sname = 'series_id'.$i;
              $series_id = intval($_POST[$sname]);
              if(!empty($series_id)){
                $main_com = $series_id;
              }
            }
            if($maxservice < 2 || !$series_id){
              echo '<script>alert("添加失败，主营不能为空！");history.go(-1);</script>';die;
            }
            
            $this->dealer->addDealer($receiver);
            $dealer_id = mysql_insert_id();
             $upload_dir = "../" . UPLOAD_DIR . "images/dealer_img/".$dealer_id;
            if(!is_dir($upload_dir) && !empty($upload_dir)){
                file::forcemkdir($upload_dir);
            }
            foreach ($_FILES as $k => $v) {
                $dir_pre = substr(WWW_ROOT, 0, -3);
                if($v['name']){
                    if($k == 'pic1'){
                        $oldPicArr[0] = $upload_dir.'/tp_'.$this->timestamp . rand(1000,9999).'.jpg';
                        @move_uploaded_file($v['tmp_name'], $dir_pre . $oldPicArr[0]);
                    }
                    if($k == 'pic2'){
                        $oldPicArr[1] = $upload_dir.'/tp_'.$this->timestamp . rand(1000,9999).'.jpg';
                        @move_uploaded_file($v['tmp_name'], $dir_pre . $oldPicArr[1]);
                    }
                    if($k == 'pic3'){
                        $oldPicArr[2] = $upload_dir.'/tp_'.$this->timestamp . rand(1000,9999).'.jpg';
                        @move_uploaded_file($v['tmp_name'], $dir_pre . $oldPicArr[2]);
                    }
//                    @copy($v['tmp_name'], $upload_dir .'/tp_'.$time.'jpg');
                }
            }
            foreach ($oldPicArr as $key => $list){
                $oldPicArr[$key] = substr($list, 2);
            }
            if(count($oldPicArr)!=0){
                if(count($oldPicArr)==1)
                    $arr['dealer_pic'] = $oldPicArr[0].'|';
                else
                    $arr['dealer_pic'] = implode('|', $oldPicArr);
            }else{
                $arr['dealer_pic'] = "";
            }
            $this->dealer->editDealer($arr, $dealer_id);
            $this->factory = new factory();
            $tempcamp = '';
            for($i=1; $i < $maxservice; $i++) {
                $bname = 'brand_id'.$i;
                $fname = 'factory_id'.$i;
                $sname = 'series_id'.$i;
                $brand_id = intval($_POST[$bname]);
                $factory_id = intval($_POST[$fname]);
                $series_id = intval($_POST[$sname]);
                if($brand_id) {
                    $serviceArr[$i]['dealer_id'] = $dealer_id;
                    $serviceArr[$i]['brand_id'] = $brand_id;
                    $serviceArr[$i]['factory_id'] = $factory_id;
                    $fname = $this->factory->getFactory($factory_id);
                    $serviceArr[$i]['series_id'] = $series_id;
                    $tempcamp .= $fname['factory_name'].',';
                }
            }
            $this->dealer->editDealer(array('dealer_camp'=>$tempcamp),$dealer_id);
            foreach($serviceArr as $row) {
                $this->service->insert_service($row);
            }
            $url = $_ENV['PHP_SELF'].'add';            
            echo '<script>';
            echo 'alert("添加成功！");';
            echo 'location.href="'.$url.'"';
            echo '</script>';
        }
        $this->brand = new brand();                                            
        $this->factory = new factory();        
        $this->series = new series();
        $province = $this->province->getProvince();
        $factory = '';
        $series = '';
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $type = $action == 'edit' ? '修改' : '增加';
        $this->tpl->assign('type', $type);
        $this->tpl->assign('brand', $brand);
        $this->tpl->assign('series', $series);
        $this->tpl->assign('factory', $factory);
        $this->tpl->assign('province', $province);
        $this->template($tpl_name);
    }
    
    function doDelservice() {
        $id = intval($_GET['id']);
        if($id) $this->service->delete_service($id);
    }


    function doDealerApply(){
        
        $tpl_name = 'dealer_applylist';
        $limit = 20;
        $page = max(1, intval($_GET['page']));
        $offset = ($page - 1) * $limit;
        $phpSelf = $_ENV['PHP_SELF'].'dealerapply';
       
        $list = $this->dealerapply->getList('', $limit, $offset);
        $page_bar = $this->multi($this->dealerapply->total, $limit, $page, $phpSelf.$condition);
        $this->tpl->assign('condition', $condition.'&page='.$page);
        $this->tpl->assign('list', $list);
        $this->tpl->assign('page_bar', $page_bar);
        $this->template($tpl_name);
    }

    function doApplyDetail(){
        $tpl_name = 'dealer_apply';
        $id = $_GET['id'];
        $apply = $this->dealerapply->getApplyById($id);
        $this->dealerapply->where ="id=$id";
        $this->dealerapply->ufields =array('state'=>1);
        $this->dealerapply->update();
        $this->tpl->assign('apply', $apply[0]);
        $this->template($tpl_name);
    }

    function chkAuth($id, $module_type = 'sys_module', $type_value = "A"){
      global $adminauth, $login_uid;
      $adminauth->checkAuth($login_uid, $module_type, $id, $type_value);
    }

    /*
    * 新首页,最新加入经销商
    */
    function doSsiIndexNewDealer() {
        $this->tpl_file = "ssi_cpindex_dealer";
        $this->dealer->group = "d.dealer_id";
        $newdealer=$this->dealer->getDealerandfactory("d.dealer_id,d.dealer_name,d.dealer_alias,c.factory_name", " d.dealer_id=s.dealer_id and s.factory_id=c.factory_id AND d.dealer_name<>'' and d.province_id=1 and d.state=0 ", array('d.created' => 'DESC'),10,0);
//        $newdealer=$this->dealer->getDealerandfactory("d.dealer_id,d.dealer_name,d.dealer_alias,c.factory_name", " d.dealer_id=s.dealer_id and s.factory_id=c.factory_id AND d.dealer_id in (312,133,59,154,186,112,142,1195,168,267) ", array('d.dealer_id' => 'DESC'),10,0);
//        echo $this->dealer->sql;exit;
        $this->tpl->assign('newdealer', $newdealer);
        $html = $this->fetch($this->tpl_file);
        $html = $this->replaceAttachServer($html);
        echo $html;
    }
    
    function doChkdname() {
        $dealer_name = strval($_GET["dealer_name"]);
        $dealer_id = $_GET['dealer_id'];
        $this->dealer->table_name = 'dealer_info';
        $this->dealer->fields = 'dealer_id';
        $this->dealer->where = "dealer_name = '$dealer_name' and state=0";
        if($dealer_id){
            $this->dealer->where = "dealer_name = '$dealer_name' and dealer_id<>$dealer_id and state=0";
        }
        $dealer_id = $this->dealer->getResult(3);
        if($dealer_id) echo 1;
        else echo -4;
    }
    
    function doChkdalias() {
        $dealer_alias = strval($_GET["dealer_alias"]);
        $dealer_id = $_GET['dealer_id'];
        $this->dealer->table_name = 'dealer_info';
        $this->dealer->fields = 'dealer_id';
        $this->dealer->where = "dealer_alias = '$dealer_alias' and state=0";
        if($dealer_id){
            $this->dealer->where = "dealer_alias = '$dealer_alias' and dealer_id<>$dealer_id and state=0";
        }
        $dealer_id = $this->dealer->getResult(3);
        if($dealer_id) echo 1;
        else echo -4;
    }
    
    function doChkuname() {
        $manage_user = iconv("UTF-8", "gbk", strval($_GET["manage_user"]));
        $dealer_id = $_GET['dealer_id'];
        $this->dealer->table_name = 'dealer_info';
        $this->dealer->fields = 'dealer_id';
        $this->dealer->where = "manage_user = '$manage_user' and state=0";
        if($dealer_id){
            $this->dealer->where = "manage_user = '$manage_user' and dealer_id<>$dealer_id and state=0";
        }
        $dealer_id = $this->dealer->getResult(3);
        if($dealer_id) echo 1;
        else echo -4;
    }    
    
    function doChangeCooperate(){
        $dealer_id = $_GET['id'];
        $state = $_GET['state'];
        
        $this->dealer->ufields = array(
            'state' => $state
        );
        $this->dealer->where = "dealer_id='{$dealer_id}'";
        $r = $this->dealer->update();
        echo intval($r);
    }
}

?>
