<?php

/**
 * DES encrypt and descrypt class
 * recommand require PHP5.2+
 * 
 * $Id: descrypt.class.php 1607 2015-12-17 15:49:30Z david $
 * @author David.Shaw <tudibao@163.com>
 */
class DEScrypt {

    /**
     * 密钥字符串
     * @var string 
     */
    var $key;

    /**
     * initialization vector
     * @var mixed 
     */
    var $iv;

    /**
     * Opens the module of the algorithm and the mode to be used
     * @var resource 
     */
    var $td;

    /**
     * 初始DES，及设置密码和IV值
     * 
     * @param string $key 设置密码字符串
     * @param string $iv 设置的iv值，可以为空
     */
    function __construct($key, $iv = '') {
        if (!$iv) {
            $ivArray = array(0x12, 0x34, 0x56, 0x78, 0x90, 0xAB, 0xCD, 0xEF);
            foreach ($ivArray as $v) {
                $this->iv .= chr($v);
            }
        } else {
            $this->iv = $iv;
        }
        $this->key = $key;
        $this->td = mcrypt_module_open('des', '', 'cbc', '');
        $this->key = substr($this->key, 0, mcrypt_enc_get_key_size($this->td));
        #$iv_size = mcrypt_enc_get_iv_size($td);
        #$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    }

    /**
     * DES 加密，返回移经过base64编码
     * 
     * @param string $str 待加密字符串
     * @param string $key 密钥
     * @param long $iv 偏移，缺省为12345678
     * @return string DES加密后的字符串，经过base64编码
     */
    function encrypt($str) {
        $this->createTd();
        $_str = mcrypt_generic($this->td, $str);
        mcrypt_generic_deinit($this->td);
        $enc_str = base64_encode($_str);
        return $enc_str;
    }

    /**
     * DES 解密，先base64解码，再DES解码
     * 
     * @param string $str 加密过的字符串
     * @param string $key 密钥
     * @param long $iv 偏移，缺省为12345678
     * @return string 解码之后的原始字符串
     */
    function decrypt($str) {
        $strBin = base64_decode($str);
        $this->createTd();
        $str = mdecrypt_generic($this->td, $strBin);
        $str = preg_replace( "/\p{Cc}*$/u", "", $str );
        return $str;
    }

    /**
     * 初始化 mcrypt_model
     */
    function createTd() {
        if (mcrypt_generic_init($this->td, $this->key, $this->iv) == -1) {
            die('Initialize encryption handle failure.');
        }
    }

    /**
     * 将16进制转移成2进制
     * 
     * @param string $hexData 16进制数据串
     * @return string 2进制串
     */
    function hex2bin($hexData) {
        $binData = "";
        for ($i = 0; $i < strlen($hexData); $i += 2) {
            $binData .= chr(hexdec(substr($hexData, $i, 2)));
        }
        return $binData;
    }

    /**
     * PKCS5压缩字符串
     * 
     * @param string $text 字符串
     * @param int $blocksize 长度
     * @return string 压缩后的内容
     */
    function pkcs5Pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    /**
     * 去除字符串末尾的PKCS5未文本字符
     * @param string $source    带有padding字符的字符串
     */
    function pkcs5Unpad($text) {
        $pad = ord($text {strlen($text) - 1});
        if ($pad > strlen($text))
            return false;
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad)
            return false;
        return substr($text, 0, - 1 * $pad);
    }

    function __destruct() {
        mcrypt_module_close($this->td);
    }

}
