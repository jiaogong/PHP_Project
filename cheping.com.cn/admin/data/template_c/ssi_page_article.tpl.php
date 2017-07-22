<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<div class="remen" style="margin-top: 0px;">
     <div class="remen_1"><a class="axg" href="javascript:void(0)" style="margin-left:5px;cursor:default;">热门文章</a></div>
     <? foreach((array)$value as $k=>$v) {?>
         <div class="rm_list_sp">
     <div class="rm_list_sp1"><a href="<?=$v['url']?>"><img src="/attach/<?=$v[pic]?>" width="139" height="92" alt="<?=$v[alt]?>"></div>
         <div class="rm_list_sm1"><a href="<?=$v['url']?>" style="font-size:14px;"><?=$v[title]?></a></div>
         <div class="rm_list_sp_time"><? echo date('Y-m-d',$v[uptime]) ?></div>
     </div>
     <?}?>

  </div>

