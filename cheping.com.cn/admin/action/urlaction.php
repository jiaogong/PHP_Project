<?php
/**
 * Created by PhpStorm.
 * User: Yi
 * Date: 2016/4/14
 * Time: 11:39
 * $Id: urlaction.php 2317 2016-04-28 06:34:57Z wangchangjiang $
 * Topic: 将tobingo数据库的部分表，移动、追加（不覆盖原有）到cheping数据库的部分相同表中
 */
class urlaction extends action{

    var $url;

    function __construct(){
        parent::__construct();
        $this->checkAuth(101, 'sys_module', 'A');
    }

    function doDefault() {
        $this->dobg2cp();
    }
    // <冰狗tobingo>数据库 数据表的数据 【移入】(不替换，只追加)  <车评cheping>数据库 相同数据名的数据表中
    function dobg2cp(){
        header('Content-type: text/html; charset=utf-8');
        set_time_limit(0);
        $start_time = time();
        //获取被追加数据表-表名
        $table1 = $this->getValue('table')->String();
        //获取源数据表-表名
        $table2 = $this->getValue('table2')->String();
        if($table1 && $table2 && $table1!=$table2) {
            //实例化表
            $this->cheping_tab1 = new cheping_model($table1);
            $this->cheping_tab2 = new cheping_model($table2);
            //检测表名是否存在
            $is_error1 = $this->cheping_tab1->selectTab();
            $is_error2 = $this->cheping_tab2->selectTab();
            if($is_error1 && $is_error2){
                //获取源数据表的数据总条数
                $tab2_num = $this->cheping_tab2->getDataNum();
                $counting = 0;//计数器，统计共插入多少条
                $nums = 10000; //每次插入多少条

                //拼接要插入的字段名
                $fields = '';
                $tab1_fields = array_keys($is_error1);
                $tab2_fields = array_keys($is_error2);
                foreach($tab1_fields as $k =>$v){
                    if(in_array($v, $tab2_fields)){
                        if($v!='id') {
                            $fields .= $v . ", ";
                        }
                    }
                }
                $fields = rtrim($fields,', ');

                for($i=0;$tab2_num > ($nums * $i);$i++){
                    $first = $nums * $i;
                    $this->cheping_tab1->insertFileData($table1,$table2, $fields, $first, $nums);
                }
                $counting = $tab2_num;
                $end_time = time();
                $time = $end_time - $start_time - 8*3600;
                $time = date('H时i分s秒', $time);
                echo "共插入：<font style='color:#ff0d0c'> $counting </font>条，用时：$time";
            }else{
                if(!$is_error1 && $is_error2) {
                    echo "Error:  被插入数据table=参数表名不存在!";
                }elseif($is_error1 && !$is_error2){
                    echo "Error:  源数据table2=参数表名不存在!";
                }elseif(!$is_error1 && !$is_error2){
                    echo "Error:  源数据table2=参数表名和被插入数据table=参数表名都不存在!";
                }
            }
        }else{
            if(!$table1 && $table2) {
                echo "Error:  url没有传入被插入数据table=参数表名!";
            }elseif($table1 && !$table2){
                echo "Error:  url没有传入源数据table2=参数表名!";
            }elseif(!$table1 && !$table2){
                echo "Error:  url没有传入源数据table2=参数表名，和被插入数据table=参数表名!";
            }elseif($table1 == $table2){
                echo "Error:  url传入源数据table2=参数表名和被插入数据table=参数表名不能相同!";
            }
        }

    }


    //删除数据库重复数据
    function dodelRepeat(){
        header('Content-type: text/html; charset=utf-8');
        set_time_limit(0);
        $start_time = time();
        //获取要删除重复数据的表名
        $table = $this->getValue('table')->String();
        //获取要删除重复值的字段
        $field = $this->getValue('field')->String();
        if($table && $field){
            //实例化表
            $this->cheping_tab = new cheping_model($table);
            //检测表名是否存在
            $is_error = $this->cheping_tab->selectTab();
            $counting = 0; //统计删除的条数
            if($is_error){
                $fields_arr = $this->cheping_tab->getRepeatData($field);
                $repeat_num = count($fields_arr); //总的重复条数
                if($fields_arr) {
                    foreach ($fields_arr as $k => $v) {
                        $id = $this->cheping_tab->getRepeatDataId($v);
                        if ($id) {
                            $id = intval($id);
                            $is_del = $this->cheping_tab->delRepeatData($id);
                            if ($is_del) {
                                $counting += $is_del;
                            }
                        }
                    }
                }
                $end_time = time();
                $time = $end_time - $start_time - 8*3600;
                $time = date('H时i分s秒', $time);
                $surplus = $repeat_num - $counting;//剩余条数据
                if (!$surplus) {
                    echo "删除成功！共删除：<font style='color:#ff0d0c'> $counting </font>条，用时：$time";
                } else {
                    echo "共：<font style='color:#ff0d0c'> $repeat_num </font>条重复，剩余：<font style='color:#ff0d0c'> $surplus </font>条，用时：$time";
                }
            }else{
                echo "Error:  要删除重复数据的table=参数表名不存在!";
            }
        }else{
            if(!$table && $field) {
                echo "Error:  url没有传入要删除重复数据table=参数表名!";
            }elseif($table && !$field){
                echo "Error:  url没有传入要删除重复数据field=字段名!";
            }elseif(!$table && !$field){
                echo "Error:  url没有传入要删除重复数据table=参数表名，和field=字段名!";
            }
        }
    }

    //权限
    function checkAuth($id, $module_type = 'sys_module', $type_value = "A") {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, $module_type, $id, 'A');
    }

}