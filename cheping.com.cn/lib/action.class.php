<?php

/**
 * action base class
 * $Id: action.class.php 2009 2016-04-08 11:08:24Z david $
 */
class action extends object {

    var $tpl;
    var $cache;
    var $hfilter;
    var $use_cache = false;
    var $cache_time = 3600;
    var $cache_salt = 'g';
    var $tpl_name = '';
    var $strip_chars = '';
    var $act_name = "action";
    var $func_pre = "do";
    var $replace = array();
    var $defaultTplVars = array('page_title', 'discription', 'keywords', 'css', 'js');

    function __construct() {
        global $local_host, $relative_dir;

        $this->replace = array(
            'href="css/' => 'href="' . $relative_dir . 'css/',
            'src="js/' => 'src="' . $relative_dir . 'js/',
        );

        $this->initTpl();
        $this->hfilter = new HttpFilter();
        $this->timestamp = $this->timestamp ? $this->timestamp : time();
        //$this->tpl->assign('username', session('user_name'));
        $this->tpl->assign('local_host', $local_host);
        $this->tpl->assign('relative_dir', $relative_dir);
        $this->tpl->assign('site_name', SITE_NAME);
        $this->tpl->assign('php_self', $_SERVER['REQUEST_URI']);
        $this->tpl->assign('env', $_ENV);
    }

    function vars($name, $val) {
        $this->tpl->assign($name, $val);
    }

    function initTpl() {
        $this->tpl = new template();
    }

    /**
     * 设置模板文件存放的子目录名称
     * 
     * @param string $tpldir  template下的模板子目录
     * @return void
     */
    function setTplDir($tpldir = '') {
        $this->tpl->template($tpldir);
    }

    /**
     * 输出模板解析后的页面内容
     * @param string    $tpl_name 模板名称
     * @param boolean   $return 返回值/直接输出
     * @description:    即不同参数，缓存内容不一样，根据这个参数调用不同的缓存
     */
    function template($tpl_name = '', $return = false, $callback = '') {
        $tpl_name = $tpl_name ? $tpl_name : $this->tpl_name;
        $result = '';
        if ($this->use_cache) {
            $tk = '';
            if (strpos($this->cache_salt, 'g') !== FALSE) {
                $tk .= serialize($_SERVER['QUERY_STRING']);
            }
            if (strpos($this->cache_salt, 'p') !== FALSE) {
                $tk .= serialize($_POST);
            }
            if (strpos($this->cache_salt, 's') !== FALSE) {
                $tk .= serialize($_SESSION);
            }
            if (strpos($this->cache_salt, 'c') !== FALSE) {
                $tk .= serialize($_COOKIE);
            }
            $skey = substr(md5($tk), 8, 24);
            $cache_key = COOKIE_PRE . $tpl_name . '_' . $skey;
            if ($this->strip_chars) {
                $cache_key = COOKIE_PRE . $this->strip_chars . '_' . $skey;
            } else {
                $cache_key = COOKIE_PRE . $tpl_name . '_' . $skey;
            }
            $result = $html = $this->cache->getCache($cache_key);
            if ($return)
                return $result;
        }
        if (!$result || !$this->use_cache) {
            $html = $this->tpl->fetch($tpl_name);
            $html = $this->getSSIfile($html);
            $html = $this->replaceTpl($html);
            if ($callback) {
                $html = $callback($html);
            }
            $this->use_cache && $this->cache->writeCache($cache_key, $html, $this->cache_time);
        }
        echo $html;
    }

    /**
     * 设置模板变量
     * 同时指定是否需要对模板解析后的内容进行缓存
     * 
     * @param string    $tplname 模板名称
     * @param boolean   $use_cache   是否起用缓存
     * @param integer   $cache_time  缓存时间
     * @param string    $salt 缓存种子 g:$_GET, p:$_POST, s:$_SESSIOn, c:$_CCOKIE
     * @param string    $strip_chars 替换cache_key的字符串
     */
    function setTplName($tplname, $use_cache = false, $cache_time = 3600, $salt = 'g', $strip_chars = '') {
        $this->tpl_name = $tplname;
        $this->use_cache = $use_cache;
        $this->cache_time = $cache_time;
        $this->cache_salt = $salt;
        $this->strip_chars = $strip_chars;

        if ($this->use_cache) {
            $result = $this->template($tpl_name, true);
            if ($result) {
                echo $result;
                exit;
            }
        }
    }

    /**
     * 设置cache对象
     * 用于缓存页面缓存
     * 
     * @global object $_cache
     * @param object $cache_obj
     */
    function setCache($cache_obj = '') {
        global $_cache;
        $this->cache = $cache_obj ? $cache_obj : $_cache;
    }

    function message($url, $str, $time = 3) {
        $template_name = "redirect";

        $this->tpl->assign('url', $url);
        $this->tpl->assign('str', $str);
        $this->tpl->assign('time', $time);
        $this->tpl->display($template_name);
    }

    /**
     * 根据参数调用对应方法
     * 
     * @param mixed $opt
     */
    function run($opt = array()) {
        if (!$_GET[$this->act_name]) {
            $this->doDefault();
        } else {
            $func_name = $this->func_pre . $_GET[$this->act_name];
            if (!$opt) {
                $this->$func_name();
            } else {
                $vars = "";
                foreach ($opt as $key => $value) {
                    $vars .= "$value,";
                }
                $vars = substr($vars, 0, -1);
                eval("\$this->$func_name($vars);");
            }
        }
    }

    /**
     * make page
     * 
     * @param mixed $get_id
     * @param mixed $page_type
     * @param mixed $filename
     * @param mixed $debug
     * @return int
     */
    function makePage($get_id, $page_type = 'index', $filename, $debug = true) {
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
     * check create option
     * 
     * @param mixed $make
     * @param mixed $action_type
     * @return array
     */
    function createshow($make = false, $action_type = '') {
        $action = $action_type ? $action_type : $this->filter($_GET['o'], HTTP_FILTER_STRING);
        if (empty($action) && $_ENV['os'] !== 'win') {
            $opt = getopt('o:d::');
        } else {
            if (empty($this->id))
                $this->id = 0;
            if ($action) {
                $opt = array('o' => 'make', 'd' => $this->id);
            } else
                $opt = array('o' => $make, 'd' => $this->id);
        }

        return $opt;
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
    function getSSIfile($html) {
        $opt = $this->createshow(true);
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
    function parseSSIfile($html) {
        #parse include
        #$html = preg_replace('/<!--#include\s+virtual="([^\'\"]+)"\s*-->/esi', "\$this->loadSSIfile('\\1')", $html);
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
        $ret = @file_get_contents(SITE_ROOT . $file[1]);
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

    /**
     * replace content
     * 
     * @param mixed $html
     * @return mixed
     */
    function replaceTpl($html) {
        global $attach_server, $relative_dir;
        if (!empty($this->replace)) {
            $html = str_replace(array_keys($this->replace), array_values($this->replace), $html);
        }

        if (!empty($attach_server)) {
            $max = count($attach_server);
            $html = preg_replace_callback(
                    '%(name|src|data-original)=[\"\']/?((' . UPLOAD_DIR . ')?images\/)%is', "replaceAttachServer", $html
            );
            #$html = str_replace('"this.src="', '"this.src=\'', $html);
            $html = preg_replace('%this.src="([\w\:\/\.\?\=\&]+)\'%ims', 'this.src=\'\\1\'', $html);
        } elseif (!empty($this->replace)) {
            $replace = array(
                'src="' . UPLOAD_DIR => 'src="' . $relative_dir . UPLOAD_DIR,
                'src="images/' => 'src="' . $relative_dir . 'images/',
                'src="/images/' => 'src="' . $relative_dir . 'images/',
                "this.src='/images" => "this.src='{$relative_dir}images",
            );
            $html = str_replace(array_keys($replace), array_values($replace), $html);
        }

        return $html;
    }

    /*
     * @判断是否登录
     * 没有登录 跳转到登录页面，登录后跳转到之前的请求页面
     */

    function checklogin() {
        global $relative_dir;
        $user_id = session("user_id");
        $user_name = session("user_name");
        //保存登录前的页面地址
        if (empty($user_id) || empty($user_name)) {
            //"http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF'];
            $lurl = urlencode('http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"]);
            //跳转到登录页面
            echo "<script>window.location='{$relative_dir}login.php?lurl=$lurl'</script>";
            exit;
        }
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
    function filter($data, $type = 1, $default = '') {
        switch ($type) {
            case 2: $data = $this->hfilter->filterFloat($data);
                break;
            case 3: $data = $this->hfilter->filterEmail($data);
                break;
            case 4: $data = $this->hfilter->filterUrl($data, $default);
                break;
            case 5: $data = $this->hfilter->filterString($data);
                break;
            case 6: $data = $this->hfilter->filterQuote($data);
                break;
            case 7: $data = $this->hfilter->filterEncode($data);
                break;
            case 8: $data = $this->hfilter->filterSpecial($data);
                break;
            case 9: $data = $this->hfilter->stripHtml($data, 1, $default);
                break;
            case 10: $data = $this->hfilter->stripUrl($data);
                break;
            case 11: $data = $this->hfilter->filterStrongPassword($data, $default);
                break;
            default : $data = $this->hfilter->filterInt($data); #filterInt
                break;
        }

        return (empty($data) && $type <> 11) ? $default : $data;
    }

    /**
     * 表单数据验证
     * 未验证的类型，待添加
     * 
     * array $formDataArr = array('表单名称' => array('验证类型', '是否必填，如果为空，则有值时验证合法性，无值不验证', '当失败时返回的错误提示'));
     * @example array array('username' => array(FORM_CHECK_HZ_EN_NUM, 'required', '用户名非法或为空！'));
     * @param array $formDataArr 表单数组及说明
     * @return 表单某字段验证失败，提示信息，并返回，成功则返回表单数据的数组
     */
    function checkForm($formDataArr, $method = 'post') {
        $r = $this->hfilter->filterForm($formDataArr, $method);
        if (!$r['status']) {
            $this->alert($r['name'] . $r['message'], 'js', 2);
        } else {
            return $r['return'];
        }
    }

}

?>
