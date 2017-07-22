<?php

class smsAction extends action {
    var $pagedata;
    function __construct() {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, 'sys_module', 901, 'A');

        parent::__construct();
        $this->sms = new sms();
        $this->shortMsg = new shortMsg();
    }

    function doDefault() {
        $this->doList();
    }

    function doSmsMass() {
        $id = $this->getValue('id')->Int();
        $sms = $this->sms->getSmsbyid($id);

        $soapmsg = new soapmsg();
        $mobile = array();
        $user_type = explode(',', $sms['user_type']);
        $user_type = array_filter($user_type);
        if (empty($user_type)) {
            $this->alert('没有指定群里短信用户，返回修改群发设置！', 'js', 2);
        } else {
            $model = new model();
            #网站注册用户
            if (array_search(3, $user_type) !== false) {
                $model->table_name = 'cardb_user';
                $model->fields = 'uphone';
                $model->where = "state=1 and uphone <> ''";
                $result = $model->getResult(2);
                foreach ($result as $row) {
                    $mobile[] = $row['uphone'];
                }
            }

            #经销商联系人
            if (array_search(1, $user_type) !== false) {
                $t = array();
                $model->table_name = 'dealer_info';
                $model->fields = "dealer_id,dealer_tel";
                $model->where = "province_id=3 and state in (0,2) and dealer_name<>'' and (dealer_tel LIKE '13%' OR dealer_tel LIKE '15%' OR dealer_tel LIKE '18%')";
                $model->group = 'dealer_tel';
                $user1_mobile = $model->getResult(4);
                foreach ($user1_mobile as $value) {
                    preg_match_all('/(1[358][\d]{9})/si', $value, $match);
                    $t = array_merge($t, $match[1]);
                }
                $model->group = '';
                $mobile = array_merge($mobile, $t);
            }

            #报价销售人
            if (array_search(2, $user_type) !== false) {
                $t = array();
                $model->table_name = 'cardb_price';
                $model->fields = "id,saler_tel";
                $model->where = "price_type=0 and (saler_tel LIKE '13%' OR saler_tel LIKE '15%' OR saler_tel LIKE '18%')";
                $model->group = 'saler_tel';
                $user2_mobile = $model->getResult(4);
                foreach ($user2_mobile as $value) {
                    preg_match_all('/(1[358][\d]{9})/si', $value, $match);
                    $t = array_merge($t, $match[1]);
                }
                $mobile = array_merge($mobile, $t);
            }
            sort($mobile);
        }
        #$list = $this->pagedata->getSomePagedata("id,value", "name='payment_alarm' and state=1 ", 2);
        #$mobile = array();
        $mobile[] = 13911918020;
        $mobileStr = implode(',', $mobile);
        $state = $soapmsg->postMsg($mobileStr, $sms['content']);
        //记录短信日志
        $this->shortMsg->recordMsg(0, $state, 10, $mobileStr, $sms['content']);

        if ($state == 2)
            $str = '发送成功！';
        else
            $str = '发送失败,请与管理员联系！失败参数：' . $state;
        $this->alert($str, 'js', 3, 'index.php?action=sms');
    }

    function doList() {
        $limit = 20;
        $tpl_name = 'sms_list';
        $page = max(1, intval($this->getValue('page')->Int()));
        $offset = ($page - 1) * $limit;

        $list = $this->sms->getSms('*', "1", array('updated' => 'DESC'), $offset, $limit);
        $page_bar = $this->multi($this->sms->total, $limit, $page, $_ENV['PHP_SELF']);
        $this->vars('list', $list);
        $this->vars('page_bar', $page_bar);
        $this->template($tpl_name);
    }

    function doAdd() {
        $add_edit_btn = $this->postValue('add_edit_btn')->Val();
        if (empty($add_edit_btn)) {
            $tpl_name = 'sms_edit';
            $page_title = "添加短信模板";
            $this->vars("page_title", $page_title);

            $this->vars("attr_type", $this->sms->type);
            $this->template($tpl_name);
        } else {
            //添加 编辑
            $meg = $user_type = "";
            $id = $this->postValue('id')->Int();
            $user_type = $this->postValue('user_type')->Val();
            if (!empty($user_type)) {
                $user_type = implode(',', $user_type);
            }

            if ($id) {
                //编辑
                $ufileds = array(
                    "title" => $this->postValue('title')->String(),
                    "content" => $this->postValue('content')->Val(),
                    "state" => $this->postValue('state')->Int(),
                    "mass" => $this->postValue('mass')->String(),
                    'user_type' => $user_type,
                    "updated" => $this->timestamp,
                );
                $this->sms->ufields = $ufileds;
                $this->sms->where = "id='$id'";
                $ret = $this->sms->update();
                $meg = "修改";
            } else {
                //添加
                $ufileds = array(
                    "title" => $this->postValue('title')->String(),
                    "content" => $this->postValue('content')->String(),
                    "state" => $this->postValue('state')->Int(),
                    "mass" => $this->postValue('mass')->String(),
                    'user_type' => $user_type,
                    "created" => time(),
                    "updated" => time(),
                );
                $this->sms->ufields = $ufileds;
                $ret = $this->sms->insert();
                $meg = "添加";
            }
            if ($ret) {
                $this->alert($meg . "成功!", "js", 3, $_ENV["PHP_SELF"]);
            }
        }
    }

    function doEdit() {
        $tpl_name = 'sms_edit';
        $page_title = "修改短信模板";
        $this->vars("page_title", $page_title);
        $this->vars("attr_type", $this->sms->type);
        $id = $this->getValue('id')->Int();
        if (!$id) {
            $this->alert("请求失败!", "js", 2);
        }
        $sms = $this->sms->getSmsbyid(intval($id), 0);
        $user_type = explode(',', $sms['user_type']);
        $this->vars("user_type", $user_type);
        $this->vars("sms", $sms);
        $this->template($tpl_name);
    }

    /**
     * 人工发送短信
     * 接收方号码及短信内容完全人工编辑
     */
    function doSend() {
        $this->template("sms_send");
    }

    /**
     * 开始发送手动编辑的短信内容
     */
    function doSendSms() {
        $mobile = $this->postValue('mobile')->Mobile();
        $content = $this->postValue('content')->String() . "【ams车评网】";

        $soapmsg = new soapmsg();
        $state = $soapmsg->postMsg($mobile, $content);
        //记录短信日志
        $this->shortMsg->recordMsg(0, $state, 99, $mobile, $content);

        if ($state == 2)
            $str = '发送成功！';
        else
            $str = '发送失败,请与管理员联系！失败参数：' . $state;
        $this->alert($str, 'js', 3, 'index.php?action=sms');
    }

}

?>
