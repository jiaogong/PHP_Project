<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once "../include/common.inc.php";
$code = util::random(5, 3);
session("bingo_code", $code);
util::makecode($code);
?>
