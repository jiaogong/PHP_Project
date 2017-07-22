<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<div class="syg_left_02">
    <div class="pcdg_title"> 市场热点车型</div>
    <div class="pctj_bg">
        <div class="pctj_tt"></div>
    </div>    
    <div id="banner">
        <div id="banner_info"></div>
        <ul class="djan">
            <li class="on" id="on1"></li>
            <li id="on2"></li>
        </ul>
        <div id="banner_list2">
            <? foreach((array)$second_model[0] as $k=>$m) {?>
            <div class="hot" style="width:655px;<? if ($k == 1) { ?>display:none;<? } ?>">
            <? foreach((array)$m as $q=>$mm) {?>
            <div 
                <? if ($q % 2 != 0) { ?>
                style="float:right;display:inline; "
                <? } else { ?>
                style="float:left;"
                <? } ?>                
                class="hgzc_cont">
                <? $title = $mm['series_name'] . $mm['model_name'] ?>
                <? $shortTitle = string::get_str($title, 40) ?>
                <p style="font-size:14px; color:#585858; line-height:28px;padding-left:8px;"><a href="modelinfo_<?=$mm['model_id']?>.html" title="<?=$title?>" target="_blank"><?=$shortTitle?></a></p>
                <div style="width:321px;">
                    <div class="intr_car_bg">
                        <div class="zxrx">                        
                            <dl>
                                <dt><a href="modelinfo_<?=$mm['model_id']?>.html" target="_blank"><img width="160" height="120" onerror="this.src='/images/180x100.jpg'" <? if ($k == 1) { ?>class="lazy_load"<? } ?> src<? if ($k == 1) { ?>2<? } ?>="/attach/images/model/<?=$mm['model_id']?>/160x120<?=$mm['model_pic1']?>"></a></dt>
                                <dd></dd>
                            </dl>
                        </div>
                    </div>
                    <div class="bgbmj">
                        <p style="font-size:20px;">冰狗商情价</p>
                        <span style="font-size:20px; color:#ed7001; margin-right:5px;"><?=$mm['bingo_price']?>万</span>
                        <span class="biaoge_tan">
                            <? if ($mm['price_img']) { ?>
                                <img src="images/<?=$mm['price_img']?>">
                            <? } ?>
                            <a href="javascript:void(0);">
                                <span style="font-size:12px; display:none; <? if ($mm['price_img'] == 'shuang11_biao.jpg') { ?>right:-10px;<? } ?>">
                                    <div class="gzs_jtbg"></div>
                                    <?=$mm['price_notice']?>
                                </span>
                            </a> 
                        </span>   
                        <br>
                        <span style="font-size:14px; color:#585858; text-decoration:line-through; margin-right:10px;"><?=$mm['model_price']?>万</span>
                        <? if ($mm['discount'] < 10) { ?><span style="color:red; font-size:14px;"><?=$mm['discount']?></span>折<? } ?>
                        <br>
                        <? if ($mm['discount_val'] == '无优惠') { ?>
                            <span class="wnsq">0元</span>
                        <? } elseif(strpos($mm['discount_val'], '加价') !== false) { ?>
                            <span class="jia"><? echo str_replace('加价', '', $mm['discount_val']) ?></span>
                        <? } else { ?>
                            <span class="wnsq"><?=$mm['discount_val']?></span>
                        <? } ?>
                    </div>
                    <div class="clear"></div>
                    <dl style="padding-left:5px; height:28px;">
                        <? if ($mm['dealer_name']) { ?>
                        <dt><img src="images/sq_4s.jpg"></dt>
                        <dd style="font-size:12px; font-weight:600;"><?=$mm['dealer_name']?></dd>
                        <? } ?>
                    </dl>
                    <div class="clear"></div>
                    <div style="padding-right:10px; padding-left:8px; line-height:24px;">
                        <div style="width:140px; float:left;">获取方式：
                            <? if ($mm['price_img'] == 'shuang11_biao.jpg') { ?>网络双11
                            <? } else { ?>冰狗行情团队
                            <? } ?>
                        </div>
                        <? if ($mm['get_time']) { ?><div style="width:160px; float:right;">
                            <? if ($mm['price_img'] == 'shuang11_biao.jpg') { ?>
                                截止时间：
                            <? } else { ?>
                                获取时间：
                            <? } ?>                            
                            <?=$mm['get_time']?></div>
                        <? } ?>
                    </div>
                    <div class="clear"></div>
                    <div style="width:298px; margin:0 auto;  padding:5px 10px 5px 10px; margin-top:5px; height:40px; color:#ff7800; font-size:14px;">
                        <?=$mm['title']?>
                    </div>
                    <div style="width:310px; font-size:12px; color:#969ea2; margin-top:10px; padding-left:8px; height:22px;">
                        <div style="float:left; width:120px; line-height:22px;"><a style="float:left;color:#969ea2;" class="jdb" href="compare_<?=$mm['model_id']?>.html" target="_blank">加对比</a>
                            <a style="float:right;font-size:12px; color:#969ea2;" class="jgz" href="javascript:addattention(<?=$mm['model_id']?>);">加关注</a></div>
                        <div class="cksq"><a href="offers_<?=$mm['model_id']?>.html" onfocus="this.blur()" target="_blank">查看此车商情</a></div>
                    </div>
                                                    
                </div>
                <div class="clear"></div>
            </div> 
            <?}?>
            </div>
            <?}?>
        </div>
    </div>
</div>
<div class="syg_left_02">
    <div class="pcdg_title"> 当下购买推荐</div>
    <div class="pctj_bg">
        <div class="pctj_tt"></div>
    </div>    
    <div id="banner">
        <div id="banner_info"></div>
        <ul class="djan">
            <li class="on" id="on1"></li>
            <li id="on2"></li>
        </ul>
        <div id="banner_list2">
            <? foreach((array)$second_model[1] as $k=>$m) {?>
            <div class="hot" style="width:655px;<? if ($k == 1) { ?>display:none;<? } ?>">
            <? foreach((array)$m as $q=>$mm) {?>
            <div 
                <? if ($q % 2 != 0) { ?>
                style="float:right;display:inline; "
                <? } else { ?>
                style="float:left;"
                <? } ?>                
                class="hgzc_cont">
                <? $title = $mm['series_name'] . $mm['model_name'] ?>
                <? $shortTitle = string::get_str($title, 40) ?>
                <p style="font-size:14px; color:#585858; line-height:28px;padding-left:8px;"><a href="modelinfo_<?=$mm['model_id']?>.html" title="<?=$title?>" target="_blank"><?=$shortTitle?></a></p>
                <div style="width:321px;">
                    <div class="intr_car_bg"> 
                        <div class="zxrx">                        
                            <dl>
                                <dt><a class="zxrx" href="modelinfo_<?=$mm['model_id']?>.html" target="_blank"><img width="160" height="120" onerror="this.src='/images/180x100.jpg'" <? if ($k == 1) { ?>class="lazy_load"<? } ?> src<? if ($k == 1) { ?>2<? } ?>="/attach/images/model/<?=$mm['model_id']?>/160x120<?=$mm['model_pic1']?>"></a></dt>
                                <dd></dd>
                            </dl>
                        </div>
                    </div>
                    <div class="bgbmj">
                        <p style="font-size:20px;">冰狗商情价</p>
                        <span style="font-size:20px; color:#ed7001; margin-right:5px;"><?=$mm['bingo_price']?>万</span>
                        <span class="biaoge_tan">
                            <? if ($mm['price_img']) { ?>
                                <img src="images/<?=$mm['price_img']?>">
                            <? } ?>
                            <a href="javascript:void(0);">
                                <span style="font-size:12px; display:none;<? if ($mm['price_img'] == 'shuang11_biao.jpg') { ?>right:-10px;<? } ?>">
                                    <div class="gzs_jtbg"></div>
                                    <?=$mm['price_notice']?>
                                </span>
                            </a> 
                        </span>                        
                        <br>
                        <span style="font-size:14px; color:#585858; text-decoration:line-through; margin-right:10px;"><?=$mm['model_price']?>万</span>
                        <? if ($mm['discount'] < 10) { ?><span style="color:red; font-size:14px;"><?=$mm['discount']?></span>折<? } ?>
                        <br>
                        <? if ($mm['discount_val'] == '无优惠') { ?>
                            <span class="wnsq">0元</span>
                        <? } elseif(strpos($mm['discount_val'], '加价') !== false) { ?>
                            <span class="jia"><? echo str_replace('加价', '', $mm['discount_val']) ?></span>
                        <? } else { ?>
                            <span class="wnsq"><?=$mm['discount_val']?></span>
                        <? } ?>
                    </div>
                    <div class="clear"></div>
                    <dl style="padding-left:5px; height:28px;">
                        <? if ($mm['dealer_name']) { ?>
                        <dt><img src="images/sq_4s.jpg"></dt>
                        <dd style="font-size:12px; font-weight:600;"><?=$mm['dealer_name']?></dd>
                        <? } ?>
                    </dl>
                    <div class="clear"></div>
                    <div style="padding-right:10px; padding-left:8px; line-height:24px;">
                        <div style="width:140px; float:left;">获取方式：
                            <? if ($mm['price_img'] == 'shuang11_biao.jpg') { ?>网络双11<? } else { ?>冰狗行情团队<? } ?></div>
                        <? if ($mm['get_time']) { ?><div style="width:160px; float:right;">
                            <? if ($mm['price_img'] == 'shuang11_biao.jpg') { ?>
                                截止时间：
                            <? } else { ?>
                                获取时间：
                            <? } ?>
                            <?=$mm['get_time']?></div><? } ?>
                    </div>
                    <div class="clear"></div>
                    <div style="width:298px; margin:0 auto;  padding:5px 10px 5px 10px; margin-top:5px; height:40px; color:#ff7800; font-size:14px;">
                        <?=$mm['title']?>
                    </div>
                    <div style="width:310px; font-size:12px; color:#969ea2; margin-top:10px; padding-left:8px; height:22px;">
                        <div style="float:left; width:120px; line-height:22px;"><a style="float:left;color:#969ea2;" class="jdb" href="compare_<?=$mm['model_id']?>.html" target="_blank">加对比</a>
                            <a style="float:right;font-size:12px; color:#969ea2;" class="jgz" href="javascript:addattention(<?=$mm['model_id']?>);" >加关注</a></div>
                        <div class="cksq"><a href="offers_<?=$mm['model_id']?>.html" onfocus="this.blur()" target="_blank">查看此车商情</a></div>
                    </div>
                                                    
                </div>
                <div class="clear"></div>
            </div> 
            <?}?>
            </div>
            <?}?>
        </div>
    </div>
</div>