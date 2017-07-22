<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Dbfile extends model{

    var $pic_type = array(
      1 => array('title'=>'�������'),
      2 => array('title'=>'��������'),
      3 => array('title'=>'�п��Ǳ�'),
      4 => array('title'=>'����ϸ��')
    );

    function __construct() {
        $this->table_name = "cardb_file";
        parent::__construct();
    }
    //
    function getModelPic($fields, $where, $flag = 1, $order = array()) {
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        $result = $this->getResult($flag);
        return $result;
    }
    
    //���ݳ���idȡ��ͼƬ
    function getfiles($model_id,$order=array("id"=>"asc")){
        $this->fields= "*";
        $this->where = "type_name='model' and type_id='$model_id' and ppos =1 ";
        $this->order= array("ppos"=>"desc","pos"=>"asc");        
        $result = $this->getResult(2);        
        return $result;
    }

    //���ݳ���idȡ����ͼ ppos in (1,2,3,4)
    function getOnefile1($model_id){
        $this->fields= "*";
        $this->where = "type_name='model' and type_id='$model_id' and ppos in (1,2,3,4) ";
        $this->order= array("ppos"=>"asc","pos"=>"asc");
        return $this->getResult(2);
    }    

    //����ͼƬ����
    function getPictures($pic){
        if($pic){
            //ͼƬ����
            foreach ($this->pic_type as $key => $value) {
                $i=0;
                foreach ($pic as $k => $v) {
                    if($key==$v["pos"] && $i<4){
                        $new_pic[$value["title"]][]=$v;
                        $i++;
                    }
                }
            }
            return $new_pic;
        }else{
            return "";
        }
    }
    
    function getFilesbyidandpos($model_id,$pos,$order=array("id"=>"asc")){
        $this->fields= "*";
        $this->where = "type_name='model' and type_id='$model_id' and pos ='$pos' ";
        $this->order= array("id"=>"asc","ppos"=>"desc","pos"=>"asc");
        return $this->getResult(2);
    }    
 
    
    //ȡ��������ͼ
    function getModelfile($modelid){
      $this->fields = "*";
      $this->where = " type_name='model' and ppos=1 and type_id='{$modelid}'";
      $this->order =  array("ppos"=>"desc","pos"=>"asc");
      return $this->getResult(1);
    }


    //���ݳ���idȡ����ͼ
    function getOnefile($model_id, $type=''){
        if($type == 'old'){
            $extra = " and ppos=999 ";
        }else{
            $extra = " and ppos=1 ";
        }
        $this->fields= "*";
        $this->where = "type_name='model' and type_id='$model_id' {$extra} and pos=1";
        $this->order= array("ppos"=>"desc","pos"=>"asc");
        return $this->getResult(1);
    }


    //���ݳ���idȡͼ��8��
    function getOnefile2($model_id){
        for($i=1;$i<=4;$i++){
            $this->fields= "*";
            $this->where = "type_name='model' and type_id='$model_id' and pos=$i ";
            $this->order= array("id"=>"asc");            
            $pic[$i]=$this->getResult(2);
        }
        return $pic;
    }


    function getAllModelPic(){
      global $_cache;
      $cache_key = "model_pic";
      $cache_time = 12*3600;
      $model_pic = $_cache->getCache($cache_key);
      if(!$model_pic){
        $this->where = "type_name='model' and ppos=1";
        $this->fields = "*";
        $pic = $this->getResult();
        $model_pic = array();
        foreach ($pic as $k => $v) {
          $model_pic['model_id'] = array(
            'name' => $v['name'],
            'created' => $v['created']
          );
        }
        $_cache->writeCache($cache_key, $model_pic, $cache_time);
      }
      return $model_pic;
    }

    function pic_type_sum($model_id){
        $this->fields= "count(*)";
        $pic_type=array();
        foreach ($this->pic_type as $key => $value) {
            $this->where = "type_name='model' and type_id='$model_id' and pos ='$key' ";
            $result=$this->getResult(3);
            $value["total"]=$result;
            $pic_type["pic"][$key]=$value;
            $pic_type["pictotal"]+=$result;
        }
        return $pic_type;
    }
    
}


?>
