<?php

/**
 * 文章表model
 * $Id: article.php 2933 2016-06-06 09:29:26Z cuiyuanxin $
 */
class article extends model {

    var $url_prefix;
    var $total;

    /**
     * 文章数据model析构方法，定义文章表cp_article
     */
    function __construct() {
        $this->table_name = "cp_article";
        parent::__construct();
    }
    
    function getSelect($fields = '*', $where, $type = 2){
        $this->fields = $fields;
        $this->where = $where;
        return $this->getResult($type);
    }

    /**
     * 关联article=>ca表，artcile_category=>cac表进行查询
     * 返回满足条件的文章及文章分类信息
     * 
     * @param string $where 关联条件的条件
     * @param int $limit 需要返回的数据条数，默认返回20条记录
     * @param int $offset 对应数据的起始偏移，默认从第一条记录开始
     * @param array $order 查询排序条件
     * @param int $type 查询类型，同getResult参数，默认返回多条记录
     * @return mixed 返回查询到的数据，失败返回false
     */
    function getArticle($where, $limit = 20, $offset = 0, $order = array(), $type = 2) {
        $this->tables = array(
            'cp_article' => 'ca',
            'cp_article_category' => 'cac'
        );

        $this->where = $where;
        $this->fields = "count(ca.id)";
        $this->total = $this->joinTable(3);

        $this->fields = "ca.id,ca.source,ca.relative_title,ca.relative_url,ca.title,ca.title2,ca.title3,ca.content,ca.chief,ca.pic,ca.type_id,ca.ishot,ca.tag_list,ca.hot_pic,ca.series_list,ca.state,ca.uptime,ca.created,ca.updated,ca.category_id,cac.id cacid,cac.category_name,cac.path,cac.parentid";
        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;
        $res = $this->joinTable($type);
        //echo $this->sql;
        if ($res)
            foreach ($res as $key => $val) {
                $this->table_name = "cp_tags";
                $this->where = "id in($val[tag_list])";
                $this->fields = "id,tag_name";
                $this->order = "";
                $this->limit = 1;
                $tag_name = $this->getResult(2);
                if ($tag_name) {
                    foreach ($tag_name as $k => $v) {
                        $res[$key][tag_name][$k][id] = $v[id];
                        $res[$key][tag_name][$k][tag_name] = $v[tag_name];
                    }
                }
                $this->table_name = "cardb_series";
                $this->where = "series_id in($val[series_list]) AND state in(3,8)";
                $this->fields = "series_name,series_id";
                $this->order = "";
                $this->limit = 1;
                $series_name = $this->getResult(2);
                $res[$key][series_name] = $series_name;
            }
        if ($res)
            return $res;
        else
            return false;
    }

    //查询文章的标题
    function getTitle($where) {
        $this->ufields = "*";
        $this->where = $where;
        return $this->getResult();
    }

    /**
     * 关联article=>ca表，artcile_category=>cac表进行查询
     * 返回满足条件的文章及文章分类信息
     * 
     * @param string $where 关联条件的条件
     * @param int $limit 需要返回的数据条数，默认返回20条记录
     * @param int $offset 对应数据的起始偏移，默认从第一条记录开始
     * @param array $order 查询排序条件
     * @param int $type 查询类型，同getResult参数，默认返回多条记录
     * @return mixed 返回查询到的数据，失败返回false
     */
    function getArticles($where, $fields, $limit = 20, $offset = 0, $order = array(), $type = 2) {
        $this->tables = array(
            'cp_article' => 'ca',
            'cp_article_category' => 'cac'
        );

        $this->where = $where;
        $this->fields = "count(ca.id)";
        $this->total = $this->joinTable(3);

        $this->fields = $fields;
        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;
        $res = $this->joinTable($type);

        if ($res)
            return $res;
        else
            return false;
    }

    /**
     * 查询文章表
     * 返回满足条件的记录数组
     * 
     * @param string $fields 返回的字段
     * @param string $where 查询的条件
     * @param int $flag 查询类型，同getResult参数
     * @param int $offset 对应数据的起始偏移
     * @param int $limit 需要返回的数据条数
     * @return array 查询到的记录数组
     */
    function getlist($fields, $where, $flag, $offset = Null, $limit = Null) {
        $this->where = "count(*)";
        $this->total = $this->getResult(3);

        $this->ufields = $fields;
        $this->where = "$where";
        if ($limit) {
            $this->limit = $limit;
        }
        if ($offset) {
            $this->offset = $offset;
        }
        $return = $this->getResult($flag);
        return $return;
    }

    /**
     * 调用getList方法
     * 
     * @param string $fields 返回的字段
     * @param string $where 查询的条件
     * @param int $flag 查询类型，同getResult参数
     * @return array 查询到的记录数组
     */
    function getlists($fields, $where, $flag, $offset = Null, $limit = Null) {
        return $this->getlist($fields, $where, $flag, $offset, $limit);
    }

    /**
     * 统计分类文章总数
     * @param string $where 查询条件
     * @return array 满足条件的多条记录数组
     */
    function getcount($where) {
        $this->fields = "count(id) num";
        $this->where = "$where";
        return $this->total = $this->getResult(2);
    }

    /**
     * 根据文章ID取文章详细信息
     * 
     * @param int $article_id 文章ID
     * @return array 文章数组
     */
    function getArticleById($article_id) {
        $this->reset();
        $this->tables = array(
            'cp_article' => 'ca',
            'cp_article_category' => 'cac'
        );
        $this->where = "ca.category_id=cac.id and ca.id='{$article_id}'";
        $this->fields = "ca.*,cac.parentid";
        return $this->total = $this->joinTable();
    }

    /**
     * 根据文章ID取得SEO化的URL
     * 
     * @param int $article_id
     * @return url 文章页url地址
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
        return $this->getRewriteUrlByAid($article_id);
    }

    /**
     * 根据文章数据，返回文章/视频的链接
     * 如果定义rewrite，则返回url格式链接
     * 
     * @param array $article 文章数组，其中三个参数是必须的：array('id'文章ID, 'uptime'更新时间, 'p_category_id'文章父栏目ID)
     * @return string url 符合要求的链接地址
     */
    function getRewriteUrl($article) {
        global $local_host;
        $article_url = '';
        if (RWURL === 1) {
            $this->url_prefix = array(
                7 => 'http://news.' . DOMAIN . '/',
                8 => 'http://pingce.' . DOMAIN . '/',
                10 => 'http://wenhua.' . DOMAIN . '/',
                9 => 'http://v.' . DOMAIN . '/',
            );
            $article_url = $this->url_prefix[$article['p_category_id']];
            if ($article['p_category_id'] <> 9) {
                $article_url .= date('Ym-d', $article['uptime']) . '-' . $article['id'] . '.html';
            } else {
                $article_url .= $article['id'] . '.html';
            }
        } else {
            $article_url = '/html/article/';
            if ($article['p_category_id'] <> 9) {
                $article_url .= date('Ym/d', $article['uptime']) . '/' . $article['id'] . '.html';
            } else {
                $article_url = $local_host . "video.php?action=ZuiZhong&id=9&ids={$article['id']}";
            }
        }

        return $article_url;
    }

    /**
     * 图片路径处理
     * @param type $dir_pic 图片路径 例如  images/articletitle/2015/08/08/KgsyMYvjV6Zk.jpg
     * @param type $size 缩略图尺寸  例如  820*550
     * @return type $urlpic  图片返回路径
     */
    function getArticlePic($dir_pic, $size = '820x550') {
        $str = substr(strrchr($dir_pic, '/'), 1);
        $size_str = $size . $str;
        $urlpic = str_replace($str, $size_str, $dir_pic);

        return $urlpic;
    }

    /**
     * 关联文章分类表查询，返回查询文章列表
     * 
     * @param string $where 查询条件
     * @param string $fields 返回的字段
     * @param int $limit 返回的记录条数
     * @param int $offset 起始的查询偏移
     * @param array $order 排序字段及排序方式
     * @param int $type 查询方式，同getResult类型
     * @return array 查询的文章记录数组
     */
    function getArticleListPage($where, $fields = "*", $order = array(), $type = 2) {
        $this->tables = array(
            'ca' => 'cp_article',
            'cac' => 'cp_article_category', //2级  parentid非0
            'pcac' => 'cp_article_category', //1级  parentid=0
            'us' => 'admin_user'
        );

        $this->where = "ca.category_id=cac.id and cac.parentid=pcac.id and (ca.author = us.realname OR ca.author = us.nickname) and " . $where;
        $this->fields = $fields ? $fields : "*";
        $this->order = $order;

        return $this->joinTable($type, 1);
    }

    /**
     * app接口调用
     * 
     * @param string $where 查询条件
     * @param string $fields 返回的字段
     * @param int $flag 查询方式，同getResult类型
     * @param int $offset 对应数据的起始偏移
     * @param int $limit 需要返回的数据条数
     * @return array 查询的文章记录数组
     */
    function getAr($where, $fields, $flag, $offset = Null, $limit = Null) {
        $this->tables = array(
            'cp_article' => 'ca',
            'cp_article_category' => 'cac'
        );
        $this->where = $where;
        $this->fields = 'count(ca.id)';
        $this->total = $this->joinTable(3);

        $this->fields = $fields;
        if ($limit) {
            $this->limit = $limit;
        }
        if ($offset) {
            $this->offset = $offset;
        }
        return $this->joinTable($flag);
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

        $result = $this->getResult($type);
        $this->reset();
        return $result;
    }

    /**
     * 根据文章标签，取得相应的文章列表
     * 
     * @param string $tagname 文章标签
     * @param int $limit 显示文章条数
     * @param array $order 排序字段及排序方式
     * @return array 文章列表数组
     */
    function getArticleByTagname($tagname, $limit = 20, $offset = 0, $order = array()) {
        $this->tables = array(
            'cp_article' => 'a',
            'cp_article_tags' => 't'
        );
        $this->where = "a.state=3 and a.id=t.article_id AND t.tag_name='{$tagname}'";
        $this->fields = 'count(a.id)';
        $this->limit = 1;
        $this->total = $this->joinTable(3);

        $this->fields = "a.*";
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order = $order;
        $result = $this->joinTable(2);
        return $result;
    }

}

?>
