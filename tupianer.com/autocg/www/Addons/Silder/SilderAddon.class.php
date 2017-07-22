<?php

namespace Addons\Silder;

use Common\Controller\Addon;

/**
 * 幻灯片插件
 * @author  崔元欣 <15811506097@163.com>
 */
class SilderAddon extends Addon {

    public $info = array(
        'name' => 'Silder',
        'title' => '幻灯片',
        'description' => '幻灯片设置，包含图片展示效果，图片文字说明。',
        'status' => 1,
        'author' => '崔元欣',
        'version' => '1.0'
    );
    public $admin_list = array(
        'model' => 'Silder', //要查的表
        'order' => 'id desc', //排序,
        'listKey' => array(//这里定义的是除了id序号外的表格里字段显示的表头名
            'title' => '标题',
            'sildertext' => '幻灯片描述',
            'statustext' => '显示状态',
            'priorityr' => '优先级',
        ),
    );
    public $custom_adminlist = 'adminlist.html';

    public function table_name() {
        $db_prefix = C('DB_PREFIX');
        return $db_prefix;
    }

    public function install() {
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS `{$this->table_name()}silder` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
    `title` varchar(30) NOT NULL COMMENT '标题',
    `silderpic` int(11) NOT NULL COMMENT '图片ID',
    `sildertext` varchar(255) NOT NULL DEFAULT ' ' COMMENT '图片描述',
    `jumplink` varchar(255) NOT NULL DEFAULT ' ' COMMENT '跳转链接',
    `jumptype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '跳转方式（ 1:当前页 2:新标签）',
    `priorityr` tinyint(1) NOT NULL DEFAULT '0' COMMENT '优先级（0-9）',
    `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态（0：禁用，1：正常 -1：删除）',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Silder插件-数据库' ;
SQL;

        $hookModel = M('hooks');
        $where['name'] = 'Silder';

        $hookTest = $hookModel->where($where)->find();

        if (empty($hookTest)) {

            $data = array(
                'name' => 'Silder',
                'description' => 'Silder 插件所需钩子',
                'type' => 1,
                'update_time' => time(),
                'addons' => 'Silder'
            );

            $hookTest = $hookModel->add($data);

            if (flase === $hookTest) {
                session('addons_install_error', ',Silder 钩子创建错误，请检查是否重复。');
                return false;
            }
        }

        D()->execute($sql);

        if (count(M()->query("SHOW TABLES LIKE '" . $this->table_name() . "silder'")) != 1) {
            session('addons_install_error', ',silder表未创建成功，请手动检查插件中的sql，修复后重新安装');
            return false;
        }

        return true;
    }

    public function uninstall() {
        $db_prefix = C('DB_PREFIX');
        $sql = "DROP TABLE IF EXISTS `" . $this->table_name() . "silder`;";
        D()->execute($sql);

        $hookModel = M('hooks');
        $where['name'] = 'Silder';
        $hookModel->where($where)->delete();

        return true;
    }

    //实现的Silder钩子方法
    public function Silder($param) {
        $config = $this->getConfig();

        if (!$config['silder_swtich']) {
            return;
        }

        $SilderModel = D('Addons://Silder/Silder');
        $info = $SilderModel->silderLists($param);
        if (empty($info)) {
            return;
        }

        $this->assign('addons_config', $config);
        $this->assign('addons_info', $info);
        $this->display('widget');
    }

}
