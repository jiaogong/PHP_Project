<?php

/**
 * 用户登录页面action
 * $Id: loginaction.php 2840 2016-06-01 10:51:14Z wangqin $
 * @author David Shaw <tudibao@163.com>
 */
class loginAction extends action {

    function __construct() {
        parent::__construct();
        $this->user = new users();
        $this->smstpl = new smsTpl();
        $this->soapmsg = new soapmsg();
        $this->shortmsg = new shortMsg();
    }

    function doSendCode() {
        $phone = filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_NUMBER_INT);

        #如果不是正确手机号，返回错误代码
        if (!util::checkMobile($phone)) {
            return 1;
        }
        $code = mt_rand(1000, 9999);
        session("get_code", $code);
        $msgTpl = $this->smstpl->getTpl($this->shortmsg->tpl_flag['get_code']);
        $msg = str_replace('{$get_code}', $code, $msgTpl);

        $state = $this->soapmsg->postMsg($phone, $msg);

        if ($state == 2)
            $this->shortmsg->recordMsg(0, $state, $this->shortmsg->tpl_flag['get_code'], $phone, $msg);
        echo $state;
    }

    function doCheckCode() {
        $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_MAGIC_QUOTES);
        $get_pcode = session("get_code");
        if ($get_pcode == $code) {
            echo 1;
        } else {
            echo -4;
        }
    }

    function doChkUname() {
        $uid = 0;
        $username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_MAGIC_QUOTES);
        $phoneReg = '/^(13|18|15|17)\d{9}/';
        if (preg_match($phoneReg, $username)) {
            $uid = $this->user->getUser('uid', "uphone='$username'", 1);
        } else {
            $uid = $this->user->getUser('uid', "uname='$username'", 1);
        }
        echo intval($uid);
    }

    function doLogout() {

        if ($_GET[id] == 1) {
            unset_session('uid');
            unset_session('uid');
            unset_session('uid');
            cookie('data', 1, 0);
            global $local_host;
            echo json_encode($local_host);
        } else {
            unset_session('uid');
            unset_session('uid');
            unset_session('uid');
            cookie('data', 1, 0);
            echo 1;
        }
    }

    function dogetPassword() {
        $tpl_name = "getpassword";
        $css = array("index", "password_zhaohui");
        $js = array("jquery-1.8.3.min", 'global');
        $this->vars('css', $css);
        $this->vars('js', $js);
        $referer = $_SERVER['HTTP_REFERER'];
        if (strpos($referer, 'login.php') || strpos($referer, 'register.php')) {
            cookie('getpw_referer', '/');
        } else {
            cookie('getpw_referer', $referer);
        }
        $title = "找回密码-" . SITE_NAME;
        $keyword = "ams车评网,找回密码";
        $description = "ams车评网找回密码。ams车评网每天推出精品车评资讯、视频等内容，定期为车评网会员举办各种线下体验活动，还不赶紧加入我们。";
        $this->vars('title', $title);
        $this->vars('keyword', $keyword);
        $this->vars('description', $description);
        $this->template($tpl_name, '', 'replaceNewsChannel');
    }

    function doupdatePassword() {
        $mobile = filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_NUMBER_INT);

        #如果不是正确手机号，返回错误代码
        if (!util::checkMobile($mobile)) {
            return 1;
        }
        $password = dstring::stripscript($_POST['password']);

        $get_pcode = session("get_code");
        $code = $_POST['code'];
        if ($code == $get_pcode) {
            $this->user->ufields = array("password" => md5($password));
            $this->user->where = "mobile=$mobile";
            $id = $this->user->update();

            $user = $this->user->getUser('id,mobile,username', "mobile='{$mobile}'", 1);
            session('uid', $user['id']);
            session('username', $user['username']);
            $url = cookie('getpw_referer');
            echo json_encode($url);
        } else {
            echo 2;
        }
    }

    function dochecklogin() {
        $cookieUid = intval(cookie('header_uid'));
        $cookieUser = cookie('data');
        if (session('uid')) {
            $sessionid = session('uid');
            $user = $this->user->getUser('id,mobile,username', "id='{$sessionid}'", 1);
            echo json_encode(array('msg' => 'ok', 'user' => $user[username], 'userid' => $sessionid));
        } elseif ($cookieUid && $cookieUser) {
            $user = $this->user->getUser('id,username,mobile,password', "id='{$cookieUid}'", 1);
            $md51 = md5($user['username'] . $user['password']);

            if ($md51 == $cookieUser) {
                $username = $user['username'];
                session('uid', $cookieUid);
                session('username', $username);
                echo json_encode(array('msg' => 'ok', 'user' => $username, 'uid' => $cookieUid));
            } else {
                unset_session('uid');
                unset_session('username');
                echo json_encode(array('msg' => 'error0'));
            }
        } else {
            unset_session('uid');
            unset_session('username');
            echo json_encode(array('msg' => 'error1'));
        }
    }

    function doDefault() {
        $template = 'login';
        $css = array("index", "dl");
        $js = array("jquery-1.8.3.min", 'global');
        $this->vars('css', $css);
        $this->vars('js', $js);
        $user = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_MAGIC_QUOTES);
        $pwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_MAGIC_QUOTES);
        $type = intval($_POST['type']);
        if ($user && $pwd) {
            $pwd = md5($pwd);
            $phoneReg = '/^(13|18|15|17)\d{9,}$/';

            if (preg_match($phoneReg, $user)) {
                $uid = $this->user->getUser('id, password,username', "mobile='{$user}'", 1);
                echo $this->user->sql;die;
            } else {
                $uid = $this->user->getUser('id, password,username', "username='{$user}'", 1);
            }

            if ($uid && $pwd == $uid['password']) {
                session('uid', $uid['id']);
                session('username', $uid['username']);
                if ($type) {
                    cookie('data', md5($uid['username'] . $pwd), 3600 * 24 * 30);
                    cookie('header_uid', $uid['id'], 3600 * 24 * 30);
                }
                $loginReferer = cookie('login_referer');

                if ($loginReferer) {
                    header("location:$loginReferer");
                } else {
                    header("location:/");
                }
                exit;
            } else {
                $this->alert('用户名和密码不符', 'js', 3, 'login.php');
            }
        }
        if (empty($user)) {
            $referer = $_SERVER['HTTP_REFERER'];
            if (strpos($referer, 'login.php') || strpos($referer, 'register.php')) {
                
            } else {
                cookie('login_referer', $referer);
            }
        }
        $title = "会员登录-" . SITE_NAME;
        $keyword = "ams车评网,会员登录";
        $description = "ams车评网登录页面。ams车评网每天推出精品车评资讯、视频等内容，定期为车评网会员举办各种线下体验活动，还不赶紧加入我们。";
        $this->vars('title', $title);
        $this->vars('keyword', $keyword);
        $this->vars('description', $description);
        $this->template($template, '', 'replaceNewsChannel');
    }

    function dochecklogins() {
        $user = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_MAGIC_QUOTES);
        $pwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_MAGIC_QUOTES);
        $pwd = md5($pwd);
        $type = intval($_POST['type']);
        $phoneReg = '/^(13|18|15|17)\d{9,}$/';
        if (preg_match($phoneReg, $user)) {
            $uid = $this->user->getUser('id, password,username', "mobile='{$user}'", 1);
        } else {
            $uid = $this->user->getUser('id, password,username', "username='{$user}'", 1);
        }
        if ($uid && $pwd == $uid['password']) {
            session('uid', $uid['id']);
            session('username', $uid['username']);
            if ($type) {
                cookie('data', md5($uid['username'] . $pwd), 3600 * 24 * 30);
                cookie('header_uid', $uid['id'], 3600 * 24 * 30);
            }
            $loginReferer = cookie('login_referer');
            if ($loginReferer) {
                echo json_encode(array('msg' => '1', 'url' => $loginReferer));
            } else {
                echo json_encode(array('msg' => '2', 'url' => '/'));
            }
        } else {
            echo -1;
        }
    }

    function doajaxlogin() {
        #allow CORS access
        #util::allowCORS();
        
        $user = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_MAGIC_QUOTES);
        $pwd = $_POST['password'];
        $type = $_POST['type'];
        if ($user && $pwd) {
            $pwd = md5($pwd);
            $phoneReg = '/^(13|18|15|17)\d{9,}$/';
            if (preg_match($phoneReg, $user)) {
                $uid = $this->user->getUser('id, password,username', "mobile='$user'", 1);
            } else {
                $uid = $this->user->getUser('id, password,username', "username='$user'", 1);
            }
            if ($uid && $pwd == $uid['password']) {

                session('uid', $uid['id']);
                session('username', $uid['username']);
                if ($type) {
                    cookie('data', md5($uid['username'] . $pwd), 3600 * 24 * 30);
                    cookie('header_uid', $uid['id'], 3600 * 24 * 30);
                }
                echo $uid[id];
            } else {
                echo -4;
            }
        } else {
            echo -4;
        }
    }

}
