<?php

/**
 * dcrypt.class.php
 * encrypt & decrypt class, include DES, AES, RSA algorithm
 * $Id: dcrypt.class.php 1478 2015-11-30 08:42:14Z david $
 * @author David.Shaw <tudibao@163.com>
 */
define('DCRYPT_MODE_DES', 0);
define('DCRYPT_MODE_AES', 1);
define('DCRYPT_MODE_RSA', 2);
define('DCRYPT_ENCRYPT', 0);
define('DCRYPT_DECRYPT', 1);
define('DCRYPT_PRIV_ENCRYPT', 0);
define('DCRYPT_PRIV_DECRYPT', 1);
define('DCRYPT_PUB_ENCRYPT', 2);
define('DCRYPT_PUB_DECRYPT', 3);

class dcrypt {

    private static $mode;

    public function __construct() {
        //TODO;
    }

    /**
     * 加密/解密方法
     * 注: DES加/解密的"key"是必须参数，其它加/解密中的key和iv不是必须的
     * 
     * @param string $str 需要加/解密的字符串
     * @param int $mode 加/解密模式，必填, 0: DES, 1: AES, 2: RSA
     * @param int $type 加密/解密,必填 0: 加密, 1: 解密 
     * @param string $key 密钥, 必填
     * @param string $iv 对应DES模式中的iv
     */
    private static function crypt($str, $mode = DCRYPT_MODE_DES, $type = DCRYPT_ENCRYPT, $key = '', $iv = '') {
        if(empty($key) && !$mode) die('crypt need argument key');
        $class_file = self::getClass($mode);
        $instance = $class_name = self::$mode;
        $class_func = $type ? "decrypt" : "encrypt";

        include_once "dcrypt/" . $class_file;
        switch ($mode) {
            case DCRYPT_MODE_DES:
                $crypt = new $class_name($key, $iv);
                return $crypt->$class_func($str);
                break;
            case DCRYPT_MODE_AES:
                $crypt = new $class_name ();
                return $crypt->$class_func($str);
                break;
            case DCRYPT_MODE_RSA:
                switch ($type) {
                    case DCRYPT_PRIV_ENCRYPT:
                        return rsacrypt::privEncrypt($str);
                        break;
                    case DCRYPT_PRIV_DECRYPT:
                        return rsacrypt::privDecrypt($str);
                        break;
                    case DCRYPT_PUB_ENCRYPT:
                        return rsacrypt::pubEncrypt($str);
                        break;
                    case DCRYPT_PUB_ENCRYPT:
                        return rsacrypt::pubDecrypt($str);
                        break;

                    default:
                        die("dcrypt type error.");
                        break;
                }
                break;
        }
    }

    /**
     * AES或DES 加密方法
     * 注: DES加/解密的"key"是必须参数，其它加/解密中的key和iv不是必须的
     * 
     * @param string $str 需要加/解密的字符串
     * @param int $mode 加/解密模式，, 必填 0: DES, 1: AES
     * @param string $key 密钥, 必填
     * @param string $iv 对应DES模式中的iv
     * @see $enc_str = dcrypt::encrypt($str, DCRYPT_MODE_DES, $key);
     */
    public static function encrypt($str, $mode, $key = '', $iv = '') {
        return self::crypt($str, $mode, DCRYPT_ENCRYPT, $key, $iv);
    }

    /**
     * AES或DES 解密方法
     * 注: DES加/解密的"key"是必须参数，其它加/解密中的key和iv不是必须的
     * 
     * @param string $str 需要加/解密的字符串
     * @param int $mode 加/解密模式，, 必填 0: DES, 1: AES
     * @param string $key 密钥, 必填
     * @param string $iv 对应DES模式中的iv
     * @see $dec_str = dcrypt::decrypt($str, DCRYPT_MODE_DES, $key);
     */
    public static function decrypt($str, $mode, $key = '', $iv = '') {
        return self::crypt($str, $mode, DCRYPT_DECRYPT, $key, $iv);
    }

    /**
     * RSA 私钥加密方法
     * 
     * @param string $str 需要加/解密的字符串
     * @see $enc_str = dcrypt::privEncrypt($str);
     */
    public static function privEncrypt($str) {
        return self::crypt($str, DCRYPT_MODE_RSA, DCRYPT_PRIV_ENCRYPT);
    }

    /**
     * RSA 私钥解密方法
     * 
     * @param string $str 需要加/解密的字符串
     * @see $enc_str = dcrypt::privDecrypt($str);
     */
    public static function privDecrypt($str) {
        return self::crypt($str, DCRYPT_MODE_RSA, DCRYPT_PRIV_DECRYPT);
    }

    /**
     * RSA 公钥加密方法
     * 
     * @param string $str 需要加/解密的字符串
     * @see $enc_str = dcrypt::pubEncrypt($str);
     */
    public static function pubEncrypt($str) {
        return self::crypt($str, DCRYPT_MODE_RSA, DCRYPT_PUB_ENCRYPT);
    }

    /**
     * RSA 公钥解密方法
     * 
     * @param string $str 需要加/解密的字符串
     * @see $dec_str = dcrypt::pubDecrypt($str);
     */
    public static function pubDecrypt($str) {
        return self::crypt($str, DCRYPT_MODE_RSA, DCRYPT_PUB_DECRYPT);
    }

    /**
     * 返回具体对应的加密类文件名
     */
    private static function getClass($mode) {
        switch ($mode) {
            case 0:
                self::$mode = 'descrypt';
                break;
            case 1:
                self::$mode = 'aescrypt';
                break;
            case 2:
                self::$mode = 'rsacrypt';
                break;
            default:
                self::$mode = '';
                break;
        }

        if (self::$mode) {
            return self::$mode . '.class.php';
        } else {
            die('dcrypt mode error.');
        }
    }

}
