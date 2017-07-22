<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class modelInfoAction extends action {

    public $models;
    public $dealerprice;
    public $dbfile;
    public $series;
    public $seriesseting;
    public $seriesloan;
    public $param;
    public $paramtxt;
    public $article;
    public $comment;
    public $commentresult;
    public $prosinfo;
    public $attention;
    public $pricelog;
    public $price;
    public $cardemand;
    public $realdata;
    public $cardbfile;
    public $salestate;
    public $oldcarval;
    public $webinfo;
    public $dealerInfo;
    public $brand;
    public $color;
    public $goods;

    function __construct() {
        parent::__construct();
        $this->models = new models();
        $this->dealerprice = new dealerPrice();
        $this->dbfile = new dbfile();
        $this->series = new series();
        $this->seriesseting = new seriessetting();
        $this->seriesloan = new seriesloan();
        $this->param = new param();
        $this->paramtxt = new paramtxt();
        $this->article = new article();
        $this->comment = new comment();
        $this->commentresult = new commentresult();
        $this->prosinfo = new prosinfo();
        $this->attention = new attention();
        $this->pricelog = new priceLog();
        $this->price = new price();
        $this->cardemand = new cardemand();
        $this->realdata = new realdata();
        $this->cardbfile = new cardbfile();
        $this->salestate = new salestate();
        $this->oldcarval = new oldcarval();
        $this->webinfo = new websaleinfo();
        $this->dealerInfo = new dealerinfo();
        $this->brand = new brand();
        $this->color = new color();
        $this->goods = new goods();

        //配置小图标
        $this->pz_img = array(
            'ssn' => array(
                'st98' => '泊车辅助',
                'st97' => '定速巡航',
                'st95' => '多功能方向盘',
                'st74' => '感应钥匙',
                'st75' => '手动模式',
                'st86' => '天窗',
                'st100' => '行车电脑',
                'st102' => '真皮座椅',
                'st171' => '自动空调',
                'st112' => '座椅电加热',
                'st150' => '自动头灯',
                'st107' => '座椅方向调节'
            ),
            'aqn' => array(
                'st80' => '车身稳定控制',
                'st148' => '氙灯',
                'st69' => '胎压监测',
                'qinang' => '安全气囊'
            ),
            'ss' => array(
                'st98' => 'bcfz',
                'st97' => 'dsxh',
                'st95' => 'dgnfxp',
                'st74' => 'gyys',
                'st75' => 'sdms',
                'st86' => 'tch',
                'st100' => 'xcdn',
                'st102' => 'zpzy',
                'st171' => 'zdkt',
                'st112' => 'zydjr',
                'st107' => 'zyfxtj',
                'st150' => 'zdtd'
            ),
            'aq' => array(
                'st80' => 'cswdkz',
                'st148' => 'xq',
                'st69' => 'tyjc',
                'qinang' => 'aqqn'
            )
        );
        $this->vars('garage', 'garage');
    }

    function doDefault() {
        $this->doModelInfo();
    }

    function doGetIp() {
        $ip = util::getip();
        echo $ip;
    }

    function doSuportComment() {
        $id = $_GET['id'];
        $sql = "UPDATE cardb_comment SET s7 = s7 + 1 WHERE id = $id";
        $result = $this->comment->db->query($sql);
        $fields = array('comment_id' => $id, 'comment_result' => '1', 'created' => time());
        $resultid = $this->commentresult->insertAdd($fields);

        if ($result == 1 && $resultid)
            echo 1;
        else
            echo -4;
    }

    function doAttention() {
        $modelId = $_GET['mid'];
        $uid = session('uid');
        $timestamp = time();
        $url = "modelinfo.php?mid=$modelId";
        if (!$uid) {
            $lurl = urlencode($url);
            //$this->alert('登录后才能添加关注,请先登录!', 'js', 3, "login.php?lurl=$lurl");
            echo 3;
        } else {
            $id = $this->attention->getAttention('id', "user_id = $uid AND model_id = $modelId AND state = 1", array(), 3);
            if ($id)
            //$this->alert('您已经关注该车款', 'js', 3, $url);
                echo 2;
            else {
                $ufields = array(
                    'user_id' => $uid,
                    'model_id' => $modelId,
                    'state' => 1,
                    'created' => $timestamp
                );
                $this->attention->insertAttention($ufields);
                // $this->alert('关注成功!', 'js', 3, $url);
                echo 1;
            }
        }
    }

    function doModelInfo() {
        global $_cache;
        $tpl_name = 'model_info';
        $this->vars('css', array('comm', 'jquery.autocomplete', 'base2', 'new_ckyx', 'search2', 'newbase', 'common'));
        $this->vars('js', array('global', 'series', 'brand', 'model_info'));

        $brandId = $_REQUEST['brand_id'];
        $seriesId = $_REQUEST['series_id'];
        $modelId = $_REQUEST['model_id'];
        $t_cache = false;
        $cache_time = 3600;
        $modelId = $modelId ? $modelId : $_GET['mid'];
        if (!$modelId) {
            if ($brandId && !$seriesId) {
                $url = "/search.php?action=index&br=$brandId";
                header("Location:$url");
            }
            if ($seriesId) {
                $modelId = $this->series->getSeriesdata('default_model', "series_id = $seriesId", 3);
                if ($modelId) {
                    $url = "modelinfo_$modelId.html";
                } else {
                    $url = $_SERVER["HTTP_REFERER"];
                }
                header("Location:$url");
                exit;
            }
        }
        //根据车型id取出车型信息
        $model = $this->models->getSeriesmodelsbymid($modelId);
        if (empty($model))
            $this->alert('该车款页面不存在,请重新选择!', 'js', '3', '/');
        if (!empty($model))
            $this->vars('pz_img', $this->models->pzImg);
        //处理车身图片
        $model['model_price'] = $this->del0($model['model_price']);
        $cartype = $model['st4'];
        $factoryType = array(
            1 => '自主',
            2 => '合资',
            3 => '进口'
        );
        $model['factoryType'] = $factoryType[$model['factory_import']];
        //百公里加速  条件  同系 年款+排量+功率
        if ($model[st7] == '' || $model[st7] == '无') {
            if ($model[st6] == '' || $model[st6] == '无') {
                $where = "state=3 and series_id=$model[series_id] and date_id=$model[date_id] and st27='{$model[st27]}' and st37='{$model[st37]}' and IFNULL(st6, st7) <> ''";
                $fields = 'st6,st7';
                $result = $this->models->getModel($fields, $where, 1, '', '1');
                //echo $this->models->sql;
                $model[st6] = $result[st6];
                $model[st7] = $result[st7];
            }
        }
        //取出车款库存
        $model["inventory"] = $this->dealerprice->getDprice("inventory", "model_id='$modelId' and state=1", 3);
        //页面头部信息
        $page_title = "【$model[series_name] $model[model_name]_参数_配置_图片】-ams车评网";
        $keywords = "$model[series_name] $model[model_name]参数,$model[series_name] $model[model_name]配置,$model[series_name] $model[model_name]图片";
        $description = "ams车评网车型频道为您提供全国最全$model[series_name] $model[model_name]最新报价, $model[series_name] $model[model_name]图片, $model[series_name] $model[model_name]参数配置,行情对比及暗访价等信息,帮您在第一时间选择自己的爱车.";
        $this->vars('title', $page_title);
        $this->vars('keyword', $keywords);
        $this->vars('description', $description);
        //取出品牌logo
        $brand_logo = $this->brand->getByBrandId("brand_logo", "brand_id ='{$model['brand_id']}' and state=3", 3);
        $logo_size = @getimagesize("../attach/images/brand/$brand_logo");
        //车系下的车款
        $serielist = $this->models->getModel('model_id,model_name', "series_id = '{$model['series_id']}' and state=3 order by date_id desc", 2);
        $mkey = null;
        if ($serielist)
            foreach ($serielist as $key => $value) {
                if ($key == 0 || strlen($value['model_name']) > strlen($serielist[$mkey]['model_name'])) {
                    $mkey = $key;
                }
            }
        //求最长的车款名
        $model_name_max = strlen($serielist[$mkey]['model_name']) * 9;

        //获取车系图片+2
        //$series_pic = $this->cardbfile->getModelLists("cf.pos>0 and cf.s1='{$model['series_id']}' and cf.type_id='{$model['model_id']}' and cf.pic_color=co.color_name", $model['model_id']);
        $series_pics = $this->cardbfile->getCardbFile('*', "type_name='model' AND type_id='{$model['model_id']}' AND pos<5 AND ppos<5 ORDER BY pos,ppos ASC", 2);
        //取全车系的外观实拍图颜色
        $series_color_pic = $this->color->getColorlist("id,color_pic,type_id,color_name", "type_id='{$model['model_id']}' and type_name='model'", 2);
        $result = $_cache->getCache("model_pics_{$model['model_id']}");
        if (empty($result)) {
            if ($series_pics)
                foreach ($series_pics as $key => $value) {
                    $res[$value['pos']][] = $value;
                }
            if ($res)
                foreach ($res as $key => $value) {
                    if ($key == 1) {
                        $series_pic[1]['totil'] = $this->cardbfile->getCardbFile('COUNT(*) totil', "type_name='model' AND type_id='{$model['model_id']}' and pos = 1 GROUP BY pos", 3);
                        $series_pic[1]['name'] = $this->cardbfile->pt[$key];
                        $series_pic[1]['content'] = $value;
                        $series_pic[1]['pos'] = 1;
                    } elseif ($key == 2) {
                        $series_pic[3]['totil'] = $this->cardbfile->getCardbFile('COUNT(*) totil', "type_name='model' AND type_id='{$model['model_id']}' and pos = 2 GROUP BY pos", 3);
                        $series_pic[3]['name'] = $this->cardbfile->pt[$key];
                        $series_pic[3]['content'] = $value;
                        $series_pic[3]['pos'] = 2;
                    } elseif ($key == 3) {
                        $series_pic[4]['totil'] = $this->cardbfile->getCardbFile('COUNT(*) totil', "type_name='model' AND type_id='{$model['model_id']}' and pos = 3 GROUP BY pos", 3);
                        $series_pic[4]['name'] = $this->cardbfile->pt[$key];
                        $series_pic[4]['content'] = $value;
                        $series_pic[4]['pos'] = 3;
                    } elseif ($key == 4) {
                        $series_pic[2]['totil'] = $this->cardbfile->getCardbFile('COUNT(*) totil', "type_name='model' AND type_id='{$model['model_id']}' and pos = 4 GROUP BY pos", 3);
                        $series_pic[2]['name'] = $this->cardbfile->pt[$key];
                        $series_pic[2]['content'] = $value;
                        $series_pic[2]['pos'] = 4;
                    }
                }
            $_cache->writeCache("model_pics_{$model['model_id']}", $series_pic, 24 * 3600);
        } else {
            $series_pic = $result;
        }

        if ($series_pic) {
            ksort($series_pic);
        }
        $s_num = count($series_pic);

        //处理车款外观图
        if ($s_num >= 3) {
            foreach ($series_pic as $key => $value) {
                if ($series_color_pic)
                    foreach ($series_color_pic as $k => $v) {
                        if ($value['content'][1]['type_id'] == $v['type_id']) {
                            $value['content'][1]['color_id'] = $v['id'];
                        }
                    }
                $model_pic[$value['pos']] = $value['content'][1];
            }
        } else {
            $defaultModel_Id = $this->series->getSeriesdata('IF(last_picid>0,last_picid,default_model) as default_id', "series_id = '{$model['series_id']}'", 3);
            $series_pic1 = $this->cardbfile->getCardbFile('*', "type_name='model' AND type_id='{$defaultModel_Id}' AND pos<5 AND ppos<5 ORDER BY pos,ppos ASC", 2);
            //取全车系的外观实拍图颜色
            $series_color_pic = $this->color->getColorlist("id,color_pic,type_id,color_name", "type_id='{$defaultModel_Id}' and type_name='model'", 2);
            $result = $_cache->getCache("model_pics_{$defaultModel_Id}");
            if (empty($result)) {
                if ($series_pic1)
                    foreach ($series_pic1 as $key => $value) {
                        $res[$value['pos']][] = $value;
                    }
                if ($res)
                    foreach ($res as $key => $value) {
                        if ($key == 1) {
                            $series_pic[1]['totil'] = $this->cardbfile->getCardbFile('COUNT(*) totil', "type_name='model' AND type_id='{$defaultModel_Id}' and pos = 1 GROUP BY pos", 3);
                            $series_pic[1]['name'] = $this->cardbfile->pt[$key];
                            $series_pic[1]['content'] = $value;
                            $series_pic[1]['pos'] = 1;
                        } elseif ($key == 2) {
                            $series_pic[3]['totil'] = $this->cardbfile->getCardbFile('COUNT(*) totil', "type_name='model' AND type_id='{$defaultModel_Id}' and pos = 2 GROUP BY pos", 3);
                            $series_pic[3]['name'] = $this->cardbfile->pt[$key];
                            $series_pic[3]['content'] = $value;
                            $series_pic[3]['pos'] = 2;
                        } elseif ($key == 3) {
                            $series_pic[4]['totil'] = $this->cardbfile->getCardbFile('COUNT(*) totil', "type_name='model' AND type_id='{$defaultModel_Id}' and pos = 3 GROUP BY pos", 3);
                            $series_pic[4]['name'] = $this->cardbfile->pt[$key];
                            $series_pic[4]['content'] = $value;
                            $series_pic[4]['pos'] = 3;
                        } elseif ($key == 4) {
                            $series_pic[2]['totil'] = $this->cardbfile->getCardbFile('COUNT(*) totil', "type_name='model' AND type_id='{$defaultModel_Id}' and pos = 4 GROUP BY pos", 3);
                            $series_pic[2]['name'] = $this->cardbfile->pt[$key];
                            $series_pic[2]['content'] = $value;
                            $series_pic[2]['pos'] = 4;
                        }
                    }
                $_cache->writeCache("model_pics_{$defaultModel_Id}", $series_pic, 24 * 3600);
            } else {
                $series_pic = $result;
            }
            if ($series_pic) {
                foreach ($series_pic as $key => $value) {
                    if ($series_color_pic)
                        foreach ($series_color_pic as $k => $v) {
                            if ($value['content'][1]['type_id'] == $v['type_id']) {
                                $value['content'][1]['color_id'] = $v['id'];
                            }
                        }
                    $model_pic[$value['pos']] = $value['content'][1];
                }
            }
            $model_pic[5] = true;
        }

        //媒体价
        $offers = $this->price->getPriceByModelId($model['model_id'], 1);
        //取配置
        $paramArr = $this->param->getParam("id,name,pid3,orderby,p_id", "pid3<>0 and orderby >0 or id=28 order by orderby asc", 2);
        //亮点配置
        $m_st_num = 0;
        $model_pz = $this->models->newRangeConfigImg($model);
        if ($paramArr)
            foreach ($paramArr as $key => $value) {
                $m_arr = explode(',', $value['p_id']);
                $p_num = 0;
                if ($m_arr)
                    foreach ($m_arr as $k => $v) {
                        $p_id = st . $v;
                        if (array_search($p_id, $model_pz['newss'])) {
                            ++$p_num;
                        }
                    }
                if ($p_num > 0) {
                    continue;
                } else {
                    $m_st = st . $value['id'];
                    if ($m_st_num < 20) {
                        if (array_search($m_st, $model_pz['newss'])) {
                            $m_pz[] = $m_st;
                            $m_st_num++;
                        }
                    }
                }
            }
        $pzImg = $this->models->pzImg;
        //车系特点
        $seriesId = $model['series_id'];
        $series = $this->series->getSeriesdata('pros, cons, score, series_intro,compete_id', "series_id = '{$seriesId}'", 1);
        $series['score'] = explode('||', $series['score']);
        $series['sppf'] = 'sppf' . round($series["score"]["5"]);
        if ($series["score"]["5"] > 9 && $series["score"]["5"] < 10) {
            $series['sppf'] = 'sppf' . floor($series["score"]["5"]);
        }
        //取出关注车款+1
        $attentionModel = $this->models->getAttentionModel($model['model_id'], $model['model_price'], $model['type_id'], $model['st4']);
        //竞争车型
        if ($series['compete_id']) {
            foreach (explode(',', $series['compete_id']) as $sm_id) {
                $series_compete_list = $this->models->getmodel("model_id,model_name,model_price,series_id,series_name,brand_name,model_pic1,model_pic2", "series_id ='{$sm_id}' and state=3 and model_id!='{$model['model_id']}'", 2);
                if (!empty($series_compete_list))
                    $series_arr = array();
                foreach ($series_compete_list as $key => &$value) {
                    $value['priec'] = abs($value['model_price'] - $model['model_price']);
                    $series_arr[] = abs($value['model_price'] - $model['model_price']);
                }
                @array_multisort($series_arr, SORT_ASC, $series_compete_list);
                if ($series_compete_list[0]['model_id'] > 0) {
                    $s_compete_id .=$series_compete_list[0]['model_id'] . ',';
                }
            }
        }
        if ($model['compete_id'] || $s_compete_id) {
            if ($s_compete_id) {
                $model['compete_id'] = $s_compete_id . $model['compete_id'];
                $model['compete_id'] = rtrim($model['compete_id'], ',');
            }
            $compete_list = $this->models->getmodel("model_id as id,model_id,model_name,series_id,series_name,brand_name,model_pic1,model_pic2", "model_id in('{$model['compete_id']}') and state=3 group by series_id", 4);
            if (!empty($compete_list))
                foreach (explode(',', $model['compete_id']) as $cm_id) {
                    if (!empty($compete_list[$cm_id]))
                        $t_compete_list[$cm_id] = $compete_list[$cm_id];
                }
            $compete_list = $t_compete_list;
        }
        if ($compete_list) {
            if (count($compete_list) < 3) {
                $compete_list = array_merge($compete_list, $attentionModel['same_st'], $attentionModel['same_type']);
            }
        } else {
            $compete_list = array_merge($attentionModel['same_st'], $attentionModel['same_type']);
        }

        $compete_A = $compete_arr = array();
        $compete_i = 0;
        if ($compete_list)
            foreach ($compete_list as $key => $value) {
                if ($compete_i < 3) {
                    breack;
                    if (!array_key_exists($value['series_id'], $compete_A)) {
                        $compete_i++;
                        $compete_A[$value['series_id']] = 1;
                        $compete_arr[] = $value;
                    }
                }
            }

        //车款列表+2
        $morder = array();
        $sortarr = array("model_price" => "model_price", "bingo_price" => "bingo_price", "model_dprice" => "model_dprice");
        $sort = strtolower($_GET["sort"]);
        $sort = array_key_exists($sort, $sortarr) ? $sort : "bingo_updated";
        $sortdir = strtolower($_GET["sortdir"]);
        $sortdir = $sortdir == "desc" || $sortdir == "asc" ? $sortdir : "DESC";

        if (array_key_exists($_GET["sort"], $sortarr)) {
            $this->tpl->assign('sort', $sort);
        }
        $this->tpl->assign('sortdir', $sortdir);
        $morder["date_id"] = "DESC";
        if ($sort == "model_dprice") {
            $morder["model_price-bingo_price"] = $sortdir;
        } else {
            $morder[$sort] = $sortdir;
        }
        $cache_key = $sort . "_" . $sortdir . '_' . $seriesId;
        $seriemodel = $this->series->getSeriesmodelsCache($seriesId, $morder, $cache_key, 2, "140x80");
        $cacheSeriesList = $normalModel = $stopModel = array();
        if ($seriemodel)
            foreach ($seriemodel as $value) {
                if ($value['state'] == '9')
                    $stopModel[] = $value;
                else
                    $normalModel[] = $value;
            }
        $normalCount = count($normalModel);
        $stopCount = count($stopModel);
        $serieCache_key = $cache_key . "_sc"; #substr(md5(serialize($seriemodel)),7,16);

        $pzImg = $this->models->pzImg;
        $this->vars("pzImg", $pzImg);
        //    echo $serieCache_key;
        $seriesList = $this->series->getSeriesCache($seriesId, $serieCache_key);
        // var_dump($seriesList);
        if (empty($seriesList)) {
            $seriesModel = array();
            if ($seriemodel)
                foreach ($seriemodel as $key => $row) {
                    $prices = $this->price->getSeritePriceByModelId($row['model_id']);
                    $bingobangPrice = $prices['price'] ? $prices['price'] : $row['dealer_price_low'];
                    $row['pricelog_id_from'] = $prices['pricelog_id_from'];
                    $row['dealer_price_low'] = $prices['price'] ? $prices['price'] : $row['dealer_price_low'];
                    $modelPrice = $row['model_price'];
                    $diffPrice = $modelPrice - $bingobangPrice;
//                    $row['mostbuy_price'] = $this->pricelog->getPrice($row['model_id'], 3);
                    $row['diff_price'] = $diffPrice == 0 ? '无优惠' : formatDiscount($modelPrice, $bingobangPrice);
                    if ($modelPrice > 0) {
                        $row['diff_percent'] = $diffPrice != 0 ? '折扣<span style="color:#ed7001;">' . round(($bingobangPrice / $modelPrice) * 10, 2) . '折</span>' : '无折扣';
                    } else {
                        $row['diff_percent'] = '折扣: 无折扣';
                    }
                    //配置        
                    $row = $this->models->newRangeConfigImg($row);
                    $p_st_num = 1;
                    $pz = array();
                    if ($paramArr)
                        foreach ($paramArr as $key => $value) {
                            $p_arr = explode(',', $value['p_id']);
                            $p_num = 0;
                            if ($p_arr)
                                foreach ($p_arr as $k => $v) {
                                    $p_id = st . $v;
                                    if (array_search($p_id, $row['newss'])) {
                                        ++$p_num;
                                    }
                                }
                            if ($p_num > 0) {
                                continue;
                            } else {
                                $p_st = st . $value['id'];
                                if ($p_st_num < 11) {
                                    if (array_search($p_st, $row['newss'])) {
                                        $pz[] = $p_st;
                                        ++$p_st_num;
                                    }
                                }
                            }
                        }
                    $row['ld_pz'] = $pz;
                    $seriesModel[] = $row;
                }
            $seriemodel = $seriesModel;
            $normalModel = $stopModel = $pz_arr = array();
            if ($seriemodel)
                foreach ($seriemodel as $value) {
                    if ($value['state'] == '9')
                        $stopModel[] = $value;
                    else
                        $normalModel[] = $value;
                }

            if ($normalModel) {
                $resultNormal = $this->models->getModelPic($normalModel, true);
                //在售车款

                foreach ($resultNormal["models"] as $key => $value) {
                    if ($value)
                        foreach ($value as $k => $v) {
                            $normal_px[$k] = $v['model_price'];
                        }
                    @array_multisort($normal_px, SORT_ASC, $value);
                    if ($value)
                        foreach ($value as $k => $v) {
                            $resultNormal1["models"][$key][$v['st27'] . 'L ' . $v['st28'] . ' ' . $v['st36'] . '马力'][] = $v;
                        }
                }
                foreach ($resultNormal1 as $k1 => $v1) {
                    if ($v1)
                        foreach ($v1 as $k2 => $v2) {
                            if ($v2)
                                foreach ($v2 as $k3 => $v3) {
                                    if ($v3)
                                        foreach ($v3 as $k4 => $v4) {
                                            if ($v4['dealer_price_low'] > 0 && $v4['model_price'] > 0) {
                                                $diff = round($v4['model_price'] - $v4['dealer_price_low'], 2);
                                                if ($diff != 0) {
                                                    $resultNormal1[$k1][$k2][$k3][$k4]['zk'] = round(($v4['dealer_price_low'] / $v4['model_price']) * 10, 2);
                                                }
                                                $resultNormal1[$k1][$k2][$k3][$k4]['m_price'] = $diff;
                                            } else {
                                                $resultNormal1[$k1][$k2][$k3][$k4]['zk'] = '';
                                                $resultNormal1[$k1][$k2][$k3][$k4]['m_price'] = '';
                                            }

                                            if ($k4 == 0) {
                                                $pz_arr = $v4['ld_pz'];
                                                if ($v4['ld_pz'])
                                                    foreach ($v4['ld_pz'] as $ks => $vs) {
                                                        $resultNormal1[$k1][$k2][$k3][$k4]['pz'][$vs] = $pzImg['newss'][$vs] . '.png';
                                                    }
                                            } else {
                                                $pz_lan = array_diff($v4[ld_pz], $pz_arr);
                                                if ($pz_lan) {
                                                    if ($v4['ld_pz'])
                                                        foreach ($v4['ld_pz'] as $ks => $vs) {
                                                            if (array_search($vs, $pz_lan) !== false) {
                                                                $resultNormal1[$k1][$k2][$k3][$k4]['pz'][$vs] = $pzImg['newss'][$vs] . '_lan.png';
                                                            } else {
                                                                $resultNormal1[$k1][$k2][$k3][$k4]['pz'][$vs] = $pzImg['newss'][$vs] . '.png';
                                                            }
                                                        }
                                                } else {
                                                    if ($v4['ld_pz'])
                                                        foreach ($v4['ld_pz'] as $ks => $vs) {
                                                            $resultNormal1[$k1][$k2][$k3][$k4]['pz'][$vs] = $pzImg['newss'][$vs] . '.png';
                                                        }
                                                }
                                            }
                                        }
                                }
                        }
                }
            }
            if ($stopModel) {
                $resultStop = $this->models->getModelPic($stopModel, true);
                foreach ($resultStop["models"] as $key => $value) {
                    if ($value)
                        foreach ($value as $k => $v) {
                            $stop_px[$k] = $v[model_price];
                        }

                    @array_multisort($stop_px, SORT_ASC, $value);
                    if ($value)
                        foreach ($value as $k => $v) {
                            $resultStop1["models"][$key][$v[st27] . 'L ' . $v[st28] . ' ' . $v[st36] . '马力'][] = $v;
                        }
                }
                if ($resultStop1)
                    foreach ($resultStop1 as $k1 => $v1) {
                        if ($v1)
                            foreach ($v1 as $k2 => $v2) {
                                if ($v2)
                                    foreach ($v2 as $k3 => $v3) {
                                        if ($v3)
                                            foreach ($v3 as $k4 => &$v4) {
                                                if ($v4['dealer_price_low'] > 0 && $v4['model_price'] > 0) {
                                                    $diff = round($v4['model_price'] - $v4['dealer_price_low'], 2);
                                                    if ($diff != 0) {
                                                        $resultStop1[$k1][$k2][$k3][$k4]['zk'] = round(($v4['dealer_price_low'] / $v4['model_price']) * 10, 2);
                                                    }
                                                    $resultStop1[$k1][$k2][$k3][$k4]['m_price'] = $diff;
                                                } else {
                                                    $resultStop1[$k1][$k2][$k3][$k4]['zk'] = '';
                                                    $resultStop1[$k1][$k2][$k3][$k4]['m_price'] = '';
                                                }

                                                if ($k4 == 0) {
                                                    $pz_arr = $v4['ld_pz'];
                                                    if ($v4['ld_pz'])
                                                        foreach ($v4['ld_pz'] as $ks => $vs) {
                                                            $resultStop1[$k1][$k2][$k3][$k4]['pz'][$vs] = $pzImg['newss'][$vs] . '.png';
                                                        }
                                                } else {
                                                    $pz_lan = array_diff($v4[ld_pz], $pz_arr);
                                                    if ($pz_lan) {
                                                        if ($v4['ld_pz'])
                                                            foreach ($v4['ld_pz'] as $ks => $vs) {
                                                                if (array_search($vs, $pz_lan) !== false) {
                                                                    $resultStop1[$k1][$k2][$k3][$k4]['pz'][$vs] = $pzImg['newss'][$vs] . '_lan.png';
                                                                } else {
                                                                    $resultStop1[$k1][$k2][$k3][$k4]['pz'][$vs] = $pzImg['newss'][$vs] . '.png';
                                                                }
                                                            }
                                                    } else {
                                                        if ($v4['ld_pz'])
                                                            foreach ($v4['ld_pz'] as $ks => $vs) {
                                                                $resultStop1[$k1][$k2][$k3][$k4]['pz'][$vs] = $pzImg['newss'][$vs] . '.png';
                                                            }
                                                    }
                                                }
                                            }
                                    }
                            }
                    }
            }
            $cacheSeriesList = array(
                "0" => $resultNormal1,
                "1" => $resultStop1,
            );
            $seriesList = $this->series->getSeriesCache($seriesId, $serieCache_key, $cacheSeriesList);
        } else {
            if (is_array($seriesList[0]['models'])) {
                ;
                foreach ($seriesList[0]['models'] as $kkk => &$vvvs) {
                    if ($vvvs)
                        foreach ($vvvs as $kk => & $vvs) {
                            if ($vvs)
                                foreach ($vvs as $K => & $vs) {
                                    $prices = $this->price->getPriceList("*", "model_id=$vs[model_id] and price_type=5 and price!='' order by price_type,price", 1);
                                    if ($prices) {
                                        $vs['price'] = $prices['price'];
                                    }
                                }
                        }
                }
            }
        }
        //取车身空间图
        if ($model['is_sportcar']) {
            $carClass = "04";
            $actClass = 'ckyx_cp';
        } else {
            if ($model['st4'] == "两厢车") {
                if ($model['type_id'] == 1 || $model['type_id'] == 2) {
                    $carClass = "01";
                    $actClass = 'ckyx_ao';
                } elseif ($model['type_id'] == 3 || $model['type_id'] == 4 || $model['type_id'] == 5 || $model['type_id'] == 6) {
                    $carClass = "02";
                    $actClass = 'ckyx_ajys';
                } else {
                    $carClass = "02";
                    $actClass = 'ckyx_ajys';
                }
            } elseif ($model['st4'] == "三厢车") {
                $carClass = "07";
                $actClass = 'ckyx_sx';
            } elseif ($model['st4'] == "coupe" || $model['st4'] == "掀背车") {
                $carClass = "06";
                $actClass = 'ckyx_cupe';
            } elseif ($model['st4'] == "MPV") {
                $carClass = "09";
                $actClass = 'ckyx_mpv';
            } elseif ($model['st4'] == "SUV") {
                $carClass = "03";
                $actClass = 'ckyx_suv';
            } elseif ($model['st4'] == "旅行车") {
                $carClass = "08";
                $actClass = 'ckyx_lx';
            } elseif (strpos($model['st4'], '敞篷') !== false) {
                $carClass = "05";
                $actClass = 'ckyx_chpe';
            } elseif (strpos($model['st4'], '跑车') !== false) {
                //包括跑车和硬顶跑车都用超跑的图
                $carClass = "04";
                $actClass = 'ckyx_cp';
            }
        }
        //4s保养+1
        $where = "series_id = {$model['series_id']}";
        $param = array('date_id', 'st41', 'st28', 'st48');
        foreach ($param as $value) {
            $where .= " AND $value = '{$model[$value]}'";
        }
        if ($model['st27']) {
            $where .= " AND st27 = '{$model['st27']}'";
        }
        //车型+1
        $st28 = $model['st28'];
        if ($st28 == '自然吸气')
            $air = 'L';
        if ($st28 == '涡轮增压' || $st == '机械增压')
            $air = 'T';
        $sname = $model['date_id'] . '款 ' . $model['st27'] . ' ' . $air . ' ' . $model['st2'];
        //噪音+1
        $normNoise = array(50, 65, 68, 72);
        $noiseName = array('怠速', '60公里/小时', '80公里/小时', '120公里/小时');
        $noiseKey = array('noise', '60perh', '80perh', '120perh');
        $realData = $this->realdata->getRealData($where);
        $patterns = array(
            '/\d*(挡自动|速自动|挡手自一体)/si',
            '/\d*(挡手动|档 手动)/si',
            '/\d*(挡序列变速箱|挡序列变速|挡序列)/si',
            '/\d*(挡CVT手自一体|挡CVT|挡无级变速手自一体|挡无级变速|CVT 无级变速箱|CVT无级变速|无级变速|电动车单速变速箱)/si',
            '/\d*(挡双离合变速箱|挡双离合)/si',
        );
        $replacements = array(
            "A",
            "M",
            "AMT",
            "CVT",
            "DCT",
        );
        $this->tpl->assign('patterns', $patterns);
        $this->tpl->assign('replacements', $replacements);
        $this->vars('series_pic', $series_pic);
        $this->vars('series_id', $seriesId);
        $this->vars('noise_key', $noiseKey);
        $this->vars('norm_noise', $normNoise);
        $this->vars('noise_name', $noiseName);
        $this->vars('sname', $sname);
        $this->vars('realdata', $realData);
        $this->vars('act_class', $actClass);
        $this->vars('car_class', $carClass);
        $this->vars('attention_model', $attentionModel);
        $this->vars('result_stop', $seriesList['1']);
        $this->vars('result_normal', $seriesList['0']);
        $this->vars('normal_count', $normalCount);
        $this->vars('stop_count', $stopCount);
        $this->vars('series', $series);
        $this->vars("compete_list", $compete_arr);
        $this->vars("model_pz", $model_pz);
        $this->vars("pzImg", $pzImg);
        $this->vars("m_pz", $m_pz);
        $this->vars('model_name_max', $model_name_max);
        $this->vars('model', $model);
        $this->vars('serielist', $serielist);
        $this->vars("logo_size", $logo_size);
        $this->vars("brand_logo", $brand_logo);
        $this->vars('series_color_pic', $series_color_pic);
        $this->vars('model_pic', $model_pic);
        $this->vars("offers", $offers);
        $this->vars("mid", $modelId);

        $this->template($tpl_name, '', 'replaceNewsChannel');
    }

    function doAjaxLd() {
        $modelId = $_GET['mid'];
        $model = $this->models->getSeriesmodelsbymid($modelId);
        $paramArr = $this->param->getParam("id,name,pid3,orderby,p_id", "pid3<>0 and orderby >0 or id=28 order by orderby asc", 2);
        $model_pz = $this->ModelPz($model, $paramArr);
        $pzImg = $this->models->pzImg;
        $images = 'images/col_bus.jpg';
        $mz = array();
        if ($model_pz)
            foreach ($model_pz as $key => $value) {
                if ($key == 'pz_newss') {
                    $mz[] = $value;
                } else {
                    if ($value)
                        foreach ($value as $k => $v) {
                            $mz[] = $v;
                        }
                }
            }
        if ($mz)
            $html = '';
        foreach ($mz as $key => $array) {
            if ($key == 'pz_newss') {
                $html .= '<div class="i-tabs-content i-tabs-content-active">';
            } else {
                $html .= '<div class="i-tabs-content">';
            }
            $html .= '<div class="tabs-news-module">';
            $html .= '<div class="wrap1_v1">';
            $html .= '<div class="left1_v1">';
            $html .= '<input type="hidden" value="0" class="show_index">';
            $html .= '<div class="leftw_v1">';
            $html .= '<ul class="column_list2t">';
            $m_totil = count($array);
            if ($array)
                foreach ($array as $k => $v) {
                    $m_pz = 0;
                    $html .= '<li style="display: ';
                    if ($k == 0) {
                        $html .= 'list-item">';
                    } else {
                        $html .= 'none">';
                    }
                    if ($v)
                        foreach ($v as $vk => $vv) {
                            ++$m_pz;
                            $p_pz_1 = $m_pz % 12;
                            $html .= '<a href="javascript:void(0)" ';
                            if ($p_pz_1 == 0) {
                                $html .= 'style="margin-right:0px;">';
                            } else {
                                $html .= '>';
                            }
                            $html .= '<img width="85" height="38" src="images/search_icon/' . $pzImg['newss'][$vv] . '.png" title="' . $pzImg['newssn'][$vv] . '" onerror="this.src=' . $images . '"></a>';
                        }
                    $html .= '</li>';
                }
            $html .= '</ul>';
            $html .= '<div class="Round_bus">';
            if ($m_totil > 1) {
                $html .= '<ul>';
                if ($m_totil == 2) {
                    $html .= '<li><a href="javascript:void(-1);" class="focus"></a></li>';
                    $html .= '<li><a href="javascript:void(-1);" class=""></a></li>';
                } else if ($m_totil == 3) {
                    $html .= '<li><a href="javascript:void(-1);" class="focus"></a></li>';
                    $html .= '<li><a href="javascript:void(-1);" class=""></a></li>';
                    $html .= '<li><a href="javascript:void(-1);"></a></li>';
                } else if ($m_totil == 4) {
                    $html .= '<li><a href="javascript:void(-1);" class="focus"></a></li>';
                    $html .= '<li><a href="javascript:void(-1);" class=""></a></li>';
                    $html .= '<li><a href="javascript:void(-1);"></a></li>';
                    $html .= '<li><a href="javascript:void(-1);"></a></li>';
                }
                $html .= '</ul>';
                $html .= '<span class="lsi_v"><a href="javascript:void(-1);"><img src="images/scy_zjt_hui.jpg"></a></span> <span class="lsi_v1"><a href="javascript:void(-1);"><img src="images/scy_yjt.jpg"></a></span>';
            }
            $html .= '<span class="rg_show"><a href="javascript:void(-1);"><em style=" font-style:normal; margin-right:5px; color:#ea1a14;">收起</em><img src="images/up_show.jpg"></a></span>';
            $html .= '</div>';
            $html .= '</ul>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }
        echo $html;
    }

    //ajax 获取配置图片
    function doAjaxPeiZhiList() {
        //分类
        $type = array(
            1 => array(33, 34, 35), //安全  安全+防盗+主动安全
            2 => array(6, 31, 40), //舒适  座椅储物+加热通风+娱乐通讯
            3 => array(38, 39), //驾驶辅助+中控方向盘
            4 => array(5, 36, 37)//车窗后视+车身外饰+灯光照明
        );
        $model_id = $_POST['model_id'];
        $pzing = $this->models->pzImg;
        $modelsArr = $this->models->getModel("*", "model_id=$model_id", "1");
        $p_st_num = 0;
        $pz_type = array();
        $resutl['mid'] = $model_id;
        $row = $this->models->newRangeConfigImg($modelsArr);
        $paramArr = $this->param->getParam("id,name,pid3,orderby,p_id", "pid3<>0 and orderby >0 or id=28 order by orderby asc", 2);
        if (strpos($row['st42'], '95')) {
            $st42 = array();
            $st42[] = $pzing['newss']['st42'] . '.png';
            $st42[] = $pzing['newssn']['st42'];
            $resutl['pz_newss']['st42'] = $st42;
        }
        foreach ($paramArr as $key => $value) {


            if ($value['p_id']) {
                // $p_id = st.$value['p_id'];
                $p_arr = explode(',', $value['p_id']);
                $p_num = 0;
                foreach ($p_arr as $k => $v) {
                    $p_id = st . $v;
                    if (array_search($p_id, $row['newss'])) {
                        ++$p_num;
                    }
                }
                if ($p_num > 0) {
                    continue;
                } else {
                    $p_st = st . $value['id'];
                    if (array_search($p_st, $row['newss'])) {

                        $resutl['pz_newss'][$p_st][] = $pzing['newss'][$p_st] . '.png';
                        $resutl['pz_newss'][$p_st][] = $pzing['newssn'][$p_st];
                        if (array_search($value['pid3'], $type[1]) !== false) {
                            $pz_type[1][$p_st][] = $pzing['newss'][$p_st] . '.png';
                            $pz_type[1][$p_st][] = $pzing['newssn'][$p_st];
                        }
                        if (array_search($value['pid3'], $type[2]) !== false) {
                            $pz_type[2][$p_st][] = $pzing['newss'][$p_st] . '.png';
                            $pz_type[2][$p_st][] = $pzing['newssn'][$p_st];
                        }
                        if (array_search($value['pid3'], $type[3]) !== false) {
                            $pz_type[3][$p_st][] = $pzing['newss'][$p_st] . '.png';
                            $pz_type[3][$p_st][] = $pzing['newssn'][$p_st];
                        }if (array_search($value['pid3'], $type[4]) !== false) {
                            $pz_type[4][$p_st][] = $pzing['newss'][$p_st] . '.png';
                            $pz_type[4][$p_st][] = $pzing['newssn'][$p_st];
                        }
                    }
                }
            } else {
                $p_st = st . $value['id'];
                if (array_search($p_st, $row['newss'])) {

                    $resutl['pz_newss'][$p_st][] = $pzing['newss'][$p_st] . '.png';
                    $resutl['pz_newss'][$p_st][] = $pzing['newssn'][$p_st];
                    if (array_search($value['pid3'], $type[1]) !== false) {
                        $pz_type[1][$p_st][] = $pzing['newss'][$p_st] . '.png';
                        $pz_type[1][$p_st][] = $pzing['newssn'][$p_st];
                    }
                    if (array_search($value['pid3'], $type[2]) !== false) {
                        $pz_type[2][$p_st][] = $pzing['newss'][$p_st] . '.png';
                        $pz_type[2][$p_st][] = $pzing['newssn'][$p_st];
                    }
                    if (array_search($value['pid3'], $type[3]) !== false) {
                        $pz_type[3][$p_st][] = $pzing['newss'][$p_st] . '.png';
                        $pz_type[3][$p_st][] = $pzing['newssn'][$p_st];
                    }if (array_search($value['pid3'], $type[4]) !== false) {
                        $pz_type[4][$p_st][] = $pzing['newss'][$p_st] . '.png';
                        $pz_type[4][$p_st][] = $pzing['newssn'][$p_st];
                    }
                }
            }
        }
        ksort($pz_type);
        $resutl['pz_type'] = $pz_type;

        if ($resutl) {
            echo json_encode($resutl);
        } else {
            echo -4;
        }
    }

    //车款图标配置
    function ModelPz($mdoel, $paramArr) {
        $type = array(
            1 => array(33, 34, 35), //安全  安全+防盗+主动安全
            2 => array(6, 31, 40), //舒适  座椅储物+加热通风+娱乐通讯
            3 => array(38, 39), //驾驶辅助+中控方向盘
            4 => array(5, 36, 37)//车窗后视+车身外饰+灯光照明
        );
        $p_st_num = 0;
        $pz_type = array();
        $row = $this->models->newRangeConfigImg($mdoel);
        if (strpos($row['st42'], '95')) {
            $resutl['pz_newss']['st42'] = "st42";
        }
        foreach ($paramArr as $key => $value) {
            if ($value['p_id']) {
                // $p_id = st.$value['p_id'];
                $p_arr = explode(',', $value['p_id']);
                $p_num = 0;
                foreach ($p_arr as $k => $v) {
                    $p_id = st . $v;
                    if (array_search($p_id, $row['newss'])) {
                        ++$p_num;
                    }
                }
                if ($p_num > 0) {
                    continue;
                } else {
                    $p_st = st . $value['id'];
                    if (array_search($p_st, $row['newss'])) {

                        $resutl['pz_newss'][$p_st] = $p_st;
                        if (array_search($value['pid3'], $type[1]) !== false) {
                            $pz_type[1][$p_st] = $p_st;
                        }
                        if (array_search($value['pid3'], $type[2]) !== false) {
                            $pz_type[2][$p_st] = $p_st;
                        }
                        if (array_search($value['pid3'], $type[3]) !== false) {
                            $pz_type[3][$p_st] = $p_st;
                        }
                        if (array_search($value['pid3'], $type[4]) !== false) {
                            $pz_type[4][$p_st] = $p_st;
                        }
                    }
                }
            } else {
                $p_st = st . $value['id'];
                if (array_search($p_st, $row['newss'])) {

                    $resutl['pz_newss'][$p_st] = $p_st;
                    if (array_search($value['pid3'], $type[1]) !== false) {
                        $pz_type[1][$p_st] = $p_st;
                    }
                    if (array_search($value['pid3'], $type[2]) !== false) {
                        $pz_type[2][$p_st] = $p_st;
                    }
                    if (array_search($value['pid3'], $type[3]) !== false) {
                        $pz_type[3][$p_st] = $p_st;
                    }
                    if (array_search($value['pid3'], $type[4]) !== false) {
                        $pz_type[4][$p_st] = $p_st;
                    }
                }
            }
        }
        ksort($pz_type);
        foreach ($pz_type as $k => &$v) {
            $v = array_chunk($v, 36, true);
        }

        $resutl['pz_type'] = $pz_type;
        $resutl['pz_newss'] = @array_chunk($resutl['pz_newss'], 36, true);

        return $resutl;
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

    //计算加减价
    function price($s) {
        if ($s > 0 && $s < 1) {
            return '省<span style="color:#d70b0f">' . $s * 10000 . '</span>元';
        } elseif ($s >= 1) {
            return '省<span style="color:#d70b0f">' . $s . '</span>万元';
        } else if ($s < 0 && $s > -1) {
            return '<span style="color:#d70b0f">加</span>' . abs($s * 10000) . '元';
        } elseif ($s <= -1) {
            return '<span style="color:#d70b0f">加</span>' . abs($s) . '万元';
        } else {
            return $s;
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

    //全险计算
    /**
     * $price 裸车价
     * $num  座位
     */
    function doInsurance($price, $num) {
        //交强险
        if ($num > 6) {
            $InsurancePrice_jq = '1100';
        } else {
            $InsurancePrice_jq = '950';
        }
        //第三方责任险
        if ($num > 7) {
            $InsurancePrice_rz = '478';
        } else {
            $InsurancePrice_rz = '516';
        }
        //车辆损失险
        if ($num > 6) {
            $InsurancePrice_ss = 550 + $price * 0.01088;
        } else {
            $InsurancePrice_ss = 459 + $price * 0.01088;
        }
        //全车盗抢险
        if ($num > 6) {
            $InsurancePrice_bd = 119 + $price * 0.00374;
        } else {
            $InsurancePrice_bd = 102 + $price * 0.004505;
        }
        $TotilInsurancePrice = $InsurancePrice_jq + $InsurancePrice_rz + $InsurancePrice_ss + $InsurancePrice_bd;

        return round($TotilInsurancePrice, 2);
    }

    //ajax 检测该车款是否有某种实拍图颜色的图片
    function doCheckImage() {
        $pic_color = $_POST[pic_color];
        $model_id = $_POST[model_id];
        $arr = $this->cardbfile->getCheckModelPic($model_id, $pic_color);
        if ($arr) {
            echo json_encode($arr);
        } else {
            echo -4;
        }
    }

    //ajax 更换车款页商情价
    function doajaxshangqing() {

        $priceid = $_POST[priceid];
        $model_id = $_POST[model_id];
        $model_price = $_POST[model_price];
        $st22 = $_POST[st22];
        $arr = $this->pricelog->getPriceLogByid($model_id, $priceid);
        if ($arr) {
            $arr[quanxian] = $this->doInsurance($arr[price] * 10000, $st22);
            $arr[lcprice] = $arr[price];
            $arr[gouzhi] = round(( $arr[price] * 10000) / 11.7, 2);
            $diff = $model_price - $arr[price];
            if ($diff > 0 && $diff < 1) {
                $offers[0][youhui_price] = $diff * 10000 . '万';
            } elseif ($diff >= 1) {
                $offers[0][youhui_price] = $diff . '万';
            }
            $arr[totile_price] = round(( $arr[quanxian] / 10000 + $arr[lcprice] + $arr[gouzhi] / 10000), 2);
        }
        //var_dump($arr);exit;
        if ($arr) {
            echo json_encode($arr);
        } else {
            echo -4;
        }
    }

    function doAjaxPage() {

        $page = $_POST[page];
        $st = $_POST[st];
        $d = $_POST[d];
        $d_model = $_POST[d_model];
        $where = $str = $_POST[where];
        $where .="='标配' and state in(3,8)";
        $ld_totile = $this->models->getModel("count(model_id)", "$where", 3);
        $where .=" and model_id!=$d_model ";
        if ($d && $page == 1) {
            $start = 0;
            $ld_d = $this->models->getModel("model_id,model_name,series_id,brand_id", "model_id=$d_model", 2);
            $where .=" order by date_id desc,model_price asc  limit $start,4";
            $ld_pz1 = $this->models->getModel("model_id,model_name,series_id,brand_id", "$where", 2);
            $ld_pz = array_merge($ld_d, $ld_pz1);
        } else {
            $start = ($page - 1) * 5;
            $where .=" order by date_id desc,model_price asc  limit $start,5";
            $ld_pz = $this->models->getModel("model_id,model_name,series_id,brand_id", "$where", 2);
        }

        $html = "";
        $k = 5 * ($page - 1);
        foreach ($ld_pz as $key => $value) {
            $k++;
            $html .="<tr><td><div style='white-space: nowrap;' class='zp_ck'><span>" . $k . '. ';
            $html .="</span><a href='modelinfo.php?mid=$value[model_id]'";
            if ($d_model == $value[model_id]) {
                $html .="style='color:#3399ff'";
            }
            $html .=" target='_black' title='" . $value[model_name] . "'>" . string::get_str($value[model_name], 21) . "</a></div></td></tr>";
        }
        echo $html;
    }

}

?>