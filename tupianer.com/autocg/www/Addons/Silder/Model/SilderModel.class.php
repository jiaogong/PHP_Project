<?php

namespace Addons\Silder\Model;

use Think\Model;

/**
 * Silder模型
 * @author  崔元欣 <15811506097@163.com>
 */
class SilderModel extends Model {

    protected function _after_find(&$result, $options) {
        $result['statustext'] = $result['status'] == 0 ? '禁用' : '正常';
        $cover = M('picture')->field('path')->find($result['silderpic']);
        $result['path'] = $cover['path'];
    }

    protected function _after_select(&$result, $options) {
        foreach ($result as &$record) {
            $this->_after_find($record, $options);
        }
    }

    protected $_validate = array(
        array('title', 'require', '标题不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('silderpic', 'number', '图片不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
    );

    public function detail($id) {
        $data = $this->find($id);
        $cover = M('picture')->find($data['silderpic']);
        $data['path'] = $cover['path'];
        return $data;
    }

    public function forbidden($id) {
        return $this->save(array('id' => $id, 'status' => '0'));
    }

    public function off($id) {
        return $this->save(array('id' => $id, 'status' => '1'));
    }

    public function del($id) {
        return $this->delete($id);
    }

    public function silderLists($param) {
        $where = array(
            'status' => array('eq', 1),
        );

        return $this->where($where)->order('priorityr asc')->select();
    }

    public function update() {
        $data = $this->create();

        if (empty($data['id'])) { //新增数据
            $id = $this->add(); //添加基础内容
            if (!$id) {
                $this->error = '新增幻灯片内容出错！';
                return false;
            }
        } else { //更新数据
            $status = $this->save(); //更新基础内容
            if (false === $status) {
                $this->error = '更新幻灯片内容出错！';
                return false;
            }
        }

        // 更新完成
        return $data;
    }

}
