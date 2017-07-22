<?php

/**
 * $Id: offersaction.php 6173 2015-01-30 05:55:48Z wangmeijun $
 */
class offersAction extends action {

    public function __construct() {
        parent::__construct();
        $this->models = new models();
        $this->pricelog = new priceLog();
        $this->article = new article();
        $this->oldcarval = new oldCarVal();
        $this->soapmsg = new soapmsg();
        $this->dealerInfo = new dealerinfo();
        $this->price = new price();
        $this->realdata = new realdata();
        $this->websaleinfo = new Websaleinfo();
        $this->seriesloan = new seriesLoan();
        $this->goods = new Goods();
        $this->vars('garage', 'garage');
    }

    function doDefault() {
        $this->doIndex();
    }

    function doMap() {
        $act = $_GET['act'];
        switch ($act) {
            case 'getcontent':
                $url = "http://map.autohome.com.cn/DealersData.aspx?value={$_GET['value']}&fid={$_GET['fid']}&bid={$_GET['bid']}&CityID={$_GET['CityID']}&type={$_GET['type']}&date={$_GET['date']}&index={$_GET['index']}";
                $content = file_get_contents($url);
                $contentArr = explode('*', $content);
                $rightContent = $contentArr[1];
                preg_match_all("%dtli_zh'.+?OpenWinIconRed\(([^']+)'%sim", $content, $matches);
                $replace = array();
                foreach ($matches[1] as $k => $v) {
                    $matches[1][$k] = "%$v.+?;%sim";
                    $replace[$k] = '';
                }
                $rightContent = preg_replace($matches[1], $replace, $rightContent);
                $contentArr[1] = $rightContent;
                $content = implode('*', $contentArr);
                $content = preg_replace("%<div\s*class='dtli_zh.+?</div>%sim", '', $content);
                $content = str_replace("class='gray", "style='display:none;' class='gray", $content);
                echo $content;
                break;
            case 'chgpage':
                $url = "http://map.autohome.com.cn/Handler/DealerKind.ashx?R={$_GET['R']}&value={$_GET['value']}&CityID={$_GET['CityID']}&kindId=1";
                $url .= "&type=1&pageCurrent={$_GET['pageCurrent']}";
                $content = file_get_contents($url);
                $content = str_replace("marginr5'", 'marginr5\' style="display:none;"', $content);
                echo $content;
                break;
            case 'automap': #地图主页面
                require_once '../lib/webclient.class.php';
                $keyword = $_GET['keyword'] ? urlencode($_GET['keyword']) : '';
                if ($keyword)
                    $url = "http://map.autohome.com.cn/beijing/?keyword=$keyword&page=1";
                else
                    $url = 'http://map.autohome.com.cn/beijing';
                $webclient = new webClient();
                $webclient->setUrl($url);
                $webclient->setReferer("http://map.autohome.com.cn/beijing/");
                $webclient->getContent();
                $webclient->result = str_replace(
                        array(
                    "/map.aspx?",
                    'src="/js/',
                    'http://map.autohome.com.cn/js/mapeffect.js',
                    '/css/mapstyle.css',
                    "/Images/an",
                    "/Images/n",
                    '"/Images/',
                    '/Handler/DealerKind.ashx?',
                    'http://img.autohome.com.cn/count.js"></script>',
                    '/DealersData.aspx',
                    '汽车之家',
                    '<span class="fr">',
                    'location.search = "keyword="',
                    'currentfidbid = msg[2]',
                    'lastfidbid = msg[2]',
                    "marginr5'",
                    "class='gray",
                    "con01t'",
                        ), array(
                    "/offers.php?action=map&act=mapjs1&",
                    'src="http://map.autohome.com.cn/js/',
                    "/offers.php?action=map&act=mapjs2",
                    "http://map.autohome.com.cn/css/mapstyle.css",
                    "http://map.autohome.com.cn/Images/an",
                    "http://map.autohome.com.cn/Images/n",
                    '"http://map.autohome.com.cn/Images/',
                    '/offers.php?action=map&act=chgpage&',
                    '/offers.php?action=map&act=countjs"></script><script>searchClick(1,1);</script>',
                    '/offers.php?action=map&act=getcontent',
                    'ams车评网',
                    '<span class="fr" style="display:none;">',
                    'location.href = "offers.php?action=map&act=automap&keyword="',
                    'currentfidbid = msg[2].replace(/(^\s*)|(\s*$)/g,"")',
                    'lastfidbid = msg[2].replace(/(^\s*)|(\s*$)/g,"")',
                    'marginr5\' style="display:none;"',
                    "style='display:none;' class='gray",
                    "con01t' style='display:none;'",
                        ), $webclient->result
                );

                $webclient->result = preg_replace('/<div class="topright"[^>]*>/si', '<div class="topright" style="display:none;">', $webclient->result);
                $webclient->result = preg_replace('%<div class="logo".+?<div class="topright%sim', '<a href="http://www.bingocar.cn" target="_blank"><div class="logo" style="background-image:url(/images/logo.jpg)"></div></a><div class="topright', $webclient->result);
                //$webclient->result = str_replace('<script language="javacript" type="text/javascript" src="http://img.autohome.com.cn/count.js"></script>', '', $webclient->result);
                //$webclient->result = preg_replace('/<a class="xxjs" [^>]+>详细介绍</a>/si', '', $webclient->result);
                //$webclient->result = preg_replace('/<div id="sidebar"[^>]*>/si', '<div id="sidebar" style="display:none;">', $webclient->result);
                //$webclient->result = preg_replace('/<div id="togglebar"[^>]*>/si', '<div id="togglebar" style="display:none;">', $webclient->result);        
                //$webclient->result = preg_replace('/<div id="mainContent">(.+?)<div id="content"/si', '<div id="mainContent"><div id="content"', $webclient->result);
                //$webclient->result = preg_replace('/<div id="content"[^>]*>/si', '<div id="content" style="margin-left:0;">', $webclient->result);
                echo $webclient->result;
                break;
            case 'countjs':
                require_once '../lib/webclient.class.php';
                $url = 'http://img.autohome.com.cn/count.js';
                $webclient = new webClient();
                $webclient->setUrl($url);
                $webclient->getContent();
                echo $webclient->result;
                break;
            case 'mapjs2': #地图效果js
                require_once '../lib/webclient.class.php';
                $url = "http://map.autohome.com.cn/js/mapeffect.js";
                $webclient = new webClient();
                $webclient->setUrl($url);
                $webclient->setReferer("http://map.autohome.com.cn/beijing/");
                $webclient->getContent();
                #/Images/an1.png
                $webclient->result = str_replace(
                        array(
                    "/Images/an",
                    "/Images/n",
                    '"/Images/',
                    '/Handler/AssociationalWord.ashx'
                        ), array(
                    "http://map.autohome.com.cn/Images/an",
                    "http://map.autohome.com.cn/Images/n",
                    '"http://map.autohome.com.cn/Images/',
                    'http://map.autohome.com.cn/Handler/AssociationalWord.ashx'
                        ), $webclient->result
                );
                echo $webclient->result;
                break;
            case 'mapjs1': #替换map.aspx相关
                require_once '../lib/webclient.class.php';
                $webclient = new webClient();
                $url = "http://map.autohome.com.cn/map.aspx?cityName=北京市";
                $webclient = new webClient();
                $webclient->setUrl($url);
                $webclient->setReferer("http://map.autohome.com.cn/beijing/");
                $webclient->getContent();
                $webclient->result = str_replace(
                        array(
                    "/Images/an",
                    "/Images/n",
                    '"/Images/',
                    '/Handler/CustomIw.ashx?',
                    'url(images/'
                        ), array(
                    "http://map.autohome.com.cn/Images/an",
                    "http://map.autohome.com.cn/Images/n",
                    '"http://map.autohome.com.cn/Images/',
                    '/offers.php?action=map&act=mapdealerinfo&',
                    'url(http://map.autohome.com.cn/images/'
                        ), $webclient->result
                );
                echo $webclient->result;
                break;
            case 'mapdealerinfo': #显示地图图片信息utf-8编码
                $url = "http://map.autohome.com.cn/Handler/CustomIw.ashx?dealerId={$_GET['dealerId']}&cityName={$_GET['cityName']}&address={$_GET['address']}&keyword={$_GET['keyword']}";
                //$map_info = "<div class='layer1'><div class='yayer_con'><div class='conpadding'><h2><a style='cursor: pointer;' href='http://dealer.autohome.com.cn/dealer/121/' target='_blank' class='cmname' title='bingocar北京燕宝汽车销售有限公司'><span class='icon_4s'>bingocar北京燕宝汽车销售有限公司...</span></a><a href='http://dealer.autohome.com.cn/dealer/121/' target='_blank' class='xxjs'>详细介绍</a></h2><dl class='dl_1'><dt>品牌：</dt><dd><nobr><span>宝马</span></nobr></dd><dd class='cleardd'></dd><dt>车系：</dt><dd><nobr><span>宝马1系</span><span>宝马1系M</span><span>宝马3系</span><span>宝马3系(进口)</span><span>...</span></nobr></dd></dl><dl class='dl_1'><dt>地址：</dt><dd title='亦庄4S店，燕莎展厅'>亦庄4S店，燕莎展厅</dd><dd class='cleardd'></dd><dt>电话：</dt><dd>4006805588，67821666</dd></dl><div class='ly2dz'><span>交通路线：<a target='_blank' href=http://www.mapbar.com/search/#ac=bus&st=b&qbus=1&mc=北京市&on=&dn=北京燕宝汽车销售有限公司&wf=bs >到这里去</a>&nbsp;&nbsp;<a target='_blank' href=http://www.mapbar.com/search/#ac=bus&st=b&qbus=1&mc=北京市&on=北京燕宝汽车销售有限公司&dn=&wf=bs>从这里出发</a></span><br/><span title='2013开新杆，精彩一刻在燕宝'>最新行情：<a target='_blank' href=http://dealer.autohome.com.cn/dealer/121/news_4615944.html>2013开新杆，精彩一刻在燕宝</a></span></div></div></div><div class='layer1_zhi'></div><div class='layer_close' onclick='hideCustomIw();'></div><div class='layer_Shadow1'></div><div class='layer_Shadow2'></div></div>";
                $mapInfo = file_get_contents($url);
                $mapInfo = str_replace("class='xxjs'", 'class=\'xxjs\' style="display:none;"', $mapInfo);
                $mapInfo = str_replace('>最新行情：', 'style="display:none;">最新行情：', $mapInfo);
                $mapInfo = preg_replace("%http://dealer.autohome.com.cn/dealer/\d+/'\s*target='_blank'%sim", 'javascript:void(0);', $mapInfo);
                preg_match("%cmname'\s*title='([^']+)%sim", $mapInfo, $matches);
                $mapInfo = preg_replace("%<a.+?cmname'\s*title='[^']+'>(<span class='[^']+'>[^<]+</span>)</a>%sim", '$1', $mapInfo);
                $dealerName = $matches[1];
                if ($dealerName) {
                    $dealer = $this->dealerInfo->getOneDealer('dealer_tel', "dealer_name = '$dealerName'");
                    $tel = $dealer['dealer_tel'];
                    $mapInfo = preg_replace('%电话：</dt>\s*<dd>[^<]+</dd>%sim', "电话：</dt><dd>$tel</dd>", $mapInfo);
                }
                echo $mapInfo;
                break;
        }
    }

    function doCorrection() {
        $tpl_name = 'offers_correction';
        $id = $_GET['id'];
        $fields = '*';
        $where = "id = $id";
        $getType = 1;
        $pricelog = $this->pricelog->getPriceLog($fields, $where, $getType);
        $modelId = $pricelog['model_id'];
        $modelInfo = $this->models->getOneModel('factory_name, series_name, model_name', $modelId);

        $this->vars('css', array('base', 'price_error', 'jquery.ui.theme', 'jquery.ui.datepicker', 'common'));
        $this->vars('js', array('jquery-1.8.3.min', 'global', 'jquery.ui.datepicker', 'jquery.ui.datepicker-zh-CN'));
        $this->vars('model_info', $modelInfo);
        $this->vars('pricelog', $pricelog);
        $this->template($tpl_name, '', 'replaceNewsChannel');
    }

    function doSendAddress() {
        $tel = $_POST['mobile'];
        $content = $_POST['content'];
        $postCode = strtolower($_POST['code']);
        $code = strtolower(session('bingo_code'));
        //验证码错误
        if ($postCode != $code)
            echo 3;
        else {
            $ret = $this->soapmsg->postMsg($tel, $content);
            //短信发送成
            if ($ret == 2)
                echo 1;
            //发送失败
            else
                echo 2;
        }
    }

    function doIndex() {
        $templateName = 'offers';
        $modelId = intval($_GET['model_id']) ? intval($_GET['model_id']) : 1;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $active = intval($_GET['active']) ? intval($_GET['active']) : 0;
        $posid = intval($_GET['posid']);
        $timestamp = time();
        #双11价格
        $websaleinfo = $this->websaleinfo->getNov11($modelId);
        $websaleinfoCount = count($websaleinfo);
        $competeModel = array();
        $lastTimestamp = $timestamp - 3600 * 24 * 90;
        $fields = 'brand_id, series_id, model_id, compete_id,date_id,st27,st28,st41,st48, brand_name, model_name, factory_name, series_name, model_pic1, model_pic2,hasloan, IF(dealer_price_low > 0, dealer_price_low, bingo_price) as bingobang_price, model_price';
        $modelInfo = $this->models->getOneModel($fields, $modelId);
        $modelInfo['model_price'] = floatval($modelInfo['model_price']);
        $priceType = $this->price->getPriceAndModelA(5, " and cp.model_id=$modelId", 'cp.pricelog_id_from,cp.price');
        $modelInfo['price'] = $priceType[0]['price'];
        if ($priceType[0]['pricelog_id_from'] == '1') {
            $modelInfo['price_type'] = 0;
        } elseif ($priceType[0]['pricelog_id_from'] == '2') {
            $modelInfo['price_type'] = 5;
        } elseif ($priceType[0]['pricelog_id_from'] == '3') {
            $modelInfo['price_type'] = 6;
        }
        if ($modelInfo['compete_id']) {
            $this->models->fields = 'model_id, model_price, factory_name, series_name, model_name, dealer_price_low, model_pic2, model_pic1';
            $this->models->where = "model_id in ({$modelInfo['compete_id']}) and state in (3,8)";
            $this->models->limit = 2;
            $competeModel = $this->models->getResult(2);
            if ($competeModel) {
                foreach ($competeModel as $cmk => $cmv) {
                    if ($cmv['dealer_price_low'] > 0) {
                        $priceType = $this->price->getPriceAndModelA(5, " and cp.model_id={$cmv['model_id']}", 'cp.pricelog_id_from,cp.price_from,cp.price');
                        $competeModel[$cmk]['price'] = $priceType[0]['price'];
//                        if ($priceType[0]['pricelog_id_from'] == '1') {
//                            $competeModel[$cmk]['price_type'] = 0;
//                        } elseif ($priceType[0]['pricelog_id_from'] == '2') {
                        $competeModel[$cmk]['price_type'] = 5;
//                        } elseif ($priceType[0]['pricelog_id_from'] == '3') {
//                            $competeModel[$cmk]['price_type'] = 6;
//                            $competeModel[$cmk]['price_from'] = $priceType[0]['price_from'];
//                        }
                    }

                    $competeModel[$cmk]['dealer_price_low'] = floatval($competeModel[$cmk]['dealer_price_low']);
                    $competeModel[$cmk]['model_price'] = floatval($competeModel[$cmk]['model_price']);
                    //获取ibuycar价格
                    $goods_price = $this->goods->getList("goods_price", "model_id =$cmv[model_id] and goods_price>0", 3);
                    if ($goods_price) {
                        $competeModel[$cmk]['dealer_price_low'] = $goods_price;
                        $competeModel[$cmk]['goodsprice'] = 1;
                    }
                }
            }
        }


        //零利率
        $rates = $this->pricelog->getPriceLogList("rate", "model_id=$modelId and rate='有' and get_time>$lastTimestamp and get_time<$timestamp and price_type in(0,5)", 3);
        //补贴内容
        //节能惠民补贴
        if ($modelInfo[series_id]) {
            $where = "series_id = $modelInfo[series_id] AND date_id = $modelInfo[date_id] AND st27 = '$modelInfo[st27]' AND st28='$modelInfo[st28]' AND st41 = '$modelInfo[st41]' AND st48='$modelInfo[st48]'";
            $fields = 'new_energy,purcharse_tax,conservate';
            $resultbt = $this->realdata->getConservate($fields, $where);
            //贷款方案
            $loanArr = $this->seriesloan->getLoanList("*", "series_id=$modelInfo[series_id] and end_date>$timestamp", 1);
        }
        //老旧机动车企业奖励
        $oldcarprice = $this->oldcarval->getOldCarList("*", "model_id=$modelId  and end_date>$timestamp", 1);
        //获取ibuycar价格
        $goods_price = $this->goods->getList("goods_price", "model_id =$modelId and goods_price>0", 3);
        if ($goods_price) {
            $modelInfo['bingobang_price'] = $goods_price;
            $modelInfo['goodsprice'] = 1;
        }
        $seriesName = $modelInfo['series_name'];
        $modelPrice = $modelInfo['bingobang_price'] > 0 ? $modelInfo['bingobang_price'] : $modelInfo['model_price'];

        $modelInfo['delivery_price'] = getDeliveryPrice($modelInfo['bingobang_price']);
        if ($modelInfo['bingobang_price'] > 0) {
            $modelInfo['bingobang_price'] = floatval($modelInfo['bingobang_price']);
            $diff = $modelInfo['model_price'] - $modelInfo['bingobang_price'];
            if ($diff < 1 && $diff > 0) {
                $modelInfo['privilege'] = $diff * 10000 . '元';
            } elseif ($diff >= 1) {
                $modelInfo['privilege'] = $diff . '万';
            }
            if ($diff > 0) {
                $modelInfo[wx_price1] = '优惠' . $diff . '万，值不值？求鉴定！';
                $modelInfo[wx_price2] = '现在只卖' . $modelInfo['bingobang_price'] . '万（优惠' . $diff . '万），求鉴定！帮看看是否值得购买？';
            } elseif ($diff < 0) {
                $modelInfo[wx_price1] = '加价' . abs($diff) . '万，值不值？求鉴定！';
                $modelInfo[wx_price2] = '现在只卖' . $modelInfo['bingobang_price'] . '万（加价' . abs($diff) . '万），求鉴定！帮看看是否值得购买？';
            } else {
                $modelInfo[wx_price1] = '不优惠也不加价，值不值？求鉴定！';
                $modelInfo[wx_price2] = '现在只卖' . $modelInfo['bingobang_price'] . '万（不优惠也不加价），求鉴定！帮看看是否值得购买？';
            }
        } else {
            $modelInfo[wx_price1] = '这个价格值不值？求鉴定！';
            $modelInfo[wx_price2] = '这个价格值不值？求鉴定！是否值得购买？';
        }

        $offers = $this->price->getPrice(2, "cp.dealer_id=di.dealer_id and cp.price_type=5 and cp.model_id='$modelId' GROUP BY cp.dealer_id ORDER BY cp.price ASC", 'cp.id,di.dealer_pic,di.dealer_pic_alt,cp.dealer_name,cp.dealer_addr,cp.price_type,cp.price,cp.get_time,cp.4s_replacement_price,cp.service_level,cp.profess_level,cp.lowprice_level,cp.saler,cp.saler_tel,cp.report_title1,cp.report_title2,cp.report_title3'); //
        if ($offers) {
            foreach ($offers as $key => $value) {
                if ($value['price'] > 0) {
                    $diff = $modelInfo['model_price'] - $value['price'];
                    if ($diff < 1 && $diff > 0) {
                        $offers[$key]['privilege_hui'] = $diff * 10000 . '元';
                    } elseif ($diff >= 1) {
                        $offers[$key]['privilege_hui'] = $diff . '万';
                    }
                }
                if ($resultbt[0][conservate]) {
                    $offers[$key]['huiming'] = $resultbt[0][conservate];
                    $price_yh = str_replace("元", '', $resultbt[0][conservate]);
                    $offers[$key][totil_price] = $value['4s_replacement_price'] * 10000 + $oldcarprice['car_prize'] + $price_yh;
                } else {
                    $offers[$key][totil_price] = $value['4s_replacement_price'] * 10000 + $oldcarprice['car_prize'];
                }
                if ($value['nude_car_rate'] > 0) {
                    //裸车价
                    $offers[$key]['nude_car_rate_1'] = $modelInfo['model_price'] - $value['nude_car_rate'];
                    if ($value['nude_car_rate'] < 1 && $value['nude_car_rate'] > 0) {
                        $offers[$key]['nude_car_rate_2'] = $value['nude_car_rate'] * 10000 . '元';
                    } elseif ($value['nude_car_rate'] >= 1) {
                        $offers[$key]['nude_car_rate_2'] = $value['nude_car_rate'] . '万';
                    }
                }
                if ($value['buy_discount_rate'] > 0) {
                    $offers[$key]['buy_discount_rate_1'] = $modelInfo['model_price'] - $value['buy_discount_rate'];
                    if ($value['buy_discount_rate'] < 1 && $value['buy_discount_rate'] > 0) {
                        $offers[$key]['buy_discount_rate_2'] = $value['buy_discount_rate'] * 10000 . '元';
                    } elseif ($value['buy_discount_rate'] >= 1) {
                        $offers[$key]['buy_discount_rate_2'] = $value['buy_discount_rate'] . '万';
                    }
                }
                //正则替换样式
                if ($value['report_content11'] || $value['report_content12']) {
                    $offers[$key]['report_content11'] = preg_replace('/style=\"([^"])+\"/', "", $value['report_content11']);
                    $offers[$key]['report_content12'] = preg_replace('/style=\"([^"])+\"/', "", $value['report_content12']);
                }
                if ($value['report_content21'] || $value['report_content22']) {
                    $offers[$key]['report_content21'] = preg_replace('/style=\"([^"])+\"/', "", $value['report_content21']);
                    $offers[$key]['report_content22'] = preg_replace('/style=\"([^"])+\"/', "", $value['report_content22']);
                }
                if ($value['report_content31'] || $value['report_content32']) {
                    $offers[$key]['report_content31'] = preg_replace('/style=\"([^"])+\"/', "", $value['report_content31']);
                    $offers[$key]['report_content32'] = preg_replace('/style=\"([^"])+\"/', "", $value['report_content32']);
                }
                if ($loanArr) {
                    $offers[$key]['first_morry'] = round($loanArr['first_pay_rate'] * 0.01 * $value['price'], 2);
                    $offers[$key]['last_morry'] = round($loanArr['loan_rate'] * 0.01 * $value['price'], 2);
                    if ($loanArr['loan_peroid'] > 0) {
                        $offers[$key]['month_morry'] = round(($loanArr['loan_rate'] * 0.01 * $value['price'] * 10000) * ($loanArr['interest'] * 0.01 / 12 + 1) / $loanArr['loan_peroid']);
                    }
                }
                $offers[$key]['item_active'] = $offers[$key]['content_active'] = array();
                if ($value['id'] == $posid && $posid) {
                    $offers[$key]['item_active'][$active] = 'i-tabs-item-active';
                    $offers[$key]['content_active'][$active] = 'i-tabs-content-active';
                } else {
                    $offers[$key]['item_active'][0] = 'i-tabs-item-active';
                    $offers[$key]['content_active'][0] = 'i-tabs-content-active';
                }
            }
        }

        $this->vars("ibuycarUrl", DOIBUYCARMAIN);
        $page_title = "$seriesName $modelInfo[model_name]经销商裸车价,暗访价-ams车评网";
        $this->vars("title", $page_title);
        $this->vars('websaleinfo', $_websaleinfo);
        $this->vars('model_info', $modelInfo);
        $this->vars("oldcarprice", $oldcarprice);
        $this->vars("rates", $rates);
        $this->vars("loanArr", $loanArr);
        $this->vars("resultbt", $resultbt);
        $this->vars('compete_model', $competeModel);
        $this->vars('offers', $offers);
        $this->vars('day_price', $dayPrice);
        $this->vars('article', $article);
        $this->vars('page_bar', $page_bar);
        $this->vars('keyword', "$seriesName $modelInfo[model_name]经销商裸车价,$modelInfo[model_name]暗访价");
        $this->vars('description', "ams车评网经销商频道为您提供最全最精确的经销商裸车价,及$seriesName $modelInfo[model_name]暗访价,让您能够快速精确了解到经常商最低价格,最全汽车经销商报价信息尽在ams车评网.");
        $this->vars('css', array('jquery.autocomplete', 'base2', 'shangqing2', 'comm', 'common'));
        $this->vars('js', array('jquery-1.8.3.min', 'global', 'brand', 'series', 'offers'));
        $this->template($templateName, '', 'replaceNewsChannel');
    }

}

?>
 