<?php

/**
 * 评论页面action
 * $Id: reviewaction.php 2540 2016-05-09 02:26:18Z wangchangjiang $
 * @author David Shaw <tudibao@163.com>
 */
class reviewAction extends action {

    public $user;
    public $review;
    public $badword;
    public $pagedate;
    public $tag;

    function __construct() {
        parent::__construct();
        $this->user = new users();
        $this->review = new reviews();
        $this->badword = new badword();
        $this->tag = new tag();
        $this->pagedate = new pageData();
    }

    function doDefault() {
        $this->doList();
    }

    function doList() {
        $tpl_name = "article_review";
        $css = array("index", 'wenzhangzuizhong');
        $js = array("jquery-1.8.3.min", 'global');
        $this->vars('css', $css);
        $this->vars('js', $js);
        $uid = session("uid");
        $this->vars("uid", $uid);
        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
        $page = max(1, $page);
        $page_size = 10;
        $page_start = ($page - 1) * $page_size;

        $type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_NUMBER_INT);
        $type = $type ? $type : 1;
        $article_id = intval($_REQUEST['article_id']);
        $type_id = intval($_REQUEST['type_id']);
        $state = $this->filter($_GET['state'], HTTP_FILTER_INT);
        if ($type == 1) {
            $order = array("cr.created" => "desc", "cr.praise" => "desc");
        } else {
            $order = array("cr.praise" => "desc", "cr.created" => "desc");
        }
        if (empty($state)) {
            switch ($uid) {
                case 0:
                    $extra .="&type=$type&article_id=$article_id&type_id=$type_id";
                    $where = "cr.uid=cu.id and cr.type_id='{$type_id}' and cr.state=1 and cr.parentid=0 and cr.article_id='{$article_id}'";
                    $list = $this->review->getPriceAndModelA($where, $page_size, $page_start, $order);
                    $total = $this->review->total;
                    $page_bar = multipage::multi($total, $page_size, $page, '/review.php?action=list' . $extra);
                    break;
                default:
                    $extra .="&type=$type&article_id=$article_id&type_id=$type_id&state=$state";
                    $where = "cr.uid=cu.id and cr.type_id='{$type_id}' and cr.state!=0 and cr.parentid=0 and cr.article_id='{$article_id}'";
                    $list = $this->review->getPriceAndModelA($where, $page_size, $page_start, $order);
                    if ($list)
                        foreach ($list as $key => $val) {
                            if ($val[state] == 2) {
                                if ($uid !== $val[uid]) {
                                    unset($list[$key]);
                                }
                            }
                        }
                    $total = count($list);
                    $page_bar = multipage::multi($this->review->total, $page_size, $page, '/review.php?action=list' . $extra);
            }
        } else {
            $extra .="&type=$type&article_id=$article_id";
            $where = "cr.uid=cu.id and cr.type_id='{$type_id}' and cr.state!=0 and  cr.parentid=0 and cr.article_id='{$article_id}'";
            $list = $this->review->getPriceAndModelA($where, $page_size, $page_start, $order);
            if ($list)
                foreach ($list as $key => $val) {
                    if ($val[state] == 2) {
                        if ($uid !== $val[uid]) {
                            unset($list[$key]);
                        }
                    }
                }
            $total = count($list);
            $page_bar = multipage::multi($this->review->total, $page_size, $page, '/review.php?action=list' . $extra);
        }
        $total = $total ? $total : 0;
        //显示楼数
        $num = $total - $page_start;
        $page_bar = replaceReviewURL($page_bar);
        $this->vars('list', $list);
        $this->vars("type", $type);
        $this->vars('total', $total);
        $this->vars("type_id", $type_id);
        $this->vars('num', $num);
        $this->vars('page_bar', $page_bar);
        $this->vars('article_id', $article_id);
        $this->template($tpl_name);
    }

    function doSubmitReview() {
        $message = '';
        $uid = session("uid");
        #type_id，为空时，默认为1，代表文章评论
        $type_id = $this->filter($_POST['type_id'], HTTP_FILTER_INT, 1);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_MAGIC_QUOTES);
        $content = preg_replace('/(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/im', '', preg_replace('/<(.*?)>/is', "", trim($content)));

        #只有登录用户及有评论内容，才能写表操作
        if (!empty($uid) && !empty($content)) {
            $users = $this->user->getUser('id,username', "id='$uid'", 1);
            $article_id = filter_input(INPUT_POST, 'article_id', FILTER_SANITIZE_NUMBER_INT);
            $ip = util::getip();
            $badwords = $this->badword->getlist("badwords", "id=1", 3);
            $array = array_filter(explode("|", $badwords));
            $badword1 = array_combine($array, array_fill(0, count($array), '*'));
            $str = strtr($content, $badword1);
            //获取全局开关
            $strs = $this->pagedate->getSomePagedata("value", "name='review'", 3);
            $shenhe = unserialize($strs);
            $this->review->ufields = array(
                "content" => $content,
                "type_id" => $type_id,
                "uid" => $users['id'],
                "uname" => $users['username'],
                "created" => $this->timestamp,
                "article_id" => $article_id,
                "ip" => $ip,
            );
            $review_url = "/review.php?action=list&article_id={$article_id}&state={$shenhe}&type_id={$type_id}";
            switch ($shenhe) {
                case 1:
                    $this->review->ufields['state'] = 2;
                    $r = $this->review->insert();
                    if ($r) {
                        $this->alert('', 'js', 3, $review_url);
                    } else {
                        $message = '评论失败--！';
                        $this->alert($message, 'js', 3, $review_url);
                    }
                    break;
                case 0:
                    $this->review->ufields['state'] = 1;
                    $r = $this->review->insert();
                    if ($r) {
                        $this->alert('', 'js', 3, $review_url);
                    } else {
                        $message = '评论失败~~！';
                        $this->alert($message, 'js', 3, $review_url);
                    }
                    break;
                default:
                    echo "程序出现错误！";
            }
        } else {
            $review_url = "/review.php?action=list&article_id={$article_id}&state={$shenhe}";
            if (empty($uid)) {
                $message = '请先登录，再评论！';
            } elseif (empty($content)) {
                $message = '评论内容不能为空！';
            }
            $this->alert($message, 'js', 3, $review_url);
        }
    }

    //评论回复
    function doReviewAnswer() {
        $uid = session("uid");
        if (empty($uid))
            exit;

        $users = $this->user->getUser('id,username', "id='$uid'", 1);
        $content = filter_input(INPUT_GET, 'contents', FILTER_SANITIZE_MAGIC_QUOTES);
        $content = preg_replace('/(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/im', '', preg_replace('/<(.*?)>/is', "", trim($content)));
        $parentid = intval($_GET['id']);
        $article_id = intval($_GET['article_id']);
        $ip = util::getip();
        $strs = $this->pagedate->getSomePagedata("value", "name='review'", 3);
        $shenhe = unserialize($strs);

        if ($shenhe == 1) {
            #关键词过滤，暂时屏蔽不用
            if (0) {
                $badwords = $this->badword->getlist("badwords", "id=1", 3);
                $array = array_filter(explode("|", $badwords));
                $badword1 = array_combine($array, array_fill(0, count($array), '*'));
                $str = strtr($content, $badword1);
            }
            if ($users[id] && $content) {
                $this->review->ufields = array(
                    "content" => $content,
                    "type_id" => 1,
                    "uid" => $users[id],
                    "uname" => $users['username'],
                    "created" => time(),
                    'article_id' => $article_id,
                    "parentid" => $parentid,
                    "ip" => $ip,
                    "state" => 2
                );
                $id = $this->review->insert();
            }
            $html = '';
            if ($id) {
                $html .='<div class="repeat"><span class="repeatsp1 fl">' . $users['username'] . '</span><span class="repeatsp2 fl"  style="color:#ed2d28;">提交成功，您的回复内容正在审核中，请耐心等待 </span><span class="repeatsp3 fr">刚刚</span>  <div class="clear"></div></div>';
            } else {
                $html = false;
            }
            echo $html;
        } else {
            #关键词过滤，暂时屏蔽不用
            if (0) {
                $badwords = $this->badword->getlist("badwords", "id=1", 3);
                $array = array_filter(explode("|", $badwords));
                $badword1 = array_combine($array, array_fill(0, count($array), '*'));
                $str = strtr($content, $badword1);
            }
            if ($users[id] && $content) {
                $this->review->ufields = array(
                    "content" => $content,
                    "type_id" => 1,
                    "uid" => $users[id],
                    "uname" => $users['username'],
                    'article_id' => $article_id,
                    "created" => time(),
                    "parentid" => $parentid,
                    "ip" => $ip,
                    "state" => 1
                );
                $id = $this->review->insert();
            }
            $html = '';
            if ($id) {
                $html .='<div class="repeat"><span class="repeatsp1 fl">' . $users['username'] . '</span><span class="repeatsp2 fl">' . $content . '</span><span class="repeatsp3 fr">刚刚</span>  <div class="clear"></div></div>';
            } else {
                $html = false;
            }
            echo $html;
        }
    }

    function doReviewPraise() {
        $ip = util::getip();
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $ltime = 24 * 3600;
        $state = 0;
        $isArr = cookie("review_praise");
        $isArr = unserialize($isArr);
        if ($isArr) {
            $str = array_search($id, $isArr[$ip]);
            if ($str !== FALSE) {
                $state = 1;
            } else {
                $isArr[$ip][] = $id;
                $isArr = serialize($isArr);
                cookie("review_praise", $isArr, $ltime);
            }
        } else {
            $content[$ip][] = $id;
            $content = serialize($content);
            cookie("review_praise", $content, $ltime);
        }

        if ($state) {
            echo -4;
        } elseif (!empty($id)) {
            $praise = $this->review->getlist("id='{$id}'", "praise", 3);
            $praise_num = $praise + 1;
            $this->review->ufields = array(
                "praise" => $praise_num,
                "ip" => $ip,
            );
            $this->review->where = "id=$id";
            $this->review->update();
            echo "赞($praise_num)";
        }
    }

}
