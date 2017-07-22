<?php

include "../include/common_na.inc.php";
session_write_close();
set_time_limit(0);

if (PHP_SAPI == 'cli') {
    $opt = getopt('a:i:e:o:');
    $action = $opt['a'];
    $id = $opt['i'];
    $ext = $opt['e'];
} else {
    $action = $_GET['act'];
}

if ($action == 'countfile') {
    echo "start..<br>\n";
    $cfile = new fileCount();
    $cfile->countAll();
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
            "m.state=3 and m.series_id=s.series_id and s.factory_id=f.factory_id and f.brand_id=b.brand_id", array('b.brand_id' => 'desc'), 5000
    );
    $modelpic_dirpre = ATTACH_DIR . 'images/model/';
    $model_id = array();
    foreach ($allmodel as $k => $model) {
        $pic = $file_obj->getModelPic($model['model_id']);
        if (empty($pic) || !file_exists($modelpic_dirpre . $model['model_id'] . "/" . $pic['name'])) {
            array_push($model_id, $model['model_id']);
        }
    }
    $s = implode(',', $model_id);
    file_put_contents("nopic.txt", $s);
}
