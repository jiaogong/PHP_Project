<?php

/**
 * article interface
 * $Id: article.php 1558 2015-12-08 05:36:24Z wangqin $
 */
class article extends model {

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
        $this->table_name = "cp_article";
        parent::__construct();
        $this->url_prefix = array(
            7 => 'http://news.' . DOMAIN . '/',
            8 => 'http://pingce.' . DOMAIN . '/',
            10 => 'http://wenhua.' . DOMAIN . '/',
            9 => 'http://v.' . DOMAIN . '/',
        );
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
        $this->fields = 'id, title, title2, pic, created';
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
     * 根据article_id获取文章记录
     * 
     * @param int $id 文章ID
     * @return array 文章记录数组
     */
    function getArticle($id) {
        $this->where = "id='{$id}'";
        $this->fields = '*';
        return $this->getResult();
    }

    /**
     * 获取首页文章列表
     * 
     * @param string $fields 返回的文章字段
     * @param string $where 查询条件
     * @param int $type 查询类型，同getResult内的类型
     * @param array $order 排序
     * @param int $limit 返回的记录数
     * @return array 返回的文章列表
     */
    function getIndexFootArticle($fields, $where, $type = 2, $order = '', $limit) {
        $this->tables = array(
            $this->table_name => 'a',
            'article_channel' => 'ac'
        );
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        $this->limit = $limit;
        $result = $this->joinTable($type);
        if($result) {
            foreach ($result as $k => $row) {
                $title = $row['title'] . ' ' . $row['title2'];
                $result[$k]['full_title'] = $title;
                $result[$k]['short_title'] = mb_substr($title, 0, 36, 'utf-8');
            }
        }
        return $result;
    }

    /**
     * 返回查询文章列表
     * 
     * @param string $where 查询条件
     * @param string $fields 返回的字段
     * @param int $limit 返回的记录条数
     * @param int $offset 起始的查询偏移
     * @param array $order 排序字段及排序方式
     * @param int $type 查询方式，同getResult类型
     * @return array 查询的文章记录数组
     */
    function getArticleList($where, $fields = "*", $limit = 20, $offset = 0, $order = array(), $type = 2) {
        $this->fields = "count(id)";
        $this->where = $where ? $where : 1;
        $this->total = $this->getResult(3);

        $this->fields = $fields ? $fields : "*";
        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;

        return $this->getResult($type);
    }

    /**
     * 关联文章分类表查询，返回查询文章列表
     * LeftJoin关联文章表与文章分类表
     * $this->join_condition属性为leftjoin语句的ON后面的条件，必填
     * 
     * @param string $where 查询条件
     * @param string $fields 返回的字段
     * @param int $limit 返回的记录条数
     * @param int $offset 起始的查询偏移
     * @param array $order 排序字段及排序方式
     * @param int $type 查询方式，同getResult类型
     * @return array 查询的文章记录数组
     */
    function getArticleListPage($where, $fields = "*", $limit = 20, $offset = 0, $order = array(), $type = 2) {
        $this->tables = array(
            'ca' => 'cp_article',
            'cac' => 'cp_article_category',
            'pcac' => 'cp_article_category'
        );
        $this->fields = "count(ca.id)";
        $this->join_condition = array('ca.category_id=cac.id', 'cac.parentid=pcac.id');
        $this->where = "" . $where;
        $this->total = $this->leftJoin(3, 1);
        $this->fields = $fields ? $fields : "*";
        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;

        return $this->leftJoin($type, 1);
    }

    /**
     * 自定义关联查询，返回查询结果
     * 
     * @param string $fields 返回的字段
     * @param string $where 查询条件
     * @param array $order 排序字段及排序方式
     * @param array $tables 关联表的表数组
     * @param int $type 查询方式，同getResult类型
     * @return array 返回查询的数组
     */
    function getArticles($fields, $where, $order = null, $tables = array(), $type = 2) {
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        $this->tables = $tables;
        return $this->joinTable($type);
    }

    /**
     * 根据where条件，查询并返回文章相关字段的数据
     * 
     * @param string $fields 需要返回的字段
     * @param string $where 查询条件
     * @param interger $flag 查询方法;1=返回单行结果，2=返回匹配的多行结果，3=返回单列结果，4=返回关联数组
     * @return array 文章结果数组
     */
    function getArticleFields($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }

    /**
     * 上传头图
     * @param array $file 上传的临时文件
     * @param string $dir 上传目录
     * @return string  $file_name. $fileName 图片地址名称
     */
    function uploadPic($file, $dir = 'article') {
        global $watermark_opt;
        $uploadRootDir = ATTACH_DIR . "images/$dir/";
        file::forcemkdir($uploadRootDir);
        $uploadDir = $uploadRootDir . date("Y/m/d", time()) . '/';
        file::forcemkdir($uploadDir);
        $file_name = "images/$dir/" . date("Y/m/d", time()) . '/';
        $fileName = util::random(12);
        $fileName .= '.jpg';
        move_uploaded_file($file, $uploadDir . $fileName);
        if ($dir == 'articletitle') {
            imagemark::resize($uploadDir . $fileName, "820x550", 820, 550, '', $watermark_opt);
            imagemark::resize($uploadDir . $fileName, "280x186", 280, 186, '', $watermark_opt);
            imagemark::resize($uploadDir . $fileName, "160x120", 160, 120, '', $watermark_opt);
        } else {
            imagemark::resize($uploadDir . $fileName, "1180x400", 1180, 400, '', $watermark_opt);
        }
        return $file_name . $fileName;
    }

    /**
     * 上传文章图
     * @param array $file 上传的临时文件
     * @param string $dir 上传目录
     * @return string  $file_name. $fileName 图片地址名称
     */
    function uploadarticlePic($file, $dir = 'article') {
        global $watermark_opt;
        $waterpic = SITE_ROOT . "images/watermark/waterpic.png";

        $uploadRootDir = ATTACH_DIR . "images/$dir/";
        file::forcemkdir($uploadRootDir);
        $uploadDir = $uploadRootDir . date("Y/m/d", time()) . '/';
        file::forcemkdir($uploadDir);
        $file_name = "images/$dir/" . date("Y/m/d", time()) . '/';
        $fileName = util::random(12);
        $fileName .= '.jpg';
        move_uploaded_file($file, $uploadDir . $fileName);
        //生成水印
        $ret = imagemark::resize($uploadDir . $fileName, "820x540", 820, 540, '', $watermark_opt);
        imagemark::watermark($ret['tempurl'], array('type' => 'file', 'file' => $waterpic), 3, '', $watermark_opt);
        return $fileName;
    }

    /**
     * 根据文章ID取文章详细信息
     * @param int $article_id 文章ID
     * @return array 文章数组
     */
    function getArticleById($article_id) {
        $this->tables = array(
            'cp_article' => 'ca',
            'cp_article_category' => 'cac'
        );

        $this->where = "ca.category_id=cac.id and ca.id='{$article_id}'";
        $this->fields = "ca.*,cac.parentid";
        return $this->total = $this->joinTable();
    }
    
    /**
     * 返回文章表和频道关联数据
     * 
     * @param string $where
     * @param string $fields
     * @param array $order
     * @param int $flag
     * @return array 返回数据
     */
    function getArticleAndCategory($fields, $where, $order=array(), $flag=2) {
        $this->tables = array(
            'cp_article' => 'ca',
            'cp_article_category' => 'cac'
        );
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        return $this->joinTable($flag);
    }

    /**
     * 根据文章ID取得SEO化的URL
     * 
     * @param int $article_id
     * @return url
     */
    function getRewriteUrlByAid($article_id) {
        $article = $this->getArticleById($article_id);
        $article['p_category_id'] = $article['parentid'];
        $url = $this->getRewriteUrl($article);
        return $url;
    }

    /**
     * 根据文章原始的链接，返回SEO优化的链接
     * 
     * @param string $url 文章链接
     * @return url SEO优化的文章链接
     */
    function getRewriteUrlByUrl($url) {
        @preg_match('%html/article/\d+/\d+/(\d+)\.html%im', $url, $match);
        $article_id = $match[1];
        return $article_id ? $this->getRewriteUrlByAid($article_id) : $url;
    }

    /**
     * 根据文章数据，返回文章/视频的链接
     * 如果定义rewrite，则返回url格式链接
     * 
     * @param array $article 文章数组，其中三个参数是必须的：array('id'文章ID, 'uptime'上线时间, 'p_category_id'文章父栏目ID)
     * @return string url 符合要求的链接地址
     */
    function getRewriteUrl($article) {
        global $local_host;
        $article_url = '';
        if (RWURL === 1) {
            $article_url = $this->url_prefix[$article['p_category_id']];
            if ($article['p_category_id'] <> 9) {
                $article_url .= date('Ym-d', $article['uptime']) . '-' . $article['id'] . '.html';
            } else {
                $article_url .= $article['id'] . '.html';
            }
        } else {
            $article_url = 'html/article/';
            if ($article['p_category_id'] <> 9) {
                $article_url = $local_host . $article_url . date('Ym/d', $article['uptime']) . '/' . $article['id'] . '.html';
            } else {
                $article_url = $local_host . "video.php?action=ZuiZhong&id=9&ids={$article['id']}";
            }
        }

        return $article_url;
    }

    /**
     * 返回rewrite的域名
     * 
     * @param int $pid 文章分类父ID
     * @return string 域名字符串
     */
    function getRewriteDomain($pid) {
        if (RWURL === 1) {
            return $this->url_prefix[$pid];
        } else {
            return '/';
        }
    }
    
    function getRewriteChannel($url){
        
    }

    /**
     * 图片路径处理
     * @param string $dir_pic 图片路径 例如  images/articletitle/2015/08/08/KgsyMYvjV6Zk.jpg
     * @param string $size 缩略图尺寸  例如  820*550
     * @return string $urlpic  图片返回路径
     */
    function getArticlePic($dir_pic, $size = '820x550') {
        $str = substr(strrchr($dir_pic, '/'), 1);
        $size_str = $size . $str;
        $urlpic = str_replace($str, $size_str, $dir_pic);

        return $urlpic;
    }

    /**
     * 根据文章数据，返回文章的静态文件名称
     * 
     * @param array $article 文章记录数组
     * @return string 文章静态文件名称
     */
    function getFilename($article) {
        $filename = $this->filename_tpl;
        if (strpos($filename, '{Ym}') !== FALSE) {
            $filename = str_replace('{Ym}', date('Ym', $article['created']), $filename);
        }
        if (strpos($filename, '{d}') !== FALSE) {
            $filename = str_replace('{d}', date('d', $article['created']), $filename);
        }
        if (strpos($filename, '{id}') !== FALSE) {
            $filename = str_replace('{id}', $article['id'], $filename);
        }
        return $filename;
    }

    /**
     * 根据图片名称，返回cardb_file表的记录
     * 
     * @param string $image_name 图片名称
     * @return array 图片记录
     */
    function getImageByName($image_name) {
        $cardbfile = new cardbFile();
        return $cardbfile->getFileByName($image_name);
    }

    /**
     * 修正文章图片html标签
     * 
     * @param string $article_content 文章正文内容
     * @param int $update 是否更新到文章表
     * @return string 文章正文，如果update=1返回更新的状态
     */
    function fixArticleImgTag($article_content, $update = 0) {
        
        global $local_host;
        #去除空段
        $article_content = preg_replace('%(<p[^>]*>\s*</p>)%', '', $article_content);

        #处理图说标签异常问题
        preg_match_all('%<img\s+src=".+?/\d{4}/\d{2}/\d{2}/820x540([^"]+)"[^/]+/>%sim', $article_content, $matches);
        if ($matches) {
            foreach ($matches[0] as $k => $v) {
                $image_name = $matches[1][$k];
                $image_file = $this->getImageByName($image_name);
                #echo "$image_name  == $image_alt <br>\n";
                #var_dump($image_file);
                if ($image_file['id']) {
                    #$image_path = $local_host . "images/article/" . date('Y/m/d', $image_file['created']) . "/820x540";
                    $article_content = preg_replace(
                            '%<img\s+src="(.+?' . $image_name . ')"[^/]+/>%sim', '<img class="tishi_' . $image_file['id'] . ' allview" src="\1" /> ', $article_content
                    );
                }
            }
        }

        #处理编辑上传的图片异常问题
        $article_content = preg_replace('%<img\s+src="(.+?)(\/\d{6}\/\d{2})/820x540([^"]+)"[^/]+/>%sim', '<img class="allcc" src="\1\2/820x540\3" /> ', $article_content);

        #替换部分office垃圾样式
        $article_content = str_replace(array('allview', 'class="Img"', 'class="jiao"', 'alt="" ', '<b>', '</b>', '/><br />'), array('allcc', 'class="Img allcc"', '', '', '', '', '/>'), $article_content);
        $article_content = preg_replace('/<([a-z]+) class="MsoNormal"[^>]+>/sim', '<\1>', $article_content);
        $arr = preg_match('%<span style=\"font-family:(.*?);color:(.+?);[^>]+\">(.*?)</span>%s', $article_content);
        $arrs = preg_match('%<span style=\"color:(.*?);\">(.+?)</span>%s',$article_content);
        if($arr == 1 && $arrs == 0){
            $article_content = preg_replace('%<span [^>]+>(.*?)</span>%s', '\1', $article_content);
        }else if($arr == 1 && $arrs == 1){
            $article_content = preg_replace('%<span style=\"font-family:(.*?);color:(.*?);[^>]+\">(.+?)</span>%s', '\3', $article_content);
            $res = preg_match('%<span style=\"font-family:(.*?);color:(.*?);[^>]+\">(.+?)</span>%s', $article_content);
            if($res == 1){
                $article_content = preg_replace('%<span style=\"font-family:(.*?);color:(.*?);[^>]+\">(.+?)</span>%s', '\3', $article_content);
            }
        }
        $article_content = preg_replace('/<o:p><\/o:p>/sim', '', $article_content);
        $article_content = preg_replace('%<p>\s+<img([^>]+)>\s+</p>%sim', '<p style="text-align:center;">'."\n".'<img\1></p>', $article_content);
        $article_content = preg_replace('%<p>\s*&[^<]+<img([^>]+)>\s+</p>%sim', '<p style="text-align:center;">'."\n".'<img\1></p>', $article_content);
        $article_content = preg_replace('%<p>\s*<span[^>]*>\s*<img([^>]+)>.+?</span>%sim', '<p style="text-align:center;"><img\1>', $article_content);
        $article_content = preg_replace('%<img src="'.$local_host.'([^"]+)" /> %sim', '<img class="allcc" src="'.$local_host.'\1" /> ', $article_content);
        #修正最恶心的两条不规范操作代码  ヽ(≧Д≦)ノ 
        $article_content = preg_replace('%<[^p]{2,}><img([^>]+)>\s+<[^p]{2,}>%', '<img\1>', $article_content);
        $article_content = preg_replace('%\s+<br />\s+<img([^>]+)>\s*</p>%s', "</p>\n<p style=\"text-align:center;\">\n<img\\1>\n</p>", $article_content);
        $article_content = preg_replace('%<p>\s+<img([^>]+)>\s*<br />\s+%s', "<p style=\"text-align:center;\">\n<img\\1>\n</p>\n<p>", $article_content);

        #更新文章数据
        if ($update) {
            $this->ufields['content'] = $article['content'];
            $this->where = "id='{$id}'";
            $r = $this->update();
            return $r;
        } else {
            return $article_content;
        }
    }

}

?>
