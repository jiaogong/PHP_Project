<?php

/**
 * string public static function
 * $Id: dstring.class.php 2218 2016-04-22 03:28:14Z david $
 * @author David.Shaw <tudibao@163.com>
 */
class dstring {

    public function __construct() {
        die("Class string can not instantiated!");
    }

    //截取字符串
    public static function get_str($str, $len = 380) {
        $returnstr = "";
        if (strlen($str) > $len) {
            for ($i = 0; $i < $len; $i++) {
                if (ord(substr($str, $i, 1)) > 0xa0) {
                    $returnstr.=substr($str, $i, 2);
                    $i++;
                } else {
                    $returnstr.=substr($str, $i, 1);
                }
            }
            $returnstr = $returnstr;
        } else {
            $returnstr = $str;
        }
        return $returnstr;
    }

    public static function substring($str, $start = 0, $limit = 12, $charset = "utf-8") {
        if ('gbk' == strtolower($charset)) {
            $strlen = strlen($str);
            if ($start >= $strlen) {
                return $str;
            }
            $clen = 0;
            for ($i = 0; $i < $strlen; $i++, $clen++) {
                if (ord(substr($str, $i, 1)) > 0xa0) {
                    if ($clen >= $start) {
                        $tmpstr.=substr($str, $i, 2);
                    }
                    $i++;
                } else {
                    if ($clen >= $start) {
                        $tmpstr.=substr($str, $i, 1);
                    }
                }
                if ($clen >= $start + $limit) {
                    break;
                }
            }
            $str = $tmpstr;
        } else {
            $patten = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
            preg_match_all($patten, $str, $regs);
            $v = 0;
            $s = '';
            for ($i = 0; $i < count($regs[0]); $i++) {
                (ord($regs[0][$i]) > 129) ? $v += 2 : $v++;
                if($v >= $start){
                    $s .= $regs[0][$i];
                    if ($v >= $limit * 2) {
                        break;
                    }
                }
            }
            $str = $s;
        }
        return $str;
    }

    public static function hiconv($str, $to = '', $from = '', $force = false) {
        if (empty($str))
            return $str;
        if (!preg_match('/[\x80-\xff]/', $str))
            return $str; // is contain chinese char
        if (empty($to)) {
            if ('utf-8' == strtolower(SITE_CHARSET)) {
                return $str;
            }
            $to = SITE_CHARSET;
        }
        if (empty($from)) {
            $from = ('gbk' == strtolower($to)) ? 'utf-8' : 'gbk';
        }
        $to = strtolower($to);
        $from = strtolower($from);
        //$isutf8=preg_match( '/^([\x00-\x7f]|[\xc0-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xf7][\x80-\xbf]{3})+$/', $str );
        $re = strlen($str) > 6 ? '/([\xe0-\xef][\x80-\xbf]{2}){2}/' : '/[\xe0-\xef][\x80-\xbf]{2}/';
        $isutf8 = preg_match($re, $str);

        //$force = (substr($to, 0, 3) == 'utf') ? true : $force;

        if (!$force && $isutf8 && $to == 'utf-8')
            return $str;
        if (!$force && !$isutf8 && $to == 'gbk')
            return $str;

        if (function_exists('iconv')) {
            $str = iconv($from, $to, $str);
        } else {
            require_once(SITE_ROOT . '/lib/Chinese.class.php');
            $ch = new chinese($from, $to);
            if ('utf-8' == $from) {
                $str = addslashes($ch->convert(stripslashes($str)));
            } else {
                $str = $ch->convert($str);
            }
        }
        return $str;
    }

    public static function hstrlen($str, $charset = "gbk") {
        if ('gbk' == strtolower($charset)) {
            $length = strlen($str);
        } else {
            $length = floor(2 / 3 * strlen($str));
        }
        return $length;
    }

    /**
     * 统计字符串中的中文及英文字符数
     * 注：返回的统计数组中 total数组元素返回的是汉字+英文的字节数
     * 
     * @param string $string 要统计的原始字符串
     * @param string $charset 字符串编码，默认UTF-8
     * @return array 返回统计结果数组 array(string=>原字符串, hz=>中文字字符串, hz_total=>中文字符数, en_total=>英文字符数, total=>总字符字节数)
     */
    public static function strLengthInfo($string, $charset = 'utf-8') {
        $num = $charset == 'utf-8' ? 3 : 2;
        preg_match_all('/(\w+)/is', $string, $match2);
        $en = implode('', $match2[1]);
        $en_total = strlen($en);

        #preg_match_all('/([\x{2E80}-\x{FFEF}]+)/uism', $string, $match0);#cover most CJK characters
        #preg_match_all('/([\x{4e00}-\x{9fa5}]+)/ismu', $string, $match1);#only match chineses words
        $hz_all = preg_replace('/\w/is', '', $string);
        #preg_match_all('/([\xAF-\x{FFEF}]+)/uism', $string, $match0);#effect same prevoius code,faster
        $hz_byte_total = strlen($hz_all);
        $hz_total = round($hz_byte_total / $num);
        $total = $hz_byte_total + $en_total;
        return array('string' => $string, 'en' => $en, 'hz' => $hz_all, 'hz_total' => $hz_total, 'en_total' => $en_total, 'total' => $total);
    }

    public static function hstrtoupper($str) {
        if (is_array($str)) {
            foreach ($str as $key => $val) {
                $str[$key] = self::hstrtoupper($val);
            }
        } else {
            $i = 0;
            $total = strlen($str);
            $restr = '';
            for ($i = 0; $i < $total; $i++) {
                $str_acsii_num = ord($str[$i]);
                if ($str_acsii_num >= 97 and $str_acsii_num <= 122) {
                    $restr.=chr($str_acsii_num - 32);
                } else {
                    $restr.=chr($str_acsii_num);
                }
            }
        }
        return $restr;
    }

    public static function hstrtolower($string) {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string[$key] = self::hstrtolower($val);
            }
        } else {
            $string = strtolower($string);
        }
        return $string;
    }

    public static function haddslashes($string, $force = 0) {
        if (!MAGIC_QUOTES_GPC || $force) {
            if (is_array($string)) {
                foreach ($string as $key => $val) {
                    $string[$key] = self::haddslashes($val, $force);
                }
            } else {
                $string = addslashes($string);
            }
        }
        return $string;
    }

    public static function hstripslashes($string) {
        if (is_array($string)) {
            while (@list($key, $var) = @each($string)) {
                if ($key != 'argc' && $key != 'argv' && (strtoupper($key) != $key || '' . intval($key) == "$key")) {
                    if (is_string($var)) {
                        $string[$key] = stripslashes($var);
                    }
                    if (is_array($var)) {
                        $string[$key] = self::hstripslashes($var);
                    }
                }
            }
        } else {
            $string = stripslashes($string);
        }
        return $string;
    }

    public static function convercharacter($str) {
        $str = str_replace('\\\r', "", $str);
        $str = str_replace('\\\n', "", $str);
        $str = str_replace('\n', "", $str);
        $str = str_replace('\r', "", $str);
        return $str;
    }

    public static function getfirstletter($string, $type = 0, $charset = "gbk") {
        if ($type) {
            $py = '';
            for ($i = 0; $i < strlen($string); $i++) {
                if (ord($string[$i]) > 127)
                    $py .= self::getfirstletter($string[$i] . $string[++$i]);
                else
                    $py .= self::getfirstletter($string[$i]);
            }
            return $py;
        }else {
            if ($charset == 'utf-8') {
                $string = self::hiconv($string, 'gbk', 'utf-8');
            }
            $dict = array(
                'a' => 0xB0C4, 'b' => 0xB2C0, 'c' => 0xB4ED, 'd' => 0xB6E9,
                'e' => 0xB7A1, 'f' => 0xB8C0, 'g' => 0xB9FD, 'h' => 0xBBF6,
                'j' => 0xBFA5, 'k' => 0xC0AB, 'l' => 0xC2E7, 'm' => 0xC4C2,
                'n' => 0xC5B5, 'o' => 0xC5BD, 'p' => 0xC6D9, 'q' => 0xC8BA,
                'r' => 0xC8F5, 's' => 0xCBF9, 't' => 0xCDD9, 'w' => 0xCEF3,
                'x' => 0xD1B8, 'y' => 0xD4D0, 'z' => 0xD7F9,
            );
            $letter = substr($string, 0, 1);
            $letter_ord = ord($letter);
            if ($letter_ord >= 176 && $letter_ord <= 215) {
                $num = '0x' . bin2hex(substr($string, 0, 2));
                foreach ($dict as $k => $v) {
                    if ($v >= $num)
                        break;
                }
                return $k;
            }elseif (($letter_ord > 64 && $letter_ord < 91) || ($letter_ord > 96 && $letter_ord < 123)) {
                return $letter;
            } elseif ($letter >= '0' && $letter <= '9') {
                return $letter;
            } else {
                return '*';
            }
        }
    }

    public static function stripspecialcharacter($string) {
        $string = trim($string);
        $string = str_replace("&", "", $string);
        $string = str_replace("\'", "", $string);
        $string = str_replace("'", "", $string);
        $string = str_replace("&amp;amp;", "", $string);
        $string = str_replace("&amp;quot;", "", $string);
        $string = str_replace("\"", "", $string);
        $string = str_replace("&amp;lt;", "", $string);
        $string = str_replace("<", "", $string);
        $string = str_replace("&amp;gt;", "", $string);
        $string = str_replace(">", "", $string);
        $string = str_replace("&amp;nbsp;", "", $string);
        $string = str_replace("\\\r", "", $string);
        $string = str_replace("\\\n", "", $string);
        $string = str_replace("\n", "", $string);
        $string = str_replace("\r", "", $string);
        $string = str_replace("\r", "", $string);
        $string = str_replace("\n", "", $string);
        $string = str_replace("'", "&#39;", $string);
        $string = nl2br($string);
        return $string;
    }

    public static function convert_to_unicode($string, $charset = "gbk") {
        if ($charset == 'gbk') {
            $string = self::hiconv($string, 'utf-8', 'gbk');
        }
        $string = preg_replace("/([\\xc0-\\xff][\\x80-\\xbf]*)/e", "' U8'.bin2hex( \"$1\" )", self::hstrtolower($string));
        if (strlen($string) < 4) {
            $string = ' DS' . $string;
        }
        return $string;
    }

    public static function stripscript($string) {
        $pregfind = array("/<script.*>.*<\/script>/siU", '/on(mousewheel|mouseover|click|load|onload|submit|focus|blur)="[^"]*"/i');
        $pregreplace = array('', '',);
        $string = preg_replace($pregfind, $pregreplace, $string);
        return $string;
    }

    public static function wordwrap($string, $len, $d = "\n") {
        $strlen = ceil(strlen($string) / 2);
        $tmp = array();
        for ($i = 0; $i < $strlen; $i = $i + $len) {
            $tmp[] = self::substring($string, $i, $len - 1);
        }
        return implode($d, $tmp);
    }

    public static function utf8RawUrlDecode($source) {
        $decodedStr = "";
        $pos = 0;
        $len = strlen($source);
        while ($pos < $len) {
            $charAt = substr($source, $pos, 1);
            if ($charAt == '%') {
                $pos++;
                $charAt = substr($source, $pos, 1);
                if ($charAt == 'u') {
                    // we got a unicode character
                    $pos++;
                    $unicodeHexVal = substr($source, $pos, 4);
                    $unicode = hexdec($unicodeHexVal);
                    $entity = "&#" . $unicode . ';';
                    $decodedStr .= utf8_encode($entity);
                    $pos += 4;
                } else {
                    // we have an escaped ascii character
                    $hexVal = substr($source, $pos, 2);
                    $decodedStr .= chr(hexdec($hexVal));
                    $pos += 2;
                }
            } else {
                $decodedStr .= $charAt;
                $pos++;
            }
        }
        return $decodedStr;
    }

}

?>