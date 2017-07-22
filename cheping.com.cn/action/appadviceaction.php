<?php

import('dcrypt.class', 'lib');

class appadviceAction extends action {
    var $advice;
    public $users;
    
    function __construct() {
        parent::__construct();
        $this->advice = new advice();
        $this->users = new users();
    }
    
    function doDefault() {
        $this->doAppAdvice();
    }
    
    function doAppAdvice(){
        $user_all = dcrypt::privDecrypt($_GET['parse']);
        $parse_query = parseQuery($user_all);
        $user = $parse_query["name"];
        $pwd = $parse_query["password"];
        $content  = $parse_query["content"];
        $user_contact  = $parse_query["user_contact"];
        
        $uid = $this->users->verifyUser($user, $pwd);
        switch ($uid) {
            case -1:
                $output = array('code' => -1, 'mes' => '用户名不能为空');
                exit(json_encode($output));
                break;
            case -2:
                $output = array('code' => -2, 'mes' => '密码不能为空');
                exit(json_encode($output));
                break;
            case 0:
                $output = array('code' => 0, 'mes' => '该用户不存在');
                exit(json_encode($output));
                break;
            default:
                if ($uid) {
                    $username = $this->users->getUser('username', "id='{$uid}'", 3);
                    $this->advice->ufields = array(
                        'state' => 1,
                        'created' => $this->timestamp,
                        'uid' => $uid,
                        'username' => $username,
                        'content' => $content,
                        'user_contact' => $user_contact
                    );
                    $this->advice->where = "id='{$id}'";
                    $ret = $this->advice->insert();
                    if($ret){
                        $output = array('code' => 1, 'mes' => '反馈成功');
                        exit(json_encode($output));
                    }else{
                        $output = array('code' => 2, 'mes' => '反馈失败');
                        exit(json_encode($output));
                    }
                }
        }
    }
}