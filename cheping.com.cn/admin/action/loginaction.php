<?php

/**
 * login
 * $Id: loginaction.php 1250 2015-11-13 09:08:46Z xiaodawei $
 */
class loginAction extends action {

    var $user;

    function __construct() {
        parent::__construct();
        $_ENV['user'] = new user();
    }

    function doDefault() {
        $this->doShowLogin();
    }

    function doShowLogin() {
        $template_name = "login";
        $this->vars('loginUser', session('username'));
        $this->vars('pageindex', 'login');
        if (session('username')) {
            $this->vars('page_title', SITE_NAME . '--后台管理');
        } else
            $this->vars('page_title', SITE_NAME . '--后台登录');
        $this->tpl->display($template_name);
    }

    function doCheckLogin() {
        $username = $this->postValue('username')->String();
        $password = $this->postValue('password')->String();

        $loginUser = $_ENV['user']->login($username, $password);
        $this->vars('loginUser', $username);
        $this->doShowLogin();
    }

    function doShowLeft() {
        $isLogin = $_ENV['user']->login();
        $this->vars('page_title', SITE_NAME . '--菜单');
        $this->vars('pageindex', 'loginleft');
        if ($isLogin) {
            $this->tpl->display('left');
        } else {
            echo "<script>parent.location.href='" . ADMIN_PATH . "';</script>";
        }
    }

    function checkFrameLogin() {
        $isLogin = $_ENV['user']->login();
        if (!$isLogin) {
            echo "<script>parent.location.href='" . ADMIN_PATH . "';</script>";
        }
    }

    function doRcheckLogin() {
        $username = $this->postValue('username')->String();
        $password = $this->postValue('password')->String();
        $username = iconv('utf-8', 'gbk', $username);
        $isLogin = $_ENV['user']->login($username, $password);
        if ($isLogin === true)
            echo '1';
    }

    function doCheckMemberCard() {
        $memberCard = $this->getValue('member_card')->EnNum();
        $model = new model();
        $model->table_name = 'users';
        $model->fields = 'uid';
        $model->where = "member_card = '$memberCard'";
        $uid = $model->getResult();
        if ($uid && !$model->isError())
            echo 1;
        else
            echo 0;
    }

    function doLogout() {

        unset_session('username');
        unset_session('user_id');

        @header("Expires: " . gmdate("D, d M Y H:i:s", time() - 1) . " GMT");

        $this->message(ADMIN_PATH, "您以成功退出，将自动返回登录页面。", 3, "退出");
    }

}

?>
