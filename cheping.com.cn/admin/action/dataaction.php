<?php

/**
 * $Id: dataaction.php 2684 2016-05-16 08:55:56Z wangqin $
 */
class dataAction extends action {

    var $state = array(
        0 => "删除",
        1 => "草稿",
        2 => "待审核",
        6 => "待审核(缺参数)",
        3 => "正常",
        7 => "正常(缺参数)",
        4 => "未通过",
        5 => "屏蔽",
        9 => "停产",
    );

    function __construct() {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, 'sys_module', 206, 'A');

        parent::__construct();
        $this->factory = new factory();
        $this->brand = new brand();
        $this->series = new series();
        $this->model = new cardbModel();
        $this->upload = new uploadFile();
        $this->realdata = new realdata();
        $this->color = new color();
        $this->salestate = new cardbsalestate();
    }

    function doDefault() {
        $this->tpl_file = "data_list";
        $this->page_title = "统计列表";

        $data = array();
        //统计
        $total = 0;
        foreach ($this->state as $key => $value) {
            $result = $this->brand->getDatabyState($key);
            $data["品牌"]["total"]+=$result;
            $data["品牌"]["state"][$value] = $result;
            $data["品牌"]["detail"] = "detail&act=brand";

            $result = $this->factory->getDatabyState($key);
            $data["厂商"]["total"]+=$result;
            $data["厂商"]["state"][$value] = $result;
            $data["厂商"]["detail"] = "detail&act=factory";
            $result = $this->series->getDatabyState($key);
            $data["车系"]["total"]+=$result;
            $data["车系"]["state"][$value] = $result;
            $data["车系"]["detail"] = "detail&act=series";

            $result = $this->model->getDatabyState($key);
            $data["车型"]["total"]+=$result;
            $data["车型"]["state"][$value] = $result;
        }
        $this->tpl->assign("state", $this->state);
        $this->tpl->assign("data", $data);
        $this->tpl->assign('page_title', $this->page_title);
        $this->template();
    }

    function doPic() {
        $this->tpl_file = "datapic_list";
        $this->page_title = "图片关联统计";

        $data = array();
        //车系关联图片
//        $where="1 and state='3'";//正常状态车系总数
        $where = " 1 and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.state='3'";
        $data["车系"]["total"] = $this->series->getPic($where);

        $where = " 1 and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.state='3' and series_pic<>'' "; //正常状态已关联车系总数
        $data["车系"]["state"]["已上传车系图"] = $this->series->getPic($where);

        $where = "1 and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.state='3' and series_pic is null "; //正常状态已关联车系总数
        $data["车系"]["state"]["未上传车系图"] = $this->series->getPic($where);

        $where = " 1 and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.state='3' and s.last_picid<>'0' "; //正常状态已关联车系总数
        $data["车系"]["state"]["已实拍"] = $this->series->getPic($where);

        $where = "1 and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.state='3' and s.last_picid='0' "; //正常状态已关联车系总数
        $data["车系"]["state"]["未实拍"] = $this->series->getPic($where);

        $data["车系"]["detail"] = "detail&act=series";

        //车款关联图片
        $where = "1 and state='3'"; //正常状态车系总数
        $data["车款"]["total"] = $this->model->getPic($where);

        $where = "1 and state='3' and unionpic='1'"; //正常状态已关联车系总数
        $data["车款"]["state"]["已关联"] = $this->model->getPic($where);

        $where = "1 and state='3' and unionpic='0'"; //正常状态已关联车系总数
        $data["车款"]["state"]["未关联"] = $this->model->getPic($where);
//        $this->model->getPic();
//        print_r($data);exit;
        $this->tpl->assign('page_title', $this->page_title);
        $this->tpl->assign("data", $data);
        $this->template();
    }

    function doKeyword() {
        $this->tpl_file = "keyword_list";
        $this->page_title = "关键字统计";

        $data = array();

        //已填关键字的品牌
        $where = " keyword<>'' and state='3' ";
        $this->brand->getAllBrand($where);
        $data["品牌"]["keyword"]["已设关键字"] = $this->brand->total;
        $data["品牌"]["total"]+=$this->brand->total;

        //已填关键字的品牌
        $where = " keyword='' and state='3' ";
        $this->brand->getAllBrand($where);
        $data["品牌"]["keyword"]["未设关键字"] = $this->brand->total;
        $data["品牌"]["total"]+=$this->brand->total;
        $data["品牌"]["detail"] = "keyworddetail&act=brand";

        //已填关键字的品牌
        $where = " 1 and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.keyword<>'' and s.state='3' ";
        $this->series->getAllSeries($where);
        $data["车系"]["keyword"]["已设关键字"] = $this->series->total;
        $data["车系"]["total"]+=$this->series->total;
        //已填关键字的品牌
        $where = " 1 and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.keyword='' and s.state='3' ";
        $this->series->getAllSeries($where);
        $data["车系"]["keyword"]["未设关键字"] = $this->series->total;
        $data["车系"]["total"]+=$this->series->total;
        $data["车系"]["detail"] = "keyworddetail&act=series";

        $this->tpl->assign('page_title', $this->page_title);
        $this->tpl->assign("data", $data);
        $this->template();
    }

    function doKeyworddetail() {
        $this->tpl_file = "keyword_detail";
        $this->page_title = "关键字统计";

        $data = array();
        $act = $_GET["act"];
        $state = $_GET["state"];
        $where = " 1 ";
        if ($state == 1) {
            if ($act == "series") {
                $where .= " and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.keyword<>'' and s.state='3' ";
                $this->tpl->assign('temp', "已设关键字 车系");
            } else {
                $where .= " and keyword<>'' and state='3' ";
                $this->tpl->assign('temp', "已设关键字 品牌");
            }
        } else if ($state == 2) {
            if ($act == "series") {
                $where .= " and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.keyword='' and s.state='3' ";
                $this->tpl->assign('temp', "未设关键字 车系");
            } else {
                $where .= " and keyword='' and state='3' ";
                $this->tpl->assign('temp', "未设关键字 品牌");
            }
        }
        $fun = "getAll" . ucwords($act);
        $data = $this->$act->$fun($where);
//        print_r($data);exit;
        $this->tpl->assign($act, $data);
        $this->tpl->assign('total', $this->$act->total);
        $this->tpl->assign('page_title', $this->page_title);
        $this->template();
    }

    function doSeriespic() {
        $this->tpl_file = "data_detail";
        $page_title = "关联图片车系";
        $temp = "";
        if ($_GET["picstate"] == "1") {
            $where = "1 and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.state='3' and series_pic<>''";
            $temp = "已上传车系图车系";
        } else if ($_GET["picstate"] == "0") {
            $where = "1 and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.state='3' and series_pic is null ";
            $temp = "未上传车系图车系";
        } else if ($_GET["picstate"] == "2") {
            $where = "1 and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.state='3' and s.last_picid<>'0' ";
            $temp = "已实拍图片车系";
        } else if ($_GET["picstate"] == "3") {
            $where = "1 and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.state='3' and s.last_picid='0' ";
            $temp = "未实拍图片车系";
        } else {
            $where = "1 and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.state='3' and series_pic<>''";
            $temp = "已上传车系图车系";
        }
        $series = $this->series->getAllSeries($where);
        $this->tpl->assign('temp', $temp);
        $this->tpl->assign('page_title', $page_title);
        $this->tpl->assign('series', $series);
        $this->tpl->assign('total', $this->series->total);
        $this->template();
    }

    function doDetail() {
        $this->tpl_file = "data_detail";

        $act = $_GET["act"] ? $_GET["act"] : "brand";
        $state = $_GET["state"] ? $_GET["state"] : "0";
        $page_title = "";
        $st = $this->state;
        switch ($act) {
            case "brand":
                $result = $this->$act->getData($state);
                $page_title = $st[$state] . "状态品牌";
                break;
            case "factory":
                $result = $this->$act->getData($state);
                $page_title = $st[$state] . "状态厂商";
                break;
            case "series";
                $where = "1 and state='$state'";
                $series = $this->$act->getData($where);
                $page_title = $st[$state] . "状态车系";
                break;
            default:
                $this->doDefault();
                break;
        }
        $this->page_title = $page_title;
        $this->tpl->assign('page_title', $this->page_title);
        if (!empty($result)) {
            $this->tpl->assign('result', $result);
        }
        if (!empty($series)) {
            $this->tpl->assign('series', $series);
        }
        $this->template();
    }

    //新车系统计
    function doSeries() {
        $this->tpl_file = "statistics_series";
        $this->page_title = "车系统计";
        $data = array();
        $result = $this->series->getSeriesFields("type_name,last_picid,default_model,pros,cons,prosetting,compete_id", "state=3", 2);
        if ($result) {
            foreach ($result as $key => $value) {
                //车系级别是否已设置
                if ($value['type_name']) {
                    $data['车系级别']['已设置'][total] +=1;
                    $data['车系级别']['已设置'][state] = 1;
                } else {
                    $data['车系级别']['未设置'][total] +=1;
                    $data['车系级别']['未设置'][state] = 2;
                }
                //默认车款是否设置
                if ($value['last_picid'] || $value['default_model']) {
                    $data['默认车款']['已设置'][total] +=1;
                    $data['默认车款']['已设置'][state] = 3;
                } else {
                    $data['默认车款']['未设置'][total] +=1;
                    $data['默认车款']['未设置'][state] = 4;
                }
                //专家评论是否已填写
                if ($value['pros'] && $value['cons']) {
                    $data['专家评论']['已设置'][total] +=1;
                    $data['专家评论']['已设置'][state] = 5;
                } else {
                    $data['专家评论']['未设置'][total] +=1;
                    $data['专家评论']['未设置'][state] = 6;
                }
                //车系的亮点配置
                if ($value['prosetting']) {
                    $data['亮点配置']['已设置'][total] +=1;
                    $data['亮点配置']['已设置'][state] = 9;
                } else {
                    $data['亮点配置']['未设置'][total] +=1;
                    $data['亮点配置']['未设置'][state] = 10;
                }
                //车系的竞争车系
                if ($value['compete_id']) {
                    $data['竞争车系']['已设置'][total] +=1;
                    $data['竞争车系']['已设置'][state] = 13;
                } else {
                    $data['竞争车系']['未设置'][total] +=1;
                    $data['竞争车系']['未设置'][state] = 14;
                }

                $data['外观白底图']['已上传'][state] = 7;
                $data['外观白底图']['未上传'][state] = 8;
                $data['外观实拍图']['已上传'][state] = 11;
                $data['外观实拍图']['未上传'][state] = 12;   
            }
        }
        $data['外观白底图']['已上传'][state] = 7;
        $data['外观白底图']['未上传'][state] = 8;
        $data['外观实拍图']['已上传'][state] = 11;
        $data['外观实拍图']['未上传'][state] = 12;

        //统计正常车系的车款
        $carnormal = $this->series->getCarNormals();
        foreach ($carnormal as $k => $v) {
            if ($v['total'] != 0) {
                $data['有正常车款']['正常'][total] +=1;
                $data['有正常车款']['正常'][state] = 15;
            } else {
                $data['无正常车款']['不正常'][total] +=1; //统计结果的个数
                $data['无正常车款']['不正常'][state] = 16;
            }
        }

        $this->vars('total', count($result)); //显示总数
        $this->vars('data', $data);
        $this->template();
    }

    function doSeriesDetail() {
        $this->tpl_file = "statistics_series_detail";
        $this->page_title = "车系统计";
        $page = $_GET['page'];
        $page = max(1, $page);
        $extra = "&page=" . $page;
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $this->tpl->assign('brand', $brand);
        $state = $_REQUEST[state];
        $extra = "&state=" . $state;
        $where = "state in(3)";

        if ($_REQUEST[brand_id]) {
            $factory = $this->factory->getFactorylist("factory_id,factory_name", "brand_id=$_REQUEST[brand_id] and state=3", 2);
            $this->vars("factory", $factory);
            $where .=" and brand_id=$_REQUEST[brand_id]";
            $this->vars("brand_id", $_REQUEST[brand_id]);
            $extra .="&brand_id=" . $_REQUEST[brand_id];
            $ser = $this->series->getSeriesFields("series_id", "brand_id=$_REQUEST[brand_id] and state=3", 2);
            foreach ($ser as $key => $value) {
                $seriesid .=$value[series_id] . ',';
            }
            $seriesid = rtrim($seriesid, ',');
        }

        if ($_REQUEST[factory_id]) {
            $series = $this->series->getSeriesFields("series_id,series_name", "factory_id=$_REQUEST[factory_id] and state=3", 2);
            $this->vars("series", $series);
            $where .=" and factory_id=$_REQUEST[factory_id]";
            $this->vars("factory_id", $_REQUEST[factory_id]);
            $extra .="&factory_id=" . $_REQUEST[factory_id];
            $ser = $this->series->getSeriesFields("series_id", "factory_id=$_REQUEST[factory_id] and state=3", 2);
            foreach ($ser as $key => $value) {
                $seriesid .=$value[series_id] . ',';
            }
            $seriesid = rtrim($seriesid, ',');
        }

        if ($_REQUEST[series_id]) {
            $model = $this->model->chkModel("model_id,model_name", "series_id=$_REQUEST[series_id] and state=3", '', 2);
            $this->vars("model", $model);
            $where .=" and series_id=$_REQUEST[series_id]";
            $this->vars("series_id", $_REQUEST[series_id]);
            $extra .="&series_id=" . $_REQUEST[series_id];
            $seriesid = $_REQUEST[series_id];
        }
        $data = array();
        if ($state == 1) {
            $where .=" and type_name!=''";
            $total = $this->series->getSeriesdata("count(series_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->series->getSeriesdata("series_id,brand_name,series_name,factory_name,state", "$where", 2);
        } elseif ($state == 2) {
            $where .=" and type_name=''";
            $total = $this->series->getSeriesdata("count(series_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->series->getSeriesdata("series_id,brand_name,series_name,factory_name,state", "$where", 2);
        } elseif ($state == 3) {
            $where .=" and (last_picid!='' or default_model!='')";
            $total = $this->series->getSeriesdata("count(series_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->series->getSeriesdata("series_id,brand_name,series_name,factory_name,state", "$where", 2);
        } elseif ($state == 4) {
            $where .=" and last_picid='' and default_model=''";
            $total = $this->series->getSeriesdata("count(series_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->series->getSeriesdata("series_id,brand_name,series_name,factory_name,state", "$where", 2);
        } elseif ($state == 5) {
            $where .=" and sale_value!=''";
            $total = $this->series->getSeriesdata("count(series_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->series->getSeriesdata("series_id,brand_name,series_name,factory_name,state", "$where", 2);
        } elseif ($state == 6) {
            $where .=" and pros=''";
            $total = $this->series->getSeriesdata("count(series_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->series->getSeriesdata("series_id,brand_name,series_name,factory_name,state", "$where", 2);
        } elseif ($state == 9) {
            $where .=" and prosetting!=''";
            $total = $this->series->getSeriesdata("count(series_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->series->getSeriesdata("series_id,brand_name,series_name,factory_name,state", "$where", 2);
        } elseif ($state == 10) {
            $where .=" and prosetting=''";
            $total = $this->series->getSeriesdata("count(series_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->series->getSeriesdata("series_id,brand_name,series_name,factory_name,state", "$where", 2);
        } elseif ($state == 13) {
            $where .=" and compete_id!=''";
            $total = $this->series->getSeriesdata("count(series_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->series->getSeriesdata("series_id,brand_name,series_name,factory_name,state", "$where", 2);
        } elseif ($state == 14) {
            $where .=" and compete_id=''";
            $total = $this->series->getSeriesdata("count(series_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->series->getSeriesdata("series_id,brand_name,series_name,factory_name,state", "$where", 2);
        } elseif ($state == 15) {
            $where = "s.state=3";
            $brands = $_POST['brand_id'];
            $factory_id = $_POST['factory_id'];
            $series_id = $_POST['series_id'];
            if ($brands) {
                $where .=" and s.brand_id=" . $brands;
            }
            if ($factory_id) {
                $where .=" and s.factory_id=" . $factory_id;
            }
            if ($series_id) {
                $where .=" and s.series_id=" . $series_id;
            }

            $totals = $this->series->getCarNormal($where);
            foreach ($totals as $key => $value) {
                if ($value[total] != 0) {
                    $data[] = $value;
                }
            }
        } elseif ($state == 16) {
            $where = "s.state=3";
            $brands = $_POST['brand_id'];
            $factory_id = $_POST['factory_id'];
            $series_id = $_POST['series_id'];
            if ($brands) {
                $where .=" and s.brand_id=" . $brands;
            }
            if ($factory_id) {
                $where .=" and s.factory_id=" . $factory_id;
            }
            if ($series_id) {
                $where .=" and s.series_id=" . $series_id;
            }

            $totals = $this->series->getCarNormal($where);
            foreach ($totals as $key => $value) {
                if ($value[total] == 0) {
                    $data[] = $value;
                }
            }
        }
        //外观白底图
        if ($state == 7 || $state == 8) {
//            var_dump($state);
            $result = $this->series->getSeriesdata("series_id,brand_name,series_name,factory_name,state", "$where", 2); //查询厂商品牌等字段状态为3的
            if ($result) {
                foreach ($result as $key => $value) {
                    //外观白底图是否已上传
                    $style = $this->model->getStyleRange($value[series_id]); //查询
                    $tmp = array();
                    $style_status = false;
                    foreach ($style as $k => $v) {
                        $v['st4_id'] = array_search($v['st4'], $this->series->st4_list); //从字符串里查询
                        $v['st21_id'] = array_search($v['st21'], $this->series->st21_list);

                        $v['id'] = $v['st4_id'] . "_" . $v['st21_id'] . '_' . $v['date_id'];
                        $p = $this->upload->getStylePic($value[series_id], $v['st4_id'], $v['st21_id'], $v['date_id'],$type = 0);
                        if ($p['name']) {
                            $style_status = true;
                        } else {
                            $style_status = false;
                            break;
                        }
                    }
                    if ($style_status) {
                        $data1[] = $value;
                    } else {
                        $data2[] = $value;
                    }
                }
            }
            if ($state == 7) {
                if (!empty($data1)) {
                    $total = count($data1);

                    $data = array_slice($data1, $page_start, $page_size);
                }
            }
            if ($state == 8) {
                if (!empty($data2)) {
                    $total = count($data2);
                    $data = array_slice($data2, $page_start, $page_size);
                }
            }
        }
        //外观实拍图
        if ($state == 11 || $state == 12) {
            $result = $this->series->getSeriesdata("series_id,brand_name,series_name,factory_name,state", "$where", 2); //查询厂商品牌等字段状态为3的
            if ($result) {
                foreach ($result as $key => $value) {
                    //外观白底图是否已上传
                    $style1 = $this->model->getStyleRange($value[series_id]); //查询
                    $tmp = array();
                    $style1_status = false;
                    foreach ($style1 as $k => $v) {
                        $v['st4_id'] = array_search($v['st4'], $this->series->st4_list); //从字符串里查询
                        $v['st21_id'] = array_search($v['st21'], $this->series->st21_list);

                        $v['id'] = $v['st4_id'] . "_" . $v['st21_id'] . '_' . $v['date_id'];
                        $p1 = $this->upload->getStylePic($value[series_id], $v['st4_id'], $v['st21_id'], $v['date_id'], $type = 1);
                        if ($p1['name']) {
                            $style1_status = true;
                        } else {
                            $style1_status = false;
                            break;
                        }
                    }
                    if ($style1_status) {
                        $data3[] = $value;
                    } else {
                        $data4[] = $value;
                    }
                }
            }
            if ($state == 11) {
                if (!empty($data3)) {
                    $total = count($data3);
                    $data = array_slice($data3, $page_start, $page_size);
                }
            }
            if ($state == 12) {
                if (!empty($data4)) {
                    $total = count($data4);
                    $data = array_slice($data4, $page_start, $page_size);
                }
            }
        }

        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . 'seriesdetail' . $extra);
        $this->vars('page_bar', $page_bar);
        $this->vars("state", $state);
        $this->vars("data", $data);
        $this->template();
    }
 /**
     * 处理外观白底图外观实拍图的查看显示数字
     * @param $datas  获取ajax传来的状态变量
     * return array    $total
     */
    function doCountAjax() {
        $datas = $_REQUEST['datas'];
        if ($datas) {
            //外观白底图是否已上传
            $result = $this->series->getSeriesdata("series_id", "state=3", 2);
            if ($result) {
                foreach ($result as $key => $value) {
                    $style = $this->model->getStyleRange($value[series_id]);
                    $style_status = $style1_status = $style_ok = $style1_ok = false;
                    foreach ($style as $k => $v) {
                        $v['st4_id'] = array_search($v['st4'], $this->series->st4_list);
                        $v['st21_id'] = array_search($v['st21'], $this->series->st21_list);
                        $v['id'] = $v['st4_id'] . "_" . $v['st21_id'] . '_' . $v['date_id'];
                        //外观白底图
                        if ($style_ok === FALSE) {
                            $p = $this->upload->getStylePic($value[series_id], $v['st4_id'], $v['st21_id'], $v['date_id'],$type = 0); //查询图片表里是否有上传的图片
                            if ($p['name']) {
                                $style_status = true;
                            } else {
                                $style_status = false;
                                $style_ok = true;
                            }
                        }
                        //外观实拍图
                        if ($style1_ok === FALSE) {
                            $p1 = $this->upload->getStylePic($value[series_id], $v['st4_id'], $v['st21_id'], $v['date_id'], $type = 1);
                            if ($p1['name']) {
                                $style1_status = true;
                            } else {
                                $style1_status = false;
                                $style1_ok = true;
                            }
                        }
                        #外观白底图和外观实拍图都查完
                        if ($style_ok && $style1_ok) {
                            break;
                        }
                    }

                    if ($style_status) {
                        if ($datas == 7) {
                            $total +=1;
                            echo $total;
                        }
                    } else {
                        if ($datas == 8) {
                            $total +=1;
                            echo $total;
                        }
                    }
                    // 外观实拍图未上传
                    if ($style1_status) {
                        if ($datas == 11) {
                            $total +=1;
                            echo $total;
                        }
                    } else {
                        if ($datas == 12) {
                            $total +=1;
                            echo $total;
                        }
                    }
                }
            }
        }
    }

    //车型
    function doCarModel() {
        $this->tpl_file = "statistics_carmodel";
        $this->page_title = "车型统计";
        $data = array();
        $where = "state=1";
        $totalArr = $this->realdata->getRealdata("count(id) as total", "$where");
        $total = $totalArr[0][total];
        $returnArr = $this->realdata->getRealdata("*", "$where");
        foreach ($returnArr as $key => $value) {
            //车型噪音是否已填写
            if ($value[noise] > 0) {
                $data['车型噪音']["怠速噪音"]['已填写']['total']+=1;
                $data['车型噪音']["怠速噪音"]['已填写']['state'] = 1;
            } else {
                $data['车型噪音']["怠速噪音"]['未填写']['total']+=1;
                $data['车型噪音']["怠速噪音"]['未填写']['state'] = 2;
            }
            if ($value["60perh"] > 0) {
                $data['车型噪音']['60公里/小时']['已填写']['total']+=1;
                $data['车型噪音']["60公里/小时"]['已填写']['state'] = 3;
            } else {
                $data['车型噪音']["60公里/小时"]['未填写']['total']+=1;
                $data['车型噪音']["60公里/小时"]['未填写']['state'] = 4;
            }
            if ($value["80perh"] > 0) {
                $data['车型噪音']["80公里/小时"]['已填写']['total']+=1;
                $data['车型噪音']["80公里/小时"]['已填写']['state'] = 5;
            } else {
                $data['车型噪音']["80公里/小时"]['未填写']['total']+=1;
                $data['车型噪音']["80公里/小时"]['未填写']['state'] = 6;
            }
            if ($value["120perh"] > 0) {
                $data['车型噪音']["120公里/小时"]['已填写']['total']+=1;
                $data['车型噪音']["120公里/小时"]['已填写']['state'] = 7;
            } else {
                $data['车型噪音']["120公里/小时"]['未填写']['total']+=1;
                $data['车型噪音']["120公里/小时"]['未填写']['state'] = 8;
            }

            //车型实测油耗是否已填写

            if ($value["mileage"] > 0) {
                $data['车型实测油耗']["测试总里程"]['已填写']['total']+=1;
                $data['车型实测油耗']["测试总里程"]['已填写']['state'] = 9;
            } else {
                $data['车型实测油耗']["测试总里程"]['未填写']['total']+=1;
                $data['车型实测油耗']["测试总里程"]['未填写']['state'] = 10;
            }
            if ($value["fuel"] > 0) {
                $data['车型实测油耗']["燃油总量"]['已填写']['total']+=1;
                $data['车型实测油耗']["燃油总量"]['已填写']['state'] = 11;
            } else {
                $data['车型实测油耗']["燃油总量"]['未填写']['total']+=1;
                $data['车型实测油耗']["燃油总量"]['未填写']['state'] = 12;
            }
            if ($value["fuel_hour"] > 0) {
                $data['车型实测油耗']["综合油耗"]['已填写']['total']+=1;
                $data['车型实测油耗']["综合油耗"]['已填写']['state'] = 13;
            } else {
                $data['车型实测油耗']["综合油耗"]['未填写']['total']+=1;
                $data['车型实测油耗']["综合油耗"]['未填写']['state'] = 14;
            }

            //车型4S保养是否已填写
            if ($value["oil_level"]) {
                $data['车型4S保养']["原厂指定机油"]['已填写']['total'] +=1;
                $data['车型4S保养']["原厂指定机油"]['已填写']['state'] = 15;
            } else {
                $data['车型4S保养']["原厂指定机油"]['未填写']['total'] +=1;
                $data['车型4S保养']["原厂指定机油"]['未填写']['state'] = 16;
            }
            if ($value["change_cycle"]) {
                $data['车型4S保养']["换油周期"]['已填写']['total'] +=1;
                $data['车型4S保养']["换油周期"]['已填写']['state'] = 17;
            } else {
                $data['车型4S保养']["换油周期"]['未填写']['total'] +=1;
                $data['车型4S保养']["换油周期"]['未填写']['state'] = 18;
            }
            if ($value["oil_filter"]) {
                $data['车型4S保养']["机油机滤"]['已填写']['total'] +=1;
                $data['车型4S保养']["机油机滤"]['已填写']['state'] = 19;
            } else {
                $data['车型4S保养']["机油机滤"]['未填写']['total'] +=1;
                $data['车型4S保养']["机油机滤"]['未填写']['state'] = 20;
            }
            if ($value["oil_3filter"]) {
                $data['车型4S保养']["机油三滤"]['已填写']['total'] +=1;
                $data['车型4S保养']["机油三滤"]['已填写']['state'] = 21;
            } else {
                $data['车型4S保养']["机油三滤"]['未填写']['total'] +=1;
                $data['车型4S保养']["机油三滤"]['未填写']['state'] = 22;
            }
            //车型国家补贴是否已填写
            if ($value["conservate"]) {
                $data['车型国家补贴']["节能补贴"]['已填写']['total'] +=1;
                $data['车型国家补贴']["节能补贴"]['已填写']['state'] = 23;
            } else {
                $data['车型国家补贴']["节能补贴"]['未填写']['total'] +=1;
                $data['车型国家补贴']["节能补贴"]['未填写']['state'] = 24;
            }
            if ($value["purcharse_tax"]) {
                $data['车型国家补贴']["车船税减免"]['已填写']['total'] +=1;
                $data['车型国家补贴']["车船税减免"]['已填写']['state'] = 25;
            } else {
                $data['车型国家补贴']["车船税减免"]['未填写']['total'] +=1;
                $data['车型国家补贴']["车船税减免"]['未填写']['state'] = 26;
            }
            if ($value["new_energy"]) {
                $data['车型国家补贴']["新能源补贴"]['已填写']['total'] +=1;
                $data['车型国家补贴']["新能源补贴"]['已填写']['state'] = 27;
            } else {
                $data['车型国家补贴']["新能源补贴"]['未填写']['total'] +=1;
                $data['车型国家补贴']["新能源补贴"]['未填写']['state'] = 28;
            }
        }
        $this->vars('total', $total);
        $this->vars('data', $data);
        $this->template();
    }

    function doCarModelDetail() {
        $this->tpl_file = "statistics_carmodel_detail";
        $this->page_title = "车型统计";
        $page = $_GET['page'];
        $page = max(1, $page);
        $extra = "&page=" . $page;
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $this->tpl->assign('brand', $brand);
        $state = $_REQUEST[state];
        $extra = "&state=" . $state;

        if ($_REQUEST[brand_id]) {
            $factory = $this->factory->getFactorylist("factory_id,factory_name", "brand_id=$_REQUEST[brand_id] and state=3", 2);
            $this->vars("factory", $factory);
            $where .=" and brand_id=$_REQUEST[brand_id]";
            $this->vars("brand_id", $_REQUEST[brand_id]);
            $extra .="&brand_id=" . $_REQUEST[brand_id];
            $ser = $this->series->getSeriesFields("series_id", "brand_id=$_REQUEST[brand_id] and state=3", 2);
            foreach ($ser as $key => $value) {
                $seriesid .=$value[series_id] . ',';
            }
            $seriesid = rtrim($seriesid, ',');
        }

        if ($_REQUEST[factory_id]) {
            $series = $this->series->getSeriesFields("series_id,series_name", "factory_id=$_REQUEST[factory_id] and state=3", 2);
            $this->vars("series", $series);
            $where .=" and factory_id=$_REQUEST[factory_id]";
            $this->vars("factory_id", $_REQUEST[factory_id]);
            $extra .="&factory_id=" . $_REQUEST[factory_id];
            $ser = $this->series->getSeriesFields("series_id", "factory_id=$_REQUEST[factory_id] and state=3", 2);
            foreach ($ser as $key => $value) {
                $seriesid .=$value[series_id] . ',';
            }
            $seriesid = rtrim($seriesid, ',');
        }
        if ($_REQUEST[series_id]) {
            $model = $this->model->chkModel("model_id,model_name", "series_id=$_REQUEST[series_id] and state=3", '', 2);
            $this->vars("model", $model);
            $where .=" and series_id=$_REQUEST[series_id]";
            $this->vars("series_id", $_REQUEST[series_id]);
            $extra .="&series_id=" . $_REQUEST[series_id];
            $seriesid = $_REQUEST[series_id];
        }
        $data = array();
        $series_name = '';
        if ($state == 1) {
            $where = "noise!=''";
            if ($seriesid) {
                $where .=" and state=1 and series_id in($seriesid)";
            }

            $noiseArr = $this->realdata->getRealdata("id,series_id, noise, 60perh, 120perh,st27,st28,st41,st48,date_id", "$where");
            if ($noiseArr) {
                foreach ($noiseArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 2) {
            $where = "(noise='' or noise is null) and state=1 ";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $noiseArr = $this->realdata->getRealdata("id,series_id, noise, 60perh,80perh, 120perh,st27,st28,st41,st48,date_id", "$where");
            #echo $this->realdata->sql;
            if ($noiseArr) {
                foreach ($noiseArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 3) {
            $where = "(60perh='' or 60perh is null) and state=1 ";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $noiseArr = $this->realdata->getRealdata("id,series_id, noise, 60perh,80perh, 120perh,st27,st28,st41,st48,date_id", "$where");
            if ($noiseArr) {
                foreach ($noiseArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 4) {
            $where = "(60perh='' or 60perh is null) and state=1 ";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $noiseArr = $this->realdata->getRealdata("id,series_id, noise, 60perh,80perh, 120perh,st27,st28,st41,st48,date_id", "$where");
            if ($noiseArr) {
                foreach ($noiseArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 5) {
            $where = "(80perh='' or 80perh is null) and state=1";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $noiseArr = $this->realdata->getRealdata("id,series_id, noise, 60perh,80perh, 120perh,st27,st28,st41,st48,date_id", "$where");
            if ($noiseArr) {
                foreach ($noiseArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 6) {
            $where = "(80perh='' or 80perh is null) and state=1";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $noiseArr = $this->realdata->getRealdata("id,series_id, noise, 60perh,80perh, 120perh,st27,st28,st41,st48,date_id", "$where");
            if ($noiseArr) {
                foreach ($noiseArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 7) {
            $where = "(120perh='' or 120perh is null) and state=1";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $noiseArr = $this->realdata->getRealdata("id,series_id, noise, 60perh,80perh, 120perh,st27,st28,st41,st48,date_id", "$where");
            if ($noiseArr) {
                foreach ($noiseArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 8) {
            $where = "(120perh='' or 120perh is null) and state=1";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $noiseArr = $this->realdata->getRealdata("id,series_id, noise, 60perh,80perh, 120perh,st27,st28,st41,st48,date_id", "$where");
            if ($noiseArr) {
                foreach ($noiseArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 9) {
            $where = " state=1 and mileage!=''";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $mieageArr = $this->realdata->getRealdata("id,road,mileage, fuel, fuel_hour,series_id,date_id,st27,st28,st41,st48,date_id", "$where");
            if ($mieageArr) {
                foreach ($mieageArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 10) {
            $where = "state=1 and (mileage='' or mileage is null)";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $mieageArr = $this->realdata->getRealdata("id,road,mileage, fuel, fuel_hour,series_id,st27,st28,st41,st48,date_id", "$where");

            if ($mieageArr) {
                foreach ($mieageArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 11) {
            $where = "state=1 and fuel!=''";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $mieageArr = $this->realdata->getRealdata("id,road,mileage, fuel, fuel_hour,series_id,date_id,st27,st28,st41,st48,date_id", "$where");
            if ($mieageArr) {
                foreach ($mieageArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 12) {
            $where = "state=1 and (fuel='' or fuel is null)";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $mieageArr = $this->realdata->getRealdata("id,road,mileage, fuel, fuel_hour,series_id,st27,st28,st41,st48,date_id", "$where");
            if ($mieageArr) {
                foreach ($mieageArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 13) {
            $where = "state=1 and fuel_hour!=''";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $mieageArr = $this->realdata->getRealdata("id,road,mileage, fuel, fuel_hour,series_id,date_id,st27,st28,st41,st48,date_id", "$where");
            if ($mieageArr) {
                foreach ($mieageArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 14) {
            $where = "state=1 and (fuel_hour='' or fuel_hour is null)";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $mieageArr = $this->realdata->getRealdata("id,road,mileage, fuel, fuel_hour,series_id,st27,st28,st41,st48,date_id", "$where");
            if ($mieageArr) {
                foreach ($mieageArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 15) {
            $where = "state=1 and oil_level!=''";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $oilArr = $this->realdata->getRealdata("id,series_id,oil_level, change_cycle, oil_3filter, st27,st28,st41,st48,date_id", "$where");
            if ($oilArr) {
                foreach ($oilArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 16) {
            $where = "state=1 and (oil_level=''or oil_level is null)";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $oilArr = $this->realdata->getRealdata("id,series_id,oil_level, change_cycle, oil_3filter,st27,st28,st41,st48,date_id ", "$where");
            if ($oilArr) {
                foreach ($oilArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 17) {
            $where = "state=1 and change_cycle!=''";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $oilArr = $this->realdata->getRealdata("id,series_id,oil_level, change_cycle, oil_3filter, st27,st28,st41,st48,date_id", "$where");
            if ($oilArr) {
                foreach ($oilArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 18) {
            $where = "state=1 and (change_cycle='' or change_cycle is null )";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $oilArr = $this->realdata->getRealdata("id,series_id,oil_level, change_cycle, oil_3filter,st27,st28,st41,st48,date_id ", "$where");
            if ($oilArr) {
                foreach ($oilArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 19) {
            $where = "state=1 and oil_filter!=''";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $oilArr = $this->realdata->getRealdata("id,series_id,oil_level, change_cycle, oil_3filter, st27,st28,st41,st48,date_id", "$where");
            if ($oilArr) {
                foreach ($oilArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 20) {
            $where = "state=1 and (oil_filter='' or oil_filter is null )";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $oilArr = $this->realdata->getRealdata("id,series_id,oil_level, change_cycle, oil_3filter,st27,st28,st41,st48,date_id ", "$where");
            if ($oilArr) {
                foreach ($oilArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 21) {
            $where = "state=1 and oil_3filter!=''";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $oilArr = $this->realdata->getRealdata("id,series_id,oil_level, change_cycle, oil_3filter, st27,st28,st41,st48,date_id", "$where");
            if ($oilArr) {
                foreach ($oilArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 22) {
            $where = "state=1 and (oil_3filter='' or oil_3filter is null)";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $oilArr = $this->realdata->getRealdata("id,series_id,oil_level, change_cycle, oil_3filter,st27,st28,st41,st48,date_id ", "$where");
            if ($oilArr) {
                foreach ($oilArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 23) {
            $where = "state=1 and conservate!=''";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $energyArr = $this->realdata->getRealdata("id,series_id,conservate, purcharse_tax, new_energy,st27,st28,st41,st48,date_id", "$where");
            if ($energyArr) {
                foreach ($energyArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 24) {
            $where = "state=1 and (conservate='' or conservate is null)";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $energyArr = $this->realdata->getRealdata("id,series_id,conservate, purcharse_tax, new_energy,st27,st28,st41,st48,date_id", "$where");
            //  echo  $this->realdata->sql;
            if ($energyArr) {
                foreach ($energyArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 25) {
            $where = "state=1 and purcharse_tax!='' and purcharse_tax!=''";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $energyArr = $this->realdata->getRealdata("id,series_id,conservate, purcharse_tax, new_energy,st27,st28,st41,st48,date_id", "$where");
            if ($energyArr) {
                foreach ($energyArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 26) {
            $where = "state=1 and ( purcharse_tax='' or purcharse_tax is null )";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $energyArr = $this->realdata->getRealdata("id,series_id,conservate, purcharse_tax, new_energy,st27,st28,st41,st48,date_id", "$where");
            //  echo  $this->realdata->sql;
            if ($energyArr) {
                foreach ($energyArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 27) {
            $where = "state=1 and  new_energy!=''";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $energyArr = $this->realdata->getRealdata("id,series_id,conservate, purcharse_tax, new_energy,st27,st28,st41,st48,date_id", "$where");
            if ($energyArr) {
                foreach ($energyArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        } elseif ($state == 28) {
            $where = "state=1 and ( new_energy='' or new_energy is null)";
            if ($seriesid) {
                $where .=" and series_id in($seriesid)";
            }
            $energyArr = $this->realdata->getRealdata("id,series_id,conservate, purcharse_tax, new_energy,st27,st28,st41,st48,date_id", "$where");
            //  echo  $this->realdata->sql;
            if ($energyArr) {
                foreach ($energyArr as $key => $value) {
                    $series_name = $this->series->getSeriesdata("series_name,brand_name,state", "series_id=$value[series_id]", 1);
                    $data[$key] = $value;
                    $data[$key][series_name] = $series_name[series_name];
                    $data[$key][brand_name] = $series_name[brand_name];
                    $data[$key][state] = $series_name[state];
                }
            }
        }

        #分页
        if (!empty($data)) {
            $page_total = count($data);
            $pages = ceil($page_total / 9);
            if ($page > $pages)
                $page = $page_total;
            $page_start = ($page - 1) * $page_size;
            $result = array_slice($data, $page_start, $page_size);
            $page_bar = $this->multi($page_total, $page_size, $page, $_ENV['PHP_SELF'] . 'carmodeldetail' . $extra);
        }

        // var_dump($data);
        $this->vars('page_bar', $page_bar);
        $this->vars("state", $state);
        $this->vars("data", $result);
        $this->template();
    }

    //车款
    function doModel() {
        $this->tpl_file = "statistics_model";
        $this->page_title = "车款统计";
        $data = array();
        $total = $this->model->getSimp("count(model_id) as total", "state in(3,6,8)", 3);
        //车款北京在售状态是否已填写
        $where = "state in(3,6,8) and model_id in(select model_id from cardb_salestate where state=3)";
        $modelArr = $this->model->getSimp("count(model_id)", "$where", 3);
        $data['车款北京在售状态']['已填写'][total] = $modelArr;
        $data['车款北京在售状态']['已填写'][state] = 1;
        $data['车款北京在售状态']['未填写'][total] = $total - $modelArr;
        $data['车款北京在售状态']['未填写'][state] = 2;

        //车款白底图是否已上传
        $where = "state in(3,6,8) and (model_pic1 !='' or model_pic2 !='') and (model_pic1 is not null or model_pic2 is not null)";
        $picArr = $this->model->getSimp("count(model_id) as total", "$where", 3);
        //  echo $this->model->sql;exit;
        $data['车款白底图']['已填写'][total] = $picArr;
        $data['车款白底图']['已填写'][state] = 3;
        $data['车款白底图']['未填写'][total] = $total - $picArr;
        $data['车款白底图']['未填写'][state] = 4;
        //车款对手车款是否已填写
        $where = "state in(3,6,8) and compete_id is not null and compete_id!=''";
        $comptetArr = $this->model->getSimp("count(model_id) as total", "$where", 3);
        // echo $this->model->sql;exit;
        $data['车款对手车款']['已填写'][total] = $comptetArr;
        $data['车款对手车款']['已填写'][state] = 5;
        $data['车款对手车款']['未填写'][total] = $total - $comptetArr;
        $data['车款对手车款']['未填写'][state] = 6;
        //车款热度是否已设置
        $where = "state in(3,6,8) and views!='' and views is not null ";
        $viewArr = $this->model->getSimp("count(model_id) as total", "$where", 3);
        //echo $this->model->sql;exit;
        $data['车款热度']['已设置'][total] = $viewArr;
        $data['车款热度']['已设置'][state] = 7;
        $data['车款热度']['未设置'][total] = $total - $viewArr;
        $data['车款热度']['未设置'][state] = 8;
        //车款颜色块是否已匹配
        $color = $this->color->getColorList("type_id", "type_name='model' AND color_pic ='' group by type_id", 2);
        foreach ($color as $key => $value) {
            $modelid .=$value[type_id] . ',';
        }
        $modelid = rtrim($modelid, ',');
        $where = "state in(3,6,8) and model_id in($modelid)";
        $colorArr = $this->model->getSimp("count(model_id)", "$where", 3);
        $data['车款颜色块']['已匹配'][total] = $total - $colorArr;
        $data['车款颜色块']['已匹配'][state] = 9;
        $data['车款颜色块']['未匹配'][total] = $colorArr;
        $data['车款颜色块']['未匹配'][state] = 10;
        //车款弹性元件是否设置219，220
        $where = "state in(3,6,8) and st219!='' and st220!=''";
        $stArr = $this->model->getSimp("count(model_id) as total", "$where", 3);
        //echo $this->model->sql;exit;
        $data['车款弹性元件']['已设置'][total] = $stArr;
        $data['车款弹性元件']['已设置'][state] = 11;
        $data['车款弹性元件']['未设置'][total] = $total - $stArr;
        $data['车款弹性元件']['未设置'][state] = 12;

        $this->vars("total", $total);
        $this->vars("data", $data);
        $this->template();
    }

    function doModelDetail() {
        $this->tpl_file = "statistics_model_detail";
        $this->page_title = "车款统计";
        $page = $_GET['page'];
        $page = max(1, $page);
        $extra = "&page=" . $page;
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $this->tpl->assign('brand', $brand);
        $data = array();
        $where = "state in(3,6,8)";
        $state = $_REQUEST[state];
        $extra = "&state=" . $state;
        if ($_REQUEST[series_id]) {
            $model = $this->model->chkModel("model_id,model_name", "series_id=$_REQUEST[series_id] and state=3", '', 2);
            $this->vars("model", $model);
            $where .=" and series_id=$_REQUEST[series_id]";
            $this->vars("series_id", $_REQUEST[series_id]);
            $extra .="&series_id=" . $_REQUEST[series_id];
        }
        if ($_REQUEST[factory_id]) {
            $series = $this->series->getSeriesFields("series_id,series_name", "factory_id=$_REQUEST[factory_id] and state=3", 2);
            $this->vars("series", $series);
            $where .=" and factory_id=$_REQUEST[factory_id]";
            $this->vars("factory_id", $_REQUEST[factory_id]);
            $extra .="&factory_id=" . $_REQUEST[factory_id];
        }
        if ($_REQUEST[brand_id]) {
            $factory = $this->factory->getFactorylist("factory_id,factory_name", "brand_id=$_REQUEST[brand_id] and state=3", 2);
            $this->vars("factory", $factory);
            $where .=" and brand_id=$_REQUEST[brand_id]";
            $this->vars("brand_id", $_REQUEST[brand_id]);
            $extra .="&brand_id=" . $_REQUEST[brand_id];
        }
        if ($_REQUEST[model_id]) {
            $where .=" and model_id=$_REQUEST[model_id]";
            $this->vars("model_id", $_REQUEST[model_id]);
            $extra .="&model_id=" . $_REQUEST[model_id];
        }


        if ($state == 1) {
            $sql = "select model_id from cardb_salestate where state=3";
            $where .=" and model_id in($sql)";
            $total = $this->model->getSimp("count(model_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->model->getSimp("model_id,brand_name,series_name,model_name,state", "$where", 2);
        } elseif ($state == 2) {
            $sql = "select model_id from cardb_salestate where state=3";
            $where .=" and model_id not in($sql)";
            $total = $this->model->getSimp("count(model_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->model->getSimp("model_id,brand_name,series_name,model_name,state", "$where", 2);
        } elseif ($state == 3) {
            $where .=" and (model_pic1 !='' or model_pic2 !='') and (model_pic1 is not null or model_pic2 is not null)";
            $total = $this->model->getSimp("count(model_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->model->getSimp("model_id,brand_name,series_name,model_name,state", "$where", 2);
        } elseif ($state == 4) {
            $where .=" and (model_pic1 is null or model_pic1='') and (model_pic2 is null or model_pic2='')";
            $total = $this->model->getSimp("count(model_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->model->getSimp("model_id,brand_name,series_name,model_name,state", "$where", 2);
        } elseif ($state == 5) {
            $where .=" and compete_id is not null and compete_id!=''";
            $total = $this->model->getSimp("count(model_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->model->getSimp("model_id,brand_name,series_name,model_name,state", "$where", 2);
        } elseif ($state == 6) {
            $where .=" and (compete_id is  null or compete_id='')";
            $total = $this->model->getSimp("count(model_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->model->getSimp("model_id,brand_name,series_name,model_name,state", "$where", 2);
        } elseif ($state == 7) {
            $where .=" and views!='' and views is not null ";
            $total = $this->model->getSimp("count(model_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->model->getSimp("model_id,brand_name,series_name,model_name,state", "$where", 2);
        } elseif ($state == 8) {
            $where .=" and (views='' or views is null)";
            $total = $this->model->getSimp("count(model_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->model->getSimp("model_id,brand_name,series_name,model_name,state", "$where", 2);
        } elseif ($state == 9) {
            $color = $this->color->getColorList("type_id", "type_name='model' AND color_pic ='' group by type_id", 2);
            foreach ($color as $key => $value) {
                $modelid .=$value[type_id] . ',';
            }
            $modelid = rtrim($modelid, ',');
            $where .=" and model_id not in($modelid)";
            $total = $this->model->getSimp("count(model_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->model->getSimp("model_id,brand_name,series_name,model_name,state", "$where", 2);
        } elseif ($state == 10) {
            $color = $this->color->getColorList("type_id", "type_name='model' AND color_pic='' group by type_id", 2);
            foreach ($color as $key => $value) {
                $modelid .=$value[type_id] . ',';
            }
            $modelid = rtrim($modelid, ',');
            $where .=" and model_id in($modelid)";
            $total = $this->model->getSimp("count(model_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->model->getSimp("model_id,brand_name,series_name,model_name,state", "$where", 2);
        } elseif ($state == 11) {
            $where .=" and st219!='' and st220!='' ";
            $total = $this->model->getSimp("count(model_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->model->getSimp("model_id,brand_name,series_name,model_name,state", "$where", 2);
        } elseif ($state == 12) {
            $where .=" and ( st219='' or st220='')";
            $total = $this->model->getSimp("count(model_id)", "$where", 3);
            $where .=" limit $page_start,$page_size";
            $data = $this->model->getSimp("model_id,brand_name,series_name,model_name,state", "$where", 2);
        }

        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . 'modeldetail' . $extra);
        $this->vars('page_bar', $page_bar);
        $this->vars("state", $state);
        $this->vars("data", $data);
        $this->template();
    }

    function doUpdateOldData() {
        $r = $this->realdata->updateOldData();
        if ($r) {
            $msg = "更新成功！";
        } else {
            $msg = "更新失败！";
        }
        $this->alert("实测数据{$msg}!", 'js', 3, $_ENV['PHP_SELF']);
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

}

?>
