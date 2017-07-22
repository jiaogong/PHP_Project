<?php

/**
 * cp_forum
 * $Id: bbsforum.php 3010 2016-06-08 04:12:41Z wangchangjiang $
 */
class bbsforum extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = "cp_forum";
    }

    /**
     * 获取论坛版块相关信息
     *
     * @param $fields
     * @param null $where
     * @param int $flag
     * @return mixed
     */
    function getForumTypeData($fields, $where=Null,$order=Null, $flag=1){
        $this->fields= $fields;
        if($where)
            $this->where = $where;
        if($order)
            $this->order = $order;
        return $this->getResult($flag);
    }
    /**
     * 获取论坛版块与主题的相关信息
     *
     * @param $fields
     * @param null $where
     * @param int $flag
     * @return mixed
     */
    function getForumAndThemeData($fields, $where=Null,$order=Null, $flag=1){
        $this->tables = array(
            'cp_forum' => 'cf',
            'cp_thread' => 'ct'
        );
        $this->fields= $fields;
        if($where)
            $this->where = $where;
        if($order)
            $this->order = $order;
        return $this->getResult($flag);
    }

    /**
     * 当发帖成功时，论坛版块的帖子数量加1
     *
     * @param  int $fid
     * @return bool
     */
    function addPostToNum($fid){
        $this->fields = "posts";
        $this->where = "fid={$fid}";
        $this->total = $this->getResult(3);
        $forum_posts_num = $this->total;

        $this->ufields = array('posts', $forum_posts_num + 1);
        $this->where = "fid={$fid}";
        return $this->update();
    }

    /**
     * 当删除帖子成功时，论坛版块的帖子数量减1
     *
     * @param  int $fid
     * @return bool
     */
    function delPostToNum($fid){
        $this->fields = "posts";
        $this->where = "fid={$fid}";
        $this->total = $this->getResult(3);
        $forum_posts_num = $this->total;

        if($forum_posts_num) {
            $this->ufields = array('posts', $forum_posts_num - 1);
            $this->where = "fid={$fid}";
            return $this->update();
        }
    }
    /**
     * 当添加主题成功时，论坛版块的主题数量加1
     *
     * @param  int $fid
     * @return bool
     */
    function addThemeToNum($fid){
        $this->fields = "threads";
        $this->where = "fid={$fid}";
        $this->total = $this->getResult(3);
        $forum_threads_num = $this->total;

        $this->ufields = array('threads', $forum_threads_num + 1);
        $this->where = "fid={$fid}";
        return $this->update();
    }
    /**
     * 当删除主题成功时，论坛版块的主题数量减1
     *
     * @param  int $fid
     * @return bool
     */
    function delThemeToNum($fid){
        $this->fields = "threads";
        $this->where = "fid={$fid}";
        $this->total = $this->getResult(3);
        $forum_threads_num = $this->total;

        if($forum_threads_num) {
            $this->ufields = array('threads', $forum_threads_num - 1);
            $this->where = "fid={$fid}";
            return $this->update();
        }
    }
}

?>
