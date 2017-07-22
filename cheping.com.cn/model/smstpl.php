<?php

/**
 * 短信模板model
 * $Id: smstpl.php 971 2015-10-22 04:09:19Z xiaodawei $
 * @author David Shaw <tudibao@163.com>
 */
class smsTpl extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = 'cardb_smstpl';
    }

    function getTpl($id) {
        $this->fields = 'content';
        $this->where = "id = '$id' and state=1";
        $result = $this->getResult(3);
        return $result;
    }

}

?>