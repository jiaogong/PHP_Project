<?php

/**
 * wap视频页 video
 * $Id: wapvideoaction.php 983 2015-11-23 10:56:45Z cuiyuanxin $
 */
class wapregisterAction extends action {

    function __construct() {
        parent::__construct();
        $this->user = new users();
        $this->soapmsg = new soapmsg();
        $this->shortmsg = new shortmsg();
        $this->smstpl = new smsTpl();
        $this->profiles = new users_profiles();
    }

    function doDefault() {
        $this->doregister();
    }

    /**
     * 注册页面分配页面
     */
    function doRegister() {
        $tpl_name = "wap_register";
        $css = array("index", "zccg");
        $js = array("jquery-1.8.3.min");

        $this->vars('css', $css);
        $this->vars('js', $js);

        $this->template($tpl_name, '', 'replaceWapNewsUrl');
    }

    /**
     * 验证数据库里是有此号码
     */
    function doChkMoblie() {
        $mobile = $_GET['mobile'];
        $uid = $this->user->getUser('id', "mobile = '$mobile'", 3); //通过手机号获取uid
        if ($uid) {
            echo $uid;
        } else {
            echo -4;
        }
    }

    /**
     * 验证码的校验
     */
    function doCheckCode() {
        $code = trim($_GET['code']);
        $reg_code = session("reg_code"); //验证验证码是否正确
        if ($reg_code == $code) {
            echo 1;
            exit;
        } else {
            echo -4;
            exit;
        }
    }

    /**
     * 重新发送验证码
     */
    function doSendCode() {
        $phone = $_GET['mobile'];
        $code = mt_rand(1000, 9999);
        session("reg_code", $code);
        $msgTpl = $this->smstpl->getTpl($this->shortmsg->tpl_flag['reg_code']);
        $msg = str_replace('{$reg_code}', $code, $msgTpl);
        $state = $this->soapmsg->postMsg($phone, $msg);
        if ($state == 2)
            $aa = $this->shortmsg->recordMsg(0, $state, $this->shortmsg->tpl_flag['reg_code'], $phone, $msg);
        echo $state;
    }

    function doSregister() {
        $tpl_name = "wap_register_son";
        if ($_POST) {
            $username = trim($_POST['username']); //接受用户名
            $pwd = $_POST['password'];
            if($pwd=='')$this->alert('密码不能为空', 'js', 3, 'wapregister.php?action=Sregister');
            $password = md5($_POST['password']); //接受密码  
            $phone = $_GET['phone'];
            $username_reg = "/^[a-zA-Z0-9_u4e00-u9fa5]{3,20}[^_]$/";
            $reg = preg_match($username_reg, $username);
            //如果用户名符合要求,且没有人注册过
            if ($reg == 1) {
                $ip = util::getip();
                //将用户信息存入数据库
                $this->user->ufields = array("username" => "$username", "password" => "$password", "mobile" => "$phone", "state" => "1", "created" => time(), "reg_ip" => "$ip");
                $id = $this->user->insert();
                if ($id) {
                    //将数据插入到用户信息表
                    $aa = $this->profiles->ufields = array("uid" => "$id", "avatar" => "", "birthday" => "1990-01-01");
                    $id = $this->profiles->insert();
                    $this->alert('注册成功', 'js', 3, 'waplogin.php?action=login');
                } else {
                    $this->alert('提交信息有错误,请重新提交!', 'js', 3, 'wapregister.php?action=Sregister');
                }
            } else {
                $this->alert('用户名不符合要求', 'js', 3, 'wapregister.php?action=Sregister');
            }
        } else {
            $this->template($tpl_name, '', 'replaceNewsChannel');
        }
    }

}
