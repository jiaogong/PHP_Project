<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class cpajaxAction extends action {

    function __construct() {
        parent::__construct();
        $this->models = new models();
        $this->city = new city();
        $this->pricelog = new priceLog();
        $this->brand = new brand();
        $this->series = new series();
        $this->price = new price();
        $this->pagedata = new cp_pageData();

        $this->ibuycarsalecars = new ibuycarsalecar();
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

    function doCity() {
        $province_id = $_POST['pid'];
        if ($province_id) {
            $province = $this->city->getCityByPid($province_id);
            echo json_encode($province);
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
            $price['name'] = string::get_str($price['name1'], 34);

            if ($bingobang > 0) {
                $price['save'] = $this->SaveMoney($modelPrice, $bingobang);
                $price['discount'] = $modelPrice - $bingobang == 0 ? '无折扣' : round(($bingobang / $modelPrice) * 10, 2) . '折';
            } else {
                $price['save'] = '无优惠';
                $price['discount'] = '无折扣';
            }


            foreach ($price as &$value) {
                $value = iconv('gbk', 'utf-8', $value);
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
                $comparePriceLog[iconv('gbk', 'utf-8', $comparepricelname)] = $result;
            }
            echo json_encode($comparePriceLog);
        } else {
            echo -4;
        }
    }

    function doTopSearch() {
        @header("content-type:text/html; charset=utf-8");
        $q = $_GET['q'];
        $keyWord = iconv('utf-8', 'gbk', $this->js_unescape($q));
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

    function doAdvice() {
        $email = $message = '';
        $message = htmlspecialchars($_POST['message']);
        $tmp = parse_url($_SERVER['HTTP_REFERER']);

        if (preg_match('/([\w\.]+)@([\w\.]+)/', $_POST['email'])) {
            $email = $_POST['email'];
        }
        #数据异常返回失败
        if (!$message || !$email || strpos($tmp['host'], DOMAIN) === FALSE) {
            echo 0;
            exit;
        };

        $advice = new cardbadvice();
        $advice_data = array(
            'message' => iconv('utf-8', 'gbk', $message),
            'contact' => $email,
            'ip' => util::getIP(),
            'created' => time(),
            'error_url' => $_SERVER['HTTP_REFERER'],
            'type' => 5,
            'username' => session('uname'),
            'user_id' => session('uid'),
        );
        #var_dump($advice_data);
        $advice->ufields = $advice_data;
        $ret = $advice->insert();
        echo 1;
    }

    //检测验证码
    function doCheckCode() {
        $code = strtolower($_POST['code']);
        $bingo_code = strtolower(session("bingo_code"));

        if ($code == $bingo_code) {
            echo 1;
        } else {
            echo -4;
        }
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
        echo json_encode($compete);
    }

    function getCompete($sid, $length, $st4, $price) {
        $where2 = '';
        if (in_array($st4, array('软顶敞篷车', '硬顶敞篷车', '硬顶跑车', '跑车', 'coupe'))) {
            $where2 = " and cm.st4 in ('软顶敞篷车', '硬顶敞篷车', '硬顶跑车', '跑车', 'coupe')";
        }
        $sid = is_array($sid) ? implode(',', $sid) : $sid;
        $tmp = $newArr = array();
        $where = '';
        if ($sid)
            $where .= " and cm.series_id not in ($sid)";
        if ($where2)
            $where = $where . $where2;
        else
            $where = " and st4='$st4'" . $where;

        $modelStInfo = $this->models->getJoinTable('cm.model_id, cm.dealer_price_low, cm.model_price, cm.model_pic1, cm.series_id, cs.series_alias, cf.factory_alias', $where);

        if ($modelStInfo) {
            $sid = explode(',', $sid);
            foreach ($modelStInfo as $key => $val) {
                if ($val['dealer_price_low'] > 1)
                    $tmp[$key] = abs($val['dealer_price_low'] - $price);
                else
                    $tmp[$key] = abs($val['model_price'] - $price);
                $sid[] = $val['series_id'];
            }
            asort($tmp);
            foreach ($tmp as $key => $val) {
                $newArr[] = $modelStInfo[$key];
                if (count($newArr) > $length - 1)
                    break;
            }
            if (count($newArr) < $length) {
                $recommendResult = $this->getRecommend();
                foreach ($recommendResult as $val) {
                    if (!in_array($val['series_id'], $sid)) {
                        $newArr[] = $val;
                        if (count($newArr) > $length - 1)
                            break;
                    }
                }
            }
        }else {
            $newArr = $this->getRecommend();
        }
        return $newArr;
    }

    function getRecommend() {
        $result = $this->pagedata->getSomePagedata('value', "name='recommend' and c1='index' and c2=1", 1);
        if ($result) {
            $recommend = mb_unserialize($result['value']);
            foreach ($recommend[0] as $key => $val) {
                $recommend[0][$key]['dealer_price_low'] = $val['price'];
            }
            return $recommend[0];
        }
    }

    function dopan19() {
        $model_id = $_GET['model_id'];
        if (!empty($model_id)) {
            $looks = $this->ibuycarsalecars->getSomePagedata('value', "name='salecar' and c1='index' and c2=1", 3);
            $looks = unserialize($looks);
            for ($i = 1; $i < 5; $i++) {
                if ($looks[$i]['id'] == $model_id) {
                    echo "<script>window.location.href='http://www.ibuycar.com/modelinfo_m" . $model_id . ".html';</script>";
                    exit;
                }
            }
            $looks1 = $this->ibuycarsalecars->getSomePagedata('value', "name='shoppingtype1' and c1='index' and c2=1", 3);
            $looks = unserialize($looks1);
            for ($i = 1; $i < 6; $i++) {
                if ($looks[$i]['id'] == $model_id) {
                    echo "<script>window.location.href='http://www.ibuycar.com/modelinfo_m" . $model_id . ".html';</script>";
                    exit;
                }
            }
            $looks2 = $this->ibuycarsalecars->getSomePagedata('value', "name='shoppingtype2' and c1='index' and c2=1", 3);
            $looks = unserialize($looks2);
            for ($i = 1; $i < 6; $i++) {
                if ($looks[$i]['id'] == $model_id) {
                    echo "<script>window.location.href='http://www.ibuycar.com/modelinfo_m" . $model_id . ".html';</script>";
                    exit;
                }
            }
            $looks3 = $this->ibuycarsalecars->getSomePagedata('value', "name='shoppingtype3' and c1='index' and c2=1", 3);
            $looks = unserialize($looks3);
            for ($i = 1; $i < 6; $i++) {
                if ($looks[$i]['id'] == $model_id) {
                    echo "<script>window.location.href='http://www.ibuycar.com/modelinfo_m" . $model_id . ".html';</script>";
                    exit;
                }
            }
            echo "<script>window.location.href='http://www.ibuycar.com';</script>";
        }
    }

}

?>