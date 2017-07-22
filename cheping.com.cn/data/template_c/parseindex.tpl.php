<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('index_header');?>
<div class="clear"></div>

<!--content开始-->


<div class="content_v5">
<!--    <div id="popMask" style="display:none;position: fixed; z-index: 999; top: 0px; left: 0px; height: 100%; width: 100%; filter: Alpha(Opacity=80);opacity:0.8; background: none repeat scroll 0% 0% rgb(204, 204, 212);"></div>
        <div class="ss_tks">
            <div class="ss_tc"><p style="text-align:center;">&nbsp;</p><a href="javascript:void(0)" id="fanhui">&nbsp;</a></div>
        </div> -->
    
    <div class="v5_top">
        <div class="v5_top_title">
            <ul>
                <li class="title_01"><h2>选车</h2></li>                
                <li>
                    <div class="title_select">
                        <select id="brand_id" name="brand_id" onchange="javascript:series_select($('#series_id'), this.value);">
                            <option>品牌</option>
                            <script>brand_select($('#brand_id'));</script>                
                        </select>
                    </div>
                </li>
                <li>
                    <div class="title_select">
                        <select id="series_id" name="series_id" onchange="javascript:model_select($('#model_id'), this.value);" disabled="disabled">
                            <option value="0">车型</option>
                        </select>              
                    </div>
                </li>
                <li>
                    <div  class="v5_top_sousuo">
                        <input class="syg_ss" type="button" style="cursor: pointer;"/>
                    </div>
                </li>
                <li class="title_02">大家都在搜：</li>
                <li>
                    <div class="sousuo_jieguo">
                        <!--#include virtual="ssi/ssi_newindex_search.shtml"-->
                    </div>
                </li>
            </ul>
        </div>
        <div class="v5_cont">
            <div class="v5_cont_left">
                <ul class="list_s_left">
                    <li style="height:45px; line-height:45px;">价格区间</li>
                    <li style="height:119px; line-height:119px;">热门车</li>
                    <li style="height:112px; line-height:112px; border-bottom:none;">车型</li>
                </ul>
                <div class="list_s_right">
                    <!--#include virtual="ssi/ssi_newindex_hotcar.shtml"-->
                    <div class="s_right_xia">
                        <dl>
                            <dt><a target="_blank" href="/search.php?action=index&cs=2"><img src="images/cx_01.jpg" id="cs2"></a></dt>
                            <dd>三厢车</dd>
                        </dl>
                        <dl>
                            <dt><a target="_blank" href="/search.php?action=index&cs=1"><img src="images/cx_02.jpg" id="cs1"></a></dt>
                            <dd>两厢车</dd>
                        </dl>
                        <dl>
                            <dt><a target="_blank" href="/search.php?action=index&cs=4"><img src="images/cx_03.jpg" id="cs4"></a></dt>
                            <dd>掀背车</dd>
                        </dl>
                        <dl>
                            <dt><a target="_blank" href="/search.php?action=index&cs=5"><img src="images/cx_04.jpg" id="cs5"></a></dt>
                            <dd> SUV</dd>
                        </dl>
                        <dl>
                            <dt><a target="_blank" href="/search.php?action=index&cs=6"><img src="images/cx_05.jpg" id="cs6"></a></dt>
                            <dd>MPV</dd>
                        </dl>
                        <dl>
                            <dt><a target="_blank" href="/search.php?action=index&cs=3"><img src="images/cx_06.jpg" id="cs3"></a></dt>
                            <dd> 旅行车</dd>
                        </dl>
                        <dl>
                            <dt><a target="_blank" href="/search.php?action=index&cs=7"><img src="images/cx_07.jpg" id="cs7"></a></dt>
                            <dd>coupe </dd>
                        </dl>
                        <dl>
                            <dt><a target="_blank" href="/search.php?action=index&cs=8"><img src="images/cx_08.jpg" id="cs8"></a></dt>
                            <dd>敞篷车</dd>
                        </dl>
                        <dl>
                            <dt><a target="_blank" href="/search.php?action=index&ot=3"><img src="images/cx_09.jpg" id="cs9"></a></dt>
                            <dd>新能源 </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <!--#include virtual="ssi/ssi_newindex_look.shtml"-->
        </div>
    </div>
    <div class="content_left" style="width:483px; float: left;">
    <div class="v5_cont_banner">
        <div class="banner_left">
            <!--#include virtual="ssi/ssi_newindex_focus5.shtml"-->
            <!--#include virtual="ssi/ssi_newindex_focus2.shtml"-->
        </div>
        <!--#include virtual="ssi/ssi_newindex_hotarticle.shtml"-->
    </div>

    <div class="v5_content_news">
        <div class="content_newa_left">
            <div class="left_shang">
                <!--#include virtual="ssi/ssi_newindex_rmdword.shtml"-->
                <!--#include virtual="ssi/ssi_newindex_rmdseries_<?=$date?>.shtml-s"-->
                <!--#include virtual="ssi/ssi_newindex_rmdseries.shtml"-->
                <!--#include virtual="ssi/ssi_newindex_rmdarticle_<?=$date?>.shtml-s"-->
                <!--#include virtual="ssi/ssi_newindex_rmdarticle.shtml"-->
            </div>

            <!-- 猜你喜欢 开始 -->
        <!--#include virtual="ssi/ssi_newindex_recommend.shtml-s"-->
            <!-- 猜你喜欢 结束 -->
            <!-- 新闻中心 开始 -->
            <!--#include virtual="ssi/ssi_index_footarticle.shtml"-->
            <!-- 新闻中心 结束 -->
        </div>
    </div>
    </div>
    <div class="content_right" style=" width:323px; float: right;">
        <!-- 汽车暗访报告 开始-->
        <!--#include virtual="ssi/ssi_newindex_discount.shtml-s"-->
        <!-- 汽车暗访报告 结束-->
        <!--#include virtual="/ssi/ssi_newindex_modelpk.shtml"-->
        <!-- 新车上市 开始-->
        <!--#include virtual="ssi/ssi_newindex_newcarmarket.shtml"-->
        <!-- 新车上市 结束-->
        <!-- 即将上市 开始-->
        <!--#include virtual="ssi/ssi_newindex_upcoming.shtml-s"-->
        <!-- 即将上市 结束-->
        <!--#include virtual="ssi/ssi_index_comment.shtml"-->
    </div>

    <!--<div class="v5_cont_baojia">-->

    <!--</div>-->
</div>
<div class="clear"></div>
<script>
    $('.zcbf div').click(function () {
        $('.zcbf div').removeClass('i-tabs-item-active');
        $(this).toggleClass('i-tabs-item-active');
        $('.i-tabs-contentbt').toggleClass('i-tabs-content-active');
        if ($('#bt_type').val() == 'zc') {
            $('#bt_type').val('bf');
            $('.bt_value').text('3500');
            $('.yuan').text('元');
        }
        else {
            $('#bt_type').val('zc');
            $('.bt_value').text('3000');
            $('.yuan').text('元');
        }
        $('.yongtu').val('zk');
        $('.car_type').val('w');
        $('.year').val('68y');
    });
    var bt = eval("(" + '<?=$bt?>' + ")");
    $('.yongtu').change(function () {
        var yongtu = $(this).val();
        if (yongtu == 'zk') {
            html = '<option value="w">微型</option><option value="s">小型</option><option value="m">中型</option><option value="b">大型</option>'
        }
        else {
            html = '<option value="w">微型</option><option value="s">轻型</option><option value="m">中型</option><option value="b">重型</option>';
        }
        $('.car_type').html(html);
    });
    $('.car_type, .year').change(function () {
        var btType = $('#bt_type').val();
        var yongtu = $('#' + btType + 'yongtu').val();
        var carType = $('#' + btType + 'car_type').val();
        var year = $('#' + btType + 'year').val();
        var value = bt[btType][yongtu][year][carType];
        $('.bt_value').text(value);
        if (value == '--')
            $('.yuan').text('');
        else
            $('.yuan').text('元');
    });

    $(function(){
        $('.denglu').hide();
　　}); 
</script>                                                                                                                                            
<script src="/js/counter.php?c1=index&c2=1"></script>
<br />
<br />
<div class="clear"></div>
<!--页脚-->
<div class="clear"></div>
<!--#include virtual="/ssi/ssi_cpindexlink.shtml"-->