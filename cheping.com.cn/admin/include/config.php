<?php

/**
 * config.php的模板文件
 * 使用时，去掉文件名的.default 并修改里面的具体配置值
 * $Id$
 * @author David.Shaw <tudibao@163.com>
 */
define('SITE_ROOT', substr(dirname(__FILE__), 0, -7));
define('SITE_CHARSET', "utf-8");
define('SITE_NAME', "车评网后台管理系统");
define('WWW_ROOT', SITE_ROOT . "../");
define('ADMIN_PATH', "/admin/");
define('UPLOAD_DIR', "attach/");
define('ATTACH_DIR', WWW_ROOT . UPLOAD_DIR);
define('RELAT_DIR', '/');
define('FTP_DIR', WWW_ROOT . 'admin/data/tmp/');
define('DOMAIN', "cp.com");
define('RWURL', 1);

define('DB_CHARSET', "utf8");
define('DBTYPE', "mysql");
define('DBHOST', "192.168.2.254:33066");
define('DBUSER', "root");
define('DBPASS', "!zdc123");
define('DBNAME', "cheping");

define('COOKIE_PRE', "cpa_"); //session & cookie prefix string
define('ENCRYPT', 'AES');
define('SKEY', 'wYwSpUz6diTorPAFfddKKm4nqKSpVY5u');


date_default_timezone_set('Asia/Shanghai');

//mail settings
/*$mail_setting = array(
    'maildelimiter' => 1,
    'mailusername' => SITE_NAME,
    'mailsend' => 2,
    'mailauth' => 1,
    'mailserver' => 'smtp.xxx.com',
    'mailport' => 25,
    'mailauth_username' => 'xxxx',
    'mailauth_password' => '123456',
    'mailfrom' => 'xxxx@xxx.com',
);*/

$local_path = SITE_ROOT;
$local_host="http://www.".DOMAIN."/";
$local_ip="http://127.0.0.1/";
$relative_dir = RELAT_DIR;
$admin_path = ADMIN_PATH;

/*$attach_server = array(
  'http://img1.' . DOMAIN,
  'http://img2.' . DOMAIN,
  'http://img3.' . DOMAIN,
  'http://img4.' . DOMAIN,
  'http://img5.' . DOMAIN,
);*/

if($relative_dir) {
  $local_host = substr($local_host, 0, -1) . $relative_dir;
}else{
  $relative_dir = "/";
}

$db_charset = DB_CHARSET;

$timestamp = time(); 
$today = date('Y/m/d');

$watermark = 1;    //1开始水印，0关闭水印 ''/images/watermark/watermark.png''
$watermark_opt = 0;    //0 require GD lib, 1 require Imagick lib
$upload_basedir = UPLOAD_DIR;

#$dfile = "file://localhost/path=" . ATTACH_DIR;
$dfile = "ftp://attach:attach@192.168.1.206/path=/";

define("CACHE_API", "memcache"); // value is 'file' or 'memcache'
//define("M_SERVER", "192.168.2.254");
define("M_SERVER", "127.0.0.1");
define("M_PORT", 11211);
define('M_STORE_TIME', 3600);

define('CACHE_DSN', CACHE_API.'://'.M_SERVER.':'.M_PORT . '/persistent=1&timeout=3000');

/*define('DB_DSN', DB_API.'://'.DB_USER.':'.DB_PW.'@'.DB_HOST.':'.DB_PORT.'/dbtype='.DB_TYPE.'&dbname='.DB_NAME.'&charset='.DB_CHARSET.'&persistent='.DB_CONNECT);
*/
?>
