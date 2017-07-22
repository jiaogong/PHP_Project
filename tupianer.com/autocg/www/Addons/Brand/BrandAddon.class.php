<?php

namespace Addons\Brand;

use Common\Controller\Addon;

/**
 * 品牌产品管理插件
 * @author 崔元欣 <15811506097@163.com>
 */
class BrandAddon extends Addon {

    public $info = array(
        'name' => 'Brand',
        'title' => '品牌产品管理',
        'description' => '品牌产品管理',
        'status' => 1,
        'author' => '崔元欣',
        'version' => '0.1'
    );
    public $admin_list = array(
        'model' => 'Brand', //要查的表
        'fields' => '*', //要查的字段
        'map' => '', //查询条件, 如果需要可以再插件类的构造方法里动态重置这个属性
        'order' => 'id asc', //排序,
        'list_grid' => array(//这里定义的是除了id序号外的表格里字段显示的表头名和模型一样支持函数和链接
            'brand:品牌',
            'manufacturer:厂商',
            'series:车系',
            'car:车款',
        ),
    );
    
    public $custom_adminlist = 'adminlist.html';

    //获取表前缀
    public function db_prefix() {
        $db_prefix = C('DB_PREFIX');
        return $db_prefix;
    } 

    public function install() {
        $sql1 = <<<SQL
CREATE TABLE IF NOT EXISTS `{$this->db_prefix()}brand` (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `brand` varchar(50) NOT NULL DEFAULT '' COMMENT '品牌',
  `brandpic` int(11) NOT NULL COMMENT '品牌图片ID',
  `manufacturer` varchar(50) NOT NULL DEFAULT '' COMMENT '厂商',
  `series` varchar(50) NOT NULL DEFAULT '' COMMENT '车系',
  `seriespic` int(11) NOT NULL COMMENT '车系图片ID',
  `car` varchar(255) NOT NULL DEFAULT '' COMMENT '车款',
  `carpic` int(11) NOT NULL COMMENT '车款图片ID',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态（1：正常 -1：删除）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
SQL;
        $hookModel = M('hooks');
        $where['name'] = 'Brand';
        $hookTest = $hookModel->where($where)->find();
        if (empty($hookTest)) {

            $data = array(
                'name' => 'Brand',
                'description' => 'Brand 插件所需钩子',
                'type' => 1,
                'update_time' => time(),
                'addons' => 'Brand'
            );

            $hookTest = $hookModel->add($data);

            if (flase === $hookTest) {
                session('addons_install_error', ',Brand 钩子创建错误，请检查是否重复。');
                return false;
            }
        }
        D()->execute($sql1);
        if (count(M()->query("SHOW TABLES LIKE '" . $this->db_prefix() . "brand'")) != 1) {
            session('addons_install_error', ',brand表未创建成功，请手动检查插件中的sql，修复后重新安装');
            return false;
        }

        return true;
    }

    public function uninstall() {
        $db_prefix = C('DB_PREFIX');
        $sql = "DROP TABLE IF EXISTS `" . $this->db_prefix() . "brand`;";
        D()->execute($sql);

        $hookModel = M('hooks');
        $where['name'] = 'Brand';
        $hookModel->where($where)->delete();

        return true;
    }

}
