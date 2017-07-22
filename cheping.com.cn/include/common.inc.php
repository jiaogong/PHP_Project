<?php

/**
 * common include file
 * $Id: common.inc.php 2922 2016-06-06 03:35:27Z wangqin $
 */
error_reporting(7);

require_once "config.php";

#pear
set_include_path(SITE_ROOT . 'lib/PEAR');
ini_set('default_charset', SITE_CHARSET);

require_once SITE_ROOT . "lib/PEAR/DB.php";
require_once SITE_ROOT . 'lib/file.class.php';
require_once SITE_ROOT . 'lib/util.class.php';
require_once SITE_ROOT . 'lib/dstring.class.php';
require_once SITE_ROOT . 'lib/httpfilter.class.php';
require_once SITE_ROOT . 'lib/template.class.php';
require_once SITE_ROOT . 'lib/dcache.class.php';
require_once SITE_ROOT . 'lib/object.class.php';
require_once SITE_ROOT . 'lib/model.class.php';
require_once SITE_ROOT . 'lib/action.class.php';
require_once SITE_ROOT . 'lib/multipage.class.php';
require_once  SITE_ROOT . 'include/global.func.php';
require_once SITE_ROOT . 'lib/imagemark.class.php';

if (!defined('DBNAME2'))
    define('DBNAME2', DBNAME);

#init Cache
if (defined('CACHE_DSN'))
    $_cache = & dcache::getInstance(CACHE_DSN);

#user agent
if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
    $_ENV['browser'] = 'firefox';
} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
    $_ENV['browser'] = 'msie';
} elseif (preg_match('/(applewebkit|uc).*?mobile/is', $_SERVER['HTTP_USER_AGENT'])) {
    $_ENV['browser'] = 'mobile';
} else {
    $_ENV['browser'] = 'other';
}

#os
if (DIRECTORY_SEPARATOR == '\\') {
    $_ENV['os'] = 'win';
} else {
    $_ENV['os'] = 'other';
}

$_SERVER['PHP_SELF'] = dstring::stripscript($_SERVER['PHP_SELF']);
$_SERVER['PHP_SELF'] = str_replace('.php/', '.php', $_SERVER['PHP_SELF']);
foreach ($_GET as $k => $v) {
    $_GET[$k] = dstring::stripscript($v);
}
#access log.
//$ip = util::getip();
//$useragent = util::getUserAgent($_SERVER['HTTP_USER_AGENT']); #get_browser(null, true);
//$buid = str_replace(array('+', '=', '/', ' '), array('', '', '', ''), addslashes($_COOKIE['buid']));
//@preg_match('%(\w+)\.php\?(action=(\w+)&)?%im', strtolower($_SERVER['REQUEST_URI']), $match);
//$mod = array(
//    'class' => $match[1] . 'action',
//    'method' => $match[3] ? $match[3] : 'default',
//    'ip' => $ip,
//    'sid' => $buid,
//    'useragent' => $_SERVER['HTTP_USER_AGENT'],
//    'timeline' => $timestamp,
//);
#log用户访问的action及method
//logUserAccess($mod);
#各action限制
//verifyUserAccess($mod);

