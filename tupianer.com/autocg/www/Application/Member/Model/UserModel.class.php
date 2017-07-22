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
class UserModel extends Model {

    protected $_map = array(
        'uid' => 'uid',
        'username' => 'username',
        'realname' => 'realname',
        'password' => 'password',
        'phone' => 'phone',
        'tel' => 'tel',
        'email' => 'email',
        'gender' => 'gender',
        'age' => 'age',
        'last_login' => 'last_login',
        'last_ip' => 'last_ip',
        'ip' => 'ip',
        'creted' => 'creted',
        'updated' => 'updated',
        'user_type' => 'user_type'
    );

    /**
     * 注册一个新用户
     * @param  string $username 用户名
     * @param  string $password 用户密码
     * @param  string $email    用户邮箱
     * @param  string $user_type  用户类型
     * @return integer          注册成功-用户信息，注册失败-错误编号
     */
    public function register($username = '', $email = '', $password = '', $user_type = '') {
        $data = array(
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'user_type' => $user_type
        );
        $User = M('User');
        $User->add($data);
        return 1;
    }

    /**
     * 用户登录认证
     * @param  string  $username 用户名
     * @param  string  $password 用户密码
     * @param  integer $type     用户名类型 （1-用户名，2-邮箱，3-手机，4-UID）
     * @return integer           登录成功-用户ID，登录失败-错误编号
     */
    public function login($username, $password) {
        $User = M('User');
        $list = $User->where('username="' . $username . '"')->find();
        if ($list['password'] == $password) {
            return $list['uid']; //登录成功，返回用户ID
        } else {
            return -2; //密码错误
        }
    }

    /**
     * 获取用户信息
     * @param  string  $uid         用户ID或用户名
     * @param  boolean $is_username 是否使用用户名查询
     * @param  boolean $email 是否使用邮箱查询
     * @return array                用户信息
     */
    public function info($uid, $is_username = false, $email = false) {
        $map = array();
        if ($is_username) { //通过用户名获取
            $map['username'] = $uid;
        } else if ($email) {
            $map['email'] = $uid;
        } else {
            $map['id'] = $uid;
        }

        $user = $this->where($map)->field('uid,username,email,phone')->find();
        if (is_array($user)) {
            return array($user['id'], $user['username'], $user['email'], $user['phone']);
        } else {
            return -1; //用户不存在或被禁用
        }
    }

    /**
     * 用户名验证
     * @param  string  $username 用户名
     * @param  string  $password 用户密码
     * @param  integer $type     用户名类型 （1-用户名，2-邮箱，3-手机，4-UID）
     * @return integer           登录成功-用户ID，登录失败-错误编号
     */
    public function valatename($username) {
        $User = M('User');
        $list = $User->where('username="' . $username . '"')->find();
        if (empty($list['username'])) {
            return -1; //用户不存在
        } else {
            return 1; //密码错误
        }
    }

    public function islogin($userid) {
        $User = M('User');
        $User = $User->where('uid="' . $userid . '"')->find();
        $_SESSION[userid] = $User;
    }

    public function logout() {
        session_destroy();
    }

    /**
     * 检测用户信息
     * @param  string  $field  用户名
     * @param  integer $type   用户名类型 1-用户名，2-用户邮箱，3-用户电话
     * @return integer         错误编号
     */
//    public function checkField($field, $type = 1) {
//        $data = array();
//        switch ($type) {
//            case 1:
//                $data['username'] = $field;
//                break;
//            case 2:
//                $data['email'] = $field;
//                break;
//            case 3:
//                $data['mobile'] = $field;
//                break;
//            default:
//                return 0; //参数错误
//        }
//
//        return $this->create($data) ? 1 : $this->getError();
//    }

    /**
     * 更新用户登录信息
     * @param  integer $uid 用户ID
     */
//    protected function updateLogin($uid) {
//        $data = array(
//            'id' => $uid,
//            'last_login_time' => NOW_TIME,
//            'last_login_ip' => get_client_ip(1),
//        );
//        $this->save($data);
//    }

    /**
     * 更新用户信息
     * @param int $uid 用户id
     * @param array $data 修改的字段数组
     * @return true 修改成功，false 修改失败
     * @author 崔元欣 <15811506097@163.com>
     */
    public function updateUserFields($uid, $data) {
        if (empty($uid) || empty($data)) {
            $this->error = '参数错误！';
            return false;
        }

        //更新用户信息
        $data = $this->create($data);
        if ($data) {
            return $this->where(array('id' => $uid))->save($data);
        }
        return false;
    }

    /**
     * 验证用户密码
     * @param int $uid 用户id
     * @param string $password_in 密码
     * @return true 验证成功，false 验证失败
     * @author huajie <banhuajie@163.com>
     */
//    protected function verifyUser($uid, $password_in) {
//        $password = $this->getFieldById($uid, 'password');
//        if (think_ucenter_md5($password_in, UC_AUTH_KEY) === $password) {
//            return true;
//        }
//        return false;
//    }
}
