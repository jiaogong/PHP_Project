<?php

/*
 * 采集易车商城数据
 * 
 * @author David Shaw <tudibao@163.com>
 * $Id: grabyichemall.php 1792 2016-03-28 01:59:03Z wangchangjiang $
 */

set_time_limit(0);
import('webclient.class', 'lib');

class grabyichemall extends model {

    var $wc;
    var $yiche_auto;
    var $model;
    var $factory;
    var $model_list = array();
    var $totalpage = 1;
    var $cookie_file;
    var $retry_times = 0;
    var $logFile;
    var $grab_result = array();
    private $verbose = false;
    private $eof = "<br>\n";
    private $start_page = "http://www.yichemall.com/car/list?&pricebegin=2&priceend=2000";
    
    function __construct() {
        parent::__construct();
        $this->wc = new webClient();
        $this->wc->setRedirect(FALSE);
        $this->factory = new factory();
        $this->model = new cardbModel();
        
        $this->table_name = "yiche_price";
        $this->logFile = SITE_ROOT . "errorlog.txt";
        $this->wc->cookieFile = SITE_ROOT . "yiche_price.txt";
        $this->grab_result['error'] = 0;
        $this->grab_result['start_time'] = $this->timestamp;
        $this->grab_result['insert'] = $this->grab_result['update'] = 0;
    }

    function getPageList($page_num = '') {
        $p = $page_num ? $page_num : 1;
        $page_url = $this->start_page . "&p=" . $p;
        $this->wc->setUrl($page_url);
        $this->wc->setUserAgent($this->wc->useragent);
        $this->wc->setReferer($page_url);
        $this->wc->getContent();
        $page_data = $this->wc->result;
        
        $this->printMessage("开始采集数据:" . $this->start_page);
        $this->printMessage($this->eof . "<hr>第[{$p}]页:" . $page_url);

        #解析第二页开始的数据
        if ($p == 1) {
            $this->totalpage = intval($this->getPageCount($page_data));
            if(!$this->totalpage){
                $this->printMessage("没有分析到数据哦， -_-||");
                exit;
            }else{
                $this->grab_result['total_page'] = $this->totalpage;
                $this->printMessage("数据总页数:" . $this->totalpage);
            }
        }
        $goods_url = "http://www.yichemall.com/car/detail/";
        preg_match_all('%"/car/detail/(\d+)" target="_blank" class="dis_in_block mt10"%sm', $page_data, $match);
        if ($match[1]) {
            #var_dump($match[1]);
            foreach ($match[1] as $series_id) {
                $detail_url = $goods_url . $series_id;
                $this->anazyGoodsPage($detail_url);
                $this->otherModelData($series_id);
                #exit;
            }
        }
        #return true;
        if ($this->totalpage > 1 && !$page_num) {
            for ($i = 2; $i <= $this->totalpage; $i++) {
                $page_url = $this->start_page . "&p={$i}";
                $this->printMessage($this->eof . "<hr>第[{$i}]页:" . $page_url);
                $this->wc->setUrl($page_url);
                $this->wc->setUserAgent($this->wc->useragent);
                $this->wc->setReferer($page_url);
                $this->wc->getContent();
                $page_data = $this->wc->result;

                preg_match_all('%"/car/detail/(\d+)" target="_blank" class="dis_in_block mt10"%sm', $page_data, $match);
                if ($match[1]) {
                    foreach ($match[1] as $key => $series_id) {
                        $detail_url = $goods_url . $series_id;
                        $this->anazyGoodsPage($detail_url);
                        $this->otherModelData($series_id);
                    }
                }
                #sleep(2);
            }
        }
    }

    function getPageCount($page_data) {
        preg_match('/value="(\d+)" id="hidTotelCount"/sm', $page_data, $match);
        $totalcount = intval($match[1]);
        preg_match('/value="(\d+)" id="hidpageSize"/sm', $page_data, $match);
        $pagesize = intval($match[1]);
        return @ceil($totalcount / $pagesize);
    }

    function anazyGoodsPage($url, $retry = false, $modelid = '') {
        $brand_name = $factory_name = $series_name = $model_name = $modelprice = $mallprice = '';
        $orderprice = $province = $city = $num = $yc_memo1 = $saleinfo = '';
        $stats = 1;
        
        preg_match('/c_(\d+)_/sm', $url, $match);
        if($match[1] && !$modelid){
            $modelid = $match[1];
        }
                
        $this->wc->setUrl($url);
        $this->wc->setUserAgent($this->wc->useragent);
        $this->wc->setReferer($url);
        $this->wc->getContent();
        $this->wc->result = mb_convert_encoding($this->wc->result, "gbk", 'utf-8');
        #$this->wc->result = iconv('utf-8', 'gbk', $this->wc->result);
        #厂商及车系
        preg_match('/h2 title="(\S+)\s&nbsp;\s([^"]+)">/sm', $this->wc->result, $match);
        $factory_name = $match[1];
        $series_name = $match[2];
        
        #易车车系ID
        preg_match('/"ModelId"[^\d]+(\d+)/sm', $this->wc->result, $match);
        $series_id = $match[1];
        #车款名称
        preg_match('/<h3><a id="carTab">([^<]+)\s+</sm', $this->wc->result, $match);
        $model_name = $match[1];
        
        /**
         * 判断是否分析到车款名称及车系名称,如果没有可能数据采集失败，重试
         */
        $message = ($retry ? "[失败，重试……]:" : "分析车款页:") . "<a href='{$url}' target='_blank'>{$factory_name} {$series_name} {$model_name}</a>";;
        $this->printMessage($message);
        
        #如果解析内容失败，再重试 5 次
        if (empty($factory_name)) {
            #$this->verbose && print("retry:{$url}\n");
            ++$this->retry_times;
            if ($this->retry_times < 5) {
                return $this->anazyGoodsPage($url, true, $modelid);
            } else {
                ++$this->grab_result['error'];
                error_log("error_url:{$url}\n", 3, $this->logFile);
            }
        }
        $this->retry_times = 0;
        
        #商城价
        preg_match('/"MallPrice">\s+([\d.]+)万元/sm', $this->wc->result, $match);
        $mallprice = $match[1];
        #指导价
        preg_match('/"FactoryPrice">([\d.]+)万/sm', $this->wc->result, $match);
        $modelprice = $match[1];
        #大促价
        preg_match('/大促价.*?([\d.]+)万元/sm', $this->wc->result, $match);
        $mallprice2 = $match[1];
        #需要支付金额
        preg_match('/需支付金额.*?([\d.]+)元/sm', $this->wc->result, $match);
        $orderprice = $match[1];

        #销售省
        preg_match('/"currentProvince">\s+(\S+)/sm', $this->wc->result, $match);
        $province = $match[1];
        #销售城市
        preg_match('/"currentCity">\s+(\S+)/sm', $this->wc->result, $match);
        $city = $match[1];
        #数量
        preg_match('/"StockNumber">([^<]+)/sm', $this->wc->result, $match);
        $num = $match[1];
        #促销信息
        preg_match('/"subtitle">([^<]+)/sm', $this->wc->result, $match);
        $saleinfo = strval($match[1]);
        #订金
        preg_match('/"DepositTab" class="font_30">([\d.]+)/sm', $this->wc->result, $match);
        $orderprice = $match[1];
        #购买方式
        preg_match('/class="button_orange[^>]+>\s+<a[^>]+>([^<]+)/sm', $this->wc->result, $match);
        $yc_memo1 = $match[1];
        $this->wc->result = $match = null;

        if ($yc_memo1 == '已售罄') {
            $stats = 0;
        }

        $factory = $this->factory->getFactoryByName($factory_name);
        $brand_name = $factory['brand_name'];
        #$factory_name = iconv('gbk','utf-8',$factory_name);
        $this->ufields = array(
            'yc_modelname' => $model_name,
            'yc_seriesname' => $series_name,
            'yc_factoryname' => $factory_name,
            'yc_brandname' => $factory['brand_name'],
            'yc_modelprice' => $modelprice,
            'yc_mallprice' => $mallprice,
            'yc_orderprice' => $orderprice,
            'yc_saleprovince' => $province,
            'yc_salecity' => $city,
            'yc_num' => $num,
            'yc_saleinfo' => $saleinfo,
            'yc_memo1' => $yc_memo1, /* 购车方式，按钮中的文字 */
            'created' => $this->timestamp,
            'yc_mallprice2' => $mallprice2,
            'sale_stats' => $stats,
        );

        $this->where = "yc_modelname='{$model_name}' and yc_seriesname='{$series_name}'";
        $this->fields = "id,yc_mallprice,yc_mallprice2,old_price1,old_price2,old_price3,sale_time1,sale_time2,sale_time3,created";
        $yc_model = $this->getResult();
        
        #取车款列表
        if ($series_id && !$this->model_list[$series_id]) {
            $this->model_list[$series_id] = $this->getModelUrlList($series_id, $model_name);
            $this->ufields['yc_mid'] = $this->model_list[$series_id][0]['model_id'];
        } else {
            $this->ufields['yc_mid'] = $modelid;
            #$this->printMessage("[同一车系车款]");
        }
        
        if (!$yc_model['id']) {
            $this->insert();
            ++$this->grab_result['insert'];
            $str = "add new";
        } else {
            #如果历史价格中不存在同样价格，更新历史价格
            if ($mallprice != $yc_model['old_price1'] && $mallprice2 != $yc_model['old_price1'] &&
                    $mallprice != $yc_model['old_price2'] && $mallprice2 != $yc_model['old_price2'] &&
                    $mallprice != $yc_model['old_price3'] && $mallprice2 != $yc_model['old_price3'] &&
                    ($yc_model['yc_mallprice'] > 0 || $yc_model['yc_mallprice2'] > 0)) {
                if (!$yc_model['old_price1'] && !$yc_model['old_price2'] && !$yc_model['old_price3']) {
                    $this->ufields['old_price1'] = $yc_model['yc_mallprice2'] ? $yc_model['yc_mallprice2'] : $yc_model['yc_mallprice'];
                    $this->ufields['sale_time1'] = $yc_model['created'];
                } elseif (!$yc_model['old_price2'] && !$yc_model['old_price3']) {
                    $this->ufields['old_price2'] = $yc_model['yc_mallprice2'] ? $yc_model['yc_mallprice2'] : $yc_model['yc_mallprice'];
                    $this->ufields['sale_time2'] = $yc_model['created'];
                } elseif (!$yc_model['old_price3']) {
                    $this->ufields['old_price3'] = $yc_model['yc_mallprice2'] ? $yc_model['yc_mallprice2'] : $yc_model['yc_mallprice'];
                    $this->ufields['sale_time3'] = $yc_model['created'];
                } else {
                    if ($yc_model['sale_time1'] <= $yc_model['sale_time2'] && $yc_model['sale_time1'] <= $yc_model['sale_time3']) {
                        $this->ufields['old_price1'] = $yc_model['yc_mallprice2'] ? $yc_model['yc_mallprice2'] : $yc_model['yc_mallprice'];
                        $this->ufields['sale_time1'] = $yc_model['created'];
                    } elseif ($yc_model['sale_time2'] <= $yc_model['sale_time1'] && $yc_model['sale_time2'] <= $yc_model['sale_time3']) {
                        $this->ufields['old_price2'] = $yc_model['yc_mallprice2'] ? $yc_model['yc_mallprice2'] : $yc_model['yc_mallprice'];
                        $this->ufields['sale_time2'] = $yc_model['created'];
                    } else {
                        $this->ufields['old_price3'] = $yc_model['yc_mallprice2'] ? $yc_model['yc_mallprice2'] : $yc_model['yc_mallprice'];
                        $this->ufields['sale_time3'] = $yc_model['created'];
                    }
                }
            }
            $this->where = "id='{$yc_model['id']}'";
            $this->update();
            ++$this->grab_result['update'];
            $str = "update";
        }
        $message = $str == 'update' ? "车款已存在，更新" : "新车款数据入库";
        $this->printMessage("[结果]:{$message}");
        
        $str .= ":" . $this->sql;
        error_log($str . $this->errorMsg(), 3, $this->logFile);
        
        $this->grab_result['end_time'] = time();
        #$model_list = $this->getModelUrlList($series_id, $model_name);
    }

    function otherModelData($series_id) {
        if ($series_id && count($this->model_list[$series_id]) > 1) {
            $model_list = $this->model_list[$series_id];
            #var_dump($model_list);
            $this->printMessage("开始分析其它车款数据……");
            foreach ($model_list as $key => $value) {
                #忽略第一条记录，因为首先采集的数据为第一条
                if (!$key) {
                    continue;
                }
                $this->anazyGoodsPage($value['url'], $value['model_id']);
            }
        } else {
            return '';
        }
    }

    function getModelUrlList($modelId, $productName) {
        $url = "http://www.yichemall.com/SingleProduct/GetProductList";
        $referer = "http://www.yichemall.com/car/detail/{$modelId}";
        $this->wc->setUrl($url);
        $this->wc->setUserAgent($referer);
        $this->wc->setReferer($url);
        $this->wc->setPostVars(array(
            'modelId' => $modelId,
            'productName' => iconv('gbk', 'utf-8', $productName),
        ));
        $this->wc->getContent();
        $retval = json_decode($this->wc->result, true);
        $productlist = array();
        foreach ($retval['Product'] as $key => $value) {
            $value['CarName'] = trim($value['CarName']);
            $value['CarId'] = trim($value['CarId']);
            $productlist[] = array(
                'model_id' => $value['CarId'],
                'model_name' => iconv('utf-8', 'gbk', $value['CarName']),
                'url' => "http://www.yichemall.com/car/detail/c_" . $value['CarId'] . "_" . str_replace(array('+'), array('%20'), urlencode($value['CarName'])),
            );
        }
        #exit;
        if (!empty($retval)) {
            return $productlist;
        } else {
            return false;
        }
    }

    function setVerbose($verbose = true) {
        $this->verbose = $verbose;
    }
    
    function setEof($eof = "\n"){
        $this->eof = $eof;
    }
    
    /**
     * 输入信息，verbose必须为true
     * @param string $message
     */
    function printMessage($message = ''){
        $this->verbose && print($message . $this->eof);
    }
    
    function  setStartPage($url){
        $this->start_page = preg_replace('/&p=\d/sim', '', $url);
    }
    
    /**
     * 根据易车的车辆信息，匹配冰狗车辆信息
     * 并更新易车车辆信息表
     */
    function updateBingoData(){
        
    }
}
