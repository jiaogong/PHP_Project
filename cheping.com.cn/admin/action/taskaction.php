<?php

/**
 * $Id: taskaction.php 1174 2015-11-05 01:22:27Z xiaodawei $
 */
class taskAction extends action {

    var $brand;
    var $factory;
    var $series;
    var $task;
    var $taskUser;
    var $user;
    
    function __construct() {
        parent::__construct();
        $this->checkAuth(703);
        $this->brand = new brand();
        $this->factory = new factory();
        $this->series = new series();
        $this->task = new seriesTask();
        $this->taskUser = new taskUser();
        $this->user = new user();
        $nav = array(
            'seriesList' => '车系管理',
//            'giveTask' => '分配任务',
//            'manageTask' => '管理任务'
        );
        $linkman = $this->user->getFields('uid, realname', "gid = 8", 4);
        $this->vars('nav', $nav);
        $this->vars('linkman', $linkman);
    }

    function doDefault() {
        $this->doSeriesList();
    }

    function doChangeLinkman() {
        $taskId = $this->getValue('tid')->Int();
        $uid = $this->getValue('uid')->Int();
        $state = $this->getValue('state')->Int();
        $ufields = array(
            'task_id' => $taskId,
            'uid' => $uid,
            'state' => $state
        );
        $id = $this->taskUser->getTaskUser('id', "task_id = $taskId AND uid = $uid", 3);
        if ($id)
            $result = $this->taskUser->updateTaskUser($id);
        else
            $result = $this->taskUser->insertTaskUser($ufields);
        echo $result ? 1 : 0;
    }

    function doChangeGrade() {
        $grade = $this->getValue('grade')->String();
        $seriesId = $this->getValue('sid')->Int();
        if ($grade && $seriesId)
            $result = $this->series->updateSeries(array('grade' => $grade), $seriesId);
        
            $seriesprice = new seriespriceAction ();
            $seriesprice->sid =$seriesId;
            //同步车系车款
            $seriesprice->doGoodsAdd();
            //更新价格
            $seriesprice->doUpdatePriceToGoodsSearch();
            
        echo $result ? 1 : 2;
    }

    function doManageTask() {
        $templateName = 'task_manage';
        
        $stime = $this->getValue('stime')->Int();
        $startTime = $this->postValue('start_time')->Int($stime);
        $etime = $this->getValue('etime')->Int();
        $endTime = $this->postValue('end_time')->Int($etime);
        
        $mpurl = $_ENV['PHP_SELF'] . 'manageTask&stime=' . $startTime . '&etime=' . $endTime;
        $page = $this->getValue('page')->Int();
        $curpage = max($page, 1);
        $perpage = $limit = 20;
        $offset = ($curpage - 1) * $perpage;
        $seriesTask = $this->task->getSeriesTask($startTime, $endTime, $limit, $offset);
        $num = $this->task->num;
        foreach ($seriesTask as $k => $v) {
            $taskId = $v['task_id'];
            $seriesTask[$k]['user'] = $this->taskUser->getTaskUser('uid as tid, uid', "task_id = $taskId AND state = 0", 4);
        }
        $pageBar = $this->multi($num, $perpage, $curpage, $mpurl);
        $this->vars('pageBar', $pageBar);
        $this->vars('seriesTask', $seriesTask);
        $this->template($templateName);
    }

    function doGiveTask() {
        $templateName = 'task_give';
        $maxRow = 5;
        if (!empty($_POST)) {
            $maxRow = $this->postValue('maxRow')->Int();
            $linkman = $this->postValue('linkman')->Val();
            for ($i = 0; $i < $maxRow; $i++) {
                if ($this->postValue('series_id' . $i)->Val()) {
                    $ufields = array(
                        'brand_id' => $this->postValue('brand_id' . $i)->Int(),
                        'factory_id' => $this->postValue('factory_id' . $i)->Int(),
                        'start_time' => $this->postValue('start_time')->Int(),
                        'end_time' => $this->postValue('end_time')->Int(),
                        'grade' => $this->postValue('grade')->Val()
                    );
                    $taskId = $this->task->insertTask($ufields);
                    $ufields = array('task_id' => $taskId);
                    foreach ($linkman as $uid) {
                        $ufields['uid'] = $uid;
                        $this->taskUser->insertTaskUser($ufields);
                    }
                }
            }
            $this->alert('操作成功！', 'js', 3, '?action=task-giveTask');
            exit;
        }
        $this->vars('maxRow', $maxRow);
        $carSelect = $this->task->getSelectInfo();
        $this->vars('carSelect', $carSelect);
        $this->template($templateName);
    }

    /**
     * 车系分级列表
     * 模板：task_series_list.htm
     * 
     * @param int $bid 品牌ID
     * @param int $fid 厂商ID
     * @param int $sid 车系ID
     */
    function doSeriesList() {
        $templateName = 'task_series_list';
        $sid = $this->requestValue('sid')->Int();
        $bid = $this->requestValue('bid')->Int();
        $fid = $this->requestValue('fid')->Int();
        
        $where = 'cs.state in (3, 7, 8) AND cb.brand_id = cs.brand_id AND cf.factory_id = cs.factory_id';
        if ($sid)
            $where .= " AND cs.series_id = $sid";
        #如果品牌ID存在，取出其下所有厂商数据
        if ($bid || $fid) {
            $factory = $this->factory->getFactoryByBrand($bid);
            $where .= " and cb.brand_id='{$bid}'";
        }
        #如果存在厂商ID，取出其下所有车系
        if ($fid || $sid) {
            $series = $this->series->getSeriesdata("*","factory_id='{$fid}' and state in (3,8)");
            $where .= " and cf.factory_id='{$fid}'";
        }
        
        $mpurl = $_ENV['PHP_SELF'] . "&bid={$bid}&fid={$fid}&sid={$sid}";
        
        $page = $this->getValue('page')->Int();
        $curpage = max($page, 1);
        $perpage = $limit = 20;
        $offset = ($curpage - 1) * $perpage;
        $result = $this->series->getTaskList('cs.brand_name, cs.series_id, cs.series_name, cs.factory_name, cs.grade', $where, $limit, $offset);
        $num = $this->series->num;
        
        $pageBar = $this->multi($num, $perpage, $curpage, $mpurl);
        $carSelect = $this->task->getSelectInfo();
        
        $this->vars('result', $result);
        $this->vars('pageBar', $pageBar);
        $this->vars('carSelect', $carSelect);
        $this->vars('sid', $sid);
        $this->vars('bid', $bid);
        $this->vars('fid', $fid);
        $this->vars('factory', $factory);
        $this->vars('series', $series);
        
        $this->template($templateName);
    }

    function checkAuth($id, $module_type = 'sys_module', $type_value = "A") {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, $module_type, $id, 'A');
    }

}

?>
