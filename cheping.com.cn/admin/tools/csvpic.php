<?php
/*
 * 抓取汽车之家实拍图，根据传入的品牌，车系，车款ID处理
 */

include '../include/common.inc.php';
$grabpic = new grabpicAction();
set_time_limit(0);

$barray = $sarray = $marray = array();

if (php_sapi_name() === 'cli') {
    $opt = getopt("b:m:s:a:o:");
    if ($opt['a'] === 'cli') {
        if ($opt['b']) {
            $barray = explode(',', $opt['b']);
        } elseif ($opt['s']) {
            $sarray = explode(',', $opt['s']);
        } elseif ($opt['m']) {
            $marray = explode(',', $opt['m']);
        }
        if(!empty($opt['o'])){
            $grabpic->overwrite = true;
        }
    } else {
        $barray = array(); //$barray = array('249','16','18','19','255');
        $sarray = array();
    }
}
$all = 0;
$message = "";
if ($marray) {
    $message = "model_id:" . implode(',', $marray);
    foreach ($marray as $mlist) {
        $grabpic->doPic('', '', $mlist);
    }
} else if ($sarray) {
    $message = "series_id:" . implode(',', $sarray);
    foreach ($sarray as $slist) {
        $grabpic->doPic('', $slist);
    }
} else if ($barray) {
    $message = "brand_id:" . implode(',', $barray);
    foreach ($barray as $blist) {
        $grabpic->doPic($blist);
    }
} else if ($all) {
    #$grabpic->doPic();
}

$message = date('Y/m/d H:i:s') . ":grab pic success!\n" . $message . "\n";
if($opt['a']!=='cli'){
    $message = nl2br($message);
}
echo $message;
?>
