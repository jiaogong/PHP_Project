<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function _initialize(){
		$sid = session('admin_id');
		if(empty($sid)){
			$this->error('您还没有登陆,请登陆...',U('Admin/Login/login'),3);
		}

		//检测用户权限
		//创建权限对象
		$AUTH = new \Think\Auth();
		//类库位置应该位于ThinkPHP\Library\Think\
		if(!$AUTH->check(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME, session('admin_id'))){
		    $this->error('没有权限',U('Index/index'));
		}

		$user = M('user');
		$users = $user->select();
		foreach ($users as $key => $value) {
			// var_dump($value['num']);
			$id = array('id'=>$value['id']);
			$u_scores = $value['u_score'];
		
			// var_dump($orderids);die;
			// var_dump($nums);die;
			$userlevel = array();
				if($u_scores >= 10000){
					$userlevel['userlevel'] = 'lv5';
				}else if($u_scores >=5000 && $u_scores < 10000){
					$userlevel['userlevel'] = 'lv4';
				}else if($u_scores >= 2000 && $u_scores < 5000){
					$userlevel['userlevel'] = 'lv3';
				}else if($u_scores >= 500 && $u_scores < 2000){
					$userlevel['userlevel'] = 'lv2';
				}else{
					$userlevel['userlevel'] = 'lv1';
				}
				// var_dump($userlevel);die;
				$users = $user->where($id)->save($userlevel);
		}
	}
}