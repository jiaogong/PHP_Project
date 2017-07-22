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
    $(function () {
        $('.main-title ul li').click(function () {
            var c = $(this).index();
            $('.main-title ul li').eq(c).addClass('song').siblings('li').removeClass('song');
        })
    });
    jQuery(document).ready(function ($) {
        $('.theme-login').click(function () {
            $('.theme-popover-mask').fadeIn(100);
            $('.theme-popover').slideDown(200);
        })
        $('.theme-poptit .close').click(function () {
            $('.theme-popover-mask').fadeOut(100);
            $('.theme-popover').slideUp(200);
        })
    });

    $(function () {
        var p = 2;// 初始化页面，点击事件从第二页开始
        var flag = false;
        $("input[name=btn]").click(function () {
            //初始状态，如果没数据return ,false;否则
            if ($("#content h5").size() <= 0)
            {
                return false;
            }
            else {
                send();
            }
        })

        function send() {
            if (flag) {
                return false;
            }
            $.ajax({
                type: 'post',
                url: "/video.php?action=ajaxcontent&id=<?=$id?>",
                data: {k: p}, //初始化页数,
                beforeSend: function () {
                    $("#content").append("<div id='load'></div>");
                },
                success: function (data) {
                    if (data != '') {
//	 			$.each(data,function(i,v){
//	 		            $("#content").append("<h5><div class='left_list'><div class='list_tupian'><a href='"+v['created']+"'><img src='/attach/"+v['pic']+"' width='280' height='186'></a></div><div class='fanwei'>"+v['p_category_name']+"</div><div class='jieshao'><a href=''>"+v['title']+"</a></div><div class='list_biaoqian'><a href=''></a>&nbsp;</div><div class='list_time'>"+v['time']+"</div></div></h5>");
//	 			})
                        $("#content").append(data);
                    } else {
                        $("input[name=btn]").val('加载完毕');
                        flag = true;
                    }
                },
                complete: function () {
                    $("#load").remove();
                }
                });
            p++;
        }
    });
</script>

<div class="concent">
    <div class="main-title">
        <ul> 
            <li <? if (!$ids) { ?>class="song"<? } ?> ><a href="video.php?action=Video&id=<?=$id?>">全部</a></li> 
            <? foreach((array)$ac as $k=>$v) {?>
            <? if ($v[count]==0) { ?><? } else { ?>
            <li <? if ($ids == $v[id]) { ?>class="song"<? } ?>><a href="video.php?action=Video&id=<?=$id?>&ids=<?=$v[id]?>"><?=$v[category_name]?></a></li> 
            <? } ?>
            <?}?>

        </ul> 
    </div> 
    <div class="main-title-con"  >
        <div class="left fl">
            <? if (!$lists) { ?>
            <div id="d1">
                <div class="video-main-left fl">
                    <div class="video-con">
                        <? foreach((array)$list as $k=>$v) {?>
                        <div class="left_list1">
                            <a href="video.php?action=ZuiZhong&id=<?=$id?>&ids=<?=$v[id]?>" target="_blank"><span><img class="huaguo lazyimg" style="width:279px;height:187px;" data-original="<?=UPLOAD_DIR?><?=$v[pic]?>" src="../images/loading_img/loading280x185.png"   alt="<?=$v[title]?>"/></span></a>
                            <a href="video.php?action=ZuiZhong&id=<?=$id?>&ids=<?=$v[id]?>" target="_blank"><span class="span-img"><img src="images/player.png"  /></span></a>
                            <!--        <span class="span-zi">20:00</span>-->
                            <span class="span1" style=""><a href="video.php?action=ZuiZhong&id=<?=$id?>&ids=<?=$v[id]?>" target="_blank"><?=$v[title]?></a></span>
                            <p class="pred">
                                <? foreach((array)$v[tag_name] as $keys=>$value) {?>
                                <? if ($keys<3) { ?>
                                <span>
                                    <a href="article.php?action=ActiveList&id=<?=$value['id']?>" target="_blank"><?=$value['tag_name']?></a>
                                </span>
                                <? } ?>
                                <?}?>
                            </p>
                            <span class="span-time fr"><? echo date("Y-m-d",$v["uptime"]); ?></span>
                        </div> 
                        <?}?>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                    <div class="ep-pages">
                        <?=$page_bar?>
                    </div>
                </div>
            </div>
            <? } else { ?>
            <div id='content'>
                <? foreach((array)$lists as $k=>$v) {?>
                <h5>
                    <div class="left_list1">
                        <span><a href="video.php?action=ZuiZhong&id=<?=$id?>&ids=<?=$v[id]?>" target="_blank"><img class="huaguo lazyimg" style="width:279px;height:187px;" data-original="<?=UPLOAD_DIR?><?=$v[pic]?>" alt="<?=$v[title]?>" src="../images/loading_img/loading280x185.png" /></a></span>
                        <span class="span-img"><a href="video.php?action=ZuiZhong&id=<?=$id?>&ids=<?=$v[id]?>" target="_blank"><img src="images/player.png"  /></a></span>
                        <a target="_blank" href="video.php?action=Video&id=<?=$id?>&ids=<?=$v[cacid]?>"><span class="span-zixin"><?=$v[category_name]?></span></a>
                        <span class="spother" style=" font-size:16px;line-height:22px;   height: 48px; margin-top:8px;overflow: hidden; "><a href="video.php?action=ZuiZhong&id=<?=$id?>&ids=<?=$v[id]?>" target="_blank"><?=$v[title]?></a></span>
                        <p class="pred">
                            <? foreach((array)$v[tag_name] as $keys=>$value) {?>
                            <? if ($keys<3) { ?>
                            <span>
                                <a href="article.php?action=ActiveList&id=<?=$value['id']?>" target="_blank"><?=$value['tag_name']?></a>
                            </span>
                            <? } ?>
                            <?}?>
                        </p>
                        <span class="span-time fr" style="font-size:14px;"><? echo date("Y-m-d",$v["uptime"]); ?></span>
                        <div class="clear"></div>
                    </div> 
                </h5>
                <?}?>

            </div>
            <input type='button' class="jiazai" name='btn' id='btn' style="border:0px;" value='点击继续浏览'>
            <? } ?>
            <script>
                (function() {
                    var bct = document.createElement("script");
                    bct.src = "/js/counter.php?cname=video&c1=<?=$id?>&c2=<?=$ids?>&c3=";
                    bct.src += "&df="+document.referrer;
                    document.getElementsByTagName('head')[0].appendChild(bct);
                })();
            </script>
        </div>
         <!--左列表结束-->
   <div class="right fr">
    <!--#include virtual="/ssi/ssi_index_video.shtml"-->
    <!--精彩视频结束-->
    <!--#include virtual="/ssi/ssi_index_tag.shtml"-->
    <!--精品分类结束-->
    </div> 
    </div>
   
</div>


<div class="clear"></div>
</div>
<? if (!$ids) { ?>
<? include $this->gettpl('index_footer');?>
<? } else { ?>
<? include $this->gettpl('article_footer');?>
<? } ?>
