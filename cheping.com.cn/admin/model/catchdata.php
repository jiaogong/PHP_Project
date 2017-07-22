<?php
/**
* 用于网站抓取相关程序
* 
*/
//require_once '../lib/webclient.class.php';
class CatchData extends webClient {
    private $userAgent = array(
        "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-CN; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13",
        "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.13) Gecko/20101209 Red Hat/3.6-2.el5 Firefox/3.6.13",
        "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3",
        "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)",
        "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Trident/4.0)",
        "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; WOW64; Trident/4.0)",
        "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0)",
        "Mozilla/5.0 (Windows NT 6.1; rv:2.0) Gecko/20100101 Firefox/4.0",
    );   
    public function __construct() {
        parent::__construct();
        //$this->catchResult($url);
    }
    /**
    * 获取页面所以内容
    * 
    * @param mixed $url
    */
    public function catchResult($url, $header = 1, $ref = 0) {
        $time = date("Y-m-d H:i:s");
        $dir = SITE_ROOT.'data/log';
        file::forcemkdir($dir);
        $this->setUrl($url);        
        $this->setRandAgent($this->userAgent);        
        $this->setHeaderOut($header);
        if($ref) $this->setReferer($ref);
        $this->setAcceptEncode('gzip, deflate');
        //$this->setProxy();        
        $this->getContent(FALSE);         
    }    
    /**
    * 用正则匹配出需要的内容
    * 
    * @param mixed $regular
    * @param mixed $flag 0.使用preg_match_all匹配 1.使用preg_match匹配
    */
    public function pregMatch($regular, $flag = 0) {
        $success = 0;
        if (!$flag) $success = preg_match_all($regular, $this->result, $matches);
        else $success = preg_match($regular, $this->result, $matches);
        if($success) return $matches;
        else return false;
    }  
    public function catchArticle($url, $page_flag, $preg, $conv = 0, $yicheflag = 0) {
        $parse = parse_url($url);
        $host = substr($url, 0, strrpos($url, '/'));          
        $this->catchResult($url);
        if($conv) $this->result = iconv('utf-8', 'gbk', $this->result);
        $cmatches = $this->pregMatch($preg['preg_index'], 1);
        $content = $cmatches[1];
        if($page_flag) {
            if(strpos($this->result, $page_flag) !== false) {
              $pmatches = $this->pregMatch($preg['preg_page']);
              if($pmatches) {
                  $first_page = $pmatches[2][0];
                  $first_page_url = $pmatches[1][0];
                  if($first_page == 1) { 
                      $first_page_url = $this->getPurl($host, $page_flag, $first_page_url);        
                      return $this->catchArticle($first_page_url, $page_flag, $preg, $conv);
                  }
                  foreach($pmatches[1] as $purl) {
                      $purl = $this->getPurl($host, $page_flag, $purl);
                      $this->catchResult($purl);
                      if($conv) $this->result = mb_convert_encoding($this->result, 'GBK', 'UTF-8');
                      $matches = $this->pregMatch($preg['preg_pcontent'], 1);
                      if($matches) {
                          $content .= '<hr style="page-break-after:always;border: 1px dotted #AAAAAA;font-size: 0;height: 2px;margin:10px 0px 10px 0px;">';
                          $content .= $matches[1];                      
                      }                     
                  }              
              }
            }            
        }
        if($yicheflag=='11'){
            $content = preg_replace('%<div class="newsmap">.+?</div>%sim', '', $content);
            $content = preg_replace('%<li>\s*<label>\s*销售电话：</label><span.+?</span></li>%sim', '', $content);
        }
        if($preg['preg_strip']) $content = $this->stripUrl($content, $preg['preg_strip']);
        $img = $this->downloadImg($content, $preg['preg_download']);
        if(!empty($img)) $content = str_replace($img['src'], $img['newsrc'], $content);
        return $content;
    }
    public function getPurl($host, $page_flag, $url) {
        if($page_flag == 'class="pages_n"') {
            $parse = parse_url($host);
            $purl = 'http://'.$parse['host'].$url;
        }
        else {
            $righturl = substr($url, strrpos($url, '/'));
            if(strpos($url, '/') === 0) $purl = $host.$righturl;
            else $purl = $host.'/'.$righturl;
        }
        return $purl;
    }
    public function stripUrl($content, $preg_strip) {
        foreach($preg_strip as $k => $v) {
            $strip[$k] = "\$1";
        }
        $content = preg_replace($preg_strip, $strip, $content);
        $content = preg_replace($preg_strip, $strip, $content);
        return $content;
    }                                    
    public function downloadImg($content, $preg_download) {        
        $img = array();
        $matchcount = preg_match_all($preg_download, $content, $imgmatches);
        if($matchcount) {
            foreach($imgmatches[1] as $imgsrc) {
                $this->catchResult($imgsrc, 0);
                $path = SITE_ROOT.'../attach/images/article';
                $data = date("Y/m/d");
                $path .= '/'.$data;
                file::forcemkdir($path);                                
                $file_name = substr($imgsrc, strrpos($imgsrc, '/') + 1);
                $file = $path.'/'.$file_name;
                file_put_contents($file, $this->result);
                $img['newsrc'][] = '/attach/images/article/'.$data.'/'.$file_name;
            }            
            $img['src'] = $imgmatches[1];
        }
        return $img;   
    }   
    public function saveLog($logStr, $logName) {
        $dir = SITE_ROOT . 'data/log';
        file::forcemkdir($dir);
        $file = $dir . '/' . $logName;
        file_put_contents($file, $logStr, FILE_APPEND);
    }
}

?>
