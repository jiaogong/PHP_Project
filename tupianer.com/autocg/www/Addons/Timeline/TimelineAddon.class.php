<?php

namespace Addons\Timeline;

use Common\Controller\Addon;

/**
 * 工作时间轴插件
 * @author 崔元欣 <15811506097@163.com>
 */
class TimelineAddon extends Addon {

    public function __construct() {
        parent::__construct();
        include_once $this->addon_path . 'function.php';
    }

    public $info = array(
        'name' => 'Timeline',
        'title' => '行业资讯管理',
        'description' => '行业资讯管理时间轴展示',
        'status' => 0,
        'author' => '崔元欣',
        'version' => '0.1'
    );
    public $admin_list = array(
        'model' => 'Timeline', //要查的表
        'fields' => '*', //要查的字段
        'map' => '', //查询条件, 如果需要可以再插件类的构造方法里动态重置这个属性
        'order' => 'id asc', //排序,
        'list_grid' => array(//这里定义的是除了id序号外的表格里字段显示的表头名，规则和模型里的规则一样
            'title:标题',
            'date:创建时间',
            'link:链接',
            'source:来源',
            'id:操作:[EDIT]|编辑,[DELETE]|删除'
        )
    );

    //获取表前缀
    public function db_prefix() {
        $db_prefix = C('DB_PREFIX');
        return $db_prefix;
    }

    public function install() {
        $sql1 = <<<SQL
CREATE TABLE IF NOT EXISTS `{$this->db_prefix()}timeline` (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `date` varchar(22) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `link` varchar(255) NOT NULL DEFAULT 'Jay' COMMENT '链接',
  `source` varchar(255) NOT NULL DEFAULT '' COMMENT '来源',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
SQL;
        $hookModel = M('hooks');
        $where['name'] = 'Timeline';
        $hookTest = $hookModel->where($where)->find();
        if (empty($hookTest)) {

            $data = array(
                'name' => 'Timeline',
                'description' => 'Timeline 插件所需钩子',
                'type' => 1,
                'update_time' => time(),
                'addons' => 'Timeline'
            );

            $hookTest = $hookModel->add($data);

            if (flase === $hookTest) {
                session('addons_install_error', ',Timeline 钩子创建错误，请检查是否重复。');
                return false;
            }
        }
        D()->execute($sql1);
        if (count(M()->query("SHOW TABLES LIKE '" . $this->db_prefix() . "timeline'")) != 1) {
            session('addons_install_error', ',timeline表未创建成功，请手动检查插件中的sql，修复后重新安装');
            return false;
        }

        return true;
    }

    public function uninstall() {
        $db_prefix = C('DB_PREFIX');
        $sql = "DROP TABLE IF EXISTS `" . $this->db_prefix() . "timeline`;";
        D()->execute($sql);

        $hookModel = M('hooks');
        $where['name'] = 'Timeline';
        $hookModel->where($where)->delete();

        return true;
    }

    //实现的single钩子方法
    public function Timeline($param) {
        if ($param['name'] == 'Timeline') {
            $this->display('single');
        }
    }

}
