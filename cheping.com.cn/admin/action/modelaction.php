<?php

/**
 * cardb_model action
 * $Id: modelaction.php 3173 2016-06-23 04:05:05Z wangchangjiang $
 * @author David.Shaw
 */
set_time_limit(0);

class modelAction extends action {

    var $factory;
    var $brand;
    var $series;
    var $cardbmodel;
    var $paramtype;
    var $paramtxt;
    var $param;
    var $upload;

    function __construct() {
        parent::__construct();
        $this->factory = new factory();
        $this->brand = new brand();
        $this->series = new series();
        $this->cardbmodel = new cardbModel();
        $this->paramtype = new paramType();
        $this->paramtxt = new paramtxt();
        $this->param = new param();
        $this->upload = new uploadFile();
        $this->cardbSaleState = new cardbsalestate();
        $this->model_collect = new cardbModelPicCollect();
        $this->admin_user = new user(); 
    }

    function doDefault() {
        $this->doList();
    }

    function doList() {
        $template_name = "model_list";
        $this->page_title = "车款列表";
        $extra = $brand_id = $series_id = $factory_id = $keyword = $rkeyword = null;

        $page = $this->getValue('page')->Int();
        $father_id = $this->getValue('fatherId')->Int();
        $extra = "&fatherId={$father_id}";
        $this->checkAuth($father_id, 'series');

        $brand_id = $this->requestValue('brand_id')->Int();
        $factory_id = $this->requestValue('factory_id')->Int();
        $series_id = $this->requestValue('series_id')->Int();
        $keyword = $this->requestValue('keyword')->UrlDecode();
        $rkeyword = $keyword = $this->addValue($keyword)->stripHtml(1);

        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $where = "(m.state=3 or m.state=7 or m.state=8) and m.series_id=s.series_id and s.factory_id=f.factory_id and f.brand_id=b.brand_id and m.model_name<>'' and m.series_id='{$father_id}'";
        if ($series_id) {
            $where .= " and m.series_id='{$series_id}'";
            $extra .= "&series_id={$series_id}&factory_id={$factory_id}&brand_id={$brand_id}";

            $factory_list = $this->factory->getAllFactory(
                    "f.brand_id=b.brand_id and f.brand_id='{$brand_id}'", array('f.letter' => 'asc'), 100
            );
            $series_list = $this->series->getAllSeries(
                    "s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.factory_id='{$factory_id}'", array('s.letter' => 'asc'), 100
            );

            $this->vars('series_list', $series_list);
            $this->vars('series_id', $series_id);
            $this->vars('factory_list', $factory_list);
            $this->vars('factory_id', $factory_id);
        }
        if ($keyword) {
            $where .= " and s.series_name like '%{$keyword}%'";
            $extra .= "&keyword={$rkeyword}";
        }

        $list = array();
        $tmp = $this->cardbmodel->getAllModel($where, array('m.model_id' => 'desc'), $page_size, $page_start);
        $page_bar = $this->multi($this->cardbmodel->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);

        if (!empty($tmp)) {
            foreach ($tmp as $k => $v) {
                if ($this->upload->checkUnion($v['model_id'], 'model')) {
                    $v['union'] = 1;
                } else {
                    $v['union'] = 0;
                }
                $pc = $this->paramtxt->getModelTxtCount($v['model_id']);
                if (!empty($pc)) {
                    $v['paramtxt'] = 1;
                } else {
                    $v['paramtxt'] = 0;
                }
                $list[] = $v;
            }
        }
        $brand_list = $this->brand->getAllBrand("state=3", array('letter' => 'asc'), 300);

        $this->vars('page_title', $this->page_title);
        $this->vars('list', $list);
        $this->vars('brand_list', $brand_list);
        $this->vars('page_bar', $page_bar);
        $this->vars('brand_id', $brand_id);
        $this->vars('keyword', $keyword);
        $this->vars('rkeyword', $rkeyword);
        $this->template($template_name);
    }

    function doAdd() {
        global $model_df_state;
        $template_name = "model_add";
        $this->page_title = "新建车款";

        $fatherId = $this->requestValue('fatherId')->Int();
        if ($fatherId) {
            $this->checkAuth($fatherId, 'series');
        } else {
            $this->checkAuth(11);
        }

        #车款参数列表
        $pt = $this->paramtype->getParamTypeAssoc();
        $p = $this->param->getParamAssoc();
        #var_dump($p);
        $cols = $this->cardbmodel->getModelParamFields();
        $tmp = $tmp2 = array();

        foreach ($cols as $k => $v) {
            if (array_key_exists($k, $p)) {
                foreach ($this->paramtype->parent_category as $ck => $cv) {
                    #判断参数分类值
                    $pid_val = $p[$k]['pid' . $ck];

                    #判断参数内所属组
                    $n = $pt[$pid_val]['pid'];
                    if ($pid_val) {
                        #echo "pid_val:{$pid_val}, k={$k}, name={$p[$k]['name']} ck,cv={$ck},{$cv}, pk,pv={$pk},{$pv} <br>\n";
                        if ($n !== $ck)
                            $tmp[$n][$pid_val][] = $p[$k];
                        else
                            $tmp[$ck][$pid_val][] = $p[$k];
                        break;
                    }
                }
            }
        }

        ksort($tmp);
        #var_dump($tmp);
        $this->vars('pt', $pt);
        $this->vars('p', $p);
        $this->vars('param_list', $tmp);
        $this->vars('parent_category', $this->paramtype->parent_category);

        if ($_POST) {
            if ($model_df_state) {
                $model_state = $model_df_state;
            } else {
                $model_state = 1;
            }

            $this->cardbmodel->ufields = array(
                'model_name' => $this->postValue('model_name')->Val(),
                'brand_name' => $this->postValue('brand_name')->Val(),
                'brand_id' => $this->postValue('brand_id')->Val(),
                'factory_name' => $this->postValue('factory_name')->Val(),
                'factory_id' => $this->postValue('factory_id')->Int(),
                'series_name' => $this->postValue('series_name')->Val(),
                'series_id' => $this->postValue('series_id')->Int(),
                'keyword' => $this->postValue('keyword')->Val(),
                'model_price' => $this->postValue('model_price')->Val(),
                'bingo_price' => $this->postValue('bingo_price')->Val(),
                'date_id' => $this->postValue('date_id')->Int(),
                'compete_id' => $this->postValue('compete_id')->Val(),
                'state' => $model_state,
                'created' => $this->timestamp,
                'updated' => $this->timestamp,
            );

            #upload model pic
            $model_pic = $_FILES['model_pic1'];
            if ($model_pic['size']) {
                $model_pic['type_name'] = 'model';
                $model_pic['type_id'] = $this->postValue('model_id')->Int();
                $filepath = $this->upload->uploadCarPic($model_pic);
                $this->cardbmodel->ufields['model_pic1'] = $filepath;
            }

            foreach ($cols as $k => $v) {
                if ($p[$k]['data_type'] !== 4) {
                    $this->cardbmodel->ufields['st' . $k] = $this->postValue('st' . $k)->Val();
                } else {
                    $this->cardbmodel->ufields['st' . $k] = $this->postValue('st' . $k)->Val() . "->" . $this->postValue('st' . $k . '_2')->Val();
                }
            }
            $model_id = $ret = $this->cardbmodel->insert();
            #start 更新cardb_modelprice里边的指导价
            $this->cardbmodel->updatePrice($model_id, array('model_price' => $this->postValue('model_price')->Val()));
            #end
            if ($model_id) {
                $msg = "成功";

                #处理车系外观图，如果有外观图，复制到本车款
                $series_id = $this->postValue('series_id')->Int();
                $r = $this->upload->copyStylePic(
                        $series_id, $model_id, array(
                        'st4' => $this->postValue('st4')->Val(),
                        'st21' => $this->postValue('st21')->Val(),                            
                        ),
                        $this->postValue('date_id')->Int()
                );
                if ($r) {
                    $this->cardbmodel->ufields = array(
                        'model_pic2' => $r
                    );
                    $this->cardbmodel->where = "model_id='{$model_id}'";
                    $s = $this->cardbmodel->update();
                }
                #end外观
                #更新车系bingo_price
                $bingo_price_range = $this->cardbmodel->getBingoPriceRange($series_id);
                $this->series->ufields = array(
                    'bingo_price_low' => $bingo_price_range['min_price'],
                    'bingo_price_high' => $bingo_price_range['max_price'],
                );
                $this->series->where = "series_id='{$series_id}'";
                $sr = $this->series->update();
                #end
                #添加searchindex，用于搜索的数据
                $si_obj = new searchIndex();
                $factory_id = $this->postValue('factory_id')->Int();
                $factory = $this->factory->getFactory($factory_id);
                $this->cardbmodel->ufields['factory_import'] = $factory['factory_import'];
                $this->cardbmodel->ufields['model_id'] = $model_id;
                $r = $si_obj->addIndex($this->cardbmodel->ufields);
                #end
            } else {
                $msg = "失败";
            }
            $this->alert("新建车款信息{$msg}！", 'js', 1, $_ENV['PHP_SELF']);
        } else {
            $fatherId = $this->getValue('fatherId')->Int();
            $father = $this->series->getSeries($fatherId);
            $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);

            $this->vars('fatherId', $fatherId);
            $this->vars('father', $father);
            $this->vars('brand', $brand);

            unset($tmp);
            foreach ($cols as $key => $value) {
                if (!empty($p[$key]))
                    $tmp[$key] = $this->param->getParamHtml($p[$key]);
            }
            $this->vars('param_html', $tmp);
        }
        $this->template($template_name);
    }

    function doEdit() {
        global $model_df_state;
        $template_name = "model_add";
        $this->page_title = "修改车款";
        $model_id = $this->requestValue('model_id')->Int();
        $this->checkAuth($model_id, 'model');

        #车款参数列表
        $pt = $this->paramtype->getParamTypeAssoc();
        $p = $this->param->getParamAssoc();
        #var_dump($p);
        $cols = $this->cardbmodel->getModelParamFields();
        $tmp = $tmp2 = array();

        foreach ($cols as $k => $v) {
            if (array_key_exists($k, $p)) {
                foreach ($this->paramtype->parent_category as $ck => $cv) {
                    #判断参数分类值
                    $pid_val = $p[$k]['pid' . $ck];

                    #判断参数内所属组
                    $n = $pt[$pid_val]['pid'];
                    if ($pid_val) {
                        #echo "pid_val:{$pid_val}, k={$k}, name={$p[$k]['name']} ck,cv={$ck},{$cv}, pk,pv={$pk},{$pv} <br>\n";
                        if ($n !== $ck)
                            $tmp[$n][$pid_val][] = $p[$k];
                        else
                            $tmp[$ck][$pid_val][] = $p[$k];
                        break;
                    }
                }
            }
        }

        ksort($tmp);
        #var_dump($tmp);
        $this->vars('pt', $pt);
        $this->vars('p', $p);
        $this->vars('param_list', $tmp);
        $this->vars('parent_category', $this->paramtype->parent_category);
        if ($this->postValue('model_id')->Exist()) {
            $bjState = $this->postValue('bjstate')->Val();
            if($bjState) {
                $bjId = $this->cardbSaleState->getOneState('id', "model_id = {$model_id} AND city_id = 19");
                if($bjId) $this->cardbSaleState->updateState(array('state' => $bjState), "model_id = {$model_id} AND city_id = 19");            
                else {
                    $ufields = array(
                        'province_id' => 3,
                        'city_id' => 19,
                        'model_id' => $model_id,
                        'state' => $bjState
                    );
                    $this->cardbSaleState->insertState($ufields);
                }                
            }
            if ($model_df_state) {
                $model_state = $model_df_state;
            } else {
                $model_state = 1;
            }

            $this->cardbmodel->ufields = array(
                'brand_name' => $this->postValue('brand_name')->Val(),
                'brand_id' => $this->postValue('brand_id')->Val(),
                'factory_name' => $this->postValue('factory_name')->Val(),
                'factory_id' => $this->postValue('factory_id')->Val(),
                'series_name' => $this->postValue('series_name')->Val(),
                'series_id' => $this->postValue('series_id')->Val(),
                'keyword' => $this->postValue('keyword')->Val(),
                'model_price' => $this->postValue('model_price')->Val(),
                'bingo_price' => $this->postValue('bingo_price')->Val(),
                'date_id' => $this->postValue('date_id')->Val(),
                'compete_id' => $this->postValue('compete_id')->Val(),
                'state' => $model_state,
                'updated' => $this->timestamp,
            );
            $model_name = $this->postValue('model_name')->String();
            if ($model_name) {
                $this->cardbmodel->ufields['model_name'] = $model_name;
            }
            #upload model pic
            $model_pic = $_FILES['model_pic1'];
            if ($model_pic['size']) {
                $model_pic['type_name'] = 'model';
                $model_pic['type_id'] = $model_id;
                $filepath = $this->upload->uploadCarPic($model_pic);
                $this->cardbmodel->ufields['model_pic1'] = $filepath;
            }
             #upload model pic
            $model_pic2 = $_FILES['model_pic2'];
            if ($model_pic2['size']) {
                $model_pic2['type_name'] = 'model';
                $model_pic2['type_id'] = $model_id;
                $filepath = $this->upload->uploadCarPic($model_pic2);
                $this->cardbmodel->ufields['model_pic2'] = $filepath;
            }

            foreach ($cols as $k => $v) {
                if ($p[$k]['data_type'] !== 4) {
                    $this->cardbmodel->ufields['st' . $k] = $this->postValue('st' . $k)->Val();
                } else {
                    $this->cardbmodel->ufields['st' . $k] = $this->postValue('st' . $k)->Val() . "->" . $this->postValue('st' . $k . '_2')->Val();
                }
            }
            $this->cardbmodel->where = "model_id='{$model_id}'";
            #var_export($this->cardbmodel->ufields);
            #exit;

            $ret = $this->cardbmodel->update();
            #start 更新cardb_modelprice里边的指导价
            $this->cardbmodel->updatePrice($model_id, array('model_price' => $this->postValue('model_price')->Val()));
            #end
            if ($ret) {
                $msg = "成功";
                $series_id = $this->postValue('series_id')->Int();
                #更新车系bingo_price
                $bingo_price_range = $this->cardbmodel->getBingoPriceRange($series_id);
                $this->series->ufields = array(
                    'bingo_price_low' => $bingo_price_range['min_price'],
                    'bingo_price_high' => $bingo_price_range['max_price'],
                );
                $this->series->where = "series_id='{$series_id}'";
                $sr = $this->series->update();
                #end
            } else {
                $msg = "失败";
            }
            $this->alert("车款信息修改{$msg}！", 'js', 3, $_ENV['PHP_SELF'] . "&fatherId={$series_id}");
        } else {
            $model_id = $this->getValue('model_id')->Int();
            if ($model_id) {
                $bjState = $this->cardbSaleState->getOneState('state', "model_id = {$model_id} AND city_id = 19");
                $this->vars('bjState', $bjState);                
                $model = $this->cardbmodel->getModel($model_id);
                $this->vars('model', $model);

                unset($tmp);
                foreach ($cols as $key => $value) {
                    if (!empty($p[$key]))
                        $tmp[$key] = $this->param->getParamHtml($p[$key], $model['st' . $key]);
                }
                $this->vars('param_html', $tmp);

                $series = $this->series->getSeries($model['series_id']);
                $factory = $this->factory->getFactory($series['factory_id']);
                $brand = $this->brand->getBrand($factory['brand_id']);
                $this->vars('series', $series);
                $this->vars('factory', $factory);
                $this->vars('brand', $brand);

                $allbrand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
                $this->vars('allbrand', $allbrand);
            }
        }
        $this->template($template_name);
    }

    function doMove() {
        $id = $this->getValue('model_id')->Int();
        $this->checkAuth($id, 'model');

        $sid = $this->getValue('series_id')->Int();

        #如果series_id为空，返回
        if (!$sid) {
            $this->alert(
                    array(
                        'type' => 'js',
                        'message' => '车系ID参数为空！',
                        'act' => 2,
                    )
            );
        }

        $series = $this->series->getSeries($sid);

        #如果不存在状态为正常，即state=3的车系，返回
        if (empty($series)) {
            $this->alert(
                    array(
                        'type' => 'js',
                        'message' => '选择的车系不存在或停产！',
                        'act' => 2,
                    )
            );
        }

        $this->cardbmodel->ufields = array(
            'series_id' => $series['series_id'],
            'series_name' => $series['series_name'],
            'factory_id' => $series['factory_id'],
            'factory_name' => $series['factory_name'],
            'brand_id' => $series['brand_id'],
            'brand_name' => $series['brand_name'],
            'type_id' => $series['type_id'],
            'type_name' => $series['type_name'],
        );
        $this->cardbmodel->where = "model_id='{$id}'";
        $r = $this->cardbmodel->update();
        if ($r) {
            $msg = "成功";
        } else {
            $msg = "失败";
        }
        $this->alert(
                array(
                    'type' => 'js',
                    'message' => "车款已经{$msg}移动到{$series['series_name']}！",
                    'act' => 2,
                )
        );
    }

    function doDel() {
        $id = $this->getValue('model_id')->Int();
        $this->checkAuth($id, 'model');

        $this->cardbmodel->ufields = array(
            'state' => 0
        );

        $this->cardbmodel->where = "model_id='{$id}'";
        $ret = $this->cardbmodel->update();
        if ($ret) {
            $msg = "成功";
        } else {
            $msg = "失败";
        }
        $this->alert("车款删除{$msg}!", 'js', 3, $_ENV['PHP_SELF'] . "&fatherId=" . $this->getValue('fatherId')->Int());
    }

    function doUploadZip() {
        $file = $_FILES['fileToUpload'];
        $file['type_id'] = $this->postValue('model_id')->Int();
        $ext = file::extname($file['name']);

        #判断压缩包格式
        if ($ext != 'zip') {
            $error = "-1";
            #exit;
        }

        #判断文件尺寸，不能大于50M
        $mb_size = 50 * 1024 * 1024 * 1024;
        if ($file['size'] >= $mb_size) {
            $error = "-2";
            #exit;
        }

        $r = $this->upload->uploadModelZip($file);
        if ($r) {
            $error = "1";
        } else {
            $error = "0";
        }
        $e = stripcslashes(var_export($_FILES));
        echo "{error:'{$error}'\n, msg: '{$e}'\n}";
        exit;
    }

    function doJcupload() {
        $_FILES["Filedata"]["name"] = iconv("UTF-8", "GBK", $_FILES["Filedata"]["name"]);
        $file = $_FILES['Filedata'];
        $_FILES['Filedata']['model_id'] = $file['type_id'] = $_REQUEST['modelid'];
        $ext = file::extname($file['name']);

        #write upload log
        $upload_log = SITE_ROOT . "data/log/upload_modelzip.log";
        $upload_msg = "start:" . date('Y/m/d H:i:s') . "\r\n" . var_export($_FILES["Filedata"], true) . "\r\n";
        @file_put_contents($upload_log, $upload_msg, 8);

        #判断压缩包格式
        if ($ext != 'zip') {
            $error = "-1";
            #exit;
        }

        #判断文件尺寸，不能大于50M
        $mb_size = 50 * 1024 * 1024 * 1024;
        if ($file['size'] >= $mb_size) {
            $error = "-2";
            #exit;
        }

        $r = $this->upload->uploadModelZip($file);
        if ($r) {
            $error = "1";
        } else {
            $error = "0";
        }
        exit;
    }

    function doSwfuploadzip() {
        $phpsessid = $this->postValue('PHPSESSID')->Val();
        if ($phpsessid) {
            session_id($phpsessid);
        }
        #session_start();
        ini_set("html_errors", "0");
        $file = $_FILES["Filedata"];
        $model_id = $this->postValue('model_id')->Int();
        if (!isset($file) || !is_uploaded_file($file["tmp_name"]) || $file["error"] != 0 || empty($model_id)) {
            header("HTTP/1.1 500 Internal Server Error");
            exit(0);
        }

        $file['type_id'] = $model_id;
        $r = $this->upload->uploadModelZip($file);
        if (!$r) {
            error_log("model_id:" . $file['type_id'] . " upload error(" . $file["tmp_name"] . ")\n", 3, SITE_ROOT . "data/log/upload_err.log");
        }
        echo "Make sure Flash Player on OS X works";
        exit(0);
    }

    function doJson() {
        $sid = $this->getValue('sid')->Int();
        #$this->checkAuth($sid, 'series');

        $model = $this->cardbmodel->getModelBySid($sid);

        $ret = array();
        foreach ($model as $key => $value) {
            $ret[] = array(
                'model_id' => $key,
                'model_name' => $value['model_name'],
                'dealer_price_low' => $value['dealer_price_low']
            );
        }
        echo json_encode($ret);
    }
    function doAllStateJson() {
        $sid = $this->getValue('sid')->Int();
        #$this->checkAuth($sid, 'series');
        $where = "series_id='{$sid}' and state in(3,8,9,11)";
        $fields = "model_id,model_name,dealer_price_low";
        $model = $this->cardbmodel->chkSelect($fields,$where);

        $ret = array();
        foreach ($model as $key => $value) {
            $ret[] = array(
                'model_id' => $value['model_id'],
                'model_name' => $value['model_name'],
                'dealer_price_low' => $value['dealer_price_low']
            );
        }
        echo json_encode($ret);
    }

    function doCarJson() {
        #要求有产品完全权限，可操作此功能
        $this->checkAuth(10, 'sys_module');

        $js = "";
        $brand_js = $series_js = $model_js = array();
        $models = $this->cardbmodel->getAllModel(
                'm.series_id=s.series_id and s.factory_id=f.factory_id and f.brand_id=b.brand_id and m.state=3 and b.state=3 and f.state=3 and s.state=3', array('b.letter' => 'asc'), 0, 4000
        );
        foreach ($models as $k => $v) {
            if (!array_key_exists($v['brand_id'], $brand_js))
                $brand_js[$v['brand_id']] = array(
                    'brand_id' => $v['brand_id'],
                    'brand_name' => $v['brand_name'],
                    'letter' => $v['letter'],
                );

            if (!array_key_exists($v['series_id'], (array) $series_js[$v['brand_id']]))
                $series_js[$v['brand_id']][$v['series_id']] = array(
                    'series_id' => $v['series_id'],
                    'series_name' => $v['series_name'],
                    'brand_id' => $v['brand_id'],
                );

            #if(!array_key_exists($v['model_id'], (array)$model_js[$v['series_id']]))
            $model_js[$v['series_id']][$v['model_id']] = array(
                'model_id' => $v['model_id'],
                'model_name' => $v['model_name'],
                'date_id' => $v['date_id'],
            );
        }
        return array(
            'brand' => json_encode($brand_js),
            'series' => json_encode($series_js),
            'model' => json_encode($model_js),
        );
    }

    function doBrandJs() {
        #要求有产品完全权限，可操作此功能
        $this->checkAuth(10, 'sys_module');
        $data = $this->cardbmodel->getJsonData();
        $js = "var brand_js=" . $data['brand'] . ";\n";
        echo $js;
    }

    function doSeriesJs() {
        #要求有产品完全权限，可操作此功能
        $this->checkAuth(10, 'sys_module');
        $data = $this->cardbmodel->getJsonData();
        $js = "var series_js=" . $data['series'] . ";\n";
        echo $js;
    }

    function doModelJs() {
        #要求有产品完全权限，可操作此功能
        $this->checkAuth(10, 'sys_module');
        $data = $this->cardbmodel->getJsonData();
        $js = "var model_js=" . $data['model'] . ";\n";
        echo $js;
    }

    function doUnionPic() {
        $id = $this->getValue('model_id')->Int();
        $this->checkAuth($id, 'model');

        #$pic_obj = new uploadFile();
        $this->upload->unionModelPic($id);
    }

    function doReUnionPic() {
        $id = $this->getValue('model_id')->Int();
        $this->checkAuth($id, 'model');

        $this->upload->delUnionPic($id, 'model');
        #$pic_obj = new uploadFile();
        $this->upload->unionModelPic($id);
    }

    function doConvertSt() {
        $id = $this->getValue('model_id')->Int();
        $this->checkAuth($id, 'model');
        $ret = $this->cardbmodel->convertSt2Txt($id);
        if ($ret) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function doFixData() {

        $count = 0;
        $data = $this->cardbmodel->getAllModel(
                "m.series_id=s.series_id and s.factory_id=f.factory_id and f.brand_id=b.brand_id and (m.series_name='' or m.factory_name='' or m.brand_name='')", array(), 5000
        );
        foreach ($data as $key => $v) {
            $this->cardbmodel->ufields = array(
                'series_name' => $v['series_name'],
                'factory_name' => $v['factory_name'],
                'brand_name' => $v['brand_name'],
            );
            $this->cardbmodel->where = "model_id='{$v['model_id']}'";
            $r = $this->cardbmodel->update();
            if ($r) {
                $count++;
            }
        }
        return true;
    }

    function checkAuth($id, $module_type = 'sys_module', $type_value = "A") {
        global $adminauth, $login_uid;
        if ($module_type == 'sys_module') {
            $adminauth->checkAuth($login_uid, 'sys_module', $id, 'A');
        } else {
            $func = "get" . $module_type;
            if ($module_type == 'model') {
                $tmp = $this->cardbmodel->$func($id);
            } else {
                $tmp = $this->$module_type->$func($id);
            }
            $adminauth->checkAuth($login_uid, 'brand_module', $tmp['brand_id'], 'A');
        }
    }

    function doPic() {
        $code = $this->getValue('c')->String();
        $code = base64_decode($code);
        $filename = WWW_ROOT . $code;
        if (file_exists($filename)) {
            echo "<img src='" . RELAT_DIR . "{$code}' width=200>";
        } else {
            echo "file not found";
        }
    }

    /**
     *  将所有dealer_price_low复制到search_index 
     */
    function doCopyToIndex() {
        $this->cardbmodel->fields = "model_id,dealer_price_low";
        $this->cardbmodel->where = "dealer_price_low<>0";
        $model = $this->cardbmodel->getResult(2);
        $searchindex = new searchIndex();
        foreach ($model as $key => $val) {
            $data['bingo_price'] = $val['dealer_price_low'];
            $searchindex->ufields = $data;
            $searchindex->where = "model_id='{$val[model_id]}'";
            $searchindex->update();
        }
        echo "search_index表价格复制完成！";
    }

    function doChangeViews() {
        $model_id = $this->getValue('model_id')->Int();
        $views = $this->getValue('views')->Int();

        $this->cardbmodel->where = "model_id='{$model_id}'";
        $this->cardbmodel->ufields = array(
            'views' => $views
        );
        $r = $this->cardbmodel->update();
        echo json_encode($r);
    }

    function doChangeSportCar() {
        $model_id = $this->getValue('model_id')->Int();
        $sportcar = $this->getValue('sportcar')->Int();
        $this->cardbmodel->where = "model_id='{$model_id}'";
        $this->cardbmodel->ufields = array(
            'is_sportcar' => $sportcar
        );
        $r = $this->cardbmodel->update();
        echo json_encode($r);
    }
    
    function doUpdateUnionPic(){
        $r = $this->cardbmodel->updateUnionPic();
        echo json_encode($r);
    }

        
    //通过车款id,返回采集车系的图片相关信息
    function doModelPicCollect(){
        #要求有产品完全权限，可操作此功能
        $this->checkAuth(10, 'sys_module');
        global $login_uid;
        $tpl_name = "modelcollect";
        $model_id = $this->postValue('modelid')->Int();
        $page = $this->getValue('page')->Int();
        $extra = "modelpiccollect";
        if($model_id){
            $isExist_modelId = $this->model_collect->isModelId($model_id);
            $model_result = $this->cardbmodel->chkModel("brand_name,series_name,model_name","model_id=$model_id AND state in(3,8)","",1);
            $author = $this->admin_user->getFields('username', "uid=$login_uid", 3);
            if(!$isExist_modelId){
                if($model_result){
                    $data = array();
                    $data['model_id'] = $model_id;
                    $data['brand_name'] = $model_result['brand_name'];
                    $data['series_name'] = $model_result['series_name'];
                    $data['model_name'] = $model_result['model_name'];
                    $data['author'] = $author;
                    $data['collect_num'] = 0;
                    $data['state'] = 1; 
                    $data['created'] = time();
                    $this->model_collect->addCollect($data);
                    $this->alert("车款id添加成功!", 'js', 3, $_ENV['PHP_SELF'] . $extra);          
                }else{
                    $this->alert("此车款不是正常或在售状态!", 'js', 3, $_ENV['PHP_SELF'] . $extra); 
                }
            }else{
                if($isExist_modelId == "2" || $isExist_modelId == "3"){
                    $data['state'] = 1;
                    $data['author'] = $author;
                    $data['created'] = time();
                    $this->model_collect->upCollect("model_id=$model_id",$data);
                    if($isExist_modelId == "2"){
                        $this->alert("此车款已采集，重新添加采集成功!", 'js', 3, $_ENV['PHP_SELF'] . $extra);
                    }else{
                        $this->alert("此车款之前为采集失败，重新添加采集成功!", 'js', 3, $_ENV['PHP_SELF'] . $extra);
                    }
                }elseif($isExist_modelId == "1"){
                    $this->alert("此车款已存在列表，状态 - 【未采集】!", 'js', 3, $_ENV['PHP_SELF'] . $extra);  
                }elseif($isExist_modelId == "4"){
                    $this->alert("此车款已存在列表，状态 - 【采集中】!", 'js', 3, $_ENV['PHP_SELF'] . $extra); 
                }
            }
        }
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $result = $this->model_collect->getList('',array('created'=>'DESC'), $page_start, $page_size);
        $page_bar = $this->multi($this->model_collect->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);
        $this->vars('modelid', $model_id);
        $this->vars('list', $result);
        $this->vars('page_bar', $page_bar);
        $this->template($tpl_name);
    }
}
?>

