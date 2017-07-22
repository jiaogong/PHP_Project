<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<div class="bgtj">
    <p style="font-size:18px; height:38px; line-height:38px; background-color:#f5f7f8; padding-left:10px;border-
       bottom:solid 1px #d7dfe4;">冰狗推荐</p>
    <div class="bgtj_cont1">
        <div class="bgtj_left">
            <p><span style="font-size:21px; color:#ed7001; font-weight:bold; float:left; line-height:24px;">推荐理由
                </span><span style="float:right; width:150px; margin-top:3px;"><a href="compare.php?modelid=<?=$first_model['model_id']?>"  target="_blank" class="jdb">加对比</a><a href="javascript:addattention(<?=$first_model['model_id']?>);" class="jgz">加关注
                </a></span></p>
        <div class="clear"></div>
        <p style="font-size:14px; color:#ed7001; margin-top:10px;height:40px;overflow: hidden;" title="<?=$first_model['title']?>"><?=$first_model['title']?></p>
        </div>
        <div class="bgtj_right">
            <div style="float:left; width:340px;">
                <div class="bgtj_df" style="width: 365px;">
                   <img src="images/ckyx_chepi.jpg" style="float:left; margin:1px 5px 1px 1px;">
                   <div style="float: left;width: 300px;"> <b style="float:left; font-size:18px; color:#585858; font-weight:normal;">总体评分：</b>
                       <span class="sppf" style="float: left;"></span> <b style="font-size:20px; font-weight:normal; color:#d6000f; float: left;"><?=$seriesInfo['score'][5]?></b>
                       <input type="hidden" value="<?=$seriesInfo['sppf']?>" id="xj_sppf" />
                    <ul class="bgtj_pf">
                        <li>品质：<span><?=$seriesInfo['score'][0]?></span></li>
                        <li> 性能：<span><?=$seriesInfo['score'][1]?></span></li>
                        <li> 配置：<span><?=$seriesInfo['score'][2]?></span></li>
                        <li> 安全：<span><?=$seriesInfo['score'][3]?></span></li>
                        <li> 外观：<span><?=$seriesInfo['score'][4]?></span></li>
                           
                     </ul></div>
                 </div>
                <p style="height:36px; line-height:36px; color:#585858;"><b style="font-size:12px; font-weight: normal;">由全球权威汽车媒体品牌ams车评 特约提供</b></p>
                </div>
	</div>
    </div>
    <div class="ckyx_bor"></div>
    <div class="bgtj_cont2">
        <div class="bgtj_left">
            <dl class="tjc">
                <dt style="width:200px; margin: 0 auto; padding: 10px 0px;"><a href="modelinfo.php?mid=<?=$first_model['model_id']?>" title="<?=$first_model['model_name']?>">
                <img width="200" height="110" onerror="this.src='images/180x100.jpg'" src="attach/images/model/<?=$first_model['model_id']?>/180x100<?=$first_model['model_pic2']?>" /></a>
                </dt>
                <dd style="width: 234px;height: 25px;overflow:hidden;">
                    <p style="font-size:14px; color:#585858; margin-top:5px;"><a href="modelinfo.php?mid=<?=$first_model['model_id']?>" title="<?=$first_model['model_name']?>"><?=$first_model['model_name']?></a></p>
                </dd>
            </dl> 
        <p style="font-size:21px; color:#000; width:250px; margin-top:5px;"><?=$first_model['price_name']?><span 
                style="font-size:32px; color:#ed7001; line-height:28px;"><?=$first_model['bingobang_price']?></span><b style="font-
                weight:normal; font-size:12px; color:#000;">万</b></p>
        <p style="font-size:12px; margin-top:5px;"><span style="color:#000;">促销信息：</span>
            <? $diffPrice = $first_model['model_price'] - $first_model['bingobang_price'] ?>
            <? if ($diffPrice > 0) { ?>
            <span style="color:#ed7001;"><? echo (round($first_model['bingobang_price'] / $first_model['model_price'], 3)) * 10 ?>折</span>
            <span style="color:#585858;">（优惠<? echo $diffPrice * 10000 ?>元）</span>
            <? } elseif($diffPrice == 0) { ?>
            <span style="color:#ed7001;">无优惠</span>
            <? } else { ?>
            <span style="color:#ed7001;">加价<? echo abs($diffPrice) * 10000 ?>元</span>
            <? } ?>
         </p>
    </div>
    <div class="bgtj_right">
        <div class="jgfx">
            <ul>
                <? $j = 0 ?>
                <? $max = $high_price + 1 ?>
                <? for($price = $low_price; $price < $max; $price += $unit_price) { ?>
                <li><?=$price?></li>
                <? $j++ ?>
                <? } ?>
            </ul>
            <div class="clear"></div>
            <? if ($first_model['bingobang_price'] > 0) { ?>
            <div class="ck_csz_lv forst" id="price0" style="left:<? if ($first_model['bingobang_price']>$low_price&&$first_model['bingobang_price']<$high_price+1) { ?><?=$price_length['bingobang_price']?><? } elseif($first_model['bingobang_price']<$low_price) { ?><?=$price_length['min_price']?><? } else { ?><?=$price_length['max_price']?><? } ?>px;"> <a class="tooltips" href="javascript:void(0);"><span>
                        <p><?=$first_model['price_name']?>：</p>
                        <p><?=$first_model['bingobang_price']?>万</p>
                    </span></a> </div>
         
            <? } ?>                
            <? if ($first_model['dealercost_price'] > 0) { ?>       
            <div class="ck_jxs_hu" id="price1" style="left:<? if ($first_model['dealercost_price']>$low_pirce&&$first_model['dealercost_price']<$high_price+1) { ?><?=$price_length['dealercost_price']?><? } elseif($first_model['dealercost_price']<$low_price) { ?><?=$price_length['min_price']?><? } else { ?><?=$price_length['max_price']?><? } ?>px;"> <a class="tooltips" href="javascript:void(0);"><span>
                        <p>经销商成本价</p>
                        <p><?=$first_model['dealercost_price']?>万</p>
                    </span></a> </div>
            <? } ?>
            <? if ($first_model['model_price'] > 0) { ?>
            <div class="ck_bgb_ho" id="price2" style="left:<? if ($first_model['model_price']>$low_price&&$first_model['model_price']<$high_price+1) { ?><?=$price_length['model_price']?><? } elseif($first_model['model_price']<$low_price) { ?><?=$price_length['min_price']?><? } else { ?><?=$price_length['max_price']?><? } ?>px;"> <a class="tooltips" href="javascript:void(0);"><span>
                        <p>厂商指导价</p>
                        <p><?=$first_model['model_price']?>万</p>
                    </span></a> </div>
            <? } ?>
            <? if ($first_model['mostbuy_price'] > 0) { ?>
            <div class="ck_pjc_lan" id="price3" style="left:<? if ($first_model['mostbuy_price']>$low_price&&$first_model['mostbuy_price']<$high_price+1) { ?><?=$price_length['mostbuy_price']?><? } elseif($first_model['mostbuy_price']<$low_price) { ?><?=$price_length['min_price']?><? } else { ?><?=$price_length['max_price']?><? } ?>px;"> <a class="tooltips" href="javascript:void(0);"><span>
                        <p>最多人购买价</p>
                        <p><?=$first_model['mostbuy_price']?>万</p>
                    </span></a> </div>                             
            <? } ?>
            <? if ($first_model['mentioncar_price'] > 0) { ?>
            <div class="ck_bgo_zi" id="price4" style="left:<? if ($first_model['mentioncar_price']<$high_price+1) { ?><?=$price_length['mentioncar_price']?><? } else { ?><?=$high_price?>+1<? } ?>px;"> <a class="tooltips" href="javascript:void(0);"><span>
                        <p>提车价（预算）</p>
                        <p><?=$first_model['mentioncar_price']?>万</p>
                    </span></a> </div>
            <? } ?>
          
        </div>
        <div class="jgfx_ys"> <a class="tooltips2" href="javascript:void(0);"><img src="images/ckyx_lv.png"/><span>
                    <div class="gzs_jtbg"><img src="images/syg_jt.png" /></div>
                    <b>冰狗商情价</b><br>                        
                    商情价是我们通过独家渠道为您获取的当前市场可成交价格，全力保障您买车侃价不吃亏！</span></a> <a class="tooltips2" href="javascript:void(0);"><img 
                    src="images/ckyx_hu.png"/><span>
                    <div class="gzs_jtbg"><img src="images/syg_jt.png" /></div>
                    <b>经销商成本</b><br>
                    经销商成本价是冰狗通过各种官方渠道特别为您获取的，反映的是经销商从汽车厂商进货（不含返点）的成本价格
                    ，让您在和经销商侃价时心中有数。</span></a> <a class="tooltips2" href="javascript:void(0);"><img src="images/ckyx_ho.png"/><span 
                    style="width:17em;">
                    <div class="gzs_jtbg"><img src="images/syg_jt.png" /></div>
                    <b>厂商指导价</b><br>
                    厂商为了维持市场价格秩序而给出的价格标杆，您的实际购车价格更多受市场供求影响，有可能低于指导价哦！
                </span></a> <a class="tooltips2" href="javascript:void(0);"><img src="images/ckyx_la.png"/><span style="width:14em;">
                    <div class="gzs_jtbg"><img src="images/syg_jt.png" /></div>
                    <b>最多人购买价</b><br>
                    最多人购买价是冰狗通过各种权威渠道、购车者反馈获得的，反映的是近期市场上多数购车者的成交价格。
                </span></a> <a class="tooltips2" href="javascript:void(0);"><img src="images/ckyx_zi.png"/><span style="width:14em;">
                    <div class="gzs_jtbg"><img src="images/syg_jt.png" /></div>
                    <b>提车价（预算）</b><br>
                    提车价表达的是一个大体的购车预算，即购买该车的“最低成本”，其构成为：<font color='red'>冰狗商情价</font>+<font color='red'>购置税</font>+<font color='red'>交强险</font>+<font color='red'>上牌费用</font></span></a>
        </div>
           <dl>
		<dt><img src="images/syg_bu.jpg" /></dt>
                <dd class="lba">
                 <div style="width: 500px;">
                    <div style="float: left; max-width:20em; width: auto;white-space:nowrap; overflow: hidden;">
                        <span>[国家补贴]</span>&nbsp;&nbsp;<?=$c_Subsidy[0]?>
                    </div>
                    <div class="ckxx"> 
		        <div class="ckxx1" style="width:55px;height:20px;">
                           <? if ($c_Subsidy[1]!="") { ?> <a href="javascript:void(0)">更多>></a><? } ?>
                           <span id="span" style="color: #000">
                           <div class="gzs_jtbg"><img src="images/syg_jt.png"></div>
                           <b class="closebox"> <a href="javascript:void(0)"onclick="$('#hellobaby').slideUp('slow');$('.closebox').css('display','block');" title="关闭">×</a> </b>
                           <?=$c_Subsidy[1]?> 
                           </span>
		        </div>
                    </div>
                 </div>
            <div class="clear"></div>               
            <div style="width: 500px;">
               <div style="float: left; max-width:20em; width: auto;white-space:nowrap; overflow: hidden;">
                   <span>[厂商补贴]</span>&nbsp;&nbsp;<?=$s_Subsidy[0]?>
               </div>
               <div class="ckxx"> 
                        <div class="ckxx2" style="width:55px; height:20px;">
                            <? if ($s_Subsidy[1]!="") { ?><a href="javascript:void(0)">更多>></a><? } ?>
                             <span id="span2" style="color: #000">
                                 <div class="gzs_jtbg"><img src="images/syg_jt.png"></div>
                                 <b class="closebox"> <a href="javascript:void(0)"onclick="$('#hellobaby').slideUp('slow');$('.closebox').css('display','block');" title="关闭">×</a> </b><br/>
                                  <?=$s_Subsidy[1]?>
                             </span>
                         </div>
               </div>
             </div> 
               </dd>
           </dl>
            <script type="text/javascript">
                    $(".ckxx1 a").click( function () {	
                            $("#span").toggle();	
                    });	
                    $(".ckxx2 a").click( function () {	
                            $("#span2").toggle();	
                    });
            </script>		
        </div>
    </div>
</div>