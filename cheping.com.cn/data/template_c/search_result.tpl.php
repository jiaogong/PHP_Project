<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('index_header');?>
<!--header结束-->
<div class="ss_content">
<!--    <p class="lj"><a href="/">ams车评网首页</a> > 搜车-->
    <div class="ss_top">
        <div class="ss_top2"> 
            <span style="font-size:18px; color:#e61a15; width:68px; text-align:center;border-right:solid 1px #d7dfe4; display:block; float:left; font-weight:bold">品牌</span>            
            <? $brParam = (array)$search_param['br'] ?>
            <? $endBr = end($brParam) ?>
            <? foreach((array)$brand_select as $k=>$v) {?>
            <? $bids = array(); ?>
            
            <? foreach((array)$v as $bk=>$bv) {?>
            <? $bids[] = $bv['brand_id']; ?>
            <?}?>
            <div class="jdbgz">             
                <div class="ckqtk">         
                    <? $intersect = array_intersect($bids, $brParam) ?>
                    <? if (!empty($intersect)) { ?>   
                    <a href="javascript:;" class="up chk" style="display:none;"><?=$k?></a> 
                    <a href="javascript:;" class="down chkd" style="color: #e61a15"><?=$k?></a> 
                    <? } else { ?>
                    
                    <? if ($match_options['letter'][$k]) { ?>
                    <? if ($k == 'A' && empty($brParam)) { ?>
                    <a href="javascript:;" class="up" style="display:none;">A</a> 
                    <a href="javascript:;" class="down" style="color: #e61a15">A</a>                                                                         
                    <? } else { ?>
                    <a href="javascript:;" class="up"><?=$k?></a> 
                    <a href="javascript:;" style="display:none;" class="down"><?=$k?></a>                                                     
                    <? } ?>
                    <? } else { ?>
                    <span style="color:#d1cfcf"><?=$k?></span>
                    <? } ?>
                    <? } ?>                    
                </div>
                <div class="table" 
                     <? if ($k == 'A' && empty($brParam) && $match_options['letter'][$k] || $k == $brand[$endBr]['letter']) { ?>
                     style="display:block;"
                     <? } else { ?>
                     style="display:none;"
                     <? } ?>>                     
                     <ul style="width:1094px;">
                        <? foreach((array)$match_options['letter'][$k.'c'] as $kk=>$vv) {?>
                        <? if ($brand[$kk]['brand_name']) { ?>
                        <li><a
                                <? if (in_array($kk, $brParam)) { ?> 
                                href="javascript:;" class="focus">
                                <? } else { ?>
                                href="/search.php?<?=$url_querystring?>&br=<?=$kk?>">
                                <? } ?>
                                <? echo $brand[$kk]['letter'] ?>. <? echo $brand[$kk]['brand_name']; ?>
                                <span>
                                    (<?=$vv?>)
                                </span>
                            </a>
                        </li>
                        <? } ?>
                        <?}?>
                    </ul>
                </div> 
            </div>
            <?}?>            
        </div>
        <div class="ss_top3">
            <table width="1178" border="0">
                <tr>
                    <th style="width:184px;" scope="col">价格区间</th>
                    <th style="width:100px;" scope="col">车身形式</th>
                    <th style="width:68px;" scope="col">厂商性质</th>
                    <th style="width:70px;" scope="col">国别</th>
                    <th style="width:165px;" scope="col">级别 </th>
                    <th style="width:90px;" scope="col">排量 </th>
                    <th style="width:93px;" scope="col"> 变速箱</th>
<!--                                        <th style="width:70px;" scope="col">燃油类型</th>-->
                    <th style="width:120px;" scope="col"> 进气形式</th>
                    <th style="width:90px;" scope="col"> 座位数</th>
                    <th style=" width:100px;background:none; background-color:#ecf4fc;" scope="col">其他选项</th>
                </tr>      
                <tr>
                    <td class="price_range">
                        <ul>
                            <? foreach((array)$price_select as $k=>$v) {?>
                            <? if (array_key_exists($k, (array)$match_options['pr']) || in_array($k, (array)$search_param['pr'])) { ?>
                            <li>
                                <a <? if (in_array($k, (array)$search_param['pr'])) { ?>href="javascript:;" class="focus"<? } else { ?>href="/search.php?<? if ($cdp) { ?><? echo qasStrip($url_querystring, 'cdp='.$cdp); ?><? } else { ?><?=$url_querystring?><? } ?>&pr=<?=$k?>"<? } ?>>                                  
                                    <? if ($v['low']==0) { ?>
                                    <?=$v['high']?>万以下
                                    <? } elseif($v['high']==0) { ?>
                                    <?=$v['low']?>万以上
                                    <? } else { ?>
                                    <?=$v['low']?>-<?=$v['high']?>万
                                    <? } ?>
                            </a>
                        </li>
                        <? } else { ?>
                        <li>
                            <span class="noresult">
                                <? if ($v['low']==0) { ?>
                                <?=$v['high']?>万以下
                                <? } elseif($v['high']==0) { ?>
                                <?=$v['low']?>万以上
                                <? } else { ?>
                                <?=$v['low']?>-<?=$v['high']?>万
                                <? } ?>                                
                            </span>
                        </li>
                        <? } ?>
                        <?}?>
                    </ul>
                    <div class="clear"></div>                        
                    <p>
                        <input id="price_low" value="<? if ($cdparr) { ?><?=$cdparr[0]?><? } ?>" maxlength="4" type="text" class="text" />
                        -
                        <input id="price_high" value="<? if ($cdparr) { ?><?=$cdparr[1]?><? } ?>" maxlength="4" type="text" class="text" />
                        &nbsp;万
                        <input type="button" class="input_ss" value="确定"/>
                    </p>
                </td>
                <td class="cheshen_xs">
                    <ul>
                        <? if (!empty($match_options['cs'])) { ?>                                                                
                        <? foreach((array)$cs_select as $k=>$v) {?>
                        <? if (array_key_exists($k, (array)$match_options['cs']) || count($match_options['cs'][$k]) || in_array($k, (array)$search_param['cs'])) { ?>
                        <li>
                            <a <? if (in_array($k, (array)$search_param['cs'])) { ?>href="javascript:;" class="focus"<? } else { ?>href="/search.php?<?=$url_querystring?>&cs=<?=$k?>"<? } ?>>
                                <?=$v?>
                        </a>
                    </li>
                    <? } else { ?>
                    <li>
                        <span class="noresult"><?=$v?></span>
                    </li>
                    <? } ?>                    
                    <?}?>                                
                    <? } ?>      
                </ul>
            </td>
            <td class="changs">
                <? if (!empty($match_options['fi'])) { ?>                                                                        
                <? foreach((array)$fi_select as $k=>$v) {?>
                <? if (array_key_exists($k, (array)$match_options['fi']) || count($match_options['fi'][$k]) || in_array($k, (array)$search_param['fi'])) { ?>
                <p>
                    <a <? if (in_array($k, (array)$search_param['fi'])) { ?>href="javascript:;" class="focus"<? } else { ?>href="/search.php?<?=$url_querystring?>&fi=<?=$k?>"<? } ?>>
                        <?=$v?>
                </a>
            </p>
            <? } else { ?>
            <p>
                <span class="noresult"><?=$v?></span>
            </p>            
            <? } ?>
            <?}?>                                                         
            <? } ?>    
        </td>
        <td class="guo_bie">
            <ul>
                <? if (!empty($match_options['bi'])) { ?>
                <? foreach((array)$guobie_select as $k=>$v) {?>
                <? if (array_key_exists($k, (array)$match_options['bi']) || in_array($k, (array)$search_param['bi'])) { ?>
                <li>
                    <a <? if (in_array($k, (array)$search_param['bi'])) { ?>href="javascript:;" class="focus"<? } else { ?>href="/search.php?<?=$url_querystring?>&bi=<?=$k?>"<? } ?>>
                        <?=$v?>
                </a>
            </li>
            <? } else { ?>
            <li>
                <span class="noresult"><?=$v?></span>
            </li>        
            <? } ?>
            <?}?>
            <? } ?>  
        </ul>
    </td>
    <td class="ji_bie">
        <ul>
            <? if (!empty($match_options['ct'])) { ?>                                    
            <? foreach((array)$type_select as $k=>$v) {?>
            <? if (array_key_exists($k, (array)$match_options['ct']) || count($match_options['ct'][$k]) || in_array($k, (array)$search_param['ct'])) { ?>
            <li <? if (in_array($k, array(10, 11))) { ?>style="width:70px;"<? } ?>>
                <a <? if (in_array($k, (array)$search_param['ct'])) { ?>href="javascript:;" class="focus"<? } else { ?>href="/search.php?<?=$url_querystring?>&ct=<?=$k?>"<? } ?>>
                    <?=$v?>
            </a>
        </li>
        <? } else { ?>
        <li <? if (in_array($k, array(10, 11))) { ?>style="width:70px;"<? } ?>>
            <span class="noresult"><?=$v?></span>
        </li>    
        <? } ?>
        <?}?>          
        <? } ?>                             
    </ul>
</td>
<td class="pai_lia">
    <ul>
        <? if (!empty($match_options['pl'])) { ?>                                    
        <? foreach((array)$pl_select as $k=>$v) {?>
        <? if (array_key_exists($k, (array)$match_options['pl']) || count($match_options['pl'][$k]) || in_array($k, (array)$search_param['pl'])) { ?>
        <li>
            <a <? if (in_array($k, (array)$search_param['pl'])) { ?>href="javascript:;" class="focus"<? } else { ?>href="/search.php?<?=$url_querystring?>&pl=<?=$k?>"<? } ?>>
                <? if ($v['low']==0) { ?>
                <?=$v['high']?>以下
                <? } elseif($v['high']==0) { ?>
                <?=$v['low']?>以上
                <? } else { ?>
                <?=$v['low']?>-<?=$v['high']?>
                <? } ?>
        </a>
    </li>
    <? } else { ?>
    <li>
        <span class="noresult">
            <? if ($v['low']==0) { ?>
            <?=$v['high']?>以下
            <? } elseif($v['high']==0) { ?>
            <?=$v['low']?>以上
            <? } else { ?>
            <?=$v['low']?>-<?=$v['high']?>
            <? } ?>
        </span>
    </li>        
    <? } ?>
    <?}?>                              
    <? } ?>
</ul>
</td>
<td class="gear_boxes ">
    <ul>
        <? if (!empty($match_options['bsx'])) { ?>                                    
        <? foreach((array)$bsx_select as $k=>$v) {?>
        <? if (array_key_exists($k, (array)$match_options['bsx']) || count($match_options['bsx'][$k]) || in_array($k, (array)$search_param['bsx'])) { ?>
        <li <? if ($k == 4) { ?>style="width:40px;"<? } ?>>
            <a <? if (in_array($k, (array)$search_param['bsx'])) { ?>href="javascript:;" class="focus"<? } else { ?>href="/search.php?<?=$url_querystring?>&bsx=<?=$k?>"<? } ?>>
                <?=$v[1]?>
        </a>
    </li>
    <? } else { ?>
    <li <? if ($k == 4) { ?>style="width:40px;"<? } ?>>
        <span class="noresult"><?=$v[1]?></span>
    </li>        
    <? } ?>
    <?}?>   
    <? } ?>    
</ul>
</td>

<td class="biansx">
    <? if (!empty($match_options['jq'])) { ?>                                    
    <? foreach((array)$jq_select as $k=>$v) {?>
    <? if (array_key_exists($k, (array)$match_options['jq']) || count($match_options['jq'][$k]) || in_array($k, (array)$search_param['jq'])) { ?>
    <p>
        <a <? if (in_array($k, (array)$search_param['jq'])) { ?>href="javascript:;" class="focus"<? } else { ?>href="/search.php?<?=$url_querystring?>&jq=<?=$k?>"<? } ?>>
            <?=$v?>
    </a>
</p>
<? } else { ?>
<p>
    <span class="noresult"><?=$v?></span>
</p>       
<? } ?>
<?}?>          
<? } ?>   
</td>
<td class="seat">
    <ul>
        <? if (!empty($match_options['zw'])) { ?>                                    
        <? foreach((array)$zw_select as $k=>$v) {?>
        <? if (array_key_exists($k, (array)$match_options['zw']) || count($match_options['zw'][$k]) || in_array($k, (array)$search_param['zw'])) { ?>
        <li>
            <a <? if (in_array($k, (array)$search_param['zw'])) { ?>href="javascript:;" class="focus"<? } else { ?>href="/search.php?<?=$url_querystring?>&zw=<?=$k?>"<? } ?>>
                <?=$v?>座
        </a>
    </li>
    <? } else { ?>
    <li>
        <span class="noresult"><?=$v?>座</span>
    </li>           
    <? } ?>
    <?}?>   
    <? } ?>     
</ul>
</td>
<td style=" border-right:none" class="more_options">
    <ul>
        <li class="qig_dianji">
            <a href="javascript:void(0);">气缸数<span style="margin-left:21px;"><img src="images/redjt.png"></span></a>
            <div class="more_options_qigang more_options_zk" style="display: none;">
                <div style="position:absolute; top:-15px; right:-2px;"><img src="images/ss_gb.jpg"></div>
                <ul>
                    <? if (!empty($match_options['qg'])) { ?>                                    
                    <? foreach((array)$qg_select as $k=>$v) {?>
                    <? if (array_key_exists($k, (array)$match_options['qg']) || count($match_options['qg'][$k]) || in_array($k, (array)$search_param['qg'])) { ?>
                    <li>
                        <a <? if (in_array($k, (array)$search_param['qg'])) { ?>href="javascript:;" class="focus"<? } else { ?>href="/search.php?<?=$url_querystring?>&qg=<?=$k?>"<? } ?>>
                            <?=$v?>缸
                    </a>
                </li>
                <? } else { ?>
                <li><span class="noresult"><?=$v?>缸</span></li>               
                <? } ?>
                <?}?>                                    
                <? } ?>
            </ul>
        </div>							
    </li>
    <li class="cheti_dianji"><a href="javascript:void(0);">车体结构<span class="sanjiao"><img src="images/redjt.png"></span></a>
        <div style="display: none;" class="more_options_cheti more_options_zk">
            <div style="position:absolute; top:-15px; right:-2px;"><img src="images/ss_gb.jpg"></div>
            <? foreach((array)$st_select as $k=>$v) {?>
            <? if (array_key_exists($k, (array)$match_options['st']) || count($match_options['st'][$k]) || in_array($k, (array)$search_param['st'])) { ?>
            <a <? if (in_array($k, (array)$search_param['st'])) { ?>href="javascript:;" class="focus"<? } else { ?>href="/search.php?<?=$url_querystring?>&st=<?=$k?>"<? } ?>>
                <?=$v?>
        </a>
        <? } else { ?>
        <span class="noresult"><?=$v?></span>
        <? } ?>
        <?}?>       
    </div>	
</li>
<li class="qudong"><a href="javascript:void(0);">驱动形式<span class="sanjiao"><img src="images/redjt.png"></span></a>
    <div class="qudong_cont more_options_zk" style="display: none;">
        <div style="position:absolute; top:-15px; right:-2px;"><img src="images/ss_gb.jpg"></div>
        <? foreach((array)$dr_select as $k=>$v) {?>
        <? if (array_key_exists($k, (array)$match_options['dr']) || count($match_options['dr'][$k]) || in_array($k, (array)$search_param['dr'])) { ?>
        <a <? if (in_array($k, (array)$search_param['dr'])) { ?>href="javascript:;" class="focus"<? } else { ?>href="/search.php?<?=$url_querystring?>&dr=<?=$k?>"<? } ?>>
            <?=$v?>
    </a>&nbsp;
    <? } else { ?>
    <span class="noresult"><?=$v?></span>
    <? } ?>
    <?}?>
</div>
</li>
<li class="ranliao"><a href="javascript:void(0);">燃料类型<span class="sanjiao"><img src="images/redjt.png"></span></a>
    <div class="ranliao_cont more_options_zk" style="display: none;">
        <div style="position:absolute; top:-15px; right:-2px;"><img src="images/ss_gb.jpg"></div>
        <? foreach((array)$ot_select as $k=>$v) {?>
        <? if (array_key_exists($k, (array)$match_options['ot']) || count($match_options['ot'][$k]) || in_array($k, (array)$search_param['ot'])) { ?>
        <a <? if (in_array($k, (array)$search_param['ot'])) { ?>href="javascript:;" class="focus"<? } else { ?>href="/search.php?<?=$url_querystring?>&ot=<?=$k?>"<? } ?>>
            <?=$v?>
    </a>&nbsp;
    <? } else { ?>
    <span class="noresult"><?=$v?></span>
    <? } ?>
    <?}?>
</div>
</li>
<li class="che_dianji" style="top: 1px;">
    <a href="javascript:void(0);">车辆配置<span class="sanjiao"><img src="images/redjt.png"></span></a>
    <div class="more_options_peizhi more_options_zk" style="display:none;">    
        <div style="position:absolute; top:-15px; right:-2px;"><img src="images/ss_gb.jpg"></div>        
        <ul>        
            <? $i = 0 ?>
            <? foreach((array)$searchPz as $k=>$v) {?>
            <? ++$i ?>
            <? if (count($match_options[$k][1]) > 0) { ?>
            <li>
                <input <? if (in_array(1,(array)$search_param[$k])) { ?>checked="checked"<? } ?> type="checkbox" id="<?=$k?>">
                    <?=$v?>
            </li>
            <? } else { ?>
            <li>
                <input disabled="disabled" type="checkbox" id="<?=$k?>">
                <span class="noresult"><?=$v?></span>
            </li>
            <? } ?>        
            <?}?>
            <br>
            <li style="width:325px; text-align:center; margin-top:5px; margin-bottom:6px;" class="qd_an"><a href="javascript:void(0);"></a></li>
        </ul>    
    </div>    
</li>
</ul>
</td>
</tr>
</table>
</div>
<div class="ss_top4">
    <div class="sstj"> <span style="font-size:18px; color:#e61a15; width:106px; text-align:center; display:block; float:left;font-weight:bold">已选条件</span>

        <dl>
            <dd style="min-height: 64px;"> 
                <? if ($search_title) { ?><?=$search_title?><a href="/search.php?action=index" style="background:none; border:none; color:#e61a15; font-size:14px; margin-left:25px; font-weight:bolder;">撤销所有选择</a><? } ?>
            </dd>
        </dl>        
    </div>
    <div style="float:right; width:215px; margin:0 auto; text-align:center; font-size:14px;">
        <? if ($series_count && $model_count && $search_param['default_sid'] == 0) { ?>共 <span style="color:#ea1a14;"><?=$series_count?></span>个车系，<span style="color:#ff8f34;"><?=$model_count?></span>个车款<? } ?>
    </div>
</div>
</div>
<? if ($search_param['default_sid'] == 1) { ?>
<div class="bao_qian">
    <dl style="width:460px;padding-top:5px; float:left; margin-left:340px;">
        <dd>
            <div style="font-size:24px; height:42px; line-height:32px; color:#3983e5;">很抱歉,没有找到符合您要求的车款</div>
            <p style="font-size:16px; margin-top:5px;">以下为网站默认推荐车款</p>
        </dd>
    </dl>
    <div style="width:45px; height:42px; float:left; margin-top:20px;"><img src="images/bq.jpg"></div>
</div> 
<? } ?>
<? if (!empty($result)) { ?>
<div class="ss_container">
    <div class="ss_top5">
        <div class="shang_itabs">
            <div class="i-tabsx">                
                <div class="i-tabs-nav">                   
                    <h2><a <? if ($sale==0) { ?>href="javascript:;" class="i-tabs-item i-tabs-item-active"<? } else { ?> class="i-tabs-item" href="/search.php?<? echo qasStripField($url_querystring, array('sale')); ?>"<? } ?>>全部车型</a></h2>
                    <h2><a <? if ($sale==1) { ?>href="javascript:;" class="i-tabs-item i-tabs-item-active"<? } else { ?> class="i-tabs-item" href="/search.php?<? echo qasStripField($url_querystring, array('sale')) ?>&sale=1"<? } ?>>在产在售</a></h2>
                    <h2><a <? if ($sale==2) { ?>href="javascript:;" class="i-tabs-item i-tabs-item-active"<? } else { ?> class="i-tabs-item" href="/search.php?<? echo qasStripField($url_querystring, array('sale')) ?>&sale=2"<? } ?>>停产在售</a></h2>
                </div>                
                <p class="cx_top1" style="margin:10px 0px 0px 0px; height:21px;">
<!--                    <a href="?<? echo qasStripField($url_querystring, array('sortby', 'sort')) ?>" 
                    <? if ($sortby == 'dr') { ?>style="background:url(../images/tabbg.jpg);" >折扣</a>
                    <? } else { ?>
                    >折扣</a>
                    <? } ?>-->
                    <a href="/search.php?<? echo qasStripField($url_querystring, array('sortby', 'sort')) ?><? if ($sortby == 'pr' && $sort == 'asc') { ?>&sortby=pr&sort=desc<? } else { ?>&sortby=pr&sort=asc<? } ?>"
                       <? if ($sortby == 'pr' && $sort == 'asc') { ?>
                       style="background:url(../images/tabbg.jpg);" >价格</a>
                    <? } elseif($sortby == 'pr' && $sort == 'desc') { ?>
                    style="background:url(../images/tabbg.jpg);" >价格</a>
                    <? } else { ?>
                    >价格</a>
                    <? } ?>
<!--                    <a href="?<? echo qasStripField($url_querystring, array('sortby', 'sort')) ?>&sortby=dv&sort=desc" 
                       <? if ($sortby == 'dv') { ?>
                       style="background:url(../images/tabbg.jpg);" >优惠幅度</a>
                    <? } else { ?>
                    >优惠幅度</a>-->
<!--                    <? } ?>                    -->
                </p>

                <? foreach((array)$result as $k=>$v) {?>
                
                <div  class="ss_cont">
                    <dl>
                        <dt><a href="/modelinfo_s<?=$v['series_id']?>.html" target="_blank"><img class="lazyimgs" data-original="/attach/images/model/<? echo $series_pic[$v['series_id']]['default_mid'] ?>/<? echo '190x142' . $series_pic[$v[series_id]]['pic']; ?>"  onerror="this.src='../images/236x132.jpg'" src="../images/loading_img/loading189x142.png" width="190" height="142" alt="<? echo $series_info[$v['series_id']]['factory_name'] ?>  <? echo $series_info[$v['series_id']]['series_name'] ?>"/></a></dt>
                        <dd style="line-height:26px;">
                            <div style="border-bottom:solid 1px #000; height:36px; width: 305px;"> 
                                <span style="float:left; width:50px; height:30px;"><img style="height:30px;" src="/attach/images/brand/<? echo $brand_logo[$v['brand_id']]; ?>"  alt="<? echo $series_info[$v['series_id']]['factory_name'] ?>  <? echo $series_info[$v['series_id']]['series_name'] ?>"></span>
                                <span title="<? echo $series_info[$v['series_id']]['factory_name'] ?>  <? echo $series_info[$v['series_id']]['series_name'] ?>" style="height:30px; line-height:30px; margin-left:8px; font-size:16px; color:#000; float:left"><a href="/modelinfo_s<?=$v['series_id']?>.html" target="_blank"><? echo $series_info[$v['series_id']]['factory_name'] ?>  <? echo mb_substr($series_info[$v['series_id']]['series_name'],0,6,'utf-8') ?></a></span>
                                <!--<div class="chak"><a href="#">查看默认车款</a></div>-->
                            </div>
                            <div class="clear"></div>
                            <p style="width:305px; height:28px; line-height:28px;"> 
                                <span style="font-size:14px; float:left; width:80px;">基本参数</span> 
                                <span style="float:right; padding-right:8px;">
                                    <a href="/param.php?sid=<?=$v['series_id']?>" target="_blank">参数</a>
                                    丨<a href="bigpic.php?sid=<?=$v['series_id']?>" target="_blank"> 图片</a> 
                                    <? $officalUrl = $series_info[$v['series_id']]['offical_url'] ?>
                                    <? if ($officalUrl) { ?>
                                    丨<a href="<?=$officalUrl?>" target="_blank" rel="nofollow"> 官网</a>
                                    <? } ?>                                    
                                </span>
                            </p>
                            <div style="font-size:12px;">
                                <span style="width:150px; float:left;">级别：<? echo $series_info[$v['series_id']]['ct'] ?></span>
                                <span style="float:left;"> 排量：<? echo $series_info[$v['series_id']]['s1'] ?></span>
                            </div>
                            <div class="clear"></div>
                            <p style="font-size:12px;">车身形式：<? echo $series_info[$v['series_id']]['s3'] ?> </p>
                            <p style="font-size:12px; white-space:nowrap; overflow:hidden; width:305px;text-overflow:ellipsis; 
" title="<? echo $series_info[$v['series_id']]['s2'] ?>">变速箱：<? echo mb_substr($series_info[$v['series_id']]['s2'],0,30,'utf-8') ?></p>
                        </dd>             
                    </dl>
                    <div class="gaolia_pz">
                        <p style="text-align:center; font-size:16px; height:38px; line-height:38px;">亮点配置</p>
                        <div class="v_content">

                            <div class="v_content_nav">
                                <div class="v_content_w">
                                    <? $k = 0 ?>
                                    <? foreach((array)$v['setting'] as $st) {?>
                                    <? $pic = $pzimg[$st] ?>
                                    <? if ($pic && $k < 10) { ?>
                                    <? $k++ ?>
                                    <div class="v_content_array">
                                        <img class="lazyimgs" data-original="/images/search_icon/<?=$pic?>"  src="../images/loading_img/loading85x38.png" onerror="this.src='../images/85x38.jpg'" title="<? echo $pz[$st] ?>" >
                                    </div>
                                    <? } ?>
                                    <?}?>
                                </div>
                            </div>

                        </div>
                    </div>                      

                    <? $vs = $seriesPrice[$v['series_id']] ?>
                    <div class="market_price">
                        <div class="clear"></div>
                        <div style="font-size:18px;"> 网络媒体价</div>
                        <div>
                            <span style="font-size:32px; color:#ff8f34; height:36px; line-height:36px;"><? if ($v['bingo_price']) { ?><?=$v['bingo_price']?><? } elseif($v['model_price']) { ?><?=$v['model_price']?><? } ?></span>
                            <span style="font-size:14px;">万</span>
                        </div>
                        <div class="clear"></div>
                        <? if ($v['model_price']) { ?>                        
                        <div style="line-height:28px;">
                            <div style="float:left; font-size:14px" >
                                厂商指导价：<span style=" margin-right:3px; font-size:14px;"><? echo (float) $v['model_price'] ?> 万</span>
                            </div>
                        </div>  
                        <? } ?>
                    </div>                              

                </div>
                <div class="table_1 mtable_<?=$v['series_id']?>" style="display: none;"></div>      
                <? if ($v['model_count'] > 0) { ?>
                <div class="chakan_ck stable_<?=$v['series_id']?>">
                    <input type="hidden" value="<?=$v['series_id']?>">
                    <div style="color: rgb(58, 138, 243); font-size: 14px; display: block;" class="chakan_ck1">
                        <div class="chakan_ck2">
                            <a class="ck_up" href="javascript:void(0);">展开全部车款(<?=$v['model_count']?>)</a>
                        </div>
                    </div>
                    <div style="color: rgb(58, 138, 243); font-size: 14px; display:none" class="chakan_ck22">
                        <p style="text-align: center"><img id="loading" src="images/load.gif"></p>
                    </div>
                    <div style="color: rgb(58, 138, 243); font-size: 14px; display: none;" class="chakan_ck3">
                        <a class="ck_down" href="javascript:void(0);">收起全部车款(<?=$v['model_count']?>)</a> 
                    </div>
                </div>                                
                <div style="border:solid 1px #e61a15; bottom: 0; clear: both;"></div>            
                <? } ?>                
                <? } ?>                                    
            </div>                        
        </div>                      
    </div>
</div>
<? } ?>
<div class="peizhi_itabs" style="display:none;">
    <div style="color:#585858;" class="i-tabs-nav">
        <span style="float:left; width:200px;">快速对比价格</span>
        <div class="db_up" style="color:#585858; margin-right:10px; float:right; font-size:12px;">
            <a class="ksdb" href="javascript:void(0);">开始对比</a> <a class="close_quick_compare" href="javascript:void(0);">收起</a>
            <input type="hidden" id="ksdbval" name="ksdbval" value="">
        </div>
    </div>
    <div class="i-tabs-container">
        <span class="no_left"><img src="images/db_left.jpg"></span>
        <div class="db_container" style="display:none;">
            <dl>
                <dt><img class="cmp_model_pic" width="122" height="93" src="" onerror="this.src='images/122x93.jpg'"></dt>
                <dd>
                    <div class="db_title cmp_model_name"></div>
                    <div class="db_cont">
                        <div class="db_left cmp_bingo_price"></div>
                        <span class="db_sq cmp_li"><img src="images/libao.jpg"></span>
                    </div>
                    <div class="db_cont">
                        <div class="db_left cmp_model_price"></div>
                        <span class="db_sq cmp_jie"> <img src="images/butie.jpg"></span>
                    </div>
                    <div class="db_cont">
                        <div class="db_left xianjin"></div> 
                        <span class="db_sq teshu"><img src="images/huodong.jpg"></span>
                    </div>
                </dd>
            </dl>
            <div class="clear"></div>
            <div class="db_shanchu">
                <a style="float:left;" href="javascript:void(0);" class="move_left"><img src="images/db_left.jpg"></a>
                <span class="shanchu"><a href="javascript:void(0);">删除</a><input type="hidden" class="quick_mid" value=""/></span>                
                <a style="float:right;" href="javascript:void(0);" class="move_right"><img src="images/db_right.jpg"></a>
            </div>
        </div>
        <span class="no_right"><img src="images/db_right.jpg"></span>
    </div>
</div>    
<? if ($page_bar) { ?>
<div class="fy_cont" style="width:1178px;">
    <ul><?=$page_bar?></ul>
</div>
<? } ?>
</div>
<div class="clear"></div>
<div class="zk_bian" style="display:none;">
    <p style="float:right;">&nbsp;
        <!--<img src="images/bian_close.jpg">-->
    </p>
    <p class="bian_zhank"><a href="javascript:void(0);">展开</a></p>
    <p class="bian_zhank_k"><a href="javascript:void(0);">快速对比</a></p>
    <p class="bian_jiant"><img src="images/bian_jiant.jpg"></p>
</div>

<script>
    $(".chakan_ck").click(function () {
        var sid = $(this).children('input').val();
        var ck = '<?=$cacheKey?>';
        if (!$('.stable_' + sid).children('.chakan_ck1').is(':hidden')) {
            if ($('.mtable_' + sid).html() == '') {
                $.ajax({
                    url:'/search.php?action=AjaxSeriesZk',
                    type: "GET",
                    data:({sid: sid, ck: ck}),
                    beforeSend:function(){
                        $('.stable_' + sid).children('.chakan_ck22').css("display","block");
                        $('.stable_' + sid).children('.chakan_ck1').hide();
                    }, 
                    //添加loading信息
                    success:function(ret){
                        $('.mtable_' + sid).html(ret);
                        $('.stable_' + sid).children('.chakan_ck22').css("display","none");
                        $('.stable_' + sid).children('.chakan_ck3').show();
                    }    
                    //清掉loading信息
                });
                $('.mtable_' + sid).toggle();
            }else{
                $('.stable_' + sid).children('.chakan_ck1').hide();
                $('.stable_' + sid).children('.chakan_ck3').show();
                $('.mtable_' + sid).toggle();
            }
        }else {
            $('.stable_' + sid).children('.chakan_ck1').show();
            $('.stable_' + sid).children('.chakan_ck3').hide();
            $('.mtable_' + sid).toggle();
        }
    })


/*展开对比*/
    $('.quick_compare').click(function(){
        $(this).attr('checked','checked');
        $('.peizhi_itabs').show();
        $('.zk_bian').hide();
    })

    //居中快速对比图标
    var right = ($(window).width() - 1180) / 2 - $('.zk_bian').width();
    var zktop = $(window).height() / 2;
    $('.zk_bian').css('right', right);
    $('.zk_bian').css('top', zktop);  
    $('.move_right').live('click', function () {
        var parent = $(this).parent('.db_shanchu').parent('.db_container');
        parent.insertAfter(parent.next());
    });
    $('.move_left').live('click', function () {
        var parent = $(this).parent('.db_shanchu').parent('.db_container');
        parent.insertBefore(parent.prev());
    });
    $('.ksdb,.bian_zhank_k').click(function () {
        var val = $('#ksdbval').val();
        val = val.replace(/_$/g, '', val);
        window.open('compare_' + val + '.html');
    });
    $('.shanchu').live('click', function () {
        var model_id = $(this).children('.quick_mid').val();
        $(this).parent('.db_shanchu').parent('.db_container').remove();
        $('input[value="' + model_id + '"]').attr('checked', false);
        if ($('.i-tabs-container').children('div').length == 1)
            $('.peizhi_itabs').hide();
    });
    /*快速对比*/
    $('.quick_compare').live('click', function () {
        var num = $('.i-tabs-container').children('div').length;
        var isChecked = $(this).is(':checked');
        var model_id = $(this).val();
        if (isChecked == true) {
            if (num < 5) {
                var val = $('#ksdbval').val();
                val += model_id + '_';
                $('#ksdbval').val(val);
                $('.peizhi_itabs').show();
                $.get('/search.php?action=ajaxQuickCompare', {model_id: model_id}, function (str) {
                    var ret = eval('(' + str + ')');
                    var div = $('.i-tabs-container').children('.db_container').eq(0);
                    var html = '<div class="db_container container_' + model_id + '">' + div.html() + '</div>';
                    $('.i-tabs-container').append(html);
                    $('.quick_mid').eq(num).val(model_id);
                    <? if ($attach_server) { ?>
                    $('.cmp_model_pic').eq(num).attr('src', '<?=$attach_server?>/model/' + model_id + '/122x93' + ret.model_pic1);
                    <? } else { ?>
                    $('.cmp_model_pic').eq(num).attr('src', '/attach/images/model/' + model_id + '/122x93' + ret.model_pic1);
                    <? } ?>
                    $('.cmp_model_name').eq(num).text(ret.series_name + ' ' + ret.model_name);
                    if (ret.dealer_price_low > 0)
                        $('.cmp_bingo_price').eq(num).html('媒体价：<span style="color:#ff8f34;">' + ret.dealer_price_low + '万</span>');
                    else if (ret.media_price > 0)
                        $('.cmp_bingo_price').eq(num).html('媒体价：<span style="color:#ff8f34;">' + ret.media_price + '万</span>');
                    else
                        $('.cmp_bingo_price').eq(num).html('媒体价：<span style="color:#ff8f34;">未获取</span>');
                    $('.cmp_model_price').eq(num).html('<span style="color:#8a8a8a; text-decoration:line-through;">指导价：' + ret.model_price + '万</span>');
                    
                    if (ret.free_promotion_gift == '' || ret.free_promotion_gift == '无' || !ret.free_promotion_gift)
                        $('.cmp_li').eq(num).hide();
                    else {
                        $('.cmp_li').eq(num).show();
                        $('.cmp_li').eq(num).attr('title', ret.free_promotion_gift);
                    }
                    if (ret.conservate && ret.conservate != 0 || ret.oldcar_company_prize && ret.oldcar_company_prize != 0) {
                        $('.cmp_jie').eq(num).show();
                        var title = '';
                        if (ret.conservate && ret.conservate != 0)
                            title = '节能惠民补贴：' + ret.conservate;
                        if (ret.oldcar_company_prize && ret.oldcar_company_prize != 0)
                            title += ' 置换补贴(老旧)：' + ret.oldcar_company_prize;
                        $('.cmp_jie').eq(num).attr('title', title);
                    }
                    else
                        $('.cmp_jie').eq(num).hide();
                    if (ret.special_event == '无' || ret.special_event == '' || !ret.special_event) {
                        $('.teshu').eq(num).hide();
                    }
                    else {
                        $('.teshu').eq(num).show();
                        $('.teshu').eq(num).attr('title', ret.special_event);
                    }
                });
            }
            else {
                $(this).attr('checked', false);
                alert('对比车型最多可以添加4个');
            }
        }
        else {
            var val = $('#ksdbval').val();
            val = val.replace(model_id + '_', '');
            $('#ksdbval').val(val);
            $('.container_' + model_id).remove();
            if (num == 2)
                $('.peizhi_itabs').hide();
        }
    });
    /*居中对比框*/
    var right = ($(window).width() - $('.peizhi_itabs').width()) / 2;
    $('.peizhi_itabs').css('right', right);
    $('.more_options ul li').click(function () {
        var num = $(this).index();
        $('.more_options_zk').eq(num).toggle();
        $('.more_options_zk').not($('.more_options_zk').eq(num)).hide();
    });
    $('.qd_an').click(function () {
        var str = '';
        var url = '<?=$url_querystring?>'
        url = url.replace(/(&*sp\d+=\d+)/g, '');
        for (i = 1; i < 16; i++) {
            if ($('#sp' + i).is(':checked') == true)
                str += '&sp' + i + '=1';
        }
        if (!url)
            str = str.substr(1);
        location.href = "/search.php?" + url + str;
    });
    //输入价格区间
    $(".input_ss").click(function () {
        var search_price_low = parseInt($("#price_low").val());
        var search_price_high = parseInt($("#price_high").val());
        if ($("#price_low").val() == "" || $("#price_high").val() == "") {
            alert("价格区间不能为空!");
            return false;
        } else if (isNaN(search_price_low) || isNaN(search_price_high)) {
            alert("价格只能为数字!!");
            return false;
        } else if (search_price_low > search_price_high) {
            alert("价格区间填写不正确!!");
            return false;
        } else {
            window.location = "/search.php?<?=$inner_price_str?>&cdp=" + search_price_low + "," + search_price_high;
        }
    });
    function closeQuickCmp(model_id) {
        $("input[value='" + model_id + "']").attr('checked', false);
        $('.duibi_' + model_id).remove();
    }
    function getPriceInfo(mid, tid) {
        if ($('.tr_' + mid).is(':hidden')) {
            $.get('/search.php?action=ajaxModelZk', {model_id: mid, type: tid}, function (ret) {
                if (ret) {
                    var obj = eval('(' + ret + ')');
                    $('#dealer_pic_' + mid).attr('src', obj.dealer_pic);
                    if (obj.active_url)
                        $('#active_url_' + mid).attr('href', obj.active_url);
                    if (obj.source_url)
                        $('#source_url_' + mid).attr('href', obj.source_url);
                    if (obj.chou) {
                        $('#dl_chou_' + mid).show();
                        $('#chou_' + mid).html(obj.chou);
                    }
                    if (obj.xian) {
                        $('#dl_xian_' + mid).show();
                        $('#xian_' + mid).html(obj.xian);
                    }
                    if (obj.zeng) {
                        $('#dl_zeng_' + mid).show();
                        $('#zeng_' + mid).html(obj.zeng);
                    }

                    $('#dealer_name_' + mid).text(obj.dealer_name);
                    $('#dealer_area_' + mid).text(obj.dealer_area);
                    $('#dealer_tel_' + mid).text(obj.dealer_tel);
                    $('#dealer_linkman_' + mid).text(obj.dealer_linkman);
                    $('#price_type_' + mid).html(obj.price_type_name);
                    $('#get_type_' + mid).text(obj.get_type);
                    $('#jnbt_' + mid).text(obj.jnbt);
                    $('#rate_' + mid).html(obj.rate);
                    $('#get_time_' + mid).text(obj.get_time);
                    $('#oldcar_' + mid).text(obj.car_prize);
                    $('#cp_id_' + mid).text(obj.cp_id);
                    if (obj.free_promotion_gift != '无' && obj.free_promotion_gift) {
                        $('#lib_' + mid).show();
                        $('#lib_' + mid).attr('title', obj.free_promotion_gift);
                    }
                    if (obj.special_event) {
                        $('#special_' + mid).show();
                        $('#special_' + mid).attr('title', obj.special_event);
                    }
                    $('.tr_' + mid).show();
                    $('#changechk_' + mid + ' a').toggle();
                }
            });
        }else {
            $('.tr_' + mid).hide();
            $('#changechk_' + mid + ' a').toggle();
        };
    }
</script>
<script>
    (function() {
        var bct = document.createElement("script");
        bct.src = "/js/counter.php?cname=search_result&c1=1&c2=&c3=";
        bct.src += "&df="+document.referrer;
        document.getElementsByTagName('head')[0].appendChild(bct);
    })();
</script>
<script type="text/javascript">
    $(function(){
        $('.denglu').hide();
    })
</script>
<? include $this->gettpl('index_footer');?>