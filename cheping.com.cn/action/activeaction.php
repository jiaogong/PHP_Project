<?php

/**
 * $Id: activeaction.php 4462 2013-12-24 07:36:21Z yizhangdong $
 * 
 */
class activeAction extends action {

    function __construct() {
        parent::__construct();
        $this->activelog = new activelog();
        $this->camplucky = new campLucky();
        $this->campdiscount = new campDiscount();
        $this->campseries = new campSeries();
        $this->useractivity = new useractivity();
        $this->users = new users();
        $this->campodds = new campodds();
		$this->campprize = new campprize();
        $this->camp_name = array(
            1 => 'A阵营',
            2 => 'B阵营',
            3 => 'C阵营'
        );        
    }

    function doDefault() {
        $opt = $this->createshow(true);
        if($opt['o']==='make'){
            $this->doUpdateScores();
        }else{
            $this->doActiveIndex();
        }
    }
    /**
     * 投注
     */
    function doBit() {
        $uid = session('uid');
        //被投注人user_id
        $user_id = $_POST['uid'];
        $id = $_POST['id'];
        $timestamp = time();
        $date_time = date("Y-m-d");
        $day_time = date("H") > 12 ? 1 : 0;
        $logFlag = 13;
        if($uid) {
            $scores = intval($_POST['scores']);
            if(!in_array($scores, array(10, 20, 50, 100, 200)) || $scores < 0) {
                echo -1;
                exit;
            }
            $userScores = $this->users->getUser('scores', "uid = $uid", 3);
            $activity = $this->useractivity->getActive('bits, discount_id, camp_id, rank', "id = $id", 1);
            if(!empty($activity)) {                
                $odds = $this->campodds->getTodOdds($activity['discount_id'], $activity['camp_id'],$activity['rank'], $date_time, $day_time);                
                $bits = $activity['bits'] + 1;
                if(!$odds) {
                    echo -3;
                    exit;
                }
                if($userScores - $scores >= 0 && mysql_error() == '') {
                    $rows = $this->users->updateUser($uid, array('scores' => $userScores - $scores, 'new_flag' => $logFlag));
                    if($rows) {                    
                        $this->useractivity->updateUserActivity(array('bits' => $bits), "id = $id");                    
                        $ip = util::getip();
                        $fields = array(
                            'uid' => $uid, 
                            'flag' => $logFlag, 
                            'create_time' => $timestamp, 
                            'scores' => -1 * $scores, 
                            'odds' => $odds, 
                            'discount_id' => $activity['discount_id'],
                            'camp_id' => $activity['camp_id'],
                            'user_id' => $user_id,
                            'ip' => "$ip"
                        );
                        $this->activelog->insertLog($fields);                       
                        echo 1;                                    
                    }
                    exit;
                }
                else echo -2;
            }
        }
    }
    /**
     * 显示投注弹窗
     */
    function doActiveBit() {
        $id = $_GET['id'];
        $campId = $_GET['cid'];
        $uid = session('uid');
        $timestamp = time();
        $bitinfo = $this->useractivity->getBitinfo($id, $campId);        
        $bitinfo['scores'] = $this->users->getUser('scores', "uid = $uid", 3);
        $bitinfo['bit_camp'] = $this->camp_name[$campId] . ' ' . date('Y年', $bitinfo['start_time']) . '第' . $bitinfo['discount_id'] . '期';                
        $rank = $bitinfo['rank'];        
        $discountId = $bitinfo['discount_id'];        
        if($rank < 4 && $rank > 0) {
            $field = 'odds' . $rank;
            $date_time = date("Y-m-d");
            $hour = date('H', $timestamp);
            $day_time = $hour >= 12 ? 1 : 0;
            $order = array(
                'date_time' => 'ASC',
                'day_time' => 'ASC'
                );
            $limit = 3;
            $odds = $this->campodds->getOdds("$field, day_time", "discount_id = $discountId AND camp_id = $campId AND date_time >= '$date_time' AND state = 0",  2, $order, $limit);
            if($day_time == 0) {
                $bitinfo['odds'] = $odds[0][$field];
                $bitinfo['next_odds'] = $odds[1][$field];
            }
            else {
                $bitinfo['odds'] = $odds[1][$field];
                $bitinfo['next_odds'] = $odds[2][$field];                
            }        
            switch ($rank) {
                case '1':
                    $bitinfo['rank'] = '冠军';
                    break;
                case '2':
                    $bitinfo['rank'] = '亚军';
                    break;
                case '3':
                    $bitinfo['rank'] = '季军';
                    break;
                default:
                    if($rank) $bitinfo['rank'] = '第' . $rank . '名';
                    else $bitinfo['rank'] = '';
                    break;
            }

            foreach($bitinfo as &$v) {
                $v = $v;
            }
            $bitinfo = json_encode($bitinfo);
        }
        else $bitinfo = 0;
        echo $bitinfo;
    }
    function doActiveRule() {
        $templateName = 'active_rule';
        $this->vars('css', array('base', 'gcdj_gzhz'));
        $this->vars('js', array('jquery-1.8.3.min', 'global'));
        $this->template($templateName);
    }
    function doUpdateScores() {
        $timestamp = time();
        $fields = 'id, uid, scores, flag';
        $where = "create_time > $timestamp - 120 AND create_time < $timestamp - 15 AND state = 0 AND flag in (2, 3, 4, 7, 8, 9)";
        //$where = "$timestamp - create_time > 60 AND state = 0 AND flag in (2, 3, 4, 7, 8, 9)";
        $activelog = $this->activelog->getActiveLog($fields, $where, 2);
        foreach($activelog as $row) {
            $uid = $row['uid'];
            $scores = $this->users->getUser('scores', "uid = $uid", 3);            
            $ufields = array(
                'scores' => $scores + $row['scores'],
                'new_flag' => $row['flag']
            );
            $this->users->updateUser($uid, $ufields);
            $ufields = array('state' => 1);
            $this->activelog->updateActive($ufields, $row['id']);
        }
    }
    function doForward() {
        $uid = session('uid');
        $logFlag = $_GET['logflag'];
        $flogFlag = $_GET['flogflag'];
        $timestamp = time();
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        //当天开始时间
        $dayStart = mktime(0, 0, 0, $month, $day, $year);
        //当天结束时间
        $dayEnd = mktime(23, 59, 59, $month, $day, $year);         
        if($uid) {
            $userInfo = $this->users->getUserById($uid);
            if (!empty($userInfo)) {
                $fields = 'count(*)';
                $where = "uid = $uid AND flag = $logFlag AND create_time > $dayStart AND create_time < $dayEnd";
                $count = $this->activelog->getActiveLog($fields, $where, 3);
                $newestTime = $this->activelog->getNewestTime($uid, $logFlag);                    
                $newStart = mktime(0, 0, 0, date('m', $newestTime), date('d', $newestTime), date('Y', $newestTime));
                $diffTime = $dayStart - $newStart;
                if($count < 6 && $diffTime >= 3600 * 24) {
//                    $scores = $userInfo['scores'] + 20;
                    //每次转载加20分
//                    $ufields = array(
//                        'scores' => $scores,
//                        'new_flag' => $logFlag
//                        );
//                    $this->users->updateUser($uid, $ufields);                    
                    $ip = util::getip();
                    $fields = array('uid' => $uid, 'flag' => $logFlag, 'create_time' => $timestamp, 'scores' => 2, 'state' => 0, 'ip' => "$ip");
                    $this->activelog->insertLog($fields);                    
//                    $fuid = $userInfo['friend_uid'];
//                    if (!empty($fuid)) {
//                        $friendInfo = $this->users->getUserById($fuid);
//                        if (!empty($friendInfo)) {
////                            $scores = $friendInfo['scores'] + 5;
////                            //朋友转载每次加5分
////                            $ufields = array('scores' => $scores);
////                            $this->users->updateUser($fuid, $ufields);
//                            $fields = array('uid' => $fuid, 'flag' => $flogFlag, 'create_time' => $timestamp, 'scores' => 5, 'state' => 0);
//                            $this->activelog->insertLog($fields);
//                        }
//                    }                        
                }                                                            
            }
        }
    }
    function doActiveOdds() {
        $timestamp = time();
        $discountId = $_GET['did'];
        $date_time = date('Y-m-d');
        $hour = date('H');
        $day_time = $hour >= 12 ? 1 : 0;
        $endTime = $hour <= 12 ? strtotime($date_time . " 12:00:00") : strtotime($date_time . " 24:00:00");
        $order = array(
            'date_time' => 'ASC',
            'day_time' => 'ASC'
        );
        $limit = 3;
        $result = $this->campodds->getOdds("odds1", "discount_id = $discountId AND camp_id = 1 AND date_time >= '$date_time'",  2, $order, $limit);
        if($day_time == 0 || count($result) < 3) $odds = $result;
        else {
            array_shift($result);
            $odds = $result;
        }
        //var_dump($day_time);
        echo json_encode(array('endTime' => $endTime, 'odds' => $odds));
    }
    
    function doActiveIndex() {
        $templateName = 'active';
        $fid = $_GET['fid'];
        if($fid) {
            $ip = util::getip();
            $logId = $this->activelog->getActiveLog('id', "uid = $fid AND ip = '$ip'", 3);
            if(!$logId) {
                $friendScores = $this->users->getUser('scores', "uid = $fid", 3);
                $ufields = array('scores' => $friendScores + 5, 'new_flag' => 17);
                $this->users->updateUser($fid, $ufields);                
                $ufields = array(
                    'uid' => $fid,
                    'ip' => "$ip",
                    'flag' => 17,
                    'scores' => 5,
                    'create_time' => time()
                );
                $this->activelog->insertLog($ufields);
            }
        }        
        $this->vars('uname', session('uname'));
        $uid = session('uid');
        $week = date('N', time());
        $date_time = date("Y-m-d");
        $weekTittle = array(
            1 => '冰狗购车网_攻城夺金_IPAD大奖每月发，提交发票赢大奖，比比谁更会侃价，参与照样有奖拿！',
            2 => '冰狗购车网_攻城夺金_动动手指获积分，零成本赢取IPAD，多重好礼送不停，有车没车参一手！',
            3 => '冰狗购车网_攻城夺金_舞动你的手指，轻松获取积分，购车只是开始，IPAD油卡在等你！',
            4 => '冰狗购车网_攻城夺金_提交购车发票，免费参加活动，IPAD风暴来袭，惊喜如何抵挡！',
            5 => '冰狗购车网_攻城夺金_上传购车发票，惊喜大奖等你，每日获取积分，赢取IPAD好礼！',
            6 => '冰狗购车网_攻城夺金_IPAD近在咫尺，仅需动动手指，机会不可失，失则不再来！',
            7 => '冰狗购车网_攻城夺金_提交购车发票，免费赢取好礼，人人有机会，大奖送不停！'
            
        );
        $description = "提交购车发票并且攻擂成功就有机会赢取加油卡、充值卡等多重礼遇。为了回馈广大网友，只要您成功邀请好友注册，每天登陆网站，转发活动微博，同样也有机会赢取奖品……";
        $keywords = "提交购车发票赠送加油卡、充值卡、转发、微博、注册、冰狗、bingocar、冰狗网、冰狗购车网、冰狗暗访价、冰狗商情、汽车行情、汽车价格、网上买车、网上购车、bingo、汽车、买车、买车网、购车、购车网、汽车网、北京买车、汽车报价、大众、日产、丰田、本田、车价计算";        
        $this->vars('keywords', $keywords);
        $this->vars('description', $description);
        $this->vars('page_title', $weekTittle[$week]);
        $this->vars('css', array('base', 'gcdj_pindao'));
        $this->vars('js', array('jquery-1.8.3.min', 'global', 'active'));
        $newActiveLog = $this->activelog->getNewlog();
        $activeRank = $this->activelog->getRank();
        $camp = $this->campdiscount->getNewestCamp();
        $luckyPrize = $this->camplucky->getOne($date_time);
        if(!empty($camp)) {
            $timestamp = time();
            $discountId = $camp['id'];            
            $hour = date('H', $timestamp);            
            $day_time = $hour >= 12 ? 1 : 0;
            $endTime = $hour <= 12 ? strtotime($date_time . " 12:00:00") : strtotime($date_time . " 24:00:00");
            $order = array(
                'date_time' => 'ASC',
                'day_time' => 'ASC'
            );
            $limit = 3;
            $result = $this->campodds->getOdds("odds1", "discount_id = $discountId AND camp_id = 1 AND date_time >= '$date_time'",  2, $order, $limit);            
            if($day_time == 0) {
                $odds = $result;
            }
            else {
                array_shift($result);
                $odds = $result;
            }           
            $campSeries = $this->campseries->getCampSeries();
            $submitState = 0;
            $auditState = 3;
            for($i=1; $i<4; $i++) {
                $submitDiscount = 'submitDiscount'.$i;                
                $auditDiscount = 'auditDiscount'.$i;
                $discount = 'discount'.$i;
                $$submitDiscount = $this->campdiscount->sumDiscount($discountId, $i, $submitState);
                $$auditDiscount = $this->campdiscount->sumDiscount($discountId, $i, $auditState);
                $$discount = $this->campdiscount->getDiscount($discountId, $i);
                $this->vars($discount, $$discount);
                $this->vars($submitDiscount, $$submitDiscount);
                $this->vars($auditDiscount, $$auditDiscount);
            }
            if ($uid)
                $myRank = $this->useractivity->getMyrank($uid, $discountId);
            $this->vars('myRank', $myRank);
            $this->vars('endTime', $endTime);
            $this->vars('odds', $odds);            
            $this->vars('campSeries', $campSeries);
            $this->vars('camp', $camp);       
        }
		//获奖名单部分
		$activeInfo = array(array('-','-'),array('-','-'));
		$nextDiscountAPrize = array(array('-'),array('-'),array('-'));
		$nextDiscountBPrize = array(array('-'),array('-'),array('-'));
		$nextDiscountCPrize = array(array('-'),array('-'),array('-'));
		$nextScorePrize = array(array('-'),array('-'),array('-'));
		$nextDiscount = $this->campdiscount->getNextDiscount();
		if($nextDiscount){
			if($nextDiscount['prize1']){
				$nextDiscountAPrize[0]=array($nextDiscount['prize1']);
				$nextDiscountBPrize[0]=array($nextDiscount['prize1']);
				$nextDiscountCPrize[0]=array($nextDiscount['prize1']);
			}
			if($nextDiscount['prize2']){
				$nextDiscountAPrize[1]=array($nextDiscount['prize2']);
				$nextDiscountBPrize[1]=array($nextDiscount['prize2']);
				$nextDiscountCPrize[1]=array($nextDiscount['prize2']);
			}
			if($nextDiscount['prize3']){
				$nextDiscountAPrize[2]=array($nextDiscount['prize3']);
				$nextDiscountBPrize[2]=array($nextDiscount['prize3']);
				$nextDiscountCPrize[2]=array($nextDiscount['prize3']);
			}
			$activeInfo[1] = array($nextDiscount['id'],date('Y-m',$nextDiscount['end_time']));
			$nextDiscount['score_prize1'] && ($nextScorePrize[0] = array($nextDiscount['score_prize1']));
			$nextDiscount['score_prize2'] && ($nextScorePrize[1] = array($nextDiscount['score_prize2']));
			$nextDiscount['score_prize3'] && ($nextScorePrize[2] = array($nextDiscount['score_prize3']));
		}
		$lastDiscount = $this->campdiscount->getLastDiscount();
		$lastScoreRank = array(array('-','-','-','冠军'),array('-','-','-','亚军'),array('-','-','-','季军'));
		$lastDiscountRankA = array(array('-','-','-','冠军'),array('-','-','-','亚军'),array('-','-','-','季军'));
		$lastDiscountRankB = array(array('-','-','-','冠军'),array('-','-','-','亚军'),array('-','-','-','季军'));
		$lastDiscountRankC = array(array('-','-','-','冠军'),array('-','-','-','亚军'),array('-','-','-','季军'));
		if($lastDiscount){
			$activeInfo[0] = array($lastDiscount['id'],date('Y-m',$lastDiscount['end_time']));
			if($lastDiscount['prize_state'] == '1'){
				$lastScoreRank[0][2] = $lastDiscount['score_prize1'];
				$lastScoreRank[1][2] = $lastDiscount['score_prize2'];
				$lastScoreRank[2][2] = $lastDiscount['score_prize3'];
				$scoreRankDB = $this->campprize->getScoreRank($lastDiscount['id']);
				if($scoreRankDB){
					foreach($scoreRankDB as $srlist){
						switch($srlist['rank']){
							case 1:
								$lastScoreRank[0] = array($srlist['uname'],$srlist['scorce'].'分',$srlist['scorce_prize'],'冠军');
							break;
							case 2:
								$lastScoreRank[1] = array($srlist['uname'],$srlist['scorce'].'分',$srlist['scorce_prize'],'亚军');
							break;
							case 3:
								$lastScoreRank[2] = array($srlist['uname'],$srlist['scorce'].'分',$srlist['scorce_prize'],'季军');
							break;
						}
					}
				}
			}
			if($lastDiscount['discount_state'] == 1){
				$lastDiscountRankA[0][2] = $lastDiscountRankB[0][2] = $lastDiscountRankC[0][2] = $lastDiscount['prize1'];
				$lastDiscountRankA[1][2] = $lastDiscountRankB[1][2] = $lastDiscountRankC[1][2] = $lastDiscount['prize2'];
				$lastDiscountRankA[2][2] = $lastDiscountRankB[2][2] = $lastDiscountRankC[2][2] = $lastDiscount['prize3'];
				$discountRankDB = $this->campprize->getDiscountRank($lastDiscount['id']);
				if($discountRankDB){
					foreach($discountRankDB as $drlist){
						switch($drlist['camp_id']){
							case 1:
								if($drlist['rank']==1){
									$lastDiscountRankA[0] = array($drlist['uname'],$drlist['discount_zk'].'折',$drlist['discount_prize'],'冠军');
								}elseif($drlist['rank']==2){
									$lastDiscountRankA[1] = array($drlist['uname'],$drlist['discount_zk'].'折',$drlist['discount_prize'],'亚军');
								}elseif($drlist['rank']==3){
									$lastDiscountRankA[2] = array($drlist['uname'],$drlist['discount_zk'].'折',$drlist['discount_prize'],'季军');
								}
							break;
							case 2:
								if($drlist['rank']==1){
									$lastDiscountRankB[0] = array($drlist['uname'],$drlist['discount_zk'].'折',$drlist['discount_prize'],'冠军');
								}elseif($drlist['rank']==2){
									$lastDiscountRankB[1] = array($drlist['uname'],$drlist['discount_zk'].'折',$drlist['discount_prize'],'亚军');
								}elseif($drlist['rank']==3){
									$lastDiscountRankB[2] = array($drlist['uname'],$drlist['discount_zk'].'折',$drlist['discount_prize'],'季军');
								}
							break;
							case 3:
								if($drlist['rank']==1){
									$lastDiscountRankC[0] = array($drlist['uname'],$drlist['discount_zk'].'折',$drlist['discount_prize'],'冠军');
								}elseif($drlist['rank']==2){
									$lastDiscountRankC[1] = array($drlist['uname'],$drlist['discount_zk'].'折',$drlist['discount_prize'],'亚军');
								}elseif($drlist['rank']==3){
									$lastDiscountRankC[2] = array($drlist['uname'],$drlist['discount_zk'].'折',$drlist['discount_prize'],'季军');
								}
							break;
						}
					}
				}
			}
		}
		$this->vars('activeinfo', $activeInfo);
		$this->vars('lastscorerank', $lastScoreRank);
		$this->vars('lastdiscountranka', $lastDiscountRankA);
		$this->vars('lastdiscountrankb', $lastDiscountRankB);
		$this->vars('lastdiscountrankc', $lastDiscountRankC);
		$this->vars('nextdiscountaprize', $nextDiscountAPrize);
		$this->vars('nextdiscountbprize', $nextDiscountBPrize);
		$this->vars('nextdiscountcprize', $nextDiscountCPrize);
		$this->vars('nextscoreprize', $nextScorePrize);
        $this->vars('luckyPrize', $luckyPrize);        
        $this->vars('newActiveLog', $newActiveLog);
        $this->vars('activeRank', $activeRank);        
        $this->vars('pageindex', 'active');        
        $this->template($templateName);
    }

    //贡献榜更多
    function doIntegralRankList() {
        $this->vars('page_title', '冰狗购车网 - 贡献榜积分排名');
        $this->vars('css', array('base', 'gcdj_pindao', 'grzx', 'content'));
        $this->vars('js', array('jquery-1.8.3.min', 'global'));
        $page_size = 25;
        $page = $_GET[page] ? $_GET[page] : 1;
        $tpl_name = 'integralranklist';
        $result = $this->activelog->getRank(1);
        if ($result) {
            foreach ($result as $k => $v) {
                $result[$k][ranking] = $k + 1;
            }
        }
        #分页  
        if (!empty($result)) {
            $page_total = count($result);
            $this->vars('result_total', $page_total);
            $this->vars('result_total_page', ceil($page_total / $page_size));
            $page_start = ($page - 1) * $page_size;
            $resultArr = array_slice($result, $page_start, $page_size);
            $page_bar = $this->user_multi($page_total, $page_size, $page, "active.php?action=integralranklist", 0, 6);
        }
        $this->vars("page_size", $page_size);
        $this->vars("pagehtml", $page_bar);
        $this->vars("list", $resultArr);
        $this->template($tpl_name);
    }

}

?>
 