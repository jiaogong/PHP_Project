<?php

/**
 * wap视频页 video
 * $Id: wapvideoaction.php 983 2015-11-23 10:56:45Z cuiyuanxin $
 */
class wapreviewAction extends action {

    public $user;
    public $review;
    public $badword;
    public $pagedate;
    public $tag;
    public $article;

    function __construct() {
        parent::__construct();
        $this->article = new article();
        $this->user = new users();
        $this->review = new reviews();
        $this->badword = new badword();
        $this->tag = new tag();
        $this->pagedate = new pageData();
        $this->userinfo = new users_profiles();
    }

    function doreview() {
        $uid = session('uid');
        $username = session('username');
        $avator = $this->userinfo->getUsers($uid);
        $this->vars('name', $username); //分配名字
        $this->vars("avatar", $avator['avatar']);
        $css = array("reset","people");
        $title = "wap-评论页";
        $js = array("jquery-1.8.3.min");
        $articleIdo = intval($_GET['articleId']); //获取a连接上面的文章id
        if ($articleIdo) {
            $where = "id=" . $articleIdo;
        }
        $aTitle = $this->article->getTitle($where); //查询文章的标题以及文章的作者
        $wheres = "cr.article_id=" . $articleIdo . " and cr.uid=cup.uid and state=1 and cr.parentid=0";
        $order = array("cr.created" => "desc");
        $review = $this->review->getReview($wheres, $order); //查询所有的用户对这篇文章的回复
        if ($review) {
            foreach ($review as $key => $val) {
                $whereson = "cr.parentid=" . $val["id"] . " and cup.uid=cr.uid and state=1 and cr.parentid>0";
                $iRviewson = $this->review->getReview($whereson); //查询二级评论
                //把传出来的结果集给$ireview
                $review[$key]["reviewson"] = $iRviewson;
            }
        }
        $this->vars("title", $title);
        $this->vars("css", $css);
        $this->vars("js", $js);
        $this->vars("rview", $review);
        $this->vars("article", $aTitle);
        $this->template('wap_review', '', 'replaceWapNewsUrl');
    }
}
