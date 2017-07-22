<?php

/**
 * 普通ajax方法，请放此文件中实现
 * 注意：要严格限制各种输入参数的合法性
 * $Id: ajaxaction.php 2954 2016-06-07 03:41:08Z david $
 */
class ajaxAction extends action {

    var $province;
    var $article;
    var $city;
    var $tag;
    var $series;
    var $category;
    var $pagedata;

    function __construct() {
        parent::__construct();
        $this->tag = new tag();
        $this->province = new province();
        $this->article = new article();
        $this->series = new series();
        $this->category = new article_category();
        $this->city = new city();
        $this->pagedata = new pageData();
        $this->models = new models();
        $this->pricelog = new priceLog();
        $this->price = new price();
        $this->brand = new brand();
    }

    /**
     * 根据地区ID返回所有省份及直辖市数据
     * select标签里的 option 数据
     * 返回的数据为 HTML 文本形式
     */
    function doProvince() {
        $html = "<option>请选择</option>";
        $region_id = $this->filter($_GET['id'], HTTP_FILTER_INT, 0);
        $list = $this->province->getList("id,name", "region_id=$region_id", 2);
        if ($list)
            foreach ($list as $key => $value) {
                $html .= "<option value=" . $value['id'] . ">" . $value['name'] . "</option>";
            }
        echo $html;
    }

    /**
     * 根据省份ID，返回所有其下的城市列表
     * 数据以HTML的option标签形式返回
     */
    function doCity() {
        $html = "<option>请选择</option>";
        $province_id = $this->filter($_GET['id'], HTTP_FILTER_INT, 0);
        $list = $this->city->getList("id,name", "province_id=$province_id", 2);
        if ($list)
            foreach ($list as $key => $value) {
                $html .= "<option value=" . $value['id'] . ">" . $value['name'] . "</option>";
            }
        echo $html;
    }

    /**
     * 首页获取更多数据的ajax方法
     * 默认传递页号，返回指定数据
     * 页号默认从第2页开始，小于此数，可能同首页默认显示的数据重复
     */
    function doAjaxContent() {
        $page = $this->filter($_POST['k'], HTTP_FILTER_INT, 2);
        #要求最小页号是第2页
        $page = max($page, 2);
        $page_size = 24;
        $page_start = ($page - 1) * $page_size + 6;

        $data['name'] = 'manual';
        $pdid = $this->pagedata->getSomePagedata("value", "name='{$data['name']}'", 3);
        $list = unserialize($pdid);
        $newarr = array_slice($list, $page_start, $page_size);

        $html = '';
        if ($newarr) {
            foreach ($newarr as $key => $value) {
                //$value['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
                if ($value['cname'] == 'article') {
                    $html .= '<h5><div class="left_list"><div class="list_tupian"><a href="' . $value['url'] . '" target="_blank"><img src="/attach/' . $value['pic'] . '" width="280" height="186" alt="' . $value['title'] . '"></a></div><a href="/article.php?action=CarReview&id=' . $value['p_category_id'] . '" target="_blank"><div class="fanwei">' . $value['p_category_name'] . '</div></a><div class="jieshao"><a href="' . $value['url'] . '" target="_blank">' . $value['title'] . '</a></div><div class="list_biaoqian">';
                    foreach ($value['tag_list'] as $k => $v) {
                        if ($k < 3) {
                            $html .= '<a href="/article.php?action=ActiveList&id=' . $v['tag_id'] . '" target="_blank">' . $v['tag_name'] . '</a>&nbsp;';
                        }
                    }
                    $html .= '</div><div class="list_time">' . date('Y.m.d', $value['uptime']) . '</div></div></h5>';
                } else {
                    $html .= '<h5><div class="left_list"><span><a href="' . $value['url'] . '" target="_blank"><img src="/attach/' . $value['pic'] . '" width="280" height="186" alt="' . $value['title'] . '"/></a></span><span class="span-img"><a href="' . $value['url'] . '" target="_blank"><img src="images/point2.png"  /></a></span><a href="/video.php?action=Video&id=' . $value['p_category_id'] . '" target="_blank"><span class="span-zi" style="width:55px; height:30px;">' . $value['p_category_name'] . '</span></a><span class="span1" style="margin-top:5px;"><a href="' . $value['url'] . '" target="_blank">' . $value['title'] . '</a></span><p class="pred"><span>';
                    foreach ($value['tag_list'] as $k => $v) {
                        if ($k < 3) {
                            $html .= '<a href="/article.php?action=ActiveList&id=' . $v['tag_id'] . '">' . $v['tag_name'] . '</a>';
                        }
                    }
                    $html .= '</span></p><div class="list_time fr">' . date('Y.m.d', $value['uptime']) . '</div></div></h5>';
                }
            }
        }
        $html = replaceNewsChannel($html);
        $html = replaceImageUrl($html);
        echo json_encode($html);
    }
    //这里是处理自动搜索
  function doTopSearch() {
        @header("content-type:text/html; charset=utf-8");
        $q = $_GET['q'];
        $keyWord = $this->js_unescape($q);
        $reslut = $this->series->getAutocomplete($keyWord);

        if ($reslut) {
            foreach ($reslut as $key => $value) {
                echo $value[series_name] . "\n";
            }
        }
    }
    //转换js escape提交过来数据
    function js_unescape($str) {
        $ret = '';
        $len = strlen($str);
        for ($i = 0; $i < $len; $i++) {
            if ($str[$i] == '%' && $str[$i + 1] == 'u') {
                $val = hexdec(substr($str, $i + 2, 4));
                if ($val < 0x7f)
                    $ret .= chr($val);
                else if ($val < 0x800)
                    $ret .= chr(0xc0 | ($val >> 6)) . chr(0x80 | ($val & 0x3f));
                else
                    $ret .= chr(0xe0 | ($val >> 12)) . chr(0x80 | (($val >> 6) & 0x3f)) . chr(0x80 | ($val & 0x3f));
                $i += 5;
            }
            else if ($str[$i] == '%') {
                $ret .= urldecode(substr($str, $i, 3));
                $i += 2;
            } else
                $ret .= $str[$i];
        }
        return $ret;
    }
    /**
     * 首页获取更多数据的ajax方法
     * 默认传递页号，返回指定数据
     * 页号默认从第2页开始，小于此数，可能同首页默认显示的数据重复
     */
    function doAjaxWap() {

        $page = $this->filter($_POST['k'], HTTP_FILTER_INT, 2);
        #要求最小页号是第2页
        $page = max($page, 2);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        $value = $this->pagedata->getSomePagedata("value", "name='manual'", 3);
        $list = unserialize($value);
        $newarr = array_slice($list, $page_start, $page_size);
        $html = '';
        if ($newarr) {
            foreach ($newarr as $key => $value) {
                //$value['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
                if ($value['cname'] == 'article') {
                    $html .= '<li><div class="tupian"><span><a href="';
                    if ($value['p_category_id'] == 10) {
                        $html .= '/wenhua/' . date("Ym-d", $value["uptime"]) . '-' . $value['id'] . '.html';
                    } else if ($value['p_category_id'] == 7) {
                        $html .= '/news/' . date("Ym-d", $value["uptime"]) . '-' . $value['id'] . '.html';
                    } else if ($value['p_category_id'] == 8) {
                        $html .= '/pingce/' . date("Ym-d", $value["uptime"]) . '-' . $value['id'] . '.html';
                    } else if ($value['p_category_id'] == 9) {
                        $html .= '/v/' . $value['id'] . '.html';
                    }
                    $html .='"><img src="/attach/' . $value['pic1'] . '" width="100%" height="100px"alt="' . $value['title'] . '"></a></span><p><a href="';
                    if ($value['p_category_id'] == 10) {
                        $html .= '/wenhua/' . date("Ym-d", $value["uptime"]) . '-' . $value['id'] . '.html';
                    } else if ($value['p_category_id'] == 7) {
                        $html .= '/news/' . date("Ym-d", $value["uptime"]) . '-' . $value['id'] . '.html';
                    } else if ($value['p_category_id'] == 8) {
                        $html .= '/pingce/' . date("Ym-d", $value["uptime"]) . '-' . $value['id'] . '.html';
                    } else if ($value['p_category_id'] == 9) {
                        $html .= '/v/' . $value['id'] . '.html';
                    }
                    if (strlen($value['title']) > 60) {
                        $html .= '">' . dstring::substring($value['title'], 0, 20) . '...</a></p></div></li>';
                    } else {
                        $html .= '">' . $value['title'] . '</a></p></div></li>';
                    }
                } else {
                    $html .= '<li><div class="video"><div class="video-img"><span><a href="/v/' . $value['id'] . '.html"><img src="/attach/' . $value['pic1'] . '" width="100%" height="100px" alt="' . $value['title'] . '"></a></span><span class="videoimg"><a href="/v/' . $value['id'] . '.html"><img src="/images/player.png" /></a></span></div><p><a href="/v/' . $value['id'] . '.html">';
                    if (strlen($value['title']) > 60) {
                        $html .= dstring::substring($value['title'], 0, 20) . '...</a></p></div></li>';
                    } else {
                        $html .= $value['title'] . '</a></p></div></li>';
                    }
                }
            }
        }
        $html = replaceWapNewsUrl($html);
        $html = replaceImageUrl($html);
        echo json_encode($html);
    }

    function doAjaxWapVideo() {

        $page = $this->filter($_POST['k'], HTTP_FILTER_INT, 2);
        #要求最小页号是第2页
        $page = max($page, 2);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        $type_id = $this->filter($_POST['id'], HTTP_FILTER_INT, 9);
        $type = $this->filter($_POST['type'], HTTP_FILTER_INT, 0);

        switch ($type) {
            case 0:
                $where = "ca.category_id=cac.id and cac.parentid='{$type_id}' and ca.state=3";
                $fields = "ca.id,ca.title,ca.title2,ca.pic,ca.uptime";
                $lists = $this->article->getArticles($where, $fields, $page_size, $page_start, array("ca.uptime" => "DESC"), 2);
                if ($lists) {
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = $this->article->getArticlePic($value['pic'], '344x258');
                    }
                }
                break;
            default :
                $where = "ca.category_id=cac.id and cac.id='{$type}' and ca.state=3";
                $fields = "ca.id,ca.title,ca.title2,ca.pic,ca.uptime";
                $lists = $this->article->getArticles($where, $fields, $page_size, $page_start, array("ca.uptime" => "DESC"), 2);
                if ($lists)
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = $this->article->getArticlePic($value['pic'], '344x258');
                    }
        }

        $html = '';
        if ($lists) {
            foreach ($lists as $key => $value) {
                $html .= '<li><div class="img1 fl"><a href="/v/' . $value['id'] . '.html"><img src="/attach/' . $value['pic'] . '" width="100%"/></a></div><div class="desc fl"><span style=" display:block;"><a href="/v/' . $value['id'] . '.html">' . $value['title'] . '</a></span><div class="sptime">' . date("Y-m-d", $value["uptime"]) . '</div></div><div class="clear"></div></li>';
            }
        }
        $html = replaceWapNewsUrl($html);
        $html = replaceImageUrl($html);
        echo json_encode($html);
    }

    function doAjaxWapPing() {

        $page = $this->filter($_POST['k'], HTTP_FILTER_INT, 2);
        #要求最小页号是第2页
        $page = max($page, 2);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        $type_id = $this->filter($_POST['id'], HTTP_FILTER_INT, 9);
        $type = $this->filter($_POST['type'], HTTP_FILTER_INT, 0);

        switch ($type) {
            case 0:
                $where = "ca.category_id=cac.id and cac.parentid='{$type_id}' and ca.state=3";
                $fields = "ca.id,ca.title,ca.title2,ca.pic,ca.uptime";
                $lists = $this->article->getArticles($where, $fields, $page_size, $page_start, array("ca.uptime" => "DESC"), 2);
                if ($lists) {
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = $this->article->getArticlePic($value['pic'], '344x258');
                    }
                }
                break;
            default :
                $where = "ca.category_id=cac.id and cac.id='{$type}' and ca.state=3";
                $fields = "ca.id,ca.title,ca.title2,ca.pic,ca.uptime";
                $lists = $this->article->getArticles($where, $fields, $page_size, $page_start, array("ca.uptime" => "DESC"), 2);
                if ($lists)
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = $this->article->getArticlePic($value['pic'], '344x258');
                    }
        }

        $html = '';
        if ($lists) {
            foreach ($lists as $key => $value) {
                $html .= '<li><div class="img1 fl"><a href="/pingce/' . date("Ym-d", $value["uptime"]) . '-' . $value['id'] . '.html"><img src="/attach/' . $value['pic'] . '" width="100%"/></a></div><div class="desc fl"><span style=" display:block;"><a href="/pingce/' . date("Ym-d", $value["uptime"]) . '-' . $value['id'] . '.html">' . $value['title'] . '</a></span><div class="sptime">' . date("Y-m-d", $value["uptime"]) . '</div></div><div class="clear"></div></li>';
            }
        }
        $html = replaceWapNewsUrl($html);
        $html = replaceImageUrl($html);
        echo json_encode($html);
    }

    function doAjaxWapNew() {

        $page = $this->filter($_POST['k'], HTTP_FILTER_INT, 2);
        #要求最小页号是第2页
        $page = max($page, 2);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        $type_id = $this->filter($_POST['id'], HTTP_FILTER_INT, 9);
        $type = $this->filter($_POST['type'], HTTP_FILTER_INT, 0);

        switch ($type) {
            case 0:
                $where = "ca.category_id=cac.id and cac.parentid='{$type_id}' and ca.state=3";
                $fields = "ca.id,ca.title,ca.title2,ca.pic,ca.uptime";
                $lists = $this->article->getArticles($where, $fields, $page_size, $page_start, array("ca.uptime" => "DESC"), 2);
                if ($lists) {
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = $this->article->getArticlePic($value['pic'], '344x258');
                    }
                }
                break;
            default :
                $where = "ca.category_id=cac.id and cac.id='{$type}' and ca.state=3";
                $fields = "ca.id,ca.title,ca.title2,ca.pic,ca.uptime";
                $lists = $this->article->getArticles($where, $fields, $page_size, $page_start, array("ca.uptime" => "DESC"), 2);
                if ($lists)
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = $this->article->getArticlePic($value['pic'], '344x258');
                    }
        }

        $html = '';
        if ($lists) {
            foreach ($lists as $key => $value) {
                $html .= '<li><div class="img1 fl"><a href="/news/' . date("Ym-d", $value["uptime"]) . '-' . $value['id'] . '.html"><img src="/attach/' . $value['pic'] . '" width="100%"/></a></div><div class="desc fl"><span style=" display:block;"><a href="/news/' . date("Ym-d", $value["uptime"]) . '-' . $value['id'] . '.html">' . $value['title'] . '</a></span><div class="sptime">' . date("Y-m-d", $value["uptime"]) . '</div></div><div class="clear"></div></li>';
            }
        }
        $html = replaceWapNewsUrl($html);
        $html = replaceImageUrl($html);
        echo json_encode($html);
    }

    function doAjaxWapWenhua() {

        $page = $this->filter($_POST['k'], HTTP_FILTER_INT, 2);
        #要求最小页号是第2页
        $page = max($page, 2);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        $type_id = $this->filter($_POST['id'], HTTP_FILTER_INT, 9);
        $type = $this->filter($_POST['type'], HTTP_FILTER_INT, 0);

        switch ($type) {
            case 0:
                $where = "ca.category_id=cac.id and cac.parentid='{$type_id}' and ca.state=3";
                $fields = "ca.id,ca.title,ca.title2,ca.pic,ca.uptime";
                $lists = $this->article->getArticles($where, $fields, $page_size, $page_start, array("ca.uptime" => "DESC"), 2);
                if ($lists) {
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = $this->article->getArticlePic($value['pic'], '344x258');
                    }
                }
                break;
            default :
                $where = "ca.category_id=cac.id and cac.id='{$type}' and ca.state=3";
                $fields = "ca.id,ca.title,ca.title2,ca.pic,ca.uptime";
                $lists = $this->article->getArticles($where, $fields, $page_size, $page_start, array("ca.uptime" => "DESC"), 2);
                if ($lists)
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = $this->article->getArticlePic($value['pic'], '344x258');
                    }
        }

        $html = '';
        if ($lists) {
            foreach ($lists as $key => $value) {
                $html .= '<li><div class="img1 fl"><a href="/wenhua/' . date("Ym-d", $value["uptime"]) . '-' . $value['id'] . '.html"><img src="/attach/' . $value['pic'] . '" width="100%"/></a></div><div class="desc fl"><span style=" display:block;"><a href="/wenhua/' . date("Ym-d", $value["uptime"]) . '-' . $value['id'] . '.html">' . $value['title'] . '</a></span><div class="sptime">' . date("Y-m-d", $value["uptime"]) . '</div></div><div class="clear"></div></li>';
            }
        }
        $html = replaceWapNewsUrl($html);
        $html = replaceImageUrl($html);
        echo json_encode($html);
    }

    //猜你喜欢
    function doJsRecommend() {
        $sourceCookie = stripslashes($_COOKIE['hisArt']);
        $cookieModel = json_decode($sourceCookie, true);
        if (is_array($cookieModel)) {
            $end = end($cookieModel);
            $mid = $end['id'];
            $competeResult = $this->models->getCompeteInfo($mid, 'cm.series_id as sid, cm.series_id, cm.model_id, cm.dealer_price_low, cm.model_price, cm.model_pic1, cm.st4, cm.type_id, cs.series_alias, cf.factory_alias', 4);
            if ($competeResult && $competeResult['res']) {
                $compete = $competeResult['res'];
                $modelInfo = $competeResult['st'];
                $length = 12 - count($compete);
                if (count($compete) < 12) {
                    $sid = array_keys($compete);
                    array_push($sid, $modelInfo['series_id']);
                    //$tmp = $this->getCompete($sid, $length, $modelInfo['st4'], $modelInfo['type_id'], $modelInfo['dealer_price_low']);
                    $price = $modelInfo['dealer_price_low'] > 1 ? $modelInfo['dealer_price_low'] : $modelInfo['model_price'];
                    $tmp = $this->getCompete($sid, $length, $modelInfo['st4'], $price);
                    $compete = array_merge($compete, $tmp);
                }
            } elseif ($competeResult && $competeResult['st']) {
                $modelInfo = $competeResult['st'];
                //$compete = $this->getCompete($modelInfo['series_id'], 12, $modelInfo['st4'], $modelInfo['type_id'], $modelInfo['dealer_price_low']);
                $price = $modelInfo['dealer_price_low'] > 1 ? $modelInfo['dealer_price_low'] : $modelInfo['model_price'];
                $compete = $this->getCompete($modelInfo['series_id'], 12, $modelInfo['st4'], $price);
            } else {
                $compete = $this->getRecommend();
            }
        } else {
            $compete = $this->getRecommend();
        }
        foreach ($compete as $key => $val) {
            $compete[$key]['series_alias'] = $val['series_alias'];
            $compete[$key]['factory_alias'] = $val['factory_alias'];
            $compete[$key]['brand_name'] = $val['brand_name'];
            $compete[$key]['st4'] = $val['st4'];
            $compete[$key]['dealer_price_low'] = floatval($val['dealer_price_low'] > 1 ? $val['dealer_price_low'] : $val['model_price']);
        }
        #var_dump($compete);exit;
        echo json_encode($compete);
    }

    //根据brand_id取出车系
    function doseries() {
        $brand_id = $_POST["brand_id"];
        if ($brand_id) {
            $models = $this->series->getSeriesorderById($brand_id);
            echo json_encode($models);
        } else {
            echo -4;
        }
    }

    //根据series_id取出车款
    function doModels() {
        $series_id = $_POST["series_id"];
        if ($series_id) {
            $models = $this->models->getModelsbyseriesid($series_id);
            echo json_encode($models);
        } else {
            echo -4;
        }
    }
    
    function doChangeModelPrice() {
        $modelId = $_GET['model_id'];
        if ($modelId) {
            $fields = 'model_id,brand_name,series_name,model_name,model_price, IF(bingo_price>0,bingo_price, dealer_price_low) as bingobang,model_pic1,model_pic2';
            $price = $this->models->getOneModel($fields, $modelId);
            $prices = $this->price->getSeritePriceByModelId($modelId);
            $bingobang = $price['bingobang'] = $prices[price] ? $prices[price] : $price['bingobang'];
            if ($prices) {
                $price[pricelog_id_from] = $prices[pricelog_id_from];
            }
            $modelPrice = $price['model_price'];

            $price['bingobang'] = $bingobang == 0 ? '未获取' : $this->del0($bingobang) . '万元';
            $price['model_price'] = $modelPrice == 0 ? '--' : $this->del0($modelPrice) . '万元';
            $price['model_pic'] = "/attach/images/model/{$price[model_id]}/{$price[model_pic1]}";
            $price['name1'] = $price[series_name] . ' ' . $price[model_name];
            $price['name'] = dstring::substring($price['name1'], 0,34);

            if ($bingobang > 0) {
                $price['save'] = $this->SaveMoney($modelPrice, $bingobang);
                $price['discount'] = $modelPrice - $bingobang == 0 ? '无折扣' : round(($bingobang / $modelPrice) * 10, 2) . '折';
            } else {
                $price['save'] = '无优惠';
                $price['discount'] = '无折扣';
            }


            foreach ($price as &$value) {
                $value = $value;
            }
            echo json_encode($price);
        } else {
            echo -4;
        }
    }

    function doChangeModelPriceLog() {
        $modelId = $_GET['model_id'];
        $modelId = rtrim($modelId, ',');
        $modelidArr = explode(',', $modelId);
        if ($modelidArr) {

            foreach ($modelidArr as $key => $value) {
                $result = $this->pricelog->getModelPriceLog($value);
                $model_name = $this->models->getModel('brand_name,series_name,model_name', "model_id = $value", 1, '', 1);
                $comparepricelname = $model_name[brand_name] . ' ' . $model_name[series_name] . ' ' . $model_name[model_name];
                $comparePriceLog[$comparepricelname] = $result;
            }
            echo json_encode($comparePriceLog);
        } else {
            echo -4;
        }
    }
    
    //去掉价格最后的0
    function del0($s) {
        $s = trim(strval($s));
        if (preg_match('#^-?\d+?\.0+$#', $s)) {
            return preg_replace('#^(-?\d+?)\.0+$#', '$1', $s);
        }
        if (preg_match('#^-?\d+?\.[0-9]+?0+$#', $s)) {
            return preg_replace('#^(-?\d+\.[0-9]+?)0+$#', '$1', $s);
        }
        return $s;
    }
    
    //计算省了多少钱
    function SaveMoney($highPrice, $lowPrice) {

        $diffPrice = $highPrice - $lowPrice;
        if ($lowPrice == 0) {
            $discount = '无优惠';
        } else {
            if ($diffPrice >= 1) {
                $discount = '<span style="color:#f9444d;">' . $diffPrice . '</span>' . '万元';
            } elseif ($diffPrice < 1 && $diffPrice > 0) {
                $discount = '<span style="color:#f9444d;">' . (floor(10000 * $diffPrice)) . '</span>' . '元';
            } elseif ($diffPrice == 0) {
                $discount = '无优惠';
            } elseif ($diffPrice < 0 && $diffPrice > -1) {
                $discount = '加价' . (floor(abs($diffPrice) * 10000)) . '元';
            } else
                $discount = '加价' . abs($diffPrice) . '万元';
        }
        return $discount;
    }
    
    //获取首页车型大全数据
    function doJsonData(){
                        
        $letter_html = $brand_html = $select_html = '';
        $getbranddata = strval($_GET['getbranddata']);
        $getseriesdata = strval($_GET['getseriesdata']);
        $brand_id = intval($_GET['brandid']);
        $letter = $this->brand->getDrand('letter', 'state=3 GROUP BY letter order by letter asc', 2);
        $brand = $this->brand->getDrand('brand_id,brand_name,brand_logo,letter', 'state=3 order by letter asc', 2);   
        $array = array();
        $series = array();
        if(!$brand_id){
            if ($letter) {
                foreach ($letter as $key => $value) {
                    if ($brand) {
                        foreach ($brand as $k => $v) {
                            if ($v['letter'] == $value['letter']) {
                                $array[$v['letter']][] = $v;
                                $series[$v['brand_id']] = $this->series->getSeriesList('series_id,series_name,series_pic', 'brand_id=' . $v['brand_id'] . ' and state=3', 2);
                            }
                        }
                    }
                }
            }
        }else{
            $series[$v['brand_id']] = $this->series->getSeriesList('series_id,series_name,series_pic', 'brand_id=' . $brand_id . ' and state=3', 2);
        }

        //获取品牌
        if($getbranddata && $getbranddata=='get'){
            $letter_html = '<ul id="navul">';
            if($letter){
                foreach($letter as $k=>$v){
                    $letter_html .= '<li><a href="javascript:void(0);" name="'.$v[letter].'">'.$v[letter].'</a></li>';
                }
            }
            $letter_html .= '</ul>';

            $brand_html = '<div class="select_second"><div class="select_second2">';
                if ($array){
                    foreach($array as $kk=>$vv){
                        $brand_html .= '<div class="select_second3" id="pinpai_'.$kk.'" style="cursor: pointer;">';
                            if($vv){
                                foreach($vv as $kkk=>$vvv){
                                    $brand_html .= '<dl class="select_second4" brandid="'.$vvv[brand_id].'" id="pinpai_'.$vvv[brand_id].'">';
                                    $brand_html .= '<dt><img src="attach/images/brand/'.$vvv[brand_logo].'" style="width:20px;"/></dt>';
                                    $brand_html .= '<dd>'.$vvv[letter].'-'.$vvv[brand_name].'</dd>';
                                    $brand_html .= '</dl>';
                                }
                            }
                        $brand_html .= '</div>';
                    }
                }
            $brand_html .= '</div></div>';
            echo $this->replaceTpl($letter_html.$brand_html);
            exit;
        }
        //获取车系
        if($getseriesdata && $getseriesdata=='get' && $brand_id){
            if($series){
                foreach($series as $sk=>$sv){
                    $select_html .='<div style="position:absolute; z-index:2005;top:0px; left:167px; display:none;" class="select_03" id="pinpai_'.$sk.'_cx">';
                        $select_html .='<div class="select_first">';
                        if($sv){
                            foreach($sv as $skk=>$svv){
                                $select_html .='<a href="/modelinfo_s'. $svv['series_id'] .'.html" target="_blank">';
                                $select_html .='<dl>';
                                    $select_html .='<dt><img src="attach/images/series/'.$svv[series_id].'/'.$svv[series_pic].'" style="width:120px;height:80px;"/></dt>';
                                    $select_html .='<dd>';
                                        $select_html .='<p style="font-size:14px; color:#3c3c3c;">'.$svv[series_name].'</p>';
                                    $select_html .='</dd>';
                                $select_html .='</dl>';
                                $select_html .='</a>';
                            }
                        }
                        $select_html .='</div>';
                        $select_html .='<div class="right_sj"><em></em></div>';
                    $select_html .='</div>';
                }
            }
            echo $this->replaceTpl($select_html);
            exit; 
        }
        
    }
}
