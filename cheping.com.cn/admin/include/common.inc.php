<?php

/**
 * common include file
 * $Id: common.inc.php 1996 2016-04-08 09:30:40Z wangchangjiang $
 * @author David.Shaw <tudibao@163.com>
 */
error_reporting(7);
@session_start();

require_once "config.php";

#pear
//set_include_path(SITE_ROOT . 'lib/PEAR');
//ini_set('default_charset', SITE_CHARSET);

require_once SITE_ROOT . 'lib/db.php';
require_once SITE_ROOT . 'lib/file.class.php';
require_once SITE_ROOT . 'lib/util.class.php';
require_once SITE_ROOT . 'lib/drequest.class.php';
#require_once SITE_ROOT . 'lib/httpfilter.class.php';
require_once SITE_ROOT . 'lib/dstring.class.php';
require_once SITE_ROOT . 'lib/template.class.php';
require_once SITE_ROOT . 'lib/dcache.class.php';
require_once SITE_ROOT . 'lib/object.class.php';
require_once SITE_ROOT . 'lib/model.class.php';
require_once SITE_ROOT . 'lib/action.class.php';
require_once SITE_ROOT . 'lib/imagemark.class.php';
require_once SITE_ROOT . "include/global.func.php";
require_once SITE_ROOT . "include/action_power.inc.php";

if (ini_get('short_open_tag') !== '1' || (ini_get('display_errors') === '1' && error_reporting() === E_ALL)) {
    die("open php.ini file, modify short_open_tag=On; display_errors=On;error_reporting=E_ALL & ~E_NOTICE & ~E_STRICT\n");
}
if(!extension_loaded('mcrypt')){
    die("not found `mcrypt` module, check configure in php.ini file!\n");
}

if (!defined('DBNAME2'))
    define('DBNAME2', DBNAME);

#init Cache
if (defined('CACHE_API'))
    $_cache = & dcache::getInstance(CACHE_DSN);

#user agent
if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
    $_ENV['browser'] = 'firefox';
} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
    $_ENV['browser'] = 'msie';
} else {
    $_ENV['browser'] = 'other';
}

#os
if (DIRECTORY_SEPARATOR == '\\') {
    $_ENV['os'] = 'win';
} else {
    $_ENV['os'] = 'other';
}

$adminauth = new adminAuth();
$login_uid = session('user_id');
$login_uname = session('username');

foreach ($_GET as $k => $v) {
    $$k = $_GET[$k] = dstring::stripscript($_GET[$k]);
}

@preg_match('%([a-zA-Z0-9\_\-]*)%', $_GET['action'], $matches);
$vars = $matches[1];
list($module, $action) = explode('-', $vars);

if (!$module) {
    $action = 'showlogin';
    $module = 'login';
}
$_GET['action'] = $action;
$_ENV['module'] = $module;
$_ENV['PHP_SELF'] = $_SERVER['PHP_SELF'] . "?action=" . $_ENV['module'] . "-";

$cardb_state = array(
    0 => "删除",
    1 => "草稿",
    2 => "待审核",
    6 => "待审核(缺参数)",
    3 => "正常",
    7 => "正常(缺参数)",
    4 => "未通过",
    5 => "屏蔽",
    8 => "停产在售",
    9 => "停产停售",
    10 => "待审核(未上市)",
    11 => "正常(未上市)",
);
