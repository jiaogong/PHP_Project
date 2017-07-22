<?php

namespace Addons\Qualifications;

use Common\Controller\Addon;

/**
 * 资质审核管理插件
 * @author 崔元欣
 */
class QualificationsAddon extends Addon {

    public $info = array(
        'name' => 'Qualifications',
        'title' => '资质审核管理',
        'description' => '这是一个资质审核管理',
        'status' => 1,
        'author' => '崔元欣',
        'version'  => '0.1'
    );
    public $admin_list = array(
        'model' => 'Aptitude', //要查的表
        'fields' => '*', //要查的字段
        'map' => '', //查询条件, 如果需要可以再插件类的构造方法里动态重置这个属性
        'order' => 'id desc', //排序,
        'list_grid' => array(//这里定义的是除了id序号外的表格里字段显示的表头名和模型一样支持函数和链接
            'enterprise:企业名称',
            'contacts:联系人',
            'description:描述',
            'link_id|get_link:外链',
            'update_time|time_format:更新时间',
            'id:操作:[EDIT]|编辑,[DELETE]|删除'
        ),
    );

    public function install() {
        return true;
    }

    public function uninstall() {
        return true;
    }

}
