<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class compareAction extends action {

    function __construct() {
        parent::__construct();
        $this->models = new models();
        $this->series = new series();
        $this->dbfile = new Dbfile();
        $this->param = new param();
        $this->paramtype = new paramType();
        $this->paramtxt = new Paramtxt();
        $this->vars('garage', 'garage');
    }

    function doDefault() {
        echo $this->doIndex();
    }

    function doIndex() {
        $template_name = "compare";

        $this->vars('css', array('compare', 'newbase', 'common'));
        $this->vars('js', array('jquery-1.8.3.min', 'global', 'brand', 'series', 'jquery.lazyload'));

        $model_id = _10917;
        $modelsid = explode("_", $_GET["modelid"]);
        $i = 0;
        $get_do = $_GET["do"];
        switch ($get_do) {
            case "param":
                $do = 2;
                break;
            case "abstract":
                $do = 1;
                break;
            default:
                $do = 1;
                $get_do = "";
                break;
        }
        $this->tpl->assign('get_do', $get_do);
        $attr = $newmodelsid = array();
        if ($modelsid) {
            foreach ($modelsid as $key => $value) {
                $value = intval($value);
                $nullstr = "<strong>---</strong>";
                if ($i < 4) {
                    $model = $this->series->getSeriesmodels("model", $value, null, array(), 1, "120x68");
                    if ($model) {
                        $model["model_name"] = $this->series->getModelname($model["model_name"]);
                        $web_title .= ' ' . $model['series_name'] . '_' . $model['date_id'] . '款' . $model['model_name'] . '，';
                    }
                    if (empty($models[0]) || ($model && empty($newmodelsid[$value]))) {
                        //重构车型id参数
                        if ($model) {
                            $newmodelsid[$value] = $value;
                        }
                        if ($_GET["change"] == $value) {
                            $attrchangekey = $i;
                        }
                        $models[$i] = $model;
                        if ($model["compete_id"]) {
                            $arr = explode(",", $model["compete_id"]);
                            $j = 0;
                            foreach ($arr as $key => $value) {
                                if ($j < 3) {
                                    $result = $this->models->getSeriesmodelsbymidpic($value, "120x68");
                                    if ($result) {
                                        $others[$j] = $result;
                                        $others[$j]["model_name"] = $result["date_id"] . "款 " . $result["brand_name"] . " " . $this->series->getModelname($result["model_name"]);
                                        $j++;
                                    }
                                }
                            }
                            $models[$i]["others"] = $others;
                        }
                        if ($do == 1) {
                            //概述
                            $attr["价格"]["厂商指导价"][$i] = $model ? $model["model_price"] ? strval($model["model_price"]) . " 万" : "暂无" : ""; //价格
                            $attr["价格"]["上次成交价"][$i] = $model ? "暂无上次成交价" : "";
                            $attr["重要信息"]["级别"][$i] = $model ? $model["type_name"] ? $model["type_name"] : $nullstr : "";
                            $attr["重要信息"]["车身结构"][$i] = (($model["st21"] ? $model["st21"] . '门' : '') . ($model["st22"] ? $model["st22"] . '座' : '') . ($model["st4"] ? $model["st4"] : '')) ? ($model["st21"] ? $model["st21"] . '门' : '') . ($model["st22"] ? $model["st22"] . '座' : '') . ($model["st4"] ? $model["st4"] : '') : '';
                            $attr["重要信息"]["发动机"][$i] = $model ? $model["st1"] . ' ' . $model["st28"] . ' ' . $model["st31"] . "气门/缸" : "";
                            $attr["重要信息"]["变速箱"][$i] = $model ? $model["st49"] . "挡" . $model["st50"] ? $model["st49"] . "挡" . $model["st50"] : $nullstr : "";
                            $attr["重要信息"]["功率@转速"][$i] = $model ? $model["st37"] . "@" . $model["st38"] ? $model["st37"] . "@" . $model["st38"] : $nullstr : "";
                            $attr["重要信息"]["油耗（工信部综合）"][$i] = $model ? $model["st10"] ? strval($model["st10"]) : $nullstr : "";
                            $attr["重要信息"]["整车质保"][$i] = $model ? $model["st11"] ? $model["st11"] : $nullstr : "";
                        } else if ($do == 2) {
                            //技术参数
                            $paramattr = $this->param->paramattr;
                            if ($paramattr) {
                                foreach ($paramattr as $key => $value) {
                                    foreach ($value["attr"] as $k => $v) {
                                        $tem = explode("-", $v["pid"]);
                                        $temv = null;
                                        if (count($tem) > 1) {
                                            if ($v["name"] == "比功率(kw/kg)") {
                                                if (isset($model["st" . $tem[0]]) && $model["st" . $tem[0]] != "-" && $model["st" . $tem[0]] != "无" && isset($model["st" . $tem[1]]) && $model["st" . $tem[1]] != "-" && $model["st" . $tem[1]] != "无") {
                                                    $temv = (intval(($model["st" . $tem[0]] / $model["st" . $tem[1]]) * 1000)) / 1000;
                                                } else {
                                                    $temv = "";
                                                }
                                            } else {
                                                $temv = $model["st" . $tem[0]] . "/" . $model["st" . $tem[1]];
                                            }
                                        } else {
                                            if ($model["st" . $v["pid"]] == "标配") {
                                                $temv = "<em class='black'></em>";
//                                        $attr[$value["title"]][$v["name"]][$i]="<font style='font-size:20px;'>●</font>";
                                            } else if ($model["st" . $v["pid"]] == "选配") {
                                                $temv = "<em class='white'></em>";
//                                        $attr[$value["title"]][$v["name"]][$i]="<font style='font-size:20px;'>○</font>";
                                            } else {
                                                $temv = $model["st" . $v["pid"]];
                                            }
                                        }
                                        $temv = strval($temv);
                                        if (isset($temv) && $temv != "无" && trim($temv) != "" && trim($temv) != "无/无") {
                                            $attr[$value["title"]][$v["name"]][$i] = $model ? $temv : "";
                                        } else {
                                            $attr[$value["title"]][$v["name"]][$i] = $model ? $nullstr : "";
                                        }
                                    }
                                }
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        if (!empty($newmodelsid)) {
            $modelsidstr = implode("_", $newmodelsid);
            $this->tpl->assign('newmodelsid', $newmodelsid);
            $this->tpl->assign('modelsidstr', $modelsidstr);
        }
        $this->tpl->assign('sum_attr', $i);
        $this->tpl->assign('attr', $attr);
        if ($_GET["change"]) {
            $changeModelId = $_GET['change'];
            $changeModeInfo = $this->models->getOneModel('brand_id,series_id', $changeModelId);
            $this->tpl->assign('attrchangekey', $attrchangekey);
            $this->tpl->assign('brand_id', $changeModeInfo['brand_id']);
            $this->tpl->assign('series_id', $changeModeInfo['series_id']);
            $this->tpl->assign('change_id', $_GET['change']);
        }
        if (count($models) != 1) {
            $web_title = $models[0]['model_name'] . "和" . $models[1]['model_name'] . "哪个更好-ams车评网";
            $keywords = $models[0]['model_name'] . "和" . $models[1]['model_name'] . "哪个更好";
            $description = "ams车评网车型对比,提供" . $models[0]['model_name'] . "和" . $models[1]['model_name'] . "参数对比、更多车型对比信息尽在ams车评网";
        } else {
            $web_title = '汽车车款对比_汽车参数对比-ams车评网';
            $keywords = '车款对比,汽车参数对比';
            $description = 'ams车评网车型对比,提供汽车车型对比、汽车参数对比等全面的车款对比参数,让您轻松比较车款之间的差异,更多汽车信息尽在ams车评网';
        }

        $this->tpl->assign('title', $web_title);
        $this->tpl->assign('keyword', $keywords);
        $this->tpl->assign('description', $description);

        $this->tpl->assign('models', $models);
        $modelIdInfo = "";
        foreach ($models as $k => $val) {
            if ($k == 0) {
                $modelIdInfo .= $val['model_id'];
            } else {
                $modelIdInfo .= '_' . $val['model_id'];
            }
        }

        $this->tpl->assign('model_id_info', $modelIdInfo);
        $this->tpl->assign('nav', $do);
        $lujing = array(
//            'url' => '/search.php?action=index',
            'title' => '车型对比',
            'b' => 'compar'
        );
        $this->tpl->assign('lujing', $lujing);
        $html = $this->tpl->fetch($template_name);
        $html = $this->getSSIfile($html);
        echo $this->replaceTpl($html);
    }

    function getCommattr($attr) {
        foreach ($attr as $key => $value) {
            foreach ($value as $k => $v) {
                $tem = array_unique($v);
                if (count($tem) == 2) {
                    $tem1 = array_count_values($v);
                    foreach ($tem1 as $k1 => $v1) {
                        if ($v1 == 1) {
                            $temk = array_search($k1, $v);
                            $attr[$key][$k]["istrue"] = $temk;
                        }
                    }
                }
            }
        }
        return $attr;
    }

}
?>
