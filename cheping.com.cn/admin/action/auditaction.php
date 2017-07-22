<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class auditAction extends action {

    var $state = array(
            /* 0 => "删除",
              1 => "草稿",
              2 => "待审核",
              6=>"待审核(缺参数)",
              3 => "正常",
              7=>"正常(缺参数)",
              4 => "未通过",
              5 => "屏蔽",
              8 => "停产在售",
              9 => "停产", */
    );
    //要修改其下面级别的状态
    var $s = array(
        0 => "删除",
        9 => "停产",
    );
    var $color = array(
        0 => "#5b1b1b",
        1 => "#815b5b",
        2 => "#ce354b",
        6 => "#9b1326",
        3 => "#2e63eb",
        7 => "#072b86",
        4 => "#fa1308",
        5 => "#b1b2ab",
        9 => "#a186c2",
        10 => "#ce354b",
        11 => "#2e63eb",
    );
    var $type = array(
        "brand" => "品牌审核",
        "factory" => "厂商审核",
        "series" => "车系审核",
        "model" => "车款审核",
    );

    function __construct() {
        global $adminauth, $login_uid, $cardb_state;
        $adminauth->checkAuth($login_uid, 'sys_module', 204, 'A');
        $this->state = $cardb_state;

        parent::__construct();
        $this->factory = new factory();
        $this->brand = new brand();
        $this->series = new series();
        $this->model = new cardbModel();
    }

    function doDefault() {
        $type = $this->getValue('t')->String('brand');
        $this->tpl_file = "comm_audit";
        $this->page_title = "数据审核管理";
        $keyword = $this->requestValue('keyword')->UrlDecode();
        $rkeyword = $keyword = $this->addValue($keyword)->stripHtml(1);
        $state = $this->requestValue('state')->Int();
        $page = $this->getValue('page')->Int();
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $list = array();
        switch ($type) {
            case "brand":
                $where = " 1 ";
                if ($state != "" && isset($state)) {
                    $where.=" and state='" . $state . "'";
                    $this->vars('s', $state);
                    $extra .= "&state=$state";
                }
                $brand_id = $this->postValue('brand_id')->Int();
                if (!empty($brand_id)) {
                    $where.=" and brand_id='" . $brand_id . "'";
                    $this->vars('id', $brand_id);
                }
                if ($keyword) {
                    $where .= " and brand_name like '%{$keyword}%'";
                    $extra .= "&keyword={$rkeyword}";
                    $this->vars('keyword', $rkeyword);
                }
                $fun = "getAll" . ucwords($type);
                $result = $this->$type->$fun($where, array('updated' => 'desc'), $page_size, $page_start);
                foreach ($result as $key => $value) {
                    $list[$key]["id"] = $value["brand_id"];
                    $list[$key]["name"] = $value["brand_name"];
                    $list[$key]["date"] = $value["created"] ? date("Y-m-d", $value["created"]) : "-";
                    $list[$key]["state"] = $value["state"];
                }
                break;
            case "factory":
                $where = " 1 and f.brand_id=b.brand_id ";
                if ($state != "" && isset($state)) {
                    $where.=" and f.state='" . $state . "'";
                    $this->vars('s', $state);
                    $extra .= "&state=$state";
                }
                $factory_id = $this->postValue('factory_id')->Int();
                if (!empty($factory_id)) {
                    $where.=" and factory_id='" . $factory_id . "'";
                    $this->vars('id', $factory_id);
                }
                if ($keyword) {
                    $where .= " and (factory_name like '%{$keyword}%' or b.brand_name like '%{$keyword}%') ";
                    $extra .= "&keyword={$rkeyword}";
                    $this->vars('keyword', $rkeyword);
                }
                $fun = "getAll" . ucwords($type);
                $result = $this->$type->$fun($where, array(), $page_size, $page_start);
                foreach ($result as $key => $value) {
                    $list[$key]["id"] = $value["factory_id"];
                    $list[$key]["name"] = $value["brand_name"] . "--" . $value["factory_name"];
                    $list[$key]["date"] = $value["created"] ? date("Y-m-d", $value["created"]) : "-";
                    $list[$key]["state"] = $value["state"];
                }
                break;
            case "series":
                $where = " 1 and s.factory_id=f.factory_id and f.brand_id=b.brand_id ";
                if ($state != "" && isset($state)) {
                    $where.=" and s.state='" . $state . "'";
                    $this->vars('s', $state);
                    $extra .= "&state=$state";
                }
                $series_id = $this->postValue('series_id')->Int();
                if (!empty($series_id)) {
                    $where.=" and series_id='" . $series_id . "'";
                    $this->vars('id', $series_id);
                }
                if ($keyword) {
                    $where .= " and (series_name like '%{$keyword}%' or s.factory_name like '%{$keyword}%' or s.brand_name like '%{$keyword}%')";
                    $extra .= "&keyword={$rkeyword}";
                    $this->vars('keyword', $rkeyword);
                }
                $fun = "getAll" . ucwords($type);
                $result = $this->$type->$fun($where, array('series_id' => 'desc'), $page_size, $page_start);
                foreach ($result as $key => $value) {
                    $list[$key]["id"] = $value["series_id"];
                    $list[$key]["name"] = $value["factory_name"] . "--" . $value["series_name"];
                    $list[$key]["date"] = $value["created"] ? date("Y-m-d", $value["created"]) : "-";
                    $list[$key]["state"] = $value["state"];
                }
                break;
            case "model":
                $where = " 1 and s.factory_id=f.factory_id and f.brand_id=b.brand_id and m.series_id=s.series_id and m.state not in(0,5)";
                if ($state != "" && isset($state)) {
                    $where.=" and m.state='" . $state . "' ";
                    $this->vars('s', $state);
                    $extra .= "&state=$state";
                }
                $model_id = $this->postValue('model_id')->Int();
                if (!empty($model_id)) {
                    $where.=" and model_id='" . $model_id . "'";
                    $this->vars('id', $model_id);
                }
                if ($keyword) {
                    $where .= " and (model_name like '%{$keyword}%' or m.series_name like '%{$keyword}%' or m.factory_name like '%{$keyword}%' or m.brand_name like '%{$keyword}%')";
                    $extra .= "&keyword={$rkeyword}";
                    $this->vars('keyword', $rkeyword);
                }
                $fun = "getAll" . ucwords($type);
                $result = $this->$type->$fun($where, array('model_id' => 'desc'), $page_size, $page_start);
                foreach ($result as $key => $value) {
                    $list[$key]["id"] = $value["model_id"];
                    $list[$key]["name"] = $value["brand_name"] . "-" . $value["series_name"] . "-" . $value["model_name"];
                    $list[$key]["date"] = $value["created"] ? date("Y-m-d", $value["created"]) : "-";
                    $list[$key]["state"] = $value["state"];
                    $list[$key]["last_picid"] = $value["last_picid"];
                }
                break;
            default:
                break;
        }
        $extra .= "&t=" . $type;
        $page_bar = $this->multi($this->$type->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra, 0, 4);
        $this->vars('list', $list);
        $this->vars('page_bar', $page_bar);
        $this->vars('t', strtolower($type));
        $this->vars('type', $this->type);
        $this->vars('page', $page);
        $this->vars('state', $this->state);
        $this->vars('color', $this->color);
        $this->vars('page_title', $this->page_title);
        $this->template();
    }

    function doUpdtestate() {
        $type = $this->postValue('t')->String('brand');
        $state = $this->postValue('state')->Int();
        $s = $this->s;
        $result = $this->$type->upDataState($state, $this->postValue('id')->Int());
        $id = $this->postValue('id')->Int();
        //如果 $type=model,$state不等于3或7时,修改当前车款，车系的last_picid
        if ($type == "model" && $state != 3 && $state != 7 && $state != 8) {
            $this->$type->getSeriesmodels($id);
        }
        if ($result) {
            $color = $this->color;
            $color = $color[$state];
            echo json_encode($color);
        }
    }

    function doUpdteallstate() {
        $type = $this->getValue('t')->String('brand');
        $this->tpl_file = "comm_audit";
        $this->page_title = "数据审核管理";

        $keyword = $this->requestValue('keyword')->UrlDecode();
        $rkeyword = $keyword = $this->addValue($keyword)->stripHtml(1);

        $oldstate = $this->postValue('oldstate')->Int();
        $state = $this->postValue('state')->Int();
        $idarr = $this->postValue('id')->Val();

        //如果 $type=model,$state不等于3时,修改当前车款，车系的last_picid
        if ($type == "model" && $state != 3) {
            $id = $this->addValue($idarr)->Int();
            $this->$type->getSeriesmodels();
        }

        $s = $this->s;
        if (isset($s[$state])) {
            if (is_array($idarr)) {
                if ($type == "model" && $state != 3) {
                    foreach ($idarr as $key => $value) {
                        $this->$type->upDataState($state, $value);
                        $this->$type->getSeriesmodels($value);
                    }
                } else {
                    foreach ($idarr as $key => $value) {
                        $this->$type->upDataState($state, $value);
                    }
                }
            }
        } else {
            $this->$type->ufields = array(
                'state' => $state
            );
            if (is_array($idarr)) {
                $lowbrand = strtolower($type);
                if ($type == "model" && $state != 3) {
                    foreach ($idarr as $key => $value) {
                        $this->$type->where = $lowbrand . "_id='" . $value . "'";
                        $result = $this->$type->update();
                        $this->$type->getSeriesmodels($value);
                    }
                } else {
                    foreach ($idarr as $key => $value) {
                        $this->$type->where = $lowbrand . "_id='" . $value . "'";
                        $result = $this->$type->update();
                    }
                }
            }
        }

        $page = $this->getValue('page')->Int();
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $list = array();
        switch ($type) {
            case "brand":
                $where = " 1 ";
                if ($oldstate != "" && isset($oldstate)) {
                    $where.=" and state='" . $oldstate . "'";
                    $this->vars('s', $oldstate);
                    $extra .= "&state=$oldstate";
                }
                if ($keyword) {
                    $where .= " and brand_name like '%{$keyword}%'";
                    $extra .= "&keyword={$rkeyword}";
                    $this->vars('keyword', $rkeyword);
                }
                $fun = "getAll" . ucwords($type);
                $result = $this->$type->$fun($where, array(), $page_size, $page_start);
                foreach ($result as $key => $value) {
                    $list[$key]["id"] = $value["brand_id"];
                    $list[$key]["name"] = $value["brand_name"];
                    $list[$key]["date"] = $value["created"] ? date("Y-m-d", $value["created"]) : "-";
                    $list[$key]["state"] = $value["state"];
                }
                break;
            case "factory":
                $where = " 1 and f.brand_id=b.brand_id ";
                if ($oldstate != "" && isset($oldstate)) {
                    $where.=" and state='" . $oldstate . "'";
                    $this->vars('s', $oldstate);
                    $extra .= "&state=$oldstate";
                }
                if ($keyword) {
                    $where .= " and (factory_name like '%{$keyword}%' or b.brand_name like '%{$keyword}%') ";
                    $extra .= "&keyword={$rkeyword}";
                    $this->vars('keyword', $rkeyword);
                }
                $fun = "getAll" . ucwords($type);
                $result = $this->$type->$fun($where, array(), $page_size, $page_start);
                foreach ($result as $key => $value) {
                    $list[$key]["id"] = $value["factory_id"];
                    $list[$key]["name"] = $value["factory_name"];
                    $list[$key]["date"] = $value["created"] ? date("Y-m-d", $value["created"]) : "-";
                    $list[$key]["state"] = $value["state"];
                }
                break;
            case "series":
                $where = " 1 and s.factory_id=f.factory_id and f.brand_id=b.brand_id ";
                if ($oldstate != "" && isset($oldstate)) {
                    $where.=" and s.state='" . $oldstate . "'";
                    $this->vars('s', $oldstate);
                    $extra .= "&state=$oldstate";
                }
                if ($keyword) {
                    $where .= " and (series_name like '%{$keyword}%' or s.factory_name like '%{$keyword}%' or s.brand_name like '%{$keyword}%') ";
                    $extra .= "&keyword={$rkeyword}";
                    $this->vars('keyword', $rkeyword);
                }
                $fun = "getAll" . ucwords($type);
                $result = $this->$type->$fun($where, array(), $page_size, $page_start);
                foreach ($result as $key => $value) {
                    $list[$key]["id"] = $value["series_id"];
                    $list[$key]["name"] = $value["series_name"];
                    $list[$key]["date"] = $value["created"] ? date("Y-m-d", $value["created"]) : "-";
                    $list[$key]["state"] = $value["state"];
                }
                break;
            case "model":
                $where = " 1 and s.factory_id=f.factory_id and f.brand_id=b.brand_id and m.series_id=s.series_id ";
                if ($oldstate != "" && isset($oldstate)) {
                    $where.=" and m.state='" . $oldstate . "'";
                    $this->vars('s', $oldstate);
                    $extra .= "&state=$oldstate";
                }
                if ($keyword) {
                    $where .= " and (model_name like '%{$keyword}%' or m.series_name like '%{$keyword}%' or m.factory_name like '%{$keyword}%' or m.brand_name like '%{$keyword}%') ";
                    $extra .= "&keyword={$rkeyword}";
                    $this->vars('keyword', $rkeyword);
                }
                $fun = "getAll" . ucwords($type);
                $result = $this->$type->$fun($where, array(), $page_size, $page_start);
                foreach ($result as $key => $value) {
                    $list[$key]["id"] = $value["model_id"];
                    $list[$key]["name"] = $value["brand_name"] . "--" . $value["series_name"] . "--" . $value["model_name"];
                    $list[$key]["date"] = $value["created"] ? date("Y-m-d", $value["created"]) : "-";
                    $list[$key]["state"] = $value["state"];
                }
                break;
            default:
                break;
        }
        $extra .= "&t=" . $type;
        $page_bar = $this->multi($this->$type->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra, 0, 4);
        $this->vars('list', $list);
        $this->vars('page_bar', $page_bar);
        $this->vars('t', $type);
        $this->vars('type', $this->type);
        $this->vars('page', $page);
        $this->vars('state', $this->state);
        $this->vars('color', $this->color);
        $this->vars('page_title', $this->page_title);
        $this->template();
    }

}

?>
