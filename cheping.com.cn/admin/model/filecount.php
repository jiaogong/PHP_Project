<?php

/**
 * 图片统计数表
 */
class fileCount extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = "cardb_file_count";
    }

    function getCount($type_name, $type_id) {
        $this->field = "count(*)";
        $this->where = "type_name='{$type_name}' and type_id='{$type_id}'";
        $this->limit = 1;
        return $this->getResult(3);
    }

    function getCountList($type_name, $order = array()) {
        $this->field = "count(*)";
        $this->where = "type_name='{$type_name}'";
        $this->order = $order;
        return $this->getResult(2);
    }

    /**
     * 获取最新更新图片的车款
     * 每个车系取一款车，默认取9条
     * 
     * @param      int     $limit      返回的记录条数
     * @return     array   最新更新图片的车款数组，每个车系取一款车
     */
    function getLastestList($limit = 9) {
        $this->tables = array(
            'cardb_file_count' => 'c',
            'cardb_model' => 'm',
            'cardb_file' => 'cf',
        );
        $this->fields = "cf.*,m.model_name,m.series_name";
        $this->where = "c.type_name='series' AND c.total>0 AND c.last_model_id=m.model_id AND m.state=3 AND cf.type_name='model' AND cf.type_id=c.last_model_id AND cf.pos=1 AND cf.ppos=1";
        $this->order = array('c.last_updated' => 'desc');
        $this->limit = $limit;
        return $this->joinTable(2);
    }

    /**
     * 取所有子节点的图片总数
     * 返回的数组为：array(id => 图片总数, ...)
     * <p>
     * 如果要取品牌ID：1下的所有厂商图片总数，
     * 调用方法为：getChildrenCountList('factory', 1)
     * </p>
     * @param string   $type_name      类型名称，只能为brand, factory, series, model
     * @param int      $parent_id      父类型ID
     * @param array    $order          需要排序的数组，array(字段名 => 排序方式)
     */
    function getChildrenCountList($type_name, $parent_id, $order = array()) {
        $this->fields = "type_id, total";
        $this->where = "type_name='{$type_name}' and parent_id='{$parent_id}'";
        return $this->getResult(4);
    }

    /**
     * 获取所有品牌数据及其图片总数
     * <p>
     * 返回的数组格式为：array(brand_id => 品牌及图片数数组,.....)
     * </p>
     * @param       array       $order      品牌排序数组
     * @return      array       品牌及图片总数数组   
     */
    function getBrandCountList($order = array('b.letter' => 'asc')) {
        $this->tables = array(
            'cardb_brand' => 'b',
            'cardb_file_count' => 'c'
        );
        $this->fields = "b.brand_id,b.brand_name,b.letter,b.state,b.full_pinyin,c.total";
        $this->where = "c.type_name='brand' AND c.type_id=b.brand_id AND b.state=3 AND c.total>0";
        $this->order = $order;
        return $this->joinTable(4);
    }

    function countAll($force_clear = false) {
        //
        if ($force_clear) {
            echo "clear all data:\n";
            $this->sql = "truncate table {$this->table_name}";
            $this->query();
        } else {
            echo "repaire data\n";
            $limit_s = $limit_f = 0;
            #删除非在售车系
            $this->fields = "GROUP_CONCAT(type_id)";
            $this->where = "type_name='series' AND NOT EXISTS
                            (
                                SELECT series_id 
                                FROM cardb_model 
                                WHERE state IN (3,8) AND cardb_model.series_id=cardb_file_count.type_id 
                                GROUP BY series_id
                            )";
            $del_series_id = $this->getResult(3);
            $limit_s = count(explode(',', $del_series_id));
            if ($limit_s) {
                $this->where = "type_name='series' and type_id in ({$del_series_id})";
                $this->limit = $limit_s;
                $this->del();
                #echo $this->sql . "\n";
            }
            #删除非在售厂商
            $this->fields = "GROUP_CONCAT(type_id)";
            $this->where = "type_name='factory' AND NOT EXISTS
                            (
                                SELECT factory_id 
                                FROM cardb_model 
                                WHERE state IN (3,8) AND cardb_model.factory_id=cardb_file_count.type_id 
                                GROUP BY factory_id
                            )";
            $del_factory_id = $this->getResult(3);
            $limit_f = count(explode(',', $del_factory_id));
            if ($limit_f) {
                $this->where = "type_name='factory' and type_id in ({$del_factory_id})";
                $this->limit = $limit_f;
                $r = $this->del();
                #echo $this->sql . "\n";
            }
            #恢复初始值，避免后续查询出错
            $this->limit = 1;
        }
        //
        $file_obj = new cardbFile();
        $file_obj->where = 'ppos<900 and type_name="model" and type_id in (select model_id from cardb_model where state in(3,8))';
        $file_obj->fields = "s1,count(*) scount";
        $file_obj->group = 's1';
        $res = $file_obj->getResult(4);
        foreach ($res as $k => $v) {
            $this->ufields = array(
                'type_name' => 'series',
                'type_id' => $k,
                'total' => $v,
            );
            $this->where = "type_name='series' and type_id='{$k}'";
            $this->fields = "*";
            $s = $this->getResult();
            if ($s) {
                $this->update();
            } else {
                $this->insert();
            }
        }
        return true;
    }

    function countParent() {
        $brand = new brand();
        $factory = new factory();
        $series = new series();
        $file = new cardbFile();
        $this->fields = "type_id,total";
        $this->where = "type_name='series'";
        $r = $this->getResult(4);

        $factory_count = $brand_count = array();
        $allseries = $series->getAllSeries("s.factory_id=f.factory_id and f.brand_id=b.brand_id");
        foreach ($allseries as $k => $v) {
            $file->tables = array(
                'cardb_file' => 'f',
                'cardb_model' => 'm',
            );
            $file->where = "f.type_name='model' AND f.type_id=m.model_id AND m.state IN (3,8) AND m.series_id='{$v['series_id']}'";
            $file->fields = "f.type_id,f.updated";
            $file->order = array('f.updated' => 'desc');
            $last_updated = $file->joinTable();
            
            #如果是在售车款图片数据，则取最近入库的车款ID，图片库入库时间
            if ($last_updated) {
                $this->ufields = array(
                    'parent_id' => $v['factory_id'],
                    'last_updated' => $last_updated['updated'],
                    'last_model_id' => $last_updated['type_id'],
                );
                $this->where = "type_name='series' and type_id='{$v['series_id']}'";
                $this->update();

                $factory_count[$v['factory_id']]['last_updated'] = $last_updated['updated'];
                $factory_count[$v['factory_id']]['last_model_id'] = $last_updated['type_id'];
                
                $brand_count[$v['brand_id']]['last_updated'] = $last_updated['updated'];
                $brand_count[$v['brand_id']]['last_model_id'] = $last_updated['type_id'];
            }
            $factory_count[$v['factory_id']]['total'] += intval($r[$v['series_id']]);
            $factory_count[$v['factory_id']]['parent_id'] = $v['brand_id'];
            
            $brand_count[$v['brand_id']]['total'] += intval($r[$v['series_id']]);
        }
        #echo "factory_count:\n" . var_export($factory_count, true) . "\nbrand_count:\n" . var_export($brand_count, true) . "\n";
        foreach ($factory_count as $k => $v) {
            $this->ufields = array(
                'type_name' => 'factory',
                'type_id' => $k,
                'parent_id' => $v['parent_id'],
                'total' => $v['total'],
                'last_updated' => $v['last_updated'],
                'last_model_id' => $v['last_model_id'],
            );
            $this->where = "type_name='factory' and type_id='{$k}'";
            $f = $this->getResult();
            if ($f) {
                $this->update();
            } else {
                $this->insert();
            }
        }

        foreach ($brand_count as $k => $v) {
            $this->ufields = array(
                'type_name' => 'brand',
                'type_id' => $k,
                'parent_id' => '',
                'total' => $v['total'],
                'last_updated' => $v['last_updated'],
                'last_model_id' => $v['last_model_id'],
            );
            $this->where = "type_name='brand' and type_id='{$k}'";
            $b = $this->getResult();
            if ($b) {
                $this->update();
            } else {
                $this->insert();
            }
        }
        return true;
    }

    /**
     * 根据车款ID更新，所属的车系，厂商，品牌图片总数
     * <b>注：只计算在售车款的图片总数，停产不计算</b>
     * 
     * @param   int         $model_id       车款ID
     * @return  boolean     更新成功或失败状态
     */
    function updateFileCountByModel($model_id) {
        $file = new uploadFile();
        $file->where = "type_name='model' and type_id='{$model_id}'";
        $file->fields = "updated";
        $file->order = array('updated' => 'desc');
        $last_updated = $file->getResult(3);

        $model = new cardbModel();
        $m = $model->getModel($model_id);
        if ($m) {
            #当前车系下所有在售车款ID
            $model->where = "series_id='{$m['series_id']}' and state in (3,8)";
            $model->fields = "GROUP_CONCAT(model_id)";
            $model_id_s = $model->getResult(3);

            #当前厂商下所有在售车款ID
            $model->where = "factory_id='{$m['factory_id']}' and state in (3,8)";
            $model->fields = "GROUP_CONCAT(model_id)";
            $model_id_f = $model->getResult(3);

            #当前品牌下所有在售车款ID
            $model->where = "brand_id='{$m['brand_id']}' and state in (3,8)";
            $model->fields = "GROUP_CONCAT(model_id)";
            $model_id_b = $model->getResult(3);

            #当前车系图片总数
            $file->where = "type_name='model' and type_id in ({$model_id_s})";
            $file->fields = "count(id)";
            $total_s = $file->getResult(3);
            #当前厂商图片总数
            $file->where = "type_name='model' and type_id in ({$model_id_f})";
            $file->fields = "count(id)";
            $total_f = $file->getResult(3);
            #当前品牌图片总数
            $file->where = "type_name='model' and type_id in ({$model_id_b})";
            $file->fields = "count(id)";
            $total_b = $file->getResult(3);

            #更新车系图片数
            $this->where = "type_name='series' and type_id='{$m['series_id']}'";
            $s = $this->getResult();
            $this->ufields = array(
                'total' => $total_s,
                'parent_id' => $m['factory_id'],
                'last_updated' => $last_updated,
                'last_model_id' => $model_id
            );
            if ($s) {
                $this->where = "type_name='series' and type_id='{$m['series_id']}'";
                $rs = $this->update();
            } else {
                $rs = $this->insert();
            }
            #更新厂商图片数
            $this->where = "type_name='factory' and type_id='{$m['factory_id']}'";
            $f = $this->getResult();
            $this->ufields = array(
                'total' => $total_f,
                'parent_id' => $m['brand_id'],
                'last_updated' => $last_updated,
                'last_model_id' => $model_id
            );
            if ($f) {
                $this->where = "type_name='factory' and type_id='{$m['factory_id']}'";
                $rf = $this->update();
            } else {
                $rf = $this->insert();
            }
            #更新品牌图片数
            $this->where = "type_name='brand' and type_id='{$m['brand_id']}'";
            $b = $this->getResult();
            $this->ufields = array(
                'total' => $total_b,
                'last_updated' => $last_updated,
                'last_model_id' => $model_id
            );
            if ($b) {
                $this->where = "type_name='factory' and type_id='{$m['brand_id']}'";
                $rb = $this->update();
            } else {
                $rb = $this->insert();
            }
            return $rs && $rf && $rb;
        }
        return false;
    }

}

#
{
    /*
      CREATE TABLE `cardb_file_count` (
      `id` int(10) unsigned NOT NULL auto_increment,
      `type_name` varchar(20) default NULL COMMENT '类型:brand,factory,series,model',
      `type_id` mediumint(6) unsigned default NULL COMMENT '类型ID',
      `parent_id` mediumint(6) unsigned default NULL COMMENT '父ID',
      `total` mediumint(6) unsigned default '0' COMMENT '图片数',
      `last_updated` int(10) unsigned default '0' COMMENT '图片最后入库的时间',
      `last_model_id` mediumint(8) unsigned default NULL COMMENT '最后更新的车款ID',
      PRIMARY KEY  (`id`),
      KEY `type_name` (`type_name`,`type_id`),
      KEY `parent_id` (`parent_id`),
      KEY `last_updated` (`last_updated`),
      KEY `last_model_id` (`last_model_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
     */
}
?>
