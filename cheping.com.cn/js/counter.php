<?php

/**
 * counter
 * $Id: counter.php 2629 2016-05-11 03:21:47Z david $
 * sample: <script src='http://domain.name/js/counter.php?cname=article&c1=频道或分类id&c2=文章id'></script>
 */
require '../include/common.inc.php';

$counter = new counter();

$ip = util::getip();
$useragent = util::getUserAgent($_SERVER['HTTP_USER_AGENT']); #get_browser(null, true);

$os = $useragent['os'];
$browser = $useragent['browser'];
$browserver = $useragent['browserver'];
$referer = $_SERVER['HTTP_REFERER'];
@preg_match('/([a-zA-z\d]{1,32})/si', $_GET['cname'], $matches);
$cname = $matches[1];
if (empty($cname))
    exit;
$c1 = intval($_GET['c1']);
$c2 = intval($_GET['c2']);
$c3 = intval($_GET['c3']);
$buid = str_replace(array('+', '=', '/', ' '), array('', '', '', ''), addslashes($_COOKIE['buid']));
$df = trim(addslashes($_GET['df']));
$data = array(
    'cname' => $cname,
    'c1' => $c1,
    'c2' => $c2,
    'c3' => $c3,
    'ip' => $ip,
    'os' => $os,
    'browser' => $browser,
    'browserver' => $browserver,
    'referer' => $df ? $df : $referer,
    'timeline' => $timestamp,
    'sid' => $buid,
);
$counter->addCounter($data);

if ($counter->isError()) {
    @error_log($sql . "\r\n", 3, SITE_ROOT . "data/log/counter.err.log");
}
?>
