<?php

/*
 * 抓取易车商城数据
 * 
 * @author David Shaw <tudibao@163.com>
 * $Id
 */

class grabYicheAction extends action {

    var $gc;
    var $gyc;
    var $yc_brand;
    var $yc_factory;
    var $yc_series;
    var $yc_model;
    var $brand;
    var $factory;
    var $series;
    var $model;
    function __construct() {
        parent::__construct();
        $this->gc = new grabyichemall();
        $this->gyc = new grabYiCheCar();
        $this->yc_brand = new yicheBrand();
        $this->yc_factory = new yicheFactory();
        $this->yc_series = new yicheSeries();
        $this->yc_model = new yicheModel();
        $this->brand = new brand();
        $this->factory = new factory();
        $this->series = new series();
        $this->model = new cardbModel();
    }

    function doDefault() {
        $this->doIndex();
    }

    function doIndex() {
        $this->template('grab_yichemall');
    }
    
    /**
     * 抓取易车商城数据
     */
    function doGrabMall() {
        set_time_limit(0);
        ob_implicit_flush();
        
        $yiche_url = unescape($_GET['url']);
        #echo $yiche_url;
        echo "准备分析链接……<hr><br>\n";
        $this->gc->setStartPage($yiche_url);
        $this->gc->setVerbose();
        $this->gc->getPageList();
        
        echo "<hr><br>报告：" . "<br>\n";
        echo "总页数：" . $this->gc->grab_result['total_page'] . "<br>\n";
        echo "共采集车款：" . ($this->gc->grab_result['insert'] + $this->gc->grab_result['update']) . "<br>\n";
        echo "新入库车款：" . $this->gc->grab_result['insert'] . "<br>\n";
        echo "更新已有车款：" . $this->gc->grab_result['update'] . "<br>\n";
        echo "失败车款（数值仅参考）：" . $this->gc->grab_result['error'] . "<br>\n";
        echo "采集数据总用时（秒）:" . ($this->gc->grab_result['end_time'] - $this->gc->grab_result['start_time']) . "<br>\n";
        echo "<script>parent.document.getElementById('bn').disabled=false;</script>";
        ob_implicit_flush(FALSE);
    }
    
    function doYicheTree(){
        $this->template('grab_yichetree');
    }
    
    function doGrabTree(){
        set_time_limit(0);
        ob_implicit_flush();
        
        $type = $type_id = '';
        $url = unescape($_GET['url']);
        $yiche_tree_url = "http://car.bitauto.com/tree_chexing";
        
        #检查链接是否合法
        if(strpos($url, $yiche_tree_url) === FALSE){
            die("采集的链接不正确(1)！\n");
        }
        
        preg_match('/mb_(\d+)/si', $url, $match);
        #检查是否为品牌
        if($match[1]){
            $type = "brand";
            $type_id = $match[1];
        }
        #检查是否为车系
        preg_match('/sb_(\d+)/si', $url, $match);
        if($match[1]){
            $type = "series";
            $type_id = $match[1];
        }
        
        #输出采集到的品牌、厂商、车系、车款等相关信息
        $this->gyc->debug = true; 
        
        #开始采集易车产品树的数据，并入库
        $this->gyc->grabYicheModels($type, $type_id);
        echo "<script>parent.document.getElementById('bn').disabled=false;</script>";
        ob_implicit_flush(FALSE);
    }
    
    function doBrand(){
        $bc_brand_list = $this->brand->getAllBrand('state=3');
        $list = $this->yc_brand->getList();
        
        $this->vars('bc_brand', $bc_brand_list);
        $this->vars('list', $list);
        $this->template('yc_brand');
    }
    
    function doUpdateBrand(){
        $args = filter_input_array(INPUT_GET, array(
            'yid' => FILTER_SANITIZE_NUMBER_INT,
            'bid' => FILTER_SANITIZE_NUMBER_INT,
        ));
        
        $ret = array('code' => 0);
        #冰狗品牌
        $bc_brand = $this->brand->getBrand($args['bid']);
        if(!$bc_brand['brand_id']){
            $ret['msg'] = iconv('gbk', 'utf-8', '指定的冰狗品牌不存在！');
            echo json_encode($ret);
            exit;
        }
        #易车品牌
        $yc_brand = $this->yc_brand->getBrand($args['yid']);
        if(!$yc_brand['id']){
            $ret['msg'] = iconv('gbk', 'utf-8', '指定的易车品牌不存在！');
            echo json_encode($ret);
            exit;
        }
        #更新易车品牌表
        $this->yc_brand->ufields = array(
            'brand_id' => $bc_brand['brand_id'],
            'brand_name' => $bc_brand['brand_name'],
            'state' => 3,
        );
        $this->yc_brand->where = "id='{$args['yid']}'";
        $r = $this->yc_brand->update();
        if($r){
            $ret['msg'] = iconv('gbk', 'utf-8', '易车品牌更新成功，刷新以显示更新后的内容！');
            $ret['code'] = 1;
        }else{
            $ret['msg'] = iconv('gbk', 'utf-8', '易车品牌更新失败！');
        }
        echo json_encode($ret);
        exit;
    }
    
    function doFactory(){
        $list = $this->yc_factory->getList();
        $bc_factory = $this->factory->getAllFactory('f.brand_id=b.brand_id and b.state=3 and f.state=3');
        
        $this->vars('bc_factory', $bc_factory);
        $this->vars('list', $list);
        $this->template('yc_factory');
    }
    
    /**
     * 
     */
    function doGetYcFactory(){
        $bid = intval($_GET['bid']);
        $yc_factory_json = $this->yc_factory->getListByBid($bid);
        die($yc_factory_json);
    }
    
    /**
     * 更新易车厂商表
     */
    function doUpdateFactory(){
        $args = filter_input_array(INPUT_GET, array(
            'yid' => FILTER_SANITIZE_NUMBER_INT,
            'bid' => FILTER_SANITIZE_NUMBER_INT,
        ));
        
        $ret = array('code' => 0);

        #冰狗厂商数据
        $bc_factory = $this->factory->getFactory($args['bid']);
        if(!$bc_factory['factory_id']){
            $ret['msg'] = iconv('gbk', 'utf-8', '指定的冰狗厂商不存在！');
            echo json_encode($ret);
            exit;
        }
        #易车厂商
        $yc_factory = $this->yc_factory->getFactory($args['yid']);
        if(!$yc_factory['id']){
            $ret['msg'] = iconv('gbk', 'utf-8', '指定的易车厂商不存在！');
            echo json_encode($ret);
            exit;
        }
        #更新易车厂商表
        $this->yc_factory->ufields = array(
            'factory_id' => $bc_factory['factory_id'],
            'factory_name' => $bc_factory['factory_name'],
            'state' => 3,
        );
        $this->yc_factory->where = "id='{$args['yid']}'";
        $r = $this->yc_factory->update();
        if($r){
            $ret['msg'] = iconv('gbk', 'utf-8', '易车厂商更新成功，刷新以显示更新后的内容！');
            $ret['code'] = 1;
        }else{
            $ret['msg'] = iconv('gbk', 'utf-8', '易车厂商更新失败！');
        }
        echo json_encode($ret);
        exit;
    }
    
    function doSeries(){
        $args = filter_input_array(INPUT_GET, array(
            'page' => FILTER_SANITIZE_NUMBER_INT,
            'fid' => FILTER_SANITIZE_NUMBER_INT,
        ));
        $fid = $args['fid'];
        $page = max($args['page'], 1);
        $page_size = 30;
        $limit = $page_size;
        $offset = ($page-1)*$page_size;
        $where = $args['fid'] ? "yc_fid='{$fid}'" : '';
        $extra = 'series&fid=' . $fid ;
        $list = $this->yc_series->getList($where, $limit, $offset);
        #echo "d:"  . $this->yc_series->total;
        $page_bar = $this->multi($this->yc_series->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);
        
        $yc_brand = $this->yc_brand->getList();
        $bc_brand_fact = $this->factory->getAllFactory('f.brand_id=b.brand_id and f.state=3 and b.state=3');
        
        $this->tpl->assign('yc_brand', $yc_brand);
        $this->tpl->assign('bc_brand_fact', $bc_brand_fact);
        $this->tpl->assign('page_bar', $page_bar);
        $this->vars('list', $list);
        $this->template('yc_series');
    }
    
    function doGetSeries(){
        $fid = intval($_GET['fid']);
        $bc_series = $this->series->getAllSeries(
                "s.factory_id='{$fid}' and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.state=3 and b.state=3 and f.state=3"
                );
        #var_dump($bc_series);
        $json = array();
        foreach ($bc_series as $k => $v) {
            $json[] = array(
                'series_id' => $v['series_id'],
                'series_name' => iconv('gbk', 'utf-8', $v['series_name']),
            );
        }
        die(json_encode($json));
    }
    
    function doGetYcSeries(){
        $fid = intval($_GET['fid']);
        $yc_series = $this->yc_series->getList("yc_fid='{$fid}'", 2000);
        $json = array();
        foreach ($yc_series as $k => $v) {
            $json[] = array(
                'id' => $v['id'],
                'yc_sid' => $v['yc_sid'],
                'yc_seriesname' => $v['yc_seriesname'],
            );
        }
        die(json_encode($json));
    }
    
    function doUpdateSeries(){
        $sid = intval($_GET['sid']);
        $yid = intval($_GET['yid']);
        
        $bc_series = $this->series->getSeries($sid);
        $yc_series = $this->yc_series->getSeries($yid);
        if($bc_series['series_name'] && $yc_series['id']){
            #更新易车车系表数据
            $this->yc_series->ufields = array(
                'series_id' => $bc_series['series_id'],
                'series_name' => $bc_series['series_name'],
                'state' => 3,
            );
            $this->yc_series->where = "id='{$yc_series['id']}'";
            $yc_s = $this->yc_series->update();
            #更新易车厂商
            $this->yc_factory->ufields = array(
                'factory_id' => $bc_series['factory_id'],
                'factory_name' => $bc_series['factory_name'],
                'state' => 3,
            );
            $this->yc_factory->where = "yc_factoryname='{$yc_series['yc_factoryname']}'";
            $yc_f = $this->yc_factory->update();
            #echo $this->yc_factory->sql;
            #更新易车品牌
            $this->yc_brand->ufields = array(
                'brand_id' => $bc_series['brand_id'],
                'brand_name' => $bc_series['brand_name'],
                'state' => 3,
            );
            $this->yc_brand->where = "yc_brandname='{$yc_series['yc_brandname']}'";
            $yc_b = $this->yc_brand->update();
            $ret['msg'] = iconv('gbk', 'utf-8', '易车车系信息更新成功，刷新以显示更新后的内容！');
            $ret['code'] = 1;
        }else{
            $ret['msg'] = iconv('gbk', 'utf-8', '车系信息更新失败，所选冰狗车或易车系信息可能不存在！');
        }
        die(json_encode($ret));
    }
    
    function doModel(){
        $args = filter_input_array(INPUT_GET, array(
            'page' => FILTER_SANITIZE_NUMBER_INT,
            'sid' => FILTER_SANITIZE_NUMBER_INT,
        ));
        $page = max($args['page'], 1);
        $page_size = 30;
        $limit = $page_size;
        $offset = ($page-1)*$page_size;
        $where = $args['sid'] ? "yc_sid='{$args['sid']}'" : '';
        $extra = 'model&sid=' . $args['sid'] ;
        $list = $this->yc_model->getList($where, $limit, $offset);
        #echo "d:"  . $this->yc_series->total;
        $page_bar = $this->multi($this->yc_model->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);
        
        $yc_brand = $this->yc_brand->getList();
        $bc_brand_fact = $this->factory->getAllFactory('f.brand_id=b.brand_id and f.state=3 and b.state=3');
        
        $this->tpl->assign('yc_brand', $yc_brand);
        $this->tpl->assign('bc_brand_fact', $bc_brand_fact);
        $this->tpl->assign('page_bar', $page_bar);
        $this->vars('list', $list);
        $this->template('yc_model');
    }
    
    /**
     * 根据车系ID返回冰狗车款列表
     * Ajax调用，返回JSON格式数组
     */
    function doGetModel(){
        $sid = intval($_GET['sid']);
        $bc_model = $this->model->getModelBySid($sid);
        $json = array();
        foreach ($bc_model as $k => $v) {
            $json[] = array(
                'model_id' => $k,
                'model_name' => iconv('gbk', 'utf-8', $v['model_name']),
            );
        }
        die(json_encode($json));
    }
    
    /**
     * 更新车款信息
     * Ajax调用
     */
    function doUpdateModel(){
        $yid = intval($_GET['yid']);
        $mid = intval($_GET['mid']);
        
        $yc_model = $this->yc_model->getModel($yid);
        $bc_model = $this->model->getModel($mid);
        if($yc_model['id'] && $bc_model['model_id']){
            #更新易车车款表数据
            $this->yc_model->ufields = array(
                'model_id' => $bc_model['model_id'],
                'model_name' => $bc_model['model_name'],
                'state' => 3,
            );
            $this->yc_model->where = "id='{$yc_model['id']}'";
            $yc_m = $this->yc_model->update();
            #更新易车车系表数据
            $this->yc_series->ufields = array(
                'series_id' => $bc_model['series_id'],
                'series_name' => $bc_model['series_name'],
                'state' => 3,
            );
            $this->yc_series->where = "id='{$yc_model['id']}'";
            $yc_s = $this->yc_series->update();
            #更新易车厂商
            $this->yc_factory->ufields = array(
                'factory_id' => $bc_model['factory_id'],
                'factory_name' => $bc_model['factory_name'],
                'state' => 3,
            );
            $this->yc_factory->where = "yc_factoryname='{$yc_model['yc_factoryname']}'";
            $yc_f = $this->yc_factory->update();
            #echo $this->yc_factory->sql;
            #更新易车品牌
            $this->yc_brand->ufields = array(
                'brand_id' => $bc_model['brand_id'],
                'brand_name' => $bc_model['brand_name'],
                'state' => 3,
            );
            $this->yc_brand->where = "yc_brandname='{$yc_model['yc_brandname']}'";
            $yc_b = $this->yc_brand->update();
            $ret['msg'] = iconv('gbk', 'utf-8', '易车车款信息更新成功，刷新以显示更新后的内容！');
            $ret['code'] = 1;
        }else{
            $ret['msg'] = iconv('gbk', 'utf-8', '车款信息更新失败，所选冰狗车或易车款信息可能不存在！');
        }
        die(json_encode($ret));
    }
    
    /**
     * 测试用例
     */
    function doTest() {
        ob_implicit_flush();
        #http://www.yichemall.com/car/detail/2750
        #2750
        #2014款 2.4L 自动 舒适版（颜色齐全）
        #$productlist = $this->gc->getModelUrlList(2750, '2014款 2.4L 自动 舒适版（颜色齐全）');
        #var_dump($productlist);
//        if(1)
//        $this->gc->anazyGoodsPage("http://www.yichemall.com/car/detail/c_106386_2014%E6%AC%BE%202.4L%20%E8%87%AA%E5%8A%A8%20%E7%B2%BE%E8%8B%B1%E7%89%88%EF%BC%88%E9%A2%9C%E8%89%B2%E9%BD%90%E5%85%A8%EF%BC%89/");
//        else{
//        $this->gc->anazyGoodsPage("http://www.yichemall.com/car/detail/3650");
//        $this->gc->otherModelData(3650);
//        }
        echo "test<br>\n";
        $letterBrnad = $this->gyc->grabYicheModels(3999);
        #var_export($letterBrnad);
        ob_implicit_flush(FALSE);
    }

}
