<?php

class shortMsgAction extends action {

    function __construct() {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, 'sys_module', 903, 'A');

        parent::__construct();
        $this->shortMsg = new shortMsg();
        $this->pagedata = new pageData();
    }

    function doDefault() {
        $this->doMsgList();
    }

    function doMsgList() {

        $tpl_name = 'shortmsg';
        $limit = 20;
        $condition = '';
        $page = max(1, intval($this->getValue('page')->Int()));
        $offset = ($page - 1) * $limit;
        $receiver = array('step', 'state', 'mobile', 'ip');
        $receiverArr = receiveArray($receiver);
        extract($receiverArr);
        $select_step = $this->shortMsg->step;
        $select_state = array('', '失败', '成功');

        $this->shortMsg->fields = 'count(*)';
        $this->shortMsg->where = "state in(2,4)";

        if ($step !== '') {
            $this->shortMsg->where .= " and step = $step";
            $condition .= "&step=$step";
        }
        if ($state !== '') {
            $this->shortMsg->where .= " and state = $state";
            $condition .= "&state=$state";
        }
        if ($mobile) {
            $this->shortMsg->where .= " and mobile like '%$mobile%'";
            $condition .= "&mobile=$mobile";
        }
        if ($ip) {
            $this->shortMsg->where .= " and ip like '%$ip%'";
            $condition .= "&ip=$ip";
        }

        $total = $this->shortMsg->getResult(3);
        $this->shortMsg->fields = '*';
        $this->shortMsg->limit = $limit;
        $this->shortMsg->offset = $offset;
        $this->shortMsg->order = array('sendtime' => 'DESC');
        $msgList = $this->shortMsg->getResult(2);
        $page_bar = $this->multi($total, $limit, $page, '?action=shortmsg' . $condition);
        $this->vars('msglist', $msgList);
        $this->vars('page_bar', $page_bar);
        $this->vars('select_step', $select_step);
        $this->vars('select_state', $select_state);
        $this->template($tpl_name);
    }

    function doResendMsg() {
        $msg = array();
        $mid = $this->getValue('mid')->Int();
        $sopaMsg = new soapmsg();
        if ($mid) {
            $this->shortMsg->fields = 'buyinfo_id, mobile, content, step';
            $this->shortMsg->where = "id = $mid";
            $msg = $this->shortMsg->getResult();
            $flag = 'false';
            if (!empty($msg) && !DB::isError($msg)) {
                extract($msg);
                //发送短信
                $state = $sopaMsg->postMsg($mobile, $content);
                $this->shortMsg->recordMsg($buyinfo_id, $state, 2, $mobile, $content);
                if ($state == 2)
                    $flag = 'success';
            }
            echo $flag;
        }
    }

    function doSmsPeople() {
        $template = 'smspeople_list';
        $list = $this->pagedata->getSomePagedata("id,value,state", "name='payment_alarm'", 2);
        if ($list) {
            foreach ($list as $key => $value) {
                $con = unserialize($value['value']);
                $list[$key]['username'] = $con['username'];
                $list[$key]['phone'] = $con['phone'];
            }
        }
        $this->vars('list', $list);
        $this->template($template);
    }

    function doSmslogdel() {
        $id = $this->getValue('id')->Int();
        $this->shortMsg->where = "id=$id";
        $ret = $this->shortMsg->del();
        if ($ret) {
            $this->alert("修改成功！", 'js', 3, $_ENV['PHP_SELF'] . "MsgList");
        } else {
            $this->alert("修改失败！", 'js', 3, $_ENV['PHP_SELF'] . "MsgList");
        }
    }

    function doSmsPeopleAdd() {
        $template = 'smspeople_edit';
        if ($_POST) {
            $arr = array();
            $arr['username'] = $this->postValue('username')->String();
            $arr['phone'] = $this->postValue('phone')->Val();
            $ufields['value'] = serialize($arr);
            $ufields['state'] = $this->postValue('state')->Int();
            $ufields['name'] = "payment_alarm";
            $ufields['updated'] = $this->timestamp;
            $id = $this->postValue('id')->Int();
            if ($id) {
                $ret = $this->pagedata->updatePageData($ufields, "id={$id}");
            } else {
                $ufields['created'] = time();
                $ret = $this->pagedata->insertPageData($ufields);
            }
            if ($ret) {
                $this->alert("修改成功！", 'js', 3, $_ENV['PHP_SELF'] . "SmsPeople");
            } else {
                $this->alert("修改失败！", 'js', 3, $_ENV['PHP_SELF'] . "SmsPeople");
            }
        } else {
            $id = $this->getValue('id')->Int();
            if ($id) {
                $sms = $this->pagedata->getData($id);
                $value = unserialize($sms['value']);
                $sms['username'] = $value['username'];
                $sms['phone'] = $value['phone'];
                $this->vars("sms", $sms);
            }
        }
        $this->template($template);
    }

}

?>
