<?php

namespace Home\Controller;
use Think\Upload;
/**
 * 前台作品上传控制器
 * 上传个人作品
 */
class UploadOpusController extends HomeController {

    ///优酷视频上传
    public function youku_upload() {
        $this->display();
    }

    // 优酷上传授权文件
    public function oauth_result() {
        $this->display();
    }

    // 优酷视频播放
    public function youku_play() {
        $this->display();
    }


    //上传图片页
    public function pic_upload() {

        //获取 产品（车型）
        $brandList = $this-> get_brand(); 


        //获取用户id
        $uid = session('uid');
        $uid = 22;

        $data = I('post.');
            if($data){
            $data['uid'] = $uid;

            //优酷视频上传后返回的视频id
            //保存数据库

            //上传作品封面
            if($_FILES['file1']){
                $type ='Pic';
                $remark = '上传作品-图片作品';
                $fileName = 'file1';
                $thumbs = ture;
                $s = 150;
                $m = 300;
                $b = 550;
                $data['covers'] = $this->upload_covers_pic($type,$fileName,$remark,$thumbs,$s,$m,$b);
            }

            $data['created'] = time();

            //添加数据库
            $upload_pic = M('upload_pic');
            $upload_pic_id = $upload_pic->data($data)->add();

            if($upload_pic_id){
                if($data['state']==1){
                     echo '<script language="JavaScript">alert("保存成功");</script>;'; 
                }

            }
        }

        $this->assign("carLogoList",$brandList['carLogoList']);//品牌
        $this->assign("carTypeList",$brandList['carTypeList']);//车系
        $this->assign("carModelList",$brandList['carModelList']);//车款

        $this->display();
    }
    
    //上传视频页
    public function video_upload(){

        //获取 产品（车型）
        $brandList = $this-> get_brand(); 

        //获取用户id
        $uid = session('uid');
        $uid = 22;

        $data = I('post.');

        if($data){
            $data['uid'] = $uid;

            //优酷视频上传后返回的视频id
            //保存数据库

            //上传作品封面
            if($_FILES['covers_s']){
                $type ='Pic';
                $remark = '上传视频作品封面图片';
                $fileName = 'covers';
                $thumbs = ture;
                $s = 150;
                $m = 300;
                $b = 550;
                $data['covers'] = $this->upload_covers_pic($type,$fileName,$remark,$thumbs,$s,$m,$b);
            }

            $data['created'] = time();
            $data['material'] = 3;
            $this->assign("carLogoList",$brandList['carLogoList']);//品牌
            $this->assign("carTypeList",$brandList['carTypeList']);//车系
            $this->assign("carModelList",$brandList['carModelList']);//车款

            //添加数据库
            // $upload_video = M('upload_video');
            // $upload_video_id = $upload_video->data($data)->add();

            // if($upload_video_id){
            //     if($data['state']==1){
            //          echo '<script language="JavaScript">alert("保存成功");</script>;'; 
            //     }

            // }
        }
        $this->display();
    }
    
    //上传模型页
    public function model_upload() {

        //获取 产品（车型）
        $brandList = $this-> get_brand();

        //获取用户id
        $uid = session('uid');
        $uid = 22;

        $data = I('post.');

        if($data){
            $data['uid'] = $uid;

            //上传作品封面
            if($_FILES['covers_s']){
                $type ='Pic';
                $remark = '上传模型作品封面图片';
                $fileName = 'covers_s';
                $thumbs = ture;
                $s = 150;
                $m = 300;
                $b = 550;
                $data['covers'] = $this->upload_covers_pic($type,$fileName,$remark,$thumbs,$s,$m,$b);
            } 

            //上传附件
            if($_FILES['file1']){
                $type ='Model';
                $remark = '上传模型作品附件';
                $fileName = 'file1';
                $fileLayout = array('zip','rar','max','myay',$data['model_format']);
                $data['model_file'] = $this->made_upload_file($type,$fileName,$remark,$fileLayout);
            }
            
            $data['created'] = time();
            $data['material'] = 5;

            //添加数据库
            $upload_model = M('upload_model');
            $upload_model_id = $upload_model->data($data)->add();

            if($upload_model_id){
                if($data['state']==1){
                     echo '<script language="JavaScript">alert("保存成功");</script>;'; 
                }
            }
        }
        $this->assign("carLogoList",$brandList['carLogoList']);//品牌
        $this->assign("carTypeList",$brandList['carTypeList']);//车系
        $this->assign("carModelList",$brandList['carModelList']);//车款

        $this->display();
    }

    //获取 产品（车型）
    private function get_brand(){
        //产品（车型）
        $brand = M('brand');
        $carLogoList = $brand->group('brand')->field('brand')->select();
        $carTypeList = $brand->group('series')->field('series')->select();
        $carModelList = $brand->group('car')->field('car')->select();
        
        $carTypeNum = count($carTypeList);
        $carModelNum = count($carModelList);
        $carTypeList[$carTypeNum] = array('series'=>'其他');
        $carModelList[$carModelNum] = array('car'=>'其他');
        $brandList = array('carLogoList' => $carLogoList,'carTypeList' => $carTypeList,'carModelList' => $carModelList);
        return $brandList;
    }



/**
* 上传附件
* type：上传文件的类型目录  string
* fileName：上传文件的name名  string
* remark：上传文件备注，文件的用途 string
* size：文件上传的大小 int (例如：100 * 1024 * 1024) ！暂不设定
* fileLayout：文件格式 array (例如：array('zip', 'rar'))
*/
    private function made_upload_file($type,$fileName,$remark,$fileLayout) {

        $upload = new \Think\Upload(); // 实例化上传类    
        $upload->maxSize = 100 * 1024 * 1024; // 设置附件上传大小 100M   
        $upload->exts = $fileLayout; // 设置附件上传类型
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


/**
* 上传附件-图片
* type：上传图片的类型目录 string
* fileName：上传图片的name名 string
* remark：上传图片备注，图片的用途 string
* thumbs：是否缩放：is true是缩放  bool
* s：缩放的最小尺寸 int
* m：缩放的中间尺寸 int
* b：缩放的大尺寸  int
*/

    private function upload_covers_pic($type,$fileName,$remark,$thumbs,$s,$m,$d) {

        $upload = new \Think\Upload(); // 实例化上传类    
        $upload->maxSize = 2 * 1024 * 1024; // 设置附件上传大小 2M   
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg','bmp'); // 设置附件上传类型
        $upload->saveName = array('uniqid', ''); //图片的命名唯一
        $upload->savePath = '/Attachment/'.$type.'/'; // 设置附件上传目录  
        $upload->autoSub = true; //上传子目录开启
        $upload->subName = array('date', 'Y-m-d');  // 子目录的命名 
        // 上传单个文件     
        $info = $upload->upload();
        // 上传成功 获取上传文件信息         

        $data['channel'] = $type;  //文件所属频道
        $data['path'] = "/Uploads" . $info[$fileName]['savepath'];  //文件保存的路径
        $data['savename'] = $info[$fileName]['savename']; //保存名称
        $data['savepath'] = "/Uploads" . $info[$fileName]['savepath'] . $info[$fileName]['savename'];
        $data['md5'] = $info[$fileName]['md5'];
        $data['sha1'] = $info[$fileName]['sha1'];
        $data['status'] = 1;
        $data['create_time'] = time();
        $data['ext'] = $info[$fileName]['ext'];
        $data['remark'] = $remark;

        //生成缩略图
        if($thumbs){ 
            $date = date('Y-m-d');
            $picpath = './Uploads/Attachment/'.$type.'/'.$date.'/';
            $image = new \Think\Image();
            if($s){ 
                $image->open($picpath.$data['savename']);
                $image->thumb($s, $s)->save($picpath.'s_'.$data['savename']);//小图
                $data['picinfo'] .= 's_:'.$s.'*'.$s.',';
            }
            if($m){
                $image->open($picpath.$data['savename']);
                $image->thumb($m, $m)->save($picpath.'m_'.$data['savename']);//中图
                $data['picinfo'] .= 'm_:'.$m.'*'.$m.',';
            }
            if($b){
                $image->open($picpath.$data['savename']);
                $image->thumb($b, $b)->save($picpath.'b_'.$data['savename']);//大图
                $data['picinfo'] .= 'b_:'.$b.'*'.$b;
            }
        }

        //添加到数据库，并返回对应的id
        $pic = M('picture');
        $pic_upload_id = $pic->data($data)->add();

        return $pic_upload_id;
    }

}
