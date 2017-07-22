<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class cp_Province extends model {

    function __construct() {
        $this->table_name = "province";
        parent::__construct();
    }

    function getAllprovince() {
        global $_cache;
        $key = "province";
        $result = $_cache->getCache($key);
        if ($result) {
            return $result;
        } else {
            $this->fields = "*";
//                    $this->where = "1 and sequence<>1";
            $this->where = "1";
            $this->order = array("sequence" => "DESC", "name" => "ASC");
            $result = $this->getResult(2);
            $_cache->writeCache($key, $result, 3600 * 24 * 365);
            return $result;
        }
    }

    function getProvinceByid($id) {
        $this->reset();
        $this->fields = "name";
        $this->where = "id='$id'";
        return $this->getResult(3);
    }

    /**
     * 根据省级名称名称获取省级信息
     * @param string $name
     * @return array
     */
    function getProvinceByName($name) {
        $this->fields = "*";
        $this->where = "name = '$name'";
        return $this->getResult();
    }

    /**
     * 取所有的省级地区
     */
    function getProvince(){
        $this->reset();
        $this->fields = '*';
        return $this->getResult(2);
    }
}

?>