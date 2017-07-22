<?php
namespace Home\Controller;
use Think\Controller;
class DiscussController extends Controller {
    
    //添加评论
    public function add(){
        //创建对象
        $content = M('content');
        $res['addtime']= date('Y-m-d');
        $res =I()+$res;
        // var_dump($res);die;
        if($content->add($res)){
            $this->ajaxReturn(1);
        }else{
            $tihs->ajaxReturn(0);
        }
    }

    //查看评论
    public function look(){
        //创建对象
        $content = M('content');
        $where['uid']=I('post.uid');
        $where['gid']=I('post.gid');
        $where['uname']=I('post.uname');
        $res = $content->where($where)->select();
        if($res){
            $this->ajaxReturn($res);
        }
    }
    //删除评论
    public function delete(){
        //创建对象
        $content = M('content');
        $res = $content->where(I())->delete();
        if($res){
            $this->ajaxReturn(1);
        }else{
            $this->ajaxReturn(0);
        }
    }

}