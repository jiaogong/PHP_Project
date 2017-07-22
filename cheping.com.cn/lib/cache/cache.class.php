<?php

class cache{

	var $cachefile;
	var $cachetype;
	var $phpexit='<?php exit;?>';
  private $cache_list_name = "cache_list_name_srv";

	function cache($type='base64'){
		$this->cachetype=$type;
	}

	function getcachefile($cachename){
		$this->cachefile=SITE_ROOT.'/data/cache/'.$cachename.'.php';
	}

	function isvalid($cachename,$cachetime){
		if(0==$cachetime){
			return true;
		}
		$this->getcachefile($cachename);
		if(!is_readable($this->cachefile)||$cachetime<0){
			return false;
		}
		clearstatcache();
		return (time()-filemtime($this->cachefile))<$cachetime;
	}

	function getcache($cachename,$cachetime=0){
		$data='';
		$this->getcachefile($cachename);
		if($this->isvalid($cachename,$cachetime)){
			if($fp = @fopen($this->cachefile,'rb')) {
				if(PHP_VERSION >='4.3.0' && function_exists('file_get_contents')) {
					$data=file_get_contents($this->cachefile);
				}else{
					flock($fp,LOCK_EX);
					$data=fread($fp, filesize($this->cachefile));
					flock($fp, LOCK_UN);
					fclose($fp);
				}
				$method='decode_'.$this->cachetype;
				$data=substr($data,13);
				$data=$this->$method($data);
			}
		}
		return $data;
	}

	function writecache($cachename, $data, $cachetime=0){
		$bytes=0;
		$this->getcachefile($cachename);
		$method='encode_'.$this->cachetype;
		$data=$this->$method($data);
		$data=$this->phpexit.$data;
		if($fp = @fopen($this->cachefile,'wb')){
			if (PHP_VERSION >='4.3.0' && function_exists('file_put_contents')){
				return file_put_contents($this->cachefile,$data);
			}else{
				flock($fp, LOCK_EX);
				$bytes=fwrite($fp,$data);
				flock($fp,LOCK_UN);
				fclose($fp);
			}
		}
		return $bytes;
	}

	function removecache($cachename){
		$this->getcachefile($cachename);
		if(file_exists($this->cachefile)){
			unlink($this->cachefile);
		}
	}

	function encode_base64($data){
		return base64_encode(serialize($data));;
	}

	function decode_base64($data){
		return unserialize(base64_decode($data));
	}

	function encode_json($data){
		if(function_exists('json_encode')){
			$data=json_encode($data);
		}else{
			include_once SITE_ROOT.'/lib/json.class.php';
			$json=new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
			$data=$json->encode($data);
		}
		return $data;
	}

	function decode_json($data){
		if(function_exists('json_decode')){
			$data=json_decode($data,true);
		}else{
			include_once SITE_ROOT.'/lib/json.class.php';
			$json=new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
			$data=$json->decode($data);
		}
		return $data;
	}
  
  function registerKey($key){
    $cache_list = (array)$this->getCache($this->cache_list_name);
    if(!array_key_exists($key, $cache_list)){
      array_push($cache_list, array($key => time()));
      $this->writeCache($this->cache_list_name, $cache_list, 2592000);
      return true;
    }
    return false;
  }

}

?>