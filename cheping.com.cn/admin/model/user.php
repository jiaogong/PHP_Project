<?php

/**
 * user
 * $Id: user.php 1130 2015-11-02 01:42:52Z xiaodawei $
 */
class user extends model {

    var $auth_value;
    var $module_name;
    var $module_code;
    var $user_id;
    var $user_name;
    var $auth;
    var $sysmodule;
    var $adminauth;

    function user() {
        parent::__construct();
        $this->table_name = "admin_user";
        $this->sysmodule = new sysmodule();
        $this->adminauth = new adminAuth();
    }

    function getFields($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }

    function getUser($uid) {
        $this->fields = "*";
        $this->where = "uid='{$uid}'";
        $user = $this->getResult();
        $usergroup = new userGroup();
        $group = $usergroup->getGroup($user['gid']);
        $user['group_id'] = $user['gid'];
        $user['gid'] = $group ? $group['group_name'] : '未知用户类型';
        return $user;
    }

    function getAllUser($type = 1, $include_admin = 0) {
        $userlist = array();
        $this->fields = "*";
        $this->where = "actived='1' and username<>'' " . ($type == 3 ? "" : "and jianzhi='{$type}'") . ($include_admin ? "" : " and uid>0");
        $alluser = $this->getResult(2);

        $usergroup = new usergroup();
        $groups = $usergroup->getGroupAssoc();
        foreach ($alluser as $key => $value) {
            $groupname = $groups[$value['gid']];
            if (!$groupname)
                $groupname = '未知用户类型';
            $value['gid'] = $groupname;
            $userlist[] = $value;
        }
        return $userlist;
    }

    function getUserByName($username, $actived = 1) {
        $this->reset();
        $this->where = "username='$username' and actived='{$actived}'";
        $this->fields = "*";
        $result = $this->getResult();
        return $result;
    }

    function login($username = '', $userpass = '') {
        if (session('user_id') || session('username')) {
            return true;
        } else {
            #($username && $userpass) || die('用户名密码不能为空!');
            $user = $this->getUserByName($username);
            $dec_pass = dencrypt($userpass);
            if (!$user || $user['password'] != $dec_pass) {
                return $user['password'];
            } else {
                session('user_id', $user['uid']);
                session('username', $user['username']);

                $this->user_id = $user['uid'];
                $this->user_name = $user['username'];
                $_ENV['userinfo'] = $user;
                return true;
            }
        }
    }

    /* 获取分组内的用户
     * flag=false 返回查找的所有用户 array(user1,user2,user3)
     * flag=true 根据分组id返回对应的数组 array(gid1=>array(),gid2=>array());
     */

    function getGroupUser($gid, $flag) {
        if (empty($gid))
            return false;
        if (is_array($gid)) {
            $gid2 = implode(',', $gid);
            $where = "gid in ($gid2)";
        } else {
            $where = "gid=$gid";
        }
        $this->where = $where;
        $this->fields = 'uid id, uid, username, password, realname, gid';
        $result = $this->getResult(4);
        if ($result) {
            if ($flag) {
                $array = array();
                foreach ($result as $val) {
                    foreach ($gid as $v) {
                        if ($val['gid'] == $v) {
                            $array[$val['gid']][] = $val;
                            continue 2;
                        }
                    }
                }
                return $array;
            } else {
                return $result;
            }
        }
    }

    /**
     * 推荐码注册的查询
     * 
     * @param string $field  字段列表
     * @param string $where sql 条件
     * @param int $offset
     * @param int $limit  每页最大显示条数
     * @param array $order 排序
     * @param int $flag 查询状态数字
     * @return type
     */
    function getInvitedregPage($field, $where, $offset, $limit, $order, $flag) {
        $this->where = $where;
        $this->fields = 'count(*)';
        $this->total = $this->getResult(3);
        if ($this->total) {
            $this->offset = $offset;
            $this->fields = $field;
            $this->limit = $limit;
            $this->order = $order;
            return $this->getResult($flag);
        }
    }

    /**
     * 推荐码购车查询
     * 
     * @param string $field  字段列表
     * @param string $where sql 条件
     * @param int $offset
     * @param int $limit  每页最大显示条数
     * @param array $order 排序
     * @return type
     */
    function getInvitebuyPage($field, $where, $order) {
        $this->tables = array(
            'ibuycar_order' => 'io',
            'cardb_user' => 'cu'
        );
        $this->where = $where;

        $this->fields = $field;
        $this->order = $order;
        return $this->joinTable(2);
    }

    //leftjoin
    function getInvitedPage($where, $fields, $order, $offset, $limit) {
        $this->table_name = "cardb_user cu";
        $this->fields = 'count(*) count';
        $this->tables = array(
            'ibuycar_order' => 'io',
            DBNAME2 . '.cardb_model' => 'cm'
        );
        $this->join_condition = array('cu.uid=io.uid and cu.uphone!="" ', 'io.m_id=cm.model_id and io.test_time!=""');
        $this->where = $where;
        $this->total = $this->leftJoin();

        if ($this->total) {
            $this->fields = $fields;
            $this->order = $order;
            $this->offset = $offset;
            $this->limit = $limit;
            return $this->leftJoin(2);
        }
    }

    //leftjoin
    function getInvitedExt($where, $fields, $order) {
        $this->table_name = "cardb_user cu";
        $this->tables = array(
            'ibuycar_order' => 'io',
            DBNAME2 . '.cardb_model' => 'cm'
        );
        $this->join_condition = array('cu.uid=io.uid and cu.uphone!="" ', 'io.m_id=cm.model_id and io.test_time!=""');
        $this->where = $where;
        $this->fields = $fields;
        $this->order = $order;
        $this->offset = $offset;
        $this->limit = $limit;
        return $this->leftJoin(2);
    }

}

?>
