<?php

namespace Addons\Email;

use Common\Controller\Addon;

/**
 * 邮件管理插件
 * @author  崔元欣 <15811506097@163.com>
 */
class EmailAddon extends Addon {

    public $info = array(
        'name' => 'Email',
        'title' => '邮件管理',
        'description' => '邮件发送插件',
        'status' => 1,
        'author' => '崔元欣',
        'version' => '0.1'
    );
    public $admin_list = array(
        'model' => 'Config', //要查的表
        'fields' => "name,title,remark,type,value", //要查的字段
        'map' => "", //查询条件, 如果需要可以再插件类的构造方法里动态重置这个属性
        'order' => 'id desc', //排序,
    );
    public $custom_adminlist = 'adminlist.html';

    //获取表前缀
    public function db_prefix() {
        $db_prefix = C('DB_PREFIX');
        return $db_prefix;
    }

    public function install() {



        $sql1 = <<<SQL
CREATE TABLE IF NOT EXISTS `{$this->db_prefix()}mail_history` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `create_time` int(11) NOT NULL,
  `from` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
SQL;

        $sql2 = <<<SQLT
   CREATE TABLE IF NOT EXISTS `{$this->db_prefix()}mail_history_link` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_id` int(11) NOT NULL,
  `to` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
SQLT;

        $sql3 = <<<SQLS
  CREATE TABLE IF NOT EXISTS `{$this->db_prefix()}mail_list` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
SQLS;
        $sql4 = <<<SQLF
CREATE TABLE IF NOT EXISTS `{$this->db_prefix()}mail_token` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `token` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
SQLF;
        $sql5 = <<<INSERT
INSERT INTO `{$this->db_prefix()}config` (`id`, `name`, `type`, `title`, `group`, `extra`, `remark`, `create_time`, `update_time`, `status`, `value`, `sort`) VALUES
(null, 'MAIL_TYPE', 4, '邮件类型', 5, 'SMTP模块发送\r\n其他模块发送', '', 1410491198, 1410491839, 1, '0', 1),
(null, 'MAIL_SMTP_HOST', 1, 'SMTP服务器', 5, '', '邮箱服务器名称[如：smtp.qq.com]', 1410491317, 1410937703, 1, 'smtp.qq.com', 2),
(null, 'MAIL_SMTP_PORT', 0, 'SMTP服务器端口', 5, '', '端口一般为25', 1410491384, 1410491384, 1, '465', 3),
(null, 'MAIL_SMTP_USER', 1, 'SMTP服务器用户名', 5, '', '邮箱用户名', 1410491508, 1410941682, 1, '12321312@qq.com', 4),
(null, 'MAIL_SMTP_PASS', 1, 'SMTP服务器密码', 5, '邮箱密码', '密码', 1410491656, 1410941695, 1, '11111', 5),
(null, 'MAIL_SMTP_CE', 1, '邮件发送测试', 5, '', '发送测试邮件用的，测试你的邮箱配置成功没有', 1410491698, 1410937656, 1, '213213@qq.com', 6),
(null, 'FROM_EMAIL', 1, '发件人名称', 5, '', '发件人名称', 1410925495, 1410925495, 1, '图片+', 0);
INSERT;
        D()->execute($sql1);
        D()->execute($sql2);
        D()->execute($sql3);
        D()->execute($sql4);
        D()->execute($sql5);
        return true;
    }

    public function uninstall() {
        $model = D();
        $model->execute("DROP TABLE IF EXISTS {$this->db_prefix()}mail_history;");
        $model->execute("DROP TABLE IF EXISTS {$this->db_prefix()}mail_history_link;");
        $model->execute("DROP TABLE IF EXISTS {$this->db_prefix()}mail_list;");
        $model->execute("DROP TABLE IF EXISTS {$this->db_prefix()}mail_token;");
        $model->table($this->DB_PREFIX() . "config")->where($this->admin_list['map'])->delete(); //不加这句，会导致删除插件后再安装不成功，原因是在config表中的名称重复，添加会失败，导致安装失败。
        return true;
    }

    //实现的pageFooter钩子方法
    public function pageFooter($param) {
        $this->display('subscribe');
    }

}
