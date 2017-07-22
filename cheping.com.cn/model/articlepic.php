<?php

/**
 * 文章图片表model,查询cardb_file表
 * $Id: articlepic.php 1254 2015-11-13 09:16:34Z xiaodawei $
 * @author David Shaw <tudibao@163.com>
 */
class articlepic extends model {

    function __construct() {
        $this->table_name = "cardb_file";
        parent::__construct();
    }

    function getArticle($where, $limit = 20, $offset = 0, $order = array(), $type = 2) {
        $this->tables = array(
            'cae' => 'cp_article_category',
            'pcae' => 'cp_article_category',
            'ca' => 'cp_article',
            'cf' => 'cardb_file'
        );

        $this->where = "cae.id=pcae.parentid and cae.state=1 and pcae.state=1 and ca.category_id=pcae.id and ca.state=3 and ca.pic_org_id=cf.type_id GROUP BY cf.type_id";
        $this->fields = "count(ca.id)";
        $this->total = $this->joinTable(3, 1);
//        echo $this->sql;
        $this->fields = "cae.id caeid,pcae.id pcaeid,cae.category_name caename,pcae.category_name pcaename,cae.path caep,pcae.path pcaep,cae.parentid caepa,pcae.parentid pcaepa,cae.state caes,pcae.state pcaes,ca.id caid,ca.title catitle,ca.title2 catitle2,ca.pic capic,ca.type_id,ca.uptime,ca.pic_org_id,ca.category_id,cf.id cfid";
        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;
        $res = $this->joinTable($type, 1);
        if ($res)
            return $res;
        else
            return false;
    }

    function getCount($where, $order = array(), $type = 2) {
        $this->tables = array(
            'cp_article' => 'ca',
            'cardb_file' => 'cf'
        );
        $this->where = $where;
        $this->fields = "count(cf.id)";
        $this->total = $this->joinTable(1);

        $this->where = $where;
        $this->fields = "ca.id caid,ca.title,ca.title2,ca.title3,ca.pic,ca.pic_org_id,cf.id,cf.name,cf.file_type,cf.type_name,cf.type_id,cf.memo,cf.created,cf.updated,ca.uptime";
        $this->order = $order;
        return $this->joinTable($type);
    }

    function getCounts($where, $fields, $order = array(), $type = 2) {
        $this->where = $where;
        $this->fields = $fields;
        $this->order = $order;
        return $this->getResult($type);
    }

}

?>
