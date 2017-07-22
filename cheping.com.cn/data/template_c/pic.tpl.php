<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('index_header');?>
<script>
    $(document).ready(function () {
        $(window).bind('scroll', function () {
            var navHeight = $('.head_v1').height();
            if ($(window).scrollTop() > navHeight) {
                $('.frame_left').addClass('fixed');
            }
            else {
                $('.frame_left').removeClass('fixed');
            }
        });
        $('body').on('click', '.jiajie', function () {
            var bid = $(this).attr('bid');
            var arrow = $(this).find("em.arrow");
            if (arrow.css('display') == 'block') {
                $(this).find(".down").css({display: 'none'});
                $(this).find(".up").css({display: 'block'});
                $('ul#list' + bid).css({display: 'none'});
            } else {
                $(this).find(".down").css({display: 'block'});
                $(this).find(".up").css({display: 'none'});
                $.get('/pic.php?action=getfactory&bid=' + bid, function (data) {
                    $('ul#list' + bid).html(data);
                    $('ul#list' + bid).css({display: 'block'});
                });
            }
        });
        $('body').on('click', '.second_bg', function () {
            var fid = $(this).attr('fid');
            $.get('/pic.php?action=getseries&fid=' + fid, function (data) {
                $('ul#serieslist_' + fid).html(data);
            });
        });
    });
</script>
<div class="tppd_content" style=" overflow: hidden;">
    <div class="tppd_container">
        <!--左侧导航树开始-->
        <DIV id="frame_left" class="frame_left">
            <DIV class="frame_treesub">
                <UL id="navul">
                    <LI><A href="javascript:void(0);" name="A">A</A> </LI>
                    <LI><A href="javascript:void(0);" name="B">B</A> </LI>
                    <LI><A href="javascript:void(0);" name="C">C</A> </LI>
                    <LI><A href="javascript:void(0);" name="D">D</A> </LI>
                    <LI class="none"><A href="javascript:void(0);">E</A> </LI>
                    <LI><A href="javascript:void(0);" name="F">F</A> </LI>
                    <LI><A href="javascript:void(0);" name="G">G</A> </LI>
                    <LI><A href="javascript:void(0);" name="H">H</A> </LI>
                    <LI class="none"><A href="javascript:void(0);">I</A> </LI>
                    <LI><A href="javascript:void(0);" name="J">J</A> </LI>
                    <LI><A href="javascript:void(0);" name="K">K</A> </LI>
                    <LI><A href="javascript:void(0);" name="L">L</A> </LI>
                    <LI><A href="javascript:void(0);" name="M">M</A> </LI>
                    <LI><A href="javascript:void(0);" name="N">N</A> </LI>
                    <LI><A href="javascript:void(0);" name="O">O</A> </LI>
                    <LI class="none"><A href="javascript:void(0);">P</A> </LI>
                    <LI><A href="javascript:void(0);" name="Q">Q</A> </LI>
                    <LI><A href="javascript:void(0);" name="R">R</A> </LI>
                    <LI><A href="javascript:void(0);" name="S">S</A> </LI>
                    <LI><A href="javascript:void(0);" name="S">T</A> </LI>
                    <!--                    <LI class="none"><A href="javascript:void(0);">T</A> </LI>-->
                    <LI class="none"><A href="javascript:void(0);">U</A> </LI>
                    <LI class="none"><A href="javascript:void(0);">V</A> </LI>
                    <LI><A href="javascript:void(0);" name="W">W</A> </LI>
                    <LI><A href="javascript:void(0);" name="X">X</A> </LI>
                    <LI><A href="javascript:void(0);" name="Y">Y</A> </LI>
                    <LI><A href="javascript:void(0);" name="Z">Z</A> </LI>
                </UL>
            </DIV>
            <DIV id="frame_tree" class="frame_tree">
                <? $first_letter = ''; ?>
                <? foreach((array)$allbrand as $bkey=>$blist) {?>
                <h3 id="brand<?=$bkey?>" name="brand_<?=$blist['letter']?>">
                    <span id="brand_<?=$blist['letter']?>" name="<?=$blist['letter']?>" class="px_zm">
                        <? if ($first_letter !== $blist['letter']) { ?>
                        <?=$blist['letter']?>&nbsp;&nbsp;&nbsp;&nbsp;
                        <? $first_letter = $blist['letter']; ?>
                        <? } else { ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <? } ?>
                    </span>
                    <a href="/image_searchbrandlist_brand_id_<?=$bkey?>.html">
                        <span  class="first_bg" style="cursor:pointer"><?=$blist['brand_name']?></span>
                        <span class="mum">(<font style="color:#ea1a14;"><?=$blist['total']?></font>)</span>
                    </a>
                </h3>
                <div class="<? if ($series['brand_id']==$bkey) { ?>jiajie1<? } else { ?>jiajie<? } ?>" bid="<?=$bkey?>">
                    <em class="arrow down" ><img src="images/tk_jians.jpg" /></em>
                    <em class="arrow up" ><img src="images/fcloses.jpg" /></em>
                </div>
                <!--//厂商列表，车系列表-->
                <ul id="list<?=$bkey?>" class="list" <? if ($bkey == $brand_id) { ?>style="display:block;"<? } ?> name="brand_<?=$blist['letters']?>"></ul>
                <div class="tk_bor"></div>
                <?}?>
                <div style="height: 3px;" id="carBottom"></div>
            </DIV>
        </DIV>

        <div class="tkpp_right" style="padding-left:230px;">
            <p><span style="float:left;">
                    <input type="text" value="输入车系或者品牌：奥迪、宝马3系" id="image_search" name="searchname" class="serch"/>
                    <input type="button" class="serch_btton"  style="border: medium none;" onfocus="this.blur()"/></span>
                <span style="float:right;">热门搜索： <? foreach((array)$serieshot as $k=>$v) {?><a href="<? if ($v[link]) { ?>/<?=$v[link]?><? } else { ?>/image_searchlist_series_id_<?=$v[series_id]?>.html<? } ?>"> <? if ($v[name]) { ?><?=$v[name]?><? } else { ?><?=$v[series_name]?><? } ?></a><?}?></span></p>

            <div class="hot">
                <div id="cover" style="float:left; width:755px;">
                    <ul style="width: 1311px; left: 0px;">
                        <? foreach((array)$piccarousel[0] as $pckey=>$pclist) {?>
                        <? if ($pckey==1) { ?>
                        <li id="cover<? echo $pckey ?>"><a href="<?=$pclist['link']?>"><img width="755" height="428" src="attach/images/<?=$pclist['pic']?>" alt="<?=$pclist['picalt']?>"></a>
                            <span class="cover_zi">
                                <p><?=$pclist['title']?></p>
                            </span>
                        </li>
                        <? } else { ?>
                        <li id="cover<? echo $pckey ?>"><a href="<?=$pclist['link']?>"><img width="755" height="428" src="attach/images/<?=$pclist['pic']?>" alt="<?=$pclist['picalt']?>"></a>
                            <span class="cover_zi">
                                <p><?=$pclist['title']?></p>
                            </span>
                        </li>
                        <? } ?>
                        <?}?>
                    </ul>
                </div>
                <ul id="idNum" class="num1">
                    <? foreach((array)$piccarousel[0] as $pcckey=>$pcclist) {?>
                    <li class="num_now<? echo $pcckey ?>"><a href="javascript:void(0)" id="num<? echo $pcckey ?>" class="<? if ($pcckey != 0&&$pcckey!=1) { ?>num_other<? } else { ?>num_now<? } ?>" onmouseover="coverHover(<? echo $pcckey ?>);"></a></li>
                    <?}?>
                </ul>
                <input type="hidden" id="count" value="1">
            </div>
            <!--最新更新-->
            <div class="tkpd_modle">
                <div class="tkpd_modle_title">最新更新</div>
                <div class="tkpd_modle_content">
                    <ul>
                        <? foreach((array)$newcolorpic as $ncplist) {?>
                        <li>
                            <a href="/image_Searchlist_series_id_<?=$ncplist['s1']?>.html"  target="_blank"><img class="lazyimgs" width="242" height="182" data-original="/attach/images/model/<?=$ncplist['type_id']?>/304x227<?=$ncplist['name']?>" src="../images/loading_img/loading242x182.png" alt="<?=$ncplist['series_name']?>"/></a>
                            <div class="tk_show"><em class="tp_show"></em><span><?=$ncplist['series_name']?> <?=$ncplist['model_name']?></span></div>
                        </li>
                        <? } ?>
                    </ul>
                </div>
            </div>
            <!--热度最高-->
            <div class="tkpd_modle">
                <div class="tkpd_modle_title">热度最高</div>
                <div class="tkpd_modle_content">
                    <ul>
                        <? foreach((array)$hotcolorpic as $hcplist) {?>
                        <li>
                            <a href="/image_Searchlist_series_id_<?=$hcplist['s1']?>.html" target="_blank"><img class="lazyimgs"  width="242" height="182" data-original="/attach/images/model/<?=$hcplist['type_id']?>/304x227<?=$hcplist['name']?>" src="../images/loading_img/loading242x182.png" alt="<?=$hcplist['series_name']?>" /></a>
                            <div class="tk_show"><em class="tp_show"></em><span><?=$hcplist['series_name']?> <?=$hcplist['model_name']?></span></div>
                        </li>
                        <? } ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <!--//这里是搜索的弹框js控制-->
    <div id="popMask" style="position: fixed; z-index: 999; top: 0px; left: 0px; height: 100%; width: 100%; opacity: 0.8; background: rgb(204, 204, 212) none repeat scroll 0% 0%; display:none;"></div>
    <div class="ss_tks" style="display: block; background:white; width:326px; height:150px; z-index:9999; position:relative;top:0%; left:50%; margin-left:-150px;display:none; z-index:99999; ">
        <div class="ss_tc" style="position: absolute; height:150px; width:326px; ">
            <p style="margin-top:40px; text-align: center;">对不起，没有搜索的您想要的内容</p>
            <a id="fanhui" href="" style=" text-align: center; margin-top:30px; display:block;">
                <img src="images/ss_tk.jpg">
            </a>
        </div>
    </div>
    <div class="clear"></div>
    <script>
        (function() {
            var bct = document.createElement("script");
            bct.src = "/js/counter.php?cname=pic&c1=1&c2=&c3=";
            bct.src += "&df="+document.referrer;
            document.getElementsByTagName('head')[0].appendChild(bct);
        })();
    </script>

