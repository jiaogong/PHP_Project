<?php
/**
 * cardb_file表存储model
 * $Id: cardbfile.php 836 2015-09-23 11:16:44Z xiaodawei $
 * @author David Shaw <tudibao@163.com>
 */

class cardbFile extends model {
    
    function __construct() {
        parent::__construct();
        $this->table_name = "cardb_file";
    }
    
    function getFileByName($name){
        $this->fields = "*";
        $this->where = "name='{$name}'";
        return $this->getResult();
    }
    
    function getOneUploadFile($where, $flag = 2) {
        $this->fields = "*";
        $this->where = $where;
        return $this->getResult($flag);
    }
    
     function getlist($field,$where, $flag = 2) {
        $this->fields = "$field";
        $this->where = $where;
        return $this->getResult($flag);
    }
    
    function getVideo($where = '1', $order = array(), $limit = 1, $offset = 0) {
        $this->tables = array(
            'f' => 'cardb_file',
            's' => 'cardb_series',
        );

        $this->where = "f.type_id=s.series_id and f.type_name='seriesvideo' and s.state=3 and " . $where;
        $this->fields = "count(f.id)";
        $this->total = $this->joinTable(3, 1);

        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->fields = "f.*, s.series_name,s.brand_name,s.factory_name";

        $ret = $this->joinTable(2, 1);
        return $ret;
    }

    function getFile($id) {
        $this->fields = "*";
        $this->where = "id='{$id}'";
        return $this->getResult();
    }

    function getVideoPic($id) {
        $this->fields = "*";
        $this->where = "type_id='{$id}' and file_type='jpg'";
        return $this->getResult();
    }

    /**
     * 取车系外观图片
     * @param $id 车系ID
     * @param $pos st4
     * @param $ppos $st21
     * @param $type 1外观实拍图，0外观白底图
     * return array
     */
    function getStylePic($id, $pos = 1, $ppos = 1, $date = 0, $type = 0) {
        $type_name = $type ? "stylepic" : "style";
        $this->where = "type_name='{$type_name}' and type_id='{$id}'" . ($pos ? " and pos='{$pos}'" : "")
                . ($ppos ? " and ppos='{$ppos}'" : "") . ($date ? " and s1='{$date}'" : "");
        $this->fields = "*";
        return $this->getResult();
    }

    /**
     * 取车系图片
     * 
     * @param mixed $id
     * @param mixed $pos 0表示所有分类
     * @param mixed $ppos 0表示忽略此字段
     */
    function getSeriesPic($id, $pos = 1, $ppos = 1) {
        $this->where = "type_name='series' and type_id='{$id}'" . ($pos ? " and pos='{$pos}'" : "") . ($ppos ? " and ppos='{$ppos}'" : "");
        $this->fields = "*";
        return $this->getResult();
    }

    function getAllSeriesPic($id, $pos = 1) {
        $this->where = "type_name='series' and type_id='{$id}'" . ($pos ? " and pos='{$pos}'" : "");
        $this->fields = "*";
        return $this->getResult(2);
    }

    function getSeriesPicByMid($mid, $pos = 1, $ppos = 1) {
        if (empty($mid))
            return false;

        $this->where = "type_name='model' and (";
        foreach ($mid as $k => $v) {
            if ($k)
                $this->where .= " or ";
            $this->where .= " type_id='{$v}'";
        }
        $this->where .= " )" . ($pos ? " and pos='{$pos}'" : "") . ($ppos ? " and ppos='{$ppos}'" : "") . " order by id desc";
        $this->fields = "*";
        return $this->getResult();
    }

    /**
     * 取车款图片
     * 
     * @param mixed $id
     * @param mixed $pos 0表示忽略此字段
     * @param mixed $ppos 0表示忽略此字段
     */
    function getModelPic($id, $pos = 1, $ppos = 1) {
        $this->where = "type_name='model' and type_id='{$id}'" . ($pos ? " and pos='{$pos}'" : "") . ($ppos ? " and ppos='{$ppos}'" : "");
        $this->fields = "*";
        return $this->getResult();
    }

    function getAllModelPic($id, $pos = 1, $extra = false, $limit = 0) {
        $this->where = "type_name='model' and type_id='{$id}'" . ($pos ? " and pos='{$pos}'" : "")
                . ($extra ? "" : " and ppos<900");
        $this->fields = "*";
        $this->order = array('pos' => 'asc', 'ppos' => 'asc');
        if($limit) $this->limit = $limit;
        return $this->getResult(2);
    }

    /**
     * 返回车款实拍图位置编号1的图片数
     * 用于检验车款实拍图四个分类是否齐全
     * 
     * @param int $id
     * @return array
     */
    function getModelFousPicNum($id) {
        $this->where = "type_name='model' and type_id='{$id}' and ppos='1' and ppos<900";
        $this->fields = "count(*)";
        return $this->getResult(3);
    }

    function checkUnion($id, $type) {
        $this->where = "type_name='{$type}' and type_id='{$id}'";
        $this->fields = "id";
        return $this->getResult(3);
    }
}

