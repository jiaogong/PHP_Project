<?php

namespace Home\Controller;
use Think\Page;

/**
 * 前台设计师控制器
 */
class DesignerController extends HomeController {

    //个人设计师页
    public function individual_designers() {
//        if(session('?uid')){
//         $uid = session('uid');
//        }
        $uid = I('get.uid'); //获取用户id
        $uid = 22;
        if ($uid) {
            $user = M('user'); //用户表
            $designer_info = $user->join('tu_user_info ON tu_user.uid = tu_user_info.uid')
                    ->field('tu_user.*,tu_user_info.*')
                    ->where('tu_user.uid = %d', $uid)
                    ->select();

            //作品展示
            $model_opus = M('upload_model'); //模型作品表
            $pic_opus = M('upload_pic'); //图片作品表
            $video_opus = M('upload_video'); //视频作品表
            $model_list = $model_opus->where('uid = %d', $uid)
                    ->order('created desc')
                    ->limit(6)
                    ->select();
            $pic_list = $pic_opus->where('uid = %d', $uid)
                    ->order('created desc')
                    ->limit(6)
                    ->select();

            $video_list = $video_opus->where('uid = %d', $uid)
                    ->order('created desc')
                    ->limit(6)
                    ->select();

            $model_mun = count($model_list);
            $pic_mun = count($pic_list);
            $video_mun = count($video_list);
            $max_num = max($model_mun, $pic_mun, $video_mun);
            $all_list_array = [];
            $all_list=[];
            
            //全部作品时默认显示的行数
            $all_page_num = 2;
            for ($i = 0; $i < $all_page_num; $i++) {
                if ($model_list[$i]) {
                    $all_list_array[$i][0] = $model_list[$i];
                }
                if ($pic_list[$i]) {
                    $all_list_array[$i][1] = $pic_list[$i];
                }
                if ($video_list[$i]) {
                    $all_list_array[$i][2] = $video_list[$i];
                }
                foreach ($all_list_array[$i] as $v){
                  $all_list[] = $v;  
                }
            }
            $tags = I('get.tags');
            if ($tags) {
                if ($tags == 1) {
                    $all_opus_list = $all_list;
                } elseif ($tags == 2) {
                    $all_opus_list = $model_list;
                } elseif ($tags == 3) {
                    $all_opus_list = $pic_list;
                } else {
                    $all_opus_list = $video_list;
                }
            } else {
                $all_opus_list = $all_list;
            }

            $this->assign('$designer_info', $designer_info[0]); // 用户名
            $this->assign('avatar', '/' . $designer_info[0]['avatar']); // 用户头像
            $this->assign('username', $designer_info[0]['username']); // 用户名
            $this->assign('score', $designer_info[0]['score']); // 积分
            $this->assign('popularity', $designer_info[0]['popularity']); // 人气
            $this->assign('focus', $designer_info[0]['focus']); // 关注
            $this->assign('profile', $designer_info[0]['profile']); // 简介
            $this->assign('banner', '/' . $designer_info[0]['banner']); // 头图
            $this->assign('user_type', $designer_info[0]['user_type']); // 用户类型
            $this->assign('uid', $uid); 
            $this->assign('tags', $tags); //选项卡
            $this->assign('all_opus_list', $all_opus_list); //作品展示
        }
        $this->display();
    }

    public function ajax_all_opus(){   
        
        $uid = I('get.uid'); //获取用户id
//        $uid = 22;
        if ($uid) {        
            //作品展示
            $model_opus = M('upload_model'); //模型作品表
            $pic_opus = M('upload_pic'); //图片作品表
            $video_opus = M('upload_video'); //视频作品表
            $model_list = $model_opus->where('uid = %d', $uid)
                    ->order('created desc')
                    ->select();

            $pic_list = $pic_opus->where('uid = %d', $uid)
                    ->order('created desc')
                    ->select();

            $video_list = $video_opus->where('uid = %d', $uid)
                    ->order('created desc')
                    ->select();
        }

            $model_mun = count($model_list);
            $pic_mun = count($pic_list);
            $video_mun = count($video_list);
            $max_num = max($model_mun, $pic_mun, $video_mun);
            $all_list = [];
            $all_list_array = [];
            //全部作品时默认显示的行数
            for ($i = 0; $i < $max_num; $i++) {
                if ($model_list[$i]) {
                    $all_list_array[$i][0] = $model_list[$i];
                }
                if ($pic_list[$i]) {
                    $all_list_array[$i][1] = $pic_list[$i];
                }
                if ($video_list[$i]) {
                    $all_list_array[$i][2] = $video_list[$i];
                }
                foreach ($all_list_array[$i] as $v){
                  $all_list[] = $v;  
                }
            }
            
            //$falls_all发送ajax后的数
            $falls_all = I('post.falls_all');   
            $tags = I('get.tags');
            
            if($falls_all){
                $all_page_num = 6*$falls_all;
            
            
                $model_list = array_slice($model_list,$all_page_num,6,true);
                $pic_list = array_slice($pic_list,$all_page_num,6,true);
                $video_list = array_slice($video_list,$all_page_num,6,true);
                $all_list = array_slice($all_list,$all_page_num,6,true);

                if ($tags) {
                    if ($tags == 1) {
                        $all_opus_list = $all_list;
                    } elseif ($tags == 2) {
                        $all_opus_list = $model_list;
                    } elseif ($tags == 3) {
                        $all_opus_list = $pic_list;
                    } elseif ($tags == 4){
                        $all_opus_list = $video_list;
                    }
                } else {
                    $all_opus_list = $all_list;
                }

                $this->ajaxReturn($all_opus_list);
            }
    }

}
