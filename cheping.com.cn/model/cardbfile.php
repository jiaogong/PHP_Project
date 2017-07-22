<?php

/**
 * cardb color
 * $Id: cardbfile.php 5799 2014-08-26 07:04:37Z yizhangdong $
 */
class cardbFile extends model {

    var $pt = array(
        1 => '车身外观',
        2 => '车厢空间',
        3 => '其他细节',
        4 => '中控内饰'
    );
    var $pos_arr = array(1, 4, 2, 3);

    public function __construct() {
        parent::__construct();
        $this->table_name = 'cardb_file';
    }

    function getCardbFile($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }

    function getPic($id) {
        return $this->getPicRow("id='{$id}'");
    }

    function getPicRow($where, $order = array()) {
        $this->where = $where;
        $this->fields = "*";
        return $this->getResult();
    }

    function getPrevPos($pos) {
        $pos_id = array_search($pos, $this->pos_arr);
        $prev_pos = $pos_id > 0 ? $this->pos_arr[$pos_id - 1] : 0;
        return $prev_pos;
    }

    function getNextPos($pos) {
        $pos_id = array_search($pos, $this->pos_arr);
        $next_pos = $pos_id < 3 ? $this->pos_arr[$pos_id + 1] : 0;
        return $next_pos;
    }

    function getPrevPic($fields, $where, $limit = 1) {
        $this->table_name = "(select * from cardb_file where {$where} order by ppos asc) as x";
        $this->fields = $fields;
        $this->order = array('ppos' => 'desc');
        $this->where = "";
        $this->group = "";
        if ($limit > 1) {
            $ret = $this->getResult(2);
        } else {
            $ret[] = $this->getResult();
        }
        //处理记录不够的情况
        @preg_match('/pos=\'?(\d)\'?/si', $this->table_name, $match);
        $pos = $match[1];
        $prev_pos = $this->getPrevPos($pos);
        if (count($ret) < $limit && $prev_pos) {
            $this->table_name = preg_replace('/pos=\'?(\d)\'?/si', $prev_pos, $this->table_name);
            $this->table_name = strrchr('and ppos', $this->table_name);
            echo $this->table_name;
        }
        $this->table_name = "cardb_file";
        return $ret;
    }

    function getNextPic($fields, $where, $limit = 1) {
        
    }

    /**
     * @param type $series_id 车系id
     * @return array  
     */
    function getSeriesImage($series_id) {
        $this->fields = "*";
        $this->where = "s1={$series_id}";
        $resutl = $this->getResult(2);

        return $resutl;
    }

    /**
     * 获取最新更新的图片
     * @return array $res 最新更新的图片
     */
    function getNewColorPic() {
        $this->tables = array(
            'cardb_file' => 'cf',
            'cardb_model' => 'cm');
        $this->fields = 'cf.*,cm.model_name,cm.series_name';
        $this->where = "cf.type_name='model' and cf.type_id=cm.model_id and pos =1 and cf.ppos=1 and cf.name!=''";
        $this->order = array('cf.updated' => 'desc');
        $this->group = 'cm.series_id';
        $this->limit = 9;
        $res = $this->joinTable(2);
        if ($res)
            return $res;
        else
            return false;
    }

    /**
     * 获取热度最高的图片
     * @return array $res 热度最高的图片
     */
    function getHotColorPic() {
        global $_cache;
        $key = "hotcolorpic";
        $hotcolorpic = $_cache->getCache($key);
        if ($hotcolorpic) {
            return $hotcolorpic;
        } else {
            $cardb_model = new models();
            $cardb_model->table_name = '(select views,series_id,model_name,series_name,model_id from cardb_model where state=3 group by brand_id order by views desc,date_id desc,model_price desc) sv';
            $cardb_model->ufields = 'views,series_id,model_name,series_name';
            $cardb_model->where = 'views>1';
            $cardb_model->group = 'series_id';
            $cardb_model->order = 'views desc';
            $cardb_model->limit = 9;
            $cmRes = $cardb_model->getResult(2);
            $temp = array();
            if ($cmRes)
                foreach ($cmRes as $cmrkey => $cmrlist) {
                    if (count($temp) > 8) {
                        $_cache->writeCache($key, $temp, 84600);
                        return $temp;
                    }
                    $this->fields = "*";
                    $this->where = "type_id={$cmrlist['model_id']} and type_name='model' and pos=1 and ppos=1";
                    $this->order = '';
                    $this->limit = 1;
                    $this->group = '';
                    $abc = $this->getResult(1);
                    if ($abc) {
                        $temp[$cmrkey] = $abc;
                        $temp[$cmrkey]['model_name'] = $cmrlist['model_name'];
                        $temp[$cmrkey]['series_name'] = $cmrlist['series_name'];
                    }
                }
        }
    }

    /**
     * 根据条件获取数据
     * @param array $fields 需要查询的字段
     * @param string $where 条件
     * @param string $group 分组
     * @param array $order 排序
     * @param int $flag 状态
     * @return array 结果
     */
    function getSomeCF($fields, $where, $group, $order, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        if ($group)
            $this->group = $group;
        else
            $this->group = '';
        if ($order)
            $this->order = $order;
        else
            $this->order = '';
        $res = $this->getResult($flag);
        if ($res)
            return $res;
        else
            return false;
    }

    function getSeriesList($where) {
        $this->fields = "pos, count(id) as total";
        if ($where) {
            $this->where = $where;
        } else {
            $this->where = "pos>0";
        }
        $this->group = "pos";
        $res = $this->getResult(2);
        if ($res) {
            foreach ($res as $key => $value) {
                if ($value[pos] == 1) {
                    $result[1][name] = $this->pt[$value[pos]];
                    $result[1][pos] = $value[pos];
                    $result[1][total] = $value[total];
                } elseif ($value[pos] == 2) {
                    $result[3][name] = $this->pt[$value[pos]];
                    $result[3][pos] = $value[pos];
                    $result[3][total] = $value[total];
                } elseif ($value[pos] == 3) {
                    $result[4][name] = $this->pt[$value[pos]];
                    $result[4][pos] = $value[pos];
                    $result[4][total] = $value[total];
                } elseif ($value[pos] == 4) {
                    $result[2][name] = $this->pt[$value[pos]];
                    $result[2][pos] = $value[pos];
                    $result[2][total] = $value[total];
                }
            }
        }
        if ($result) {
            ksort($result);
        }

        return $result;
    }

    function getSeriesDataLists($where, $pos = Null, $offset = Null, $limit = Null) {
        $this->tables = array(
            'cardb_file' => 'cf',
            'cardb_model' => 'cm'
        );
        if (!$pos) {
            $pt = $this->pt;
            $pos_arr = $this->pos_arr;
            foreach ($pos_arr as $k => $v) {
                $this->reset();
                $this->tables = array(
                    'cardb_file' => 'cf',
                    'cardb_model' => 'cm'
                );
                $this->fields = "cm.model_name,cf.type_id,cm.brand_name,cm.series_name,cf.name as name,cf.pos,cf.ppos,cf.id";
                $this->where = $where . " and cf.pos={$v}";
                $this->group = "cf.id";
                $total = $this->joinTable(2);

                $this->fields = "cm.model_name,cf.type_id,cm.brand_name,cm.series_name,cf.name as name,cf.pos,cf.ppos,cf.id";
                $this->where = $where . " and cf.pos={$v}";
                $this->order = array("cf.pos" => "asc", "cf.ppos" => "asc");
                $this->group = "cf.id";
                $this->limit = 8;
                $content = $this->joinTable(2);
                $arr[$k]['content'] = $content;
                $arr[$k]['name'] = $pt[$v];
                $arr[$k]['pos'] = $v;
                $arr[$k]['total'] = count($total);
            }
        } else {
            $this->reset();
            $this->tables = array(
                'cardb_file' => 'cf',
                'cardb_model' => 'cm'
            );
            $this->fields = "cm.model_name,cf.type_id,cm.brand_name,cm.series_name,cf.name as name,cf.pos,cf.ppos,cf.id";
            $this->where = $where;
            $this->order = array("cf.pos" => "asc", "cf.ppos" => "asc");
            $this->group = "cf.id";
            $total = $this->joinTable(2);
            $this->total = count($total);

            $this->fields = "cm.model_name,cf.type_id,cm.brand_name,cm.series_name,cf.name as name,cf.pos,cf.ppos,cf.id";
            $this->where = $where;
            $this->order = array("cf.pos" => "asc", "cf.ppos" => "asc");
            $this->group = "cf.id";
            if ($offset)
                $this->offset = $offset;
            if ($limit)
                $this->limit = $limit;
            $content = $this->joinTable(2);
            $arr[$pos]['content'] = $content;
            $pt = $this->pt;
            $arr[$pos]['name'] = $pt[$pos];
            $arr[$pos]['pos'] = $pos;
            $arr[$pos]['total'] = count($total);
        }
        return $arr;
    }

    /**
     * 图片搜索结果页面查询
     * @param type $where
     * @return type
     */
    function getSeriesLists($where, $offset = Null, $limit = Null) {
        $this->fields = "count(*)";
        if ($where) {
            $this->where = $where;
        } else {
            $this->where = "pos>0";
        }
        $this->total = $this->getResult(3);

        $this->fields = "*";
        if ($where) {
            $this->where = $where;
        } else {
            $this->where = "pos>0";
        }
        $this->group = "";
        $this->order = array("pos" => "asc", "ppos" => "asc");
        if ($offset) {
            $this->offset = $offset;
        }
        if ($limit) {
            $this->limit = $limit;
        }
        $arr = $this->getResult(2);
        echo $this->sql;
        exit;
        $this->color = new color();
        if ($arr) {
            foreach ($arr as $key => $value) {
                $this->table_name = "cardb_model";
                $this->fields = "model_name,brand_name,series_name";
                $this->order = array();
                $this->where = "model_id=$value[type_id]";
                $name = $this->getResult(1);
                $color_id = $this->color->getColorlist("id", "color_name='$value[pic_color]'", 3);
                $arr[$key][model_name] = $name[model_name];
                $arr[$key][series_name] = $name[series_name];
                $arr[$key][brand_name] = $name[brand_name];
                $arr[$key][color_id] = $color_id;
            }
            foreach ($arr as $key => $value) {
                $res[$value[pos]][] = $value;
            }
            $num = count($res);
            foreach ($res as $key => $value) {
                if ($num == 1) {
                    $result[$key][total] = count($value);
                    $result[$key][name] = $this->pt[$key];
                    $result[$key][content] = $value;
                    $result[$key][pos] = $key;
                } else {
                    if ($key == 1) {
                        $result[1][total] = count($value);
                        $result[1][name] = $this->pt[$key];
                        $result[1][content] = $value;
                        $result[1][pos] = 1;
                    } elseif ($key == 2) {
                        $result[3][total] = count($value);
                        $result[3][name] = $this->pt[$key];
                        $result[3][content] = $value;
                        $result[3][pos] = 2;
                    } elseif ($key == 3) {
                        $result[4][total] = count($value);
                        $result[4][name] = $this->pt[$key];
                        $result[4][content] = $value;
                        $result[4][pos] = 3;
                    } elseif ($key == 4) {
                        $result[2][total] = count($value);
                        $result[2][name] = $this->pt[$key];
                        $result[2][content] = $value;
                        $result[2][pos] = 4;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * 车款页图片查询
     * @param type $where
     * @return type
     */
    function getModelLists($where, $model_id = FALSE) {
        global $_cache;
        $chache_key = "model_pics_$model_id";
        $result = $_cache->getCache($chache_key);
        if (empty($result)) {
            $this->tables = array(
                'cardb_file' => 'cf',
                'cardb_color' => 'co');
            $this->fields = "*";
            if ($where) {
                $this->where = $where;
            } else {
                $this->where = "pos>0";
            }
            $this->order = array("pos" => "asc", "ppos" => "asc");
            $this->group = "";
            $arr = $this->getResult(2);
            $this->color = new color();
            if ($arr) {
                foreach ($arr as $key => $value) {

                    $color_id = $this->color->getColorlist("id", "color_name='$value[pic_color]'", 3);
                    $arr[$key][color_id] = $color_id;
                }
                foreach ($arr as $key => $value) {
                    $res[$value[pos]][] = $value;
                }
                foreach ($res as $key => $value) {
                    if ($key == 1) {
                        $result[1][totil] = count($value);
                        $result[1][name] = $this->pt[$key];
                        $result[1][content] = $value;
                        $result[1][pos] = 1;
                    } elseif ($key == 2) {
                        $result[3][totil] = count($value);
                        $result[3][name] = $this->pt[$key];
                        $result[3][content] = $value;
                        $result[3][pos] = 2;
                    } elseif ($key == 3) {
                        $result[4][totil] = count($value);
                        $result[4][name] = $this->pt[$key];
                        $result[4][content] = $value;
                        $result[4][pos] = 3;
                    } elseif ($key == 4) {
                        $result[2][totil] = count($value);
                        $result[2][name] = $this->pt[$key];
                        $result[2][content] = $value;
                        $result[2][pos] = 4;
                    }
                }
            }

            $_cache->writeCache($chache_key, $result, 24 * 3600);
        }

        return $result;
    }

    //取出车款4种分类图
    function getDefaultModelfile($modelid) {
        $this->fields = "id,type_id,pos,pic_color,name,ppos";
        $this->where = " type_name='model' and ppos=1 and type_id='{$modelid}'";
        $this->order = array("pos" => "asc", "ppos" => "desc");
        $this->group = "pos";
        $model = $this->getResult(2);
        $this->color = new color();
        $this->models = new models();
        if ($model) {
            foreach ($model as $key => $value) {
                $color = $this->color->getColorlist("id,color_pic", "color_name='$value[pic_color]'", 1);
                $model_name = $this->models->getModelNameByid($modelid);
                if ($value[pos] == 1) {
                    $result[1] = $value;
                    $result[1][color_id] = $color[id];
                    $result[1]['model_name'] = $model_name;
                } elseif ($value[pos] == 2) {
                    $result[3] = $value;
                    $result[3][color_id] = $color[id];
                    $result[3]['model_name'] = $model_name;
                } elseif ($value[pos] == 3) {
                    $result[4] = $value;
                    $result[4][color_id] = $color[id];
                    $result[4]['model_name'] = $model_name;
                } elseif ($value[pos] == 4) {
                    $result[2] = $value;
                    $result[2][color_id] = $color[id];
                    $result[2]['model_name'] = $model_name;
                }
            }
        }

        return $result;
    }

    /**
     * 获取车系的实拍图颜色
     * @param type $where
     * @return type
     */
    function getSeriesColorLists($where, $model_id) {
        $this->fields = "pic_color,type_id,ppos";
        $this->where = "type_id=$model_id and pos=1 and pic_color !=''";
        $this->order = array("ppos" => "asc");
        $this->group = "pic_color";
        $model = $this->getResult(2);
        $this->where = $where;
        if ($model) {
            foreach ($model as $key => $value) {
                $this->where .=" and pic_color!='$value[pic_color]'";
                $model_pic .="'$value[pic_color]'" . ',';
            }
            $model_pic = rtrim($model_pic, ',');
        }

        $arr = $this->getResult(2);
        if ($model) {
            foreach ($model as $key => $value) {
                array_unshift($arr, $value);
            }
        }
        $this->color = new color();
        if ($arr) {
            foreach ($arr as $key => $value) {
                $color = $this->color->getColorlist("id,color_pic", "color_name='$value[pic_color]'", 1);
                $arr[$key][color_id] = $color[id];
                $arr[$key][url] = $color[color_pic];
            }
        }
        return $arr;
    }

    /**
     * 根据条件获取数据
     * @param array $fields 需要查询的字段
     * @param string $where 条件
     * @param string $group 分组
     * @param array $order 排序
     * @param int $flag 状态
     * @return array 结果
     */
    function getSomeCFLimit($fields, $where, $group, $order, $limit, $flag, $offset = '') {
        $this->fields = $fields;
        $this->where = $where;
        if ($group)
            $this->group = $group;
        else
            $this->group = '';
        if ($order)
            $this->order = $order;
        else
            $this->order = '';

        if ($limit)
            $this->limit = $limit;
        else
            $this->limit;
        if ($offset)
            $this->offset = $offset;
        else
            $this->offset;
        $this->getall = 0;
        // echo $this->limit;exit;
        $res = $this->getResult($flag);
        $next_pic_count = 4 - count($res) % 4;

        if ($res)
            return $res;
        else
            return false;
    }

    /**
     * @根据车系id取出有图片的车款
     * @param string $series_id 车系id
     */
    function getPicAndModel($series_id) {
        $this->tables = array(
            'cardb_file' => 'cf',
            'cardb_model' => 'cm'
        );
        $this->fields = 'cf.*,cm.model_name';
        $this->where = "cf.type_id=cm.model_id and cm.state in(3,8) and cf.s1=$series_id and cf.type_name='model' and cf.ppos<900";
        $this->order = '';
        $this->group = 'cf.type_id';
        $res = $this->joinTable(2);
        if ($res)
            return $res;
        else
            return false;
    }

    /**
     * @根据车款id取出有图片的车系
     * @param string $model_id 车款id
     */
    function getPicAndSeries($model_id) {
        $this->tables = array(
            'cardb_file' => 'cf',
            'cardb_model' => 'cm'
        );
        $this->fields = 'cf.ppos as cfpos,cf.s1,cf.type_id,cf.name,cm.series_name';
        $this->where = "cf.type_id=cm.model_id and cm.state=3 and cf.type_id=$model_id and cf.type_name='model' and cf.pos=1 and cf.ppos<900 and cf.ppos>0";
        $this->order = array('cf.ppos' => 'asc');
        $res = $this->joinTable(1);
        if ($res)
            return $res;
        else
            return false;
    }

    /**
     * ajax 检测某车款是否有实拍图图片
     * @param type $model_id
     * @param type $pic_color 
     */
    function getCheckModelPic($model_id, $pic_color) {
        $this->table_name = "cardb_file";
        $this->fields = "name,type_id,id,pos,ppos";
        $this->where = "type_id=$model_id and pic_color='$pic_color' and  pos=1 and ppos>0 ";
        $this->order = array("ppos" => "asc");
        $arr = $this->getResult(1);
        if ($arr) {
            $this->color = new color();
            $color = $this->color->getColorlist("id", "color_name='$pic_color'", 3);
            $arr[color_id] = $color;
        }
        return $arr;
    }

    /**
     * 查出cardb_model in (3,8)的图片
     */
    function getPNM($fields, $brand_id = '') {
        if ($brand_id)
            $this->where = "type_id in (select model_id from cardb_model where brand_id=$brand_id and state in(3,8)) and ppos<900 and type_name='model'";
        else
            $this->where = 'type_id in (select model_id from cardb_model where state in(3,8)) and ppos<900 and type_name="model"';
        $this->fields = $fields;
        $this->group = 's1';
        $res = $this->getResult(4);
        return $res;
    }

}

?>
