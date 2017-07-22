<?php

class bbspost extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = "cp_post";
    }

    function getSelect($field = '*', $where = 1, $type = 2) {
        $this->fields = $field;
        $this->where = $where;
        $res = $this->getResult($type);
        if ($res) {
            return $res;
        } else {
            return FALSE;
        }
    }

    function getAdd($ufields) {
        $this->ufields = $ufields;
        return $this->insert();
    }

    function getUpdate($ufields, $where) {
        $this->ufields = $ufields;
        $this->where = $where;
        return $this->update();
    }

    function getEven($field, $where, $limit = 20, $offset = 0, $order = array(), $type = 2) {
        $this->tables = array(
            'cp_post' => 'cp',
            'cp_thread' => 'ct',
            'cp_forum' => 'cf'
        );
        $this->where = $where . ' and ct.fid = cf.fid';
        $this->fields = "count(cp.pid)";
        $this->total = $this->joinTable(3);

        $this->fields = $field;
        $this->where = $where . ' and ct.fid = cf.fid';
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order = $order;
        $res = $this->joinTable($type);
        if ($res) {
            return $res;
        } else {
            return FALSE;
        }
    }

    function getEvens($field, $where, $order = array(), $type = 2) {
        $this->tables = array(
            'cp_post' => 'cp',
            'cp_thread' => 'ct',
            'cp_forum' => 'cf'
        );

        $this->fields = $field;
        $this->where = $where . ' and ct.fid = cf.fid';
        $this->order = $order;
        $res = $this->joinTable($type);
        if ($res) {
            return $res;
        } else {
            return FALSE;
        }
    }

    function getEvena($field, $where, $type = 2) {
        $this->tables = array(
            'cp_post' => 'cp',
            'cp_thread' => 'ct',
            'cp_forum' => 'cf',
            'cp_user' => 'cu'
        );

        $this->fields = $field;
        $this->where = $where;
        $res = $this->joinTable($type);
        if ($res) {
            return $res;
        } else {
            return FALSE;
        }
    }

    function getEvenb($field, $where, $limit = 20, $offset = 0, $order = array(), $type = 2) {
        $this->tables = array(
            'cp' => 'cp_post',
            'ct' => 'cp_thread',
            'cf' => 'cp_forum',
            'cu' => 'cp_user',
            'cpp' => 'cp_post'
        );
        $this->where = $where;
        $this->fields = "count(cp.pid)";
        $this->total = $this->joinTable(3);

        $this->fields = $field;
        $this->where = $where;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order = $order;
        $res = $this->joinTable($type);
        if ($res) {
            return $res;
        } else {
            return FALSE;
        }
    }

}

?>
