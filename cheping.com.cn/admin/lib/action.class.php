<?php

/**
 * action base class
 * $Id: action.class.php 2920 2016-06-06 02:30:23Z david $
 * @author David.Shaw <tudibao@163.com>
 */
class action extends object {

    public $tpl;
    public $act_name = "action";
    public $func_pre = "do";
    public $replace = array();
    public $page_title;
    public $common_total = '共';
    public $common_total_num = '条';
    public $tpl_file = '';

    public function __construct() {
        $this->initTpl();
        if (!$this->timestamp)
            $this->timestamp = time();
    }

    public function initTpl() {
        global $local_host;
        $this->tpl = new template();
        $this->tpl->assign('admin_path', ADMIN_PATH);
        $this->tpl->assign('page_charset', SITE_CHARSET);
        $this->tpl->assign('relat_dir', RELAT_DIR);
        $this->tpl->assign('login_uid', session('user_id'));
        $this->tpl->assign('login_uname', session('username'));
        $this->tpl->assign('php_self', $_ENV['PHP_SELF']);
        $this->tpl->assign('main_site', $local_host);
    }

    /**
     * 设置模板文件存放的子目录名称
     * 
     * @param string $tpldir  template下的模板子目录
     * @return void
     */
    public function setTplDir($tpldir = '') {
        $this->tpl->template($tpldir);
    }

    public function vars($name, $val) {
        $this->tpl->assign($name, $val);
    }

    public function fetch($template_name, $replace = true) {
        if (!is_object($this->tpl))
            return false;
        $html = $this->tpl->fetch($template_name);
        $html = $replace ? $this->replaceTpl($html) : $html;
        return $html;
    }

    public function template($template_name = '', $replace = true, $callback = '') {
        global $attach_server;

        if ($this->page_title) {
            $this->tpl->assign('page_title', $this->page_title);
        }
        if (!$template_name) {
            $html = $this->fetch($this->tpl_file, $replace);
        } else{
            $html = $this->fetch($template_name, $replace);
        }
        
        if($callback){
            $html = $callback($html);
        }
        
        if (!empty($attach_server) && ADMINED_ !== 1) {
            $max = count($attach_server);
            $html = preg_replace_callback(
                    '%(name|src|src2)=[\"\']/?((' . UPLOAD_DIR . ')?images\/)%is', "replaceAttachServer", $html
            );
            #$html = str_replace('"this.src="', '"this.src=\'', $html);
            $html = preg_replace('%this.src="([\w\:\/\.\?\=\&]+)\'%ims', 'this.src=\'\\1\'', $html);
        }

        echo $html;
    }

    public function replaceTpl($html) {
        if (!empty($this->replace)) {
            return str_replace(array_keys($this->replace), array_values($this->replace), $html);
        } else
            return $html;
    }

    /**
     * 根据参数调用对应方法
     * 
     * @param mixed $opt
     */
    public function run($opt = array()) {
        if (!$_GET[$this->act_name]) {
            $this->doDefault();
        } else {
            $func_name = $this->func_pre . $_GET[$this->act_name];
            if (!$opt) {
                $this->$func_name();
            } else {
                $publics = "";
                foreach ($opt as $key => $value) {
                    $publics .= "$value,";
                }
                $publics = substr($publics, 0, -1);
                eval("\$this->$func_name($publics);");
            }
        }
    }

    public function multi($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 10, $autogoto = TRUE, $simple = FALSE) {
        global $maxpage;
        $multipage = '';
        $purls = explode("?", $mpurl);
        $mpurl = count($purls) > 1 ? $mpurl . "&" : $mpurl . "?";
        $realpages = 1;
        if (is_numeric($num) && $num > $perpage) {
            $offset = 2;
            $realpages = ceil($num / $perpage);
            $pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;
            if ($page > $pages) {
                $from = 1;
                $to = $pages;
            } else {
                $from = $curpage - $offset;
                $to = $from + $page - 1;
                if ($from < 1) {
                    $to = $curpage + 1 - $from;
                    $from = 1;
                    if ($to - $from < $page) {
                        $to = $page;
                    }
                } elseif ($to > $pages) {
                    $from = $pages - $page + 1;
                    $to = $pages;
                }
            }

            $multipage = "<ol>";
            $multipage .= ($curpage - $offset > 1 && $pages > $page ? '<li><a href="' . $mpurl . 'page=1" >1 ...</a></li>' : '') .
                    ($curpage > 1 && !$simple ? '<li><a href="' . $mpurl . 'page=' . ($curpage - 1) . '" >&lsaquo;&lsaquo;</a></li>' : '');
            for ($i = $from; $i <= $to; $i++) {
                $multipage .= $i == $curpage ? '<li class="songs">' . $i . '</li>' : '<li><a href="' . $mpurl . 'page=' . $i . '" >' . $i . '</a></li>';
            }
            $multipage .= ($curpage < $pages && !$simple ? '<li class=""><a href="' . $mpurl . 'page=' . ($curpage + 1) . '" >&rsaquo;&rsaquo;</a></li>' : '') .
                    ($to < $pages ? '<li class="chang"><a href="' . $mpurl . 'page=' . $pages . '" >... ' . $realpages . '</a></li>' : '') .
                    (!$simple && $pages > $page && !$ajaxtarget ? '<kbd><input type="text" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location=\'' . $mpurl . 'page=' . '\'+this.value+\'\'; return false;}" /></kbd>' : '');

            // $multipage = $multipage ? (!$simple ? '<span class="gray">&nbsp;' . $this->common_total . $num . $this->common_total_num . '&nbsp;</span>' : '') . $multipage : '';
        }
        $maxpage = $realpages;
        return $multipage;
    }

    public function message($url, $str, $time = 3, $title = '') {
        $template_name = "redirect";
        $this->tpl->assign('url', $url);
        $this->tpl->assign('str', $str);
        $this->tpl->assign('time', $time);
        $this->tpl->assign('title', "{$title}-" . SITE_NAME);
        $this->tpl->display($template_name);
    }

    /**
     * get arguments
     * 
     * @param mixed $make
     * @param mixed $action_type
     * @return array
     */
    public function getOpt($make = false) {
        $action = $_GET['o'];

        if (!isset($action) && $_ENV['os'] !== 'win') {
            $opt = getopt('o:d::');
        } else {
            if (empty($this->id))
                $this->id = 1;
            $opt = array('o' => $action, 'd' => $this->id);
        }

        return $opt;
    }

    public function makePage($get_id, $page_type = 'index', $filename, $debug = true) {
        ob_start();
        echo $this->{'parse' . $page_type}();
        $file_str = ob_get_contents();
        ob_end_clean();
        $dir = dirname($filename);
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
        $int = file_put_contents($filename, $file_str);

        if ($debug) {
            if ($int == strlen($file_str)) {
                echo "$page_type {$get_id} ok\n";
            } else {
                echo "$page_type {$get_id} err\n";
            }
        } else {
            return $int;
        }
    }

    /**
     * 生成静态文件
     * 
     * @param mixed $str  "index.php?action=brand-js"
     * @param mixed $page_type
     * @param mixed $filename
     * @param mixed $debug
     * @return int
     */
    public function action2File($url, $filename, $debug = false) {
        $tmp = parse_url($url);
        if ($tmp['query']) {
            foreach (explode('&', $tmp['query']) as $uv) {
                list($arg, $argv) = explode('=', $uv);
                if ($arg == 'action') {
                    list($actionclass, $actionfunc) = explode('-', $argv);
                } else {
                    $_GET[$arg] = $argv;
                }
            }
        }
        #检查类名和方法名
        if (!$actionclass || !$actionfunc) {
            return false;
        }
        $actionclass = "{$actionclass}action";
        $actionfunc = "do{$actionfunc}";

        $instance = new $actionclass;
        #检查方法在类中是否在在
        if (!method_exists($instance, $actionfunc)) {
            return false;
        }

        ob_start();
        #判断是否有callback定义, 其中callback中的方法，必须是model
        $call_ret = '';
        if (strpos($_GET['callback'], ":") !== false) {
            list($call_action, $call_method) = explode(':', $_GET['callback']);
            #$call_class = "{$call_action}action";
            #$call_func = "do{$call_method}";
            $call_class = "{$call_action}";
            $call_func = "{$call_method}";
            $call_obj = new $call_class;
            if (method_exists($call_obj, $call_func)) {
                $call_ret = $call_obj->$call_func();
            }
        }
        echo $instance->$actionfunc($call_ret);
        $file_str = ob_get_contents();
        ob_end_clean();

        #如果不要求生成文件，返回
        $f = file::getfilename($filename);
        if (!$f || $f == ".") {
            return true;
        }

        $dir = dirname($filename);
        if (!is_dir($dir)) {
            file::forcemkdir($dir);
        }
        $int = file_put_contents($filename, $file_str);

        if ($debug) {
            if ($int == strlen($file_str)) {
                echo "OK， {$filename}\n";
            } else {
                echo "Err, {$filename}\n";
            }
        } else {
            return $int;
        }
    }

    /**
     * preview ssi include code, not support recursion
     * 
     * eg: ssi include code <!--#include virtual="/html/index.html"-->
     * replace above code by "/html/index.html" file content
     * 
     * @param $html; $html
     * @return $html;
     */
    public function getSSIfile($html) {
        $opt = $this->getOpt(true);
        if ($opt['o'] !== 'make') {
            $html = $this->parseSSIfile($html);
        }
        return $html;
    }

    /**
     * parse ssi code to php code
     * eg: <!--#element attribute=value attribute=value ... -->
     * @param mixed $html
     * @return $html;
     */
    public function parseSSIfile($html) {
        #parse include
        $html = preg_replace_callback('/<!--#include\s+virtual="([^\'\"]+)"\s*-->/si', array($this, 'loadAbsSSI'), $html);
        $html = preg_replace_callback('/<!--#include\s+file="([^\'\"]+)"\s*-->/si', array($this, 'loadRelSSI'), $html);
        return $html;
    }

    /**
     * 加载绝对路径的ssi文件
     * 
     * @param array $file 数组[1]为ssi文件路径
     * @return string  ssi文件的内容
     */
    function loadAbsSSI($file) {
        $ret = null;
        $ret = @file_get_contents(WWW_ROOT . $file[1]);
        #replace
        $ret = $this->replaceTpl($ret);
        return $ret;
    }

    /**
     * 加载相对路径的SSI文件
     * 
     * @param array $file 数组[1]为ssi文件路径
     * @return string ssi文件的内容
     */
    function loadRelSSI($file) {
        $ret = null;
        $ret = @file_get_contents($file[1]);
        $ret = $this->replaceTpl($ret);
        return $ret;
    }
    
    public function replaceAttachServer($html) {
        global $attach_server;
        if (!empty($attach_server)) {
            $max = count($attach_server);
            $html = preg_replace_callback(
                    '%src=[\"\']/?((' . UPLOAD_DIR . ')?images\/)%is', "replaceAttachServer", $html
            );
            $html = preg_replace('%this.src="([\w\:\/\.\?\=\&]+)\'%ims', 'this.src=\'\\1\'', $html);
        }
        return $html;
    }

    /**
     * 对指定的数据进行过滤
     * $type定义 1:int,2:float,3:email,4:url,5:string,6:quote,7:encode,8:special,9:stripHtml,10:stripUrl,11:strongpasswod
     * 
     * 数据类型详细说明：
     * @see int：删除非整型字符，只返回满足整型格式的数据
     * @see float：删除非浮点型字符，只返回满足浮点型格式的数据
     * @see email：删除非邮件地址格式字符，只返回满足邮件地址格式的数据
     * @see url：删除非链接地址字符，只返回满足链接地址格式的数据
     * @see string：删除那些对应用程序有潜在危害的数据，可简单去除一些html标签，只返回字符串
     * @see quote：对4类字符转义处理，分别是[ ' "  \ NULL]
     * @see encode：对字符串进行urlencode
     * @see special：相当于htmlspecialchars()函数
     * @see strongpassword：验证密码强度，如果满足default/need定义的强度要求，返回原密码，否则返回false或空
     * 
     * @param string $dataname 对应$_GET, $_POST等数组里的值，如$_GET['name']，则不name
     * @param int $type 数据验证类型，默认int型,可以是int, float, email, url, string,quote,encode,special,stripHtml,stripUrl
     * @param mixed $default 设置为空时的默认值，如$type=HTTP_FILTER_STRONGPASSWORD，则为要求强度等级0:不要求,1:低，2:中，3:高
     * @return mixed 删除非法字符后的内容
     */
    public function filter($data, $type = 1, $default = '') {
        switch ($type) {
            case 2: $data = $this->addValue($data)->Float();
                break;
            case 3: $data = $this->addValue($data)->Email();
                break;
            case 4: $data = $this->addValue($data)->Url($default);
                break;
            case 5: $data = $this->addValue($data)->String();
                break;
            case 6: $data = $this->addValue($data)->Quote();
                break;
            case 7: $data = $this->addValue($data)->UrlEncode();
                break;
            case 8: $data = $this->addValue($data)->SpecialChars();
                break;
            case 9: $data = $this->addValue($data)->stripHtml();
                break;
            case 10: $data = $this->addValue($data)->stripUrl();
                break;
            case 11: $data = $this->addValue($data)->StrongPassword($default);
                break;
            default : $data = $this->addValue($data)->Int(); #filterInt
                break;
        }

        return (empty($data) && $type <> 11) ? $default : $data;
    }

}

?>
