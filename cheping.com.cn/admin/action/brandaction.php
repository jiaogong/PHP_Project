<?php

/**
 * brand action
 * $Id: brandaction.php 1170 2015-11-04 14:58:47Z xiaodawei $
 * @author David.Shaw
 */
class brandAction extends action {

    var $brand;
    var $factory;
    var $upload;

    function __construct() {
        parent::__construct();
        $this->brand = new brand();
        $this->factory = new factory();
        $this->upload = new uploadFile();
    }

    function doDefault() {
        $this->doList();
    }

    function doList() {
        $template_name = "brand_list";
        $this->page_title = "汽车品牌列表";
        $this->checkAuth(801, 'sys_module');

        $page = $this->getValue('page')->Int();

        $extra = $brand_id = $keyword = $rkeyword = null;
        $state = $this->requestValue('state')->Int();
        $keyword = $this->requestValue('keyword')->UrlDecode();
        $rkeyword = $keyword = $this->addValue($keyword)->stripHtml(1);

        $page = max(1, $page);
        $page_size = 18;
        $page_start = ($page - 1) * $page_size;
        $where = "1";
        if ($state) {
            $where .= " and state='{$state}'";
            $extra = "&state={$state}";
        }
        if ($keyword) {
            $where .= " and brand_name like '%{$keyword}%'";
            $extra .= "&keyword={$rkeyword}";
        }

        $list = $this->brand->getAllBrand($where, array('letter' => 'asc'), $page_size, $page_start);
        $page_bar = $this->multi($this->brand->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);

        $this->vars('page_title', $this->page_title);
        $this->vars('list', $list);
        $this->vars('state_list', getCardbState());
        $this->vars('page_bar', $page_bar);
        $this->vars('state', $state);
        $this->vars('keyword', $keyword);
        $this->vars('rkeyword', $rkeyword);
        $this->template($template_name);
    }

    function doDel() {
        $id = $this->getValue('brand_id')->Int();
        $this->checkAuth($id, 'brand_module');

        $this->brand->ufields = array(
          'state' => 0
        );

        $this->brand->where = "brand_id='{$id}'";
        $ret = $this->brand->update();
        if ($ret) {
            $msg = "成功";
        } else {
            $msg = "失败";
        }
        $this->alert("品牌删除{$msg}!", 'js', 3, $_ENV['PHP_SELF']);
    }

    function doAdd() {
        global $brand_df_state, $factory_df_state;

        $template_name = "brand_add";
        $this->page_title = "新建汽车品牌";
        $this->checkAuth(801, 'sys_module');

        if ($_POST) {
            #brand state
            $confirm = $this->postValue('toconfirm')->Val();
            if ($brand_df_state) {
                $brand_state = $brand_df_state;
            } else {
                if ($confirm) {
                    $brand_state = 2;
                } else {
                    $brand_state = 1;
                }
            }

            #factory state
            if ($factory_df_state) {
                $fact_state = $factory_df_state;
            } else {
                $fact_state = 3;
            }

            if ($confirm) {
                $state = $brand_df_status ? $brand_df_status : 2;
            }

            $brand_name = $this->postValue('brand_name')->String();
            $brand_alias = $this->postValue('brand_alias')->String();
            $cardb_factory = $this->postValue('cardb_factory')->String();
            $keyword = $this->postValue('keyword')->String();
            $brand_logo = $_FILES['brand_logo'];
            $brand_intro = $this->postValue('brand_intro')->Val();
            $brand_import = $this->postValue('brand_import')->Val();
            $this->brand->ufields = array(
              'brand_name' => $brand_name,
              'brand_alias' => $brand_alias,
              'keyword' => $keyword,
              'brand_intro' => $brand_intro,
              'brand_import' => $brand_import,
              'state' => $brand_state,
              /*'letter' => util::Pinyin($brand_name),*/
              'created' => $this->timestamp,
              'updated' => $this->timestamp,
            );
            $full_pinyin = $this->postValue('full_pinyin')->String();
            if ($full_pinyin) {
                $this->brand->ufields['full_pinyin'] = $full_pinyin;
            } else {
                $this->brand->ufields['full_pinyin'] = util::Pinyin($brand_name, 2);
            }
            $this->brand->ufields['letter'] = strtoupper(substr($this->brand->ufields['full_pinyin'], 0, 1));
            
            $short_pinyin = $this->postValue('short_pinyin')->En();
            if ($short_pinyin) {
                $this->brand->ufields['short_pinyin'] = $short_pinyin;
            } else {
                $this->brand->ufields['short_pinyin'] = util::Pinyin($brand_name, 3);
            }

            $insert_id = $this->brand->insert();

            if ($insert_id) {
                $msg = "成功";

                #insert factory
                if ($cardb_factory) {
                    $tmp = $tmp2 = array();
                    $cardb_factory = str_replace('；', ';', $cardb_factory);
                    $tmp = array_unique(explode(';', $cardb_factory));
                    $brand_factory = $this->factory->getFactoryByBrand($insert_id);
                    foreach ($brand_factory as $key => $value) {
                        $tmp2[$value['factory_id']] = $value['factory_name'];
                    }

                    foreach ($tmp as $key => $value) {
                        #if not exist
                        if (!array_search($value, $tmp2)) {
                            $this->factory->ufields = array(
                              'factory_name' => $value,
                              'brand_name' => $brand_name,
                              'brand_id' => $insert_id,
                              'state' => $fact_state,
                              'created' => $this->timestamp,
                              'updated' => $this->timestamp,
                            );
                            $this->factory->insert();
                        }
                    }
                }

                #upload brand logo
                if ($brand_logo['size']) {
                    $brand_logo['type_id'] = $insert_id;
                    $brand_logo['type_name'] = $brand_name;

                    $brand_logo_path = $this->upload->uploadBrandLogo($brand_logo);
                    if (!$brand_logo_path) {
                        $msg .= "，品牌LOGO上传失败";
                    }

                    $this->brand->ufields = array(
                      'brand_logo' => $brand_logo_path
                    );
                    $this->brand->where = "brand_id='{$insert_id}'";
                    $ret = $this->brand->update();
                }
            } else {
                $msg = "失败";
            }
            $this->alert("新建品牌{$msg}!", 'js', 3, $_ENV['PHP_SELF']);
        } else {
            $this->vars('brand_import', $this->brand->brand_import);
            $this->template($template_name);
        }
    }

    function doEdit() {
        global $brand_df_state, $factory_df_state;
        $template_name = "brand_add";
        $new_fid = array();
        $brand_id = $this->postValue('brand_id')->Int();
        if ($brand_id) {
            $this->checkAuth($brand_id, 'brand_module');

            #brand state
            $confirm = $this->postValue('toconfirm')->Val();
            if ($brand_df_state) {
                $brand_state = $brand_df_state;
            } else {
                if ($confirm) {
                    $brand_state = 2;
                } else {
                    $brand_state = 1;
                }
            }

            #factory state
            if ($factory_df_state) {
                $fact_state = $factory_df_state;
            } else {
                $fact_state = 1;
            }

            if ($confirm) {
                $state = $brand_df_status ? $brand_df_status : 2;
            }

            $brand_name = $this->postValue('brand_name')->String();
            $brand_alias = $this->postValue('brand_alias')->String();
            $cardb_factory = $this->postValue('cardb_factory')->String();
            $cardb_factory_id = $this->postValue('cardb_factory_id')->Int();
            $keyword = $this->postValue('keyword')->String();
            $brand_logo = $_FILES['brand_logo'];
            $brand_intro = $this->postValue('brand_intro')->Val();
            $brand_import = $this->postValue('brand_import')->Val();
            $this->brand->ufields = array(
              'brand_name' => $brand_name,
              'brand_alias' => $brand_alias,
              'keyword' => $keyword,
              'brand_intro' => $brand_intro,
              'brand_import' => $brand_import,
              'state' => $brand_state,
              /*'letter' => util::Pinyin($brand_name),*/
              'updated' => $this->timestamp,
            );
            $full_pinyin = $this->postValue('full_pinyin')->String();
            if ($full_pinyin) {
                $this->brand->ufields['full_pinyin'] = $full_pinyin;
            } else {
                $this->brand->ufields['full_pinyin'] = util::Pinyin($brand_name, 2);
            }
            $this->brand->ufields['letter'] = strtoupper(substr($this->brand->ufields['full_pinyin'], 0, 1));
            $short_pinyin = $this->postValue('short_pinyin')->En();
            if ($short_pinyin) {
                $this->brand->ufields['short_pinyin'] = $short_pinyin;
            } else {
                $this->brand->ufields['short_pinyin'] = util::Pinyin($brand_name, 3);
            }

            $this->brand->where = "brand_id='{$brand_id}'";
            $ret = $this->brand->update();
            if ($ret) {
                $msg = "成功";

                $fact_id = explode(';', $cardb_factory_id);
                $fact_val = explode(';', $cardb_factory);

                $fact_id_cnt = count($fact_id);
                $fact_val_cnt = count($fact_val);

                #更新
                if ($fact_id_cnt == $fact_val_cnt) {
                    foreach ($fact_val as $k => $v) {
                        $this->factory->ufields = array(
                          'factory_name' => $v,
                          'brand_name' => $brand_name,
                          'state' => $fact_state,
                          'updated' => $this->timestamp,
                        );
                        $this->factory->where = "factory_id='{$fact_id[$k]}'";
                        $this->factory->update();
                    }
                }
                #有删除
                elseif ($fact_id_cnt > $fact_val_cnt) {
                    foreach ($fact_id as $k => $v) {
                        if ($k + 1 > $fact_val_cnt) {
                            #del
                            $this->factory->ufields = array('state' => 0);
                            $this->factory->where = "factory_id='{$v}'";
                            $this->factory->update();
                            continue;
                        }
                        $this->factory->ufields = array(
                          'factory_name' => $fact_val[$k],
                          'brand_name' => $brand_name,
                          'state' => $fact_state,
                          'updated' => $this->timestamp,
                        );
                        $this->factory->where = "factory_id='{$v}'";
                        $this->factory->update();
                    }
                }
                #有插入
                else {
                    foreach ($fact_val as $k => $v) {
                        if ($k + 1 > $fact_id_cnt) {
                            #del
                            $this->factory->ufields = array(
                              'factory_name' => $v,
                              'brand_id' => $brand_id,
                              'brand_name' => $brand_name,
                              'state' => $fact_state,
                              'created' => $this->timestamp,
                              'updated' => $this->timestamp,
                            );
                            $this->factory->insert();
                            continue;
                        }
                        $this->factory->ufields = array(
                          'factory_name' => $v,
                          'brand_name' => $brand_name,
                          'state' => $fact_state,
                          'updated' => $this->timestamp,
                        );
                        $this->factory->where = "factory_id='{$fact_id[$k]}'";
                        $this->factory->update();
                    }
                }

                #upload brand logo
                if ($brand_logo['size']) {
                    $brand_logo['type_id'] = $brand_id;
                    $brand_logo['type_name'] = $brand_name;

                    $brand_logo_path = $this->upload->uploadBrandLogo($brand_logo);
                    if (!$brand_logo_path) {
                        $msg .= "，品牌LOGO上传失败";
                    }

                    $this->brand->ufields = array(
                      'brand_logo' => $brand_logo_path
                    );
                    $this->brand->where = "brand_id='{$brand_id}'";
                    $ret = $this->brand->update();
                }

                #更新品牌下车系
                $series_obj = new series();
                $series_obj->ufields = array(
                  'brand_name' => $brand_name,
                );
                $series_obj->where = "brand_id='{$brand_id}'";
                $series_obj->update();

                #更新品牌下车款的，品牌名称和品牌国别
                $model_obj = new cardbModel();
                $model_obj->ufields = array(
                  'brand_name' => $brand_name,
                  'brand_import' => $brand_import,
                );
                $model_obj->where = "brand_id='{$brand_id}'";
                $model_obj->update();
            } else {
                $msg = "失败";
            }

            $this->alert("修改品牌{$msg}!", 'js', 3, $_ENV['PHP_SELF']);
        } 
        else {
            $brand_id = $this->getValue('brand_id')->Int();
            $this->checkAuth($this->getValue('brand_id')->Int(), 'brand_module');

            $this->page_title = "修改汽车品牌";
            $brand = $this->brand->getBrand($brand_id);

            #get factory
            $factory = $this->factory->getFactoryByBrand($brand_id);
            foreach ($factory as $key => $value) {
                $new_fid[$value['factory_id']] = $value['factory_name'];
            }
            $this->vars('brand_import', $this->brand->brand_import);
            $this->vars('fact_id', implode(';', array_keys($new_fid)));
            $this->vars('fact_val', implode(';', array_values($new_fid)));
            $this->vars('brand', $brand);
            #$this->template($template_name);
            echo $this->fetch($template_name);
        }
    }

    function doJs() {
        $list = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $js = "";
        $t_letter = "";
        foreach ($list as $key => $value) {
            /* if($t_letter == $value['letter'] && $t_letter){
              $js .= "document.write('<option value={$value['brand_id']}>&nbsp;&nbsp;&nbsp;&nbsp;{$value['brand_name']}</option>');\r\n";
              }else{ */
            $t_letter = $value['letter'];
            $js .= "document.write('<option value={$value['brand_id']}>{$value['letter']}  {$value['brand_name']}</option>');\r\n";
            /* } */
        }
        echo $js;
    }

    function doSsiBrandList() {
        $this->tpl_file = "ssi_index_brand";
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        foreach ($brand as $key => $value) {
            $newbrand[$value["letter"]][] = $value;
        }
        $width = floor(940 / count($newbrand));
        $this->vars('width', $width);
        $this->vars('brand', $newbrand);
        $this->template();
    }

    //首页品牌搜索
    function doSsiIndexBrandSearch() {
        $this->tpl_file = "ssi_index_search_brand";
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        foreach ($brand as $key => $value) {
            $newbrand[$value["letter"]][] = $value;
        }
        $this->vars('brand', $newbrand);
        $this->template();
    }

    //品牌-品牌索引
    function doSsiBrandSearch() {
        $this->tpl_file = "ssi_search_brand";
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        foreach ($brand as $key => $value) {
            $newbrand[$value["letter"]][] = $value;
        }
        $this->vars('brand', $newbrand);
        $this->template();
    }

    function checkAuth($id, $module_type = 'brand_module', $type_value = "A") {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, $module_type, $id, 'A');
    }

    function doJson() {
        $brand = $this->brand->getBrands('brand_id,brand_name,letter', 'state=3', 2, array('letter' => 'asc'), 1000);
        foreach ($brand as $key => $val) {
            $brand[$key]['brand_name'] =  $val['brand_name'];
        }
        echo json_encode($brand);
    }

}

?>
