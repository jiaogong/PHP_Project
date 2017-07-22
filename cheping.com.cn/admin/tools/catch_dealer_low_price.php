<?php

include '../include/common.inc.php';
include SITE_ROOT . 'lib/webclient.class.php';
include SITE_ROOT . 'model/catchdata.php';

set_time_limit(0);
$model = new cardbModel();
$catchData = new CatchData();
$county = new County();
$dealer = new dealer();
$pricelog = new cardbPriceLog();
$cardbprice = new cardbprice();
$brand = new brand();

$b = $_GET['b'];
if($b){
    $brands = $brand->getBrandlist("brand_id","state=3 and brand_name='{$b}'",1);
    $ids = $model->chkSelect('src_id, model_id, series_id, factory_name,series_name,model_name', "state in(3,8) and brand_id='{$brands['brand_id']}'", 2); //10
}else{
    $ids = $model->chkModel('src_id, model_id, series_id, factory_name,series_name,model_name', 'state in(3,8)', array('model_id' => 'desc'), '2', 20); //10
}

//抓取的汽车之家报价
$priceType = 5;
$splitNum = 20;
$cgbaojia = 0;
$sbbaojia = 0;
$sbjingxiaoshang = array();
$xzjxs = array();
$xzbj = 0;
foreach (array_chunk($ids, $splitNum) as $row) {
    foreach ($row as $key => $value) {
        $id = $value['src_id'];
        if (!$id)
            continue;
        $modelId = $value['model_id'];
        $seriesId = $value['series_id'];
        $province = '北京';
        $city = '北京';
        $url = "http://dealer.autohome.com.cn/frame/spec/$id/110000/110100/0/1/1/5?isPage=0&source=defalut&kindId=1";
        $catchData->catchResult($url);
//        $price = $catchData->pregMatch('/<span class="font22">(.*?)<\/span>/sim', 0); //取价格最低三条//
        $price = $catchData->pregMatch('%class="font22" target="_blank">\s+([\d\.]+)\s+</a>%', 0);
        if ($price[1]) {
            $price = array_slice($price[1], 0, 3);
            $cgbaojia++;
        } else {
            $sbbaojia++;
            $sbjingxiaoshang[$value['model_name']] = $value['series_name'];
            continue;
        }
//        $dealer_alias = $catchData->pregMatch('%href="http://dealer\.autohome\.com\.cn/(\d+)/spec_(\d+)[^"]+"\s+data-location="[^"]+" target="_blank">\s+(\S+)\s+<\/a>%', 0); //取经销商别名    
        $dealer_alias = $catchData->pregMatch('%\[4S[^\]]+\] </span>\s*(\S+)%', 0);
        if ($dealer_alias[1]) {
            $dealername = array_slice($dealer_alias[1], 0, 3);
        } else {
            continue;
        }
        if (empty($dealername)) {
            continue;
        } else {
            $cardbprice->where = "model_id='$modelId'";
            $cardbprice->del();
            foreach ($dealername as $key => $value) {
                $dealer_id = $dealer->getDealer("dealer_id,dealer_name,dealer_alias,dealer_area,src_id", 'dealer_alias LIKE "' . iconv('gbk', 'utf-8', $value) . '%" AND state=2');
                if (empty($dealer_id[0]['dealer_id'])) {
                    //                    $catchData->catchResult("http://dealer.autohome.com.cn/$dealerid[$key]");
                    $dealer_addr = $catchData->pregMatch('/<div class="dd-tx">\s+<div title="([^"]+)/', 1); //取经销商地址 
                    $receiver['dealer_name'] = iconv('gbk', 'utf-8', $value);
                    $receiver['dealer_alias'] = iconv('gbk', 'utf-8', $value);
                    $receiver['dealer_area'] = iconv('gbk', 'utf-8', $dealer_addr[1]);
                    $receiver['src_id'] = $id;
                    $receiver['state'] = 2;
                    $res = $dealer->addDealer($receiver);
                    if ($res) {
                        $xzjxs[] = iconv('gbk', 'utf-8', $value);
                        $receiver = array();
                        $receiver['model_id'] = $modelId;
                        $receiver['series_id'] = $seriesId;
                        $receiver['price_type'] = $priceType;
                        $receiver['price'] = $price[$key];
                        $receiver['dealer_id'] = $res;
                        $receiver['dealer_name'] = trim(iconv('gbk', 'utf-8', $value));
                        $receiver['dealer_addr'] = trim(iconv('gbk', 'utf-8', $dealer_addr[1]));
                        $receiver['province'] = $province;
                        $receiver['city'] = $city;
                        $src = $cardbprice->addPrice($receiver);
                        if ($src) {
                            $xzbj++;
                        }
                    }
                } else {
                    $receiver = array();
                    if ($dealer_id[0]['src_id'] == 0) {
                        $receivers['src_id'] = $id;
                        $dealer->editDealer($receivers, $dealer_id[0]['dealer_id']);
                    }
                    $receiver['model_id'] = $modelId;
                    $receiver['series_id'] = $seriesId;
                    $receiver['price_type'] = $priceType;
                    $receiver['price'] = $price[$key];
                    $receiver['dealer_id'] = trim($dealer_id[0]['dealer_id']);
                    $receiver['dealer_name'] = trim($dealer_id[0]['dealer_name']);
                    $receiver['dealer_addr'] = trim($dealer_id[0]['dealer_area']);
                    $receiver['province'] = $province;
                    $receiver['city'] = $city;
                    $src = $cardbprice->addPrice($receiver);
                    if ($src) {
                        $xzbj++;
                    }
                }
            }
        }
    }
}
echo '抓取结束';
echo '<br />';
echo '成功抓取报价' . $cgbaojia;
echo '<br />';
echo '失败抓取报价' . $sbbaojia;
echo '<br />';
echo '失败抓取经销商' . count($sbjingxiaoshang);
echo '<br />';
echo '入库经销商' . count($xzjxs);
echo '<br />';
echo '入库报价' . $xzbj;
echo '<br />';
$mulu = '抓取失败经销商目录:<br />';
if ($sbjingxiaoshang)
    foreach ($sbjingxiaoshang as $key => $value) {
        $mulu .= $key . ':' . $value . '<br />';
    }
echo $mulu;
?>
