<?php

/**
 * article type action
 * $Id: articletypeaction.php 1174 2015-11-05 01:22:27Z xiaodawei $
 */
class articletypeaction extends action {

    var $articletype;

    function __construct() {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, 'sys_module', 401, 'A');

        parent::__construct();
        $this->articletype = new articletype();
    }

    function doDefault() {
        $this->doList();
    }

    function doList() {
        $this->tpl_file = "articletype_list";
        $all = $this->articletype->getParticelType();

        $this->vars('articletype', $all);
        $this->template();
    }

    function doAdd() {
        $this->tpl_file = "articletype_add";
        $this->page_title = "添加文章分类";
        if ($_POST) {
            $name = $this->postValue('name')->String();
            $level = $this->postValue('level')->EnNum();

            if ($level > 1) {
                $pid = $this->postValue('pid')->Int();
            } else {
                $pid = 0;
            }
            $this->articletype->ufields = array(
                'name' => $name,
                'pid' => $pid,
            );
            $id = $this->postValue('id')->Int();
            if ($id) {
                $msg = "修改";
                $this->articletype->where = "id='{$id}'";
                $ret = $this->articletype->update();
            } else {
                $msg = "添加";
                $ret = $this->articletype->insert();
            }

            if ($ret) {
                $msg .= "成功";
            } else {
                $msg .= "失败";
            }
            $message = array(
                'type' => 'js',
                'message' => '文章分类' . $msg,
                'act' => 3,
                'url' => $_ENV['PHP_SELF'],
            );
            $this->alert($message);
        } else {
            $id = $this->getValue('id')->Int();
            if ($id) {
                $at = $this->articletype->getArticleType($id);
                $this->vars('articletype', $at);
                $this->vars('id', $id);

                $all = $this->articletype->getAllArticleType('pid=0');
                $this->vars('all', $all);
            }
            $this->template();
        }
    }

    function doEdit() {
        $this->doAdd();
    }

    function doDel() {
        $id = $this->getValue('id')->Int();
        $this->articletype->where = "id='{$id}'";
        $ret = $this->articletype->del();
        if ($ret) {
            $msg = '成功';
        } else {
            $msg = '失败';
        }
        $message = array(
            'type' => 'js',
            'message' => '文章分类删除' . $msg,
            'act' => 3,
            'url' => $_ENV['PHP_SELF'],
        );
        $this->alert($message);
    }

    function doPJson() {
        $where = "pid=0";
        $ret = $this->articletype->getAllArticleType($where);
        $tmp = array();
        foreach ($ret as $key => $value) {
            $value['name'] = iconv('gbk', 'utf-8', $value['name']);
            $tmp[] = $value;
        }
        echo json_encode($tmp);
    }

    function checkAuth() {
        
    }

}

?>
