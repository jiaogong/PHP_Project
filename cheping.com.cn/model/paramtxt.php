<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    class Paramtxt extends model{

        function  __construct() {
            $this->table_name = "cardb_paramtxt";
            parent::__construct();
        }

       function getParamtxtlist($model_id,$order=array(),$whereappend="") {
            $this->reset();
            $this->fields = "*";
            $this->where = "model_id='$model_id'".$whereappend;
            $this->order = $order;
            $paramtxt = $this->getResult(2);

            if(empty ($paramtxt)) {
                return array();
            }else{
                $paramvalue=array();
                foreach ($paramtxt as $key => $value) {
                    $paramtxt[$key]["value"]=explode("\n", $value["value"]);
                    $paramvalue[$value["state"]][$value["pid"]]=$paramtxt[$key];
                }
            }
//            return $paramvalue;

            //paramtype  pid=3 标配
            $ptype=new paramType();
            $paramtype3 = $ptype->getParamtypebypid(3, array("type_order"=>"ASC"));
            $newresult=array();
            foreach ($paramtype3 as $key => $value) {
                if(!empty ($paramvalue[0][$value["id"]])){
                    $newresult[0][]=$paramvalue[0][$value["id"]];
                }
            }
            $newresult[1]=$paramvalue[1];
           
           return  $newresult;
        }

//        function Getparamtxt($paramtxt) {
//            if(empty ($paramtxt)) {
//                return "";
//            }else{
//                $paramvalue=array();
//                foreach ($paramtxt as $key => $value) {
//                    $paramtxt[$key]["value"]=explode("\n", $value["value"]);
//                    $paramvalue[$value["state"]][]=$paramtxt[$key];
//                }
//            }
//            return $paramvalue;
//        }

    }
?>
