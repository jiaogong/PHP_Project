<?php
return array(
	'WEBPOWER'=>'ON',
	'DB_TYPE'=>'mysql',
	'DB_NAME'=>'mcake',
	'DB_USER'=>'root',
	'DB_PWD'=>'',
	'DB_HOST'=>'localhost',
	'DB_CHARSET'=>'utf8',
	'OFFLINEMESSAGE'=>'本站正在维护中，暂不能访问。<br /> 请稍后再访问本站。',
	'__UPLOAD__'=>'/mcake/Uploads/Admin/images',


	'AUTH_CONFIG' => array(
	    'AUTH_ON' => true,  // 认证开关
	    'AUTH_TYPE' => 1, // 认证方式，1为实时认证；2为登录认证。
	    'AUTH_GROUP' => 'mcake_group', // 用户组数据表名
	    'AUTH_GROUP_ACCESS' => 'mcake_group_access', // 用户-用户组关系表
	    'AUTH_RULE' => 'mcake_rule', // 权限规则表
	),

);

?>