<?php

namespace Admin\Controller;

use User\Api\UsersApi;

/**
 * 定制订单管理管理控制器
 * Class AuthFrontController
 * @author 崔元欣 <15811506097@163.com>
 */
class CustomController extends AdminController {

    public function _initialize() {
        parent::_initialize();
        $type = array(
            '1' => '模型',
            '2' => '广告图',
            '3' => '产品说明书',
            '4' => '视频脚本',
            '5' => '视频'
        );
        $this->assign('type', $type);
    }

    public function index() {
        $id = I('get.id', 1);
        switch ($id) {
            case 1:
                $model = 'MadeOrderModel';
                break;
            case 2:
                $model = 'MadeOrderAdpic';
                break;
            case 3:
                $model = 'MadeOrderManual';
                break;
            case 4:
                $model = 'MadeOrderVideoScript';
                break;
            case 5:
                $model = 'MadeOrderVideo';
                break;
            default:
                echo "程序错误";
        }
        $list = M($model)->field('id,order_num,uid,item_name,state')->order('created desc')->select();
        foreach ($list as $key => $value) {
            /* 调用注册接口注册用户 */
            $User = new UsersApi;
            $uid = $User->info($value['uid'], false, false);
            $list[$key]['username'] = $uid[1];
        }
        $this->assign('id', $id);
        $this->assign('list', $list);
        $this->meta_title = '定制订单列表';
        $this->display();
    }

    public function edit() {
        $type = I('get.type', 1);
        switch ($type) {
            case 1:
                $model = 'MadeOrderModel';
                break;
            case 2:
                $model = 'MadeOrderAdpic';
                break;
            case 3:
                $model = 'MadeOrderManual';
                break;
            case 4:
                $model = 'MadeOrderVideoScript';
                break;
            case 5:
                $model = 'MadeOrderVideo';
                break;
            default:
                echo "程序错误";
        }
        if (IS_POST) {
            if (!empty($_POST['amounts'])) {
                $_POST['state'] = 8;
            } else {
                $_POST['state'] = 3;
            }
            $Model = M($model);
            $data = $Model->create();
            if ($data) {
                $r = $Model->save();
                if ($r === false) {
                    $this->error('操作失败' . $Model->getError());
                } else {
                    if ($_POST['state'] == 3) {
                        $list = M($model)->where(array('id' => $_POST['id']))->field('order_num,uid')->select();
                        /* 调用注册接口注册用户 */
                        $User = new UsersApi;
                        $uid = $User->info($list[0]['uid'], false, false);
                        $user = session('user_auth');
                        $data['from_uid'] = $user['uid'];
                        $data['from_username'] = $user['username'];
                        $data['title'] = "官方客服";
                        $data['content'] = "尊敬的用户:" . $uid[1] . "，您的订单编号为:" . $list[0]['order_num'] . "的项目合同已上传，请尽快确认！";
                        $data['date'] = time();
                        if ($res = M('MessageSender')->add($data)) {
                            $map['mid'] = $res;
                            $map['to_uid'] = $uid[0];
                            $map['to_username'] = $uid[1];
                            $map['is_readed'] = 0;
                            if (M('ArMessageReceiver')->add($map)) {
                                $this->success('操作成功!', U('index'));
                            }
                        }
                    } else {
                        $this->success('操作成功!', U('index'));
                    }
                }
            } else {
                $this->error('操作失败' . $Model->getError());
            }
        } else {
            $id = I('get.id', 1);
            $list = M($model)->where(array('id' => $id))->select();
            $ison = json_decode(think_decrypt($list[0]['pact']), true);
            $list[0]['pacts'] = $ison['name'];
            $list[0]['pactid'] = $ison['id'];
            $this->assign('info', $list[0]);
            $this->meta_title = '定制订单详情';
            $this->display();
        }
    }

    public function del() {
        $type = I('get.type', 1);
        switch ($type) {
            case 1:
                $model = 'MadeOrderModel';
                break;
            case 2:
                $model = 'MadeOrderAdpic';
                break;
            case 3:
                $model = 'MadeOrderManual';
                break;
            case 4:
                $model = 'MadeOrderVideoScript';
                break;
            case 5:
                $model = 'MadeOrderVideo';
                break;
            default:
                echo "程序错误";
        }
        $id = array_unique((array) I('id', 0));
        $id = is_array($id) ? implode(',', $id) : $id;
        $map['id'] = array('in', $id);
        if(M($model)->where($map)->delete()){
            $this->success('操作成功');
        }else{
            $this->error('操作失败');
        }
    }

    public function type() {
        $type = I('get.type', 1);
        switch ($type) {
            case 1:
                $model = 'MadeOrderModel';
                break;
            case 2:
                $model = 'MadeOrderAdpic';
                break;
            case 3:
                $model = 'MadeOrderManual';
                break;
            case 4:
                $model = 'MadeOrderVideoScript';
                break;
            case 5:
                $model = 'MadeOrderVideo';
                break;
            default:
                echo "程序错误";
        }
        $Model = M($model);
        $data['id'] = I('get.id');
        $data['state'] = I('get.state');
        if ($data) {
            $r = $Model->save($data);
            switch ($data['state']) {
                case 5:
                    if ($r) {
                        $this->success('确认支付成功');
                    } else {
                        $this->error('确认支付失败');
                    }
                    break;
                case 6:
                    if ($r) {
                        $this->success('正在制作中');
                    } else {
                        $this->error('制作失败');
                    }
                    break;
                case 7:
                    if ($r) {
                        $this->success('确认验收成功');
                    } else {
                        $this->error('确认验收失败');
                    }
                    break;
                default:
                    echo "程序错误";
            }
        } else {
            $this->error('参数非法');
        }
    }

    public function product() {
        $type = I('get.type', 1);
        switch ($type) {
            case 1:
                $model = 'MadeOrderModel';
                break;
            case 2:
                $model = 'MadeOrderAdpic';
                break;
            case 3:
                $model = 'MadeOrderManual';
                break;
            case 4:
                $model = 'MadeOrderVideoScript';
                break;
            case 5:
                $model = 'MadeOrderVideo';
                break;
            default:
                echo "程序错误";
        }
        if (IS_POST) {
            $Model = M($model);
            $data = $Model->create();
            if ($data) {
                $r = $Model->save();
                if ($r === false) {
                    $this->error('操作失败' . $Model->getError());
                } else {
                    $list = M($model)->where(array('id' => $_POST['id']))->field('order_num,uid')->select();
                    /* 调用注册接口注册用户 */
                    $User = new UsersApi;
                    $uid = $User->info($list[0]['uid'], false, false);
                    $user = session('user_auth');
                    $data['from_uid'] = $user['uid'];
                    $data['from_username'] = $user['username'];
                    $data['title'] = "官方客服";
                    $data['content'] = "尊敬的用户:" . $uid[1] . "，您的订单编号为:" . $list[0]['order_num'] . "的项目已制作完成，请尽快确认！";
                    $data['date'] = time();
                    if ($res = M('MessageSender')->add($data)) {
                        $map['mid'] = $res;
                        $map['to_uid'] = $uid[0];
                        $map['to_username'] = $uid[1];
                        $map['is_readed'] = 0;
                        if (M('ArMessageReceiver')->add($map)) {
                            $this->success('操作成功!', U('index'));
                        }
                    }
                }
            } else {
                $this->error('操作失败' . $Model->getError());
            }
        } else {
            $id = I('get.id', 1);
            $list = M($model)->where(array('id' => $id))->field('id,product')->select();
            $ison = json_decode(think_decrypt($list[0]['product']), true);
            $list[0]['name'] = $ison['name'];
            $list[0]['uid'] = $ison['id'];
            $this->assign('info', $list[0]);
            $this->display();
        }
    }

    /* 下载文件 */

    public
            function download($id = null) {
        if (empty($id) || !is_numeric($id)) {
            $this->error('参数错误！');
        }

        $File = D('File');
        $root = C('DOWNLOAD_UPLOAD.rootPath');
        $call = array($this, 'setDownload');
        if (false === $File->download($root, $id)) {
            $this->error = $File->getError();
        }
    }

}
