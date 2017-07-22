<?php
/* 
 * cardb_colorpic
 * $Id: colorpic.php 202 2013-03-22 13:41:12Z yanhongwei $
 */
class colorpic extends model{
    function __construct(){
      parent::__construct();
      $this->table_name = "cardb_colorpic";
    }

    function getAllColorPic($where='1',$order=array(),$limit=1,$offset=0){
      $this->where = $where;
      $this->fields = "count(id)";
      $this->total = $this->getResult(3);
      
      $this->fields = "*";
      $this->where = $where;
      $this->limit=$limit;
      $this->offset = $offset;
      return $this->getResult(2);
    }

    function uploadPic($name, $dir) {
      if($_FILES[$name]['error'] == 0 && is_uploaded_file($name)) {
          $ext = end(explode('.', $_FILES[$name]['name']));
          $path = $dir.'/'.$name.time().'.'.$ext;
          file::forcemkdir(ATTACH_DIR.'images/'.$dir);
          $upfile = ATTACH_DIR.'images/'.$path;
          $ret = copy($_FILES[$name]['tmp_name'], $upfile);
          if($ret) return $path;
          else return false;
      }
      else return false;
    }
    function getColorpicById($id){
        $this->fields="*";
        $this->where="id='{$id}'";
        return $this->getResult(1);
    }
    function getColorpic(){
        $this->fields = "*";
        return $this->getResult(2);
    }
  }
?>
