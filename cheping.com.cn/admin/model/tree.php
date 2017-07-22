<?php

/**
 * tree
 * $Id: tree.php 2517 2016-05-05 05:23:42Z wangchangjiang $
 */
class Tree extends model {

    var $brand;
    var $factory;
    var $series;
    var $model;

    function __construct() {
        parent::__construct();
        $this->table_name = "cardb_brand";
        $this->brand = new brand();
        $this->factory = new factory();
        $this->series = new series();
        $this->model = new cardbModel();
    }

    function getBrandList($id, $order = array("letter" => "asc", 'brand_name' => 'asc')) {
        $this->brand->fields = "brand_id as id, CONCAT('[',letter,'" . ']品牌-'
                . "', brand_name) as cardb_title, '-1' as 'parent_id', 'factory' as 'cardb_category'";
        $this->brand->where = "state=3 " . ($id > 0 ? " and brand_id='$id'" : "");
        $this->brand->order = $order;
        $this->brand->getall = 1;
        $ret = $this->brand->getResult(2);

        return $ret ? $ret : array(0 => array('id' => '-1', 'cardb_title' => iconv('gbk', 'utf-8', '暂无品牌'), 'cardb_category' => 'series', 'parent_id' => '-1'));
    }

    function getFactoryList($id, $order = array("factory_name" => "asc")) {
        /* $series_obj = new series();
          $series_obj->fields = "factory_id as id, CONCAT('" . '厂商-'
          . "',factory_name) as cardb_title, brand_id as parent_id, 'series' as 'cardb_category'";
          $series_obj->where = "state=3 " . ($id > 0 ? " and brand_id='$id'" : "");
          $series_obj->group = "factory_id";
          $ret = $series_obj->getResult(2);
          return $ret; */

        $this->factory->fields = "factory_id as id, CONCAT('" . '厂商-'
                . "',factory_name) as cardb_title, brand_id as parent_id, 'series' as 'cardb_category'";
        $this->factory->where = "state=3 " . ($id > 0 ? " and brand_id='$id'" : "");
        $this->factory->order = $order;
        $this->factory->getall = 1;
        $ret = $this->factory->getResult(2);

        return $ret;
    }

    function getSeriesList($id, $order = array("series_name" => "asc")) {
        $this->series->fields = "series_id as id, CONCAT('" . '车系-'
                . "',series_name) as cardb_title, factory_id as parent_id, 'model' as 'cardb_category'";
        $this->series->where = "state=3 " . ($id > 0 ? " and factory_id='$id'" : "");
        $this->series->order = $order;
        $this->series->getall = 1;
        $ret = $this->series->getResult(2);

        return $ret;
    }

    function getModelList($id, $order = array("model_name" => "asc")) {
        $this->model->fields = "model_id as id, model_name as cardb_title, series_id as parent_id, '' as 'cardb_category', model_id, model_name";
        $this->model->where = "(state=3 or state=8) " . ($id > 0 ? " and series_id='$id'" : "");
        $this->model->order = $order;
        $this->model->getall = 1;
        $ret = $this->model->getResult(2);
        return $ret;
    }

    function getModelCount($type = 'brand', $id = 1) {
        $this->model->tables = array(
            'cardb_model' => 'm',
            'cardb_series' => 's',
        );
        $this->model->fields = "count(s.{$type}_id)";
        $this->model->where = "(m.state=3 or m.state=8) and s.state=3 and s.series_id=m.series_id and s.{$type}_id='{$id}'";
        $ret = $this->model->joinTable(3);
        return $ret;
    }

}
