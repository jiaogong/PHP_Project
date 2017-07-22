<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('index_header');?>
<script language="javascript">
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
    $(function () {
        $('.main-title ul li').click(function () {
            var c = $(this).index();
            $('.main-title ul li').eq(c).addClass('song').siblings('li').removeClass('song');
        })
    });
    if (window.parent.length > 0) {
        window.parent.document.all.mainframe.style.height = document.body.scrollHeight;
    }
</script>

<div class="con-list"><!--内容开始-->
    <span class="span-list1"><a href="/">车评首页</a> > 精品分类 > <?=$tag_name?></span> 
    <span class="span-list2"><?=$tag_name?></span> 
    <div class="main-title mar28px">
        <ul> 
            <li <? if (!$ids) { ?>class="song"<? } ?>><a href="article.php?action=ActiveList&id=<?=$id?>">全部 <?=$total?> </a></li> 
            <? foreach((array)$ac as $k=>$v) {?>
            <? if ($v[count]==0) { ?><? } else { ?>
            <li <? if ($ids == $v[id]) { ?>class="song"<? } ?>><a href="article.php?action=ActiveList&ids=<?=$v[id]?>&id=<?=$v[tag_id]?>" ><?=$v[caename]?> <?=$v[count]?> </a></li> 
            <? } ?>
            <?}?> 
        </ul> 
    </div> 
    <div class="main-title-con">
        <div class="left fl">
            <div id="d1">
                <div class="dl-main-left fl mar20px">   
                    <? if ($list) { ?>
                    <? foreach((array)$list as $k=>$v) {?>
                    <div class="left_list">
                        <div class="list_tupian"><a href="<?=$v[url]?>" target="_blank"><img src="<?=UPLOAD_DIR?><?=$v[pic]?>" width="280" height="186" alt="<?=$v[title]?>"></a></div>
                        <a href="article.php?action=CarReview&id=<?=$v[caeid]?>" target="_blank"><div class="fanwei"><?=$v[caename]?></div></a>
                        <div class="jieshao"><a href="<?=$v[url]?>" target="_blank"><?=$v[title]?></a></div>
                        <div class="list_biaoqian">
                            <? foreach((array)$v[tag_name] as $key=>$val) {?>
                            <? if ($key<3) { ?>
                            <a href="article.php?action=ActiveList&id=<?=$val['id']?>" target="_blank"><?=$val['tag_name']?></a>&nbsp;
                            <? } ?>
                            <?}?>
                        </div>
                        <div class="list_time"><? echo date("Y-m-d",$v["uptime"]); ?></div>
                    </div>
                    <?}?>
                    <div class="ep-pages">
                        <?=$page_bar?>
                    </div>
                    <? } else { ?>
                    <div>暂无内容</div>
                    <? } ?>
                </div>
            </div>
            <script>
                (function() {
                    var bct = document.createElement("script");
                    bct.src = "/js/counter.php?cname=tag&c1=<?=$ids?>&c2=<?=$id?>&c3=";
                    bct.src += "&df="+document.referrer;
                    document.getElementsByTagName('head')[0].appendChild(bct);
                })();
            </script>
        </div>
        <div class="right fr">
            <!--#include virtual="/ssi/ssi_index_tag.shtml"-->
            <!--精品分类结束-->
            <!--#include virtual="/ssi/ssi_index_article.shtml"-->
            <!--热门文章结束-->
            <!--#include virtual="/ssi/ssi_index_video.shtml"-->
            <!--精彩视频结束-->
        </div>
        <div class="clear"></div>
    </div>

</div>

<!--#include virtual="/ssi/article_footer.shtml"-->


