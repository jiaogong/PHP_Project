<?php

class bigpicAction extends action {

    function __construct() {
        parent::__construct();
        $this->models = new models();
        $this->cardbfile = new cardbFile();
        $this->cardbcolor = new color();
        $this->series = new series();
        $this->piclimit = 4;
        $this->vars('garage', 'garage');
    }

    function doDefault() {
        $seriesId = intval($_GET['sid']);
        if ($seriesId) {
            $idInfo[0] = $this->series->getSeriesdata('default_model', "series_id = $seriesId", 3);
        } else {
            $idInfo = explode('-', $_GET['id']);
            $this->vars('modelId', $idInfo[0]);
        }

        if (!isset($idInfo[1]))
            $idInfo[1] = '111111111';
        $nowId = max(0, $idInfo['3']);
        if (empty($idInfo[0])) {
            $modelOne = $this->cardbfile->getSomeCF('type_id', "type_name='model' and ppos<900", '', array('s1' => 'asc'), 1);
            // $modelOne = $this->models->getModel('model_id', 'state=3', 1, array('series_id' => 'asc'), 1);
            $idInfo[0] = $modelOne['type_id'];
        }

        $count1 = $count2 = $count3 = $count4 = array('count' => 0);

        $seriesInfo = $this->models->getModel('series_id,brand_name,factory_name,series_name,model_name,brand_id', "model_id={$idInfo[0]}", 1, array(), 1);
        
        $modelInfo = $this->cardbfile->getPicAndModel($seriesInfo['series_id']);
        $colorInfo = $this->cardbfile->getSomeCF('pic_color', "type_name='model' and type_id={$idInfo[0]} and ppos<900", 'pic_color', array('id' => 'asc'), 2);
        if ($colorInfo) {
            foreach ($colorInfo as $cikey => $cilist) {
                if ($cilist['pic_color']) {
                    $colorInfoTemp = $this->cardbcolor->getSomeC('id', "type_name='model' and type_id={$idInfo[0]} and color_name='{$cilist['pic_color']}'", '', array(), 1);
                    $colorInfo[$cikey]['id'] = $colorInfoTemp['id'];
                } else {
                    $colorInfo[$cikey]['pic_color'] = '无颜色';
                    $colorInfo[$cikey]['id'] = 0;
                }
            }
        } else {
            $colorInfo = array(array('id' => '0', 'pic_color' => '无颜色'));
            $colorId = '';
            $idInfo[1] = 0;
        }
        if (empty($idInfo[1]) && isset($idInfo[2]) && isset($idInfo[3])) {
            // $colorInfo = array(array('id' => '#', 'pic_color' => '无颜色'));
            $colorId = '';
            $idInfo[1] = 0;
        } else {
            if ($idInfo[1] == '111111111') {
                $idInfo[1] = $colorInfo[0]['id'];
                $colorId = $colorInfo[0]['pic_color'];
            } else {
                $tempColor = $this->cardbcolor->getColor($idInfo[1]);
                if ($tempColor) {
                    $colorId = $tempColor['color_name'];
                    $idInfo[1] = $tempColor['id'];
                } else {
                    $colorId = $colorInfo[0]['id'];
                    $idInfo[1] = $colorInfo[0]['pic_color'];
                }
            }
        }
        if (empty($idInfo[2]))
            $idInfo[2] = 1;
        if (empty($idInfo[1])) {
            $color_where = " and (pic_color='' or pic_color is null)";
        } else {
            if ($colorId) {
                $color_where = " and pic_color='{$colorId}' ";
            } else {
                $color_where = " and (pic_color='' or pic_color is null)";
            }
        }
        $colorPic = $this->cardbfile->getSomeCFLimit('name,id,type_id,ppos,pos', "type_name='model' and type_id={$idInfo[0]} {$color_where} and pos={$idInfo[2]} and ppos<900", '', array('id' => 'asc'), 0, 2);
        //判断最后一页，是否有空缺，如果有，用下一分类图片填充
        $colorPic_count = count($colorPic);
        if ($colorPic_count < 4) {
            $next_pic_count = 4 - $colorPic_count % 4;
            $pos_arr = array(1, 4, 2, 3);
            $pos_id = array_search($idInfo[2], $pos_arr);

            $next_pos = $pos_id < 3 ? $pos_arr[$pos_id + 1] : 0;
            $prev_pos = $pos_id > 0 ? $pos_arr[$pos_id - 1] : 0;
            $this->vars('next_pos', $next_pos);
            $this->vars('prev_pos', $prev_pos);

            if (!empty($next_pos)) {
                $next_colorPic = $this->cardbfile->getSomeCFLimit('name,id,type_id,ppos,pos', "type_name='model' and type_id={$idInfo[0]} and pic_color='$colorId' and pos={$next_pos}", '', array('id' => 'asc'), $next_pic_count, 2);
            }
            if (!empty($colorPic) && !empty($next_colorPic))
                $colorPic = array_merge($colorPic, $next_colorPic);
//            #var_dump($colorPic);
        }

        if ($nowId == 0)
            $nowId = $colorPic[0]['id'];

        #统计车身外观
        $count1 = $this->cardbfile->getSomeCF('count(*) count', "type_id={$idInfo[0]} {$color_where} and pos=1 and ppos<900", '', array(), 1);
        #统计中控方向盘
        $count2 = $this->cardbfile->getSomeCF('count(*) count', "type_id={$idInfo[0]} {$color_where} and pos=4 and ppos<900", '', array(), 1);
        #统计车厢座椅
        $count3 = $this->cardbfile->getSomeCF('count(*) count', "type_id={$idInfo[0]} {$color_where} and pos=2 and ppos<900", '', array(), 1);
        #统计其他细节
        $count4 = $this->cardbfile->getSomeCF('count(*) count', "type_id={$idInfo[0]} {$color_where} and pos=3 and ppos<900", '', array(), 1);

        if (empty($idInfo[3]))
            $idInfo[3] = $colorPic[0]['name'];
        else {
            $getSomeCFTemp = $this->cardbfile->getSomeCF('name,id,type_id', "id={$idInfo[3]} and ppos<900", '', '', 1);
            $idInfo[3] = $getSomeCFTemp['name'];
        }

        #竞争对手
        global $_cache, $attach_server;
        $competeSeriesId = $_cache->getCache('competeseries' . $seriesInfo['series_id']);
        if ($competeSeriesId) {
            $competeArray = $competeSeriesId;
        } else {
            if ($seriesInfo['series_id']) {
                $competeInfo = $this->models->getModel('compete_id', "state=3 and series_id={$seriesInfo['series_id']}", 2, array(), 100);
                $competeArray = array();
                $tempCompete = array();
                if ($competeInfo) {
                    foreach ($competeInfo as $cikey => $cilist) {
                        if (count($tempCompete) >= 5)
                            break;
                        $competeInfo = explode(',', trim($cilist['compete_id'], ','));
                        // $competeInfo = array(array('compete_id' => 11334),array('compete_id' => 12840));
                        if (!empty($competeInfo[0])) {
                            foreach ($competeInfo as $cikey2 => $cilist2) {
                                if (count($tempCompete) >= 5)
                                    break;
                                $competeSeriesPic = $this->cardbfile->getPicAndSeries($cilist2);
                                if ($competeSeriesPic && !in_array($competeSeriesPic['s1'], $tempCompete)) {
                                    $tempCompete[] = $competeSeriesPic['s1'];
                                    $competeArray[] = $competeSeriesPic;
                                }
                            }
                        }
                    }
                    $_cache->writeCache('competeseries' . $seriesInfo['series_id'], $competeArray, 7 * 24 * 60 * 60);
                }
                // $competeInfo['compete_id'] = '10953,10954,13290,12867';
            }
        }
//        var_dump($modelId);die;
        $page_title = "$seriesInfo[model_name]图片_$seriesInfo[brand_name]_汽车图片-ams车评网";
        $keywords = "$seriesInfo[model_name]图片,$seriesInfo[brand_name]车身外观实拍图片";
        $description = "ams车评网为您提供$seriesInfo[brand_name]$seriesInfo[model_name]图片，车身外观实拍图片等精彩图片内容，更多精彩图片尽在ams车评网";
        $this->tpl->assign('title', $page_title);
        $this->tpl->assign('keyword', $keywords);
        $this->tpl->assign('description', $description);

        $this->vars('idInfo', $idInfo[0]);

        $this->vars('modelinfo', $modelInfo);
        $this->vars('seriesinfo', $seriesInfo);
        $this->vars('modelid', $modelId);
        $this->vars('colorinfo', $colorInfo);
        $this->vars('colorpic', $colorPic);
        $this->vars('idinfo', $idInfo);
        $this->vars('countinfo', array($count1['count'], $count2['count'], $count3['count'], $count4['count']));
        $this->vars('nowid', $nowId);
        $this->vars('competearray', $competeArray);

        $this->vars('js', array('global','jquery-1.8.3.min','bigpic','jquery.lazyload'));
        $this->vars('css', array('comm', 'base', 'ckdt', 'jquery.autocomplete', 'newbase', 'common'));
        if ($attach_server[0]) {
            $this->replace = array(
                'href="/attach/images/model' => 'href="' . $attach_server[0] . '/model'
            );
        }
        $this->template('bigpic', '', 'replaceNewsChannel');
    }

    function doGetJson() {
        #list($model_id, $color_id, $pos_id, $size) = explode('-', $_GET['id']);
        $model_id = intval($_GET['mid']);
        $pic_pos = intval($_GET['pos']);
        $pic_ppos = intval($_GET['ppos']);
        if (empty($pic_id) || empty($pic_pos))
            return false;

        $pos_arr = array(1, 4, 2, 3);
        $pos_id = array_search($pic_pos, $pos_arr);
        $next_pos_id += $pos_id;
        //越界
        if ($next_pos_id > 3)
            return false;
        else
            $next_pos = $pos_arr[$next_pos_id];

        @preg_match('/([\x{4e00}-\x{9fa5}]*)/siu', $_GET['color'], $colors);
        $pic_color = $colors[1];

        $pic = $this->cardbfile->getPicRow("type_name='model' and type_id='{$model_id}' and pic_color='{$pic_color}' and pos='{$pic_pos}' and ppos>'{$pic_ppos}'", array('ppos' => 'asc'));

        //如果同颜色，同分类下，没有图，取下一分类
        if (!$pic['id']) {
            $pic = $this->cardbfile->getPicRow("type_name='model' and type_id='{$model_id}' and pic_color='{$pic_color}' and pos='{$next_pos}'", array('ppos' => 'asc'));
        }

        //如果不为空
        $ret = array();
        if (!empty($pic['id'])) {
            $ret = array(
                'id' => $pic['id'],
                'name' => $pic['name'],
                'type_id' => $pic['type_id'],
                'pos' => $pic['pos'],
                'ppos' => $pic['ppos'],
                'pic_color' => $pic['pic_color'],
            );
            echo json_encode($ret);
        }
        echo json_encode($ret);
        exit;
    }

}

?>