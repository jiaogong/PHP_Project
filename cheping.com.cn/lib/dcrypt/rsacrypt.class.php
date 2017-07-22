<?php

/**
 * RSA encrypt and decrypt, static class
 * require OpenSSL lib
 * 
 * notice: 
 * if data encrypt by private key, use public key decrypt.
 * if data encrypt by public key, use private key decrypt.
 * 
 * CLI, make private key & public key command:
 * > openssl genrsa -out rsa_private_key.pem 1024
 * > openssl pkcs8 -topk8 -inform PEM -in rsa_private_key.pem -outform PEM -nocrypt -out private_key.pem
 * > openssl rsa -in rsa_private_key.pem -pubout -out rsa_public_key.pem
 * 
 * $Id: rsacrypt.class.php 882 2015-10-13 03:26:04Z xiaodawei $
 * @author David.Shaw <tudibao@163.com>
 */
class rsacrypt {

    /**
     * 私钥字符串
     * @var string  
     */
    private static $private_key = '-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQCqju+azRCG9e+VCM/1S65GRzvQvXKuIcQMf0rxJniUvFK6eXpA
JeCFiElv6T+707f6+CSCghLu6BWAuMZ/gqvi5ILj/UKfO7BeL+NQHOqLNSrDGFOk
BlIslWL5aDVyqotfrG8LmHvQ8cwuBuIvl0GSlAhSDYgO3g5YuTaaOb6p8QIDAQAB
AoGAVCqnORgbIM66xSwNG7qWLN44OWFT93R4P8aNYAWhGZz5okYSOxe1/Y9s1gof
xnvLXdEYi0LPPxBOlDAa3I/KbCXwUGJz6sc5QIY/9Eo4MTgZBCLwCoCRCuwbaUdZ
6XtxdQKofyxb4Z8fv+XvtRo/DcL53/lZU2U0hWrf5uHBRoUCQQDantZ1cBjw7Qgx
VzW3D5+dB6sGxmqlkeRs/7B8rX7Xzggm3TXqazCLE9ZKRDSuIrKQm4Ple2JSsmlG
i7qHU0pLAkEAx7hjOCQb/d7EAIW8EtkMeT2N3p73sGbnBAdTYOUW2uSpycZZMxhM
Bz8bQXwBfy8qV1Fk0C71bW5DV75rYxp3MwJAHVXW/ScvkZSc1tIW+Rt1lYKj5mLV
iKYM+rtMmU5GiPqyiVSBmZUMjHz68jg4wW0SfOkBR9fIl8Qs8DRrsSDyBQJAU/8l
o5f0Odp13q5gQiENEPSldSqwi31LzbLzCz5uVVN0YUtNeqLOXwHYibsIuh/xE9ZE
qxYE3KhSJFYOvhiEZwJBANUqZPYBZJ+2tOdqUGA1N8S+IUmkhT+g1rgMA2qNbWXU
MiD4n9dA40lAtFPy8mMhJ+cCdbJQz9DrIk5MudnnkcE=
-----END RSA PRIVATE KEY-----';

    /**
     * 公钥字符串
     * @var string 
     */
    private static $public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCqju+azRCG9e+VCM/1S65GRzvQ
vXKuIcQMf0rxJniUvFK6eXpAJeCFiElv6T+707f6+CSCghLu6BWAuMZ/gqvi5ILj
/UKfO7BeL+NQHOqLNSrDGFOkBlIslWL5aDVyqotfrG8LmHvQ8cwuBuIvl0GSlAhS
DYgO3g5YuTaaOb6p8QIDAQAB
-----END PUBLIC KEY-----';

    /**
     * oepnssl create private key
     * @var resouce 
     */
    //private $privkey;

    /**
     * oepnssl create public key
     * @var resouce 
     */
    //private $pubkey;

    function __construct() {
        
    }

    /**
     * 返回对应的私钥
     * 
     * @return string 私钥字符串
     */
    private static function getPrivateKey() {
        $privKey = (defined('PRIVATE_KEY') && PRIVATE_KEY)  ? PRIVATE_KEY : self::$private_key;
        return openssl_pkey_get_private($privKey);
    }

    /**
     * 返回对应的私钥
     * 
     * @return string 公钥字符串
     */
    private static function getPublicKey() {
        $pubKey = (defined('PUBLIC_KEY') && PUBLIC_KEY) ? PUBLIC_KEY : self::$public_key;
        return openssl_pkey_get_public($pubKey);
    }

    /**
     * 将传入的数据使用私钥加密
     * 
     * @param string $data 待加密的字符串
     * @return string 私钥加密后的字符串
     */
    public static function privEncrypt($data) {
        if (!is_string($data)) {
            return null;
        }
        return openssl_private_encrypt($data, $encrypted, self::getPrivateKey()) ? base64_encode($encrypted) : null;
    }

    /**
     * 将公钥加密过的字符串使用私钥解密
     * 
     * @param string $encrypted 公钥加密的字符串
     * @return string 解密后的原始字符串
     */
    public static function privDecrypt($encrypted = null) {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_private_decrypt(base64_decode($encrypted), $decrypted, self::getPrivateKey())) ? $decrypted : null;
    }

    /**
     * 将传入的数据使用公钥加密
     * 
     * @param string $data 待加密的字符串
     * @return string 公钥加密后的字符串
     */
    public static function pubEncrypt($data) {
        if (!is_string($data)) {
            return null;
        }
        return openssl_public_encrypt($data, $encrypted, self::getPublicKey()) ? base64_encode($encrypted) : null;
    }

    /**
     * 将私钥加密过的字符串使用公钥解密
     * 
     * @param string $encrypted 私钥加密的字符串
     * @return string 解密后的原始字符串
     */
    public static function pubDecrypt($encrypted) {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_public_decrypt(base64_decode($encrypted), $decrypted, self::getPublicKey())) ? $decrypted : null;
    }

}
