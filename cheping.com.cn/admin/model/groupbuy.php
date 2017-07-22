<?php
class groupbuy extends model {
    function __construct() {
        parent::__construct();
        $this->table_name = 'cardb_groupbuy';
    } 
  function uploadPic($name, $dir) {
      if($_FILES[$name]['error'] == 0 && is_uploaded_file($_FILES[$name]['tmp_name'])) {
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
  
  function batchUploadPic($name, $dir) {      
      file::forcemkdir(ATTACH_DIR.'images/'.$dir);          
      $pathArr = array();               
      if(!empty($_FILES[$name]['error'])) {
          foreach($_FILES[$name]['error'] as $k => $e) {
              if($e == 0 && is_uploaded_file($_FILES[$name]['tmp_name'][$k])) {
                  $ext = end(explode('.', $_FILES[$name]['name'][$k]));
                  $path = $dir.'/'.$name.$k.time().'.'.$ext;              
                  $upfile = ATTACH_DIR.'images/'.$path;
                  $ret = copy($_FILES[$name]['tmp_name'][$k], $upfile);                                    
                  $pathArr[$k] = $path;
              }
          }          
      }
      else $pathArr[] = $this->uploadPic($name, $dir);
      if(!empty($pathArr)) return $pathArr;
      else return false;
  }             
    function getAllGroupbuy($fields, $offset, $limit) {
        $this->fields = 'count(*)';
        $this->where = 'state in (0, 2)';
        $this->total = $this->getResult(3);
        $this->fields = $fields;
        $this->limit = $limit;
        $this->offset = $offset;        
        $this->order = array('create_time' => 'DESC');        
        $result = $this->getResult(2);
        return $result;
    }
    function getOneField($field, $id) {
        $this->fields = $field;
        $this->where = "id = $id AND state in (0, 2)";
        $result = $this->getResult(3);
        return $result;
    }
    function getOneGroupbuy($id) {
        $this->fields = '*';
        $this->where = "id = $id AND state in (0, 2)";
        $result = $this->getResult();
        return $result;
    }
    function insertGroupbuy($ufields) {
        $this->ufields = $ufields;
        $id = $this->insert();
        return $id;
    }
    function updatedGroupbuy($ufields, $where) {
        $this->ufields = $ufields;
        $this->where = $where;
        $this->update();           
    }
    
    function getData($fields="*" , $where="1" , $order=array() , $offset=0, $limit=0,$type=2){
        $this->fields = $fields;
        if(!empty($limit))
        $this->limit = $limit;
        $this->where = $where;
        if(!empty($offset))
            $this->offset = $offset;
        $this->order = $order;
        $result = $this->getResult($type);
        return $result;
    }


}
?>
