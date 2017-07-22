<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
﻿<div class="list_video"><!--热门文章-->
	   <div class="hot_chexing"><a class="a1" href="javascript:void(0)" style="margin-left:5px;cursor:default">热门文章</a></div>
           <? foreach((array)$value as $k=>$v) {?>
	   <div class="list_sp">
	      <div class="list_sp1"><a href="<?=$v['url']?>" target="_blank"><img src="/attach/<?=$v[pic]?>" width="139" height="92" alt="<?=$v[alt]?>"></a></div>
		  <div class="list_sm1"><a href="<?=$v['url']?>" target="_blank"><?=$v[title]?></a></div>
		  <div class="list_sp_time"><? echo date('Y-m-d',$v[uptime]) ?></div>
	   </div>
	<?}?>
</div>