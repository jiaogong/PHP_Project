<?php

/**
 * ad click action
 * $Id: myurlaction_1.php 764 2015-08-31 09:57:47Z cuiyuanxin $
 */
class meAction extends action {

    public $counter;

    function __construct() {
        parent::__construct();
        $this->counter = new counter();
    }

    function doDefault() {
        $this->doCounter();
    }

    function doCounter() {
        $ip = util::getip();
        $useragent = util::getUserAgent($_SERVER['HTTP_USER_AGENT']); #get_browser(null, true);

        $os = $useragent['os'];
        $browser = $useragent['browser'];
        $browserver = $useragent['browserver'];
        $referer = $_SERVER['HTTP_REFERER'];
        #myurl.php?cname=myurl&c1=1&c2=1&c3=1 == http://fyc.cheping.com.cn/research/
        @preg_match('/([a-zA-z\d]{1,32})/si', $_GET['cname'], $matches);
        $cname = $matches[1];
        if (empty($cname))
            exit;
        $c1 = intval($_GET['c1']);
        $c2 = intval($_GET['c2']);
        $c3 = intval($_GET['c3']);
        $buid = str_replace(array('+', '=', '/', ' '), array('', '', '', ''), addslashes($_COOKIE['buid']));

        $data = array(
            'cname' => $cname,
            'c1' => $c1,
            'c2' => $c2,
            'c3' => $c3,
            'ip' => $ip,
            'os' => $os,
            'browser' => $browser,
            'browserver' => $browserver,
            'referer' => $referer,
            'timeline' => $this->timestamp,
            'sid' => $buid,
        );
        $ret = $this->counter->addCounter($data);
        //redirect url
        @header('Location: http://fyc.cheping.com.cn/research/');
    }

}
