<?php

/**
 * category action
 * $Id: paramtypeaction.php 2 2012-10-08 03:01:42Z xiaodawei $
 * @author David.Shaw
 */
class paramtypeAction extends action {

    var $param;
    var $paramtype;

    function __construct() {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, 'sys_module', 803, 'A');

        parent::__construct();
        $this->paramtype = new paramType();
        $this->checkAuth();
    }

    function doDefault() {
        $this->doList();
    }

    function doList() {
        $template_name = "paramtype_list";
        $this->page_title = "参数组列表";

        $page = $this->getValue('page')->Int();

        $extra = $pcategory = $keyword = $rkeyword = null;
        $pcategory = $this->requestValue('pcategory')->Int();
        $keyword = $this->requestValue('keyword')->UrlDecode();
        $rkeyword = $keyword = $this->addValue($keyword)->stripHtml(1);

        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $where = "1";
        if ($pcategory) {
            $where .= " and pid='{$pcategory}'";
            $extra = "&pcategory={$pcategory}";
            #$this->subcategory->where = "pid='{$pcategory}'";
            $this->tpl->assign('pcategory', $pcategory);
        }
        if ($keyword) {
            $where .= " and name like '%{$keyword}%'";
            $extra .= "&keyword={$rkeyword}";
        }

        $category_list = $this->paramtype->getAllParamType($where, array('id' => 'desc'), $page_size, $page_start);

        $pcategory_list = $this->paramtype->parent_category;

        $page_bar = $this->multi($this->paramtype->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);
        $this->tpl->assign('list', $category_list);
        $this->tpl->assign('category_list', $pcategory_list);
        $this->tpl->assign('page_bar', $page_bar);
        $this->tpl->assign('pcategory', $pcategory);
        $this->tpl->assign('keyword', $keyword);
        $this->tpl->assign('rkeyword', $rkeyword);
        $this->template($template_name);
    }

    function doAdd() {
        if ($_POST) {
            $type_order = $this->postValue('type_order')->Int(1);
            $category_name = $this->postValue('name')->String();
            $this->paramtype->ufields = array(
                'name' => $category_name,
                'pid' => $this->postValue('pcategory')->Int(),
                'type_order' => $type_order,
            );

            #修改
            $id = $this->postValue('id')->Int();
            if ($id) {
                $this->paramtype->where = "id<>'{$id}' and name='{$category_name}'";
                $this->paramtype->fields = "count(id)";
                $count = $this->paramtype->getResult(3);

                if ($count) {
                    $this->alert("参数组类别“{$category_name}”已经在在，请改名后提交！", 'js', 2);
                } else {
                    $this->paramtype->where = "id='{$id}'";
                    $ret = $this->paramtype->update();
                    $this->alert("参数组类别“{$category_name}”修改成功！", 'js', 3, $_ENV['PHP_SELF']);
                }
            }
            #添加
            else {
                $this->paramtype->where = "name='{$category_name}'";
                $this->paramtype->fields = "count(id)";
                $count = $this->paramtype->getResult(3);

                if ($count) {
                    $this->alert("参数组类别“{$category_name}”已经在在，请改名后提交！", 'js', 2);
                } else {
                    $ret = $this->paramtype->insert();
                    $this->alert("参数组类别“{$category_name}”添加成功！", 'js', 3, $_ENV['PHP_SELF']);
                }
            }
        }
        #显示修改/添加页面
        else {
            $template_name = "paramtype_add";
            $this->page_title = "添加参数组";
            $this->paramtype->where = "order_sort>0";
            $category_list = $this->paramtype->parent_category;
            $id = $this->getValue('id')->Int();
            if ($id) {
                $this->page_title = "参数组类别修改";
                $category = $this->paramtype->getParamType($id);
                $this->tpl->assign('category', $category);
                $this->tpl->assign('pid', $category['pid']);
            }

            $this->tpl->assign('category_list', $category_list);
            $this->template($template_name);
        }
    }

    function doEdit() {
        $this->doAdd();
    }

    function doDel() {
        $id = $this->getValue('id')->Int();
        $this->paramtype->where = "id='{$id}'";
        $ret = $this->paramtype->del();
        if ($ret) {
            $msg = "成功";
        } else {
            $msg = "失败";
        }
        $this->alert("参数类别删除{$msg}!", 'js', 3, $_ENV['PHP_SELF']);
    }

    function doJson() {
        $pid = $this->getValue('pid')->Int();
        if (!$pid)
            return false;

        $parmtype = array();
        $ret = $this->paramtype->getParamTypeByPid($pid);

        foreach ($ret as $key => $value) {
            $parmtype[] = array(
                'id' => $value['id'],
//                'name' => iconv('gbk', 'utf-8', $value['name']),
                'name' => $value['name'],
                'pid' => $value['pid'],
            );
        }
        echo json_encode($parmtype);
    }

    function checkAuth() {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, 'sys_module', 803, 'A');
    }

}

?>
