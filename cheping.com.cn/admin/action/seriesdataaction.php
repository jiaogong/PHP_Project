<?php

class seriesdataAction extends action {

    function __construct() {
        parent::__construct();
        $this->brand = new brand();
        $this->factory = new factory();
        $this->series = new series();
        $this->serieslog = new serieslog();
        $this->cardbmodel = new cardbModel();
        $this->cardbfile = new uploadFile();
        $this->checkAuth();
    }

    function doDefault() {
        $this->doList();
    }

    function doList() {

        $tpl_name = "series_data";
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $this->tpl->assign('brand', $brand);
        $this->template($tpl_name);
    }

    //按条件抓取
    function doCatchData() {
        $tpl_name = "series_data";

        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $this->tpl->assign('brand', $brand);

        $fields = "brand_name,factory_name,series_name,brand_id,factory_id,src_id,series_id";

        if ($_POST['series_id']) {
            $where = "series_id=$_POST[series_id]";
            $arr = $this->series->getSeriesFields($fields, $where, $_POST['series_id']);
        } elseif ($_POST['factory_id']) {
            $where = "factory_id=$_POST[factory_id] and state=3";
            $arr = $this->series->getSeriesFields($fields, $where, $_POST['factory_id']);
        } elseif ($_POST['brand_id']) {
            $where = "brand_id=$_POST[brand_id] and state=3";
            $arr = $this->series->getSeriesFields($fields, $where, $_POST['factory_id']);
        } else {
            $where = "state=3";
            $arr = $this->series->getSeriesFields($fields, $where, $_POST['factory_id']);
        }

        if ($arr) {
            foreach ($arr as $key => $value) {
                $id = $value['series_id'];
                $src_id = $value['src_id'];
                $p_url = "http://car.autohome.com.cn/config/series/" . $src_id . ".html";
                $this->checkAuth($id, 'series');
                session_write_close();
                $url = $p_url;
                

                $catch_obj = new CatchAutoCar();
                $catch_obj->getPageContent($url);
                $src_series = $catch_obj->getSeriesInfo();
                if ($src_series) {
                    $bingo_series = $catch_obj->getBingoSeriesData($src_series, $id);

                    if ($bingo_series['series_id']) {
                        $model_options = $catch_obj->analyzeSeriesModels();
                        $format_option = $catch_obj->formatSeriesOption($model_options, $bingo_series);
                        $ret = $catch_obj->addSeriesModels($format_option, $bingo_series);
                        foreach ($ret as $key => $vv) {
                            if ($key == 0) {
                                foreach ($vv as $k => $v) {
                                    $ret[$key][$k] = $v;
                                }
                            } else {
                                $ret[$key]['model_name'] = $ret[$key]['model_name'];
                            }
                        }
                    } else {
                        $ret = array(
                          'src_brand_name' => $bingo_series['src_brand_name'],
                          'src_factory_name' => $bingo_series['src_factory_name'],
                          'src_series_name' => $bingo_series['src_series_name'],
                          'brand_name' => $bingo_series['brand_name'],
                          'factory_name' => $bingo_series['factory_name'],
                          'series_name' => $bingo_series['series_name'],
                          'state' => 0,
                        );
                    }
                } else {
                    $ret = array(
                      'brand_name' => $value['brand_name'],
                      'factory_name' => $value['factory_name'],
                      'series_name' => $value['series_name'],
                      'state' => 0,
                    );
                }

                if ($ret['state'] === 0) {
                    $result['e'][] = $ret;
                } else {
                    $result['t'][] = $ret;
                }
                //抓取车系颜色
                $catch_obj->getPageContent($p_url);
                $modelColor = $catch_obj->getModelColor();
                $factoryName = $modelColor['model_name'][0]['paramitems'][2]['valueitems'][0]['value'];
                $factoryName = $factoryName;
                $modelId = array();
                foreach (array($modelColor['model_name'][0]['paramitems'][0]['valueitems']) as $key => $list) {
                    if(!empty($list))
                    foreach($list as $k=>$v){            
                        $v['value'] = iconv('utf-8', 'gbk', $v['value']);
                        preg_match('/(.*?)\s+(\d+款)(.*)/si', $v['value'], $temp);
                        $stemp = $temp[1];
                        $mtemp = $temp[2] . $temp[3];
                        //          $mtemp = iconv('utf-8','gbk',$mtemp);
                        //          $stemp = iconv('utf-8', 'gbk', $stemp);
                        $where = "factory_name='{$factoryName}' and series_name='{$stemp}' and model_name='{$mtemp}' and state in (3,8)";
                        $res = $this->cardbmodel->chkModel('series_id,model_id', $where, '', 1);
                        if (!empty($res)) {
                            $modelId[$v['specid']] = $res['model_id'];
                            $sid = $res['series_id'];
                        }
                    }
                }

                if (!empty($modelId)) {
                    $color = new color();
                    $colorN = $color->inserColor($modelColor['color'], $modelId, $sid);
                }


                //抓取车系热度
                $catchData = new CatchData();
                $hot_url = "http://www.autohome.com.cn/" . $src_id . "/";
                $catchData->catchResult($hot_url);
                $attentionMatches = $catchData->pregMatch('#<a href="\/spec\/[\d]+\/\#pvareaid=[\d]+">([^<]+)</a>.*? <span class="attention-value" style="width: ([\d]+)%;">#si');
     
                if (!empty($attentionMatches)) {
                    foreach ($attentionMatches[1] as $ka => $va) {
                        $cardbModel = new cardbModel();
                        $attention = $attentionMatches[2][$ka];
                        $where = "model_name = '$va' AND series_name = '{$value['series_name']}' AND state in (3, 7, 8)";
                        $ufields = array('views' => $attention);
                        $cardbModel->updateModel($ufields, $where);
                    }
                }

                $catch_obj->getStopSell($id);
            }
        }

        $this->vars("result_e", $result[e]);
        $this->vars("result_t", $result[t]);
        $this->template($tpl_name);
    }

    //按地址抓取
    function doCatchDataurl() {
        $tpl_name = "series_data";
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $this->tpl->assign('brand', $brand);
        $url = $_POST[seriesurl];
        @preg_match_all('%(\d+)%is', $url, $match);
        $dr = $match[1];
        if ($dr[0]) {
            $fields = "brand_name,factory_name,series_name,brand_id,factory_id,src_id,series_id";
            $where = "src_id = $dr[0] and state=3";
            $return = $this->series->getSeriesFields($fields, $where, $dr[0]);
            $id = $return[0]['series_id'];

            $this->checkAuth($id, 'series');
        }

        session_write_close();
        $catch_obj = new CatchAutoCar();
        $catch_obj->getPageContent($url);
        $src_series = $catch_obj->getSeriesInfo();

        if ($src_series) {
            $bingo_series = $catch_obj->getBingoSeriesData($src_series, $id);

            if ($bingo_series['series_id']) {
                $model_options = $catch_obj->analyzeSeriesModels();
                $format_option = $catch_obj->formatSeriesOption($model_options, $bingo_series);
                $ret = $catch_obj->addSeriesModels($format_option, $bingo_series);
                foreach ($ret as $key => $value) {
                    if ($key == 0) {
                        foreach ($value as $k => $v) {
                            $ret[$key][$k] = iconv('utf-8', 'gbk', $v);
                        }
                    } else {
                        $ret[$key][model_name] = iconv('utf-8', 'gbk', $ret[$key][model_name]);
                    }
                }
            } else {

                $ret = array(
                  'src_brand_name' => $bingo_series['src_brand_name'],
                  'src_factory_name' => $bingo_series['src_factory_name'],
                  'src_series_name' => $bingo_series['src_series_name'],
                  'brand_name' => $bingo_series['brand_name'],
                  'factory_name' => $bingo_series['factory_name'],
                  'series_name' => $bingo_series['series_name'],
                  'state' => 0,
                );
            }
        } else {
            $ret = array(
              'brand_name' => $return[0]['brand_name'],
              'factory_name' => $return[0]['factory_name'],
              'series_name' => $return[0]['series_name'],
              'state' => 0,
            );
        }
        //抓取车系颜色
        $this->checkAuth($id, 'series');
        session_write_close();
        $catch_obj->getPageContent($url);
        $modelColor = $catch_obj->getModelColor();
        $factoryName = $modelColor['model_name'][0]['paramitems'][2]['valueitems'][0]['value'];
        $factoryName = iconv('utf-8', 'gbk', $factoryName);
        $modelId = array();
        if ($modelColor['model_name'][0]['paramitems'][0]['valueitems']) {
            foreach ($modelColor['model_name'][0]['paramitems'][0]['valueitems'] as $key => $v) {
           
                //foreach($list as $k=>$v){
                       $v['value'] = iconv('utf-8', 'gbk', $v['value']);
                        preg_match('/(.*?)\s+(\d+款)(.*)/si', $v['value'], $temp);
                        $stemp = $temp[1];
                        $mtemp = $temp[2] . $temp[3];
                        $where = "factory_name='{$factoryName}' and series_name='{$stemp}' and model_name='{$mtemp}' and state in (3,8)";
                        $res = $this->cardbmodel->chkModel('series_id,model_id', $where, '', 1);
                        if (!empty($res)) {
                            $modelId[$v['specid']] = $res['model_id'];
                            $sid = $res['series_id'];
                        }
                }
             
            //}
        }


        if (!empty($modelId)) {
            $color = new color();
            $colorN = $color->inserColor($modelColor['color'], $modelId, $sid);
        }


        //抓取车系热度
        $catchData = new CatchData();
        $hot_url = str_replace('options.html', '', $url);
        $catchData->catchResult($hot_url);
        $attentionMatches = $catchData->pregMatch('#<a href="/spec/[\d]+/\#pvareaid=[\d]+" data-location="[^"]+">([^<]+)</a>.*? <span class="attention-value" style="width: ([\d]+)%;">#si');
        $series_name = $return[0][series_name];
        if (!empty($attentionMatches)) {
            foreach ($attentionMatches[1] as $ka => $va) {
                $cardbModel = new cardbModel();
                $attention = $attentionMatches[2][$ka];
                $where = "model_name = '$va' AND series_name = '$series_name' AND state in (3, 7, 8)";

                $ufields = array('views' => $attention);
                $cardbModel->updateModel($ufields, $where);
            }
        }
        if ($ret['state'] === 0) {
            $result['e'][] = $ret;
        } else {
            $result['t'][] = $ret;
        }
        $this->vars("result_e", $result[e]);
        $this->vars("result_t", $result[t]);
        $this->template($tpl_name);
    }

    function checkAuth() {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, 'sys_module', 201, 'A');
    }

    function doUpdateSeriesLog() {
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $this->tpl->assign('brand', $brand);
        $tpl_name = "serieslog";
        $page = $_GET['page'];
        $page = max(1, $page);
        $extra = "&page=" . $page;
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $where = "state in(1,3)";
        // var_dump($_POST);
        if ($_REQUEST[series_id]) {
            $model = $this->cardbmodel->chkModel("model_id,model_name", "series_id=$_REQUEST[series_id] and state=3", '', 2);
            $this->vars("model", $model);
            $where .=" and series_id=$_REQUEST[series_id]";
            $this->vars("series_id", $_REQUEST[series_id]);
            $extra .="&series_id=" . $_REQUEST[series_id];
        }
        if ($_REQUEST[factory_id]) {
            $series = $this->series->getSeriesFields("series_id,series_name", "factory_id=$_REQUEST[factory_id] and state=3", 2);
            $this->vars("series", $series);
            $where .=" and factory_id=$_REQUEST[factory_id]";
            $this->vars("factory_id", $_REQUEST[factory_id]);
            $extra .="&factory_id=" . $_REQUEST[factory_id];
        }
        if ($_REQUEST[brand_id]) {
            $factory = $this->factory->getFactorylist("factory_id,factory_name", "brand_id=$_REQUEST[brand_id] and state=3", 2);
            $this->vars("factory", $factory);
            $where .=" and brand_id=$_REQUEST[brand_id]";
            $this->vars("brand_id", $_REQUEST[brand_id]);
            $extra .="&brand_id=" . $_REQUEST[brand_id];
        }
        if ($_REQUEST[model_id]) {
            $where .=" and model_id=$_REQUEST[model_id]";
            $this->vars("model_id", $_REQUEST[model_id]);
            $extra .="&model_id=" . $_REQUEST[model_id];
        }

        if ($_REQUEST[start_time]) {
            $start_time = strtotime($_REQUEST[start_time]);
            $this->vars("start_time", $start_time);
            $where .=" and add_time>$start_time";
            $extra .="&start_time=" . $_REQUEST[start_time];
        }
        if ($_REQUEST[end_time]) {
            $end_time = strtotime($_REQUEST[end_time]);
            $this->vars("end_time", $end_time);
            $where .=" and add_time<$end_time";
            $extra .="&add_time=" . $_REQUEST[add_time];
        }
        if ($_REQUEST[state]) {
            $this->vars("state", $_REQUEST[state]);
            $where .=" and state=$_REQUEST[state]";
            $extra .="&state=" . $_REQUEST[state];
        }

        $total = $this->serieslog->getListNum($where);
        $result = $this->serieslog->getList($where, $page_start, $page_size);
        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . 'UpdateSeriesLog' . $extra);
        $this->vars('page_bar', $page_bar);
        $this->vars("list", $result);
        $this->vars('extra', $extra);
        $this->template($tpl_name);
    }

    function doUpdateSeriesLogList() {
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $this->tpl->assign('brand', $brand);
        $tpl_name = "serieslog_list";
        $page = $_GET['page'];
        $page = max(1, $page);
        $extra = ''; #"page=".$page;
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $where = "state in(2,4,5)";
        if ($_REQUEST[series_id]) {
            $model = $this->cardbmodel->chkModel("model_id,model_name", "series_id=$_REQUEST[series_id] and state=3", '', 2);
            $this->vars("model", $model);
            $where .=" and series_id=$_REQUEST[series_id]";
            $this->vars("series_id", $_REQUEST[series_id]);
            $extra .="&series_id=" . $_REQUEST[series_id];
        }
        if ($_REQUEST[factory_id]) {
            $series = $this->series->getSeriesFields("series_id,series_name", "factory_id=$_REQUEST[factory_id] and state=3", 2);
            $this->vars("series", $series);
            $where .=" and factory_id=$_REQUEST[factory_id]";
            $this->vars("factory_id", $_REQUEST[factory_id]);
            $extra .="&factory_id=" . $_REQUEST[factory_id];
        }
        if ($_REQUEST[brand_id]) {
            $factory = $this->factory->getFactorylist("factory_id,factory_name", "brand_id=$_REQUEST[brand_id] and state=3", 2);
            $this->vars("factory", $factory);
            $where .=" and brand_id=$_REQUEST[brand_id]";
            $this->vars("brand_id", $_REQUEST[brand_id]);
            $extra .="&brand_id=" . $_REQUEST[brand_id];
        }
        if ($_REQUEST[model_id]) {
            $where .=" and model_id=$_REQUEST[model_id]";
            $this->vars("model_id", $_REQUEST[model_id]);
            $extra .="&model_id=" . $_REQUEST[model_id];
        }


        if ($_REQUEST[start_time]) {
            $start_time = strtotime($_REQUEST[start_time]);
            $this->vars("start_time", $start_time);
            $where .=" and update_time>$start_time";
            $extra .="&start_time=" . $_REQUEST[start_time];
        }
        if ($_REQUEST[end_time]) {
            $end_time = strtotime($_REQUEST[end_time]);
            $this->vars("end_time", $end_time);
            $where .=" and update_time<$end_time";
            $extra .="&add_time=" . $_REQUEST[add_time];
        }
        if ($_REQUEST[state]) {
            $this->vars("state", $_REQUEST[state]);
            $where .=" and state=$_REQUEST[state]";
            $extra .="&state=" . $_REQUEST[state];
        }
        $total = $this->serieslog->getListNum($where);
        $result = $this->serieslog->getList($where, $page_start, $page_size);
        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . 'UpdateSeriesLogList&' . $extra);
        $this->vars('page_bar', $page_bar);
        $this->vars("list", $result);
        $this->vars('extra', $extra);
        $this->template($tpl_name);
    }

    function doSeriesLogList_update() {
        $state = $_GET[state];
        $id = $_GET[id];
        $author = session('username');
        $this->serieslog->ufields = array("state" => 5, "author" => "$author", "update_time" => time());
        $this->serieslog->where = "id=$id and state=$state";
        $r2 = $this->serieslog->update();
        if ($r2) {
            $this->alert('操作成功', 'js', 2);
        } else {
            $this->alert('操作失败', 'js', 2);
        }
    }

    function doFilesModelLog_update() {
        $state = $_GET[state];
        $id = $_GET[id];
        $author = session('username');
        $this->serieslog->ufields = array("state" => 12, "author" => "$author", "update_time" => time());
        $this->serieslog->where = "id=$id and state=$state";
        $r2 = $this->serieslog->update();
        if ($r2) {
            $this->alert('操作成功', 'js', 2);
        } else {
            $this->alert('操作失败', 'js', 2);
        }
    }

    function doNewUpdate() {
        $model_id = $this->getValue('modelid')->Int();
        $series_id = $this->getValue('seriesid')->Int(); //$_GET[seriesid];
        $state = $this->getValue('state')->Int();//$_GET[state];
        if ($_REQUEST[series_id]) {
            $extra .="&series_id=" . $_REQUEST[series_id];
        }
        if ($_REQUEST[factory_id]) {

            $extra .="&factory_id=" . $_REQUEST[factory_id];
        }
        if ($_REQUEST[brand_id]) {

            $extra .="&brand_id=" . $_REQUEST[brand_id];
        }
        if ($_REQUEST[model_id]) {

            $extra .="&model_id=" . $_REQUEST[model_id];
        }

        if ($_REQUEST[start_time]) {
            $extra .="&start_time=" . $_REQUEST[start_time];
        }
        if ($_REQUEST[end_time]) {

            $extra .="&add_time=" . $_REQUEST[add_time];
        }
        if ($_REQUEST[state]) {
            $extra .="&state=" . $_REQUEST[state];
        }
        if ($_REQUEST[page]) {
            $extra .="&page=" . $_REQUEST[page];
        }
        $author = session('username');
        if ($state == 3) {
            $this->cardbmodel->ufields = array("state" => 9);
            $this->cardbmodel->where = "model_id=$model_id";
            $r1 = $this->cardbmodel->update();
            if(!$r1){
                $this->cardbmodel->where = "model_id=$model_id and state=9";
                $r1 = $this->cardbmodel->getResult(3);
            }
            if ($r1) {
                $this->serieslog->ufields = array("state" => 4, "author" => "$author", "update_time" => time());
                $this->serieslog->where = "model_id=$model_id and state=3";
                $r2 = $this->serieslog->update();
            }
            if ($r1 && $r2) {
                $this->alert('操作成功', 'js', 3, $_ENV['PHP_SELF'] . "updateserieslog" . $extra);
            } else {
                $this->alert('操作失败', 'js', 3, $_ENV['PHP_SELF'] . "updateserieslog" . $extra);
            }
        } elseif($state == 1) {

            $grabpic = new grabpicAction();
            $grabpic->doPic('', '', $model_id);
            $r1 = $this->cardbfile->getOneUploadFile("type_id=$model_id and type_name='model'");
            if ($r1) {
                $this->serieslog->ufields = array("state" => 2, "author" => "$author", "update_time" => time());
                $this->serieslog->where = "model_id=$model_id and state=1";
                $r2 = $this->serieslog->update();
            }

            if ($r1 && $r2) {
                $this->alert('操作成功', 'js', 3, $_ENV['PHP_SELF'] . "updateserieslog" . $extra);
            } else {
                $this->alert('操作失败', 'js', 3, $_ENV['PHP_SELF'] . "updateserieslog" . $extra);
            }
            $this->serieslog->ufields = array("state" => 2, "author" => "$author", "update_time" => time());
            $this->serieslog->where = "model_id=$model_id and state=1";
            $r2 = $this->serieslog->update();
        }
    }

    //抓取车系列表
    function doFileSeriesList() {
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $this->tpl->assign('brand', $brand);


        $page = $_GET['page'];
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $where = "file_state !=0";
        if ($_REQUEST[series_id]) {
            $model = $this->cardbmodel->chkModel("model_id,model_name", "series_id=$_REQUEST[series_id] and state=3", '', 2);
            $this->vars("model", $model);
            $where .=" and series_id=$_REQUEST[series_id]";
            $this->vars("series_id", $_REQUEST[series_id]);
            $extra .="&series_id=" . $_REQUEST[series_id];
        }
        if ($_REQUEST[factory_id]) {
            $series = $this->series->getSeriesFields("series_id,series_name", "factory_id=$_REQUEST[factory_id] and state=3", 2);
            $this->vars("series", $series);
            $where .=" and factory_id=$_REQUEST[factory_id]";
            $this->vars("factory_id", $_REQUEST[factory_id]);
            $extra .="&factory_id=" . $_REQUEST[factory_id];
        }
        if ($_REQUEST[brand_id]) {
            $factory = $this->factory->getFactorylist("factory_id,factory_name", "brand_id=$_REQUEST[brand_id] and state=3", 2);
            $this->vars("factory", $factory);
            $where .=" and brand_id=$_REQUEST[brand_id]";
            $this->vars("brand_id", $_REQUEST[brand_id]);
            $extra .="&brand_id=" . $_REQUEST[brand_id];
        }

        if ($_REQUEST[start_time]) {
            $start_time = strtotime($_REQUEST[start_time]);
            $this->vars("start_time", $start_time);
            $where .=" and add_time>$start_time";
            $extra .="&start_time=" . $_REQUEST[start_time];
        }
        if ($_REQUEST[end_time]) {
            $end_time = strtotime($_REQUEST[end_time]);
            $this->vars("end_time", $end_time);
            $where .=" and add_time<$end_time";
            $extra .="&end_time=" . $_REQUEST[end_time];
        }
        if ($_REQUEST[id] == 'brand') {
            $tpl_name = "fileserieslog_list_brand";
            $where .=" and file_state =1";
            $extra .="&id=" . $_REQUEST[brand];
        } elseif ($_REQUEST[id] == 'factory') {
            $tpl_name = "fileserieslog_list_factory";
            $where .=" and file_state =2";
            $extra .="&id=" . $_REQUEST[factory];
        } elseif ($_REQUEST[id] == 'model') {
            $tpl_name = "fileserieslog_list_model";
            if ($_REQUEST['state']) {
                $where .=" and state =$_REQUEST[state]";
                $extra .="&state=" . $_REQUEST[state];
            } else {
                $where .=" and state in(11,10,12)";
            }
            $where = str_replace('file_state !=0 and', '', $where);
            $extra .="&id=" . $_REQUEST[model];
        } else {
            $tpl_name = "fileserieslog_list";
            $where .=" and file_state in(3,4)";
        }

        $total = $this->serieslog->getListNum($where);
        //echo $this->serieslog->sql;
        $result = $this->serieslog->getList($where, $page_start, $page_size);
        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . 'FileSeriesList' . $extra);
        $this->vars('page_bar', $page_bar);
        $this->vars("list", $result);
        $this->template($tpl_name);
    }

}

?>
