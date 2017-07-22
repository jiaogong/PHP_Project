<?php

namespace Addons\Timeline\Model;

use Think\Model;

/**
 * Timeline模型
 * @author 崔元欣 <15811506097@163.com>
 */
class TimelineModel extends Model {

    protected $_validate = array(
        array('title', 'require', '标题'),
        array('title', '', '标题！', 0, 'unique', 1),
    );

    public $model = array(
        'title' => '行业资讯管理',
        'template_add' => 'edit.html',
        'template_edit' => 'edit.html',
        'search_key' => '',
        'extend' => 1,
    );

    /**
     * 获取链接id
     * @return int 链接对应的id
     * @author 崔元欣 <15811506097@163.com>
     */
    protected function getLink() {
        $link = I('post.link_id');
        if (empty($link)) {
            return 0;
        } else if (is_numeric($link)) {
            return $link;
        }
        $res = D('Url')->update(array('url' => $link));
        return $res['id'];
    }

    public $_fields = array(
        'id' => array(
            'name' => 'id',
            'title' => 'ID',
            'type' => 'num',
            'remark' => '',
            'is_show' => 0,
            'value' => 0,
        ),
        'title' => array(
            'name' => 'title',
            'title' => '标题',
            'type' => 'string',
            'remark' => '',
            'is_show' => 1,
            'is_must' => 1,
        ), 'date' => array(
            'name' => 'date',
            'title' => '创建日期',
            'type' => 'datetime',
            'remark' => '',
            'is_show' => 1,
            'value' => 0,
            'is_must' => 1,
        ), 'link' => array(
            'name' => 'link',
            'title' => '链接',
            'type' => 'string',
            'remark' => '',
            'is_show' => 1,
            'is_must' => 1,
        ), 'source' => array(
            'name' => 'source',
            'title' => '来源',
            'type' => 'string',
            'remark' => '',
            'is_show' => 1,
            'is_must' => 0,
        ),
    );

}
