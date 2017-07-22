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
    });
</script>
<div class="tppd_content">
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
                    <!--<LI class="none"><A href="javascript:void(0);">T</A> </LI>-->
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
                <div class="<? if ($seriesdata['brand_id']==$bkey) { ?>jiajie1<? } else { ?>jiajie<? } ?>" bid="<?=$bkey?>">
                    <em class="arrow down" ><img src="images/tk_jians.jpg" /></em>
                    <em class="arrow up" ><img src="images/fcloses.jpg" /></em>
                </div>
                <!--//厂商列表，车系列表-->
                <ul id="list<?=$bkey?>" class="list" <? if ($bkey == $seriesdata['brand_id']) { ?>style="display:block;"<? } ?> name="brand_<?=$blist['letters']?>"></ul>
                <div class="tk_bor"></div>
                <?}?>
                <div style="height: 3px;" id="carBottom"></div>
            </DIV>
        </DIV>
        <div class="tkpp_right" style="padding-left:230px;">
            <p>
                <span style="float:left;">
                    <input type="text" value="输入车系或者品牌：奥迪、宝马3系" id="image_search" name="searchname" class="serch"/>
                    <input type="button" class="serch_btton" style="border: medium none;" onfocus="this.blur()" />
                </span>
                <span style="float:right;">	热门搜索： <? foreach((array)$serieshot as $k=>$v) {?><a style="color:#ea1a14;" href="<? if ($v[link]) { ?>/<?=$v[link]?><? } else { ?>/image_searchlist_series_id_<?=$v[series_id]?>.html<? } ?>"> <? if ($v[name]) { ?><?=$v[name]?><? } else { ?><?=$v[series_name]?><? } ?></a><?}?></span></p>

            <div class="ck_yixuan">
                <? if ($search_title) { ?>
                <span class="yixuan_title">已选条件</span>
                <dl>
                    <dd  id="search_title">
                        <?=$search_title?>
                    </dd>
                </dl>
                <span class="yixuan_qc"><a href="/image_SearchList_series_id_<?=$series_id?>.html"><img src="/images/yixuan_qc.jpg" /></a></span>
                <? } else { ?>
                <span class="yixuan_title">个性化选图</span>
                <? } ?>
            </div>
            <div class="ck_chexi">
                <div class="chexi_title"><?=$seriesdata['series_name']?> 在售车款<span style=" font-size:12px;"><? if ($seriesdata['series_total']) { ?>（<?=$seriesdata['series_total']?>张)<? } else { ?>暂无<? } ?></span>
                    <span class="chexi_right" ></span>
                    <span class="chexi_right1"></span></div>
                <div id="chexi_dn" style="display:block;">
                    <div class="ck_ck">按车款</div>
                    <? if ($date_model_array) { ?>
                    <? $iii=count($date_model_array)-2 ?>
                    <? foreach((array)$date_model_array as $key=>$value) {?>
                    <p class="ck_year"><?=$value['date']?>年款</p>
                    <? if ($value['content']) { ?>
                    <? foreach((array)$value['content'] as $k=>$v) {?>
                    <div class="chexi_list">
                        <dl>
                            <dd>
                                <a <? if ($model_id==$v[model_id]) { ?>class="focus"<? } ?> href="<? if ($model_id==$v[model_id]) { ?>javascript:void(0)<? } else { ?>/modelpicselect/<?=$series_id?>_<?=$v[model_id]?>_<?=$color_id?>_<?=$tp?>.html<? } ?>"><?=$v[model_name]?> <? if ($v[model_total]) { ?>(<?=$v[model_total]?>张)<? } ?></a>
                            </dd>
                        </dl>
                    </div>
                    <?}?>
                    <? } ?>
                    <div class="clear"></div>
                    <div  <? if ($key <= $iii) { ?>class="ck_xian"<? } ?> style="margin-top:10px"></div>
                    <?}?>
                    <? } ?>
                    
                    <div class="ck_ck">按分类</div>
                    <ul class="fenlei">
                        <? foreach((array)$poslist as $key=>$value) {?>
                        <li><a <? if ($tp==$value['pos']) { ?>class="focus"<? } ?> href="<? if ($tp==$value['pos']) { ?>javascript:void(0)<? } else { ?>/modelpicselect/<?=$series_id?>_<?=$model_id?>_<?=$color_id?>_<?=$value['pos']?>.html<? } ?>"><?=$value['name']?><? if ($value['total']) { ?>(<?=$value['total']?>张)<? } ?></a></li>
                        <?}?>
                    </ul>
                    <? if ($seriescolorlist) { ?>
                    <p class="ck_ck">按外观颜色</p>
                    <div class="ck_allcolor">
                        <? if ($seriescolorlist) { ?>   
                        <? foreach((array)$seriescolorlist as $key=>$value) {?> 
                        <dl class="ck_color">
                            <dt><span class="huise"><img onerror = "this.src='/images/50x50.jpg'" src="/attach/images/<?=$value['color_pic']?>" width="25" height="25"/></span></dt>
                            <dd><a <? if ($color_id==$value['id']) { ?>class="focus"<? } ?> href="<? if ($color_id==$value['id']) { ?>javascript:void(0)<? } else { ?>/modelpicselect/<?=$series_id?>_<?=$model_id?>_<?=$value['id']?>_<?=$tp?>.html<? } ?>"><?=$value['color_name']?><? if ($value['total']) { ?>(<?=$value['total']?>张)<? } ?></a></dd>
                        </dl>
                        <?}?>
                        <? } else { ?>
                        <dl class="ck_color">  
                            <dd>此车型暂无可选颜色<dd>
                        </dl>
                        <? } ?>
                    </div>
                    <div style="clear: both;"></div>
                    <? } ?>
                </div> 
            </div>
            <? if ($serieslist) { ?>
            <? foreach((array)$serieslist as $key=>$value) {?>
            <div class="tkpd_modle">
                <div class="ckk_title"><span class="title_zi"><?=$value['name']?></span><span style=" font-size:12px; float: left;"><? if ($value['total']) { ?>（<?=$value['total']?>张)<? } ?></span><? if (!$tp) { ?><span class="ck_right"><a href="/modelpicselect/<?=$series_id?>_<?=$model_id?>_<?=$color_id?>_<?=$value['pos']?>.html">更多>></a></span><? } ?></div>
                <div class="tkpd_modle_content modle_content">
                    <? if ($tp) { ?>
                    <? foreach((array)$value['content'] as $k=>$v) {?>
                    <? $i++ ?>
                    <? $ii = $i%4 ?>
                    <dl <? if ($ii==0) { ?> style="margin:0px;" <? } ?>>
                        <dt><a href="/bigpic_<?=$v[type_id]?>_<? if ($v[color_id]) { ?><?=$v[color_id]?><? } else { ?>0<? } ?>_<?=$v[pos]?>_<?=$v[id]?>.html"><img class="lazyimgs" data-original="/attach/images/model/<?=$v[type_id]?>/<? if ($v[pos]==1&&$v[ppos]<6) { ?>304x227<? } else { ?>242x180<? } ?><?=$v['name']?>" src="../images/loading_img/loading161x120.png" width="161" height="120" alt="<?=$v[series_name]?>" /></a></dt>
                        <dd><a href="/bigpic_<?=$v[type_id]?>_<? if ($v[color_id]) { ?><?=$v[color_id]?><? } else { ?>0<? } ?>_<?=$v[pos]?>_<?=$v[id]?>.html"><? echo dstring::substring($v[model_name],0,12) ?></a>
                        </dd>
                    </dl>
                    <?}?>
                    <? } else { ?>
                    <? $i=0 ?>
                    <? foreach((array)$value['content'] as $k=>$v) {?>
                    <? $i++ ?>
                    <? $ii = $i%4 ?>
                    <? if ($i<9) { ?>
                    <dl <? if ($ii==0) { ?> style="margin:0px;" <? } ?>>
                        <dt><a href="/bigpic_<?=$v[type_id]?>_<? if ($v[color_id]) { ?><?=$v[color_id]?><? } else { ?>0<? } ?>_<?=$v[pos]?>_<?=$v[id]?>.html"><img class="lazyimgs" data-original="/attach/images/model/<?=$v[type_id]?>/<? if ($v[pos]==1&&$v[ppos]<6) { ?>304x227<? } else { ?>242x180<? } ?><?=$v['name']?>" src="../images/loading_img/loading161x120.png"  width="161" height="120"  alt="<?=$v[series_name]?>"/></a></dt>
                        <dd><a href="/bigpic_<?=$v[type_id]?>_<? if ($v[color_id]) { ?><?=$v[color_id]?><? } else { ?>0<? } ?>_<?=$v[pos]?>_<?=$v[id]?>.html"><? echo dstring::substring($v[model_name],0,12) ?></a>
                        </dd>
                    </dl>
                    <? } ?>
                    <?}?>
                    <? } ?>
                </div>
            </div>
            <?}?>
            <? } else { ?>
            <div class="tkpd_modle"><p style="text-align: center">抱歉暂无图片</p></div>
            <? } ?>
            <div class="fy_cont" style="width:795px;"><?=$page_bar?></div>
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

    <script>
        function showHidden(idCode) {
            var objUl = document.getElementById(idCode);
            if (objUl.style.display == "none") {
                objUl.style.display = "block";
            }
            else {
                objUl.style.display = "none";
            }
        }
        //这里是搜索下拉提示
        $(document).ready(function () {
            $("#image_search").autocomplete(
                    "/ajax.php?action=TopSearch",
                    {
                        delay: 10,
                        minChars: 1,
                        matchSubset: 1,
                        matchContains: 1,
                        cacheLength: 10,
                        onItemSelect: selectItem,
                        onFindValue: findValue,
                        formatItem: formatItem,
                        autoFill: false
                    }
            );
        });
        function findValue(li) {
            if (li == null)
                return alert("No match!");
            if (!!li.extra)
                var sValue = li.extra[0];
            else
                var sValue = li.selectValue;
        }
        function selectItem(li) {
            findValue(li);
        }
        function formatItem(row) {
            return row[0];//return row[0] + " (id: " + row[1] + ")"//如果有其他参数调用row[1]，对应输出格式Sparta|896
        }
        function lookupAjax() {
            var oSuggest = $("#input_test")[0].autocompleter;
            oSuggest.findValue();
            return false;
        }
    </script>
</div>
<div class="clear"></div>
<script>
    (function() {
        var bct = document.createElement("script");
        bct.src = "/js/counter.php?cname=searchList&c1=<?=$series_id?>&c2=&c3=";
        bct.src += "&df="+document.referrer;
        document.getElementsByTagName('head')[0].appendChild(bct);
    })();
</script>
