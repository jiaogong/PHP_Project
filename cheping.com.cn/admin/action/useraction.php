<?php

/**
 * user action
 * @author David.Shaw
 * $Id: useraction.php 1190 2015-11-06 01:43:20Z xiaodawei $
 */
class userAction extends action {

    var $user;

    function __construct() {
        parent::__construct();
        $this->user = new user();
    }

    function doDefault() {
        $this->doUserList();
    }

    function doUserList() {
        $this->checkLoginAuth();

        $this->page_title = "用户列表";
        $template_name = "user_list";
        $sideline = $this->getValue('type')->En();
        $type = $sideline == "sideline" ? 1 : 0;
        $userlist = $this->user->getAllUser($type);
        $this->vars('alluser', $userlist);
        $this->vars('type', $type);
        $this->vars('page_title', $this->page_title);

        $this->tpl->display($template_name);
    }

    function doAdd() {
        $this->checkLoginAuth();

        $usergroup = new userGroup();
        $groups = $usergroup->getAllGroup();

        $userinfo = array();
        $template_name = "user_add";
        $uid_exist = $this->getValue('uid')->Exist();
        if ($uid_exist) {
            $this->page_title = "用户信息修改";
            $type = "edit";
            $uid = $this->getValue('uid')->Int();
            $userinfo = $this->user->getUser($uid);
            if (empty($userinfo['uid'])) {
                $this->alert('要修改的用户信息不在在。按“确定”返回。', 'js', 2);
            } else {
                $this->vars('user', $userinfo);
                $this->vars('ro', "readonly");
            }
        } else {
            $this->page_title = "添加新用户";
            $type = "add";
        }

        $this->vars('groups', $groups);
        $this->vars('user', $userinfo);
        $this->vars('type', $type);
        $this->vars('page_title', $this->page_title);
        $this->tpl->display($template_name);
    }

    function doEdit() {
        $this->doAdd();
    }

    function doUpdate() {
        global $adminauth;
        $this->checkLoginAuth();
        $uid = $this->postValue('uid')->Int();
        $password = $this->postValue('password')->StrongPassword();
        if (!$password) {
            $message = "失败原因：用户密码太简单，请使用大小写字母+数字组合！";
        } elseif ($uid) {
            $message = "用户信息修改";
            $old_user = $this->user->getUserByName($this->postValue('username')->String());
            if ($old_user['username']) {
                $this->user->ufields = array(
                    'nickname' => $this->postValue('nickname')->String(),
                    'gid' => $this->postValue('gid')->Int(),
                    'jianzhi' => $this->postValue('jianzhi')->Int(),
                    'mobile' => $this->postValue('mobile')->Mobile(),
                    'password' => dencrypt($password),
                    'realname' => $this->postValue('realname')->String(),
                    'level' => $this->postValue('level')->EnNum(),
                );
                $this->user->where = "uid='{$uid}'";
                if ($this->user->update()) {
                    $message .= "成功！";
                } else {
                    $message .= "失败！";
                }
            } else {
                $message .= "失败，原因：用户信息不存在！";
            }
        } else {
            $message = "添加新用户";
            $old_user = $this->user->getUserByName($this->postValue('username')->String());
            if ($old_user['username']) {
                $message = "失败，原因：用户信息已存在！";
            } else {
                $this->user->ufields = array(
                    'username' => $this->postValue('username')->String(),
                    'nickname' => $this->postValue('nickname')->String(),
                    'gid' => $this->postValue('gid')->Int(),
                    'jianzhi' => $this->postValue('jianzhi')->Int(),
                    'mobile' => $this->postValue('mobile')->Mobile(),
                    'password' => $password,
                    'realname' => $this->postValue('realname')->String(),
                    'level' => $this->postValue('level')->EnNum(),
                );

                if (false !== ($ret = $this->user->insert())) {
                    $message .= "成功！";

                    #insert group perm
                    $usergroup = new userGroup();
                    $groupauth = $usergroup->getGroupAuth($this->postValue('gid')->Int());
                    foreach ($groupauth as $key => $value) {
                        $adminauth->ufields = array(
                            'uid' => $ret,
                            'auth_type' => 'sys_module',
                            'type_id' => $key,
                            'auth_value' => $value,
                        );
                        $adminauth->insert();
                    }
                } else {
                    $message .= "失败！";
                }
            }
        }
        $this->alert($message, 'js', 3, $_ENV['PHP_SELF']);
    }

    function doDelUser() {
        $this->checkLoginAuth();
        $uid = $this->getValue('uid')->Int();
        $ret = false;
        if ($uid) {
            $this->user->where = "uid='{$uid}'";
            $this->user->ufields = array('actived' => 0);
            $ret = $this->user->update();
        }
        if ($ret) {
            $message = "删除用户成功！";
        } else {
            $message = "删除用户失败！";
        }
        $this->alert($message, 'js', 3, $_ENV['PHP_SELF']);
    }

    function doChangePassword() {
        global $login_uname;
        $template_name = "change_password";
        $this->page_title = "用户密码修改";

        $this->vars('username', $login_uname);
        $this->vars('page_title', $this->page_title);
        $this->tpl->display($template_name);
    }

    /**
     * 用户修改自己密码功能。
     * 传入的用户ID必须与登录的用户ID相等才允许正常操作。
     */
    function doUpdatePassword() {
        global $login_uid;
        $user = $this->user->getUser($login_uid);
        if ($user) {
            $oldpass = $this->postValue('oldpass')->String();
            $newpass = $this->postValue('newpass1')->String();
            $enc_oldpass = dencrypt($oldpass);
            if ($user['password'] == $enc_oldpass) {
                $enc_newpass = dencrypt($newpass);
                $this->user->ufields = array('password' => $enc_newpass);
                $this->user->where = "uid='{$user['uid']}'";
                if ($this->user->update()) {
                    $message = "密码修改成功！";
                    $this->alert($message, 'js', 3, $_ENV['PHP_SELF'] . 'changepassword');
                } else {
                    $message = "密码修改失败！";
                }
            } else {
                $message = "密码修改失败，原因：原始密码错误！";
            }
        } else {
            $message = "密码修改失败，原因：用户数据不存在！";
        }
        $this->alert($message, 'js', 2);
    }

    function doPasswordStrong() {
        $password = $this->getValue('password')->StrongPassword();
        echo json_encode(array('password' => $password));
    }

    function checkLoginAuth() {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, 'sys_module', 101, 'W');
    }

}


