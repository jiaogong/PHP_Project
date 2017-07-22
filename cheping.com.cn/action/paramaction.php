<?php

/**
  * param action
  * $Id: paramaction.php 5542 2014-03-18 08:06:21Z yinliuhui $
  * $Author: yinliuhui $
 */

class paramaction extends action {

    function __construct() {
        parent::__construct();
        $this->models = new models();
        $this->series = new series();
        $this->param = new param();
        $this->vars('garage', 'garage');
    }

    function doDefault() {
        echo $this->doIndex();
    }
	
    function doIndex(){
    	$template_name = "param";
        
    	$this->vars('css', array('cspz', 'base', 'comm', 'index_scrollbar','common'));
        $this->vars('js', array('global', 'param', 'tab'));
        $seriesId = $_GET['sid'];
        if($seriesId) $modelId = $this->series->getSeriesdata('default_model', "series_id = $seriesId", 3);
        else {
            $modelId = $_POST['model_id'];
            $modelId = $modelId ? $modelId : $_GET['mid'];
        }
        //根据车型id取出车型信息
        $modelInfo = $this->models->getSeriesmodelsbymid($modelId);         
        //车系id $serise_id
        $page_title ="【".$modelInfo['series_name']."】".$modelInfo['brand_name'].$modelInfo['series_name']."参数配置-ams车评网";
        $keywords = $modelInfo['brand_name'].$modelInfo['series_name']."参数配置";
        $description = "ams车评网提供".$modelInfo['series_name']."配置参数，包括".$modelInfo['series_name']."动力传动系统，尺寸及空间，制动、防盗配置，中控等配置参数详情，更多".$modelInfo['series_name']."参数配置信息尽在ams车评网。";
        $this->vars('title', $page_title);
        $this->vars('keyword', $keywords);
        $this->vars('description', $description);
        $this->vars("model",$modelInfo);
        
        $series_id = $modelInfo['series_id']?$modelInfo['series_id']:1;
        $resultarr = $this->models->getParamBySeriesId( $series_id);
        
        $date_id_class = $st4_class = $st27_class = $st50_class = array();
        foreach($resultarr as $k =>  $v){
            //年款
        	$date_id_class[] = $v['date_id'];
              //车身形式
        	$st4_class[] = $v['st4'];
                //排量
                //st28来判断st27是否带T
                if(strpos($v['st28'],"增压")){
                    $st27_class[] = $v['st27'].'T';
                }else{
                    $st27_class[] = $v['st27'];
                }
               // 变速箱
        	if(strpos($v['st50'],"AT")){
                    $st50_class[] = "自动";
               }else if(strpos($v['st50'],"MT")){
                    $st50_class[] = "手动";
                }else if(strpos($v['st50'],"DCT")){
                    $st50_class[] = "双离合";
                }else if(strpos($v['st50'],"CVT")){
                    $st50_class[] = "无极";
                }else if(strpos($v['st50'],"AMT")){
                    $st50_class[] = "序列"; 
                }
        	
        }
      
        $date_id_class = array_unique($date_id_class);
        $st4_class = array_unique($st4_class);
        $st27_class = array_unique($st27_class);
        $st50_class = array_unique($st50_class);
        sort($date_id_class );
        sort($st4_class);
        sort($st27_class);
        sort($st50_class);
     
        $this->vars("date_id_class",$date_id_class);
        $this->vars("st4_class",$st4_class);
        $this->vars("st27_class",$st27_class);
        $this->vars("st50_class",$st50_class);
        
        
        foreach ($resultarr as $key => $value) {
            $resultarr[$key]['date_id_class'] ='date_id_'.array_search($value['date_id'],$date_id_class );
            $resultarr[$key]['st4_class'] = 'st4_'.array_search($value['st4'], $st4_class );
            
             if(strpos($value['st28'],"增压")){
                 $resultarr[$key]['st27_class'] = 'st27_'.array_search($value['st27'].'T',$st27_class );
                    
                }else{
                    $resultarr[$key]['st27_class'] = 'st27_'.array_search($value['st27'],$st27_class );
                }
            
               if(strpos($value['st50'],"AT")){
                    
                     $resultarr[$key]['st50_class'] = 'st50_'.array_search("自动" ,$st50_class);
               }else if(strpos($value['st50'],"MT")){
                  
                    $resultarr[$key]['st50_class'] = 'st50_'.array_search("手动" ,$st50_class);
                }else if(strpos($value['st50'],"DCT")){
                    
                    $resultarr[$key]['st50_class'] = 'st50_'.array_search("双离合" ,$st50_class);
                }else if(strpos($value['st50'],"CVT")){
                  
                    $resultarr[$key]['st50_class'] = 'st50_'.array_search("无极" ,$st50_class);
                }else if(strpos($value['st50'],"AMT")){
                  
                    $resultarr[$key]['st50_class'] = 'st50_'.array_search("序列" ,$st50_class);
                }
           
              
           
        }
    
      foreach($resultarr as  $key=>$model){
        	
        	
        	//技术参数
                $nullstr = "<strong>---</strong>";     	    
                $paramlist[$model[model_id]] = $model;      	    
                $paramattr = $this->param->paramattr;
                foreach ($paramattr as $key => $value) {
                        foreach ($value["attr"] as $k => $v) {
                              $tem = explode("-", $v["pid"]);
                              $temv = null;
                              if (count($tem) > 1) {
                                    if ($v["name"] == "比功率(kw/kg)") {
                                        if (isset($model["st" . $tem[0]]) && $model["st" . $tem[0]] != "-" && $model["st" . $tem[0]] != "无" && isset($model["st" . $tem[1]]) && $model["st" . $tem[1]] != "-" && $model["st" . $tem[1]] != "无" && $model["st" . $tem[1]] !=0) {
                                            $temv = (intval(($model["st" . $tem[0]] / $model["st" . $tem[1]]) * 1000)) / 1000;
                                        } else {
                                            $temv = "";
                                        }
                                    } else {
                                        $temv = $model["st" . $tem[0]] . "/" . $model["st" . $tem[1]];
                                    }
                              } else {
                                    if ($model["st" . $v["pid"]] == "标配") {
                                        $temv = "<em class='black'></em>";
//                                        $attr[$value["title"]][$v["name"]][$i]="<font style='font-size:20px;'>●</font>";
                                    } else if ($model["st" . $v["pid"]] == "选配") {
                                        $temv = "<em class='white'></em>";
//                                        $attr[$value["title"]][$v["name"]][$i]="<font style='font-size:20px;'>○</font>";
                                    } else {
                                        $temv = $model["st" . $v["pid"]];
                                    }
                             }
                            $temv = strval($temv);
                            if (isset($temv) && $temv != "无" && trim($temv) != "" && trim($temv) != "无/无") {
                                    $attr[$value["title"]][$v["name"]][$model[model_id]][] = $model ? $temv : "";
                                    $attr[$value["title"]][$v["name"]][$model[model_id]][] = $model[date_id_class];
                                    $attr[$value["title"]][$v["name"]][$model[model_id]][] = $model[st4_class];
                                    $attr[$value["title"]][$v["name"]][$model[model_id]][] = $model[st27_class];
                                    $attr[$value["title"]][$v["name"]][$model[model_id]][] = $model[st50_class];
                                    
                            } else {
                                    $attr[$value["title"]][$v["name"]][$model[model_id]][] = $model ? $nullstr : "";
                                    $attr[$value["title"]][$v["name"]][$model[model_id]][] = $model[date_id_class];
                                    $attr[$value["title"]][$v["name"]][$model[model_id]][] = $model[st4_class];
                                    $attr[$value["title"]][$v["name"]][$model[model_id]][] = $model[st27_class];
                                    $attr[$value["title"]][$v["name"]][$model[model_id]][] = $model[st50_class];
                            }
                     }
                        
                }

              
        }
        
        
        $this->vars("attr",$attr);
        $this->vars("paramlist",$paramlist);
         
       $this->template($template_name, '', 'replaceNewsChannel');
    
    }
   

}

?>
