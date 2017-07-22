<?php

/**
 * object base class
 * $Id: object.class.php 1210 2015-11-12 02:56:12Z xiaodawei $
 * @author David.Shaw <tudibao@163.com>
 */
class object {

    protected $data = array();
    protected $timestamp;

    function __construct() {
        $this->timestamp = time();
    }

    function __set($name, $value) {
        $this->data[$name] = $value;
    }

    function __get($name) {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
                'Undefined property via __get(): ' . $name .
                ' in ' . $trace[0]['file'] .
                ' on line ' . $trace[0]['line'], E_USER_WARNING);
        return null;
    }

    function __isset($name) {
        return isset($this->data[$name]);
    }

    function __unset($name) {
        unset($this->data[$name]);
    }

    function import($name, $type = 'model') {
        $filename = SITE_ROOT . $type . "/" . $name . ".php";
        if (file_exists($filename)) {
            require_once $filename;
        } else {
            die($filename . 'not found!');
        }
    }

    /**
     * alert
     * 
     * @param mixed $str
     * @param mixed $type
     * @param mixed $act 0 无操作 1 关闭 2 返回 3 redirect 4 等于exit 
     * @example 如果为array(
      type => 'js',
      message => 'xx',
      url => 'url',
      act => 3,
      urly => 'xx',
      urln => 'xx',
      );
     * @return void
     */
    function alert($str, $type = "js", $act = 4, $url = "") {
        #处理数组参数
        if (is_array($str) && !empty($str)) {
            $arr = $str;
            unset($str);

            $type = $arr['type'];
            $str = $arr['message'];
            $url = $arr['url'];
            $act = $arr['act'];
        }

        switch ($type) {
            case 'js':
                @header('Content-type: text/html; charset=' . SITE_CHARSET);
                $new_str = "<script>alert('{$str}');</script>";
                echo $new_str;
                switch ($act) {
                    case 0:
                        break;
                    case 1:
                        echo "<script>window.close();</script>";
                        break;
                    case 2:
                        echo "<script>history.go(-1);</script>";
                        break;
                    case 3:
                        echo "<script>location.href='{$url}';</script>";
                        break;
                    case 4:
                        exit();
                        break;
                }
                exit;
                break;

            case 'json':
                if (strtolower(SITE_CHARSET) !== 'utf-8') {
                    $message = iconv(SITE_CHARSET, 'utf-8', $str);
                } else
                    $message = trim($str);

                @header('Content-type: text/html; charset=UTF-8');
                echo json_encode(
                        array('error' => $act, 'message' => $message, 'url' => $url)
                );
                exit;
                break;

            case 'confirm':
                @header('Content-type: text/html; charset=' . SITE_CHARSET);
                $js_str = "
            <script>
              if(window.confirm('{$arr['message']}')){
                location.href='{$arr['urly']}';
              }else{
                location.href='{$arr['urln']}';
              }
            </script>
          ";
                echo $js_str;
                exit;
                break;
        }
    }
    
    /**
     * 根据name返回指定的$_GET值。
     * 如果要处理的数据为数组，后接->Val()方法。
     * 
     * @param string $name 要处理的数据为数组时，请后接->Val()方法
     * @return \DFilter 对象，需要后接->Val()或->Int()等方法
     */
    function getValue($name = ''){
        return new DFilter($name, 'GET');
    }
    
    /**
     * 根据name返回指定的$_POST值。
     * 如果要处理的数据为数组，后接->Val()方法。
     * 
     * @param string $name 要处理的数据为数组时，请后接->Val()方法
     * @return \DFilter 对象，需要后接->Val()或->Int()等方法
     */
    function postValue($name = ''){
        return new DFilter($name, 'POST');
    }
    
    /**
     * 根据name返回指定的$_REQUEST值。
     * 如果要处理的数据为数组，后接->Val()方法。
     * 
     * @param string $name 要处理的数据为数组时，请后接->Val()方法
     * @return \DFilter 对象，需要后接->Val()或->Int()等方法
     */
    function requestValue($name = ''){
        return new DFilter($name, 'REQUEST');
    }
    
    /**
     * 传指定的值，进行处理。
     * 如果要处理的数据为数组，后接->Val()方法。
     * 
     * @param string $data 要处理的数据为数组时，请后接->Val()方法
     * @return \DFilter 对象，需要后接->Val()或->Int()等方法
     */
    function addValue($data = ''){
        return new DFilter($data);
    }

}

?>
