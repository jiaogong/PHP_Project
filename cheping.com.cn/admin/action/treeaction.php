<?php

/**
 * tree action
 * $Id: treeaction.php 1170 2015-11-04 14:58:47Z xiaodawei $
 */
class treeAction extends action {

    var $tree;

    function __construct() {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, 'sys_module', 801, 'R');

        parent::__construct();
        $this->tree = new Tree();
    }

    function doDefault() {
        $this->doTreeIndex();
    }

    function doTreeIndex() {
        $this->checkAuth();
        
        $template_name = "tree_index";
        $this->page_title = "产品信息";

        $this->vars('page_title', $this->page_title);
        $this->tpl->display($template_name);
    }

    function doTreeLeft() {
        $this->checkAuth();
        $template_name = "tree_left";
        $this->page_title = "列表";

        $this->vars('page_title', $this->page_title);
        $this->tpl->display($template_name);
    }

    function doTreeLeftData() {
        $type = $this->getValue('type')->En();
        $id = $this->getValue('id')->Int();
        $pid = $this->getValue('pid')->Int();

        if ($type) {
            $this->data = $this->tree->{"get" . $type . "List"}($id);
        }

        $cardb_tree = array(
            'brand',
            'factory',
            'series',
            'model'
        );
        $sub_type = '';
        $sub_type_key = array_search($type, $cardb_tree) + 1;
        if ($sub_type_key < count($cardb_tree)) {
            $sub_type = $cardb_tree[$sub_type_key];
        }

        $result = array();
        foreach ($this->data as $k => $v) {
            $count = $sub_type ? $this->tree->getModelCount($type, $v['id']) : 0;

            $result[] = array(
                "attr" => array(
                    "id" => "node_" . $v['id'],
                    "rel" => $v['cardb_category'],
                    "nc" => $v['cardb_category'],
                    "href" => $sub_type ? "?action={$v['cardb_category']}-list&fatherId={$v['id']}" : '',
                    "elink" => "?action={$type}-edit&{$type}_id={$v['id']}&fatherId={$v['parent_id']}",
                    "target" => "list"
                ),
                "data" => $count ? $v['cardb_title'] . "({$count})" : $v['cardb_title'],
                "state" => $type == "model" ? "" : "closed"
            );
        }

        echo json_encode($result);
    }

    function doTreeTop() {
        $this->checkAuth();
        $template_name = "tree_top";
        $this->page_title = "top";

        $this->vars('page_title', $this->page_title);
        $this->tpl->display($template_name);
    }

    function doBlank() {
        $template_name = "blank";
        $this->page_title = "blank";

        $this->vars('page_title', $this->page_title);
        $this->tpl->display($template_name);
    }

    //简化品牌名字
    function get_manu_name($manu_name) {
        if (strstr($manu_name, "（")) {
            $b_pos = strpos($manu_name, "（");
            if (ord(substr($manu_name, ($b_pos - 1), 1)) > 0xa0) {//is chinese
                $manu_name = substr($manu_name, 0, $b_pos);
            } else {//is english
                $manu_name = substr($manu_name, ($b_pos + 2));
                $manu_name = ereg_replace(')|）', '', $manu_name);
            }
        }
        return $manu_name;
    }

    function checkAuth() {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, 'sys_module', 801, 'A');
    }

}

?>
