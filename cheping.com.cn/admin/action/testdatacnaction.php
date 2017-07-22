<?php
/*
 * 车辆测试数据管理（中国区）
 * testdatacn action
 * $Id: testdatacnaction.php 3173 2016-06-23 04:05:05Z wangchangjiang $
 */

class testdatacnAction extends action{

    var $brand;
    var $testcn;

    function __construct(){
        $this->checkAuth(820, 'sys_module', 'A');
        $this->brand = new brand();
        $this->testcn = new cardbModelDataCN();
        parent::__construct();
    }

    function doDefault(){
        $this->doTestDataCNList();
    }
    //测试数据列表
    function doTestDataCNList(){
        $this->tpl_file = "testdatacnlist";
        $this->page_title = "测试数据(中国区)列表";
        $brand_list = $this->brand->getAllBrand("state in (3,8,9,11)", array('letter' => 'asc'));
        $brand_id = $this->postValue("brand_id")->Int();
        $factory_id = $this->postValue("factory_id")->Int();
        $series_id = $this->postValue("series_id")->Int();
        $model_id = $this->postValue("model_id")->Int();
        $brand_name = $this->postValue("brand_name")->String();
        $factory_name = $this->postValue("factory_name")->String();
        $series_name = $this->postValue("series_name")->String();
        $model_name = $this->postValue("model_name")->String();
        $model_name_m = $this->postValue("model_name_m")->String();
        $id = $this->postValue("id")->Int();
        if($model_name_m){
            $model_name = $model_name_m;
        }
        $where = "";
        if($model_name || $id){
            if($model_name && !$id) {
                $where = "model_name='{$model_name}'";
            }elseif(!$model_name && $id){
                $where = "id={$id}";
            }elseif($model_name && $id){
                $where = "id={$id} and model_name='{$model_name}'";
            }
            if($model_name && $model_id){
                $where .= " and model_id={$model_id}";
            }
            $s_arr = array(
                "brand_id" => $brand_id,
                "factory_id" => $factory_id,
                "series_id" => $series_id,
                "model_id" => $model_id,
                "brand_name" => $brand_name,
                "factory_name" => $factory_name,
                "series_name" => $series_name,
                "model_name" => $model_name,
                "id" => $id,
            );
            $this->vars('s' , $s_arr);
        }
        $page = $this->getValue('page')->Int();
        $page = max(1, $page);
        $page_size = 18;
        $page_start = ($page - 1) * $page_size;
        $list = $this->testcn->getList("id,model_id,model_name,address,tester,date_ymd,inputuser,created,state", "{$where}", true, 2, array("created"=>"DESC"), $page_start, $page_size);
        $total = $this->testcn->total;
        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . "TestDataCNList");
        $this->vars('list', $list);
        $this->vars('page_bar', $page_bar);
        $this->vars('brand', $brand_list);
        $this->template();
    }
    //添加 / 编辑   测试数据
    function doAdd(){
        global $login_uname;
        $this->tpl_file = "testdatacnadd";
        $switch = $res = '';
        $oc_arr = $data = array();
        $brand_list = $this->brand->getAllBrand("state in (3,8,9,11)", array('letter' => 'asc'));
        $model_id = $this->getValue("model_id")->Int();
        $model_name = $this->getValue("model_name")->String();
        $id = $this->getValue("id")->Int();
        if(!$id){
            $switch = "添加";
        }else{
            $switch = "编辑";
            $this->vars('id', $id);
            $getCarNameAndData_where = "id={$id}";
            $list = $this->testcn->getCarNameAndData("*", $getCarNameAndData_where);
            if ($list) {
                $list['w'] = str2arr($list['weight']);
                $list['s'] = str2arr($list['speed']);
                $list['b'] = str2arr($list['brake']);
                $list['bd'] = str2arr($list['brake_disc']);
                $list['ls'] = str2arr($list['low_speed']);
                $list['hs'] = str2arr($list['high_speed']);
                $list['pk'] = str2arr($list['poor_km']);
                $list['n'] = str2arr($list['noise']);
                $list['sn'] = str2arr($list['size_normal']);
                $list['sov'] = str2arr($list['size_other_van']);
                $list['t'] = str2arr($list['turning']);
                $this->vars('data', $list);
            }
        }
        if($_POST) {
            $event = $this->postValue("event")->String();
            $model_name_post = $this->postValue("model_name")->String();
            $model_name_post_m = $this->postValue("model_name_m")->String();
            $model_id_post = $this->postValue("model_id")->Int();
            $id_post = $this->postValue("id")->Int();
            $brand_name = $this->postValue("brand_name")->String();
            $factory_name = $this->postValue("factory_name")->String();
            $series_name = $this->postValue("series_name")->String();
            $car_hs = $this->postValue("car_hs")->Int();
            $price = $this->postValue("price")->String();
            $drive = $this->postValue("drive")->String();
            $class = $this->postValue("class")->String();
            $number = $this->postValue("number")->Int();
            $weight = $this->postValue("w")->Val();
            $weight = $this->arr2str($weight);
            $speed = $this->postValue("s")->Val();
            $speed = $this->arr2str($speed);
            $brake = $this->postValue("b")->Val();
            $brake = $this->arr2str($brake);
            $cold_brake = $this->postValue("cold_brake")->String();
            $brake_5 = $this->postValue("brake_5")->String();
            $hot_brake = $this->postValue("hot_brake")->String();
            $brake_disc = $this->postValue("bd")->Val();
            $brake_disc = $this->arr2str($brake_disc);
            $esp_on_18 = $this->postValue("esp_on_18")->String();
            $esp_off_18 = $this->postValue("esp_off_18")->String();
            $security_wire = $this->postValue("security_wire")->String();
            $esp_on_100 = $this->postValue("esp_on_100")->String();
            $esp_off_100 = $this->postValue("esp_off_100")->String();
            $low_speed = $this->postValue("ls")->Val();
            $low_speed = $this->arr2str($low_speed);
            $high_speed = $this->postValue("hs")->Val();
            $high_speed = $this->arr2str($high_speed);
            $poor_km = $this->postValue("pk")->Val();
            $poor_km = $this->arr2str($poor_km);
            $noise = $this->postValue("n")->Val();
            $noise = $this->arr2str($noise);
            $size_normal = $this->postValue("sn")->Val();
            $size_normal = $this->arr2str($size_normal);
            $size_other_van = $this->postValue("sov")->Val();
            $size_other_van = $this->arr2str($size_other_van);
            $turning = $this->postValue("t")->Val();
            $turning = $this->arr2str($turning);
            $oc = $this->postValue("oc")->Val();
            if (is_array($oc)) {
                foreach ($oc as $i => $v) {
                    $oc_arr["oc" . ($i + 1)] = $v;
                }
            }
            $test_oc = $this->postValue("test_oc")->String();
            $jingang = $this->postValue("jingang")->String();
            $ruisi = $this->postValue("ruisi")->String();
            $ams = $this->postValue("ams")->String();
            $date_ymd = $this->postValue("date_ymd")->String();
            $address = $this->postValue("address")->String();
            $tt = $this->postValue("tt")->String();
            $kw = $this->postValue("kw")->String();
            $tester = $this->postValue("tester")->String();
            $operator = $this->postValue("operator")->String();
            $weather = $this->postValue("weather")->String();
            $post_date = $this->postValue("post_date")->String();
            $type = $this->postValue("type")->String();
            $state = $this->postValue("state")->Int();

            $inputuser = $login_uname;
            $modifier = $login_uname;
            $created = time();
            $updated = time();
            if($model_name_post_m){
                $model_name_post = $model_name_post_m;
            }
            $data = array(
                "car_hs" => $car_hs,
                "price" => $price,
                "drive" => $drive,
                "class" => $class,
                "number" => $number,
                "weight" => $weight,
                "speed" => $speed,
                "brake" => $brake,
                "cold_brake" => $cold_brake,
                "brake_5" => $brake_5,
                "hot_brake" => $hot_brake,
                "brake_disc" => $brake_disc,
                "esp_on_18" => $esp_on_18,
                "esp_off_18" => $esp_off_18,
                "security_wire" => $security_wire,
                "esp_on_100" => $esp_on_100,
                "esp_off_100" => $esp_off_100,
                "low_speed" => $low_speed,
                "high_speed" => $high_speed,
                "poor_km" => $poor_km,
                "noise" => $noise,
                "size_normal" => $size_normal,
                "size_other_van" => $size_other_van,
                "turning" => $turning,
                "test_oc" => $test_oc,
                "jingang" => $jingang,
                "ruisi" => $ruisi,
                "ams" => $ams,
                "date_ymd" => $date_ymd,
                "address" => $address,
                "tt" => $tt,
                "kw" => $kw,
                "tester" => $tester,
                "operator" => $operator,
                "weather" => $weather,
                "post_date" => $post_date,
                "type" => $type,
                "state" => $state,
                "updated" => $updated,
            );

            if(!$event && !$id_post && !$id){
                $switch = "添加";
                $data["model_id"] = $model_id_post;
                $data["model_name"] = $model_name_post;
                $data["brand_name"] = $brand_name;
                $data["factory_name"] = $factory_name;
                $data["series_name"] = $series_name;
                $data["created"] = $created;
                $data["inputuser"] = $inputuser;
                $data = array_merge($data, $oc_arr);
                $this->testcn->ufields = $data;
                $res = $this->testcn->insert();
            }elseif($event == "edit" && $id_post && $id){
                $switch = "编辑";
                $data["modifier"] = $modifier;
                $data = array_merge($data, $oc_arr);
                $this->testcn->where = "id={$id_post}";
                $this->testcn->ufields = $data;
                $res = $this->testcn->update();
            }
            $prompt = $res ? "成功" : "失败";
            $this->alert("测试数据{$switch}{$prompt}！", 'js', 3, $_ENV['PHP_SELF'] . 'TestDataCNList');
        }

        $this->page_title = "{$switch}测试数据";
        $this->vars('brand', $brand_list);
        $this->vars('switch', $switch);
        $this->template();
        
    }

    function checkAuth($id, $module_type = 'sys_module', $type_value = "A"){
      global $adminauth, $login_uid;
      $adminauth->checkAuth($login_uid, $module_type, $id, 'A');
    }

    /**
     * 将数组以 “|” 拆分成字符串
     * @param $arr
     * @return bool|string
     */
    private function arr2str($arr){
        if(is_array($arr)){
            return implode("|", $arr);
        }else{
            return $arr;
        }
    }

}