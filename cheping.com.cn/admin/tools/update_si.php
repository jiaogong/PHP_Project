<?php

/**
 * update table' search_indext 
 * $Id: update_si.php 1621 2013-07-04 11:15:22Z yizhangdong $
 */
error_reporting(7);
set_time_limit(0);
require_once("../include/common.inc.php");

$brand_obj = new brand();
$fact_obj = new factory();
$si_obj = new searchIndex();
$uc = new updateCache();

$count = $uc->count(); //取总数
for ($i = 0; $i <= $count['model_id']; $i+=200) {
    $allmodel = $uc->getAllModel($i . ',200');
    if ($allmodel)
        foreach ($allmodel as $k => $v) {
            $si_obj->addIndex($v, true);
        }
}
#清除过期数据
$si_obj->where = "updated<'{$timestamp}' or updated is null";
$si_obj->limit = 1000;
$r = $si_obj->del();

if ($r) {
    echo "delete expired records ok<br>\n";
} else {
    echo "delete expired records err<br>\n";
}
?>
