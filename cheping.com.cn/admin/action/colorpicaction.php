<?php
/* 
 * colorpic action
 * $Id:colorpicaction.php 2 2013-3-20 13:52
 * @author Yanhongwei$
 */
class colorpicAction extends action{
    var $colorpic;
    var $upload;
    function  __construct() {
        parent::__construct();
        $this->colorpic=new colorpic();
        $this->upload = new uploadFile();
    }
    function doDefault(){
        $this->doList();
    }
    function doList(){
        $this->tpl_file = "colorpic_list";
        $this->page_title  ="车身颜色列表";
        $tpl_name='colorpic_list';
        $where='1';
        $order=array('id'=>'desc');
        $page_size='20';
        $page=max(1,$this->getValue('page')->Int());
        $page_start=($page-1)*$page_size;
        $list=$this->colorpic->getAllColorPic($where,$order,$page_size,$page_start);//var_dump($list);exit;
        foreach($list as $k => $v){
            $list[$k]['pic'] =RELAT_DIR . UPLOAD_DIR . 'images/' . $v['pic'];
        }
        $page_bar = $this->multi($total=$this->colorpic->total, $page_size, $page, $_ENV['PHP_SELF']);
        $this->tpl->assign('page_bar',$page_bar);
        $this->tpl->assign('list',$list);
        $this->template($tpl_name);
    }
    function doAdd(){
        $this->tpl_file = "colorpic_add";
        $this->page_title  ="添加车身颜色";
        if($_POST){
            //将汉字转为拼音
            if($name=$this->upload->uploadColorPic($_FILES['pic'])){
                $this->colorpic->ufields = array(
                    'name'=>$this->postValue('name')->String(),
                    'pic'=>'color/' . $name,
                );
                if($this->colorpic->insert()){
                    $this->alert("图片添加成功！", 'js', 3, $_ENV['PHP_SELF']);
                }else{
                    $this->alert("图片添加失败！", 'js', 3, $_ENV['PHP_SELF']);
                }
            }else{
                $this->alert("图片添加失败！", 'js', 3, $_ENV['PHP_SELF']);
            }
        }else{
            $tpl_name="colorpic_add";
            $this->template($tpl_name);
        }
    }
    function doEdit(){
        $this->page_title="修改车身颜色";
        $this->tpl_file = "colorpic_edit";
        if($_POST){
            $id = $this->postValue('id')->Int();
            $name = $this->postValue('name')->String();
            $this->colorpic->where = "id<>'{$id}' and name='{$name}'";
            $this->colorpic->fields = "count(id)";
            $count = $this->colorpic->getResult(3);
            if($count){
                $this->alert("名称“{$name}”已经在在，请改名后提交！", 'js', 2);
            }else{
                //只修改颜色名称
                if(empty($_FILES['pic']['name'])){
                    $this->colorpic->ufields = array(
                        'name' => $name,
                    );
                    $this->colorpic->where="id='{$id}'";
                    $this->colorpic->update();
                    $this->alert("名称修改成功", 'js', 3, $_ENV['PHP_SELF']);
                }else{
                    //名称图片一同修改
                    $this->colorpic->where = "id='{$id}'";
                    $this->colorpic->fields = "pic";
                    $pic = $this->colorpic->getResult(3);
                    $pic=ATTACH_DIR.'images/'.$pic;
                    @unlink($pic);
                    if($pic=$this->upload->uploadColorPic($_FILES['pic'])){
                        $name=$this->postValue('name');
                        $this->colorpic->ufields = array(
                            'name'=>$name,
                            'pic'=>'color/' . $pic,
                        );
                        $this->colorpic->where = "id='{$id}'";
                        if($this->colorpic->update()){
                            $this->alert("修改成功！", 'js', 3, $_ENV['PHP_SELF']);
                        }else{
                            $this->alert("修改失败！", 'js', 3, $_ENV['PHP_SELF']);
                        }
                    }else{
                        $this->alert("修改失败！", 'js', 3, $_ENV['PHP_SELF']);
                    }
                }
            }
        }else{
            $tpl_name="colorpic_edit";
            $list=$this->colorpic->getColorpicById($this->getValue('id')->Int());
            $list['pic'] = RELAT_DIR . UPLOAD_DIR . 'images/' . $list['pic'];
            $this->tpl->assign('list',$list);
            $this->template($tpl_name);
        }
    }
    function doDel(){
      $id=$this->getValue('id')->Int();
      $this->colorpic->where = "id='{$id}'";
      $this->colorpic->fields = "pic";
      $pic = $this->colorpic->getResult(3);
      $pic=ATTACH_DIR.'images/'.$pic;
      $mm = @unlink($pic);  
      $ret = $this->colorpic->del();
      if($ret){
        $msg = "成功";
      }else{
        $msg = "失败";
      }
      $this->alert("车身颜色删除{$msg}!", 'js', 3, $_ENV['PHP_SELF'] . $qs);
    }
}
?>
