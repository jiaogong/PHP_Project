<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#startdate").datepicker();
        $("#enddate").datepicker();
        $("#form").submit(function () {

            var reg = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/;
            if ($("#startdate").val().length < 1) {
                alert("请填写起始日期");
                return false;
            } else {
                if ($("#startdate").val().match(reg) == null) {
                    alert("起始日期格式不正确!");
                    return false;
                }
            }
            if ($("#enddate").val().length < 1) {
                alert("请填写终止日期");
                return false;
            } else {
                if ($("#enddate").val().match(reg) == null) {
                    alert("终止日期格式不正确!");
                    return false;
                }
            }

        });
    });
</script>
<div class="user">
    <div class="nav">
        <ul>
<!--            <li><a href="<?=$php_self?>searchstatpic" target="_blank">网站流量曲线图</a></li>-->
            <li><a href="<?=$php_self?>" class="song">按日期统计</a></li>
            <li><a href="<?=$php_self?>historystat">历史统计</a></li>
<!--            <li ><a href="<?=$php_self?>webdetail">详细流量统计</a></li>-->
        </ul>   
    </div>
    <div class="clear"></div>
    <div class="user-con">
        <div style=" padding:20px 5px; width：98%; border-bottom:1px solid #ccc; ">
            <form action="<?=$php_self?>" method="post" id="form">
                <table style=" table-layout: auto; width:100%; "border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <th colspan="5"><h2 style="color:blue;"><? if ($startdate) { ?><?=$pagetype["$type"]?>  <?=$startdate?> 至 <?=$enddate?> <? } ?> 站点PV/IP统计查询</h2><th/>
                    <tr/>
                    <tr  style="height: 36px;">
                        <td width="16%">

                        </td>
                        <td width="25%">
                            起始日期：
                            <input size="12" readonly="readonly" name="startdate" id="startdate" value="<?=$startdate?>" style="width: 95px;">
                        </td>
                        <td width="25%">
                            至：
                            <input size="12" readonly="readonly" name="enddate" id="enddate" value="<?=$enddate?>">
                        </td>
                        <td width="20%">
                            <input type="submit" name="search" value=" 搜 索 ">
                        </td>
                        <td width="16%">

                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="user-table">
            <form id="info_form" name="info_form" method="post" action="index.php?action=article-list">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="20%" style="">页面类型</td>
                        <td width="20%">浏览量(PV)</td>
                        <td width="20%">访问(IP)</td>
                        <td width="20%">独立客户端(UV)</td>
                        <td width="20%">人均浏览量(PV/UV)</td>
                    </tr>
                    <tbody>
                        <? if ($stat) { ?>

                        <? foreach((array)$stat as $key=>$value) {?>
                        <tr>
                            <td><? echo $pagetype[$key]; ?></td>
                            <td><? if ($value['pv']) { ?><? echo round($value['pv']) ?><? } else { ?>0<? } ?>(pv)</td>
                            <td><? if ($value['ip']) { ?><? echo round($value['ip']) ?><? } else { ?>0<? } ?>(ip)</td>
                            <td><? if ($value['uv']) { ?><? echo round($value['uv']) ?><? } else { ?>0<? } ?>(uv)</td>
                            <td><? if ($value['uv']>0) { ?><? echo intval((round($value['pv'])/round($value['uv']))*100)/100 ?><? } else { ?>0<? } ?></td>
                        </tr>
                        <?}?>

                        <? } ?>

                        <? if (empty($stat)) { ?>
                        <tr>
                            <th colspan="8"  class="page_bar_css">
                    <h3 style="color:red;">暂无相关数据</h3>
                    </th>
                    </tr>
                    <? } ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
</body>
</html>
