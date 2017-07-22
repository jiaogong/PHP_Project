<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class paramType extends model{

    function __construct(){
      $this->table_name = "cardb_paramtype";
      parent::__construct();
    }

    function getParamtypelist($fileds,$where,$order=null,$tables=null){
        $this->reset();
        $this->fields = $fileds;
        $this->where = $where;
        if($order){$this->order = $order;}
        if($tables){
            $this->tables = $tables;
            return $this->joinTable(2);
        }else{
            return $this->getResult(2);
        }
    }

    function getParamtypebypid($pid,$order=array()){
        $this->reset();
        $this->fields = "*";
        $this->where = "pid='$pid'";
        $this->order = $order;
        return $this->getResult(2);
    }

    /*
         * 根据参数 及 参数值 分组值对应
         * 参数$param  参数值 $model
         */
        function getParam($param,$model){
              $newparam=array();
              $i=0;
              foreach ($param as $key => $value) {
//                  if($model["st".$value["id"]]){
                    if(empty($newparam[$value["pid2"]])){
                    $newparam[$value["pid2"]]["type_name"]=$value["type_name"];
                    }
                    $newparam[$value["pid2"]]["attr"][$i]["id"]=$value["id"];
                    $newparam[$value["pid2"]]["attr"][$i]["name"]=$value["name"];
                    $newparam[$value["pid2"]]["attr"][$i]["value"]=$model["st".$value["id"]];
                    $i++;
//                  }else{
//                    if(empty($newparam[$value["pid2"]])){
//                    $newparam[$value["pid2"]]["type_name"]=$value["type_name"];
//                    }
//                    $newparam[$value["pid2"]]["attr"][$i]["id"]=$value["id"];
//                    $newparam[$value["pid2"]]["attr"][$i]["name"]=$value["name"];
//                    $newparam[$value["pid2"]]["attr"][$i]["value"]=$model["st".$value["id"]];
//                    $i++;
//                  }
              }
              return $newparam;
        }

}

?>
