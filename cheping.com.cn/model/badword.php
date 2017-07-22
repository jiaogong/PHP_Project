<?php

/**
 * 评论内容过滤用的关键词model
 * $Id: badword.php 970 2015-10-22 04:09:08Z xiaodawei $
 */
class badword extends model {

    var $total;

    function __construct() {
        $this->table_name = "cp_badwords";
        parent::__construct();
    }

    function getList($fields = "*", $where, $type = 2) {
        $this->where = $where;
        $this->fields = $fields;
        return $this->getResult($type);
    }

}

?>
