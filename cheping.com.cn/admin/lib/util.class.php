<?php

/**
 * usual function
 * $Id: util.class.php 1815 2016-03-30 03:20:59Z david $
 * @author David.Shaw <tudibao@163.com>
 */
class util {

    public function util() {
        die("Class util can not instantiated!");
    }

    /**
     * random
     * @param int $length
     * @return string $hash
     */
    public static function random($length = 6, $type = 0) {
        $hash = '';
        $chararr = array(
            'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz',
            'ABCDEFGH0123456789',
            '0123456789',
            'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
        );
        $chars = $chararr[$type];
        $max = strlen($chars) - 1;
        PHP_VERSION < '4.2.0' && mt_srand((double) microtime() * 1000000);
        for ($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }

    /**
     * image_compress
     * @param string $url,$prefix;int  $width,$height
     * @return array $result
     */
    public static function image_compress($url, $prefix = 's_', $width = 80, $height = 60, $suffix = '', $strip_str = '') {
        global $lang;
        $result = array('result' => false, 'tempurl' => '', 'msg' => 'something Wrong');
        if (!file_exists($url)) {
            $result['msg'] = $url . 'img is not exist';
            return $result;
        }
        $urlinfo = pathinfo($url);
        $ext = strtolower($urlinfo['extension']);
        if ($strip_str)
            $urlinfo['basename'] = str_replace($strip_str, '', $urlinfo['basename']);
        $tempurl = $urlinfo['dirname'] . '/' . $prefix . substr($urlinfo['basename'], 0, -1 - strlen($ext)) . $suffix . '.' . $ext;
        if (!util::isimage($ext)) {
            $result['msg'] = 'img must be gif|jpg|jpeg|png';
            return $result;
        }
        $ext = ($ext == 'jpg') ? 'jpeg' : $ext;
        $createfunc = 'imagecreatefrom' . $ext;
        $imagefunc = 'image' . $ext;
        if (function_exists($createfunc)) {
            list($actualWidth, $actualHeight) = getimagesize($url);
            if ($actualWidth < $width && $actualHeight < $height) {
                copy($url, $tempurl);
                $result['tempurl'] = $tempurl;
                $result['result'] = true;
                return $result;
            }
            if ($actualWidth < $actualHeight) {
                $width = round(($height / $actualHeight) * $actualWidth);
            } else {
                $height = round(($width / $actualWidth) * $actualHeight);
            }
            $tempimg = imagecreatetruecolor($width, $height);
            $img = $createfunc($url);
            imagecopyresampled($tempimg, $img, 0, 0, 0, 0, $width, $height, $actualWidth, $actualHeight);
            $result['result'] = ($ext == 'png') ? $imagefunc($tempimg, $tempurl) : $imagefunc($tempimg, $tempurl, 80);

            imagedestroy($tempimg);
            imagedestroy($img);
            if (file_exists($tempurl)) {
                $result['tempurl'] = $tempurl;
            } else {
                $result['tempurl'] = $url;
            }
        } else {
            copy($url, $tempurl);
            if (file_exists($tempurl)) {
                $result['result'] = true;
                $result['tempurl'] = $tempurl;
            } else {
                $result['tempurl'] = $url;
            }
        }
        return $result;
    }

    /**
     * 根据扩展名判断是否允许的图片格式
     * 
     * @param string $extname
     * @return true or false
     */
    public static function isimage($extname) {
        return in_array($extname, array('jpg', 'jpeg', 'png', 'gif'));
    }

    /**
     * getfirstimg
     * @param string $content
     * @return string $tempurl
     */
    public static function getfirstimg($string) {
        preg_match("/<img.+?src=[\\\\]?\"(.+?)[\\\\]?\"/i", $string, $imgs);
        if (isset($imgs[1])) {
            return $imgs[1];
        } else {
            return "";
        }
    }

    public static function getimagesnum($string) {
        preg_match_all("/<img.+?src=[\\\\]?\"(.+?)[\\\\]?\"/i", $string, $imgs);
        return count($imgs[0]);
    }

    /**
     * formatfilesize
     *
     * @param int $size
     * @return string $_format
     */
    public static function formatfilesize($filename) {
        $size = filesize($filename);
        if ($size < 1024) {
            $_format = $size . "B";
            return $_format;
        } elseif ($size < 1024 * 1024) {
            $_format = round($size / 1024, 2) . "KB";
            return $_format;
        } elseif ($size < 1024 * 1024 * 1024) {
            $_format = round($size / (1024 * 1024), 2) . "MB";
            return $_format;
        }
    }

    /**
     * getip
     *
     * @return string
     */
    public static function getip() {
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } else if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $ip = getenv('REMOTE_ADDR');
        } else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        preg_match("/[\d\.]{7,15}/", $ip, $temp);
        $ip = $temp[0] ? $temp[0] : 'unknown';
        unset($temp);
        return $ip;
    }

    /**
     * 返回验证码图片
     * 
     * @param string $code 要生成的验证码字符串
     */
    public static function makecode($code) {
        $codelen = strlen($code);
        $im = imagecreate(50, 20);
        $font_type = SITE_ROOT . "/style/default/ant2.ttf";
        $bgcolor = ImageColorAllocate($im, 235, 245, 255); //近白色
        $iborder = ImageColorAllocate($im, 70, 80, 90); //近黑色

        $fontColor = ImageColorAllocate($im, 164, 164, 164);
        $fontColor1 = ImageColorAllocate($im, 20, 80, 255); //近蓝色
        $fontColor2 = ImageColorAllocate($im, 50, 50, 50); //近黑色
        $fontColor3 = ImageColorAllocate($im, 255, 80, 20); //近红色
        $fontColor4 = ImageColorAllocate($im, 20, 200, 20); //近绿色

        $lineColor = ImageColorAllocate($im, 110, 220, 220); //淡蓝色

        for ($j = 3; $j <= 16; $j = $j + 4)
            imageline($im, 2, $j, 48, $j, $lineColor);
        for ($j = 2; $j < 52; $j = $j + (mt_rand(3, 6)))
            imageline($im, $j, 2, $j - 6, 18, $lineColor);
        imagerectangle($im, 0, 0, 49, 19, $iborder);
        $strposs = array();
        for ($i = 0; $i < $codelen; $i++) {
            if (function_exists("imagettftext")) {
                $strposs[$i][0] = $i * 10 + 6;
                $strposs[$i][1] = mt_rand(15, 18);
                imagettftext($im, 11, 5, $strposs[$i][0] + 1, $strposs[$i][1] + 1, $fontColor, $font_type, $code[$i]);
            } else {
                imagestring($im, 5, $i * 10 + 6, mt_rand(2, 4), $code[$i], $fontColor2);
            }
        }
        for ($i = 0; $i < $codelen; $i++) {
            if (function_exists("imagettftext")) {
                $fontC = ${'fontColor' . mt_rand(1, 4)};
                imagettftext($im, 11, 5, $strposs[$i][0], $strposs[$i][1], $fontC, $font_type, $code[$i]);
            }
        }
        header("Pragma:no-cache\r\n");
        header("Cache-Control:no-cache\r\n");
        header("Expires:0\r\n");
        if (function_exists("imagejpeg")) {
            header("content-type:image/jpeg\r\n");
            imagejpeg($im);
        } else {
            header("content-type:image/png\r\n");
            imagepng($im);
        }
        ImageDestroy($im);
    }

    /**
     * 通过fscoket方法实现get
     * demo:
     *  $referer = 'http://mai.bitauto.com/all/detail-93.html';
     *  $url = 'http://mai.bitauto.com/goodsdetail.aspx?action=GetCarInfo&carId=1135';
     *  $cookie = 'ASP.NET_SessionId=2rn1wo0rhvukm3jspdqtz1e5';
     * 
     *  $httpheader = array(
     * 	'url' => $url,
     * 	'useragent' => 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0',
     * 	'x-requested-with' => 'XMLHttpRequest',
     * 	'referer' => $referer,
     * 	'cookie' => $cookie,
     *  );
     *  echo sock_get($httpheader, 0);
     */
    public static function dget($param, $gzip = 0) {
        $data = '';
        $info = parse_url($param['url']);
        $fp = fsockopen($info["host"], 80, $errno, $errstr, 3);
        $head = "GET " . $info['path'] . "?" . $info["query"] . " HTTP/1.1\r\n";
        $head .= "Host: " . $info['host'] . "\r\n";
        $head .= $param['useragent'] ? "User-Agent: {$param['useragent']}\r\n" : "";
        $head .= "Accept: */*\r\n";
        $head .= "Accept-Language: zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3\r\n";
        $head .= $gzip ? "Accept-Encoding: gzip, deflate\r\n" : "";

        $head .= $param['x-requested-with'] ? "X-Requested-With: {$param['x-requested-with']}\r\n" : "";
        $head .= $param['referer'] ? "Referer: {$param['referer']}\r\n" : "";
        $head .= $param['cookie'] ? "Cookie: {$param['cookie']}\r\n" : "";
        #$head .= "Connection: keep-alive\r\n";
        $head .= "Connection: Close\r\n";
        $head .= "\r\n";
        $write = fputs($fp, $head);
        while (!feof($fp)) {
            $data .= fgets($fp, 4096);
        }
        fclose($fp);
        list($h, $d) = explode("\r\n\r\n", $data);

        if ($gzip) {
            $d = gzdecode($d);
        }
        return $d;
    }

    #if (!public static function_exists('gzdecode')) {     

    public static function gzdecode($data) {
        $flags = ord(substr($data, 3, 1));
        $headerlen = 10;
        $extralen = 0;
        $filenamelen = 0;
        if ($flags & 4) {
            $extralen = unpack('v', substr($data, 10, 2));
            $extralen = $extralen[1];
            $headerlen += 2 + $extralen;
        }
        if ($flags & 8) // Filename     
            $headerlen = strpos($data, chr(0), $headerlen) + 1;
        if ($flags & 16) // Comment     
            $headerlen = strpos($data, chr(0), $headerlen) + 1;
        if ($flags & 2) // CRC at end of file     
            $headerlen += 2;
        $unpacked = @gzinflate(substr($data, $headerlen));
        if ($unpacked === FALSE)
            $unpacked = $data;
        return $unpacked;
    }

    #}

    public static function is_mem_available($mem) {
        $limit = trim(ini_get('memory_limit'));
        if (empty($limit))
            return true;
        $unit = strtolower(substr($limit, -1));
        switch ($unit) {
            case 'g':
                $limit = substr($limit, 0, -1);
                $limit *= 1024 * 1024 * 1024;
                break;
            case 'm':
                $limit = substr($limit, 0, -1);
                $limit *= 1024 * 1024;
                break;
            case 'k':
                $limit = substr($limit, 0, -1);
                $limit *= 1024;
                break;
        }
        if (function_exists('memory_get_usage')) {
            $used = memory_get_usage();
        }
        if ($used + $mem > $limit) {
            return false;
        }
        return true;
    }

    public static function strcode($string, $action = 'ENCODE') {
        $key = substr(md5($_SERVER["HTTP_USER_AGENT"] . PP_KEY), 8, 18);
        $string = $action == 'ENCODE' ? $string : base64_decode($string);
        $len = strlen($key);
        $code = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $k = $i % $len;
            $code .= $string[$i] ^ $key[$k];
        }
        $code = $action == 'DECODE' ? $code : base64_encode($code);
        return $code;
    }

    /**
     * 检测给出IP是否为内网Ip
     * @param <type> $ip
     * @return <type> 是内网IP 返回TRUE
     */
    public static function is_private_ip($ip = '') {
        if (empty($ip)) {
            $ip = $_SERVER['SERVER_ADDR'];
        } else {
            $ip = gethostbyname($ip);
        }

        $i = explode('.', $ip);
        if ($i[0] == 127)
            return true;
        if ($i[0] == 10)
            return true;
        if ($i[0] == 172 && $i[1] > 15 && $i[1] < 32)
            return true;
        if ($i[0] == 192 && $i[1] == 168)
            return true;
        return false;
    }

    public static function getmicrotime() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float) $sec);
    }

    /**
     * 取字符串拼音
     * 
     * @param string $_String
     * @param int $_Len 1，字符串首字母, 2,全拼， 3，汉字拼音缩写
     * @param string $_Code 字符串编辑，默认为：gb2312
     * @return string 拼音
     */
    public static function Pinyin($_String, $_Len = 1, $_Code = 'utf-8') {
        $_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha" .
                "|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|" .
                "cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er" .
                "|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui" .
                "|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang" .
                "|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang" .
                "|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue" .
                "|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne" .
                "|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen" .
                "|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang" .
                "|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|" .
                "she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|" .
                "tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu" .
                "|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you" .
                "|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|" .
                "zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo|ou|x|q|h|x|r";

        $_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990" .
                "|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725" .
                "|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263" .
                "|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003" .
                "|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697" .
                "|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211" .
                "|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922" .
                "|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468" .
                "|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664" .
                "|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407" .
                "|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959" .
                "|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652" .
                "|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369" .
                "|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128" .
                "|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914" .
                "|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645" .
                "|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149" .
                "|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087" .
                "|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658" .
                "|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340" .
                "|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888" .
                "|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585" .
                "|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847" .
                "|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055" .
                "|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780" .
                "|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274" .
                "|-10270|-10262|-10260|-10256|-10254|-9559|-6704|-6421|-5445|-4923|-4445";
        $_TDataKey = explode('|', $_DataKey);
        $_TDataValue = explode('|', $_DataValue);

        $_Data = (PHP_VERSION >= '5.0') ? array_combine($_TDataKey, $_TDataValue) : util::_Array_Combine($_TDataKey, $_TDataValue);
        arsort($_Data);
        reset($_Data);

        if ($_Code != 'gb2312')
            $_String = util::_U2_Utf8_Gb($_String);
        $_Res = '';
        for ($i = 0; $i < strlen($_String); $i++) {
            $_P = ord(substr($_String, $i, 1));
            if ($_P > 160) {
                $_Q = ord(substr($_String, ++$i, 1));
                $_P = $_P * 256 + $_Q - 65536;
            }

            if ($_Len == 1) {
                return strtoupper(substr(util::_Pinyin($_P, $_Data), 0, 1));
            } elseif ($_Len == 3) {
                $_Res .= substr(util::_Pinyin($_P, $_Data), 0, 1);
            } else {
                $_Res .= util::_Pinyin($_P, $_Data);
            }

            /* $_Res .= util::_Pinyin($_P, $_Data);
              if($_Len == 1){
              $_Res = strtoupper($_Res[0]);
              return $_Res;
              } */
        }
        return preg_replace("/[^a-zA-Z0-9]*/", '', $_Res);
    }

    public static function _Pinyin($_Num, $_Data) {
        if ($_Num > 0 && $_Num < 160)
            return chr($_Num);
        elseif ($_Num < -20319 || $_Num > -4445)
            return '';
        else {
            foreach ($_Data as $k => $v) {
                if ($v <= $_Num)
                    break;
            }
            return $k;
        }
    }

    public static function _U2_Utf8_Gb($_C) {
        $_String = '';
        if ($_C < 0x80)
            $_String .= $_C;
        elseif ($_C < 0x800) {
            $_String .= chr(0xC0 | $_C >> 6);
            $_String .= chr(0x80 | $_C & 0x3F);
        } elseif ($_C < 0x10000) {
            $_String .= chr(0xE0 | $_C >> 12);
            $_String .= chr(0x80 | $_C >> 6 & 0x3F);
            $_String .= chr(0x80 | $_C & 0x3F);
        } elseif ($_C < 0x200000) {
            $_String .= chr(0xF0 | $_C >> 18);
            $_String .= chr(0x80 | $_C >> 12 & 0x3F);
            $_String .= chr(0x80 | $_C >> 6 & 0x3F);
            $_String .= chr(0x80 | $_C & 0x3F);
        }
        return iconv('UTF-8', 'GB2312', $_String);
    }

    public static function _Array_Combine($_Arr1, $_Arr2) {
        for ($i = 0; $i < count($_Arr1); $i++)
            $_Res[$_Arr1[$i]] = $_Arr2[$i];
        return $_Res;
    }

    public static function getUserAgent($ua) {
        $ret = array();

        #check os
        if (strpos($ua, 'Windows') !== false) {
            if (strpos($ua, 'Windows NT 5.1') !== false) {
                $ret['os'] = 'winxp';
            } elseif (strpos($ua, 'Windows NT 6.0') !== false) {
                $ret['os'] = 'vista';
            } elseif (strpos($ua, 'Windows NT 6.1') !== false) {
                $ret['os'] = 'win7';
            } elseif (strpos($ua, 'Windows NT 6.2') !== false) {
                $ret['os'] = 'win8';
            } elseif (strpos($ua, 'Windows NT 6.3') !== false) {
                $ret['os'] = 'win8.1';
            } elseif (strpos($ua, 'Windows NT 10.0') !== false) {
                $ret['os'] = 'win10';
            } elseif (strpos($ua, 'Windows NT 5.1') !== false) {
                $ret['os'] = 'win2000';
            } elseif (strpos($ua, 'Windows ME') !== false) {
                $ret['os'] = 'winme';
            } elseif (strpos($ua, 'Windows 98') !== false) {
                $ret['os'] = 'win98';
            } else {
                $ret['os'] = 'win other';
            }
        } elseif (strpos($ua, 'Android') !== false) {
            $ret['os'] = 'Android';
        } elseif (strpos($ua, 'Linux') !== false) {
            $ret['os'] = 'Linux';
        } elseif (strpos($ua, 'Mac') !== false) {
            $ret['os'] = 'Mac';
        } elseif (strpos($ua, 'Solaris') !== false) {
            $ret['os'] = 'Solaris';
        } elseif (strpos($ua, 'FreeBSD') !== false) {
            $ret['os'] = 'FreeBSD';
        } elseif (strpos($ua, 'iOS') !== false) {
            $ret['os'] = 'iOS';
        } else {
            $ret['os'] = 'other';
        }

        #check browser
        if (strpos($ua, 'Opera') !== false) {
            $ret['browser'] = 'opera';
        } elseif (strpos($ua, 'Edge') !== false) {
            $ret['browser'] = 'Edge';
            preg_match('%Edge/([\d.]+)%si', $ua, $match);
            $ret['browserver'] = $match[1];
        } elseif (strpos($ua, 'Firefox') !== false) {
            $ret['browser'] = 'firefox';
            preg_match('%firefox/([\d.]+)%si', $ua, $match);
            $ret['browserver'] = $match[1];
        } elseif (strpos($ua, 'MSIE') !== false) {
            $ret['browser'] = 'ie';
            preg_match('/MSIE\s+([\d.]+)/si', $ua, $match);
            $ret['browserver'] = ($ret['os'] == 'win7' && $match[1] == '7.0') ? '8.0' : $match[1];
        } elseif (strpos($ua, 'Chrome') !== false) {
            $ret['browser'] = 'chrome';
            preg_match('%Chrome/([\d.]+)%si', $ua, $match);
            $ret['browserver'] = $match[1];
        } elseif (strpos($ua, 'Konqueror') !== false) {
            $ret['browser'] = 'konqueror';
        } elseif (strpos($ua, 'MQQBrowser') !== false) {
            $ret['browser'] = 'MQQBrowser';
            preg_match('%MQQBrowser/([\d.]+)%si', $ua, $match);
            $ret['browserver'] = $match[1];
        } elseif (strpos($ua, 'Googlebot') !== false) {
            $ret['os'] = 'Googlebot';
            preg_match('%Googlebot/([\d.]+)%si', $ua, $match);
            $ret['browser'] = $ret['browserver'] = $match[1];
        } elseif (strpos($ua, 'Baiduspider') !== false) {
            $ret['os'] = 'Baiduspider';
            $ret['browser'] = $ret['browserver'] = '';
        } elseif (strpos($ua, 'UCWEB') !== false) {
            preg_match('%UCWEB/([\d.]+)%si', $ua, $match);
            $ret['browser'] = 'UCWEB';
            $ret['browserver'] = $match[1];
        } elseif (strpos($ua, 'Safari') !== false) {
            $ret['browser'] = 'safari';
            preg_match('%Version/([\d.]+)%si', $ua, $match);
            $ret['browserver'] = $match[1];
        } elseif (strpos($ua, 'Mobile Safari') !== false) {
            $ret['browser'] = 'Mobile Safari';
            preg_match('%Version/([\d.]+)%si', $ua, $match);
            $ret['browserver'] = $match[1];
        } else {
            $ret['browser'] = 'other';
        }
        return $ret;
    }
    
    /**
     * 允许外部站点访问/调用本站JS，若传入具体域名，为安全起见，先添加$trust_domain数组到config.php中
     * <p>
     * $trust_domain = array(
     *  'http://xxxx.com', 'http://aaaa.com'
     * )
     * </p>
     * 
     * <b>
     * 该函数建议放到执行的代码最上面，防止header infomation modified
     * </b>
     * 
     * @param mixed $domain ‘*’表示允许任意外部域名访问，空值则判断请求的URL中域名是否存在于trust_domain数组中
     * @return void
     */
    public static function allowCORS($domain = '') {
        global $trust_domain;
        $domain = $domain == '*' ? $domain : util::getRefererHost();
        
        if(!empty($domain)){
            header("Access-Control-Allow-Origin:{$domain}");
            header('Access-Control-Allow-Credentials:true');
            header('Access-Control-Allow-Methods:GET, POST, OPTIONS');
        }else{
            return ;
        }
    }
    
    /**
     * 获取HTTP_REFERER地址的主机信息，含http://协议头字符串
     * 
     * @return mixed 成功返回匹配的主机字符串，失败返回false
     */
    public static function getRefererHost(){
        if($_SERVER['HTTP_REFERER']){
            $url_info = parse_url($_SERVER['HTTP_REFERER']);
            return $url_info['scheme'] . '://' . $url_info['host'];
        }else{
            return false;
        }
    }
    
    /**
     * 发送邮件
     * 基于sock发送邮件
     * 
     * @param mixed $mail
     * 参数说明：
     * $mail['subject'] 邮件标题
     * $mail['message'] 邮件正文
     * $mail['email_to'] 接收邮件的邮件地址，多个地址用半角,号分隔
     * $mail['html'] 不为空时，代表邮件正文html格式，否则为文本格式
     * 
     * require:
     * $mail_setting = array();
     * $mail_setting['maildelimiter']  1:\n结束,2:\r结束
     * $mail_setting['mailusername'] 邮件中显示的发件人名称
     * $mail_setting['mailauth'] 是否用户名，密码使用邮件，验证
     * $mail_setting['mailserver'] SMTP服务器地址
     * $mail_setting['mailport'] SMTP服务器端口
     * $mail_setting['mailauth_username']  发件箱账号
     * $mail_setting['mailauth_password'] 发件箱密码
     * $mail_setting['mailfrom'] 发件箱完整地址
     */
    public static function sendmail(
    $mail = array()
    ) {
        global $mail_setting;

        if (!$fp = fsockopen($mail_setting['mailserver'], $mail_setting['mailport'], $errno, $errstr, 30)) {
            return false;
        }

        $maildelimiter = $mail_setting['maildelimiter'] == 1 ? "\r\n" : ($mail_setting['maildelimiter'] == 2 ? "\r" : "\n");
        $mailusername = isset($mail_setting['mailusername']) ? $mail_setting['mailusername'] : 1;
        $sitename = SITE_NAME;
        $mail['subject'] = '=?' . SITE_CHARSET . '?B?' . base64_encode(str_replace("\r", '', str_replace("\n", '', $mail['subject']))) . '?=';
        $mail['message'] = chunk_split(base64_encode(str_replace("\r\n.", " \r\n..", str_replace("\n", "\r\n", str_replace("\r", "\n", str_replace("\r\n", "\n", str_replace("\n\r", "\r", $mail['message'])))))));

        $email_from = $mail['frommail'] == '' ? '=?' . SITE_CHARSET . '?B?' . base64_encode($sitename) . "?= <{$mail_setting['maildefault']}>" : (preg_match('/^(.+?) \<(.+?)\>$/', $email_from, $from) ? '=?' . SITE_CHARSET . '?B?' . base64_encode($from[1]) . "?= <{$from[2]}>" : $mail['frommail']);

        foreach (explode(',', $mail['email_to']) as $touser) {
            $tousers[] = preg_match('/^(.+?) \<(.+?)\>$/', $touser, $to) ? ($mailusername ? '=?' . SITE_CHARSET . '?B?' . base64_encode($to[1]) . "?= <$to[2]>" : $to[2]) : $touser;
        }

        $mail['email_to'] = implode(',', $tousers);
        $headers = "From: $email_from{$maildelimiter}X-Priority: 3{$maildelimiter}X-Mailer: BingoCar {$maildelimiter}MIME-Version: 1.0{$maildelimiter}Content-type: text/" . ($mail['html'] ? 'html' : 'plain') . "; charset=" . SITE_CHARSET . "{$maildelimiter}Content-Transfer-Encoding: base64{$maildelimiter}";
        $mail_setting['mailport'] = $mail_setting['mailport'] ? $mail_setting['mailport'] : 25;
        stream_set_blocking($fp, true);

        $lastmessage = fgets($fp, 512);
        if (substr($lastmessage, 0, 3) != '220') {
            return false;
        }

        fputs($fp, ($mail_setting['mailauth'] ? 'EHLO' : 'HELO') . " BingoCar\r\n");
        $lastmessage = fgets($fp, 512);
        if (substr($lastmessage, 0, 3) != 220 && substr($lastmessage, 0, 3) != 250) {
            return false;
        }

        while (1) {
            if (substr($lastmessage, 3, 1) != '-' || empty($lastmessage)) {
                break;
            }
            $lastmessage = fgets($fp, 512);
        }

        if ($mail_setting['mailauth']) {
            fputs($fp, "AUTH LOGIN\r\n");
            $lastmessage = fgets($fp, 512);
            if (substr($lastmessage, 0, 3) != 334) {
                return false;
            }

            fputs($fp, base64_encode($mail_setting['mailauth_username']) . "\r\n");
            $lastmessage = fgets($fp, 512);
            if (substr($lastmessage, 0, 3) != 334) {
                return false;
            }

            fputs($fp, base64_encode($mail_setting['mailauth_password']) . "\r\n");
            $lastmessage = fgets($fp, 512);
            if (substr($lastmessage, 0, 3) != 235) {
                return false;
            }

            $email_from = $mail_setting['mailfrom'];
        }

        fputs($fp, "MAIL FROM: <" . preg_replace("/.*\<(.+?)\>.*/", "\\1", $email_from) . ">\r\n");
        $lastmessage = fgets($fp, 512);
        if (substr($lastmessage, 0, 3) != 250) {
            fputs($fp, "MAIL FROM: <" . preg_replace("/.*\<(.+?)\>.*/", "\\1", $email_from) . ">\r\n");
            $lastmessage = fgets($fp, 512);
            if (substr($lastmessage, 0, 3) != 250) {
                return false;
            }
        }

        $email_tos = array();
        foreach (explode(',', $mail['email_to']) as $touser) {
            $touser = trim($touser);
            if ($touser) {
                fputs($fp, "RCPT TO: <" . preg_replace("/.*\<(.+?)\>.*/", "\\1", $touser) . ">\r\n");
                $lastmessage = fgets($fp, 512);
                if (substr($lastmessage, 0, 3) != 250) {
                    fputs($fp, "RCPT TO: <" . preg_replace("/.*\<(.+?)\>.*/", "\\1", $touser) . ">\r\n");
                    $lastmessage = fgets($fp, 512);
                    return false;
                }
            }
        }

        fputs($fp, "DATA\r\n");
        $lastmessage = fgets($fp, 512);
        if (substr($lastmessage, 0, 3) != 354) {
            return false;
        }

        $headers .= 'Message-ID: <' . gmdate('YmdHs') . '.' . substr(md5($mail['message'] . microtime()), 0, 6) . rand(100000, 999999) . '@' . $_SERVER['HTTP_HOST'] . ">{$maildelimiter}";

        fputs($fp, "Date: " . gmdate('r') . "\r\n");
        fputs($fp, "To: " . $mail['email_to'] . "\r\n");
        fputs($fp, "Subject: " . $mail['subject'] . "\r\n");
        fputs($fp, $headers . "\r\n");
        fputs($fp, "\r\n\r\n");
        fputs($fp, "{$mail['message']}\r\n.\r\n");
        $lastmessage = fgets($fp, 512);
        if (substr($lastmessage, 0, 3) != 250) {
            return false;
        }

        fputs($fp, "QUIT\r\n");
        return true;
    }
}

?>