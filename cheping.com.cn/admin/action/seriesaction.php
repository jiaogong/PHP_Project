<?php

/**
 * series action
 * $Id: seriesaction.php 3173 2016-06-23 04:05:05Z wangchangjiang $
 * @author David.Shaw
 */
class seriesAction extends action {

    var $factory;
    var $brand;
    var $series;
    var $model;
    var $cartype;
    var $upload;

    function __construct() {
        parent::__construct();
        $this->factory = new factory();
        $this->brand = new brand();
        $this->series = new series();
        $this->model = new cardbModel();
        $this->cartype = new cardbType();
        $this->upload = new uploadFile();
    }

    function doDefault() {
        $this->doList();
    }

    function doSeriesAttention() {
        import('webclient.class', 'lib');
        $surl = $this->getValue('surl')->Url();
        $sname = $this->getValue('sname')->String();
        $catchData = new CatchData();
        $catchData->catchResult($surl);
        #$catchData->result = iconv('gbk', 'utf-8', $catchData->result);
        $attentionMatches = $catchData->pregMatch('%<a href="/spec/[\d]+/#pvareaid=[\d]+">([^<]+)</a>%si');
        $attentionMatches1 = $catchData->pregMatch('/<div class="attention">\s+<span class="attention-value" style="width: ([\d]+)%;"><\/span>\s+<\/div>/si');
        #var_dump($attentionMatches1[1]);exit;
        if (!empty($attentionMatches) && !empty($attentionMatches1)) {

            $cardbModel = new cardbModel();
            $checkSeriesname = $cardbModel->chkModel('model_name', "series_name='$sname' AND state in (3, 7, 8)", '', 2);
            $checkSeriesname_arr = $attentionMatches1_arr = array();
            foreach($checkSeriesname as $ks=>$v){
                $checkSeriesname_arr[$ks]= $v['model_name'];
            }
            foreach($attentionMatches1[1] as $ks=>$v){
                $attentionMatches1_arr[$ks]= (int)$v;
            }
            $xxflag = 0;
            $a = '';
            foreach($attentionMatches[1] as $k => $v){
                $model_name = iconv('gbk', 'utf-8', $v);
                if (in_array($model_name,$checkSeriesname_arr)) {
                    $attentionMatches1 = $attentionMatches1_arr[$k];
                    $where = "model_name = '$model_name' AND series_name = '$sname' AND state in (3, 7, 8)";
                    $ufields = array('views' => $attentionMatches1);
                    $cardbModel->updateModel($ufields, $where);
                    $xxflag += 1;
                }
            }
            if (!$xxflag) {
                echo 2;
                exit;
            }else{
                echo 1;
                exit;
            }
        } else
            echo 0;
    }

    function doList() {
        $template_name = "series_list";
        $this->page_title = "车系列表";
        $extra = $brand_id = $factory_id = $keyword = $rkeyword = null;

        $page = $this->getValue('page')->Int();
        $father_id = $this->getValue('fatherId')->Int();
        $extra = "&fatherId={$father_id}";

        $this->checkAuth($father_id, 'factory');

        $brand_id = $this->requestValue('brand_id')->Int();
        $factory_id = $this->requestValue('factory_id')->Int();
        $keyword = $this->requestValue('keyword')->UrlDecode();
        $rkeyword = $keyword = $this->addValue($keyword)->stripHtml(1);

        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $where = "s.state in (3) and s.brand_id=b.brand_id and f.factory_id=s.factory_id" . ($father_id ? " and s.factory_id='{$father_id}'" : "");
        if ($factory_id) {
            $where .= " and s.brand_id='{$brand_id}' and s.factory_id='{$factory_id}'";
            $extra .= "&brand_id={$brand_id}&factory_id={$factory_id}";

            $factory_list = $this->factory->getAllFactory("f.brand_id=b.brand_id and f.brand_id='{$brand_id}'", array('f.letter' => 'asc'), 100);

            $this->vars('factory_list', $factory_list);
            $this->vars('factory_id', $factory_id);
        }
        if ($keyword) {
            $where .= " and s.series_name like '%{$keyword}%'";
            $extra .= "&keyword={$rkeyword}";
        }

        $list = $this->series->getAllSeries($where, array('s.letter' => 'asc'), $page_size, $page_start);
        $page_bar = $this->multi($this->series->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);

        $brand_list = $this->brand->getAllBrand("state=3", array('letter' => 'asc'), 300);

        $this->vars('page_title', $this->page_title);
        $this->vars('list', $list);
        $this->vars('brand_list', $brand_list);
        $this->vars('page_bar', $page_bar);
        $this->vars('brand_id', $brand_id);
        $this->vars('fatherId', $father_id);
        $this->vars('keyword', $keyword);
        $this->vars('rkeyword', $rkeyword);
        $this->template($template_name);
    }

    function doAdd() {
        global $series_df_state;
        $template_name = "series_add";
        $this->page_title = "新建车系";

        if ($_POST) {
            $fatherId = $this->postValue('fatherId')->Int();
            $arr_id = $this->postValue('service_id')->Val();
            if ($arr_id) {
                foreach ($arr_id as $kk => $vv) {
                    if ($this->postValue('series_id' . $vv)->Int() > 0) {
                        $compete_id .=$this->postValue('series_id' . $vv)->Int() . ',';
                    }
                }
                $compete_id = rtrim($compete_id, ',');
            }
            if ($fatherId) {
                $factory = $this->factory->getFactory($fatherId);
                $brand_name = $factory['brand_name'];
                $brand_id = $factory['brand_id'];
                $factory_name = $factory['factory_name'];
                $factory_id = $factory['factory_id'];
            } else {
                $brand_name = $this->postValue('brand_name')->String();
                $brand_id = $this->postValue('brand_id')->Int();
                $factory_name = $this->postValue('factory_name')->String();
                $factory_id = $this->postValue('factory_id')->Int();
            }
            $series_name = $this->postValue('series_name')->String();
            $series_alias = $this->postValue('series_alias')->String();
            $series_memo = $this->postValue('series_memo')->String();
            $keyword = $this->postValue('keyword')->String();
            $allowance = $this->postValue('allowance')->String();
            $price_range = $this->postValue('price_range')->Float();
            $type_id = $this->postValue('type_id')->Int();
            $saled = $this->postValue('saled')->Int();
            $sale_date = $this->postValue('sale_date')->Int();
            $sale_value = $this->postValue('sale_value')->Val();
            $offical_url = $this->postValue('offical_url')->Url();
            $default_model = $this->postValue('default_model')->Int();
            $white_img_alt = $this->postValue('white_img_alt')->String();
            $background_img_alt = $this->postValue('background_img_alt')->String();
            $series_img_alt = $this->postValue('series_img_alt')->String();
            #$compete_id = $this->postValue('compete_id')->String();

            if ($price_range) {
                list($price_low, $pice_high) = explode('-', $price_range);
            }
            $file = $_FILES['series_pic'];
            $file2 = $_FILES['series_pic2'];

            $this->series->ufields = array(
                'series_name' => $series_name,
                'series_alias' => $series_alias,
                'series_memo' => $series_memo,
                'brand_id' => $brand_id,
                'brand_name' => $brand_name,
                'factory_id' => $factory_id,
                'factory_name' => $factory_name,
                'keyword' => $keyword,
                'allowance' => $allowance,
                's1' => $this->postValue('s1')->Val(),
                's2' => $this->postValue('s2')->Val(),
                's3' => $this->postValue('s3')->Val(),
                'price_low' => $price_low,
                'price_high' => $pice_high,
                'sale_date' => $sale_date,
                'sale_value' => $sale_value,
                'offical_url' => $offical_url,
                'default_model' => $default_model,
                'compete_id' => $compete_id,
                'white_img_alt' => $white_img_alt,
                'background_img_alt' => $background_img_alt,
                'series_img_alt' => $series_img_alt
            );
            $full_pinyin = $this->postValue('full_pinyin')->String();
            if ($full_pinyin) {
                $this->series->ufields['full_pinyin'] = $full_pinyin;
            } else {
                $this->series->ufields['full_pinyin'] = util::Pinyin($brand_name, 2);
            }
            $short_pinyin = $this->postValue('short_pinyin')->En();
            if ($short_pinyin) {
                $this->series->ufields['short_pinyin'] = $short_pinyin;
            } else {
                $this->series->ufields['short_pinyin'] = util::Pinyin($brand_name, 3);
            }

            if ($type_id) {
                $series_id = $this->postValue('series_id')->Int();
                $cartype = $this->cartype->getType($type_id);
                $this->series->ufields['type_id'] = $type_id;
                $this->series->ufields['type_name'] = $cartype['type_name'];
                $ufields = array(
                    'type_id' => $type_id,
                    'type_name' => $cartype['type_name'],
                    'series_id' => $series_id,
                    'series_name' => $series_name
                );
                $where = "series_id = '$series_id'";
                $this->model->updateModel($ufields, $where);
            }

            #未上市
            if (!$saled) {
                $this->series->ufields['state'] = 10;
            }
            #上市车，判断config中的设定状态
            elseif ($series_df_state) {
                $this->series->ufields['state'] = $series_df_state;
            } else {
                #保存草稿
                if ($this->postValue('toconfirm')->Val() == '保存数据') {
                    $this->series->ufields['state'] = 1;
                }
                #待审核
                else {
                    $this->series->ufields['state'] = 2;
                }
            }
            $series_id = $this->postValue('series_id')->Int();
            if ($series_id) {
                $this->checkAuth($series_id, 'series');

                if ($file['size']) {
                    $file['series_id'] = $series_id;
                    $r = $this->upload->uploadSeriesFoucsPic($file);
                    if ($r) {
                        $this->series->ufields['series_pic'] = $r;
                    }
                }

                if ($file2['size']) {
                    $file2['series_id'] = $series_id;
                    $r = $this->upload->uploadIndexFoucsPic($file2);
                    if ($r) {
                        $this->series->ufields['series_pic2'] = $r;
                    }
                }

                #begin 外观图
                $style = $this->model->getStyleRange($series_id);
                $tmp = $ida = $idb = $idc = array();
                
                #准备删除无用的车系外观ID
                $style_obj = new seriesStyle();
                $style_condition = "series_id='{$series_id}'";
                #当前车系下已经存在的全部外观ID
                $ida = $style_obj->getStyleId($style_condition);
                
                foreach ($style as $k => $v) {
                    $v['st4_id'] = array_search($v['st4'], $this->series->st4_list);
                    $v['st21_id'] = array_search($v['st21'], $this->series->st21_list);
                    $v['id'] = $v['st4_id'] . "_" . $v['st21_id'] . '_' . $v['date_id'];
                    $tmp['style_pic_' . $v['id']] = array(
                        'st4' => $v['st4_id'],
                        'st21' => $v['st21_id'],
                        'date_id' => $v['date_id'],
                    );
                    $tmp2['stylepic_' . $v['id']] = array(
                        'st4' => $v['st4_id'],
                        'st21' => $v['st21_id'],
                        'date_id' => $v['date_id'],
                    );
                    $style_condition .= " and (st4='{$v['st4_id']}' and st21='{$v['st21_id']}' and date='{$v['date_id']}')";
                }
                #当前该车系下正常的外观ID
                $idb = $style_obj->getStyleId($style_condition);
                #无用的车系外观ID，要删除的数据
                $idc = array_diff($ida, $idb);
                if($idc){
                    $style_obj->where = "id in (". implode(',', $idc) .")";
                    $style_obj->limit = count($idc);
                    $style_obj->del();
                }
                #结束外观ID删除
                
                foreach ($_FILES as $k => $v) {
                    if (preg_match('/^style_pic_/', $k) && $v['size']) {
                        $file = $_FILES[$k];
                        $file['series_id'] = $series_id;
                        $file['st4'] = $tmp[$k]['st4'];
                        $file['st4_str'] = $this->series->st4_list[$file['st4']];
                        $file['st21'] = $tmp[$k]['st21'];
                        $file['date_id'] = $tmp[$k]['date_id'];
                        $file['st21_str'] = $this->series->st21_list[$file['st21']];
                        
                        if ($file['st4'] && $file['st21'] && $file['date_id']) {
                            $sr = $this->upload->uploadStylePic($file);
                        }
                    }
                }
                foreach ($_FILES as $k => $v) {
                    if (preg_match('/^stylepic_/', $k) && $v['size']) {
                        $file = $_FILES[$k];
                        $file['series_id'] = $series_id;
                        $file['st4'] = $tmp2[$k]['st4'];
                        $file['st4_str'] = $this->series->st4_list[$file['st4']];
                        $file['st21'] = $tmp2[$k]['st21'];
                        $file['date_id'] = $tmp2[$k]['date_id'];
                        $file['st21_str'] = $this->series->st21_list[$file['st21']];

                        if ($file['st4'] && $file['st21'] && $file['date_id']) {
                            $sr = $this->upload->uploadStylePic($file, 2);
                        }
                    }
                }
                #end 外观图
                #实拍车款ID
                $this->series->ufields['last_picid'] = $this->postValue('last_picid')->Int();
                $this->series->ufields['updated'] = $this->timestamp;
                $this->series->where = "series_id='{$series_id}'";
                $ret = $this->series->update();
                if ($ret) {
                    $msg = "成功";
                } else {
                    $msg = "失败";
                }
                $this->alert("修改车系信息{$msg}!", 'js', 3, $_ENV['PHP_SELF'] . "&fatherId=" . $fatherId);
            } else {
                $this->checkAuth(801, 'sys_module');

                $this->series->ufields['brand_name'] = $brand_name;
                $this->series->ufields['brand_id'] = $brand_id;
                $this->series->ufields['factory_name'] = $factory_name;
                $this->series->ufields['factory_id'] = $factory_id;
                $this->series->ufields['created'] = $this->timestamp;
                $this->series->ufields['updated'] = $this->timestamp;
                $ret = $this->series->insert();

                if ($ret) {
                    if ($file['size']) {
                        $file['series_id'] = $ret;
                        $r = $this->upload->uploadSeriesFoucsPic($file);
                        if ($r) {
                            $this->series->ufields['series_pic'] = $r;
                        }
                        $r = $this->series->where = "series_id='{$ret}'";
                        $ret = $this->series->update();
                    }
                    $msg = "成功";
                } else {
                    $msg = "失败";
                }
                $this->alert("新建车系{$msg}!", 'js', 4, $_ENV['PHP_SELF']);
            }
        } else {
            $cartype = $this->cartype->getAllType();
            $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);

            if ($this->getValue('series_id')->Int()) {
                $series_id = $this->getValue('series_id')->Int();
                $this->checkAuth($series_id, 'series');
                //处理竞争车款
                $compete_id = $this->series->getSeriesdata("compete_id", "series_id='{$series_id}' and state in(3,8)", 3);
                if ($compete_id) {
                    foreach (explode(',', $compete_id) as $vvv) {
                        $compete_arr[] = $this->series->getSeriesdata("brand_id,factory_id,series_id,brand_name,factory_name,series_name", "series_id='{$vvv}' and state in(3,8)", 2);
                    }
                }
                if ($compete_arr) {
                    foreach ($compete_arr as $keyy => &$vvv) {
                        foreach ($vvv as $keyyy => $vvvv) {
                            $vvv[factory] = $this->series->getSeriesdata("series_id,series_name", "factory_id='{$vvvv[factory_id]}' and state=3", 2);
                            $vvv[brand] = $this->factory->getFactorylist("factory_id,factory_name", "brand_id='{$vvvv[brand_id]}' and state in(3,8)", 2);
                        }
                    }
                }
                $this->vars('compete_arr', $compete_arr);
                #外观图
                $style = $this->model->getStyleRange($series_id);
                $tmp = array();
                foreach ($style as $k => $v) {
                    $v['st4_id'] = array_search($v['st4'], $this->series->st4_list);
                    $v['st21_id'] = array_search($v['st21'], $this->series->st21_list);
                    $v['id'] = $v['st4_id'] . "_" . $v['st21_id'] . '_' . $v['date_id'];

                    $ptemp = $this->upload->getOneUploadFile("type_name='stylepic' and type_id='$series_id' and pos='{$v['st4_id']}' and ppos='{$v['st21_id']}' and s1='{$v['date_id']}'", 1);
                    $p = $this->upload->getStylePic($series_id, $v['st4_id'], $v['st21_id'], $v['date_id']);
                    if (!empty($p)) {
                        $v['crpic'] = base64_encode("images/series/{$series_id}/{$p['name']}");
                    }
                    $tmp[] = $v;
                    unset($v['crpic']);
                    if (!empty($ptemp)) {
                        $v['crpic'] = base64_encode("images/series/{$series_id}/{$ptemp['name']}");
                    }
                    $tmp2[] = $v;
                }
                $this->vars('style', $tmp);
                $this->vars('stylepic', $tmp2);
                $this->vars('st4', $this->series->st4_list);
                $this->vars('st21', $this->series->st21_list);
                #外观图
                #有实拍图的车款
                $this->model->group = '';
                $pic_model = $this->model->getSimpleModel(
                        "series_id='{$series_id}' and state in(3,8) and unionpic=1", 50
                );
                $this->vars('pic_model', $pic_model);
                #有实拍图的车款
                #车系默认车款
                $default_model = $this->model->getSimpleModel(
                        "series_id='{$series_id}' and state in(3,8)", 50
                );
                $this->vars('default_model', $default_model);

                $series = $this->series->getSeries($series_id);
                $this->vars('series', $series);

                $factory = $this->factory->getFactory($series['factory_id']);
                $this->vars('factory', $factory);
                $this->vars('fatherId', $factory['factory_id']);
            } else {
                $fatherid = $this->getValue('fatherId')->Int();
                if ($fatherid) {
                    $this->checkAuth($fatherid, 'factory');
                    $factory = $this->factory->getFactory($fatherid);
                    $this->vars('factory', $factory);
                    $this->vars('fatherId', $fatherid);
                }
            }
            $this->checkAuth(801, 'sys_module');
            $this->vars('cartype', $cartype);
            $this->vars('brand', $brand);
        }
        //调用车系
        $chkModel = $this->model->chkModel("model_name,model_id", "series_id='{$series_id}' and state in (3,8)", 2);
        $this->vars('chkModel', $chkModel);
        $this->template($template_name);
    }

    function doEdit() {
        $this->doAdd();
    }

    function doCompleModel() {
        $model_id = $this->getValue('model_id')->Int();
        //$compeltArr = $this->model->getCompeteModel($model_id);
        //$compeltid = implode($compeltArr,",");
        $compeltid = $this->model->chkModel("compete_id", "model_id='{$model_id}'  and state in (3,8)", '', 3);


        $modellist = $this->model->chkModel("brand_name,factory_name,series_name,model_name,model_id", "model_id in({$compeltid}) and state in (3,8)", 2);
        foreach ($modellist as $key => $value) {
            $modellist[$key]['brand_name'] = iconv('gbk', 'utf-8', $value['brand_name']);
            $modellist[$key]['factory_name'] = iconv('gbk', 'utf-8', $value['factory_name']);
            $modellist[$key]['series_name'] = iconv('gbk', 'utf-8', $value['series_name']);
            $modellist[$key]['model_name'] = iconv('gbk', 'utf-8', $value['model_name']);
        }

        //var_dump($modellist);
        echo json_encode($modellist);
    }

    /**
     * 显示车款竞争车款      
     */
    function doAddCompleModel() {
        $series_id = $this->getValue('series_id')->Int();
        $modellist = $this->model->chkModel("model_id", "series_id='{$series_id}' and state in (3,8)", 2);
        $i = 0;
        if ($modellist&&is_array($modellist)) {
            foreach ($modellist as $key => $value) {
                $compeltArrs = $this->model->getCompeteModel($value['model_id']);
                if (is_array($compeltArrs)) {
                    $compeltArr = array_slice($compeltArrs, 0, 5);
                    $compeltid = implode($compeltArr, ',');
                    $this->model->ufields = array("compete_id" => $compeltid);
                    $this->model->where = "model_id='{$value[model_id]}'";
                    $id = $this->model->update();
                    if ($id) {
                        $i++;
                    }
                }
            }
        }

        if (count($modellist) == $i) {
            echo json_encode("ok");
        } else {
            echo $i;
        }
    }

    function doDel() {
        $id = $this->getValue('series_id')->Int();
        $this->checkAuth($id, 'series');

        $this->series->ufields = array(
            'state' => 0
        );

        $this->series->where = "series_id='{$id}'";
        $ret = $this->series->update();
        if ($ret) {
            #删除车系下的车款
            $model_obj = new cardbModel();
            $model_obj->where = "series_id='{$id}'";
            $model_obj->ufields = array(
                'state' => 0,
            );
            $r = $model_obj->update();
            $msg = "成功";
        } else {
            $msg = "失败";
        }
        $this->alert("车系删除{$msg}!", 'js', 3, $_ENV['PHP_SELF']);
    }

    function doJson() {
        $state = $this->getValue('state')->Int();
        if($state == 3){
            $state = "s.state=3";
        }else{
            $state = "s.state";
        }
        $type = $this->getValue('t')->En();
        if ($type == 'brand') {
            $id = $this->getValue('brand_id')->Int();
            $list = $this->series->getAllSeries(
                    "{$state} and s.factory_id=f.factory_id and f.brand_id=b.brand_id and b.brand_id='{$id}' and s.state in(3,8)", array('s.letter' => 'asc'), 100
            );
        } else {
            $id = $this->getValue('factory_id')->Int();
            $list = $this->series->getAllSeries(
                    "{$state} and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.factory_id='{$id}' and s.state in(3,8)", array('s.letter' => 'asc'), 100
            );
        }
        $ret = array();
        foreach ($list as $key => $value) {
            $ret[] = array(
                'series_id' => $value['series_id'],
                'series_alias' =>  $value['series_alias'],
                'series_name' =>  $value['series_name'],
                'factory_name' => $value['factory_name']
            );
        }

        echo json_encode($ret);
    }

    function doAllStateJson() {
        $type = $this->getValue('t')->En();
        if ($type == 'brand') {
            $id = $this->getValue('brand_id')->Int();
            $list = $this->series->getAllSeries(
                "s.factory_id=f.factory_id and f.brand_id=b.brand_id and b.brand_id='{$id}' and s.state in(3,8,9,11)", array('s.letter' => 'asc'), 100
            );
        } else {
            $id = $this->getValue('factory_id')->Int();
            $list = $this->series->getAllSeries(
                "s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.factory_id='{$id}' and s.state in(3,8,9,11)", array('s.letter' => 'asc'), 100
            );
        }
        $ret = array();
        foreach ($list as $key => $value) {
            $ret[] = array(
                'series_id' => $value['series_id'],
                'series_alias' =>  $value['series_alias'],
                'series_name' =>  $value['series_name'],
                'factory_name' => $value['factory_name']
            );
        }

        echo json_encode($ret);
    }

    /**
     * 根据厂商id取有暗访价的车系
     */
    function doJsonPrice() {
        $id = $this->getValue('factory_id')->Int();
        $list = $this->series->getSeriesPrice($id);
        $ret = array();
        foreach ($list as $key => $value) {
            $ret[] = array(
                'series_id' => $value['series_id'],
//                'series_alias' => iconv('gbk', 'utf-8', $value['series_alias']),
//                'series_name' => iconv('gbk', 'utf-8', $value['series_name']),
//                'factory_name' => iconv('gbk', 'utf-8', $value['factory_name'])
                'series_alias' => $value['series_alias'],
                'series_name' => $value['series_name'],
                'factory_name' => $value['factory_name']
            );
        }
        echo json_encode($ret);
    }

    /**
     * 显示年份的车系名称
     * 
     */
    function doYJson() {
        $id = $this->getValue('factory_id')->Int();
        $this->checkAuth($id, 'factory');
        $model_obj = new cardbModel();
        $tmp = $model_obj->getAllModel(
                "m.factory_id='{$id}' and m.series_id=s.series_id and s.factory_id=f.factory_id and f.brand_id=b.brand_id and m.state=3", array('m.date_id' => 'desc'), 200
        );
        #var_dump($tmp);
        $ret = array();
        foreach ($tmp as $k => $v) {
            $ak = $v['series_id'] . "_" . $v['date_id'];
            if (!array_key_exists($ak, $ret)) {
                $ret[$ak] = $v;
            }
        }
        unset($tmp);
        foreach ($ret as $k => $v) {
            list($sid, $year) = explode('_', $k);
            $tmp[$sid][$year] = array(
                'series_id' => $v['series_id'],
                'factory_id' => $v['factory_id'],
                'brand_id' => $v['brand_id'],
                'series_name' => iconv('gbk', 'utf-8', $v['series_name']),
                'factory_name' => iconv('gbk', 'utf-8', $v['factory_name']),
                'brand_name' => iconv('gbk', 'utf-8', $v['brand_name']),
                'date_id' => $v['date_id'],
            );
        }
        echo json_encode($tmp);
    }

    /**
     * 输出品牌对应车系JS
     */
    function doJs() {
        #要求有产品完全权限，可操作此功能
        $this->checkAuth(10, 'sys_module');

        $model = new cardbModel();
        $model->fields = "brand_id,brand_name,series_id,series_name, date_id";
        $list = $model->getSimpleModel(
                'state=3', 5000, 0, array('series_id' => 'asc', 'date_id' => 'desc')
        );

        $ret = array();
        foreach ($list as $key => $value) {
            $value['series_name'] = iconv('gbk', 'utf-8', $value['series_name']);
            if (
                    !array_key_exists($value['brand_id'], $ret) ||
                    !array_key_exists($value['date_id'], $ret[$value['brand_id']]) ||
                    !in_array(array($value['series_id'], $value['series_name']), $ret[$value['brand_id']][$value['date_id']])
            ) {
                $ret[$value['brand_id']][$value['date_id']][] = array($value['series_id'], $value['series_name']);
            }
        }

        $tmp = array();
        foreach ($ret as $key => $value) {
            krsort($value);
            $tmp[$key] = $value;
        }
        echo "var series_arr=" . json_encode($tmp) . ";";
    }

    //输出车系对应的车款
    function doJsmodels() {
        #要求有产品完全权限，可操作此功能
        $this->checkAuth(10, 'sys_module');

        $model = new cardbModel();
        $model->tables = array("cardb_series" => "cs", "cardb_model" => "cm");
        $model->fields = "cm.model_id,cm.model_name,cm.brand_id,cm.brand_name,cm.series_id,cm.series_name, cm.date_id,cs.last_picid";
        $list = $model->getSimpleModels(
                'cm.state=3 and cm.series_id=cs.series_id', 5000, 0, array('series_id' => 'asc', 'date_id' => 'desc'), array('cardb_series' => 'cs', 'cardb_model' => 'cm')
        );
        $ret = array();
        $file = new cardbFile();
        foreach ($list as $key => $value) {
            $value['model_name'] = iconv('gbk', 'utf-8', $this->series->getModelname($value['model_name']));
            if (
                    !array_key_exists($value['date_id'], $ret) ||
                    !array_key_exists($value['series_id'], $ret[$value['date_id']]) ||
                    !in_array(array($value['model_id'], $value['model_name']), $ret[$value['date_id']][$value['series_id']])
            ) {
                //取出车款图片
                $result = $file->getModelPic($value['model_id']);
                if (empty($result)) {
                    $result = $file->getModelPic($value['last_picid']);
                }
                $ret[$value['date_id']][$value['series_id']][] = array($value['model_id'], $value['model_name'], $result["name"], $result["type_id"]);
            }
        }

        #sort
        $tmp = array();
        foreach ($ret as $key => $value) {
            krsort($value);
            $tmp[$key] = $value;
        }
        echo "var models_arr=" . json_encode($tmp) . ";";
    }

    function doUnionPic() {
        $id = $this->getValue('series_id')->Int();
        $this->checkAuth($id, 'series');

        $pic_obj = new uploadFile();
        $pic_obj->unionSeriesPic($id);
    }

    function doRPriceRange() {
        $id = $this->getValue('series_id')->Int();
        $this->checkAuth($id, 'series');
        $model_obj = new cardbModel();
        $model_obj->where = "series_id='{$id}' and (state=3 or state=7 or state=8) and model_price>0";
        $price_range = $model_obj->getPriceRange();
        echo json_encode($price_range);
    }

    /**
     * 获取车系下车款参数值
     * cardb_model field 排量 st27 变速箱简称 st2
     * cardb_series field s1 s2 
     */
    function doRParam() {
        $id = $this->getValue('series_id')->Int();
        $st_id = $this->getValue('st')->Int();
        $this->checkAuth($id, 'series');
        $model_obj = new cardbModel();
        $s_model = $model_obj->getSimpleModel("state in (3,8) and series_id='{$id}'", 100);

        $a = $t = array();
        foreach ($s_model as $k => $v) {
            if (rtrim($v['st28']) == '涡轮增压' && $st_id == 27) {
                $key = $v[('st' . $st_id)] . 'T';
            } else {
                $key = $v['st' . $st_id];
            }
            $t[$key] = 1;
        }
        $t = array_keys($t);
        echo json_encode($t);
    }

    function doPic() {
        $id = $this->getValue('series_id')->Int();
        $type = $this->getValue('type')->String();
        $this->checkAuth($id, 'series');
        $series = $this->series->getSeries($id);
        $series_pic = 'images/series/' . $series['series_id'] . '/' . ($type ? $series['series_pic2'] : $series['series_pic']);
        if (!file_exists(ATTACH_DIR . $series_pic)) {
            echo "file not found!";
        } else {
            echo "<img src='" . RELAT_DIR . UPLOAD_DIR . $series_pic . "' width=200>";
        }
    }

    function doDcrPic() {
        $cr = $this->getValue('cr')->Val();
        $series_pic = base64_decode($cr);
        if (!file_exists(ATTACH_DIR . $series_pic)) {
            echo "file not found!";
        } else {
            echo "<img src='" . RELAT_DIR . UPLOAD_DIR . $series_pic . "' width=200>";
        }
    }

    function doSeriesColor() {
        /** 抓取车款颜色快* */
        $id = $this->postValue('series_id')->Int();
        $this->checkAuth($id, 'series');
        $url = $this->postValue('url')->Url();
        session_write_close();
        $catch_obj = new CatchAutoCar();
        $catch_obj->getPageContent($url);
        $modelColor = $catch_obj->getModelColor();
        $factoryName = $modelColor['model_name'][0]['paramitems'][2]['valueitems'][0]['value'];
        $modelId = array();
        foreach ($modelColor['model_name'][0]['paramitems'][0]['valueitems'] as $key => $list) {
            preg_match('/(.*?)\s+(\d+款)(.*)/si', $list['value'], $temp);
            $stemp = $temp[1];
            $mtemp = $temp[2] . $temp[3];
            $where = "factory_name='{$factoryName}' and series_name='{$stemp}' and model_name='{$mtemp}' and state in (3,8)";
            $res = $this->model->chkModel('series_id,model_id', $where, '', 1);
            if (!empty($res)) {
                $modelId[$list['specid']] = $res['model_id'];
                $sid = $res['series_id'];
            }
        }
        $errorMsg = '抓取失败!';
        if (empty($modelId)) {
            echo json_encode(array($errorMsg));
            exit;
        }
        $color = new color();
        $colorN = $color->inserColor($modelColor['color'], $modelId, $sid);
        
        foreach ($colorN as $k => $val) {
            $colorN[$k] = $val;
        }
        if ($colorN) {
            echo json_encode($colorN);
        } else {
            echo json_encode(array($errorMsg));
        }
    }

    function doCatchData() {
        $id = $this->postValue('series_id')->Int();
        $this->checkAuth($id, 'series');
        $url = $this->postValue('url')->Url();
        session_write_close();

        /* $catch_obj = new catchAutoHome();
          $catch_obj->opt_url = $url;
          $ret = $catch_obj->getSeriesOptions($id);
          $update_r = $catch_obj->getStopAndSale($id); */

        $catch_obj = new CatchAutoCar();
        $catch_obj->getPageContent($url);
        $src_series = $catch_obj->getSeriesInfo();
        $bingo_series = $catch_obj->getBingoSeriesData($src_series, $id);
        if ($bingo_series['series_id']) {
            $model_options = $catch_obj->analyzeSeriesModels();
            $format_option = $catch_obj->formatSeriesOption($model_options, $bingo_series);
            $ret = $catch_obj->addSeriesModels($format_option, $bingo_series);
            $catch_obj->getStopSell($id);
        } else {
            $ret = array(
                'src_brand_name' => $bingo_series['src_brand_name'],
                'src_factory_name' => $bingo_series['src_factory_name'],
                'src_series_name' => $bingo_series['src_series_name'],
                'brand_name' => $bingo_series['brand_name'],
                'factory_name' => $bingo_series['factory_name'],
                'series_name' => $bingo_series['series_name'],
                'state' => 0,
            );
            echo json_encode(array($ret));
            exit;
        }

        if (empty($ret)) {
            echo 0;
        } else {
            echo json_encode($ret);
        }
        exit;
    }

    /**
     * 更新cardb_file表中的s1字段
     * s1字段存储对应车款的车系ID
     */
    function doUpdateFileSid() {
        $models = $this->model->getSimpleModel(
                "state=3 or state=7 or state=8", 5000
        );

        foreach ($models as $k => $v) {
            $this->upload->ufields = array(
                's1' => $v['series_id'],
            );
            $this->upload->where = "file_type='jpg' and type_name='model' and type_id='{$v['model_id']}'";
            $r = $this->upload->update();
            if ($r) {
                echo "file model({$v['model_id']}): ok!<br>\n";
            }
        }
    }

    function doUpdateDealerPrice() {
        $dealerprice = new dealerprice();

        $series = $this->series->getAllSeries(
                "s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.state=3", array(), 1000
        );
        foreach ($series as $k => $v) {
            $dealerprice->fields = "*";
            $dealerprice->where = "series_id='{$v['series_id']}'";
            $dealerprice->order = array("model_price" => 'asc');
            $dealerprice->limit = 1;
            $price = $dealerprice->getResult();

            if (!empty($price)) {
                $this->series->ufields = array("dealer_price_low" => $price['model_price']);
                $this->series->where = "series_id='{$v['series_id']}'";
                $sr = $this->series->update();
            }
        }
        return true;
    }

    function doUpdateLastPicid() {
        $series = $this->series->getAllSeries(
                "s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.state=3", array(), 800
        );

        foreach ($series as $k => $v) {
            #图片数最多的车款
            $this->upload->fields = "COUNT(type_id) AS total,type_id AS model_id, s1 AS series_id";
            $this->upload->where = "file_type='jpg' AND type_name='model' AND s1='{$v['series_id']}'";
            $this->upload->group = "type_id";
            $this->upload->order = array('total' => 'desc');
            $file = $this->upload->getResult();

            if ($file && $file['series_id']) {
                $this->series->ufields = array(
                    "last_picid" => $file['model_id'],
                );
                $this->series->where = "series_id='{$file['series_id']}'";
                $r = $this->series->update();
                if ($r) {
                    echo "series({$file['series_id']}): ({$file['model_id']}) ok!<br>\n";
                }
            }
        }
    }

    /**
     * 更新车系表的厂商指导价，价格区间值
     * 对应的字段
     * 厂商指导价，最低价 => price_low
     * 厂商指导价，最高价 => price_high
     */
    function doUpdatePriceRange() {
        $all_series = $this->series->getAllSeries(
                "s.brand_id=b.brand_id and s.factory_id=f.factory_id and s.state=3", array(), 1000
        );

        $err = array();
        foreach ($all_series as $k => $v) {
            $this->model->where = "series_id='{$v['series_id']}' and model_price>0 and (state=3 or state=7 or state=8)";
            $series_price_range = $this->model->getPriceRange();

            #更新该车系指导价格区间字段
            $this->series->ufields = array(
                'price_low' => $series_price_range['min_price'],
                'price_high' => $series_price_range['max_price'],
            );
            $this->series->where = "series_id='{$v['series_id']}'";
            $r = $this->series->update();

            if (!$r) {
                $err[] = "{$v['series_id']} price_rang error";
            }
        }

        if (empty($r)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 更新车系表的经销商最低报价
     * 对应的字段
     * 最低经销商价格 => dealer_price_low
     */
    function doUpdateDealerPriceLow() {
        $all_series = $this->series->getAllSeries(
                "s.brand_id=b.brand_id and s.factory_id=f.factory_id and s.state=3", array(), 1000
        );

        $err = array();
        foreach ($all_series as $k => $v) {
            $dealer_price_low = $this->model->getDealerPriceLowBySid($v['series_id']);
            if (empty($dealer_price_low))
                continue;

            #更新该车系指导价格区间字段
            $this->series->ufields = array(
                'dealer_price_low' => $dealer_price_low,
            );
            $this->series->where = "series_id='{$v['series_id']}'";
            $r = $this->series->update();

            if (!$r) {
                $err[] = "{$v['series_id']} dealer_price_low error";
            }
        }

        return empty($r);
    }

    /**
     * 检查所有车系的实拍图ID
     * 处理ID对应的车款不存在或不正常情况 
     * series.last_picid
     */
    function doChkLastPicid() {
        $all_series = $this->series->getAllSeries(
                "s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.state=3 and s.last_picid>0", array(), 1000
        );
        foreach ($all_series as $key => $value) {
            $this->model->fields = "model_id as id,model_id";
            $this->model->where = "series_id='{$value['series_id']}' and unionpic=1 and (state=3 or state=8 or state=7)";
            $union_model = $this->model->getResult(4);

            //如果没有匹配到车系表中的last_picid，说明该last_picid对应的车款已经无效
            if (array_search($value['last_picid'], $union_model) === FALSE && !empty($union_model)) {
                $new_last_picid = array_shift($union_model);
                $this->series->ufields = array(
                    'last_picid' => $new_last_picid
                );
                $this->series->where = "series_id='{$value['series_id']}'";
                $r = $this->series->update();
                if ($r) {
                    echo "series [{$value['series_id']}] last_picid updated, model_id [{$value['last_picid']}] by [{$new_last_picid}]<br>\n";
                }
            }
        }
        return true;
    }

    function doFixData() {

        $count = 0;
        $data = $this->series->getAllSeries(
                "s.factory_id=f.factory_id and f.brand_id=b.brand_id and (s.brand_name='' or s.factory_name='')", array(), 1000
        );
        #var_dump($data);
        foreach ($data as $key => $v) {
            $this->series->ufields = array(
                'brand_name' => $v['brand_name'],
                'factory_name' => $v['factory_name'],
            );
            $this->series->where = "series_id='{$v['series_id']}'";
            $r = $this->series->update();
            if ($r) {
                $count++;
            }
        }
        return true;
    }

    function checkAuth($id, $module_type = 'factory', $type_value = "A") {
        global $adminauth, $login_uid;
        if ($module_type == 'factory') {
            $tmp = $this->factory->getFactory($id);
            $adminauth->checkAuth($login_uid, 'brand_module', $tmp['brand_id'], 'A');
        } elseif ($module_type == 'series') {
            $tmp = $this->series->getSeries($id);
            $adminauth->checkAuth($login_uid, 'brand_module', $tmp['brand_id'], 'A');
        } else {
            $adminauth->checkAuth($login_uid, 'sys_module', $id, 'A');
        }
    }

    /**
     * 热门车系图片搜索
     */
    function doSeriesHotList() {
        $tpl_name = "series_hot";
        $this->pd_obj = new pageData();
        $fields = 'brand_id, letter, brand_name';
        $where = 'state = 3';
        $order = array('letter' => 'ASC');
        $brand = $this->brand->getBrands($fields, $where, 2, $order);
        $pic_num = 5;
        $pd_obj = $this->pd_obj;
        if ($_POST) {
            $ret = array();
            for ($i = 1; $i <= $pic_num; $i++) {

                $brand = $this->postValue('brand_id_' . $i)->Val();
                $series = $this->postValue('series_id_' . $i)->Val();
                $name = $this->postValue('name_' . $i)->Val();
                $link = $this->postValue('link_' . $i)->Val();

                $ret[$i] = array(
                    'brand' => $brand,
                    'series' => $series,
                    'name' => $name,
                    'link' => $link
                );
            }
            $s = $pd_obj->addPageData(array(
                'name' => 'serieshot',
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
                'url' => $_ENV['PHP_SELF'] . "serieshotlist"
            );
            $this->alert($message);
        } else {
            
        }
        $result = $pd_obj->getPageData(
                array(
                    'name' => 'serieshot',
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
        $this->vars('brand', $brand);
        $this->vars('recommendfocus', $tmp);

        $this->template($tpl_name);
    }

    /**
     * 设置车系下的默认车款信息
     * default_model 默认车款
     * last_picid 实拍图默认车款
     * 
     * rule:年款为最新+关注度最高+实拍图分类大于等于3个+实拍图数量最多
     */
    function doSetDefaultModel() {
        $cardbfile = new cardbFile();
        $model_state = array(3, 8);
        $log_file = SITE_ROOT . 'data/log/default_model.log';
        $errlog_file = SITE_ROOT . 'data/log/default_model_err.log';
        $emtpy_series_log = SITE_ROOT . 'data/log/empty_series.log';
        $empty_default = '';

        $all_series = $this->series->getSeriesdata("*", "state=3", 2);
        foreach ($all_series as $k => $v) {
            #判断默认车款是否正常状态
            $default_model_id = $v['default_model'];
            #$default_model_state = $this->model->getField('state', $v['default_model']);
            #判断车系实拍图，默认车款是否正常状态
            $lastpic_model_id = $v['last_picid'];
            #$lastpic_model_state = $this->model->getField('state', $v['last_picid']);

            $tmp = $series_model = $date_id = $views = $ppos = $pic = array();
            $models = $this->model->getSimpleModel("series_id='{$v['series_id']}' and state in (3,8) and model_pic1<>''", 100, 0, array('date_id' => desc, 'views' => 'desc'));
            foreach ($models as $tk => $tv) {
                #ppos=1数量
                $cardbfile->fields = "count(id)";
                $cardbfile->where = "type_name='model' and type_id='{$tv['model_id']}' and ppos=1";
                $ppos_cnt = $cardbfile->getResult(3);

                #图片总数
                $cardbfile->where = "type_name='model' and type_id='{$tv['model_id']}' and ppos<900";
                $pic_cnt = $cardbfile->getResult(3);

                #无图，忽略此车款
                if ($ppos_cnt < 4)
                    continue;

                $series_model[] = array(
                    'model_id' => $tv['model_id'],
                    'views' => $tv['views'],
                    'series_id' => $tv['series_id'],
                    'date_id' => $tv['date_id'],
                    'ppos_cnt' => $ppos_cnt,
                    'pic_cnt' => $pic_cnt,
                );
                $date_id[] = $tv['date_id'];
                $views[] = $tv['views'];
                $ppos[] = $ppos_cnt;
                $pic[] = $pic_cnt;
            }

            array_multisort($date_id, SORT_DESC, $views, SORT_DESC, $ppos, SORT_DESC, $pic, SORT_DESC, $series_model);

            $new_model_id = $series_model[0]['model_id'];
            #如果没有找到默认车款记录下该车系ID
            if (empty($new_model_id)) {
                $empty_default .= "{$v['series_id']},";
                continue;
            }

            #if( !in_array($default_model_state, $model_state) ){
            #}
            #if( !in_array($lastpic_model_state, $model_state) ){
            #}

            $this->series->ufields = array(
                'default_model' => $new_model_id,
                'last_picid' => $new_model_id,
                'updated' => $this->timestamp,
            );
            $this->series->where = "series_id='{$tv['series_id']}'";
            $r = $this->series->update();

            if ($r) {
                $message = date('Y/m/d H:i:s') . " series({$tv['series_id']}):{$default_model_id}={$new_model_id},{$lastpic_model_id}={$new_model_id}";
                error_log("{$message}\n", 3, $log_file);
            } else {
                $message = date('Y/m/d H:i:s') . " series({$tv['series_id']}):{$this->series->sql}";
                error_log("{$message}\n", 3, $errlog_file);
            }
            echo $message . "<br>\n";
            #var_dump($series_model[0]);
        }
        if ($empty_default) {
            $empty_default = trim($empty_default, ',');
            $message = date('Y/m/d H:i:s') . " empty series:{$empty_default}";
            error_log("{$message}\n", 3, $emtpy_series_log);
        }
    }

    #更新价格

    function doModifySeriesPrice($series = 'all') {
        $logPath = SITE_ROOT . 'data/log';
        @file::forcemkdir($logPath);
        if ($series === 'all') {
            $seriesDB = $this->series->getSeriesdata('series_id', 'state=3');
        } elseif (is_int($series)) {
            $seriesDB = $this->series->getSeriesdata('series_id', "state=3 and series_id='$series'");
        } else {
            exit('请输入车系id');
        }
        $ufields = array();
        if ($seriesDB) {
            foreach ($seriesDB as $sdbv) {
                $fields = array('model_price' => array(0), 'dealer_price' => array(0), 'discount_val' => array(0), 'discount_rate' => array(0));
                $modelDB = $this->model->chkModel('model_price,dealer_price_low', "series_id={$sdbv['series_id']} and state in (3,8)", '', 2, 100);
                if ($modelDB) {
                    foreach ($modelDB as $mdbk => $mdbv) {
                        $fields['model_price'][$mdbk] = $mdbv['model_price'];
                        $fields['dealer_price'][$mdbk] = $mdbv['dealer_price_low'];
                        $fields['discount_val'][$mdbk] = ($mdbv['dealer_price_low'] && $mdbv['dealer_price_low'] != '0.00') ? $mdbv['model_price'] - $mdbv['dealer_price_low'] : 0;
                        $fields['discount_rate'][$mdbk] = ($mdbv['dealer_price_low'] && $mdbv['dealer_price_low'] != '0.00') ? round($mdbv['dealer_price_low'] / $mdbv['model_price'], 2) * 10 : 0;
                    }
                }
                foreach ($fields['dealer_price'] as $dpk => $dpv) {
                    if (empty($dpv) or $dpv == '0.00')
                        unset($fields['dealer_price'][$dpk]);
                }
                foreach ($fields['model_price'] as $mpk => $mpv) {
                    if (empty($mpv) or $mpv == '0.00')
                        unset($fields['model_price'][$mpk]);
                }
                foreach ($fields['discount_rate'] as $mdk => $mdv) {
                    if (empty($mdv) or $mdv == '0.00')
                        unset($fields['discount_rate'][$mdk]);
                }
                $ufields['price_low'] = !empty($fields['model_price']) ? min($fields['model_price']) : 0;
                $ufields['price_high'] = !empty($fields['model_price']) ? max($fields['model_price']) : 0;
                $ufields['dealer_price_low'] = !empty($fields['dealer_price']) ? min($fields['dealer_price']) : 0;
                $ufields['dealer_price_high'] = !empty($fields['dealer_price']) ? max($fields['dealer_price']) : 0;
                $ufields['discount_val'] = max($fields['discount_val']) > 0 ? max($fields['discount_val']) : min($fields['discount_val']);
                $ufields['discount_rate'] = !empty($fields['discount_rate']) ? min($fields['discount_rate']) : 0;
                $this->series->updateSeries($ufields, $sdbv['series_id']);
                error_log(date('Y-m-d h:i:s') . '---' . $this->series->sql . "\n", 3, $logPath . '/modify_series_price.log');
            }
        }
    }

    //判断车系下是否有在售车款（state in (3,8)），没有修改车系状态为9
    function doStopSeries() {
        $seriesResult = $this->series->getSeriesdata("series_id", "state=3");
        if ($seriesResult) {
            foreach ($seriesResult as $val) {
                $modelResult = $this->model->getSimp('count(*) total', "series_id={$val['series_id']} and state in (3,8)", 3);
                if (empty($modelResult)) {
                    $this->series->updateSeries(array('state' => 9), $val['series_id']);
                    error_log('[' . date('Y-m-d h:i:s') . '] [' . $this->series->sql . ']' . "\n", 3, SITE_ROOT . 'data/log/stopseries.log');
                }
            }
        }
    }

    /**
     * 计算车系下所有页面的访问记录数
     * 将总数存储在cardb_series | views中
     */
    function doCountSeriesViews() {
        set_time_limit(300);
        $time_start = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
        $time_end = $time_start + 86400;
        $count_obj = new counter();
        $all_series = $this->series->getAllSeries('b.brand_id=f.brand_id and f.factory_id=s.factory_id and s.state=3', array(), 1200);
        #var_dump($all_series);exit;
        #清空车系表中存储的旧访问数
        $this->series->where = "state=3";
        $this->series->ufields['views'] = 0;
        $this->series->update();

        foreach ($all_series as $series) {
            #取得该车的所有车款
            $this->model->fields = "group_concat(model_id)";
            $this->model->where = "series_id='{$series['series_id']}' and state in (3,8)";
            $series_model_id = $this->model->getResult(3);

            #统计所有车款的访问总数，bingocar数据库，以后加ibuycar库
            if (!empty($series_model_id)) {
                $count_obj->where = "created>='{$time_start}' and created<'{$time_end}' and ((c1='series' and c2='{$series['series_id']}') or ((c1='model' or c1='modelpic') and c2 in ({$series_model_id})))";
                $count_obj->fields = "count(id)";
                $total = $count_obj->getResult(3);
                #echo $count_obj->sql . "\n";
                #更新车系表views字段
                $this->series->ufields['views'] = $total;
                $this->series->where = "series_id='{$series['series_id']}'";
                $rs = $this->series->update();
                if ($rs) {
                    echo "series[{$series['series_id']}] total:{$total}\n";
                } else {
                    echo "series[{$series['series_id']}] total:null\n";
                }
            }
        }
    }
    
    /**
     * 重新关联车系图到车款
     */
    function doReunionPic(){
        $args = array(
            'sid' => FILTER_SANITIZE_NUMBER_INT,
            'type' => FILTER_SANITIZE_NUMBER_INT,
            'styleid' => FILTER_SANITIZE_STRING,
        );
        $get = filter_input_array(INPUT_GET, $args);
        
        $sid = $get['sid'];
        $tid = $get['type'];
        $style_id = $get['styleid'];
        $ret = $err = array();
        
        list($st4, $st21, $date_id) = explode('_', $style_id);
        if($st4 && $st21 && $date_id && $sid){
            $st = array('st4' => $this->series->st4_list[$st4], 'st21' => $this->series->st21_list[$st21]);
            $series_models = $this->model->getModelBySid($sid);
            foreach ($series_models as $mid => $model) {
                $r = $this->upload->copyStylePic($sid, $mid, $st, $date_id, $tid);
                if(!$r){
                    $err[] = iconv('gbk', 'utf-8', "{$model['factory_name']} {$model['series_name']} {$model['model_name']}[$mid]] 更新车系图片失败!");
                }
            }
            if(empty($err)){
                $ret['status'] = 1;
            }else{
                $ret = array(
                    'status' => 0,
                    'err' => $err
                );
            }
        }else{
            $ret['status'] = 0;
        }
        echo json_encode($ret);
    }

}

?>