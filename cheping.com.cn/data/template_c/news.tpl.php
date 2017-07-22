<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('index_header');?>
<script type="text/javascript">
    $(function(){
        $('.prevPage').click(function(){
            if($('.song').length>0){
                $('.song').prev().addClass('song').siblings('li').removeClass('song');
            }
        })
        $('.nextPage').click(function(){
            if($('.song').length>0){
                $('.song').next().addClass('song').siblings('li').removeClass('song');
            }
        })
        $('.ep-pages ol li a').click(function(){
            $(this).parent('li').addClass('song').siblings('li').removeClass('song');
        })
    });
    $(function(){
   	$('.main-title ul li').click(function(){
   		var c = $(this).index();
   		$('.main-title ul li').eq(c).addClass('song').siblings('li').removeClass('song');
   	})
    });
</script>
 
<div class="concent">
    <div class="main-title" >
             <ul> 
                <li <? if (!$ids) { ?>class="song"<? } ?> ><a href="article.php?action=CarReview&id=<?=$id?>">全部</a></li> 
                <? foreach((array)$ac as $k=>$v) {?>
                    <? if ($v[count]==0) { ?><? } else { ?>
                        <li <? if ($ids == $v[id]) { ?>class="song"<? } ?>><a href="article.php?action=CarReview&id=<?=$id?>&ids=<?=$v[id]?>" ><?=$v[category_name]?></a></li> 
                    <? } ?>
                <?}?> 
            </ul> 
   </div> 
   <div class="main-title-con" >
       <div class="left fl">
            <div id="d1">
                <div class="dl-main-left fl">
                    <ul class="">     
                        <? foreach((array)$lists as $k=>$v) {?>
                        <li>
                                <span class="fl"><a href="/html/article/<? echo date("Ym/d",$v["uptime"]); ?>/<?=$v[id]?>.html" target="_blank"><img class="huaguo lazyimg" style="width:279px;height:184px;" data-original="<?=UPLOAD_DIR?><?=$v[pic]?>" src="../images/loading_img/loading280x185.png"  alt="<?=$v[title]?>" /></a></span>
                                    <div class="span-con fr">
                                        <p class="p1"><a href="/html/article/<? echo date("Ym/d",$v["uptime"]); ?>/<?=$v[id]?>.html" target="_blank"><?=$v[title]?></a></p>
                                        <p class="p2"><? foreach((array)$v[series_name] as $key=>$val) {?><a href="<?=$local_host?>modelinfo_s<?=$val['series_id']?>.html" target="_blank"><span class="spcolor"><? if ($key<6) { ?><?=$val['series_name']?><? } ?></span></a>&nbsp;&nbsp;<?}?><span class="fr margr4px"><? echo date("Y-m-d",$v["uptime"]); ?></span></p>
                                        <p class="p3 fade"><? echo dstring::substring($v[chief],0,75),'...' ?></p>
                                        <p class="p-four"> 
                                            <? foreach((array)$v[tag_name] as $keys=>$value) {?>
                                            <? if ($keys<6) { ?>
                                                <span class="spa">
                                                <i class="sppic fl"><img src="images/point.png" /></i>
                                                <span class="spzi fl"><a href="article.php?action=ActiveList&id=<?=$value['id']?>" target="_blank"><?=$value['tag_name']?></a></span>
                                              </span>
                                            <? } ?>
                                            <?}?>
                                        </p>
                                    </div>
                            </li>
                        <?}?>
                    </ul>
                </div>
                <div class="fy_cont1" style="width:100%;">
                    <?=$page_bar?>
                </div>
            </div>
       </div>
       <div class="right fr">
        <div class="dl-main-right fr">
         <!--#include virtual="/ssi/ssi_index_tag.shtml"-->
         <!--精品分类结束-->
         <!--#include virtual="/ssi/ssi_index_article.shtml"-->
         <!--热门文章结束-->     
        </div>
    </div>
    </div>
    <script>
        (function() {
            var bct = document.createElement("script");
            bct.src = "/js/counter.php?cname=article&c1=<?=$id?>&c2=<?=$ids?>&c3=";
            bct.src += "&df="+document.referrer;
            document.getElementsByTagName('head')[0].appendChild(bct);
        })();
    </script>  
    <div class="clear"></div>
</div>
<? if (!$ids) { ?>
<? include $this->gettpl('index_footer');?>
<? } else { ?>
<? include $this->gettpl('article_footer');?>
<? } ?>