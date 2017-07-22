/*
Navicat MySQL Data Transfer

Source Server         : 
Source Server Version : 50172
Source Host           : 
Source Database       : ot

Target Server Type    : MYSQL
Target Server Version : 50172
File Encoding         : 65001

Date: 2015-12-31 21:44:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tu_action
-- ----------------------------
DROP TABLE IF EXISTS `tu_action`;
CREATE TABLE `tu_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '行为唯一标识',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '行为说明',
  `remark` char(140) NOT NULL DEFAULT '' COMMENT '行为描述',
  `rule` text COMMENT '行为规则',
  `log` text COMMENT '日志规则',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统行为表';

-- ----------------------------
-- Records of tu_action
-- ----------------------------
INSERT INTO `tu_action` VALUES ('1', 'user_login', '用户登录', '积分+10，每天一次', 'table:member|field:score|condition:uid={$self} AND status>-1|rule:score+10|cycle:24|max:1;', '[user|get_nickname]在[time|time_format]登录了后台', '1', '1', '1387181220');
INSERT INTO `tu_action` VALUES ('2', 'add_article', '发布文章', '积分+5，每天上限5次', 'table:member|field:score|condition:uid={$self}|rule:score+5|cycle:24|max:5', '', '2', '0', '1380173180');
INSERT INTO `tu_action` VALUES ('3', 'review', '评论', '评论积分+1，无限制', 'table:member|field:score|condition:uid={$self}|rule:score+1', '', '2', '1', '1383285646');
INSERT INTO `tu_action` VALUES ('4', 'add_document', '发表文档', '积分+10，每天上限5次', 'table:member|field:score|condition:uid={$self}|rule:score+10|cycle:24|max:5', '[user|get_nickname]在[time|time_format]发表了一篇文章。\r\n表[model]，记录编号[record]。', '2', '0', '1386139726');
INSERT INTO `tu_action` VALUES ('5', 'add_document_topic', '发表讨论', '积分+5，每天上限10次', 'table:member|field:score|condition:uid={$self}|rule:score+5|cycle:24|max:10', '', '2', '0', '1383285551');
INSERT INTO `tu_action` VALUES ('6', 'update_config', '更新配置', '新增或修改或删除配置', '', '', '1', '1', '1383294988');
INSERT INTO `tu_action` VALUES ('7', 'update_model', '更新模型', '新增或修改模型', '', '', '1', '1', '1383295057');
INSERT INTO `tu_action` VALUES ('8', 'update_attribute', '更新属性', '新增或更新或删除属性', '', '', '1', '1', '1383295963');
INSERT INTO `tu_action` VALUES ('9', 'update_channel', '更新导航', '新增或修改或删除导航', '', '', '1', '1', '1383296301');
INSERT INTO `tu_action` VALUES ('10', 'update_menu', '更新菜单', '新增或修改或删除菜单', '', '', '1', '1', '1383296392');
INSERT INTO `tu_action` VALUES ('11', 'update_category', '更新分类', '新增或修改或删除分类', '', '', '1', '1', '1383296765');

-- ----------------------------
-- Table structure for tu_action_log
-- ----------------------------
DROP TABLE IF EXISTS `tu_action_log`;
CREATE TABLE `tu_action_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `action_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '行为id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行用户id',
  `action_ip` bigint(20) NOT NULL COMMENT '执行行为者ip',
  `model` varchar(50) NOT NULL DEFAULT '' COMMENT '触发行为的表',
  `record_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '触发行为的数据id',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '日志备注',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行行为的时间',
  PRIMARY KEY (`id`),
  KEY `action_ip_ix` (`action_ip`),
  KEY `action_id_ix` (`action_id`),
  KEY `user_id_ix` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='行为日志表';

-- ----------------------------
-- Records of tu_action_log
-- ----------------------------
INSERT INTO `tu_action_log` VALUES ('1', '1', '1', '0', 'member', '1', 'admin在2015-12-18 15:46登录了后台', '1', '1450424794');
INSERT INTO `tu_action_log` VALUES ('2', '1', '1', '0', 'member', '1', 'admin在2015-12-21 10:15登录了后台', '1', '1450664134');
INSERT INTO `tu_action_log` VALUES ('3', '10', '1', '0', 'Menu', '27', '操作url：/autocg/www/admin.php?s=/Menu/edit.html', '1', '1450681232');
INSERT INTO `tu_action_log` VALUES ('4', '10', '1', '0', 'Menu', '17', '操作url：/autocg/www/admin.php?s=/Menu/edit.html', '1', '1450681413');
INSERT INTO `tu_action_log` VALUES ('5', '10', '1', '0', 'Menu', '27', '操作url：/autocg/www/admin.php?s=/Menu/edit.html', '1', '1450681446');
INSERT INTO `tu_action_log` VALUES ('6', '10', '1', '0', 'Menu', '124', '操作url：/autocg/www/admin.php?s=/Menu/add.html', '1', '1450681603');
INSERT INTO `tu_action_log` VALUES ('7', '1', '1', '2130706433', 'member', '1', 'admin在2015-12-21 15:40登录了后台', '1', '1450683634');
INSERT INTO `tu_action_log` VALUES ('8', '10', '1', '0', 'Menu', '125', '操作url：/autocg/www/admin.php?s=/Menu/add.html', '1', '1450683697');
INSERT INTO `tu_action_log` VALUES ('9', '10', '1', '0', 'Menu', '27', '操作url：/autocg/www/admin.php?s=/Menu/edit.html', '1', '1450694496');
INSERT INTO `tu_action_log` VALUES ('10', '1', '1', '2130706433', 'member', '1', 'admin在2015-12-21 19:49登录了后台', '1', '1450698567');
INSERT INTO `tu_action_log` VALUES ('11', '10', '1', '0', 'Menu', '126', '操作url：/autocg/www/admin.php?s=/Menu/add.html', '1', '1450699352');
INSERT INTO `tu_action_log` VALUES ('12', '10', '1', '0', 'Menu', '127', '操作url：/autocg/www/admin.php?s=/Menu/add.html', '1', '1450699481');
INSERT INTO `tu_action_log` VALUES ('13', '1', '1', '2130706433', 'member', '1', 'admin在2015-12-23 10:07登录了后台', '1', '1450836462');
INSERT INTO `tu_action_log` VALUES ('14', '10', '1', '0', 'Menu', '128', '操作url：/autocg/www/admin.php?s=/Menu/add.html', '1', '1451297024');
INSERT INTO `tu_action_log` VALUES ('15', '10', '1', '0', 'Menu', '127', '操作url：/autocg/www/admin.php?s=/Menu/edit.html', '1', '1451297044');
INSERT INTO `tu_action_log` VALUES ('16', '10', '1', '0', 'Menu', '0', '操作url：/autocg/www/admin.php?s=/Menu/del/id/143.html', '1', '1451299249');
INSERT INTO `tu_action_log` VALUES ('17', '10', '1', '0', 'Menu', '0', '操作url：/autocg/www/admin.php?s=/Menu/del/id/144.html', '1', '1451299272');
INSERT INTO `tu_action_log` VALUES ('18', '10', '1', '0', 'Menu', '150', '操作url：/autocg/www/admin.php?s=/Menu/add.html', '1', '1451355019');
INSERT INTO `tu_action_log` VALUES ('19', '10', '1', '0', 'Menu', '151', '操作url：/autocg/www/admin.php?s=/Menu/add.html', '1', '1451356519');
INSERT INTO `tu_action_log` VALUES ('20', '10', '1', '0', 'Menu', '152', '操作url：/autocg/www/admin.php?s=/Menu/add.html', '1', '1451357258');
INSERT INTO `tu_action_log` VALUES ('21', '1', '1', '2130706433', 'member', '1', 'admin在2015-12-29 14:44登录了后台', '1', '1451371453');
INSERT INTO `tu_action_log` VALUES ('22', '10', '1', '0', 'Menu', '153', '操作url：/autocg/www/admin.php?s=/Menu/add.html', '1', '1451448503');
INSERT INTO `tu_action_log` VALUES ('23', '1', '1', '2130706433', 'member', '1', 'admin在2015-12-30 17:13登录了后台', '1', '1451466811');

-- ----------------------------
-- Table structure for tu_addons
-- ----------------------------
DROP TABLE IF EXISTS `tu_addons`;
CREATE TABLE `tu_addons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL COMMENT '插件名或标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text COMMENT '插件描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `config` text COMMENT '配置',
  `author` varchar(40) DEFAULT '' COMMENT '作者',
  `version` varchar(20) DEFAULT '' COMMENT '版本号',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `has_adminlist` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台列表',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='插件表';

-- ----------------------------
-- Records of tu_addons
-- ----------------------------
INSERT INTO `tu_addons` VALUES ('15', 'EditorForAdmin', '后台编辑器', '用于增强整站长文本的输入和显示', '1', '{\"editor_type\":\"2\",\"editor_wysiwyg\":\"1\",\"editor_height\":\"500px\",\"editor_resize_type\":\"1\"}', 'thinkphp', '0.1', '1383126253', '0');
INSERT INTO `tu_addons` VALUES ('2', 'SiteStat', '站点统计信息', '统计站点的基础信息', '1', '{\"title\":\"\\u7cfb\\u7edf\\u4fe1\\u606f\",\"width\":\"1\",\"display\":\"1\",\"status\":\"0\"}', 'thinkphp', '0.1', '1379512015', '0');
INSERT INTO `tu_addons` VALUES ('3', 'DevTeam', '开发团队信息', '开发团队成员信息', '1', '{\"title\":\"OneThink\\u5f00\\u53d1\\u56e2\\u961f\",\"width\":\"2\",\"display\":\"1\"}', 'thinkphp', '0.1', '1379512022', '0');
INSERT INTO `tu_addons` VALUES ('4', 'SystemInfo', '系统环境信息', '用于显示一些服务器的信息', '1', '{\"title\":\"\\u7cfb\\u7edf\\u4fe1\\u606f\",\"width\":\"2\",\"display\":\"1\"}', 'thinkphp', '0.1', '1379512036', '0');
INSERT INTO `tu_addons` VALUES ('5', 'Editor', '前台编辑器', '用于增强整站长文本的输入和显示', '1', '{\"editor_type\":\"2\",\"editor_wysiwyg\":\"1\",\"editor_height\":\"300px\",\"editor_resize_type\":\"1\"}', 'thinkphp', '0.1', '1379830910', '0');
INSERT INTO `tu_addons` VALUES ('6', 'Attachment', '附件', '用于文档模型上传附件', '1', 'null', 'thinkphp', '0.1', '1379842319', '1');
INSERT INTO `tu_addons` VALUES ('9', 'SocialComment', '通用社交化评论', '集成了各种社交化评论插件，轻松集成到系统中。', '1', '{\"comment_type\":\"1\",\"comment_uid_youyan\":\"\",\"comment_short_name_duoshuo\":\"\",\"comment_data_list_duoshuo\":\"\"}', 'thinkphp', '0.1', '1380273962', '0');
INSERT INTO `tu_addons` VALUES ('17', 'Email', '邮件管理', '邮件发送插件', '1', '{\"random\":\"1\"}', '崔元欣', '0.1', '1450686234', '1');
INSERT INTO `tu_addons` VALUES ('18', 'Silder', '幻灯片', '幻灯片设置，包含图片展示效果，图片文字说明。', '1', '{\"silder_swtich\":\"1\",\"silder_effect\":\"slideInLeft\",\"silder_animspeed\":\"2000\"}', '崔元欣', '1.0', '1450781146', '1');
INSERT INTO `tu_addons` VALUES ('21', 'Brand', '品牌产品管理', '品牌产品管理', '1', '{\"random\":\"1\"}', '崔元欣', '0.1', '1450948674', '1');
INSERT INTO `tu_addons` VALUES ('20', 'Timeline', '行业资讯管理', '行业资讯管理时间轴展示', '1', '{\"random\":\"1\"}', '崔元欣', '0.1', '1450941345', '1');
INSERT INTO `tu_addons` VALUES ('23', 'Qualifications', '资质审核管理', '这是一个资质审核管理', '1', '{\"random\":\"1\"}', '崔元欣', '0.1', '1451558483', '1');

-- ----------------------------
-- Table structure for tu_aptitude
-- ----------------------------
DROP TABLE IF EXISTS `tu_aptitude`;
CREATE TABLE `tu_aptitude` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `license` int(11) NOT NULL COMMENT '营业执照',
  `enterprise` varchar(255) NOT NULL COMMENT '企业名称',
  `address` varchar(255) NOT NULL COMMENT '企业联系地址',
  `contacts` varchar(255) NOT NULL COMMENT '联系人',
  `telephone` varchar(255) NOT NULL COMMENT '联系电话',
  `bankcard` varchar(255) NOT NULL COMMENT '银行卡号',
  `account` varchar(100) NOT NULL COMMENT '开户银行',
  `type` int(2) NOT NULL DEFAULT '1' COMMENT '分类  1:厂商2:代理3:设计师',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_aptitude
-- ----------------------------
INSERT INTO `tu_aptitude` VALUES ('1', '6', '百度', '北京市不知道的区什么什么楼', '李鸿章', '13037047497', '', '', '1');

-- ----------------------------
-- Table structure for tu_ar_message_receiver
-- ----------------------------
DROP TABLE IF EXISTS `tu_ar_message_receiver`;
CREATE TABLE `tu_ar_message_receiver` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL COMMENT '与发件箱id关联',
  `to_uid` int(11) NOT NULL COMMENT '收件人id',
  `to_username` varchar(32) NOT NULL COMMENT '收件人用户名',
  `is_readed` tinyint(4) NOT NULL DEFAULT '0' COMMENT '收件人是否已读 1:是0:否',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '收件人是否删除 1:是0:否',
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_ar_message_receiver
-- ----------------------------
INSERT INTO `tu_ar_message_receiver` VALUES ('1', '6', '22', 'ceshi', '0', '0');
INSERT INTO `tu_ar_message_receiver` VALUES ('2', '7', '0', '', '0', '0');
INSERT INTO `tu_ar_message_receiver` VALUES ('3', '8', '22', 'ceshi', '0', '0');
INSERT INTO `tu_ar_message_receiver` VALUES ('4', '9', '22', 'ceshi', '0', '0');

-- ----------------------------
-- Table structure for tu_attachment
-- ----------------------------
DROP TABLE IF EXISTS `tu_attachment`;
CREATE TABLE `tu_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '附件显示名',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '附件类型',
  `source` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '资源ID',
  `record_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联记录ID',
  `download` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '附件大小',
  `dir` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '上级目录ID',
  `sort` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `idx_record_status` (`record_id`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='附件表';

-- ----------------------------
-- Records of tu_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for tu_attribute
-- ----------------------------
DROP TABLE IF EXISTS `tu_attribute`;
CREATE TABLE `tu_attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '字段名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '字段注释',
  `field` varchar(100) NOT NULL DEFAULT '' COMMENT '字段定义',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '数据类型',
  `value` varchar(100) NOT NULL DEFAULT '' COMMENT '字段默认值',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '参数',
  `model_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型id',
  `is_must` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否必填',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `validate_rule` varchar(255) NOT NULL DEFAULT '',
  `validate_time` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `error_info` varchar(100) NOT NULL DEFAULT '',
  `validate_type` varchar(25) NOT NULL DEFAULT '',
  `auto_rule` varchar(100) NOT NULL DEFAULT '',
  `auto_time` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `auto_type` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `model_id` (`model_id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='模型属性表';

-- ----------------------------
-- Records of tu_attribute
-- ----------------------------
INSERT INTO `tu_attribute` VALUES ('1', 'uid', '用户ID', 'int(10) unsigned NOT NULL ', 'num', '0', '', '0', '', '1', '0', '1', '1384508362', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('2', 'name', '标识', 'char(40) NOT NULL ', 'string', '', '同一根节点下标识不重复', '1', '', '1', '0', '1', '1383894743', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('3', 'title', '标题', 'char(80) NOT NULL ', 'string', '', '文档标题', '1', '', '1', '0', '1', '1383894778', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('4', 'category_id', '所属分类', 'int(10) unsigned NOT NULL ', 'string', '', '', '0', '', '1', '0', '1', '1384508336', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('5', 'description', '描述', 'char(140) NOT NULL ', 'textarea', '', '', '1', '', '1', '0', '1', '1383894927', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('6', 'root', '根节点', 'int(10) unsigned NOT NULL ', 'num', '0', '该文档的顶级文档编号', '0', '', '1', '0', '1', '1384508323', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('7', 'pid', '所属ID', 'int(10) unsigned NOT NULL ', 'num', '0', '父文档编号', '0', '', '1', '0', '1', '1384508543', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('8', 'model_id', '内容模型ID', 'tinyint(3) unsigned NOT NULL ', 'num', '0', '该文档所对应的模型', '0', '', '1', '0', '1', '1384508350', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('9', 'type', '内容类型', 'tinyint(3) unsigned NOT NULL ', 'select', '2', '', '1', '1:目录\r\n2:主题\r\n3:段落', '1', '0', '1', '1384511157', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('10', 'position', '推荐位', 'smallint(5) unsigned NOT NULL ', 'checkbox', '0', '多个推荐则将其推荐值相加', '1', '[DOCUMENT_POSITION]', '1', '0', '1', '1383895640', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('11', 'link_id', '外链', 'int(10) unsigned NOT NULL ', 'num', '0', '0-非外链，大于0-外链ID,需要函数进行链接与编号的转换', '1', '', '1', '0', '1', '1383895757', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('12', 'cover_id', '封面', 'int(10) unsigned NOT NULL ', 'picture', '0', '0-无封面，大于0-封面图片ID，需要函数处理', '1', '', '1', '0', '1', '1384147827', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('13', 'display', '可见性', 'tinyint(3) unsigned NOT NULL ', 'radio', '1', '', '1', '0:不可见\r\n1:所有人可见', '1', '0', '1', '1386662271', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `tu_attribute` VALUES ('14', 'deadline', '截至时间', 'int(10) unsigned NOT NULL ', 'datetime', '0', '0-永久有效', '1', '', '1', '0', '1', '1387163248', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `tu_attribute` VALUES ('15', 'attach', '附件数量', 'tinyint(3) unsigned NOT NULL ', 'num', '0', '', '0', '', '1', '0', '1', '1387260355', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `tu_attribute` VALUES ('16', 'view', '浏览量', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '', '1', '0', '1', '1383895835', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('17', 'comment', '评论数', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '', '1', '0', '1', '1383895846', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('18', 'extend', '扩展统计字段', 'int(10) unsigned NOT NULL ', 'num', '0', '根据需求自行使用', '0', '', '1', '0', '1', '1384508264', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('19', 'level', '优先级', 'int(10) unsigned NOT NULL ', 'num', '0', '越高排序越靠前', '1', '', '1', '0', '1', '1383895894', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('20', 'create_time', '创建时间', 'int(10) unsigned NOT NULL ', 'datetime', '0', '', '1', '', '1', '0', '1', '1383895903', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('21', 'update_time', '更新时间', 'int(10) unsigned NOT NULL ', 'datetime', '0', '', '0', '', '1', '0', '1', '1384508277', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('22', 'status', '数据状态', 'tinyint(4) NOT NULL ', 'radio', '0', '', '0', '-1:删除\r\n0:禁用\r\n1:正常\r\n2:待审核\r\n3:草稿', '1', '0', '1', '1384508496', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('23', 'parse', '内容解析类型', 'tinyint(3) unsigned NOT NULL ', 'select', '0', '', '0', '0:html\r\n1:ubb\r\n2:markdown', '2', '0', '1', '1384511049', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('24', 'content', '文章内容', 'text NOT NULL ', 'editor', '', '', '1', '', '2', '0', '1', '1383896225', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('25', 'template', '详情页显示模板', 'varchar(100) NOT NULL ', 'string', '', '参照display方法参数的定义', '1', '', '2', '0', '1', '1383896190', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('26', 'bookmark', '收藏数', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '', '2', '0', '1', '1383896103', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('27', 'parse', '内容解析类型', 'tinyint(3) unsigned NOT NULL ', 'select', '0', '', '0', '0:html\r\n1:ubb\r\n2:markdown', '3', '0', '1', '1387260461', '1383891252', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `tu_attribute` VALUES ('28', 'content', '下载详细描述', 'text NOT NULL ', 'editor', '', '', '1', '', '3', '0', '1', '1383896438', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('29', 'template', '详情页显示模板', 'varchar(100) NOT NULL ', 'string', '', '', '1', '', '3', '0', '1', '1383896429', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('30', 'file_id', '文件ID', 'int(10) unsigned NOT NULL ', 'file', '0', '需要函数处理', '1', '', '3', '0', '1', '1383896415', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('31', 'download', '下载次数', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '', '3', '0', '1', '1383896380', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `tu_attribute` VALUES ('32', 'size', '文件大小', 'bigint(20) unsigned NOT NULL ', 'num', '0', '单位bit', '1', '', '3', '0', '1', '1383896371', '1383891252', '', '0', '', '', '', '0', '');

-- ----------------------------
-- Table structure for tu_auth_extend
-- ----------------------------
DROP TABLE IF EXISTS `tu_auth_extend`;
CREATE TABLE `tu_auth_extend` (
  `group_id` mediumint(10) unsigned NOT NULL COMMENT '用户id',
  `extend_id` mediumint(8) unsigned NOT NULL COMMENT '扩展表中数据的id',
  `type` tinyint(1) unsigned NOT NULL COMMENT '扩展类型标识 1:栏目分类权限;2:模型权限',
  UNIQUE KEY `group_extend_type` (`group_id`,`extend_id`,`type`),
  KEY `uid` (`group_id`),
  KEY `group_id` (`extend_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组与分类的对应关系表';

-- ----------------------------
-- Records of tu_auth_extend
-- ----------------------------
INSERT INTO `tu_auth_extend` VALUES ('1', '1', '1');
INSERT INTO `tu_auth_extend` VALUES ('1', '1', '2');
INSERT INTO `tu_auth_extend` VALUES ('1', '2', '1');
INSERT INTO `tu_auth_extend` VALUES ('1', '2', '2');
INSERT INTO `tu_auth_extend` VALUES ('1', '3', '1');
INSERT INTO `tu_auth_extend` VALUES ('1', '3', '2');
INSERT INTO `tu_auth_extend` VALUES ('1', '4', '1');
INSERT INTO `tu_auth_extend` VALUES ('1', '37', '1');

-- ----------------------------
-- Table structure for tu_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `tu_auth_group`;
CREATE TABLE `tu_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键',
  `module` varchar(20) NOT NULL DEFAULT '' COMMENT '用户组所属模块',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '组类型',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `description` varchar(80) NOT NULL DEFAULT '' COMMENT '描述信息',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户组状态：为1正常，为0禁用,-1为删除',
  `rules` varchar(500) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id，多个规则 , 隔开',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_auth_group
-- ----------------------------
INSERT INTO `tu_auth_group` VALUES ('1', 'admin', '1', '默认用户组', '', '1', '1,2,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,79,80,81,82,83,84,86,87,88,89,90,91,92,93,94,95,96,97,100,102,103,105,106');
INSERT INTO `tu_auth_group` VALUES ('2', 'admin', '1', '测试用户', '测试用户', '1', '1,2,5,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,79,80,82,83,84,88,89,90,91,92,93,96,97,100,102,103,195');
INSERT INTO `tu_auth_group` VALUES ('4', 'home', '1', '厂商', '测试前台权限', '1', '402,403,404');
INSERT INTO `tu_auth_group` VALUES ('5', 'home', '1', '代理', '测试前台权限', '1', '');
INSERT INTO `tu_auth_group` VALUES ('6', 'home', '1', '设计师', '测试前台权限', '1', '');
INSERT INTO `tu_auth_group` VALUES ('7', 'home', '1', '图片公司', '测试前台权限', '1', '');

-- ----------------------------
-- Table structure for tu_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `tu_auth_group_access`;
CREATE TABLE `tu_auth_group_access` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_auth_group_access
-- ----------------------------
INSERT INTO `tu_auth_group_access` VALUES ('22', '4');
INSERT INTO `tu_auth_group_access` VALUES ('23', '4');

-- ----------------------------
-- Table structure for tu_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `tu_auth_rule`;
CREATE TABLE `tu_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `module` varchar(20) NOT NULL COMMENT '规则所属module',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1-url;2-主菜单',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效(0:无效,1:有效)',
  `condition` varchar(300) NOT NULL DEFAULT '' COMMENT '规则附加条件',
  PRIMARY KEY (`id`),
  KEY `module` (`module`,`status`,`type`)
) ENGINE=MyISAM AUTO_INCREMENT=405 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_auth_rule
-- ----------------------------
INSERT INTO `tu_auth_rule` VALUES ('1', 'admin', '2', 'Admin/Index/index', '首页', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('2', 'admin', '2', 'Admin/Article/index', '内容', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('3', 'admin', '2', 'Admin/User/index', '用户', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('4', 'admin', '2', 'Admin/Addons/index', '扩展', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('5', 'admin', '2', 'Admin/Config/group', '系统', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('7', 'admin', '1', 'Admin/article/add', '新增', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('8', 'admin', '1', 'Admin/article/edit', '编辑', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('9', 'admin', '1', 'Admin/article/setStatus', '改变状态', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('10', 'admin', '1', 'Admin/article/update', '保存', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('11', 'admin', '1', 'Admin/article/autoSave', '保存草稿', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('12', 'admin', '1', 'Admin/article/move', '移动', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('13', 'admin', '1', 'Admin/article/copy', '复制', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('14', 'admin', '1', 'Admin/article/paste', '粘贴', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('15', 'admin', '1', 'Admin/article/permit', '还原', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('16', 'admin', '1', 'Admin/article/clear', '清空', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('17', 'admin', '1', 'Admin/Article/examine', '审核列表', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('18', 'admin', '1', 'Admin/article/recycle', '回收站', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('19', 'admin', '1', 'Admin/User/addaction', '新增用户行为', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('20', 'admin', '1', 'Admin/User/editaction', '编辑用户行为', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('21', 'admin', '1', 'Admin/User/saveAction', '保存用户行为', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('22', 'admin', '1', 'Admin/User/setStatus', '变更行为状态', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('23', 'admin', '1', 'Admin/User/changeStatus?method=forbidUser', '禁用会员', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('24', 'admin', '1', 'Admin/User/changeStatus?method=resumeUser', '启用会员', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('25', 'admin', '1', 'Admin/User/changeStatus?method=deleteUser', '删除会员', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('26', 'admin', '1', 'Admin/User/index', '用户信息', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('27', 'admin', '1', 'Admin/User/action', '用户行为', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('28', 'admin', '1', 'Admin/AuthManager/changeStatus?method=deleteGroup', '删除', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('29', 'admin', '1', 'Admin/AuthManager/changeStatus?method=forbidGroup', '禁用', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('30', 'admin', '1', 'Admin/AuthManager/changeStatus?method=resumeGroup', '恢复', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('31', 'admin', '1', 'Admin/AuthManager/createGroup', '新增', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('32', 'admin', '1', 'Admin/AuthManager/editGroup', '编辑', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('33', 'admin', '1', 'Admin/AuthManager/writeGroup', '保存用户组', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('34', 'admin', '1', 'Admin/AuthManager/group', '授权', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('35', 'admin', '1', 'Admin/AuthManager/access', '访问授权', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('36', 'admin', '1', 'Admin/AuthManager/user', '成员授权', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('37', 'admin', '1', 'Admin/AuthManager/removeFromGroup', '解除授权', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('38', 'admin', '1', 'Admin/AuthManager/addToGroup', '保存成员授权', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('39', 'admin', '1', 'Admin/AuthManager/category', '分类授权', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('40', 'admin', '1', 'Admin/AuthManager/addToCategory', '保存分类授权', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('41', 'admin', '1', 'Admin/AuthManager/index', '后台权限管理', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('42', 'admin', '1', 'Admin/Addons/create', '创建', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('43', 'admin', '1', 'Admin/Addons/checkForm', '检测创建', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('44', 'admin', '1', 'Admin/Addons/preview', '预览', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('45', 'admin', '1', 'Admin/Addons/build', '快速生成插件', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('46', 'admin', '1', 'Admin/Addons/config', '设置', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('47', 'admin', '1', 'Admin/Addons/disable', '禁用', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('48', 'admin', '1', 'Admin/Addons/enable', '启用', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('49', 'admin', '1', 'Admin/Addons/install', '安装', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('50', 'admin', '1', 'Admin/Addons/uninstall', '卸载', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('51', 'admin', '1', 'Admin/Addons/saveconfig', '更新配置', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('52', 'admin', '1', 'Admin/Addons/adminList', '插件后台列表', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('53', 'admin', '1', 'Admin/Addons/execute', 'URL方式访问插件', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('54', 'admin', '1', 'Admin/Addons/index', '插件管理', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('55', 'admin', '1', 'Admin/Addons/hooks', '钩子管理', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('56', 'admin', '1', 'Admin/model/add', '新增', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('57', 'admin', '1', 'Admin/model/edit', '编辑', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('58', 'admin', '1', 'Admin/model/setStatus', '改变状态', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('59', 'admin', '1', 'Admin/model/update', '保存数据', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('60', 'admin', '1', 'Admin/Model/index', '模型管理', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('61', 'admin', '1', 'Admin/Config/edit', '编辑', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('62', 'admin', '1', 'Admin/Config/del', '删除', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('63', 'admin', '1', 'Admin/Config/add', '新增', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('64', 'admin', '1', 'Admin/Config/save', '保存', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('65', 'admin', '1', 'Admin/Config/group', '网站设置', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('66', 'admin', '1', 'Admin/Config/index', '配置管理', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('67', 'admin', '1', 'Admin/Channel/add', '新增', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('68', 'admin', '1', 'Admin/Channel/edit', '编辑', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('69', 'admin', '1', 'Admin/Channel/del', '删除', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('70', 'admin', '1', 'Admin/Channel/index', '导航管理', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('71', 'admin', '1', 'Admin/Category/edit', '编辑', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('72', 'admin', '1', 'Admin/Category/add', '新增', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('73', 'admin', '1', 'Admin/Category/remove', '删除', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('74', 'admin', '1', 'Admin/Category/index', '分类管理', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('75', 'admin', '1', 'Admin/file/upload', '上传控件', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('76', 'admin', '1', 'Admin/file/uploadPicture', '上传图片', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('77', 'admin', '1', 'Admin/file/download', '下载', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('94', 'admin', '1', 'Admin/AuthManager/modelauth', '模型授权', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('79', 'admin', '1', 'Admin/article/batchOperate', '导入', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('80', 'admin', '1', 'Admin/Database/index?type=export', '备份数据库', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('81', 'admin', '1', 'Admin/Database/index?type=import', '还原数据库', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('82', 'admin', '1', 'Admin/Database/export', '备份', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('83', 'admin', '1', 'Admin/Database/optimize', '优化表', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('84', 'admin', '1', 'Admin/Database/repair', '修复表', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('86', 'admin', '1', 'Admin/Database/import', '恢复', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('87', 'admin', '1', 'Admin/Database/del', '删除', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('88', 'admin', '1', 'Admin/User/add', '新增用户', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('89', 'admin', '1', 'Admin/Attribute/index', '属性管理', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('90', 'admin', '1', 'Admin/Attribute/add', '新增', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('91', 'admin', '1', 'Admin/Attribute/edit', '编辑', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('92', 'admin', '1', 'Admin/Attribute/setStatus', '改变状态', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('93', 'admin', '1', 'Admin/Attribute/update', '保存数据', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('95', 'admin', '1', 'Admin/AuthManager/addToModel', '保存模型授权', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('96', 'admin', '1', 'Admin/Category/move', '移动', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('97', 'admin', '1', 'Admin/Category/merge', '合并', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('98', 'admin', '1', 'Admin/Config/menu', '后台菜单管理', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('99', 'admin', '1', 'Admin/Article/mydocument', '内容', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('100', 'admin', '1', 'Admin/Menu/index', '菜单管理', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('101', 'admin', '1', 'Admin/other', '其他', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('102', 'admin', '1', 'Admin/Menu/add', '新增', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('103', 'admin', '1', 'Admin/Menu/edit', '编辑', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('104', 'admin', '1', 'Admin/Think/lists?model=article', '文章管理', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('105', 'admin', '1', 'Admin/Think/lists?model=download', '下载管理', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('106', 'admin', '1', 'Admin/Think/lists?model=config', '配置管理', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('107', 'admin', '1', 'Admin/Action/actionlog', '行为日志', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('108', 'admin', '1', 'Admin/User/updatePassword', '修改密码', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('109', 'admin', '1', 'Admin/User/updateNickname', '修改昵称', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('110', 'admin', '1', 'Admin/action/edit', '查看行为日志', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('205', 'admin', '1', 'Admin/think/add', '新增数据', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('111', 'admin', '2', 'Admin/article/index', '文档列表', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('112', 'admin', '2', 'Admin/article/add', '新增', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('113', 'admin', '2', 'Admin/article/edit', '编辑', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('114', 'admin', '2', 'Admin/article/setStatus', '改变状态', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('115', 'admin', '2', 'Admin/article/update', '保存', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('116', 'admin', '2', 'Admin/article/autoSave', '保存草稿', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('117', 'admin', '2', 'Admin/article/move', '移动', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('118', 'admin', '2', 'Admin/article/copy', '复制', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('119', 'admin', '2', 'Admin/article/paste', '粘贴', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('120', 'admin', '2', 'Admin/article/batchOperate', '导入', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('121', 'admin', '2', 'Admin/article/recycle', '回收站', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('122', 'admin', '2', 'Admin/article/permit', '还原', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('123', 'admin', '2', 'Admin/article/clear', '清空', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('124', 'admin', '2', 'Admin/User/add', '新增用户', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('125', 'admin', '2', 'Admin/User/action', '用户行为', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('126', 'admin', '2', 'Admin/User/addAction', '新增用户行为', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('127', 'admin', '2', 'Admin/User/editAction', '编辑用户行为', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('128', 'admin', '2', 'Admin/User/saveAction', '保存用户行为', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('129', 'admin', '2', 'Admin/User/setStatus', '变更行为状态', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('130', 'admin', '2', 'Admin/User/changeStatus?method=forbidUser', '禁用会员', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('131', 'admin', '2', 'Admin/User/changeStatus?method=resumeUser', '启用会员', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('132', 'admin', '2', 'Admin/User/changeStatus?method=deleteUser', '删除会员', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('133', 'admin', '2', 'Admin/AuthManager/index', '权限管理', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('134', 'admin', '2', 'Admin/AuthManager/changeStatus?method=deleteGroup', '删除', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('135', 'admin', '2', 'Admin/AuthManager/changeStatus?method=forbidGroup', '禁用', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('136', 'admin', '2', 'Admin/AuthManager/changeStatus?method=resumeGroup', '恢复', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('137', 'admin', '2', 'Admin/AuthManager/createGroup', '新增', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('138', 'admin', '2', 'Admin/AuthManager/editGroup', '编辑', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('139', 'admin', '2', 'Admin/AuthManager/writeGroup', '保存用户组', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('140', 'admin', '2', 'Admin/AuthManager/group', '授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('141', 'admin', '2', 'Admin/AuthManager/access', '访问授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('142', 'admin', '2', 'Admin/AuthManager/user', '成员授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('143', 'admin', '2', 'Admin/AuthManager/removeFromGroup', '解除授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('144', 'admin', '2', 'Admin/AuthManager/addToGroup', '保存成员授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('145', 'admin', '2', 'Admin/AuthManager/category', '分类授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('146', 'admin', '2', 'Admin/AuthManager/addToCategory', '保存分类授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('147', 'admin', '2', 'Admin/AuthManager/modelauth', '模型授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('148', 'admin', '2', 'Admin/AuthManager/addToModel', '保存模型授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('149', 'admin', '2', 'Admin/Addons/create', '创建', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('150', 'admin', '2', 'Admin/Addons/checkForm', '检测创建', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('151', 'admin', '2', 'Admin/Addons/preview', '预览', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('152', 'admin', '2', 'Admin/Addons/build', '快速生成插件', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('153', 'admin', '2', 'Admin/Addons/config', '设置', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('154', 'admin', '2', 'Admin/Addons/disable', '禁用', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('155', 'admin', '2', 'Admin/Addons/enable', '启用', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('156', 'admin', '2', 'Admin/Addons/install', '安装', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('157', 'admin', '2', 'Admin/Addons/uninstall', '卸载', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('158', 'admin', '2', 'Admin/Addons/saveconfig', '更新配置', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('159', 'admin', '2', 'Admin/Addons/adminList', '插件后台列表', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('160', 'admin', '2', 'Admin/Addons/execute', 'URL方式访问插件', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('161', 'admin', '2', 'Admin/Addons/hooks', '钩子管理', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('162', 'admin', '2', 'Admin/Model/index', '模型管理', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('163', 'admin', '2', 'Admin/model/add', '新增', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('164', 'admin', '2', 'Admin/model/edit', '编辑', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('165', 'admin', '2', 'Admin/model/setStatus', '改变状态', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('166', 'admin', '2', 'Admin/model/update', '保存数据', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('167', 'admin', '2', 'Admin/Attribute/index', '属性管理', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('168', 'admin', '2', 'Admin/Attribute/add', '新增', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('169', 'admin', '2', 'Admin/Attribute/edit', '编辑', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('170', 'admin', '2', 'Admin/Attribute/setStatus', '改变状态', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('171', 'admin', '2', 'Admin/Attribute/update', '保存数据', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('172', 'admin', '2', 'Admin/Config/index', '配置管理', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('173', 'admin', '2', 'Admin/Config/edit', '编辑', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('174', 'admin', '2', 'Admin/Config/del', '删除', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('175', 'admin', '2', 'Admin/Config/add', '新增', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('176', 'admin', '2', 'Admin/Config/save', '保存', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('177', 'admin', '2', 'Admin/Menu/index', '菜单管理', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('178', 'admin', '2', 'Admin/Channel/index', '导航管理', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('179', 'admin', '2', 'Admin/Channel/add', '新增', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('180', 'admin', '2', 'Admin/Channel/edit', '编辑', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('181', 'admin', '2', 'Admin/Channel/del', '删除', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('182', 'admin', '2', 'Admin/Category/index', '分类管理', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('183', 'admin', '2', 'Admin/Category/edit', '编辑', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('184', 'admin', '2', 'Admin/Category/add', '新增', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('185', 'admin', '2', 'Admin/Category/remove', '删除', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('186', 'admin', '2', 'Admin/Category/move', '移动', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('187', 'admin', '2', 'Admin/Category/merge', '合并', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('188', 'admin', '2', 'Admin/Database/index?type=export', '备份数据库', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('189', 'admin', '2', 'Admin/Database/export', '备份', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('190', 'admin', '2', 'Admin/Database/optimize', '优化表', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('191', 'admin', '2', 'Admin/Database/repair', '修复表', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('192', 'admin', '2', 'Admin/Database/index?type=import', '还原数据库', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('193', 'admin', '2', 'Admin/Database/import', '恢复', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('194', 'admin', '2', 'Admin/Database/del', '删除', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('195', 'admin', '2', 'Admin/other', '其他', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('196', 'admin', '2', 'Admin/Menu/add', '新增', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('197', 'admin', '2', 'Admin/Menu/edit', '编辑', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('198', 'admin', '2', 'Admin/Think/lists?model=article', '应用', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('199', 'admin', '2', 'Admin/Think/lists?model=download', '下载管理', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('200', 'admin', '2', 'Admin/Think/lists?model=config', '应用', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('201', 'admin', '2', 'Admin/Action/actionlog', '行为日志', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('202', 'admin', '2', 'Admin/User/updatePassword', '修改密码', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('203', 'admin', '2', 'Admin/User/updateNickname', '修改昵称', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('204', 'admin', '2', 'Admin/action/edit', '查看行为日志', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('206', 'admin', '1', 'Admin/think/edit', '编辑数据', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('207', 'admin', '1', 'Admin/Menu/import', '导入', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('208', 'admin', '1', 'Admin/Model/generate', '生成', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('209', 'admin', '1', 'Admin/Addons/addHook', '新增钩子', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('210', 'admin', '1', 'Admin/Addons/edithook', '编辑钩子', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('211', 'admin', '1', 'Admin/Article/sort', '文档排序', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('212', 'admin', '1', 'Admin/Config/sort', '排序', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('213', 'admin', '1', 'Admin/Menu/sort', '排序', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('214', 'admin', '1', 'Admin/Channel/sort', '排序', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('215', 'admin', '1', 'Admin/Category/operate/type/move', '移动', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('216', 'admin', '1', 'Admin/Category/operate/type/merge', '合并', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('217', 'admin', '1', 'Admin/article/index', '文档列表', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('218', 'admin', '1', 'Admin/think/lists', '数据列表', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('219', 'admin', '1', 'Admin/Users/index', '用户信息', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('220', 'admin', '1', 'Admin/Users/add', '新增前台用户', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('221', 'admin', '1', 'Admin/AuthFront/index', '前台权限管理', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('222', 'admin', '1', 'Admin/AuthFront/createGroup', '新增前台权限分组', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('223', 'admin', '2', 'Admin/AuthFront/index', '权限管理', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('224', 'admin', '2', 'Admin/AuthFront/changeStatus?method=deleteGroup', '删除', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('225', 'admin', '2', 'Admin/AuthFront/changeStatus?method=forbidGroup', '禁用', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('226', 'admin', '2', 'Admin/AuthFront/changeStatus?method=resumeGroup', '恢复', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('227', 'admin', '2', 'Admin/AuthFront/writeGroup', '保存用户组', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('228', 'admin', '2', 'Admin/AuthFront/group', '授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('229', 'admin', '2', 'Admin/AuthFront/access', '访问授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('230', 'admin', '2', 'Admin/AuthFront/user', '成员授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('231', 'admin', '2', 'Admin/AuthFront/removeFromGroup', '解除授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('232', 'admin', '2', 'Admin/AuthFront/addToGroup', '保存成员授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('233', 'admin', '2', 'Admin/AuthFront/category', '分类授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('234', 'admin', '2', 'Admin/AuthFront/addToCategory', '保存分类授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('235', 'admin', '2', 'Admin/AuthFront/modelauth', '模型授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('236', 'admin', '2', 'Admin/AuthFront/addToModel', '保存模型授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('237', 'admin', '2', 'Admin/Users/action', '用户行为', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('238', 'admin', '2', 'Admin/Users/addAction', '新增用户行为', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('239', 'admin', '2', 'Admin/Users/editAction', '编辑用户行为', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('240', 'admin', '2', 'Admin/Users/saveAction', '保存用户行为', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('241', 'admin', '2', 'Admin/Users/setStatus', '变更行为状态', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('242', 'admin', '2', 'Admin/Users/changeStatus?method=forbidUser', '禁用会员', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('243', 'admin', '2', 'Admin/Users/changeStatus?method=resumeUser', '启用会员', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('244', 'admin', '2', 'Admin/Users/changeStatus?method=deleteUser', '删除会员', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('245', 'admin', '1', 'Admin/AuthFront/editGroup', '编辑', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('246', 'admin', '1', 'Admin/Users/action', '用户行为', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('247', 'admin', '1', 'Admin/Users/addaction', '新增用户行为', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('248', 'admin', '1', 'Admin/Users/editaction', '编辑用户行为', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('249', 'admin', '1', 'Admin/Users/saveAction', '保存用户行为', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('250', 'admin', '1', 'Admin/Users/setStatus', '变更行为状态', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('251', 'admin', '1', 'Admin/Users/changeStatus?method=forbidUser', '禁用会员', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('252', 'admin', '1', 'Admin/Users/changeStatus?method=resumeUser', '启用会员', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('253', 'admin', '1', 'Admin/Users/changeStatus?method=deleteUser', '删除会员', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('254', 'admin', '1', 'Admin/AuthFront/changeStatus?method=deleteGroup', '删除', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('255', 'admin', '1', 'Admin/AuthFront/changeStatus?method=forbidGroup', '禁用', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('256', 'admin', '1', 'Admin/AuthFront/changeStatus?method=resumeGroup', '恢复', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('257', 'admin', '1', 'Admin/AuthFront/writeGroup', '保存用户组', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('258', 'admin', '1', 'Admin/AuthFront/group', '授权', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('259', 'admin', '1', 'Admin/AuthFront/access', '访问授权', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('260', 'admin', '1', 'Admin/AuthFront/user', '成员授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('261', 'admin', '1', 'Admin/AuthFront/removeFromGroup', '解除授权', '-1', '');
INSERT INTO `tu_auth_rule` VALUES ('262', 'admin', '1', 'Admin/AuthFront/addToGroup', '保存成员授权', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('263', 'admin', '1', 'Admin/AuthFront/category', '分类授权', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('264', 'admin', '1', 'Admin/AuthFront/addToCategory', '保存分类授权', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('265', 'admin', '1', 'Admin/AuthFront/modelauth', '模型授权', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('266', 'admin', '1', 'Admin/AuthFront/addToModel', '保存模型授权', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('403', 'home', '1', 'Home/Member/auto', '上传头像', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('404', 'home', '1', 'Home/Member/autos', 'ceshi', '1', '');
INSERT INTO `tu_auth_rule` VALUES ('402', 'home', '2', 'Home/Member/index', '个人中心', '1', '');

-- ----------------------------
-- Table structure for tu_brand
-- ----------------------------
DROP TABLE IF EXISTS `tu_brand`;
CREATE TABLE `tu_brand` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `brand` varchar(50) NOT NULL DEFAULT '' COMMENT '品牌',
  `brandpic` int(11) NOT NULL COMMENT '品牌图片ID',
  `manufacturer` varchar(50) NOT NULL DEFAULT '' COMMENT '厂商',
  `series` varchar(50) NOT NULL DEFAULT '' COMMENT '车系',
  `seriespic` int(11) NOT NULL COMMENT '车系图片ID',
  `car` varchar(255) NOT NULL DEFAULT '' COMMENT '车款',
  `carpic` int(11) NOT NULL COMMENT '车款图片ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=487 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_brand
-- ----------------------------
INSERT INTO `tu_brand` VALUES ('247', '测试一下', '0', '大众(进口)', '途锐', '0', '2011款 3.0TDI V6 柴油标配型', '0');
INSERT INTO `tu_brand` VALUES ('246', '测试', '0', '大众(进口)', 'Tiguan', '0', '2011款 2.0TSI R-Line', '0');
INSERT INTO `tu_brand` VALUES ('3', '大众', '4', '大众(进口)', '途锐', '4', '2011款 3.0TDI V6 柴油豪华型', '4');
INSERT INTO `tu_brand` VALUES ('4', '大众', '4', '大众(进口)', '途锐', '6', '2011款 3.0TSI V6 标配型', '5');
INSERT INTO `tu_brand` VALUES ('281', '大众', '0', '大众(进口)', '夏朗', '0', '2013款 1.8TSI 舒适型 欧V', '0');
INSERT INTO `tu_brand` VALUES ('280', '大众', '0', '大众(进口)', '夏朗', '0', '2013款 1.8TSI 舒适型 欧IV', '0');
INSERT INTO `tu_brand` VALUES ('279', '大众', '0', '大众(进口)', '夏朗', '0', '2013款 1.8TSI 标配型 欧V', '0');
INSERT INTO `tu_brand` VALUES ('278', '大众', '0', '大众(进口)', '夏朗', '0', '2013款 1.8TSI 标配型 欧IV', '0');
INSERT INTO `tu_brand` VALUES ('277', '大众', '0', '大众(进口)', '途锐', '0', '2013款 3.0TSI X 十周年限量版', '0');
INSERT INTO `tu_brand` VALUES ('276', '大众', '0', '上海大众', '朗逸', '0', '2013款 改款 1.6L 自动豪华版', '0');
INSERT INTO `tu_brand` VALUES ('275', '测试', '0', '上海大众', '朗逸', '0', '2013款 改款 1.6L 自动舒适版', '0');
INSERT INTO `tu_brand` VALUES ('274', '大众', '0', '上海大众', '朗逸', '0', '2013款 改款 1.6L 手动舒适版', '0');
INSERT INTO `tu_brand` VALUES ('273', '大众', '0', '上海大众', '朗逸', '0', '2013款 改款 1.6L 自动风尚版', '0');
INSERT INTO `tu_brand` VALUES ('272', '大众', '0', '上海大众', '朗逸', '0', '2013款 改款 1.6L 手动风尚版', '0');
INSERT INTO `tu_brand` VALUES ('271', '大众', '0', '大众(进口)', '迈特威', '0', '2012款 2.0T 尊享版', '0');
INSERT INTO `tu_brand` VALUES ('270', '大众', '0', '大众(进口)', '迈特威', '0', '2012款 2.0T 豪华版', '0');
INSERT INTO `tu_brand` VALUES ('269', '大众', '0', '大众(进口)', '途锐', '0', '2013款 3.6L V6 越野增强豪华型', '0');
INSERT INTO `tu_brand` VALUES ('268', '大众', '0', '大众(进口)', '途锐', '0', '2013款 3.6L V6 越野增强高配型', '0');
INSERT INTO `tu_brand` VALUES ('267', '大众', '0', '大众(进口)', '途锐', '0', '2012款 R-Line 豪华型', '0');
INSERT INTO `tu_brand` VALUES ('266', '大众', '0', '大众(进口)', '途锐', '0', '2012款 R-Line 高配型', '0');
INSERT INTO `tu_brand` VALUES ('265', '大众', '0', '一汽-大众', '迈腾', '0', '2013款 1.4TSI 蓝驱版', '0');
INSERT INTO `tu_brand` VALUES ('264', '大众', '0', '大众(进口)', '途锐', '0', '2013款 3.0TSI V6 限量奢华版', '0');
INSERT INTO `tu_brand` VALUES ('263', '大众', '0', '大众(进口)', '迈特威', '0', '2012款 2.0T 商务版', '0');
INSERT INTO `tu_brand` VALUES ('262', '大众', '0', '上海大众', 'POLO', '0', '2012款 1.4TSI GTI', '0');
INSERT INTO `tu_brand` VALUES ('261', '大众', '0', '大众(进口)', '迈腾(进口)', '0', '2012款 旅行版 2.0TSI 四驱豪华型', '0');
INSERT INTO `tu_brand` VALUES ('260', '大众', '0', '大众(进口)', '迈腾(进口)', '0', '2012款 旅行版 2.0TSI 四驱舒适型', '0');
INSERT INTO `tu_brand` VALUES ('259', '大众', '0', '大众(进口)', '迈腾(进口)', '0', '2012款 旅行版 2.0TSI 豪华型', '0');
INSERT INTO `tu_brand` VALUES ('258', '大众', '0', '大众(进口)', '迈腾(进口)', '0', '2012款 旅行版 2.0TSI 舒适型', '0');
INSERT INTO `tu_brand` VALUES ('257', '大众', '0', '一汽-大众', '高尔夫', '0', '2012款 2.0TSI GTI', '0');
INSERT INTO `tu_brand` VALUES ('256', '大众', '0', '大众(进口)', '大众EOS', '0', '2011款 2.0TSI', '0');
INSERT INTO `tu_brand` VALUES ('255', '大众', '0', '大众(进口)', '途锐', '0', '2011款 3.0TSI V6 Hybrid', '0');
INSERT INTO `tu_brand` VALUES ('254', '大众', '0', '大众(进口)', '途锐', '0', '2011款 3.0TSI V6 豪华型', '0');
INSERT INTO `tu_brand` VALUES ('253', '大众', '0', '大众(进口)', '途锐', '0', '2011款 3.0TSI V6 高配型', '0');
INSERT INTO `tu_brand` VALUES ('252', '大众', '0', '大众(进口)', '途锐', '0', '2011款 3.0TSI V6 舒适型', '0');
INSERT INTO `tu_brand` VALUES ('251', '大众', '0', '大众(进口)', '途锐', '0', '2011款 3.0TSI V6 标配型', '0');
INSERT INTO `tu_brand` VALUES ('250', '大众', '0', '大众(进口)', '途锐', '0', '2011款 3.0TDI V6 柴油豪华型', '0');
INSERT INTO `tu_brand` VALUES ('249', '大众', '0', '大众(进口)', '途锐', '0', '2011款 3.0TDI V6 柴油高配型', '0');
INSERT INTO `tu_brand` VALUES ('248', '大众', '0', '大众(进口)', '途锐', '0', '2011款 3.0TDI V6 柴油舒适型', '0');
INSERT INTO `tu_brand` VALUES ('282', '大众', '0', '上海大众', '朗行', '0', '2013款 1.6L 手动风尚型', '0');
INSERT INTO `tu_brand` VALUES ('283', '大众', '0', '上海大众', '朗行', '0', '2013款 1.6L 自动风尚型', '0');
INSERT INTO `tu_brand` VALUES ('284', '大众', '0', '上海大众', '朗行', '0', '2013款 1.6L 手动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('285', '大众', '0', '上海大众', '朗行', '0', '2013款 1.6L 自动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('286', '大众', '0', '上海大众', '朗行', '0', '2013款 1.6L 自动豪华型', '0');
INSERT INTO `tu_brand` VALUES ('287', '大众', '0', '上海大众', '朗行', '0', '2013款 1.4TSI 手动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('288', '大众', '0', '上海大众', '朗行', '0', '2013款 1.4TSI 自动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('289', '大众', '0', '上海大众', '朗行', '0', '2013款 1.4TSI 手动豪华型', '0');
INSERT INTO `tu_brand` VALUES ('290', '大众', '0', '上海大众', '朗行', '0', '2013款 1.4TSI 自动豪华型', '0');
INSERT INTO `tu_brand` VALUES ('291', '大众', '0', '大众(进口)', '辉腾', '0', '2012款 3.0L 商务型', '0');
INSERT INTO `tu_brand` VALUES ('292', '大众', '0', '大众(进口)', '辉腾', '0', '2012款 3.0L 行政型', '0');
INSERT INTO `tu_brand` VALUES ('293', '大众', '0', '大众(进口)', '辉腾', '0', '2012款 3.0TDI 行政型', '0');
INSERT INTO `tu_brand` VALUES ('294', '大众', '0', '大众(进口)', '辉腾', '0', '2012款 3.0L 精英定制型', '0');
INSERT INTO `tu_brand` VALUES ('295', '大众', '0', '大众(进口)', '辉腾', '0', '2012款 3.0TDI 精英定制型', '0');
INSERT INTO `tu_brand` VALUES ('296', '大众', '0', '大众(进口)', '辉腾', '0', '2012款 3.6L 尊享定制型', '0');
INSERT INTO `tu_brand` VALUES ('297', '大众', '0', '大众(进口)', '辉腾', '0', '2012款 4.2L 奢享定制型', '0');
INSERT INTO `tu_brand` VALUES ('298', '大众', '0', '大众(进口)', '甲壳虫', '0', '2014款 1.4TSI R-Line', '0');
INSERT INTO `tu_brand` VALUES ('299', '大众', '0', '上海大众', '朗逸', '0', '2013款 改款 1.4TSI 手动舒适版', '0');
INSERT INTO `tu_brand` VALUES ('300', '大众', '0', '上海大众', '朗逸', '0', '2013款 改款 1.4TSI DSG舒适版', '0');
INSERT INTO `tu_brand` VALUES ('301', '大众', '0', '上海大众', '朗逸', '0', '2013款 改款 1.4TSI 手动豪华版', '0');
INSERT INTO `tu_brand` VALUES ('302', '大众', '0', '上海大众', '朗逸', '0', '2013款 改款 1.4TSI DSG豪华版', '0');
INSERT INTO `tu_brand` VALUES ('303', '大众', '0', '上海大众', '朗逸', '0', '2014款 1.6L 自动运动版', '0');
INSERT INTO `tu_brand` VALUES ('304', '大众', '0', '上海大众', '朗逸', '0', '2014款 1.4TSI DSG运动版', '0');
INSERT INTO `tu_brand` VALUES ('305', '大众', '0', '上海大众', '朗行', '0', '2014款 1.6L 自动运动版', '0');
INSERT INTO `tu_brand` VALUES ('306', '大众', '0', '上海大众', '朗行', '0', '2014款 1.4TSI 自动运动版', '0');
INSERT INTO `tu_brand` VALUES ('307', '大众', '0', '上海大众', '朗逸', '0', '2014款 1.4TSI DSG蓝驱技术版', '0');
INSERT INTO `tu_brand` VALUES ('308', '大众', '0', '上海大众', '朗境', '0', '2014款 1.6L 自动型', '0');
INSERT INTO `tu_brand` VALUES ('309', '大众', '0', '上海大众', '朗境', '0', '2014款 1.4TSI DSG', '0');
INSERT INTO `tu_brand` VALUES ('310', '大众', '0', '大众(进口)', '迈特威', '0', '2014款 2.0T 行政版', '0');
INSERT INTO `tu_brand` VALUES ('311', '大众', '0', '大众(进口)', '途锐', '0', '2014款 3.0TSI V6 黑色探险者', '0');
INSERT INTO `tu_brand` VALUES ('312', '大众', '0', '一汽-大众', '宝来', '0', '2014款 1.6L 手动时尚型', '0');
INSERT INTO `tu_brand` VALUES ('313', '大众', '0', '一汽-大众', '宝来', '0', '2014款 1.6L 自动时尚型', '0');
INSERT INTO `tu_brand` VALUES ('314', '大众', '0', '一汽-大众', '宝来', '0', '2014款 1.6L 手动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('315', '大众', '0', '一汽-大众', '宝来', '0', '2014款 1.6L 自动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('316', '大众', '0', '上海大众', '帕萨特', '0', '2014款 1.8TSI DSG尊雅版', '0');
INSERT INTO `tu_brand` VALUES ('317', '大众', '0', '上海大众', '帕萨特', '0', '2014款 1.8TSI 自动尊荣版', '0');
INSERT INTO `tu_brand` VALUES ('318', '大众', '0', '上海大众', '帕萨特', '0', '2014款 1.8TSI DSG尊荣版', '0');
INSERT INTO `tu_brand` VALUES ('319', '大众', '0', '上海大众', '帕萨特', '0', '2014款 1.8TSI DSG尊荣导航版', '0');
INSERT INTO `tu_brand` VALUES ('320', '大众', '0', '上海大众', '帕萨特', '0', '2014款 1.8TSI DSG御尊版', '0');
INSERT INTO `tu_brand` VALUES ('321', '大众', '0', '上海大众', '帕萨特', '0', '2014款 1.8TSI DSG御尊导航版', '0');
INSERT INTO `tu_brand` VALUES ('322', '大众', '0', '上海大众', '帕萨特', '0', '2014款 1.8TSI DSG至尊版', '0');
INSERT INTO `tu_brand` VALUES ('323', '大众', '0', '上海大众', '帕萨特', '0', '2014款 2.0TSI DSG御尊版', '0');
INSERT INTO `tu_brand` VALUES ('324', '大众', '0', '上海大众', '帕萨特', '0', '2014款 2.0TSI DSG御尊导航版', '0');
INSERT INTO `tu_brand` VALUES ('325', '大众', '0', '上海大众', '帕萨特', '0', '2014款 2.0TSI DSG至尊版', '0');
INSERT INTO `tu_brand` VALUES ('326', '大众', '0', '上海大众', '帕萨特', '0', '2014款 3.0L V6 DSG旗舰版', '0');
INSERT INTO `tu_brand` VALUES ('327', '大众', '0', '上海大众', '帕萨特', '0', '2014款 3.0L V6 DSG旗舰尊享版', '0');
INSERT INTO `tu_brand` VALUES ('328', '大众', '0', '上海大众', '帕萨特', '0', '2014款 1.4TSI DSG蓝驱技术版', '0');
INSERT INTO `tu_brand` VALUES ('329', '大众', '0', '上海大众', '桑塔纳·尚纳', '0', '2015款 1.6L 自动豪华版', '0');
INSERT INTO `tu_brand` VALUES ('330', '大众', '0', '大众(进口)', '凯路威', '0', '2014款 2.0TSI 两驱舒适版', '0');
INSERT INTO `tu_brand` VALUES ('331', '大众', '0', '大众(进口)', '凯路威', '0', '2014款 2.0TSI 四驱舒适版', '0');
INSERT INTO `tu_brand` VALUES ('332', '大众', '0', '大众(进口)', '途锐', '0', '2014款 4.2L V8', '0');
INSERT INTO `tu_brand` VALUES ('333', '大众', '0', '一汽-大众', '高尔夫', '0', '2015款 1.4T 手动R-Line', '0');
INSERT INTO `tu_brand` VALUES ('334', '大众', '0', '大众(进口)', '高尔夫(进口)', '0', '2012款 1.4TSI 舒适敞篷版', '0');
INSERT INTO `tu_brand` VALUES ('335', '大众', '0', '大众(进口)', '高尔夫(进口)', '0', '2012款 1.4TSI 豪华敞篷版', '0');
INSERT INTO `tu_brand` VALUES ('336', '大众', '0', '大众(进口)', '高尔夫(进口)', '0', '2011款 1.4TSI Cross Golf', '0');
INSERT INTO `tu_brand` VALUES ('337', '大众', '0', '大众(进口)', '高尔夫(进口)', '0', '2013款 2.0TSI GTI敞篷版', '0');
INSERT INTO `tu_brand` VALUES ('338', '大众', '0', '大众(进口)', '高尔夫(进口)', '0', '2014款 2.0TSI R敞篷版', '0');
INSERT INTO `tu_brand` VALUES ('339', '大众', '0', '上海大众', 'POLO', '0', '2014款 1.4L 手动风尚版', '0');
INSERT INTO `tu_brand` VALUES ('340', '大众', '0', '上海大众', 'POLO', '0', '2014款 1.4L 手动舒适版', '0');
INSERT INTO `tu_brand` VALUES ('341', '大众', '0', '上海大众', 'POLO', '0', '2014款 1.4L 自动舒适版', '0');
INSERT INTO `tu_brand` VALUES ('342', '大众', '0', '上海大众', 'POLO', '0', '2014款 1.4L 自动豪华版', '0');
INSERT INTO `tu_brand` VALUES ('343', '大众', '0', '上海大众', 'POLO', '0', '2014款 1.6L 手动舒适版', '0');
INSERT INTO `tu_brand` VALUES ('344', '大众', '0', '上海大众', 'POLO', '0', '2014款 1.6L 自动舒适版', '0');
INSERT INTO `tu_brand` VALUES ('345', '大众', '0', '上海大众', 'POLO', '0', '2014款 1.6L 自动豪华版', '0');
INSERT INTO `tu_brand` VALUES ('346', '大众', '0', '大众(进口)', '甲壳虫', '0', '2014款 2.0TSI 性能版', '0');
INSERT INTO `tu_brand` VALUES ('347', '大众', '0', '一汽-大众', '宝来', '0', '2014款 1.4TSI 手动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('348', '大众', '0', '一汽-大众', '宝来', '0', '2014款 1.4TSI 自动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('349', '大众', '0', '一汽-大众', '宝来', '0', '2014款 1.4TSI 自动豪华型', '0');
INSERT INTO `tu_brand` VALUES ('350', '大众', '0', '一汽-大众', '宝来', '0', '2014款 1.4TSI 手动Sportline', '0');
INSERT INTO `tu_brand` VALUES ('351', '大众', '0', '一汽-大众', '宝来', '0', '2014款 1.4TSI 自动Sportline', '0');
INSERT INTO `tu_brand` VALUES ('352', '大众', '0', '上海大众', '途观', '0', '2015款 1.4TSI 手动两驱蓝驱版', '0');
INSERT INTO `tu_brand` VALUES ('353', '大众', '0', '上海大众', '途观', '0', '2015款 1.8TSI 手动两驱风尚版', '0');
INSERT INTO `tu_brand` VALUES ('354', '大众', '0', '上海大众', '途观', '0', '2015款 1.8TSI 自动两驱风尚版', '0');
INSERT INTO `tu_brand` VALUES ('355', '大众', '0', '上海大众', '途观', '0', '2015款 1.8TSI 自动两驱舒适版', '0');
INSERT INTO `tu_brand` VALUES ('356', '大众', '0', '上海大众', '途观', '0', '2015款 1.8TSI 自动四驱舒适版', '0');
INSERT INTO `tu_brand` VALUES ('357', '大众', '0', '上海大众', '途观', '0', '2015款 1.8TSI 自动两驱豪华型', '0');
INSERT INTO `tu_brand` VALUES ('358', '大众', '0', '上海大众', '途观', '0', '2015款 1.8TSI 自动四驱豪华型', '0');
INSERT INTO `tu_brand` VALUES ('359', '大众', '0', '上海大众', '途观', '0', '2015款 2.0TSI 自动四驱豪华版', '0');
INSERT INTO `tu_brand` VALUES ('360', '大众', '0', '上海大众', '途观', '0', '2015款 2.0TSI 自动四驱旗舰版', '0');
INSERT INTO `tu_brand` VALUES ('361', '大众', '0', '上海大众', '途安', '0', '2015款 1.4T 手动风尚版5座', '0');
INSERT INTO `tu_brand` VALUES ('362', '大众', '0', '上海大众', '途安', '0', '2015款 1.4T 手动舒适版5座', '0');
INSERT INTO `tu_brand` VALUES ('363', '大众', '0', '上海大众', '途安', '0', '2015款 1.4T 手动豪华版5座', '0');
INSERT INTO `tu_brand` VALUES ('364', '大众', '0', '上海大众', '桑塔纳·尚纳', '0', '2015款 1.4L 手动风尚版', '0');
INSERT INTO `tu_brand` VALUES ('365', '大众', '0', '上海大众', '桑塔纳·尚纳', '0', '2015款 1.4L 手动舒适版', '0');
INSERT INTO `tu_brand` VALUES ('366', '大众', '0', '上海大众', '桑塔纳·尚纳', '0', '2015款 1.6L 手动风尚版', '0');
INSERT INTO `tu_brand` VALUES ('367', '大众', '0', '上海大众', '桑塔纳·尚纳', '0', '2015款 1.6L 自动风尚版', '0');
INSERT INTO `tu_brand` VALUES ('368', '大众', '0', '上海大众', '桑塔纳·尚纳', '0', '2015款 1.6L 手动舒适版', '0');
INSERT INTO `tu_brand` VALUES ('369', '大众', '0', '上海大众', '桑塔纳·尚纳', '0', '2015款 1.6L 自动舒适版', '0');
INSERT INTO `tu_brand` VALUES ('370', '大众', '0', '上海大众', '桑塔纳·尚纳', '0', '2015款 1.4T DSG尊享版', '0');
INSERT INTO `tu_brand` VALUES ('371', '大众', '0', '一汽-大众', '捷达', '0', '2015款 1.4L 手动时尚型', '0');
INSERT INTO `tu_brand` VALUES ('372', '大众', '0', '上海大众', '帕萨特', '0', '2015款 1.8TSI DSG 30周年纪念版', '0');
INSERT INTO `tu_brand` VALUES ('373', '大众', '0', '大众(进口)', '高尔夫(进口)', '0', '2014款 1.4TSI 旅行版', '0');
INSERT INTO `tu_brand` VALUES ('374', '大众', '0', '一汽-大众', '捷达', '0', '2015款 1.4L 手动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('375', '大众', '0', '一汽-大众', '迈腾', '0', '2015款 1.8TSI 领先型', '0');
INSERT INTO `tu_brand` VALUES ('376', '大众', '0', '一汽-大众', '一汽-大众CC', '0', '2015款 1.8TSI 尊贵型', '0');
INSERT INTO `tu_brand` VALUES ('377', '大众', '0', '一汽-大众', '一汽-大众CC', '0', '2015款 1.8TSI 豪华型', '0');
INSERT INTO `tu_brand` VALUES ('378', '大众', '0', '一汽-大众', '一汽-大众CC', '0', '2015款 2.0TSI 尊贵型', '0');
INSERT INTO `tu_brand` VALUES ('379', '大众', '0', '一汽-大众', '一汽-大众CC', '0', '2015款 2.0TSI 豪华型', '0');
INSERT INTO `tu_brand` VALUES ('380', '大众', '0', '一汽-大众', '一汽-大众CC', '0', '2015款 2.0TSI 至尊型', '0');
INSERT INTO `tu_brand` VALUES ('381', '大众', '0', '一汽-大众', '一汽-大众CC', '0', '2015款 3.0FSI V6', '0');
INSERT INTO `tu_brand` VALUES ('382', '大众', '0', '一汽-大众', '高尔夫', '0', '2015款 1.4TSI 手动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('383', '大众', '0', '一汽-大众', '高尔夫', '0', '2015款 1.4TSI 自动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('384', '大众', '0', '一汽-大众', '高尔夫', '0', '2015款 1.4TSI 自动豪华型', '0');
INSERT INTO `tu_brand` VALUES ('385', '大众', '0', '一汽-大众', '高尔夫', '0', '2015款 1.4TSI 自动旗舰型', '0');
INSERT INTO `tu_brand` VALUES ('386', '大众', '0', '大众(进口)', '辉腾', '0', '2014款 3.0L 商务型', '0');
INSERT INTO `tu_brand` VALUES ('387', '大众', '0', '大众(进口)', '辉腾', '0', '2014款 3.0L 行政型', '0');
INSERT INTO `tu_brand` VALUES ('388', '大众', '0', '大众(进口)', '夏朗', '0', '2014款 2.0TSI 标配型', '0');
INSERT INTO `tu_brand` VALUES ('389', '大众', '0', '大众(进口)', '夏朗', '0', '2014款 2.0TSI 舒适型', '0');
INSERT INTO `tu_brand` VALUES ('390', '大众', '0', '大众(进口)', '夏朗', '0', '2014款 2.0TSI 豪华型', '0');
INSERT INTO `tu_brand` VALUES ('391', '大众', '0', '大众(进口)', '尚酷', '0', '2015款 1.4TSI 风尚版', '0');
INSERT INTO `tu_brand` VALUES ('392', '大众', '0', '大众(进口)', '尚酷', '0', '2015款 1.4TSI 舒适版', '0');
INSERT INTO `tu_brand` VALUES ('393', '大众', '0', '大众(进口)', '尚酷', '0', '2015款 2.0TSI 豪华版', '0');
INSERT INTO `tu_brand` VALUES ('394', '大众', '0', '大众(进口)', '尚酷', '0', '2015款  R 2.0TSI', '0');
INSERT INTO `tu_brand` VALUES ('395', '大众', '0', '上海大众', '途安', '0', '2015款 1.4T DSG舒适版5座', '0');
INSERT INTO `tu_brand` VALUES ('396', '大众', '0', '上海大众', '途安', '0', '2015款 1.4T DSG豪华版5座', '0');
INSERT INTO `tu_brand` VALUES ('397', '大众', '0', '上海大众', '途安', '0', '2015款 1.4T DSG旗舰版5座', '0');
INSERT INTO `tu_brand` VALUES ('398', '大众', '0', '大众(进口)', '甲壳虫', '0', '2015款 1.2TSI', '0');
INSERT INTO `tu_brand` VALUES ('399', '大众', '0', '大众(进口)', '甲壳虫', '0', '2015款 1.4TSI', '0');
INSERT INTO `tu_brand` VALUES ('400', '大众', '0', '大众(进口)', '甲壳虫', '0', '2015款 2.0TSI', '0');
INSERT INTO `tu_brand` VALUES ('401', '大众', '0', '一汽-大众', '迈腾', '0', '2015款 改款 1.4TSI 豪华型', '0');
INSERT INTO `tu_brand` VALUES ('402', '大众', '0', '一汽-大众', '迈腾', '0', '2015款 改款 1.8TSI 豪华型', '0');
INSERT INTO `tu_brand` VALUES ('403', '大众', '0', '一汽-大众', '迈腾', '0', '2015款 改款 2.0TSI 尊贵型', '0');
INSERT INTO `tu_brand` VALUES ('404', '大众', '0', '一汽-大众', '迈腾', '0', '2015款 改款 1.8TSI 尊贵型', '0');
INSERT INTO `tu_brand` VALUES ('405', '大众', '0', '上海大众', '凌渡', '0', '2015款 230TSI 手动风尚版', '0');
INSERT INTO `tu_brand` VALUES ('406', '大众', '0', '上海大众', '凌渡', '0', '2015款 230TSI DSG风尚版', '0');
INSERT INTO `tu_brand` VALUES ('407', '大众', '0', '上海大众', '凌渡', '0', '2015款 280TSI 手动舒适版', '0');
INSERT INTO `tu_brand` VALUES ('408', '大众', '0', '上海大众', '凌渡', '0', '2015款 280TSI DSG舒适版', '0');
INSERT INTO `tu_brand` VALUES ('409', '大众', '0', '上海大众', '凌渡', '0', '2015款 280TSI DSG豪华版', '0');
INSERT INTO `tu_brand` VALUES ('410', '大众', '0', '上海大众', '凌渡', '0', '2015款 330TSI DSG舒适版', '0');
INSERT INTO `tu_brand` VALUES ('411', '大众', '0', '上海大众', '凌渡', '0', '2015款 330TSI DSG豪华版', '0');
INSERT INTO `tu_brand` VALUES ('412', '大众', '0', '一汽-大众', '迈腾', '0', '2015款 改款 2.0TSI 旗舰型', '0');
INSERT INTO `tu_brand` VALUES ('413', '大众', '0', '上海大众', '桑塔纳·尚纳', '0', '2015款 1.6L 手动豪华版', '0');
INSERT INTO `tu_brand` VALUES ('414', '大众', '0', '大众(进口)', '途锐', '0', '2015款 3.0TSI V6 耀锐限量版', '0');
INSERT INTO `tu_brand` VALUES ('415', '大众', '0', '一汽-大众', '捷达', '0', '2015款 1.6L 手动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('416', '大众', '0', '大众(进口)', '高尔夫(进口)', '0', '2015款 2.0TSI R', '0');
INSERT INTO `tu_brand` VALUES ('417', '大众', '0', '大众(进口)', '大众up!', '0', '2015款 electric up!', '0');
INSERT INTO `tu_brand` VALUES ('418', '大众', '0', '大众(进口)', '大众up!', '0', '2015款 1.0L high up!', '0');
INSERT INTO `tu_brand` VALUES ('419', '大众', '0', '大众(进口)', '大众up!', '0', '2015款 1.0L move up!', '0');
INSERT INTO `tu_brand` VALUES ('420', '大众', '0', '大众(进口)', '高尔夫(进口)', '0', '2015款 1.4TSI Sportsvan', '0');
INSERT INTO `tu_brand` VALUES ('421', '大众', '0', '上海大众', '途观', '0', '2015款 1.8TSI 手动两驱限量版', '0');
INSERT INTO `tu_brand` VALUES ('422', '大众', '0', '一汽-大众', '高尔夫', '0', '2015款 1.2TSI 自动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('423', '大众', '0', '一汽-大众', '速腾', '0', '2015款 230TSI 手动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('424', '大众', '0', '一汽-大众', '速腾', '0', '2015款 230TSI 自动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('425', '大众', '0', '一汽-大众', '速腾', '0', '2015款 230TSI 手动豪华型', '0');
INSERT INTO `tu_brand` VALUES ('426', '大众', '0', '一汽-大众', '速腾', '0', '2015款 230TSI 自动豪华型', '0');
INSERT INTO `tu_brand` VALUES ('427', '大众', '0', '一汽-大众', '速腾', '0', '2015款 280TSI 自动旗舰型', '0');
INSERT INTO `tu_brand` VALUES ('428', '大众', '0', '一汽-大众', '迈腾', '0', '2015款 改款 2.0TSI 豪华型', '0');
INSERT INTO `tu_brand` VALUES ('429', '大众', '0', '一汽-大众', '捷达', '0', '2015款 1.6L 手动时尚型', '0');
INSERT INTO `tu_brand` VALUES ('430', '大众', '0', '一汽-大众', '捷达', '0', '2015款 1.6L 自动时尚型', '0');
INSERT INTO `tu_brand` VALUES ('431', '大众', '0', '大众(进口)', 'Tiguan', '0', '2015款 2.0TSI 舒适版', '0');
INSERT INTO `tu_brand` VALUES ('432', '大众', '0', '上海大众', 'POLO', '0', '2014款 Cross POLO 手动', '0');
INSERT INTO `tu_brand` VALUES ('433', '大众', '0', '上海大众', 'POLO', '0', '2014款 Cross POLO 自动', '0');
INSERT INTO `tu_brand` VALUES ('434', '大众', '0', '上海大众', 'POLO', '0', '2015款 1.4TSI GTI', '0');
INSERT INTO `tu_brand` VALUES ('435', '大众', '0', '一汽-大众', '速腾', '0', '2015款 1.6L 手动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('436', '大众', '0', '一汽-大众', '速腾', '0', '2015款 1.6L 自动时尚型', '0');
INSERT INTO `tu_brand` VALUES ('437', '大众', '0', '一汽-大众', '高尔夫', '0', '2015款 1.6L 手动时尚型', '0');
INSERT INTO `tu_brand` VALUES ('438', '大众', '0', '一汽-大众', '高尔夫', '0', '2015款 1.6L 自动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('439', '大众', '0', '一汽-大众', '高尔夫', '0', '2015款 1.6L 自动时尚型', '0');
INSERT INTO `tu_brand` VALUES ('440', '大众', '0', '一汽-大众', '速腾', '0', '2015款 1.6L 手动时尚型', '0');
INSERT INTO `tu_brand` VALUES ('441', '大众', '0', '一汽-大众', '捷达', '0', '2015款 1.6L 手动豪华型', '0');
INSERT INTO `tu_brand` VALUES ('442', '大众', '0', '大众(进口)', '途锐', '0', '2015款 3.0TDI V6 柴油标配型', '0');
INSERT INTO `tu_brand` VALUES ('443', '大众', '0', '大众(进口)', '途锐', '0', '2015款 3.0TDI V6 柴油舒适型', '0');
INSERT INTO `tu_brand` VALUES ('444', '大众', '0', '大众(进口)', '途锐', '0', '2015款 3.0TSI V6 标配型', '0');
INSERT INTO `tu_brand` VALUES ('445', '大众', '0', '大众(进口)', '途锐', '0', '2015款 3.0TSI V6 舒适型', '0');
INSERT INTO `tu_brand` VALUES ('446', '大众', '0', '大众(进口)', '途锐', '0', '2015款 3.0TSI V6 高配型', '0');
INSERT INTO `tu_brand` VALUES ('447', '大众', '0', '大众(进口)', '途锐', '0', '2015款 3.0TSI V6 豪华型', '0');
INSERT INTO `tu_brand` VALUES ('448', '大众', '0', '大众(进口)', '途锐', '0', '2015款 3.0TSI V6 R-Line 豪华型', '0');
INSERT INTO `tu_brand` VALUES ('449', '大众', '0', '一汽-大众', '高尔夫', '0', '2015款 1.4T 自动R-Line', '0');
INSERT INTO `tu_brand` VALUES ('450', '大众', '0', '大众(进口)', '辉腾', '0', '2015款 3.0L 商务型', '0');
INSERT INTO `tu_brand` VALUES ('451', '大众', '0', '大众(进口)', '辉腾', '0', '2015款 3.0L 精英定制型', '0');
INSERT INTO `tu_brand` VALUES ('452', '大众', '0', '大众(进口)', '辉腾', '0', '2015款 3.6L 尊享定制型', '0');
INSERT INTO `tu_brand` VALUES ('453', '大众', '0', '大众(进口)', '辉腾', '0', '2015款  4.2L 奢享定制型', '0');
INSERT INTO `tu_brand` VALUES ('454', '大众', '0', '大众(进口)', '凯路威', '0', '2015款 2.0TSI 两驱舒适版', '0');
INSERT INTO `tu_brand` VALUES ('455', '大众', '0', '大众(进口)', '凯路威', '0', '2015款 2.0TSI 四驱舒适版', '0');
INSERT INTO `tu_brand` VALUES ('456', '大众', '0', '一汽-大众', '速腾', '0', '2015款 1.6L 自动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('457', '大众', '0', '上海大众', '朗逸', '0', '2014款 1.4TSI DSG 30周年纪念版', '0');
INSERT INTO `tu_brand` VALUES ('458', '大众', '0', '上海大众', 'POLO', '0', '2014款 1.6L 自动30周年纪念版', '0');
INSERT INTO `tu_brand` VALUES ('459', '大众', '0', '上海大众', '帕萨特', '0', '2014款 1.8TSI DSG 30周年纪念版', '0');
INSERT INTO `tu_brand` VALUES ('460', '大众', '0', '上海大众', '途安', '0', '2014款 1.4T DSG30周年纪念版', '0');
INSERT INTO `tu_brand` VALUES ('461', '大众', '0', '上海大众', '途观', '0', '2014款 1.8TSI 自动两驱30周年纪念版', '0');
INSERT INTO `tu_brand` VALUES ('462', '大众', '0', '一汽-大众', '宝来', '0', '2015款 质惠版 1.6L 手动时尚型', '0');
INSERT INTO `tu_brand` VALUES ('463', '大众', '0', '一汽-大众', '宝来', '0', '2015款 质惠版 1.6L 自动时尚型', '0');
INSERT INTO `tu_brand` VALUES ('464', '大众', '0', '一汽-大众', '宝来', '0', '2015款 质惠版 1.6L 手动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('465', '大众', '0', '一汽-大众', '宝来', '0', '2015款 质惠版 1.6L 自动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('466', '大众', '0', '一汽-大众', '宝来', '0', '2015款 质惠版 1.4TSI 自动Sportline', '0');
INSERT INTO `tu_brand` VALUES ('467', '大众', '0', '一汽-大众', '捷达', '0', '2015款 质惠版 1.4L 手动时尚型', '0');
INSERT INTO `tu_brand` VALUES ('468', '大众', '0', '一汽-大众', '捷达', '0', '2015款 质惠版 1.4L 手动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('469', '大众', '0', '一汽-大众', '捷达', '0', '2015款 质惠版 1.6L 手动时尚型', '0');
INSERT INTO `tu_brand` VALUES ('470', '大众', '0', '一汽-大众', '捷达', '0', '2015款 质惠版 1.6L 自动时尚型', '0');
INSERT INTO `tu_brand` VALUES ('471', '大众', '0', '一汽-大众', '捷达', '0', '2015款 质惠版 1.6L 手动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('472', '大众', '0', '一汽-大众', '捷达', '0', '2015款 质惠版 1.6L 自动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('473', '大众', '0', '一汽-大众', '捷达', '0', '2015款 质惠版 1.4TSI 自动运动型', '0');
INSERT INTO `tu_brand` VALUES ('474', '大众', '0', '一汽-大众', '捷达', '0', '2015款 1.4TSI 自动运动型', '0');
INSERT INTO `tu_brand` VALUES ('475', '大众', '0', '上海大众', '桑塔纳·尚纳', '0', '2014款 1.6L 自动30周年纪念版', '0');
INSERT INTO `tu_brand` VALUES ('476', '大众', '0', '上海大众', '朗行', '0', '2014款 1.4TSI 自动30周年纪念版', '0');
INSERT INTO `tu_brand` VALUES ('477', '大众', '0', '一汽-大众', '捷达', '0', '2015款 1.6L 自动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('478', '大众', '0', '一汽-大众', '捷达', '0', '2015款 1.6L 自动豪华型', '0');
INSERT INTO `tu_brand` VALUES ('479', '大众', '0', '上海大众', '桑塔纳浩纳', '0', '桑塔纳·浩纳 2015款 1.6L 手动风尚型', '0');
INSERT INTO `tu_brand` VALUES ('480', '大众', '0', '上海大众', '桑塔纳浩纳', '0', '桑塔纳·浩纳 2015款 1.6L 自动风尚型', '0');
INSERT INTO `tu_brand` VALUES ('481', '大众', '0', '上海大众', '桑塔纳浩纳', '0', '桑塔纳·浩纳 2015款 1.6L 手动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('482', '大众', '0', '上海大众', '桑塔纳浩纳', '0', '桑塔纳·浩纳 2015款 1.6L 自动舒适型', '0');
INSERT INTO `tu_brand` VALUES ('483', '大众', '0', '上海大众', '桑塔纳浩纳', '0', '桑塔纳·浩纳 2015款 1.6L 自动豪华型', '0');
INSERT INTO `tu_brand` VALUES ('484', '大众', '0', '上海大众', '桑塔纳浩纳', '0', '桑塔纳·浩纳 2015款 230TSI DSG舒适型', '0');
INSERT INTO `tu_brand` VALUES ('485', '大众', '0', '上海大众', '桑塔纳浩纳', '0', '桑塔纳·浩纳 2015款 230TSI DSG豪华型', '0');
INSERT INTO `tu_brand` VALUES ('486', '测试', '0', '上海大众', '朗逸', '0', '2015款 1.6 手动舒适版', '0');

-- ----------------------------
-- Table structure for tu_category
-- ----------------------------
DROP TABLE IF EXISTS `tu_category`;
CREATE TABLE `tu_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `name` varchar(30) NOT NULL COMMENT '标志',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `list_row` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '列表每页行数',
  `meta_title` varchar(50) NOT NULL DEFAULT '' COMMENT 'SEO的网页标题',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `template_index` varchar(100) NOT NULL DEFAULT '' COMMENT '频道页模板',
  `template_lists` varchar(100) NOT NULL DEFAULT '' COMMENT '列表页模板',
  `template_detail` varchar(100) NOT NULL DEFAULT '' COMMENT '详情页模板',
  `template_edit` varchar(100) NOT NULL DEFAULT '' COMMENT '编辑页模板',
  `model` varchar(100) NOT NULL DEFAULT '' COMMENT '列表绑定模型',
  `model_sub` varchar(100) NOT NULL DEFAULT '' COMMENT '子文档绑定模型',
  `type` varchar(100) NOT NULL DEFAULT '' COMMENT '允许发布的内容类型',
  `link_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外链',
  `allow_publish` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许发布内容',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '可见性',
  `reply` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许回复',
  `check` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发布的文章是否需要审核',
  `reply_model` varchar(100) NOT NULL DEFAULT '',
  `extend` text COMMENT '扩展设置',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '数据状态',
  `icon` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类图标',
  `groups` varchar(255) NOT NULL DEFAULT '' COMMENT '分组定义',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of tu_category
-- ----------------------------
INSERT INTO `tu_category` VALUES ('1', 'blog', '博客', '0', '0', '10', '', '', '', '', '', '', '', '2,3', '2', '2,1', '0', '0', '1', '0', '0', '1', '', '1379474947', '1382701539', '1', '0', '');
INSERT INTO `tu_category` VALUES ('2', 'default_blog', '默认分类', '1', '1', '10', '', '', '', '', '', '', '', '2,3', '2', '2,1,3', '0', '1', '1', '0', '1', '1', '', '1379475028', '1386839751', '1', '0', '');

-- ----------------------------
-- Table structure for tu_channel
-- ----------------------------
DROP TABLE IF EXISTS `tu_channel`;
CREATE TABLE `tu_channel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '频道ID',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级频道ID',
  `title` char(30) NOT NULL COMMENT '频道标题',
  `url` char(100) NOT NULL COMMENT '频道连接',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '导航排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `target` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '新窗口打开',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_channel
-- ----------------------------
INSERT INTO `tu_channel` VALUES ('1', '0', '首页', 'Index/index', '1', '1379475111', '1379923177', '1', '0');
INSERT INTO `tu_channel` VALUES ('2', '0', '博客', 'Article/index?category=blog', '2', '1379475131', '1379483713', '1', '0');
INSERT INTO `tu_channel` VALUES ('3', '0', '官网', 'http://www.onethink.cn', '3', '1379475154', '1387163458', '1', '0');

-- ----------------------------
-- Table structure for tu_config
-- ----------------------------
DROP TABLE IF EXISTS `tu_config`;
CREATE TABLE `tu_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '配置说明',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `value` text COMMENT '配置值',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `type` (`type`),
  KEY `group` (`group`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_config
-- ----------------------------
INSERT INTO `tu_config` VALUES ('1', 'WEB_SITE_TITLE', '1', '网站标题', '1', '', '网站标题前台显示标题', '1378898976', '1379235274', '1', 'OneThink内容管理框架', '0');
INSERT INTO `tu_config` VALUES ('2', 'WEB_SITE_DESCRIPTION', '2', '网站描述', '1', '', '网站搜索引擎描述', '1378898976', '1379235841', '1', 'OneThink内容管理框架', '1');
INSERT INTO `tu_config` VALUES ('3', 'WEB_SITE_KEYWORD', '2', '网站关键字', '1', '', '网站搜索引擎关键字', '1378898976', '1381390100', '1', 'ThinkPHP,OneThink', '8');
INSERT INTO `tu_config` VALUES ('4', 'WEB_SITE_CLOSE', '4', '关闭站点', '1', '0:关闭,1:开启', '站点关闭后其他用户不能访问，管理员可以正常访问', '1378898976', '1379235296', '1', '1', '1');
INSERT INTO `tu_config` VALUES ('9', 'CONFIG_TYPE_LIST', '3', '配置类型列表', '4', '', '主要用于数据解析和页面表单的生成', '1378898976', '1379235348', '1', '0:数字\r\n1:字符\r\n2:文本\r\n3:数组\r\n4:枚举', '2');
INSERT INTO `tu_config` VALUES ('10', 'WEB_SITE_ICP', '1', '网站备案号', '1', '', '设置在网站底部显示的备案号，如“沪ICP备12007941号-2', '1378900335', '1379235859', '1', '', '9');
INSERT INTO `tu_config` VALUES ('11', 'DOCUMENT_POSITION', '3', '文档推荐位', '2', '', '文档推荐位，推荐到多个位置KEY值相加即可', '1379053380', '1379235329', '1', '1:列表推荐\r\n2:频道推荐\r\n4:首页推荐', '3');
INSERT INTO `tu_config` VALUES ('12', 'DOCUMENT_DISPLAY', '3', '文档可见性', '2', '', '文章可见性仅影响前台显示，后台不收影响', '1379056370', '1379235322', '1', '0:所有人可见\r\n1:仅注册会员可见\r\n2:仅管理员可见', '4');
INSERT INTO `tu_config` VALUES ('13', 'COLOR_STYLE', '4', '后台色系', '1', 'default_color:默认\r\nblue_color:紫罗兰', '后台颜色风格', '1379122533', '1379235904', '1', 'default_color', '10');
INSERT INTO `tu_config` VALUES ('20', 'CONFIG_GROUP_LIST', '3', '配置分组', '4', '', '配置分组', '1379228036', '1384418383', '1', '1:基本\r\n2:内容\r\n3:用户\r\n4:系统', '4');
INSERT INTO `tu_config` VALUES ('21', 'HOOKS_TYPE', '3', '钩子的类型', '4', '', '类型 1-用于扩展显示内容，2-用于扩展业务处理', '1379313397', '1379313407', '1', '1:视图\r\n2:控制器', '6');
INSERT INTO `tu_config` VALUES ('22', 'AUTH_CONFIG', '3', 'Auth配置', '4', '', '自定义Auth.class.php类配置', '1379409310', '1379409564', '1', 'AUTH_ON:1\r\nAUTH_TYPE:2', '8');
INSERT INTO `tu_config` VALUES ('23', 'OPEN_DRAFTBOX', '4', '是否开启草稿功能', '2', '0:关闭草稿功能\r\n1:开启草稿功能\r\n', '新增文章时的草稿功能配置', '1379484332', '1379484591', '1', '1', '1');
INSERT INTO `tu_config` VALUES ('24', 'DRAFT_AOTOSAVE_INTERVAL', '0', '自动保存草稿时间', '2', '', '自动保存草稿的时间间隔，单位：秒', '1379484574', '1386143323', '1', '60', '2');
INSERT INTO `tu_config` VALUES ('25', 'LIST_ROWS', '0', '后台每页记录数', '2', '', '后台数据每页显示记录数', '1379503896', '1380427745', '1', '10', '10');
INSERT INTO `tu_config` VALUES ('26', 'USER_ALLOW_REGISTER', '4', '是否允许用户注册', '3', '0:关闭注册\r\n1:允许注册', '是否开放用户注册', '1379504487', '1379504580', '1', '1', '3');
INSERT INTO `tu_config` VALUES ('27', 'CODEMIRROR_THEME', '4', '预览插件的CodeMirror主题', '4', '3024-day:3024 day\r\n3024-night:3024 night\r\nambiance:ambiance\r\nbase16-dark:base16 dark\r\nbase16-light:base16 light\r\nblackboard:blackboard\r\ncobalt:cobalt\r\neclipse:eclipse\r\nelegant:elegant\r\nerlang-dark:erlang-dark\r\nlesser-dark:lesser-dark\r\nmidnight:midnight', '详情见CodeMirror官网', '1379814385', '1384740813', '1', 'ambiance', '3');
INSERT INTO `tu_config` VALUES ('28', 'DATA_BACKUP_PATH', '1', '数据库备份根路径', '4', '', '路径必须以 / 结尾', '1381482411', '1381482411', '1', './Data/', '5');
INSERT INTO `tu_config` VALUES ('29', 'DATA_BACKUP_PART_SIZE', '0', '数据库备份卷大小', '4', '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '1381482488', '1381729564', '1', '20971520', '7');
INSERT INTO `tu_config` VALUES ('30', 'DATA_BACKUP_COMPRESS', '4', '数据库备份文件是否启用压缩', '4', '0:不压缩\r\n1:启用压缩', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', '1381713345', '1381729544', '1', '1', '9');
INSERT INTO `tu_config` VALUES ('31', 'DATA_BACKUP_COMPRESS_LEVEL', '4', '数据库备份文件压缩级别', '4', '1:普通\r\n4:一般\r\n9:最高', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '1381713408', '1381713408', '1', '9', '10');
INSERT INTO `tu_config` VALUES ('32', 'DEVELOP_MODE', '4', '开启开发者模式', '4', '0:关闭\r\n1:开启', '是否开启开发者模式', '1383105995', '1383291877', '1', '1', '11');
INSERT INTO `tu_config` VALUES ('33', 'ALLOW_VISIT', '3', '不受限控制器方法', '0', '', '', '1386644047', '1386644741', '1', '0:article/draftbox\r\n1:article/mydocument\r\n2:Category/tree\r\n3:Index/verify\r\n4:file/upload\r\n5:file/download\r\n6:user/updatePassword\r\n7:user/updateNickname\r\n8:user/submitPassword\r\n9:user/submitNickname\r\n10:file/uploadpicture', '0');
INSERT INTO `tu_config` VALUES ('34', 'DENY_VISIT', '3', '超管专限控制器方法', '0', '', '仅超级管理员可访问的控制器方法', '1386644141', '1386644659', '1', '0:Addons/addhook\r\n1:Addons/edithook\r\n2:Addons/delhook\r\n3:Addons/updateHook\r\n4:Admin/getMenus\r\n5:Admin/recordList\r\n6:AuthManager/updateRules\r\n7:AuthManager/tree', '0');
INSERT INTO `tu_config` VALUES ('35', 'REPLY_LIST_ROWS', '0', '回复列表每页条数', '2', '', '', '1386645376', '1387178083', '1', '10', '0');
INSERT INTO `tu_config` VALUES ('36', 'ADMIN_ALLOW_IP', '2', '后台允许访问IP', '4', '', '多个用逗号分隔，如果不配置表示不限制IP访问', '1387165454', '1387165553', '1', '', '12');
INSERT INTO `tu_config` VALUES ('37', 'SHOW_PAGE_TRACE', '4', '是否显示页面Trace', '4', '0:关闭\r\n1:开启', '是否显示页面Trace信息', '1387165685', '1387165685', '1', '1', '1');
INSERT INTO `tu_config` VALUES ('45', 'MAIL_TYPE', '4', '邮件类型', '5', 'SMTP模块发送\r\n其他模块发送', '', '1410491198', '1410491839', '1', '0', '1');
INSERT INTO `tu_config` VALUES ('46', 'MAIL_SMTP_HOST', '1', 'SMTP服务器', '5', '', '邮箱服务器名称[如：smtp.qq.com]', '1410491317', '1410937703', '1', 'smtp.qq.com', '2');
INSERT INTO `tu_config` VALUES ('47', 'MAIL_SMTP_PORT', '0', 'SMTP服务器端口', '5', '', '端口一般为25', '1410491384', '1410491384', '1', '465', '3');
INSERT INTO `tu_config` VALUES ('48', 'MAIL_SMTP_USER', '1', 'SMTP服务器用户名', '5', '', '邮箱用户名', '1410491508', '1410941682', '1', '745454106@qq.com', '4');
INSERT INTO `tu_config` VALUES ('49', 'MAIL_SMTP_PASS', '1', 'SMTP服务器密码', '5', '邮箱密码', '密码', '1410491656', '1410941695', '1', 'qkjemztolvpwbdfj', '5');
INSERT INTO `tu_config` VALUES ('50', 'MAIL_SMTP_CE', '1', '邮件发送测试', '5', '', '发送测试邮件用的，测试你的邮箱配置成功没有', '1410491698', '1410937656', '1', '15811506097@163.com', '6');
INSERT INTO `tu_config` VALUES ('51', 'FROM_EMAIL', '1', '发件人名称', '5', '', '发件人名称', '1410925495', '1410925495', '1', '图片+', '0');

-- ----------------------------
-- Table structure for tu_document
-- ----------------------------
DROP TABLE IF EXISTS `tu_document`;
CREATE TABLE `tu_document` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` char(40) NOT NULL DEFAULT '' COMMENT '标识',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '标题',
  `category_id` int(10) unsigned NOT NULL COMMENT '所属分类',
  `group_id` smallint(3) unsigned NOT NULL COMMENT '所属分组',
  `description` char(140) NOT NULL DEFAULT '' COMMENT '描述',
  `root` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '根节点',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属ID',
  `model_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '内容模型ID',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '2' COMMENT '内容类型',
  `position` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '推荐位',
  `link_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外链',
  `cover_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '封面',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '可见性',
  `deadline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '截至时间',
  `attach` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '附件数量',
  `view` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `comment` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `extend` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '扩展统计字段',
  `level` int(10) NOT NULL DEFAULT '0' COMMENT '优先级',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '数据状态',
  PRIMARY KEY (`id`),
  KEY `idx_category_status` (`category_id`,`status`),
  KEY `idx_status_type_pid` (`status`,`uid`,`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文档模型基础表';

-- ----------------------------
-- Records of tu_document
-- ----------------------------
INSERT INTO `tu_document` VALUES ('1', '1', '', 'OneThink1.1开发版发布', '2', '0', '期待已久的OneThink最新版发布', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '23', '0', '0', '0', '1406001413', '1406001413', '1');

-- ----------------------------
-- Table structure for tu_document_article
-- ----------------------------
DROP TABLE IF EXISTS `tu_document_article`;
CREATE TABLE `tu_document_article` (
  `id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
  `parse` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '内容解析类型',
  `content` text NOT NULL COMMENT '文章内容',
  `template` varchar(100) NOT NULL DEFAULT '' COMMENT '详情页显示模板',
  `bookmark` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档模型文章表';

-- ----------------------------
-- Records of tu_document_article
-- ----------------------------
INSERT INTO `tu_document_article` VALUES ('1', '0', '<h1>\r\n	OneThink1.1开发版发布&nbsp;\r\n</h1>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<strong>OneThink是一个开源的内容管理框架，基于最新的ThinkPHP3.2版本开发，提供更方便、更安全的WEB应用开发体验，采用了全新的架构设计和命名空间机制，融合了模块化、驱动化和插件化的设计理念于一体，开启了国内WEB应用傻瓜式开发的新潮流。&nbsp;</strong> \r\n</p>\r\n<h2>\r\n	主要特性：\r\n</h2>\r\n<p>\r\n	1. 基于ThinkPHP最新3.2版本。\r\n</p>\r\n<p>\r\n	2. 模块化：全新的架构和模块化的开发机制，便于灵活扩展和二次开发。&nbsp;\r\n</p>\r\n<p>\r\n	3. 文档模型/分类体系：通过和文档模型绑定，以及不同的文档类型，不同分类可以实现差异化的功能，轻松实现诸如资讯、下载、讨论和图片等功能。\r\n</p>\r\n<p>\r\n	4. 开源免费：OneThink遵循Apache2开源协议,免费提供使用。&nbsp;\r\n</p>\r\n<p>\r\n	5. 用户行为：支持自定义用户行为，可以对单个用户或者群体用户的行为进行记录及分享，为您的运营决策提供有效参考数据。\r\n</p>\r\n<p>\r\n	6. 云端部署：通过驱动的方式可以轻松支持平台的部署，让您的网站无缝迁移，内置已经支持SAE和BAE3.0。\r\n</p>\r\n<p>\r\n	7. 云服务支持：即将启动支持云存储、云安全、云过滤和云统计等服务，更多贴心的服务让您的网站更安心。\r\n</p>\r\n<p>\r\n	8. 安全稳健：提供稳健的安全策略，包括备份恢复、容错、防止恶意攻击登录，网页防篡改等多项安全管理功能，保证系统安全，可靠、稳定的运行。&nbsp;\r\n</p>\r\n<p>\r\n	9. 应用仓库：官方应用仓库拥有大量来自第三方插件和应用模块、模板主题，有众多来自开源社区的贡献，让您的网站“One”美无缺。&nbsp;\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<strong>&nbsp;OneThink集成了一个完善的后台管理体系和前台模板标签系统，让你轻松管理数据和进行前台网站的标签式开发。&nbsp;</strong> \r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<h2>\r\n	后台主要功能：\r\n</h2>\r\n<p>\r\n	1. 用户Passport系统\r\n</p>\r\n<p>\r\n	2. 配置管理系统&nbsp;\r\n</p>\r\n<p>\r\n	3. 权限控制系统\r\n</p>\r\n<p>\r\n	4. 后台建模系统&nbsp;\r\n</p>\r\n<p>\r\n	5. 多级分类系统&nbsp;\r\n</p>\r\n<p>\r\n	6. 用户行为系统&nbsp;\r\n</p>\r\n<p>\r\n	7. 钩子和插件系统\r\n</p>\r\n<p>\r\n	8. 系统日志系统&nbsp;\r\n</p>\r\n<p>\r\n	9. 数据备份和还原\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	&nbsp;[ 官方下载：&nbsp;<a href=\"http://www.onethink.cn/download.html\" target=\"_blank\">http://www.onethink.cn/download.html</a>&nbsp;&nbsp;开发手册：<a href=\"http://document.onethink.cn/\" target=\"_blank\">http://document.onethink.cn/</a>&nbsp;]&nbsp;\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<strong>OneThink开发团队 2013~2014</strong> \r\n</p>', '', '0');

-- ----------------------------
-- Table structure for tu_document_download
-- ----------------------------
DROP TABLE IF EXISTS `tu_document_download`;
CREATE TABLE `tu_document_download` (
  `id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
  `parse` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '内容解析类型',
  `content` text NOT NULL COMMENT '下载详细描述',
  `template` varchar(100) NOT NULL DEFAULT '' COMMENT '详情页显示模板',
  `file_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件ID',
  `download` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档模型下载表';

-- ----------------------------
-- Records of tu_document_download
-- ----------------------------

-- ----------------------------
-- Table structure for tu_file
-- ----------------------------
DROP TABLE IF EXISTS `tu_file`;
CREATE TABLE `tu_file` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件ID',
  `file_channel` varchar(40) NOT NULL DEFAULT '' COMMENT '文件所属频道',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `path` char(100) NOT NULL DEFAULT '' COMMENT '文件保存的路径',
  `savename` char(20) NOT NULL DEFAULT '' COMMENT '保存的名称',
  `savepath` char(100) NOT NULL DEFAULT '' COMMENT '文件保存的路径+保存的文件名',
  `ext` char(5) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `mime` char(40) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '远程地址',
  `location` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '后台文件驱动',
  `remark` char(40) NOT NULL DEFAULT '' COMMENT '备注信息',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_md5` (`md5`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='文件表';

-- ----------------------------
-- Records of tu_file
-- ----------------------------
INSERT INTO `tu_file` VALUES ('9', 'VideoScript', '多种切换效果的图片切换插件.rar', '/Uplaods/Attachment/VideoScript/2015-12-30/', '5683ae0f21e52.rar', '/Uplaods/Attachment/VideoScript/2015-12-30/5683ae0f21e52.rar', 'rar', 'zip', '376952', '76fdbc7b69a48a5db258e195b1b8201a', 'c94550a374f1dba94651476cf9c3d67cb67f043a', '', '0', '参考风格', '1451470351');
INSERT INTO `tu_file` VALUES ('10', '', 'PicPacking.zip', '/Uploads/Download/2015-12-30/5683b413b75a5.zip', '5683b413b75a5.zip', '2015-12-30/', 'zip', 'application/octet-stream', '5227451', 'baee945f081e7d5ec29dc3d90cacd232', '38c46ea18307e6e787669d750cc4a9b389688f20', '', '0', '', '1451471891');

-- ----------------------------
-- Table structure for tu_hooks
-- ----------------------------
DROP TABLE IF EXISTS `tu_hooks`;
CREATE TABLE `tu_hooks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `description` text COMMENT '描述',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `addons` varchar(255) NOT NULL DEFAULT '' COMMENT '钩子挂载的插件 ''，''分割',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_hooks
-- ----------------------------
INSERT INTO `tu_hooks` VALUES ('1', 'pageHeader', '页面header钩子，一般用于加载插件CSS文件和代码', '1', '0', '', '1');
INSERT INTO `tu_hooks` VALUES ('2', 'pageFooter', '页面footer钩子，一般用于加载插件JS文件和JS代码', '1', '0', 'ReturnTop,Email', '1');
INSERT INTO `tu_hooks` VALUES ('3', 'documentEditForm', '添加编辑表单的 扩展内容钩子', '1', '0', 'Attachment', '1');
INSERT INTO `tu_hooks` VALUES ('4', 'documentDetailAfter', '文档末尾显示', '1', '0', 'Attachment,SocialComment', '1');
INSERT INTO `tu_hooks` VALUES ('5', 'documentDetailBefore', '页面内容前显示用钩子', '1', '0', '', '1');
INSERT INTO `tu_hooks` VALUES ('6', 'documentSaveComplete', '保存文档数据后的扩展钩子', '2', '0', 'Attachment', '1');
INSERT INTO `tu_hooks` VALUES ('7', 'documentEditFormContent', '添加编辑表单的内容显示钩子', '1', '0', 'Editor', '1');
INSERT INTO `tu_hooks` VALUES ('8', 'adminArticleEdit', '后台内容编辑页编辑器', '1', '1378982734', 'EditorForAdmin', '1');
INSERT INTO `tu_hooks` VALUES ('13', 'AdminIndex', '首页小格子个性化显示', '1', '1382596073', 'SiteStat,SystemInfo,DevTeam', '1');
INSERT INTO `tu_hooks` VALUES ('14', 'topicComment', '评论提交方式扩展钩子。', '1', '1380163518', 'Editor', '1');
INSERT INTO `tu_hooks` VALUES ('16', 'app_begin', '应用开始', '2', '1384481614', '', '1');
INSERT INTO `tu_hooks` VALUES ('17', 'Silder', 'Silder 插件所需钩子', '1', '1450860362', 'Silder', '1');
INSERT INTO `tu_hooks` VALUES ('19', 'Timeline', 'Timeline 插件所需钩子', '1', '1450941346', 'Timeline', '1');
INSERT INTO `tu_hooks` VALUES ('20', 'Brand', 'Brand 插件所需钩子', '1', '1450948674', 'Brand', '1');

-- ----------------------------
-- Table structure for tu_made_order_adpic
-- ----------------------------
DROP TABLE IF EXISTS `tu_made_order_adpic`;
CREATE TABLE `tu_made_order_adpic` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT COMMENT '定制订单-广告图 id',
  `order_num` varchar(60) NOT NULL COMMENT '订单编号',
  `uid` int(11) NOT NULL COMMENT '下单的用户id',
  `pact` text NOT NULL COMMENT '合同',
  `item_name` varchar(255) NOT NULL COMMENT '项目名称',
  `item_describe` text NOT NULL COMMENT '项目描述',
  `item_budget` int(15) NOT NULL COMMENT '项目预算',
  `item_cycle` varchar(255) NOT NULL COMMENT '项目周期',
  `application` varchar(255) NOT NULL COMMENT '应用场景',
  `car_logo` varchar(255) NOT NULL COMMENT '产品车型-品牌',
  `car_type` varchar(255) NOT NULL COMMENT '产品车型-车型',
  `car_model` varchar(255) NOT NULL COMMENT '产品车型-车款',
  `one_format` varchar(255) NOT NULL COMMENT '单张输出格式',
  `car_color` varchar(255) NOT NULL COMMENT '车型颜色',
  `exterior` varchar(255) NOT NULL COMMENT '车辆外观',
  `internal` varchar(255) NOT NULL COMMENT '车辆内饰',
  `parts` varchar(255) NOT NULL COMMENT '外观或内饰单独配件展示',
  `steel_frame` varchar(255) NOT NULL COMMENT '钢架结构',
  `suspension` varchar(255) NOT NULL COMMENT '悬架系统',
  `transmission` varchar(255) NOT NULL COMMENT '发动机&变速器',
  `engine` varchar(255) NOT NULL COMMENT '发动机透视',
  `gasbag` varchar(255) NOT NULL COMMENT '气囊展示',
  `electric` varchar(255) NOT NULL COMMENT '电器系统',
  `background` varchar(255) NOT NULL COMMENT '背景环境',
  `all_format` varchar(255) NOT NULL COMMENT '360°展示输出格式',
  `all_exterior` varchar(255) NOT NULL COMMENT '外观360°展示',
  `all_internal` varchar(255) NOT NULL COMMENT '内饰360°展示',
  `fish_eye_show` varchar(255) NOT NULL COMMENT '内饰鱼眼720°展示',
  `all_engine` varchar(255) NOT NULL COMMENT '发动机360°展示',
  `all_background` varchar(255) NOT NULL COMMENT '外观360°背景展示',
  `max_model` varchar(255) NOT NULL COMMENT 'max模型',
  `one_style` varchar(255) NOT NULL COMMENT '单帧风格',
  `reference_style` varchar(255) NOT NULL COMMENT '参考风格',
  `reference_note` varchar(255) NOT NULL COMMENT '参考风格-备注',
  `background_ask` varchar(255) NOT NULL COMMENT '指定背景要求',
  `contacts` varchar(255) NOT NULL COMMENT '联系人',
  `phone` varchar(255) NOT NULL COMMENT '联系电话',
  `annex` varchar(255) NOT NULL COMMENT '附件',
  `annex_note` text NOT NULL COMMENT '附件备注',
  `service_charge` varchar(255) NOT NULL COMMENT '服务费',
  `taxes` varchar(255) NOT NULL COMMENT '税费',
  `cost` varchar(255) NOT NULL COMMENT '费用预估',
  `state` varchar(255) NOT NULL COMMENT '状态',
  `created` int(10) unsigned DEFAULT NULL COMMENT '下单时间',
  `amount` varchar(255) NOT NULL COMMENT '付款金额',
  `note` text COMMENT '备注',
  `product` text COMMENT '成品',
  `amounts` varchar(255) DEFAULT NULL COMMENT '尾款',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_made_order_adpic
-- ----------------------------
INSERT INTO `tu_made_order_adpic` VALUES ('1', '11111111111', '22', '	\r\nMDAwMDAwMDAwMMewftKSpX6ZgZt8p6zOqqKSzpymjLpxmsV4fKea0Ymrq6Gjy4HLrMyann2kvbh8b4HNcqOLlXqYvWOqoprRlq3H\r\npKDZgcuszJt4fWDEqHxvgc2nqYi8eqPGY3ydm5WqrrR-bZWaz63ZkYiJk6_ffLCFtYWnf7iBpLGreJWE3ohqsXuCy4amet2Rm5ph\r\nvLmIrp3OnKp7za-Zx2N8ZJK7aKDEjonLh8t-lIabnqq8z4SxhZN5ZoC7fWGwn6aim6d8q6ulgsqcz4vakYmJn6zPoqKFy3GrgLdo\r\nqLGaZqyFqqquq6Cry5K6nZOBm6aZyNKfsIHKp5yUu6SkvoR_aIHRea_FfqzSkZR7k5mIcKW7qGyvkZSCn5anaarIeYCekbtjoa56\r\nftyZuqXPgZummbG5fLKG24Fkf7eBo62eZ52Gt3xuq6R-ypK5ipiGdY2dsKmasZK1lJ6Au46asZuinZHegaOxi3bMkbmDzoWbhKms\r\nzqqim5OYm3-3gWatm4Nmkd6EaryOedqHpoLahmOMYr25lm2G24llgbuJY7KFeJyR3oWgsY593IemoJWHdZ-dsM90ooSkemSV0a-Z\r\ns5p_m4SnfavEaYLKnKmh2ZqagGasz3SihKR6rIy7aZjHnqmbh818oa56fsybz4vLnHiNlsesn62StHlpe859YLKFe2KG3nhssYt5\r\ny56zcqA', '测试', '测试测试测试测试测试', '1000', '10', '111', '111', '111', '', '11', '11', '111', '111', '11', '11', '11', '11', '11', '11', '11', '11', '11', '11', '11', '11', '11', '11', '11', '11', '11', '11', '11', '11', '11111111111', '1', '111测试', '11', '11', '1000-2000', '3', null, '10000', '11111111111111111111111', 'MDAwMDAwMDAwMMewftKSpX6ZgZt8p6zOqqKSzpymjLpxmsV4fKea0Ymrq6Gjy4HLrMyann2kvbh8b4HNcqOLlXqYvWOqoprRlq3HpKDZgcuszJt4fWDEqHxvgc2nqYi8eqPGY3ydm5WqrrR-bZWaz63ZkYiJk6_ffLCFtYWnf7iBpLGreJWE3ohqsXuCy4amet2Rm5phvLmIrp3OnKp7za-Zx2N8ZJK7aKDEjonLh8t-lIabnqq8z4SxhZN5ZoC7fWGwn6aim6d8q6ulgsqcz4vakYmJn6zPoqKFy3GrgLdoqLGaZqyFqqquq6Cry5K6nZOBm6aZyNKfsIHKp5yUu6SkvoR_aIHRea_FfqzSkZR7k5mIcKW7qGyvkZSCn5anaarIeYCekbtjoa56ftyZuqXPgZummbG5fLKG24Fkf7eBo62eZ52Gt3xuq6R-ypK5ipiGdY2dsKmasZK1lJ6Au46asZuinZHegaOxi3bMkbmDzoWbhKmszqqim5OYm3-3gWatm4Nmkd6EaryOedqHpoLahmOMYr25lm2G24llgbuJY7KFeJyR3oWgsY593IemoJWHdZ-dsM90ooSkemSV0a-Zs5p_m4SnfavEaYLKnKmh2ZqagGasz3SihKR6rIy7aZjHnqmbh818oa56fsybz4vLnHiNlsesn62StHlpe859YLKFe2KG3nhssYt5y56zcqA', '20000');

-- ----------------------------
-- Table structure for tu_made_order_manual
-- ----------------------------
DROP TABLE IF EXISTS `tu_made_order_manual`;
CREATE TABLE `tu_made_order_manual` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT COMMENT '定制订单-产品说明书 id',
  `order_num` varchar(60) NOT NULL COMMENT '订单编号',
  `uid` int(11) NOT NULL COMMENT '下单的用户id',
  `pact` text NOT NULL COMMENT '合同',
  `item_name` varchar(255) NOT NULL COMMENT '项目名称',
  `item_describe` text NOT NULL COMMENT '项目描述',
  `item_budget` float(15,0) NOT NULL COMMENT '项目预算',
  `item_cycle` varchar(255) NOT NULL COMMENT '项目周期',
  `application` varchar(255) NOT NULL COMMENT '应用场景',
  `car_logo` varchar(255) NOT NULL COMMENT '产品车型-品牌',
  `car_type` varchar(255) NOT NULL COMMENT '产品车型-车型',
  `car_model` varchar(255) NOT NULL COMMENT '产品车型-车款',
  `format` varchar(255) NOT NULL COMMENT '输出格式',
  `car_color` varchar(255) NOT NULL COMMENT '车型颜色',
  `exterior` varchar(255) NOT NULL COMMENT '车辆外观',
  `internal` varchar(255) NOT NULL COMMENT '车辆内饰',
  `steel_frame` varchar(255) NOT NULL COMMENT '钢架结构',
  `suspension` varchar(255) NOT NULL COMMENT '悬架系统',
  `dynamic` varchar(255) NOT NULL COMMENT '动力系统',
  `transmission` varchar(255) NOT NULL COMMENT '发动机&变速器',
  `engine` varchar(255) NOT NULL COMMENT '发动机透视',
  `gasbag` varchar(255) NOT NULL COMMENT '气囊展示',
  `electric` varchar(255) NOT NULL COMMENT '电器系统',
  `tire` varchar(255) NOT NULL COMMENT '轮胎',
  `Headlight` varchar(255) NOT NULL COMMENT '大灯',
  `seat` varchar(255) NOT NULL COMMENT '座椅',
  `sound` varchar(255) NOT NULL COMMENT '音响',
  `meter` varchar(255) NOT NULL COMMENT '组合仪表',
  `air_conditioning` varchar(255) NOT NULL COMMENT '空调控制区域',
  `wiper` varchar(255) NOT NULL COMMENT '雨刷控制器',
  `lighting` varchar(255) NOT NULL COMMENT '照明控制器',
  `smart_key` varchar(255) NOT NULL COMMENT '智能钥匙',
  `child_lock` varchar(255) NOT NULL COMMENT '儿童安全锁',
  `power_seat` varchar(255) NOT NULL COMMENT '电动座椅控制系统',
  `boot` varchar(255) NOT NULL COMMENT '后备箱置物',
  `brake` varchar(255) NOT NULL COMMENT '驻车控制',
  `gear` varchar(255) NOT NULL COMMENT '档位控制说明',
  `steering` varchar(255) NOT NULL COMMENT '多功能方向盘说明',
  `cabin` varchar(255) NOT NULL COMMENT '发动机舱内说明',
  `other_artifacts` varchar(255) NOT NULL COMMENT '其他装配件',
  `environment` varchar(255) NOT NULL COMMENT '背景环境图',
  `background` varchar(255) NOT NULL COMMENT '指定背景要求',
  `size_page` varchar(255) NOT NULL COMMENT '产品册尺寸及页数',
  `contacts` varchar(255) NOT NULL COMMENT '联系人',
  `phone` varchar(255) NOT NULL COMMENT '联系电话',
  `annex` varchar(255) NOT NULL COMMENT '附件',
  `annex_note` text NOT NULL COMMENT '附件备注',
  `service_charge` varchar(255) NOT NULL COMMENT '服务费',
  `taxes` varchar(255) NOT NULL COMMENT '税费',
  `cost` varchar(255) NOT NULL COMMENT '费用预估',
  `state` varchar(255) NOT NULL COMMENT '状态',
  `created` int(10) unsigned DEFAULT NULL COMMENT '下单时间',
  `amount` varchar(255) NOT NULL COMMENT '付款金额',
  `note` text COMMENT '备注',
  `product` text COMMENT '成品',
  `amounts` varchar(255) DEFAULT NULL COMMENT '尾款',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_made_order_manual
-- ----------------------------

-- ----------------------------
-- Table structure for tu_made_order_model
-- ----------------------------
DROP TABLE IF EXISTS `tu_made_order_model`;
CREATE TABLE `tu_made_order_model` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT COMMENT '定制订单-模型 id',
  `order_num` varchar(60) NOT NULL COMMENT '订单编号',
  `uid` int(11) NOT NULL COMMENT '下单的用户id',
  `pact` text NOT NULL COMMENT '合同',
  `item_name` varchar(255) NOT NULL COMMENT '项目名称',
  `item_describe` text NOT NULL COMMENT '项目描述',
  `item_budget` float(15,0) NOT NULL COMMENT '项目预算',
  `item_cycle` varchar(255) NOT NULL COMMENT '项目周期',
  `application` varchar(255) NOT NULL COMMENT '应用场景',
  `car_logo` varchar(255) NOT NULL COMMENT '产品-品牌',
  `car_type` varchar(255) NOT NULL COMMENT '车型',
  `car_model` varchar(255) NOT NULL COMMENT '车款',
  `industrial` smallint(2) unsigned NOT NULL COMMENT '工业模型( 是 : 1 , 否 ： 0 )',
  `exterior` int(15) unsigned NOT NULL COMMENT '外观模型',
  `internal` int(15) unsigned NOT NULL COMMENT '内饰模型制作',
  `engine` int(15) unsigned NOT NULL COMMENT '发动机模型',
  `gearbox` int(15) unsigned NOT NULL COMMENT '变速箱模型',
  `suspension` int(15) unsigned NOT NULL COMMENT '悬架模型',
  `steel_frame` int(15) unsigned NOT NULL COMMENT '钢架模型',
  `chassis` int(15) unsigned NOT NULL COMMENT '底盘模型',
  `other_artifacts` int(15) unsigned NOT NULL COMMENT '其他构件',
  `facelift` int(15) unsigned NOT NULL COMMENT '外观内饰改款模型制作',
  `visual_parts` int(15) unsigned NOT NULL COMMENT '外观配件',
  `interior_parts` int(15) unsigned NOT NULL COMMENT '内部配件',
  `scenario_model` varchar(255) NOT NULL COMMENT '场景模型',
  `scenario_model_type` varchar(255) NOT NULL COMMENT '场景模型类型',
  `role` varchar(255) NOT NULL COMMENT '角色模型',
  `role_type` varchar(255) NOT NULL COMMENT '角色模型类型',
  `quality` varchar(255) NOT NULL COMMENT '汽车模型质量',
  `contacts` varchar(255) NOT NULL COMMENT '联系人',
  `phone` varchar(255) NOT NULL COMMENT '联系电话',
  `annex` varchar(255) NOT NULL COMMENT '附件',
  `annex_note` text NOT NULL COMMENT '附件备注',
  `service_charge` varchar(255) NOT NULL COMMENT '服务费',
  `taxes` varchar(255) NOT NULL COMMENT '税费',
  `cost` varchar(255) NOT NULL COMMENT '费用预估',
  `state` varchar(255) NOT NULL COMMENT '状态',
  `created` int(10) unsigned DEFAULT NULL COMMENT '下单时间',
  `amount` varchar(255) NOT NULL COMMENT '付款金额',
  `note` text COMMENT '备注',
  `product` text COMMENT '成品',
  `amounts` varchar(255) DEFAULT NULL COMMENT '尾款',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_made_order_model
-- ----------------------------

-- ----------------------------
-- Table structure for tu_made_order_type
-- ----------------------------
DROP TABLE IF EXISTS `tu_made_order_type`;
CREATE TABLE `tu_made_order_type` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '订制订单类型id',
  `item_name` varchar(20) NOT NULL COMMENT '订单类型名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_made_order_type
-- ----------------------------
INSERT INTO `tu_made_order_type` VALUES ('1', '模型');
INSERT INTO `tu_made_order_type` VALUES ('2', '广告图');
INSERT INTO `tu_made_order_type` VALUES ('3', '产品说明书');
INSERT INTO `tu_made_order_type` VALUES ('4', '视频脚本');
INSERT INTO `tu_made_order_type` VALUES ('5', '视频');

-- ----------------------------
-- Table structure for tu_made_order_video
-- ----------------------------
DROP TABLE IF EXISTS `tu_made_order_video`;
CREATE TABLE `tu_made_order_video` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT COMMENT '订制订单-视频id',
  `order_num` varchar(60) NOT NULL COMMENT '订单编号',
  `uid` int(11) NOT NULL COMMENT '下单的用户id',
  `pact` text NOT NULL COMMENT '合同',
  `item_name` varchar(255) NOT NULL COMMENT '项目名称',
  `item_describe` tinytext NOT NULL COMMENT '项目描述',
  `item_budget` float(15,0) NOT NULL COMMENT '项目预算',
  `item_cycle` varchar(255) NOT NULL COMMENT '项目周期',
  `application` varchar(255) NOT NULL COMMENT '应用场景',
  `channel` varchar(255) NOT NULL COMMENT '输出渠道',
  `car_logo` varchar(255) NOT NULL COMMENT '产品车型-品牌',
  `car_type` varchar(255) NOT NULL COMMENT '产品车型-车型',
  `car_model` varchar(255) NOT NULL COMMENT '产品车型-车款',
  `video_scale` varchar(255) NOT NULL COMMENT '视频画面比例',
  `video_size` varchar(255) NOT NULL COMMENT '视频详细尺寸',
  `video_format` varchar(255) NOT NULL COMMENT '视频格式',
  `car_color` varchar(255) NOT NULL COMMENT '主打车型颜色',
  `video_time` varchar(255) NOT NULL COMMENT '影片时长',
  `environment` varchar(255) NOT NULL COMMENT '环境要求',
  `video_style` varchar(255) NOT NULL COMMENT '影片风格',
  `exhibit` varchar(255) NOT NULL COMMENT '展示内容',
  `scene` varchar(255) NOT NULL COMMENT '场景元素',
  `reference_style` varchar(255) NOT NULL COMMENT '参考风格',
  `remarks` text NOT NULL COMMENT '备注',
  `style` varchar(255) NOT NULL COMMENT '参考风格',
  `contacts` varchar(255) NOT NULL COMMENT '联系人',
  `phone` varchar(255) NOT NULL COMMENT '联系电话',
  `role` varchar(255) NOT NULL COMMENT '角色',
  `pack` int(2) NOT NULL COMMENT '是否包装 （1：是 ， 0：否）',
  `music` int(2) NOT NULL COMMENT '是否音乐（1：是，0：否）',
  `sound` int(2) NOT NULL COMMENT '是否音效（1：是，0：否）',
  `voiceover` varchar(255) DEFAULT NULL COMMENT '配音',
  `annex` varchar(255) NOT NULL COMMENT '附件',
  `annex_note` text NOT NULL COMMENT '附件备注',
  `service_charge` varchar(255) NOT NULL COMMENT '服务费',
  `taxes` varchar(255) NOT NULL COMMENT '税费',
  `cost` varchar(255) NOT NULL COMMENT '费用预估',
  `state` varchar(255) NOT NULL COMMENT '状态',
  `created` int(10) unsigned DEFAULT NULL COMMENT '下单时间',
  `amount` varchar(255) DEFAULT NULL COMMENT '付款金额',
  `note` text COMMENT '备注',
  `product` text COMMENT '成品',
  `amounts` varchar(255) DEFAULT NULL COMMENT '尾款',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tu_made_order_video
-- ----------------------------

-- ----------------------------
-- Table structure for tu_made_order_video_script
-- ----------------------------
DROP TABLE IF EXISTS `tu_made_order_video_script`;
CREATE TABLE `tu_made_order_video_script` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT COMMENT '订制订单-视频脚本id',
  `order_num` varchar(60) NOT NULL COMMENT '订单编号',
  `uid` int(11) NOT NULL COMMENT '下单的用户id',
  `pact` text NOT NULL COMMENT '合同',
  `item_name` varchar(255) NOT NULL COMMENT '项目名称',
  `item_describe` tinytext NOT NULL COMMENT '项目描述',
  `item_budget` float(15,0) NOT NULL COMMENT '项目预算',
  `item_cycle` varchar(255) NOT NULL COMMENT '项目周期',
  `application` varchar(255) NOT NULL COMMENT '应用场景',
  `channel` varchar(255) NOT NULL COMMENT '输出渠道',
  `car_logo` varchar(255) NOT NULL COMMENT '产品车型-品牌',
  `car_type` varchar(255) NOT NULL COMMENT '产品车型-车型',
  `car_model` varchar(255) NOT NULL COMMENT '产品车型-车款',
  `format` varchar(255) NOT NULL COMMENT '输出格式',
  `car_color` varchar(255) NOT NULL COMMENT '主打车型颜色',
  `time` varchar(255) NOT NULL COMMENT '影片预计时长',
  `environmental` varchar(255) NOT NULL COMMENT '环境要求',
  `video_style` varchar(255) NOT NULL COMMENT '环境要求',
  `show_content` varchar(255) NOT NULL COMMENT '展示内容',
  `scene_elements` varchar(255) NOT NULL COMMENT '场景元素',
  `reference_style` varchar(255) NOT NULL COMMENT '参考风格',
  `reference_style_note` varchar(255) NOT NULL COMMENT '参考风格',
  `role` varchar(255) NOT NULL COMMENT '角色模型',
  `role_type` varchar(255) NOT NULL COMMENT '角色模型类型',
  `special` varchar(255) NOT NULL COMMENT '特殊展示部件',
  `contacts` varchar(255) NOT NULL COMMENT '联系人',
  `phone` varchar(255) NOT NULL COMMENT '联系电话',
  `annex` varchar(255) NOT NULL COMMENT '附件',
  `annex_note` text NOT NULL COMMENT '附件备注',
  `service_charge` varchar(255) NOT NULL COMMENT '服务费',
  `taxes` varchar(255) NOT NULL COMMENT '税费',
  `cost` varchar(255) NOT NULL COMMENT '费用预估',
  `state` varchar(255) NOT NULL COMMENT '状态',
  `created` int(10) unsigned DEFAULT NULL COMMENT '下单时间',
  `amount` varchar(255) DEFAULT NULL COMMENT '付款金额',
  `note` text COMMENT '备注',
  `product` text COMMENT '成品',
  `amounts` varchar(255) DEFAULT NULL COMMENT '尾款',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_made_order_video_script
-- ----------------------------

-- ----------------------------
-- Table structure for tu_mail_history
-- ----------------------------
DROP TABLE IF EXISTS `tu_mail_history`;
CREATE TABLE `tu_mail_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `create_time` int(11) NOT NULL,
  `from` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_mail_history
-- ----------------------------
INSERT INTO `tu_mail_history` VALUES ('1', '测试发送', '测试测试测试测试测试测试测试测试', '1450691280', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('2', 'socketssocketssockets', '<h3>\r\n	sockets\r\n</h3>\r\n<h3>\r\n	sockets\r\n</h3>\r\n<h3>\r\n	sockets\r\n</h3>\r\n<h3>\r\n	sockets\r\n</h3>\r\n<h3>\r\n	sockets\r\n</h3>\r\n<h3>\r\n	sockets\r\n</h3>\r\n<h3>\r\n	sockets\r\n</h3>\r\n<h3>\r\n	sockets\r\n</h3>\r\n<h3>\r\n	sockets\r\n</h3>\r\n<h3>\r\n	sockets\r\n</h3>\r\n<h3>\r\n	sockets\r\n</h3>\r\n<h3>\r\n	sockets\r\n</h3>\r\n<h3>\r\n	sockets\r\n</h3>', '1450691575', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('3', '测试', '测试测试测试测试测试测试测试测试测试', '1450692656', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('4', '测试', '测试测试测试测试测试测试测试测试测试', '1450692854', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('5', '测试', '测试测试测试测试测试', '1450693341', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('6', '测试', '测试测试测试测试测试', '1450693380', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('7', '测试', '测试测试测试测试测试', '1450693400', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('8', '测试', '测试测试测试测试测试', '1450693418', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('9', '测试', '测试测试测试测试测试', '1450693449', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('10', '测试', '测试测试测试测试测试', '1450693509', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('11', '测试', '测试测试测试测试测试', '1450693531', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('12', '测试', '测试测试测试测试测试', '1450693571', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('13', '测试', '测试测试测试测试测试', '1450693598', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('14', '测试', '测试测试测试测试测试', '1450693611', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('15', '测试', '测试测试测试测试测试', '1450693625', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('16', '测试', '测试测试测试测试测试', '1450693661', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('17', '测试', '测试测试测试测试测试', '1450693688', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('18', '测试', '测试测试测试测试测试', '1450693705', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('19', '测试', '测试测试测试测试测试', '1450693761', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('20', '测试', '测试测试测试测试测试', '1450693800', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('21', '测试', '测试测试测试测试测试', '1450693868', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('22', '测试', '测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试', '1450694030', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('23', '测试', '测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试', '1450694079', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('24', '1111111111111', '111111111111111111111', '1450837183', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('25', '2222222222222', '2222222222222222222222222222', '1450837220', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('26', '草稿箱测试', '草稿箱测试', '1450838202', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('27', '草稿箱测试', '草稿箱测试', '1450838215', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('28', '啥地方撒撒的发生大幅', '啥地方撒撒的发生大幅', '1450838538', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('29', '测试颜色', '测试颜色', '1450838735', 'OneThink内容管理框架', '1');
INSERT INTO `tu_mail_history` VALUES ('30', '?????????????????????', '?????????????????????????????????????', '1450838918', 'OneThink内容管理框架', '1');

-- ----------------------------
-- Table structure for tu_mail_history_link
-- ----------------------------
DROP TABLE IF EXISTS `tu_mail_history_link`;
CREATE TABLE `tu_mail_history_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_id` int(11) NOT NULL,
  `to` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_mail_history_link
-- ----------------------------
INSERT INTO `tu_mail_history_link` VALUES ('1', '1', '745454106@qq.com', '0');
INSERT INTO `tu_mail_history_link` VALUES ('2', '2', '745454106@qq.com', '0');
INSERT INTO `tu_mail_history_link` VALUES ('3', '3', '15811506097@163.com', '0');
INSERT INTO `tu_mail_history_link` VALUES ('4', '4', '15811506097@163.com', '0');
INSERT INTO `tu_mail_history_link` VALUES ('5', '23', '15811506097@163.com', '1');
INSERT INTO `tu_mail_history_link` VALUES ('6', '24', '15811506097@163.com', '0');
INSERT INTO `tu_mail_history_link` VALUES ('7', '25', '1369071016@qq.com', '0');
INSERT INTO `tu_mail_history_link` VALUES ('8', '26', '745454106@qq.com', '0');
INSERT INTO `tu_mail_history_link` VALUES ('9', '27', '15811506097@163.com', '0');
INSERT INTO `tu_mail_history_link` VALUES ('10', '28', '15811506097@163.com', '0');
INSERT INTO `tu_mail_history_link` VALUES ('11', '29', '15811506097@163.com', '1');
INSERT INTO `tu_mail_history_link` VALUES ('12', '30', '1369071016@qq.com', '1');

-- ----------------------------
-- Table structure for tu_mail_list
-- ----------------------------
DROP TABLE IF EXISTS `tu_mail_list`;
CREATE TABLE `tu_mail_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_mail_list
-- ----------------------------
INSERT INTO `tu_mail_list` VALUES ('1', '745454106@qq.com', '1', '1450691249');
INSERT INTO `tu_mail_list` VALUES ('2', '15811506097@163.com', '1', '1450692639');
INSERT INTO `tu_mail_list` VALUES ('3', '1369071016@qq.com', '1', '1450838889');

-- ----------------------------
-- Table structure for tu_mail_token
-- ----------------------------
DROP TABLE IF EXISTS `tu_mail_token`;
CREATE TABLE `tu_mail_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `token` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_mail_token
-- ----------------------------
INSERT INTO `tu_mail_token` VALUES ('1', '745454106@qq.com', 'MLnYcTDam9');
INSERT INTO `tu_mail_token` VALUES ('2', '15811506097@163.com', 'AwxZ4z22Uq');
INSERT INTO `tu_mail_token` VALUES ('3', '1369071016@qq.com', '9Tfgo47AGg');

-- ----------------------------
-- Table structure for tu_member
-- ----------------------------
DROP TABLE IF EXISTS `tu_member`;
CREATE TABLE `tu_member` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `nickname` char(16) NOT NULL DEFAULT '' COMMENT '昵称',
  `sex` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '性别',
  `birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT '生日',
  `qq` char(10) NOT NULL DEFAULT '' COMMENT 'qq号',
  `score` mediumint(8) NOT NULL DEFAULT '0' COMMENT '用户积分',
  `login` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `reg_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '会员状态',
  PRIMARY KEY (`uid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Records of tu_member
-- ----------------------------
INSERT INTO `tu_member` VALUES ('1', 'admin', '0', '0000-00-00', '', '50', '8', '0', '1450409053', '2130706433', '1451466811', '1');
INSERT INTO `tu_member` VALUES ('2', '测试小可爱', '0', '0000-00-00', '', '0', '0', '0', '0', '0', '0', '-1');
INSERT INTO `tu_member` VALUES ('3', 'ceshi1', '0', '0000-00-00', '', '0', '0', '0', '0', '0', '0', '-1');

-- ----------------------------
-- Table structure for tu_menu
-- ----------------------------
DROP TABLE IF EXISTS `tu_menu`;
CREATE TABLE `tu_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT ' 标题',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `url` char(255) NOT NULL COMMENT '链接地址',
  `hide` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `tip` varchar(255) NOT NULL COMMENT '提示',
  `group` varchar(50) DEFAULT NULL COMMENT '分组',
  `is_dev` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否仅开发者模式可见',
  `status` tinyint(1) unsigned zerofill NOT NULL DEFAULT '0' COMMENT '状态',
  `condition` varchar(255) NOT NULL COMMENT '菜单分组',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=154 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_menu
-- ----------------------------
INSERT INTO `tu_menu` VALUES ('1', '首页', '0', '1', 'Index/index', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('2', '内容', '0', '2', 'Article/index', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('3', '文档列表', '2', '0', 'article/index', '1', '', '内容', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('4', '新增', '3', '0', 'article/add', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('5', '编辑', '3', '0', 'article/edit', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('6', '改变状态', '3', '0', 'article/setStatus', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('7', '保存', '3', '0', 'article/update', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('8', '保存草稿', '3', '0', 'article/autoSave', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('9', '移动', '3', '0', 'article/move', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('10', '复制', '3', '0', 'article/copy', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('11', '粘贴', '3', '0', 'article/paste', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('12', '导入', '3', '0', 'article/batchOperate', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('13', '回收站', '2', '0', 'article/recycle', '1', '', '内容', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('14', '还原', '13', '0', 'article/permit', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('15', '清空', '13', '0', 'article/clear', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('16', '用户', '0', '3', 'User/index', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('17', '用户信息', '16', '0', 'User/index', '0', '', '后台用户管理', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('18', '新增用户', '17', '0', 'User/add', '0', '添加新用户', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('19', '用户行为', '16', '0', 'User/action', '0', '', '行为管理', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('20', '新增用户行为', '19', '0', 'User/addaction', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('21', '编辑用户行为', '19', '0', 'User/editaction', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('22', '保存用户行为', '19', '0', 'User/saveAction', '0', '\"用户->用户行为\"保存编辑和新增的用户行为', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('23', '变更行为状态', '19', '0', 'User/setStatus', '0', '\"用户->用户行为\"中的启用,禁用和删除权限', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('24', '禁用会员', '19', '0', 'User/changeStatus?method=forbidUser', '0', '\"用户->用户信息\"中的禁用', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('25', '启用会员', '19', '0', 'User/changeStatus?method=resumeUser', '0', '\"用户->用户信息\"中的启用', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('26', '删除会员', '19', '0', 'User/changeStatus?method=deleteUser', '0', '\"用户->用户信息\"中的删除', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('27', '后台权限管理', '16', '0', 'AuthManager/index', '1', '', '后台用户管理', '1', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('28', '删除', '27', '0', 'AuthManager/changeStatus?method=deleteGroup', '0', '删除用户组', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('29', '禁用', '27', '0', 'AuthManager/changeStatus?method=forbidGroup', '0', '禁用用户组', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('30', '恢复', '27', '0', 'AuthManager/changeStatus?method=resumeGroup', '0', '恢复已禁用的用户组', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('31', '新增', '27', '0', 'AuthManager/createGroup', '0', '创建新的用户组', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('32', '编辑', '27', '0', 'AuthManager/editGroup', '0', '编辑用户组名称和描述', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('33', '保存用户组', '27', '0', 'AuthManager/writeGroup', '0', '新增和编辑用户组的\"保存\"按钮', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('34', '授权', '27', '0', 'AuthManager/group', '0', '\"后台 \\ 用户 \\ 用户信息\"列表页的\"授权\"操作按钮,用于设置用户所属用户组', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('35', '访问授权', '27', '0', 'AuthManager/access', '0', '\"后台 \\ 用户 \\ 权限管理\"列表页的\"访问授权\"操作按钮', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('36', '成员授权', '27', '0', 'AuthManager/user', '0', '\"后台 \\ 用户 \\ 权限管理\"列表页的\"成员授权\"操作按钮', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('37', '解除授权', '27', '0', 'AuthManager/removeFromGroup', '0', '\"成员授权\"列表页内的解除授权操作按钮', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('38', '保存成员授权', '27', '0', 'AuthManager/addToGroup', '0', '\"用户信息\"列表页\"授权\"时的\"保存\"按钮和\"成员授权\"里右上角的\"添加\"按钮)', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('39', '分类授权', '27', '0', 'AuthManager/category', '0', '\"后台 \\ 用户 \\ 权限管理\"列表页的\"分类授权\"操作按钮', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('40', '保存分类授权', '27', '0', 'AuthManager/addToCategory', '0', '\"分类授权\"页面的\"保存\"按钮', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('41', '模型授权', '27', '0', 'AuthManager/modelauth', '0', '\"后台 \\ 用户 \\ 权限管理\"列表页的\"模型授权\"操作按钮', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('42', '保存模型授权', '27', '0', 'AuthManager/addToModel', '0', '\"分类授权\"页面的\"保存\"按钮', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('43', '扩展', '0', '7', 'Addons/index', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('44', '插件管理', '43', '1', 'Addons/index', '0', '', '扩展', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('45', '创建', '44', '0', 'Addons/create', '0', '服务器上创建插件结构向导', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('46', '检测创建', '44', '0', 'Addons/checkForm', '0', '检测插件是否可以创建', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('47', '预览', '44', '0', 'Addons/preview', '0', '预览插件定义类文件', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('48', '快速生成插件', '44', '0', 'Addons/build', '0', '开始生成插件结构', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('49', '设置', '44', '0', 'Addons/config', '0', '设置插件配置', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('50', '禁用', '44', '0', 'Addons/disable', '0', '禁用插件', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('51', '启用', '44', '0', 'Addons/enable', '0', '启用插件', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('52', '安装', '44', '0', 'Addons/install', '0', '安装插件', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('53', '卸载', '44', '0', 'Addons/uninstall', '0', '卸载插件', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('54', '更新配置', '44', '0', 'Addons/saveconfig', '0', '更新插件配置处理', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('55', '插件后台列表', '44', '0', 'Addons/adminList', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('56', 'URL方式访问插件', '44', '0', 'Addons/execute', '0', '控制是否有权限通过url访问插件控制器方法', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('57', '钩子管理', '43', '2', 'Addons/hooks', '0', '', '扩展', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('58', '模型管理', '68', '3', 'Model/index', '0', '', '系统设置', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('59', '新增', '58', '0', 'model/add', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('60', '编辑', '58', '0', 'model/edit', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('61', '改变状态', '58', '0', 'model/setStatus', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('62', '保存数据', '58', '0', 'model/update', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('63', '属性管理', '68', '0', 'Attribute/index', '1', '网站属性配置。', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('64', '新增', '63', '0', 'Attribute/add', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('65', '编辑', '63', '0', 'Attribute/edit', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('66', '改变状态', '63', '0', 'Attribute/setStatus', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('67', '保存数据', '63', '0', 'Attribute/update', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('68', '系统', '0', '4', 'Config/group', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('69', '网站设置', '68', '1', 'Config/group', '0', '', '系统设置', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('70', '配置管理', '68', '4', 'Config/index', '0', '', '系统设置', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('71', '编辑', '70', '0', 'Config/edit', '0', '新增编辑和保存配置', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('72', '删除', '70', '0', 'Config/del', '0', '删除配置', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('73', '新增', '70', '0', 'Config/add', '0', '新增配置', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('74', '保存', '70', '0', 'Config/save', '0', '保存配置', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('75', '菜单管理', '68', '5', 'Menu/index', '0', '', '系统设置', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('76', '导航管理', '68', '6', 'Channel/index', '0', '', '系统设置', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('77', '新增', '76', '0', 'Channel/add', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('78', '编辑', '76', '0', 'Channel/edit', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('79', '删除', '76', '0', 'Channel/del', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('80', '分类管理', '68', '2', 'Category/index', '0', '', '系统设置', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('81', '编辑', '80', '0', 'Category/edit', '0', '编辑和保存栏目分类', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('82', '新增', '80', '0', 'Category/add', '0', '新增栏目分类', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('83', '删除', '80', '0', 'Category/remove', '0', '删除栏目分类', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('84', '移动', '80', '0', 'Category/operate/type/move', '0', '移动栏目分类', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('85', '合并', '80', '0', 'Category/operate/type/merge', '0', '合并栏目分类', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('86', '备份数据库', '68', '0', 'Database/index?type=export', '0', '', '数据备份', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('87', '备份', '86', '0', 'Database/export', '0', '备份数据库', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('88', '优化表', '86', '0', 'Database/optimize', '0', '优化数据表', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('89', '修复表', '86', '0', 'Database/repair', '0', '修复数据表', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('90', '还原数据库', '68', '0', 'Database/index?type=import', '0', '', '数据备份', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('91', '恢复', '90', '0', 'Database/import', '0', '数据库恢复', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('92', '删除', '90', '0', 'Database/del', '0', '删除备份文件', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('93', '其他', '0', '5', 'other', '1', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('96', '新增', '75', '0', 'Menu/add', '0', '', '系统设置', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('98', '编辑', '75', '0', 'Menu/edit', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('106', '行为日志', '16', '0', 'Action/actionlog', '0', '', '行为管理', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('108', '修改密码', '16', '0', 'User/updatePassword', '1', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('109', '修改昵称', '16', '0', 'User/updateNickname', '1', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('110', '查看行为日志', '106', '0', 'action/edit', '1', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('112', '新增数据', '58', '0', 'think/add', '1', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('113', '编辑数据', '58', '0', 'think/edit', '1', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('114', '导入', '75', '0', 'Menu/import', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('115', '生成', '58', '0', 'Model/generate', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('116', '新增钩子', '57', '0', 'Addons/addHook', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('117', '编辑钩子', '57', '0', 'Addons/edithook', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('118', '文档排序', '3', '0', 'Article/sort', '1', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('119', '排序', '70', '0', 'Config/sort', '1', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('120', '排序', '75', '0', 'Menu/sort', '1', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('121', '排序', '76', '0', 'Channel/sort', '1', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('122', '数据列表', '58', '0', 'think/lists', '1', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('123', '审核列表', '3', '0', 'Article/examine', '1', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('124', '用户信息', '16', '0', 'Users/index', '0', '', '前台用户管理', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('125', '新增前台用户', '124', '0', 'Users/add', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('126', '前台权限管理', '16', '0', 'AuthFront/index', '0', '', '前台用户管理', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('127', '新增前台权限分组', '126', '0', 'AuthFront/createGroup', '0', '创建新的前台用户组', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('128', '编辑', '126', '0', 'AuthFront/editGroup', '0', '编辑前台用户组名称和描述', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('129', '用户行为', '124', '0', 'Users/action', '0', '', '行为管理', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('130', '新增用户行为', '124', '0', 'Users/addaction', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('131', '编辑用户行为', '124', '0', 'Users/editaction', '0', '', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('132', '保存用户行为', '124', '0', 'Users/saveAction', '0', '\"用户->用户行为\"保存编辑和新增的用户行为', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('133', '变更行为状态', '124', '0', 'Users/setStatus', '0', '\"用户->用户行为\"中的启用,禁用和删除权限', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('134', '禁用会员', '124', '0', 'Users/changeStatus?method=forbidUser', '0', '\"用户->用户信息\"中的禁用', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('135', '启用会员', '124', '0', 'Users/changeStatus?method=resumeUser', '0', '\"用户->用户信息\"中的启用', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('136', '删除会员', '124', '0', 'Users/changeStatus?method=deleteUser', '0', '\"用户->用户信息\"中的删除', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('137', '删除', '126', '0', 'AuthFront/changeStatus?method=deleteGroup', '0', '删除用户组', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('138', '禁用', '126', '0', 'AuthFront/changeStatus?method=forbidGroup', '0', '禁用用户组', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('139', '恢复', '126', '0', 'AuthFront/changeStatus?method=resumeGroup', '0', '恢复已禁用的用户组', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('140', '保存用户组', '126', '0', 'AuthFront/writeGroup', '0', '新增和编辑用户组的\"保存\"按钮', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('141', '授权', '126', '0', 'AuthFront/group', '0', '\"后台 \\ 用户 \\ 用户信息\"列表页的\"授权\"操作按钮,用于设置用户所属用户组', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('142', '访问授权', '126', '0', 'AuthFront/access', '0', '\"后台 \\ 用户 \\ 权限管理\"列表页的\"访问授权\"操作按钮', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('145', '保存成员授权', '126', '0', 'AuthFront/addToGroup', '0', '\"用户信息\"列表页\"授权\"时的\"保存\"按钮和\"成员授权\"里右上角的\"添加\"按钮)', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('146', '分类授权', '126', '0', 'AuthFront/category', '0', '\"后台 \\ 用户 \\ 权限管理\"列表页的\"分类授权\"操作按钮', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('147', '保存分类授权', '126', '0', 'AuthFront/addToCategory', '0', '\"分类授权\"页面的\"保存\"按钮', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('148', '模型授权', '126', '0', 'AuthFront/modelauth', '0', '\"后台 \\ 用户 \\ 权限管理\"列表页的\"模型授权\"操作按钮', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('149', '保存模型授权', '126', '0', 'AuthFront/addToModel', '0', '\"分类授权\"页面的\"保存\"按钮', '', '0', '1', 'admin');
INSERT INTO `tu_menu` VALUES ('150', '个人中心', '0', '8', 'Member/index', '0', '前台个人中心权限', '', '0', '1', 'home');
INSERT INTO `tu_menu` VALUES ('151', '上传头像', '150', '0', 'Member/auto', '0', 'ceshi', '', '0', '1', 'home');
INSERT INTO `tu_menu` VALUES ('152', 'ceshi', '151', '0', 'Member/autos', '0', '', '', '0', '1', 'home');
INSERT INTO `tu_menu` VALUES ('153', '定制订单列表', '2', '0', 'Custom/index', '0', '定制订单管理', '订单管理', '0', '1', 'admin');

-- ----------------------------
-- Table structure for tu_message_sender
-- ----------------------------
DROP TABLE IF EXISTS `tu_message_sender`;
CREATE TABLE `tu_message_sender` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `from_uid` int(11) NOT NULL COMMENT '发信人',
  `from_username` varchar(32) NOT NULL COMMENT '发信人用户名',
  `title` varchar(200) NOT NULL COMMENT '信息标题',
  `content` text NOT NULL COMMENT '信息内容',
  `from_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '发信人是否删除 1:是0:否',
  `date` int(10) NOT NULL COMMENT '发送日期',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='用户站内信';

-- ----------------------------
-- Records of tu_message_sender
-- ----------------------------
INSERT INTO `tu_message_sender` VALUES ('4', '1', 'admin', '官方客服', '尊敬的用户:admin，您的订单编号为:11111111111的项目合同已上传，请尽快确认！', '0', '1451475405');
INSERT INTO `tu_message_sender` VALUES ('5', '1', 'admin', '官方客服', '尊敬的用户:admin，您的订单编号为:11111111111的项目合同已上传，请尽快确认！', '0', '1451480549');
INSERT INTO `tu_message_sender` VALUES ('6', '1', 'admin', '官方客服', '尊敬的用户:admin，您的订单编号为:11111111111的项目合同已上传，请尽快确认！', '0', '1451480777');
INSERT INTO `tu_message_sender` VALUES ('7', '1', 'admin', '官方客服', '尊敬的用户:，您的订单编号为:的项目已制作完成，请尽快确认！', '0', '1451547788');
INSERT INTO `tu_message_sender` VALUES ('8', '1', 'admin', '官方客服', '尊敬的用户:ceshi，您的订单编号为:11111111111的项目已制作完成，请尽快确认！', '0', '1451547968');
INSERT INTO `tu_message_sender` VALUES ('9', '1', 'admin', '官方客服', '尊敬的用户:ceshi，您的订单编号为:11111111111的项目合同已上传，请尽快确认！', '0', '1451553987');

-- ----------------------------
-- Table structure for tu_model
-- ----------------------------
DROP TABLE IF EXISTS `tu_model`;
CREATE TABLE `tu_model` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '模型ID',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '模型标识',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '模型名称',
  `extend` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '继承的模型',
  `relation` varchar(30) NOT NULL DEFAULT '' COMMENT '继承与被继承模型的关联字段',
  `need_pk` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '新建表时是否需要主键字段',
  `field_sort` text COMMENT '表单字段排序',
  `field_group` varchar(255) NOT NULL DEFAULT '1:基础' COMMENT '字段分组',
  `attribute_list` text COMMENT '属性列表（表的字段）',
  `attribute_alias` varchar(255) NOT NULL DEFAULT '' COMMENT '属性别名定义',
  `template_list` varchar(100) NOT NULL DEFAULT '' COMMENT '列表模板',
  `template_add` varchar(100) NOT NULL DEFAULT '' COMMENT '新增模板',
  `template_edit` varchar(100) NOT NULL DEFAULT '' COMMENT '编辑模板',
  `list_grid` text COMMENT '列表定义',
  `list_row` smallint(2) unsigned NOT NULL DEFAULT '10' COMMENT '列表数据长度',
  `search_key` varchar(50) NOT NULL DEFAULT '' COMMENT '默认搜索字段',
  `search_list` varchar(255) NOT NULL DEFAULT '' COMMENT '高级搜索的字段',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `engine_type` varchar(25) NOT NULL DEFAULT 'MyISAM' COMMENT '数据库引擎',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='文档模型表';

-- ----------------------------
-- Records of tu_model
-- ----------------------------
INSERT INTO `tu_model` VALUES ('1', 'document', '基础文档', '0', '', '1', '{\"1\":[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\"]}', '1:基础', '', '', '', '', '', 'id:编号\r\ntitle:标题:[EDIT]\r\ntype:类型\r\nupdate_time:最后更新\r\nstatus:状态\r\nview:浏览\r\nid:操作:[EDIT]|编辑,[DELETE]|删除', '0', '', '', '1383891233', '1384507827', '1', 'MyISAM');
INSERT INTO `tu_model` VALUES ('2', 'article', '文章', '1', '', '1', '{\"1\":[\"3\",\"24\",\"2\",\"5\"],\"2\":[\"9\",\"13\",\"19\",\"10\",\"12\",\"16\",\"17\",\"26\",\"20\",\"14\",\"11\",\"25\"]}', '1:基础,2:扩展', '', '', '', '', '', '', '0', '', '', '1383891243', '1387260622', '1', 'MyISAM');
INSERT INTO `tu_model` VALUES ('3', 'download', '下载', '1', '', '1', '{\"1\":[\"3\",\"28\",\"30\",\"32\",\"2\",\"5\",\"31\"],\"2\":[\"13\",\"10\",\"27\",\"9\",\"12\",\"16\",\"17\",\"19\",\"11\",\"20\",\"14\",\"29\"]}', '1:基础,2:扩展', '', '', '', '', '', '', '0', '', '', '1383891252', '1387260449', '1', 'MyISAM');

-- ----------------------------
-- Table structure for tu_picture
-- ----------------------------
DROP TABLE IF EXISTS `tu_picture`;
CREATE TABLE `tu_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id自增',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片链接',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_picture
-- ----------------------------
INSERT INTO `tu_picture` VALUES ('1', '/Uploads/Picture/2015-12-22/56792a7db5841.jpg', '', 'eba794c2f1b7b8bcf74aa09182da97e5', '1023e8981c54658a6317d25dd61203a11363490b', '1', '1450781309');
INSERT INTO `tu_picture` VALUES ('2', '/Uploads/Picture/2015-12-22/56792f300db27.jpg', '', '3bc18cb77385a742f92a35a5c75d085c', '5a02d858afb0530631c6347d6046f562d271ee1d', '1', '1450782511');
INSERT INTO `tu_picture` VALUES ('3', '/Uploads/Picture/2015-12-23/567a6aaf0edd7.jpg', '', 'e8745a31b25fa1095a7639f7ffcb5685', 'f3a456fdd171a369224c1430e2c3738cccbd2d52', '1', '1450863278');
INSERT INTO `tu_picture` VALUES ('4', '/Uploads/Picture/2015-12-24/567bcec3ac0b5.jpg', '', 'da9ccf648544c44a945d6ffd02869615', '96b04e52725d354e51fd4f3682a594d0c8f85383', '1', '1450954435');
INSERT INTO `tu_picture` VALUES ('5', '/Uploads/Picture/2015-12-25/567cb7af71edb.jpg', '', '7240d35b2eebf7588904729f8bb81ff5', 'b841cbe40f437b2fdfa0c20246dd58610f14d1c0', '1', '1451014063');
INSERT INTO `tu_picture` VALUES ('6', '/Uploads/Picture/2015-12-25/567cb7d446591.png', '', '4ec05c28213fdcefc895c4c3b849576e', '802d8e192d88aefd33ddd4ede2ca5bfbb95fadd9', '1', '1451014100');

-- ----------------------------
-- Table structure for tu_silder
-- ----------------------------
DROP TABLE IF EXISTS `tu_silder`;
CREATE TABLE `tu_silder` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `title` varchar(30) NOT NULL COMMENT '标题',
  `silderpic` int(11) NOT NULL COMMENT '图片ID',
  `sildertext` varchar(255) NOT NULL DEFAULT ' ' COMMENT '图片描述',
  `jumplink` varchar(255) NOT NULL DEFAULT ' ' COMMENT '跳转链接',
  `jumptype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '跳转方式（ 1:当前页 2:新标签）',
  `priorityr` tinyint(1) NOT NULL DEFAULT '0' COMMENT '优先级（0-9）',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态（0：禁用，1：正常 -1：删除）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Silder插件-数据库';

-- ----------------------------
-- Records of tu_silder
-- ----------------------------
INSERT INTO `tu_silder` VALUES ('1', 'ceshi', '1', '测试轮播', 'http://www.baidu.com', '1', '0', '1');
INSERT INTO `tu_silder` VALUES ('2', 'ceshi1', '2', 'ceshi1', 'http://www.baidu.com', '1', '1', '1');
INSERT INTO `tu_silder` VALUES ('3', '测试颜色', '3', '测试颜色', 'http:/www.baidu.com', '1', '0', '1');

-- ----------------------------
-- Table structure for tu_timeline
-- ----------------------------
DROP TABLE IF EXISTS `tu_timeline`;
CREATE TABLE `tu_timeline` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `date` varchar(22) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `link` varchar(255) NOT NULL DEFAULT 'Jay' COMMENT '链接',
  `source` varchar(255) NOT NULL DEFAULT '' COMMENT '来源',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_timeline
-- ----------------------------
INSERT INTO `tu_timeline` VALUES ('1', '测试', '2015-12-23 15:19:08', 'http://baidu.com', '百度');
INSERT INTO `tu_timeline` VALUES ('2', '测试一下', '2015-12-31 11:20:05', 'http://sana.com', '新浪');
INSERT INTO `tu_timeline` VALUES ('3', '测试', '2015-12-31 11:20:05', 'http://tianya.com', '天涯小说');
INSERT INTO `tu_timeline` VALUES ('4', '乐视电视', '2015-12-31 11:20:05', 'http://leshi.com', '乐视');

-- ----------------------------
-- Table structure for tu_ucenter_admin
-- ----------------------------
DROP TABLE IF EXISTS `tu_ucenter_admin`;
CREATE TABLE `tu_ucenter_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员用户ID',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '管理员状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of tu_ucenter_admin
-- ----------------------------

-- ----------------------------
-- Table structure for tu_ucenter_app
-- ----------------------------
DROP TABLE IF EXISTS `tu_ucenter_app`;
CREATE TABLE `tu_ucenter_app` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '应用ID',
  `title` varchar(30) NOT NULL COMMENT '应用名称',
  `url` varchar(100) NOT NULL COMMENT '应用URL',
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '应用IP',
  `auth_key` varchar(100) NOT NULL DEFAULT '' COMMENT '加密KEY',
  `sys_login` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '同步登陆',
  `allow_ip` varchar(255) NOT NULL DEFAULT '' COMMENT '允许访问的IP',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '应用状态',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='应用表';

-- ----------------------------
-- Records of tu_ucenter_app
-- ----------------------------

-- ----------------------------
-- Table structure for tu_ucenter_member
-- ----------------------------
DROP TABLE IF EXISTS `tu_ucenter_member`;
CREATE TABLE `tu_ucenter_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` char(16) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `email` char(32) NOT NULL COMMENT '用户邮箱',
  `mobile` char(15) NOT NULL DEFAULT '' COMMENT '用户手机',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `reg_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) DEFAULT '0' COMMENT '用户状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of tu_ucenter_member
-- ----------------------------
INSERT INTO `tu_ucenter_member` VALUES ('1', 'admin', '76004c336ac1ad1e3e3bd1c3a1d29d15', 'admin@qq.com', '', '1450409053', '0', '1451466811', '2130706433', '1450409053', '1');
INSERT INTO `tu_ucenter_member` VALUES ('2', 'ceshi', 'df2125f12d69a8e1872025446a2d5609', 'ceshi@qq.com', '', '1450681101', '0', '1450680615', '0', '1450681101', '1');
INSERT INTO `tu_ucenter_member` VALUES ('3', 'ceshi1', 'e7da8fd8095d73617bc720881e4e087e', 'ceshi1@qq.com', '', '1450681179', '0', '0', '0', '1450681179', '1');

-- ----------------------------
-- Table structure for tu_ucenter_setting
-- ----------------------------
DROP TABLE IF EXISTS `tu_ucenter_setting`;
CREATE TABLE `tu_ucenter_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '设置ID',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型（1-用户配置）',
  `value` text NOT NULL COMMENT '配置数据',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='设置表';

-- ----------------------------
-- Records of tu_ucenter_setting
-- ----------------------------

-- ----------------------------
-- Table structure for tu_upload_model
-- ----------------------------
DROP TABLE IF EXISTS `tu_upload_model`;
CREATE TABLE `tu_upload_model` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT COMMENT '上传模型作品表 id',
  `uid` int(11) NOT NULL COMMENT '上传作品的用户id',
  `title` varchar(80) DEFAULT NULL COMMENT '模型的标题',
  `instruct` varchar(80) DEFAULT NULL COMMENT '模型的简介',
  `covers` varchar(80) DEFAULT NULL COMMENT '作品封面',
  `tags` varchar(50) DEFAULT NULL COMMENT '标签',
  `price` int(10) DEFAULT '0' COMMENT '标价',
  `praise` int(12) DEFAULT '0' COMMENT '点赞',
  `material` int(2) NOT NULL DEFAULT '5' COMMENT '用途（5：模型，0：其它）',
  `created` int(12) DEFAULT NULL COMMENT '创建时间',
  `update` int(12) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_upload_model
-- ----------------------------
INSERT INTO `tu_upload_model` VALUES ('1', '22', '漂亮', '这是一辆漂亮美丽时尚高端上档次的高级轿车,买不了吃亏,买不了上当', 'findimg.png', '模型', '1200', '100', '5', '1', '1');
INSERT INTO `tu_upload_model` VALUES ('2', '23', '漂亮', '这是一辆漂亮美丽时尚高端上档次的高级轿车,买不了吃亏,买不了上当', 'findimg.png', '模型', '1800', '200', '5', '4', '4');
INSERT INTO `tu_upload_model` VALUES ('3', '22', '漂亮', '这是一辆漂亮美丽时尚高端上档次的高级轿车,买不了吃亏,买不了上当', 'findimg.png', '模型', '1200', '300', '5', '7', '7');
INSERT INTO `tu_upload_model` VALUES ('4', '22', '漂亮', '这是一辆漂亮美丽时尚高端上档次的高级轿车,买不了吃亏,买不了上当', 'findimg.png', '模型', '1200', '400', '5', '10', '10');
INSERT INTO `tu_upload_model` VALUES ('5', '22', '漂亮', '这是一辆漂亮美丽时尚高端上档次的高级轿车,买不了吃亏,买不了上当', 'findimg.png', '模型', '1200', '500', '5', '13', '13');
INSERT INTO `tu_upload_model` VALUES ('6', '22', '漂亮', '这是一辆漂亮美丽时尚高端上档次的高级轿车,买不了吃亏,买不了上当', 'findimg.png', '模型', '1200', '600', '5', '16', '16');
INSERT INTO `tu_upload_model` VALUES ('7', '22', '漂亮', '这是一辆漂亮美丽时尚高端上档次的高级轿车,买不了吃亏,买不了上当', 'findimg.png', '模型', '1200', '700', '0', '19', '19');

-- ----------------------------
-- Table structure for tu_upload_pic
-- ----------------------------
DROP TABLE IF EXISTS `tu_upload_pic`;
CREATE TABLE `tu_upload_pic` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT COMMENT '上传模型作品表 id',
  `uid` int(11) NOT NULL COMMENT '上传作品的用户id',
  `covers` varchar(80) DEFAULT NULL COMMENT '作品封面',
  `tags` varchar(50) DEFAULT NULL COMMENT '标签',
  `price` int(10) DEFAULT '0' COMMENT '标价',
  `praise` int(12) DEFAULT '0' COMMENT '点赞',
  `material` mediumint(2) NOT NULL DEFAULT '1' COMMENT '图片用途（1：成品广告图，2：背景图素材）',
  `created` int(12) DEFAULT NULL COMMENT '创建时间',
  `update` int(12) DEFAULT NULL COMMENT '更新时间',
  `title` varchar(80) DEFAULT NULL COMMENT '图片标题',
  `instruct` varchar(80) DEFAULT NULL COMMENT '图片介绍',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
-- Records of tu_upload_pic
-- ----------------------------
INSERT INTO `tu_upload_pic` VALUES ('1', '22', 'findimg2.jpg', '图片', '1200', '100', '1', '2', '2', '你是车吗', '这么好的车是在哪里买的啊,大家好才是真的好');
INSERT INTO `tu_upload_pic` VALUES ('2', '22', 'findimg2.jpg', '图片', '1200', '200', '1', '5', '5', '你是车吗', '这么好的车是在哪里买的啊,大家好才是真的好');
INSERT INTO `tu_upload_pic` VALUES ('3', '22', 'findimg2.jpg', '图片', '1200', '300', '2', '8', '8', '你是车吗', '这么好的车是在哪里买的啊,大家好才是真的好');
INSERT INTO `tu_upload_pic` VALUES ('4', '22', 'findimg2.jpg', '图片', '1200', '400', '1', '11', '11', '你是车吗', '这么好的车是在哪里买的啊,大家好才是真的好');
INSERT INTO `tu_upload_pic` VALUES ('5', '22', 'findimg2.jpg', '图片', '1200', '500', '2', '14', '14', '你是车吗', '这么好的车是在哪里买的啊,大家好才是真的好');
INSERT INTO `tu_upload_pic` VALUES ('6', '22', 'findimg2.jpg', '图片', '1200', '600', '1', '17', '17', '你是车吗', '这么好的车是在哪里买的啊,大家好才是真的好');
INSERT INTO `tu_upload_pic` VALUES ('7', '22', 'findimg2.jpg', '图片', '1200', '700', '1', '20', '20', '你是车吗', '这么好的车是在哪里买的啊,大家好才是真的好');

-- ----------------------------
-- Table structure for tu_upload_video
-- ----------------------------
DROP TABLE IF EXISTS `tu_upload_video`;
CREATE TABLE `tu_upload_video` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT COMMENT '上传模型作品表 id',
  `uid` int(11) NOT NULL COMMENT '上传作品的用户id',
  `title` varchar(80) DEFAULT NULL COMMENT '视频标题',
  `instruct` varchar(80) DEFAULT NULL COMMENT '视频简介',
  `covers` varchar(80) DEFAULT NULL COMMENT '作品封面',
  `tags` varchar(50) DEFAULT NULL COMMENT '标签',
  `price` int(10) DEFAULT '0' COMMENT '标价',
  `praise` int(12) DEFAULT '0' COMMENT '点赞',
  `material` mediumint(2) NOT NULL DEFAULT '3' COMMENT '用途（3：视频，0：其它）',
  `created` int(12) DEFAULT NULL COMMENT '创建时间',
  `update` int(12) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
-- Records of tu_upload_video
-- ----------------------------
INSERT INTO `tu_upload_video` VALUES ('1', '22', '视频吧', '我是视屏车来看看我吧', 'findimg3.jpg', '视频', '1200', '100', '3', '3', '3');
INSERT INTO `tu_upload_video` VALUES ('2', '22', '视频吧', '我是视屏车来看看我吧', 'findimg3.jpg', '视频', '1200', '200', '3', '6', '6');
INSERT INTO `tu_upload_video` VALUES ('3', '22', '视频吧', '我是视屏车来看看我吧', 'findimg3.jpg', '视频', '1200', '300', '3', '9', '9');
INSERT INTO `tu_upload_video` VALUES ('4', '22', '视频吧', '我是视屏车来看看我吧', 'findimg3.jpg', '视频', '1200', '400', '3', '12', '12');
INSERT INTO `tu_upload_video` VALUES ('5', '22', '视频吧', '我是视屏车来看看我吧', 'findimg3.jpg', '视频', '1200', '500', '3', '15', '15');
INSERT INTO `tu_upload_video` VALUES ('6', '22', '视频吧', '我是视屏车来看看我吧', 'findimg3.jpg', '视频', '1200', '600', '3', '18', '18');
INSERT INTO `tu_upload_video` VALUES ('7', '22', '视频吧', '我是视屏车来看看我吧', 'findimg3.jpg', '视频', '1200', '700', '3', '21', '21');

-- ----------------------------
-- Table structure for tu_url
-- ----------------------------
DROP TABLE IF EXISTS `tu_url`;
CREATE TABLE `tu_url` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '链接唯一标识',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `short` char(100) NOT NULL DEFAULT '' COMMENT '短网址',
  `status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_url` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='链接表';

-- ----------------------------
-- Records of tu_url
-- ----------------------------

-- ----------------------------
-- Table structure for tu_user
-- ----------------------------
DROP TABLE IF EXISTS `tu_user`;
CREATE TABLE `tu_user` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT '' COMMENT '用户登录名',
  `realname` varchar(20) DEFAULT '' COMMENT '用户真实姓名',
  `password` varchar(32) DEFAULT '' COMMENT '登录密码md5',
  `phone` varchar(20) DEFAULT NULL COMMENT '手机号码',
  `tel` varchar(20) DEFAULT NULL COMMENT '固定电话或其它',
  `email` varchar(50) DEFAULT NULL COMMENT '电子邮箱',
  `gender` tinyint(1) DEFAULT '1' COMMENT '性别：1男，0女',
  `age` tinyint(3) unsigned DEFAULT NULL COMMENT '年龄',
  `last_login` int(10) DEFAULT NULL COMMENT '最后登录时间',
  `last_ip` varchar(15) DEFAULT NULL COMMENT '最后登录IP',
  `ip` varchar(15) DEFAULT NULL COMMENT '注册IP',
  `created` int(10) DEFAULT NULL COMMENT '注册时间',
  `updated` int(10) DEFAULT NULL COMMENT '信息修改时间',
  `user_type` int(10) NOT NULL DEFAULT '1' COMMENT '用户类型 1:厂商 2:厂商代理 3:设计师 4:图片公司',
  PRIMARY KEY (`uid`),
  KEY `username` (`username`),
  KEY `email` (`email`),
  KEY `phone` (`phone`),
  KEY `password` (`password`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_user
-- ----------------------------
INSERT INTO `tu_user` VALUES ('22', 'ceshi', 'ceshi', 'dfc50f50974cb2de4a7be68d177efe14', null, null, '1369071016@qq.com', '1', null, null, null, '2130706433', '1450855185', '1450855185', '3');
INSERT INTO `tu_user` VALUES ('23', 'qin', 'ceshi1', '25f9e794323b453885f5181f1b624d0b', null, null, 'ceshi1@qq.com', '1', null, null, null, '2130706433', '1450845675', '1450845675', '2');
INSERT INTO `tu_user` VALUES ('24', 'sddfs', 'dfdsf', 'dfdsf', 'df', null, 'dfsdf', '1', null, null, null, null, null, null, '0');
INSERT INTO `tu_user` VALUES ('25', 'dsfds', '', 'd58e3582afa99040e27b92b13c8f2280', null, null, 'dsfds', '1', null, null, null, null, null, null, '3');
INSERT INTO `tu_user` VALUES ('26', 'ddd', '', '77963b7a931377ad4ab5ad6a9cd718aa', null, null, 'ddd', '1', null, null, null, null, null, null, '3');
INSERT INTO `tu_user` VALUES ('27', 'nn', '', 'a1931ec126bbad3fa7a3fc64209fd921', null, null, 'nn', '1', null, null, null, null, null, null, '3');
INSERT INTO `tu_user` VALUES ('28', 'zhangjinwei', '', '166b1abae4e25ea8647ed0974b09da73', null, null, 'zhangjinwei', '1', null, null, null, null, null, null, '3');
INSERT INTO `tu_user` VALUES ('29', 'edfddf', '', 'b52c96bea30646abf8170f333bbd42b9', null, null, 'edfddf', '1', null, null, null, null, null, null, '3');
INSERT INTO `tu_user` VALUES ('30', 'wangpeng', '', 'fcea920f7412b5da7be0cf42b8c93759', null, null, 'wangpeng', '1', null, null, null, null, null, null, '3');
INSERT INTO `tu_user` VALUES ('31', '76987978', '', 'fcea920f7412b5da7be0cf42b8c93759', null, null, '76987978', '1', null, null, null, null, null, null, '2');
INSERT INTO `tu_user` VALUES ('32', '2312323', '', 'c36ab251470a365552a735b38d0af8f7', null, null, '2312323', '1', null, null, null, null, null, null, '3');
INSERT INTO `tu_user` VALUES ('33', 'Garfield', '', 'fcea920f7412b5da7be0cf42b8c93759', null, null, 'Garfield', '1', null, null, null, null, null, null, '2');
INSERT INTO `tu_user` VALUES ('34', 'wqww', '', 'c36ab251470a365552a735b38d0af8f7', null, null, 'wqww', '1', null, null, null, null, null, null, '3');
INSERT INTO `tu_user` VALUES ('35', 'qqqqqqq', '', 'fcea920f7412b5da7be0cf42b8c93759', null, null, 'qqqqqqq', '1', null, null, null, null, null, null, '3');

-- ----------------------------
-- Table structure for tu_user_info
-- ----------------------------
DROP TABLE IF EXISTS `tu_user_info`;
CREATE TABLE `tu_user_info` (
  `uid` int(11) unsigned NOT NULL,
  `score` int(10) NOT NULL DEFAULT '0' COMMENT '用户积分',
  `popularity` int(10) unsigned NOT NULL COMMENT '人气',
  `focus` int(10) unsigned NOT NULL COMMENT '被关注',
  `profile` varchar(255) DEFAULT '' COMMENT '个人简介',
  `avatar` varchar(80) DEFAULT '' COMMENT '用户头像',
  `banner` varchar(80) DEFAULT NULL COMMENT '个人设计师-头图',
  `img_url` varchar(90) DEFAULT NULL,
  `is_authen` int(10) DEFAULT '0' COMMENT '是否认证（0为否，1为是）',
  `authen_brand` int(10) DEFAULT '-1' COMMENT '已经认证的匹配厂商id',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_user_info
-- ----------------------------
INSERT INTO `tu_user_info` VALUES ('22', '55', '200', '16', '对待工作认真负责，善于沟通、协调有较强的组织能力与团队精神；活泼开朗、乐观上进、有爱心并善于施教并行；上进心强、勤于学习能不断提高自身的能力与综合素质。对待工作认真负责，善于沟通、协调有较强的组织能力与团队精神；活泼开朗、乐观上进、有爱心并善于施教并行；上进心强、勤于学习能不断提高自身的能力与综合素质。', 'persontu.jpg', 'personda.jpg', 'findimg.png', '0', '-1');
INSERT INTO `tu_user_info` VALUES ('23', '10', '0', '0', '性格开朗、思维活跃;拥有年轻人的朝气蓬勃,做事有责任心,条理性强;易与人相处,对工作充满热情,勤奋好学,敢挑重担,具有很强的团队精神和协调能力。告诉大家回复收到回复收复失地凤凰山东方还不是都就凤凰山东方的凤凰山东方黑色的就凤凰山东方发挥地方好地方 返回师傅师傅就是打发时间的方式地方果', '', '123.jpg', '123.jpg', '0', '-1');
INSERT INTO `tu_user_info` VALUES ('24', '0', '0', '0', '', '', null, null, '0', '-1');
INSERT INTO `tu_user_info` VALUES ('25', '0', '0', '0', '', '', null, null, '0', '-1');
INSERT INTO `tu_user_info` VALUES ('26', '0', '0', '0', '', '', null, null, '0', '-1');
INSERT INTO `tu_user_info` VALUES ('27', '0', '0', '0', '', '', null, null, '0', '-1');
INSERT INTO `tu_user_info` VALUES ('28', '0', '0', '0', '', '', null, null, '0', '-1');
INSERT INTO `tu_user_info` VALUES ('29', '0', '0', '0', '', '', null, null, '0', '-1');
INSERT INTO `tu_user_info` VALUES ('30', '0', '0', '0', '', '', null, null, '0', '-1');
INSERT INTO `tu_user_info` VALUES ('31', '0', '0', '0', '', '', null, null, '0', '-1');
INSERT INTO `tu_user_info` VALUES ('32', '0', '0', '0', '', '', null, null, '0', '-1');

-- ----------------------------
-- Table structure for tu_userdata
-- ----------------------------
DROP TABLE IF EXISTS `tu_userdata`;
CREATE TABLE `tu_userdata` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `type` tinyint(3) unsigned NOT NULL COMMENT '类型标识',
  `target_id` int(10) unsigned NOT NULL COMMENT '目标id',
  UNIQUE KEY `uid` (`uid`,`type`,`target_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tu_userdata
-- ----------------------------
