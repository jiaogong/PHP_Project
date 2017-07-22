<?php

/**
 * appreview action
 * $Id: appreviewaction.php 1597 2015-12-11 07:16:27Z cuiyuanxin $
 */
import('dcrypt.class', 'lib');

class appreviewAction extends action {

    var $users;
    var $article;
    var $reviews;
    var $uprofiles;

    function __construct() {
        global $adminauth, $login_uid;
        parent::__construct();
        $this->users = new users();
        $this->article = new article();
        $this->reviews = new reviews();
        $this->uprofiles = new users_profiles();
    }

    function doDefault() {
        $this->doOutReviewList($uid);
    }
    
     /**
     * 我的评论列表 
     */
      function doOutReviewList() {
        global $local_host;
        $user_all = dcrypt::privDecrypt($_GET['parse']);
        $parse_query = parseQuery($user_all);
        $user = $parse_query["name"];
        $pwd = $parse_query["password"];
        $page = $parse_query["page"];

        
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $uid = $this->users->verifyUser($user, $pwd);

        switch ($uid) {
            case -1:
                $output = array('code' => -1, 'mes' => '用户名不能为空');
                echo json_encode($output);
                break;
            case -2:
                $output = array('code' => -2, 'mes' => '密码不能为空');
                echo json_encode($output);
                break;
            case 0:
                $output = array('code' => 0, 'mes' => '该用户不存在');
                echo json_encode($output);
                break;
            default:
                if ($uid) {
                    $review_where = "cr.article_id=ca.id and cr.uid='$uid'  and cr.uid=cu.id and ca.state=3 and cr.state=1 and cr.parentid=0";
                    $review_fields = " ca.title,ca.id aid,cr.content rcontent,ca.type_id,cr.created,ca.pic";
                    $review_order = array('cr.created' => 'desc');
                    $review_List = $this->reviews->getApp($review_where, $review_fields, $review_order, 2);
                    
                    $user = $this->users->getList("cu.id='{$uid}'", "cu.id uid,cu.username,cup.avatar", 1);

                    if ($user['avatar']) {
                        $user['avatar'] = $local_host . UPLOAD_DIR . $user['avatar'];
                    } else {
                        $user['avatar'] = "-3";
                    }
                    if ($review_List) {
                        foreach ($review_List as $k => $v) {
                            $review_List[$k]['avatar'] = $user['avatar'];
                            $review_List[$k]['uid'] = $user['uid'];
                            $review_List[$k]['username'] = $user['username'];
                            $review_List[$k]['time'] = format_date($review_List[$k]['created']);
                            $review_List[$k]['pic'] = $local_host . UPLOAD_DIR . $v['pic'];
                        }
                    }
                    
                    if ($review_List) {
                        $num = count($review_List);
                        $pages = ceil($num / $page_size);
                    
                        if (is_numeric($page)) {
                            if ($page > $pages) {
                                $output = array('code' => 15, 'mes' => '没有数据了');
                                exit(json_encode($output));
                            } else {
                                $newarr = array_slice($review_List, $page_start, $page_size);
                                if (!$newarr) {
                                    $output = array('code' => -11, 'mes' => '获取内容失败');
                                    exit(json_encode($output));
                                }
                            }
                        }
                            $output = array('code' => 12, 'list' => $newarr, 'mes' => '数据获取成功');
                            exit(json_encode($output));
                    }else{
                         $output = array('code' => -13, 'list' => $newarr, 'mes' => '没有数据');
                            exit(json_encode($output));
                    }
                }

        }
    }


    /**
     * 评论回复列表 
     * @author wangchangjiang
     */
    function doBackReviewList() {
        global $local_host;

        $user = dcrypt::privDecrypt($_GET['userName']);
        $pwd = dcrypt::privDecrypt($_GET['password']);
        $uid = intval($this->users->verifyUser($user, $pwd));
        $page = dcrypt::privDecrypt($_GET['page']);
        $page = $this->filter($page, HTTP_FILTER_INT);

        if ($uid) {
            $review_where = 'state=1 and parentid=0 and uid=' . $uid;
            $review_fields = ' id ';
            $page_size = 20;
            $reviews_page = max(1, $page);
            $reviews_page_start = ($reviews_page - 1) * $page_size;
            $this->reviews->limit = $page_size;
            $this->reviews->offset = $reviews_page_start;
            $review_id = $this->reviews->getList($review_where, $review_fields, 2);
            

            if ($review_id) {
                foreach ($review_id as $k => $v) {
                    $reviewa_where = 'cr.state=1 and cr.parentid=' . $v['id'] . ' and ca.state=3';
                    $reviewa_fields = ' cr.content rcontent,cr.created rcreated,cr.type_name typename,cr.type_id typeid,cr.uid uid,ca.id aid,ca.title title,ca.pic';
                    $review_order = array('cr.created' => 'desc');
                    $reviewInfos[] = $this->reviews->getListlimit($reviewa_where, $reviewa_fields, $limit, $offset, $review_order, $type = 2);
                }
                if ($reviewInfos) {
                    foreach ($reviewInfos as $k => $v) {
                        if ($v) {
                            foreach ($v as $key => $value) {
                                $uid = $value['uid'];
                                $user_where = ' id=' . $uid;
                                $user_fields = ' username ';
                                $userName = $this->users->getUser($user_fields, $user_where, 1);
                                if ($userName) {
                                    $userNames = $userName;
                                } else {
                                    $userNames = array('username' => '用户名暂无');
                                }
                                $uprofiles_where = ' uid=' . $uid;
                                $uprofiles_fields = ' avatar ';
                                $userAvatar = $this->uprofiles->getUser($uprofiles_fields, $uprofiles_where, 1);
                                if ($userAvatar) {
                                    $userAvatars = $userAvatar;
                                } else {
                                    $userAvatars = array('avatar' => '暂无头像');
                                }

                                $v[$key]['time'] = format_date($v[$key]['rcreated']);
                                $reviewList[$key] = $v[$key] + $userNames + $userAvatars;

                                if ($reviewList[$key]['avatar'] != '暂无头像') {
                                    $reviewList[$key]['avatar'] = $local_host . UPLOAD_DIR . $reviewList[$key]['avatar'];
                                } else {
                                    $reviewList[$key]['avatar'] = $reviewList[$key]['avatar'];
                                }
                                $reviewList[$key]['pic'] = $local_host . UPLOAD_DIR . $value['pic'];
                            }
                        }
                    }

                    if ($reviewList) {
                        $output = array('code' => 12, 'list' => $reviewList, 'mes' => '数据获取成功');
                        echo json_encode($output);
                    } else {
                        $output = array('code' => -23, 'mes' => '获取回复用户信息异常');
                        exit(json_encode($output));
                    }
                } else {
                    $output = array('code' => -22, 'mes' => '没有与你相关的评论内容');
                    exit(json_encode($output));
                }
            } else {
                $output = array('code' => -24, 'mes' => '没有要请求的数据');
                exit(json_encode($output));
            }
        } else {
            $output = array('code' => -21, 'mes' => '用户信息出现错误');
            exit(json_encode($output));
        }
    }

}

?>
