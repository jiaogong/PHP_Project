<?php

/**
 * catch autocar data
 * $Id: catchautocar.php 2682 2016-05-16 07:44:42Z wangchangjiang $
 * $Author: wangchangjiang $
 */
set_time_limit(0);

import('webclient.class', 'lib');

class CatchAutoCar extends webClient {

    var $ua = "Mozilla/5.0 (Windows NT 6.1; rv:2.0) Gecko/20100101 Firefox/4.0";
    var $series;
    var $model;
    var $brand;
    var $factory;
    var $model_name_list = array();
    var $param;
    var $now;
    private $model_state = 3;

    function __construct() {
        parent::__construct();
        $this->now = time();

        $this->brand = new brand();
        $this->factory = new factory();
        $this->series = new series();
        $this->model = new cardbModel();
        $this->param = new param();
    }

    /**
     * 从车系页面分析车款数据
     */
    function analyzeSeriesModels() {
        #分析页面基本配置
        preg_match('/config = ([^;]+)/si', $this->result, $match);
        $config_json = $match[1];
        $config = (array) json_decode($config_json, true);
        $config = (array) $config['result']['paramtypeitems'];
        unset($match);
        #分析页面安全舒适配置
        preg_match('/option = ([^\r]+)/si', $this->result, $match);
        $option_json = $match[1];
        $option_json = substr($option_json, 0, -1);
        $option = (array) json_decode($option_json, true);
        unset($match);
        return array(
          'config' => $config,
          'option' => $option,
        );
    }

    /**
     * 取车款颜色
     */
    function getModelColor() {
        preg_match('/var color = ([^\r]+)/si', $this->result, $match);
        $color[1] = substr($match[1], 0, -1);
        $color_json = $color[1];
        $color = (array) json_decode($color_json, true);
        $color = (array) $color['result']['specitems'];
        rsort($color);
        preg_match('/config = ([^;]+)/si', $this->result, $match);
        $config_json = $match[1];
        $config = (array) json_decode($config_json, true);
        $config = (array) $config['result']['paramtypeitems'];
        unset($match);
        return array(
          'model_name' => $config,
          'color' => $color);
    }

    function formatSeriesOption($data, $data2) {
        $ret = $param = array();
        $temparray = array();
        $autohomespecid = array();
        $type = $this->getBingoParam();
        $r_series_name = str_replace(array('(', ')', '[', ']'), array('\(', '\)', '\[', '\]'), $data2['series_name']);
        #分析车款名称

        foreach ((array) $data['config'][0]['paramitems'][0]['valueitems'] as $k => $v) {
            $model_name = $v['value'];
            $autohomespecid[] = $v['specid'];
            $model_name = preg_replace("/(" . $r_series_name . "\s+)/i", '', $model_name, 1);
            $this->model_name_list[] = $model_name;
        }
        foreach ($data['config'] as $k => $v) {
            foreach ($v['paramitems'] as $kk => $vv) {
                $name = $vv['name'];
                if ($type[$name]) {
                    foreach ($vv['valueitems'] as $key => $value) {
                        $tv = $value['value'];
                        switch ($tv) {
                            case '0': $tv = '无';
                                break;
                            case '-': $tv = '无';
                                break;
                            default:;
                        }
                        #处理源网站有两个 车身结构 的问题
                        if ($ret[$this->model_name_list[$key]]['param'][$type[$name]]) {
                            $ret[$this->model_name_list[$key]]['param'][$type[$name]] .= "|" . $tv;
                        } else {
                            $ret[$this->model_name_list[$key]]['param'][$type[$name]] = $tv;
                        }
                    }
                } elseif ($name == '厂商指导价(元)') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        $ret[$this->model_name_list[$key]]['model_price'] = str_replace('万', '', $value['value']);
                        $ret[$this->model_name_list[$key]]['model_id'] = $value['specid'];
                    }
                } elseif ($name == '排量(mL)') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        $ret[$this->model_name_list[$key]]['param'][$type['汽缸容积(mL)']] = $value['value'];
                    }
                }
            }
        }
        foreach ((array) $data['option']['result']['configtypeitems'] as $k => $v) {
            foreach ($v['configitems'] as $kk => $vv) {
                $name = $vv['name'];
                if ($type[$name]) {
                    foreach ($vv['valueitems'] as $key => $value) {
                        $tv = $value['value'];
                        switch ($tv) {
                            case '●': $tv = '标配';
                                break;
                            case '-': $tv = '无';
                                break;
                            case '○': $tv = '选配';
                                break;
                            default:;
                        }
                        $ret[$this->model_name_list[$key]]['param'][$type[$name]] = $tv;
                    }
                } elseif ($name == '主/副驾驶座安全气囊') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        if ($value['value'] == '-') {
                            $ret[$this->model_name_list[$key]]['param']['62'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['63'] = '无';
                            continue;
                        }
                        $arr = explode('/', $value['value']);
                        $arr[0] = dstring::substring(trim($arr[0], '&nbsp;'), 1, 1);
                        $arr[1] = dstring::substring(trim($arr[1], '&nbsp;'), 1, 1);
                        for ($i = 0; $i < 2; $i++) {
                            switch ($arr[$i]) {
                                case '●':
                                    $temparray[$i] = '标配';
                                    break;
                                case '-':
                                    $temparray[$i] = '无';
                                    break;
                                default :
                                    $temparray[$i] = '选配';
                            }
                        }
                        $ret[$this->model_name_list[$key]]['param']['62'] = $temparray[0];
                        $ret[$this->model_name_list[$key]]['param']['63'] = $temparray[1];
                    }
                } elseif ($name == '前/后排侧气囊') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        if ($value['value'] == '-') {
                            $ret[$this->model_name_list[$key]]['param']['64'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['65'] = '无';
                            continue;
                        }
                        $arr = explode('/', $value['value']);
                        $arr[0] = dstring::substring(trim($arr[0], '&nbsp;'), 1, 1);
                        $arr[1] = dstring::substring(trim($arr[1], '&nbsp;'), 1, 1);
                        for ($i = 0; $i < 2; $i++) {
                            switch ($arr[$i]) {
                                case '●':
                                    $temparray[$i] = '标配';
                                    break;
                                case '-':
                                    $temparray[$i] = '无';
                                    break;
                                default :
                                    $temparray[$i] = '选配';
                            }
                        }
                        $ret[$this->model_name_list[$key]]['param']['64'] = $temparray[0];
                        $ret[$this->model_name_list[$key]]['param']['65'] = $temparray[1];
                    }
                } elseif ($name == '前/后排头部气囊(气帘)') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        if ($value['value'] == '-') {
                            $ret[$this->model_name_list[$key]]['param']['66'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['67'] = '无';
                            continue;
                        }
                        $arr = explode('/', $value['value']);
                        $arr[0] = dstring::substring(trim($arr[0], '&nbsp;'), 1, 1);
                        $arr[1] = dstring::substring(trim($arr[1], '&nbsp;'), 1, 1);
                        for ($i = 0; $i < 2; $i++) {
                            switch ($arr[$i]) {
                                case '●':
                                    $temparray[$i] = '标配';
                                    break;
                                case '-':
                                    $temparray[$i] = '无';
                                    break;
                                default :
                                    $temparray[$i] = '选配';
                            }
                        }
                        $ret[$this->model_name_list[$key]]['param']['66'] = $temparray[0];
                        $ret[$this->model_name_list[$key]]['param']['67'] = $temparray[1];
                    }
                } elseif ($name == '前/后驻车雷达') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        if ($value['value'] == '-') {
                            $ret[$this->model_name_list[$key]]['param']['229'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['230'] = '无';
                            continue;
                        }
                        $arr = explode('/', $value['value']);
                        $arr[0] = dstring::substring(trim($arr[0], '&nbsp;'), 1, 1);
                        $arr[1] = dstring::substring(trim($arr[1], '&nbsp;'), 1, 1);
                        for ($i = 0; $i < 2; $i++) {
                            switch ($arr[$i]) {
                                case '●':
                                    $temparray[$i] = '标配';
                                    break;
                                case '-':
                                    $temparray[$i] = '无';
                                    break;
                                default :
                                    $temparray[$i] = '选配';
                            }
                        }
                        $ret[$this->model_name_list[$key]]['param']['229'] = $temparray[0];
                        $ret[$this->model_name_list[$key]]['param']['230'] = $temparray[1];
                    }
                } elseif ($name == '主/副驾驶座电动调节') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        if ($value['value'] == '-') {
                            $ret[$this->model_name_list[$key]]['param']['227'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['228'] = '无';
                            continue;
                        }
                        $arr = explode('/', $value['value']);
                        $arr[0] = dstring::substring(trim($arr[0], '&nbsp;'), 1, 1);
                        $arr[1] = dstring::substring(trim($arr[1], '&nbsp;'), 1, 1);
                        for ($i = 0; $i < 2; $i++) {
                            switch ($arr[$i]) {
                                case '●':
                                    $temparray[$i] = '标配';
                                    break;
                                case '-':
                                    $temparray[$i] = '无';
                                    break;
                                default :
                                    $temparray[$i] = '选配';
                            }
                        }
                        $ret[$this->model_name_list[$key]]['param']['227'] = $temparray[0];
                        $ret[$this->model_name_list[$key]]['param']['228'] = $temparray[1];
                    }
                } elseif ($name == '多媒体系统') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        if ($value['value'] == '-') {
                            $ret[$this->model_name_list[$key]]['param']['139'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['140'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['141'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['142'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['143'] = '无';
                            continue;
                        }
                        $ret[$this->model_name_list[$key]]['param']['139'] = '无';
                        $ret[$this->model_name_list[$key]]['param']['140'] = '无';
                        $ret[$this->model_name_list[$key]]['param']['141'] = '无';
                        $ret[$this->model_name_list[$key]]['param']['142'] = '无';
                        $ret[$this->model_name_list[$key]]['param']['143'] = '无';
                        $temp = explode("(", $value['value']);
                        $tempaaa = explode(',', trim(dstring::substring($temp[1], 2), ')'));
                        $tempaaa[] = $temp[0];
//                        (多碟CD,单碟DVD,单碟CD)
                        $tempcount = count($tempaaa);
                        $tempa = array(139, 140, 141, 142, 143);
                        for ($i = 0; $i < $tempcount; $i++) {
                            foreach ($tempa as $list) {
                                if ($type[$tempaaa[$i]] == $list) {
                                    if ($i == $tempcount - 1)
                                        $ret[$this->model_name_list[$key]]['param'][$list] = '标配';
                                    else
                                        $ret[$this->model_name_list[$key]]['param'][$list] = '选配';
                                }
                            }
                        }
                    }
                }elseif ($name == '扬声器数量') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        if ($value['value'] == '-') {
                            $ret[$this->model_name_list[$key]]['param']['144'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['145'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['146'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['147'] = '无';
                            continue;
                        }
                        $value['value'] = $value['value'];
                        $tempa = array(144, 145, 146, 147);
                        foreach ($tempa as $list) {
                            if ($type[$value['value']] == $list) {
                                $ret[$this->model_name_list[$key]]['param'][$list] = '标配';
                            } else {
                                $ret[$this->model_name_list[$key]]['param'][$list] = '无';
                            }
                        }
                    }
                } elseif ($name == '空调控制方式') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        if ($value['value'] == '-') {
                            $ret[$this->model_name_list[$key]]['param']['171'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['170'] = '无';
                            continue;
                        }
                        $value['value'] = $value['value'];
                        $tempair1 = dstring::substring($value['value'], 0, 1);
                        $tempair2 = dstring::substring($value['value'], 2, 1);

                        if ($tempair1 == '自动') {
                            switch ($tempair2) {
                                case '●':
                                    $ret[$this->model_name_list[$key]]['param']['171'] = '标配';
                                    $ret[$this->model_name_list[$key]]['param']['170'] = '无';
                                    break;
                                case '○':
                                    $ret[$this->model_name_list[$key]]['param']['171'] = '选配';
                                    $ret[$this->model_name_list[$key]]['param']['170'] = '无';
                                    break;
                                default :
                                    $ret[$this->model_name_list[$key]]['param']['171'] = '无';
                                    $ret[$this->model_name_list[$key]]['param']['170'] = '无';
                            }
                        } else {
                            switch ($tempair2) {
                                case '●':
                                    $ret[$this->model_name_list[$key]]['param']['170'] = '标配';
                                    $ret[$this->model_name_list[$key]]['param']['171'] = '无';
                                    break;
                                case '○':
                                    $ret[$this->model_name_list[$key]]['param']['171'] = '选配';
                                    $ret[$this->model_name_list[$key]]['param']['170'] = '无';
                                    break;
                                default :
                                    $ret[$this->model_name_list[$key]]['param']['170'] = '无';
                                    $ret[$this->model_name_list[$key]]['param']['171'] = '无';
                            }
                        }
                    }
                } elseif ($name == '前/后排座椅加热') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        if ($value['value'] == '-') {
                            $ret[$this->model_name_list[$key]]['param']['112'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['113'] = '无';
                            continue;
                        }
                        $temp = explode('/', $value['value']);
                        $temp1 = dstring::substring(trim($temp[0], '&nbsp;'), 1, 1);
                        $temp2 = dstring::substring(trim($temp[1], '&nbsp;'), 1, 1);
                        switch ($temp1) {
                            case '●':
                                $ret[$this->model_name_list[$key]]['param']['112'] = '标配';
                                break;
                            case '-':
                                $ret[$this->model_name_list[$key]]['param']['112'] = '无';
                                break;
                            default :
                                $ret[$this->model_name_list[$key]]['param']['112'] = '选配';
                        }
                        switch ($temp2) {
                            case '●':
                                $ret[$this->model_name_list[$key]]['param']['113'] = '标配';
                                break;
                            case '-':
                                $ret[$this->model_name_list[$key]]['param']['113'] = '无';
                                break;
                            default :
                                $ret[$this->model_name_list[$key]]['param']['113'] = '选配';
                        }
                    }
                } elseif ($name == '前/后排座椅通风') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        if ($value['value'] == '-') {
                            $ret[$this->model_name_list[$key]]['param']['221'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['222'] = '无';
                            continue;
                        }
                        $temp = explode('/', $value['value']);

                        $temp1 = dstring::substring(trim($temp[0], '&nbsp;'), 1, 1);
                        $temp2 = dstring::substring(trim($temp[1], '&nbsp;'), 1, 1);
                        switch ($temp1) {
                            case '●':
                                $ret[$this->model_name_list[$key]]['param']['221'] = '标配';
                                break;
                            case '-':
                                $ret[$this->model_name_list[$key]]['param']['221'] = '无';
                                break;
                            default :
                                $ret[$this->model_name_list[$key]]['param']['221'] = '选配';
                        }
                        switch ($temp2) {
                            case '●':
                                $ret[$this->model_name_list[$key]]['param']['222'] = '标配';
                                break;
                            case '-':
                                $ret[$this->model_name_list[$key]]['param']['222'] = '无';
                                break;
                            default :
                                $ret[$this->model_name_list[$key]]['param']['222'] = '选配';
                        }
                    }
                } elseif ($name == '前/后排座椅按摩') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        if ($value['value'] == '-') {
                            $ret[$this->model_name_list[$key]]['param']['223'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['224'] = '无';
                            continue;
                        }
                        $temp = explode('/', $value['value']);
                        $temp1 = dstring::substring(trim($temp[0], '&nbsp;'), 1, 1);
                        $temp2 = dstring::substring(trim($temp[1], '&nbsp;'), 1, 1);
                        switch ($temp1) {
                            case '●':
                                $ret[$this->model_name_list[$key]]['param']['223'] = '标配';
                                break;
                            case '-':
                                $ret[$this->model_name_list[$key]]['param']['223'] = '无';
                                break;
                            default :
                                $ret[$this->model_name_list[$key]]['param']['223'] = '选配';
                        }
                        switch ($temp2) {
                            case '●':
                                $ret[$this->model_name_list[$key]]['param']['224'] = '标配';
                                break;
                            case '-':
                                $ret[$this->model_name_list[$key]]['param']['224'] = '无';
                                break;
                            default :
                                $ret[$this->model_name_list[$key]]['param']['224'] = '选配';
                        }
                    }
                } elseif ($name == '后排座椅放倒方式') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        if ($value['value'] == '-') {
                            $ret[$this->model_name_list[$key]]['param']['116'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['117'] = '无';
                            continue;
                        }
                        $value['value'] = $value['value'];
                        if ($value['value'] == '比例放倒') {
                            $ret[$this->model_name_list[$key]]['param']['116'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['117'] = '标配';
                        } else {
                            $ret[$this->model_name_list[$key]]['param']['116'] = '标配';
                            $ret[$this->model_name_list[$key]]['param']['117'] = '无';
                        }
                    }
                } elseif ($name == '前/后中央扶手') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        if ($value['value'] == '-') {
                            $ret[$this->model_name_list[$key]]['param']['125'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['126'] = '无';
                            continue;
                        }
                        $temp = explode('/', $value['value']);
                        $temp1 = dstring::substring(trim($temp[0], '&nbsp;'), 1, 1);
                        $temp2 = dstring::substring(trim($temp[1], '&nbsp;'), 1, 1);
                        switch ($temp1) {
                            case '●':
                                $ret[$this->model_name_list[$key]]['param']['125'] = '标配';
                                break;
                            case '-':
                                $ret[$this->model_name_list[$key]]['param']['125'] = '无';
                                break;
                            default :
                                $ret[$this->model_name_list[$key]]['param']['125'] = '选配';
                        }
                        switch ($temp2) {
                            case '●':
                                $ret[$this->model_name_list[$key]]['param']['126'] = '标配';
                                break;
                            case '-':
                                $ret[$this->model_name_list[$key]]['param']['126'] = '无';
                                break;
                            default :
                                $ret[$this->model_name_list[$key]]['param']['126'] = '选配';
                        }
                    }
                } elseif ($name == '前/后电动车窗') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        if ($value['value'] == '-') {
                            $ret[$this->model_name_list[$key]]['param']['156'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['157'] = '无';
                            continue;
                        }
                        $temp = explode('/', $value['value']);
                        $temp1 = dstring::substring(trim($temp[0], '&nbsp;'), 1, 1);
                        $temp2 = dstring::substring(trim($temp[1], '&nbsp;'), 1, 1);
                        switch ($temp1) {
                            case '●':
                                $ret[$this->model_name_list[$key]]['param']['156'] = '标配';
                                break;
                            case '-':
                                $ret[$this->model_name_list[$key]]['param']['156'] = '无';
                                break;
                            default :
                                $ret[$this->model_name_list[$key]]['param']['156'] = '选配';
                        }
                        switch ($temp2) {
                            case '●':
                                $ret[$this->model_name_list[$key]]['param']['157'] = '标配';
                                break;
                            case '-':
                                $ret[$this->model_name_list[$key]]['param']['157'] = '无';
                                break;
                            default :
                                $ret[$this->model_name_list[$key]]['param']['157'] = '选配';
                        }
                    }
                } elseif ($name == '方向盘调节') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        if ($value['value'] == '-') {
                            $ret[$this->model_name_list[$key]]['param']['92'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['93'] = '无';
                            continue;
                        }
                        $temp1 = $value['value'];
                        switch ($temp1) {
                            case '上下+前后调节':
                                $ret[$this->model_name_list[$key]]['param']['92'] = '标配';
                                $ret[$this->model_name_list[$key]]['param']['93'] = '标配';
                                break;
                            case '上下调节':
                                $ret[$this->model_name_list[$key]]['param']['92'] = '标配';
                                $ret[$this->model_name_list[$key]]['param']['93'] = '无';
                                break;
                            case '前后调节':
                                $ret[$this->model_name_list[$key]]['param']['92'] = '无';
                                $ret[$this->model_name_list[$key]]['param']['93'] = '标配';
                                break;
                            default :
                                $ret[$this->model_name_list[$key]]['param']['92'] = '无';
                                $ret[$this->model_name_list[$key]]['param']['93'] = '无';
                        }
                    }
                } elseif ($name == '内/外后视镜自动防眩目') {
                    foreach ($vv['valueitems'] as $key => $value) {
                        if ($value['value'] == '-') {
                            $ret[$this->model_name_list[$key]]['param']['225'] = '无';
                            $ret[$this->model_name_list[$key]]['param']['226'] = '无';
                            continue;
                        }
                        $temp = explode('/', $value['value']);
                        $temp1 = dstring::substring(trim($temp[0], '&nbsp;'), 1, 1);
                        $temp2 = dstring::substring(trim($temp[1], '&nbsp;'), 1, 1);
                        switch ($temp1) {
                            case '●':
                                $ret[$this->model_name_list[$key]]['param']['225'] = '标配';
                                break;
                            case '-':
                                $ret[$this->model_name_list[$key]]['param']['225'] = '无';
                                break;
                            default :
                                $ret[$this->model_name_list[$key]]['param']['225'] = '选配';
                        }
                        switch ($temp2) {
                            case '●':
                                $ret[$this->model_name_list[$key]]['param']['226'] = '标配';
                                break;
                            case '-':
                                $ret[$this->model_name_list[$key]]['param']['226'] = '无';
                                break;
                            default :
                                $ret[$this->model_name_list[$key]]['param']['226'] = '选配';
                        }
                    }
                }
            }
        }
        return array('ret' => $ret, 'specid' => $autohomespecid);
    }

    /**
     * 将格式化的数据插入数据库
     */
    function addSeriesModels($data, $data2) {
        #如果没有匹配到车系信息，返回失败
        if (!$data2['series_id']) {
            return $msg;
        }
        $this->serieslog = new serieslog();
        $file_obj = new uploadFile();
        $this->series->updateSeries(array('src_id' => $data2['src_id']), $data2['series_id']);
        $tmp = $msg = $mtmp = $_models = array();
        $msg[] = array(
          'src_brand_name' => $data2['src_brand_name'],
          'src_factory_name' => $data2['src_factory_name'],
          'src_series_name' => $data2['src_series_name'],
          'brand_name' => $data2['brand_name'],
          'factory_name' => $data2['factory_name'],
          'series_name' => $data2['series_name'],
        );

        #汽车之家,本地车款库状态包括(删除，待审核,正常，停产在售，停产停售，待审核未上市，正常未上市)
        $bingo_models = $this->model->getModelBySid($data2['series_id'], '', '1,2,3,4,5,6,7,8,9,10,11');
        foreach ($bingo_models as $k => $v) {
            $tmp[$v['model_name']] = $k;
        }
        #检索本地库的该车系下的所有车款数据，包含正常的，待审核，未上市状态
        $t_bingo_models = $this->model->getModelBySid($data2['series_id'], '', '3,8,2,6,9,10,11,7');
        foreach ($t_bingo_models as $k => $v) {
            $mtmp[] = $v['model_name'];
            $_models[$v['model_name']] = $k;
            //处理未上市
            if ($v['state'] == 11) {
                $d_model_state[] = $k;
            }
        }
        $model_diff = array_diff($mtmp, $this->model_name_list);
        if ($model_diff) {
            foreach ($model_diff as $value) {
                //添加停产记录
                $s_id = $this->serieslog->getModelList("id", "model_name='$value' and state=3", 3);
                if (empty($s_id)) {
                    $this->serieslog->ufields = array(
                      'brand_id' => $data2['brand_id'],
                      'brand_name' => $data2['brand_name'],
                      'src_brand_name' => $data2['src_brand_name'],
                      'factory_id' => $data2['factory_id'],
                      'factory_name' => $data2['factory_name'],
                      'src_factory_name' => $data2['src_factory_name'],
                      'series_id' => $data2['series_id'],
                      'series_name' => $data2['series_name'],
                      'src_series_name' => $data2['src_series_name'],
                      'src_id' => $data2['src_id'],
                      'model_name' => $value,
                      'model_id' => $tmp[$value],
                      'state' => 3,
                      'add_time' => $this->now,
                    );
                    $rrr = $this->serieslog->getModelById($tmp[$value], 4);
                    if (!$rrr) {
                        $this->serieslog->insert();
                    }
                }
            }
        }

        foreach ($this->model_name_list as $k => $v) {
            preg_match('/(\d{2,4})款/si', $v, $match);
            $date_id = $match[1];

            $this->model->ufields = array(
              'brand_id' => $data2['brand_id'],
              'brand_name' => $data2['brand_name'],
              'brand_import' => $data2['brand_import'],
              'factory_id' => $data2['factory_id'],
              'factory_name' => $data2['factory_name'],
              'series_id' => $data2['series_id'],
              'series_name' => $data2['series_name'],
              'type_id' => $data2['type_id'],
              'type_name' => $data2['type_name'],
              'src_id' => $data['specid'][$k],
              'model_price' => $data['ret'][$v]['model_price'],
              'model_name' => $v,
              'date_id' => $date_id,
              'updated' => $this->now,
            );
            #如果指导价为0，设置为 `正常（未上市）` 状态, 默认状态为 `正常`
            if (floatval($this->model->ufields['model_price']) < 1) {
                $this->model->ufields['state'] = 11;
            }
            foreach ($data['ret'][$v]['param'] as $pk => $pv) {
                if ($pk == '4') {
                    list($this->model->ufields['st20'], $this->model->ufields['st4']) = explode('|', $pv);
                } else {
                    if($pk){
                        $this->model->ufields['st' . $pk] = $pv;
                    }
                }
            }
            #如果存在，则更新，否则插入
            if ($_models[$v]) {
                $model_id = $_models[$v];
                if ($d_model_state) {
                    if (array_search($model_id, $d_model_state) !== FALSE && floatval($this->model->ufields['model_price']) > 0) {
                        $rrr1 = $this->serieslog->getModelById($model_id, 11);
                        $this->serieslog->ufields = array(
                          'brand_id' => $data2['brand_id'],
                          'brand_name' => $data2['brand_name'],
                          'src_brand_name' => $data2['src_brand_name'],
                          'factory_id' => $data2['factory_id'],
                          'factory_name' => $data2['factory_name'],
                          'src_factory_name' => $data2['src_factory_name'],
                          'series_id' => $data2['series_id'],
                          'series_name' => $data2['series_name'],
                          'src_series_name' => $data2['src_series_name'],
                          'src_id' => $data2['src_id'],
                          'model_name' => $v,
                          'model_price' => $data['ret'][$v]['model_price'],
                          'model_id' => $model_id,
                          'state' => 10,
                        );
                        if ($rrr1) {
                            $this->serieslog->where = "id='{$rrr1}'";
                            $this->serieslog->update();
                        }
                    }
                }

                $this->model->where = "model_id='{$model_id}'";
                $r = $this->model->update();
                #更新搜索表search_index
            }
            #数据库不存在，插入新车
            else {
                $this->model->ufields['state'] = $this->model_state;
                $this->model->ufields['created'] = $this->now;
                $this->model->ufields['state'] = 3;
                if ($this->model->ufields['st56'] != '-') {
                    $model_id = $this->model->insert();
                }
                if ($model_id) {
                    //添加增加记录
                    $a_id = $this->serieslog->getModelList("id", "model_name='$v' and state=1", 3);

                    if (empty($a_id)) {
                        $this->serieslog->ufields = array(
                          'brand_id' => $data2['brand_id'],
                          'brand_name' => $data2['brand_name'],
                          'src_brand_name' => $data2['src_brand_name'],
                          'factory_id' => $data2['factory_id'],
                          'factory_name' => $data2['factory_name'],
                          'src_factory_name' => $data2['src_factory_name'],
                          'series_id' => $data2['series_id'],
                          'series_name' => $data2['series_name'],
                          'src_series_name' => $data2['src_series_name'],
                          'src_id' => $data2['src_id'],
                          'model_name' => $v,
                          'model_id' => $model_id,
                          'state' => 1,
                          'add_time' => $this->now,
                        );
                        $this->serieslog->insert();

                        if (floatval($this->model->ufields['model_price']) < 1) {
                            $this->serieslog->ufields = array(
                              'brand_id' => $data2['brand_id'],
                              'brand_name' => $data2['brand_name'],
                              'src_brand_name' => $data2['src_brand_name'],
                              'factory_id' => $data2['factory_id'],
                              'factory_name' => $data2['factory_name'],
                              'src_factory_name' => $data2['src_factory_name'],
                              'series_id' => $data2['series_id'],
                              'series_name' => $data2['series_name'],
                              'src_series_name' => $data2['src_series_name'],
                              'src_id' => $data2['src_id'],
                              'model_name' => $v,
                              'model_price' => $data['ret'][$v]['model_price'],
                              'model_id' => $model_id,
                              'state' => 11,
                              'add_time' => $this->now,
                            );
                            $this->serieslog->insert();
                        }
                    }
                }
            }
            #add/update model pic,model_pic1
            $model_pic1 = $this->model->getField('model_pic1', $model_id);
            if (empty($model_pic1)) {
                $f = $file_obj->copyStylePic($data2['series_id'], $model_id, array('st4' => $this->model->ufields['st4'], 'st21' => $this->model->ufields['st21']), $date_id, 1);

                if ($f) {
                    $this->model->ufields = array(
                      'model_pic1' => $f,
                      'updated' => $this->now,
                    );
                    $this->model->where = "model_id='{$model_id}'";
                    $this->model->update();
                }
            }

            #add/update model pic,model_pic2
            $model_pic2 = $this->model->getField('model_pic2', $model_id);
            if (empty($model_pic2)) {
                $f = $file_obj->copyStylePic($data2['series_id'], $model_id, array('st4' => $this->model->ufields['st4'], 'st21' => $this->model->ufields['st21']), $date_id);

                if ($f) {
                    $this->model->ufields = array(
                      'model_pic2' => $f,
                      'updated' => $this->now,
                    );
                    $this->model->where = "model_id='{$model_id}'";
                    $this->model->update();
                }
            }
            #modelpic end

            $msg[] = array(
              'model_name' => $v,
              'state' => $r ? 1 : 0,
              'exist' => $_models[$v] ? 1 : 0,
            );
        }

        return $msg;
    }

    /**
     * 从车系页面分析车系相关信息
     */
    function getSeriesInfo() {
        #取原url的车系ID
        preg_match('/(\d+)/si', $this->url, $match);
        $src_id = $match[1];
        unset($match);

        #分析车系名，厂商名，品牌名
        preg_match('/_([^_]+)参数_([^_]+)_/si', $this->result, $match);
        $brand_name = trim($match[2]);
        $series_name = trim($match[1]);

        if (!$brand_name || !$series_name) {
            return false;
        } else {
            return array(
              'brand_name' => $brand_name,
              'series_name' => $series_name,
              'series_id' => $src_id,
            );
        }
    }

    /**
     * 抓取指定页面
     */
    function getPageContent($url) {
        $this->setUrl($url);
        $this->setUserAgent($this->ua);
        $this->getContent();
        $this->result = iconv('gbk', 'utf-8', $this->result);
        #echo iconv('gbk', 'utf-8', $this->result);exit;
    }

    /**
     * 根据抓取的车系信息匹配数据库的车系信息
     * 
     * @param mixed $data
     * @return mixed
     */
    function getBingoSeriesData($data, $series_id = 0) {
        $brand_info = $factory_info = $series_info = array();
        $brand_info = $this->brand->getBrandByName($data['brand_name']);
        if ($brand_info['brand_id']) {
            if ($series_id) {
                $series_info = $this->series->getAllSeries(
                  "s.factory_id=f.factory_id and f.brand_id=b.brand_id and b.state=3 and (s.state=3 or s.state=11)
            and b.brand_id='{$brand_info['brand_id']}' and s.series_id='{$series_id}'", array(), 1
                );
            } else {
                $series_info = $this->series->getAllSeries(
                  "s.factory_id=f.factory_id and f.brand_id=b.brand_id and b.state=3 and (s.state=3 or s.state=11)
            and b.brand_id='{$brand_info['brand_id']}' and s.series_name='{$data['series_name']}'", array(), 1
                );
            }

            $series_info = array_shift($series_info);
            $series_info['src_brand_name'] = $data['brand_name'];
            $series_info['src_factory_name'] = $data['factory_name'];
            $series_info['src_series_name'] = $data['series_name'];
        }
        #如果车系关系查询失败，单独查询车系表
        if (!$series_info['series_id']) {
            $_series = $this->series->getSeriesByName($data['series_name']);
            $series_info['src_brand_name'] = $data['brand_name'];
            $series_info['src_factory_name'] = $data['factory_name'];
            $series_info['src_series_name'] = $data['series_name'];
            $series_info['brand_name'] = $brand_info['brand_name'] ? $brand_info['brand_name'] : $_series['brand_name'];
            $series_info['factory_name'] = $factory_info['factory_name'] ? $factory_info['factory_name'] : $_series['factory_name'];
            $series_info['series_name'] = $series_info['series_name'] ? $series_info['series_name'] : $_series['series_name'];
        }
        $series_info['brand_import'] = $brand_info['brand_import'];
        $series_info['src_id'] = $data['series_id'] == $series_info['src_id'] ? $series_info['src_id'] : $data['series_id'];

        return $series_info;
    }

    /**
     * 取冰狗的参数
     * 返回数据，参数名为key，参数id为值
     */
    function getBingoParam() {
        $ret = array();
        $data = $this->param->getParamAliasAssoc();
        $ret = array_flip($data);
        return $ret;
    }

    /**
     * 设置车款的默认状态，仅针对插入的新车状态
     * 不修改本地库已经存在的车款状态
     * 
     * @param type $state
     */
    function setModelState($state) {
        $this->model_state = $state;
    }

    /* 		$this->brand = new brand();
      $this->factory = new factory();
      $this->series = new series();
      $this->model = new cardbModel();
      $this->param = new param();
     */

    function getStopSell($sid) {
        $sid = intval($sid);
        $stop_model_list = array();
        if ($sid) {
            $seriesSrcid = $this->series->getSeriesdata('src_id', "series_id=$sid and state=3", 3);
            if ($seriesSrcid) {
                $regex = '/<li><a href="javascript:void\(0\);" target="_self" data="(\d+)">\d+.+<\/a><\/li>/';
                $autohomeUrl = 'http://www.autohome.com.cn/' . $seriesSrcid . '/';
                $this->setUrl($autohomeUrl);
                $this->setReferer = 'http://www.autohome.com.cn/';
                $this->getContent();
                #$this->result = iconv('gbk', 'utf-8', $this->result);
                if ($this->result) {
                    $matches = $this->pregMatch($regex);
                    if (is_array($matches) && is_array($matches[1])) {
                        foreach ($matches[1] as $val) {
                            $url = "http://www.autohome.com.cn/ashx/series_allspec.ashx?s=$seriesSrcid&l=3&y=$val";
                            $this->setUrl($url);
                            $this->setHeaderOut(false);
                            $this->getContent();
                            
                            if ($this->result) {
                                $result = iconv('gbk', 'utf-8', $this->result);
                                $result = json_decode($result, true);
                                if (is_array($result) && is_array($result['Spec'])) {
                                    foreach ($result['Spec'] as $val) {//Name
                                        $modelResult = $this->model->getSimp('model_id, state', "series_id=$sid and model_name='{$val['Name']}' and state in (3,8)", 1);
                                        if ($modelResult && $modelResult['state'] != 9) {
                                            $stop_model_list[] = $modelResult['model_id'];
                                            $this->model->updateModel(array('state' => 9), "model_id={$modelResult['model_id']}");
                                            error_log('[' . date('Y-m-d h:i:s') . ']' . ' [' . $this->model->sql . "]\n", 3, SITE_ROOT . 'data/log/autostopsell.log');
                                        } elseif (empty($modelResult)) {
                                            error_log('[' . date('Y-m-d h:i:s') . ']' . ' [error: (no data) ' . $this->model->sql . "]\n", 3, SITE_ROOT . 'data/log/autostopsell.log');
                                        }
                                    }
                                }
                            } else {
                                error_log('[' . date('Y-m-d h:i:s') . ']' . " [error: (curl) http://www.autohome.com.cn/ashx/series_allspec.ashx?s=$seriesSrcid&l=3&y=$val]\n", 3, SITE_ROOT . 'data/log/autostopsell.log');
                            }
                        }
                    }
                } else {
                    error_log('[' . date('Y-m-d h:i:s') . ']' . " [error: (curl) $autohomeUrl]\n", 3, SITE_ROOT . 'data/log/autostopsell.log');
                }
            } else {
                error_log('[' . date('Y-m-d h:i:s') . ']' . " [error: (no src_id) series_id=$sid]\n", 3, SITE_ROOT . 'data/log/autostopsell.log');
            }
        }
        return $stop_model_list;
    }

}

?>
