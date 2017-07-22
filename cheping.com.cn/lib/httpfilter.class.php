<?php

/**
 * 验证及过滤HTTP中的GET和POST数据
 * 1:int,2:float,3:email,4:url,5:string,6:quote,7:encode,8:special,9:stripHtml,10:stripUrl
 * 
 * $Id: httpfilter.class.php 1551 2015-12-08 02:40:48Z david $
 * @author David.Shaw <tudibao@163.com>
 */
define('HTTP_FILTER_INT', 1);
define('HTTP_FILTER_FLOAT', 2);
define('HTTP_FILTER_EMAIL', 3);
define('HTTP_FILTER_URL', 4);
define('HTTP_FILTER_STRING', 5);
define('HTTP_FILTER_QUOTE', 6);
define('HTTP_FILTER_ENCODE', 7);
define('HTTP_FILTER_SPECIAL', 8);
define('HTTP_FILTER_STRIPHTML', 9);
define('HTTP_FILTER_STRIPURL', 10);
/**
 * @var int 密码强度，0:至少6位，大小写数字，1:要求6位，大或小字母+数字，2:要求至少6位，大写+小写+数字，3:至少8位，大写+小写+数字
 */
define('HTTP_FILTER_STRONGPASSWORD', 11);

/**
 * @var int 表示验证的字符串只能为数字
 */
define('FORM_CHECK_INT', 0);
/**
 * @var int 表示验证的字符串只能为正常字符，不含有html等相关标签元素
 */
define('FORM_CHECK_STRING', 1);
/**
 * @var int 表示验证的字符串只能为汉字
 */
define('FORM_CHECK_HZ', 2);
/**
 * @var int 表示验证的字符串只能为英文大小字母
 */
define('FORM_CHECK_EN', 3);
/**
 * @var int 表示验证的字符串需包含汉字、英文大小字母、数字
 */
define('FORM_CHECK_HZ_EN_NUM', 4);
/**
 * @var int 表示验证的字符串只能是正确的电子邮箱格式
 */
define('FORM_CHECK_EMAIL', 5);
/**
 * @var int 表示验证的字符串必须是中国合法的手机号码格式，不含+086国家号码
 */
define('FORM_CHECK_MOBILE', 6);
/**
 * @var int 表示验证的字符串必须是合法的url格式
 */
define('FORM_CHECK_URL', 7);
/**
 * @var int 表示验证的字符串必须是合法的中国邮政编码格式
 */
define('FORM_CHECK_ZIPCODE', 8);
/**
 * @var int 表示验证的字符串必须是合法的年龄范围
 */
define('FORM_CHECK_AGE', 9);
/**
 * @var int 表示验证的字符串必须是合理的出生日期
 */
define('FORM_CHECK_BIRTHDAY', 10);
/**
 * @var int 验证身份证号合法性
 */
define('FORM_CHECK_IDCARD', 11);
/**
 * @var int 表示按给定的正则式验证
 */
define('FORM_CHECK_REGEX', 99);

class HttpFilter {

    public function __construct() {
        //die('static instanced!');
    }

    /**
     * check telephone number is valid?
     * @param string $tel
     * @return boolean true/false
     */
    public function checkTel($tel) {
        return preg_match('/[+\d]{3,}-?[\d]{2,3}-?[\d]{6,8}/im', $tel);
    }

    /**
     * check mobile number is valid?
     * @param longint $mobile
     * @return boolean true/false
     */
    public function checkMobile($mobile) {
        return (preg_match('/1[3578][\d]{9}/im', $mobile) && strlen($mobile) == 11);
    }

    /**
     * check email is valid?
     * @param string $email
     * @return boolean true/false
     */
    public function checkEmail($email) {
        return preg_match('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}/im', $email);
    }

    /**
     * 对指定的数据进行过滤
     * $type定义 1:int,2:float,3:email,4:url,5:string,6:quote,7:encode,8:special,9:stripHtml,10:stripUrl
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
     * 
     * @param string $dataname 对应$_GET, $_POST等数组里的值，如$_GET['name']，则不name
     * @param string $type 数据验证类型，可以是int, float, email, url, string,quote,encode,special,stripHtml,stripUrl
     * @param mixed $default 设置为空时的默认值
     * @return mixed 删除非法字符后的内容
     */
    public function get($data, $type = 1, $default = '') {
        switch ($type) {
            case 2: $data = $this->filterFloat($data);
                break;
            case 3: $data = $this->filterEmail($data);
                break;
            case 4: $data = $this->filterUrl($data);
                break;
            case 5: $data = $this->filterString($data);
                break;
            case 6: $data = $this->filterQuote($data);
                break;
            case 7: $data = $this->filterEncode($data);
                break;
            case 8: $data = $this->filterSpecial($data);
                break;
            case 9: $data = $this->stripHtml($data);
                break;
            case 10: $data = $this->stripUrl($data);
                break;
            default : $data = $this->filterInt($data); #filterInt
                break;
        }
        return empty($data) ? $default : $data;
    }

    /**
     * 验证参数是否是数值，不是返回false或空
     * 正确返回原值
     * 
     * @param int $data 要验证的数值
     * @return string 正确返回原值，错误返回false或空
     */
    public function filterInt($data) {
        return intval($data);
    }

    /**
     * 验证浮点数值的合法性
     * 
     * @param float $data 要验证的浮点值
     * @return string 合法返回原浮点值，错误返回flase或空
     */
    public function filterFloat($data) {
        return floatval($data);
    }

    /**
     * 将字符串中不允许出现在html标签去掉
     * 
     * @param string $data 要处理的字符串
     * @return string 处理完的字符串
     */
    public function filterString($data) {
        return $this->stripHtml($data, 0);
    }

    /**
     * 验证邮件地址是否合法
     * 
     * @param string $data 要处理的字符串
     * @return string 邮件地址合法，返回原值，不合法，返回false或空
     */
    public function filterEmail($data) {
        $ret = $this->checkEmail($data);
        return $ret ? $data : $ret;
    }

    /**
     * 将字符串中的' " \ NULL转义
     * 如果php.ini中的magic_quotes_gpc = On
     * 则不转义直接返回原值
     * 
     * @param string $data 要处理的字符串
     * @return string 转义后的字符串
     */
    public function filterQuote($data) {
        if(get_magic_quotes_gpc()){
            return $data;
        }
        return addslashes($data);
    }

    /**
     * 对指定字符进行html编码
     * 
     * @param string $data 要处理的字符串
     * @return string 处理完的字符串
     */
    public function filterSpecial($data) {
        return htmlspecialchars($data);
    }
    
    /**
     * 将字符串中不允许出现在url中的字符去掉
     * 
     * @param string $data 要处理的字符串
     * @param  int multi 0：返回一个url，1：返回多个url的数组
     * @return string 处理完的字符串
     */
    public function filterUrl($data, $multi = 0) {
        if(!$multi){
            @preg_match('/((https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$])/i', $data, $match);
        }else{
            @preg_match_all('/((https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$])/ims', $data, $matches);
            foreach ($matches as $v) {
                $match[] = $v[1];
            }
        }
        
        return $match[1];
    }

    /**
     * 进字符串进行urlencode编码
     * 
     * @param string $data 要处理的字符串
     * @return string 处理完的字符串
     */
    public function filterEncode($data) {
        return urlencode($data);
    }

    /**
     * 正则过滤字符串
     * 
     * @param string $data 要处理的字符串
     * @param string $regex 正则表达式
     * @return string 满足正则式的，返回原值，否则返回false
     */
    public function filterRegex($data, $regex) {
        if (empty($regex))
            return FALSE;
        return preg_match($regex, $data) ? $data : false;
    }

    /**
     * 验证输入的内容是否为汉字，英文，数字组成
     * @param string $data
     */
    public function filterHZ_EN_Num($data) {
        return $this->filterRegex($data, '/^[\x{4e00}-\x{9fa5}0-9a-zA-z]+$/imu');
    }

    /**
     * 验证字符串是否是汉字字符串
     * 
     * @param string $data 要验证的字符串
     * @return string 是汉字串，返回原值，否则返回false或空
     */
    public function filterHZ($data) {
        return $this->filterRegex($data, '/^[\x{4e00}-\x{9fa5}]+$/imu');
    }

    /**
     * 验证字符串是否为（大小写）英文字符串
     * 
     * @param string $data 待验证的字符串
     * @return string 正确返回原值，错误返回false或空
     */
    public function filterEN($data) {
        return $this->filterRegex($data, '/^[a-zA-Z]+$/im');
    }

    /**
     * 验证字符串是否为数字和密码组合
     * 
     * @param string $data 要验证的字符串
     * @return bool 正确返回原值，错误返回flase或空
     */
    public function filterEn_Num($data){
        $regex = '/^[0-9a-zA-Z]+$/im';
        return $this->filterRegex($data, $regex);
    }
    
    /**
     * 验证邮政编码
     * 
     * @param int $data 邮政编码
     * @return boolean true/false
     */
    public function filterZipcode($data) {
        return $this->filterRegex($data, '/^[1-6][0-9]{5}$/im');
    }

    /**
     * 日期格式必须为：年份[年/-]月分[月/-]日
     * 例如：2015年1月2日
     * 
     * @param date $data 日期字符串
     * @param int $return 返回值的类型，如果true:返回年，月，日数组, false:直接返回原值，
     * @return boolean 正确返回传入的日期字符串，错误返回false
     */
    public function filterDate($data, $return = false) {
        $regext = '%^([12][0-9]{3})[年/-]([01][0-9])[月/-]([0-3][0-9])[日号]?$%im';
        @preg_match($regext, $data, $match);
        $curr_y = date('Y');
        if (($match[1] >= 1800 && $match[1] <= ($curr_y + 3)) && ($match[2] >= 1 && $match[2] <= 12) && ($match[2] >= 1 && $match[2] <= 31)) {
            return $return ? array('year' => $match[1], 'month' => $match[2], 'day' => $match[3]) : $data;
        } else {
            return false;
        }
    }

    /**
     * 判断出生日期，如果有传入年龄，则和判断年龄与出生日期是否医院
     * 
     * @param date $data 出生日期
     * @param int $age 年龄，选填
     * @return boolean
     */
    public function filterBirthday($data, $age = '') {
        #验证日期，返回年，月，日数组，用于后面和年龄的判断
        $r = $this->filterDate($data, true);

        #如果有传入年龄，且出生日期合法，做相关验证
        if ($r['year'] && $age) {
            if ((date('Y') - $r['year']) <> intval($age)) {
                return false;
            }
        }
        return $r ? $data : false;
    }
    
    /**
     * 验证年龄数值的合法性
     * 
     * @param int $data 年龄数值
     * @param date $birthday 出生日期，选填
     * @return boolean
     */
    public function filterAge($data, $birthday = '') {
        $data = $this->filterInt($data);
        if($birthday && $data){
            $br = $this->filterBirthday($birthday, $data);
            return $br ? $data : false;
        }
        return ($data < 110 && $data > 1) ? $data : false;
    }

    /**
     * 验证密码强度
     * 弱密码要求6位密码，中等密码要求6位，高强度密码要求8以上且大小写、数字都要有
     * 
     * @param string $password 密码原文字符串
     * @param int $need 密码强度要求，0:不要求，1弱密码，2中等强度要求,3最高级别强度要求
     * @return string 密码强度通过返回原密码，否则返回false
     */
    public function filterStrongPassword($password, $need = 1){
        #$regex = '/^[a-zA-z0-9\.\$\#\@]/im';
        $password = $this->filterEn_Num($password);
        if($password){
            switch ($need) {
                case 3:#要求至少8位，且必需含有大写字母、小写字母及数字
                    $regex = '/(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])\S{8,}/';
                    $r = $this->filterRegex($password, $regex);
                    break;
                case 2:#要求至少6位，且必需含有大写字母、小写字母及数字
                    $regex = '/(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])\S{6,}/';
                    $r = $this->filterRegex($password, $regex);
                    break;
                case 1:#要求至少6位，要求含有大写或小写字母及数字
                    $regex = '/(?=\S*?[a-zA-Z])(?=\S*?[0-9])\S{6,}/';
                    $r = $this->filterRegex($password, $regex);
                    break;
                default:#不要求密码内容，但是位数至少6位，不建议使用此等级
                    $regex = '/(?=\S*?[a-zA-Z0-9])\S{6,}/';
                    $r = $this->filterRegex($password, $regex);
                    break;
            }
            return $r ? $r : false;
        }
        return false;
    }
    
    /**
     * 验证身份证的合法性
     * 
     * @param string $data 身份证
     * @param int $return true返回包含出生年，月，日，及身份证的数组, false返回身份证
     * @return boolean 身份证不合法返回false，合法默认返回传入的身份证字符串
     */
    public function filterIdCard($data, $return = false) {
        $data = strtoupper($data);
        $regex = '/^[1-6][0-9]{5}([12][0-9]{3})([01][0-9])([0-3][0-9])[0-9]{3}[0-9xX]$/im';
        $r = preg_match($regex, $data, $match);

        #身份证格式正确，则验证最后一位校验位是否正确
        if ($match[1]) {
            $check_code = $this->getIdCardCheckCode($data);
            if ($check_code == $data[17]) {
                return $return ? array('year' => $match[1], 'month' => $match[2], 'day' => $match[3], 'idcard' => $data) : $data;
            }
        }
        return false;
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
     * @param boolean $special 去除非html标签的特殊字符
     * @param boolean $strip_table 在处理之前，去除table标签及里面的内容
     * @return string 去除Html标签后的字符串
     */
    public function stripHtml($data, $special = 1, $strip_table = 0) {
        if($strip_table){
            $data = preg_replace('%<table[^>]+>(.*?)</table>%sm', '', $data);
        }
        $data = strip_tags($data);
        $data = preg_replace('/<(.*?)>/is', "", $data);
        $data = preg_replace('/&[a-z]+;/is', "", $data);
        $data = preg_replace('/&#\d+;/is', "", $data);
        $data = trim($data);
        if($special){
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
    public function stripUrl($data) {
        $data = preg_replace('/(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/im', '', $data);
        return $data;
    }

    /**
     * 表单POST数据验证
     * 未验证的类型，待添加
     * 
     * array $formDataArr = array('表单名称' => array('验证类型', '是否必填，如果为空，则有值时验证合法性，无值不验证', '当失败时返回的错误提示'));
     * @example array array('username' => array(FORM_CHECK_HZ_EN_NUM, 'required', '用户名非法或为空！'));
     * @param array $formDataArr 表单数组及说明
     * @return array 验证结果，成功array('status' => 1,...), 失败array('status' => 0,....)
     */
    public function filterFormPost($formDataArr = array()) {
        return $this->filterForm($formDataArr, 'post');
    }

    /**
     * 表单GET数据验证
     * 未验证的类型，待添加
     * 
     * array $formDataArr = array('表单名称' => array('验证类型', '是否必填，如果为空，则有值时验证合法性，无值不验证', '当失败时返回的错误提示'));
     * @example array array('username' => array(FORM_CHECK_HZ_EN_NUM, 'required', '用户名非法或为空！'));
     * @param array $formDataArr 表单数组及说明
     * @return array 验证结果，成功array('status' => 1,...), 失败array('status' => 0,....)
     */
    public function filterFormGet($formDataArr = array()) {
        return $this->filterForm($formDataArr, 'get');
    }

    public function filterForm($formDataArr, $method = 'get') {
        $datapool = $method == 'get' ? $_GET : $_POST;
        foreach ($formDataArr as $k => $v) {
            //$datapool[$k];
            if (!empty($datapool[$k])) {
                switch ($v[0]) {
                    case FORM_CHECK_INT:
                        $ret = $this->filterInt($datapool[$k]);
                        break;
                    case FORM_CHECK_HZ:
                        $ret = $this->filterHZ($datapool[$k]);
                        break;
                    case FORM_CHECK_EN:
                        $ret = $this->filterEN($datapool[$k]);
                        break;
                    case FORM_CHECK_HZ_EN_NUM:
                        $ret = $this->filterHZ_EN_Num($datapool[$k]);
                        break;
                    case FORM_CHECK_EMAIL:
                        $ret = $this->filterEmail($datapool[$k]);
                        break;
                    case FORM_CHECK_URL:#TODO;;
                        $ret = $this->filterUrl($datapool[$k]);
                        break;
                    case FORM_CHECK_ZIPCODE:
                        $ret = $this->filterZipcode($datapool[$k]);
                        break;
                    case FORM_CHECK_IDCARD:
                        $ret = $this->filterIdCard($datapool[$k]);
                        break;
                    case FORM_CHECK_AGE:
                        $ret = $this->filterAge($datapool[$k]);
                        break;
                    case FORM_CHECK_BIRTHDAY:
                        $ret = $this->filterBirthday($datapool[$k]);
                        break;
                    default : #FORM_CHECK_STRING
                        $ret = $this->filterString($datapool[$k]);
                        break;
                }
            }
            #当需要对值对待验证:需有值，但无值返回false, 有值，但是验证失败，返回false
            if ((!empty($datapool[$k]) && empty($ret) ) || ($v[1] == 'required' && empty($datapool[$k])) ) {
                $message = $v[2] ? $v[2] : '空或非法';
                return array('status' => 0, 'name' => $k, 'message' => $message);
            }
        }
        return array('status' => 1, 'return' => $datapool);
    }

}
