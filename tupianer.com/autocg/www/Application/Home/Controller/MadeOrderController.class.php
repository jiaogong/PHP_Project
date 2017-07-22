<?php

namespace Home\Controller;

use OT\DataDictionary;
use Think\Upload;
use Think\Image;

/**
 * 前台订制订单控制器
 * json_decode(think_decrypt($list[0]['pact'])) 合同解密
 */
class MadeOrderController extends HomeController {

    ///定制订单选择页
    public function made_index() {
        $this->display();
    }

    // 下单页（定制订单 - 视频脚本）
    public function video_script() {
        
        //获取 产品（车型）
        $brandList = $this-> get_brand(); 

        //上传附件        
       $type = 'MadeVideoScript';
       $file_type = $this->made_upload_type($type);
       
        if($file_type['file_styles_id']){
            $data['reference_style'] = $file_type['file_styles_id'];
        }
        if($file_type['file_background_id']){
            $data['background'] = $file_type['file_background_id'];
        }
        if($file_type['file_annex_id']){
            $data['annex'] = $file_type['file_annex_id'];
        }
        //写入数据库
        $made_order_video  = M('made_order_video');
//        $made_video_id = $made_order_video->data($data)->add();
        
        $this->assign("carLogoList",$brandList['carLogoList']);//品牌
        $this->assign("carTypeList",$brandList['carTypeList']);//车系
        $this->assign("carModelList",$brandList['carModelList']);//车款
  
        // 保存成功
//        if($made_video_id){
//              echo '<script language="JavaScript">alert("保存成功");</script>;'; 
//        }
        
               
       
        $this->display();
    }

    // 下单页（定制订单 - 产品说明书）
    public function manual() {
        
        //获取 产品（车型）
        $brandList = $this-> get_brand();
        
        //上传附件
       $type = 'MadeManual';
       $file_type = $this->made_upload_type($type);
       
        if($file_type['file_styles_id']){
            $data['reference_style'] = $file_type['file_styles_id'];
        }
        if($file_type['file_background_id']){
            $data['background'] = $file_type['file_background_id'];
        }
        if($file_type['file_annex_id']){
            $data['annex'] = $file_type['file_annex_id'];
        }
        //写入数据库
        $made_order_video  = M('made_order_video');
//        $made_video_id = $made_order_video->data($data)->add();

        $this->assign("carLogoList",$brandList['carLogoList']);//品牌
        $this->assign("carTypeList",$brandList['carTypeList']);//车系
        $this->assign("carModelList",$brandList['carModelList']);//车款
  
        // 保存成功
//        if($made_video_id){
//              echo '<script language="JavaScript">alert("保存成功");</script>;'; 
//        }
        
        
        
        $this->display();
    }

    // 下单页（定制订单 - 广告图）
    public function ad_pic() {
        
        //获取 产品（车型）
        $brandList = $this-> get_brand();

        //上传附件        
        $type ='MadeAdPic';
         $file_type = $this->made_upload_type($type);
         
        if($file_type['file_styles_id']){
            $data['reference_style'] = $file_type['file_styles_id'];
        }
        if($file_type['file_background_id']){
            $data['background'] = $file_type['file_background_id'];
        }
        if($file_type['file_annex_id']){
            $data['annex'] = $file_type['file_annex_id'];
        }
        //写入数据库
        $made_order_video  = M('made_order_video');
//        $made_video_id = $made_order_video->data($data)->add();

        $this->assign("carLogoList",$brandList['carLogoList']);//品牌
        $this->assign("carTypeList",$brandList['carTypeList']);//车系
        $this->assign("carModelList",$brandList['carModelList']);//车款
  
        // 保存成功
//        if($made_video_id){
//              echo '<script language="JavaScript">alert("保存成功");</script>;'; 
//        }
        
        
        
        $this->display();
    }

    // 下单页（定制订单 - 模型）
    public function model() {
        
        //获取 产品（车型）
        $brandList = $this-> get_brand();
        
        //上传附件
        $type ='MadeModel';
        $file_type = $this->made_upload_type($type);
        
        
        if($file_type['file_styles_id']){
            $data['reference_style'] = $file_type['file_styles_id'];
        }
        if($file_type['file_background_id']){
            $data['background'] = $file_type['file_background_id'];
        }
        if($file_type['file_annex_id']){
            $data['annex'] = $file_type['file_annex_id'];
        }
        //写入数据库
        $made_order_video  = M('made_order_video');
//        $made_video_id = $made_order_video->data($data)->add();

        $this->assign("carLogoList",$brandList['carLogoList']);//品牌
        $this->assign("carTypeList",$brandList['carTypeList']);//车系
        $this->assign("carModelList",$brandList['carModelList']);//车款
  
        // 保存成功
//        if($made_video_id){
//              echo '<script language="JavaScript">alert("保存成功");</script>;'; 
//        }
        
        $this->display();
    }

    //下单页（定制订单 - 视频）
    public function video() {
        
        //获取 产品（车型）
        $brandList = $this-> get_brand();
        
        $data = I('post.');

        //上传附件
        $type ='MadeVideo';
//        $file_type = $this->made_upload_type($type); 
        
//        if($file_type['file_styles_id']){
//            $data['reference_style'] = $file_type['file_styles_id'];
//        }
//        if($file_type['file_background_id']){
//            $data['background'] = $file_type['file_background_id'];
//        }
//        if($file_type['file_annex_id']){
//            $data['annex'] = $file_type['file_annex_id'];
//        }
//        

            // if($data){
                $data['service_charge'] = '0.15';
                $data['taxes'] = '0.0672';
            //写入数据库
                $made_order_video  = M('made_order_video');
//              $made_video_id = $made_order_video->data($data)->add();
            // }
        $this->assign("carLogoList",$brandList['carLogoList']);//品牌
        $this->assign("carTypeList",$brandList['carTypeList']);//车系
        $this->assign("carModelList",$brandList['carModelList']);//车款
  
        // 保存成功
//        if($made_video_id){
//              echo '<script language="JavaScript">alert("保存成功");</script>;'; 
//        }
        
        $this->display();
    }

    // 订单详情页（定制订单 - 视频脚本）
    public function videoScirpt_detail() {
        $this->display();
    }

    // 订单详情页（定制订单 - 产品说明书）
    public function manual_detail() {
        $this->display();
    }

    // 订单详情页（定制订单 - 广告图）
    public function adPic_detail() {
        $this->display();
    }

    // 订单详情页（定制订单 - 模型）
    public function model_detail() {
        $this->display();
    }

    //订单详情页（定制订单 - 视频）
    public function video_detail() {
        $this->display();
    }
    
    
     //返回上传附件后的id
    private function made_upload_type($type){
        //$reference_style = '参考风格'; //  'file1' =  '参考风格'  'file2' =  '背景要求'   'file3' =  '附件'
        if ($_FILES['file1']) {
             $remark = '参考风格';
             $fileName = 'file1';
            $file_styles_id = $this->made_upload_file($type,$fileName,$remark);
        }
        if($_FILES['file2']) {
            $remark = '背景要求';
             $fileName = 'file2';
           $file_background_id = $this->made_upload_file($type,$fileName,$remark);
        }
        if($_FILES['file3']) {
            $remark = '附件';
             $fileName = 'file3';
            $file_annex_id = $this->made_upload_file($type,$fileName,$remark);
        }
        $file_type = array('file_styles_id'=>$file_styles_id, 'file_background_id'=>$file_background_id, 'file_annex_id'=>$file_annex_id);
        return $file_type;
    }
    
    //上传附件
    private function made_upload_file($type,$fileName,$remark) {

        $upload = new \Think\Upload(); // 实例化上传类    
        $upload->maxSize = 100 * 1024 * 1024; // 设置附件上传大小 100M   
        $upload->exts = array('zip', 'rar'); // 设置附件上传类型
        $upload->saveName = array('uniqid', ''); //图片的命名唯一
        $upload->savePath = '/Attachment/'.$type.'/'; // 设置附件上传目录  
        $upload->autoSub = true; //上传子目录开启
        $upload->subName = array('date', 'Y-m-d');  // 子目录的命名 
        // 上传单个文件     
        $info = $upload->upload();
        // 上传成功 获取上传文件信息         
        $pic = M('file');
        $data['name'] = $info[$fileName]['name'];  //原始文件名
        $data['file_channel'] = $type;  //文件所属频道
        $data['path'] = "/Uploads" . $info[$fileName]['savepath'];  //文件保存的路径
        $data['savename'] = $info[$fileName]['savename']; //保存名称
        $data['savepath'] = "/Uploads" . $info[$fileName]['savepath'] . $info[$fileName]['savename'];
        $data['md5'] = $info[$fileName]['md5'];
        $data['size'] = $info[$fileName]['size'];
        $data['ext'] = $info[$fileName]['ext'];
        $data['sha1'] = $info[$fileName]['sha1'];
        $data['mime'] = 'zip';
        $data['remark'] = $remark;
        $data['create_time'] = time();
        //添加到数据库，并返回对应的id
        $file_upload_id = $pic->data($data)->add();
        return $file_upload_id;
    }
    
    //获取 产品（车型）
    private function get_brand(){
        //产品（车型）
        $brand = M('brand');
        $carLogoList = $brand->group('brand')->field('brand')->select();
        $carTypeList = $brand->group('series')->field('series')->select();
        $carModelList = $brand->group('car')->field('car')->select();
        
        $brandList = array('carLogoList' => $carLogoList,'carTypeList' => $carTypeList,'carModelList' => $carModelList);
        return $brandList;
    }

}
