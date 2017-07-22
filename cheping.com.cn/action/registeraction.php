<?php

/**
 * 用户注册页面action
 * $Id: registeraction.php 983 2015-10-22 04:56:45Z xiaodawei $
 * @author David Shaw <tudibao@163.com>
 */
class registerAction extends action {

    function __construct() {
        parent::__construct();
        $this->user = new users();
        $this->soapmsg = new soapmsg();
        $this->shortmsg = new shortmsg();
        $this->smstpl = new smsTpl();
    }

    function doDefault() {
        $this->doregister();
    }

    function doRegister() {
        $tpl_name = 'register';
        $css = array("index", "zc");
        $js = array("jquery-1.8.3.min", 'global');

        $this->vars('css', $css);
        $this->vars('js', $js);
        $title = "会员注册-" . SITE_NAME;
        $keyword = "会员注册,ams车评网";
        $description = "新会员注册，成为ams车评网会员，ams车评网每天推出精品车评资讯、视频等内容，定期为车评网会员举办各种线下体验活动，还不赶紧加入我们。";
        $this->vars("title", $title);
        $this->vars("keyword", $keyword);
        $this->vars("description", $description);
        $this->template($tpl_name, '', 'replaceNewsChannel');
    }

    function doChkUsername() {
        $username = $_GET['username'];
        $uid = $this->user->getuser('id', "username = '$username'", 3);
        if ($uid) {
            echo $uid;
        } else {
            echo -4;
        }
    }

    function doChkMoblie() {
        $mobile = $_GET['mobile'];
        $uid = $this->user->getUser('id', "mobile = '$mobile'", 3);

        if ($uid) {
            echo $uid;
        } else {
            echo -4;
        }
    }

    function doCheckCode() {
        $code = $_GET['code'];
        $reg_code = session("reg_code");
        if ($reg_code == $code) {
            echo 1;
        } else {
            echo -4;
        }
    }

    function doSendCode() {
        $phone = $_GET['mobile'];
        $code = mt_rand(1000, 9999);
        session("reg_code", $code);
        $msgTpl = $this->smstpl->getTpl($this->shortmsg->tpl_flag['reg_code']);

        $msg = str_replace('{$reg_code}', $code, $msgTpl);
        $state = $this->soapmsg->postMsg($phone, $msg);

        if ($state == 2)
            $this->shortmsg->recordMsg(0, $state, $this->shortmsg->tpl_flag['reg_code'], $phone, $msg);
        echo $state;
    }

    function dosubform() {
        $tpl_name = "register_success";
        $css = array("index", "zccg");
        $js = array("jquery-1.8.3.min", 'global');
        $this->vars('css', $css);
        $this->vars('js', $js);
        if ($_POST) {

            $username = trim($_POST['username']);
            $mobile = $_POST['mobile'];
            $code = $_POST['code'];
            $password = md5($_POST['password']);

            $mphone_reg = "/^(13|18|15|17)\d{9,9}$/";
            $username_reg = "/^[a-zA-Z0-9_u4e00-u9fa5]{3,20}[^_]$/";
            if (!preg_match($mphone_reg, $mobile)) {
                $this->alert('手机号不正确', 'js', 3, 'register.php?action=register');
            }
            if (!preg_match($username_reg, $username)) {
                $this->alert('用户名不符合要求', 'js', 3, 'register.php?action=register');
            }
            $reg_code = session("reg_code");
            if ($reg_code != $code) {
                $this->alert('验证码不正确', 'js', 3, 'register.php?action=register');
            }
            $is_name = $this->user->getUser('id', "mobile = '$mobile' or username='$username'", 3);
            if ($is_name) {
                $this->alert('手机号或用户名已使用', 'js', 3, 'register.php?action=register');
            }
            $ip = util::getip();
            $this->user->ufields = array("username" => "$username", "password" => "$password", "mobile" => "$mobile", "state" => "1", "created" => time(), "reg_ip" => "$ip");
            $id = $this->user->insert();

            if ($id) {
                session('username', $username);
                session('uid', $id);
            } else {
                $this->alert('提交信息有误，请重新填写', 'js', 3, 'register.php?action=register');
            }
        }
        $title = "注册成功-" . SITE_NAME;
        $keyword = "注册成功,车评网";
        $description = "恭喜您，成功注册为车评网新会员！ ";
        $this->vars("title", $title);
        $this->vars("keyword", $keyword);
        $this->vars("description", $description);
        $this->template($tpl_name, '', 'replaceNewsChannel');
    }

}
