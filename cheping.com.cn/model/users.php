<?php

/**
 * 注册的用户model
 * $Id: users.php 2937 2016-06-06 09:49:02Z wangqin $
 * @author David Shaw <tudibao@163.com>
 */
class users extends model {

    function __construct() {
        $this->table_name = "cp_user";
        parent::__construct();
    }

    function addUser($ufields) {
        $this->ufields = $ufields;
        return $this->insert();
    }

    function addBingoUser($ufields) {
        $this->table_name = DBNAME2 . ".cardb_user";
        $this->ufields = $ufields;
        return $this->insert();
    }

    function updateibuycarUser($ufields, $where) {
        $this->table_name = DBNAME2 . ".cardb_user";
        $this->ufields = $ufields;
        $this->where = $where;
        $this->update();
    }

    /**
     * 更新用户表users
     * $Id: users.php 2937 2016-06-06 09:49:02Z wangqin $
     */
    function updateUser($ufields, $where) {
        $this->ufields = $ufields;
        $this->where = $where;
        return $this->update();
    }

    function getUser($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        return $this->getResult($flag);
    }

    function getUserAttention($uid) {
        $this->fields = 'attention';
        $this->where = "uid = $uid";
        $attention = $this->getResult(3);
        if ($attention)
            $arr = explode(',', $attention);
        else
            $arr = array();
        return $arr;
    }
        /**
     * 根据id查询字段
     */
    function getUsers($uid) {
        $this->fields = '*';
        $this->where = "id = $uid";
        $attention = $this->getResult(1);
        return $attention;
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
        $this->fields = 'count(uphone)';
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
    function getInvitebuyPage($field, $where, $offset, $limit, $order) {
        $this->tables = array(
            'ibuycar_order' => 'io',
            'cardb_user' => 'cu'
        );
        $this->fields = 'count(*)';
        $this->where = $where;
        $this->total = $this->joinTable(3);

        if ($this->total) {
            $this->fields = $field;
            $this->offset = $offset;
            $this->limit = $limit;
            $this->order = $order;
            return $this->joinTable(2);
        }
    }

    /**
     * 个人关注
     * 
     * @param string $field  字段列表
     * @param string $where sql 条件
     * @param int $offset  设置查询的起始位置
     * @param int $limit  每页最大显示条数
     * @param array $order 排序
     * @return array
     */
    function getGuan($field, $where, $offset, $limit, $order) {
        $this->tables = array(
            'cardb_guan' => 'cg',
            DBNAME2 . '.cardb_model' => 'cm',
            DBNAME2 . '.cardb_factory' => 'cf',
            DBNAME2 . '.cardb_series' => 'cs'
        );
        $this->fields = 'count(*)';
        $this->where = $where;
        $this->total = $this->joinTable(3);
        if ($this->total) {
            $this->fields = $field;
            $this->offset = $offset;
            $this->limit = $limit;
            $this->order = $order;
            return $this->joinTable(2);
        }
    }

    function getList($where, $fields = "*", $type = 2) {
        $this->tables = array(
            'cp_user' => 'cu',
            'cp_user_profiles' => 'cup',
        );
        $this->join_condition = array(
            'cu.id=cup.uid'
        );
        $this->where = $where;
        $this->fields = $fields;
        return $this->leftJoin($type);
    }
    /**
     * 查询字段
     */
    function fildss($filds,$where,$flag=1){
       $this->fields = $fields;
       $this->where = $where;
       return $this->getResult($flag);
    }
    /**
     * 验证用户信息
     * 
     * @param string $user  用户名
     * @param string $pwd   密码

     */
    function verifyUser($user, $pwd) {
        $phoneReg = '/^(13|18|15|17)\d{9,}$/';
        if (empty($user)) {
            return -1;
        } else if (empty($pwd)) {
            return -2;
        } else {
            if (preg_match($phoneReg, $user)) {
                $uid = $this->getUser('id', "mobile='{$user}' and password='$pwd'", 1);
            } else {
                $uid = $this->getUser('id', "username='{$user}' and password='$pwd'", 1);
            }
        }
        if (!empty($uid['id'])) {
            return $uid['id'];
        } else {
            return 0;
        }
    }

}

?>
