<?php

namespace Addons\Brand\Model;

use Think\Model;

/**
 * Brand模型
 */
class BrandModel extends Model {
    
    protected $_validate = array(
        array('car', 'require', '车款不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('car','','该车款已经存在！',self::EXISTS_VALIDATE,'unique',self::MODEL_BOTH),
    );

    public function detail($id) {
        $data = $this->find($id);
        $cover = M('picture')->where('id in(' . $data['brandpic'] . ',' . $data['seriespic'] . ',' . $data['carpic'] . ')')->select();
        $data['brandpic'] = $cover[0]['path'];
        $data['seriespic'] = $cover[1]['path'];
        $data['carpic'] = $cover[2]['path'];
        return $data;
    }

    public function update() {
        $data = $this->create();

        if (empty($data['id'])) { //新增数据
            $id = $this->add(); //添加基础内容
            if (!$id) {
                $this->error = '新增品牌内容出错！';
                return false;
            }
        } else { //更新数据
            $status = $this->save(); //更新基础内容
            if (false === $status) {
                $this->error = '更新品牌内容出错！';
                return false;
            }
        }

        // 更新完成
        return $data;
    }
    
    public function del($id) {
        return $this->delete($id);
    }

}
