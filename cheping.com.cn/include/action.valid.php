<?php

/**
 * verify action frequence
 * 所有字母一定要用小写，勿用大写
 * $Id: action.valid.php 771 2015-09-01 06:36:09Z xiaodawei $
 */
#set actionAction access frequence
$action_valid['articleaction'] = array(
    'carreview' => array('min' => 5, 'hour' => 500, 'day' => 1000, 'opt' => '', 'url' => '/'),
);

