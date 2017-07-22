<?php
/**
 * app bbspost action
 * $Id: bbspostaction.php 3017 2016-06-08 06:42:28Z wangchangjiang $
 */

class bbspostAction extends action {

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

    //用户帖子列表
    function doPostsList(){
        $this->page_title = "帖子列表";
        $this->tpl_file = "bbspostslist";
        $search_where = $page_sreach_field = "";
        $date_order = " order by dateline DESC";
        $fid_type = $this->getValue('fid_type')->Int(1);
        $event = $this->getValue('event')->String();
        $date = $this->getValue('date')->String();
        if($event=='date' && $date){
            if($date=='publish'){
                $date_order = " order by dateline DESC";
            }elseif($date=='modify'){
                $date_order = " order by `update` DESC";
            }
        }
        $forum_list = $this->bbsforum->getForumTypeData('fid,name',"status=1 and type='forum'",array('displayorder'=>'ASC'),$flag=2);
        $page = $this->getValue('page')->Int();
        $subject = $this->postValue('subject')->String();
        if($_GET['subject']){
            $subject = $this->getValue('subject')->String();
        }
        $author = $this->postValue('author')->String();
        if($_GET['author']){
            $author = $this->getValue('author')->String();
        }
        if($subject){
            $search_where = "subject LIKE '%{$subject}%' and ";
            $page_sreach_field = "&subject={$subject}";
        }
        if($author){
            $search_where = "author='{$author}' and ";
            $page_sreach_field = "&author={$author}";
        }
        $page = max(1, $page);
        $page_size = 15;
        $page_start = ($page - 1) * $page_size;
        $post_list = $this->bbspost->getData('*', "{$search_where}fid={$fid_type} and status=0 and first in(0,1) {$date_order}", 2, $page_start, $page_size);
        $total = $this->bbspost->total;
        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . "PostsList&fid_type={$fid_type}{$page_sreach_field}");
        $this->vars('forum_list', $forum_list);
        $this->vars('fid_type',$fid_type);
        $this->vars('post_list',$post_list);
        $this->vars('page_bar',$page_bar);
        $this->vars('subject',$subject);
        $this->vars('author',$author);
        $this->template();
    }

    //发布帖子
    function doPublishPost(){
        global $local_host, $login_uid, $login_uname;
        $pid = $this->getValue('pid')->Int();
        $event = $this->getValue('event')->String();
        $fid = $this->getValue('fid')->Int();
        $switch = $res = "";
        if(!$pid) {
            $switch = "发布";
        }elseif($pid && $event=='edit'){
            $switch = "编辑";
            $post_list = $this->bbspost->getData('*',"pid={$pid}",1);
            $theme_data = $this->bbsthread->getThreadTypeData('tid,name',"fid={$post_list['fid']} and status=0",2);
            $this->vars('list', $post_list);
            $this->vars('theme_data', $theme_data);
            $this->vars('pid', $pid);
        }elseif($pid && $event=='del' && $fid){
            $this->bbspost->where = "pid={$pid}";
            $del_post = $this->bbspost->del();
            if($del_post){
                $this->bbsforum->delPostToNum($fid);
                echo 1;
            }
            exit;
        }
        $this->page_title = "{$switch}帖子";
        $this->tpl_file = "bbspublishpost";
        if ($_POST) {
            $subject = $this->postValue('subject')->String();
            $fid = $this->postValue('fid')->Int();
            $tid = $this->postValue('tid')->Int();
            $message = $this->postValue('ke_text')->Val();
            //$message = stripslashes($message);//去除反斜杠
            $toppost = $this->postValue('toppost')->Int();
            $digest = $this->postValue('digest')->Int();
            $authority = $this->postValue('authority')->Int();
            $status = $this->postValue('status')->Int();
            $invisible = 1;
            $dateline = time();
            if(!$pid){
                $this->bbspost->ufields = array(
                    'subject' => $subject,
                    'fid' => $fid,
                    'tid' => $tid,
                    'message' => $message,
                    'invisible' => $invisible,
                    'author' => $login_uname,
                    'authorid' => $login_uid,
                    'dateline' => $dateline,
                    '`update`' => $dateline,
                    'toppost' => $toppost,
                    'digest' => $digest,
                    'authority' => $authority,
                    'status' => $status,
                    'first' => 0,
                );
                $res = $this->bbspost->insert();
                if($res){
                    $posts_num = $this->bbsforum->addPostToNum($fid);
                }
            }elseif($pid && $event=='edit'){
                $this->bbspost->ufields = array(
                    'subject' => $subject,
                    'fid' => $fid,
                    'tid' => $tid,
                    'message' => $message,
                    'invisible' => $invisible,
                    'lasteditor' => $login_uname,
                    'lasteditorid' => $login_uid,
                    'datetime' => $dateline,
                    'toppost' => $toppost,
                    'digest' => $digest,
                    'authority' => $authority,
                    'status' => $status,
                    'first' => 0,
                );
                $this->bbspost->where = "pid={$pid}";
                $res = $this->bbspost->update();
            }

            $prompt = $res ? "成功" : "失败";
            $this->alert("帖子{$switch}{$prompt}！", 'js', 3, $_ENV['PHP_SELF'] . 'PostsList&fid_type='.$fid);
        }

        $forum_name = $this->bbsforum->getForumTypeData('fid,name', 'status=1', array('displayorder' => 'ASC'), 2);
        $this->vars('forum_name', $forum_name);
        $this->vars('main_site',$local_host);
        $this->template();
    }


    //用户行为：举报、回帖、等列表
    function doBehaviourList(){
        $type_id = 0;
        $switch = $res = $page_msg =  $search_where = $search_field = "";
        $type = $this->getValue('type')->String("reply");
        $pid = $this->getValue('pid')->Int();
        $event = $this->getValue('event')->String();
        $page = $this->getValue('page')->Int();
        $comment = $this->postValue('comment')->Int();
        $author = $this->postValue('author')->String();
        if($_GET['comment']){
            $comment = $this->getValue('comment')->Int();
        }
        if($_GET['author']){
            $author = $this->getValue('author')->String();
        }
        if($comment){
            $search_where .= "comment={$comment} and ";
            $search_field .="&message={$comment}";
        }
        if($author){
            $search_where .= "author={$author} and ";
            $search_field .="&author={$author}";
        }
        if($type == "reply"){
            $type_id = 2;
            $switch = "回复";
        }elseif($type == "report"){
            $type_id = 3;
            $switch = "举报";
        }
        $this->page_title = "{$switch}帖列表";
        $this->tpl_file = "bbsbehaviourlist";
        if($type_id) {
            $page = max(1, $page);
            $page_size = 18;
            $page_start = ($page - 1) * $page_size;
            $list = $this->bbspost->getData("pid,author,authorid,message,dateline,comment,status", "{$search_where}first={$type_id} and popularize=0 order by dateline DESC", 2, $page_start, $page_size);
            $total = $this->bbspost->total;
            $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . "BehaviourList&type={$type}{$search_field}");
            $this->vars('list', $list);
            $this->vars('page_bar', $page_bar);
        }
        if($pid && $type=='reply' && $event=='del'){
            $this->bbspost->where = "pid={$pid} and first=2";
            $res = $this->bbspost->del();
            $prompt = $res ? "成功" : "失败";
            if($page){
                $page_msg = "&page={$page}";
            }
            $this->alert("用户回复删除{$prompt}！", 'js', 3, $_ENV['PHP_SELF'] . "BehaviourList&type=" . $type . $page_msg);
        }
        $this->vars("page", $page);
        $this->vars("switch", $switch);
        $this->vars("type", $type);
        if($comment) {
            $this->vars("comment", $comment);
        }
        $this->vars("author", $author);
        $this->template();
    }

    //查看/ 编辑 用户行为：举报、回帖、等内容
    function doReadBehaviour(){
        $type_id = 0;
        $switch = $res = "";
        $type = $this->getValue('type')->String("reply");
        $pid = $this->getValue('pid')->Int();
        $page = $this->getValue('page')->Int();
        if($type == "reply"){
            $type_id = 2;
            $switch = "回复";
        }elseif($type == "report"){
            $type_id = 3;
            $switch = "举报";
        }
        $this->page_title = "查看{$switch}内容";
        $this->tpl_file = "bbsreadbehaviour";
        if($type_id && $pid) {
            $list = $this->bbspost->getData("pid,author,authorid,message,dateline,comment,status", "first={$type_id} and pid={$pid} and popularize=0",1);
            $this->bbspost->ufields = array('status' => 1);
            $this->bbspost->where = "first={$type_id} and pid={$pid} and popularize=0";
            $this->bbspost->update();
            $this->vars('list', $list);
            $content = DeleteHtml($list['message']);
            $content_len = mb_strlen($content,'utf-8');
            $this->vars('content_len', $content_len);
        }
        $this->vars("switch", $switch);
        $this->vars("type", $type);
        $this->vars("page", $page);
        $this->template();
    }

    //ajax通用fid(论坛版块id) 返回 主题相关信息
    function doajaxFidTOTheme(){
        $theme_html = '';
        $fid = $this->postValue('fid')->Int();
        if($fid) {
            $theme_name = $this->bbsthread->getThreadTypeData('tid,name', "status=0 and fid={$fid}  order by displayorder ASC", 2);
            if($theme_name){
                foreach($theme_name as $k=>$val) {
                    $theme_html .= "<option  value = \"{$val['tid']}\" >{$val['name']}</option >";
                }
            }else{
                $theme_html = '<option  value = "" >暂无主题</option >';
            }
            echo $theme_html;
        }
    }

    //ajax 发布帖子时， 上传帖子的相关图片
    function doajaxPostPic(){
        global $local_host, $watermark_opt;
        $this->pagedata = new pageData();
        $value = $this->pagedata->getSomePagedata("value", "name='waterpic'", 3);

        $list = unserialize($value);
        $waterpic = SITE_ROOT . $list['waterpic'];
        $type = 'bbs/post';
        $ret_type = $this->getValue('ret')->String('js');
        $src_fileid = $this->getValue('sfid')->String();
        $oFile = $_FILES[$src_fileid];
        if (!$src_fileid) {
            $this->alert('文件名称未指定', $ret_type, 1);
        } else {
            if (!is_writable(ATTACH_DIR)) {
                $this->alert('目录无权限', $ret_type, 1);
            }

            $attach_dir = ATTACH_DIR . 'images/';
            $sFileName = $oFile['name'];
            $sFileType = file::extname($sFileName);
            if ($sFileType != 'jpg' && $sFileType != 'png') {
                $this->alert('图片格式不合法，请上传JPG或PNG格式图片', $ret_type, 1);
            }
            $sOriginalFileName = $sFileName;
            $sExtension = substr($sFileName, ( strrpos($sFileName, '.') + 1));
            $sExtension = strtolower($sExtension);

            $dFileName = util::random(16) . "." . $sExtension;
            $sDate = date('Y/m/d');
            $attach_dir .= $type . '/' . $sDate . '/';
            file::forcemkdir($attach_dir);

            $image_url = $local_host . 'attach/images/' . $type . '/' . $sDate . '/820x540' . $dFileName;
            $sFilePath = $attach_dir . $dFileName;
            if (move_uploaded_file($oFile['tmp_name'], $sFilePath)) {
                $ret = imagemark::resize($sFilePath, "820x540", 820, 540, '', $watermark_opt);
                if ($ret) {
                    imagemark::watermark($ret['tempurl'], array('type' => 'file', 'file' => $waterpic), 2, '', $watermark_opt);
                }
                $this->alert('图片上传成功！', $ret_type, 0, $image_url);
            } else {
                $this->alert('图片上传失败！', $ret_type, 4);
            }
        }
    }
}