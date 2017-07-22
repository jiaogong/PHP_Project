<?php

/**
 * $Id: staticaction.php 2109 2016-04-18 07:00:20Z wangchangjiang $
 */
set_time_limit(0);

class staticAction extends action {

    var $static;

    function __construct() {
        parent::__construct();
        $this->static = new cardbStatic();
        $this->article = new article();
        $this->cardbmodel = new cardbModel();
        $this->brand_obj = new brand();
        $this->pageData = new pageData();
        $this->series = new series();
        $this->pricelog = new cardbPriceLog();
        $this->cardbprice = new cardbPrice();
        $this->comment = new comment();
        $this->optlog = new optLog();
    }

    function doDefault() {
        $this->doList();
    }

    function doEdit() {
        $this->doAdd();
    }
    
    function doAutoTask() {
        $this->checkAuth(801, 'sys_module', 'A');

        $tpl_name = "static_tasklist";
        $this->page_title = "自动任务列表";

        $page = $this->getValue('page')->Int();
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        $list = $this->static->getAllStatic('type=5', array('id' => 'desc'), $page_size, $page_start);
        $page_bar = $this->multi($this->static->total, $page_size, $page, $_ENV['PHP_SELF'].'autotask');
        
        $this->vars('list', $list);
        $this->vars('page_bar', $page_bar);
        $this->template($tpl_name);
    }
    
    function doAdd() {
        $this->checkAuth(801, 'sys_module', 'A');

        $tpl_name = "static_add";
        $this->page_title = "添加静态化数据";

        if ($_POST) {
            $id = $this->postValue('id')->Int();
            $savepath = $this->postValue('savepath')->String();
            $savepath = str_replace('../', '', $savepath);
            $savepath = ltrim($savepath, '/');
            $filetype = $this->postValue('filetype')->Val();
            $type = $this->static->type[$filetype];
            $savepath = $type['path'] . $savepath;

            #检查文件名称是否在在
            $t = $this->static->getStaticByPath($savepath, $id);
            if ($t && $savepath) {
                $message = array(
                    'type' => 'js',
                    'message' => '文件名称已经存在，请返回修改！',
                    'act' => 2,
                );
                $this->alert($message);
            }

            $this->static->ufields = array(
                'name' => $this->postValue('name')->String(),
                'url' => $this->postValue('url')->String(),
                'savepath' => trim($savepath),
                'cron' => $this->postValue('cron')->String(),
                'type' => $this->postValue('filetype')->String(),
                'memo' => $this->postValue('memo')->String(),
                'updated' => $this->timestamp,
                'state' => $this->postValue('state')->Int(),
            );

            if ($this->postValue('id')->Int()) {
                $this->static->where = "id='{$this->postValue('id')->Int()}'";
                $ret = $this->static->update();
            } else {
                $this->static->ufields['created'] = $this->timestamp;
                $ret = $this->static->insert();
            }

            if ($ret) {
                $msg = "成功";
            } else {
                $msg = "失败";
            }
            $message = array(
                'type' => 'js',
                'message' => ($this->postValue('id')->Int() ? "修改" : "添加") . $msg,
                'act' => 3,
                'url' => $_ENV['PHP_SELF']
            );
            $this->alert($message);
        } else {
            $id = $this->getValue('id')->Int();
            if ($id) {
                $this->static->where = "id='{$id}'";
                $static = $this->static->getStatic($id);

                #$filename = pathinfo($static['savepath']);
                #$static['filename'] = $filename['basename');
                $filename = str_replace($this->static->type[$static['type']]['path'], '', $static['savepath']);
                $static['filename'] = $filename;
                $this->vars('static', $static);
            }

            $this->vars('type', $this->static->type);
            $this->template($tpl_name);
        }
    }

    function doMakeFile() {
        $id = $this->getValue('id')->Int();
        $static = $this->static->getStatic($id);
        if (empty($static['savepath'])) {
            $save_file = "";
        } else {
            $save_file = WWW_ROOT . $static['savepath'];
        }
        $ret = $this->action2File($static['url'] . '&rand=' . rand(10000, 99999), $save_file);
        if ($ret) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function doDel() {
        $this->checkAuth(801, 'sys_module', 'A');

        $id = $this->getValue('id')->Int();
        $this->static->where = "id='{$id}'";
        $ret = $this->static->del();
        if ($ret) {
            $msg = "成功";
        } else {
            $msg = "失败";
        }
        $message = array(
            'type' => 'js',
            'message' => "记录删除{$msg}",
            'act' => 3,
            'url' => $_ENV['PHP_SELF']
        );
        $this->alert($message);
    }

    function doList() {
        $this->checkAuth(801, 'sys_module', 'A');

        $tpl_name = "static_list";
        $this->page_title = "静态化数据列表";

        $page = $this->getValue('page')->Int();
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        $list = $this->static->getAllStatic('type<>5', array('id' => 'desc'), $page_size, $page_start);
        $page_bar = $this->multi($this->static->total, $page_size, $page, $_ENV['PHP_SELF']);

        $this->vars('list', $list);
        $this->vars('page_bar', $page_bar);
        $this->template($tpl_name);
    }
    /**
     * 添加首页轮播数据
     */
    function doFocus() {
        $this->checkAuth(209, 'sys_module', 'A');
        $fields = 'brand_id, letter, brand_name';
        $where = 'state = 3';
        $order = array('letter' => 'ASC');
        $brand = $this->brand_obj->getBrands($fields, $where, 2, $order);
        $this->vars('brand', $brand);

        $this->page_title = "首页轮播图片";
        $tpl_name = "cpindex_focus";
        $pageData = $this->pageData;
        $upload_obj = new uploadFile();
        $pic_num = 5;

        if ($_POST) {
            $ret = array();
            for ($i = 1, $j = 1; $i <= $pic_num; $i++) {
                $title = $_POST['name_' . $i];
                if (empty($title))
                    continue;
                #if($_FILES['pic_' . $i]['size'] == "" || $_POST['pic_h_'.$i] == "") continue;

                $title1 = $_POST['name1_' . $i];
                $cream = $_POST['cream_' . $i];
                $spot = $_POST['spot_' . $i];
                $link = $_POST['link_' . $i];
                $file = $_FILES['pic_' . $i];
                $brand = $_POST['brand_id_' . $i];
                $series = $_POST['series_id_' . $i];
                $model = $_POST['model_id_' . $i];

                $ret[$j] = array(
                    'title' => $title,
                    'title1' => $title1,
                    //'cream'=>$cream,
                    'spot' => $spot,
                    'link' => $link,
                    'model' => $model,
                    'brand' => $brand,
                    'series' => $series
                );

                if ($file['size']) {
                    $pic = $upload_obj->uploadAdPic($file);
                    $ret[$j]['pic'] = $pic;
                } else {
                    $ret[$j]['pic'] = $_POST['pic_h_' . $i];
                }
                $j++;
            }
            $s = $pageData->addPageData(array(
                'name' => 'focus',
                'value' => $ret,
                'c1' => 'index',
                'c2' => '1',
                'c3' => 0,
            ));
            if ($s) {
                $msg = "成功";
            } else {
                $msg = "失败";
            }
            $message = array(
                'type' => 'js',
                'message' => $this->page_title . $msg,
                'act' => 3,
                'url' => $_ENV['PHP_SELF'] . "focus"
            );
            $this->alert($message);
        } else {
            $result = $pageData->getPageData(
                    array(
                        'name' => 'focus',
                        'c1' => 'index',
                        'c2' => '1',
                        'c3' => 0,
                    )
            );
            $focus_val = unserialize($result['value']);
            if (empty($focus_val)) {
                $tmp = array_fill(1, $pic_num, array());
            } else {
                for ($i = 1; $i <= $pic_num; $i++) {
                    if (empty($focus_val[0][$i])) {
                        $tmp[$i] = array();
                    } else {
                        $tmp[$i] = $focus_val[0][$i];
                    }
                }
            }
            $this->vars('focus', $tmp);
            $this->vars('pic_num', $pic_num);
            $this->template($tpl_name);
        }
    }

    /**
     * 添加首页推荐轮播数据
     */
    function doRecommendFocus() {
        $this->checkAuth(209, 'sys_module', 'A');
        $fields = 'brand_id, letter, brand_name';
        $where = 'state = 3';
        $order = array('letter' => 'ASC');
        $brand = $this->brand_obj->getBrands($fields, $where, 2, $order);
        $this->vars('brand', $brand);

        $this->page_title = "首页推荐手动轮播图";
        $tpl_name = "cpindex_recommendfocus";
        $pageData = $this->pageData;
        $upload_obj = new uploadFile();
        $pic_num = 5;

        if ($_POST) {
            $ret = array();
            for ($i = 1; $i <= $pic_num; $i++) {
                if ($_FILES['pic_' . $i]['size'] == "" and $_POST['pic_h_' . $i] == "")
                    continue;
                $link = $_POST['link_' . $i];
                $title = $_POST['title' . $i];
                $file = $_FILES['pic_' . $i];
                $brand = $_POST['brand_id_' . $i];
                $series = $_POST['series_id_' . $i];
                $model = $_POST['model_id_' . $i];

                $ret[$i] = array(
                    'link' => $link,
                    'title' => $title,
                    'model' => $model,
                    'brand' => $brand,
                    'series' => $series
                );

                if ($file['size']) {
                    $pic = $upload_obj->uploadAdPic($file);
                    $ret[$i]['pic'] = $pic;
                } else {
                    $ret[$i]['pic'] = $_POST['pic_h_' . $i];
                }
            }
            $s = $pageData->addPageData(array(
                'name' => 'recommendfocus',
                'value' => $ret,
                'c1' => 'index',
                'c2' => '1',
                'c3' => 0,
            ));
            if ($s) {
                $msg = "成功";
            } else {
                $msg = "失败";
            }
            $message = array(
                'type' => 'js',
                'message' => $this->page_title . $msg,
                'act' => 3,
                'url' => $_ENV['PHP_SELF'] . "recommendfocus"
            );
            $this->alert($message);
        } else {
            $result = $pageData->getPageData(
                    array(
                        'name' => 'recommendfocus',
                        'c1' => 'index',
                        'c2' => '1',
                        'c3' => 0,
                    )
            );
            $focus_val = mb_unserialize($result['value']);
            if (empty($focus_val)) {
                $tmp = array_fill(1, $pic_num, array());
            } else {
                for ($i = 1; $i <= $pic_num; $i++) {
                    if (empty($focus_val[0][$i])) {
                        $tmp[$i] = array();
                    } else {
                        $tmp[$i] = $focus_val[0][$i];
                    }
                }
            }
            $this->vars('recommendfocus', $tmp);
            $this->vars('pic_num', $pic_num);
            $this->template($tpl_name);
        }
    }

    //产品库首页-新闻中心
    function doFootarticle() {
        $tplName = 'ssi_index_footarticle';
        /* 文章 */
        $fields = 'id, created, title, title2, category_id';
        $condition = "state = 3 and ";
        $order = ' order by created DESC limit 6';
//        $type = array(
//            2 => '车市动态',
//            5 => '静态评测',
//            6 => '车型导购',
//            7 => '动态评测',
//            12 => '行情促销'
//        );
//        $this->vars('type', $type);
        //评测导购
        $where = $condition . "category_id = 56" . $order;
        $article['dynamic'] = $this->article->getArticleFields($fields, $where, 2);
        //市场快报
        $where = $condition . "category_id = 55" . $order;
        $article['market'] = $this->article->getArticleFields($fields, $where, 2);
        $this->vars('article', $article);
        $this->template($tplName);
    }


    /**
     * 首品库首页-右侧底部（汽车图片）
     *
     */
    function doIndexComment() {
        $tpl_name = 'ssi_cpindex_comment';
        //$this->series = new series();
        $seriesArr = $this->series->getSeriesdata("series_id,IF(last_picid,last_picid,default_model) as default_modelid", "state=3", 2);
        $seriesA = array_rand($seriesArr, 20);
        array_unique($seriesA);
        shuffle($seriesA);
        $seriesB = array_slice($seriesA, 1, 6);
        $str = '';
        foreach ($seriesB as $key => $value) {
            $str .=$seriesArr[$value]['default_modelid'] . ',';
        }
        $str = rtrim($str, ',');

        $list = $this->series->getNewColorPic($str);
        $this->cardbmodel->limit = 3;
        $list = $this->cardbmodel->getSimp('model_id, series_id, model_pic1, series_name', "model_id in ($str) and state in (3,8)");
        $resultlist = array_slice($list, 0, 3);
        $this->vars('resultlist', $resultlist);
        $this->template($tpl_name);
    }
 
    function checkAuth($id, $module_type = 'sys_module', $type_value = "A") {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, $module_type, $id, 'A');
    }

}
?>

