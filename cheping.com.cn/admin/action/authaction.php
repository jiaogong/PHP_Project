<?php

/**
 * auth action
 * $Id: authaction.php 1249 2015-11-13 08:58:14Z xiaodawei $
 */
class authAction extends action {

    var $auth;
    var $brand;
    var $user;

    function __construct() {
        global $adminauth;
        parent::__construct();
        $this->auth = $adminauth;
        $this->brand = new brand();
        $this->user = new user();
    }

    function doDefault() {
        $this->doAuthList();
    }

    function doAuthList() {
        $this->page_title = "用户权限列表";
        $this->checkAuth();
        $uid = $this->getValue('uid')->Int();
        $user = new user();
        $userinfo = $user->getUser($uid);
        $userauth = $this->auth->getUserAuthAssoc($uid, 'sys_module');

        #alluser
        $alluser = $user->getAllUser(3);
        $allauth = $this->auth->getAllModule();
        $template_name = "auth_edit";
        $sys_auth = $this->auth->getUserAuth($uid, 'sys_module');
        $this->vars('sys_auth', $sys_auth);

        $this->vars('userinfo', $userinfo);
        $this->vars('userauth', $userauth);
        $this->vars('auth_value', $this->auth->auth_value);
        $this->vars('alluser', $alluser);
        $this->vars('allauth', $allauth);
        $this->vars('page_title', $this->page_title);
        $this->tpl->display($template_name);
    }

    function doAuthEdit() {
        $this->checkAuth();
        $u_sys_auth = array();
        $uid = $this->postValue('uid')->Int();
        $auth_type = "sys_module";

        $allauth = $this->auth->getAllModule();
        $u_sys_auth = $this->auth->getAuthAssoc($uid, $auth_type);
        $change_count = 0;
        foreach ($allauth as $key => $value) {
            $k_module_id = 'module_' . $key;
            $k_module_val = 'm_radio_' . $key;
            $module_val = $this->postValue($k_module_val)->En();
            $auth_value = $this->addValue($module_val)->Val('N');
            
            if ($this->postValue($k_module_id)->Exist()) {
                if ($u_sys_auth[$value['module_id']] !== $module_val) {
                    if ($u_sys_auth[$value['module_id']]) {
                        $this->auth->ufields = array(
                            'auth_value' => $auth_value
                        );
                        $this->auth->where = "uid='{$uid}' and type_id='{$value['module_id']}' and auth_type='{$auth_type}'";
                        $ret = $this->auth->update();
                    } else {
                        $this->auth->ufields = array(
                            'uid' => $uid,
                            'auth_type' => $auth_type,
                            'type_id' => $value['module_id'],
                            'auth_value' => $auth_value,
                        );
                        $ret = $this->auth->insert();
                    }
                    $change_count++;
                }
            }
        }
        if (!$change_count) {
            $this->alert("没有权限被更新（原因：提交的权限和未修改之前相同）！", 'js', 2);
        } else {
            if ($ret) {
                $this->alert("权限更新成功", 'js', 3, $_ENV['PHP_SELF'] . "&uid={$uid}");
            } else {
                $this->alert("权限更新失败，请与管理员联系！", 'js', 2);
            }
        }
    }

    function doCarAuth() {
        $this->page_title = "用户产品列表";
        $this->checkAuth();
        $uid = $this->getValue('uid')->Int();

        $userinfo = $this->user->getUser($uid);
        $userauth = $this->auth->getUserAuthAssoc($uid, 'brand_module');

        #alluser
        $alluser = $this->user->getAllUser(3);

        $allauth = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);

        #var_dump($allauth);
        $template_name = "car_auth";
        $sys_auth = $this->auth->getUserAuth($uid, 'brand_module');
        $this->vars('sys_auth', $sys_auth);

        $this->vars('userinfo', $userinfo);
        $this->vars('userauth', $userauth);
        $this->vars('auth_value', $this->auth->auth_value);
        $this->vars('alluser', $alluser);
        $this->vars('allauth', $allauth);
        $this->vars('page_title', $this->page_title);
        $this->tpl->display($template_name);
    }

    function doCarEdit() {
        $this->checkAuth();
        $uid = $this->postValue('uid')->Int();
        $auth_type = "brand_module";
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $u_pro_auth = $this->auth->getAuthAssoc($uid, $auth_type);

        foreach ($brand as $key => $value) {

            $k_module_val = $this->postValue('m_radio_' . $value['brand_id'])->Val();
            if (array_key_exists($value['brand_id'], $u_pro_auth)) {
                $this->auth->ufields = array(
                    'auth_value' => $k_module_val
                );
                $this->auth->where = "uid='{$uid}' and type_id='{$value['brand_id']}' and auth_type='{$auth_type}'";
                $ret = $this->auth->update();
            } elseif ($k_module_val) {
                $this->auth->ufields = array(
                    'uid' => $uid,
                    'auth_type' => $auth_type,
                    'type_id' => $value['brand_id'],
                    'auth_value' => $k_module_val,
                );
                $this->auth->where = "uid='{$uid}' and type_id='{$value['brand_id']}' and auth_type='{$auth_type}'";
                $ret = $this->auth->insert();
            }
        }
        if ($ret) {
            $this->alert("权限更新成功", 'js', 3, $_ENV['PHP_SELF'] . "&uid={$uid}");
        } else {
            $this->alert("权限更新失败，请与管理员联系！", 'js', 2);
        }
    }

    function doCopyAuth() {
        $this->checkAuth();
        $ret = null;
        $to_userauth = array();
        $from_uid = $this->postValue('uid')->Int();
        $to_uid = $this->postValue('to_uid')->Int();
        $auth_type = 'sys_module';
        $userauth = $this->auth->getUserAuth($from_uid, $auth_type);
        $to_userauth = $this->auth->getAuthAssoc($to_uid, $auth_type);

        foreach ($userauth as $key => $value) {
            if (array_key_exists($value['type_id'], $to_userauth)) {
                if ($to_userauth[$value['type_id']] !== $value['auth_value']) {
                    $this->auth->ufields = array(
                        'auth_value' => $value['auth_value']
                    );
                    $this->auth->where = "uid='{$to_uid}' and auth_type='{$auth_type}' and type_id='{$value['type_id']}'";
                    $ret = $this->auth->update();
                }
            } else {
                $this->auth->ufields = array(
                    'uid' => $to_uid,
                    'auth_type' => $auth_type,
                    'type_id' => $value['type_id'],
                    'auth_value' => $value['auth_value'],
                );
                $ret = $this->auth->insert();
            }
        }
        $user = new user();
        $user->where = "uid='{$to_uid}'";
        $user->fields = "username";
        $to_username = $user->getResult(3);
        if (is_null($ret)) {
            $this->alert("您与“{$to_username}”权限相同，不需要权限复制！", 'js', 3, $_ENV['PHP_SELF'] . "&uid={$from_uid}");
        } elseif ($ret) {
            $this->alert("为“{$to_username}”复制权限成功", 'js', 3, $_ENV['PHP_SELF'] . "&uid={$from_uid}");
        } else {
            $this->alert("为“{$to_username}”复制权限失败，请与管理员联系！", 'js', 2);
        }
    }

    function checkAuth() {
        global $login_uid, $adminauth;
        $adminauth->checkAuth($login_uid, 'sys_module', 101, 'W');
    }

}

?>
