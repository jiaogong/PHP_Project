<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
     class Comment extends model {
         
         function __construct() {
             $this->table_name = "cardb_comment";
             parent::__construct();
         }

         //根据车款id取出评论
         function getCommentByid($type_name="series",$id,$order=array(),$pagelen=5,$page=1,$whereapend=""){
             $startrow= ( $page -1 ) * $pagelen < 0 ? '0' : ( $page -1 ) * $pagelen ;
             //车款
             if($type_name=="model"){
                 $this->where = " type_name='$type_name' and type_id='$id' and state='3' ";
             }else if($type_name=="series"){
                 $this->where = " s9='$id' and state='3' and (type_name='model' or type_name='series') ";
             }else if(empty($id)){
                 return array();
             }
             $this->where.=" and pid='0' ".$whereapend;
             $this->fields = "count(id) as total";
             $this->total = $this->getResult(3);

             $this->fields = "*";
             if($order){
                 $this->order=$order;
             }
             $this->limit = $pagelen;
             $this->offset = $startrow;
             return $this->getResult(2);
         }
       //根据车款id取出评论
         function getAllCommentByid($type_name="series",$id,$whereapend=""){
             
             //车款
             if($type_name=="model"){
                 $this->where = " type_name='$type_name' and type_id='$id' and state='3' ";
             }else if($type_name=="series"){
                 $this->where = " s9='$id' and state='3' and (type_name='model' or type_name='series') ";
             }else if(empty($id)){
                 return array();
             }
             $this->where.=" and pid='0' ".$whereapend;
             $this->fields = "id,type_name,type_id,comment,name,uid,uname,created";
             $this->result = $this->getResult(2);
             return $this->result;
         }
        function getIndexComment() {
            $this->tables = array(
                'cardb_model' => 'cm',
                'cardb_comment' => 'cc'
            );
            $this->fields = "cm.model_id, cm.model_name, cm.model_pic1, cm.model_pic2, cm.model_price, cc.uname, cc.pros as comment, cc.s10";
            $this->where = "cm.model_id = cc.type_id AND cc.type_name = 'fake'";
            $this->order = array('cc.created' => 'DESC');            
            $result = $this->joinTable();
            return $result;
        }        
     }
?>
