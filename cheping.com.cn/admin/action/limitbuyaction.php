<?php
class limitBuyAction extends action {
    function __construct() {
        parent::__construct();        
    }
    function doDefault() {
        $this->doList();        
    }

    function doList() {
//        $this->checkAuth(209, 'sys_module', 'A');
//
//        $pageData = new pageData();
//        if(!empty($_POST)) {
//            $upload = new uploadFile();
//            $model_id = intval($_POST['model_id']);
//            $ad_word = strval($_POST['ad_word']);
//            $flag = intval($_POST['flag']);
//            $ad_img = $_FILES['ad_img'];
//            $model_img = $_FILES['model_img'];
//            if($ad_img['size']) $pic = $upload->uploadAdPic($ad_img);
//            if($model_img['size']) $model_pic = $upload->uploadAdPic($model_img);
//            $ret = array(
//                'model_pic' => $model_pic,
//                'model_id' => $model_id,
//                'pic'      => $pic,
//                'ad_word'  => $ad_word,
//                'flag'     => $flag
//            );
//            $s = $pageData->addPageData(array(
//              'name' => 'limitbuy',
//              'value' => $ret,
//              'c1' => 'index',
//              'c2' => '1',
//              'c3' => 0,
//            ));
//            //$this->action2File('index.php?action=static-SsiIndexHotModels1', SITE_ROOT.'../ssi/index_xianshi.shtml');
//
//            if($s){
//              $msg = "操作成功!";
//            }else{
//              $msg = "操作失败!";
//            }
//            $message = array(
//              'type' => 'js',
//              'message' => $msg,
//              'act' => 3,
//              'url' => 'index.php?action=limitbuy'
//            );
//            $this->alert($message);
//        }
//        else {
//            $tpl_name = 'limit_buy';
//            $result = $pageData->getPageData(
//              array(
//                'name' => 'limitbuy',
//                'c1' => 'index',
//                'c2' => '1',
//                'c3' => 0,
//              )
//            );
//            $value = unserialize($result['value']);
//            $this->tpl->assign('limit_info', $value[0]);
//            $this->template($tpl_name);
//        }
        $this->doLimitbuy();
    }
    
    /**
     * 首页限量
     */
    function doLimitCar() {
        $this->checkAuth(212, 'sys_module', 'A');
        $this->page_title = "首页限量";
        $this->tpl_file = "limit_car";
        $pd_obj = new pageData();
        $fact_obj = new factory();
        $series_obj = new series();
        $model_obj = new cardbModel();
        
        $upload_obj = new uploadFile();
        $pic_num = 3;

        if($_POST) {
            
            $ret = array();
            for($i=1; $i<= $pic_num; $i++) {
                $title = $_POST['title_' . $i];
                $ts['title'] = $title;
                $num = $_POST['num_' . $i];
                $ts['num'] = $num;
                $dnum = $_POST['dnum_' . $i];
                $ts['dnum'] = $dnum;
                $flag = $_POST['flag_' . $i];
                $ts['flag'] = $flag;
                $model_id = $_POST['model_id_' . $i];
                $pic = $_FILES['pic_' . $i];

                $model = $model_obj->getModel($model_id);

                $ts['model'] = $model;

                if($pic['size']) {
                    $pic['type_name'] = "adpic";
                    $pic['thumb_size'] = "236x132";
                    $t = $upload_obj->uploadBrandPic($pic);
                    if($t) {
                        $ts['pic'] = $pic_url = $pic['type_name'] . '/' . $t;
                    }
                }else{
                    $old_pic = $_POST["old_pic_".$i];
                    if($old_pic){
                        $ts['pic'] = $old_pic;
                    }
                }

                $ret[] = $ts;

            }

            $s = $pd_obj->addPageData(array(
                    'name' => 'limitcar',
                    'value' => $ret,
                    'c1' => 'index',
                    'c2' => '1',
                    'c3' => 0,
            ));
            if($s) {
                $msg = "成功";
            }else {
                $msg = "失败";
            }
            $message = array(
                    'type' => 'js',
                    'message' => $this->page_title."操作". $msg,
                    'act' => 3,
                    'url' => $_ENV['PHP_SELF'] . "limitcar"
            );
            $this->alert($message);
        }else {
            $brand_obj = new brand();
            $brand_list = $brand_obj->getAllBrand('state=3', array('letter' => 'asc'), 200);
            $this->tpl->assign('brand', $brand_list);
            
            $result = $pd_obj->getPageData(
                    array(
                    'name' => 'limitcar',
                    'c1' => 'index',
                    'c2' => '1',
                    'c3' => 0,
                    )
            );

            $focus_val = unserialize($result['value']);

            if(!empty($focus_val)){
                foreach ((array)$focus_val[0] as $k => $v) {
                    if($v['model']['brand_id']) {
                        $factory = $fact_obj->getFactoryByBrand($v['model']['brand_id']);
                        $this->tpl->assign('factory_' . $k, $factory);
                    }
                    if($v['model']['factory_id']) {
                        $series = $series_obj->getAllSeries(
                                "(s.state=3 or s.state=11) and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.factory_id='{$v['model']['factory_id']}'",
                                array('s.letter' => 'asc'),
                                100
                        );
                        #var_dump($series_obj->sql);
                        $this->tpl->assign('series_' . $k, $series);
                    }
                    if($v['model']['series_id']) {
                        $model = $model_obj->getAllModel(
                                "(m.state=3 or m.state=7 or m.state=8 or m.state=11) and m.series_id=s.series_id and s.factory_id=f.factory_id and f.brand_id=b.brand_id
              and m.series_id='{$v['model']['series_id']}'",
                                array(),
                                100
                        );
                        $this->tpl->assign('model_' . $k, $model);
                    }
                }
            }
//            print_r($focus_val[0]);exit;
            $this->vars('hotcarseries', $focus_val[0]);
            $this->vars('pic_num', $pic_num);
            $this->template();
            
        }

    }

    /**
     * 首页限时抢购
     */
    function doLimitbuy() {
        $this->checkAuth(212, 'sys_module', 'A');
        $this->page_title = "首页限时";
        $this->tpl_file = "limit_buy";
        $pd_obj = new pageData();
        $fact_obj = new factory();
        $series_obj = new series();
        $model_obj = new cardbModel();

        $upload_obj = new uploadFile();
        $pic_num = 3;

        if($_POST) {

            $ret = array();
            for($i=1; $i<= $pic_num; $i++) {
                $title = $_POST['title_' . $i];
                $ts['title'] = $title;
                $startdate =  $_POST['startdate_' . $i]." ".$_POST['hour_' . $i].":00:00";
                $ts['starttime'] = strtotime($startdate);

                $enddate = $_POST['enddate_' . $i];
                $ts['enddate'] = $enddate;
                $flag = $_POST['flag_' . $i];
                $ts['flag'] = $flag;
                $model_id = $_POST['model_id_' . $i];
                $pic = $_FILES['pic_' . $i];

                $model = $model_obj->getModel($model_id);

                $ts['model'] = $model;

                if($pic['size']) {
                    $pic['type_name'] = "adpic";
                    $pic['thumb_size'] = "236x132";
                    $t = $upload_obj->uploadBrandPic($pic);
                    if($t) {
                        $ts['pic'] = $pic_url = $pic['type_name'] . '/' . $t;
                    }
                }else{
                    $old_pic = $_POST["old_pic_".$i];
                    if($old_pic){
                        $ts['pic'] = $old_pic;
                    }
                }

                $ret[] = $ts;

            }

            $s = $pd_obj->addPageData(array(
                    'name' => 'limitbuy',
                    'value' => $ret,
                    'c1' => 'index',
                    'c2' => '1',
                    'c3' => 0,
            ));
            if($s) {
                $msg = "成功";
            }else {
                $msg = "失败";
            }
            $message = array(
                    'type' => 'js',
                    'message' => $this->page_title."操作". $msg,
                    'act' => 3,
                    'url' => $_ENV['PHP_SELF']
            );
            $this->alert($message);
        }else {
            $brand_obj = new brand();
            $brand_list = $brand_obj->getAllBrand('state=3', array('letter' => 'asc'), 200);
            $this->tpl->assign('brand', $brand_list);

            $result = $pd_obj->getPageData(
                    array(
                    'name' => 'limitbuy',
                    'c1' => 'index',
                    'c2' => '1',
                    'c3' => 0,
                    )
            );

            $focus_val = unserialize($result['value']);

            if(!empty($focus_val)) {
                foreach ((array)$focus_val[0] as $k => $v) {
                    if($v['model']['brand_id']) {
                        $factory = $fact_obj->getFactoryByBrand($v['model']['brand_id']);
                        $this->tpl->assign('factory_' . $k, $factory);
                    }
                    if($v['model']['factory_id']) {
                        $series = $series_obj->getAllSeries(
                                "(s.state=3 or s.state=11) and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.factory_id='{$v['model']['factory_id']}'",
                                array('s.letter' => 'asc'),
                                100
                        );
                        #var_dump($series_obj->sql);
                        $this->tpl->assign('series_' . $k, $series);
                    }
                    if($v['model']['series_id']) {
                        $model = $model_obj->getAllModel(
                                "(m.state=3 or m.state=7 or m.state=8 or m.state=11) and m.series_id=s.series_id and s.factory_id=f.factory_id and f.brand_id=b.brand_id
                  and m.series_id='{$v['model']['series_id']}'",
                                array(),
                                100
                        );
                        $this->tpl->assign('model_' . $k, $model);
                    }
                }
            }
    //            print_r($focus_val[0]);exit;
            $this->vars('hotcarseries', $focus_val[0]);
            $this->vars('pic_num', $pic_num);
            $this->template();

        }

    }


    function checkAuth($id, $module_type = 'sys_module', $type_value = "A"){
      global $adminauth, $login_uid;
      $adminauth->checkAuth($login_uid, $module_type, $id, 'A');
    }            
}  
?>
