<?php

include "../include/common_na.inc.php";
session_write_close();
set_time_limit(0);

if (PHP_SAPI == 'cli') {
    $opt = getopt('a:i:e:o:');
    $action = $opt['a'];
    $id = $opt['i'];
    $ext = $opt['e'];
    $o = $opt['o'];
    $stopchar = "\n";
} else {
    $action = $_GET['act'];
    $stopchar = "<br>\n";
}

if ($action == 'countfile') {
    echo "start..<br>\n";
    $cfile = new fileCount();
    $cfile->countAll($o);
    $cfile->countParent();
}
#
elseif ($action == 'brandcount') {
    $cfile = new fileCount();
    $bf = $cfile->getBrandCountList();

    var_dump($bf);
}
#
elseif ($action == "modelnopic") {
    $file_obj = new uploadFile();
    $model_obj = new cardbModel();
    $allmodel = $model_obj->getAllModel(
            "m.state in (3,8) and m.series_id=s.series_id and s.factory_id=f.factory_id and f.brand_id=b.brand_id", array('b.brand_id' => 'desc'), 5000
    );
    $modelpic_dirpre = ATTACH_DIR . 'images/model/';
    $model_id = $model_ida = array();
    #获取已经在抓取图片任务中的车款ID
    $piccollect = new cardbModelPicCollect();
    $piccollect->fields = "GROUP_CONCAT(model_id)";
    $piccollect->where = "state=1";
    #所有待抓取的车款ID，逗号相连的model_id
    $model_ids = $piccollect->getResult(3);
    if ($model_ids) {
        $model_ida = explode(',', $model_ids);
    }
    foreach ($allmodel as $k => $model) {
        #判断当前车款是否已经存在于抓取任务中，存在则跳过
        if (in_array($model['model_id'], $model_ida)) {
            continue;
        } else {
            $unionpic = 0;
            $pic = $file_obj->getModelPic($model['model_id']);
            if (empty($pic) || !file_exists($modelpic_dirpre . $model['model_id'] . "/" . $pic['name'])) {
                array_push($model_id, $model['model_id']);
            }else{
                $unionpic = 1;
            }
            $model_obj->ufields['unionpic'] = $unionpic;
            $model_obj->where = "model_id='{$model['model_id']}'";
            $model_obj->update();
        }
    }
    $s = implode(',', $model_id);
    file_put_contents("nopic.txt", $s);
}
#
elseif ($action == "grabmodelpic") {
    $grabpic = new grabpicAction();
    $piccollect = new cardbModelPicCollect();
    $piccollect->fields = "GROUP_CONCAT(model_id)";
    $piccollect->where = "state=1";
    #所有待抓取的车款ID，逗号相连的model_id
    $model_ids = $piccollect->getResult(3);
    #echo $model_ids . $stopchar;exit;

    if ($model_ids) {
        echo "prepare model id: {$model_ids}{$stopchar}";
        $marray = explode(',', $model_ids);
        foreach ($marray as $k => $model_id) {
            if (empty($model_id)) {
                continue;
            }
            #记录设置为正在采集状态
            $piccollect->ufields = array(
                'state' => 4,
                'collect_num' => 0,
                'author' => 'System Task',
            );
            $piccollect->where = "model_id='{$model_id}'";
            $piccollect->update();

            #删除该车款当前所有图片记录和图片文件
            $grabpic->overwrite = true;
            $total = $grabpic->doPic('', '', $model_id);
            if ($total[$model_id] > 0) {
                $state = 2;#成功
            } else {
                $state = 3;#没抓取到图片，失败
            }
            $piccollect->ufields = array(
                'state' => $state,
                'collect_num' => $total[$model_id],
            );
            $piccollect->where = "model_id='{$model_id}'";
            $piccollect->update();
            echo "download model pic[{$model_id}]: state= {$state}, total= {$total[$model_id]}{$stopchar}";
        }
    }else{
        echo "no model id{$stopchar}";
    }
}
#
elseif ($action == 'stopmodel') {
    $tt = '';
    if ($id) {
        $tt = "and s.series_id in ({$id})";
    }
    $series = new series();
    $catchdata = new CatchAutoCar();
    #$catchdata->getStopSell(1072);
    $allseries = $series->getAllSeries("s.state=3 and s.factory_id=f.factory_id and f.brand_id=b.brand_id {$tt}");
    foreach ($allseries as $k => $v) {
        $r = $catchdata->getStopSell($v['series_id']);
        if ($r) {
            echo "series:{$v['series_id']} - " . date('Y/m/d H:i:s') . "<br>\n" . var_export($r, true) . "<br>\n";
        }
    }
}
#检查外观文件与数据库记录的对应关系，以实际存在的文件修正数据。
#同时将外观文件更新到对应车款图片目录下，修正车款图片数据
elseif($action == 'fixstylepic'){
    $tt = '';
    if ($id) {
        $tt = "and s.series_id in ({$id})";
    }
    $series_pic_dir = ATTACH_DIR . "images/series/";
    $series_obj = new series();
    $model_obj = new cardbModel();
    $file_obj = new uploadFile();
    $allmodel = $model_obj->getAllModel(
        "m.state in (3,8) and m.series_id=s.series_id and s.factory_id=f.factory_id and f.brand_id=b.brand_id", array('b.brand_id' => 'desc'), 5000
    );
    $e_style = $e_stylepic = array();
    foreach ($allmodel as $k => $v) {
        $style = $file_obj->copyStylePic($v['series_id'], $v['model_id'], array('st4' => $v['st4'], 'st21' => $v['st21']), $v['date_id'], 0);
        $stylepic = $file_obj->copyStylePic($v['series_id'], $v['model_id'], array('st4' => $v['st4'], 'st21' => $v['st21']), $v['date_id'], 1);
        #白底图不存在
        if($style === false){
            $e_style[] = $v['model_id'];
        }
        #实拍图不存在
        if($stylepic === false){
            $e_stylepic[] = $v['model_id'];
        }
    }
    echo "no style model:" . var_export($e_style, true) . $stopchar;
    echo "no stylepic model:" . var_export($e_stylepic, true) . $stopchar;
}
#检查车款实拍图是否存在，不存在，则从车系复制图片到车款图目录
elseif($action == 'checkmodelpic1'){
    $log = "";
    $model_pic_dir = ATTACH_DIR . "images/model/";
    $series_pic_dir = ATTACH_DIR . "images/series/";
    $model_obj = new cardbModel();
    $file_obj = new uploadFile();
    $allmodel = $model_obj->getAllModel(
        "m.state in (3,8) and m.series_id=s.series_id and s.factory_id=f.factory_id and f.brand_id=b.brand_id", array('b.brand_id' => 'desc'), 8000
    );
    foreach ($allmodel as $k => $v) {
        $model_pic1 = $model_pic_dir . $v['model_id'] . "/" . $v['model_pic1'];
        $series_pic1 = $series_pic_dir . $v['series_id'] . "/" . $v['model_pic1'];
        if(!file_exists($model_pic1) && file_exists($series_pic1)){
            $series_pic1_dir = $series_pic_dir . $v['series_id'] . "/";
            $model_pic1_dir = $model_pic_dir . $v['model_id'] . "/";
            foreach ($file_obj->style_size as $kk => $size) {
                if(!file_exists($series_pic1_dir . $size . $v['model_pic1'])){
                    list($width, $height) = explode('x', $size);
                    imagemark::resize($series_pic1_dir . $v['model_pic1'], $size, $width, $height, '', $watermark_opt);
                    copy($series_pic1_dir . $size . $v['model_pic1'], $model_pic1_dir . $size . $v['model_pic1']);
                }else{
                    copy($series_pic1_dir . $size . $v['model_pic1'], $model_pic1_dir . $size . $v['model_pic1']);
                }
            }
            #复制原始图片到车款目录
            if($o){
                copy($series_pic1, $model_pic1);
            }
        }elseif(!file_exists($model_pic1) && !file_exists($series_pic1)){
            $log .= "model_id:{$v['model_id']} model_pic1:{$v['model_pic1']}\n";
        }
    }
    echo $log;
}
#delete stop sale model
elseif($action == 'checkstopmodel'){
    $stop_model = array();
    $stop_model_str = '';
    $stop_model_pic = 0;
    $model_pic_dir = ATTACH_DIR . "images/model/";
    $model_obj = new cardbModel();
    $file_obj = new uploadFile();
    $model_obj->fields = "count(*)";
    $model_obj->where = "state in (9,0,1,2,5,6,10,7)";
    $count = $model_obj->getResult(3);
    $step = ($count>1000) ? 1000 : 2;
    for($i=0,$j=0; $i<$count; $i+=$step,$j++){
        $model_obj->fields = "model_id";
        $model_obj->where = "state in (9,0,1,2,5,6,10,7)";
        $model_obj->order = array('model_id' => 'asc');
        $model_obj->limit = $step;
        $model_obj->offset = $j*$step;
        $allmodel = $model_obj->getResult(2);
        foreach ($allmodel as $k => $v) {
            $model_pic1 = $model_pic_dir . $v['model_id'];
            if(is_dir($model_pic1)){
                $stop_model_str .= $v['model_id'] . ",";
            }
            #删除图片表中的记录
            $file_obj->where = "type_name='model' and type_id='{$v['model_id']}'";
            $file_obj->fields = "count(*)";
            $file_count = $file_obj->getResult(3);
            $stop_model_pic += $file_count;
            #删除停产车款图片记录，同时删除其图片目录
            if($o){
                $file_obj->where = "type_name='model' and type_id='{$v['model_id']}'";
                $file_obj->limit = $file_count;
                $file_obj->del();
                #删除停产车款的图片目录
                $model_pic1 = realpath($model_pic1);
                if(is_dir($model_pic1)){
                    echo $model_pic1 . "<br>\n";
                    file::cleardir($model_pic1, true);
                    @rmdir($model_pic1);
                }
            }
        }
    }
    file_put_contents("stop_model.txt", substr($stop_model_str, 0, -1));
    echo "stopmodel pic total:" . $stop_model_pic . "<br>\n";
}
#
elseif($action == "test"){
    echo "test start:<br>\n";
    $grabpic = new grabpicAction();
    $grabpic->overwrite = true;
    $total = $grabpic->doPic('', '', 20894);
    echo var_export($total,true) . "<br>\n";
}