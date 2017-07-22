<?php

/**
 * vote action
 * $Id: voteaction.php 1250 2016-03-01 15:08:1Z cuiyuanxin $
 */
class voteAction extends action {
    
//    public $friend;
    public $vote;

    function __construct() {
        parent::__construct();
        $this->vote = new vote();
    }

    function doDefault() {
        $this->doList();
    }
    
    function doList(){
        $tpl_name = "vote_list";
        $fields = "GROUP_CONCAT(audio) audio,GROUP_CONCAT(compass) compass,GROUP_CONCAT(tyre) tyre,GROUP_CONCAT(seats) seats,GROUP_CONCAT(lubricating) lubricating,GROUP_CONCAT(platform) platform,GROUP_CONCAT(certification) certification,GROUP_CONCAT(travel) travel,GROUP_CONCAT(rental) rental,GROUP_CONCAT(tools) tools,GROUP_CONCAT(fmcc) fmcc,GROUP_CONCAT(motors) motors,GROUP_CONCAT(interest) interest";
        $res = $this->vote->getCount($fields,'1',2);
        $array['audio'] = array_count_values(array_filter(explode(',',$res[0]['audio'])));
        $array['compass'] = array_count_values(array_filter(explode(',',$res[0]['compass'])));
        $array['tyre'] = array_count_values(array_filter(explode(',',$res[0]['tyre'])));
        $array['seats'] = array_count_values(array_filter(explode(',',$res[0]['seats'])));
        $array['lubricating'] = array_count_values(array_filter(explode(',',$res[0]['lubricating'])));
        $array['platform'] = array_count_values(array_filter(explode(',',$res[0]['platform'])));
        $array['certification'] = array_count_values(array_filter(explode(',',$res[0]['certification'])));
        $array['travel'] = array_count_values(array_filter(explode(',',$res[0]['travel'])));
        $array['rental'] = array_count_values(array_filter(explode(',',$res[0]['rental'])));
        $array['tools'] = array_count_values(array_filter(explode(',',$res[0]['tools'])));
        $array['fmcc'] = array_count_values(array_filter(explode(',',$res[0]['fmcc'])));
        $array['motors'] = array_count_values(array_filter(explode(',',$res[0]['motors'])));
        if($res[0]['interest'])
            foreach ($re = explode(',',$res[0]['interest']) as $key => $value) {
                switch ($value) {
                    case 1:
                        $re[$key] = "特别";
                        break;
                    case 2:
                        $re[$key] = "还可以";
                        break;
                    case 3:
                        $re[$key] = "几乎没有";
                        break;
                }
            }
        $array['interest'] = array_count_values(array_filter($re));
                
        $this->vars('_list', $array);
        $this->template($tpl_name);
    }
    
    function doUser(){
        $tpl_name = "vote_user";
        $page = $this->getValue('page')->Int(1);
        $page = max(1, $page);
        $page_size = 18;
        $page_start = ($page - 1) * $page_size;
        
        $list = $this->vote->getUser($page_size, $page_start);
        $total = $this->vote->total;
        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . 'user' . $extra);
        
        $this->vars('_list', $list);
        $this->vars('page_bar', $page_bar);
        $this->template($tpl_name);
    }
    
    function doXiangqing(){
        $tpl_name = "vote_xiangqing";
        $res = $this->vote->getCount('*','id='.$_GET['id'],1);
        $this->vars('_list', $res);
        $this->template($tpl_name);
    }

}
