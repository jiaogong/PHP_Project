<?php

/**
 * $Id: imageaction.php 6088 2014-12-31 13:45:08Z wangguodong $
 * 
 */
class imageAction extends action {

    var $filecount;
    var $factory;
    var $brand;
    var $series;
    
    function __construct() {
        parent::__construct();
        $this->brand = new brand();
        $this->series = new series();
        $this->factory = new factory();
        $this->cardbfile = new cardbfile();
        $this->models = new models();
        //$this->color = new color();
        $this->pagedata = new pageData();
        $this->filecount = new fileCount();
        $this->doSeriesHot();
        $this->vars('garage', 'garage');
    }

    function doDefault() {
        $this->doSearchList();
    }

    function doSeriesHot() {
        $result = $this->pagedata->getSeriesHot();
        $this->vars('serieshot', $result);
    }
    
    function doSearchCheck() {
        $name = $_POST[searchname];
        $brand_id = $this->brand->getSearchBrandName($name);
        if ($brand_id) {
            $url = "/image_searchbrandlist_brand_id_{$brand_id}.html";
            echo $url;
        } else {
            $series_id = $this->series->getSearchSeriesName($name);
            if ($series_id) {
                $url = "/image_SearchList_series_id_{$series_id}.html";
                echo $url;
            } else {
                $url = -4;
                echo $url;
            }
        }
    }

    function doSearchBrandList() {
        $leftTree = $this->filecount->getBrandCountList();
        $tpl_name = 'search_brand_list';
        $this->vars('css', array('jquery.autocomplete', 'base', 'tppd_index', 'newbase', 'common'));
        $this->vars('js', array('jquery.touchSwipe.min', 'tppd_index', 'tppd_index_pd', 'global','jquery.autocomplete','tpd_index'));
        $brand_id = intval($_GET['brand_id']);

        if ($brand_id) {
            $list = $this->brand->getLeftList($brand_id);
            if ($list['factory']) {
                foreach ($list['factory'] as $key => $val) {
                    $factoryName = $key . ',';
                    if ($val['series']) {
                        foreach ($val['series'] as $k => $v) {
                            $tmp = $this->cardbfile->getSomeCF('name,created,type_id', "s1=$k and ppos<900 and type_name='model'", '', array('pos' => 'asc', 'ppos' => 'asc'), 1);
                            $list['factory'][$key]['series'][$k]['image'] = $tmp['name'];
                            $list['factory'][$key]['series'][$k]['created'] = $tmp['created'];
                            $list['factory'][$key]['series'][$k]['model_id'] = $tmp['type_id'];
                        }
                    }
                }
            }
            //$brand_name = $this->brand->getByBrandId("brand_name","brand_id=$brand_id",3);
        }
   
        $factoryName = ltrim($factoryName, ',');
        $page_title = "【$list[brand_name]】图片_汽车图片_汽车图片大全-ams车评网";
        $keywords = "$list[brand_name]图片,$list[brand_name]汽车图片";
        $description = "ams车评网汽车图片库为您提供专业$list[brand_name]汽车图片大全，包含$list[brand_name]的外观、颜色、中控内饰、车箱空间等$list[brand_name]汽车图片。";
        $this->tpl->assign('title', $page_title);
        $this->tpl->assign('keyword', $keywords);
        $this->tpl->assign('description', $description);
        $this->vars('allbrand', $leftTree);
        $this->vars('brand_id', $brand_id);
        $this->vars("list", $list);
        $this->vars('pageindex', 'pic');
        $lujing = array(
            'title' => '汽车品牌',
            'b' => 'pic'
        );
        $this->vars('lujing', $lujing);
        $this->template($tpl_name);
    }

    function doSearchList() {
        $tpl_name = 'image_list';
        $this->vars('css', array('comm', 'jquery.autocomplete', 'base', 'tppd_index', 'ck_ssjg', 'newbase', 'common'));
        $this->vars('js', array('jquery.touchSwipe.min','tppd_index','global', 'jquery.autocomplete','tpd_index'));
       
        $series_id = intval($_GET[series_id]);
        $model_id = intval($_GET[model_id]);
        $color_id = intval($_GET[color_id]);
        $tp = strval($_GET[tp]);
        $page = intval($_GET[page]);
        $page = max($page, 1);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $model_name = $color_name = $zwv = $page_title_c = $keywords_c = $description_c = $mid = $date_model = $series_total =  "";

        if ($model_id) {
            $model_name = $this->models->getModelNameByid($model_id);
            $search_title .= "<a href='/modelpicselect/{$series_id}__{$color_id}_{$tp}.html'>" . $model_name . "</a>";
        }
//        if ($color_id) {
//            $color_name = $this->color->getColor($color_id, 'color_name', 3);
//            $search_title .= "<a href='/modelpicselect/{$series_id}_{$model_id}__{$tp}.html'>" . $color_name . "</a>";
//        }
        if ($tp) {
            $zwv = $this->cardbfile->pt[$tp];
            $search_title .= "<a href='/modelpicselect/{$series_id}_{$model_id}_{$color_id}_.html'>" . $zwv . "</a>";
        }
        if ($series_id) {
            $seriesdata = $this->series->getSeriesdata("brand_id,brand_name,series_name", "series_id=$series_id", 1);
            //左边品牌车系选择栏
            $leftTree = $this->filecount->getBrandCountList();
            $this->vars('allbrand', $leftTree);
            
            //在售车款 [按车款]
            $modellist = $this->models->getModel("model_name,model_id,date_id,series_id,series_name", "series_id=$series_id and state=3", 2, array("date_id" => "desc"));
            $date_model_array = array();
            if ($modellist) {
                foreach ($modellist as $k => $v) {
                    $mid .=$v['model_id'] . ','; //拼接在售车款id
                    $date_num = 0;
                    if($date_model_array[$date_num]['date'] && $date_model_array[$date_num]['date'] == $v['date_id']){
                       $v['model_total'] = $this->cardbfile->getCardbFile('count(id) as model_total',"type_id={$v['model_id']} and ppos<900 and type_name='model'",3);
                       $series_total += $v['model_total'];
                       $date_model_array[$date_num]['content'][] = $v;
                    }elseif($date_model_array[$date_num]['date'] && $date_model_array[$date_num]['date'] != $v['date_id']){
                        $date_num++;
                        $date_model_array[$date_num]['date'] = $v['date_id'];
                        $v['model_total'] = $this->cardbfile->getCardbFile('count(id) as model_total',"type_id={$v['model_id']} and ppos<900 and type_name='model'",3);
                        $series_total += $v['model_total'];
                        $date_model_array[$date_num]['content'][] = $v;
                    }elseif(!$date_model_array[$date_num]['date']){
                        $date_model_array[$date_num]['date'] = $v['date_id'];
                        $v['model_total'] = $this->cardbfile->getCardbFile('count(id) as model_total',"type_id={$v['model_id']} and ppos<900 and type_name='model'",3);
                        $series_total += $v['model_total'];
                        $date_model_array[$date_num]['content'][] = $v;
                    }  
                }
                $mid = rtrim($mid, ','); //拼接在售车款id
            }
            $seriesdata['series_total'] = $series_total;//车系总张数
            
            $where = "cm.model_id=cf.type_id and cf.pos>0 and cf.s1=$series_id and cf.ppos<900 and cf.type_name='model'";
            $where_color_check = "cf.pos>0 and cf.s1=$series_id and cf.ppos<900 and cf.type_name='model' and cf.pic_color!=''";
            $where_model_check = "pos>0 and s1=$series_id and ppos<900 and type_name='model'";
            if ($tp) {
                $where.=" and cf.pos=$tp";
            }
//            if ($color_id) {
//                $where.=" and cf.pic_color='$color_name'";
//                $where_color_check.=" and cf.pic_color='$color_name'";
//            }
            if ($model_id) {
                $where.=" and cf.type_id=$model_id";
                $where_color_check.=" and cf.type_id=$model_id";
                $where_model_check .=" and type_id=$model_id";
            }
            if ($mid) {
                $where_model_check .=" and type_id in($mid)";
                $where.=" and cf.type_id in($mid)";
            }
            
            //按分类
            $poslist = $this->cardbfile->getSeriesList($where_model_check);
            //按外观颜色
            //$seriescolorlist = $this->color->getSeriesColorLists($where_color_check);
            
            //车身外观、中控内饰、车厢空间、其他细节
            if(!$tp){
                $result = $this->cardbfile->getSeriesDataLists($where);
            }else{
                $result = $this->cardbfile->getSeriesDataLists($where, $tp, $page_start, $page_size);
                $page_total = $this->cardbfile->total;
                $page_bar = multipage::offer_multi($page_total, $page_size, $page, "/modelpicselect/{$series_id}_{$model_id}_{$color_id}_{$tp}_");
            }
        }

        if ($series_id) {
            $page_title = "【" . $seriesdata['series_name'] . "图片】" . $seriesdata['brand_name'] . "_汽车图库-ams车评网";
            $keywords = $seriesdata['series_name'] . $seriesdata['brand_name'] . "汽车图片";
            $description = "ams车评网提供" . $seriesdata['series_name'] . "图片,包括" . $seriesdata['brand_name'] . "全部" . $seriesdata['series_name'] . "车型外观、颜色、中控内饰、车箱空间等其他细节的大量图片,更多精彩汽车图片尽在ams车评网";
        }
        if ($model_id) {
            if ($page_title_c) {
                $page_title_c .= $seriesdata['series_name'] . "_" . $model_name;
                $keywords_c .= $model_name;
                $description_c .= $model_name; 
            } else {
                $page_title_c = $seriesdata['series_name'] . "_" . $model_name;
                $keywords_c = $model_name;
                $description_c = $model_name;
            }
        }
        if ($tp) {
            if ($page_title_c) {
                $page_title_c .= $zwv;
                $keywords_c .= $zwv;
                $description_c .= $zwv;
            } else {
                $page_title_c = $zwv;
                $keywords_c = $zwv;
                $description_c = $zwv;
            }
        }
        if ($color_id) {
            if ($page_title_c) {
                $page_title_c .= $color_name;
                $keywords_c .= $color_name;
                $description_c .= $color_name;
            } else {
                $page_title_c = $color_name;
                $keywords_c = $color_name;
                $description_c = $color_name;
            }
        }
        if ($color_id || $tp) {
            if ($page_title_c) {
                $this->vars('title', $seriesdata['brand_name'] . $page_title_c . "图片-ams车评网");
                $this->vars('keyword', $seriesdata['brand_name'] . $keywords_c . "图片");
                $this->vars("description", "ams车评网" . $description_c . "图片,提供" . $seriesdata['brand_name'] . $description_c . "的外观、颜色、中控内饰、车箱空间等其他细节的大量图片,更多精彩汽车图片尽在ams车评网");
            }
        } elseif ($model_id) {
            if ($page_title_c) {
                $this->vars('title', $page_title_c . "图片-ams车评网");
                $this->vars('keyword', $keywords_c . "图片");
                $this->vars("description", "ams车评网" . $description_c . "图片,提供" . $description_c . "的外观、颜色、中控内饰、车箱空间等其他细节的大量图片,更多精彩汽车图片尽在ams车评网");
            }
        } else {
            $this->vars('title', $page_title);
            $this->vars('keyword', $keywords);
            $this->vars("description", $description);
        }

        $this->vars('seriescolorlist', $seriescolorlist);
        $this->vars('poslist', $poslist);
        $this->vars("search_title", $search_title);
        $this->vars("model_id", $model_id);
        $this->vars("seriesdata", $seriesdata);
        $this->vars("series_id", $series_id);
        $this->vars("color_id", $color_id);
        $this->vars("tp", $tp);
        $this->vars('query_url', $query_url);
        $this->vars('serieslist', $result);
        $this->vars('page_bar', $page_bar);
        $this->vars("page_size", $page_size);
        $this->vars('date_model_array', $date_model_array);
        $this->vars('pageindex', 'pic');
        $lujing = array(
            'title' => '汽车个性化选图 ',
            'b' => 'pic'
        );
        $this->vars('lujing', $lujing);
        $this->template($tpl_name);
    }

    function doGetFactory() {
        $brand_id = intval($_GET['bid']);
        $this->factory->fields = "factory_id,factory_name";
        $this->factory->where = "brand_id='{$brand_id}' and state=3";
        $this->factory->order = array('factory_id' => 'asc');
        $factory = $this->factory->getResult(4);
        $this->brand->fields = "letter";
        $this->brand->where = "brand_id='{$brand_id}'";
        $brand_letter = $this->brand->getResult(3);
        $factory_pic_count = $this->filecount->getChildrenCountList('factory', $brand_id);
        foreach ($factory as $k => $v) {
            if ($factory_pic_count[$k]) {
                echo '<li class="first_tree">';
                echo "<p class='second_bg' onclick='factoryjia(this)' fid={$k}><i>{$v}</i><span class='mum'>(<font style='color:#ea1a14;'>{$factory_pic_count[$k]}</font>)</span></p>";
                echo "<ul id=serieslist_{$k}>";
                echo "</ul>";
                echo "</li>";
            }
        }
    }

    function doGetSeries() {
        $factory_id = intval($_GET['fid']);
        $this->series->fields = "series_id, series_name";
        $this->series->where = "factory_id='{$factory_id}' and state=3";
        $this->series->order = array('series_id' => 'asc');
        $series = $this->series->getResult(4);
        $series_pic_count = $this->filecount->getChildrenCountList('series', $factory_id);
        foreach ($series as $k => $v) {
            if ($series_pic_count[$k]) {
                echo "<li class=second_tree><a href='/image_searchlist_series_id_{$k}.html'><i>{$v}</i><span>(<font style='color:#ea1a14;'>{$series_pic_count[$k]}</font>)</span></a></li>";
            }
        }
    }

}

?>