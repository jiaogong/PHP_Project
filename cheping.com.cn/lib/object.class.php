<?php

/**
 * object base class
 * $Id: object.class.php 606 2015-08-20 03:59:37Z xiaodawei $
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
     * @param string $str 提示信息
     * @param string $type 提示类型，js或json
     * @param int $act 提示的之后的处理方式 0 无操作 1 关闭 2 返回 3 redirect 4 等于exit 
     */
    function alert($str='', $type = "js", $act = 4, $url = "") {
        switch ($type) {
            case 'js':
                if($str){
                    $new_str = "<script>alert('{$str}');</script>";
                    echo $new_str;
                }
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

                header('Content-type: text/html; charset=UTF-8');
                echo json_encode(
                        array('error' => $act, 'message' => $message, 'url' => $url)
                );
                exit;
                break;
        }
    }

}

?>
