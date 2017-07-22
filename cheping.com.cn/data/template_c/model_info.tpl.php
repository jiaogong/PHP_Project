<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('index_header');?>
<!--content开始-->
<script type="text/javascript" src="vendor/FusionCharts/js/FusionCharts.js"></script>
<div class="content_v4">
    <div class="wrap1_v2">
        <div class="topv1_title">
            <div class="topv1_name"> 
                <div style="float: left;width:62px;height: 46px;line-height: 46px;background-color: #fff;text-align: center;border-right: 1px solid #D7DFE4;">
                    <span style="vertical-align:middle;padding-left: 10px;padding-right: 10px;">
                        <img style="vertical-align: middle;" <? if ($logo_size[1]>46) { ?>height='46'<? } ?>src="/attach/images/brand/<?=$brand_logo?>" alt="<?=$model['series_name']?> <?=$model['model_name']?>">
                    </span>
                </div>
                <div style="font-size:18px;padding-left: 5px;" class="xl_bg">
                    <?=$model['series_name']?> <?=$model['model_name']?>
                    <div class="topv1_nr" style="display:none;width:<? echo $model_name_max ?>px;">
                        <ul>
                            <? foreach((array)$serielist as $key=>$value) {?>
                            <li><a href="modelinfo_<?=$value['model_id']?>.html" target="_blank"><?=$value['model_name']?></a></li>
                            <?}?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="xl_kuang">
                <form>
                    <span style="margin:0px 5px; font-size:14px; font-weight:bolder; color:#585858;">切换车系</span>
                    <select style="width:130px; margin-right:5px; cursor:pointer" id="brand_id" name="brand_id" onchange="javascript:series_select($('#series_id'), this.value);">
                        <option selected value="0">品牌</option>
                        <script>brand_select($('#brand_id'));</script> 
                        <? if (!$model['brand_id']) { ?><script>brand_select($('#brand_id'));</script><? } else { ?><script>brand_select($('#brand_id'), <?=$model['brand_id']?>);</script><? } ?>
                    </select>
                    <select style="width:130px; cursor:pointer" id="series_id" name="series_id" onchange="modelinfo_s(this.value)" >
                        <option value="">车系</option>
                        <? if ($model['brand_id']&&$model['series_id']) { ?><script> series_selected($('#series_id'), <?=$model['brand_id']?>, <?=$model['series_id']?>)</script><? } ?>
                    </select>
                </form>
            </div>
        </div>
        <div class="wrap_middle">
            <div class="left1_v3">
                <div class="ckdt_lunbo">
                    <div id="ckdt_datu">
                        <ul class="datu">
                            <li><a  href="bigpic_<?=$model_pic[1][type_id]?>_<? if ($model_pic[1][color_id]) { ?><?=$model_pic[1][color_id]?><? } else { ?>0<? } ?>_<?=$model_pic[1][pos]?>_<?=$model_pic[1][id]?>.html" target="_blank"><img class="lazyimg" onerror = "this.src='images/305x220.jpg'" data-original="attach/images/model/<?=$model_pic[1][type_id]?>/304x227<?=$model_pic[1][name]?>" src="../images/loading_img/loading320x240.png" width="320" height="240" alt="<?=$model['series_name']?> <?=$model['model_name']?>"/></a></li>
                            <? if ($model_pic[4][color_id]) { ?><li><a href="bigpic_<?=$model_pic[4][type_id]?>_<?=$model_pic[4][color_id]?>_<?=$model_pic[4][pos]?>_<?=$model_pic[4][id]?>.html" target="_blank"><img class="lazyimg"  onerror = "this.src='images/305x220.jpg'" data-original="attach/images/model/<?=$model_pic[4][type_id]?>/304x227<?=$model_pic[4][name]?>" src="../images/loading_img/loading320x240.png" width="320" height="240" alt="<?=$model['series_name']?> <?=$model['model_name']?>"/></a></li><? } ?>
                            <? if ($model_pic[2][color_id]) { ?><li><a href="bigpic_<?=$model_pic[2][type_id]?>_<?=$model_pic[2][color_id]?>_<?=$model_pic[2][pos]?>_<?=$model_pic[2][id]?>.html" target="_blank"><img class="lazyimg"  onerror = "this.src='images/305x220.jpg'" data-original="attach/images/model/<?=$model_pic[2][type_id]?>/304x227<?=$model_pic[2][name]?>" src="../images/loading_img/loading320x240.png" width="320" height="240" alt="<?=$model['series_name']?> <?=$model['model_name']?>"/></a></li><? } ?>
                        </ul>
                        <? if ($model_pic[5]) { ?> <div class="zi_title" style="display: none;">本车款暂无实拍图,当前显示为该车系下默认车款实拍图</div><? } ?>
                    </div>
                    <div class="ckdt_shu">
                        <div id="ckdt_xiaotu" style="height:535px; overflow:hidden;">
                            <ul class="ss_tt" id="ss_ul">
                                <? foreach((array)$model_pic as $key=>$value) {?>
                                <? if ($key<4) { ?>
                                <? if ($value['color_id']) { ?><li class="ckdt_z <? if ($key==1) { ?>focus<? } ?>"><a <? if ($model_pic[5]) { ?>title="本车款暂无实拍图&#10;当前显示为该车系下默认车款实拍图"<? } ?> href="bigpic_<?=$value['type_id']?>_<? if ($value['color_id']) { ?><?=$value['color_id']?><? } else { ?>0<? } ?>_<?=$value['pos']?>_<?=$value['id']?>.html" target="_blank"><img bid='1'  class="lazyimg"  onerror = "this.src='images/305x220.jpg'" data-original="attach/images/model/<?=$value['type_id']?>/122x93<?=$value['name']?>" src="../images/loading_img/loading100x76.png"  width="100" height="76" alt="<?=$model['series_name']?> <?=$model['model_name']?>"/></a></li><? } ?>
                                <? } ?>
                                <?}?>
                            </ul>
                        </div>
                    </div>
                </div>
                <? if ($series_color_pic) { ?>
                <div class="ysk"><? if ($series_color_pic) { ?><span style="width:50px; float:left">外观颜色</span>
                    <? $color_num=count($series_color_pic) ?>
                    <div class="v_content">
                        <div class="img_l"><? if ($color_num>8) { ?><img src="images/ckyx_left.png" /><? } ?></div>
                        <div class="v_content_nav">
                            <div class="v_content_w">
                                <? foreach((array)$series_color_pic as $key=>$value) {?>
                                <div class="v_content_array">
                                    <div class="v_content_img"><a href="javascript:void(0);"><img title="<? if ($value['type_id']==$model['model_id']) { ?><?=$value['color_name']?><? } else { ?><?=$value['color_name']?><? } ?>" onerror = "this.src='images/50x50.jpg'" src="attach/images/<? if ($value['color_pic']!='not fand') { ?><?=$value['color_pic']?><? } ?>" width="24" height="24" alt="<? if ($value['type_id']==$model['model_id']) { ?><?=$value['color_name']?><? } else { ?><?=$value['color_name']?><? } ?> <?=$model['series_name']?> <?=$model['model_name']?>"> </a> 					<input type="hidden" value="<?=$value['pic_color']?>" name="pic_color">			                                   </div>
                                </div>
                                <?}?>
                            </div>
                        </div>
                        <div class="img_r"><? if ($color_num>8) { ?><img src="images/cky_right.png" /><? } ?></div>
                    </div>
                    <? } else { ?>
                    <span style="width:100px; float:left">外观颜色暂无</span>
                    <? } ?>
                </div>		
                <? } ?>
            </div> 
            <div class="left1_center">
                <div class="p_span">
                    <div style="font-size:16px; color:#000;margin-top:10px;">媒体价：</div>
                    <div style="font-size:34px;color:#ff8f34; line-height:30px;"><?=$offers['price']?></div>
                    <div style="margin-top: 12px;font-weight:bold">万</div>
                </div>
                <div class="clear"></div>
                <p style="font-size:16px; color:#585858; line-height:26px; margin-top:18px;">厂商指导价：<?=$model['model_price']?>万 <a href="calculator.php?bid=<?=$model['brand_id']?>&sid=<?=$model['series_id']?>&mid=<?=$model['model_id']?>&price=<? if ($offers['price']) { ?><?=$offers['price']?><? } else { ?><? echo $offers['lcprice']/10000 ?><? } ?>" target="_blank"><img src="images/sqy_jsq.jpg"></a></p>
                <p style="margin-top:18px;">
                    <a class="jdb" target="_blank" href="compare_<?=$model['model_id']?>.html">加对比</a>
                </p>
                <div class="zycs_cont">
                    <div class="zycs_title">
                        <b style="font-size:16px; color:#000; font-weight:normal; float:left">主要参数</b>
                        <div class="zycs_lj"><a href="<?=$model['offical_url']?>" target="_blank" rel="nofollow">品牌官网</a> 丨<a href="/modelpicselect/<?=$model['series_id']?>_<?=$model['model_id']?>__.html" target="_blank"> 实拍图片</a> 丨<a href="param_<?=$model['model_id']?>.html" target="_blank"> 参数配置</a></div>
                    </div>
                    <ul>
                        <li> 级别：<?=$model['type_name']?>  </li>
                        <li> 排量：<? if ($model['st27']=="无") { ?><?=$model['st27']?><? } else { ?><?=$model['st27']?><? if ($model['st28']!=="自然吸气") { ?>L<? } ?><? } ?></li>
                        <li>变速箱：<? echo dstring::substring($model['st48'],0,16) ?> </li>
                        <li>驱动形式：<?=$model['st51']?></li>
                        <li>车身形式：<?=$model['st4']?> </li>
                        <li>燃油标号：<?=$model['st42']?></li>
                    </ul>									
                </div>
                <div class="zycs_cont">
                    <div class="zycs_title">
                        <b style="font-size:16px; color:#000; font-weight:normal;">亮点配置</b>
                    </div>
                    <div class="dlpz_tainer">
                        <div class="dlpz_tb">
                            <? foreach((array)$m_pz as $key=>$value) {?>
                            <a href="javascript:void(0)">
                                <img oldwidth="22" oldheight="22" onmouseover="zoom(this)" onmouseout="this.width = this.getAttribute('oldwidth');
                                                    this.height = this.getAttribute('oldheight');" onerror = "this.src='images/50x50.jpg'"  src="images/peizi/<?=$pzImg['newss'][$value]?>.png" title="<?=$pzImg['newssn'][$value]?>">
                            </a>
                            <?}?>
                        </div>
                    </div>
                    <div class="dlpz_right">
                        <a href="javascript:void(0)" class="up_pz" url="<?=$mid?>">展开全部配置<em></em></a>
                        <a href="javascript:void(0)" class="down_pz" style="display:none">收起全部配置<em></em></a>
                    </div>
                </div>
            </div>
            <div class="left1_right">
                <div class="right_top1" style="margin-top:10px;"><span>竞争车型</span></div>
                <div class="right_top2">
                    <? foreach((array)$compete_list as $key=>$value) {?>
                    <dl <? if ($key==2) { ?>style="margin:0px;"<? } ?>>
                        <dt><a target="_blank" href="modelinfo_<?=$value['model_id']?>.html"> <img class="lazyimgs" width="122" height="93" data-original="/attach/images/model/<?=$value['model_id']?>/122x93<?=$value['model_pic1']?>" src="../images/loading_img/loading122x93.png" onerror="this.src='images/180x100.jpg'" alt="<?=$value['brand_name']?> <?=$value['series_name']?> <?=$value['model_name']?>"></a></dt>
                        <dd><a target="_blank" href="modelinfo_<?=$value['model_id']?>.html"> <?=$value['brand_name']?> <?=$value['series_name']?> <?=$value['model_name']?></a></dd>
                    </dl>
                    <?}?>
                </div>
            </div>
        </div>                                             
        <div class="clear"></div>  
        <div class="qbpz_tabs" style="display:none">
            <div class="i-tabs">
                <div class="i-tabs-nav"> 
                    <span class="i-tabs-item i-tabs-item-active" style="border-left:none"> 全部配置 </span> 
                    <span class="i-tabs-item"> 安全 </span> 
                    <span class="i-tabs-item"> 舒适 </span>
                    <span class="i-tabs-item"> 驾控 </span>
                    <span class="i-tabs-item"> 外部</span>
                    <span class="rg_close"><a href="javascript:void(-1);"><img src="images/close_l1.jpg" /></a></span>	
                </div>
                <div class="i-tabs-container" id="i-tabs-container">

                </div>
            </div>
        </div>	
    </div>
    <div class="clear"></div>
    <div class="bggmc_cont2">
        <div class="cxlb_title">车系列表<b style="font-weight:normal; font-size:12px;">（共<span style="color:#ea1a14;"><? echo $normal_count + $stop_count ?></span>款）</b></div>
        <div class="cxlb">
            <div class="i-tabs">
                <div class="i-tabs-nav"><? if ($normal_count>0) { ?> <span class="i-tabs-item i-tabs-item-active">在售<b style="font-weight:normal; font-size:12px;">（<a ><?=$normal_count?></a>款）</b></span> <? } ?><? if ($stop_count>0) { ?><span class="i-tabs-item"> 停产<b style="font-weight:normal; font-size:12px;"> (<a ><?=$stop_count?></a>款）</b></span><? } ?> </div>
                <div class="i-tabs-container">
                    <div class="i-tabs-content i-tabs-content-active">
                        <div class="tabs-news-module">
                            <div class="top15">
                                <div class="mid15">
                                    <table> 
                                        <? $normal_num =0; ?>
                                        <? foreach((array)$result_normal['models'] as $key=>$value) {?>
                                        <? ++$normal_num; ?>
                                        <tr>
                                            <th class="mid_tilte" colspan="2" ><?=$key?></th>
                                            <th class="mid_tilte"  colspan="6"></th>
                                        </tr>
                                        <? if ($normal_num==1) { ?>
                                        <tr class="mid_content">
                                            <th width="81" height="50">排量</th>
                                            <th width="280" height="50">车款</th>
                                            <th width="100" height="50">厂商指导价</th>
                                            <th width="107" height="50">媒体价</th>
                                            <th width="65">优惠幅度</th>
                                            <th width="358" height="50"> 车款亮点配置 <br />
                                                <span style="color:#ea1a14; font-size:12px; font-weight:normal">红色<font style="color:#000;">图标为相比同年款、同排量最低配多出的配置</font></span></th>
                                            <th width="68" height="50">全部配置</th>
                                            <th width="61" height="50" style="border:none"></th>
                                        </tr>
                                        <? } ?>
                                        <? foreach((array)$value as $kk=>$vv) {?>
                                        <? $pz_num =count($vv) ?>
                                        <? foreach((array)$vv as $k=>$v) {?>
                                        <tr>
                                            <? if ($k==0) { ?>
                                            <td width="81"  rowspan="<?=$pz_num?>" style=" text-align:center; border-left:none;"><?=$kk?></td> 
                                            <? } ?>
                                            <td width="280"><div class="chekuan_td">
                                                    <p style="font-weight:bolder;"><a target="_blank" href="modelinfo_<?=$v[model_id]?>.html"><?=$v[model_name]?></a></p>
                                                    <div class="rd"><span>热度</span> <span title="<?=$v['views']?>" class="redu<? echo round($v['views'] / 10) ?>"></span></div>
                                                    <span class="cs"></span>
                                                    <div class="chekuan">
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <th width="110">长×宽×高（mm）</th>
                                                                    <th width="80">轴距（mm）</th>
                                                                    <th width="80">驱动形式</th>
                                                                    <th width="115">发动机排量（cm3）</th>
                                                                    <th width="115">发动机形式 </th>
                                                                    <th width="85">变速箱</th>
                                                                    <th width="100">功率PS（KW）</th>
                                                                    <th width="115">扭矩（N·m/rpm）</th>
                                                                    <th width="130">综合油耗（L/100km）</th>
                                                                    <th width="105"> 百公里加速（S） </th>
                                                                    <th width="40"></th>
                                                                </tr>
                                                                <tr>
                                                                    <td><? if (empty($v['st3'])) { ?>--<? } else { ?><?=$v['st3']?><? } ?></td>
                                                                    <td><? if (empty($v['st15'])||$v['st15']=="无") { ?>--<? } else { ?><?=$v['st15']?><? } ?></td>
                                                                    <td><? if (empty($v['st51'])) { ?>--<? } else { ?><?=$v['st51']?><? } ?></td>
                                                                    <td><? if (empty($v['st26'])||$v['st26']=="无") { ?>--<? } else { ?><?=$v['st26']?><? } ?></td>
                                                                    <td><? if ($v['st29']&&$v['st30']&&$v['st29']!=="无"&&$v['st30']!=="无") { ?><?=$v['st29']?><?=$v['st30']?><? } else { ?>--<? } ?></td>
                                                                    <td><? $str = $v['st2'].(intval($v['st49'])>0 ? $v['st49'] : "" ) ?><? echo preg_replace($patterns, $replacements, $str); ?></td>
                                                                    <td> <? if (empty($v['st36'])||$v['st36']=="无") { ?>--<? } else { ?><?=$v['st36']?><? } ?><? if (empty($v['st37'])||$v['st37']=="无") { ?>--<? } else { ?>(<?=$v['st37']?>)<? } ?></td>
                                                                    <td> <? if (empty($v['st39'])||$v['st39']=="无") { ?>--<? } else { ?><?=$v['st39']?><? } ?> </td>
                                                                    <td> <? if (empty($v['st10'])||$v['st10']=="无") { ?>--<? } else { ?><?=$v['st10']?><? } ?>  </td>
                                                                    <td> 
                                                                        <? if (!$v['st6'] || $v['st6'] == '无') { ?> 暂无<? } else { ?><?=$v['st6']?><? } ?>  </td>
                                                                    <td><a href="param_<?=$v[model_id]?>.html" target="_blank">更多&gt;</a></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div></td>
                                            <td width="100"  class="duibi_xin"><span><a href="compare_<?=$v['model_id']?>.html" target="_blank">对比</a></span><?=$v[model_price]?>万</td>
                                            <td  style="color:#ff8f34;" ><? if ($v[price]>0) { ?><div title="媒体价"  <? if ($v[pricelog_id_from]) { ?>style="float: left;margin-left: 8px;"<? } ?>><?=$v[price]?>万</div>
                                                <? } else { ?>--<? } ?></td>
                                            <td width="86"><? if ($v[m_price]>0) { ?><img style="margin-right:2px;" src="images/yhfd_up.jpg"><? echo $v[m_price]*10000 ?>元<? } elseif($v[m_price]<0) { ?><img style="vertical-align:middle;margin-right:2px;" src="images/ck_sjfd.jpg"><? echo abs($v[m_price]*10000) ?>元<? } elseif($v[m_price]=='0') { ?>无优惠<? } else { ?>--<? } ?></td>
                                            <td>
                                                <div class="cy_ul">
                                                    <ul>
                                                        <? foreach((array)$v[pz] as $kkk=>$vvv) {?> 
                                                        <li ><img onerror = "this.src='images/50x50.jpg'" src="images/peizi/<?=$vvv?>" oldwidth="22" oldheight="22" onmouseover="zoom(this)" onmouseout="this.width = this.getAttribute('oldwidth');
                                                                            this.height = this.getAttribute('oldheight');" title="<? echo $pz_img['newssn'][$kkk] ?>"></li>
                                                        <?}?>
                                                    </ul>
                                                </div>
                                                <div class="cy_peizhi">	  
                                                    <div class="peizhi_tab" style="display:none">
                                                        <div class="lintab2_bottom">
                                                            <ul class="lintab2_tt" id="lintab2_tt1">
                                                                <li class="cky_hover"><a href="javascript:void(0);">全部配置  </a></li>
                                                                <li class="cky_link"><a href="javascript:void(0);">  安全</a></li>
                                                                <li class="cky_link"><a href="javascript:void(0);"> 舒适</a></li>
                                                                <li class="cky_link"><a href="javascript:void(0);">  驾控</a></li>
                                                                <li class="cky_link"><a href="javascript:void(0);">  外部</a></li>
                                                            </ul>
                                                            <ul class="lintab2_list lr0"  id="pz0_<?=$v[model_id]?>" style="display:block;"></ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td width="68" class="ckpz" style="color:#ea1a14;">
                                                <a href="javascript:void(0)" class="ckpz_id" onclick="peizhi('<?=$v[model_id]?>')">查看</a>
                                            </td>
                                            <td class="intr_tu">
                                                <div class="xianqin_xin"><a href="offers_<?=$v[model_id]?>.html" target="_blank">价格详情</a></div>
                                                <p style="text-align:center; margin:0px;">
                                            </td>
                                        </tr>
                                        <?}?>
                                        <?}?>
                                        <?}?>
                                    </table>
                                </div>
                            </div>           
                        </div>
                    </div>
                    <div class="i-tabs-content">
                        <div class="tabs-news-module">
                            <div class="top15">
                                <div class="mid15">
                                    <table> 
                                        <? $stop_num =0; ?>
                                        <? foreach((array)$result_stop['models'] as $key=>$value) {?>
                                        <? ++$stop_num; ?>
                                        <tr>
                                            <th class="mid_tilte" colspan="2" ><?=$key?></th>
                                            <th class="mid_tilte"  colspan="6"></th>
                                        </tr>
                                        <? if ($stop_num==1) { ?>
                                        <tr class="mid_content">
                                            <th width="81" height="50">排量</th>
                                            <th width="280" height="50">车款</th>
                                            <th width="100" height="50">厂商指导价</th>
                                            <th width="107" height="50">媒体价</th>
                                            <th width="86">优惠幅度</th>
                                            <th width="358" height="50"> 车款亮点配置 <br />
                                                <span style="color:#ea1a14; font-size:12px; font-weight:normal"><font>红色</font>图标为相比同年款、同排量最低配多出的配置</span></th>
                                            <th width="68" height="50">全部配置</th>
                                            <th width="61" height="50" style="border:none"></th>
                                        </tr>
                                        <? } ?>
                                        <? foreach((array)$value as $kk=>$vv) {?>
                                        <? $pz_num =count($vv) ?>
                                        <? foreach((array)$vv as $k=>$v) {?>
                                        <tr>
                                            <? if ($k==0) { ?>
                                            <td width="81"  rowspan="<?=$pz_num?>" style=" text-align:center; border-left:none;"><?=$kk?></td> 
                                            <? } ?>
                                            <td width="280"><div class="chekuan_td">
                                                    <p style="font-weight:bolder;"><a target="_blank" href="modelinfo_<?=$v[model_id]?>.html"><?=$v[model_name]?></a></p>
                                                    <div class="rd"><span>热度</span> <span title="<?=$v['views']?>" class="redu<? echo round($v['views'] / 10) ?>"></span></div>
                                                    <span class="cs"></span>
                                                    <div class="chekuan">
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <th width="110">长×宽×高（mm）</th>
                                                                    <th width="80">轴距（mm）</th>
                                                                    <th width="80">驱动形式</th>
                                                                    <th width="115">发动机排量（cm3）</th>
                                                                    <th width="115">发动机形式 </th>
                                                                    <th width="85">变速箱</th>
                                                                    <th width="100">功率PS（KW）</th>
                                                                    <th width="115">扭矩（N·m/rpm）</th>
                                                                    <th width="130">综合油耗（L/100km）</th>
                                                                    <th width="105"> 百公里加速（S） </th>
                                                                    <th width="40"></th>
                                                                </tr>
                                                                <tr>
                                                                    <td><? if (empty($v['st3'])) { ?>--<? } else { ?><?=$v['st3']?><? } ?></td>
                                                                    <td><? if (empty($v['st15'])||$v['st15']=="无") { ?>--<? } else { ?><?=$v['st15']?><? } ?></td>
                                                                    <td><? if (empty($v['st51'])) { ?>--<? } else { ?><?=$v['st51']?><? } ?></td>
                                                                    <td><? if (empty($v['st26'])||$v['st26']=="无") { ?>--<? } else { ?><?=$v['st26']?><? } ?></td>
                                                                    <td><? if ($v['st29']&&$v['st30']&&$v['st29']!=="无"&&$v['st30']!=="无") { ?><?=$v['st29']?><?=$v['st30']?><? } else { ?>--<? } ?></td>
                                                                    <td><? $str = $v['st2'].(intval($v['st49'])>0 ? $v['st49'] : "" ) ?><? echo preg_replace($patterns, $replacements, $str); ?></td>
                                                                    <td> <? if (empty($v['st36'])||$v['st36']=="无") { ?>--<? } else { ?><?=$v['st36']?><? } ?><? if (empty($v['st37'])||$v['st37']=="无") { ?>--<? } else { ?>(<?=$v['st37']?>)<? } ?></td>
                                                                    <td> <? if (empty($v['st39'])||$v['st39']=="无") { ?>--<? } else { ?><?=$v['st39']?><? } ?> </td>
                                                                    <td> <? if (empty($v['st10'])||$v['st10']=="无") { ?>--<? } else { ?><?=$v['st10']?><? } ?>  </td>
                                                                    <td> 
                                                                        <? if (!$v['st6'] || $v['st6'] == '无') { ?> 暂无<? } else { ?><?=$v['st6']?><? } ?>  </td>
                                                                    <td><a href="param_<?=$v[model_id]?>.html" target="_blank">更多&gt;</a></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div></td>
                                            <td width="100" class="duibi_xin"><span><a href="compare_<?=$v['model_id']?>.html" target="_blank">对比</a></span><?=$v[model_price]?>万</td>
                                            <td  style="color:#ff8f34;" ><? if ($v[price]>0) { ?><div title="媒体价"  <? if ($v[pricelog_id_from]) { ?>style="float: left;margin-left: 8px;"<? } ?>><?=$v[price]?>万</div>
                                                <? } else { ?>--<? } ?></td>
                                            <td width="86"><? if ($v[m_price]>0) { ?><img style="margin-right:2px;" src="images/yhfd_up.jpg"><? echo $v[m_price]*10000 ?>元<? } elseif($v[m_price]<0) { ?><img style="vertical-align:middle;margin-right:2px;" src="images/ck_sjfd.jpg"><? echo abs($v[m_price]*10000) ?>元<? } elseif($v[m_price]=='0') { ?>无优惠<? } else { ?>--<? } ?></td>
                                            <td>
                                                <div class="cy_ul">
                                                    <ul>
                                                        <? foreach((array)$v[pz] as $kkk=>$vvv) {?> 
                                                        <li ><img onerror = "this.src='images/50x50.jpg'" src="images/peizi/<?=$vvv?>" oldwidth="22" oldheight="22" onmouseover="zoom(this)" onmouseout="this.width = this.getAttribute('oldwidth');
                                                                            this.height = this.getAttribute('oldheight');" title="<? echo $pz_img['newssn'][$kkk] ?>"></li>
                                                        <?}?>
                                                    </ul>
                                                </div>
                                                <div class="cy_peizhi">	  
                                                    <div class="peizhi_tab" style="display:none">
                                                        <div class="lintab2_bottom">
                                                            <ul class="lintab2_tt" id="lintab2_tt1">
                                                                <li class="cky_hover"><a href="javascript:void(0);">全部配置  </a></li>
                                                                <li class="cky_link"><a href="javascript:void(0);">  安全</a></li>
                                                                <li class="cky_link"><a href="javascript:void(0);"> 舒适</a></li>
                                                                <li class="cky_link"><a href="javascript:void(0);">  驾控</a></li>
                                                                <li class="cky_link"><a href="javascript:void(0);">  外部</a></li>
                                                            </ul>
                                                            <ul class="lintab2_list lr0" id="pz0_<?=$v['model_id']?>" style="display:block;"></ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td width="68" class="ckpz" style="color:#ea1a14;">
                                                <a href="javascript:void(0)" class="ckpz_id" onclick="peizhi('<?=$v[model_id]?>')">查看</a>
                                            </td>
                                            <td class="intr_tu">
                                                <div class="xianqin_xin"><a href="offers_<?=$v[model_id]?>.html" target="_blank">价格详情</a></div>
                                            </td>
                                        </tr>
                                        <?}?>
                                        <?}?>
                                        <?}?>
                                    </table>
                                </div>
                            </div>           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ck_lb">
            <div class="hgzc">
                <div class="hgzc_title">关注此车的人还关注了...</div>
                <? if (!empty($attention_model)) { ?>
                <? foreach((array)$attention_model as $type) {?>
                <? foreach((array)$type as $key=>$attmodel) {?>
                <div class="hgzc_cont">
                    <? $b_name =$attmodel['brand_name'].' '.$attmodel['series_name'].' '.$attmodel['model_name'] ?><? $b_name_num =strlen($b_name) ?>
                    <p style="font-size:14px; color:#585858; line-height:28px;padding-left:10px;" <? if ($b_name_num>48) { ?>title="<?=$b_name?>"<? } ?>><a style="font-size:14px;" target="_blank" href="modelinfo_<?=$attmodel['model_id']?>.html" ><? echo dstring::substring($b_name,0,50) ?></a></p>
                    <div style="width:366px">
                        <div class="intr_car_bg"><a target="_blank" href="modelinfo_<?=$attmodel['model_id']?>.html"><img class="lazyimg" width="190" height="142" data-original="/attach/images/model/<?=$attmodel['model_id']?>/190x142<?=$attmodel['model_pic1']?>" onerror="this.src='images/180x100.jpg'" src="../images/loading_img/loading190x142.png" alt="<? echo $b_name ?>"></a></div>
                        <div style="float:right; width:160px; line-height:30px;">
                            <p>车身形式：<?=$attmodel['st4']?></p>
                            <p>级别：<?=$attmodel['type_name']?></p>
                            <p>排量：<?=$attmodel['st27']?></p>
                            <? $st_48 =strlen($model['st48']) ?>
                            <p <? if ($st_48>16) { ?>title="<?=$model['st48']?>"<? } ?>>变速箱：<? echo dstring::substring($model['st48'],0,16) ?></p>
                            <p>燃油标号：<?=$attmodel['st42']?></p>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="bgbmj">
                        <div style="float:left; width:200px;">
                            <span style="font-size:14px; color:#585858; font-weight:bolder;">媒体价:</span>
                            <span style="font-size:17px; color:#ed7001; margin-right:5px;">  <? if ($attmodel['bingobang_price']&&$attmodel['bingobang_price']!='0.00') { ?>
                                <?=$attmodel['bingobang_price']?>万
                                <? } else { ?>
                                未获取
                                <? } ?>
                            </span><br>
                            <span style="font-size:14px; color:#585858;">厂商指导价：</span><?=$attmodel['model_price']?>万<span style="color:#019c6e; margin-left:15px;"> <? $discount = round($attmodel['bingobang_price'] / $attmodel['model_price'], 3) * 10 ?>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div style="width:355px; font-size:12px; color:#969ea2; margin-top:10px; padding-left:10px; padding-right:10px; background-color:#f5f7f8; height:30px; padding-top:10px;">
                        <div style="float:left; width:120px; line-height:22px;"><a style="float:left;color:#969ea2;" class="jdb" href="compare_<?=$attmodel['model_id']?>.html" target="_blank">加对比</a>
                        </div>
                        <div class="cksq"><a href="offers_<?=$attmodel['model_id']?>.html" onfocus="this.blur()" target="_blank">价格详情</a>
                            </a></div>
                    </div>
                </div>
                <?}?>
                <? } ?>
                <? } ?>
            </div>
        </div>
        <div class="cxdg">
            <div class="i-tabs">
                <div class="i-tabs-nav"> <span class="i-tabs-item i-tabs-item-active">车系特点 </span>  </div>
                <div class="i-tabs-container">
                    <div class="i-tabs-content i-tabs-content-active">
                        <div class="tabs-news-module">
                            <div style="line-height:43px; border-bottom:solid 1px #d7dfe4; padding-right:10px;" class="ztpf">
                                <div style="float:left; width:335px;"><img src="images/ckyx_chepi.jpg" style="float:left; margin:1px 5px 1px 1px;" />
                                    <b style="float:left; font-size:18px; color:#585858; font-weight:normal;">总体评分：</b>
                                    <span id ="sppf"class="<?=$series['sppf']?>"></span> <b style="font-size:20px; font-weight:normal; color:#d6000f;"><?=$series["score"]["5"]?></b>
                                </div>
                            </div>
                            <ul>
                                <li style="margin-left:15px;">品质：<span><?=$series['score'][0]?></span></li>
                                <li> 性能：<span><?=$series['score'][1]?></span></li>
                                <li> 配置：<span><?=$series['score'][2]?></span></li>
                                <li> 安全：<span><?=$series['score'][3]?></span></li>
                                <li> 外观：<span><?=$series['score'][4]?></span></li>
                            </ul>
                            <div class="yqd">
                                <div style="text-align:left"><span style="text-align:center">优点</span><?=$series['pros']?></div>
                                <div style="text-align:left;border-bottom: 1px solid #D7DFE4;"><span style="text-align:center">缺点</span><?=$series['cons']?></div>
                            </div>
                            <p style="height:28px; margin-top:30px; line-height:28px;border-bottom:solid 1px #d7dfe4; text-indent:1em;">综述 </p>
                            <p style="font-size:12px; padding-left:15px; padding-right:10px; padding-top:7px; line-height:22px;"><?=$series["series_intro"]?></p>
                        </div>
                    </div>

                </div>
            </div>
            <!--yuanweizhi-->
        </div>
        <div style="/*clear:both*/">
            <div class="ckyx_left">
                <div class="hangqing">
                    <div class="hq_title"><span style="font-size:18px; padding-left:10px; width:300px; float:left"><?=$model['series_name']?> 图片</span><a style="float:right;  padding-right:10px;" href="image_SearchList_series_id_<?=$series_id?>.html" target="_blank" >查看全部图片&gt;&gt;</a></div>
                    <? $ii=count($series_pic); ?>
                    <? $iii=0; ?>
                    <? foreach((array)$series_pic as $key=>$value) {?>
                    <? $iii++ ?>
                    <div class="hq_content_title"><span style="float:left; width:200px; padding-left:10px;"><b style="font-size:14px;"><?=$value['name']?></b>（<font style="color:#ea1a14;"><?=$value['totil']?></font>张)</span><a style=" float:right; padding-right:10px;" href="/modelpicselect/<?=$series_id?>_<? if ($defaultModel_Id) { ?><?=$defaultModel_Id?><? } else { ?><?=$model['model_id']?><? } ?>__<?=$value['pos']?>.html" target="_blank">查看更多&gt;&gt;</a></div>
                    <div class="hq_content">
                        <? foreach((array)$value['content'] as $k=>$v) {?>
                        <? if ($k<4) { ?>
                        <dl>
                            <dt><a href="bigpic_<?=$v[type_id]?>_<? if ($v[color_id]) { ?><?=$v[color_id]?><? } else { ?>0<? } ?>_<?=$v[pos]?>_<?=$v[id]?>.html" target="_blank"><img class="lazyimgs"  onerror = "this.src='images/188x140.jpg'" data-original="attach/images/model/<?=$v[type_id]?>/<? if ($key==1) { ?>304x227<? } else { ?>190x142<? } ?><?=$v['name']?>" src="../images/loading_img/loading190x142.png" width="190" height="142" alt="<?=$value['name']?> <?=$model['series_name']?> <?=$model['model_name']?>"/></a></dt>
                        </dl>
                        <? } ?>
                        <?}?>
                    </div>
                    <?}?>
                </div>
                <div class="ckyx_cs">
                    <div class="ckyx_cs2">
                        <!--鼠标滑动就滑动-->
                        <div class="cskj">
                            <ul class="tab_tit" id="tab_tit1">
                                <li class="focus1 focus"><a class="focus_1" href="javascript:void(0);">动力/操稳</a></li>
                                <li class="focus2"><a href="javascript:void(0);">车身/空间</a></li>
                                <li class="focus3"><a href="javascript:void(0);">养护成本</a></li>
                                <li class="focus4"><a href="javascript:void(0);">噪音控制</a></li>
                            </ul>
                            <div id="lintab10" class="lintab_mid" style="display: block;">
                                <div class="<?=$act_class?>">
                                    <p style="font-size:14px; color:#000; font-weight:bolder;"><?=$model['st29']?><?=$model['st30']?> <?=$model['st27']?>L <?=$model['st33']?> <?=$model['st43']?> <?=$model['st28']?></p>
                                    <p>功率：
                                        <? if ($model['st37'] != '' && $model['st37'] != '无') { ?>
                                        <?=$model['st36']?><? if ($model['st36']) { ?>Ps<? } ?> (<?=$model['st37']?>kw) <? if ($model['st38'] != '' && $model['st38'] != '无') { ?>/ <?=$model['st38']?>rpm<? } ?>
                                        <? } else { ?>
                                        暂无
                                        <? } ?>
                                    </p>
                                    <p>扭矩：
                                        <? if ($model['st39'] != '' && $model['st39'] != '无') { ?>
                                        <?=$model['st39']?>N·m <? if ($model['st185'] != '' && $model['st185'] != '无') { ?>/ <?=$model['st185']?>rpm<? } ?>
                                        <? } else { ?>
                                        暂无
                                        <? } ?>
                                    </p>
                                    <p>变速箱：<?=$model['st50']?></p>
                                    <p><?=$model['st51']?></p>
                                    <div class="qjz_<?=$car_class?>">前弹性元件：<?=$model['st219']?></div>
                                    <div class="qxg_<?=$car_class?>"><span title="<?=$model['st52']?>">前悬挂：<?=$model['st52']?></span><em></em></div>
                                    <div class="hxg_<?=$car_class?>"><span title="<?=$model['st53']?>">后悬挂：<?=$model['st53']?></span><em></em></div>
                                    <div class="hjz_<?=$car_class?>">后弹性元件：<?=$model['st220']?></div>
                                    <div class="scjl">
                                        <? if ($model['st7'] != '无' && $model['st7'] != '') { ?>
                                        <p>0-100km/s：<span><?=$model['st7']?></span>秒</p>
                                        <p>（实测数据）</p>

                                        <? } else { ?>
                                        <? if ($model['st6'] != '无' && $model['st6'] != '') { ?>
                                        <p>0-100km/s：<span><?=$model['st6']?></span>秒</p>
                                        <p>（官方数据）</p>
                                        <? } else { ?>
                                        <p>0-100km/s：<span>暂无</span></p>
                                        <? } ?>   
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="lintab_mid" id="lintab11" style="display:none;">
                                <div class="ckxy_cskj_<?=$car_class?>">
                                    <div class="qpgd" styel="text-align:center"><?=$model['st13']?><? if ($model['st13']!='无') { ?>mm<? } ?></div>
                                    <div class="hpgd" styel="text-align:center"><?=$model['st14']?><? if ($model['st14']!='无') { ?>mm<? } ?></div>
                                    <div class="qptb" styel="text-align:center"><?=$model['st16']?><? if ($model['st16']!='无') { ?>mm<? } ?></div>
                                    <div class="hptb" styel="text-align:center"><?=$model['st17']?><? if ($model['st17']!='无') { ?>mm<? } ?></div>
                                    <div class="hpkd" styel="text-align:center"><?=$model['st15']?><? if ($model['st15']!='无') { ?>mm<? } ?></div>
                                    <div class="qpkd" styel="text-align:center"><?=$model['st12']?><? if ($model['st12']!='无') { ?>mm<? } ?></div>
                                </div>
                            </div>
                            <div class="lintab_mid" id="lintab12" style="display:none;">
                                <div class="gxb">
                                    <ul>
                                        <li class="yhcb_title">工信部油耗</li>
                                        <li>市区工况：
                                            <? if (!$model['st200'] || $model['st200'] == '无') { ?>
                                            暂无
                                            <? } else { ?>
                                            <?=$model['st200']?>升/百公里                                            
                                            <? } ?>
                                        </li>
                                        <li>综合工况：
                                            <? if (!$model['st10'] || $model['st10'] == '无') { ?>
                                            暂无
                                            <? } else { ?>
                                            <?=$model['st10']?>升/百公里                                            
                                            <? } ?>
                                        </li>
                                        <li>市郊工况：
                                            <? if (!$model['st9'] || $model['st9'] == '无') { ?>
                                            暂无
                                            <? } else { ?>
                                            <?=$model['st9']?>升/百公里
                                            <? } ?>                                        
                                        </li>
                                    </ul>
                                    <ul>
                                        <li class="yhcb_title">媒体实测</li>
                                        <li>路段：
                                            <? $road = substr($realdata['road'], 1, 1) ?>
                                            <? if ($road == 1) { ?>
                                            拥堵
                                            <? } elseif($road == 2) { ?>
                                            高速
                                            <? } else { ?>
                                            综合
                                            <? } ?>
                                        </li>
                                        <li>油耗测试总里程：
                                            <? if ($realdata['mileage']) { ?>
                                            <?=$realdata['mileage']?>公里
                                            <? } else { ?>
                                            暂无
                                            <? } ?>
                                        </li>
                                        <li>油耗燃油总量：
                                            <? if ($realdata['fuel']) { ?>
                                            <?=$realdata['fuel']?>升
                                            <? } else { ?>
                                            暂无
                                            <? } ?>                                        
                                        </li>
                                        <li>综合油耗：
                                            <? if ($realdata['fuel_hour']) { ?>
                                            <?=$realdata['fuel_hour']?>升/百公里
                                            <? } else { ?>
                                            暂无
                                            <? } ?>                                        
                                        </li>
                                        <li style="color:#898989; margin-top:5px;">*实测车型为：<?=$sname?></li>
                                    </ul>
                                </div>
                                <div class="4sby">
                                    <ul>
                                        <li class="yhcb_title">4s保养</li>
                                        <li>原厂指定机油：
                                            <? if ($realdata['oil_level']) { ?>
                                            <?=$realdata['oil_level']?>
                                            <? } else { ?>
                                            暂无
                                            <? } ?>
                                        </li>
                                        <li>换油周期：
                                            <? if ($realdata['change_cycle']) { ?>
                                            <?=$realdata['change_cycle']?>
                                            <? } else { ?>
                                            暂无
                                            <? } ?>                                 
                                        </li>
                                        <li>机油机滤：
                                            <? if ($realdata['oil_filter']) { ?>
                                            <?=$realdata['oil_filter']?>
                                            <? } else { ?>
                                            暂无
                                            <? } ?>                                          
                                        </li>
                                        <li>机油三滤：
                                            <? if ($realdata['oil_3filter']) { ?>
                                            <?=$realdata['oil_3filter']?>
                                            <? } else { ?>
                                            暂无
                                            <? } ?>                                          
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div style="DISPLAY: none;background-color:#fff; padding-top:18px;back" id="lintab13" class="lintab_mid">
                                <div style="overflow:hidden;">
                                    <div id="TopEmployeesDiv" style="margin-top:-18px;">统计图生成失败</div>
                                    <script type="text/javascript">
                                                var chart = new FusionCharts("/vendor/FusionCharts/js/MSColumn3D.swf", "ChartId", "520", "297");
                                                var str = "<chart caption='蓝色为媒体评测优秀值/黄色为<?=$model['series_name']?>噪音值' baseFontSize='12' showValues='1' numberScaleValue='1,1' numberScaleUnit='dB,dB'>\n";
                                                str += "<categories>\n";
                                        <? foreach((array)$noise_name as $name) {?>
                                        str += "<category label='<?=$name?>'  />\n";
                                        <? } ?>
                                                str += "</categories>\n";
                                                str += "<dataset color='f9ff3c'>\n";
                                        <? foreach((array)$noise_key as $value) {?>
                                        str += "<set value='<? echo $realdata[$value] ?>'/>\n";
                                        <? } ?>
                                                str += "</dataset>\n";
                                                str += "<dataset color='5abbff'>\n";
                                        <? foreach((array)$norm_noise as $value) {?>
                                        str += "<set value='<?=$value?>'/>\n";
                                        <? } ?>
                                                str += "</dataset>\n";
                                                str += "</chart>\n";
                                                chart.setDataXML(str);
                                                chart.render("TopEmployeesDiv");
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<? include $this->gettpl('index_footer');?>
