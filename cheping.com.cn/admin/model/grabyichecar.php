<?php

/*
 * yiche cars data
 * @author David Shaw <tudibao@163.com>
 * $Id: grabyichecar.php 1792 2016-03-28 01:59:03Z wangchangjiang $
 */

import('webclient.class', 'lib');

class grabYiCheCar extends model {

    var $yc_brand;
    var $yc_factory;
    var $yc_series;
    var $yc_model;
    var $wc;
    var $debug = false;

    function __construct() {
        parent::__construct();
        $this->yc_brand = new yicheBrand();
        $this->yc_factory = new yicheFactory();
        $this->yc_series = new yicheSeries();
        $this->yc_model = new yicheModel();
        $this->wc = new webClient();
    }

    /**
     * 返回易车品牌数组
     * 
     * 格式：array(brand_id => brand_name)
     * @return array $brand
     */
    function analyzeBrand() {
        $url = "http://api.car.bitauto.com/CarInfo/getlefttreejson.ashx?tagtype=chexing";
        $referer = "http://car.bitauto.com/";
        $this->wc->setUrl($url);
        $this->wc->setReferer($referer);
        $this->wc->getContent();

        $json = iconv('utf-8', 'gbk', $this->wc->result);
        preg_match_all('%([^"]+)",url:"/tree_chexing/mb_(\d+)/%sm', $json, $match);

        $brand = array();
        foreach ($match[2] as $k => $id) {
            $brand[$id] = $match[1][$k];
        }
        return $brand;
        #return json_decode($json, true);
    }

    /**
     * 返回指定品牌下的厂商和车系数组
     * 
     * 结果示例：array(
     *  factory_id => array(
     *      factory_name
     *      series => array(series_id => series_name)
     * ));
     * 
     * @param type $brand_id 品牌ID
     * @param type $brand_name 品牌名称,GBK编码
     * @return array 厂商/车系数组
     */
    function analyzeFactory($brand_id, $brand_name) {
        $referer = "http://car.bitauto.com/tree_chexing/mb_{$brand_id}/";
        $url = "http://api.car.bitauto.com/CarInfo/getlefttreejson.ashx?tagtype=chexing&pagetype=masterbrand&objid={$brand_id}";
        $this->wc->setUrl($url);
        $this->wc->setReferer($referer);
        $this->wc->getContent();

        $json = $this->wc->result;
        #$json = str_replace('JsonpCallBack(', '', $json);
        #$json = rtrim($json, ')');

        $tmp = explode(',brand:', $json);
        $json = substr($tmp[1], 0, -2);

        $json = preg_replace('/([\w]+):/sm', '"\1":', $json);
        $json = json_decode($json, true);

        #分析品牌子数组
        $letter = util::pinyin($brand_name);

        $tmp = $brand_factory = array();
        if ($json[$letter]) {
            foreach ($json[$letter] as $k => $_brand) {
                $_brand_name = iconv('utf-8', 'gbk', $_brand['name']);
                if ($_brand_name == $brand_name) {
                    $tmp = $_brand['child'];
                    #var_dump($_brand);
                    #检查品牌下有无厂商，如果没有，则厂商与品牌相同
                    $_type = $tmp[0]['type'];
                    if($_type=='cs'){
                        $tmp1 = array();
                        preg_match('/(\d+)/sm', $_brand['url'], $match);
                        $factory_id = intval("50" . $match[1]);
                        $tmp1[] = array(
                            'url' => $factory_id,
                            'name' => $_brand['name'],
                            'num' => 1,
                            'child' => $tmp,
                        );
                        $tmp = $tmp1;
                    }
                    break;
                }
            }
            #var_dump($tmp);
            foreach ($tmp as $k => $_factory) {
                preg_match('/(\d+)/sm', $_factory['url'], $match);
                $factory_id = $match[1];
                $brand_factory[$factory_id]['name'] = iconv('utf-8', 'gbk', $_factory['name']);

                #如果，厂商下有车系数据
                if ($_factory['num']) {
                    foreach ($_factory['child'] as $sk => $series) {
                        preg_match('/(\d+)/sm', $series['url'], $match);
                        $series_id = $match[1];
                        $brand_factory[$factory_id]['series'][$series_id] = iconv('utf-8', 'gbk', $series['name']);
                    }
                }
            }
        }
        return $brand_factory;
    }

    /**
     * 分析指定车系ID下的车款列表,含有易车商城的车款链接
     * 
     * @param int $series_id 车系ID
     * @return array 车款数组
     */
    function analyzeSeries($series_id) {
        $model_list = array();
        $url = "http://api.car.bitauto.com/mai/GetSerialDirectSell.ashx?serialId={$series_id}&cityid=201&callback=directsell_callback";
        $referer = "http://car.bitauto.com/tree_chexing/sb_{$series_id}/";
        $this->wc->setUrl($url);
        $this->wc->setReferer($referer);
        $this->wc->getContent();

        $json = $this->wc->result;
        $json = str_replace('directsell_callback(', '', $json);
        $json = substr($json, 0, -1);
        $json = preg_replace('/([\w]+):/sm', '"\1":', $json);

        #含有易车商城链接的车款列表，没有车款名称，需要用易车车款ID对应
        $tmp = json_decode($json, true);
        foreach ($tmp['CarList'] as $k => $v) {
            $yc_mid = $v['CarId'];
            $yc_price = $v['Price'];
            $yc_mallurl = $v['Url'];
            $model_list[$yc_mid] = array(
                'yc_price' => $yc_price,
                'yc_mallurl' => $yc_mallurl,
            );
        }

        #取该车系，车款列表页面
        $url = $referer;
        $referer = "http://car.bitauto.com/tree_chexing/";
        $this->wc->setUrl($url);
        $this->wc->setReferer($referer);
        $this->wc->getContent();
        $data = iconv('utf-8', 'gbk', $this->wc->result);

        #preg_match_all('%/m(\d+)/" target="_blank">([^<]+)%sm', $data, $match);
        preg_match_all('%/m(\d+)/" target="_blank">([^<]+).*?([\d.]+)万%sm', $data, $match);
        #var_dump($match[1]);
        if ($match[1]) {
            foreach ($match[1] as $k => $yc_mid) {
                $model_list[$yc_mid]['name'] = $match[2][$k];
                $model_list[$yc_mid]['model_price'] = $match[3][$k];
            }
        }

        return $model_list;
    }

    /**
     * 采集易车网的，品牌，厂商，车系，车款数据
     * 其中如果车款数据中含有易车商城的链接，记录到易车车款数据表中
     * 
     * @param string $type 指定采集品牌/车系数据，值（brand/series）
     * @param int $type_id 品牌/车系ID
     * @return boolean 采集状态
     */
    function grabYicheModels($type = '', $type_id = '') {
        $yc_brand = $this->analyzeBrand();

        #如果指定品牌，
        $type_id = intval($type_id);
        if ($type == "brand" && $type_id) {
            if ($yc_brand[$type_id]) {
                $tmp[$type_id] = $yc_brand[$type_id];
                $yc_brand = $tmp;
            } else {
                $this->debug && print("指定的品牌ID($type_id)，不存在！<br>\n");
                return false;
            }
        }

        foreach ($yc_brand as $brand_id => $brand_name) {
            $this->debug && print("brand(" . $brand_id . "):" . $brand_name . "<br>\n");
            #品牌入库
            $b_ret = $this->yc_brand->updateBrand(array(
                'yc_bid' => $brand_id,
                'yc_brandname' => $brand_name,
            ));

            $yc_factory = $this->analyzeFactory($brand_id, $brand_name);
            foreach ($yc_factory as $factory_id => $factory) {
                $this->debug && print("factory(" . $factory_id . "):" . $factory['name'] . "<br>\n");
                #厂商入库
                $f_ret = $this->yc_factory->updateFactory(array(
                    'yc_fid' => $factory_id,
                    'yc_factoryname' => $factory['name'],
                    'yc_bid' => $brand_id,
                    'yc_brandname' => $brand_name,
                ));

                $yc_series = $factory['series'];
                if ($yc_series) {
                    #易车车款列表
                    foreach ($yc_series as $series_id => $series_name) {
                        #如果指定车系，并且，当前处理的车系不是指定的车系，跳过
                        if ($type == "series" && $type_id && $type_id != $series_id) {
                            continue;
                        }

                        #易车车系入库
                        $this->debug && print("series(" . $series_id . "):" . $series_name . "<br>\n");
                        $s_ret = $this->yc_series->updateSeries(array(
                            'yc_sid' => $series_id,
                            'yc_seriesname' => $series_name,
                            'yc_fid' => $factory_id,
                            'yc_factoryname' => $factory['name'],
                            'yc_bid' => $brand_id,
                            'yc_brandname' => $brand_name,
                                ), true);
                        #echo $this->yc_series->sql . "<br>\n";
                        $yc_model = $this->analyzeSeries($series_id);
                        #var_dump($yc_model);
                        foreach ($yc_model as $yc_mid => $model) {
                            $this->debug && print("model(" . $yc_mid . "):" . $model['name'] . "<br>\n");
                            #易车车款入库
                            $m_ret = $this->yc_model->updateModel(array(
                                'yc_mid' => $yc_mid,
                                'yc_modelname' => $model['name'],
                                'yc_sid' => $series_id,
                                'yc_seriesname' => $series_name,
                                'yc_factoryname' => $factory['name'],
                                'yc_brandname' => $brand_name,
                                'yc_price' => $model['yc_price'],
                                'model_price' => $model['model_price'],
                                'yc_mallurl' => $model['yc_mallurl'],
                            ));
                        }
                        if ($type == "series" && $type_id && $type_id == $series_id) {
                            break;
                        }
                    }
                }
            }
            #break;
        }
    }

}
