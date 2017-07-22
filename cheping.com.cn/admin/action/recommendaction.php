<?php
class recommendAction extends action {
    function __construct() {
        parent::__construct();
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, 'sys_module', 211, 'A');                        
        $this->pageData = new pageData();
        $this->groupbuy = new groupbuy();
    }
    function doDefault() {
        $this->doList();
    }             
    function doShowRecommend() {  
        $tpl_name = 'ssi_cpindex_recommend';
        $condition = array(
            'name' => 'recommend',
            'c1'   => 'index',            
            'c2'   => 1,
            'c3'   => 0
        );
        $list = $this->pageData->getPageData($condition, 2);
        $j = 0;
        foreach($list as $l) {
            $j++;
            $cateInfo = unserialize($l['value']);        
            if(!empty($cateInfo)) {
                foreach($cateInfo['model'] as $k => $row) {
                    foreach($row as $kk => $rr) {
                        if(!$rr) unset($cateInfo['model'][$k][$kk]);
                    }
                }
                $m = $cateInfo['model']['m'];
                $b = $cateInfo['brand'];
                $s = $cateInfo['model']['s'];
                if(empty($m) || empty($b) || empty($s)) continue;
                
                $modelIdList = implode(',', $m);
                $brandIdList = implode(',', $b);
                $seriesIdList = implode(',', $s);                
                #var_dump($seriesIdList);
                $model = new model();
                $model->table_name = 'cardb_model';
                $model->fields = 'model_id, series_id, brand_name, series_name, model_name, model_pic1, model_pic2, model_price, bingo_price';
                $model->where = "model_id in ($modelIdList) ORDER BY find_in_set(model_id, '$modelIdList')";
                //车款数据
                $result = $model->getResult(2);
                $seriesId = array();
                if(!empty($result)) {
                    foreach($result as $k => $row) {
                        $modelPrice = $row['model_price'];
                        $bingoPrice = $row['bingo_price'];                                         
                        $result[$k]['offset'] = $modelPrice - $bingoPrice;       
                        $result[$k]['discount'] = $modelPrice ? round($bingoPrice / $modelPrice, 2) * 10 : '';
                    }
                    $modelInfo = array_chunk($result, 5);                    
                }
                #var_dump($modelInfo);
                $model->table_name = 'cardb_brand';
                $model->fields = 'brand_id, brand_name, brand_logo';
                $model->where = "brand_id in ($brandIdList)";
                //品牌数据
                $brandInfo = $model->getResult(2);
                //5.静态评测 6.动态评测 7.车型导购
                $articleType = array(5, 6, 7);
                $articleOrder = array(7 => 0, 5 => 1, 6 => 2);
                $sqlArr = array();
                foreach($articleType as $k => $type) {                                                                                           
                    $model->fields = "a.id, a.title, a.title2, a.created,c.channel_id AS typeid";
                    $model->tables = array(
                        'article' => 'a',
                        'cardb_article_series' => 'm',
                        'article_channel' => 'c',
                    );
                    $model->where = "a.id = m.article_id AND a.id=c.article_id AND a.state = 0 AND m.state = 0 AND
                    c.channel_id ={$type} AND m.series_id IN ({$seriesIdList}) ORDER BY a.created DESC LIMIT 6";
                    $sortArticle[$type] = $model->joinTable(2);
                }
                //var_dump($cateInfo);
                $this->tpl->assign('articleOrder', $articleOrder);                            
                $this->tpl->assign('modelInfo', $modelInfo);
                $this->tpl->assign('brandInfo', $brandInfo);
                $this->tpl->assign('articleInfo', $sortArticle);        
                $this->tpl->assign('condition', $cateInfo['condition']);
                $this->tpl->assign('rpic', $cateInfo['rpic']);
                $this->tpl->assign('price', $cateInfo['price']);
                $this->tpl->assign('url', $cateInfo['url']);
                $this->tpl->assign('ad', $cateInfo['model']['a']);
                $this->tpl->assign('nav', $cateInfo['model']['n']);
                $this->tpl->assign('id', $j);
                
                $html = $this->tpl->fetch($tpl_name);
                $fileName = '../ssi/ssi_cpindex_recommend'.$j.'.shtml';
                $length = file_put_contents($fileName, $html);
            }            
            if($length) echo 'OK';
        }    
    }
    function doList() {
        $tpl_name = 'recommend_list';
        $condition = array(
            'name' => 'recommend',
            'c1'   => 'index',            
            'c2'   => 1,
            'c3'   => 0
        );
        $list = $this->pageData->getPageData($condition, 2);
        foreach($list as $k => $row) {
            $value = unserialize($list[$k]['value']);
            $list[$k]['value'] = $value;
            $list[$k]['cate'] = $value['name'];
        }                 
        $this->tpl->assign('list', $list);
        $this->template($tpl_name);
    }
    function doDel() {
        $id = intval($_GET['id']);
        if($id) {
            $ufields = array('state' => 1);
            $where = "id = $id";
            $this->pageData->updatePageData($ufields, $where);
            $this->alert('删除成功！', 'js', 3, 'index.php?action=recommend');
        }
    }    
    function doEditRecommend() {
        $id = intval($_GET['id']) ? intval($_GET['id']) : intval($_POST['id']);
        $tpl_name = 'recommend_edit';
        $brand = new brand();
        $allbrand = $brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $this->tpl->assign('allbrand', $allbrand);

        $series_obj = new series();
        $model_obj = new cardbModel();
        
        $timestamp = time();
        $pgdata = array(          
            'name' => 'recommend',
            'c1'   => 'index',            
            'c2'   => 1,
            'c3'   => 0
        );              
        if(!empty($_POST)) {
            $recommend['name'] = strval($_POST['name']);
            for($i=1;$i<4;$i++) {
                $recommend['price'][$i] = strval($_POST['price'.$i]);
                $recommend['condition'][$i] = strval($_POST['condition'.$i]);
                $recommend['url'][$i] = strval($_POST['url'.$i]);                
            }   
            $recommend['rpic'] = $this->groupbuy->uploadPic('rpic', 'recommend/'.date('Ymd'));
            for($i=1;$i<9;$i++) {
                $recommend['brand'][$i] = intval($_POST['brand'.$i]);            
            }
            for($i=1;$i<16;$i++) {
                $recommend['model']['b'][$i] = intval($_POST['brand_id'.$i]);
                $recommend['model']['s'][$i] = intval($_POST['series_id'.$i]);                                
                $model_id = intval($_POST['model_id'.$i]);
                $recommend['model']['m'][$i] = $model_id;
                $recommend['model']['a'][$model_id] = strval($_POST['ad'.$i]);
                $recommend['model']['n'][$model_id] = intval($_POST['nav'.$i]);                
            }
            $pgdata['value'] = serialize($recommend);                 
        }
        
        if($id) {
            if(!empty($_POST)) {                   
                $pgdata['updated'] = $timestamp;                         
                $this->pageData->updatePageData($pgdata, "id=$id");
                $this->alert('数据成功保存！', 'js', 3, 'index.php?action=recommend');
            }
            else {
                $category = $this->pageData->getData($id);            
                $category['value'] = unserialize($category['value']);
                $category['cate'] = $category['value']['name'];
                //根据品牌取出车系  车系id去车款
                foreach ($category["value"]["model"]["b"] as $key => $value) {
                    
                    if($value>0){
                        //取出车系
                        $series = $series_obj->getAllSeries(
                                "(s.state=3 or s.state=11) and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.brand_id='$value'",
                                array('s.letter' => 'asc'),
                                100
                        );
                        #var_dump($series_obj->sql);exit;
                        $this->tpl->assign('series_' . $key, $series);

                        //取出车款
                        if($category["value"]["model"]["s"][$key]>0){
                            $model = $model_obj->getAllModel(
                                    "(m.state=3 or m.state=7 or m.state=8 or m.state=11) and m.series_id=s.series_id and s.factory_id=f.factory_id and f.brand_id=b.brand_id
                                     and m.series_id='{$category["value"]["model"]["s"][$key]}'",
                                    array(),
                                    100
                            );
                            $this->tpl->assign('model_' . $key, $model);
                        }

                    }
                    
                }

                $this->tpl->assign('category', $category);                                            
                $this->template($tpl_name);
            }
        }
        else {
            if(!empty($_POST)) {
                $pgdata['created'] = $timestamp;
                $pgdata['updated'] = $timestamp;
                $this->pageData->insertPageData($pgdata);                                     
                $this->alert('数据成功保存！', 'js', 3, 'index.php?action=recommend');
            }
            else {                                
                $this->template($tpl_name);
            }
        }        
    }
}
?>
