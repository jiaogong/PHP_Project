<?php

namespace Addons\Silder\Controller;

use Home\Controller\AddonsController;

class SilderController extends AddonsController {

    /**
     * 幻灯片添加
     * @author  崔元欣 <15811506097@163.com>
     */
    public function add() {
        $this->display(T('Addons://Silder@Silder/edit'));
    }

    /**
     * 幻灯片编辑
     * @author  崔元欣 <15811506097@163.com>
     */
    public function edit() {
        $id = I('get.id', '');
        $SilderModel = D('Addons://Silder/Silder');
        $info = $SilderModel->detail($id);
        $this->assign('info', $info);
        $this->display(T('Addons://Silder@Silder/edit'));
    }

    /**
     * 幻灯片禁用
     * @author  崔元欣 <15811506097@163.com>
     */
    public function forbidden() {
        $id = I('get.id', '');
        if (D('Addons://Silder/Silder')->forbidden($id)) {
            $this->success('成功禁用该幻灯片', Cookie('__forward__'));
        } else {
            $this->error(D('Addons://Silder/Silder')->getError());
        }
    }

    /**
     * 幻灯片启用
     * @author  崔元欣 <15811506097@163.com>
     */
    public function off() {
        $id = I('get.id', '');
        if (D('Addons://Silder/Silder')->off($id)) {
            $this->success('成功启用该幻灯片', Cookie('__forward__'));
        } else {
            $this->error(D('Addons://Silder/Silder')->getError());
        }
    }

    /*
     * 幻灯片删除
     * @author  崔元欣 <15811506097@163.com>
     */

    public function del() {
        $id = I('get.id', '');
        if (D('Addons://Silder/Silder')->del($id)) {
            $this->success('成功删除该幻灯片', Cookie('__forward__'));
        } else {
            $this->error(D('Addons://Silder/Silder')->getError());
        }
    }

    /**
     * 幻灯片保存
     * @author  崔元欣 <15811506097@163.com>
     */
    public function update() {
        $SilderModel = D('Addons://Silder/Silder');
        $res = $SilderModel->update();

        if (!$res) {
            $this->error($SilderModel->getError());
        } else {
            if ($res['id']) {
                $this->success('更新成功', Cookie('__forward__'));
            } else {
                $this->success('添加成功', Cookie('__forward__'));
            }
        }
    }

    /**
     * 批量处理
     * @author  崔元欣 <15811506097@163.com>
     */
    public function savestatus() {
        $status = I('get.status');
        $ids = I('post.id');

        if ($status == 1) {
            foreach ($ids as $id) {
                D('Addons://Silder/Silder')->off($id);
            }
            $this->success('成功启用所选幻灯片', Cookie('__forward__'));
        } else {
            foreach ($ids as $id) {
                D('Addons://Silder/Silder')->forbidden($id);
            }
            $this->success('成功禁用所选幻灯片', Cookie('__forward__'));
        }
    }

}
