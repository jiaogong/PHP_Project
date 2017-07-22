<?php
  /**
  * comment model
  * @author David.Shaw
  * $Id: comment.php 1789 2016-03-24 08:39:22Z wangchangjiang $
  */
  
  class comment extends model{
    function __construct(){
      $this->table_name = "cardb_comment"; 
      parent::__construct();
    }
    
    function getComment($id){
      $this->fields = "*";
      $this->where = "id='{$id}'";
      return $this->getResult();
    }
    
    function getAllComment($where = '1', $order = array(), $limit = 1, $offset = 0){
      $this->where = $where;
      $this->fields = "count(id)";
      $this->total = $this->getResult(3);
      #echo $this->sql . "<br>\n";
      $this->fields = "*";
      if($limit == -1){
        $this->getall = 1;
      }else{
        $this->limit = $limit;
        $this->offset = $offset;
      }
      
      if(!empty($order)){
       $this->order = $order;
      }
      return $this->getResult(2);
    }
    //查找品牌  厂商下 车款评论
    //
    function getAllCommenttable($where, $table=array(), $order = array(), $limit = 1, $offset = 0){
      $this->where = $where;
      $this->fields = "count(cc.id)";
      $this->tables =$table;
      $this->total = $this->joinTable(3);
      #echo $this->sql . "<br>\n";
      $this->fields = "cc.*,cs.series_name";
      if($limit == -1){
        $this->getall = 1;
      }else{
        $this->limit = $limit;
        $this->offset = $offset;
      }

      if(!empty($order)){
       $this->order = $order;
      }
      return $this->joinTable(4);
    }
    
    function getCommentTotal($where = '1'){
      $this->where = $where;
      $this->fields = "count(id)";
      $this->total = $this->getResult(3);
      return $this->total;
    }
    
    function getCommentBySid($sid, $index = false){
      if(!$sid) return false;
      $this->order = array();
      $this->fields = "count(id)";
      $this->where = "state=3 and pid=0 and ((type_name='series' and type_id='{$sid}') or (type_name='model' and s9='{$sid}'))";
      $this->total = $this->getResult(3);
      $this->reset();
      
      $this->tables = array(
        'users' => 'u',
        'cardb_comment' => 'c',
      );
      $this->where = "c.state=3 and c.pid=0 and ((c.type_name='series' and c.type_id='{$sid}') or (type_name='model' and s9='{$sid}')) and c.uid=u.uid";
      $this->order = array('c.id' => 'desc');
      $this->fields = "c.id,c.comment,type_name,type_id,u.uid,c.uname,u.name, u.gender";
      $ret = $this->joinTable();
      return $ret;
    }
    
    function getCommentUidCount($sid){
      $this->fields = "count(id)";
      $this->where = "state=3 and pid=0 and (type_name='series' and type_id='{$sid}') or (type_name='model' and s9='{$sid}')";
      $this->group = "uid";
      $this->total = $this->getResult(3);
      return $this->total;
    }
    
    /**
    * 根据状态返回用户评论统计结果
    */
    function getCommentCalResult(){
      $this->fields = "uid,COUNT(*) as total,id,created,MIN(created) as firsttime,MAX(created) as endtime";
      $this->group = "uid";
      $this->order = array('max(id)' => 'desc');
      $this->where = "state='3' and pid='0'";
      $ret = $this->getResult(4);
      
      $this->fields = "uid,COUNT(*) as total";
      $this->order = "";
      $this->where = "";
      $ret1 = $this->getResult(4);
      #var_dump($ret1);
      
      $r = array();
      foreach ($ret as $k => $v) {
        $v['uid'] = $k;  //用户ID
        $v['comment_id'] = $v['id'];  //最后的正常评论ID
        $v['comment_time'] = $v['endtime']; //最后评论时间
        $v['comment_time2'] = $v['firsttime']; //第一条评论时间
        $v['comment_count'] = $v['total']; //正常状态的评论总数
        $v['comment_count2'] = $ret1[$k]; //所有状态的评论总数
        $r[] = $v;
      }
      return $r;
    }

    /*
     * 根据uid取出评论
     */
    function getCommentByUid($uid,$order=array()){
      $this->fields="*";
      $this->where="state='3' and pid='0' and uid='{$uid}'";
      $this->order=$order;
      return $this->getResult();
    }

    //统计评论的回复数
    function getCommentcounts2($cid){
        $this->fields="count(id)";
        $this->where=" 1 and state='3' and pid='$cid' ";
        return $this->getResult(3);
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
