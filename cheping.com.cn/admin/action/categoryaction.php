<?php

/**
 * $Id: categoryaction.php 1174 2015-11-05 01:22:27Z xiaodawei $
 */
class categoryAction extends action {

    function __construct() {
        parent::__construct();
        $this->category = new category();
        $this->checkAuth(301);
    }

    function doDefault() {
        $this->doList();
    }

    function doList() {
        $templateName = 'category_list';
        $category = $this->category->getlist("*", "parentid=0", 2);
        foreach ($category as $key => $value) {
            $child = $this->category->getlist("id", "parentid='$value[id]'", 3);
            if ($child) {
                $category[$key]['child'] = 1;
            } else {
                $category[$key]['child'] = 0;
            }
        }
        $this->vars("list", $category);
        $this->template($templateName);
    }

    function dochildList() {
        $id = $this->getValue('id')->Int();
        $templateName = 'categorychild_list';
        $categoryparent = $this->category->getlist("*", "id='$id'", 1);
        $category = $this->category->getlist("*", "parentid='$id'", 2);
        $this->vars("list", $category);
        $this->vars("categoryparent", $categoryparent);
        $this->template($templateName);
    }

    function doadd() {
        $templateName = 'category_add';
        $categorylist = $this->category->getlist("*", "state=1 and parentid=0", 2);
        $this->vars("categorylist", $categorylist);
        $id = $this->getValue('id')->Int();
        if ($_POST) {
            $category_name = $this->postValue('category_name')->Val();
            $type = $this->postValue('type')->Val();
            $parentid = $this->postValue('parentid')->Int();
            $id = $this->postValue('id')->Int();
            $this->category->ufields = array("category_name" => $category_name, "state" => "0", "parentid" => $parentid);
            if ($id) {
                $this->category->where = "id=$id";
                $this->category->update();
            } else {
                $this->category->insert();
            }
            $this->alert('提交成功', 'js', 3, $_ENV['PHP_SELF'] . 'list');
        } elseif($id) {
            $parentid = $this->getValue('parentid')->Int();
            $category = $this->category->getlist("*", "id='{$id}'", 1);
            $this->vars("category", $category);
            $this->vars("parentid", $parentid);
        }

        $this->template($templateName);
    }

    function doedit() {
        $this->doadd();
    }

    function dodel() {
        $id = $this->getValue('id')->Int();
        $pid = $this->getValue('pid')->Int();
        $this->category->where = "id='$id'";
        $this->category->del();
        if ($pid) {
            $this->alert('删除成功', 'js', 3, $_ENV['PHP_SELF'] . 'childList&id=' . $pid);
        } else {
            $this->alert('删除成功', 'js', 3, $_ENV['PHP_SELF'] . 'list');
        }
    }

    function doshen() {
        $id = $this->getValue('id')->Int();
        $parentid = $this->getValue('parentid')->Int();
        $state = $this->getValue('state')->Int();
        if ($state == 1) {
            $this->category->ufields = array("state" => "0");
        } else {
            $this->category->ufields = array("state" => "1");
        }
        $this->category->where = "id='$id'";
        $this->category->update();
        if ($parentid) {
            $this->alert('修改成功', 'js', 3, $_ENV['PHP_SELF'] . 'childList&id=' . $parentid);
        } else {
            $this->alert('修改成功', 'js', 3, $_ENV['PHP_SELF'] . 'list');
        }
    }

    function doajaxcategerylist() {
        
    }

    function checkAuth($id, $module_type = 'sys_module', $type_value = "A") {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, $module_type, $id, 'A');
    }

}

?>
