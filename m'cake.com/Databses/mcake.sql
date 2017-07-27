/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : mcake

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2015-09-21 19:25:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for mcake_ad
-- ----------------------------
DROP TABLE IF EXISTS `mcake_ad`;
CREATE TABLE `mcake_ad` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告id',
  `title` varchar(255) NOT NULL COMMENT '广告标题',
  `image` varchar(255) NOT NULL COMMENT '广告图片',
  `adtime` int(12) NOT NULL COMMENT '广告出现的时间',
  `num` int(2) NOT NULL COMMENT '广告出现的次数 1为1次(开启) 0为0次(关闭)',
  `position` varchar(255) NOT NULL COMMENT '广告位置',
  `prompt` int(2) NOT NULL DEFAULT '1' COMMENT '是否开启广告前提示语 1:开启 0:不开启',
  `addtime` varchar(22) NOT NULL COMMENT '广告添加的时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_ad
-- ----------------------------
INSERT INTO `mcake_ad` VALUES ('2', '辛苦了!', '/AdImg/55f836738583b.jpg', '5', '1', 'header', '1', '2015-09-15');
INSERT INTO `mcake_ad` VALUES ('3', '我的兄弟姐妹们', '/AdImg/55f8c815bebc2.jpg', '5', '0', 'left+right', '1', '2015-09-16');

-- ----------------------------
-- Table structure for mcake_address
-- ----------------------------
DROP TABLE IF EXISTS `mcake_address`;
CREATE TABLE `mcake_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户收货地址主要用于前台',
  `uid` int(11) NOT NULL COMMENT '会员id',
  `linkman` varchar(255) NOT NULL COMMENT '联系人',
  `phone` int(11) NOT NULL COMMENT '电话',
  `address` varchar(255) NOT NULL COMMENT '收货地址',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态：0默认：非默认地址；1：非默认地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_address
-- ----------------------------
INSERT INTO `mcake_address` VALUES ('1', '1', '王先生', '2147483647', '北京市昌平区文化西路', '0');
INSERT INTO `mcake_address` VALUES ('2', '1', '李先生', '2147483647', '地址跟王先生一样', '0');
INSERT INTO `mcake_address` VALUES ('3', '1', '张先生', '2147483647', '地址跟李先生一样', '0');
INSERT INTO `mcake_address` VALUES ('4', '1', '赵先生', '2147483647', '地址跟张先生一样', '0');
INSERT INTO `mcake_address` VALUES ('5', '1', '周先生', '1242839889', '地址跟赵先生一样', '0');
INSERT INTO `mcake_address` VALUES ('8', '1', '钱先生', '2147483647', '地址跟周先生一样', '0');
INSERT INTO `mcake_address` VALUES ('9', '1', '吴先生', '2147483647', '地址跟钱先生一样', '0');
INSERT INTO `mcake_address` VALUES ('10', '1', '郑先生', '2147483647', '地址跟吴先生一样', '0');
INSERT INTO `mcake_address` VALUES ('34', '1', '孙先生', '37219732', '地址跟郑先生一样', '0');
INSERT INTO `mcake_address` VALUES ('88', '1', '不告诉你', '347982387', '爱送哪送哪~呵呵~~', '0');
INSERT INTO `mcake_address` VALUES ('158', '126', '小明', '2147483647', '北京昌平', '0');
INSERT INTO `mcake_address` VALUES ('159', '126', '马克玛丽', '2147483647', '额外惹我认为', '0');
INSERT INTO `mcake_address` VALUES ('162', '126', '马克玛丽', '2147483647', '额外惹我认为', '0');
INSERT INTO `mcake_address` VALUES ('163', '126', '小叮当', '12321321', '北京文化西路', '0');
INSERT INTO `mcake_address` VALUES ('164', '126', '叮当', '12321321', '北京文化西路', '0');
INSERT INTO `mcake_address` VALUES ('165', '127', 'a', '0', 'a', '0');
INSERT INTO `mcake_address` VALUES ('166', '127', 'a', '0', 'a', '0');
INSERT INTO `mcake_address` VALUES ('167', '127', 'a', '0', 'a', '0');
INSERT INTO `mcake_address` VALUES ('168', '127', 'a', '0', 'a', '0');
INSERT INTO `mcake_address` VALUES ('169', '127', 'b', '0', 'b', '0');
INSERT INTO `mcake_address` VALUES ('170', '126', '小明同学', '1234567780', '北京市昌平区回龙观文化西葫芦', '0');
INSERT INTO `mcake_address` VALUES ('171', '128', 'laowang', '2147483647', '北京周边', '0');
INSERT INTO `mcake_address` VALUES ('172', '126', '小红', '1324567889', '北京周边', '0');
INSERT INTO `mcake_address` VALUES ('173', '126', 'hdas', '498721398', 'fdahksjd', '0');

-- ----------------------------
-- Table structure for mcake_adv
-- ----------------------------
DROP TABLE IF EXISTS `mcake_adv`;
CREATE TABLE `mcake_adv` (
  `id` int(11) NOT NULL,
  `content` varchar(255) DEFAULT NULL COMMENT '轮播所带字的内容',
  `pic` text COMMENT '轮播所带图片',
  `internal` int(255) DEFAULT NULL COMMENT '可选参数，时间间隔',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_adv
-- ----------------------------

-- ----------------------------
-- Table structure for mcake_anniversaries
-- ----------------------------
DROP TABLE IF EXISTS `mcake_anniversaries`;
CREATE TABLE `mcake_anniversaries` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uid` int(11) NOT NULL COMMENT '用户名',
  `anni_name` varchar(10) NOT NULL COMMENT '纪念日的名字',
  `calendar` tinyint(1) NOT NULL DEFAULT '0' COMMENT '公历 农历',
  `year` int(8) NOT NULL,
  `month` int(3) NOT NULL,
  `day` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_anniversaries
-- ----------------------------
INSERT INTO `mcake_anniversaries` VALUES ('11', '2', '生日', '0', '1996', '9', '6');
INSERT INTO `mcake_anniversaries` VALUES ('12', '2', '旅游日', '0', '2015', '1', '1');
INSERT INTO `mcake_anniversaries` VALUES ('13', '128', '生日', '1', '1996', '5', '9');

-- ----------------------------
-- Table structure for mcake_article
-- ----------------------------
DROP TABLE IF EXISTS `mcake_article`;
CREATE TABLE `mcake_article` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章id',
  `title` varchar(255) NOT NULL COMMENT '文章标题',
  `type` varchar(255) NOT NULL COMMENT '文章所属类型',
  `content` text NOT NULL COMMENT '文章内容',
  `author` varchar(32) NOT NULL COMMENT '用户名_作者',
  `addtime` varchar(32) NOT NULL COMMENT '添加时间',
  `image` varchar(255) NOT NULL COMMENT '文章配图',
  `read_num` int(16) unsigned NOT NULL COMMENT '阅读量',
  `derivation` varchar(32) NOT NULL COMMENT '文章的出处',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_article
-- ----------------------------
INSERT INTO `mcake_article` VALUES ('1', '“奔跑吧市场人”', '媒体合作', '1月24日下午，一场名为“奔跑吧市场人”2015年度回馈盛宴在徐汇区天平宾馆隆重上演，来自全国各地各行业的市场精英齐聚一堂。作为主办方市场部的长 期合作伙伴，Mcake精心准备了定制款拿破仑莓恋蛋糕，一出场便引发合照“风波”，随后全场嘉宾一起分享了代表甜蜜与浪漫的莓恋蛋糕。', '刘小溜', '2015-01-24', '/Uploads/Admin/images/ArticleImg/55f05e501312d.jpg', '0', '公司文化部');
INSERT INTO `mcake_article` VALUES ('2', '女人节', '媒体合作', '3月8日女人节，Mcake联合永安百货倾心举办了一场精彩纷呈的女性主题活动。令女士们全场追逐的是由外国鲜肉亲手派送的Mcake经典款-蓝莓轻乳拿破仑蛋糕，天然优质口感愿女士们颜若桃花。虽然天公不作美，可依然无法阻挡一颗颗追求美丽拥抱甜蜜的心。', '刘小溜', '2015-03-08', '/Uploads/Admin/images/ArticleImg/55f05ec07de29.jpg', '0', '公司文化部');
INSERT INTO `mcake_article` VALUES ('3', '喜剧电影《菜鸟》上海影迷见面会', '媒体合作', '3月26日晚，喜剧电影《菜鸟》上海影迷见面会在近铁城市广场成龙影院爆笑登场，导演项华祥携柯有伦、崔允素等剧中主创齐齐亮相。作为影院的老朋 友，Mcake为电影贴心准备了定制款拿破仑莓恋蛋糕，鲜美欲滴酥脆浓郁的蛋糕让主演们赞誉有加，大刷好评，小M心里乐翻天，预祝菜鸟高飞票房大卖！', '王小步', '2015-03-26', '/Uploads/Admin/images/ArticleImg/55f05f070b71b.jpg', '0', '公司文化部');
INSERT INTO `mcake_article` VALUES ('4', '助阵TINA GIA 2015秋冬上海时装周发布会', '媒体合作', '4月10日，Mcake携定制款拿破仑莓恋蛋糕助阵TINA GIA 2015秋冬上海时装周发布会，国际超模佟晨洁惊艳亮相。高颜值超美味的莓恋蛋糕让来宾在视觉味觉双重盛宴中感受最In时尚体验。', '王小步', '2015-04-10', '/Uploads/Admin/images/ArticleImg/55f05f780b71b.jpg', '0', '公司文化部');
INSERT INTO `mcake_article` VALUES ('5', 'TINA&amp;GIA订货会', '媒体合作', ' 4月11-12日，TINA&amp;GIA订货会 ，Mcake给力赞助的蓝莓轻乳拿破仑、法香奶油可丽等三款蛋糕更是让潮人们惊喜连连', '王小步', '2015-04-12', '/Uploads/Admin/images/ArticleImg/55f05fb90b71b.jpg', '0', '公司文化部');
INSERT INTO `mcake_article` VALUES ('6', '青年导演白皓天先生的“MR.BIG BIRTHDAY NIGHTS ” 私人生日派对', '媒体合作', '4月21日晚，青年导演白皓天先生的“MR.BIG BIRTHDAY NIGHTS ” 私人生日派对在黄浦区老码头创意园区温馨上演。作为指定赞助品牌，Mcake为演艺界的朋友们带来了集“美貌”与口感为一身的拿破仑莓恋蛋糕。据悉白导的最新力作《完美世界》正紧锣密鼓的开演中。', '苏小蔓', '2015-04-21', '/Uploads/Admin/images/ArticleImg/55f06045bebc2.jpg', '0', '公司文化部');
INSERT INTO `mcake_article` VALUES ('7', '上海国际电影节', '媒体合作', '适逢上海国际电影节一年一度的盛会，由北京某投资公司主办的“飞行之夜”主题酒会于16晚在LinxClub举行，多家影视界和金融界权威人士及20余家 主流媒体共同出席。作为指定赞助商，Mcake为本次盛会带来定制款蓝莓轻乳拿破仑、卡法香缇和阳光心芒三款蛋糕，让来自法兰西的经典美味在这个星光之夜 漫延。', '苏小蔓', '2015-06-16', '/Uploads/Admin/images/ArticleImg/55f0606f1e848.jpg', '0', '公司文化部');
INSERT INTO `mcake_article` VALUES ('52', '“奔跑吧市场人”', '媒体合作', '1月24日下午，一场名为“奔跑吧市场人”2015年度回馈盛宴在徐汇区天平宾馆隆重上演，来自全国各地各行业的市场精英齐聚一堂。作为主办方市场部的长 期合作伙伴，Mcake精心准备了定制款拿破仑莓恋蛋糕，一出场便引发合照“风波”，随后全场嘉宾一起分享了代表甜蜜与浪漫的莓恋蛋糕。', '刘小溜', '2015-06-24', '/Uploads/Admin/images/ArticleImg/55f05e501312d.jpg', '0', '公司文化部');
INSERT INTO `mcake_article` VALUES ('53', '女人节', '媒体合作', '3月8日女人节，Mcake联合永安百货倾心举办了一场精彩纷呈的女性主题活动。令女士们全场追逐的是由外国鲜肉亲手派送的Mcake经典款-蓝莓轻乳拿破仑蛋糕，天然优质口感愿女士们颜若桃花。虽然天公不作美，可依然无法阻挡一颗颗追求美丽拥抱甜蜜的心。', '刘小溜', '2015-07-08', '/Uploads/Admin/images/ArticleImg/55f05ec07de29.jpg', '0', '公司文化部');
INSERT INTO `mcake_article` VALUES ('54', '喜剧电影《菜鸟》上海影迷见面会', '媒体合作', '3月26日晚，喜剧电影《菜鸟》上海影迷见面会在近铁城市广场成龙影院爆笑登场，导演项华祥携柯有伦、崔允素等剧中主创齐齐亮相。作为影院的老朋 友，Mcake为电影贴心准备了定制款拿破仑莓恋蛋糕，鲜美欲滴酥脆浓郁的蛋糕让主演们赞誉有加，大刷好评，小M心里乐翻天，预祝菜鸟高飞票房大卖！', '王小步', '2015-06-26', '/Uploads/Admin/images/ArticleImg/55f05f070b71b.jpg', '0', '公司文化部');
INSERT INTO `mcake_article` VALUES ('55', '助阵TINA GIA 2015秋冬上海时装周发布会', '媒体合作', '4月10日，Mcake携定制款拿破仑莓恋蛋糕助阵TINA GIA 2015秋冬上海时装周发布会，国际超模佟晨洁惊艳亮相。高颜值超美味的莓恋蛋糕让来宾在视觉味觉双重盛宴中感受最In时尚体验。', '王小步', '2015-07-10', '/Uploads/Admin/images/ArticleImg/55f05f780b71b.jpg', '0', '公司文化部');
INSERT INTO `mcake_article` VALUES ('56', 'TINA&amp;GIA订货会', '媒体合作', ' 4月11-12日，TINA&amp;GIA订货会 ，Mcake给力赞助的蓝莓轻乳拿破仑、法香奶油可丽等三款蛋糕更是让潮人们惊喜连连', '王小步', '2015-07-12', '/Uploads/Admin/images/ArticleImg/55f05fb90b71b.jpg', '0', '公司文化部');
INSERT INTO `mcake_article` VALUES ('57', '青年导演白皓天先生的“MR.BIG BIRTHDAY NIGHTS ” 私人生日派对', '媒体合作', '4月21日晚，青年导演白皓天先生的“MR.BIG BIRTHDAY NIGHTS ” 私人生日派对在黄浦区老码头创意园区温馨上演。作为指定赞助品牌，Mcake为演艺界的朋友们带来了集“美貌”与口感为一身的拿破仑莓恋蛋糕。据悉白导的最新力作《完美世界》正紧锣密鼓的开演中。', '苏小蔓', '2015-08-21', '/Uploads/Admin/images/ArticleImg/55f06045bebc2.jpg', '0', '公司文化部');
INSERT INTO `mcake_article` VALUES ('58', '上海国际电影节', '媒体合作', '适逢上海国际电影节一年一度的盛会，由北京某投资公司主办的“飞行之夜”主题酒会于16晚在LinxClub举行，多家影视界和金融界权威人士及20余家 主流媒体共同出席。作为指定赞助商，Mcake为本次盛会带来定制款蓝莓轻乳拿破仑、卡法香缇和阳光心芒三款蛋糕，让来自法兰西的经典美味在这个星光之夜 漫延。', '苏小蔓', '2015-09-16', '/Uploads/Admin/images/ArticleImg/55f0606f1e848.jpg', '0', '公司文化部');
INSERT INTO `mcake_article` VALUES ('59', '移动端APP开发工程师', '招贤纳士', ' 【岗位职责】\r\n\r\n1.   负责在移动端平台下的应用程序设计、开发、发布和维护；\r\n\r\n2.   负责移动端平台项目的架构设计、方案的制定；\r\n\r\n3.   跟进移动端平台的新技术发展，编写设计开发及实现文档；\r\n\r\n4.   优化移动产品的质量、性能及用户体验。\r\n\r\n \r\n\r\n【任职要求】\r\n\r\n1.   本科以上学历，3年以上互联网从业经验，精通手机客户端开发平台，至少2年以上的实际iPhone及Android平台开发经验；\r\n\r\n2.   具有电商类产品App store上线应用经验者优先；\r\n\r\n3.   精通Android/iOS工作机制和内核，精通C/C++，并对其他开发语言有所了解；\r\n\r\n4.   精通移动互联网应用协议，精通TCP/IP协议与编程；\r\n\r\n5.   有解决问题、钻研新技术的兴趣和能力,善于交流和表达,有良好的团队合作精神；\r\n\r\n6.   有良好的分析问题和解决问题的能力，良好的工作进度管理与把控能力，抗压能力强。 ', '江小鱼', '2015-09-10', '', '0', 'web开发部');
INSERT INTO `mcake_article` VALUES ('60', '移动产品经理', '招贤纳士', ' 【岗位职责】\r\n\r\n1.   负责在移动端平台下的应用程序设计、开发、发布和维护；\r\n\r\n2.   负责移动端平台项目的架构设计、方案的制定；\r\n\r\n3.   跟进移动端平台的新技术发展，编写设计开发及实现文档；\r\n\r\n4.   优化移动产品的质量、性能及用户体验。\r\n\r\n 【岗位职责】\r\n\r\n1.   负责Cooking Love烘焙社区平台业务运营需求，提出产品规划；\r\n\r\n2.   配合运营、技术，制定交互方案，设计说明文档；\r\n\r\n3.   对产品进行持续的优化，提升用户体验，深度挖掘用户需求；\r\n\r\n4.   协调运营、技术、设计完成产品推进；\r\n\r\n5.   基于用户体验设计方法（UED），结合用户需求和产品技术，辅助运营；\r\n\r\n6.   宏观把控移动端产品设计，包括调研、分析、定位、规划、设计、开发配合等；\r\n\r\n \r\n\r\n【任职要求】\r\n\r\n1.   关注细节，苛求完美；\r\n\r\n2.   具备移动社交产品的成功案例；\r\n\r\n3.   能够撰写详尽的PRD文档，制定产品功能流程和产品原型；\r\n\r\n4.   熟悉手机客户端软件及平台特性，熟悉各种手机操作系统特性；\r\n\r\n5.   具备优秀的沟通表达能力、团队协作能力，能承受较大的压力；\r\n\r\n6.   逻辑思维能力强，具备良好文字表达能力；\r\n\r\n7.   熟练使用Axure、MindManager、iWor、Mantis等软件；', '江小鱼', '2015-09-10', '', '0', 'web开发部');
INSERT INTO `mcake_article` VALUES ('61', '产品经理', '招贤纳士', ' 【岗位说明】\r\n\r\n1.   参与公司移动产品战略与发展目标的制定；\r\n\r\n2.   监督、跟进移动产品策划、设计、定义、开发的质量控制及产品的最终发布、发布后的产品推广；\r\n\r\n3.   结合数据分析，推动产品进行快速叠带更新；\r\n\r\n4.   制定、开展和推动移动团队各项工作流程和业务标准的执行、质量的把控；\r\n\r\n5.   了解电商行业在会员营销、会员管理、交叉销售、精准营销等环节的技术产品；\r\n\r\n6.   负责围绕业务问题进行用户数据分析、数据挖掘、并从产品层面指导用户标签库的整体设计、实施；\r\n\r\n7.   与全公司产品团队及相关职能部门之间保持紧密的联络与合作，以得到及时有效地支持；\r\n\r\n \r\n\r\n【任职要求】\r\n\r\n1.   有外卖平台、快消品平台产品工作经验优先考虑；\r\n\r\n2.   深刻理解互联网产品管理，理解互联网思维； \r\n\r\n3.   计算机相关专业，5年以上互联网工作经验，2年以上移动互联网工作经验，有知名移动产品经验者优先考虑；\r\n\r\n4.   熟悉电商营销相关业务细节、流程； 熟悉数据分析、数据挖掘的方法和理念； ', '江小鱼', '2015-09-10', '', '0', 'web开发部');
INSERT INTO `mcake_article` VALUES ('62', '平面设计师', '招贤纳士', ' 【岗位职责】\r\n\r\n1.  负责公司网站平台及移动平台的界面设计工作，通过良好的视觉传达与表现，增加品牌感染力，提升用户体验；\r\n\r\n2.  负责品牌形象等宣传资料、广告资料等相关内容的设计；\r\n\r\n3.  推广活动的专题设计，及品牌推广广告的创意设计；\r\n\r\n4.  组织设计师全面把握重要项目的配套设计；\r\n\r\n5.  摄影方案构思和创意。\r\n\r\n \r\n\r\n【任职要求】\r\n\r\n1.  大专以上学历，美术、设计类科班专业，良好的设计功底和创意及审美能力，2年以上相关经验；\r\n\r\n2.  爱艺术，爱生活，爱设计，有决心将设计做好尽善尽美；\r\n\r\n3.  具备互联网思维及热爱设计的达人，喜欢琢磨市场趋势、用户使用习惯、爱摸索探寻分析用户需求；\r\n\r\n4.  敏锐的捕捉视觉流行趋势，把握品牌视觉风格，将自己独到的想法融入设计之中，能帮助提升团队的设计能力；\r\n\r\n5.  工作主动性高，善于沟通，能准确完整的表达自己的设计思路；有较强的责任心和执行能力。能独立完成设计及制作任务，具备良好团队合作精神和一定的团队管理能力；\r\n\r\n6.  4A广告公司或品牌电商相关工作经验优先考虑。 ', '江小鱼', '2015-09-10', '', '0', 'web开发部');
INSERT INTO `mcake_article` VALUES ('63', '交互设计师', '招贤纳士', ' 【岗位职责】\r\n\r\n1.   负责产品的交互界面设计，分析用户操作习惯和喜好，从用户的角度出发提出最佳的交互设计和界面设计方案； \r\n\r\n2.   管理产品的体验，跟踪体验效果数据，持续改善产品的用户体验； \r\n\r\n3.   维护和更新界面设计标准和规范，负责规范和标准的实施，并参与界面设计流程的完善和优化工作。\r\n\r\n \r\n\r\n【任职要求】\r\n\r\n1.   3年以上互联网产品交互设计工作经验，可独立完成产品的原型设计；\r\n\r\n2.   逻辑思维能力强，对产品有整体规划和梳理产品信息架构的能力；\r\n\r\n3.   熟悉图像设计软件并熟练使用Visio、Axure等软件；\r\n\r\n4.   具有良好的沟通表达能力和跨职能的团队协作能力；\r\n\r\n5.   工业设计、计算机、心理学、平面设计、广告设计等相关专业本科以上学历。 ', '江小鱼', '2015-09-10', '', '0', 'web开发部');
INSERT INTO `mcake_article` VALUES ('64', '联系我们', '呼叫中心', ' MCAKE呼叫中心服务时间：8:00 - 22:00\r\n服务热线：4006-678-678全年无休 ', '米小米', '2015-09-10', '', '0', '客服部');
INSERT INTO `mcake_article` VALUES ('65', '订单查询', '订单相关', '登录MCAKE官网，点击首页上方导航栏&quot;会员中心&quot; ，在左侧&quot;我的订单&quot;中，用户可以查询在MCAKE的所有订单，包括已完成、已取消、待付款、待收货、待评价订单等。', '米小米', '2015-09-10', '', '0', '客服部');
INSERT INTO `mcake_article` VALUES ('66', '取消订单', '订单相关', '1、&quot;线上支付方式&quot;提交订单，但未进行付款：进入&quot;会员中心 — 我的订单&quot;，查找刚刚的订单，点击【取消订单】按钮取消订单。\r\n2、&quot;线上支付&quot;成功或选择&quot;货到付款方式&quot;已审核通过：致电客服热点：4006—678—678进行订单状态的修改。', '米小米', '2015-09-10', '', '0', '客服部');
INSERT INTO `mcake_article` VALUES ('67', '支付方式', '支付类', ' 货到付款：\r\n由MCAKE外送人员全程配送蛋糕，您可以在收到货物时，再进行订购商品的结算，可支付现金或使用POS机刷卡。\r\n\r\n \r\n网上支付：\r\n用户订购蛋糕，在结算页可以直接使用网上支付方式进行付款，网上支付方式主要包括：支付宝、网银在线支付。\r\n1、支付宝支付\r\n支付宝，全球领先的独立第三方支付平台。\r\n&quot;支付宝账户&quot;就是网上购物付款的&quot;电子钱包&quot;，将钱充入，随买随付，方便安全。\r\n2、网银在线支付\r\n\r\n\r\n领先的第三方电子支付专家。\r\n支持多家网银在线支付，同时涵盖工行、招行、建行、交行、农行、银联等国内20余种银行卡。\r\n\r\n \r\n预付费卡支付：\r\n订购结算页，也可以勾选使用预付费卡支付方式，目前支持得仕通、乐支付、付费通等10余种预付费卡，用户可以选择直接线上支付，也可以选择线下支付。\r\n\r\n \r\n异地付款：\r\n用户为朋友订购商品，如果选择异地付款方式，则配送员在配送蛋糕完成后，将根据用户指定地点，进行订购商品的结算，用户可以选择使用现金支付或POS刷卡。\r\n温馨提示：异地付款将会产生额外的服务费用【收款地点为外环以内及莘庄地区的，收取10元服务费；收款地点为外环以外的，客服会联系您加收服务费（郊县暂不提供配送、收款等服务）；具体配送范围标准结算页有图示展示】建议使用在线支付方式。\r\n\r\n  ', '魏小艾', '2015-09-10', '', '0', '财务部');
INSERT INTO `mcake_article` VALUES ('68', '优惠方式', '支付类', '现金卡：\r\n现金卡是MCAKE推出的一种优惠卡，主要在线下推广方式中进行售卖。用户官网购买商品，在结算页勾选使用现金卡选项，输入现金卡号，即可进行相应金额抵扣。\r\n优惠券：\r\n优惠券发放是官网不定时进行优惠的一种活动形式。优惠券一般在官网活动中发放，也有些直接加入到用户账户内，在订单结算页，可以直接勾选使用优惠券选项，进行相应抵扣。\r\n\r\n\r\n温馨提示：随着MCAKE官网不断更新，可能还会有其他优惠方式出现，用户可以实时关注&quot;会员中心&quot;进行查看。 \r\n\r\n  ', '魏小艾', '2015-09-10', '', '0', '财务部');
INSERT INTO `mcake_article` VALUES ('69', '如何订购', '购物指南', ' 1、注册/登录MCAKE官网\r\n如果您未在网站注册过，点击官网首页右上角【注册】按钮，根据提示进行账号注册；如果您已注册过，只需点击首页右上角【登录】按钮，输入帐号密码即可登录。（本网站也为用户提供了快速购买通道，无需注册会员即可直接下单订购商品）。\r\n\r\n \r\n\r\n2、选购商品放入购物车\r\n浏览/筛选您需要的商品，点击&quot;立即购买&quot;或放入&quot;我的购物车&quot;；进入购物车后，如果您还想购买其他感兴趣的商品，点击商品列表下方【继续购物】按钮即可；如果您不需要其他商品，即可点击商品列表下方的【结算】即进入结算页面。\r\n\r\n \r\n3、填写收货信息\r\n在收货信息页面填写订货人的详细信息。为了保证您的商品顺利配送，请准确填写收货人的姓名、地址、电话、配送时间等收货信息。注：官网蛋糕需至少提前5小时订购。\r\n\r\n \r\n4、选择配送方式\r\n填写收货人信息后，您可以根据您所在地区和时间要求选择您想要的送货方式。可以选择由MCAKE配送至收货地址，也可以到指定自提点地点进行自提。\r\n\r\n \r\n5、选择付款方式\r\n完成收货人信息填写后，即可选择该订单付款方式，有货到付款和网上支付供您选择，如果账户内有优惠券/积分/红包/现金卡等，可进行相应勾选。具体付款细节，见&quot;帮助中心&quot;→&quot;支付类&quot;菜单。\r\n\r\n \r\n6、订单提交完成\r\n填写并确认完以上信息，您就可以放心提交此订单，等待收货了。在提交订单后，您也可以通过会员中心&quot;我的订单&quot;查询您的订单状态。', '魏小艾', '2015-09-10', '/Uploads/Admin/images/ArticleImg/55f199c5d1cef.png', '0', '财务部');
INSERT INTO `mcake_article` VALUES ('70', '蛋糕型号介绍', '购物指南', ' 另外免费附送：\r\n目前MCAKE官网免费附送物品还有：晒单有礼贴纸、书签、蜡烛、柠檬片，根据蛋糕品种不同，附送赠品会有所调整。\r\n温馨提示：根据官网不断调整，附送商品可能会有变动，具体以用户结算页显示赠品为准。 ', '魏小艾', '2015-09-10', '/Uploads/Admin/images/ArticleImg/55f199fb53ec6.png', '0', '财务部');
INSERT INTO `mcake_article` VALUES ('71', '会员等级', '会员权益', ' 1、会员等级提高条件\r\n根据在MCAKE官网消费金额（优惠券、积分、现金卡、专项卡、红包抵扣部分不计入在内），会员划分为5个级别。用户注册后，晋升为LV1级别；消费满 500元，晋升为LV2级别；消费满2000元，晋升为LV3级别；消费满5000元，晋升为LV4级别；消费满10000元，晋升为LV5级别。\r\n\r\n \r\n2、会员等级不同，享受到的权益不同，级别越高，权益越大(不断完善中，敬请期待)', '魏小艾', '2015-09-10', '/Uploads/Admin/images/ArticleImg/55f19a421312d.png', '0', '财务部');
INSERT INTO `mcake_article` VALUES ('72', '会员积分', '会员权益', ' 1、积分来源 \r\n\r\n①注册得积分；（注册成功可获得100积分）\r\n②购物得积分；（购物完成可获得消费积分，按照会员每笔订单实际支付金额（优惠券、积分、现金卡、专项卡、红包抵扣部分不计入在内）赠送积分，每消费100元赠送25积分，按照此比例依次类推）\r\n③评论得积分；（有效订购的产品30天内可对其进行评价，评价通过审核即可获得50积分。若一笔订单包含N个产品，且评价皆通过审核，则最终可获得50N积分。若一笔订单中包含N个同款产品，仅可对商品评价一次，通过审核后，则最终可获得50积分）\r\n\r\n \r\n2、积分的作用：\r\n①积分当钱用：100积分=1元，积分可抵扣订单金额（不含环外费）；\r\n②积分兑换奖品（即将推出，敬请期待…）。\r\n\r\n \r\n3、积分适用范围：\r\n除现金卡、专享卡外，积分与官网其他优惠活动均同享。\r\n\r\n \r\n4、积分使用方式：\r\n订单提交页面，勾选【使用积分】选项即可。', '魏小艾', '2015-09-10', '/Uploads/Admin/images/ArticleImg/55f19a73af79e.png', '0', '财务部');
INSERT INTO `mcake_article` VALUES ('73', '上海', '配送服务', ' 1.免费配送区域：\r\n\r\n北以宝钱公路；西以嘉松北路、嘉松中路、嘉松南路、辰塔路、玉树路；南以申嘉湖高速、黄浦江、大治河；东以绕城高速、浦东机场为界。\r\n\r\n2. 配送时间：10：00-22：00 \r\n\r\n3. 400电话咨询时间：8 ： 00-22 ： 00（请至少提前5小时预订） ', '大胖', '2015-09-10', '/Uploads/Admin/images/ArticleImg/55f19b0476417.jpg', '0', '市场部');
INSERT INTO `mcake_article` VALUES ('76', '苏州', '配送服务', ' 1.免费配送区域：\r\n\r\n西以绕城西南线、南以绕城西南线绕城南线、东以绕城东线Ｇ15Ｗ、北以绕城北线沪宁高速范围以内（除阳澄湖地区）\r\n\r\n2. 配送时间：10：00-22：00 \r\n\r\n3. 400电话咨询时间：8 ： 00-22 ： 00（请至少提前8小时预订） ', '大胖', '2015-09-10', '/Uploads/Admin/images/ArticleImg/55f19c5616e36.png', '0', '市场部');
INSERT INTO `mcake_article` VALUES ('77', '杭州', '配送服务', ' 1. 免费配送区域：\r\n1）杭州绕城高速以外：西以东西大道（运溪路）、闲林西路、闲祝线为界；北以运溪路、兴元路、宁桥大道、东湖北路、临平大道、五支线、人民大道、环园中路；东以沪昆高速；南以G302、杭州绕城高速 ；\r\n\r\n2）下沙地区绕城高速以东到钱塘江、江东大道以南至钱塘江区域。\r\n\r\n2. 配送时间：10：00-19：00 \r\n\r\n3. 400电话咨询时间：8 ： 00-22 ： 00（请至少提前5小时预订）  ', '大胖', '2015-09-10', '/Uploads/Admin/images/ArticleImg/55f274ac44aa2.jpg', '0', '市场部');
INSERT INTO `mcake_article` VALUES ('78', '北京', '配送服务', ' 1.免费配送区域：\r\n\r\n五环以内全免，五环以外部分免；\r\n\r\n北以黑山扈路、后厂村路、京新高速、北五环；东以首都机场辅路、东苇路、金榆路、杨庄路、京哈高速；南以经海路、科创十七街、西环中路、南五环；西以西五环；\r\n\r\n2. 配送时间：10：00-22：00 \r\n\r\n3. 400电话咨询时间：8 ： 00-22 ： 00（请至少提前5小时预订） ', '大胖', '2015-09-10', '/Uploads/Admin/images/ArticleImg/55f19e9722551.jpg', '0', '市场部');

-- ----------------------------
-- Table structure for mcake_articletype
-- ----------------------------
DROP TABLE IF EXISTS `mcake_articletype`;
CREATE TABLE `mcake_articletype` (
  `id` int(11) NOT NULL,
  `articletype` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_articletype
-- ----------------------------

-- ----------------------------
-- Table structure for mcake_auser
-- ----------------------------
DROP TABLE IF EXISTS `mcake_auser`;
CREATE TABLE `mcake_auser` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `ausername` varchar(255) NOT NULL COMMENT '后台管理员用户名',
  `apass` varchar(255) NOT NULL COMMENT '后台管理员密码',
  `asex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '性别',
  `aphone` varchar(18) DEFAULT NULL COMMENT '联系电话',
  `aemail` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `addtime` varchar(20) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_auser
-- ----------------------------
INSERT INTO `mcake_auser` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '0', '15512311111', 'admin@qq.com', '2015-09-14 02:57:22');
INSERT INTO `mcake_auser` VALUES ('2', 'rules', 'a4f86f7bfc24194b276c22e0ef158197', '1', '15611111122', '111@qq.com', '2015-09-14 03:17:06');
INSERT INTO `mcake_auser` VALUES ('5', 'goods', '59da8bd04473ac6711d74cd91dbe903d', '1', '15512312312', 'admin@qq.com', '2015-09-14 10:49:36');
INSERT INTO `mcake_auser` VALUES ('6', 'orders', '12c500ed0b7879105fb46af0f246be87', '0', '15512312313', 'admin@qq.com', '2015-09-14 10:50:32');
INSERT INTO `mcake_auser` VALUES ('10', 'banner', '12df53fea8b3adfa6c2ec456dd22e204', '1', '15134335443', '111@qq.com', '2015-09-14 17:25:16');
INSERT INTO `mcake_auser` VALUES ('13', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', '1', '13645678911', '123456@qq.com', '2015-09-15 16:01:20');
INSERT INTO `mcake_auser` VALUES ('14', 'wang', 'e08392bb89dedb8ed6fb298f8e729c15', '1', '15211111111', 'wang@qq.com', '2015-09-17 21:05:11');

-- ----------------------------
-- Table structure for mcake_banner
-- ----------------------------
DROP TABLE IF EXISTS `mcake_banner`;
CREATE TABLE `mcake_banner` (
  `id` int(11) NOT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `subhead` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL COMMENT '广告链接',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_banner
-- ----------------------------
INSERT INTO `mcake_banner` VALUES ('0', null, null, '/Public/Banner/2015-09-15/55f815e49c671.jpg', null);
INSERT INTO `mcake_banner` VALUES ('1', '我们即将毕业我们即将出去各自打拼....', '还未遇见便疏远，尚未熟悉就离别，希望110期的兄弟姐妹毕业快乐前程似锦', '/Public/Banner/2015-09-18/55fb74e0c203a.png', 'http://www.mcake.com');
INSERT INTO `mcake_banner` VALUES ('2', '美味零食诱惑澳洲乳脂奶油，至纯巧克力...', '订购热线:4006687687 1-2小时送货上门! ——M.cake', '/Public/Banner/2015-09-15/55f8164eb34a7.png', 'http://www.mcake.com');
INSERT INTO `mcake_banner` VALUES ('3', '童年的中秋节像孩子一样去拥抱快乐邂逅甜蜜', '9月27日中秋节当天，门店活动：名额有限，预约报名从速详情点击。。。', '/Public/Banner/2015-09-15/55f82047632ea.png', 'http://www.mcake.com');

-- ----------------------------
-- Table structure for mcake_clendav
-- ----------------------------
DROP TABLE IF EXISTS `mcake_clendav`;
CREATE TABLE `mcake_clendav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'anniversaries 纪念日',
  `uid` int(11) DEFAULT NULL COMMENT '用户名',
  `anni_name` text COMMENT '纪念日的名字',
  `mtime` varchar(255) DEFAULT NULL COMMENT '纪念日的时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_clendav
-- ----------------------------

-- ----------------------------
-- Table structure for mcake_content
-- ----------------------------
DROP TABLE IF EXISTS `mcake_content`;
CREATE TABLE `mcake_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论表',
  `gid` int(11) NOT NULL COMMENT 'goods id 商品id',
  `uname` varchar(32) NOT NULL COMMENT '评论人的用户名',
  `uid` int(11) NOT NULL COMMENT '用户 userid',
  `content` varchar(255) NOT NULL COMMENT '内容',
  `addtime` varchar(12) NOT NULL COMMENT '评论时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_content
-- ----------------------------
INSERT INTO `mcake_content` VALUES ('1', '3', '灰机,灰机', '10', '这款蛋糕很好吃!', '2015-9-7');
INSERT INTO `mcake_content` VALUES ('2', '3', '小仙女', '11', '口感不错!', '2015-9-7');
INSERT INTO `mcake_content` VALUES ('3', '3', '啊啊', '12', 'fdsfdsf', '2015-9-7');
INSERT INTO `mcake_content` VALUES ('4', '3', 'sdfl', '13', 'dsfdsf', '2015-9-7');
INSERT INTO `mcake_content` VALUES ('5', '3', 'sdfl', '13', 'dsfdsf', '2015-9-7');
INSERT INTO `mcake_content` VALUES ('6', '3', 'sdfl', '13', 'dsfdsf', '2015-9-7');
INSERT INTO `mcake_content` VALUES ('7', '3', '美美', '14', '扒错', '2015-9-8');
INSERT INTO `mcake_content` VALUES ('20', '2', '130*****501会员', '126', '浮点数', '2015-09-17');
INSERT INTO `mcake_content` VALUES ('21', '2', '130*****501会员', '126', '奋斗过的 ', '2015-09-17');
INSERT INTO `mcake_content` VALUES ('22', '2', '130*****501会员', '126', '放多个法国', '2015-09-17');
INSERT INTO `mcake_content` VALUES ('23', '2', '130*****501会员', '126', '放多个官方的规范个', '2015-09-17');
INSERT INTO `mcake_content` VALUES ('24', '2', '130*****501会员', '126', '说的发的发', '2015-09-17');
INSERT INTO `mcake_content` VALUES ('25', '2', '130*****501会员', '126', 'HELLO', '2015-09-17');
INSERT INTO `mcake_content` VALUES ('26', '3', '130*****501会员', '126', '很好吃', '2015-09-17');
INSERT INTO `mcake_content` VALUES ('27', '3', '130*****501会员', '126', 'sadd', '2015-09-18');

-- ----------------------------
-- Table structure for mcake_country
-- ----------------------------
DROP TABLE IF EXISTS `mcake_country`;
CREATE TABLE `mcake_country` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT COMMENT '国家id',
  `cname` varchar(255) NOT NULL COMMENT '国家的名子',
  `flag_pic` varchar(255) NOT NULL COMMENT '国家对应的国旗图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_country
-- ----------------------------
INSERT INTO `mcake_country` VALUES ('1', '法国', '/Public/country2/fg.jpg');
INSERT INTO `mcake_country` VALUES ('2', '新西兰', '/Public/country2/xxl.jpg');
INSERT INTO `mcake_country` VALUES ('3', '比利时', '/Public/country2/bls.jpg');
INSERT INTO `mcake_country` VALUES ('4', '马来西亚', '/Public/country2/mlxy.jpg');
INSERT INTO `mcake_country` VALUES ('5', '波多黎各', '/Public/country2/bdlg.jpg');
INSERT INTO `mcake_country` VALUES ('6', '韩国', '/Public/country2/hg.jpg');
INSERT INTO `mcake_country` VALUES ('7', '云南', '/Public/country2/yn.jpg');
INSERT INTO `mcake_country` VALUES ('8', '土耳其', '/Public/country2/trq.jpg');
INSERT INTO `mcake_country` VALUES ('9', '也门', '/Public/country2/ym.jpg');
INSERT INTO `mcake_country` VALUES ('10', '巴基斯坦', '/Public/country2/bjst.jpg');
INSERT INTO `mcake_country` VALUES ('11', '美国', '/Public/country2/mg.jpg');
INSERT INTO `mcake_country` VALUES ('12', '马达加斯加', '/Public/country2/mdjsj.jpg');
INSERT INTO `mcake_country` VALUES ('13', '瑞士', '/Public/country2/rs.jpg');
INSERT INTO `mcake_country` VALUES ('14', '伊朗', '/Public/country2/yl.jpg');
INSERT INTO `mcake_country` VALUES ('15', '爱尔兰', '/Public/country2/arl.jpg');
INSERT INTO `mcake_country` VALUES ('16', '意大利', '/Public/country2/ydl.jpg');
INSERT INTO `mcake_country` VALUES ('17', '墨西哥', '/Public/country2/mxg.jpg');
INSERT INTO `mcake_country` VALUES ('18', '澳大利亚', '/Public/country2/adly.jpg');
INSERT INTO `mcake_country` VALUES ('19', '自制', '/Public/country2/zz.jpg');
INSERT INTO `mcake_country` VALUES ('20', '甄选及其它', '/Public/country2/zx.jpg');

-- ----------------------------
-- Table structure for mcake_coupon
-- ----------------------------
DROP TABLE IF EXISTS `mcake_coupon`;
CREATE TABLE `mcake_coupon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '优惠券',
  `couponname` varchar(32) DEFAULT NULL COMMENT '优惠券名字',
  `timeout` int(11) DEFAULT NULL COMMENT '有效时间',
  `keynumber` int(11) DEFAULT NULL COMMENT '激活码',
  `status` int(4) DEFAULT NULL COMMENT '状态',
  `commond` int(255) DEFAULT NULL COMMENT '操作几个状态值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_coupon
-- ----------------------------

-- ----------------------------
-- Table structure for mcake_detail
-- ----------------------------
DROP TABLE IF EXISTS `mcake_detail`;
CREATE TABLE `mcake_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情',
  `orderid` varchar(50) DEFAULT NULL COMMENT '订单id',
  `goodsid` varchar(50) DEFAULT NULL COMMENT '商品id',
  `name` varchar(32) DEFAULT NULL COMMENT '名字',
  `price` varchar(50) DEFAULT NULL COMMENT '价格',
  `num` int(11) DEFAULT NULL COMMENT '数量',
  `weight` int(11) DEFAULT NULL COMMENT '重量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_detail
-- ----------------------------
INSERT INTO `mcake_detail` VALUES ('1', '1231333', '1', '奶油蛋糕', '266', '1', '2');
INSERT INTO `mcake_detail` VALUES ('2', '1322333222', '2', '奶油加薄荷', '366', '1', '1');
INSERT INTO `mcake_detail` VALUES ('3', '1231335', '2', '奶油芥末', '530', '2', '3');
INSERT INTO `mcake_detail` VALUES ('4', '1441821800', '1', '简', '318', '4', '2');
INSERT INTO `mcake_detail` VALUES ('5', '1441821800', '2', 'Mojito 柠•漾', '318', '4', '2');
INSERT INTO `mcake_detail` VALUES ('6', '1442199082', '3', '悦时光', '218', '5', '2');
INSERT INTO `mcake_detail` VALUES ('7', '1442199118', '3', '悦时光', '218', '5', '2');
INSERT INTO `mcake_detail` VALUES ('8', '1442299895', '0', '悦时光', '218', '4', '0');
INSERT INTO `mcake_detail` VALUES ('9', '1442299895', '2', 'Mojito 柠•漾', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('10', '1442299916', '0', '悦时光', '218', '4', '0');
INSERT INTO `mcake_detail` VALUES ('11', '1442299916', '2', 'Mojito 柠•漾', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('12', '1442300029', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('13', '1442300070', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('14', '1442300090', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('15', '1442300220', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('16', '1442300260', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('17', '1442300270', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('18', '1442300736', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('19', '1442300960', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('20', '1442300997', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('21', '1442301225', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('22', '1442301464', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('23', '1442301656', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('24', '1442301749', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('25', '1442301802', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('26', '1442301825', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('27', '1442305346', '2', 'Mojito 柠•漾', '318', '2', '2');
INSERT INTO `mcake_detail` VALUES ('28', '1442317482', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('29', '1442317482', '1', '简', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('30', '1442317945', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('31', '1442317965', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('32', '1442318775', '2', 'Mojito 柠•漾', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('33', '1442319431', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('34', '1442319623', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('35', '1442319727', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('36', '1442319839', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('37', '1442368255', '2', 'Mojito 柠•漾', '218', '3', '1');
INSERT INTO `mcake_detail` VALUES ('38', '1442368853', '2', 'Mojito 柠•漾', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('39', '1442386118', '2', 'Mojito 柠•漾', '318', '3', '2');
INSERT INTO `mcake_detail` VALUES ('40', '1442386118', '3', '悦时光', '318', '2', '2');
INSERT INTO `mcake_detail` VALUES ('41', '1442393622', '7', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('42', '1442407483', '2', 'Mojito 柠•漾', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('43', '1442407528', '2', 'Mojito 柠•漾', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('44', '1442407655', '2', 'Mojito 柠•漾', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('45', '1442407666', '2', 'Mojito 柠•漾', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('46', '1442407689', '2', 'Mojito 柠•漾', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('47', '1442407836', '2', 'Mojito 柠•漾', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('48', '1442407858', '2', 'Mojito 柠•漾', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('49', '1442408167', '3', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('50', '1442408177', '3', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('51', '1442426766', '2', 'Mojito 柠•漾', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('52', '1442427132', '8', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('53', '1442466291', '3', '悦时光', '218', '2', '1');
INSERT INTO `mcake_detail` VALUES ('54', '1442466291', '27', '悦时光', '218', '5', '1');
INSERT INTO `mcake_detail` VALUES ('55', '1442466291', '5', '悦时光', '318', '2', '2');
INSERT INTO `mcake_detail` VALUES ('56', '1442466291', '4', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('57', '1442489716', '3', '悦时光', '318', '3', '2');
INSERT INTO `mcake_detail` VALUES ('58', '1442489716', '2', 'Mojito 柠•漾', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('59', '1442489716', '3', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('60', '1442489716', '4', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('61', '1442489725', '3', '悦时光', '318', '3', '2');
INSERT INTO `mcake_detail` VALUES ('62', '1442489725', '2', 'Mojito 柠•漾', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('63', '1442489725', '3', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('64', '1442489725', '4', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('65', '1442489770', '3', '悦时光', '318', '3', '2');
INSERT INTO `mcake_detail` VALUES ('66', '1442489770', '2', 'Mojito 柠•漾', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('67', '1442489770', '3', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('68', '1442489770', '4', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('69', '1442489778', '3', '悦时光', '318', '3', '2');
INSERT INTO `mcake_detail` VALUES ('70', '1442489778', '2', 'Mojito 柠•漾', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('71', '1442489778', '3', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('72', '1442489778', '4', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('73', '1442489891', '3', '悦时光', '318', '3', '2');
INSERT INTO `mcake_detail` VALUES ('74', '1442489891', '2', 'Mojito 柠•漾', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('75', '1442489891', '3', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('76', '1442489891', '4', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('77', '1442492268', '3', '悦时光', '318', '2', '2');
INSERT INTO `mcake_detail` VALUES ('78', '1442492268', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('79', '1442496170', '2', 'Mojito 柠•漾', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('80', '1442504398', '2', 'Mojito 柠•漾', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('81', '1442504398', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('82', '1442504398', '1', '简', '218', '2', '1');
INSERT INTO `mcake_detail` VALUES ('83', '1442504417', '2', 'Mojito 柠•漾', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('84', '1442504417', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('85', '1442504417', '1', '简', '218', '2', '1');
INSERT INTO `mcake_detail` VALUES ('86', '1442504454', '2', 'Mojito 柠•漾', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('87', '1442504454', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('88', '1442504454', '1', '简', '218', '2', '1');
INSERT INTO `mcake_detail` VALUES ('89', '1442512465', '2', 'Mojito 柠•漾', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('90', '1442512465', '3', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('91', '1442512549', '3', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('92', '1442515756', '2', 'Mojito 柠•漾', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('93', '1442516040', '3', '悦时光', '318', '3', '2');
INSERT INTO `mcake_detail` VALUES ('94', '1442516040', '2', 'Mojito 柠•漾', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('95', '1442516040', '3', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('96', '1442516040', '4', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('97', '1442516040', '4', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('98', '1442516080', '3', '悦时光', '318', '3', '2');
INSERT INTO `mcake_detail` VALUES ('99', '1442516080', '2', 'Mojito 柠•漾', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('100', '1442516080', '3', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('101', '1442516080', '4', '悦时光', '318', '1', '2');
INSERT INTO `mcake_detail` VALUES ('102', '1442516080', '4', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('103', '1442516302', '2', 'Mojito 柠•漾', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('104', '1442520035', '2', 'Mojito 柠•漾', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('105', '1442540125', '3', '悦时光', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('106', '1442540125', '2', 'Mojito 柠•漾', '218', '1', '1');
INSERT INTO `mcake_detail` VALUES ('107', '1442541709', '1', '简', '218', '2', '1');
INSERT INTO `mcake_detail` VALUES ('108', '1442543253', '3', '悦时光', '218', '1', '1');

-- ----------------------------
-- Table structure for mcake_flink
-- ----------------------------
DROP TABLE IF EXISTS `mcake_flink`;
CREATE TABLE `mcake_flink` (
  `fid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '友情连接表 id',
  `fname` varchar(32) NOT NULL COMMENT '友链的网站名称',
  `furl` varchar(255) NOT NULL COMMENT '友链的网址',
  `fimage_c` varchar(255) NOT NULL COMMENT '友链的logo图片_彩色',
  `fimage_bw` varchar(255) NOT NULL COMMENT '友链的logo图片_黑白',
  `addtime` varchar(12) NOT NULL COMMENT '友链的添加时间',
  PRIMARY KEY (`fid`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_flink
-- ----------------------------
INSERT INTO `mcake_flink` VALUES ('1', '小High博客', 'www.xiaohigh.com', '/FlinkImg/55f63adb6ea05.jpg', '/FlinkImg/55f63adb7270e.jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('2', '牛杂网', 'www.niuza.com', '/FlinkImg/03.jpg', '/FlinkImg/bw03.jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('3', '坚果手机网', 'www.jianguo.com', '/FlinkImg/25.jpg', '/FlinkImg/bw25.jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('4', '锤子科技', 'www.smartisan.com', '/FlinkImg/26.jpg', '/FlinkImg/bw26.jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('5', '美丽说', 'www.meili.com', '/FlinkImg/15.jpg', '/FlinkImg/bw25 (1).jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('6', '糗事百科', 'www.qiushi.com', '/FlinkImg/05.jpg', '/FlinkImg/bw05.jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('7', '当当网', 'www.dangdang.com', '/FlinkImg/16.jpg', '/FlinkImg/bw25 (2).jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('8', '沃商店', 'www.o.com', '/FlinkImg/17.jpg', '/FlinkImg/bw25 (3).jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('10', 'discuz', 'www.discuz.com', '/FlinkImg/20.jpg', '/FlinkImg/bw25 (6).jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('11', '京东', 'www.jd.com', '/FlinkImg/13.jpg', '/FlinkImg/bw26 (6).jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('12', '小米', 'www.xiaomi.com', '/FlinkImg/23.jpg', '/FlinkImg/bw25 (9).jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('13', 'htc', 'www.htc.com', '/FlinkImg/22.jpg', '/FlinkImg/bw25 (8).jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('14', '都市丽人', 'www.dushi.com', '/FlinkImg/21.jpg', '/FlinkImg/bw25 (7).jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('15', '西集', 'www.xiji.com', '/FlinkImg/02.jpg', '/FlinkImg/bw02.jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('16', '马蜂窝', 'www.mfo.com', '/FlinkImg/04.jpg', '/FlinkImg/bw04.jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('17', '麦当劳', 'www.maidanglao.com', '/FlinkImg/06.jpg', '/FlinkImg/bw06.jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('18', '肯德基', 'www.kfc.com', '/FlinkImg/07.jpg', '/FlinkImg/bw07.jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('19', '德克士', 'www.dekeshi.com', '/FlinkImg/10.jpg', '/FlinkImg/bw26 (3).jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('20', '必胜客', 'www.bishengke', '/FlinkImg/09.jpg', '/FlinkImg/bw26 (2).jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('21', '天猫', 'www.tianmao.com', '/FlinkImg/12.jpg', '/FlinkImg/bw26 (5).jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('22', '小肥羊', 'www.xiaofeiyang', '/FlinkImg/19.jpg', '/FlinkImg/bw25 (5).jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('23', '全聚德', 'www.quan.com', '/FlinkImg/18.jpg', '/FlinkImg/bw25 (4).jpg', '2015-09-14');
INSERT INTO `mcake_flink` VALUES ('87', '酒仙网', 'www.jiuxian', '/FlinkImg/01.jpg', '/FlinkImg/bw01.jpg', '2015-09-14');

-- ----------------------------
-- Table structure for mcake_goods
-- ----------------------------
DROP TABLE IF EXISTS `mcake_goods`;
CREATE TABLE `mcake_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `en_gname` varchar(255) NOT NULL COMMENT '商品的英文名称',
  `cn_gname` varchar(255) NOT NULL COMMENT '商品的英文名称',
  `type` varchar(32) NOT NULL COMMENT '商品类别名称',
  `descr_en` varchar(255) NOT NULL COMMENT '蛋糕英文简介',
  `descr_cn` varchar(255) NOT NULL COMMENT '蛋糕中文简介',
  `price` varchar(255) NOT NULL COMMENT '价格',
  `picname` varchar(255) NOT NULL COMMENT '图片',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品状态 0:无 1:新品  2:人气 3:金牌 4:售馨',
  `size` varchar(255) NOT NULL COMMENT '蛋糕的尺寸',
  `state` varchar(255) NOT NULL COMMENT '说明',
  `clicknum` int(11) NOT NULL COMMENT '点击 次数',
  `addtime` varchar(32) NOT NULL COMMENT '添加时间',
  `taste` varchar(32) NOT NULL COMMENT '口感',
  `feeling` varchar(255) NOT NULL COMMENT '口味',
  `basefeel` varchar(32) NOT NULL COMMENT '口味基底',
  `sour` tinyint(11) NOT NULL COMMENT '酸味',
  `sweet` tinyint(11) NOT NULL COMMENT '甜味',
  `weight` varchar(128) NOT NULL COMMENT '蛋糕磅数',
  `material_name` varchar(255) NOT NULL COMMENT '原材料名称',
  `explain` varchar(255) NOT NULL COMMENT '特别说明',
  `stocks` int(32) unsigned NOT NULL DEFAULT '20' COMMENT '总限购量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of mcake_goods
-- ----------------------------
INSERT INTO `mcake_goods` VALUES ('1', 'Carré Blanc', '简', '慕斯', 'La célèbre pâte feuilletée, les myrtilles bien sélectionnées, la génoise au fromage fondante,Voilà notre Carré Blanc pour les horoscopes de la vierge. C’est la perfection !\r\n\r\n法国国宝级拿破仑酥皮、精心挑选的野生蓝莓、口感绝佳的轻乳芝士，献给极致挑剔的处女座。外表极致简洁，内心醇厚酥脆。必须美味，必须完美！', '', '218,318,', '55e942891ab3f.jpg,55e942891ab3f.jpg,55e942891ab3f.jpg,', '2', ' 适合2-3人食用+SIZE:16cm*10cm*5.5cm+需提前5小时预定, 适合4-7人食用+SIZE:23cm*14cm*5.5cm+需提前5小时预定,,', 'dsfsd', '0', '20150904150444', '酥脆浓郁 ', '奶油/水果/芝士', 'Mousse', '0', '1', '1,2', '1-法国奶油,1-法国黄油,20-甄选草莓,20-世界甄选蓝莓,3-比利时白巧克力,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('2', 'Le MOJITO', 'Mojito 柠•漾', '水果', 'Une mousse au citron vert légèrement aromatisée au rhum blanc, une gélée verte de menthe, le Mojito vous présente une harmonie entre l’acidité et la fraîcheur.\r\n\r\nMojito 柠•漾，柔滑慕斯内蕴Q弹酒冻，绝妙配比带来口感的平衡，不太浓烈也不过于寡淡，青柠独特的酸甜带出白朗姆酒的微醺之意。', '', '218,318,', '55e943e97de29.jpg,55e943e981b32.jpg,55e943e981b32.jpg,', '0', ' 适合2-3人食用+SIZE:15cm*4.5cm+需提前5小时预定, 适合4-7人食用+SIZE:18cm*5.0cm+需提前5小时预定, 适合8-12人食用+SIZE:22cm*5.0cm+需提前24小时预定,', '0', '0', '20150904151036', '入口即化 ', '水果/巧克力', 'Mousse ', '0', '2', '1,2,3', '1-法国奶油,2-新西兰黄油,1-法国果茸,3-比利时白巧克力,4-马来西亚薄荷糖浆,20-世界甄选青柠檬,5-波多黎各朗姆酒,20-甄选薄荷叶,', '', '15');
INSERT INTO `mcake_goods` VALUES ('3', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '20');
INSERT INTO `mcake_goods` VALUES ('4', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('5', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('6', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('7', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('8', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('9', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('10', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('11', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,328,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('12', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,328,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '2', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('13', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('14', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('15', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,328,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('16', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('17', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '1', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('18', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '1', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('19', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '1', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('20', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('21', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('22', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('23', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('24', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('25', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '0', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('26', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '4', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('27', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '1', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');
INSERT INTO `mcake_goods` VALUES ('29', 'Nos jours heureux', '悦时光', '芝士', 'Choisir une après-midi, dégustez notre mousses différentes, chaque saveur apporte un sens unique Un petit part, se placée immédiatement à Paris.', '一段午后，品尝一下慕斯的绵柔细腻，每一款都带来一份特有的意境 小小一块“悦时光”，悦享巴黎的最美时光', '218,318,', '55e94728f0537.jpg,55e9472900000.jpg,55e9472903d09.jpg,', '3', ' 适合2-3人食用+SIZE:6*3.5*6个+需提前5小时预定, 适合4-7人食用+SIZE:6*3.5*12个+需提前5小时预定,,', '1磅含原味3个，抹茶、玫瑰、可可味各1个；2磅含原味6个，抹茶、玫瑰、可可味各2个； ', '0', '20150904152428', '入口即化 ', '芝士', 'Cheese', '0', '1', '1,2', '1-法国奶油,1-法国可可粉,2-新西兰黄油,6-韩国幼砂糖,20-臻选抹茶粉,7-云南玫瑰汁,1-法国番石榴糖浆,1-法国荔枝酒,2-新西兰奶油奶酪,', '', '15');

-- ----------------------------
-- Table structure for mcake_goodsinvoice
-- ----------------------------
DROP TABLE IF EXISTS `mcake_goodsinvoice`;
CREATE TABLE `mcake_goodsinvoice` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '发货单表',
  `goodsinvoicenum` varchar(255) DEFAULT NULL COMMENT '发货单号',
  `oid` varchar(255) DEFAULT NULL COMMENT '订单号',
  `linkman` varchar(255) DEFAULT NULL COMMENT '联系人',
  `invoice_number` int(11) DEFAULT NULL COMMENT '发票流水号',
  `payway` varchar(255) DEFAULT NULL COMMENT '支付方式',
  `packname` varchar(255) DEFAULT NULL COMMENT '包装名称',
  `packpay` decimal(8,2) DEFAULT NULL COMMENT '额外包装费用',
  `packfree` decimal(8,2) DEFAULT NULL COMMENT '免费额',
  `address` varchar(255) DEFAULT NULL COMMENT '收货地址',
  `sendtime` varchar(255) DEFAULT NULL COMMENT '收货时间避开的时间',
  `goodsname` varchar(255) DEFAULT NULL COMMENT '商品名字',
  `goodsnum` int(11) DEFAULT NULL COMMENT '商品数量',
  `taste` varchar(20) DEFAULT NULL COMMENT '品味',
  `feeling` varchar(20) DEFAULT NULL COMMENT '感觉',
  `sweet` varchar(20) DEFAULT NULL COMMENT '甜度',
  `goodsprice` decimal(8,2) DEFAULT NULL COMMENT '商品单价',
  `goodstotalprice` decimal(8,2) DEFAULT NULL COMMENT '商品总价',
  `describe` varchar(255) DEFAULT NULL COMMENT '包装描述 如餐具',
  `beizhu` varchar(255) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL COMMENT '总价 当发货单为完成状态时转为积分给用户',
  `username` varchar(255) DEFAULT NULL COMMENT '下单用户的名字',
  `status` varchar(255) DEFAULT '0' COMMENT '状态',
  `time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_goodsinvoice
-- ----------------------------
INSERT INTO `mcake_goodsinvoice` VALUES ('23', '1509151442305633', '1442305346', '小明', '0', '货到付款', '32120', '24.00', '0.00', '北京昌平', '周六日以外的时间', 'Mojito 柠•漾', '2', '入口即化 ', '水果/巧克力', '2', '318.00', '636.00', '额外餐具,额外生日蜡烛', '快速发货呀', '660.00', 'xiaoming', '1', '2015-09-15 16:27:13');
INSERT INTO `mcake_goodsinvoice` VALUES ('24', '1509161442404438', '1442393622', '小明', '0', '货到付款', '32120', '8.00', '0.00', '北京昌平', '周六日以外的时间', '悦时光', '1', '入口即化 ', '芝士', '1', '318.00', '318.00', '额外餐具,额外生日蜡烛', '奋斗奋斗是发放', '326.00', 'xiaoming', '1', '2015-09-16 19:53:58');
INSERT INTO `mcake_goodsinvoice` VALUES ('25', '1509161442405386', '1442393622', '小明', '0', '货到付款', '32120', '8.00', '0.00', '北京昌平', '周六日以外的时间', '悦时光', '1', '入口即化 ', '芝士', '1', '318.00', '318.00', '额外餐具,额外生日蜡烛', '奋斗奋斗是发放', '326.00', 'xiaoming', '0', '2015-09-16 20:09:46');
INSERT INTO `mcake_goodsinvoice` VALUES ('26', '1509171442427643', '1442427132', '马克玛丽', '0', '货到付款', '32120', '6.00', '0.00', '额外惹我认为', '9:00', '悦时光', '1', '入口即化 ', '芝士', '1', '218.00', '218.00', '额外餐具,额外生日蜡烛', 'zuixin', '224.00', 'changlei', '0', '2015-09-17 02:20:43');
INSERT INTO `mcake_goodsinvoice` VALUES ('27', '1509171442470727', '1442466291', '小明同学', '0', '货到付款', '32120', '36.00', '0.00', '北京市昌平区回龙观文化西葫芦', '周六日以外的时间段', '悦时光', '2', '入口即化 ', '芝士', '1', '218.00', '436.00', '额外餐具,额外生日蜡烛', '快速发货 9月18日', '472.00', 'changlei', '0', '2015-09-17 14:18:47');
INSERT INTO `mcake_goodsinvoice` VALUES ('28', '1509171442470999', '1442466291', '小明同学', '0', '货到付款', '32120', '36.00', '0.00', '北京市昌平区回龙观文化西葫芦', '周六日以外的时间段', '悦时光', '2', '入口即化 ', '芝士', '1', '218.00', '436.00', '额外餐具,额外生日蜡烛', '快速发货 9月18日', '472.00', 'changlei', '0', '2015-09-17 14:23:19');
INSERT INTO `mcake_goodsinvoice` VALUES ('30', '1509181442541855', '1442541709', '马克玛丽', '2147483647', '货到付款', '32120', '7.00', '0.00', '额外惹我认为', '123', '简', '2', '酥脆浓郁 ', '奶油/水果/芝士', '1', '218.00', '436.00', '额外餐具,额外生日蜡烛', 'shengrikauile', '443.00', 'changlei', '1', '2015-09-18 10:04:15');

-- ----------------------------
-- Table structure for mcake_group
-- ----------------------------
DROP TABLE IF EXISTS `mcake_group`;
CREATE TABLE `mcake_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_group
-- ----------------------------
INSERT INTO `mcake_group` VALUES ('1', '超级管理员', '1', '18,17,16,15,14,13,12,19,20,21,22,23,24,25,28,27,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,91,92,93,94,95,96,97,98,99,100,101,102,103,107,108,109');
INSERT INTO `mcake_group` VALUES ('2', '权限编辑', '1', '18,16,15,14,13,12,28,27,29,30,31,32,33,34');
INSERT INTO `mcake_group` VALUES ('3', '商品管理员', '1', '22,23,24,27');
INSERT INTO `mcake_group` VALUES ('4', '订单管理员', '1', '21,27');
INSERT INTO `mcake_group` VALUES ('5', '广告管理员', '1', '19,20,27');
INSERT INTO `mcake_group` VALUES ('12', '用户管理员', '1', '25,35,36,37,38,39,40,41,42,27');

-- ----------------------------
-- Table structure for mcake_group_access
-- ----------------------------
DROP TABLE IF EXISTS `mcake_group_access`;
CREATE TABLE `mcake_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_group_access
-- ----------------------------
INSERT INTO `mcake_group_access` VALUES ('1', '1');
INSERT INTO `mcake_group_access` VALUES ('2', '2');
INSERT INTO `mcake_group_access` VALUES ('5', '3');
INSERT INTO `mcake_group_access` VALUES ('6', '4');
INSERT INTO `mcake_group_access` VALUES ('10', '5');
INSERT INTO `mcake_group_access` VALUES ('13', '12');
INSERT INTO `mcake_group_access` VALUES ('14', '1');

-- ----------------------------
-- Table structure for mcake_gw
-- ----------------------------
DROP TABLE IF EXISTS `mcake_gw`;
CREATE TABLE `mcake_gw` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '重量和商品关联表重量关联价格和预约时间',
  `gid` int(11) NOT NULL COMMENT '商品id',
  `weight1` text NOT NULL,
  `weight2` text NOT NULL,
  `weight3` text NOT NULL,
  `weight5` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_gw
-- ----------------------------

-- ----------------------------
-- Table structure for mcake_help
-- ----------------------------
DROP TABLE IF EXISTS `mcake_help`;
CREATE TABLE `mcake_help` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '帮助中心',
  `title` varchar(255) DEFAULT NULL COMMENT '帮助中心文章标题',
  `content` varchar(255) DEFAULT NULL COMMENT '帮助中心文章的内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_help
-- ----------------------------

-- ----------------------------
-- Table structure for mcake_invoice
-- ----------------------------
DROP TABLE IF EXISTS `mcake_invoice`;
CREATE TABLE `mcake_invoice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '发票表',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `oid` int(11) NOT NULL COMMENT '订单号',
  `title` varchar(32) NOT NULL COMMENT '发票标题',
  `company` varchar(32) NOT NULL COMMENT '纳税公司名字',
  `total` varchar(255) NOT NULL COMMENT '发票金额',
  `privateperson` varchar(32) DEFAULT NULL COMMENT '纳税个人名字',
  `content` varchar(255) DEFAULT NULL COMMENT '发票内容',
  `status` tinyint(1) DEFAULT '0' COMMENT '是否开发票0不开发票1开发票',
  `code` varchar(32) DEFAULT NULL COMMENT '发票编号',
  `print` tinyint(1) DEFAULT '0' COMMENT '0未打印，1已打印',
  `addtime` datetime DEFAULT '2015-09-03 00:00:00' COMMENT '发票生成时间，在生成发货单时发票单也同时生成',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_invoice
-- ----------------------------
INSERT INTO `mcake_invoice` VALUES ('39', '0', '1442305346', '明细', '小明', '660', '小明', 'xdl拿破仑大芝士', '1', 'XDL20150915001', '0', '2015-09-15 16:27:13');
INSERT INTO `mcake_invoice` VALUES ('43', '0', '1442318775', '食品', '明明', '233', null, null, '1', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('47', '0', '1442319839', '食品', 'alias', '221', null, null, '1', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('48', '0', '1442368255', '食品', 'FSDF', '654', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('49', '0', '1442368853', '食品', '发顺丰大是大非', '236', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('50', '0', '1442386118', '食品', '0916', '1595', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('51', '0', '1442393622', '食品', '发顺丰大是大非', '328', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('52', '0', '1442393622', '明细', '小明', '326', '小明', '916', '1', 'XDL20150915002', '0', '2015-09-16 19:53:58');
INSERT INTO `mcake_invoice` VALUES ('53', '0', '1442393622', '明细', '小明', '326', '小明', 'xdl拿破仑大芝士1516', '1', 'XDL20150915003', '0', '2015-09-16 20:09:46');
INSERT INTO `mcake_invoice` VALUES ('54', '0', '1442407483', '食品', '', '318', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('55', '0', '1442407528', '食品', 'aa', '318', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('56', '0', '1442407655', '食品', 'dd', '318', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('57', '0', '1442407666', '食品', 'dd', '318', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('58', '0', '1442407689', '食品', 'dd', '321', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('59', '0', '1442407836', '食品', 'aa', '', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('60', '0', '1442407858', '食品', 'aa', '322', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('61', '0', '1442408167', '食品', 'aaa', '318', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('62', '0', '1442408177', '食品', 'aaa', '320', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('63', '0', '1442426766', '食品', '的萨法', '284', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('64', '0', '1442427132', '食品', 'geren', '224', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('65', '0', '1442427132', '明细', '马克玛丽', '224', '马克玛丽', 'dangao', '1', 'XDL20150915004', '0', '2015-09-17 02:20:43');
INSERT INTO `mcake_invoice` VALUES ('66', '0', '1442466291', '食品', '小明名', '2416', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('67', '0', '1442466291', '明细', '小明同学', '472', '小明同学', '蛋糕', '1', 'xdl12312123141', '0', '2015-09-17 14:18:47');
INSERT INTO `mcake_invoice` VALUES ('68', '0', '1442466291', '明细', '小明同学', '472', '小明同学', '蛋糕', '1', 'xdl12312123141', '0', '2015-09-17 14:23:19');
INSERT INTO `mcake_invoice` VALUES ('69', '0', '1442489716', '食品', '个人', '1908', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('70', '0', '1442489725', '食品', '个人', '1908', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('71', '0', '1442489770', '食品', '个人', '1908', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('72', '0', '1442489778', '食品', '个人', '1908', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('73', '0', '1442489891', '食品', '个人', '1908', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('74', '0', '1442492268', '食品', '易第优', '866', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('75', '0', '1442492268', '明细', '小明同学', '648', '小明同学', 'dangaodian', '1', 'xdl23123145444', '0', '2015-09-17 20:19:35');
INSERT INTO `mcake_invoice` VALUES ('76', '0', '1442496170', '食品', 'PHP110期', '328', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('77', '0', '1442504398', '食品', '个人', '872', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('78', '0', '1442504417', '食品', '个人', '872', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('79', '0', '1442504454', '食品', '个人', '872', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('80', '0', '1442512465', '食品', 'SCDC', '644', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('81', '0', '1442512549', '食品', 'CDA', '328', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('82', '0', '1442515756', '食品', 'PHP110期', '328', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('83', '0', '1442516040', '食品', 'geren', '2126', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('84', '0', '1442516080', '食品', 'geren', '2127', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('85', '0', '1442516302', '食品', '个人', '218', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('86', '0', '1442520035', '食品', '个人', '226', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('87', '0', '1442540125', '食品', '什么都有限公司', '444', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('88', '0', '1442541709', '食品', 'fdsf', '443', null, null, '0', null, '0', '2015-09-03 00:00:00');
INSERT INTO `mcake_invoice` VALUES ('89', '0', '1442541709', '明细', '马克玛丽', '443', '马克玛丽', '2131232131131', '1', '1231231212312', '0', '2015-09-18 10:04:15');
INSERT INTO `mcake_invoice` VALUES ('90', '0', '1442543253', '食品', '个人', '225', null, null, '0', null, '0', '2015-09-03 00:00:00');

-- ----------------------------
-- Table structure for mcake_material
-- ----------------------------
DROP TABLE IF EXISTS `mcake_material`;
CREATE TABLE `mcake_material` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'materia原材料表l',
  `name` text COMMENT '原材料',
  `country` text COMMENT '图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_material
-- ----------------------------
INSERT INTO `mcake_material` VALUES ('1', '法国奶油', '0');
INSERT INTO `mcake_material` VALUES ('2', '新西兰黄油', '1');
INSERT INTO `mcake_material` VALUES ('3', '法国果茸', '0');
INSERT INTO `mcake_material` VALUES ('4', '比利时白巧克力', '2');
INSERT INTO `mcake_material` VALUES ('5', '马来西亚薄荷糖浆', '3');
INSERT INTO `mcake_material` VALUES ('6', '世界甄选青柠檬', '17');
INSERT INTO `mcake_material` VALUES ('7', '波多黎各朗姆酒', '4');
INSERT INTO `mcake_material` VALUES ('8', '甄选薄荷叶', '17');
INSERT INTO `mcake_material` VALUES ('9', '法国可可粉', '0');
INSERT INTO `mcake_material` VALUES ('10', '韩国幼砂糖', '5');
INSERT INTO `mcake_material` VALUES ('11', '甄选抹茶粉', '17');
INSERT INTO `mcake_material` VALUES ('12', '云南玫瑰汁', '6');
INSERT INTO `mcake_material` VALUES ('13', '法国番石榴糖浆', '0');
INSERT INTO `mcake_material` VALUES ('14', '法国荔枝酒', '0');
INSERT INTO `mcake_material` VALUES ('15', '新西兰奶油奶酪', '1');
INSERT INTO `mcake_material` VALUES ('16', '法国黄油', '0');
INSERT INTO `mcake_material` VALUES ('17', '世界甄选蓝莓', '17');
INSERT INTO `mcake_material` VALUES ('18', '土耳其榛子', '7');
INSERT INTO `mcake_material` VALUES ('19', '也门咖啡', '8');
INSERT INTO `mcake_material` VALUES ('20', '新西兰金色猕猴桃', '1');
INSERT INTO `mcake_material` VALUES ('21', '甄选开心果', '17');
INSERT INTO `mcake_material` VALUES ('22', '云南玫瑰花', '6');
INSERT INTO `mcake_material` VALUES ('23', '巴基斯坦干玫瑰花', '9');
INSERT INTO `mcake_material` VALUES ('24', '美国蔓越莓', '10');
INSERT INTO `mcake_material` VALUES ('25', '马达加斯加香草棒', '11');
INSERT INTO `mcake_material` VALUES ('26', '瑞士白巧克力', '12');
INSERT INTO `mcake_material` VALUES ('27', '甄选荔枝', '17');
INSERT INTO `mcake_material` VALUES ('28', '伊朗开心果', '13');
INSERT INTO `mcake_material` VALUES ('29', '世界甄选樱桃', '17');
INSERT INTO `mcake_material` VALUES ('30', '比利时牛奶巧克力', '2');
INSERT INTO `mcake_material` VALUES ('31', '美国巴旦木仁', '10');
INSERT INTO `mcake_material` VALUES ('32', '爱尔兰百利甜酒', '14');
INSERT INTO `mcake_material` VALUES ('33', '甄选草莓', '17');
INSERT INTO `mcake_material` VALUES ('34', '冻干草莓', '17');
INSERT INTO `mcake_material` VALUES ('35', '比利时黑巧克力', '2');
INSERT INTO `mcake_material` VALUES ('36', '意大利加利安奴酒', '15');
INSERT INTO `mcake_material` VALUES ('37', '墨西哥咖啡酒', '16');
INSERT INTO `mcake_material` VALUES ('38', '美国核桃', '10');
INSERT INTO `mcake_material` VALUES ('39', '防潮糖粉', '17');
INSERT INTO `mcake_material` VALUES ('40', '世界甄选芒果', '17');
INSERT INTO `mcake_material` VALUES ('41', '美国柠檬', '10');
INSERT INTO `mcake_material` VALUES ('42', '法国君度力娇酒', '0');
INSERT INTO `mcake_material` VALUES ('47', '比利时可可脂', '2');
INSERT INTO `mcake_material` VALUES ('48', '法国白兰地', '0');
INSERT INTO `mcake_material` VALUES ('49', '意大利特浓咖啡豆', '15');
INSERT INTO `mcake_material` VALUES ('50', '自煮草莓酱', '17');
INSERT INTO `mcake_material` VALUES ('51', '澳大利亚奶油奶酪', '18');
INSERT INTO `mcake_material` VALUES ('52', '甄选奶油布丁', '17');
INSERT INTO `mcake_material` VALUES ('53', '自制奶油吉士酱', '17');
INSERT INTO `mcake_material` VALUES ('54', '测试测试', '17');

-- ----------------------------
-- Table structure for mcake_material2
-- ----------------------------
DROP TABLE IF EXISTS `mcake_material2`;
CREATE TABLE `mcake_material2` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT COMMENT '原材料表2_goods表用',
  `name` varchar(255) NOT NULL COMMENT '原材料名称',
  `country` varchar(255) NOT NULL COMMENT '所属国家',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_material2
-- ----------------------------
INSERT INTO `mcake_material2` VALUES ('1', '法国奶油', '1');
INSERT INTO `mcake_material2` VALUES ('2', '新西兰黄油', '2');
INSERT INTO `mcake_material2` VALUES ('3', '法国果茸', '1');
INSERT INTO `mcake_material2` VALUES ('4', '比利时白巧克力', '3');
INSERT INTO `mcake_material2` VALUES ('5', '马来西亚薄荷糖浆', '4');
INSERT INTO `mcake_material2` VALUES ('6', '世界甄选青柠檬', '20');
INSERT INTO `mcake_material2` VALUES ('7', '波多黎各朗姆酒', '5');
INSERT INTO `mcake_material2` VALUES ('8', '甄选薄荷叶', '20');
INSERT INTO `mcake_material2` VALUES ('9', '法国可可粉', '1');
INSERT INTO `mcake_material2` VALUES ('10', '韩国幼砂糖', '6');
INSERT INTO `mcake_material2` VALUES ('11', '甄选抹茶粉', '20');
INSERT INTO `mcake_material2` VALUES ('12', '云南玫瑰汁', '7');
INSERT INTO `mcake_material2` VALUES ('13', '法国番石榴糖浆', '1');
INSERT INTO `mcake_material2` VALUES ('14', '法国荔枝酒', '1');
INSERT INTO `mcake_material2` VALUES ('15', '新西兰奶油奶酪', '2');
INSERT INTO `mcake_material2` VALUES ('16', '法国黄油', '1');
INSERT INTO `mcake_material2` VALUES ('17', '世界甄选蓝莓', '20');
INSERT INTO `mcake_material2` VALUES ('18', '土耳其榛子', '8');
INSERT INTO `mcake_material2` VALUES ('19', '也门咖啡', '9');
INSERT INTO `mcake_material2` VALUES ('20', '新西兰金色猕猴桃', '2');
INSERT INTO `mcake_material2` VALUES ('22', '云南玫瑰花', '7');
INSERT INTO `mcake_material2` VALUES ('23', '巴基斯坦干玫瑰花', '10');
INSERT INTO `mcake_material2` VALUES ('24', '美国蔓越莓', '11');
INSERT INTO `mcake_material2` VALUES ('25', '马达加斯加香草棒', '12');
INSERT INTO `mcake_material2` VALUES ('26', '瑞士白巧克力', '13');
INSERT INTO `mcake_material2` VALUES ('27', '甄选荔枝', '20');
INSERT INTO `mcake_material2` VALUES ('28', '伊朗开心果', '14');
INSERT INTO `mcake_material2` VALUES ('29', '世界甄选樱桃', '20');
INSERT INTO `mcake_material2` VALUES ('30', '比利时牛奶巧克力', '3');
INSERT INTO `mcake_material2` VALUES ('31', '美国巴旦木仁', '11');
INSERT INTO `mcake_material2` VALUES ('32', '爱尔兰百利甜酒', '15');
INSERT INTO `mcake_material2` VALUES ('33', '甄选草莓', '20');
INSERT INTO `mcake_material2` VALUES ('34', '冻干草莓', '20');
INSERT INTO `mcake_material2` VALUES ('35', '比利时黑巧克力', '3');
INSERT INTO `mcake_material2` VALUES ('36', '意大利加利安奴酒', '16');
INSERT INTO `mcake_material2` VALUES ('37', '墨西哥咖啡酒', '17');
INSERT INTO `mcake_material2` VALUES ('38', '美国核桃', '11');
INSERT INTO `mcake_material2` VALUES ('39', '防潮糖粉', '20');
INSERT INTO `mcake_material2` VALUES ('40', '世界甄选芒果', '20');
INSERT INTO `mcake_material2` VALUES ('41', '美国柠檬', '11');
INSERT INTO `mcake_material2` VALUES ('42', '法国君度力娇酒', '1');
INSERT INTO `mcake_material2` VALUES ('47', '比利时可可脂', '3');
INSERT INTO `mcake_material2` VALUES ('48', '法国白兰地', '1');
INSERT INTO `mcake_material2` VALUES ('49', '意大利特浓咖啡豆', '16');
INSERT INTO `mcake_material2` VALUES ('50', '自煮草莓酱', '19');
INSERT INTO `mcake_material2` VALUES ('51', '澳大利亚奶油奶酪', '18');
INSERT INTO `mcake_material2` VALUES ('52', '自制奶油布丁', '19');
INSERT INTO `mcake_material2` VALUES ('53', '自制奶油吉士酱', '19');
INSERT INTO `mcake_material2` VALUES ('55', '自制黄油', '19');

-- ----------------------------
-- Table structure for mcake_orders
-- ----------------------------
DROP TABLE IF EXISTS `mcake_orders`;
CREATE TABLE `mcake_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单表',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `linkman` varchar(32) NOT NULL COMMENT '联系人',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `phone` varchar(16) NOT NULL COMMENT '电话',
  `addtime` int(11) NOT NULL COMMENT '购买时间',
  `sendtime` varchar(50) NOT NULL COMMENT '配送时间',
  `total` double(8,2) NOT NULL COMMENT '总金额',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  `oid` varchar(32) NOT NULL,
  `beizhu` varchar(255) DEFAULT NULL COMMENT '订单备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_orders
-- ----------------------------
INSERT INTO `mcake_orders` VALUES ('2', '1', 'levee', 'beijinghuilongguan', '1235466687', '201503822', '周六日以外时间', '323.00', '5', '1231333', '要求快速');
INSERT INTO `mcake_orders` VALUES ('31', '126', '小明', '北京昌平', '2147483647', '2015', '周六日以外的时间', '660.00', '4', '1442305346', '快速发货呀');
INSERT INTO `mcake_orders` VALUES ('34', '1', '小明', '北京昌平', '2147483647', '2015', '13:00', '221.00', '0', '1442317965', '超级vip');
INSERT INTO `mcake_orders` VALUES ('35', '1', '小明', '北京昌平', '2147483647', '2015', '14:00', '233.00', '0', '1442318775', '圣达菲');
INSERT INTO `mcake_orders` VALUES ('36', '1', '马克玛丽', '额外惹我认为', '2147483647', '2015', '12:00', '218.00', '0', '1442319431', 'fas');
INSERT INTO `mcake_orders` VALUES ('37', '1', '马克玛丽', '额外惹我认为', '2147483647', '2015', '12:00', '221.00', '0', '1442319623', 'fas');
INSERT INTO `mcake_orders` VALUES ('38', '1', '马克玛丽', '额外惹我认为', '2147483647', '2015', '12:00', '221.00', '0', '1442319727', 'fas');
INSERT INTO `mcake_orders` VALUES ('39', '126', '马克玛丽', '额外惹我认为', '2147483647', '2015', '12:00', '221.00', '0', '1442319839', 'fas');
INSERT INTO `mcake_orders` VALUES ('40', '126', '马克玛丽', '额外惹我认为', '2147483647', '2015', '12:00', '654.00', '0', '1442368255', 'SDFSDFDSFSDF');
INSERT INTO `mcake_orders` VALUES ('41', '1', '叮当', '北京文化西路', '12321321', '2015', '12:00', '236.00', '0', '1442368853', '916');
INSERT INTO `mcake_orders` VALUES ('42', '126', '叮当', '北京文化西路', '12321321', '2015', '12:00', '1595.00', '5', '1442386118', '0916');
INSERT INTO `mcake_orders` VALUES ('43', '1', '小明', '北京昌平', '2147483647', '2015', '周六日以外的时间', '328.00', '3', '1442393622', '奋斗奋斗是发放');
INSERT INTO `mcake_orders` VALUES ('49', '1', 'b', 'b', '0', '2015', 'aa', '0.00', '0', '1442407836', 'aa');
INSERT INTO `mcake_orders` VALUES ('50', '1', 'b', 'b', '0', '2015', '10', '322.00', '0', '1442407858', 'aa');
INSERT INTO `mcake_orders` VALUES ('51', '127', 'b', 'b', '0', '2015', '10', '318.00', '0', '1442408167', 'sdfdsf');
INSERT INTO `mcake_orders` VALUES ('52', '127', 'b', 'b', '0', '2015', '10', '320.00', '0', '1442408177', 'sdfdsf');
INSERT INTO `mcake_orders` VALUES ('53', '126', '小明', '北京昌平', '2147483647', '2015', '8:00', '284.00', '2', '1442426766', '阿道夫');
INSERT INTO `mcake_orders` VALUES ('54', '126', '马克玛丽', '额外惹我认为', '2147483647', '2015', '9:00', '224.00', '3', '1442427132', 'zuixin');
INSERT INTO `mcake_orders` VALUES ('55', '126', '小明同学', '北京市昌平区回龙观文化西葫芦', '1234567780', '2015', '周六日以外的时间段', '2416.00', '3', '1442466291', '快速发货 9月18日');
INSERT INTO `mcake_orders` VALUES ('56', '127', 'a', 'a', '0', '2015', '2015-9-20 11:30', '1908.00', '0', '1442489716', '');
INSERT INTO `mcake_orders` VALUES ('57', '127', 'a', 'a', '0', '2015', '2015-9-20 11:30', '1908.00', '0', '1442489725', '');
INSERT INTO `mcake_orders` VALUES ('58', '127', 'a', 'a', '0', '2015', '2015-9-20 11:30', '1908.00', '0', '1442489770', '收费的方式');
INSERT INTO `mcake_orders` VALUES ('59', '127', 'a', 'a', '0', '2015', '2015-9-20 11:30', '1908.00', '0', '1442489778', '收费的方式');
INSERT INTO `mcake_orders` VALUES ('60', '127', 'a', 'a', '0', '2015', '2015-9-20 11:30', '1908.00', '0', '1442489891', '收费的方式');
INSERT INTO `mcake_orders` VALUES ('61', '126', '小明同学', '北京市昌平区回龙观文化西葫芦', '1234567780', '2015', '9:00', '866.00', '3', '1442492268', '23424324');
INSERT INTO `mcake_orders` VALUES ('62', '1', '小明同学', '北京市昌平区回龙观文化西葫芦', '1234567780', '2015', '2015-9-20 11:30', '328.00', '0', '1442496170', '请及时送达。谢谢！');
INSERT INTO `mcake_orders` VALUES ('63', '128', '', '', '', '2015', '2015-9-20 11:30', '872.00', '0', '1442504398', '没有');
INSERT INTO `mcake_orders` VALUES ('64', '128', '', '', '', '2015', '2015-9-20 11:30', '872.00', '0', '1442504417', '没有');
INSERT INTO `mcake_orders` VALUES ('65', '128', '', '', '', '2015', '2015-9-20 11:30', '872.00', '0', '1442504454', '没有');
INSERT INTO `mcake_orders` VALUES ('66', '126', '小明', '北京昌平', '2147483647', '2015', 'WDDDW', '644.00', '0', '1442512465', 'SCDSC');
INSERT INTO `mcake_orders` VALUES ('67', '1', '小明', '北京昌平', '2147483647', '2015', 'SVDFR', '328.00', '0', '1442512549', 'CDAV');
INSERT INTO `mcake_orders` VALUES ('68', '1', '马克玛丽', '额外惹我认为', '2147483647', '2015', '2015-9-20 11:30', '328.00', '0', '1442515756', '请及时送达。谢谢！');
INSERT INTO `mcake_orders` VALUES ('69', '127', 'a', 'a', '0', '2015', '646', '2126.00', '0', '1442516040', 'gfh');
INSERT INTO `mcake_orders` VALUES ('70', '127', 'a', 'a', '0', '2015', '646', '2127.00', '0', '1442516080', 'gfh');
INSERT INTO `mcake_orders` VALUES ('71', '127', 'a', 'a', '0', '2015', '2015-9-20 11:30', '218.00', '0', '1442516302', '收费的方式');
INSERT INTO `mcake_orders` VALUES ('72', '126', '马克玛丽', '额外惹我认为', '2147483647', '2015', '2015-9-20 11:30', '226.00', '0', '1442520035', '收费的方式');
INSERT INTO `mcake_orders` VALUES ('73', '126', '马克玛丽', '额外惹我认为', '2147483647', '2015', '明天中午', '444.00', '0', '1442540125', '这是50个以内的汉字!!');
INSERT INTO `mcake_orders` VALUES ('74', '126', '马克玛丽', '额外惹我认为', '2147483647', '2015', '123', '443.00', '4', '1442541709', 'shengrikauile');
INSERT INTO `mcake_orders` VALUES ('75', '126', '马克玛丽', '额外惹我认为', '2147483647', '2015', '2015-9-20 11:30', '225.00', '0', '1442543253', '请及时送达。谢谢！');

-- ----------------------------
-- Table structure for mcake_packing
-- ----------------------------
DROP TABLE IF EXISTS `mcake_packing`;
CREATE TABLE `mcake_packing` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '蛋糕包装表，其额外的包装费用算到总金额里。',
  `oid` int(10) NOT NULL COMMENT '此处是订单编号，自动读入',
  `pay` varchar(32) NOT NULL DEFAULT '0' COMMENT '包装费用',
  `free` varchar(32) DEFAULT '0',
  `describe` varchar(255) NOT NULL,
  `name` varchar(32) DEFAULT '32120' COMMENT '包装名称可以使用编码，不同编码代表不同的包装',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_packing
-- ----------------------------
INSERT INTO `mcake_packing` VALUES ('12', '1442305346', '24', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('13', '1442317482', '24', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('14', '1442317965', '9', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('15', '1442318775', '15', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('16', '1442319623', '9', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('17', '1442319727', '9', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('18', '1442319839', '9', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('19', '1442368853', '12', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('20', '1442386118', '5', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('21', '1442393622', '8', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('22', '1442407689', '3', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('23', '1442407858', '3', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('24', '1442408177', '3', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('25', '1442426766', '66', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('26', '1442427132', '6', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('27', '1442466291', '36', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('28', '1442492268', '12', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('29', '1442496170', '8', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('30', '1442512465', '8', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('31', '1442512549', '8', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('32', '1442515756', '8', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('33', '1442516080', '9', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('34', '1442520035', '8', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('35', '1442540125', '8', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('36', '1442541709', '7', '0', '额外餐具,额外生日蜡烛', '32120');
INSERT INTO `mcake_packing` VALUES ('37', '1442543253', '7', '0', '额外餐具,额外生日蜡烛', '32120');

-- ----------------------------
-- Table structure for mcake_payment
-- ----------------------------
DROP TABLE IF EXISTS `mcake_payment`;
CREATE TABLE `mcake_payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '付款方式和订单关联表',
  `oid` int(11) DEFAULT NULL COMMENT '订单编码',
  `payway` varchar(50) DEFAULT NULL COMMENT '支付方式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_payment
-- ----------------------------
INSERT INTO `mcake_payment` VALUES ('1', '1231333', '货到付款');
INSERT INTO `mcake_payment` VALUES ('2', '1231335', '银联在线支付');
INSERT INTO `mcake_payment` VALUES ('4', '1441794058', '货到付款');
INSERT INTO `mcake_payment` VALUES ('5', '1441796515', '货到付款');
INSERT INTO `mcake_payment` VALUES ('6', '1441796694', '货到付款');
INSERT INTO `mcake_payment` VALUES ('7', '1441796705', '货到付款');
INSERT INTO `mcake_payment` VALUES ('8', '1441796713', '货到付款');
INSERT INTO `mcake_payment` VALUES ('9', '1441796932', '货到付款');
INSERT INTO `mcake_payment` VALUES ('10', '1441797026', '货到付款');
INSERT INTO `mcake_payment` VALUES ('11', '1441797051', '货到付款');
INSERT INTO `mcake_payment` VALUES ('12', '1441797216', '货到付款');
INSERT INTO `mcake_payment` VALUES ('13', '1441797241', '货到付款');
INSERT INTO `mcake_payment` VALUES ('14', '1441797254', '货到付款');
INSERT INTO `mcake_payment` VALUES ('15', '1441797286', '货到付款');
INSERT INTO `mcake_payment` VALUES ('16', '1441797450', '货到付款');
INSERT INTO `mcake_payment` VALUES ('17', '1441797528', '货到付款');
INSERT INTO `mcake_payment` VALUES ('18', '1441797670', '货到付款');
INSERT INTO `mcake_payment` VALUES ('19', '1441798006', '货到付款');
INSERT INTO `mcake_payment` VALUES ('20', '1441798122', '货到付款');
INSERT INTO `mcake_payment` VALUES ('21', '1441798436', '货到付款');
INSERT INTO `mcake_payment` VALUES ('22', '1441798484', '货到付款');
INSERT INTO `mcake_payment` VALUES ('23', '1441798691', '货到付款');
INSERT INTO `mcake_payment` VALUES ('24', '1441799141', '货到付款');
INSERT INTO `mcake_payment` VALUES ('25', '1441799169', '货到付款');
INSERT INTO `mcake_payment` VALUES ('26', '1441821016', '货到付款');
INSERT INTO `mcake_payment` VALUES ('27', '1441821107', '在线支付');
INSERT INTO `mcake_payment` VALUES ('28', '1441821800', '货到付款');
INSERT INTO `mcake_payment` VALUES ('29', '1442192116', '货到付款');
INSERT INTO `mcake_payment` VALUES ('30', '1442197096', '货到付款');
INSERT INTO `mcake_payment` VALUES ('31', '1442199082', '在线支付');
INSERT INTO `mcake_payment` VALUES ('32', '1442199118', '在线支付');
INSERT INTO `mcake_payment` VALUES ('33', '1442299895', '货到付款');
INSERT INTO `mcake_payment` VALUES ('34', '1442299916', '货到付款');
INSERT INTO `mcake_payment` VALUES ('35', '1442300029', '在线支付');
INSERT INTO `mcake_payment` VALUES ('36', '1442300070', '在线支付');
INSERT INTO `mcake_payment` VALUES ('37', '1442300090', '在线支付');
INSERT INTO `mcake_payment` VALUES ('38', '1442300220', '在线支付');
INSERT INTO `mcake_payment` VALUES ('39', '1442300260', '在线支付');
INSERT INTO `mcake_payment` VALUES ('40', '1442300270', '货到付款');
INSERT INTO `mcake_payment` VALUES ('41', '1442300736', '货到付款');
INSERT INTO `mcake_payment` VALUES ('42', '1442300960', '货到付款');
INSERT INTO `mcake_payment` VALUES ('43', '1442300997', '货到付款');
INSERT INTO `mcake_payment` VALUES ('44', '1442301225', '货到付款');
INSERT INTO `mcake_payment` VALUES ('45', '1442301392', '货到付款');
INSERT INTO `mcake_payment` VALUES ('46', '1442301464', '货到付款');
INSERT INTO `mcake_payment` VALUES ('47', '1442301656', '货到付款');
INSERT INTO `mcake_payment` VALUES ('48', '1442301749', '货到付款');
INSERT INTO `mcake_payment` VALUES ('49', '1442301802', '货到付款');
INSERT INTO `mcake_payment` VALUES ('50', '1442301825', '货到付款');
INSERT INTO `mcake_payment` VALUES ('51', '1442305346', '货到付款');
INSERT INTO `mcake_payment` VALUES ('52', '1442317482', '货到付款');
INSERT INTO `mcake_payment` VALUES ('53', '1442317945', '货到付款');
INSERT INTO `mcake_payment` VALUES ('54', '1442317965', '货到付款');
INSERT INTO `mcake_payment` VALUES ('55', '1442318775', '货到付款');
INSERT INTO `mcake_payment` VALUES ('56', '1442319431', '货到付款');
INSERT INTO `mcake_payment` VALUES ('57', '1442319514', '货到付款');
INSERT INTO `mcake_payment` VALUES ('58', '1442319591', '货到付款');
INSERT INTO `mcake_payment` VALUES ('59', '1442319623', '货到付款');
INSERT INTO `mcake_payment` VALUES ('60', '1442319727', '货到付款');
INSERT INTO `mcake_payment` VALUES ('61', '1442319839', '货到付款');
INSERT INTO `mcake_payment` VALUES ('62', '1442368255', '在线支付');
INSERT INTO `mcake_payment` VALUES ('63', '1442368853', '货到付款');
INSERT INTO `mcake_payment` VALUES ('64', '1442386118', '货到付款');
INSERT INTO `mcake_payment` VALUES ('65', '1442393622', '货到付款');
INSERT INTO `mcake_payment` VALUES ('66', '1442407483', '在线支付');
INSERT INTO `mcake_payment` VALUES ('67', '1442407528', '在线支付');
INSERT INTO `mcake_payment` VALUES ('68', '1442407655', '在线支付');
INSERT INTO `mcake_payment` VALUES ('69', '1442407666', '在线支付');
INSERT INTO `mcake_payment` VALUES ('70', '1442407689', '在线支付');
INSERT INTO `mcake_payment` VALUES ('71', '1442407836', '在线支付');
INSERT INTO `mcake_payment` VALUES ('72', '1442407858', '在线支付');
INSERT INTO `mcake_payment` VALUES ('73', '1442408167', '在线支付');
INSERT INTO `mcake_payment` VALUES ('74', '1442408177', '在线支付');
INSERT INTO `mcake_payment` VALUES ('75', '1442426766', '货到付款');
INSERT INTO `mcake_payment` VALUES ('76', '1442427132', '货到付款');
INSERT INTO `mcake_payment` VALUES ('77', '1442466291', '货到付款');
INSERT INTO `mcake_payment` VALUES ('78', '1442489716', '在线支付');
INSERT INTO `mcake_payment` VALUES ('79', '1442489725', '在线支付');
INSERT INTO `mcake_payment` VALUES ('80', '1442489770', '在线支付');
INSERT INTO `mcake_payment` VALUES ('81', '1442489778', '在线支付');
INSERT INTO `mcake_payment` VALUES ('82', '1442489891', '在线支付');
INSERT INTO `mcake_payment` VALUES ('83', '1442492268', '货到付款');
INSERT INTO `mcake_payment` VALUES ('84', '1442496170', '货到付款');
INSERT INTO `mcake_payment` VALUES ('85', '1442504398', '在线支付');
INSERT INTO `mcake_payment` VALUES ('86', '1442504417', '在线支付');
INSERT INTO `mcake_payment` VALUES ('87', '1442504454', '在线支付');
INSERT INTO `mcake_payment` VALUES ('88', '1442512465', '货到付款');
INSERT INTO `mcake_payment` VALUES ('89', '1442512549', '货到付款');
INSERT INTO `mcake_payment` VALUES ('90', '1442515756', '货到付款');
INSERT INTO `mcake_payment` VALUES ('91', '1442516040', '在线支付');
INSERT INTO `mcake_payment` VALUES ('92', '1442516080', '在线支付');
INSERT INTO `mcake_payment` VALUES ('93', '1442516302', '在线支付');
INSERT INTO `mcake_payment` VALUES ('94', '1442520035', '货到付款');
INSERT INTO `mcake_payment` VALUES ('95', '1442540125', '货到付款');
INSERT INTO `mcake_payment` VALUES ('96', '1442541709', '货到付款');
INSERT INTO `mcake_payment` VALUES ('97', '1442543253', '货到付款');

-- ----------------------------
-- Table structure for mcake_returngoods
-- ----------------------------
DROP TABLE IF EXISTS `mcake_returngoods`;
CREATE TABLE `mcake_returngoods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '退换货在个人中心',
  `orginid` int(11) NOT NULL COMMENT '退货原单',
  `liyou` varchar(255) NOT NULL COMMENT '退货理由',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `gid` int(11) NOT NULL COMMENT '退货物品id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_returngoods
-- ----------------------------
INSERT INTO `mcake_returngoods` VALUES ('1', '1', 'fccfcf', '1', '1');

-- ----------------------------
-- Table structure for mcake_rule
-- ----------------------------
DROP TABLE IF EXISTS `mcake_rule`;
CREATE TABLE `mcake_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_rule
-- ----------------------------
INSERT INTO `mcake_rule` VALUES ('18', 'rules', '权限管理', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('17', 'webconfig', '网站设置', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('16', 'Admin/Rule/delete', '权限删除', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('15', 'Admin/Rule/update', '权限更新', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('14', 'Admin/Rule/edit', '权限修改', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('13', 'Admin/Rule/insert', '权限插入', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('12', 'Admin/Rule/index', '权限查询', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('19', 'help', '帮助管理', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('20', 'banner', '轮播管理', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('21', 'orders', '订单管理', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('22', 'material', '原料管理', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('23', 'type', '类别管理', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('24', 'goods', '商品管理', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('25', 'user', '用户管理', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('28', 'Admin/Rule/add', '权限添加', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('27', 'Admin/Index/index', '后台首页', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('29', 'Admin/Group/add', '管理组添加', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('30', 'Admin/Group/insert', '管理组插入', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('31', 'Admin/Group/edit', '管理组修改', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('32', 'Admin/Group/update', '管理组更新', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('33', 'Admin/Group/delete', '管理组删除', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('34', 'Admin/Group/index', '管理组列表', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('35', 'Admin/User/add', '用户添加', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('36', 'Admin/User/insert', '用户插入', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('37', 'Admin/User/edit', '用户修改', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('38', 'Admin/User/update', '用户更新', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('39', 'Admin/User/index', '用户列表', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('40', 'Admin/User/delete', '用户删除', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('41', 'Admin/User/editpass', '用户密码修改', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('42', 'Admin/User/repass', '用户密码重置', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('43', 'Admin/Type/add', '类别添加', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('44', 'Admin/Type/insert', '类别插入', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('45', 'Admin/Type/edit', '类别修改', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('46', 'Admin/Type/update', '类别更新', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('47', 'Admin/Type/delete', '类别删除', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('48', 'Admin/Type/index', '类别列表', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('49', 'Admin/Goods/add', '商品添加', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('50', 'Admin/Goods/insert', '商品插入', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('51', 'Admin/Goods/edit', '商品修改', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('52', 'Admin/Goods/update', '商品更新', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('53', 'Admin/Goods/delete', '商品删除', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('54', 'Admin/Goods/index', '商品列表', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('55', 'Admin/Material/add', '原料添加', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('56', 'Admin/Material/insert', '原料插入', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('57', 'Admin/Material/edit', '原料修改', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('58', 'Admin/Material/update', '原料更新', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('59', 'Admin/Material/delete', '原料删除', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('60', 'Admin/Material/index', '原料列表', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('61', 'Admin/Material/go', '原料来源国', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('62', 'Admin/Orders/index', '订单列表', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('63', 'Admin/Orders/orders', '订单详情', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('64', 'Admin/Orders/save', '订单数据保存', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('65', 'Admin/Orders/delete', '订单删除', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('66', 'Admin/Orders/details', '订单内容', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('67', 'Admin/Orders/pack', '商品包装', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('68', 'Admin/Orders/packsave', '包装修改后的保存', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('69', 'Admin/Orders/invaoice', '发货单列表', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('70', 'Admin/Orders/goodsinvoice', '生成发货单', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('71', 'Admin/Orders/fahuoupdate', '发票修改', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('72', 'Admin/Orders/fahuodelete', '发票删除', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('73', 'Admin/Orders/fapiao', '发票详情', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('74', 'Admin/Orders/fapiaodel', '发票页删除', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('75', 'Admin/Orders/fapiaoprint', '发票打印', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('76', 'Admin/Orders/fahuodan', '发货单管理', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('77', 'Admin/Banner/index', '广告列表', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('78', 'Admin/Banner/update', '广告发布', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('79', 'Admin/Article/add', '帮助添加', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('80', 'Admin/Article/insert', '帮助插入', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('81', 'Admin/Article/index', '帮助列表', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('82', 'Admin/Article/edit', '帮助修改', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('83', 'Admin/Article/upload', '帮助图片上传', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('84', 'Admin/Article/delete', '帮助删除', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('85', 'Admin/Webconfig/index', '设置列表', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('86', 'Admin/Webconfig/update', '设置修改', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('87', 'Admin/Webconfig/detail', '系统信息详情', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('88', 'Admin/Webconfig/mesg', '邮件和短信列表', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('89', 'Admin/Webconfig/messagea', '信息发送', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('91', 'Admin/Orders/fahuodanprint', '发货单打印', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('92', 'Admin/Orders/invoice', '生成发货单', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('93', 'Admin/Orders/fapiaoupdate', '发票状态修改', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('94', 'Admin/Goods/show', 'Admin/Goods/show', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('95', 'Admin/Goods/updata', '商品更新', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('96', 'Admin/Auser/add', '用户添加', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('97', 'Admin/Auser/insert', '用户插入', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('98', 'Admin/Auser/index', '用户列表', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('99', 'Admin/Auser/edit', '用户修改', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('100', 'Admin/Auser/update', '用户更新', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('101', 'Admin/Auser/editpass', '用户修改密码页', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('102', 'Admin/Auser/repass', '用户重置密码', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('103', 'Admin/Auser/delete', '用户删除', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('107', 'Admin/Webconfig/smail', '发送邮件测试', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('108', 'Admin/Webconfig/message', '发送短信后跳转', '1', '1', '');
INSERT INTO `mcake_rule` VALUES ('109', 'Admin/Webconfig/sendMail', '发送邮件测试', '1', '1', '');

-- ----------------------------
-- Table structure for mcake_shopcart
-- ----------------------------
DROP TABLE IF EXISTS `mcake_shopcart`;
CREATE TABLE `mcake_shopcart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '购物车主键',
  `uid` int(11) NOT NULL COMMENT '会员id',
  `gid` int(11) NOT NULL COMMENT '商品磅数',
  `weight` int(11) NOT NULL COMMENT '购买数量',
  `num` int(11) NOT NULL,
  `en_name` varchar(255) NOT NULL,
  `cn_name` varchar(255) NOT NULL COMMENT '商品名称',
  `path` varchar(255) NOT NULL COMMENT '商品图片',
  `price` double NOT NULL,
  `largesses` varchar(255) NOT NULL,
  `subtotal` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_shopcart
-- ----------------------------
INSERT INTO `mcake_shopcart` VALUES ('36', '1', '2', '2', '2', 'Le MOJITO', 'Mojito 柠•漾', '20150904/s_55e943e97de29.jpg', '318', '', '636');
INSERT INTO `mcake_shopcart` VALUES ('38', '6', '0', '0', '1', 'Carré Blanc', '简', '20150904/s_55e942891ab3f.jpg', '218', '', '218');
INSERT INTO `mcake_shopcart` VALUES ('40', '0', '1', '1', '1', 'Carré Blanc', '简', '20150904/s_55e942891ab3f.jpg', '218', '', '218');
INSERT INTO `mcake_shopcart` VALUES ('166', '0', '3', '1', '1', 'Nos jours heureux', '悦时光', '20150904/s_55e94728f0537.jpg', '218', '', '218');
INSERT INTO `mcake_shopcart` VALUES ('202', '128', '2', '1', '1', 'Le MOJITO', 'Mojito 柠•漾', '20150904/s_55e943e97de29.jpg', '218', '', '218');
INSERT INTO `mcake_shopcart` VALUES ('203', '128', '3', '1', '1', 'Nos jours heureux', '悦时光', '20150904/s_55e94728f0537.jpg', '218', '', '218');
INSERT INTO `mcake_shopcart` VALUES ('204', '128', '1', '1', '2', 'Carré Blanc', '简', '20150904/s_55e942891ab3f.jpg', '218', '', '436');
INSERT INTO `mcake_shopcart` VALUES ('232', '127', '2', '1', '2', 'Le MOJITO', 'Mojito 柠•漾', '20150904/s_55e943e97de29.jpg', '218', '', '436');
INSERT INTO `mcake_shopcart` VALUES ('240', '126', '2', '1', '1', 'Le MOJITO', 'Mojito 柠•漾', '20150904/s_55e943e97de29.jpg', '218', '', '218');
INSERT INTO `mcake_shopcart` VALUES ('241', '126', '3', '1', '1', 'Nos jours heureux', '悦时光', '20150904/s_55e94728f0537.jpg', '218', '', '218');

-- ----------------------------
-- Table structure for mcake_shoucang
-- ----------------------------
DROP TABLE IF EXISTS `mcake_shoucang`;
CREATE TABLE `mcake_shoucang` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT COMMENT '收藏id',
  `uid` int(255) NOT NULL COMMENT '用户id',
  `gid` int(255) NOT NULL COMMENT '商品id',
  `gname` varchar(255) NOT NULL COMMENT '商品中文名',
  `shoutime` varchar(32) NOT NULL COMMENT '商品名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_shoucang
-- ----------------------------
INSERT INTO `mcake_shoucang` VALUES ('1', '3', '1', '简', '2015-09-16 21:00:36');
INSERT INTO `mcake_shoucang` VALUES ('2', '3', '2', 'Mojito+柠•漾', '2015-09-16 21:00:42');
INSERT INTO `mcake_shoucang` VALUES ('3', '3', '3', '悦时光', '2015-09-16 21:00:47');
INSERT INTO `mcake_shoucang` VALUES ('4', '3', '4', '悦时光', '2015-09-16 21:00:51');
INSERT INTO `mcake_shoucang` VALUES ('5', '3', '5', '悦时光', '2015-09-16 21:00:56');
INSERT INTO `mcake_shoucang` VALUES ('6', '3', '6', '悦时光', '2015-09-16 21:01:01');
INSERT INTO `mcake_shoucang` VALUES ('7', '3', '7', '悦时光', '2015-09-16 21:01:05');
INSERT INTO `mcake_shoucang` VALUES ('8', '3', '8', '悦时光', '2015-09-16 21:01:10');
INSERT INTO `mcake_shoucang` VALUES ('9', '2', '1', '简', '2015-09-16 21:07:16');
INSERT INTO `mcake_shoucang` VALUES ('10', '2', '2', 'Mojito+柠•漾', '2015-09-16 21:07:22');
INSERT INTO `mcake_shoucang` VALUES ('11', '2', '3', '悦时光', '2015-09-16 21:07:27');
INSERT INTO `mcake_shoucang` VALUES ('12', '2', '4', '悦时光', '2015-09-16 21:07:32');
INSERT INTO `mcake_shoucang` VALUES ('13', '2', '5', '悦时光', '2015-09-16 21:07:38');
INSERT INTO `mcake_shoucang` VALUES ('14', '126', '2', 'Mojito+柠•漾', '2015-09-16 22:49:15');
INSERT INTO `mcake_shoucang` VALUES ('15', '127', '24', '悦时光', '2015-09-17 00:20:53');
INSERT INTO `mcake_shoucang` VALUES ('16', '127', '5', '悦时光', '2015-09-17 16:02:33');
INSERT INTO `mcake_shoucang` VALUES ('17', '127', '4', '悦时光', '2015-09-17 18:40:49');
INSERT INTO `mcake_shoucang` VALUES ('18', '127', '2', 'Mojito+柠•漾', '2015-09-17 18:41:07');
INSERT INTO `mcake_shoucang` VALUES ('19', '128', '1', '简', '2015-09-17 23:35:04');
INSERT INTO `mcake_shoucang` VALUES ('20', '128', '2', 'Mojito+柠•漾', '2015-09-17 23:35:22');
INSERT INTO `mcake_shoucang` VALUES ('21', '126', '3', '悦时光', '2015-09-18 14:25:19');

-- ----------------------------
-- Table structure for mcake_size
-- ----------------------------
DROP TABLE IF EXISTS `mcake_size`;
CREATE TABLE `mcake_size` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL,
  `size1` text,
  `size2` text,
  `size3` text,
  `size5` text,
  `price1` varchar(255) DEFAULT NULL,
  `price2` varchar(255) DEFAULT NULL,
  `price3` varchar(255) DEFAULT NULL,
  `price5` varchar(255) DEFAULT NULL,
  `ordertime1` text,
  `ordertime2` text,
  `ordertime3` text,
  `ordertime5` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_size
-- ----------------------------

-- ----------------------------
-- Table structure for mcake_type
-- ----------------------------
DROP TABLE IF EXISTS `mcake_type`;
CREATE TABLE `mcake_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` varchar(32) DEFAULT NULL COMMENT '分类名字',
  `pid` int(11) DEFAULT NULL COMMENT '父类id号',
  `path` varchar(255) DEFAULT NULL COMMENT '分类路径',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_type
-- ----------------------------
INSERT INTO `mcake_type` VALUES ('1', '拿破仑', '0', '0');
INSERT INTO `mcake_type` VALUES ('2', '鲜奶', '0', '0');
INSERT INTO `mcake_type` VALUES ('3', '慕斯', '0', '0');
INSERT INTO `mcake_type` VALUES ('4', '芝士', '0', '0');
INSERT INTO `mcake_type` VALUES ('6', '咖啡', '0', '0');
INSERT INTO `mcake_type` VALUES ('7', '坚果', '0', '0');
INSERT INTO `mcake_type` VALUES ('9', '水果', '0', '0');

-- ----------------------------
-- Table structure for mcake_user
-- ----------------------------
DROP TABLE IF EXISTS `mcake_user`;
CREATE TABLE `mcake_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户',
  `u_score` int(255) unsigned NOT NULL DEFAULT '0' COMMENT '每位会员的积分',
  `usercount` varchar(255) NOT NULL COMMENT '会员账号',
  `name` varchar(255) NOT NULL COMMENT '会员真实姓名',
  `pass` varchar(255) NOT NULL COMMENT '会员密码',
  `sex` varchar(255) NOT NULL DEFAULT '1' COMMENT '会员性别',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `code` varchar(6) NOT NULL COMMENT '邮编',
  `phone` varchar(16) NOT NULL COMMENT '手机号',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `addtime` datetime NOT NULL COMMENT '注册时间',
  `hover` text NOT NULL COMMENT '爱好',
  `userlevel` varchar(32) DEFAULT NULL COMMENT '用户等级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_user
-- ----------------------------
INSERT INTO `mcake_user` VALUES ('1', '267', '133', 'xiaoming', 'a3590023df66ac92ae35e3316026d17d', '1', 'flasdfjldskjflsjflksdjf', '100220', '12345698798', 'dsfdsfsf@jll.com', '1', '0000-00-00 00:00:00', '343', 'lv1');
INSERT INTO `mcake_user` VALUES ('2', '0', 'hehe', 'hh', 'e10adc3949ba59abbe56e057f20f883e', '1', null, '121212', '23456334332', 'dfsld@ww.com', '1', '2015-08-31 00:00:00', '', 'lv1');
INSERT INTO `mcake_user` VALUES ('5', '0', 'admin', 'admin', '698d51a19d8a121ce581499d7b701668', 'Ů', null, '22222', '13245612245', 'admin@qq.com', '0', '2015-08-31 00:00:00', '', 'lv1');
INSERT INTO `mcake_user` VALUES ('6', '0', 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', '', null, '', '12345656783', 'admin@qq.com', '0', '2015-08-31 00:00:00', '', 'lv1');
INSERT INTO `mcake_user` VALUES ('10', '0', 'heihei', 'sdf', '698d51a19d8a121ce581499d7b701668', '', null, '', '345643', 'sdf@q.com', '0', '2015-08-31 00:00:00', '', 'lv1');
INSERT INTO `mcake_user` VALUES ('18', '0', 'sdd', 'sss', 'b59c67bf196a4758191e42f76670ceba', '', null, '232323', '1212121212', 'sd@dd.com', '0', '2015-08-31 00:00:00', '', 'lv1');
INSERT INTO `mcake_user` VALUES ('22', '0', 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Ů', null, '1111', '123123123', 'admin@qq.com', '0', '2015-08-31 00:00:00', '', 'lv1');
INSERT INTO `mcake_user` VALUES ('107', '0', 'xixi', 'sdf', '00b7691d86d96aebd21dd9e138f90840', 'Ů', null, '11', '222222', 'sfd@sdf.cn', '0', '2015-08-31 00:00:00', '', 'lv1');
INSERT INTO `mcake_user` VALUES ('118', '0', 'fdsasdf', '111', '698d51a19d8a121ce581499d7b701668', 'Ů', null, '', '111111222222', '111@ddd.com', '0', '2015-08-31 00:00:00', '', 'lv1');
INSERT INTO `mcake_user` VALUES ('122', '0', '43', '43', '17e62166fc8586dfa4d1bc0e1742c08b', '', null, '', '43', '43@qq.com', '0', '2015-08-31 00:00:00', '', 'lv1');
INSERT INTO `mcake_user` VALUES ('123', '0', 'adf', '343', '202cb962ac59075b964b07152d234b70', '男', null, '', '132313232131', '23434@dfajlsdf.com', '0', '2015-09-03 00:00:00', '', 'lv1');
INSERT INTO `mcake_user` VALUES ('124', '100', '18611111111', '', 'e10adc3949ba59abbe56e057f20f883e', '', null, '', '18611111111', '', '1', '2015-09-10 23:10:08', '', 'lv1');
INSERT INTO `mcake_user` VALUES ('125', '100', '18611111111', '', 'e10adc3949ba59abbe56e057f20f883e', '', null, '', '18611111111', '', '0', '2015-09-10 23:11:57', '', 'lv1');
INSERT INTO `mcake_user` VALUES ('126', '760', '13001901501', 'changlei', 'e10adc3949ba59abbe56e057f20f883e', '', null, '', '13001901501', '', '1', '2015-09-11 09:47:22', '', 'lv2');
INSERT INTO `mcake_user` VALUES ('127', '5001', '18612345678', 'changjiang', 'e10adc3949ba59abbe56e057f20f883e', '', 'SDF', '43455', '18612345678', '18612345678@QQ.COM', '1', '2015-09-16 00:00:00', '', 'lv4');
INSERT INTO `mcake_user` VALUES ('128', '0', '老子', '老子', '1a100d2c0dab19c4430e7d73762b3423', '1', null, '100001', '15511111111', 'www@qq.com', '1', '2015-09-17 00:00:00', '1,3,7', 'lv1');

-- ----------------------------
-- Table structure for mcake_userlevel
-- ----------------------------
DROP TABLE IF EXISTS `mcake_userlevel`;
CREATE TABLE `mcake_userlevel` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT '会员等级',
  `uid` int(11) DEFAULT NULL COMMENT '会员id',
  `level` tinyint(3) DEFAULT NULL COMMENT '等级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_userlevel
-- ----------------------------

-- ----------------------------
-- Table structure for mcake_userscore
-- ----------------------------
DROP TABLE IF EXISTS `mcake_userscore`;
CREATE TABLE `mcake_userscore` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '会员id',
  `score` varchar(255) DEFAULT NULL COMMENT '积分变化事件',
  `timeout` datetime DEFAULT NULL COMMENT '变化时间',
  `pre_score` varchar(255) DEFAULT NULL COMMENT '每次购买的积分值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcake_userscore
-- ----------------------------
