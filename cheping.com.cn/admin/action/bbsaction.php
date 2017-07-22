<?php

/**
 * appbbs action
 * $Id: bbsaction.php 2965 2016-06-07 08:27:14Z wangchangjiang $
 */
class bbsAction extends action {

    var $bbspost;
    var $bbsforum;
    var $bbsthread;

    function __construct() {
        global $adminauth, $login_uid;
        parent::__construct();
        $adminauth->checkAuth($login_uid, 'sys_module', 1801, 'A');
        $this->bbspost = new bbspost();
        $this->bbsforum = new bbsforum();
        $this->bbsthread = new bbsthread();
    }

    function doDefault() {
        $this->doRecommendList();
    }

    //精选推荐帖子列表
    function doRecommendList() {
        $this->page_title = "精选推荐帖子列表";
        $this->tpl_file = "bbsrecommendlist";
        $page = $this->getValue('page')->Int();
        $page = max(1, $page);
        $page_size = 18;
        $page_start = ($page - 1) * $page_size;
        $pid = $this->getValue('pid')->Int();
        $event = $this->getValue('event')->String();
        if($pid && $event=='cancel'){
            $this->bbspost->ufields = array('first'=>0);
            $this->bbspost->where = "pid={$pid}";
            $res = $this->bbspost->update();
            if($res){
                $this->alert('推荐帖取消成功！', 'js', 3, $_ENV['PHP_SELF']. "RecommendList");
            }
        }
        $postRecommendList = $this->bbspost->getRecommendList($page_start, $page_size);
        $total = $this->bbspost->total;
        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . "RecommendList");
        $this->vars('list', $postRecommendList);
        $this->vars('page_bar', $page_bar);
        $this->template();
    }

    // 添加/编辑 精选推荐帖
    function doaddRecommend(){
        global $local_host, $login_uid, $login_uname;
        $switch = $res = '';
        $pid = $this->getValue('pid')->Int();
        if ($pid) {
            $switch = "编辑";
            $first_list = $this->bbspost->getPostIdTOData($pid);

            $this->vars('list', $first_list);
            $this->vars('edit', 1);
        }else {
            $switch = "添加";
        }
        $this->page_title = "{$switch}精选推荐帖";
        $this->tpl_file = "bbsaddrecommend";
        if ($_POST) {
            $pids = $this->postValue('pid')->Int();
            $firsttitle = $this->postValue('firsttitle')->String();
            $firstpic = $this->postValue('firstpic')->String();
            $firstdate = $this->postValue('firstdate')->String();
            $firstsort = $this->postValue('firstsort')->Int();
            if(!$firstsort || $firstsort>100){
                $firstsort = 100;
            }
            $status = $this->postValue('status')->Int();
            $first = 1;
            $firstauthorid = $login_uid;
            $firstauthor = $login_uname;
            $this->bbspost->ufields = array(
                "firsttitle" => $firsttitle,
                "firstpic" => $firstpic,
                "firstdate" => strtotime($firstdate),
                "firstsort" => $firstsort,
                "status" => $status,
                "first" => $first,
                "firstauthorid" => $firstauthorid,
                "firstauthor" => $firstauthor,
                'firsttime' => time()
            );
            if($pid){
                $this->bbspost->where = "pid={$pid}";
                $res = $this->bbspost->update();
            }else {
                $this->bbspost->where = "pid={$pids}";
                $res = $this->bbspost->update();
            }
            $message = $res ? '成功' : '失败';
            $this->alert("帖子推荐{$message}！", 'js', 3, $_ENV['PHP_SELF'] . "RecommendList");
        }

        $this->vars('main_site', $local_host);
        $this->template();

    }

    //添加/编辑 推广帖
    function doaddPopularize(){
        global $local_host, $login_uid, $login_uname;
        $pid = $this->getValue('pid')->Int();
        $switch = $res = '';
        if ($pid) {
            $switch = "编辑";
            $this->tpl_file = "bbsaddpopularize";
            $first_list = $this->bbspost->getpopularizeIdTOData($pid);
            $this->vars('list', $first_list);
            $this->vars('edit', 2);
        }else {
            $switch = "添加";
        }
        $this->page_title = "{$switch}推广帖";
        $this->tpl_file = "bbsaddpopularize";

        if ($_POST) {
            $firsttitle = $this->postValue('firsttitle')->String();
            $firstpic = $this->postValue('firstpic')->String();
            $popularizeurl = $this->postValue('popularizeurl')->String();
            $firstdate = $this->postValue('firstdate')->String();
            $status = $this->postValue('status')->Int();
            $firstsort = $this->postValue('firstsort')->Int();
            if(!$firstsort  || $firstsort>100){
                $firstsort = 100;
            }
            $first = 1;
            $popularize = 1;
            $authorid = $login_uid;
            $author = $login_uname;
            if($pid){
                $this->bbspost->ufields = array(
                    "firsttitle" => $firsttitle,
                    "firstpic" => $firstpic,
                    "popularizeurl" => $popularizeurl,
                    "firstdate" => strtotime($firstdate),
                    "status" => $status,
                    "firstsort" => $firstsort,
                    "firstauthorid" => $login_uid,
                    "firstauthor" => $login_uname,
                    'firsttime' => time()
                );
                $this->bbspost->where = "pid={$pid}";
                $res = $this->bbspost->update();
            }else {
                $this->bbspost->ufields = array(
                    "firsttitle" => $firsttitle,
                    "firstpic" => $firstpic,
                    "popularizeurl" => $popularizeurl,
                    "firstdate" => strtotime($firstdate),
                    "status" => $status,
                    "firstsort" => $firstsort,
                    "first" => $first,
                    "popularize" => $popularize,
                    "firstauthorid" => $authorid,
                    "firstauthor" => $author,
                    "authorid" => $authorid,
                    "author" => $author,
                    "invisible" => 1,
                    'firsttime' => time()
                );
                $res = $this->bbspost->insert();
            }
            $message = $res ? '成功' : '失败';
            $this->alert("推广帖{$switch}{$message}！", 'js', 3, $_ENV['PHP_SELF'] . "RecommendList");
        }
        $this->vars('main_site', $local_host);
        $this->template();
    }

    //上传推荐帖子所需头图
    function doajaxBbsFirstPic() {
        $pic = array();
        if ($_FILES['pic']) {
            $pic = $_FILES['pic'];
        }
        if ($pic['size']) {
            $pic_name = $pic['tmp_name'];
            $pic_path = $this->uploadPic($pic_name, 'bbs', 'recommend');

            if ($pic_path) {
                echo json_encode($pic_path);
            } else {
                echo 1;
            }
        }
    }


    //通过帖子id返回帖子相关数据
    function doajaxPostIdToTitle(){
        $pid = $this->postValue('pid')->Int();
        if($pid){
            $post_data = $this->bbspost->getPostIdTOData($pid);
            if($post_data['first']==1){
                echo 1;
            }elseif($post_data['subject'] && $post_data['first']==0){
                echo $post_data['subject'];
            }elseif(!$post_data){
                echo 2;
            }
        }
    }

    //论坛版块列表  &&  关闭/开启某个论坛版块 && 删除某个论坛版块
    function doForumsList(){
        $this->page_title = "论坛版块列表";
        $this->tpl_file = "bbsforumslist";
        $fid_type = $this->getValue('fid_type')->Int(1);
        $forum_list = $this->bbsforum->getForumTypeData('*',"",array('displayorder'=>'ASC'),$flag=2);
        $fid = $this->getValue('fid')->Int();
        $event = $this->getValue('event')->String();
        $switch = $res = $del_data =  '';
        if($fid && $event=='switch'){
            $forum_status = $this->bbsforum->getForumTypeData('status',"fid={$fid}",'',3);
            if($forum_status==0){
                $this->bbsforum->ufields = array('status'=>1);
                $switch = '开启';
            }elseif($forum_status==1){
                $this->bbsforum->ufields = array('status'=>0);
                $switch = '关闭';
            }
            $this->bbsforum->where = "fid={$fid}";
            $res = $this->bbsforum->update();
        }elseif($fid && $event=='del'){
            $theme_num = $this->bbsthread->getThreadTypeData("count(tid)","fid={$fid}",3);
            if(!$theme_num){
                $this->bbsforum->where = "fid={$fid}";
                $res = $this->bbsforum->del();
                $switch = '删除';
            }else{
                $del_data = '删除失败，此版块下存在主题！';
            }
            if($del_data) {
                $this->alert("论坛版块{$del_data}", 'js', 3, $_ENV['PHP_SELF'] . "ForumsList");
            }else{
                $message = $res ? '成功' : '失败';
                $this->alert("论坛版块{$switch}{$message}！", 'js', 3, $_ENV['PHP_SELF']. "ForumsList");
            }

        }

        $this->vars('list', $forum_list);
        $this->vars('fid_type',$fid_type);
        $this->template();
    }

    //添加/编辑 论坛版块
    function doEditForum(){
        global $local_host, $login_uid, $login_uname;
        $fid = $this->getValue('fid')->Int();
        $event = $this->getValue('event')->String();
        $switch = $res = '';
        if(!$fid){
            $switch = "添加";
        }else {
            $switch = "编辑";
            $forum_list = $this->bbsforum->getForumTypeData('*', "fid={$fid}", '', $flag = 1);
            $theme_list = $this->bbsthread->getThreadTypeData('tid,name',"fid={$fid} order by displayorder ASC",2);
            $this->vars('list', $forum_list);
            $this->vars('theme_list', $theme_list);
            $this->vars('fid', $fid);
        }
        $this->page_title = "{$switch}论坛版块";
        $this->tpl_file = "bbseditforum";

        if($_POST) {
            $name = $this->postValue('name')->String();
            $type = $this->postValue('type')->String();
            $allowanonymous = $this->postValue('allowanonymous')->Int();
            $allowappend = $this->postValue('allowappend')->Int();
            $alloweditrules = $this->postValue('alloweditrules')->Int();
            $recyclebin = $this->postValue('recyclebin')->Int();
            $modnewposts = $this->postValue('modnewposts')->Int();
            $disablewatermark = $this->postValue('disablewatermark')->Int();
            $autoclose = $this->postValue('autoclose')->Int();
            $alloweditpost = $this->postValue('alloweditpost')->Int();
            $simple = $this->postValue('simple')->Int();
            $allowglobalstick = $this->postValue('allowglobalstick')->Int();
            $disablethumb = $this->postValue('disablethumb')->Int();
            $displayorder = $this->postValue('displayorder')->Int();
            if(!$displayorder || $displayorder>10){
                $displayorder = 10;
            }
            $status = $this->postValue('status')->Int();
            $operator = $login_uname;
            $operatorid = $login_uid;

            if (!$fid) {
                $this->bbsforum->ufields = array(
                    "name" => $name,
                    "type" => $type,
                    "allowanonymous" => $allowanonymous,
                    "allowappend" => $allowappend,
                    "alloweditrules" => $alloweditrules,
                    "recyclebin" => $recyclebin,
                    "modnewposts" => $modnewposts,
                    "disablewatermark" => $disablewatermark,
                    "autoclose" => $autoclose,
                    "alloweditpost" => $alloweditpost,
                    "simple" => $simple,
                    "allowglobalstick" => $allowglobalstick,
                    "disablethumb" => $disablethumb,
                    "displayorder" => $displayorder,
                    "status" => $status,
                    "operator" => $operator,
                    "operatorid" => $operatorid,
                    'createtime' => time(),
                    'datetime' => time()
                );
                $res = $this->bbsforum->insert();
            } elseif ($fid && $event == 'edit') {
                $this->bbsforum->ufields = array(
                    "name" => $name,
                    "type" => $type,
                    "allowanonymous" => $allowanonymous,
                    "allowappend" => $allowappend,
                    "alloweditrules" => $alloweditrules,
                    "recyclebin" => $recyclebin,
                    "modnewposts" => $modnewposts,
                    "disablewatermark" => $disablewatermark,
                    "autoclose" => $autoclose,
                    "alloweditpost" => $alloweditpost,
                    "simple" => $simple,
                    "allowglobalstick" => $allowglobalstick,
                    "disablethumb" => $disablethumb,
                    "displayorder" => $displayorder,
                    "status" => $status,
                    "operator" => $operator,
                    "operatorid" => $operatorid,
                    'datetime' => time()
                );
                $this->bbsforum->where = "fid={$fid}";
                $res = $this->bbsforum->update();
            }
            $message = $res ? '成功' : '失败';
            $this->alert("论坛版块{$switch}{$message}！", 'js', 3, $_ENV['PHP_SELF'] . 'ForumsList');
        }

        $this->template();
    }

    //添加/编辑/删除 论坛主题
    function doAddTheme(){
        global $local_host, $login_uid, $login_uname;
        $tid = $this->getValue('tid')->Int();
        $event = $this->getValue('event')->String();
        $switch = $res = '';
        if(!$tid){
            $switch = "添加";
        }else{
            $switch = "编辑";
            $theme_list = $this->bbsthread->getThreadTypeData('*',"tid={$tid}",1);
            $this->vars('tid',$tid);
            $this->vars('fid', $theme_list['fid']);
            $this->vars('list', $theme_list);
        }
        $this->page_title = "{$switch}论坛主题";
        $this->tpl_file = "bbsaddtheme";

        $forum_list = $this->bbsforum->getForumTypeData('fid,name',"type='forum' and status=1",array('displayorder'=>'ASC'),$flag=2);
        if($_POST){
            $name = $this->postValue('name')->String();
            $fid = $this->postValue('fid')->Int();
            $readperm = $this->postValue('readperm')->Int();
            $highlight = $this->postValue('highlight')->Int();
            $digest = $this->postValue('digest')->Int();
            $rate = $this->postValue('rate')->Int();
            $special = $this->postValue('special')->Int();
            $stickreply = $this->postValue('stickreply')->Int();
            $displayorder = $this->postValue('displayorder')->Int();
            if(!$displayorder || $displayorder>10){
                $displayorder = 10;
            }
            $status = $this->postValue('status')->Int();
            $operator = $login_uname;
            $operatorid = $login_uid;

            if(!$tid) {
                $this->bbsthread->ufields = array(
                    "name" => $name,
                    "fid" => $fid,
                    "readperm" => $readperm,
                    "highlight" => $highlight,
                    "digest" => $digest,
                    "rate" => $rate,
                    "special" => $special,
                    "stickreply" => $stickreply,
                    "displayorder" => $displayorder,
                    "status" => $status,
                    "operator" => $operator,
                    "operatorid" => $operatorid,
                    'createtime' => time(),
                    'datetime' => time()
                );
                $res = $this->bbsthread->insert();
                if($res){
                    $theme_num = $this->bbsforum->addThemeToNum($fid);
                }
            }elseif($tid && $event=='edit'){
                $this->bbsthread->ufields = array(
                    "name" => $name,
                    "fid" => $fid,
                    "readperm" => $readperm,
                    "highlight" => $highlight,
                    "digest" => $digest,
                    "rate" => $rate,
                    "special" => $special,
                    "stickreply" => $stickreply,
                    "displayorder" => $displayorder,
                    "status" => $status,
                    "operator" => $operator,
                    "operatorid" => $operatorid,
                    'datetime' => time()
                );
                $this->bbsthread->where = "tid={$tid}";
                $res = $this->bbsthread->update();
            }
            $message = $res ? '成功' : '失败';
            $this->alert("论坛主题{$switch}{$message}！", 'js', 3, $_ENV['PHP_SELF'] . 'AddTheme');

        } else {
            $fid = $this->getValue('fid')->Int();
            if ($tid && $fid && $event == 'del') {
                $posts_num = $this->bbspost->getData("count(pid)","tid={$tid}",3);
                if(!$posts_num) {
                    $this->bbsthread->where = "tid={$tid}";
                    $res_del = $this->bbsthread->del();
                    if ($res_del) {
                        $theme_del_true = $this->bbsforum->delThemeToNum($fid);
                        if ($theme_del_true) {
                            echo 1;
                        }
                    }
                }else{
                    echo 2;
                }
            }
        }
        $this->vars('forum_list', $forum_list);
        $this->template();
    }
    
    /**
     * 上传图片到指定的文件夹，并缩放
     * @param $file 临时图片名
     * @param $dir 指定文件夹
     * @param null $subdirectory 指定文件夹的子文件夹
     * @return string 返回拼接好的指定文件夹和图片名
     */
    function uploadPic($file, $dir, $subdirectory=Null) {
        global $watermark_opt;
        if($subdirectory){
            $uploadRootDir = ATTACH_DIR . "images/$dir/$subdirectory/";
        }else {
            $uploadRootDir = ATTACH_DIR . "images/$dir/";
        }
        file::forcemkdir($uploadRootDir);
        $uploadDir = $uploadRootDir . date("Y/m/d", time()) . '/';
        file::forcemkdir($uploadDir);
        if($subdirectory) {
            $file_name = "images/$dir/$subdirectory/" . date("Y/m/d", time()) . '/';
        }else{
            $file_name = "images/$dir/" . date("Y/m/d", time()) . '/';
        }
        $fileName = util::random(12);
        $fileName .= '.jpg';
        move_uploaded_file($file, $uploadDir . $fileName);
        if ($subdirectory == 'recommend') {
            imagemark::resize($uploadDir . $fileName, "420x290", 420, 290, '', $watermark_opt);
        } else {
            imagemark::resize($uploadDir . $fileName, "1180x400", 1180, 400, '', $watermark_opt);
        }
        return $file_name . $fileName;
    }

}

?>
