<?php

/**
 * DB factory, static reference
 * @author David.Shaw <tudibao@163.com>
 * $Id: db.php 1048 2015-10-27 01:18:30Z xiaodawei $
 */
define('DB_FETCHMODE_ASSOC', 1);
define('DB_FETCHMODE_NUM', 2);
define('DB_FETCHMODE_BOTH', 3);

class DB {

    private static $db = null;
    public function DB() {
        #die("not run!");
    }
    
    public static function &connect($dsn){
        if (self::$db === null) {
            $_dsn = self::parseDSN($dsn);
            $_dsn['dbname'] = $_dsn['param']['dbname'];

            #var_dump($_dsn);
            if(strpos($_dsn['type'], 'pdo') !== FALSE){
                $_dsn['db'] = substr($_dsn['type'], 3);
                $_dsn['type'] = 'pdo';
            }
            if(!$_dsn['type'] || !file_exists(SITE_ROOT . "lib/db/db_{$_dsn['type']}.class.php")){
                die("DB Driver: `{$_dsn['type']}` not found!");
            }

            include_once SITE_ROOT . "lib/db/db_{$_dsn['type']}.class.php";
            $classname = "db_{$_dsn['type']}";
            self::$db = new $classname($_dsn);
        }
        return self::$db;
    }
    
    public static function getMessage(){
        return self::$db->error();
    }
    
    public static function isError(){
        return self::$db->errno() ? true : false;
    }
    
    private static function parseDSN($dsn) {
        $tmp = parse_url($dsn);
        if (count($tmp) == 1)
            $_dsn['type'] = $tmp['path'];

        $_dsn = array(
            'type' => $tmp['scheme'],
            'host' => $tmp['host'],
            'port' => $tmp['port'],
            'user' => $tmp['user'],
            'pass' => $tmp['pass'],
            'param' => self::getParam($tmp['path'])
        );
        return $_dsn;
    }
    
    private static function getParam($str) {
        if (empty($str) || trim($str) == '/')
            return null;

        $tmp = $ret = array();
        $tmp = explode("&", substr($str, 1));
        $ret['dbname'] = array_shift($tmp);
        if(!$ret['dbname']) {
            die("dbname not defined!");
        }
        
        foreach ($tmp as $k => $value) {
            @list($key, $val) = explode('=', $value);
            $ret[$key] = $val;
        }
        return $ret;
    }

}
