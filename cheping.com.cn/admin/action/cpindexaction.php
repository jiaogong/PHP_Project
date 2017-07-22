<?php

/**
 * $Id: cpindexaction.php 2920 2016-06-06 02:30:23Z david $
 */
class cpindexAction extends action {

    var $ufields = array(
        'name' => '',
        'c1' => 'index',
        'c2' => 1
    );

    function __construct() {
        parent::__construct();
        $this->index = new index();
        $this->brand = new brand();
        $this->factory = new factory();
        $this->series = new series();
        $this->model = new cardbModel();
        $this->pageData = new pageData();
        $this->article = new article();
        $this->articleSeries = new articleSeries();
        $this->pageDataSeries = new cp_pageDataSeries();
        $this->pricelog = new cardbPriceLog();
        $this->price = new cardbPrice();
        $this->pageDataNotice = new cp_pageDataNotice();
        $this->cardbfile = new uploadFile();
        $this->oldcarval = new oldCarVal();
        $this->realdata = new realdata();
        $this->seriesType = new seriesType();
        $this->seriesloan = new seriesLoan();

        $this->checkAuth(804, 'W');
    }

    function doMakeModel() {
        $date = $_GET['date'];
        if (!$date)
            $date = date('Y-m-d');
        $pdName = $_GET['pd_name'];
        if ($pdName) {
            $ret = $this->makeFile($pdName, $date);
            //1.生成成功 0.生成失败
            if ($ret)
                echo 1;
            else
                echo 0;
        }
    }

    function makeFile($pdName, $date = '') {
        global $timestamp;
        $this->ufields['name'] = $pdName;
        unset($this->ufields['value']);
        $alias = '';
        $tplName = 'ssi_newindex_' . $pdName;
        if ($date) {
            $alias = date('_Y_m_d', strtotime($date));
            #$this->ufields['start_time'] = $date;
            //删除两天前的生成文件
            $rmAlias = date('_Y_m_d', $timestamp - 3600 * 48);
            $rmdFileName = WWW_ROOT . 'ssi/ssi_newindex_' . $pdName . $rmAlias . '.shtml';
            #$rmdFileName = WWW_ROOT . 'ssi/ssi_newindex_' . $pdName . '.shtml';
            if (file_exists($rmdFileName))
                unlink($rmdFileName);
        }
        $fileName = WWW_ROOT . 'ssi/ssi_newindex_' . $pdName . $alias . '.shtml';
        if ($pdName == 'discount') {
            $value = $this->pageData->getDiscountValue($pdName, $date);
            $fileName = WWW_ROOT . 'ssi/ssi_newindex_' . $pdName . '.shtml'; # tmp33
            if (!empty($value)) {
                $discountA = array();
                $d_i = 1;
                foreach ($value as $k => $v) {
                    $resultdetail = mb_unserialize($v['value']);
                    if ($d_i > 3) {
                        break;
                    }
                    if (!array_key_exists($resultdetail[0][bingoid], $discountA)) {
                        $discountA[$resultdetail[0][bingoid]] = $resultdetail[0][bingoid];
                        $result[] = $resultdetail;
                        $d_i ++;
                    }
                }
            }
        } elseif ($pdName == 'upcoming' || $pdName == 'look' || $pdName=='search' ) {
            unset($this->ufields['start_time']);
            $value = $this->pageData->getPageData($this->ufields, 3, 'value',array('id' => 'DESC'));
            $fileName = WWW_ROOT . 'ssi/ssi_newindex_' . $pdName . '.shtml';
            if ($value)
                $result = mb_unserialize($value);
        }elseif ($pdName == 'focus5') {
            unset($this->ufields['start_time']);
            $i = $j = 0;
            $fileName = WWW_ROOT . 'ssi/ssi_newindex_' . $pdName . '.shtml';
            $focusvalue = $this->pageData->getPageData($this->ufields, 1, 'value,id', array('id'=>'DESC'));
            $value = $focusvalue['value'];
            $result = mb_unserialize($value);
            $filesrc = WWW_ROOT . "/attach/images/focus/";
            if(!is_file($filesrc . $result[0]['createfiletime'] . "/" . $result[0]['pic']) || !is_file($filesrc . $result[1]['createfiletime'] . "/" . $result[1]['pic']) || !is_file($filesrc . $result[2]['createfiletime'] . "/" . $result[2]['pic']) || !is_file($filesrc . $result[3]['createfiletime'] . "/" . $result[3]['pic']) || !is_file($filesrc . $result[4]['createfiletime'] . "/" . $result[4]['pic']) || $j < 5) {
                #$this->ufields['start_time'] = date('Y-m-d', strtotime($date) - 3600 * 24 * $i);
                $focusvalue = $this->pageData->getPageData($this->ufields, 3, 'value', array('id' => 'DESC'));
                if ($focusvalue) {
                    $arr[$j] = $focusvalue;
                    $j++;
                }
                #header("Content-type: text/html; charset=utf-8");
                #var_dump($arr);exit;
                $value = $arr[array_rand($arr, 1)];
                $result = mb_unserialize($value);
                $i++;
            }

        } elseif ($pdName == 'focus2') {
            unset($this->ufields['start_time']);
            $i = $j = 0;
            $fileName = WWW_ROOT . 'ssi/ssi_newindex_' . $pdName . '.shtml';
            $focus2value = $this->pageData->getPageData($this->ufields, 1, 'value,id', array('id'=>'DESC'));
            $value = $focus2value['value'];
            $result = mb_unserialize($value);
            $filesrc = WWW_ROOT . "/attach/images/model/";
            if(!is_file($filesrc . $result[0]['model_id'] . "/" . $result[0]['pic']) || !is_file($filesrc . $result[1]['model_id'] . "/" . $result[1]['pic']) || $j < 6) {
                #$this->ufields['start_time'] = date('Y-m-d', strtotime($date) - 3600 * 24 * $i);
                $focus2value = $this->pageData->getPageData($this->ufields, 3, 'value', array('id' => 'DESC'));
                if ($focus2value) {
                    $arr[$j] = $focus2value;
                    $j++;
                }
//                var_dump($focus2value);exit;
                $value = $arr[array_rand($arr, 1)];
                $result = mb_unserialize($value);
                $i++;
            }
        } elseif ($pdName == 'hotarticle') {
            $i = $j = 0;
            $fileName = WWW_ROOT . 'ssi/ssi_newindex_' . $pdName . '.shtml';
            $value = $this->pageData->getPageData($this->ufields, 3, 'value',array('id' => 'DESC'));
            #var_dump($value);exit;
            if (!isset($value) || $j < 6) {
//                $this->ufields['start_time'] = date('Y-m-d', strtotime($date) - 3600 * 24 * $i);
                $value = $this->pageData->getPageData($this->ufields, 3, 'value', array('id' => 'DESC'));
                if ($value) {
                    $arr[$j] = $value;
                    $j++;
                }
                $i++;
            }

            $result = mb_unserialize($arr[array_rand($arr, 1)]);
//            header("Content-type: text/html; charset=utf-8");
//            var_dump($result);exit;
        } elseif( $pdName == 'recommend' || $pdName == 'rmdword' || $pdName=='rmdseries' || $pdName=='rmdarticle' ){
            unset($this->ufields['start_time']);
            $value = $this->pageData->getPageData($this->ufields, 3, 'value',array('id' => 'DESC'));
            $fileName = WWW_ROOT . 'ssi/ssi_newindex_' . $pdName . '.shtml'; # tmp33
            if ($value)
                $result = mb_unserialize($value);
        }elseif($pdName == 'hotcar'){
            $this->vars('pr', $this->index->pr);
            unset($this->ufields['start_time']);
            $value = $this->pageData->getPageData($this->ufields, 3, 'value',array('id' => 'DESC'));
            $fileName = WWW_ROOT . 'ssi/ssi_newindex_' . $pdName . '.shtml'; # tmp33
            if ($value)
                $result = mb_unserialize($value);
        }else{
            $value = $this->pageData->getPageData($this->ufields, 3, 'value',array('id' => 'DESC'));
            if ($value)
                $result = mb_unserialize($value);
        }
        if($result) {
            $this->vars('result', $result);
        }
        $html = $this->fetch($tplName);
        $ret = file_put_contents($fileName, $html);
        if ($ret) {
            $ufields = array('state' => 2);
            $where = "name = '$pdName'";
            if ($date)
                $where .= " AND start_time = '$date'";
            $this->pageData->updatePageData($ufields, $where);
        }
        return $ret;
    }

    function makeFile2($pdName, $date = '', $limit, $order) {
        $this->ufields['name'] = $pdName;
        $alias = '';
        if ($date) {
            $alias = date('_Y_m_d', strtotime($date));
            $this->ufields['start_time'] = $date;
            $this->removeFile($pdName);
        }
        $tplName = 'ssi_newindex_' . $pdName;
        $fileName = WWW_ROOT . 'ssi/ssi_newindex_' . $pdName . $alias . '.shtml';
        $this->pageData->limit = $limit;
        $value = $this->pageData->getPageData($this->ufields, 2, 'value', $order);
        #echo $this->pageData->sql;exit;
        if ($value) {
            foreach ($value as $val) {
                $result[] = mb_unserialize($val['value']);
            }
            $this->vars('result', $result);
        }
        #var_dump($result);exit;
        $html = $this->fetch($tplName);
        $html = replaceImageUrl($html);
//        echo($html);
        $ret = file_put_contents($fileName, $html);
        if ($ret) {
            $ufields = array('state' => 2);
            $where = "name = '$pdName'";
            if ($date)
                $where .= " AND start_time = '$date'";
            $this->pageData->updatePageData($ufields, $where);
        }
        return $ret;
    }

    function doMakeIndex() {
        global $local_host, $login_uname;

        $date = $_GET['date'];
        $index_url = $local_host . "newindex.php?{$date}&o=make";
        $msg = array(
            'date' => $date,
            'index_url' => $index_url,
            'admin' => $login_uname,
        );
        $is_auth = $this->checkAuth(803, 'A', 0);
        if (!$is_auth) {
            $msg['state'] = -1;
        } else {
            $c = @file_get_contents($index_url);
            if (strpos($c, 'ok') !== FALSE) {
                $msg['state'] = 1;
            } else {
                $msg['state'] = 0;
            }
        }
        echo json_encode($msg);
    }

    function doExportModelCount() {
        $date = $_GET['date'];
        if ($date == 'm') {
            $startTime = date('Y-m-01');
            $endTime = date('Y-m-t');
            $fname = '当月车系统计.csv';
        } else {
            $startTime = date('Y-01-01');
            $endTime = date('Y-12-31');
            $fname = '当年车系统计.csv';
        }
        $allModel = $this->index->allModel;
        $modelStr = implode(',', $allModel);
        $str = "序列,品牌,厂商,车系,$modelStr,合计\n";
        $series = $this->series->getSeriesdata('series_id, brand_name, factory_name, series_name', 'state in (3, 7, 8)');
        foreach ($series as $k => $v) {
            $seriesId = $v['series_id'];
            $str .= $k + 1;
            $str .= ',' . $v['brand_name'];
            $str .= ',' . $v['factory_name'];
            $str .= ',' . $v['series_name'];
            $count = $allCount = 0;
            foreach ($allModel as $kk => $vv) {
                $count = $this->pageDataSeries->getSeries('count(*)', "state = 0 AND series_id = $seriesId AND pd_name = '$kk' AND start_time >= '$startTime' AND start_time <= '$endTime'", 3);
                $count = (int) $count;
                $str .= ',' . $count;
                $allCount += $count;
            }
            $str .= ',' . $allCount . "\n";
        }
        header("Content-type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Accept-Length: " . strlen($str));
        header("Content-Disposition: attachment; filename=$fname");
        echo $str;
    }

    function doModelCountList() {
        global $timestamp;
        $tplName = 'cpindex_modelcount_list';
        $monthStart = date('Y-m-01', $timestamp);
        $monthEnd = date('Y-m-t', $timestamp);
        $yearStart = date('Y-01-01', $timestamp);
        $yearEnd = date('Y-12-t', $timestamp);
        $this->vars('allModel', $this->index->allModel);
        $monthCount = $this->pageDataSeries->getModelCount($monthStart, $monthEnd);
        $yearCount = $this->pageDataSeries->getModelCount($yearStart, $yearEnd);
        $this->vars('monthCount', $monthCount);
        $this->vars('yearCount', $yearCount);
        $this->template($tplName);
    }

    function doOldModelList() {
        $tplName = 'cpindex_oldmodel_list';
        $this->vars('allModel', $this->index->allModel);
        $page = $_GET['page'];
        $page = $page ? $page : 1;
        $pageSize = 10;
        $ret = $this->pageDataSeries->getOldPageData();
        $total = count($ret);
        $start = ($page - 1) * $pageSize;
        $result = array_slice($ret, $start, $pageSize);
        $this->vars('result', $result);
        $pageBar = $this->multi($total, $pageSize, $page, $_ENV['PHP_SELF'] . 'oldModelList');
        $this->vars('colspan', $pageSize + 1);
        $this->vars('pageBar', $pageBar);
        $this->template($tplName);
    }

    function doAllModelList() {
        global $timestamp;
        $tplName = 'cpindex_allmodel_list';
        $date = array();
        $allModel = $this->index->allModel;
        $this->vars('allModel', $allModel);
        $dayTimestamp = 24 * 3600;
        $yesterday = $timestamp - $dayTimestamp;
        $firstDate = date('Y-m-d', $yesterday);
        $lastDate = date('Y-m-d', $timestamp + 10 * $dayTimestamp);
        for ($i = 0; $i < 11; $i++) {
            $date[] = date('Y-m-d', $yesterday + $i * $dayTimestamp);
        }
        $this->vars('date', $date);
        $keys = array_keys($allModel);
        $result = $this->pageDataSeries->getAllPageData($keys, $firstDate, $lastDate, $carType);
        $this->vars('result', $result);
        $this->template($tplName);
    }

    function getRmdTitle($priceId) {
        $condition = $this->pricelog->getIndexRmdArticle($priceId);
        $seriesAlias = $condition['series_alias'];
        $bingoPrice = floatval($condition['price']);
        $modelPrice = $condition['model_price'];
        $diffPrice = $modelPrice - $bingoPrice;
        $point = round($diffPrice / $modelPrice * 100, 1);
        if ($modelPrice < 10 && $diffPrice > 2 || $modelPrice >= 10 && $diffPrice > 2 && $point >= 12) {
            $unit = '万元';
            if ($diffPrice < 1) {
                $unit = '元';
                $diffPrice *= 10000;
            }
            $titleArr = array($seriesAlias . ' 钜惠' . $diffPrice . $unit);
        } else {
            if ($diffPrice > 0) {
                $unit = '万元';
                if ($diffPrice < 1) {
                    $unit = '元';
                    $diffPrice *= 10000;
                }
                $titleArr = array(
                    $seriesAlias . ' 享受' . $diffPrice . $unit . '优惠',
                    $seriesAlias . ' ' . $bingoPrice . '万',
                    $bingoPrice . '万起' . $seriesAlias,
                    $bingoPrice . '万买' . $seriesAlias,
                    $seriesAlias . '优惠' . $diffPrice . $unit . '起',
                    $seriesAlias . '优惠' . $diffPrice . $unit
                );
                if (strpos($point, '.') === false)
                    $titlaArr[] = $seriesAlias . ' 优惠' . $point . '个点';
            }
            elseif ($diffPrice == 0) {
                $titleArr = array(
                    $seriesAlias . ' 店内无优惠',
                    '暗访' . $seriesAlias . ' 依旧无优惠'
                );
            } else {
                $unit = '万元';
                if ($diffPrice > -1) {
                    $unit = '元';
                    $diffPrice *= 10000;
                }
                $diffPrice = -1 * $diffPrice;
                $titleArr = array(
                    $seriesAlias . ' 加价' . $diffPrice . $unit,
                    '加' . $diffPrice . $unit . '提 ' . $seriesAlias
                );
            }
        }
        $key = array_rand($titleArr);
        $title = $titleArr[$key];
        return $title;
    }

    function doGetRmdTitle() {
        $priceId = $_GET['price_id'];
        if ($priceId) {
//            $title = iconv('gbk', 'utf-8', $this->getRmdTitle($priceId));
            $title = $this->getRmdTitle($priceId);
            echo $title;
        }
    }

    function doGetOptions() {
        $key = $_GET['key'];
        $ret = $this->index->$key;
//        foreach ($ret as &$v) {
//            $v = iconv('gbk', 'utf-8', $v);
//        }
        echo json_encode($ret);
    }

    /* 新购推荐模块推荐词操作 */

    function doRmdwordAct() {
        $this->ufields['name'] = 'rmdword';
        if (empty($_POST)) {
            $tplName = 'cpindex_rmdword_act';
            $word = $_GET['word'];
            $order = $_GET['order'];
            $type = $_GET['type'];
            $this->vars('word', $word);
            $this->vars('order', $order);
            $this->vars('type', $type);
            $value = $this->pageData->getPageData($this->ufields, 3, 'value');
            if ($value) {
                $rmdWord = mb_unserialize($value);
                $this->vars('rmdWord', $rmdWord[$type]);
            }
            //搜索项
            $options = array(
                'pr' => '价格',
                'cs' => '车身形式',
                'fi' => '厂商性质',
                'bi' => '国别',
                'ct' => '级别',
                'pl' => '排量',
                'bsx' => '变速箱',
                'jq' => '进气形式',
                'zw' => '座位数',
                'qg' => '汽缸数',
                'st' => '车体结构',
                'dr' => '驱动形式',
                'sp' => '车辆配置'
            );
            $this->vars('options', $options);
            foreach ($options as $k => $v) {
                $this->vars($k, $this->index->$k);
            }
            $this->template($tplName);
        } else {
            $type = $_POST['type'];
            $rmdWord = array();
            $value = $this->pageData->getPageData($this->ufields, 3, 'value');
            if ($value)
                $rmdWord = mb_unserialize($value);
            if ($type) {
                $carOption = $_POST['car_option'];
                $optionDetail = $_POST['option_detail'];
                $url = 'search.php?action=index';
                if (!empty($carOption)) {
                    foreach ($carOption as $k => $v) {
                        if ($v) {
                            if ($v == 'pr' && $optionDetail[$k] == 9)
                                $url .= '&pr=9&pr=10';
                            else
                                $url .= '&' . $v . '=' . $optionDetail[$k];
                        }
                    }
                }
                $searchName = $_POST['word'];
                $rmdWord[$type]['option'] = $carOption;
                $rmdWord[$type]['detail'] = $optionDetail;
                $rmdWord[$type]['keyword'] = $searchName;
                $rmdWord[$type]['url'] = $url;
            }

            $this->ufields['value'] = $rmdWord;
            $this->pageData->addIndexPagedata($this->ufields);
            $this->makeFile($this->ufields['name']);
            $this->alert('操作成功！', 'js', 3, $_ENV['PHP_SELF'] . 'rmdWordList');
        }
    }

    /* 新购推荐模块推荐词列表 */

    function doRmdwordList() {
        $tplName = 'cpindex_rmdword_list';
        $this->ufields['name'] = 'rmdword';
        $value = $this->pageData->getPageData($this->ufields, 3, 'value');
        if ($value) {
            $rmdWord = mb_unserialize($value);
            if($rmdWord) {
                foreach ($rmdWord as $k => $v) {
                    $option = $v['option'];
                    $searchName = '';
                    foreach ($option as $kk => $vv) {
                        $detail = $v['detail'];
                        if ($vv) {
                            $condition = $this->index->$vv;
                            $searchName .= ' ' . $condition[$detail[$kk]];
                        }
                    }
                    $rmdWord[$k]['search_name'] = $searchName;
                }
            }
            $this->vars('rmdWord', $rmdWord);
        }
        $carType = array('家用', '运动', '商务', 'SUV');
        $this->vars('carType', $carType);
        $this->template($tplName);
    }

    function doRmdArticleList() {
        $tplName = 'cpindex_rmdarticle_list';
        $this->ufields['name'] = 'rmdarticle';
        $carType = array('家用', '运动', '商务', 'SUV');
        $this->vars('carType', $carType);
        $modList = $this->index->getModList($this->ufields);
        $this->vars('modList', $modList);
        $this->template($tplName);
    }

    function doRmdArticleAct() {
        $date = $_GET['date'];
        $carType = array('家用', '运动', '商务', 'SUV');
        $cols = array('模块名称', '昨日文字信息', '今日文字信息', '暗访价ID');
        $lastDate = date('Y-m-d', strtotime($date) - 24 * 3600);
        $this->ufields['name'] = 'rmdarticle';
        $this->ufields['start_time'] = $lastDate;
        if (empty($_POST)) {
            //上次未填写数据  则列表页不显示昨日车系列
            $value = $this->pageData->getPageData($this->ufields, 3, 'value');
            if ($value) {
                $lastSeries = unserialize($value);
                $this->vars('lastSeries', $lastSeries);
            } else
                unset($cols[1]);
            $this->ufields['start_time'] = $date;
            $svalue = $this->pageData->getPageData($this->ufields, 3, 'value');
            if ($svalue) {
                $series = unserialize($svalue);
                $this->vars('series', $series);
            }
            $tplName = 'cpindex_rmdarticle_act';
            $this->vars('carType', $carType);
            $this->vars('cols', $cols);
            $this->vars('date', $date);
            $this->template($tplName);
        } else {
            $value = array();
            $date = $_POST['date'];
            $this->ufields['start_time'] = $date;
            for ($i = 1; $i < 25; $i++) {
                $value[$i]['alias'] = $_POST['alias' . $i];
                $value[$i]['price_id'] = $_POST['price_id' . $i];
                $value[$i]['model_id'] = $this->pricelog->getPrices('model_id', "id = {$_POST['price_id' . $i]}", 3);
            }
            $this->ufields['value'] = $value;
            $this->pageData->addIndexPagedata($this->ufields);
            $this->makefile($this->ufields['name'], $date);
            $this->alert('操作成功', 'js', 3, $_ENV['PHP_SELF'] . 'rmdArticleAct&date=' . $date);
        }
    }

    /* 新购推荐模块预览 */

    function doRmdSeriesList() {
        $tplName = 'cpindex_rmdseries_list';
        $this->ufields['name'] = 'rmdseries';
        $carType = array('家用', '运动', '商务', 'SUV');
        $this->vars('carType', $carType);
        $modList = $this->index->getModList($this->ufields);
        $this->vars('modList', $modList);
        $this->template($tplName);
    }

    /* 自动生成新购推荐模块 */

    function doAutoRmdSeries() {
        global $timestamp;
        set_time_limit(0);
        $carType = array(
            1 => '家用',
            2 => '运动',
            3 => '商务',
            4 => 'SUV'
        );
        if (!$this->ufields['name']) {
            $this->ufields['name'] = 'rmdword';
            $avalue = $this->pageData->getPageData($this->ufields, 3, 'value');
            $this->makeFile($this->ufields['name'], $avalue);
        }
        $rmdSeries = $rmdArticle = array();
        $oldSkey = array(4, 5, 6);
        for ($i = -1; $i < 10; $i++) {
            $this->ufields['name'] = 'rmdseries';
            $date = date('Y-m-d', $timestamp + $i * 24 * 3600);
            //echo "\n<br>" . $date . "<br>\n";
            $this->ufields['start_time'] = $date;
            $offers = $this->seriesType->getNewOffers($carType);
            $avalue = $this->pageData->getPageData($this->ufields, 3, 'value');
            if ($i == -1)
                continue;
            if (!empty($offers['series'])) {
                $rmdSeries[$i] = $offers['series'];
                $offSeries = $offers['series'];
                for ($q = 1; $q < 13; $q++) {
                    if (!$offSeries[$q])
                        $offSeries[$q] = $rmdSeries[$i - 1][$q];
                }
                $this->ufields['value'] = $offSeries;
                $this->pageData->addIndexPagedata($this->ufields);
                $this->makeFile($this->ufields['name'], $date);
            }
            $this->ufields['name'] = 'rmdarticle';
            $svalue = $this->pageData->getPageData($this->ufields, 3, 'value');
//            if (!$svalue) {
            $article = $offers['article'];
            $rmdArticle[$i] = $offers['article'];
            $m = 0;
            for ($j = 0; $j < 4; $j++) {
                foreach ($oldSkey as $ok => $ov) {
                    $q = $j * 6 + $ov;
                    $m++;
                    if ($rmdSeries[$i - 1][$m])
                        $article[$q] = $rmdSeries[$i - 1][$m];
                }
            }
            if (!empty($article)) {
                for ($q = 1; $q < 25; $q++) {
                    if ($article[$q]['price_id'])
                        $article[$q]['alias'] = $this->getRmdTitle($article[$q]['price_id']);
                    else {
                        $article[$q] = $rmdArticle[$i - 1][$q];
                        $article[$q]['alias'] = $this->getRmdTitle($article[$q]['price_id']);
                    }
                }
                $this->ufields['value'] = $article;
                $this->pageData->addIndexPagedata($this->ufields);
                $this->makeFile($this->ufields['name'], $date);
            }
//            }
        }
    }

    /* 新购推荐模块操作 */

    function doRmdSeriesAct() {
        $date = $_GET['date'];
        $carType = array('家用', '运动', '商务', 'SUV');
        $cols = array('模块名称', '昨日车系', '今日车系', '暗访价ID');
        $lastDate = date('Y-m-d', strtotime($date) - 24 * 3600);
        $this->ufields['name'] = 'rmdseries';
        $this->ufields['start_time'] = $lastDate;
        if (empty($_POST)) {
            //上次未填写数据  则列表页不显示昨日车系列
            $value = $this->pageData->getPageData($this->ufields, 3, 'value');
            if ($value) {
                $lastSeries = mb_unserialize($value);
                $this->vars('lastSeries', $lastSeries);
            } else
                unset($cols[1]);
            $this->ufields['start_time'] = $date;
            $this->pageData->where = '';
            $svalue = $this->pageData->getPageData($this->ufields, 3, 'value');
            if ($svalue) {
                $series = mb_unserialize($svalue);
                $this->vars('series', $series);
            }
            $tplName = 'cpindex_rmdseries_act';
            $this->vars('carType', $carType);
            $this->vars('cols', $cols);
            $this->vars('date', $date);
            $this->template($tplName);
        } else {
            $value = array();
            $date = $_POST['date'];
            $this->ufields['start_time'] = $date;
            $svalue = $this->pageData->getPageData($this->ufields, 3, 'value');
            if ($svalue)
                $value = mb_unserialize($svalue);
            for ($i = 1; $i < 13; $i++) {
                $modelInfo = array();
                $alias = $_POST['alias' . $i];
                $priceId = $_POST['price_id' . $i];
                if ($alias && $priceId) {
                    $oldPriceId = (int) $value[$i]['price_id'];
                    //车系发生变化  处理模块车系统计
                    if ($oldPriceId != $priceId) {
                        $seriesId = $this->pricelog->getPrices('series_id', "id = $priceId", 3);
                        $id = $this->pageDataSeries->getSeries('id', "pd_name = 'rmdseries' AND pos = $i AND start_time = '$date'", 3);
                        if ($id)
                            $this->pageDataSeries->updateSeries(array('series_id' => $seriesId), "id = $id");
                        else {
                            $fields = array(
                                'pd_name' => 'rmdseries',
                                'pos' => $i,
                                'start_time' => $date,
                                'series_id' => $seriesId
                            );
                            $this->pageDataSeries->insertSeries($fields);
                        }
                    }
                    $modelInfo = $this->pricelog->getIndexRmdArticle($priceId);
                }
                $value[$i]['alias'] = $alias;
                $value[$i]['price_id'] = $priceId;
                $value[$i]['model_pic'] = $modelInfo['model_pic1'];
                $value[$i]['model_name'] = $modelInfo['model_name'];
                $value[$i]['model_price'] = $modelInfo['model_price'];
                $value[$i]['series_alias'] = $modelInfo['series_alias'];
                $value[$i]['id'] = $modelInfo['id'];
                $value[$i]['price'] = $modelInfo['price'];
                $value[$i]['model_id'] = $modelInfo['model_id'];
            }
            $this->ufields['value'] = $value;
            $this->pageData->addIndexPagedata($this->ufields);
            $this->makeFile($this->ufields['name'], $date);
            $this->alert('操作成功', 'js', 3, $_ENV['PHP_SELF'] . 'rmdSeriesAct&date=' . $date);
        }
    }

    function doHotartOld() {
        $this->ufields['name'] = 'hotarticle';
        $tplName = 'cpindex_hotart_old';
        $page_size = 10;
        $page = $_GET['page'];
        $page = max(1, $page);
        $limit = ($page - 1) * $page_size;
        $result = $this->index->getHotartHistroy($this->ufields, $page_size, $limit);
        $history = $result['history'];
        $page_bar = $this->multi($result['total'], $page_size, $page, $_ENV['PHP_SELF'] . 'hotartOld');
        $this->vars('history', $history);
        $this->vars('colspan', $result['total'] + 1);
        $this->vars('page_bar', $page_bar);
        $this->template($tplName);
    }

    function doHotartChg() {
        $date = $_GET['date'] ? $_GET['date'] : $_POST['date'];
        //type 1.录入   2.修改
        $type = $_GET['type'];
        $yesterday = date('Y-m-d', strtotime($date) - 24 * 3600);
        $this->ufields['start_time'] = $yesterday;
        if ($type == 2)
            $this->ufields['start_time'] = $date;
        $this->ufields['name'] = 'hotarticle';
        $result = $this->pageData->getPageData($this->ufields, 3, 'value');
        if ($type) {
            $tplName = 'cpindex_hotart_act';
            $hotArticle = mb_unserialize($result);
            if ($type == 1) {
                $tmp = array();
                for ($i = 1; $i < 9; $i++) {
                    if ($_POST['order' . $i])
                        $tmp[$_POST['order' . $i]] = $hotArticle[$i];
                    else
                        $tmp[$_POST['order' . $i]] = array();
                }
                $hotArticle = $tmp;
            }

            foreach ($hotArticle as $k => $v) {
                if ($v['url']) {
                    $str = $v['url'];
                    $start = strripos($str, '/') + 1;
                    $length = strlen($str) - $start - 5;
                    $hotArticle[$k]['article_id'] = substr($str, $start, $length);
                }
            }
            $this->vars('hotArticle', $hotArticle);
        } else {
            $tplName = 'cpindex_hotart_entry';
            if (!empty($result)) {
                $hotArticle = mb_unserialize($result);
                $this->vars('hotArticle', $hotArticle);
            } else {
                $tplName = 'cpindex_hotart_act';
            }
        }
        $this->vars('date', $date);
        $this->template($tplName);
    }

    function doHotartList() {
        $tplName = 'cpindex_hotart_list';
        $this->ufields['name'] = 'hotarticle';
        $hotArticle = $this->index->getModList($this->ufields);
        $this->vars('hotArticle', $hotArticle);
        $this->template($tplName);
    }

    function doHotartAct() {
        global $timestamp;
        $this->ufields['name'] = $pageDataName = 'hotarticle';
        if (!empty($_POST)) {
            $hotArticle = array();
            $this->ufields['start_time'] = $startTime = $_POST['date'];
            if ($startTime) {
                $value = $this->pageData->getPageData($this->ufields, 3, 'value');
                if ($value)
                    $hotArticle = mb_unserialize($value);
                for ($i = 1; $i < 9; $i++) {
                    $hotArticle[$i]['title'] = $_POST['title' . $i];
                    $hotArticle[$i]['short_title'] = $_POST['short_title' . $i];
                    $articleId = $_POST['article_id' . $i];
                    if ($articleId) {
                        $articleCreated = $this->article->getArticleFields('created, series_list', "id = $articleId", 1);
                        if ($articleCreated) {
                            $hotArticle[$i]['url'] = "html/article/" . date('Ym/d', $articleCreated['created']) . "/$articleId.html";
                            $articleSeris = explode(',', $articleCreated['series_list']);
                            // if ($articleSeris[3]) {
                            //     $this->insertPageDataSeries($pageDataName, $i, $startTime, $articleSeris[3]);
                            // }
                        }
                        //获取关联车系
                        $articleSeris = $this->articleSeries->getArticleSeries('series_id', "article_id = $articleId AND state = 0", 2);
                        //文章变化  跟新模块车系统计
                        if ($articleId != $hotArticle[$i]['article_id']) {
                            $this->pageDataSeries->updateSeries(array('state' => 1), "pd_name = '$pageDataName' AND pos = $i AND start_time = '$startTime'");
                            if (!empty($articleSeris)) {
                                foreach ($articleSeris as $k => $v) {
                                    $seriesId = $v['series_id'];
                                    $ufields = array(
                                        'pd_name' => $pageDataName,
                                        'series_id' => $seriesId,
                                        'pos' => $i,
                                        'start_time' => $startTime
                                    );
                                    $this->pageDataSeries->insertSeries($ufields);
                                }
                            }
                        }
                        $hotArticle[$i]['article_id'] = $articleId;
                    }
                }
                $this->ufields['value'] = $hotArticle;
                $this->pageData->addIndexPagedata($this->ufields);
                $this->makeFile($pageDataName, $startTime);
                $this->alert('操作成功!', 'js', '3', $_ENV['PHP_SELF'] . 'hotartList');
            }
        }
    }

    function domakehotart() {
        $startTime = date('Y-m-d', time());
        $this->makeFile("focus5", $startTime);
        $this->makeFile("focus2", $startTime);
        $this->makeFile("hotarticle", $startTime);
    }

    function doSearchList() {
        $ufields = array(
            'name' => 'search',
            'c1' => 'index',
            'c2' => 1
        );
        $tplName = 'cpindex_search_list';
        $result = $this->pageData->getPageData($ufields);
        if (!empty($result))
            $pageData = mb_unserialize($result['value']);
        $this->vars('data', $pageData);
        $this->template($tplName);
    }

    function doSearchAct() {
        global $timestamp;
        $data = array();
        $ufields = array(
            'name' => 'search',
            'c1' => 'index',
            'c2' => 1
        );
        if (empty($_POST)) {
            $tplName = 'cpindex_search_act';
            $result = $this->pageData->getPageData($ufields);
            if (!empty($result)) {
                $data = mb_unserialize($result['value']);
                $this->vars('data', $data);
            }
            //搜索项
            $options = array(
                'pr' => '价格',
                'cs' => '车身形式',
                'fi' => '厂商性质',
                'bi' => '国别',
                'ct' => '级别',
                'pl' => '排量',
                'bsx' => '变速箱',
                'jq' => '进气形式',
                'zw' => '座位数',
                'qg' => '汽缸数',
                'st' => '车体结构',
                'dr' => '驱动形式',
                'sp' => '车辆配置'
            );
            $this->vars('options', $options);
            foreach ($options as $k => $v) {
                $this->vars($k, $this->index->$k);
            }
            $this->template($tplName);
        } else {
            $result = $this->pageData->getPageData($ufields);
            if (!empty($result))
                $pageData = mb_unserialize($result['value']);
            for ($i = 1; $i < 11; $i++) {
                $history = array();
                $alias = $_POST['alias' . $i];
                $data[$i]['alias'] = $alias;
                for ($j = 1; $j < 11; $j++) {
                    $data[$i]['option_key'][$j] = $_POST['car_option' . $i . $j];
                    $data[$i]['option_value'][$j] = $_POST['option_detail' . $i . $j];
                }
                //关键词变化做一次改动记录
                if ($alias) {
                    if (!empty($pageData) && $pageData[$i]['created'])
                        $data[$i]['created'] = $pageData[$i]['created'];
                    else
                        $data[$i]['created'] = $timestamp;
                    if (!empty($pageData) && !empty($pageData[$i]['history'])) {
                        $history = $pageData[$i]['history'];
                        if ($history[0]['alias'] != $alias) {
                            $arr = array(
                                'alias' => $alias,
                                'timestamp' => $timestamp
                            );
                            array_unshift($history, $arr);
                            //历史记录只保存最近六次
                            if (count($history) >= 7)
                                array_pop($history);
                            $data[$i]['times'] = $pageData[$i]['times'] + 1;
                        } else
                            $data[$i]['times'] = $pageData[$i]['times'];
                        $data[$i]['history'] = $history;
                    }
                    else {
                        $history[0] = array(
                            'alias' => $alias,
                            'timestamp' => $timestamp
                        );
                        $data[$i]['times'] = 1;
                        $data[$i]['history'] = $history;
                    }
                }
            }
            $ufields['value'] = $data;
            $this->pageData->addIndexPagedata($ufields);
            $ret = $this->makeFile('search');
//            if($ret)
//                $this->alert('生成成功!', 'js', '3', $_ENV['PHP_SELF'] . 'searchAct');
            $this->alert('操作成功!', 'js', '3', $_ENV['PHP_SELF'] . 'searchAct');
        }
    }

    function doGetSeriesAlias() {
        $seriesId = $_GET['sid'];
        $alias = $this->series->getSeriesdata('series_alias', "series_id = $seriesId", 3);
//        echo iconv('gbk', 'utf-8', $alias);
        echo $alias;
    }

    function doHotcarAct() {
        $ufields = array(
            'name' => 'hotcar',
            'c1' => 'index',
            'c2' => 1
        );
        $date = date('Y-m-d');
        $data = array();
        //价格区间
        $priceValue = $_GET['pv'] ? $_GET['pv'] : $_POST['pv'];
        $priceValue = $priceValue ? $priceValue : 0;
        $this->vars('priceValue', $priceValue);
        $this->vars('pr', $this->index->priceSelect);
        if (empty($_POST)) {
            $tplName = 'cpindex_act_hotcars';
            $priceSelect = $this->index->priceSelect;
            $result = $this->pageData->getPageData($ufields);
            if (!empty($result)) {
                $pageData = mb_unserialize($result['value']);
                $data = $pageData[$priceValue];
            }
            $this->vars('data', $data);
            $this->vars('priceSelect', $priceSelect);
            $carSelect = $this->index->getSelectInfo();
            $this->vars('carSelect', $carSelect);
            $this->template($tplName);
        } else {
            $result = $this->pageData->getPageData($ufields);
            if (!empty($result))
                $data = mb_unserialize($result['value']);
            for ($i = 1; $i < 31; $i++) {
                $alias = $_POST['alias' . $i];
                $seriesId = $_POST['series_id' . $i];
                if ($alias && $seriesId) {
                    $oldSeriesId = (int) $data[$priceValue][$i]['series_id'];
                    //车系发生变化  处理模块车系统计
                    if ($data[$priceValue][$i]['alias'] != $alias || $oldSeriesId != $seriesId) {
                        $id = $this->pageDataSeries->getSeries('id', "pd_name = 'hotcar' AND pos = $i", 3);
                        if ($id)
                            $this->pageDataSeries->updateSeries(array('series_id' => $seriesId), "id = $id");
                        else {
                            $fields = array(
                                'pd_name' => 'hotcar',
                                'pos' => $i,
                                'start_time' => $date,
                                'series_id' => $seriesId
                            );
                            $this->pageDataSeries->insertSeries($fields);
                        }
                    }
                }
                $data[$priceValue][$i]['alias'] = $_POST['alias' . $i];
                $data[$priceValue][$i]['brand_id'] = $_POST['brand_id' . $i];
                $data[$priceValue][$i]['factory_id'] = $_POST['factory_id' . $i];
                $data[$priceValue][$i]['series_id'] = $_POST['series_id' . $i];
            }
            $ufields['value'] = $data;

            $this->pageData->addIndexPagedata($ufields);
            //生成前台文件
            $res = $this->makeFile('hotcar');
            if($res){
                $this->alert('操作成功!', 'js', '3', $_ENV['PHP_SELF'] . 'hotcarAct&pv=' . $priceValue);
            }
        }
    }

    function doHotcarList() {
        $fields = array(
            'name' => 'hotcar',
            'c1' => 'index',
            'c2' => 1
        );
        $tplName = 'cpindex_hotcar_list';
        //价格区间
        $priceValue = $_GET['pv'];
        $priceValue = $priceValue ? $priceValue : 0;
        $result = $this->pageData->getPageData($fields);
        $priceSelect = $this->index->pr;
        $this->vars('priceSelect', $priceSelect);
        if (!empty($result)) {
            $pageData = mb_unserialize($result['value']);
            $data = $pageData[$priceValue];
            if (!empty($data)) {
                $hotcar = array_chunk($data, 3);
                $this->vars('data', $hotcar);
            }
        }
        $this->template($tplName);
    }

    function doHotcarNotice() {
        $act = $_GET['act'];
        $this->vars('act', $act);
        if ($act) {
            if (empty($_POST)) {
                $tplName = 'cpindex_notice';
                $notice = $this->pageDataNotice->getNotice($act);
                $title = array('信息预览', '操作', '逻辑说明');
                $phpSelf = $_ENV['PHP_SELF'];
                $url = array(
                    $phpSelf . $act . 'List',
                    $phpSelf . $act . 'Act',
                    'javascript:void(0);'
                );
                if ($act == 'hotart') {
                    $title[1] = '历史信息';
                    $url[1] = $_ENV['PHP_SELF'] . $act . 'Old';
                } elseif ($act == 'allmodel') {
                    $title = array('信息预览', '历史信息', '数据分析', '逻辑说明');
                    $url = array(
                        $phpSelf . 'allModelList',
                        $phpSelf . 'oldModelList',
                        $phpSelf . 'ModelCountList',
                        'javascript:void(0);'
                    );
                } elseif ($act == 'rmdWord') {
                    $title = array('模块信息预览', '模块推荐词操作', '文字信息预览', '逻辑说明');
                    $url = array(
                        $phpSelf . 'rmdSeriesList',
                        $phpSelf . 'rmdWordList',
                        $phpSelf . 'rmdArticleList',
                        'javascript:void(0);'
                    );
                } elseif ($act == 'focusfive') {
                    $title = array('信息预览', '历史信息', '逻辑说明');
                    $url = array(
                        $phpSelf . 'focuslist&num=5',
                        $phpSelf . 'focushistory&num=5',
                        'javascript:void(0);'
                    );
                } elseif ($act == 'focustwo') {
                    $title = array('信息预览', '历史信息', '逻辑说明');
                    $url = array(
                        $phpSelf . 'focuslist&num=2',
                        $phpSelf . 'focushistory&num=2',
                        'javascript:void(0);'
                    );
                } elseif ($act == 'loanreplace') {
                    $title = array('信息预览', '', '逻辑说明');
                    $url = array(
                        $phpSelf . 'loanreplacelist',
                        'javascript:void(0);'
                    );
                } elseif ($act == 'discount') {
                    $title = array('信息预览', '', '逻辑说明');
                    $url = array(
                        $phpSelf . 'discountlist',
                        'javascript:void(0);',
                        'javascript:void(0);'
                    );
                }
                $this->vars('notice', $notice);
                $this->vars('title', $title);
                $this->vars('url', $url);
                $this->template($tplName);
            } else {
                $content = $_POST['content'];
                $id = $this->pageDataNotice->getNoticeId($act);
                if ($id) {
                    $this->pageDataNotice->updateNotice($act, $content);
                } else {
                    $ufields = array(
                        'pd_name' => $act,
                        'content' => "$content"
                    );
                    $this->pageDataNotice->insertNotice($ufields);
                }
                if ($act == 'focustwo') {
                    $this->alert('操作成功！', 'js', 3, $_ENV['PHP_SELF'] . 'hotcarNotice&act=focustwo&num=2');
                } elseif ($act == 'focusfive') {
                    $this->alert('操作成功！', 'js', 3, $_ENV['PHP_SELF'] . 'hotcarNotice&act=focusfive&num=5');
                }
                $this->alert('操作成功！', 'js', 3, $_ENV['PHP_SELF'] . 'hotcarNotice&act=' . $act);
            }
        }
    }

    //大家都在看预览
    function doLookList() {
        $tpl_name = 'cpindex_looklist';
        $lookList = array(1 => '', 2 => '', 3 => '', 4 => '');
        $lookListFive = array('', '', '', '');
        $lookRes = $this->index->getLook();
        if ($lookRes) {
            $lookList1 = mb_unserialize($lookRes['value']);
            if($lookList1) {
                foreach ($lookList1 as $key => $val) {
                    $lookList[$key] = $val;
                }
            }
        }
        $this->tpl->assign('brand', $brand);
        $this->tpl->assign('looklist', $lookList);
        $this->template($tpl_name);
    }

    //大家都在看操作
    function doLookAct() {
        $tpl_name = 'cpindex_lookact';
        $lookAct = array(1 => '', 2 => '', 3 => '', 4 => '');
        $lookRes = $this->index->getLook();
        if ($lookRes) {
            $lookAct1 = mb_unserialize($lookRes['value']);
            if($lookAct1) {
                foreach ($lookAct1 as $key => $val) {
                    $lookAct[$key] = $val;
                    if ($val['brand_id']) {
                        //var_dump($val);exit;
                        $factoryData = $this->factory->getFactoryByBrand($val['brand_id']);
                        $seriesData = $this->series->getSeriesdata('series_id,series_name', "factory_id={$val['factory_id']} and state=3");
                        $lookAct[$key]['factory'] = $factoryData;
                        $lookAct[$key]['series'] = $seriesData;
                    }
                }
            }
        }

        $brand = $this->brand->getBrands('brand_id,brand_name,letter', 'state=3', 2, array('letter' => 'asc'), 1000);
        $this->tpl->assign('brand', $brand);
        $this->tpl->assign('lookact', $lookAct);
        $this->template($tpl_name);
    }

    //大家都在看插入数据
    function doAddLook() {
        /* $picSavePath = ATTACH_DIR . 'images/adpic/look';
          if (!is_dir($picSavePath)) {
          @file::forcemkdir($picSavePath);
          }
          $file = $_FILES['look_pic']; */
        $receiver = array('alias', 'brand_id', 'factory_id', 'series_id', 'series_id1', 'pic');
        $receiverArr = receiveArray($receiver);
        $arr = array();
//        var_dump($receiverArr);
        foreach ($receiverArr as $key => $val) {
//            if (!$val && $key != 'series_id1')
////                $this->alert("内容有为空的！", 'js', 3, $_ENV['PHP_SELF'] . 'lookact');
            $arr[$key] = $val;
        }
        /* if (!$file['tmp_name'])
          $this->alert("内容有为空的！", 'js', 3, $_ENV['PHP_SELF'] . 'lookact');
          $name = 'look_' . time();
          $fileExt = substr(strrchr($file['name'], '.'), 1);
          move_uploaded_file($file['tmp_name'], "$picSavePath/{$name}.$fileExt"); */

        $arr['pic'] = $receiverArr['pic'];
        $arr['created'] = date('Y-m-d');
        $arr['five'] = array();
        $arr['num'] = 1;
        /* $seriesName = $this->series->getSeriesdata('series_name',"series_id={$arr['series_id']}", 1);
          $arr['series_name'] = $seriesName['series_name']; */
        $lookRes = $this->index->getLook();
        $allInfo = unserialize($lookRes['value']);
        $num = $_POST['num'];

       $a =  $this->insertPageDataSeries('look', $num, $arr['created'], $receiverArr['series_id']);
//        var_dump($a);exit;

        if ($allInfo) {
            switch ($num) {
                case '1':
                    $arr['num'] += $allInfo[1]['num'];
                    break;
                case '2':
                    $arr['num'] += $allInfo[2]['num'];
                    break;
                case '3':
                    $arr['num'] += $allInfo[3]['num'];
                    break;
                case '4':
                    $arr['num'] += $allInfo[4]['num'];
                    break;
            }
            if ($allInfo[$num]) {
                if (count($allInfo[$num]['five']) > 4) {
                    array_pop($allInfo[$num]['five']);
                }
                array_unshift($allInfo[$num]['five'], array('alias' => $allInfo[$num]['alias'], 'start_time' => substr($allInfo[$num]['created'], 5), 'end_time' => date('m-d')));
                $arr['five'] = $allInfo[$num]['five'];
            }
            $allInfo[$num] = $arr;
            $this->index->ufields = array('value' => serialize($allInfo));
            $this->index->update();
        } else {
            //$allInfo = array(1=>$arr,2=>'',3=>'',4=>'');
            $allInfo[$num] = $arr;
            $xx = serialize($allInfo);
            $this->index->ufields = array('name' => 'look', 'value' => $xx, 'c1' => 'index', 'c2' => 1);
            $this->index->insert();
        }
        $this->alert("修改成功！", 'js', 3, $_ENV['PHP_SELF'] . 'lookact');
    }

    //大家都在看查看图片
    function doPic() {
        $state = $_GET['state'];
        $pic = $_GET['pic'];
        $sid = $_GET['sid'];
        $mid = $_GET['mid'];
        if ($state == 'focus5') {
            if (!empty($pic)) {
                echo "<img src='/attach/images/focus/$pic' />";
            } else {
                echo '没有图片';
            }
        } elseif ($state == 'focus2') {
            if ($mid && $pic) {
                echo "<img src='/attach/images/model/$mid/$pic' />";
            } else {
                echo '没有图片';
            }
        } else {
            if ($sid && $pic) {
                echo "<img src='/attach/images/series/$sid/$pic' />";
            } else {
                echo '没有图片';
            }
        }
    }

    //获取车系默认车款白底图
    function doGetDefaultModelPic() {
        $sid = intval($_GET['sid']);
        var_dump($sid);
//        if (!$sid) {
//            echo json_encode(array('error' => 1, 'msg' => '0'));
//            exit;
//        }
//        $defaultModel = $this->series->getSeriesdata('default_model', "series_id=$sid", 1);
//        if ($defaultModel) {
//            $setUp = $this->model->getSimp('st4,st21,date_id', "model_id={$defaultModel['default_model']} and state in (3,8)", 1);
//        } else {
//            $setUp = $this->model->getSimp('st4,st21,date_id', "series_id=$sid and state in (3,8) and st4<>'' AND st4 IS NOT NULL", 1);
//        }
//        $st4 = array_search($setUp['st4'], $this->series->st4_list);
//        $st21 = array_search($setUp['st21'], $this->series->st21_list);
//        $defaultModelPic = $this->cardbfile->getStylePic($sid, $st4, $st21, $setUp['date_id']);
//        echo json_encode(array('error' => 0, 'msg' => $defaultModelPic['name']));
    }

    //轮播图信息预览
    function doFocusList() {
        $tpl_name = 'cpindex_focuslist';
        $yesterdayDate = date("Y-m-d", strtotime("-1 day"));
        $yesterdayDate2 = strtotime($yesterdayDate);
        $num = $_GET['num'];
        if ($num == 5) {
            $this->vars('pdName', 'focus5');
            $result = $this->pageData->getPagedataLimit('start_time, id,value,state, start_time as date', "name='focus5' and c1='index' and c2=1 and start_time>='$yesterdayDate'", 10, '', 4);
        } else {
            $this->vars('pdName', 'focus2');
            $result = $this->pageData->getPagedataLimit('start_time, id,value,state, start_time as date', "name='focus2' and c1='index' and c2=1 and start_time>='$yesterdayDate'", 10, '', 4);
        }
        $pageDate = $pageDataRes = array();
        for ($i = 0; $i < 10; $i++) {
            $tmpDate = date('Y-m-d', $yesterdayDate2);
            $pageDate[] = $tmpDate;
            if ($i == 0) {
                $stateData[$tmpDate] = array('s' => 4);
            } else {
                $stateData[$tmpDate] = array('s' => 3, 'date' => $tmpDate);
            }
            $pageDataRes[$i] = $result[$tmpDate];
            $yesterdayDate2 += 60 * 60 * 24;
        }
        #var_dump($result);exit;
        if(!empty($result)) {
            if (!empty($pageDataRes)) {
                foreach ($pageDataRes as $key => $val) {
                    if ($val['value']) {
                        $pageDataValue = mb_unserialize($val['value']);
                        foreach ($pageDataValue as $k => $v) {
                            $tmp = explode('|', $v['title']);
                            $pageDataValue[$k]['title'] = $tmp[0];
                            if ($val['state'] == 2) {
                                $pageDataValue[$k]['state'] = '已生成';
                            } elseif ($val['state'] == 0) {
                                $pageDataValue[$k]['state'] = '<font style="color: red; font-weight: bold">未生成</font>';
                            }
                        }
                        $pageData[1][$key] = $pageDataValue[1];
                        $pageData[2][$key] = $pageDataValue[2];
                        $pageData[3][$key] = $pageDataValue[3];
                        $pageData[4][$key] = $pageDataValue[4];
                        $pageData[5][$key] = $pageDataValue[5];
                        $stateData[$val['date']]['s'] = $val['state'];
                        $stateData[$val['date']]['id'] = $val['id'];
                        $stateData[$val['date']]['date'] = $val['date'];
                    }
                    /* if($val['state'] == 2){
                      $pageData[] = array('url'=>"/admin/index.php?action=index-focusmake&id={$val['id']}");
                      } */
                }
            }
        }
        #var_dump($pageDate);exit;
        #var_dump($pageDataRes);exit;
        $this->tpl->assign('num', $num);
        $this->tpl->assign('statedata', $stateData);
        $this->tpl->assign('pagedate', $pageDate);
        $this->tpl->assign('pagedata', $pageData);
        $this->template($tpl_name);
    }

    //轮播图排序
    function doFocusSort() {
        $date = $_GET['date'];
        if ($date) {
            $tmpTime = date('Y-m-d');
            $tmp = date('Y-m-d', strtotime($date) - 60 * 60 * 24);
            $focusSortRes = $this->pageData->getSomePagedata('id,value', "name='focus5' and c1='index' and start_time='$tmp'", 1);
            if ($focusSortRes) {
                $tpl_name = 'cpindex_focussort';
                $focusSortInfo = mb_unserialize($focusSortRes['value']);
                if($focusSortInfo) {
                    foreach ($focusSortInfo as $key => $val) {
                        $xx = explode('|', $val['title']);
                        $focusSortInfo[$key]['title'] = $xx[0];
                    }
                }
                $this->tpl->assign('start_time', $date);
                $this->tpl->assign('id', $focusSortRes['id']);
                $this->tpl->assign('focussort', $focusSortInfo);
                $this->template($tpl_name);
            } else {
                if ($date == $tmpTime) {
                    $tpl_name = 'cpindex_focusact';
                    $focusAct = array(1 => '', 2 => '', 3 => '', 4 => '', 5 => '');
                    $this->tpl->assign('start_time', $date);
                    $this->tpl->assign('focusact', $focusAct);
                    $this->tpl->assign('num', $_GET['num']);
                    $this->template($tpl_name);
                } else {
                    $this->alert("请先填写昨天的值！", 'js', 3, $_ENV['PHP_SELF'] . 'focuslist&num=5');
                }
            }
        }
    }

    //轮播图排序操作
    function doFocusSortAct() {
        $tpl_name = 'cpindex_focusact';
        $id = $_POST['id'];
        $sort = $_POST['sort'];
        $start_time = $_POST['start_time'];
        $pageDataRes = $this->pageData->getSomePagedata('value', "id=$id", 1);
        $pageDataInfo = mb_unserialize($pageDataRes['value']);
        $sortArray = array();
        $tmp = array("1" => '', '2' => '', '3' => '', '4' => '', '5' => '');
        foreach ($sort as $key => $val) {
            if ($val) {
                $sortArray[$val] = $pageDataInfo[$key + 1];
            }
        }
        $sortArray = $sortArray + $tmp;
        ksort($sortArray);
        $sortArray = $this->focusAct($sortArray);
        $this->tpl->assign('num', 5);
        $this->tpl->assign('start_time', $start_time);
        $this->tpl->assign('focusact', $sortArray);
        $this->template($tpl_name);
    }

    //轮播图用
    function focusAct($focusAct) {
        if (!is_array($focusAct) || empty($focusAct))
            return;
        foreach ($focusAct as $key => $val) {
            if ($val['flag'] == 1) {
                $focusAct[$key]['str'] = "文章id:<input type='text' size='5' name='article_i[]' value={$val['article_id']}>";
            } elseif ($val['flag'] == 2) {
                $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
                $factory = $this->factory->getFactoryByBrand($val['brand_id']);
                $series = $this->series->getSeriesdata('series_id,series_name', "state=3 and factory_id={$val['factory_id']}");
                $modelList = $this->model->getSimp('model_id,model_name', "state in (3,8) and series_id={$val['series_id']}");
                $str = '<select name="brand_i[]" class="brand_id" onchange="javascript:brandChange(this);"><option value="">==请选择品牌==</option>';
                foreach ($brand as $bval) {
                    if ($bval['brand_id'] == $val['brand_id'])
                        $str .= "<option value={$bval['brand_id']} selected='trun'>{$bval['letter']} {$bval['brand_name']}</option>";
                    else
                        $str .= "<option value={$bval['brand_id']}>{$bval['letter']} {$bval['brand_name']}</option>";
                }
                $str .= '</select><select name="factory_i[]" class="factory_id" onchange="javascript:factoryChange(this);"><option value="">==请选择厂商==</option>';
                foreach ($factory as $fval) {
                    if ($fval['factory_id'] == $val['factory_id'])
                        $str .= "<option value={$fval['factory_id']} selected='trun'>{$fval['factory_name']}</option>";
                    else
                        $str .= "<option value={$fval['factory_id']}>{$fval['factory_name']}</option>";
                }
                $str .= '</select><select name="series_i[]" class="series_id" onchange="javascript:seriesChange(this);"><option value="">==请选择车系==</option>';
                foreach ($series as $sval) {
                    if ($sval['series_id'] == $val['series_id'])
                        $str .= "<option value={$sval['series_id']} selected='trun'>{$sval['series_name']}</option>";
                    else
                        $str .= "<option value={$sval['series_id']}>{$sval['series_name']}</option>";
                }
                $str .= '</select><select name="model_i[]"><option value="">==请选择车款==</option>';
                foreach ($modelList as $mval) {
                    if ($mval['model_id'] == $val['model_id'])
                        $str .= "<option value={$mval['model_id']} selected='trun'>{$mval['model_name']}</option>";
                    else
                        $str .= "<option value={$mval['model_id']}>{$mval['model_name']}</option>";
                }
                $str .= '</select>';
                $focusAct[$key]['str'] = $str;
            }elseif ($val['flag'] == 3) {
                $focusAct[$key]['str'] = "商情价id:<input type='text' size='5' name='bingoprice_i[]' value={$val['bingoprice_id']}>";
            }
            $tmp = explode('|', $val['title']);
            $focusAct[$key]['title'] = $tmp[0];
            $focusAct[$key]['title2'] = $tmp[1];
        }
        return $focusAct;
    }

    //轮播图操作
    function doFocusAct() {
        $tpl_name = 'cpindex_focusact';
        $date = $_GET['date'];
        $num = $_GET['num'];
        $focusAct = array(1 => array(), 2 => array());
        $id = '';
        if (!$date) {
            $id = $_GET['id'];
            $pageDataRes = $this->pageData->getSomePagedata('value,start_time', "id=$id", 1);
            $date = $pageDataRes['start_time'];
            $focusAct = mb_unserialize($pageDataRes['value']);
            $focusAct = $this->focusAct($focusAct);
        }
        $this->tpl->assign('id', $id);
        $this->tpl->assign('num', $num);
        $this->tpl->assign('start_time', $date);
        $this->tpl->assign('focusact', $focusAct);
        $this->template($tpl_name);
    }

    //轮播图添加信息
    function doAddFocus() {
        $receiver = array('flag', 'title', 'title2', 'pic', 'picalt', 'brand_i', 'factory_i', 'series_i', 'model_i', 'article_i', 'bingoprice_i', 'start_time', 'num', 'prev_pic');
        $receiverArr = receiveArray($receiver);
        if ($receiverArr['num'] == 2) {
            $receiverArr['flag'] = array(3, 3);
        } else {
            $receiverArr['num'] = 5;
        }
        $tmpName = 'focus' . $receiverArr['num'];
        $oldArr = $arr = array();
        $createFileTime = date('Ym', time());
        $picSavePath = ATTACH_DIR . 'images/focus/' . $createFileTime;
        if (!is_dir($picSavePath)) {
            @file::forcemkdir($picSavePath);
        }
        /* $result = $this->pageData->getSomePagedata('value', "name='$tmpName' and c1='index' AND c2 = 1 and start_time='{$receiverArr['start_time']}'", 3);                
          if($result) {
          $oldArr = unserialize($result);
          } */
        //var_dump($receiverArr['article_i']);exit;
        $name = 'focus_' . time();
        $file = $_FILES['focus_pic'];
        for ($i = 0; $i < $receiverArr['num']; $i++) {
            if($receiverArr['title'][$i] && $receiverArr['title2'][$i]) {
                $arr[$i + 1]['title'] = $receiverArr['title'][$i] . '|' . $receiverArr['title2'][$i];
            }else{
                $arr[$i + 1]['title'] ='';
            }
            if($receiverArr['picalt'][$i]) {
                $arr[$i + 1]['picalt'] = $receiverArr['picalt'][$i];
            }else{
                $arr[$i + 1]['picalt']='';
            }
            if ($receiverArr['num'] == 5) {
                if ($file['tmp_name'][$i]) {
                    $fileExt = substr(strrchr($file['name'][$i], '.'), 1);
                    $isUpload = move_uploaded_file($file['tmp_name'][$i], "$picSavePath/{$name}{$i}.$fileExt");
                    $arr[$i + 1]['pic'] = $name . $i . '.' . $fileExt;
                } else {
                    $arr[$i + 1]['pic'] = $receiverArr['prev_pic'][$i];
                }
            }
            $arr[$i + 1]['flag'] = $receiverArr['flag'][$i];
            #增加判断是否修改过
            $arr[$i + 1]['createfiletime'] = $createFileTime;
            switch ($receiverArr['flag'][$i]) {
                case '1':
                    $iKey3 = each($receiverArr['article_i']);
                    if (!$receiverArr['article_i'][$iKey3['key']])
                        $this->alert("文章id等于空！", 'js', 3, $_ENV['PHP_SELF'] . 'focuslist&num=' . $receiverArr['num']);
                    $arr[$i + 1]['article_id'] = $receiverArr['article_i'][$iKey3['key']];
                    $articleInfo = $this->article->getarticle($receiverArr['article_i'][$iKey3['key']]);
                    $articleYM = date('Ym', $articleInfo['created']);
                    $articleD = date('d', $articleInfo['created']);
                    $arr[$i + 1]['url'] = "/html/article/$articleYM/$articleD/{$receiverArr['article_i'][$iKey3['key']]}.html";
                    $asInfo = explode(',', $articleInfo['series_list']);
                    if ($asInfo[3]) {
                        $this->insertPageDataSeries('focus' . $receiverArr['num'], $i, $receiverArr['start_time'], $asInfo[3]);
                    }
                    break;
                case '2':
                    $iKey = each($receiverArr['series_i']);
                    $arr[$i + 1]['url'] = "/modelinfo_{$receiverArr['model_i'][$iKey['key']]}.html";
                    $arr[$i + 1]['brand_id'] = $receiverArr['brand_i'][$iKey['key']];
                    $arr[$i + 1]['factory_id'] = $receiverArr['factory_i'][$iKey['key']];
                    $arr[$i + 1]['series_id'] = $receiverArr['series_i'][$iKey['key']];
                    $arr[$i + 1]['model_id'] = $receiverArr['model_i'][$iKey['key']];
                    $this->insertPageDataSeries('focus' . $receiverArr['num'], $i, $receiverArr['start_time'], $arr[$i + 1]['series_id']);
                    break;
                case '3':
                    $iKey2 = each($receiverArr['bingoprice_i']);
                    $pricelogInfo = $this->pricelog->getPriceAndModelA(0, " and id={$receiverArr['bingoprice_i'][$iKey2['key']]}", 'cp.id, cm.model_id, cm.series_id, cm.factory_id, cm.brand_id');
                    if ($pricelogInfo) {
                        $pricelogInfo = $pricelogInfo[0];
                        if ($receiverArr['num'] == 2) {
                            $cfInfo = $this->model->getSimp('model_pic1', "model_id={$pricelogInfo['model_id']} and state in (3,8)", 1);
                            $arr[$i + 1]['pic'] = '190x142' . $cfInfo['model_pic1'];
                        }
                        $arr[$i + 1]['url'] = "/offers_{$pricelogInfo['model_id']}__{$pricelogInfo['id']}_0.html#shangqing{$pricelogInfo['id']}";
                        $arr[$i + 1]['bingoprice_id'] = $pricelogInfo['id'];
                        $arr[$i + 1]['brand_id'] = $pricelogInfo['brand_id'];
                        $arr[$i + 1]['factory_id'] = $pricelogInfo['factory_id'];
                        $arr[$i + 1]['series_id'] = $pricelogInfo['series_id'];
                        $arr[$i + 1]['model_id'] = $pricelogInfo['model_id'];
                        $this->insertPageDataSeries('focus' . $receiverArr['num'], $i, $receiverArr['start_time'], $arr[$i + 1]['series_id']);
                    }
                    break;
                case '4':
                    //$iKey4 = each($receiverArr[)
                    break;
                default:
                    break;
            }
            //$this->pageData->insertPageData(array('$arr);
        }
        $arr = serialize($arr);
        $dataExt = $this->pageData->getSomePagedata('id', "name='$tmpName' and c1='index' AND c2 = 1 and start_time='{$receiverArr['start_time']}'", 1);
        if ($dataExt) {
            $res = $this->pageData->updatePageData(array('value' => $arr), "id={$dataExt['id']}");
        } else {
            $res = $this->pageData->insertPageData(array('name' => $tmpName, 'value' => $arr, 'c1' => 'index', 'c2' => 1, 'start_time' => $receiverArr['start_time'], 'created' => time(), 'updated' => time()));
        }
        if($res) {
            $this->alert("提交成功！", 'js', 3, $_ENV['PHP_SELF'] . 'focuslist&num=' . $receiverArr['num']);
        }
    }

    //轮播图历史信息
    function doFocusHistory() {
        $tpl_name = 'cpindex_focushistory';
        $num = $_GET['num'];
        $page = max(1, $_GET['page']);
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $historyRes = $this->pageData->getPage('start_time, value', "name='focus$num' and c1='index'", $offset, $limit, '');
        if (!$historyRes)
            exit('没有信息');
        $historyInfo = array();
        $historyDate = array();
        if($historyRes) {
            foreach ($historyRes as $val) {
                $pageValue = mb_unserialize($val['value']);
                $historyDate[] = $val['start_time'];
                if($pageValue) {
                    foreach ($pageValue as $k => $v) {
                        $tmp = explode('|', $v['title']);
                        $historyInfo[$k][] = $tmp[0];
                    }
                }
            }
        }

        $page_bar = $this->multi($this->pageData->total, $limit, $page, $_SERVER['PHP_SELF'] . "?action=cpindex-focushistory&num=$num");
        $this->tpl->assign('num', $num);
        $this->tpl->assign('page_bar', $page_bar);
        $this->tpl->assign('historydate', $historyDate);
        $this->tpl->assign('historyinfo', $historyInfo);
        $this->template($tpl_name);
    }

    //新车-即将上市信息预览
    function doNewCarList() {

        $upcomingData = '';
        $tpl_name = 'cpindex_newcarlist';
        $result = $this->pageData->getSomePagedata('value', "name='upcoming' and c1='index'", 1);
        if (!empty($result)) {
            $result = mb_unserialize($result['value']);
        }
        $this->tpl->assign('upcomingdata', $result);
        $this->template($tpl_name);
    }

    //新车-即将上市操作
    function doNewCarAct() {
        $tpl_name = 'cpindex_newcaract';
        $this->template($tpl_name);
    }

    //新车-添加
    function doAddNewCar() {
        $receiver = array('date', 'car_name', 'price', 'url');
        $receiverArr = receiveArray($receiver);
        $flag = '';
        $newArray = array();
        foreach ($receiverArr['date'] as $key => $val) {
            if ($val) {
                $flag = 1;
                $newArray[] = array('date' => $receiverArr['date'][$key], 'car_name' => $receiverArr['car_name'][$key], 'price' => $receiverArr['price'][$key], 'url' => $receiverArr['url'][$key]);
            }
        }
        if (!$flag) {
            $this->alert("没有填写信息！", 'js', 3, $_ENV['PHP_SELF'] . 'newcaract');
        }
        $result = $this->pageData->getSomePagedata('value', "name='upcoming' and c1='index'", 1);
        if (empty($result)) {
            $value = serialize($newArray);
            $this->pageData->insertPageData(array('name' => 'upcoming', 'value' => $value, 'c1' => 'index', 'c2' => '1', 'updated' => time()));
        } else {
            $result = unserialize($result['value']);
            $formLenght = count($newArray);
            for ($i = $formLenght; $i > 0; $i--) {
                array_unshift($result, $newArray[$i - 1]);
            }
            $resLenght = count($result);
            if ($resLenght > 6) {
                $j = $resLenght - 6;
                for ($i = 0; $i < $j; $i++) {
                    array_pop($result);
                }
            }
            /* $dateArray = array();
              foreach ($result as $val) {
              $dateArray[] = $val['date'];
              }
              array_multisort($dateArray, SORT_DESC, $result); */
            $value = serialize($result);
            $this->pageData->updatePageData(array('value' => $value), "name='upcoming' and c1='index'");
            //var_dump($result);exit;
        }
        $this->alert("添加成功！", 'js', 3, $_ENV['PHP_SELF'] . 'newcarlist');
    }

    //新车-修改
    function doModifyNewCar() {
        $receiver = array('id', 'date', 'name', 'price', 'url');
        $receiverArr = receiveArray($receiver);
        $result = $this->pageData->getSomePagedata('value', "name='upcoming' and c1='index'", 1);
        $value = unserialize($result['value']);
        $value[$receiverArr['id']] = array('date' => $receiverArr['date'], 'car_name' => $receiverArr['name'], 'price' => $receiverArr['price'], 'url' => $receiverArr['url']);
        /* $dateArray = array();
          foreach($value as $val){
          $dateArray[] = $val['date'];
          }
          array_multisort($dateArray, SORT_DESC, $value); */
        $value = serialize($value);
        $this->pageData->updatePageData(array('value' => $value), "name='upcoming' and c1='index'");
        $this->alert("修改成功！", 'js', 3, $_ENV['PHP_SELF'] . 'newcarlist');
    }

    //排行榜-降价TOP10
    function doSaleTop10() {
        //($fields, $where, $order, $limit, $flag=1){
        $time = time() - 60 * 60 * 24 * 90;
        $this->price->limit = 100;
        $this->price->order = array('cp.nude_car_rate' => 'desc');
        $result = $this->price->getPriceAndModelA('0', " and cp.get_time>$time", 'cp.nude_car_rate,cm.model_id,cm.series_name,cm.series_id,cm.model_pic1');
        //$result = $this->pricelog->joinTableCardbmodel('cp.nude_car_rate,cm.model_id,cm.series_name', "", array('nude_car_rate'=>'desc'), 10, 'cp.series_id', 2);
        if (!empty($result)) {
            $sid = $newResult = array();
            foreach ($result as $val) {
                if (in_array($val['series_id'], $sid))
                    continue;
                if (count($newResult) > 9)
                    break;
                $newResult[] = $val;
                $sid[] = $val['series_id'];
            }
            $tplName = 'ssi_newindex_saletop10';
            $fileName = WWW_ROOT . 'ssi/ssi_newindex_saletop10.shtml';
            $this->vars('result', $newResult);
            #var_dump($result);
            $html = $this->fetch($tplName);
            //                    echo($html);
            //                    exit;
            $ret = file_put_contents($fileName, $html);
            echo $ret;
        }
    }

    //排行榜-车型热度榜
    function doHotTop10() {
        $time = time() - 60 * 60 * 24 * 90;
        include SITE_ROOT . 'lib/webclient.class.php';
        $catchdata = new CatchData();
        $autohomeUrl = 'http://www.autohome.com.cn/includefile/index1017/newdealer/110100.html?C1';
        $catchdata->result = '';
        $catchdata->catchResult($autohomeUrl);
        $matchs = $catchdata->pregMatch('/<div class="market-text\d+"><a href="[^"]+">(.+?)<\/a><\/div>/sim');
        if (!empty($matchs)) {
            $newString = '';
            for ($i = 0; $i < 20; $i++) {
                $newString .= '\'' . $matchs[1][$i] . '\',';
            }
            $newString = rtrim($newString, ',');
            $result = $this->series->getSeriesdata('series_name,series_id,series_name sm', "series_name in ($newString)", 4);
            if (!empty($result)) {
                $newResult = array();
                $this->price->order = array('cp.get_time' => 'desc', 'cp.nude_car_rate' => 'desc', 'cm.model_price' => 'asc');
                for ($i = 0; $i < 20; $i++) {
                    $tmp = $this->price->getPriceAndModelA('0', " and cp.series_id={$result[$matchs[1][$i]]['series_id']} and cp.get_time>$time", 'cp.nude_car_rate,cm.model_id,cm.model_pic1', '1');
                    if ($tmp && $tmp['nude_car_rate'] > 0) {
                        $newResult[] = array(
                            'nude_car_rate' => $tmp['nude_car_rate'],
                            'model_id' => $tmp['model_id'],
                            'series_id' => $result[$matchs[1][$i]]['series_id'],
                            'series_name' => $result[$matchs[1][$i]]['sm'],
                            'model_pic1' => $tmp['model_pic1']
                        );
                    }
                    if (count($newResult) > 9)
                        break;
                }
                $tplName = 'ssi_newindex_hottop10';
                $fileName = WWW_ROOT . 'ssi/ssi_newindex_hottop10.shtml';
                $this->vars('result', $newResult);
                $html = $this->fetch($tplName);
                //                    echo($html);
                //                    exit;
                $ret = file_put_contents($fileName, $html);
                echo $ret;
            }
        }
    }

    //排行榜-折扣TOP10
    function doDiscountTop10() {
        $time = time() - 60 * 60 * 24 * 90;
        $this->price->limit = 100;
        $this->price->order = array('discount' => 'asc');
        $discountInfo = $this->price->getPriceAndModelA('0', " and cp.get_time>$time", 'cp.model_id, cp.price, cm.series_id, cm.model_price, cm.series_name, cm.model_pic1, cp.price/cm.model_price discount');
        if (!empty($discountInfo)) {
            $discount = $sid = array();
            foreach ($discountInfo as $val) {
                if (in_array($val['series_id'], $sid))
                    continue;
                if (count($discount) > 9)
                    break;
                $sid[] = $val['series_id'];
                $discount[] = $val;
            }
            $tplName = 'ssi_newindex_discounttop10';
            $fileName = WWW_ROOT . 'ssi/ssi_newindex_discounttop10.shtml';
            $this->vars('result', $discount);
            $html = $this->fetch($tplName);
            //                    echo($html);
            //                    exit;
            $ret = file_put_contents($fileName, $html);
            echo $ret;
        }
    }

    //新车上市
    function doNewCarMarket() {
        $y = date('Y');
        $this->model->fields = 'cm.model_id,cm.series_id,cm.model_pic1,cm.date_id,cs.series_alias,cs.series_name';
        $result = $this->model->getSimpleModels("cm.series_id=cs.series_id and cm.state=3 and cs.state=3 and cm.date_id>=$y and model_pic1<>''", 500, 0, array('cm.date_id' => 'desc', 'cm.created' => 'desc'), array('cardb_model' => 'cm', 'cardb_series' => 'cs'));
        if ($result) {
            $arr = $sid = array();
            $i = 0;
            foreach ($result as $val) {
                if (in_array($val['series_id'], $sid))
                    continue;
                $arr[$i]['model_id'] = $val['model_id'];
                $arr[$i]['model_pic1'] = $val['model_pic1'];
                $arr[$i]['series_name'] = $val['series_alias'] ? $val['series_alias'] : $val['series_name'];
                $arr[$i]['date_id'] = $val['date_id'];
                $sid[$i] = $val['series_id'];
                $i++;
                if (count($arr) > 7)
                    break;
            }
            $tplName = 'ssi_newindex_newcarmarket';
            $fileName = WWW_ROOT . 'ssi/ssi_newindex_newcarmarket.shtml';
            $this->vars('result', $arr);
            $html = $this->fetch($tplName);
            $ret = file_put_contents($fileName, $html);
            echo $ret;
        }
    }

    //自动生成置换/贷款
    //综合优惠急诊科
    function doDiscountList() {
        $tpl_name = 'cpindex_discountlist';
        $yesterdayDate = date("Y-m-d", strtotime("-1 day"));
        $yesterdayDate2 = strtotime($yesterdayDate);
        $result = $this->pageData->getPagedataLimit('start_time, id, value, state, start_time as date', "name='discount' and c1='index' and start_time>='$yesterdayDate'", 10, '', 4);
        $pageDate = $pageDataRes = $pageData = array();
        for ($i = 0; $i < 10; $i++) {
            $tmpDate = date('Y-m-d', $yesterdayDate2);
            $pageDate[] = $tmpDate;
            if ($i == 0) {
                $stateData[$tmpDate] = array('s' => 4);
            } else {
                $stateData[$tmpDate] = array('s' => 3, 'date' => $tmpDate);
            }
            $pageDataRes[$i] = $result[$tmpDate];
            $yesterdayDate2 += 60 * 60 * 24;
        }
//        var_dump($result);exit;
        if (!empty($pageDataRes)) {
            foreach ($pageDataRes as $key => $val) {
                if ($val['value']) {
                    $pageDataValue = mb_unserialize($val['value']);
                    foreach ($pageDataValue as $k => $v) {
                        if ($val['state'] == 2) {
                            $pageDataValue[$k]['state'] = '已生成';
                        } elseif ($val['state'] == 0) {
                            $pageDataValue[$k]['state'] = '未生成';
                        }
                    }
                    $pageData[0][$key] = $pageDataValue[0];
                    $pageData[1][$key] = $pageDataValue[1];
                    $pageData[2][$key] = $pageDataValue[2];
                    $stateData[$val['date']]['s'] = $val['state'];
                    $stateData[$val['date']]['id'] = $val['id'];
                }
                /* if($val['state'] == 2){
                  $pageData[] = array('url'=>"/admin/index.php?action=index-focusmake&id={$val['id']}");
                  } */
            }
        }
//        var_dump($stateData["2015-06-13"]);exit;
        $this->tpl->assign('statedata', $stateData);
        $this->tpl->assign('pagedata', $pageData);
        $this->tpl->assign('pagedate', $pageDate);
        $this->template($tpl_name);
    }

    //综合优惠急诊科操作
    function doDiscountAct() {
        $tpl_name = 'cpindex_discountact';
        $startTime = $_GET['date'];
        $id = $_GET['id'];
        if ($id) {
            $result = $this->pageData->getSomePagedata('value,start_time', "id=$id", 1);
            $discountAct = mb_unserialize($result['value']);
            $this->tpl->assign('discountact', $discountAct);
            $this->tpl->assign('id', $id);
        }
        $this->tpl->assign('start_time', $startTime);
        $this->template($tpl_name);
    }

    //综合优惠急诊科添加
    function doDiscountAdd() {
        $receiver = array('profile', 'detail', 'index', 'bingokey', 'dbid', 'start_time');
        $receiverArr = receiveArray($receiver);
        $flag = '';
        $newArray = array();
        foreach ($receiverArr['profile'] as $key => $val) {
            if ($val) {
                $flag = 1;
                $result = $this->pricelog->joinTableCardbmodel('cp.get_time,cm.model_id,cm.model_price,cm.series_id,cm.model_pic1,cm.brand_name,cm.factory_name,cm.series_name,cm.model_name', "cp.id={$receiverArr['bingokey'][$key]} and cp.model_id=cm.model_id and state in (3,8)", '', '', '');
                if (empty($result)) {
                    $this->alert("暗访价id没有找到！", 'js', 3, $_ENV['PHP_SELF'] . 'discountact');
                }
                $newArray[$key] = array('profile' => $receiverArr['profile'][$key], 'detail' => $receiverArr['detail'][$key], 'index' => $receiverArr['index'][$key], 'bingoid' => $receiverArr['bingokey'][$key], 'get_time' => $result['get_time'], 'model_id' => $result['model_id'], 'model_name' => $result['model_name'], 'series_name' => $result['series_name'], 'factory_name' => $result['factory_name'], 'brand_name' => $result['brand_name'], 'series_id' => $result['series_id'], 'model_pic1' => $result['model_pic1'], 'model_price' => $result['model_price']);
            }
        }
        if (!$flag) {
            $this->alert("没有填写信息！", 'js', 3, $_ENV['PHP_SELF'] . 'discountact');
        }
        foreach ($newArray as $key => $val) {
            $this->insertPageDataSeries('discount', $key, $receiverArr['start_time'], $val['series_id']);
        }
        $value = serialize($newArray);
//        header("Content-type: text/html; charset=utf-8");
//        var_dump($value);
//        exit;
        if ($receiverArr['dbid']) {
            $res = $this->pageData->updatePageData(array('value' => $value, 'state' => 0), "id={$receiverArr['dbid']}");
        } else {
            $res = $this->pageData->insertPageData(array('name' => 'discount', 'value' => $value, 'c1' => 'index', 'c2' => '1', 'start_time' => $receiverArr['start_time'], 'updated' => time()));
        }
        if($res) {
            $this->alert("成功！", 'js', 3, $_ENV['PHP_SELF'] . 'discountlist');
        }
    }

    //猜您喜欢信息预览
    function doRecommendList() {
        $tpl_name = 'cpindex_recommendlist';
        $recommendList = array();
        $recommendRes = $this->pageData->getSomePagedata('value', 'name="recommend"', 1);
        if ($recommendRes) {
            $recommendList1 = mb_unserialize($recommendRes['value']);
            if($recommendList1) {
                foreach ($recommendList1 as $key => $val) {
                    $recommendList[$key] = $val;
                }
            }
        }
        //var_dump($recommendList);exit;
        $this->tpl->assign('recommendlist', $recommendList);
        $this->template($tpl_name);
    }

    //猜您喜欢操作
    function doRecommendAct() {
        $tpl_name = 'cpindex_recommendact';
        $recommendAct = array();
        $recommendRes = $this->pageData->getSomePagedata('value', 'name="recommend"', 1);
        if ($recommendRes) {
            $recommendAct1 = unserialize($recommendRes['value']);
            if($recommendAct1) {
                foreach ($recommendAct1[0] as $key => $val) {
                    $recommendAct[$key] = $val;
                    if ($val['brand_id']) {
                        //var_dump($val);exit;
                        $factoryData = $this->factory->getFactoryByBrand($val['brand_id']);
                        $seriesData = $this->series->getSeriesdata('series_id,series_name,series_alias', "factory_id={$val['factory_id']} and state=3");
                        $recommendAct[$key]['factory'] = $factoryData;
                        $recommendAct[$key]['series'] = $seriesData;
                    }
                }
            }
            $this->tpl->assign('recommendact', $recommendAct);
        }
        $brand = $this->brand->getBrands('brand_id,brand_name,letter', 'state=3', 2, array('letter' => 'asc'), 1000);
        $this->tpl->assign('brand', $brand);
        $this->template($tpl_name);
    }

    //猜您喜欢操作数据库
    function doRecommendAdd() {
        $receiver = array('brand_i', 'factory_i', 'series_i');
        $receiverArr = receiveArray($receiver);
        $arr = array();
        $date = date('Y-m-d');
        foreach ($receiverArr as $key => $val) {
            for ($i = 0; $i < 12; $i++) {
                if ($key == 'series_i') {
                    if (!$val[$i]) {
                        //$this->alert("内容有为空的！", 'js', 3, $_ENV['PHP_SELF'] . 'recommendact');
                        continue;
                    }
                    $arr[$i]['series_id'] = $val[$i];
                    $priceResult = $this->price->getPriceByModelId('price, model_id', "series_id={$val[$i]} and price_type=0", array('get_time' => 'desc', 'price' => 'asc'), 1);
                    if (empty($priceResult)) {
                        exit('车系id' . $val[$i] . '下没有车款有暗访价');
                    }
                    $modelResult = $this->model->chkModel('model_pic1, brand_name, factory_id, series_id', "model_id={$priceResult['model_id']}", '', 1);
                    $seriesAlias = $this->series->getSeriesdata('series_alias,series_name', "series_id={$modelResult['series_id']} and state=3", 1);
                    $factoryAlias = $this->factory->getFactorylist('factory_alias', "factory_id={$modelResult['factory_id']}", 1);
                    $arr[$i]['price'] = $priceResult['price'];
                    $arr[$i]['model_id'] = $priceResult['model_id'];
                    $arr[$i]['model_pic1'] = $modelResult['model_pic1'];
                    $arr[$i]['brand_name'] = $modelResult['brand_name'];
                    $arr[$i]['factory_alias'] = $factoryAlias['factory_alias'];
                    $arr[$i]['series_alias'] = $seriesAlias['series_alias'];
                    //$this->insertPageDataSeries('recommend', $i, $date, $tmp[0]);
                    //$arr[$i]['series_alias'] = $tmp[1];
                    //$arr[$i]['series_alias'] = $seriesAlias['series_name'];
                } else {
                    if (!$val[$i]) {
                        continue;
                    }
                    //$this->alert("内容有为空的！", 'js', 3, $_ENV['PHP_SELF'] . 'recommendact');
                    $arr[$i][$key . 'd'] = $val[$i];
                    $arr[$i]['created'] = $date;
                }
            }
        }
        #var_dump($arr);exit;
        #$arr['created'] = date('Y-m-d');
        $recommendRes = $this->pageData->getSomePagedata('value', 'name="recommend"', 1);
        if ($recommendRes) {
            $allInfo = unserialize($recommendRes['value']);
            if (count($allInfo) > 4) {
                array_pop($allInfo);
            }
            foreach ($allInfo as $key => $val) {
                foreach ($val as $k => $v) {
                    $allInfo[$key][$k]['start_time'] = $v['created'];
                    $allInfo[$key][$k]['end_time'] = $date;
                }
            }
            array_unshift($allInfo, $arr);
            $allInfo = serialize($allInfo);
            $this->pageData->updatePageData(array('value' => $allInfo), 'name="recommend"');
        } else {
            $value = serialize(array($arr));
            $this->pageData->insertPageData(array('name' => 'recommend', 'value' => $value, 'c1' => 'index', 'c2' => '1', 'updated' => time()));
        }
        $this->alert("修改成功！", 'js', 3, $_ENV['PHP_SELF'] . 'recommendact');
    }

    //车型PK信息预览
    function doModelPKList() {
        $tpl_name = 'cpindex_modelpklist';
        $limit = 20;
        $page = max(1, $_GET['page']);
        $offset = ($page - 1) * $limit;
        $tmpArray = array();
        $pkInfo = $this->pageData->getPage('value,created', "name='modelpk' and c1='index'", $offset, $limit, array('id' => 'desc'));
        if ($pkInfo) {
            foreach ($pkInfo as $key => $val) {
                $tmpArray[$key] = mb_unserialize($val['value']);
                $tmpArray[$key]['created'] = $val['created'];
            }
            #var_dump($tmpArray);exit;
            $this->tpl->assign('pkinfo', $tmpArray);
        }
        $page_bar = $this->multi($this->pageData->total, $limit, $page, $_ENV['PHP_SELF'] . 'modelpklist');
        $this->tpl->assign('page_bar', $page_bar);
        $this->template($tpl_name);
    }

    //车型PK操作
    function doModelPKAct() {
        $tpl_name = 'cpindex_modelpkact';
        $brand = $this->brand->getBrands('brand_id,brand_name,letter', 'state=3', 2, array('letter' => 'asc'), 1000);
        $this->tpl->assign('brand', $brand);
        $this->template($tpl_name);
    }

    //车型PK添加
    function doModelPKAdd() {
        $receiver = array('brand_i', 'factory_i', 'series_i', 'model_i');
        $receiverArr = receiveArray($receiver);
        $date = date('Y-m-d');
        //$value = array();
        for ($i = 0; $i < 10; $i++) {
            if ($receiverArr['model_i'][$i]) {
                $sInfo = $sInfo2 = $result = $result2 = array();
                if ($receiverArr['series_i'][$i]) {
                    $sInfo = $this->series->getSeriesdata('series_id, series_alias', "series_id={$receiverArr['series_i'][$i]}", 1);
                    if ($sInfo)
                        $this->insertPageDataSeries('modelpk', $i, $date, $sInfo['series_id']);
                }
                if ($receiverArr['series_i'][$i + 1]) {
                    $sInfo2 = $this->series->getSeriesdata('series_id, series_alias', "series_id={$receiverArr['series_i'][$i + 1]}", 1);
                    if ($sInfo)
                        $this->insertPageDataSeries('modelpk', $i + 1, $date, $sInfo2['series_id']);
                }
                if ($receiverArr['model_i'][$i])
                    $result = $this->model->getSimp('model_pic1', "model_id={$receiverArr['model_i'][$i]}", 1);
                if ($receiverArr['model_i'][$i + 1])
                    $result2 = $this->model->getSimp('model_pic1', "model_id={$receiverArr['model_i'][$i + 1]}", 1);
                $value = array(
                    array('brand_id' => $receiverArr['brand_i'][$i], 'factory_id' => $receiverArr['factory_i'][$i], 'series_id' => $sInfo['series_id'], 'series_alias' => $sInfo['series_alias'], 'model_id' => $receiverArr['model_i'][$i], 'model_pic1' => $result['model_pic1']),
                    array('brand_id' => $receiverArr['brand_i'][$i + 1], 'factory_id' => $receiverArr['factory_i'][$i + 1], 'series_id' => $sInfo2['series_id'], 'series_alias' => $sInfo2['series_alias'], 'model_id' => $receiverArr['model_i'][$i + 1], 'model_pic1' => $result2['model_pic1'])
                );
                $this->pageData->insertPageData(array('name' => 'modelpk', 'value' => serialize($value), 'c1' => 'index', 'c2' => '1', 'start_time' => $date, 'created' => time(), 'updated' => time()));
            }
            //var_dump($value);
            $i = $i + 1;
        }
        $this->alert("成功！", 'js', 3, $_ENV['PHP_SELF'] . 'modelpklist');
    }

    //车型PK生成
    function doMakeModelPK() {
        $flag = $this->makeFile2('modelpk', '', 5, array('id' => 'desc'));
        if ($flag > 0) {
            $this->alert("成功！", 'js', 3, $_ENV['PHP_SELF'] . 'modelpklist');
        } else {
            $this->alert("失败！", 'js', 3, $_ENV['PHP_SELF'] . 'modelpklist');
        }
    }
    //在后台辅助工具里生-成车型PK
    function doMakeModelPK2(){
        $ret = $this->makeFile2('modelpk', '', 5, array('id' => 'desc'));
        //1.生成成功 0.生成失败
        if ($ret)
            echo 1;
        else
            echo 0;
    }

    //置换/贷款信息列表
    function doLoanReplaceList() {
        $tpl_name = 'cpindex_loanreplacelist';
        $yesterdayDate = date("Y-m-d", strtotime("-1 day"));
        $yesterdayDate2 = strtotime($yesterdayDate);
        $result = $this->pageData->getPagedataLimit('start_time, id, value, state, start_time as date', "name='loanreplace' and c1='index' and start_time>='$yesterdayDate'", 10, '', 4);
        $pageDate = $pageDataRes = $pageData = array();
        for ($i = 0; $i < 10; $i++) {
            $tmpDate = date('Y-m-d', $yesterdayDate2);
            $pageDate[] = $tmpDate;
            if ($i == 0) {
                $stateData[$tmpDate] = array('s' => 4);
            } else {
                $stateData[$tmpDate] = array('s' => 3, 'date' => $tmpDate);
            }
            $pageDataRes[$i] = $result[$tmpDate];
            $yesterdayDate2 += 60 * 60 * 24;
        }
        #var_dump($pageDataRes);exit;
        if (!empty($pageDataRes)) {
            foreach ($pageDataRes as $key => $val) {
                if ($val['value']) {
                    $pageDataValue = unserialize($val['value']);
                    foreach ($pageDataValue as $k => $v) {
                        if ($val['state'] == 2) {
                            $pageDataValue[$k]['state'] = '已生成';
                        } elseif ($val['state'] == 0) {
                            $pageDataValue[$k]['state'] = '未生成';
                        }
                    }
                    $pageData[0][$key] = $pageDataValue[0];
                    $pageData[1][$key] = $pageDataValue[1];
                    $pageData[2][$key] = $pageDataValue[2];
                    $pageData[3][$key] = $pageDataValue[3];
                    $pageData[4][$key] = $pageDataValue[4];
                    $pageData[5][$key] = $pageDataValue[5];
                    $pageData[6][$key] = $pageDataValue[6];
                    $pageData[7][$key] = $pageDataValue[7];
                    $pageData[8][$key] = $pageDataValue[8];
                    $stateData[$val['date']]['s'] = $val['state'];
                    $stateData[$val['date']]['id'] = $val['id'];
                }
                /* if($val['state'] == 2){
                  $pageData[] = array('url'=>"/admin/index.php?action=index-focusmake&id={$val['id']}");
                  } */
            }
        }
        #var_dump($pageData);exit;
        $this->tpl->assign('statedata', $stateData);
        $this->tpl->assign('pagedata', $pageData);
        $this->tpl->assign('pagedate', $pageDate);
        $this->template($tpl_name);
    }

    //置换/贷款操作
    function doLoanReplaceAct() {
        $tpl_name = 'cpindex_loanreplaceact';
        $startTime = $_GET['start_time'];
        $yesterday = date('Y-m-d', strtotime($startTime) - 60 * 60 * 24);
        $yesterdayRes = $loanReplaceData = '';
        $result = $this->pageData->getSomePagedata('value', "name='loanreplace' and c1='index' and start_time='$yesterday'", 1);
        if ($result)
            $yesterdayRes = unserialize($result['value']);
        $id = $_GET['id'];
        if ($id) {
            $result = $this->pageData->getSomePagedata('value', "id='$id'", 1);
            $loanReplaceData = unserialize($result['value']);
            $this->tpl->assign('loanreplacedata', $loanReplaceData);
        }
        $this->tpl->assign('yesterdaydata', $yesterdayRes);
        $this->tpl->assign('start_time', $startTime);
        $this->tpl->assign('id', $id);
        $this->template($tpl_name);
    }

    //置换/贷款添加信息
    function doLoanReplaceAdd() {
        $seriesLoan = new seriesLoan();
        $bingopriceId = $_POST['bingoprice_i'];
        $startTime = $_POST['start_time'];
        $id = $_POST['id'];
        $value = array();
        for ($i = 0; $i < 8; $i++) {
            if (empty($bingopriceId[$i]) || !is_numeric($bingopriceId[$i]))
                continue;
            //取值没有完
            //$tmp = $this->pricelog->getIndexRmdArticle($bingopriceId[$i]);
            $tmp = $this->pricelog->getPriceAndModelA('0', " and cp.id=$bingopriceId[$i]", 'cp.price, cp.rate, cp.down_payment, cp.interest_rate_fee, cp.low_year, cm.model_id, cm.series_id, cm.factory_id, cm.model_name, cm.series_name, cm.date_id, cm.model_price, cm.model_pic1, cm.st27, cm.st28, cm.st41, cm.st48');
            if ($tmp) {
                $sInfo = $this->series->getSeriesdata('series_alias', "series_id={$tmp[0]['series_id']}", 1);
                $fInfo = $this->factory->getFactorylist('factory_alias', "factory_id={$tmp[0]['factory_id']} and state=3", 1);
                $time = time();
                if ($i < 4) {
                    //小于4为置换
                    //厂商补贴
                    $oldcarvalInfo = $this->oldcarval->getOlds('car_prize', "model_id={$tmp[0]['model_id']} and start_date<=$time and end_date>=$time", 1);
                    //节能补贴
                    $realdataInfo = $this->realdata->getRealdata('conservate', "series_id = {$tmp[0]['series_id']} AND date_id = {$tmp[0]['date_id']} AND st27 = {$tmp[0]['st27']} AND st28='{$tmp[0]['st28']}' AND st41 = '{$tmp[0]['st41']}' AND st48='{$tmp[0]['st48']}'", 1);
                    $this->insertPageDataSeries('loanreplace', $i, $startTime, $tmp['series_id']);
                    $value[$i]['model_id'] = $tmp[0]['model_id'];
                    $value[$i]['series_alias'] = $sInfo['series_alias'];
                    $value[$i]['factory_alias'] = $sInfo['factory_alias'];
                    $value[$i]['model_name'] = $tmp[0]['model_name'];
                    $value[$i]['pricelog_id'] = $bingopriceId[$i];
                    $value[$i]['bingo_price'] = $tmp[0]['price'];
                    $value[$i]['model_pic1'] = $tmp[0]['model_pic1'];
                    $value[$i]['markdown'] = floatval($tmp[0]['model_price'] - $tmp[0]['price']);
                    $value[$i]['model_price'] = $tmp[0]['model_price'];
                    $value[$i]['car_prize'] = $oldcarvalInfo['car_prize'] ? $oldcarvalInfo['car_prize'] : '--';
                    $value[$i]['conservate'] = $realdataInfo['conservate'] ? $realdataInfo['conservate'] : '--';
                    $value[$i]['price'] = floatval(($tmp[0]['price'] * 10000 - $oldcarvalInfo['car_prize']) / 10000);
                } else {
                    //手续费
//                    $fee = $seriesLoan->getSeriesLoan("series_id = {$tmp[0]['series_id']}", 'commission', 3);
                    $this->insertPageDataSeries('loanreplace', $i, $startTime, $tmp['series_id']);
                    $loanInfo = $this->seriesloan->getSeriesLoan("start_date<=$time and end_date>=$time and is_valid=1 and series_id={$tmp[0]['series_id']}", 'name, first_pay_rate, loan_peroid', 1);
                    //大于4为贷款
                    $value[$i]['model_id'] = $tmp[0]['model_id'];
                    $value[$i]['series_alias'] = $sInfo['series_alias'];
                    $value[$i]['factory_alias'] = $sInfo['factory_alias'];
                    $value[$i]['model_name'] = $tmp[0]['model_name'];
                    $value[$i]['pricelog_id'] = $bingopriceId[$i];
                    $value[$i]['bingo_price'] = $tmp[0]['price'];
                    $value[$i]['model_pic1'] = $tmp[0]['model_pic1'];
                    $value[$i]['markdown'] = floatval($tmp[0]['model_price'] - $tmp[0]['price']);
                    $value[$i]['model_price'] = $tmp[0]['model_price'];
                    $value[$i]['rate'] = $loanInfo['name'];
                    $value[$i]['down_payment'] = floatval($loanInfo['first_pay_rate']);
                    $value[$i]['low_year'] = floatval($loanInfo['loan_peroid']);
//                    $value[$i]['fee'] = $fee;
                }
            }
        }
        #var_dump($value);exit;
        if ($id) {
            $this->pageData->updatePageData(array('value' => serialize($value), 'updated' => time(), 'state' => 0), "id=$id");
        } else {
            $this->pageData->insertPageData(array('name' => 'loanreplace', 'value' => serialize($value), 'c1' => 'index', 'start_time' => $startTime, 'created' => time(), 'updated' => time()));
        }
        $this->alert("提交成功！", 'js', 3, $_ENV['PHP_SELF'] . 'loanreplacelist');
    }

    //生成置换/贷款
    function doMakeLoanReplace() {
        $id = $_GET['id'];
        $value = $this->pageData->getPageData(array('id' => $id), 1, 'value, start_time');
        if ($value) {
            $sdate = date('Y_m_d', strtotime($value['start_time']));
            $result = unserialize($value['value']);
            $result = array(array($result[0], $result[1], $result[2], $result[3]), array($result[4], $result[5], $result[6], $result[7]));
            //置换
            $this->vars('result', $result[0]);
            $html = $this->fetch('ssi_newindex_replace');
            $ret = file_put_contents(WWW_ROOT . "ssi/ssi_newindex_replace_$sdate.shtml", $html);
            $this->removeFile('replace');

            //贷款
            $this->vars('result', $result[1]);
            $html = $this->fetch('ssi_newindex_loan');
            $ret = file_put_contents(WWW_ROOT . "ssi/ssi_newindex_loan_$sdate.shtml", $html);
            $this->removeFile('loan');

            if ($ret) {
                $this->pageData->updatePageData(array('state' => 2), "id=$id");
                $this->alert("生成成功！", 'js', 3, $_ENV['PHP_SELF'] . 'loanreplacelist');
            }
        }
    }

    //自动生成置换/贷款
    function doAutoLoanReplace() {
        global $_cache;
        $time = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $endtime = $time + 86400;

        //置换
        $replaceResult = $this->oldcarval->getOldcarvalModel('cm.model_id, cm.series_id, cm.factory_id, cm.model_name, cm.model_price, cm.model_pic1, co.car_prize', " and start_date<=$time and end_date>=$endtime");

        //贷款
        $this->model->fields = 'cm.model_id, cm.series_id, cm.factory_id, cm.model_name, cm.model_price, cm.model_pic1,  csl.name, csl.loan_peroid, csl.first_pay_rate';
        $seriesloanResult = $this->model->getSimpleModels("cm.series_id=csl.series_id and cm.hasloan=1 and cm.state in (3,8) and csl.start_date<=$time and csl.end_date>=$endtime", 1000, 0, array('cm.model_id' => 'asc'), array('cardb_model' => 'cm', 'cardb_series_loan' => 'csl'));
        #die($this->model->sql);
        $this->model->order = '';
        $this->model->limit = 1;
        $this->model->offset = 0;

        //$flag=1是置换,$flag=0是贷款
        $replaceArr = $this->getPricelog($replaceResult, 1);
        $seriesloanArr = $this->getPricelog($seriesloanResult);
        if (count($replaceArr) < 1 || count($seriesloanArr) < 1) {
            exit('数据不全！');
        }

        $replaceCacheTmp = $loanCacheTmp = array();
        $replaceCache = $_cache->getcache('replace_mid');
        $replaceCache = $cache1 = $replaceCache ? $replaceCache : array();
        $loanCache = $_cache->getcache('loan_mid');
        $loanCache = $cache2 = $loanCache ? $loanCache : array();
        while (list($key, $val) = each($replaceArr)) {
            if (in_array($val['model_id'], $cache1)) {
                array_push($replaceArr, $val);
                $t1 = array_keys($cache1, $val['model_id']);
                unset($cache1[$t1[0]], $replaceArr[$key]);
            }
        }
        while (list($key, $val) = each($seriesloanArr)) {
            if (in_array($val['model_id'], $cache2)) {
                array_push($seriesloanArr, $val);
                $t2 = array_keys($cache2, $val['model_id']);
                unset($cache2[$t2[0]], $seriesloanArr[$key]);
            }
        }
        $replaceArr = array_values($replaceArr);
        $seriesloanArr = array_values($seriesloanArr);

        for ($i = 0; $i < 10; $i++) {
            $startTime = date('Y-m-d', $time + (24 * 3600 * $i));
            $startTime1 = date('Y_m_d', $endtime + (24 * 3600 * $i));

            $result = $this->pageData->getSomePagedata('id, value', "name='loanreplace' and start_time='$startTime' and c1='index' and c2=1", 1);
            $this->pageDataSeries->delPagedataSeries("pd_name='loanreplace' and start_time='$startTime'");
            $value = array();
            for ($j = 0; $j < 4; $j++) {
                if ($replaceArr[$i * 4 + $j]) {
                    $this->insertPageDataSeries('loanreplace', $j, $startTime, $replaceArr[$i * 4 + $j]['series_id']);
                    $value[$j] = $replaceArr[$i * 4 + $j];
                    if ($i == 0) {
                        $replaceCacheTmp[] = $replaceArr[$i * 4 + $j]['model_id'];
                    }
                }
                if ($seriesloanArr[$i * 4 + $j]) {
                    $this->insertPageDataSeries('loanreplace', $j + 4, $startTime, $seriesloanArr[$i * 4 + $j]['series_id']);
                    $value[$j + 4] = $seriesloanArr[$i * 4 + $j];
                    if ($i == 0) {
                        $loanCacheTmp[] = $seriesloanArr[$i * 4 + $j]['model_id'];
                    }
                }
            }
            if ($value) {
                if ($result) {
                    $this->pageData->updatePageData(array('value' => serialize($value), 'updated' => time(), 'state' => 2), "id={$result['id']}");
                } else {
                    $this->pageData->insertPageData(array('name' => 'loanreplace', 'value' => serialize($value), 'c1' => 'index', 'c2' => 1, 'state' => 2, 'start_time' => $startTime, 'created' => time(), 'updated' => time()));
                }
                if (!empty($replaceArr[$i])) {
                    $this->vars('result', array($value[0], $value[1], $value[2], $value[3]));
                    $html = $this->fetch('ssi_newindex_replace');
                    $ret = file_put_contents(WWW_ROOT . "ssi/ssi_newindex_replace_$startTime1.shtml", $html);
                    $this->removeFile('replace');
                }
                if (!empty($seriesloanArr[$i])) {
                    $this->vars('result', array($value[4], $value[5], $value[6], $value[7]));
                    $html = $this->fetch('ssi_newindex_loan');
                    $ret = file_put_contents(WWW_ROOT . "ssi/ssi_newindex_loan_$startTime1.shtml", $html);
                    $this->removeFile('loan');
                }
            }
        }
        $replaceCache = array_merge($replaceCache, $replaceCacheTmp);
        $loanCache = array_merge($loanCache, $loanCacheTmp);
        if (count($replaceCache) >= count($replaceArr))
            $replaceCache = '';
        if (count($loanCache) >= count($seriesloanArr))
            $loanCache = '';
        $_cache->writecache('replace_mid', $replaceCache, 3600 * 30);
        $_cache->writecache('loan_mid', $loanCache, 3600 * 30);
        echo 1;
    }

    //$flag=1是置换,$flag=0是贷款
    function getPricelog($mInfo, $flag = 0) {
        if (empty($mInfo))
            return array();

        $times = time() - 90 * 24 * 3600;
        $sid = array();
        static $oldcarvalPricelog1 = array();
        static $oldcarvalPricelog2 = array();
        static $i = 0;
        $lid = '';
        if ($i > 5000) {
            $i = 0;
            $sid = array();
            if ($flag)
                return $oldcarvalPricelog1;
            else
                return $oldcarvalPricelog2;
        }
        foreach ($mInfo as $val) {
            if (in_array($val['series_id'], $sid)) {
                continue;
            }
            $i++;
            //暗访价id
            $pricelogInfo = $this->pricelog->getPriceByModelid("id, price", "model_id={$val['model_id']} and price_type=0", array('id' => 'desc'), 1, 1);
            if ($pricelogInfo) {
                $sInfo = $this->series->getSeriesdata('series_alias', "series_id={$val['series_id']} and state=3", 1);
                $fInfo = $this->factory->getFactorylist('factory_alias', "factory_id={$val['factory_id']} and state=3", 1);
                $bingoPrice = floatval($pricelogInfo['price']);
                $modelPrice = floatval($val['model_price']);
                $sid[] = $val['series_id'];
                $tmp2 = array(
                    'series_id' => $val['series_id'],
                    'factory_id' => $val['factory_id'],
                    'bingo_price' => $bingoPrice,
                    'pricelog_id' => $pricelogInfo['id'],
                    'model_id' => $val['model_id'],
                    'model_name' => $val['model_name'],
                    'model_price' => $modelPrice,
                    'model_pic1' => $val['model_pic1'],
                    'markdown' => floatval($modelPrice - $bingoPrice),
                    'series_alias' => $sInfo['series_alias'],
                    'factory_alias' => $fInfo['factory_alias']
                );
                if ($flag) {
                    $tmp1 = array(
                        'car_prize' => $val['car_prize'],
                        'price' => floatval(($bingoPrice * 10000 - $val['car_prize']) / 10000)
                    );
                    $oldcarvalPricelog1[] = $tmp1 + $tmp2;
                    $length = count($oldcarvalPricelog1);
                    if ($length > 39) {
                        $i = 0;
                        $sid = array();
                        return $oldcarvalPricelog1;
                    }
                } else {
                    $tmp1 = array(
                        'rate' => $val['name'],
                        'low_year' => $val['loan_peroid'],
                        'down_payment' => $val['first_pay_rate'],
                    );
                    $oldcarvalPricelog2[] = $tmp1 + $tmp2;
                    $length = count($oldcarvalPricelog2);
                    if ($length > 39) {
                        $i = 0;
                        $sid = array();
                        return $oldcarvalPricelog2;
                    }
                }
            }
        }
        return $this->getPricelog($mInfo, $flag);
    }

    /*
     * 向page_data_series表添加信息
     * @param string $name page_date表的name
     * @param int $pos 在数组中的键值
     * @param date $time 时间 xxxx-xx-xx
     * @param int $seriesId seriesid
     */

    function insertPageDataSeries($name, $pos, $time, $seriesId) {
        var_dump($seriesId);
        $pageDataSeriesFlag = $this->pageDataSeries->getSeries('id', "series_id={$seriesId} and pos={$pos} and pd_name='{$name}' and start_time='{$time}'", 3);
        var_dump($pageDataSeriesFlag);
        if ($pageDataSeriesFlag) {
            $res = $this->pageDataSeries->updateSeries(array('series_id' => $seriesId), "id=$pageDataSeriesFlag");
        } else {
            $res = $this->pageDataSeries->insertSeries(array('pd_name' => $name, 'series_id' => $seriesId, 'pos' => $pos, 'start_time' => $time));
        }
//        return $res;
//        echo $res;exit;
    }

    function removeFile($pdName) {
        $timestamp = time();
        //删除两天前的生成文件
        $rmAlias = date('_Y_m_d', $timestamp - 3600 * 48);
        $rmdFileName = WWW_ROOT . 'ssi/ssi_newindex_' . $pdName . $rmAlias . '.shtml';
        if (file_exists($rmdFileName))
            unlink($rmdFileName);
    }

    function checkAuth($id, $type_value = "A", $rtype = 1) {
        global $login_uid, $adminauth;
        $adminauth->rtype = $rtype;
        $ret = $adminauth->checkAuth($login_uid, 'sys_module', $id, $type_value);
        return $ret;
    }

}

?>
