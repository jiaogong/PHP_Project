<?php

/**
 * WebClient.class.php
 * $Id: webclient.class.php 2483 2016-05-04 10:09:38Z david $
 * @author David.Shaw <tudibao@163.com>
 * require cURL v7.0+
 */
class webClient {

    var $result;
    var $url;
    var $ch;
    var $mod_status = 1;
    var $useragent = "Mozilla/5.0 (Windows NT 6.1; rv:2.0) Gecko/20100101 Firefox/4.0";
    var $cookieFile = '';
    var $postVar = array();
    var $login_match_str = '';
    var $login_url;
    var $login_formdata = array();
    var $login_return = false;
    var $reffer_url;
    var $proxy = 'http://127.0.0.1:8580';

    function __construct() {
        $this->ch = curl_init();
        curl_setopt($this->ch, 10018, $this->useragent);
        $this->setTimeOut();
        return $this;
    }

    function getContent($return = TRUE) {
        $this->setReturns();
        #$this->setRedirectStatus();
        $this->setRedirectCount(2);
        $this->setRedirect();
        $this->setHeaderOut(false);
        if ($this->cookieFile) {
            $this->loadCookieFile($this->cookieFile);
            $this->saveCookieFile($this->cookieFile);
        }

        if (!empty($this->postVar)) {
            $this->setPostVars($this->postVar);
        }

        $this->result = curl_exec($this->ch);

        if ($this->checkLogin()) {
            $tmp_url = $this->url;
            $this->login();

            #if need return back url
            if ($this->login_return) {
                $this->setRedirect(0);
                $this->login_return = false;
                $this->setUrl($tmp_url);
                $this->getContent($this->url);
            }
        }
        if($return){
            return $this->result;
        }
    }

    function setTimeOut() {
        curl_setopt($this->ch, 00013, 300);
        return $this;
    }

    function setUrl($url) {
        $this->url = $url;
        curl_setopt($this->ch, 10002, $url); #10002
        return $this;
    }

    function setUserAgent($ua = '') {
        $ua = $ua ? $ua : $this->useragent;
        curl_setopt($this->ch, 10018, $ua);
        return $this;
    }

    function setPostVars($var = array()) {
        if (!empty($var)) {
            curl_setopt($this->ch, 00047, 1); #00047
            curl_setopt($this->ch, 10015, http_build_query($var)); #10015
        }
        return $this;
    }

    function saveCookieFile($f) {
        curl_setopt($this->ch, 10082, $f); #10082
        return $this;
    }

    function setReferer($ref) {
        curl_setopt($this->ch, 10016, $ref); #10016
        return $this;
    }

    function setHeaderFunc($func) {
        curl_setopt($this->ch, 20079, $func); #20079
        return $this;
    }

    function setHeaderOut($bool = true) {
        curl_setopt($this->ch, 00052, $bool);
        curl_setopt($this->ch, CURLOPT_HEADER, $bool);
        curl_setopt($this->ch, CURLINFO_HEADER_OUT, $bool);
        return $this;
    }

    /**
     * send customer `http request header infomation`
     * @param type $header_array
     */
    function setHttpHeader($header_array = array()) {
        curl_setopt($this->ch, 10023, $header_array);
        return $this;
    }

    function setReturns($bool = true) {
        curl_setopt($this->ch, 19913, $bool);
        return $this;
    }

    function loadCookieFile($f) {
        curl_setopt($this->ch, 10031, $f); #10031
        return $this;
    }

    function setRedirectCount($c = 2) {
        curl_setopt($this->ch, 00068, $c);
        return $this;
    }

    function setCookies($c) {
        curl_setopt($this->ch, 10022, $c);  #10022
        return $this;
    }

    /**
     * set Header `Accept-Encoding`
     * @param type $ae
     */
    function setAcceptEncode($ae = '') {
        if ($ae) {
            curl_setopt($this->ch, 10102, $ae);
        }
        return $this;
    }

    function setRedirectStatus($bool = true) {
        curl_setopt($this->ch, 00052, $bool);
        return $this;
    }

    function getModuleStatus() {
        $msg = array(
            1 => '已完成',
            2 => '测试中',
            3 => '开发中',
            4 => '已删除'
        );

        return $msg[$this->mod_status];
    }

    function checkLogin() {
        return !empty($this->login_formdata) && preg_match('%' . $this->login_match_str . '%si', $this->result);
    }

    function login() {
        #curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        $this->setUrl($this->login_url);
        $this->setPostVars($this->login_formdata);
        $this->setReferer($this->reffer_url);
        $this->result = curl_exec($this->ch);
    }

    function setRedirect($bool = true) {
        curl_setopt($this->ch, 00052, $bool);
        return $this;
    }

    function setProxy($proxy = '', $user = '', $pwd = '') {
        $proxy = $proxy ? $proxy : $this->proxy;
        if ($proxy) {
            curl_setopt($this->ch, 10004, $proxy);

            if ($user && $pwd) {
                curl_setopt($this->ch, 10006, "{$user}:{$pwd}");
            }
        }
        return $this;
    }

    function stripOfficeTag($v) {
        $v = str_replace('<p>&nbsp;</p>', '', $v);
        $v = str_replace('<p />', '', $v);
        $v = preg_replace('%(<span\s*[^>]*>(.*)</span>)%Usi', '\2', $v);
        #$v = preg_replace('%(<span\s*lang="EN-US">(.*)</span>)%Usi', '\2', $v);
        $v = preg_replace('%(\s+class="Mso[^"]+")%si', '', $v);
        $v = preg_replace('%( style="[^"]*mso[^>]*)%si', '', $v);
        $v = preg_replace('%(<table[^>]*>)%si', '<table cellspacing="0" cellpadding="0" bordercolor="#000000" border="1" style="border-collapse: collapse;">', $v);
        $v = preg_replace('/<b><\/b>/', '', $v);
        return $v;
    }

    function setRandAgent($ua = array()) {
        if (!empty($ua)){
            $this->setUserAgent($ua[array_rand($ua, 1)]);
        }
        return $this;
    }

    /**
     * 用正则匹配出需要的内容
     * 
     * @param mixed $regular
     * @param mixed $flag 0.使用preg_match_all匹配 1.使用preg_match匹配
     */
    function pregMatch($regular, $flag = 0) {
        $success = 0;
        if (!$flag)
            $success = preg_match_all($regular, $this->result, $matches);
        else
            $success = preg_match($regular, $this->result, $matches);
        if ($success)
            return $matches;
        else
            return false;
    }

}

?>