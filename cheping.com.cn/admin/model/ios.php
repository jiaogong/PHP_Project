<?php

/**
 * ios interface
 * $Id: ios.php 1391 2016-03-10 15:25:27Z cuiyuanxin $
 */
class ios extends model {
    /*
      ios post_body消息体设置
      @param 		ticker 	str 提示栏文字
      title 	str 通知标题
      text 	str 文字描述
      device_tokens 	array 设备号
      @return
     */

    //unicast,listcast,broadcast    
    function _ios($params, $debug = false, $Ios_appkey = '5618ab7be0f55a6fa7003547', $Ios_appMasterSecret = 'ssspsufe0n7drzbpy5jlfhuiqsp4zdeb', $type = 'broadcast') {
        if (!isset($params['title']) OR ! $params['title']) {
            return array('code' => 0, 'message' => '缺失title字段');
        }
        if (isset($params['description'])) {
            $description = $params['description'];
        } else {
            $description = 'ams车评网-苹果消息推送';
        }
        $data = array(
            "appkey" => $Ios_appkey,
            "timestamp" => time(),
            "type" => $type,
            "payload" => array(
                "aps" => array(
                    "alert" => $params['title'],
                ),
                "k1" => "v1", // 自定义key-value
                "k2" => "v2",
            ),
            "description" => $description
        );
        //是否为定时发送
        if (isset($params['start_time']) AND ( $params['start_time'] > time())) {
            $data['policy']['start_time'] = $params['start_time'];
            if (isset($params['expire_time']) AND ( $params['expire_time'] > $params['start_time'])) {
                $data['policy']['expire_time'] = $params['expire_time'];
            }
        }
        //测试模式
        if ($debug) {
            $data['production_mode'] = 'false';
            $data['device_tokens'] = '787ca5ba3e68b05498fdbb153a8f4a8b5d3f5b4150786eef06c77162e458eb50,2494714a1836e6c08d5e4b95a76def3d2096c97767dc86597389814b212a01f7';
        }
        return $this->_curl($data, $Ios_appMasterSecret);
    }

    /*
      拼接curl请求
     */

    function _curl($data, $Secret, $url = 'http://msg.umeng.com/api/send') {
        $postBody = json_encode($data);
        $sign = md5("POST" . $url . $postBody . $Secret);
        $url = $url . "?sign=" . $sign;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postBody);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErrNo = curl_errno($ch);
        $curlErr = curl_error($ch);
        curl_close($ch);
        if ($httpCode == "0") {
            return array('code' => $curlErrNo, 'message' => $curlErr);
        } else if ($httpCode != "200") {
            return array('code' => $httpCode, 'message' => $result);
        } else {
            $result = json_decode($result, true);
            if (isset($result['ret']) AND $result['ret'] == 'SUCCESS') {
                switch ($data['type']) {
                    case 'unicast'://单播
                        return array('code' => 1, 'message' => $result['data']['msg_id']);
                        break;
                    case 'listcast'://组播
                        return array('code' => 1, 'message' => $result['data']['msg_id']);
                        break;
                    case 'broadcast'://广播
                        return array('code' => 1, 'message' => $result['data']['task_id']);
                        break;
                    case 'groupcast'://组广播
                        return array('code' => 1, 'message' => $result['data']['task_id']);
                        break;
                    case 'customizedcast'://通过alias发送消息
                        return array('code' => 1, 'message' => $result['data']['msg_id']);
                        break;
                    default:
                        return array('code' => 1, 'message' => $result['data']['msg_id']);
                        break;
                }
            } else {
                return array('code' => 0, 'message' => $result['data']['error_code']);
            }
        }
    }

    function foo($arr, &$rt) {
        if (is_array($arr)) {
            foreach ($arr as $v) {
                $rt[] = $v['id'];
            }
        }
        return $rt;
    }

}
