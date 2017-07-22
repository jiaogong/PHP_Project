<?php

/**
 * tree action
 * $Id: coloraction.php 5712 2014-07-24 07:46:28Z jiangweiwei $
 */
class colorAction extends action {

    var $tree;
    var $series;
    var $brand;
    var $color;
    var $colorpic;
    var $colormodel;

    function __construct() {

        parent::__construct();
        $this->tree = new Tree();
        $this->series = new series();
        $this->brand = new brand();
        $this->color = new color();
        $this->colorpic = new colorpic();
        $this->colormodel = new colormodel();
    }

    function doDefault() {
        $series = $this->getValue('color_name')->En();
        $series == 'series' ? $this->doColorIndex() : $this->doColorModelIndex();
    }

//车系颜色管理
    function doColorIndex() {
        $tpl_name = "color_index";
        $this->page_title = "车系颜色列表";
        $extra = $brand_id = $factory_id = $keyword = $rkeyword = $series_id = null;
        $keyword = $this->requestValue('keyword')->UrlDecode();
        $keyword = trim($keyword);
        $factory_id = $this->requestValue('factory_id')->Int();
        $brand_id = $this->requestValue('brand_id')->Int();
        $series_id = $this->requestValue('series_id')->Int();
        $where = "state = 3";
        if ($factory_id != '') {
            $where.=" and factory_id='{$factory_id}'";
            $extra .= "&factory_id=$factory_id";
            if ($series_id != '') {
                $where.=" and series_id='{$series_id}'";
            }
        } else if ($brand_id != '') {
            $where.=" and brand_id='{$brand_id}'";
            $extra .= "&brand_id=$brand_id";
        } else if ($series_id != '') {
            $where.=" and series_id='{$series_id}'";
            $extra .= "&series_id=$series_id";
        } else if ($keyword) {
            $where .= " and series_name like '%{$keyword}%'";
            $extra .= "&keyword={$rkeyword}";
        } else {
            
        }
        $extra .= "&color_name=series";
        $page = $this->getValue('page')->Int();
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $list = $this->series->getSeriesColor($where, array('s.series_id' => 'asc'), $page_size, $page_start);
        $page_bar = $this->multi($total = $this->series->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);
        $brand_list = $this->brand->getAllBrand();
        $this->tpl->assign('brand', $brand_list);
        $this->tpl->assign('page_bar', $page_bar);
        $this->tpl->assign('page_title', $page_title);
        $this->tpl->assign('brand_id', $brand_id);
        $this->tpl->assign('keyword', $keyword);
        $this->tpl->assign('list', $list);
        $this->template($tpl_name);
    }

    function doColorEdit() {
        if ($_POST) {
            //var_dump($_POST);exit;
            $type_id = $this->postValue('type_id')->Int();
            $color_name = $this->postValue('color_name')->Val();
            $id = $this->postValue('id')->Val();
            $rcolor_name = $this->postValue('rcolor_name')->Val();
            $old_pic = $this->postValue('old_pic')->Val();
            $new_pic = $this->postValue('new_pic')->Val();
            if (is_array($color_name)) {
                //组合数据
                foreach ($color_name as $k => $v) {
                    $list[$k]['color_name'] = $v;
                }
                foreach ($id as $k => $v) {
                    $list[$k]['id'] = $v;
                }
                foreach ($rcolor_name as $k => $v) {
                    $list[$k]['rcolor_name'] = $v;
                }
                foreach ($old_pic as $k => $v) {
                    if (!empty($new_pic[$k])) {
                        $list[$k]['color_pic'] = strrchr($new_pic[$k], '/');
                    } else {
                        $list[$k]['color_pic'] = strrchr($old_pic[$k], '/');
                    }
                }
                //判断车系颜色是否有重复
                $this->color->fields = "color_name";
                foreach ($list as $k => $v) {
                    $this->color->where = "id!='{$v['id']}' && type_name='series' &&type_id='{$type_id}' && color_name='{$v['color_name']}'";
                    $color_name = $this->color->getResult(3);
                    if ($color_name) {
                        $this->alert("车系颜色  {$color_name}  已存在，请重新输入!", 'js', 2, $_ENV['PHP_SELF']);
                    }
                }
                foreach ($list as $k => $v) {
                    $this->color->where = "id=" . $v['id'];
                    //var_dump($v['id']);
                    $this->color->ufields = array(
                        'color_name' => $v['color_name'],
                        'color_pic' => 'color' . $v['color_pic'],
                        'updated' => time(),
                    );
                    $ret = $this->color->update();
                    //将数据关联到车款
                    $this->colormodel->fields = "model_id";
                    $this->colormodel->where = "series_id=" . $this->postValue('type_id')->Int();
                    $model_id = $this->colormodel->getResult(2);
                    if (!empty($model_id)) {
                        foreach ($model_id as $kk => $vv) {
                            $this->color->where = "type_id='{$vv['model_id']}' && type_name='model' && color_name='{$v['rcolor_name']}'";
                            $this->color->ufields = array(
                                'color_name' => $v['color_name'],
                                'color_pic' => 'color' . $v['color_pic'],
                                'updated' => time(),
                            );
                            $ret = $this->color->update();
                        }
                    }
                }//exit;
                if ($ret) {
                    $msg = "成功";
                } else {
                    $msg = "失败";
                }
                $extra = "&color_name=series";
                $this->alert("车系颜色编辑{$msg}!", 'js', 3, $_ENV['PHP_SELF'] . $extra);
            } else {
                $extra = "&color_name=series";
                $this->alert("您没有做任何操作!", 'js', 3, $_ENV['PHP_SELF'] . $extra);
            }
        } else {
            $tpl_name = "color_edit";
            $this->page_title = "修改车系颜色";
            $series_id = $this->getValue('series_id')->Int();
            $series_name = $this->getValue('series_name')->String();
            $where = "type_id={$series_id} and type_name=series_name";
            $series_list = $this->color->getColorBySeries($series_id);
            $color_list = $this->colorpic->getColorpic();
            $this->tpl->assign('series_name', $series_name);
            $this->tpl->assign('series_id', $series_id);
            foreach ($color_list as $k => $v) {
                $color_list[$k]['pic'] = RELAT_DIR . UPLOAD_DIR . 'images/' . $v['pic'];
            }
            foreach ($series_list as $k => $v) {
                $series_list[$k]['color_pic'] = RELAT_DIR . UPLOAD_DIR . 'images/' . $v['color_pic'];
            }
            //var_dump($color_list);exit;
            $this->tpl->assign('color_list', $color_list);
            $this->tpl->assign('series_list', $series_list);
            $this->template($tpl_name);
        }
    }

    function doColorAdd() {
        if (!empty($_POST)) {
            $type_id = $this->postValue('type_id')->Val();
            $color_name = $this->postValue('color_name')->Val();
            $color_pic = $this->postValue('color_pic')->Val();
            if (is_array($color_name)) {
                //组合数据
                foreach ($color_name as $k => $v) {
                    $list[$k]['color_name'] = $v;
                }
                foreach ($color_pic as $k => $v) {
                    $list[$k]['color_pic'] = strrchr($v, '/');
                }
                //判断车身颜色是否有重复
                $this->color->fields = "color_name";
                foreach ($list as $k => $v) {
                    $this->color->where = "type_id='{$type_id}' && type_name='series' && color_name='{$v['color_name']}'";
                    $color_name = $this->color->getResult(3);
                    if ($color_name) {
                        $this->alert("车身颜色  {$color_name}  已存在，请重新输入!", 'js', 2, $_ENV['PHP_SELF']);
                    }
                }
                //组合数据并插入到数据表
                foreach ($list as $k => $v) {
                    $this->color->ufields = array(
                        'type_id' => $type_id,
                        'type_name' => 'series',
                        'color_name' => $v['color_name'],
                        'color_pic' => 'color' . $v['color_pic'],
                        'created' => time(),
                        'updated' => time(),
                    );
                    $ret = $this->color->insert();
                    //将数据关联到车款
                    $this->colormodel->fields = "model_id";
                    $this->colormodel->where = "series_id=" . $this->postValue('type_id')->Int();
                    $model_id = $this->colormodel->getResult(2);
                    foreach ($model_id as $kk => $vv) {
                        $this->color->ufields = array(
                            'type_id' => $vv['model_id'],
                            'type_name' => 'model',
                            'color_name' => $v['color_name'],
                            'color_pic' => $v['color_pic'],
                            'created' => time(),
                            'updated' => time(),
                        );
                        $ret = $this->color->insert();
                    }
                }
                if ($ret) {
                    $msg = "成功";
                } else {
                    $msg = "失败";
                }
                $extra = "&color_name=series";
                $this->alert("车身颜色编辑{$msg}!", 'js', 3, $_ENV['PHP_SELF'] . $extra);
            } else {
                $extra = "&color_name=series";
                $this->alert("您没有做任何操作!", 'js', 3, $_ENV['PHP_SELF'] . $extra);
            }
        } else {
            $tpl_name = "color_add";
            $this->page_title = "新增车系颜色";
            $where = "type_id={$this->getValue('series_id')->Int()} and type_name={$list['series_name']}";
            $series_list = $this->color->getColorBySeries($this->getValue('series_id')->Int());
            $color_list = $this->colorpic->getColorpic();
            foreach ($color_list as $k => $v) {
                $color_list[$k]['pic'] = RELAT_DIR . UPLOAD_DIR . 'images/' . $v['pic'];
            }
            foreach ($series_list as $k => $v) {
                $series_list[$k]['color_pic'] = RELAT_DIR . UPLOAD_DIR . 'images/' . $v['color_pic'];
            }
            //var_dump($series_list);exit;
            $this->tpl->assign('series_name', $this->getValue('series_name')->String());
            $this->tpl->assign('series_id', $this->getValue('series_id')->Int());
            $this->tpl->assign('color_list', $color_list);
            $this->tpl->assign('series_list', $series_list);
            $this->template($tpl_name);
        }
    }

    function doColorDel() {
        $this->color->where = "id=" . $this->getValue('id')->Int();
        $ret = $this->color->del();
        //删除关联
        $color_name = $this->getValue('color_name')->String();
        $this->colormodel->fields = "model_id";
        $this->colormodel->where = "series_id=" . $this->getValue('type_id')->Int();
        $model_id = $this->colormodel->getResult(2);
        //var_dump($model_id);exit;
        if (!empty($model_id)) {
            foreach ($model_id as $kk => $vv) {
                $this->color->where = "type_id='{$vv['model_id']}' && type_name='model' && color_name='{$color_name}'";
                $ret = $this->color->del(); 
            }
        }

        if ($ret) {
            $this->alert("车身颜色删除成功!", 'js', 2, $_ENV['PHP_SELF']);
        } else {
            $this->alert("车身颜色删除失败!", 'js', 2, $_ENV['PHP_SELF']);
        }
    }

    //车款颜色管理
    function doColorModelIndex() {
        $tpl_name = "color_model_index";
        $this->page_title = "车款颜色列表";
        $extra = $brand_id = $factory_id = $keyword = $rkeyword = $series_id = null;
        $keyword = $this->requestValue('keyword')->UrlDecode();
        $rkeyword = $keyword = $this->addValue($keyword)->stripHtml(1);
        $factory_id = $this->requestValue('factory_id')->Int();
        $brand_id = $this->requestValue('brand_id')->Int();
        $series_id = $this->requestValue('series_id')->Int();
        $model_id = $this->requestValue('model_id')->Int();
        $where = "state = 3";
        if ($factory_id != '') {
            $where.=" and factory_id='{$factory_id}'";
            $extra .= "&factory_id=$factory_id";
        }
        if ($brand_id != '') {
            $where.=" and brand_id='{$brand_id}'";
            $extra .= "&brand_id=$brand_id";
        }
        if ($series_id != '') {
            $where.=" and series_id='{$series_id}'";
            $extra .= "&series_id=$series_id";
        }
        if ($model_id != '') {
            $where.=" and model_id='{$model_id}'";
            $extra .= "&model_id=$model_id";
        }
        if ($keyword) {
            $where .= " and series_name like '%{$keyword}%'";
            $extra .= "&keyword={$rkeyword}";
        }
        $extra .= "&color_name=model";
        $page = $this->getValue('page')->Int();
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $list = $this->colormodel->getModelColor($where, array('s.series_id' => 'asc'), $page_size, $page_start);
        $page_bar = $this->multi($total = $this->colormodel->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);
        $brand_list = $this->brand->getAllBrand();
        $this->tpl->assign('brand', $brand_list);
        $this->tpl->assign('page_bar', $page_bar);
        $this->tpl->assign('page_title', $page_title);
        $this->tpl->assign('brand_id', $brand_id);
        $this->tpl->assign('keyword', $keyword);
        $this->tpl->assign('list', $list);
        $this->template($tpl_name);
    }

    function doColorModelAdd() {
        if ($_POST) {
            $type_id = $this->postValue('type_id')->Val();
            $color_name = $this->postValue('color_name')->Val();
            $color_pic = $this->postValue('color_pic')->Val();
            if (is_array($color_name)) {
                //组合数据
                foreach ($color_name as $k => $v) {
                    $list[$k]['color_name'] = $v;
                }

                foreach ($color_pic as $k => $v) {
                    $list[$k]['color_pic'] = strrchr($v, '/');
                }
                //判断车身颜色是否有重复
                $this->color->fields = "color_name";
                foreach ($list as $k => $v) {
                    $this->color->where = "type_id='{$type_id}' && type_name='model' && color_name='{$v['color_name']}'";
                    $color_name = $this->color->getResult(3);
                    if ($color_name) {
                        $this->alert("车款颜色  {$color_name}  已存在，请重新输入!", 'js', 2, $_ENV['PHP_SELF']);
                    }
                }
                //组合数据并插入到数据表
                foreach ($list as $k => $v) {
                    $this->color->fields = 'id';
                    $this->cardb_model = new cardbModel();
                    $mInfo = $this->cardb_model->getModel($type_id);
                    $this->color->where = "type_id={$mInfo['series_id']} and type_name='series' and color_pic='color{$v['color_pic']}'";
                    $seriesInfo = $this->color->getResult(2);
                    if (empty($seriesInfo)) {
                        $this->color->ufields = array(
                            'type_id' => $mInfo['series_id'],
                            'type_name' => 'series',
                            'color_name' => $v['color_name'],
                            'color_pic' => 'color' . $v['color_pic'],
                            'created' => time(),
                            'updated' => time(),
                        );
                        $ret = $this->color->insert();
                    }
                    $this->color->ufields = array(
                        'type_id' => $type_id,
                        'type_name' => 'model',
                        'color_name' => $v['color_name'],
                        'color_pic' => 'color' . $v['color_pic'],
                        'created' => time(),
                        'updated' => time(),
                    );
                    $ret = $this->color->insert();
                }
                if ($ret) {
                    $msg = "成功";
                } else {
                    $msg = "失败";
                }
                $extra = "&color_name=model";
                $this->alert("车款颜色编辑{$msg}!", 'js', 3, $_ENV['PHP_SELF'] . $extra);
            } else {
                $extra = "&color_name=model";
                $this->alert("您没有做任何操作!", 'js', 3, $_ENV['PHP_SELF'] . $extra);
            }
        } else {
            $tpl_name = "color_model_add";
            $this->page_title = "新增车款颜色";
            $where = "type_id={$this->getValue('model_id')->Int()} and type_name=model}";
            $model_list = $this->color->getColorByModel($this->getValue('model_id')->Int());
            $color_list = $this->colorpic->getColorpic();
            foreach ($color_list as $k => $v) {
                $color_list[$k]['pic'] = RELAT_DIR . UPLOAD_DIR . 'images/' . $v['pic'];
            }
            foreach ($model_list as $k => $v) {
                $model_list[$k]['color_pic'] = RELAT_DIR . UPLOAD_DIR . 'images/' . $v['color_pic'];
                if ($v['color_name'] == 'ʯӢ'){
                    unset($model_list[$k]);
                }
            }
            $this->tpl->assign('model_name', $this->getValue('model_name')->String());
            $this->tpl->assign('model_id', $this->getValue('model_id')->Int());
            $this->tpl->assign('color_list', $color_list);
            $this->tpl->assign('model_list', $model_list);
            $this->template($tpl_name);
        }
    }

    function doColorModelEdit() {
        if ($_POST) {
            $type_id = $this->postValue('type_id')->Val();
            $color_name = $this->postValue('color_name')->Val();
            $old_pic = $this->postValue('old_pic')->Val();
            $new_pic = $this->postValue('new_pic')->Val();
            $id = $this->postValue('id')->Val();
            if (is_array($color_name)) {
                $this->cardb_model = new cardbModel();
                //组合数据
                foreach ($color_name as $k => $v) {
                    $list[$k]['color_name'] = $v;
                    $list[$k]['id'] = $id[$k];
                }
                
                foreach ($old_pic as $k => $v) {
                    if (!empty([$k])) {
                        $list[$k]['color_pic'] = strrchr($new_pic[$k], '/');
                    } else {
                        $list[$k]['color_pic'] = strrchr($old_pic[$k], '/');
                    }
                }
                //判断车款颜色是否有重复
                $this->color->fields = "color_name";
                foreach ($list as $k => $v) {
                    $this->color->where = "id!='{$v['id']}' && type_name='model' && type_id='{$type_id}' && color_name='{$v['color_name']}'";
                    $color_name = $this->color->getResult(3);
                    if ($color_name) {
                        $this->alert("车款颜色  {$color_name}  已存在，请重新输入!", 'js', 2, $_ENV['PHP_SELF']);
                    }
                }

                foreach ($list as $k => $v) {
                    //如果修改的颜色车系里边没有，增加
                    $mInfo = $this->cardb_model->getModel($type_id);
                    $this->color->where = "type_id={$mInfo['series_id']} and type_name='series' and color_pic='color{$v['color_pic']}'";
                    $seriesInfo = $this->color->getResult(2);
                    if (empty($seriesInfo)) {
                        $this->color->ufields = array(
                            'type_id' => $mInfo['series_id'],
                            'type_name' => 'series',
                            'color_name' => $v['color_name'],
                            'color_pic' => 'color' . $v['color_pic'],
                            'created' => time(),
                            'updated' => time(),
                        );
                        $ret = $this->color->insert();
                    }
                    $this->color->where = "id=" . $v['id'];
                    $this->color->ufields = array(
                        'color_name' => $v['color_name'],
                        'color_pic' => 'color' . $v['color_pic'],
                        'updated' => time(),
                    );

                    $ret = $this->color->update();
                }
                if ($ret) {
                    $msg = "成功";
                } else {
                    $msg = "失败";
                }
                $extra = "&color_name=model";
                $this->alert("车款颜色编辑{$msg}!", 'js', 3, $_ENV['PHP_SELF'] . $extra);
            } else {
                $extra = "&color_name=model";
                $this->alert("您没有做任何操作!", 'js', 3, $_ENV['PHP_SELF'] . $extra);
            }
        } else {
            $tpl_name = "color_model_edit";
            $this->page_title = "修改车款颜色";
            $where = "type_id={$this->getValue('model_id')->Int()} and type_name=model";
            $model_list = $this->color->getColorByModel($this->getValue('model_id')->Int());
            $color_list = $this->colorpic->getColorpic();
            $this->tpl->assign('model_name', $this->getValue('model_name')->String());
            $this->tpl->assign('model_id', $this->getValue('model_id')->Int());
            foreach ($color_list as $k => $v) {
                $color_list[$k]['pic'] = RELAT_DIR . UPLOAD_DIR . 'images/' . $v['pic'];
            }
            foreach ($model_list as $k => $v) {
                $model_list[$k]['color_pic'] = RELAT_DIR . UPLOAD_DIR . 'images/' . $v['color_pic'];
                if ($v['color_name'] == 'ʯӢ'){
                    unset($model_list[$k]);
                }
            }
            //var_dump($color_list);exit;
            $this->tpl->assign('color_list', $color_list);
            $this->tpl->assign('model_list', $model_list);
            $this->template($tpl_name);
        }
    }

}

?>
