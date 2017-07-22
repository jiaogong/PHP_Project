<?php

/**
 * appcollect action
 * $Id: appcollectaction.php 1449 2015-11-26 06:39:49Z wangchangjiang $
 */
import('dcrypt.class', 'lib');

class appcollectAction extends action {

    var $users;
    var $article;
    var $collect;
    var $reviews;

    function __construct() {
        global $adminauth, $login_uid;
        parent::__construct();
        $this->users = new users();
        $this->article = new article();
        $this->collect = new collect();
        $this->reviews = new reviews();
    }

    function doDefault() {
        $this->doCollectList();
    }

    function doCollectList() {
        global $local_host;
        $userName = dcrypt::privDecrypt($_GET['userName']);
        $userName = $this->filter($userName, HTTP_FILTER_STRING);
        if ($userName) {
            $fields = "id";
            $where = "username='{$userName}'";
            $uid = $this->users->getUser($fields, $where, 3);
            if ($uid) {
                $collect_where = ' uid = ' . $uid;
                $list = $this->collect->getList($fields = "*", $collect_where, $type = 2);
                if ($list) {
                    foreach ($list as $k => $v) {
                        $collect_id[] = $v['id'];
                    }
                    if (!$_GET['page']) {
                        foreach ($list as $k => $v) {
                            $article_where = 'state=3 AND id = ' . $v[article_id];
                            $article_order = array('uptime' => 'desc');
                            $list_count[] = $this->article->getArticleList($article_where, $fields = "id,title,chief,pic,type_id,uptime", $limit = 20, $offset = 0, $article_order, $type = 2);

                            $review_where = " article_id =" . $v['article_id'];
                            $review_fields = "count(*)";
                            $review_num_list[] = $this->reviews->getList($review_where, $review_fields, 3);
                            foreach ($review_num_list as $k => $v) {
                                $list_count[$k][0]['reviews'] = $v;
                                $list_collect[$k] = $list_count[$k][0];
                                $list_collect[$k]['collect_id'] = $collect_id[$k];
                                $list_collect[$k]['pic'] = $local_host . UPLOAD_DIR . $list_count[$k][0]['pic'];
                                $list_collect[$k]['uptime'] = date('Y-m-d', $list_count[$k][0]['uptime']);
                            }
                        }
                        $output = array('code' => 1, 'type' => $list_collect, 'mes' => '数据获取成功');
                        exit(json_encode($output));
                    } else {
                        foreach ($list as $k => $v) {
                            $article_where = 'state=3 AND id = ' . $v['article_id'];
                            $pagetopic = intval($_GET['page']);
                            $page = max(1, $pagetopic);
                            $page_size = 20;
                            $page_start = ($page - 1) * $page_size;
                            $article_order2 = array('uptime' => 'desc');
                            $list_count[] = $this->article->getArticleList($article_where, $fields = "id,title,chief,pic,type_id,uptime", $page_size, $page_start, $article_order2, $type = 2);
                            $review_where = " article_id =" . $v[article_id];
                            $review_fields = "count(*)";
                            $review_num_list[] = $this->reviews->getList($review_where, $review_fields, 3);
                            foreach ($review_num_list as $k => $v) {
                                $list_count[$k][0]['reviews'] = $v;
                                $list_collect[$k] = $list_count[$k][0];
                                $list_collect[$k]['collect_id'] = $collect_id[$k];
                                $list_collect[$k]['pic'] = $local_host . UPLOAD_DIR . $list_count[$k][0]['pic'];
                                $list_collect[$k]['uptime'] = date('Y-m-d', $list_count[$k][0]['uptime']);
                            }
                        }
                        $page_num = intval(ceil(count($list_count) / $page_size));
                        if ($page_num < intval($_GET['page'])) {
                            $output = array('code' => -14, 'mes' => '剩余没有收藏数据了');
                            exit(json_encode($output));
                        } else {
                            $output = array('code' => 1, 'type' => $list_collect,  'mes' => '数据获取成功');
                            exit(json_encode($output));
                        }
                    }
                } else {
                    $output = array('code' => -13, 'mes' => '你没有收藏数据');
                    exit(json_encode($output));
                }
            } else {
                $output = array('code' => -12, 'mes' => '用户名存在问题');
                exit(json_encode($output));
            }
        } else {
            $output = array('code' => -11, 'mes' => '用户名获取出现故障');
            exit(json_encode($output));
        }
    }

    function doDelCollect() {
        global $local_host;
        $collect_id = dcrypt::privDecrypt($_GET['collect_id']);
        $collect_id = $this->filter($collect_id, HTTP_FILTER_INT);
        if ($collect_id) {
            $this->collect->where = 'id =' . $collect_id;
            $del_centent = $this->collect->del();
            if (!$del_centent) {
                $output = array('code' => -22, 'mes' => '删除内容失败');
                exit(json_encode($output));
            } else {
                $output = array('code' => 2, 'mes' => '删除内容成功');
                exit(json_encode($output));
            }
        } else {
            $output = array('code' => -21, 'mes' => '获取参数失败');
            exit(json_encode($output));
        }
    }

}

?>
