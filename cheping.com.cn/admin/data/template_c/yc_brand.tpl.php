<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
    <div class="nav">
        <ul id="nav">
            <li><a href="index.php?action=grabyiche">抓取易车商城数据</a></li>
            <li><a href="index.php?action=grabyiche-yichetree">抓取易车产品数据</a></li>
            <li><a href="index.php?action=grabyiche-brand" class="song">易车品牌管理</a></li>
            <li><a href="index.php?action=grabyiche-factory">易车厂商管理</a></li>
            <li><a href="index.php?action=grabyiche-series">易车车系管理</a></li>
            <li><a href="index.php?action=grabyiche-model">易车车款管理</a></li>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
            <table class="table2" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;word-wrap: break-word;">
                <tr align="right"  class='th'>
                    <td width="80" align="center">易车品牌ID</td>
                    <td width="260" align="center">易车品牌名称</td>
                    <td width="80" align="center">冰狗品牌ID</td>
                    <td width="260" align="center">冰狗品牌名称</td>
                    <td align="center">操作</td>
                </tr>
                <? foreach((array)$list as $k=>$v) {?>
                <tr>
                    <td><?=$v['yc_bid']?></td>
                    <td><?=$v['yc_brandname']?></td>
                    <td><?=$v['brand_id']?></td>
                    <td><?=$v['brand_name']?></td>
                    <td>
                        <a href='javascript:void(0);' yid='<?=$v[id]?>' class='edit_brand'>修改</a>
                        删除
                    </td>
                </tr>
                <?}?>
            </table>
            <div style="height:40px;"></div>
        </div>
        <div class="user_con2">
            <img src="<?=$admin_path?>images/conbt.gif" height="16" >
        </div>
    </div>
</div>
<div style="display: none;" id="bc_brand_list">
    <select name='bc_brand' id='bc_brand' style="width: 120px">
        <option value="">请选择品牌</option>
        <? foreach((array)$bc_brand as $k=>$v) {?>
        <option value='<?=$v[brand_id]?>'><?=$v[brand_name]?></option>
        <?}?>
    </select>
</div>
<script type="text/javascript">
$().ready(function(){
    $('a.edit_brand').click(function(){
        var btn_txt = $(this).text();
        if(btn_txt=='修改'){
            var brand_list=$('#bc_brand_list').html();
            $(this).text('确定').before(brand_list);
        }else{
            var brand_id = $(this).prev('select').val();
            var yid = $(this).attr('yid');
            var url='<?=$php_self?>updatebrand&yid='+yid+'&bid='+brand_id;
            $.getJSON(url, function(ret){
                alert(ret['msg']);
                if(ret['code'] == 1){
                    location.reload();
                }
            })
        }
    });
});
</script>
<? include $this->gettpl('footer');?>
