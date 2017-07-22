<?php

/**
 * page_data_notice
 * $Id: cp_pagedatanotice.php 1789 2016-03-24 08:39:22Z wangchangjiang $
 */
class cp_pageDataNotice extends model {
    function __construct() {
        parent::__construct();
        $this->table_name = 'page_data_notice';
    }
    function getNotice($pdName) {
        $this->fields = 'content';
        $this->where = "pd_name = '$pdName'";
        $result = $this->getResult(3);
        return $result;
    }
    function getNoticeId($pdName) {
        $this->fields = 'id';
        $this->where = "pd_name = '$pdName'";
        $result = $this->getResult(3);
        return $result;        
    }
    function insertNotice($ufields) {
        $this->ufields = $ufields;
        $id = $this->insert();
        return $id;
    }
    function updateNotice($pdName, $content) {
        $this->ufields = array(
            'content' => "$content"
        );
        $this->where = "pd_name = '$pdName'";
        $this->update();
    }
}
?>
