<?php //
header("Content-type:text/html;charset=utf-8");
class countaction extends action {

    public $article;
    public $category;
    public $user;

    function __construct() {
        parent::__construct();
        $this->article = new article();
        $this->category = new category();
        $this->user = new users();
        $where = "state=1 and parentid=0";
        $fields = "*";
        $category = $this->category->getlist($fields, $where, 2);
        define('ADMIN_USERNAME', 'tech');     // Admin Username  
        define('ADMIN_PASSWORD', 'tech121');      // Admin Password  
    }

    function doDefault() {
        $this->doCount();
    }

    function doCount() {

        $template_name = "article_count";
        $css = array("issue", "jquery.ui.datepicker", "jquery.ui.theme");
        $js = array("jquery-1.8.3.min", "jquery.ui.datepicker", "jquery.ui.datepicker-zh-CN", "jquery-ui.min");
        $this->vars('css', $css);
        $this->vars('js', $js);
        //$this->checkAuth(402);
        $page_title = "文章字数统计";
        $category = $this->category->getlist("*", "parentid=0 and state=1", 2);
        $this->vars("category", $category);

        
        if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || $_SERVER['PHP_AUTH_USER'] != ADMIN_USERNAME || $_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD) {
            Header("HTTP/1.0 401 Unauthorized");
            Header("WWW-Authenticate: Basic realm=\"Login\"");
            echo "您必须登录!";
        } else {
            $template_name = "article_count";
            $css = array("issue", "jquery.ui.datepicker", "jquery.ui.theme");
            $js = array("jquery", "jquery-1.8.3.min", "jquery.ui.datepicker", "jquery.ui.datepicker-zh-CN", "jquery.blockUI", "jquery-ui.min");
            $this->vars('css', $css);
            $this->vars('js', $js);
            //$this->checkAuth(402);
            $page_title = "文章字数统计";
            $category = $this->category->getlist("*", "parentid=0 and state=1", 2);
            $this->vars("category", $category);



            $where = "ca.state in(4,3,2,1) and ca.type_id=1 ";

            if ($_REQUEST[keyword]) {
                $keword = trim($_REQUEST[keyword]);
                $where .=" and ca.title like '%$keword%'";
                $this->vars('keyword', $keword);
            }
            // if ($_POST[author]) {
            //     $author = trim($_REQUEST[author]);
            //     $where .=" and us.username like'%$author%'";
            //     $this->vars('author', $author);
            // }
            if ($_REQUEST[realname]) {
                $realname = trim($_REQUEST[realname]);
                $where .=" and (us.realname like '%$realname%' OR us.nickname like '%$realname%')";
                $this->vars('realname', $realname);
            }
            if ($_REQUEST['p_category_id']) {
                $p_category_id = trim($_REQUEST['p_category_id']);
                $where .=" and pcac.id ='$p_category_id'";
                $this->vars('p_category_id', $p_category_id);
            }
            if ($_REQUEST['level']) {
                $where .=" and us.level ='$_REQUEST[level]'";
                $this->vars('level', $_REQUEST['level']);
            }
            if ($_REQUEST['uptime'] && $_REQUEST['outtime']) {
                $so_uptime = strtotime($_REQUEST['uptime']);
                $so_outtime = strtotime($_REQUEST['outtime']);
                $where .=" and " . $so_uptime . " <= ca.uptime";
                $where .=" and ca.uptime <= " . $so_outtime;
                $this->vars('uptime', $_REQUEST['uptime']);
            }

            $order = array("ca.id" => 'desc');
            $fields = 'ca.*,cac.category_name,pcac.category_name as p_category_name,pcac.id as p_category_id,us.level,us.realname';
            if ($_GET['button'] == 1) {
                $list = $this->article->getArticleListPage($where, $fields, $order, 2);

                if ($list)
                    foreach ($list as $k => $v) {
                        $len_info = dstring::strLengthInfo($this->filter($v['content'], HTTP_FILTER_STRIPHTML, 1));
                        $list[$k]['hz_total'] = trim($len_info['hz_total']);
                        $list[$k]['en_total'] = ceil(trim($len_info['en_total']) / 2);
                        $list[$k]['Total'] = intval($len_info['hz_total']) + intval($list[$k]['en_total']);
                    }
            }
        }



        $this->vars('page_title', $page_title);
        $this->vars('list', $list);
        $this->template($template_name);

    }

    //导出统计列表
    function doCountExce() {
        $id = implode(',', $_POST['id']);
        $fields = 'ca.id,ca.title,ca.author,us.level,pcac.category_name as p_category_name,ca.uptime,ca.content,us.realname';
        $where = "ca.state in(4,3,2,1) and ca.type_id=1 and ca.id in($id)";
        $flag = 2;
        $order = array("ca.id" => 'desc');
        $list = $this->article->getArticleListPage($where, $fields, $order, 2);

        $str = '文章ID,文章标题,编辑作者,编辑等级,频道,时间,中文字符,英文字符,字符总和' . "\n";
        if ($list) {
            foreach ($list as $key => $val) {
                $len_info = dstring::strLengthInfo($this->filter($val['content'], HTTP_FILTER_STRIPHTML, 1));
                $val['hz_total'] = trim($len_info['hz_total']);
                $val['en_total'] = ceil(trim($len_info['en_total']) / 2);
                $val['Total'] = intval($len_info['hz_total']) + intval($val['en_total']);

                $str .= $val['id'] . ',' . $val['title'] . ',' . $val['realname'] . ',' . $val['level'] . ',' . $val['p_category_name'] . ',' . date('Y-m-d', $val['uptime']) . ',' . $val['Total'] . "\r\n";
            }
        }
        $this->exportExcel('countexce', '文章字符统计', $str);
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
  
}
?>