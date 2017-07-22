<?php

/**
 * memcache
 * $Id: mmcache.class.php 2 2015-06-03 04:39:17Z xiaodawei $
 */
class mmcache extends Memcache {
    #private static $instance=null;

    private $cache_list_name = "cache_list_name_srv";
    private $timestamp;

    function mmcache($mm) {
        /* if (! $instance) {
          $instance = new Memcache;
          @$instance->connect(M_SERVER, M_PORT) || die('cant connect memcached server!');
          }
          return $instance;
         */
        if ($mm['param']['persistent']) {
            $func = "pconnect";
        } else {
            $func = "connect";
        }

        @parent::$func($mm['host'], $mm['port']) || die('cant connect memcached server!');
        $this->setCompressThreshold(1000000, 0.2);
        $this->timestamp = time();
    }

    function getCache($cache_key, $cache_time = 0) {
        if($cache_key !== $this->cache_list_name){
            $cb = $this->cacheExpired($cache_key);
            if ($cb) {
                return null;
            }else{
                $cache_obj = $this->get($cache_key.M_PORT);
            }
        }else{
            $cache_obj = $this->get($cache_key);
        }
        
        #$cache_obj = $this->get($cache_key.M_PORT);
        return $cache_obj ? $cache_obj : null;
    }

    function isValid($cache_key) {
        $cache_obj = $this->getCache($cache_key);
        return $cache_obj ? true : false;
    }

    function writeCache($cache_key, $value, $cache_time = 10) {
        if (empty($value))
            return $this->removeCache($cache_key);

        $cache_obj = $this->getCache($cache_key);
        $this->registerKey($cache_key);
        $this->cacheTime($cache_key, $cache_time);
        
        if ($cache_obj) {
            return $this->replace($cache_key.M_PORT, $value, 0);
        } else {
            return $this->add($cache_key.M_PORT, $value, 0, $cache_time);
        }
    }

    function removeCache($cache_key) {
        if($cache_key !== $this->cache_list_name){
            $this->unregisterKey($cache_key);
            $this->delete($cache_key . "_ds_mmcache".M_PORT);
            return $this->delete($cache_key.M_PORT);
        }else{
            return false;
        }
    }

    function cacheTime($cache_key, $cache_time = 0) {
        $cache_key = $cache_key . "_ds_mmcache";
        $cache_obj = $this->get($cache_key.M_PORT);
        //get
        if (!$cache_time) {
            return $cache_obj;
        }
        //set
        else {
            $value = array(
                'created' => $this->timestamp,
                'expired' => $this->timestamp + $cache_time
            );
            if ($cache_obj) {
                return $this->replace($cache_key.M_PORT, $value, 0);
            } else {
                return $this->add($cache_key.M_PORT, $value, 0, $cache_time);
            }
        }
    }

    function cacheExpired($cache_key) {
        $cache_obj = $this->cacheTime($cache_key);
        if ($this->timestamp > $cache_obj['expired']) {
            return true;
        } else {
            return false;
        }
    }

    function registerKey($key) {
        $cache_list = $this->getCache($this->cache_list_name);
        if(empty($cache_list)) $cache_list = array();

        #屏蔽搜索缓存记录，量大
        if (!array_key_exists($key, $cache_list) && strpos($key, 'search') === false) {
            $tc = $cache_list;
            $tc[$key] = $this->timestamp;
            if ($cache_list) {
                $this->replace($this->cache_list_name, $tc, 0, 2592000);
            } else {
                $this->add($this->cache_list_name, $tc, 0, 2592000);
            }
            unset($tc);
            return true;
        }elseif(array_key_exists($key, $cache_list) && !empty ($cache_list)){
            $tc = $cache_list;
            $tc[$key] = $this->timestamp;
            $this->replace($this->cache_list_name, $tc, 0, 2592000);
        }
        return false;
    }

    function unregisterKey($key) {
        $cache_list = (array) $this->getCache($this->cache_list_name);
        $t = array();

        if ($cache_list && array_key_exists($key, $cache_list)) {
            foreach ($cache_list as $k => $v) {
                if ($key !== $k) {
                    $t[$k] = $v;
                }
            }
            if ($cache_list) {
                $this->replace($this->cache_list_name, $t, 0, 2592000);
            } else {
                $this->add($this->cache_list_name, $t, 0, 2592000);
            }
            unset($t);
        }
        return true;
    }

}

?>
