<?php

/**
 * parmType action
 * $Id: paramaction.php 1250 2015-11-13 09:08:46Z xiaodawei $
 * @author David.Shaw
 */
class paramAction extends action {

    var $param;
    var $paramtype;
    var $par = array(
        "model_price" => "厂商指导价",
        "bingo_price" => "参考价",
        "st10" => "综合油耗",
        "st50" => "变速箱",
        "st51" => "驱动方式",
        "st27" => "排量",
        "st30" => "缸数",
        "st28" => "进气形式",
        "st41" => "燃油类型",
        "st22" => "座位",
        "st4" => "车身结构",
        "st76" => "ABS防抱死",
        "st80" => "车辆稳定性控制",
        "st63" => "副驾气囊",
        "st72" => "防盗报警",
        "st129" => "车载导航",
        "st97" => "定速巡航",
        "st98" => "倒车雷达",
        "st158" => "车窗防夹手功能",
        "st73" => "中控锁",
        "st75" => "无钥匙启动",
        "st102" => "真皮座椅",
        "st87" => "天窗",
        "st55" => "车体结构"
    );

    function __construct() {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, 'sys_module', 203, 'A');

        parent::__construct();
        $this->param = new param();
        $this->paramtype = new paramType();
        $this->model = new cardbModel();
        $this->series = new Series();
        $this->brand = new brand();
        $this->factory = new factory();
        $this->series_settings = new seriessetting();
    }

    function doDefault() {
        $this->doList();
    }

    function doList() {
        $template_name = "param_list";
        $this->page_title = "参数列表";

        $page = $this->getValue('page')->Int();

        $extra = $pcategory = $category = $keyword = $rkeyword = null;
        $pcategory = $this->requestValue('pcategory')->Int();
        $category = $this->requestValue('category')->Int();
        $keyword = $this->requestValue('keyword')->UrlDecode();
        $rkeyword = $keyword = $this->addValue($keyword)->stripHtml(1);

        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $where = "1";
        if ($pcategory && empty($category)) {
            $where .= " and ";
            $where .= " pid{$pcategory}>0";
            $cate = $this->paramtype->getParamTypeByPid($pcategory);
            $this->vars('cate', $cate);
            $extra = "&pcategory={$pcategory}";
        } elseif ($category) {
            $where .= " and (";
            foreach ($this->paramtype->parent_category as $pk => $pv) {
                $where .= " pid{$pk}='{$category}' or";
            }
            $where = substr($where, 0, -2) . ")";
            $extra = "&category={$category}&pcategory={$pcategory}";
            $cate = $this->paramtype->getParamTypeByPid($pcategory);
            $this->vars('cate', $cate);
        }
        if ($keyword) {
            $where .= " and name like '%{$keyword}%'";
            $extra .= "&keyword={$rkeyword}";
        }

        $subcate_list = $this->param->getAllParam($where, array('type_order1' => 'ASC', 'id' => 'desc'), $page_size, $page_start);
        $category_list = $this->paramtype->parent_category;
        #var_dump($this->param->sql);
        $page_bar = $this->multi($this->param->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);

        $this->vars('list', $subcate_list);
        $this->vars('category_list', $category_list);
        $this->vars('page_bar', $page_bar);
        $this->vars('pcategory', $pcategory);
        $this->vars('category', $category);
        $this->vars('keyword', $keyword);
        $this->vars('rkeyword', $rkeyword);
        $this->vars('query_string', urlencode(base64_encode($extra)));
        $this->vars('page', $page);
        $this->template($template_name);
    }

    function doAdd() {
        if ($_POST) {
            $type_order1 = $this->postValue('type_order1')->Int(1);
            $type_order2 = $this->postValue('type_order2')->Int(1);
            $type_order3 = $this->postValue('type_order3')->Int(1);
            $pid1 = $this->postValue('pcategory1')->Int();
            $pid2 = $this->postValue('pcategory2')->Int();
            $pid3 = $this->postValue('pcategory3')->Int();
            $qs = $this->postValue('qs')->Val();
            $qs = urldecode(base64_decode($qs));


            $subcate_name = $this->postValue('name')->String();
            $alias1 = $this->postValue('alias1')->String();
            $data_type = $this->postValue('data_type')->Int();
            $data_value = $this->postValue('data_value')->String();

            $this->param->ufields = array(
                'name' => $subcate_name,
                'alias1' => $alias1,
                'pid1' => $pid1,
                'pid2' => $pid2,
                'pid3' => $pid3,
                'data_type' => $data_type,
                'type_order1' => $type_order1,
                'type_order2' => $type_order2,
                'type_order3' => $type_order3,
                'data_value' => $data_value,
                'is_hidden' => $this->postValue('is_hidden')->Int(),
            );

            #修改
            if ($this->postValue('id')->Int()) {
                $id = $this->postValue('id')->Int();
                $page = $this->postValue('page')->Int();

                $this->param->where = "id<>'{$id}' and name='{$subcate_name}' and (pid1='{$pid1}' or pid2='{$pid2}' or pid3='{$pid3}')";
                $this->param->fields = "count(id)";
                $count = $this->param->getResult(3);

                if ($count) {
                    $this->alert("参数类别“{$subcate_name}”已经在在，请改名后提交！", 'js', 2);
                } else {
                    $this->param->where = "id='{$id}'";
                    $ret = $this->param->update();
                    $this->alert("参数类别“{$subcate_name}”修改成功！", 'js', 3, $_ENV['PHP_SELF'] . $qs . "&page=" . $page);
                }
            }
            #添加
            else {
                $this->param->where = "name='{$subcate_name}' and (pid1='{$pid1}' or pid2='{$pid2}' or pid3='{$pid3}')";
                $this->param->fields = "count(id)";
                $count = $this->param->getResult(3);

                if ($count) {
                    $this->alert("参数类别“{$subcate_name}”已经在在，请改名后提交！", 'js', 2);
                } else {
                    $ret = $this->param->insert();

                    #车款表增加参数字段
                    $ac = $this->param->addColumn($ret, $subcate_name, $data_type);

                    if (!$ac) {
                        $this->alert("车款表增加参数“{$subcate_name}”字段失败！", 'js', 3, $_ENV['PHP_SELF']);
                    }
                    $this->alert("参数类别“{$subcate_name}”添加成功！", 'js', 3, $_ENV['PHP_SELF']);
                }
            }
        }
        #显示修改/添加页面
        else {
            $page = $this->getValue('page')->Int();

            $template_name = "param_add";
            $this->page_title = "添加参数";
            $category_list = $this->paramtype->parent_category;

            $pcategory = array();
            foreach ($category_list as $pk => $pv) {
                $tmp['category'] = $this->paramtype->getParamTypeByPid($pk);
                $tmp['id'] = $pk;
                $tmp['name'] = $pv;
                $pcategory[] = $tmp;
            }
            unset($tmp);
            $id = $this->getValue('id')->Int();
            if ($id) {
                $this->page_title = "参数类别修改";
                $subcate = $this->param->getParam($id);

                $this->vars('subcate', $subcate);

                foreach ($pcategory as $key => $value) {
                    $value['pvalue'] = $subcate['pid' . $value['id']];
                    $tmp[] = $value;
                }
                $pcategory = $tmp;
            }

            $data_type = $this->param->getParamFieldType();

            $this->vars('data_type', $data_type);
            $this->vars('category_list', $category_list);
            $this->vars('pcategory', $pcategory);
            $this->vars('qs', $this->getValue('qs')->Val());
            $this->vars('page', $page);
            $this->template($template_name);
        }
    }

    //车款参数统计
    function doParamstat() {
        $template_name = "param_stat";
        $this->page_title = "车款参数统计";
        $this->vars('par', $this->par);
        $this->vars('page_title', $this->page_title);
        $this->template($template_name);
    }

    //对参数进行搜索
    function doParamstatdate() {
        $template_name = "param_stat";
        $this->page_title = "车款参数统计";

        $param = $this->requestValue('param')->String();
        $isv = $this->requestValue('isv')->String();
        $this->vars('param', $param);
        $keyword = $this->requestValue('keyword')->UrlDecode();
        $rkeyword = $keyword = $this->addValue($keyword)->stripHtml(1);

        $page = $this->getValue('page')->Int();
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $where = " 1 and s.factory_id=f.factory_id and f.brand_id=b.brand_id and m.series_id=s.series_id and m.state=3";
        $extra .="paramstatdate";
        if ($keyword) {
            $where .= " and $param = '{$keyword}'";
            $extra .= "&keyword={$rkeyword}";
            $this->vars('keyword', $rkeyword);
        } else {
            $where .= " and ($param = '' or $param is null) ";
        }
        $extra .= "&param=$param&isv=$isv";

        $modellist = $this->model->getAllModel($where, array("model_id" => "DESC"), $page_size, $page_start);
        $page_bar = $this->multi($this->model->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra, 0, 4);
        $this->vars('isv', $isv);
        $this->vars('par', $this->par);
        $this->vars('modellist', $modellist);
        $this->vars('page_bar', $page_bar);
        $this->vars('page_title', $this->page_title);
        $this->template($template_name);
    }

    function doEdit() {
        $this->doAdd();
    }

    function doSetting() {
        $template_name = "param_setting";
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $this->vars('brand', $brand);
        $fields = "*";
        $series_id = $this->postValue('series_id')->Int();
        $factory_id = $this->postValue('factory_id')->Int();
        $brand_id = $this->postValue('brand_id')->Int();
        if ($series_id) {
            $where = "series_id='{$series_id}' and  state in(3,8)";
            $seriesArr = $this->series->getSeriesdata($fields, $where, 2);
        } elseif ($factory_id) {
            $where = "factory_id='{$factory_id}' and state in(3,8)";
            $seriesArr = $this->series->getSeriesdata($fields, $where, 2);
        } elseif ($brand_id) {
            $where = "brand_id='{$brand_id}' and state in(3,8)";
            $seriesArr = $this->series->getSeriesdata($fields, $where, 2);
        } else {
            $seriesArr = $this->series->getSeriesdata("*", "state in(3,8)", 2);
        }

        $this->vars("list", $seriesArr);
        $this->vars('page_title', $this->page_title);
        $this->template($template_name);
    }

    function doListdetail() {
        $template_name = "param_listcheck";
        $this->page_title = "详细列表";
        $series_id = $this->getValue('series_id')->Int();
        $series_name = $this->series->getSeriesdata("series_name", "series_id='$series_id' and state in(3,8)", 3);
        $seriesArr = $this->series_settings->getSettingList("*", "series_id='$series_id' order by model_count desc", 2);
        $this->vars("list", $seriesArr);
        //var_dump($seriesArr);
        $this->vars('page_title', $this->page_title);
        $this->vars("series_name", $series_name);
        $this->vars("detail", '1');
        $this->template($template_name);
    }

    function doListCheck() {
        ini_set('max_execution_time', '100');
        $template_name = "param_listcheck";
        $this->page_title = "添加";
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $this->vars('brand', $brand);
        $fields = "series_id";
        $where = "";
        $series_id = $_REQUEST[series_id];
        $this->vars('series_id', $series_id);
        if ($series_id) {
            $seriesArr = $this->series->getSeriesdata("series_id,series_name", "series_id='$series_id' and state in(3,8)", 2);
        } else {
            $seriesArr = $this->series->getSeriesdata("series_id,series_name", "state in(3,8)", 2);
        }
        $pcategory = $this->postValue('pcategory')->Int();
        $category = $this->postValue('category')->Int();
        if ($pcategory) {
            $p_where = "id='{$pcategory}'";
            $paramArr = $this->param->getPramaList("name,id,pid3", $p_where, 2);
            $category_list = $this->param->getPramaList("id,name,pid3", "pid3='{$category}'", 2);
            $this->vars("category_list", $category_list);
            $this->vars("category", $category);
            $this->vars("pcategory", $pcategory);
        } elseif ($category) {
            $p_where = "pid3={$category}";
            $paramArr = $this->param->getPramaList("name,id,pid3", $p_where, 2);
            $this->vars("category", $category);
        } else {
            $paramArr = $this->param->getPramaList("name,id,pid3", "pid3>0", 2);
        }
        $cate = $this->paramtype->getParamTypeByPid(3);
        $this->vars("cate", $cate);
        foreach ($seriesArr as $key => $value) {
            $total = $this->model->chkModel("count(model_id) as total", "state in(3,8) and series_id='$value[series_id]'", array(), 3);
            foreach ($paramArr as $kk => $vv) {
                $num = $this->model->chkModel("count(model_id) as unm", "st$vv[id]='标配' and state in(3,8) and series_id='$value[series_id]'", array(), 3);
                $state = $this->series_settings->getSettingList("state", "series_id='$value[series_id]' and st_id='$vv[id]'", 3);

                $paramArr[$kk]['num'] = $num;
                $paramArr[$kk]['state'] = $state ? $state : 2;
                $nums[$kk] = $num;
                $names[$kk] = $vv[name];
            }
            //多维数组排序
            array_multisort($nums, SORT_DESC, $names, SORT_ASC, $paramArr);
            $seriesArr[$key]['list'] = $paramArr;
            $seriesArr[$key]['total'] = $total;
        }

        $this->vars("list", $seriesArr);
        $this->vars("series_name", $seriesArr[0][series_name]);
        $this->vars('page_title', $this->page_title);
        $this->template($template_name);
    }

    function docheckadd() {
        $series_id = $this->postValue('series_id')->Int();
        if (!$series_id)
            return false;
        $pro_name = '';
        $this->series_settings->limit = 0;
        $this->series_settings->where = "series_id='$series_id'";
        $this->series_settings->del();
        $st_id = $this->postValue('st_id')->Val();
        if ($st_id) {
            $username = session('username');
            $user_id = session('user_id');
            foreach ($st_id as $key => $value) {
                $st_arr = explode('-', $value);
                $name = $this->param->getPramaList("name", "id='$st_arr[0]'", 3);
                $this->series_settings->ufields = array(
                    "st_id" => $st_arr[0],
                    "series_id" => $series_id,
                    "st_name" => $name,
                    "created" => $this->timestamp,
                    "updated" => $this->timestamp,
                    "model_count" => $st_arr[1],
                    "user_id" => $user_id,
                    "username" => $username,
                    "state" => 1,
                );
                $this->series_settings->insert();
                $pro_name .=$name . ',';
            }
            $pro_name = rtrim($pro_name, ',');
        }

        $this->series->ufields = array("prosetting" => $pro_name);
        $this->series->where = "series_id='{$series_id}'";
        $this->series->update();

        $this->alert("添加完成", 'js', 2);
    }

    function doCheckDel() {
        $id = $this->getValue('id')->Int();
        $series_id = $this->getValue('series_id')->Int();

        $this->series_settings->where = "series_id='{$series_id}' and id='{$id}'";
        $ret = $this->series_settings->del();
        if ($ret) {
            $msg = "删除成功";
        } else {
            $msg = "删除失败";
        }
        $this->alert("$msg", 'js', 2);
    }

    function doDel() {
        $id = $this->getValue('id')->Int();
        $page = $this->getValue('page')->Int();
        $qs = $this->getValue('qs')->String();
        $qs = base64_decode($qs);

        $this->param->where = "id='{$id}'";
        $ret = $this->param->del();
        $this->series_settings->where = "st_id='{$id}'";
        $this->series_settings->del();
        if ($ret) {
            $msg = "成功";
        } else {
            $msg = "失败";
        }
        $this->alert("参数类别删除{$msg}!", 'js', 3, $_ENV['PHP_SELF'] . $qs);
    }

    //配置排序
    function doOrderList() {
        $template_name = "param_orderlist";

        if ($this->postValue('id')->Int()) {
            $orderby = $this->postValue('orderby')->Val();
            $old_orderby = $this->postValue('old_orderby')->Val();
            $arr = array_diff_assoc($orderby, $old_orderby);
            $p_id = $this->postValue('p_id')->Val();
            $old_p_id = $this->postValue('old_p_id')->Val();
            $arrid = array_diff_assoc($p_id, $old_p_id);
            if ($arr) {
                foreach ($arr as $key => $value) {
                    $value = intval($value);
                    if ($value > 0) {
                        $old_order = $old_orderby[$key];
                        if ($old_order > 0) {
                            if ($value > $old_order) {
                                $o_where = "orderby >$old_order and orderby<=$value order by orderby asc";
                                $new_order = $this->param->getPramaList("id,orderby", "$o_where", 2);
                                if ($new_order) {
                                    foreach ($new_order as $k => $v) {
                                        $new = $v['orderby'] - 1;
                                        $this->param->ufields = array("orderby" => $new);
                                        $this->param->where = "id='{$v[id]}'";
                                        $this->param->update();
                                    }
                                }
                            } else {
                                $o_where = "orderby>=$value and orderby <$old_order order by orderby asc";
                                $new_order = $this->param->getPramaList("id,orderby", "$o_where", 2);
                                if ($new_order) {
                                    foreach ($new_order as $k => $v) {
                                        $new = $v['orderby'] + 1;
                                        $this->param->ufields = array("orderby" => $new);
                                        $this->param->where = "id='{$v[id]}'";
                                        $this->param->update();
                                    }
                                }
                            }
                        }
                        $_id = $this->postValue('id')->Int();
                        $id = $_id[$key];
                        $this->param->ufields = array("orderby" => $value);
                        $this->param->where = "id='{$id}'";
                        $this->param->update();
                    } else {
                        $this->alert("排序只能为数字，你填写错误", 'js', 3, $_ENV['PHP_SELF'] . 'Orderlist');
                    }
                }
            } else if ($arrid) {
                foreach ($arrid as $key => $value) {
                    $id = $this->postValue('id')->Int()[$key];
                    $this->param->ufields = array("p_id" => $value);
                    $this->param->where = "id='{$id}'";
                    $this->param->update();
                }
            } else {
                
            }
        }

        $catename = $this->postValue('category')->Val();
        //特殊处理'涡轮增压  工作方式‘
        $where = "id=28 or ";
        if ($catename) {
            $where .="pid3='{$catename}' order by orderby asc";
        } else {
            $where .="pid3<>0 order by orderby asc";
        }

        $paramlist = $this->param->getPramaList("*", "$where", 2);
        $cate = $this->paramtype->getParamTypeByPid(3);
        $this->vars("catename", $catename);
        $this->vars("cate", $cate);
        $this->vars("list", $paramlist);
        $this->template($template_name);
    }

    //导入配置排序
    function doOrderimportant() {
        $template_name = "param_orderimportant";
        $this->template($template_name);
    }

    //导入配置排序
    function doOrderimportantList() {

        set_time_limit(0);
        $uploadName = 'dealer_price';
        $ext = end(explode('.', $_FILES[$uploadName]['name']));
        if ($ext != 'csv')
            $this->alert('文件类型不正确,请上传csv文件！', 'js', 3, $_ENV['PHP_SELF'] . 'Orderimportant');
        $groupbuy = new groupbuy();
        $dir = 'dealerprice';
        $path = $groupbuy->uploadPic($uploadName, $dir);
        $str = file_get_contents(ATTACH_DIR . 'images/' . $path);
        //var_dump($str);exit;
        $arr = explode("\r\n", $str);
        array_pop($arr);
        foreach ($arr as $key => $row) {
            $dprice = explode(',', $row);
            if ($key == 0) {
                if (($dprice[0] != '配置' && $dprice[2] != '新排序')) {

                    $this->alert("导入配置排序的格式有误，请检查后重试", 'js', 3, $_ENV['PHP_SELF'] . 'Orderimportant');
                }
            }

            if (empty($dprice[0]))
                continue;
            if (empty($dprice[2]))
                continue;
            $name = $dprice[0];
            $ordernum = intval($dprice[2]);
            if ($name == '涡轮增压') {
                $id = 28;
            } else {
                $id = $this->param->getPramaList("id", "name='$name'", 3);
            }

            // start 更新cardb_modelprice中对应的内容
            if ($id) {
                $this->param->ufields = array("orderby" => $ordernum);
                $this->param->where = "id='{$id}'";
                $this->param->update();
            }
        }

        $this->doOrderList();
    }

    function doJson() {
        $pid3 = $this->getValue('pid')->Int();
        if (!$pid3)
            return false;

        $parmtype = array();
        $ret = $this->param->getPramaList("id,name,pid3", "pid3=$pid3", 2);

        foreach ($ret as $key => $value) {
            $parmtype[] = array(
                'id' => $value['id'],
                'name' => iconv('gbk', 'utf-8', $value['name']),
                'pid3' => $value['pid3'],
            );
        }
        echo json_encode($parmtype);
    }

}

?>
