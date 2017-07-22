<?php

/**
 * review action
 * $Id: reviewaction.php 1250 2015-11-13 09:08:46Z xiaodawei $
 */
class reviewAction extends action {

    //var $factory;
    function __construct() {
        parent::__construct();
        $this->reviews = new reviews();
        $this->words = new words();
        $this->pagedate = new pageData();
        $this->badword = new badword();
        $this->checkAuth(701);
    }

    function doDefault() {
        $this->doList();
    }

    //评论列表
    function doList() {

        $template_name = "review_list";
        $this->page_title = "评论管理";
        $a = $this->getValue('a')->String();
        $page = $this->getValue('page')->Int();
        $page = max(1, $page);
        $page_size = 18;
        $page_start = ($page - 1) * $page_size;
        
        $order['cr.created'] = 'DESC';
        
        switch($a) {
            case 1:     
              
              $list = $this->reviews->getPriceAndModelA($where, $page_size, $page_start, $order);  
              $total = $this->reviews->total;
              $extra.="list&a=$a";
              $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);
              break;                  
            case 2:
              $where = 'cr.article_id=ca.id and cr.state=1';
              $list = $this->reviews->getPriceAndModelA($where, $page_size, $page_start, $order);
              $total = $this->reviews->total;
              $extra.="list&a=$a";
              $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);
              break;
            case 3:
              $where = 'cr.article_id=ca.id and cr.state=0';
              $list = $this->reviews->getPriceAndModelA($where, $page_size, $page_start, $order);

              $total = $this->reviews->total;
              $extra.="list&a=$a";
              $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);
              break;
            case 4:
              $where = 'cr.article_id=ca.id and cr.state=2';
              $list = $this->reviews->getPriceAndModelA($where, $page_size, $page_start, $order);

              $total = $this->reviews->total;
              $extra.="list&a=$a";
              $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);
              break;
            default:
              echo "系统错误";
        }
        
        $str = $this->pagedate->getSomePagedata("value", "name='review'", 3);
        $shenhe = unserialize($str);

        $this->vars('list', $list);
        $this->vars('a', $a);
        $this->vars('shenhe', $shenhe);
        $this->vars('page_bar', $page_bar);

        $this->template($template_name);
        
    }
    
    function doShenhe(){
        $state = $this->getValue('state')->Int();
        $data['name'] = 'review';
        $data['value'] = serialize($state);
        $pdid = $this->pagedate->getSomePagedata("id", "name='$data[name]'", 3);
        if ($pdid) {
            $date['created'] = $this->timestamp;
            $data['notice'] = "评论审核全局开关";
            $this->pagedate->ufields = $data;
            $this->pagedate->where = "id=$pdid";
            $ret = $this->pagedate->update();
            if ($ret) {
                $msg .= "成功";
            } else {
                $msg .= "失败";
            }
            $message = array(
                'type' => 'js',
                'act' => 3,
                'message' => $msg,
                'url' => $_ENV['PHP_SELF'] . "List&a=1"
            );
            $this->alert($message);
        }else{
            $date['created'] = $this->timestamp;
            $data['notice'] = "评论审核全局开关";
            $this->pagedate->ufields = $data;
            $ret = $this->pagedate->insert();
            if ($ret) {
                $msg .= "成功";
            } else {
                $msg .= "失败";
            }
            $message = array(
                'type' => 'js',
                'act' => 3,
                'message' => $msg,
                'url' => $_ENV['PHP_SELF'] . "List&a=1"
            );
            $this->alert($message);
        }
        
    }
    
    function doShenhes(){
        $this->tpl_file = "review_shenhe";
        $this->page_title = "评论审核";
        if($_POST){
            $id=$this->postValue('id')->Int();
            $state=$this->postValue('state')->Int();
            $this->reviews->ufields = array(
                'id' => $id,
                'state' => $state
            );
            $this->reviews->where = "id=$id";
            $ret = $this->reviews->update();
            if ($ret) {
                $msg .= "审核成功";
            } else {
                $msg .= "审核失败";
            }
            $message = array(
                'type' => 'js',
                'act' => 3,
                'message' => $msg,
                'url' => $_ENV['PHP_SELF'] . "List&a=1"
            );
            $this->alert($message);
        }else{
            $id = $this->getValue('id')->Int();
            $parent = $this->reviews->getTag($id);
            $this->vars('parent', $parent);
            $this->template();
        }
        
    }
    
    function doShenhess(){
        $tg = $this->postValue('tg')->Val();
        $id = implode(",", $this->postValue('id')->Val());
        
        switch ($tg){
        case 1:
            $this->reviews->ufields = array(
                'state' => $tg
            );
            $this->reviews->where = "id in(" . $id . ")";
            $ret = $this->reviews->update();
            
          break;
        case 0:
          $this->reviews->ufields = array(
                'state' => $tg
            );
            $this->reviews->where = "id in(" . $id . ")";
            $ret = $this->reviews->update();
          break;
        case 3:
            $this->reviews->where = "id in(" . $id . ")";
            $this->reviews->limit = 0;
            $ret = $this->reviews->del();
            $msg = "批量删除";
          break;
        default:
          $msg = "系统错误";
        }
        if ($ret) {
            $msg .= "成功";
        } else {
            $msg .= "失败";
        }
        $message = array(
            'type' => 'js',
            'act' => 3,
            'message' => $msg,
            'url' => $_ENV['PHP_SELF']. "List&a=1"
        );
        $this->alert($message);

    }

    //敏感词列表
    function doWordsList() {

        $this->tpl_file = "words_list";
        $this->page_title = "敏感词库";

        $fields = '*';
        $array = $this->words->getBadwords($where, $fields);

        $this->vars('array', $array);

        $this->template();
    }

    //修改
    function doWordsEdit() {
        $this->doWordsAdd();
    }

    //敏感词添加
    function doWordsAdd() {

        $this->tpl_file = "words_add";
        $this->page_title = "敏感词新增";

        if ($_POST) {
            $minganci = $this->postValue('minganci')->Val();

            $fields = '*';
            $array = $this->words->getBadwords($where, $fields);

            //dump($array['badwords']);
            if(!empty($array)){
                $this->words->ufields = array(
                    'badwords' => $array['badwords'] . "|" . $minganci,
                );
    //            
                $this->words->where = "id='{$array['id']}'";
                $ret = $this->words->update();
            }else{
                $this->words->ufields = array(
                    'badwords' => $array['badwords'] . "|" . $minganci,
                );
                $ret = $this->words->insert();
            }
            
            $msg = "敏感词新增";

            if ($ret) {
                $msg .= "成功";
            } else {
                $msg .= "失败";
            }
            $message = array(
                'type' => 'js',
                'act' => 3,
                'message' => $msg,
                'url' => $_ENV['PHP_SELF'] . "wordslist"
            );
            $this->alert($message);
        }

        $this->template();
    }

    //验证标签名是否正确
    function doRtitle() {
        $minganci = $this->postValue('minganci')->Val();
        $minganci || exit('0');
        $fields = '*';
        $array = $this->words->getBadwords($where, $fields);

        if (strpos($array['badwords'], $minganci)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function doWordsTxt() {
        $this->tpl_file = "words_txt";
        $this->page_title = "导出/导入敏感词库";
        $this->template();
    }

    //导出敏感词库
    function doWordsExce() {
        $fields = '*';
        $array = $this->words->getBadwords($where, $fields);

        //$str = 'ID,敏感词库' . "\r\n";
        if ($array['badwords']) {
            $list = array_filter(explode("|", $array['badwords']));
            //var_dump($list);
            foreach ($list as $key => $val) {
                //var_dump($val);
                $str .= $val . "\r\n";
            }
        }
        $this->exportExcel('wordsexce', '敏感词库', $str);
    }

    /**
     * @param string $en_name 保存的英文名
     * @param string $cn_name 输出的中文名
     */
    function exportExcel($en_name, $cn_name, $str) {
        if (!is_dir(ATTACH_DIR . 'tmp'))
            file::forcemkdir(ATTACH_DIR . 'tmp');
        $filePath = ATTACH_DIR . "tmp/{$en_name}.txt";

        if (file_exists($filePath))
            unlink($filePath);
        file_put_contents($filePath, $str);
        $file = fopen($filePath, "r");
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length: " . filesize($filePath));
        Header("Content-Disposition: attachment; filename={$cn_name}.txt");
        echo fread($file, filesize($filePath));
        fclose($file);
    }

    function doTxt() {
        $this->checkName($_FILES['txt']['name']);
        $txt = file_get_contents($_FILES['txt']['tmp_name']);
        $content = $txt;
        
        if (empty($content)) {
            echo '请选择要导入的TXT文件！';
            exit;
        }
//        var_dump($content);
        $txt1 = preg_replace('|[0-9]+|', '', $content);
        
        $csv = array_filter(explode("\n", $txt1));
        

        foreach ($csv as $key => $val) {
            $fields = '*';
            $array = $this->words->getBadwords($where, $fields);
            if(!empty($array)){
                $pos = strpos($array['badwords'],$val);
                if ($pos == false) {
                    $this->words->ufields = array(
                        'badwords' => $array['badwords']. "|" . $val ,
                    );
                    $this->words->where = "id='{$array['id']}'";
                    $ret = $this->words->update();
                }else{
                    continue;
                }
            }else{
                $this->words->ufields = array(
                    'badwords' => $array['badwords'] . "|" . $val,
                );
                //$this->words->where = "id='{$array['id']}'";
                $ret = $this->words->insert();
            }
        }
//        
        $msg = "敏感词导入";

            if ($ret) {
                $msg .= "成功";
            } else {
                $msg .= "失败";
            }
            $message = array(
                'type' => 'js',
                'act' => 3,
                'message' => $msg,
                'url' => $_ENV['PHP_SELF'] . "wordslist"
            );
            $this->alert($message);

        
//        $filename = UPLOAD_DIR . "minganci/minganci.txt";
//
//        if (file_exists($filename)) {//如果文件存在，读取其中的内容 
//            $file = file($filename);
//            $array = array_filter(explode("|", $file[0]));
//            if ($array) {
//                unset($array[0]);
//            }
//        }
//        $arr = array_diff($csv, $array);
////        var_dump($a);
//        if (is_writable($filename)) {
//            $file = fopen($filename, "r+");
//            fseek($file, 0, SEEK_END);
//            foreach ($arr as $key => $val) {
//                //            var_dump($val);
//                fprintf($file, $val);
//                fprintf($file, "|");
//            }
//            fclose($file);
//            $msg = "导入成功";
//            $message = array(
//                'type' => 'js',
//                'act' => 3,
//                'message' => $msg,
//                'url' => $_ENV['PHP_SELF']
//            );
//            $this->alert($message);
//        } else {
//            $msg = "文件不可写,请检查权限";
//            $message = array(
//                'type' => 'js',
//                'act' => 3,
//                'message' => $msg,
//                'url' => $_ENV['PHP_SELF']
//            );
//            $this->alert($message);
//        }
    }

    function checkName($name) {
        if (strrchr($name, '.') !== '.txt') {
            echo '<script type="text/javascript">alert("请上传txt文件");window.location.href="index.php?action=review-wordslist"</script>';
            exit;
        }
    }

    //删除
    function doDel() {

        $id = $this->getValue('id')->Int();
        $this->reviews->where = "id='{$id}'";
        $ret = $this->reviews->del();
        $msg = "删除";

        if ($ret) {
            $msg .= "成功！";
        } else {
            $msg .= "失败！";
        }
        $message = array(
            'type' => 'js',
            'act' => 3,
            'message' => $msg,
            'url' => $_ENV['PHP_SELF']."List&a=1"
        );
        $this->alert($message);
    }

    //回复
    function doParent() {
        global $login_uid, $login_uname;
        $this->tpl_file = "review_parent";
        $this->page_title = "评论回复";

        if ($_POST) {
            $content = $this->postValue('content')->Val();
            $parentid = $this->postValue('id')->Int();
            $parent = $this->reviews->getTag($parentid);

            $badwords = $this->badword->getlist("badwords", "id=1", 3);
            $array = array_filter(explode("|", $badwords));
            $badword1 = array_combine($array, array_fill(0, count($array), '*'));
            $str = strtr($content, $badword1);

            $this->reviews->ufields = array(
                'content' => $str,
                'type_id' => $parent['type_id'],
                'type_name' => $parent['type_name'],
                'article_id' => $parent['article_id'],
                'parentid' => $parentid,
                'uid' => $login_uid,
                'uname' => $login_uname,
                'created' => $this->timestamp,
                'ip' => util::getip(),
            );
            //var_dump($ufields);

            $msg = "回复";
            $ret = $this->reviews->insert();

            if ($ret) {
                $msg .= "成功";
            } else {
                $msg .= "失败";
            }
            $message = array(
                'type' => 'js',
                'act' => 3,
                'message' => $msg,
                'url' => $_ENV['PHP_SELF']
            );
            $this->alert($message);
        } else {
            $id = $this->getValue('id')->Int();
            if ($id) {
                $parent = $this->reviews->getTag($id);
                $this->vars('parent', $parent);
                $this->template();
            }
        }
    }

    function checkAuth($id, $module_type = 'sys_module', $type_value = "A") {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, $module_type, $id, 'A');
    }

}
