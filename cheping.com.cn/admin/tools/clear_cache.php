<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 require_once('../include/common.inc.php');
 global $_caches;
 
 $ret = $_caches->removeCache($_GET['key']);
 print_r($ret);
 exit;

?>
