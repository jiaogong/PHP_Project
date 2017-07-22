<?php

/**
 * AES encrypt and descrypt class
 * require PHP5.2+
 * 
 * $Id: aescrypt.class.php 1129 2015-11-01 12:05:52Z xiaodawei $
 * @author David.Shaw <tudibao@163.com>
 */
class AEScrypt {

    private $key;
    private $cipher;
    private $mode;
    private $iv_source;

    function __construct() {
        $this->setKey();
        $this->setCipher();
        $this->setIVSource();
        $this->setMode();
    }

    function encrypt($val) {
        $ivs = mcrypt_get_iv_size($this->cipher, $this->mode);
        $iv = mcrypt_create_iv($ivs, $this->iv_source);
        $val = str_pad($val, (16 * (floor(strlen($val) / 16) + (strlen($val) % 16 == 0 ? 2 : 1))), chr(16 - (strlen($val) % 16)));
        return base64_encode(mcrypt_encrypt($this->cipher, $this->key, $val, $this->mode, $iv));
    }

    function decrypt($val) {
        $val = base64_decode($val);
        $ivs = mcrypt_get_iv_size($this->cipher, $this->mode);
        $iv = mcrypt_create_iv($ivs, $this->iv_source);
        $dec = @mcrypt_decrypt($this->cipher, $this->key, $val, $this->mode, $iv);
        $str = rtrim($dec, (( ord(substr($dec, strlen($dec) - 1, 1)) >= 0 and ord(substr($dec, strlen($dec) - 1, 1)) <= 16) ? chr(ord(substr($dec, strlen($dec) - 1, 1))) : null));
        $str = preg_replace( "/\p{Cc}*$/u", "", $str );
        return $str;
    }

    function setKey($key = SKEY) {
        $this->key = $key;
    }

    function getKey() {
        $key_len = strlen($key);
        if($key_len == 32 || $key_len == 24 || $key_len == 16){
            return $this->key = $key;
        }  else {
            die("Only keys of sizes 16, 24 or 32 supported.");
        }
    }

    function setCipher($cipher = MCRYPT_RIJNDAEL_256) {
        $this->cipher = $cipher;
    }

    function getCipher() {
        return $this->cipher;
    }

    function setMode($mode = MCRYPT_MODE_ECB) {
        $this->mode = $mode;
    }

    function getMode() {
        return $this->mode;
    }

    function setIVSource($iv_source = NULL) {
        if ($iv_source === NULL) {
            if (DIRECTORY_SEPARATOR == '\\') {
                $this->iv_source = MCRYPT_RAND;
            } else {
                $this->iv_source = MCRYPT_DEV_URANDOM;
            }
        }else{
            $this->iv_source = $iv_source;
        }
    }

    function getIVSource() {
        return $this->iv_source;
    }

}
