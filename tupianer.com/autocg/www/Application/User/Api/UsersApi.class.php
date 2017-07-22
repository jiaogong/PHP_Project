<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2014-2015 http://www.cuiyuanxin.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 崔元欣 <15811506097@163.com>
// +----------------------------------------------------------------------

namespace User\Api;

class UsersApi {
    /**
     * 注册一个新用户
     * @param  string $username 用户名
     * @param  string $password 用户密码
     * @param  string $email    用户邮箱
     * @param  string $mobile   用户手机
     * @param  string $gender   用户性别
     * @param  string $group_id   用户角色
     * @return integer          注册成功-用户信息，注册失败-错误编号
     */
    public function register($username, $password, $email, $mobile = '',$gender = 1,$group_id = 4) {
        return D('User/User')->register($username, $password, $email, $mobile, $gender, $group_id);
    }

    /**
     * 用户登录认证
     * @param  string  $username 用户名
     * @param  string  $password 用户密码
     * @param  integer $type     用户名类型 （1-用户名，2-邮箱，3-手机，4-UID）
     * @return integer           登录成功-用户ID，登录失败-错误编号
     */
//    public function login($username, $password, $type = 1) {
//        return D('Api/UcenterMember')->login($username, $password, $type);
//    }

    /**
     * 获取用户信息
     * @param  string  $uid         用户ID或用户名
     * @param  boolean $is_username 是否使用用户名查询
     * @param  boolean $email 是否使用邮箱查询
     * @return array                用户信息
     */
    public function info($uid, $is_username = false , $email = false) {
        return D('User/User')->info($uid, $is_username, $email);
    }

    /**
     * 检测用户名
     * @param  string  $field  用户名
     * @return integer         错误编号
     */
//    public function checkUsername($username) {
//        return $this->model->checkField($username, 1);
//    }

    /**
     * 检测邮箱
     * @param  string  $email  邮箱
     * @return integer         错误编号
     */
//    public function checkEmail($email) {
//        return $this->model->checkField($email, 2);
//    }

    /**
     * 检测手机
     * @param  string  $mobile  手机
     * @return integer         错误编号
     */
//    public function checkMobile($mobile) {
//        return $this->model->checkField($mobile, 3);
//    }

    /**
     * 更新用户信息
     * @param int $uid 用户id
     * @param array $data 修改的字段数组
     * @return true 修改成功，false 修改失败
     * @author 崔元欣 <15811506097@163.com>
     */
    public function updateInfo($uid, $data) {
        D('User/User')->updateUserFields($uid, $data);
        if (D('User/User')->updateUserFields($uid, $data) !== false) {
            $return['status'] = true;
        } else {
            $return['status'] = false;
            $return['info'] = D('User/User')->getError();
        }
        return $return;
    }
}
