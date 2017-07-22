<?php

/**
 * auth
 * $Id: adminauth.php 1255 2015-11-13 09:58:10Z xiaodawei $
 */
class adminAuth extends model {

    var $auth_value = array(
        'N' => '无权限',
        'R' => '只读',
        'W' => '可写',
        'A' => '完全',
    );
    var $rtype = 1;

    function __construct() {
        $this->table_name = "admin_auth";
        parent::__construct();
    }

    function getAuthCount($where) {
        $this->where = $where;
        $this->fields = "count(*)";
        return $this->getResult(3);
    }

    /**
     * put your comment there...
     * 
     * @param mixed $uid user_id
     * @param mixed $auth_type
     * @param mixed $mcode_id  module_code
     * @param mixed $auth_value
     * @param mixed $message
     * @param int $rtype 返回信息类型，1：js返回,else 直接返回状态true/false
     */
    function checkAuth($uid, $auth_type, $mcode_id, $auth_value = 'N', $message = "您暂时没有权限，请与管理员联系！") {
        if (is_null($uid)) {
            if ($this->rtype == 1)
                $this->alert('您已经退出登录，请重新登录！', 'js', 3, ADMIN_PATH);
            else
                return false;
        }
        if (isset($uid) && $uid == 0)
            return true;
        switch ($auth_value) {
            case 'R':
                $tmp = "'R', 'A', 'W'";
                break;
            case 'W':
                $tmp = "'A', 'W'";
                break;
            case 'A':
                $tmp = "'A'";
                break;
        }

        if ($auth_type == "sys_module") {
            $type_id = $this->getModuleId($mcode_id);
        } else
            $type_id = $mcode_id;
        $this->where = "uid='{$uid}' and auth_type='{$auth_type}' and type_id='{$type_id}' and auth_value in ({$tmp})";
        $authes = $this->getAuthCount($this->where);
        if ($authes) {
            return true;
        } else {
            if ($this->rtype == 1)
                $this->alert($message);
            else
                return false;
        }
    }

    /**
     * 产品权限
     * #
     */
    function checkProductAuth() {
        
    }

    function getUserAuth($uid, $auth_type) {
        $this->fields = "*";
        $this->where = "uid='{$uid}' and auth_type='{$auth_type}'";
        return $this->getResult(2);
    }

    function getUserModuleAuth($uid, $module_code, $auth_value = '') {
        if (isset($uid) && $uid == 0)
            return true;
        $sysmodule = new sysmodule();
        $module_id = $sysmodule->getModulesByCode($module_code);
        if ($module_id) {
            $this->where = "uid='{$uid}' and type_id='{$module_id}'";
            $this->fields = "auth_value";
            $auth = $this->getResult(3);
            if ($auth_value) {
                return ($auth === $auth_value);
            } else {
                return $auth;
            }
        }
    }

    function getAuthAssoc($uid, $auth_type) {
        $this->fields = "type_id,auth_value";
        $this->where = "uid='{$uid}' and auth_type='{$auth_type}'";
        return $this->getResult(4);
    }

    function getUserAuthAssoc($uid, $auth_type) {
        $this->fields = "type_id, auth_value";
        $this->where = "uid='{$uid}' and auth_type='{$auth_type}'";
        #$this->order = array('type_id' => 'asc');
        return $this->getResult(4);
    }

    function getAllModule() {
        $this->table_name = "sys_module";
        $this->fields = "*";
        $this->where = "";
        $this->order = array('module_code' => 'asc');
        $ret = $this->getResult(2);
        $this->table_name = "admin_auth";
        return $ret;
    }

    function getProductModule() {
        $this->table_name = "product_module";
        $this->fields = "*";
        $this->where = "product_module";
        $ret = $this->getResult(2);
        $this->table_name = "admin_auth";
        return $ret;
    }

    function getModuleId($module_colde) {
        $this->table_name = "sys_module";
        $this->fields = "module_id";
        $this->where = "module_code='{$module_colde}'";
        $ret = $this->getResult(3);
        $this->table_name = "admin_auth";
        return $ret;
    }

    function superUser($uid){
        return (isset($uid) && $uid == 0);
    }
}

?>
