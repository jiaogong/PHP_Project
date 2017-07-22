<?php

/**
 * cache factory class
 * @author  David.Shaw <tudibao@163.com>
 */
class dcache {

    private static $instance = null;

    /**
     * get cache instance
     * singleton method
     * 
     * @param mixed $type  缓存类型
     * @param mixed $dsn   网站缓存服务器的dsn连接串
     * @return object dcache
     */
    public static function &getInstance($dsnstr = null) {
        if (self::$instance === null) {
            $dsnstr || die('dsn error!');
            $dsn = self::parseDsn(strtolower($dsnstr));

            switch (isset($dsn['type'])) {
                case 'memcache':
                    $dsn = self::parseDsn($dsnstr);
                    require_once(SITE_ROOT . "/lib/cache/mmcache.class.php");
                    self::$instance = new mmcache($dsn);
                    break;
                case 'memcached':
                    $dsn = self::parseDsn($dsnstr);
                    require_once(SITE_ROOT . "/lib/cache/mmcached.class.php");
                    self::$instance = new mmcached($dsn);
                    break;
                default:
                    require_once(SITE_ROOT . "/lib/cache/cache.class.php");
                    self::$instance = new cache();
            }
        }
        return self::$instance;
    }

    /**
     * 解析dsn串
     * example: memcache://127.0.0.1:11211
     * @param string $str
     * @return array 包含URL信息的数组
     */
    private static function parseDsn($str) {
        $err = false;
        $mserver = $tmp = parse_url($str);
        if (count($tmp) == 1)
            return $mserver['type'] = $tmp['path'];
        
        $mserver['param'] = self::getParam($tmp['path']);
        return $mserver;
    }

    /**
     * 从URL字符串中解析参数值
     * 
     * @param string $str URL字符串
     * @return array 参数数组
     */
    private static function getParam($str) {
        if (empty($str) || trim($str) == '/')
            return null;

        $tmp = $ret = array();
        $tmp = explode("&", substr($str, 1));
        foreach ($tmp as $value) {
            @list($key, $val) = explode('=', $value);
            $ret[$key] = $val;
        }
        return $ret;
    }

}

?>
