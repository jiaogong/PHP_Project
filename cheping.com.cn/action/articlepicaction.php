<?php

/**
 * activepic action
 * $Id: articlepicaction.php 2896 2016-06-03 08:01:55Z wangqin $
 */
class articlepicAction extends action {
    var $articlepic;
    var $article;
    var $category;
    function __construct() {
        global $adminauth, $login_uid;

        parent::__construct();
        $this->article = new article();
        $this->articlepic = new articlepic();
        $this->category = new category();
    }

    function doDefault() {
        $this->doList();
    }

    function doList() {
        if ($page !== 1) {
            $title = "读图页,第" . $page . "页-" . SITE_NAME;
        } else {
            $title = "读图页-" . SITE_NAME;
        }
        $keyword = "读图页,高清图片";
        $description = "车评网为您提供汽车读图页高清图片大全！";
        $template_name = "articlepic_list";

        $page = intval($_GET['page']);
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        $list = $this->articlepic->getArticle($where, $page_size, $page_start, array("cf.created" => "DESC"));
        if($list)
        foreach ($list as $key => $value) {
            $list[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
        }
        $page_bar = multipage::multi($this->articlepic->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra, 0, 4);

        $this->vars("title", $title);
        $this->vars("keyword", $keyword);
        $this->vars("description", $description);
        $this->vars('page_bar', $page_bar);
        $this->vars('list', $list);
        $this->vars('page_title', $this->page_title);
        $this->template($template_name);
    }

    function doFinal() {
        $template_name = "articlepic_final";//页面名字
        $type_id = intval($_GET['type_id']);
        $type_name = $_GET['type_name'];
        //$where = "ca.state='{$type_name}' and ca.type_id=1 and cf.type_id=ca.pic_org_id and cf.type_id='{$type_id}' and cf.type_name='artile_pic'";
        $where = "ca.type_id=1 and cf.type_id=ca.pic_org_id and cf.type_id='{$type_id}' and cf.type_name='artile_pic'";
        $list = $this->articlepic->getCount($where, array("ppos" => "asc")); 
        $total = $this->articlepic->total;
        if($total){
            foreach ($total as $key => $val) {
                $this->vars('total', $val);
            }
        }else{
            $this->doPublic();
        }

        $title = "【" . $list[0][title] . "_高清图片】-" . SITE_NAME;
        $keyword = $list[0][title] . ",高清图片";
        $description = "车评网为您提供" . $list[0][title] . "汽车高清图片！";
        $list[0]['p_category_id'] = $this->category->getParentId($list[0]['category_id']);
        $list[0]['url'] = $this->article->getRewriteUrl(
                array(
                    'id' => $list[0]['caid'], 
                    'uptime' => $list[0]['uptime'], 
                    'p_category_id' => $list[0]['p_category_id']
                ));
        $this->vars('list', $list);
        $this->vars("title", $title);
        $this->vars("keyword", $keyword);
        $this->vars("description", $description);
        $this->template($template_name);
    }

    function doZuiZhong() {
        $id = intval($_GET['id']);
        $uptime = date("Ym/d", $_GET['uptime']);

        $path = "html/article/" . $uptime . "/" . $id . ".html";
//        var_dump($path);
        header("location:/$path");
    }

    function doPublic() {
        @header("http/1.1 404 not found");
        @header("status: 404 not found");
        //exit();
    }

}

?>
