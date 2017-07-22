<?php

/**
 * global function
 * $Id: global.func.php 3162 2016-06-22 02:48:08Z david $
 * @author David.Shaw <tudibao@163.com>
 */

/**
 * 如果定义了 RWURL 常量
 * 正则替换文章列表页面二级栏目链接及分页链接
 * 
 * @param   string  $str    分页代码
 * @return  string  替换url后的分页代码
 */
function replaceNewsURL($str) {
    if (RWURL === 1) {
        #新车
        if (strpos($str, '&ids=54') !== false) {
            $str = preg_replace('/\/?article\.php\?action=CarReview&id=[\d]+&ids=\d+&page=([\d]+)/im', '/xinche/p\1/', $str);
        } elseif (strpos($str, '&ids=55') !== false) {
            $str = preg_replace('/\/?article\.php\?action=CarReview&id=[\d]+&ids=\d+&page=([\d]+)/im', '/zixun/p\1/', $str);
        } elseif (strpos($str, '&ids=16') !== false) {
            $str = preg_replace('/\/?article\.php\?action=CarReview&id=[\d]+&ids=\d+&page=([\d]+)/im', '/jiashi/p\1/', $str);
        } elseif (strpos($str, '&ids=56') !== false) {
            $str = preg_replace('/\/?article\.php\?action=CarReview&id=[\d]+&ids=\d+&page=([\d]+)/im', '/ceshi/p\1/', $str);
        } elseif (strpos($str, '&ids=50') !== false) {
            $str = preg_replace('/\/?article\.php\?action=CarReview&id=[\d]+&ids=\d+&page=([\d]+)/im', '/jingdianche/p\1/', $str);
        } elseif (strpos($str, '&ids=52') !== false) {
            $str = preg_replace('/\/?article\.php\?action=CarReview&id=[\d]+&ids=\d+&page=([\d]+)/im', '/fengyunche/p\1/', $str);
        } elseif (strpos($str, '&ids=51') !== false) {
            $str = preg_replace('/\/?article\.php\?action=CarReview&id=[\d]+&ids=\d+&page=([\d]+)/im', '/saiche/p\1/', $str);
        } elseif (strpos($str, '&ids=59') !== false) {
            $str = preg_replace('/\/?article\.php\?action=CarReview&id=[\d]+&ids=\d+&page=([\d]+)/im', '/duibi/p\1/', $str);
        } elseif (strpos($str, '&ids=63') !== false) {
            $str = preg_replace('/\/?article\.php\?action=CarReview&id=[\d]+&ids=\d+&page=([\d]+)/im', '/hangye/p\1/', $str);
        } else {
            $str = preg_replace('/\/?article\.php\?action=CarReview&id=[\d]+&page=([\d]+)/im', '/p\1/', $str);
        }
        $str = str_replace('"/p1/"', '"/"', $str);
    }
    return $str;
}

/**
 * 替换页面中出现的文章二级栏目链接
 * 需要根据 RWURL常量判断
 * 注：如果有新增加或删除的栏目，对应的在下面的替换规则中增加或删除规则
 * 
 * @global  string   $local_host     定义在include/config.php中站点链接
 * @param   string          $str            需要处理的原始字符串
 * @return  string          替换完成的字符串
 */
function replaceNewsChannel($str) {
    global $local_host;
    if (RWURL === 1) {
        $str = str_replace('href="article.php?action=ActiveList', 'href="' . $local_host . 'article.php?action=ActiveList', $str);
        $str = str_replace('/article.php?action=CarReview&id', 'article.php?action=CarReview&id', $str);
        $str = str_replace('/video.php?action=Video&id', 'video.php?action=Video&id', $str);
        $str = str_replace('<a href="/">首页</a>', '<a href="' . $local_host . '">首页</a>', $str);
        $str = str_replace('<a href="/">车评首页</a>', '<a href="' . $local_host . '">车评首页</a>', $str);
        $str = str_replace('<a href="/">车评网</a>', '<a href="' . $local_host . '">车评网</a>', $str);
        $str = str_replace('href="/login.php"', 'href="' . $local_host . 'login.php"', $str);
        $str = str_replace('href="/register.php"', 'href="' . $local_host . 'register.php"', $str);
        $str = str_replace('href="/user.php"', 'href="' . $local_host . 'user.php"', $str);
        $str = str_replace('<a href="/"><img src="/image', '<a href="' . $local_host . '"><img src="' . $local_host . 'image', $str);
        $str = str_replace('article.php?action=CarReview&id=7&ids=54', 'http://news.' . DOMAIN . '/xinche/', $str);
        $str = str_replace('article.php?action=CarReview&id=7&ids=55', 'http://news.' . DOMAIN . '/zixun/', $str);
        $str = str_replace('article.php?action=CarReview&id=8&ids=16', 'http://pingce.' . DOMAIN . '/jiashi/', $str);
        $str = str_replace('article.php?action=CarReview&id=8&ids=56', 'http://pingce.' . DOMAIN . '/ceshi/', $str);
        $str = str_replace('article.php?action=CarReview&id=10&ids=50', 'http://wenhua.' . DOMAIN . '/jingdianche/', $str);
        $str = str_replace('article.php?action=CarReview&id=10&ids=52', 'http://wenhua.' . DOMAIN . '/fengyunche/', $str);
        $str = str_replace('article.php?action=CarReview&id=10&ids=51', 'http://wenhua.' . DOMAIN . '/saiche/', $str);
        $str = str_replace('article.php?action=CarReview&id=8&ids=59', 'http://pingce.' . DOMAIN . '/duibi/', $str);
        $str = str_replace('article.php?action=CarReview&id=7&ids=60', 'http://wenhua.' . DOMAIN . '/quwen/', $str);
        $str = str_replace('article.php?action=CarReview&id=7&ids=63', 'http://news.' . DOMAIN . '/hangye/', $str);
        $str = str_replace('article.php?action=CarReview&id=10&ids=65', 'http://wenhua.' . DOMAIN . '/lvxing/', $str);
        $str = str_replace('article.php?action=CarReview&id=7', 'http://news.' . DOMAIN . '/', $str);
        $str = str_replace('article.php?action=CarReview&id=8', 'http://pingce.' . DOMAIN . '/', $str);
        $str = str_replace('article.php?action=CarReview&id=10', 'http://wenhua.' . DOMAIN . '/', $str);
        $str = str_replace('article.php?action=CarReview&id=9', 'http://v.' . DOMAIN . '/', $str);
        $str = str_replace('video.php?action=Video&id=9', 'http://v.' . DOMAIN . '/', $str);
        $str = preg_replace('%/review\.php\?action=list&type=(\d+)&article_id=(\d+)&type_id=(\d+)%im', '/club/\2-\1-\3.html', $str);
    }
    return $str;
}

/**
 * 替换页面中出现的文章链接
 * 需要根据 RWURL常量判断
 * 
 * @param   string  $str    要处理的原始字符串
 * @return  string  替换完成的字符串
 */
function replaceArticleUrl($str) {
    if (RWURL === 1) {
        $str = replaceNewsChannel($str);
        $querystring = $_SERVER['QUERY_STRING'];
        if (strpos($querystring, '&id=7') !== false) {
            $str = preg_replace('%href="/html/article/(\d+)/(\d+)/([^"]+)"%im', 'href="http://news.' . DOMAIN . '/\1-\2-\3"', $str);
        } elseif (strpos($querystring, '&id=8') !== false) {
            $str = preg_replace('%href="/html/article/(\d+)/(\d+)/([^"]+)"%im', 'href="http://pingce.' . DOMAIN . '/\1-\2-\3"', $str);
        } elseif (strpos($querystring, '&id=10') !== false) {
            $str = preg_replace('%href="/html/article/(\d+)/(\d+)/([^"]+)"%im', 'href="http://wenhua.' . DOMAIN . '/\1-\2-\3"', $str);
        }
    }
    return $str;
}

/**
 * 替换页面中出现的视频链接
 * 需要根据 RWURL常量判断
 * 
 * @global  string   $local_host     站点链接
 * @param   string          $str            要处理的原始字符串
 * @return  string          替换完成的字符串
 */
function replaceVideoUrl($str) {
    global $local_host;
    if (RWURL === 1) {
        #video.php?action=ZuiZhong&id=9&ids=146
        #http://v.cheping.com.cn/pingce/&page=2
        $str = preg_replace('/href="\/?video\.php\?action=ZuiZhong&id=9&ids=(\d+)"/im', 'href="http://v.' . DOMAIN . '/\1.html"', $str);
        $str = str_replace('/video.php?action=Video&id', 'video.php?action=Video&id', $str);
        $str = str_replace('video.php?action=Video&id=9&ids=33', 'http://v.' . DOMAIN . "/xiadongpingche/", $str);
        $str = str_replace('video.php?action=Video&id=9&ids=34', 'http://v.' . DOMAIN . "/jingtai/", $str);
        $str = str_replace('video.php?action=Video&id=9&ids=35', 'http://v.' . DOMAIN . "/feichedang/", $str);
        $str = str_replace('video.php?action=Video&id=9&ids=40', 'http://v.' . DOMAIN . "/guanfang/", $str);
        $str = str_replace('video.php?action=Video&id=9&ids=57', 'http://v.' . DOMAIN . "/ttyhs/", $str);
        $str = str_replace('video.php?action=Video&id=9&ids=58', 'http://v.' . DOMAIN . "/huodong/", $str);
        $str = str_replace('video.php?action=Video&id=9&ids=61', 'http://v.' . DOMAIN . '/wscsc/', $str);
        $str = str_replace('video.php?action=Video&id=9&ids=62', 'http://v.' . DOMAIN . '/cxkdp/', $str);
        $str = str_replace('video.php?action=Video&id=9&ids=66', 'http://v.' . DOMAIN . '/ttsrx/', $str);
        $str = str_replace('video.php?action=Video&id=9&ids=67', 'http://v.' . DOMAIN . '/deguo/', $str);
        $str = str_replace('video.php?action=Video&id=9&ids=70', 'http://v.' . DOMAIN . '/bjpc/', $str);
        $str = str_replace('video.php?action=Video&id=9&ids=71', 'http://v.' . DOMAIN . '/sportauto/', $str);
        $str = str_replace('video.php?action=Video&id=9', 'http://v.' . DOMAIN . "/", $str);
        $str = preg_replace('%http://v.' . DOMAIN . '/([^/]+)/&page=([\d]+)%im', '/\1/p\2/', $str);
        $str = replaceNewsChannel($str);
    }
    return $str;
}

/**
 * 将传入的内容中出现的图片路径替换成attach_server中的主机地址
 * 
 * @global  array   $attach_server      图片服务器主机名
 * @global  array   $local_host         当前www主机名
 * @param   string  $html               要替换的原内容
 * @return  string  替换过的内容
 */
function replaceImageUrl($html) {
    global $attach_server, $local_host;
    if ($attach_server) {
        $html = str_replace($local_host . 'attach/images/', $attach_server[0] . RELAT_DIR, $html);
        $html = str_replace('/attach/images/', $attach_server[0] . RELAT_DIR, $html);
    }
    return $html;
}

/**
 * 将字符串，以指定的分隔符，分隔为数组
 * 分隔符默认为`|`
 * 
 * @param   string      $str            要处理的原字符串
 * @param   string      $delimiter      指定用于分割的分隔符
 * @param   string      $force_array    返回值是否强制转换为数组
 * @return  mixed       当字符串中含有指定分隔符，返回转换的数组，否则返回原字符串
 */
function str2arr($str, $delimiter = '|', $force_array = false) {
    if (strpos($str, $delimiter) !== false) {
        return explode($delimiter, $str);
    } else {
        return $force_array ? array($str) : $str;
    }
}

/**
 * 产品数组的状态解释
 * 
 * @global  array   $cardb_state    产品数组的状态数组
 * @param   int     $state          对应的state值
 * @return  string  状态名称
 */
function getCardbState($state = -1) {
    global $cardb_state;
    $st_arr = $cardb_state;
    /* $st_arr = array(
      0 => "删除",
      1 => "草稿",
      2 => "待审核",
      6=>"待审核(缺参数)",
      3 => "正常",
      7=>"正常(缺参数)",
      4 => "未通过",
      5 => "屏蔽",
      8 => "停产在售",
      9 => "停产",
      10 => "待审核(未上市)",
      11 => "正常(未上市)",
      ); */
    return $st == -1 ? $st_arr : $st_arr[$st];
}

/**
 * 产品数组的状态解释
 *
 * @global  array   $cardb_state    产品数组的状态数组
 * @param   int     $st         对应的state值
 * @return  string  状态名称
 */
function getCardbState2($st = -1) {
    global $cardb_state;
    $st_arr = $cardb_state;
    /* $st_arr = array(
      0 => "删除",
      1 => "草稿",
      2 => "待审核",
      6=>"待审核(缺参数)",
      3 => "正常",
      7=>"正常(缺参数)",
      4 => "未通过",
      5 => "屏蔽",
      8 => "停产在售",
      9 => "停产",
      10 => "待审核(未上市)",
      11 => "正常(未上市)",
      ); */
    return $st == -1 ? $st_arr : $st_arr[$st];
}

/**
 * 扩展round函数，可去除数值末尾0
 * 
 * @param   float       $float      待处理的数值
 * @param   int         $precision  小数的精度位数
 * @param   boolean     $strip      是否去除末尾的0
 * @return  mixed       处理后的数值
 */
function dround($float, $precision = 2, $strip = false) {
    $t = number_format($float, $precision, '.', '');
    if ($strip) {
        $t = rtrim(rtrim($t, '0'), '.');
    }
    return $t;
}

/**
 * 返回格式化的价格折扣信息
 * <b>与 formatDiscount相比，没有优惠/加价和单位信息</b>
 * 
 * @param   float       $highPrice      最高价格值
 * @param   float       $lowPrice       最低价格值
 * @return  string      格式化的价格字符串
 */
function getDiscount($highPrice, $lowPrice) {
    if ($lowPrice != 0) {
        $discount = round(($lowPrice / $highPrice), 3) * 10;
        return $discount;
    }
}

/**
 * 返回格式化的价格折扣信息
 * 加价，优惠，单位可以是万或元
 * 
 * @param   float   $highPrice      最高价格值
 * @param   float   $lowPrice       最低价格值
 * @return  string  格式化的价格字符串
 */
function formatDiscount($highPrice, $lowPrice) {
    $diffPrice = $highPrice - $lowPrice;
    if ($lowPrice == 0) {
        $discount = '无优惠';
    } else {
        if ($diffPrice >= 1) {
            $discount = $diffPrice . '万元';
        } elseif ($diffPrice < 1 && $diffPrice > 0) {
            $discount = (floor(10000 * $diffPrice)) . '元';
        } elseif ($diffPrice == 0) {
            $discount = '无优惠';
        } elseif ($diffPrice < 0 && $diffPrice > -1) {
            $discount = '加价' . (floor(abs($diffPrice) * 10000)) . '元';
        } else
            $discount = '加价' . abs($diffPrice) . '万元';
    }
    return $discount;
}

/**
 * 批量将GET/POST数组放入数组中
 * 
 * @param   array   $gp     GET/POST数组
 * @return  array   指定的数组
 */
function receiveArray($gp) {
    $receiver = array();
    foreach ($gp as $value) {
        $receive = ($_GET[$value] || is_numeric($_GET[$value])) ? $_GET[$value] : (($_POST[$value] || is_numeric($_POST[$value])) ? $_POST[$value] : '');
        if (strpos($value, 'id') !== false)
            $receive = intval($receive);
        $receiver[$value] = $receive;
    }
    return $receiver;
}

/**
 * javascript警示函数
 * 
 * @param   string    $Message    警示内容
 * @return  void
 */
function showMessage($Message) {
    $Message = $Message;
    echo "<script language=\"javascript\">";
    echo "    alert(\"$Message\");";
    echo "</script>";
}

/**
 * 引入指定的PHP文件
 * <b>效果同PHP的require_once</b>
 * 
 * @param   string  $name   程序文件名，不带.php
 * @param   string  $type   程序文件存放的目录名
 */
function import($name, $type = 'model') {
    $filename = SITE_ROOT . $type . "/" . $name . ".php";
    if (file_exists($filename)) {
        require_once $filename;
    } else {
        die($filename . 'not found!');
    }
}

/**
 * 解析QueryString，返回数组
 * 
 * @param   string  $queryString    URL参数的QueryString字符串
 * @return  array   解析之后返回的QueryString对应的名称=>值的数组
 */
function parseQuery($queryString) {
    $tmp = array();
    $queryString = str_replace('&amp;', '&', $queryString);
    $ele = explode('&', $queryString);
    foreach ($ele as $v) {
        list($name, $value) = explode('=', $v);
        $tmp[$name] = $value;
    }
    return $tmp;
}

/**
 * SESSION函数
 * 当第二个参数为空时，返回指定的名称的SESSION内容
 * 
 * @param   string  $name   SESSION名称
 * @param   mixed   $value  SESSION值，当参数不为空时，此值赋值给第一个参数指定的名称
 * @return  mixed   第二个参数空时，返回指定的SESSION值，不为空返回赋值成功状态
 */
function session($name, $value = '') {
    if (!is_null($value) && $value !== FALSE && $value !== '') {
        $_SESSION[COOKIE_PRE . $name] = $value;
    } else {
        return $_SESSION[COOKIE_PRE . $name];
    }
}

/**
 * 删除指定的SESSION数据
 * 
 * @param string $name SESSION名称
 */
function unset_session($name) {
    $val_name = COOKIE_PRE . $name;
    unset($_SESSION[$val_name]);
    unset($$val_name);
}

/**
 * COOKIE函数
 * 
 * <b>当第二个参数为空时，返回指定的名称的COOKIE内容</b>
 * 
 * @global  int     $timestamp      当前时间戳
 * @param   string  $name           COOKIE名称
 * @param   mixed   $value          COOKIE值
 * @param   int     $ltime          COOKIE的生存时间
 * @param   bool    $p3p            是否设置p3p头信息，允许cookie跨域操作
 * @return  mixed   第二个参数空时，返回指定的COOKIE值，不为空返回赋值成功状态
 */
function cookie($name, $value = '', $ltime = 3600, $p3p = false) {
    global $timestamp;
    if ($p3p)
        addP3PHeader();
    if ($value) {
        @setcookie(COOKIE_PRE . $name, $value, $timestamp + $ltime, '/', '.' . DOMAIN);
    } else {
        return $_COOKIE[COOKIE_PRE . $name];
    }
}

/**
 * 设置P3P头信息，允许cookie跨域操作
 * 
 * @return void
 */
function addP3PHeader() {
    header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
}

/**
 * 针对往cookie存储汉字乱码问题的编码方法
 * JS中使用unescape方法，转换即可
 * 
 * @param   mixed       $str        将字符串进行编码，同Javascript的escape方法
 * @param   mixed       $charset    指定原字符串编码，默认为GBK编码
 * @return  string      编码后的字符串
 */
function escape($str, $charset = 'GBK') {
    preg_match_all("/[\x80-\xff].|[\x01-\x7f]+/", $str, $r);
    $ar = $r[0];
    foreach ($ar as $k => $v) {
        if (ord($v[0]) < 223)
            $ar[$k] = rawurlencode($v);
        else
            $ar[$k] = "%u" . strtoupper(bin2hex(mb_convert_encoding($str[$i], "UCS-2", $charset)));
    }
    return join("", $ar);
}

/**
 * PHP版escape方法的反函数
 * 使用方法同js版本的 unescape方法
 * 
 * @param   string      $str        将escape编码后的字符串解码
 * @param   string      $charset    编码，gbk为两字节，utf-8为三
 * @return  string      解码后的原字符串
 */
function unescape($str, $charset = 'GBK') {
    $str = rawurldecode($str);
    preg_match_all("/(?:%u.{4})/", $str, $r);
    if ($r[0]) {
        foreach ($r[0] as $k => $v) {
            if (substr($v, 0, 2) == "%u") {
                $_k = mb_convert_encoding(pack("H4", substr($v, -4)), $charset, "UCS-2");
                $str = str_replace($v, $_k, $str);
            }
        }
    }
    return $str;
}

/**
 * 替换模板中指定的内容
 * 
 * @global  array       $attach_server  对应的文件服务器域名
 * @global  object      $_cache         cache对象
 * @param   array       $matches        匹配的内容数组
 * @return  string      替换之后的内容
 */
function replaceAttachServer($matches) {
    global $attach_server, $_cache;
    #var_dump($_ENV['image_bool']);
    $max = count($attach_server);
    $rand = rand(1, $max) - 1;
    $rand_server = $attach_server[$rand];
    $key = md5($matches[0]);
    if (defined('CACHE_API')) {
        $cache_key = "ib_" . $key;
        $t = $_cache->getCache($cache_key);
        if (!$t) {
            $ret = $_cache->writeCache($cache_key, $rand_server, 86400);
        } else {
            $rand_server = $t;
        }
    } else {
        if (!key_exists($key, (array) $_ENV['image_bool'])) {
            $_ENV['image_bool'][$key] = $rand_server;
        }
        $rand_server = $_ENV['image_bool'][$key];
    }


    if (strpos($matches[0], UPLOAD_DIR) !== FALSE) {
        return $matches[1] . '="' . $rand_server . "/";
    } else {
        return $matches[1] . '="' . $rand_server . "/" . $matches[2];
    }
}

/**
 * 加密内容。
 * <p>
 * 如果在config中定义了常量 ENCRYPT，使用此定义的加密方法。
 * 如果未定义，使用md5加密。
 * </p>
 * @param   string  $data   待加密的内容，默认
 * @return  string  加密后的内容
 */
function dencrypt($data) {
    if (defined('ENCRYPT')) {
        import('dcrypt.class', 'lib');
        switch (strtoupper(ENCRYPT)) {
            case 'AES':
                return dcrypt::encrypt($data, DCRYPT_MODE_AES);
                break;
            case 'DES':
                return dcrypt::encrypt($data, DCRYPT_MODE_DES);
                break;
            default:
                return dcrypt::privEncrypt($data);
                break;
        }
    } else {
        return md5($data);
    }
}

/**
 * 自定义错误处理函数
 * 
 * @param   int     $errno      错误号
 * @param   string  $errstr     错误信息字符串
 * @param   string  $errfile    错误文件名称，带路径信息
 * @param   int     $errline    错误行号
 * @return  boolean
 */
function setErrorHandler($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        return;
    }

    switch ($errno) {
        case E_USER_ERROR:
            echo "<b>ERROR</b> [$errno] $errstr<br />\n";
            echo "  Fatal error on line $errline in file $errfile";
            #echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
            echo "Aborting...<br />\n";
            exit(1);
            break;

        case E_USER_WARNING:
            echo "<b>WARNING</b> [$errline] $errstr in file $errfile<br />\n";
            break;

        case E_USER_NOTICE:
            echo "<b>NOTICE</b> [$errline] $errstr in file $errfile<br />\n";
            break;

        default:
            echo "Unknown error type: [$errline] $errstr in file $errfile<br />\n";
            break;
    }
    return true;
}

function autoloader($classname) {
    $classname = strtolower($classname);
    if (strpos($classname, 'action')) {
        $classfile = SITE_ROOT . "action" . DIRECTORY_SEPARATOR . $classname . ".php";
    } else {
        $classfile = SITE_ROOT . "model" . DIRECTORY_SEPARATOR . $classname . ".php";
    }

    if (file_exists($classfile)) {
        include_once $classfile;
    } else {
        trigger_error("class[ $classname ] not found!", E_USER_WARNING);
        exit();
    }
}

/**
 * 使用处理过单双引号，过滤\r的mb_unserialize方法就能成功反序列化了
 */
function mb_unserialize($serial_str) {
    $serial_str = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str);
    $serial_str = str_replace("\r", "", $serial_str);
    return unserialize($serial_str);
}

/**
 * 清除、去除 字符串的空格
 * @param $str
 * @return string
 */
function DeleteHtml($str) {
    $str = trim($str); //清除字符串两边的空格
    $str = preg_replace("/\t/", "", $str); //使用正则表达式替换内容，如：空格，换行，并将替换为空。
    $str = preg_replace("/\r\n/", "", $str);
    $str = preg_replace("/\r/", "", $str);
    $str = preg_replace("/\n/", "", $str);
    $str = preg_replace("/ /", "", $str);
    $str = preg_replace("/  /", "", $str);  //匹配html中的空格
    return trim($str); //返回字符串
}

$old_error_handler = set_error_handler("setErrorHandler");
spl_autoload_register('autoloader');
?>
