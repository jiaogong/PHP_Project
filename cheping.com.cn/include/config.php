<?php
@session_start();   
define('SITE_ROOT', substr(dirname(__FILE__), 0, -7));
define('SITE_CHARSET', "utf-8");
define('SITE_NAME', "车评网");
define('WWW_ROOT', SITE_ROOT . "../");
define('ADMIN_PATH', "/admin/");
define('UPLOAD_DIR', "attach/");
define('ATTACH_DIR', SITE_ROOT . UPLOAD_DIR);
define('DOMAIN', "cheping.cn");
define('COOKIE_PRE', "cpp_");
define('RWURL',0);

//ready only
define('DB_CHARSET', "utf8");
define('DBTYPE', "mysql");
define('DBHOST', "192.168.2.254:33066");
define('DBUSER', "root");
define('DBPASS', "!zdc123");
define('DBNAME', "cheping");

//writable
//define('DBHOST_S', "192.168.2.254:33066");
//define('DBUSER_S', "root");
//define('DBPASS_S', "!zdc123");
//define('DBNAME_S', "cheping");

date_default_timezone_set('Asia/Shanghai');

//mail settings
$mail_setting = array(
    'maildelimiter' => 1,
    'mailusername' => SITE_NAME,
    'mailsend' => 2,
    'mailauth' => 1,
    'mailserver' => 'smtp.xxx.com',
    'mailport' => 25,
    'mailauth_username' => 'xxxx',
    'mailauth_password' => '123456',
    'mailfrom' => 'xxxx@xxx.com',
);

$local_path = SITE_ROOT;

$local_host="http://bo." . DOMAIN . "/";
$local_ip="http://127.0.0.1/";
$relative_dir = "/";  #if not subdir, comment this
$admin_path = ADMIN_PATH;

//$attach_server = array(
//  'http://img1.' . DOMAIN,
//  'http://img2.' . DOMAIN,
//  'http://img3.' . DOMAIN,
//  'http://img4.' . DOMAIN,
//  'http://img5.' . DOMAIN,
//);

if($relative_dir) {
  $admin_path = $relative_dir . substr($admin_path, 0, -1);
  $local_host = substr($local_host, 0, -1) . $relative_dir;
}else{
  $relative_dir = "/";
}

$db_charset = DB_CHARSET;

$timestamp = time(); 
$today = date('Y/m/d');

$watermark = 1;    //1开始水印，0关闭水印 ''/images/watermark/watermark.png''

#$brand_df_status = 3;
#$factory_df_status = 3;
#$series_df_status = 3;
#$model_df_status = 3;     

$cache_server = array(
    'type' => 'file',   /*value is 'file' or 'memcache'*/
    'server' => '192.168.2.254',
    'port' => 11211,
    'expire_time' => 3600
);
define('CACHE_DSN', $cache_server['type'].'://'.$cache_server['server'].':' . $cache_server['port'] . '/persistent=1&timeout=3000');
/*
$cache_server2 = array(
    'type' => 'memcache',
    'server' => '127.0.0.1',
    'port' => 11212,
    'expire_time' => 3600
);
define('CACHE_DSN2', $cache_server2['type'].'://'.$cache_server2['server'].':' . $cache_server2['port'] . '/persistent=1&timeout=3000');
*/
?>
