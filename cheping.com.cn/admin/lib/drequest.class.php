<?php

/**
 * 验证及过滤HTTP中的GET和POST数据
 * 1:int,2:float,3:email,4:url,5:string,6:quote,7:encode,8:special,9:stripHtml,10:stripUrl
 * 
 * $Id$
 * @author David.Shaw <tudibao@163.com>
 */
define('DREQUEST_INT', 1);
define('DREQUEST_FLOAT', 2);
define('DREQUEST_EMAIL', 3);
define('DREQUEST_URL', 4);
define('DREQUEST_STRING', 5);
define('DREQUEST_QUOTE', 6);
define('DREQUEST_ENCODE', 7);
define('DREQUEST_SPECIAL', 8);
define('DREQUEST_STRIPHTML', 9);
define('DREQUEST_STRIPURL', 10);
/**
 * @var int 密码强度，0:至少6位，大小写数字，1:要求6位，大或小字母+数字，2:要求至少6位，大写+小写+数字，3:至少8位，大写+小写+数字
 */
define('DREQUEST_STRONGPASSWORD', 11);

class DRequest {

    function __construct() {
        ;
    }

    function get($data = '') {
        return new DFilter($data);
    }

    function post($data = '') {
        return new DFilter($data);
    }

    function request($data = '') {
        return new DFilter($data);
    }

    function cookie($data = '') {
        return new DFilter($data);
    }

    function server($data = '') {
        return new DFilter($data);
    }

    function session($data = '') {
        return new DFilter($data);
    }

}

class DFilter {

    private $data = '';
    private $name;
    private $container;
    private $container_name;

    /**
     * 根据$data值，处理数据
     * 
     * @param string $name 变量名称
     * @param array GPC数组
     */
    public function __construct($name = '', $container = '') {
        if (!empty($container)) {
            $this->name = $name;
            $this->container_name = $container;

            switch ($container) {
                case 'POST':
                    $this->container = $_POST;
                    $this->data = $_POST[$name];
                    break;
                case 'REQUEST':
                    $this->container = $_REQUEST;
                    $this->data = $_REQUEST[$name];
                    break;
                default:
                    $this->container = $_GET;
                    $this->data = $_GET[$name];
                    break;
            }
        } else {
            $this->data = $name;
        }
    }

    /**
     * 仅用于销毁GET, POST, REQUEST数组变量
     */
    public function clean() {
        switch ($this->container_name) {
            case 'POST':
                unset($_POST[$this->name]);
                break;
            case 'REQUEST':
                unset($_REQUEST[$this->name]);
                break;
            default :
                unset($_GET[$this->name]);
                break;
        }
    }

    /**
     * 返回$this->data值
     * 
     * @param string $v 返回值为空时的默认值，默认为空
     * @return mixed $data 值
     */
    public function Val($v = '') {
        return $this->data ? $this->data : $v;
    }

    /**
     * 检查变量是否存在
     * 
     * @return boolean 存在返回true, 不存在返回false
     */
    public function Exist() {
        return array_key_exists($this->name, $this->container);
    }
    
    /**
     * 检测变量是否为空值
     * 
     * @return boolean 为空值返回true, 不为空返回false
     */
    public function IsEmpty(){
        return empty($this->container[$this->name]);
    }
    
    /**
     * 检测变量不是一个数值
     * 
     * @return boolean 不是数值返回true, 数值返回false
     */
    public function IsNaN(){
        return is_nan($this->container[$this->name]);
    }

    /**
     * 对数据进行MD5编码
     * 
     * @return string 返回MD5之后的数据
     */
    public function hash() {
        $this->data = trim($this->data);
        return $this->data ? md5($this->data) : '';
    }

    /**
     * check telephone number is valid?
     * 
     * @return boolean true/false
     */
    public function Tel() {
        return preg_match('/[+\d]{3,}-?[\d]{2,3}-?[\d]{6,8}/im', $this->data) ? $this->data : '';
    }

    /**
     * check mobile number is valid?
     * 
     * @return boolean true/false
     */
    public function Mobile() {
        return (preg_match('/1[3578][\d]{9}/im', $this->data) && strlen($this->data) == 11) ? $this->data : '';
    }

    /**
     * check email is valid?
     * 
     * @return boolean true/false
     */
    public function Email() {
        return preg_match('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}/im', $this->data) ? $this->data : '';
    }

    /**
     * 验证参数是否是数值，不是返回false或空
     * 正确返回原值
     * 
     * @param int $v 默认值，当为假时，默认返回0
     * @return string 正确返回原值，错误返回false或空
     */
    public function Int($v = 0) {
        $data = intval($this->data);
        return $data ? $data : $v;
    }

    /**
     * 验证浮点数值的合法性
     * 
     * @return string 合法返回原浮点值，错误返回flase或空
     */
    public function Float() {
        return floatval($this->data);
    }

    /**
     * 将字符串中不允许出现在html标签去掉
     * 
     * @param string $v 默认值，默认为空
     * @return string 处理完的字符串
     */
    public function String($v = '') {
        $data = $this->stripHtml(false);
        return $data ? $data : $v;
    }

    /**
     * 同 trim 函数
     * 
     * @return string
     */
    public function Trim() {
        return trim($this->data);
    }

    /**
     * 将字符串中的' " \ NULL转义
     * <p>
     * 如果php.ini中的magic_quotes_gpc = On
     * 则不转义直接返回原值
     * <p>
     * 
     * 
     * @return string 转义后的字符串
     */
    public function Quote() {
        if (get_magic_quotes_gpc()) {
            return $this->data;
        }
        return addslashes($this->data);
    }

    /**
     * 对指定字符进行html编码
     * 
     * @return string 处理完的字符串
     */
    public function SpecialChars() {
        return htmlspecialchars($this->data);
    }

    /**
     * 将字符串中不允许出现在url中的字符去掉
     * 
     * @param  int multi 0：返回一个url，1：返回多个url的数组
     * @return string 处理完的字符串
     */
    public function Url($multi = 0) {
        if (!$multi) {
            @preg_match('/((https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$])/i', $this->data, $match);
        } else {
            @preg_match_all('/((https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$])/ims', $this->data, $matches);
            foreach ($matches as $v) {
                $match[] = $v[1];
            }
        }

        return $match[1];
    }

    /**
     * 进字符串进行urlencode编码
     * 
     * @return string 处理完的字符串
     */
    public function UrlEncode() {
        return urlencode($this->data);
    }

    public function UrlDecode() {
        return urldecode($this->data);
    }

    /**
     * 正则过滤字符串
     * 
     * @param string $regex 正则表达式
     * @return string 满足正则式的，返回原值，否则返回false
     */
    public function Regex($regex) {
        if (empty($regex))
            return '';
        return preg_match($regex, $this->data) ? $this->data : '';
    }

    /**
     * 验证输入的内容是否为汉字，英文，数字组成
     * 
     * @return string 返回只有汉字，英文，数字的字符串
     */
    public function HzEnNum() {
        return $this->Regex('/^[\x{4e00}-\x{9fa5}0-9a-zA-z]+$/imu');
    }

    /**
     * 验证字符串是否是汉字字符串
     * 
     * @return string 是汉字串，返回原值，否则返回false或空
     */
    public function Hz() {
        return $this->Regex('/^[\x{4e00}-\x{9fa5}]+$/imu');
    }

    /**
     * 验证字符串是否为（大小写）英文字符串
     * 
     * @param string $v 返回值为空时的默认值，默认为空
     * @return string 正确返回原值，错误返回false或空
     */
    public function En($v = '') {
        $data = $this->Regex('/^[a-zA-Z]+$/im');
        return $data ? $data : $v;
    }

    /**
     * 验证字符串是否为数字和密码组合
     * 
     * @return bool 正确返回原值，错误返回flase或空
     */
    public function EnNum() {
        $regex = '/^[0-9a-zA-Z]+$/im';
        return $this->Regex($regex);
    }

    /**
     * 验证邮政编码
     * 
     * @param int $data 中国邮政编码
     * @return boolean true/false
     */
    public function ZipCode() {
        return $this->Regex('/^[1-6][0-9]{5}$/im');
    }

    /**
     * 日期格式必须为：年份[年/-]月分[月/-]日
     * <p>例如：2015年1月2日</p>
     * 
     * @param int $return 返回值的类型，如果true:返回年，月，日数组, false:直接返回原值，
     * @return boolean 正确返回传入的日期字符串，错误返回false
     */
    public function Date($return = false) {
        $regext = '%^([12][0-9]{3})[年/-]([01][0-9])[月/-]([0-3][0-9])[日号]?$%im';
        @preg_match($regext, $this->data, $match);
        $curr_y = date('Y');
        if (($match[1] >= 1800 && $match[1] <= ($curr_y + 3)) && ($match[2] >= 1 && $match[2] <= 12) && ($match[2] >= 1 && $match[2] <= 31)) {
            return $return ? array('year' => $match[1], 'month' => $match[2], 'day' => $match[3]) : $this->data;
        } else {
            return '';
        }
    }

    /**
     * 判断出生日期，如果有传入年龄，则和判断年龄与出生日期是否医院
     * 
     * @param int $age 年龄，选填
     * @return boolean
     */
    public function Birthday($age = '') {
        #验证日期，返回年，月，日数组，用于后面和年龄的判断
        $r = $this->Date(true);

        #如果有传入年龄，且出生日期合法，做相关验证
        if ($r['year'] && $age) {
            if ((date('Y') - $r['year']) <> intval($age)) {
                return false;
            }
        }
        return $r ? $this->data : '';
    }

    /**
     * 验证年龄数值的合法性
     * 
     * @param date $birthday 出生日期，选填
     * @return boolean
     */
    public function Age($birthday = '') {
        $data = $this->Int();
        if ($birthday && $data) {
            $br = $this->Birthday($data);
            return $br ? $data : '';
        }
        return ($data < 110 && $data > 1) ? $data : '';
    }

    /**
     * 验证密码强度
     * <p>弱密码要求6位密码，中等密码要求6位，高强度密码要求8以上且大小写、数字都要有</p>
     * 
     * @param string $password 密码原文字符串
     * @param int $need 密码强度要求，0:不要求，1弱密码，2中等强度要求,3最高级别强度要求
     * @return string 密码强度通过返回原密码，否则返回false
     */
    public function StrongPassword($need = 1) {
        #$regex = '/^[a-zA-z0-9\.\$\#\@]/im';
        switch ($need) {
            case 3:#要求至少8位，且必需含有大写字母、小写字母及数字
                $regex = '/(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])\S{8,}/';
                $r = $this->Regex($regex);
                break;
            case 2:#要求至少6位，且必需含有大写字母、小写字母及数字
                $regex = '/(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])\S{6,}/';
                $r = $this->Regex($regex);
                break;
            case 1:#要求至少6位，要求含有大写或小写字母及数字
                $regex = '/(?=\S*?[a-zA-Z])(?=\S*?[0-9])\S{6,}/';
                $r = $this->Regex($regex);
                break;
            default:#不要求密码内容，但是位数至少6位，不建议使用此等级
                $regex = '/(?=\S*?[a-zA-Z0-9])\S{6,}/';
                $r = $this->Regex($regex);
                break;
        }
        return $r ? $r : '';
    }

    /**
     * 验证身份证的合法性，合法则返回身份证串，非法返回空
     * 
     * @param int $return true返回包含出生年，月，日，及身份证的数组, false返回身份证
     * @return boolean 身份证不合法返回false，合法默认返回传入的身份证字符串
     */
    public function IdCard($return = false) {
        $data = strtoupper($this->data);
        $regex = '/^[1-6][0-9]{5}([12][0-9]{3})([01][0-9])([0-3][0-9])[0-9]{3}[0-9xX]$/im';
        $r = preg_match($regex, $data, $match);

        #身份证格式正确，则验证最后一位校验位是否正确
        if ($match[1]) {
            $check_code = $this->getIdCardCheckCode($data);
            if ($check_code == $data[17]) {
                return $return ? array('year' => $match[1], 'month' => $match[2], 'day' => $match[3], 'idcard' => $data) : $data;
            }
        }
        return '';
    }

    /**
     * 返回身份证最后一位的校验码
     * 
     * @param string $data 身份证号
     * @return char 身份证校验码
     */
    public function getIdCardCheckCode($data) {
        $map = array(1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2);
        $sum = 0;
        for ($i = 17; $i > 0; $i--) {
            $s = pow(2, $i) % 11;
            $sum += $s * $data[17 - $i];
        }
        $check_code = $map[$sum % 11];
        return $check_code;
    }

    /**
     * 去除所有Html相关的标签
     * 
     * @param string $data 要处理的字符串
     * @param boolean $special 为true时：去除非html标签的无效字符，如空字符和一些英文符号。非真值不过滤
     * @param boolean $strip_table 是否忽略table标签
     * @return string 去除Html标签后的字符串
     */
    public function stripHtml($special = 1, $strip_table = 0) {
        $data = $this->data;
        if($strip_table){
            $data = preg_replace('%<table[^>]+>(.*?)</table>%sm', '', $data);
        }
        $data = strip_tags($data);
        $data = preg_replace('/<(.*?)>/is', "", $data);
        $data = preg_replace('/&[a-z]+;/is', "", $data);
        $data = preg_replace('/&#\d+;/is', "", $data);
        $data = trim($data);
        if ($special) {
            $data = preg_replace('/\s+/is', "", $data);
            $data = preg_replace("/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\|\"|/", '', $data);
        }
        
        return $data;
    }

    /**
     * 去除字符串中的url内容
     * 
     * @param string $data 要处理的字符串
     * @return string 去除url后的字符串
     */
    public function stripUrl() {
        $data = preg_replace('/(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/im', '', $this->data);
        return $data;
    }

}
