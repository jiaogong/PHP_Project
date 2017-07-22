<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2014-2015 http://www.cuiyuanxin.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 崔元欣 <15811506097@163.com>
// +----------------------------------------------------------------------

namespace Member\Model;

use Think\Model;

/**
 * 会员模型
 */
class User_infoModel extends Model {

    protected $_map =array(
        'uid'=>'uid',
        'score'=>'score',
        'popularity'=>'popularity',
        'focus'=>'focus',
        'profile'=>'profile',
        'avatar'=>'avatar',
        'banner'=>'banner',
        'gender'=>'gender',
        'img_url'=>'img_url'
    );


    /**
     * 用户登录认证
     * @param  string  $username 用户名
     * @param  string  $password 用户密码
     * @param  integer $type     用户名类型 （1-用户名，2-邮箱，3-手机，4-UID）
     * @return integer           登录成功-用户ID，登录失败-错误编号
     */
    public function update_imgurl($userid,$img_url)
    {
        $Userinfo = M('User_info');
        $Userinfo->img_url= $img_url;
        $Userinfo->where('uid='.$userid)->save();

    }
    //显示所有用户的的userinfo信息
    public  function list_userinfo($userid)
    {
        $Userinfo =M('User_info');
        $list = $Userinfo->where('uid='.$userid)->find();
        return $list;
    }





}
