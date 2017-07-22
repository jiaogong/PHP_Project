<?php

/**
 * cp_post 帖子
 * $Id: bbspost.php 3010 2016-06-08 04:12:41Z wangchangjiang $
 */
class bbsPost extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = "cp_post";
    }

    /**
     * 获取精选推荐帖列表
     * @return mixed
     */
    function getRecommendList($offset, $limit) {
        $this->fields = "count(*)";
        $this->where = "invisible=1 and status=0 and  first=1";
        $this->total = $this->getResult(3);

        $this->fields = "*";
        $this->where = "invisible=1 and status=0 and  first=1";
        $this->order = array('firstsort'=>'ASC','firstdate'=>'DESC');
        $this->offset= $offset;
        $this->limit = $limit;
        return $this->getResult(2);
    }

    /**
     * 根据帖子id 返回 帖子标题和是否推荐
     * @param $pid
     * @return mixed
     */
    function getPostIdTOData($pid){
        $this->fields = "*";
        $this->where = "invisible=1 and pid={$pid} and status<>2 and popularize=0";
        return $this->getResult(1);
    }

    /**
     * 根据帖子id 返回 帖子标题和是否推荐
     * @param $pid
     * @return mixed
     */
    function getpopularizeIdTOData($pid){
        $this->fields = "*";
        $this->where = "invisible=1 and pid={$pid} and status<>2 and popularize=1";
        return $this->getResult(1);
    }

    /**
     * 获取帖子相应的数据
     * @param string $fields
     * @param string $where
     * @param int $flag
     * @param int $offset
     * @param int $limit
     * @return mixed
     */
    function getData($fields="*", $where="", $flag=1, $offset=0, $limit=1){
        $this->fields = "count(pid)";
        $this->where = $where;
        $this->total = $this->getResult(3);

        $this->fields = $fields;
        $this->where = $where;
        if($offset)
            $this->offset = $offset;
        if($limit)
            $this->limit = $limit;
        return $this->getResult($flag);
    }

}

?>
