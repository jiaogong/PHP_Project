<?php

/**
 * tag action
 * $Id: tagaction.php 1250 2015-11-13 09:08:46Z xiaodawei $
 */
class tagAction extends action {

    //var $factory;
    function __construct() {
        parent::__construct();
        $this->tags = new tags();
        $this->checkAuth(602);
    }

    function doDefault() {
        $this->doList();
    }

    //新增标签
    function doAdd() {
        global $login_uid, $login_uname;
        $this->tpl_file = "tag_add";
        $this->page_title = "新增标签";

        if ($_POST) {
            $tag_name = $this->postValue('tag_name')->String();
            if (preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9]+$/u", $tag_name)) {
                $pinyin = util::Pinyin($tag_name, 2, 'utf-8');
                $letter = util::Pinyin($pinyin, 1, 'utf-8');
                $state = 0;

                $this->tags->ufields = array(
                    'tag_name' => $tag_name,
                    'pinyin' => $pinyin,
                    'letter' => $letter,
                    'username' => $login_uname,
                    'state' => $state,
                );
                $id = $this->postValue('id')->Int();
                if (empty($id)) {
                    $this->tags->ufields['created'] = $this->timestamp;
                    $msg = "标签添加";
                    $ret = $this->tags->insert();
                } else {
                    $this->tags->ufields['created'] = $this->timestamp;
                    $this->tags->ufields['pinyin'] = $this->postValue('pinyin')->Val();
                    $this->tags->where = "id='{$id}'";
                    $ret = $this->tags->update();
                    $msg = "标签修改";
                }

                if ($ret) {
                    $msg .= "成功";
                } else {
                    $msg .= "失败";
                }

                #var_dump($_POST);
            } else {
                $msg = "标签名称不允许有特殊符号";
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
                $tag = $this->tags->getTag($id);
                $this->vars('tag', $tag);
            }
            $this->template();
        }
        //$this->template();
    }

    //验证标签名是否正确
    function doRtitle() {
        $tag_name = $this->postValue('tag_name')->String();
        $tag_name || exit('0');
        
        $tag = $this->tags->getTagname($tag_name);
        if (!empty($tag)) {
            exit('1');
        } else {
            exit('0');
        }
    }

    //标签列表
    function doList() {
        $this->page_title = "标签列表";
        $this->tpl_file = "tag_list";
        $page = $this->getValue('page')->Int();
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        if ($_REQUEST['state'] == 0) {
            $where = "state like '%" . $_REQUEST['state'] . "%'";
            $extra .= "&state=" . $_REQUEST['state'];
        } else if ($_REQUEST['state'] == 1) {
            $where = "state like '%" . $_REQUEST['state'] . "%'";
            $extra .= "&state=" . $_REQUEST['state'];
        }
        if (!empty($_REQUEST['tag_name'])) {
            $where = "tag_name like '%" . $_REQUEST['tag_name'] . "%'";
            $extra .= "&tag_name=" . $_REQUEST['tag_name'];
        }
        if (!empty($_REQUEST['letter'])) {
            $where = "letter like '%" . $_REQUEST['letter'] . "%'";
            $extra .= "&letter=" . $_REQUEST['letter'];
        }

        if ($_REQUEST['state'] == 0 and ! empty($_REQUEST['tag_name'])) {
            $where = "state like '%" . $_REQUEST['state'] . "%' and tag_name like '%" . $_REQUEST['tag_name'] . "%'";
            $extra .= "&state=" . $_REQUEST['state'] . "&tag_name=" . $_REQUEST['tag_name'];
        } else if ($_REQUEST['state'] == 1 and ! empty($_REQUEST['tag_name'])) {
            $where = "state like '%" . $_REQUEST['state'] . "%' and tag_name like '%" . $_REQUEST['tag_name'] . "%'";
            $extra .= "&state=" . $_REQUEST['state'] . "&tag_name=" . $_REQUEST['tag_name'];
        } else if ($_REQUEST['state'] == 0 and ! empty($_REQUEST['letter'])) {
            $where = "state like '%" . $_REQUEST['state'] . "%' and letter like '%" . $_REQUEST['letter'] . "%'";
            $extra .= "&state=" . $_REQUEST['state'] . "&letter=" . $_REQUEST['letter'];
        } else if ($_REQUEST['state'] == 1 and ! empty($_REQUEST['letter'])) {
            $where = "state like '%" . $_REQUEST['state'] . "%' and letter like '%" . $_REQUEST['letter'] . "%'";
            $extra .= "&state=" . $_REQUEST['state'] . "&letter=" . $_REQUEST['letter'];
        }

        # 
        $fields = '*';
        $order['letter'] = 'asc';
        $order['created'] = 'asc';
        $list = $this->tags->getTagList($where, $fields, $page_size, $page_start, $order);
        $total = $this->tags->total;

        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);

        $this->vars('list', $list);
        $this->vars('page_bar', $page_bar);
        $this->template();
    }

    //导出导入
    function doTagtag() {
        $this->page_title = "导出/导入标签";
        $this->tpl_file = "tag_tag";
        $this->template();
    }

    //修改
    function doEdit() {
        $this->doAdd();
    }

    //导出全部标签
    function doTagExce() {
        $fields = '*';
        $where = 1;
        $flag = 2;
        $order['letter'] = 'asc';
        $order['created'] = 'asc';
        $list = $this->tags->getTagFields($fields, $where, $flag, $order);

        $str = '标签ID,标签名称,标签全拼,标签名首字母,创建人,时间,状态' . "\n";
        if ($list) {
            foreach ($list as $key => $val) {
                switch ($val['state']) {
                    case 1:
                        $val['state'] = '通过';
                        break;
                    case 0:
                        $val['state'] = '不通过';
                        break;
                    default:
                        $val['state'] = '错误' . $val['state'] . '状态';
                        break;
                }
                $str .= $val['id'] . ',' . $val['tag_name'] . ',' . $val['pinyin'] . ',' . $val['letter'] . ',' . $val['username'] . ',' . date('Y-m-d', $val['created']) . ',' . $val['state'] . "\r\n";
            }
        }
        $this->exportExcel('tagexce', '全部标签库', $str);
    }

    /**
     * @param string $en_name 保存的英文名
     * @param string $cn_name 输出的中文名
     */
    function exportExcel($en_name, $cn_name, $str) {
        if (!is_dir(ATTACH_DIR . 'tmp'))
            file::forcemkdir(ATTACH_DIR . 'tmp');
        $filePath = ATTACH_DIR . "tmp/{$en_name}.csv";

        if (file_exists($filePath))
            unlink($filePath);
        file_put_contents($filePath, $str);
        $file = fopen($filePath, "r");
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length: " . filesize($filePath));
        Header("Content-Disposition: attachment; filename={$cn_name}.csv");
        echo fread($file, filesize($filePath));
        fclose($file);
    }

    /* 导入标签 */

    function doTagExport() {
        $this->checkName($_FILES['csv']['name']);
        $csv1 = file_get_contents($_FILES['csv']['tmp_name']);
        if (empty($csv1)) {
            echo '请选择要导入的CSV文件！';
            exit;
        }
        $csv1 = explode("\n",iconv("gb2312", "utf-8//IGNORE", $csv1));
        
        foreach ($csv1 as $key => $val) {
            if ($key == 0) {
                continue;
            }
//            $val = array_filter(explode(',', $val));
            if (empty($val)) {
                break;
            } else {
                $tag_name = trim($val);
                if (!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9]+$/u", $tag_name)) {
                    continue;
                }
                $tag = $this->tags->getTags($tag_name);
                if ($tag['tag_name'] == $tag_name) {
                    continue;
                }
                $pinyin = util::Pinyin($tag_name, 2, 'utf-8');
                $letter = util::Pinyin($pinyin, 1, 'utf-8');
                $username = $login_uname;
                $this->tags->ufields = array(
                    'tag_name' => $tag_name,
                    'pinyin' => $pinyin,
                    'letter' => $letter,
                    'type_id'=>1,
                    'username' => $username,
                    'state' => 0,
                );
                $this->tags->ufields['created'] = $this->timestamp;
                if ($tag_name !== '') {
                    $ret = $this->tags->insert();
                }
            }
        }
        $msg = "标签导入";
        if ($ret) {
            $msg .= "成功";
            $message = array(
                'type' => 'js',
                'act' => 3,
                'message' => $msg,
                'url' => $_ENV['PHP_SELF']
            );
            $this->alert($message);
        } else {
            $msg .= "失败";
            $message = array(
                'type' => 'js',
                'act' => 3,
                'message' => $msg,
                'url' => $_ENV['PHP_SELF']
            );
            $this->alert($message);
        }
    }

    function checkName($name) {
        if (strrchr($name, '.') !== '.csv') {
            echo '<script type="text/javascript">alert("请上传csv文件");window.location.href="index.php?action=tag"</script>';
            exit;
        }
    }

    function doDs() {
        $btn1 = $this->postValue('submit1')->Val();
        $btn2 = $this->postValue('submit2')->Val();
        if (!empty($btn1)) {
            $this->doDel();
        } else if (!empty($btn2)) {
            $this->doShen();
        }
    }

    //审核
    function doShen() {
        $id = @implode(",", $this->postValue('id')->Int());
        if (!empty($id)) {
            $id = explode(',', $id);
            foreach ($id as $key => $val) {
                $tag = $this->tags->getTag($val);
//                var_dump($tag);
                if ($tag['state'] == 1) {
                    $this->tags->ufields['state'] = 0;
//                    var_dump($this->tags->ufields['state']);
                } else {
                    $this->tags->ufields['state'] = 1;
                }
                $this->tags->where = "id='{$val}'";
                $ret = $this->tags->update();
            }
            $msg = "批量审核";
        } else {
            $id = $this->getValue('id')->Int();
            $tag = $this->tags->getTag($id);
            if ($tag['state'] == 1) {
                $this->tags->ufields['state'] = 0;
//                var_dump($this->tags->ufields['state']);
            } else {
                $this->tags->ufields['state'] = 1;
            }
            $this->tags->where = "id='{$id}'";
            $ret = $this->tags->update();
            $msg = "标签审核";
        }

        if ($ret) {
            $msg .= "成功！";
        } else {
            $msg .= "失败！";
        }
        $message = array(
            'type' => 'js',
            'act' => 3,
            'message' => $msg,
            'url' => $_ENV['PHP_SELF']
        );
        $this->alert($message);
    }

    function checkAuth($id, $module_type = 'sys_module', $type_value = "A") {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, $module_type, $id, 'A');
    }
}

?>
