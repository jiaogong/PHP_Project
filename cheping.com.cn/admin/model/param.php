<?php

/**
 * 参数分类组
 * $Id: param.php 1036 2015-10-25 03:04:45Z xiaodawei $
 * @author David.Shaw
 */
class param extends model {

    function __construct() {
        $this->table_name = "cardb_param";
        parent::__construct();
    }

    function getParam($id) {
        $this->fields = "*";
        $this->where = "id='{$id}'";
        return $this->getResult();
    }

    function getParamAssoc() {
        $this->fields = "*";
        $this->getall = 1;
        $ret = $this->getResult(2);
        $param = array();
        foreach ($ret as $key => $value) {
            $param[$value['id']] = $value;
        }
        return $param;
    }

    function getOldParamAssoc() {
        $this->table_name = "cardb_data_st";
        $this->fields = "st_id,st_name";
        $this->where = "st_id<>20 and st_id<186";
        $ret = $this->getResult(4);
        $this->table_name = "cardb_param";
        return $ret;
    }

    function getParamAliasAssoc() {
        $this->fields = "id,alias1";
        $this->where = "alias1<>''";
        return $this->getResult(4);
    }

    function getParamAssocByPid($id) {
        $this->fields = "id, name";
        $this->where = "pid1='{$id}' or pid2='{$id}' or pid3='{$id}'";
        $this->getall = 1;
        $ret = $this->getResult(4);
        return $ret;
    }

    function getParamByPid($pid) {
        $this->where = "pid1='{$pid}' or pid2='{$pid}' or pid3='{$pid}'";
        $this->fields = "*";
        return $this->getResult(2);
    }

    function getAllParam($where = '1', $order = array(), $limit = 1, $offset = 0) {
        $this->where = $where;
        $this->fields = "count(id)";
        $this->total = $this->getResult(3);

        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->fields = "*";

        $ret = array();
        $category = new paramType();
        $pcate = $category->getParamTypeAssoc();
        #var_dump($pcate);
        $subcate = $this->getResult(2);
        foreach ($subcate as $key => $value) {
            $value['pname_str'] = "";

            $ta = array();
            foreach ($pcate as $pk => $pv) {
                $tpv = $value['pid' . $pv['pid']];
                $pname = $pcate[$tpv]['pname'];
                $cname = $pcate[$tpv]['name'];
                if ($pname && !in_array($tpv, $ta)) {
                    array_push($ta, $tpv);
                    if ($value['pid' . $pv['pid']] && $value['pname_str'])
                        $value['pname_str'] .= "<br>";
                    $value['pname_str'] .= $value['pid' . $pv['pid']] ? $pname . "->" . $cname . ";" : "";
                }
                unset($tpv);
            }
            $ret[] = $value;
        }
        return $ret;
    }

    /**
     * 产品表中添加参数字段
     * 
     * @param mixed $colid
     * @param mixed $str
     * @param mixed $fieldtype
     */
    function addColumn($colid, $str = '', $fieldtype = 7) {
        if (!$colid) {
            return false;
        }
        $table = "cardb_model";
        $column = "st{$colid}";
        $column_type = $this->getParamFieldType($fieldtype, $str);

        $column_tstr = empty($column_type) ? false : "{$column_type['type']}";
        if ($column_type['length'])
            $column_tstr .= "({$column_type['length']})";

        #table exist ?
        $this->sql = "SHOW TABLES LIKE '{$table}'";
        $ret = $this->query();
        #table not exist, return false
        if (!$ret) {
            return false;
        }

        #column exist ?
        $this->sql = "SHOW COLUMNS FROM {$table} LIKE '{$column}'";
        $ret = $this->query();
        #column exist, return false
        if ($ret) {
            return false;
        }

        #add column
        $this->sql = "alter table {$table} add column `{$column}` {$column_tstr} default {$column_type['default']}";
        $ret = $this->query();
        if ($ret) {
            return true;
        }
    }

    /**
     * 参数数据类型
     * 
     * @param mixed $ft
     */
    function getParamFieldType($ft = -1, $val = '') {
        $len = strlen($val);
        if (!$len) {
            if ($ft === 0) {
                $len = 100;
            } elseif ($ft === 1) {
                $len = 10;
            } else {
                $len = 50;
            }
        } else {
            $len *= 3;
        }

        $field_type = array(
            0 => array('type' => 'varchar', 'length' => $len, 'default' => "''", 'memo' => '文本'),
            1 => array('type' => 'int', 'length' => $len, 'default' => "0", 'memo' => '数字',),
            2 => array('type' => 'varchar', 'length' => $len, 'default' => "''", 'memo' => '下拉菜单',),
            3 => array('type' => 'varchar', 'length' => $len, 'default' => "''", 'memo' => '有条件数字',),
            4 => array('type' => 'varchar', 'length' => $len, 'default' => "''", 'memo' => '双下拉菜单',),
        );

        return $ft !== -1 ? $field_type[$ft] : $field_type;
    }

    function getParamHtml($param, $value = "") {

        switch ($param['data_type']) {
            case 1:
                $html = "<input type='text' name='st{$param['id']}' value='{$value}' onkeyup='this.value=negativeDecimal(this.value)'  style='background-color:#91efff'>";
                break;
            case 2:
                $tmp = explode(';', $param['data_value']);
                $html = "<select name='st{$param['id']}'>\n<option></option>\n";
                foreach ($tmp as $k => $v) {
                    if ($v == $value) {
                        $html .= "<option value='{$v}' selected>{$v}</option>\n";
                    } else {
                        $html .= "<option value='{$v}'>{$v}</option>\n";
                    }
                }
                $html .= "</select>\n";
                break;

            case 3:
                $tmp = explode(';', $param['data_value']);
                $val = explode('->', $value);
                $html = "<select name='st{$param['id']}'>\n<option></option>\n";
                foreach ($tmp as $k => $v) {
                    if ($val[0] == $v) {
                        $html .= "<option value='{$v}' selected>{$v}</option>\n";
                    } else {
                        $html .= "<option value='{$v}'>{$v}</option>\n";
                    }
                }
                $html .= "</select>\n";

                break;

            case 4:
                $tmp = explode('||', $param['data_value']);
                $tmp1 = explode(';', $tmp[0]);
                $tmp2 = explode(';', $tmp[1]);
                $val = explode('->', $value);

                $html = "<select name='st{$param['id']}'>\n<option></option>\n";
                foreach ($tmp1 as $k => $v) {
                    if ($val[0] == $v) {
                        $html .= "<option value='{$v}' selected>{$v}</option>\n";
                    } else {
                        $html .= "<option value='{$v}'>{$v}</option>\n";
                    }
                }
                $html .= "</select>\n";

                $html .= "<select name='st{$param['id']}_2'>\n<option></option>\n";
                foreach ($tmp2 as $k => $v) {
                    if ($val[1] == $v) {
                        $html .= "<option value='{$v}' selected>{$v}</option>\n";
                    } else {
                        $html .= "<option value='{$v}'>{$v}</option>\n";
                    }
                }
                $html .= "</select>\n";
                break;

            default:
                $html = "<input type='text' name='st{$param['id']}' value='{$value}'>";
        }
        if ($value)
            $html .= "\n<span>(原值:{$value})</span>\n";
        return $html;
    }

    function getPramaList($fields, $where, $flag = 2) {
        $this->where = $where;
        $this->fields = $fields;
        $result = $this->getResult($flag);
        return $result;
    }

}

?>
