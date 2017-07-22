<?php

/**
 * 最终页面（文章、视频）收藏功能
 * $Id: collectaction.php 669 2015-08-25 07:09:53Z xiaodawei $
 * @author David.Shaw <tudibao@163.com>
 */
class collectAction extends action {

    public $user;
    public $article;
    public $article_category;
    public $collect;

    function __construct() {
        parent::__construct();
        $this->user = new users();
        $this->article = new article();
        $this->article_category = new article_category();
        $this->collect = new collect();
    }

    function doDefault() {
        $this->doCollect();
    }

    /**
     * 侧边栏收藏功能
     * 文章右侧星号的收藏按钮触发此事件
     */
    function doCollect() {
        $uid = session("uid");
        $type = intval($_GET['type']);
        $type_id = $this->filter($_GET['type_id'], HTTP_FILTER_INT, 1);
        $article_id = intval($_GET['article_id']);

        $uid = intval($uid);
        $arr['state'] = 1;

        #通过session数据判断登录用户，然后再查数据，保证安全
        if ($uid) {
            $article = $this->article->getlist("*", "id='{$article_id}'", 1);
            $categoryarr = $this->article_category->getParentCategory("pca.category_name p_category_name,ca.*", "ca.id='{$article['category_id']}' and pca.id=ca.parentid", 1);
            $users = $this->user->getUser('id,username', "id='$uid'", 1);
            $id = $this->collect->getlist("id", "uid='{$uid}' and article_id='{$article_id}'", 3);
            if ($type && !$id) {
                $arr['state'] = 0;
            } elseif ($id) {
                $this->collect->where = "uid='{$uid}' and id='{$id}'";
                $this->collect->del();
                $arr['state'] = 0;
            } else {
                $this->collect->ufields = array(
                    "uid" => $uid,
                    "uname" => $users['username'],
                    "created" => $this->timestamp,
                    "article_id" => $article_id,
                    "category_name" => $categoryarr['p_category_name'],
                    "category_id" => $categoryarr['parentid'],
                    "type_id" => $type_id,
                );
                $this->collect->insert();
            }
        }
        #未登录用户，直接返回错误代码，禁止收藏
        else {
            $arr['state'] = -1;
        }
        $num = $this->collect->getlist("count(id)", "article_id='{$article_id}'", 3);
        $arr['num'] = $num;
        echo json_encode($arr);
    }
    
    /**
     * 显示当前用户收藏数、状态
     * @author David Shaw <tudibao@163.com>
     */
    function doShow(){
        $uid = session("uid");
        $article_id = $this->filter($_GET['article_id'], HTTP_FILTER_INT);
        
        #初始化状态数组，即未登录状态，收藏数0
        $arr = array('state' => -1, 'num' => 0);
        if ($uid) {
            $num = $this->collect->getlist("count(id)", "article_id='{$article_id}'", 3);
            $arr['num'] = $num;
            
            #当state=1时，收藏的星星为红色，否则为灰色
            $arr['state'] = 0; 
        }
        echo json_encode($arr);
    }

}
