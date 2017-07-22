<?php
/**
 * 产品-产品数据   “图片库轮播图生成”页
 * showpicAction code
 * $Id: showpicaction.php 2153 2016-04-19 04:08:43Z wangchangjiang $
 * @author
 */
class showpicAction extends action{

	function __construct(){
		parent::__construct();
		 $this->pd_obj = new pagedata();
	}

	function doDefault(){
//		$picPageData = $this->pd_obj->getSomePagedata('value',"name='picindex'",1);
//		if($picPageData){
//			$tempValue = unserialize($picPageData['value']);
//			$this->tpl->assign('tempvalue', $tempValue);
//		}
//		$this->tpl->assign('js',array('jtip'));
//        $this->template('showpic');
		$this->doUploadPic();
	}

	/**
	 *图片库轮播图
	 */
	function doUploadPic1(){
		// $temp = array();
		if(!$_FILES['file'] || !$_POST['title'] || !$_POST['link'])
			exit('请填写数据');
		$file = $_FILES['file'];
		$title = $_POST['title'];
		$link = $_POST['link'];
		$uploadDir = SITE_ROOT . '../attach/images/picindex/';
		if(!is_dir($uploadDir) && !empty($uploadDir)){
                file::forcemkdir($uploadDir);
        }
        $this->time_stamp = time();
		$isExist = $this->pd_obj->getSomePagedata('*',"name='picindex'",1);
		if($isExist){
			$old = mb_unserialize($isExist['value']);
		}else{
			$old = array();
		}
		foreach ($file['tmp_name'] as $key => $value) {
			if($value){
				@move_uploaded_file($value, $uploadDir . $this->time_stamp . $key.$key . '.jpg');
				$old[$key+1]['file_pic'] = $this->time_stamp . $key.$key . '.jpg';
				$old[$key+1]['title'] = $title[$key];
				$old[$key+1]['link'] = $link[$key];
			}
		}
		$temp = serialize($old);
		if($isExist){
			$flag = $this->pd_obj->updatePageData(array('value' => $temp, 'updated' => $this->time_stamp), "id={$isExist['id']}");
		}else{
			$flag = $this->pd_obj->insertPageData(array('name' => 'picindex', 'value' => $temp, 'c1' => 'picindex', 'c2' => 1, 'created' => $this->time_stamp, 'updated' => $this->time_stamp));
		}
		if($flag)
			echo '修改成功';
		else
			echo '修改失败';
	}

	function doUploadPic(){
      $this->checkAuth(209, 'sys_module', 'A');
     
      
      $this->page_title = "频道轮播图";
      $tpl_name = "showpic";
      $pd_obj = $this->pd_obj;
      $upload_obj = new uploadFile();
      $pic_num = 5;
      
      if($_POST){
        $ret = array();
        for($i=1; $i<= $pic_num; $i++){
          if($_FILES['pic_' . $i]['size'] == "" and $_POST['pic_h_'.$i] == "") continue;
          $link = $_POST['link_' . $i];
          $title = $_POST['title'.$i];
          $file = $_FILES['pic_' . $i];
          $picalt = $_POST['picalt' . $i];

          $ret[$i] = array(
            'link' => $link,
            'title'=>$title,
			'picalt'=>$picalt
           
          );
          
          if($file['size']){ 
            $pic = $upload_obj->uploadAdPic($file);
            $ret[$i]['pic'] = $pic;
          }else{
            $ret[$i]['pic'] = $_POST['pic_h_' . $i];
          }
          
        }
		$isExist = $pd_obj->getSomePagedata('id',"name='picindex' and c1='picindex' and c2=1",1);
		if($isExist){
			$s = $pd_obj->updatePageData(array('value' => serialize(array($ret)), 'updated' => time()), "id={$isExist['id']}");
		}else{
			$s = $pd_obj->insertPageData(array('name' => 'picindex', 'value' => serialize(array($ret)), 'c1' => 'picindex', 'c2' => 1, 'created' => time(), 'updated' => time()));
		}
        /*$s = $pd_obj->addPageData(array(
          'name' => 'picindex',
          'value' => $ret,
          'c1' => 'index',
          'c2' => '1',
          'c3' => 0,
        ));*/
        if($s){
          $msg = "成功";
        }else{
          $msg = "失败";
        }
        $message = array(
          'type' => 'js',
          'message' => $this->page_title . $msg,
          'act' => 3,
          'url' => $_ENV['PHP_SELF'] . "UploadPic"
        );
        $this->alert($message);
      }else{
        $result = $pd_obj->getPageData(
          array(
            'name' => 'picindex',
            'c1' => 'picindex',
            'c2' => '1',
            'c3' => 0,
          )
        );
        $focus_val = mb_unserialize($result['value']);
        if(empty($focus_val)){
          $tmp = array_fill(1, $pic_num, array());
        }else{
          for($i=1;$i<=$pic_num;$i++){
            if(empty($focus_val[0][$i])){
              $tmp[$i] = array();
            }else{
              $tmp[$i] = $focus_val[0][$i];
            }
          }
        }
        $this->vars('recommendfocus', $tmp);
        $this->vars('pic_num', $pic_num);
        $this->template($tpl_name);
      }
      
    }

    function checkAuth($id, $module_type = 'sys_module', $type_value = "A"){
      global $adminauth, $login_uid;
      $adminauth->checkAuth($login_uid, $module_type, $id, 'A');
    }
    function doImgCode(){
      echo "<img width=230 src='" . RELAT_DIR . UPLOAD_DIR . urldecode(base64_decode($_GET['code'])) . "'>";
      exit;
    } 
	function doGetJson(){
		$fileName = $_GET['file_pic'];
		echo "<img src='". RELAT_DIR . UPLOAD_DIR ."images/picindex/" . $fileName . "'>";
	}
}
?>