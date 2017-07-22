<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class reguserAction extends action {

    var $state = array(
        "1" => "正常",
        "0" => "屏蔽"
    );
    var $color = array(
        "1" => "#2e63eb",
        "0" => "#b1b2ab"
    );

    function __construct() {
        parent::__construct();
        $this->users = new users();
        $this->checkAuth(1101);
    }

    function doDefault() {
        $this->doUserList();
    }

    function doUserList() {
        $this->page_title = "注册用户列表";
        $template_name = "users_list";

        $mobile = $this->requestValue('mobile')->Mobile();
        $username = $this->requestValue('username')->String();
        if ($this->getValue('state')->Exist()) {
            $state = $this->getValue('state')->Int();
        } else {
            $state = $this->postValue('state')->Int();
        }

        $page = $this->getValue('page')->Int();
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $where = " 1 ";
        if ($state != "" && isset($state)) {
            $where.=" and state='" . $state . "'";
            $this->vars('s', $state);
            $extra .= "&state=$state";
        }
        if ($mobile) {
            $where.=" and mobile='" . $mobile . "'";
            $this->vars('mobile', $mobile);
            $extra .= "&mobile=$mobile";
        }
        $id = $this->postValue('id')->Int();
        if (!empty($id)) {
            $where.=" and id='" . $id . "'";
            $this->vars('id', $id);
        }
        if ($username) {
            $where .= " and username like '{$username}%'";
            $extra .= "&username={$username}";
            $this->vars('username', $username);
        }
        $userlist = $this->users->getAllUsers($where, array("created" => "DESC"), $page_size, $page_start);
        $page_bar = $this->multi($this->users->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra, 0, 4);
        $this->vars('page_bar', $page_bar);
        $this->vars('users', $userlist);
        $this->vars('state', $this->state);
        $this->vars('color', $this->color);
        $this->vars('page', $page);
        $this->vars('page_title', $this->page_title);

        $this->tpl->display($template_name);
    }

    function doUpdtestate() {
        $state = $this->postValue('state')->Int();
        $id = $this->postValue('id')->Int();
        $this->users->ufields = array(
            'state' => $state
        );
        $this->users->where = "id='" . $id . "'";
        $result = $this->users->update();
        if ($result) {
            $color = $this->color;
            $color = $color[$state];
            echo json_encode($color);
        }
    }

    function doDel() {
        $id = @implode(",", $this->postValue('id')->Val());
        if (!empty($id)) {
            $this->users->where = "id in(" . $id . ")";
            $this->users->limit = 0;
            $result = $this->users->del();
            $msg = "批量删除";
        } else {
            $id = $this->getValue('id')->Int();
            $this->users->where = "id='{$id}'";
            $result = $this->users->del();
            $msg = "删除";
        }

        if ($result) {
            $msg .= "成功！";
        } else {
            $msg .= "失败！";
        }
        $message = array(
            'type' => 'js',
            'act' => 3,
            'message' => $msg,
            'url' => $_ENV['PHP_SELF']
        );
        $this->alert($message);
    }

    function doUpdteallstate() {
        if ($this->postValue('dels')->Int()) {
            $this->doDel();
        } else {
            $state = $this->postValue('state')->Int();
            $id = $this->postValue('id')->Int();

            if (is_array($id)) {
                foreach ($id as $key => $val) {
                    //var_dump($val);
                    $this->users->ufields = array(
                        'state' => $state
                    );
                    $this->users->where = "id='{$val}'";
                    $ret = $this->users->update();
                }
                $msg = "批量操作";
            }
            if ($ret) {
                $msg .= "成功！";
            } else {
                $msg .= "失败！";
            }
            $message = array(
                'type' => 'js',
                'act' => 3,
                'message' => $msg,
                'url' => $_ENV['PHP_SELF']
            );
            $this->alert($message);
        }
    }

    //用户添加编辑
    function doAddandupdate() {

        $id = $this->postValue('id')->Int();
        //判断是添加还是修改
        if (!empty($id)) {
            //修改
            $this->users->ufields = array(
                "mobile" => $this->postValue('mobile')->Mobile(),
                "email" => $this->postValue('email')->Email(),
                "password" => $this->postValue('password')->hash(),
                "state" => $this->postValue('state')->Int(),
                "updated" => $this->timestamp,
            );
            $this->users->where = "id='" . $id . "'";
            $result = $this->users->update();
//
            if ($result) {
                $message = "修改成功";
            } else {
                $message = "修改失败";
            }
        } else {
            //添加
            $ufields = array(
                "username" => $this->postValue('username')->String(),
                "mobile" => $this->postValue('mobile')->Mobile(),
                "email" => $this->postValue('email')->Email(),
                "password" => $this->postValue('password')->hash(),
                "state" => $this->postValue('state')->Int(),
                "created" => $this->timestamp,
            );
            $uid = $this->users->insertUser($ufields);
            if ($uid) {
                $message = "添加成功";
            } else {
                $message = "添加失败";
            }
        }

        $this->alert($message, 'js', 3, $_ENV['PHP_SELF']);
    }

    function doAdd() {
        $this->page_title = "添加用户";
        $template_name = "users_add";
        $id = $this->getValue('id')->Int();
        if ($id) {
            $this->page_title = "修改用户";
            $users = $this->users->getUserById($id);
            $this->vars('user', $users);
        }
        $this->vars('state', $this->state);
        $this->vars('page_title', $this->page_title);
        $this->tpl->display($template_name);
    }

    //判断用户名是否存在
    function doCheckname() {
        $username = iconv("utf-8", "gbk", $this->postValue('username')->Val());
        $resut = $this->users->getUserByName($username);
        if ($resut) {
            echo 1;
        } else {
            echo 0;
        }
    }

    //判断手机号是否唯一
    function doCheckTel() {
        $tel = iconv("utf-8", "gbk", $this->postValue('mobile')->Mobile());
        $resut = $this->users->getUserByTel($tel);
        if ($resut) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function checkAuth($id, $module_type = 'sys_module', $type_value = "A") {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, $module_type, $id, 'A');
    }
}

?>
