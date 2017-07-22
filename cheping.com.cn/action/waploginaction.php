<?php

/**
 * wap视频页 video
 * $Id: wapvideoaction.php 983 2015-11-23 10:56:45Z cuiyuanxin $
 */
class wapLoginAction extends action {

    function __construct() {
        parent::__construct();
        $this->user = new users();
        $this->smstpl = new smsTpl();
        $this->soapmsg = new soapmsg();
        $this->shortmsg = new shortMsg();
    }

    function doDefault() {
        $this->doLogin();
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

    function doLogin() {

        $tpl_name = "wap_login";
        $css = array("reset", "people");
        $js = array("jquery-1.8.3.min");
//        $user = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_MAGIC_QUOTES); //获取用户名
//        $pwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_MAGIC_QUOTES); //获取密码
        $user = $_POST['name'];
        $pwd = $_POST['password'];

        if ($_POST) {
            $pwd = md5($pwd);
            $phoneReg = '/^(13|18|15|17)\d{9,}$/'; //验证符合手机规范吗
            if (preg_match($phoneReg, $user)) {
                $uid = $this->user->getUser('id, password,username', "mobile='{$user}'", 1); //手机方式登录
                $bool = $uid ? 1 : 2;
            } else {
                $uid = $this->user->getUser('id, password,username', "username='{$user}'", 1); //用户名方式登录
                $bool = $uid ? 3 : 2;
            }
            //存在$uid 并且密码和数据库相等 存到session
            if ($uid && $pwd == $uid['password']) {
                $id = $uid['id'];
                session('uid', $id);
                session('username', $uid['username']);
                echo $bool;
                exit;
            } else {
//                $this->alert('用户名和密码不符', 'js', 3, 'waplogin.php');
                echo 6;
                exit;
            }
        } else {
            $this->vars('js', $js);
            $this->vars('css', $css);
            $this->template($tpl_name, '', 'replaceWapNewsUrl');
        }
    }

    function doUnsetUser() {
        session_destroy();
        $this->alert('您已经退出登录!', 'js', 3, 'wapindex.php?action=index');
    }

    function doSendCode() {
        $phone = $_GET['mobile'];
        $code = mt_rand(1000, 9999);
        session("code_o", $code);
        $msgTpl = $this->smstpl->getTpl($this->shortmsg->tpl_flag['code_o']);
        $msg = str_replace('{$code_o}', $code, $msgTpl);
        $state = $this->soapmsg->postMsg($phone, $msg);
        if ($state == 2)
            $this->shortmsg->recordMsg(0, $state, $this->shortmsg->tpl_flag['code_o'], $phone, $msg);
        echo $state;
    }

    function doCheckCode() {
        $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_MAGIC_QUOTES);
        $get_pcode = session("code_o");
        if ($get_pcode == $code) {
            echo 1;
            exit;
        } else {
            echo -4;
            exit;
        }
    }

    /**
     * 找回密码分配页面
     */
    function doRepassWord() {
        $tpl_name = "wap_repassword";
        $title = $_GET['p'];
        $this->vars('title', $title);
        $this->template($tpl_name, '', 'replaceNewsChannel');
    }

    /**
     * 找回密码的子页面
     * $newpwd: 获取到的新密码
     * $phone:获取到的手机号
     */
    function doRepassWordson() {
        $tpl_name = "wap_repassword_son";
        $title = $_GET['p'];
        if ($_POST) {
            $newpwds = $_POST['newpwd'];
            $newpwd = md5($newpwds);
            $phone = $_GET['phone'];
            if ($phone) {
                $uid = $this->user->getUser('id', "mobile = '$phone'", 3);
                if ($uid && $newpwd) {
                    $filed = array("password" => "$newpwd");
                    $where = "id=" . $uid;
                    $sucess = $this->user->updateUser($filed, $where);
                    if ($title) {
                        if ($sucess) {
                            $this->alert('密码修改成功', 'js', 3, '/waplogin.php?action=login');
                        } else {
                            $this->alert('两次密码相同,密码修改失败,请重试!', 'js', 3, '/wapLogin.php?action=RepassWord');
                        }
                    } else {
                        if ($sucess) {
                            $this->alert('密码修改成功', 'js', 3, '/wapuinfo.php?action=Uinfo');
                        } else {
                            $this->alert('两次密码相同,密码修改失败,请重试!', 'js', 3, '/wapLogin.php?action=RepassWord');
                        }
                    }
                }
            }
        }
        $this->template($tpl_name, '', 'replaceNewsChannel');
    }

}
