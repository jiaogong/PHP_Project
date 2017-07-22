<?php

class shortMsg extends model {

    function __construct() {
        parent::__construct();
//        $this->step = array(
//            1 => '注册验证码',
//            2 => '找回密码验证'
//        );
//        $this->tpl_flag = array(
//            'code_os' => 1,
//            'code_o' => 2,
//            'reg_code' => 3,
//            'get_code' => 4,
//        );
//        $this->step = array(
//            1 => '注册验证码',
//            2 => '找回密码验证',
//            3 => '更改手机号',
//            4 => '更改密码'
//        );
//        $this->tpl_flag = array(
//            'reg_code' => 1,
//            'get_code' => 2,
//            'code_o' => 3,
//            'code_os' => 4
//        );
        $this->step = array(
            1 => '修改密码',
            2 => '更改手机号',
            3 => '注册验证码',
            4 => '找回密码短信验证'
        );
        $this->tpl_flag = array(
            'code_os' => 1,
            'code_o' => 2,
            'reg_code' => 3,
            'get_code' => 4
        );
        $this->table_name = 'cardb_smslog';
    }

    /**
     * 记录短信日志
     * 
     * @param int $buyinfo_id
     * @param int $state    发送状态   1.成功发送短信   2.发送短信失败
     * @param int $step     在哪一步操作时发送的短信  1.推送  2.重发  3.购车提醒  4.验证购车提醒  5.验证/领卡通知 6.领取杂志 7.团购短信
     * @param string $mobile   短信接收人手机号
     * @param string $content  短信内容 
     */
    function recordMsg($buyinfo_id, $state, $step, $mobile, $content) {
        #如果state为空，直接返回false
        if (!$state) {
            return false;
        }
        $timestamp = time();
        $this->ufields = array(
            'buyinfo_id' => $buyinfo_id,
            'state' => $state,
            'step' => $step,
            'mobile' => $mobile,
            'content' => $content,
            'sendtime' => $timestamp
        );
        return $this->insert();
    }

    function getList($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }

}

?>
