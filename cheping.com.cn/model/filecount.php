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
