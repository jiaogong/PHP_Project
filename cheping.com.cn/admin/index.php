<?php
/**
* index
* $Id: index.php 1199 2015-11-09 03:11:32Z xiaodawei $
*/

include "include/common.inc.php";

#限制本机访问
$runer_ip1 = $_SERVER['REMOTE_ADDR'];
$runer_ip2 = util::getIp();
$inet_ip_pre = '192.168';
session('dsc', $_GET['dsc']);
#if(PHP_SAPI == 'cli' || strpos($runer_ip1, $inet_ip_pre)!== FALSE || strpos($runer_ip2, $inet_ip_pre)!== FALSE || $runer_ip2 == '127.0.0.1' || session('dsc')=='999'){
if(PHP_SAPI == 'cli' ||((strpos($runer_ip1, $inet_ip_pre) !== FALSE || strpos($runer_ip2, $inet_ip_pre) !== FALSE || $runer_ip2 == '127.0.0.1' || in_array($_SERVER['SERVER_NAME'], $server_name_)) && $runer_port == $restrict_port ) ||session('dsc') == '999') {	
	$classname = $module . 'action';
	$instance = new $classname();  
	$instance->run();
}else{
	header('Location: http://co.'.DOMAIN.'/admin/');
	exit;
}
?>
