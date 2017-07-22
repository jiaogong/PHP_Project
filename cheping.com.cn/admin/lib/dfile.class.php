<?php

/**
 * Delivery file factory Class :: Unfinished
 * $Id: dfile.class.php 926 2015-10-15 06:44:25Z xiaodawei $
 * @author David.Shaw <tudibao@163.com>
 */
class dfile {

    static function &getInstance($dsnstr = null) {
        $dsnstr || die('dsn error!');
        $dsn = self::parseDsn(strtolower($dsnstr));

        switch ($dsn['type']) {
            //remote 
            case 'ftp':
                #$dsn = self::parseDsn($dsnstr);
                if (!$dsn['port'])
                    $dsn['port'] = 21;
                return new remotefile($dsn);
                break;

            //local
            case 'file':
                return new localfile($dsn);
                break;
        }
    }

    function parseDsn($str) {
        $err = false;
        $tmp = parse_url($str);
        if (count($tmp) == 1)
            return $mserver['type'] = $tmp['path'];

        $mserver = array(
            'type' => $tmp['scheme'],
            'host' => $tmp['host'],
            'port' => $tmp['port'],
            'user' => $tmp['user'],
            'pass' => $tmp['pass'],
            'param' => self::getParam($tmp['path'])
        );
        return $mserver;
    }

    function getParam($str) {
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

class remotefile {

    var $ftp;
    var $rdir;

    function remotefile($dsn) {
        #var_dump($dsn);exit;
        $this->ftp = ftp_connect($dsn['host'], $dsn['port']); // or die("Couldn't connect to {$dsn['host']}");
        @ftp_login($this->ftp, $dsn['user'], $dsn['pass']); // or die("Login user or pass incorrect");
        $this->rdir = $dsn['path'];
    }

    function dsmove($src, $dest) {
        $r = $this->dschkdir($src, $dest);
        if ($r) {
            unlink($src);
            return $r;
        } else {
            return false;
        }
    }

    function dscopy($src, $dest) {
        $_dest = $this->rdir . $dest;
        $this->dsmkdir(dirname($_dest));
        $r = ftp_put($this->ftp, $_dest, $src, FTP_ASCII);
        return $r ? $dest : false;
        ;
    }

    function dsdel($file) {
        return ftp_delete($this->ftp, $file);
    }

    function dsmkdir($dir) {
        if (!ftp_chdir($this->ftp, $dir)) {
            $this->dsmkdir(dirname($dir));
            @ftp_mkdir($this->ftp, $dir);
        }
    }

    function dscleardir($dir) {
        $dir_list = ftp_rawlist($this->ftp, $dir);
        //TODO;
    }

    function dsclose() {
        return @ftp_close($this->ftp);
    }

}

class localfile {

    var $rdir;

    function localfile($dsn) {
        #var_dump($dsn);
        $this->rdir = $dsn['path'];
    }

    function dsmove($src, $dest) {
        $this->dscopy($src, $dest);
        unlink($src);
    }

    function dscopy($src, $dest) {
        $_dest = $this->rdir . $dest;
        $r = copy($src, $_dest);
        return $r ? $dest : false;
    }

    function dsdel($file) {
        unlink($file);
    }

    function dsmkdir($dir) {
        if (!file_exists($dir)) {
            $this->dsmkdir(dirname($dir));
            mkdir($dir, 0777);
        }
    }

    function dscleardir($dir, $forceclear = false) {
        if (!is_dir($dir)) {
            return;
        }
        $directory = dir($dir);
        while ($entry = $directory->read()) {
            $filename = $dir . '/' . $entry;
            if (is_file($filename)) {
                @unlink($filename);
            } elseif (is_dir($filename) && $forceclear && $entry != '.' && $entry != '..') {
                chmod($filename, 0777);
                file::cleardir($filename, $forceclear);
                rmdir($filename);
            }
        }
        $directory->close();
    }

}

?>
