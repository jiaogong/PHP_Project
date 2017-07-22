<?php

/**
 * cardb_color
 * $Id: color.php 5711 2014-07-24 07:12:45Z xiaodawei $
 */
class color extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = "cardb_color";
    }

    function getColor($id) {
        $this->fields = "*";
        $this->where = "id='{$id}'";
        return $this->getResult();
    }

    function getColorBySeries($series_id) {
        $this->fields = "*";
        $this->where = "type_id='{$series_id}' and type_name='series'";
        return $this->getResult(2);
    }

    function inserColor($color, $model_id, $sid) {
        $model = new cardbModel();
        $series = new series();
        $colorTemp = array();
        $seriesId = '';
        $time = time();
        foreach ($color as $key => $colorOne) {
            foreach ($model_id as $k => $mid) {
                if ($colorOne['specid'] == $k) {
                    foreach ($colorOne['coloritems'] as $v) {
                        $colorName = $v["name"];
                        if (array_search($colorName, $colorTemp) === FALSE) {
                            $colorTemp[] = $colorName;
                        }
                        $this->where = "type_id=$mid and type_name='model' and color_name='$colorName'";
                        $flag = $this->getResult();
                        if (empty($flag)) {
                            $this->where = "type_id=$sid and type_name='series' and color_name='$colorName'";
                            $this->fields = 'color_pic';
                            $seriesColor = $this->getResult(3);
                            if ($seriesColor) {
                                $this->ufields = array(
                                    "type_id" => $mid, "type_name" => "model", "color_name" => $colorName,
                                    "color_pic" => $seriesColor, "addition" => 0, "metallic" => 0, "state" => 0, "created" => "$time", "updated" => "$time"
                                );
                            } else {
                                $this->ufields = array(
                                    "type_id" => $mid, "type_name" => "model", "color_name" => $colorName,
                                    "color_pic" => "not find", "addition" => 0, "metallic" => 0, "state" => 0, "created" => "$time", "updated" => "$time"
                                );
                            }
                            if($colorName)
                            $this->insert();
                        }
                        if (empty($flag['color_pic']) || $flag['color_pic'] == 'not fand' || $flag['color_pic'] == 'not find') {
                            $this->where = "type_id=$sid and type_name='series' and color_name='$colorName'";
                            $this->fields = 'color_pic';
                            $seriesColor = $this->getResult(3);
                            if ($seriesColor) {
                                $this->ufields = array("color_pic" => $seriesColor);
                                $this->where = "type_id=$mid and type_name='model' and color_name='$colorName'";
                                $this->update();
                            }
                        }
                    }
                    break;
                }
            }
            if ($key == 0) {
                $seriesId = $sid;
            }
        }
        foreach ($colorTemp as $sVal) {
            $this->where = "type_name='series' and type_id=$seriesId and color_name='$sVal'";
            $flag = $this->getResult(3);
            if (empty($flag)) {
                $this->ufields = array(
                    "type_id" => $seriesId, "type_name" => "series", "color_name" => "$sVal",
                    "color_pic" => "not find", "addition" => 0, "metallic" => 0, "state" => 0, "created" => "$time", "updated" => "$time"
                );
                $this->insert();
            }
        }
        return $colorTemp;
    }

    function getColorByModel($model_id) {
        $this->fields = "*";
        $this->where = "type_id='{$model_id}' and type_name='model'";
        return $this->getResult(2);
    }

    function getColorByColorName($model_id, $color_name) {
        $this->fields = 'id';
        $this->where = "type_name='model' and type_id='$model_id' and color_name='$color_name'";
        $res = $this->getResult();
        if ($res)
            return $res;
        else
            return false;
    }

    /**
     * 自定义操作
     * @param type $fields
     * @param type $where
     * @param type $flag
     */
    function getColorList($fields, $where, $flag = 2) {
        $this->fields = $fields;
        $this->where = $where;
        $res = $this->getResult($flag);
        return $res;
    }

}

?>
