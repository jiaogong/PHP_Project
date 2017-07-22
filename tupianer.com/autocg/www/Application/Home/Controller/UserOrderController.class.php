<?php

namespace Home\Controller;
use Think\Upload;
/**
 * 前台用户订单控制器
 * 1.模型订单
 * 2.图片订单
 */
class UserOrderController extends HomeController {

    // 模型订单
    public function order_model() {

        $upload_model_id = I('get.model_id');//模型作品id
        $upload_model_id = 20;
        if($upload_model_id){
            $upload_model = M('upload_model');

            $modelData =  $upload_model -> where('id='.$upload_model_id)->select(); //查询模型作品表
            $coversPic = M('picture');
            if($modelData[0]['covers']){
                $coversData =  $coversPic -> where('id='.$modelData[0]['covers'])->select();
                $pic_path = $coversData[0]['path'].'b_'.$coversData[0]['savename'];
            }

            $this->assign('pic_path',$pic_path);
            $this->assign('model_data',$modelData[0]);


            $this->display();
        }else{
             $this->error('不存在的模型作品文件');
        }
    }

    // 图片订单
    public function order_pic() {
        $upload_pic_id = I('get.pic_id');
        $upload_pic_id = 24;
        if($upload_pic_id){

            $upload_pic = M('upload_pic');

            $picData =  $upload_pic -> where('id='.$upload_pic_id)->select(); //查询模型作品表
            $coversPic = M('picture');
            if($picData[0]['covers']){
                $coversData =  $coversPic -> where('id='.$picData[0]['covers'])->select();
                $pic_path = $coversData[0]['path'].'b_'.$coversData[0]['savename'];
            }

            $this->assign('pic_path',$pic_path);
            $this->assign('pic_data',$picData[0]);



            $this->display();
        }else{
             $this->error('不存在的图片作品文件');
        }
    } 

}
