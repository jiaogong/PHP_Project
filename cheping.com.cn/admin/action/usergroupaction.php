<?php

/**
 * user group action
 * @author David.Shaw
 * $Id: usergroupaction.php 1170 2015-11-04 14:58:47Z xiaodawei $
 */
class usergroupAction extends action {

    var $usergroup;

    function __construct() {
        parent::__construct();
        $this->usergroup = new userGroup();
    }

    function doDefault() {
        $this->doList();
    }

    function doList() {
        $this->checkAuth();
        $this->page_title = "用户组列表";
        $template_name = "usergroup_list";
        $allusergroup = $this->usergroup->getAllGroup();

        $this->vars('page_title', $this->page_title);
        $this->vars('allusergroup', $allusergroup);
        $this->tpl->display($template_name);
    }

    function doAdd() {
        $this->checkAuth();
        global $adminauth;
        $allauth = $adminauth->getAllModule();
        $group_name = $this->postValue('group_name')->String();
        if ($group_name) {
            $auth_str = "";
            foreach ($allauth as $key => $value) {
                $m_module_id = $this->postValue('m_' . $value['module_id'])->Int();
                if ($m_module_id)
                    $auth_str .= $value['module_id'] . '||' . $m_module_id . ",";
            }
            $auth_str = substr($auth_str, 0, -1);

            $this->usergroup->ufields = array(
                'group_name' => $group_name,
                'group_default_auth' => $auth_str,
                'memo' => $this->postValue('memo')->String(),
            );
            $gid = $this->postValue('gid')->Int();
            if ($gid) {
                $message = "修改用户组";
                $this->usergroup->where = "group_id='{$gid}'";
                $ret = $this->usergroup->update();
            } else {
                $message = "添加用户组";
                $ret = $this->usergroup->insert();
            }

            if ($ret) {
                $message .= "成功！";
            } else {
                $message .= "失败！";
            }
            $this->alert($message, 'js', 3, $_ENV['PHP_SELF']);
        } else {
            $template_name = "usergroup_add";
            $gid = $this->getValue('gid')->Int();
            if ($gid) {
                $this->page_title = "修改用户组";
                $group = $this->usergroup->getGroup($gid);
                $groupauth = $this->usergroup->getGroupAuth($gid);
                $this->vars('groupauth', $groupauth);
                $this->vars('gid', $gid);
                $this->vars('edit', 1);
                $this->vars('group', $group);
            } else {
                $this->page_title = "添加用户组";
            }

            $this->vars('auth_value', $adminauth->auth_value);
            $this->vars('page_title', $this->page_title);
            $this->vars('allauth', $allauth);
            $this->vars('type', 1);
            $this->tpl->display($template_name);
        }
    }

    function doEdit() {
        $this->doAdd();
    }

    function doDel() {
        $this->checkAuth();
        $gid = $this->getValue('gid')->Int();
        $this->usergroup->where = "group_id='{$gid}'";
        $ret = $this->usergroup->del();
        if ($ret) {
            $message = "用户组删除成功！";
        } else {
            $message = "用户组删除失败！";
        }
        $this->alert($message, 'js', 3, $_ENV['PHP_SELF']);
    }

    function checkAuth() {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, 'sys_module', 101, 'W');
    }

}

?>
