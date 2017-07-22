<?php

/**
 * 文章分类model
 * $Id: article_category.php 1254 2015-11-13 09:16:34Z xiaodawei $
 * @author David Shaw <tudibao@163.com>
 */
class article_category extends model {

    function __construct() {
        $this->table_name = "cp_article_category";
        parent::__construct();
    }

    /**
     * 返回满足条件的多条记录数组
     * 
     * @param string $where
     * @return array 满足条件的数组
     */
    function getCount($where) {
        $this->where = $where;
        $this->fields = '*';
        return $this->getResult(2);
    }

    /**
     * 返回满足条件的文章分类数组
     * 
     * @param string $fields 需要返回的文章分类字段
     * @param string $where 查询条件
     * @param int $flag 查询类型，同getResult参数
     * @return array 文章分类数组
     */
    function getlsit($fields, $where, $flag) {
        $this->where = $where;
        $this->fields = $fields;
        return $this->getResult($flag);
    }

    /**
     * 关联article表，article_category表进行查询
     * 返回满足条件的文章分类信息，文章信息
     * 
     * @param string $where 查询条件
     * @param int $type 查询类型，同getResult参数，默认返回多条记录
     * @return array 文章分类及文章信息的数组
     */
    function getCounts($where, $type = 2) {
        $this->tables = array(
            'cp_article_category' => 'cac',
            'cp_article' => 'ca'
        );

        $this->where = $where;
        $this->fields = "count(ca.id)";
        return $this->total = $this->joinTable(3);
    }

    /**
     * 查询文章相关的信息，包含文章，文章分类，文章标签，文章父分类等
     * 关联article, article_category, article_tags表
     * 
     * @param string $where 查询条件
     * @param int $type 查询类型，同getResult参数，默认返回多条记录
     * @return array 满足条件的数组
     */
    function getParentCategoryName($where, $type = 2) {
        $this->tables = array(
            'cae' => 'cp_article_category',
            'pcae' => 'cp_article_category',
            'cat' => 'cp_article_tags',
            'ca' => 'cp_article'
        );

        $this->where = $where;
        $this->fields = "count(ca.id)";
        $this->total = $this->joinTable(3, 1);
        $this->fields = "ca.id,ca.title,ca.title2,ca.pic,ca.type_id,ca.category_id,tag_list,ca.series_list,ca.state,ca.pic_org_id,ca.uptime,cae.id caeid,pcae.id pcaeid,cae.parentid caep,pcae.parentid pcaep,cae.category_name caename,pcae.category_name pcaename,cae.path caepath,pcae.path pcaepath,cae.state caes,pcae.state pcaes,cat.tag_id";
        $res = $this->joinTable($type, 1);
        $result = array();
        foreach ($res as $ke => $va) {
            $result[$va['caeid']][id] = $va[caeid];
            $result[$va['caeid']][caename] = $va[caename];
            $result[$va['caeid']][tag_id] = $va[tag_id];
            $result[$va['caeid']][count]+=count($va[id]);
        }
        return $result;
    }

    /**
     * 查询文章相关的信息，包含文章，文章分类，文章标签，文章父分类等
     * 关联article, article_category, article_tags表
     * 
     * @param string $where 查询条件
     * @param int $limit 返回记录数，默认20
     * @param int $offset 起始偏移，默认第一条开始
     * @param array $order 排序条件
     * @param int $type 查询类型，同getResult参数，默认返回多条记录
     * @return mixed 满足条件的文章相关信息的数组
     */
    function getArticle($where, $limit = 20, $offset = 0, $order = array(), $type = 2) {
        $this->tables = array(
            'cae' => 'cp_article_category',
            'pcae' => 'cp_article_category',
            'cat' => 'cp_article_tags',
            'ca' => 'cp_article'
        );

        $this->where = $where;
        $this->fields = "count(ca.id)";
        $this->total = $this->joinTable(3, 1);
        $this->fields = "ca.id,ca.title,ca.title2,ca.pic,ca.type_id,ca.category_id,tag_list,ca.series_list,ca.state,ca.pic_org_id,ca.uptime,cae.id caeid,pcae.id pcaeid,cae.parentid caep,pcae.parentid pcaep,cae.category_name caename,pcae.category_name pcaename,cae.path caepath,pcae.path pcaepath,cae.state caes,pcae.state pcaes,cat.tag_id";
        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;
        $res = $this->joinTable($type, 1);

        $article_obj = new article();
        foreach ($res as $key => $val) {
            $this->table_name = "cp_tags";
            $this->where = "id in({$val['tag_list']})";
            $this->fields = "id,tag_name";
            $this->order = "";
            $this->limit = 1;
            $tag_name = $this->getResult(2);
            $url = $article_obj->getRewriteUrl(array('id' => $val['id'], 'uptime' => $val['uptime'], 'p_category_id' => $val['pcaep']));
            foreach ($tag_name as $k => $v) {
                $res[$key]['tag_name'][$k]['id'] = $v['id'];
                $res[$key]['tag_name'][$k]['tag_name'] = $v['tag_name'];
                $res[$key]['url'] = $url;
            }
        }

        if ($res)
            return $res;
        else
            return false;
    }

    /**
     * 查询文章分类的父分类信息
     * 
     * @param string $fields 返回的文章分类字段
     * @param string $where 查询条件
     * @param int $flag 查询类型，同getResult参数
     * @return array 查询的文章分类数组
     */
    function getParentCategory($fields, $where, $flag) {
        $this->tables = array(
            'ca' => 'cp_article_category',
            'pca' => 'cp_article_category'
        );

        $this->fields = "$fields";
        $this->where = "$where";
        $ret = $this->joinTable($flag, 1);
        return $ret;
    }

}

?>
