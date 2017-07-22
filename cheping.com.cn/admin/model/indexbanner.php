<?php

/**
 * article interface
 * $Id: indexbanner.php 1391 2015-11-23 06:56:27Z david $
 */
class indexbanner extends model {

    var $total;
    var $pic_size = array(
        '1180x400',
        '820x550',
        '360x270',
        '280x168',
    );
    var $filename_tpl = '/html/article/{Ym}/{d}/{id}.html';
    var $url_prefix;

    function __construct() {
//        $this->table_name = "cp_article";
          $this->table_name = "cp_picshow";
        
        parent::__construct();
        $this->url_prefix = array(
            7 => 'http://news.' . DOMAIN . '/',
            8 => 'http://pingce.' . DOMAIN . '/',
            10 => 'http://wenhua.' . DOMAIN . '/',
            9 => 'http://v.' . DOMAIN . '/',
        );
    }

     /**
     * 显示列表所有数据
     * @param int $where
     * @param sting $fields
     * @param int $type
     * @return int
     */
    
    function getList($where,$fields,$type=2){
        $this->where = $where;
        $this->fields = $fields;
        $this->order = array('show_index' => 'asc');
        return $this->getResult($type);
        
    }
    /*获取所有数据*/
     function getAllList($fields = "*", $where, $type = 2) {
        $this->fields = 'id, channel, show_title, show_url, show_pic, show_enable, created, update';
//        $this->fields = $fields;
        $this->where = $where;

        $res = $this->getResult($type);
        if ($res)
            return $res;
        else
            return false;
    }
    /**
     * 返回定制的日期数组
     * 
     * @param array $arr
     * @return array
     */
    function formateDate($arr) {
        foreach ($arr as $k => $v) {
            $created = $v['created'];
            $arr[$k]['ym'] = date('Ym', $created);
            $arr[$k]['d'] = date('d', $created);
        }
        return $arr;
    }

    /**
     * 首页SSI文章数据
     * 
     * @return array
     */
    function ssiIndexArticles() {
//        $this->fields = 'id, title, title2, pic, created';
        $this->fields = 'id, channel, show_title, show_url, show_pic, show_enable, created, update';
        $this->where = "pic <> '' AND ishot = 1";
        $this->order = array('updated' => 'DESC');
        $hotArticle[] = $this->getResult();
        $this->where = 'ishot <> 1';
        $this->order = array('created' => 'DESC');
        $this->limit = 6;
        $articles = $this->getResult(2);
        $articles = array(
            'hotArticle' => $this->formateDate($hotArticle),
            $this->table_name => $this->formateDate($articles)
        );
        return $articles;
    }

        /**
     * 返回查询轮播列表
     * 
     * @param string $where 查询条件
     * @param string $fields 返回的字段
     * @param int $limit 返回的记录条数
     * @param int $offset 起始的查询偏移
     * @param array $order 排序字段及排序方式
     * @param int $type 查询方式，同getResult类型
     * @return array 查询的文章记录数组
     */
    function getBannerList($where, $fields = "*", $limit = 20, $offset = 0, $order = array(), $type = 2) {
        $this->fields = "count(*)";
        $this->where = $where ? $where:"1=1";
        $this->total = $this->getResult(3);

        $this->fields = $fields ? $fields : "*";
        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;

        return $this->getResult($type);
    }
    
     //修改查询数据
    function getTag($id) {
        $this->where = "id={$id}";
        $this->fields = '*';
        return $this->getResult();
    }
    
    function getTags($tag_name) {
        $this->where = "tag_name='$tag_name'";
        $this->fields = '*';
        return $this->getResult(1);
    }
    
     //查出指定数据
    function getTagFields($fields = "*",$where,$flag=2,$order = array()){
      $this->fields = $fields;
      $this->where = $where ? $where : 1;
      $this->order = $order;
      return $this->getResult($flag);
    }
    
     function dobannermake() {
        global $local_host;
        $this->checkAuth(207);

        $name = $this->getValue('name')->String();

        #type编号说明：1="banner_index",2="banner_news",3="banner_pingce",4="banner_video",5="banner_wenhua"
        $type = $this->getValue('type')->Int();
        if (in_array($type, array(1, 2, 3, 4, 5)) !== false) {
            $str = $this->pagedate->getSomePagedata("value", "name='$name'", 3);
            if ($str) {
                $banner = unserialize($str);
            }
            if ($banner) {
                foreach ($banner as $key => $value) {
                    $banner[$key]['alt'] = str_replace(array('"', "'"), array('', ''), $value['title']);
                    $tag_list = $this->article->getArticleFields("tag_list", "id=$value[id]", 1);
                    //标签
                    $taglist = $this->tags->getTagFields("id,tag_name", "state=1 and id in($tag_list[tag_list])", 2);
                    $banner[$key]['url'] = $this->article->getRewriteUrlByUrl($banner[$key]['url']);
                    $banner[$key]['taglist'] = $taglist;
                }
            }

            $this->vars("banner", $banner);
            $tplName = 'ssi_banner_' . $name;
            $fileName = WWW_ROOT . 'ssi/ssi_banner_' . $name . '.shtml';
        }
        #下面代码无用，暂时屏蔽，不执行
        elseif (0) {
            $arr = array("banner_index", "banner_news", "banner_pingce", "banner_video", "banner_wenhua");
            foreach ($arr as $k => $v) {
                $str = $this->pagedate->getSomePagedata("value", "name='$v'", 3);
                if ($str) {
                    $banner = unserialize($str);
                }
                if ($banner) {
                    foreach ($banner as $key => $value) {
                        $banner[$key]['alt'] = str_replace(array('"', "'"), array('', ''), $value['title']);
                        $tag_list = $this->article->getArticleFields("tag_list", "id=$value[id]", 1);
                        //标签
                        $taglist = $this->tags->getTagFields("id,tag_name", "state=1 and id in($tag_list[tag_list])", 2);
                        $banner[$key]['url'] = $this->article->getRewriteUrlByUrl($banner[$key]['url']);
                        $banner[$key]['taglist'] = $taglist;
                    }
                }

                $this->vars("banner", $banner);
                $tplName = 'ssi_banner_' . $v;
                $fileName = WWW_ROOT . 'ssi/ssi_banner_' . $v . '.shtml';
            }
        }
        $html = $this->fetch($tplName);
        $html = str_replace($local_host, '', $html);
        $html = replaceArticleUrl($html);
        $html = replaceVideoUrl($html);
        $html = preg_replace('/href="(.+?)\.html([^\'">]+)/im', 'href="\1.html', $html);
        //生成文件
        $length = file_put_contents($fileName, $html);
        if (empty($length)) {
            echo 0;
        } else {
            echo 1;
        }
    }

}

?>
