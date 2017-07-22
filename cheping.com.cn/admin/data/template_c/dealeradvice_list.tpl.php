<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
<div class="nav">
    <ul id="nav">
        <li><a href="<?=$phpSelf?>"  class="song">经销商反馈列表</a></li>
    </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
            <form id="advice" action="<?=$phpSelf?>" method="post">
                <table class="table2" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td align="left">
<!--                        <th><h2 style="color:blue;"><? echo $type[$t]  ?></h2></th>-->
                        <select style="width:120px;" id="state" name="state" onchange="javascript:document.getElementById('advice').submit();">
                            <option value="">请选择状态</option>
                            <option value="0">未回复</option>
                            <option value="1">已回复</option>
                        </select>
                        关键字:<input type="text" name="keyword" id="keyword" size="10"/>
                        开始时间:<input id="start_time" name="start_time" class="datepicker" type="text"  readonly="readonly" style="width: 100px;" >
                        截止时间:<input id="end_time" name="end_time" class="datepicker" type="text"  readonly="readonly" style="width: 100px;">

                        <input type="submit" name="search" value=" 搜 索 ">
                       </td>
                    </tr>
                    </tbody>
                </table>
            </form>
            <form id="form_all" action="<?=$php_self?>advicelist&page=<?=$page?>" method="post">
            <table id="content" class="table2" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th width="8%">编号(ID)</th>
                    <th width="30%">内容</th>
                    <th width="20%">经销商名称</th>
                    <th width="14%">提交日期</th>
                    <th width="8%">操作</th>
                </tr>
                <? foreach((array)$advice as $key=>$val) {?>
                <tr <? if ($val['state'] == 0) { ?>style="color:red"<? } ?>>
                    <td><?=$val["id"]?></td>
                    <td><? echo mb_substr($val['message'],0,28,'utf-8') ?></td>
                    <td><a href="index.php?action=dealer-edit&id=<?=$val['dealer_id']?>"><?=$val["dealer_name"]?></a></td>
                    <td><? if ($val['created']) { ?><? echo date('Y/m/d H:i:s',$val["created"]) ?><? } ?></td>
                   
                    <td><a href="index.php?action=dealeradvice-dealeradvice&id=<?=$val['id']?>"><img height="12" width="12" src="images/rewrite.gif"/>查看</a></td>
                </tr>
                <?}?>
            </table>
            </form>
            <? if ($page_bar) { ?>
            <div>
                <div class="ep-pages">
                    <?=$page_bar?>
                </div>
            </div>
            <? } ?>
        </div>
        <div class="user_con2">
            <img src="<?=$admin_path?>images/conbt.gif" height="16" >
        </div>
    </div>
</div>
<script>
$(function() {
  $("input.datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true
  });
});
</script>
    </body>
</html> 
