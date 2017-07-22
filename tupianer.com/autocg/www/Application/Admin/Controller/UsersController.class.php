<?php

// 崔元欣 <15811506097@163.com>

namespace Admin\Controller;

use User\Api\UsersApi;
use Admin\Model\AuthRuleModel;
use Admin\Model\AuthGroupModel;

/**
 * 前台用户管理控制器
 * @author 崔元欣 <15811506097@163.com>
 */
class UsersController extends AdminController {

    /**
     * 用户管理首页
     * @author 崔元欣 <15811506097@163.com>
     */
    public function index() {
        $created = I('get.created');
        $createds = I('get.createds');
        $score = I('get.score');
        $scores = I('get.scores');
        $username = I('get.username');

        if ($username !== '') {
            $map['username'] = " and user.username='$username'";
        }
        if ($created !== '' && $createds !== '') {
            $map['created'] = " and user.created BETWEEN '$created' and '$createds'";

        }
        if ($score !== '' && $scores !== '') {
            $map['score'] = " and info.score BETWEEN '".$score."' and '".$scores."'";
        }

        $Model = new \Think\Model();
        $db = $Model->field('user.uid,user.username,user.realname,user.created,info.uid iuid,info.score')
                ->table('tu_user user,tu_user_info info')
                ->where('user.uid=info.uid'.$map['username'].$map['created'].$map['score'])
                ->select();
        $count = count($db); // 查询满足要求的总记录数
        $page = new \Think\Page($count, C('LIST_ROWS')); // 实例化分页类 传入总记录数和每页显示的记录数(25)
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p =$page->show(); // 分页显示输出
        $limit = $page->firstRow.','.$page->listRows;
        $list = $Model->field('user.uid,user.username,user.realname,user.created,info.uid iuid,info.score')
                ->table('tu_user user,tu_user_info info')
                ->where('user.uid=info.uid'.$map['username'].$map['created'].$map['score'])
                ->limit($limit)->select();
        $this->assign('_page', $p? $p: '');
        $this->assign('_list', $list);
        $this->meta_title = '前台用户信息';
        $this->display();
    }

    /** 新增用户
     * @author  崔元欣 <15811506097@163.com>
     */
    public function add($username = '', $password = '', $repassword = '', $email = '', $gender = '', $group_id = '') {
        if (IS_POST) {
            /* 检测密码 */
            if ($password != $repassword) {
                $this->error('密码和重复密码不一致！');
            }
            /* 调用注册接口注册用户 */
            $User = new UsersApi;
            $uid = $User->register($username, $password, $email, $gender,$group_id);
            if (0 < $uid) { //注册成功
                $score = M('UserInfo')->data(array('uid' => $uid))->add();
                $AuthGroup = D('AuthGroup');

                if ($group_id && !$AuthGroup->checkGroupId($group_id)) {
                    $this->error($AuthGroup->error);
                }
                if ($AuthGroup->addToGroups($uid, $group_id)) {
                    $this->success('用户添加成功！', U('index'));
                } else {
                    $this->error($AuthGroup->getError());
                }
            } else { //注册失败，显示错误信息
                $this->error($this->showRegError($uid));
            }
        } else {
            $auth_groups = D('AuthGroup')->getQgroups();
            $this->assign('auth_groups', $auth_groups);

            $this->meta_title = '新增用户';
            $this->display();
        }
    }

    /**
     * 删除/批量删除
     * @author 崔元欣 <15811506097@163.com>
     */
    public function changeStatus($method = null) {
        $id = array_unique((array) I('id', 0));
        $id = is_array($id) ? implode(',', $id) : $id;
        if (empty($id)) {
            $this->error('请选择要操作的数据!');
        }
        $map['uid'] = array('in', $id);
        switch (strtolower($method)) {
            case 'deleteuser':
                $user = M('User')->where($map)->delete();
                if ($user) {
                    $score = M('UserInfo')->where($map)->delete();
                    if ($score) {
                        M('AuthGroupAccess')->where($map)->delete();
                        $this->success('删除成功');
                    } else {
                        $this->error('UserInfo:删除失败');
                    }
                } else {
                    $this->error('删除失败');
                }
                break;
            default:
                $this->error('参数非法');
        }
    }

    /**
     * 用户行为列表
     * @author huajie <banhuajie@163.com>
     */
//    public function action() {
//        //获取列表数据
//        $Action = M('Action')->where(array('status' => array('gt', -1)));
//        $list = $this->lists($Action);
//        int_to_string($list);
//        // 记录当前列表页的cookie
//        Cookie('__forward__', $_SERVER['REQUEST_URI']);
//
//        $this->assign('_list', $list);
//        $this->meta_title = '用户行为';
//        $this->display();
//    }

    /**
     * 新增行为
     * @author huajie <banhuajie@163.com>
     */
//    public function addAction() {
//        $this->meta_title = '新增行为';
//        $this->assign('data', null);
//        $this->display('editaction');
//    }

    /**
     * 编辑行为
     * @author huajie <banhuajie@163.com>
     */
//    public function editAction() {
//        $id = I('get.id');
//        empty($id) && $this->error('参数不能为空！');
//        $data = M('Action')->field(true)->find($id);
//
//        $this->assign('data', $data);
//        $this->meta_title = '编辑行为';
//        $this->display('editaction');
//    }

    /**
     * 更新行为
     * @author huajie <banhuajie@163.com>
     */
//    public function saveAction() {
//        $res = D('Action')->update();
//        if (!$res) {
//            $this->error(D('Action')->getError());
//        } else {
//            $this->success($res['id'] ? '更新成功！' : '新增成功！', Cookie('__forward__'));
//        }
//    }

    /** 修改用户
     * @author  崔元欣 <15811506097@163.com>
     */
    public function edit($id = '', $nickname = '', $password = '', $email = '') {
        if (IS_POST) {
            empty($nickname) && $this->error('请输入昵称');
            empty($password) && $this->error('请输入密码');
            empty($email) && $this->error('请输入邮箱');

            //密码验证
            $Api = new UsersApi();
            $uid = $Api->login($id, $password, 4);
            ($uid == -2) && $this->error('密码不正确');

            $data['email'] = $email;
            $Member = D('Member');
            $datas = $Member->create(array('nickname' => $nickname));

            if (!$datas) {
                $this->error($Member->getError());
            }
            $res = $Member->where(array('uid' => $uid))->save($datas);
            $ress = $Api->updateInfo($uid, $password, $data);
            if ($res && $res['status']) {
                $user = session('user_auth');
                if ($user['uid'] == $id) {
                    $user['username'] = $datas['nickname'];
                    session('user_auth', $user);
                    session('user_auth_sign', data_auth_sign($user));
                }
                $this->success('修改信息成功！');
            } else if ($res) {
                $user = session('user_auth');
                if ($user['uid'] == $id) {
                    $user['username'] = $datas['nickname'];
                    session('user_auth', $user);
                    session('user_auth_sign', data_auth_sign($user));
                }
                $this->success('修改信息成功！');
            } else if ($res['status']) {
                $this->success('修改信息成功！');
            } else {
                $this->error('修改信息失败！' . $res['info']);
            }
        } else {
            $uid = I('uid');
            $User = new UsersApi;
            $list = $User->info($uid, false);
            $nickname = M('Member')->getFieldByUid($uid, 'nickname');
            $this->assign('nickname', $nickname);
            $this->assign('list', $list);

            $this->meta_title = '修改用户';
            $this->display();
        }
    }

    /**
     * 修改密码初始化
     * @author 崔元欣 <15811506097@163.com>
     */
    public function updatePassword() {
        $uid = I('uid');
        $this->assign('uid', $uid);
        $this->meta_title = '修改密码';
        $this->display('updatepassword');
    }

    /**
     * 修改密码提交
     * @author 崔元欣 <15811506097@163.com>
     */
    public function submitPassword() {
        //获取参数
        $uid = I('id');
        $data['password'] = I('post.password');
        empty($data['password']) && $this->error('请输入新密码');
        $repassword = I('post.repassword');
        empty($repassword) && $this->error('请输入确认密码');

        if ($data['password'] !== $repassword) {
            $this->error('您输入的新密码与确认密码不一致');
        }

        $Api = new UsersApi();
        $res = $Api->updateInfo($uid, $data);
        if ($res['status']) {
            $this->success('修改密码成功！');
        } else {
            $this->error($res['info']);
        }
    }

    /**
     * 获取用户注册错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    private function showRegError($code = 0) {
        switch ($code) {
            case -1: $error = '用户名长度必须在16个字符以内！';
                break;
            case -2: $error = '用户名被禁止注册！';
                break;
            case -3: $error = '用户名被占用！';
                break;
            case -4: $error = '密码长度必须在6-30个字符之间！';
                break;
            case -5: $error = '邮箱格式不正确！';
                break;
            case -6: $error = '邮箱长度必须在1-32个字符之间！';
                break;
            case -7: $error = '邮箱被禁止注册！';
                break;
            case -8: $error = '邮箱被占用！';
                break;
            case -9: $error = '手机格式不正确！';
                break;
            case -10: $error = '手机被禁止注册！';
                break;
            case -11: $error = '手机号被占用！';
                break;
            default: $error = '未知错误';
        }
        return $error;
    }

}
