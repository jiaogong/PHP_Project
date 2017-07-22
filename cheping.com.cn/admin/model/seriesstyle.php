<?php

/**
 * seriesStyle
 * $Id: seriesstyle.php 2668 2016-05-14 00:10:01Z david $
 */
class seriesStyle extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = "cardb_series_style";
    }

    /**
     * 更新车系外观及图片数据
     * 
     * <b>参数数组格式示例：</b>
     * <pre>
      array(
      'series_id' => $value['series_id'],
      'st4' => $v['st4_id'],
      'st21' => $v['st21_id'],
      'st15' => $v['st15_id'],
      'date' => $v['date_id'],
      'pic' => $p1['name'],
      'type' => 1,#0外观白底，1外观实拍
      );
     * </pre>
     * @param array $data   格式{'series_id', 'st4', 'st15', 'st21', 'date', 'pic', 'type'}
     */
    function updateStyle($data) {
        $this->ufields = $data;
        $this->fields = "id";
        $this->where = "series_id='{$data['series_id']}' and st4='{$data['st4']}' and st21='{$data['st21']}' and "
                . "date='{$data['date']}' and type='{$data['type']}'";
        $id = $this->getResult(3);
        if ($id) {
            $this->ufields['updated'] = $this->timestamp;
            $r = $this->update();
        } else {
            $this->ufields['created'] = $this->ufields['updated'] = $this->timestamp;
            $r = $this->insert();
        }
        return $r;
    }

    /**
     * 根据条件，取车系外观表中的ID数组，
     * 
     * <b>当满足条件的记录为一条时，直接返回ID数值，多条记录时，返回多ID的数组</b>
     * <pre>
     * 示例：getStyleId("series_id='{$series_id}'");
     * </pre>
     * 
     * @param   string          $where      查询条件
     * @return  int/array       当结果为一条记录里，直接返回ID数值(int)，多条记录为数组(array)
     */
    function getStyleId($where) {
        $this->fields = "id";
        $this->where = $where;
        $ida = $this->getResult(4);
        return $ida;
    }

}

#sql script
{
    /*
      CREATE TABLE `cardb_series_style` (
      `id` int(10) unsigned NOT NULL auto_increment,
      `series_id` mediumint(6) unsigned default NULL,
      `st4` tinyint(2) default '0',
      `st21` tinyint(2) unsigned default '0',
      `st15` smallint(5) unsigned default '0',
      `date` smallint(4) unsigned default '0',
      `type` tinyint(1) default '0' COMMENT '0外观白底,1外观实拍',
      `pic` varchar(100) default '' COMMENT '外观图名称',
      `created` int(10) unsigned default NULL COMMENT '创建时间',
      `updated` int(10) unsigned default NULL COMMENT '修改时间',
      PRIMARY KEY  (`id`),
      KEY `series_id` (`series_id`),
      KEY `type` (`type`),
      KEY `pic` (`pic`),
      KEY `updated` (`updated`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
     */
}
?>
