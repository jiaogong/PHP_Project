<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
<div class="user">
<div class="nav">
    <ul id="nav">
        <li><a href="javascript:void(0);" class="song">信息预览</a></li>
        <li><a href="<?=$php_self?>hotcarAct">操作</a></li>
        <li><a href="<?=$php_self?>hotcarNotice&act=hotcar">逻辑说明</a></li>
    </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1" style="height: 500px; padding: 10px 25px;">
            <table cellpadding="0" cellspacing="0" border="0" class="tablex" >
                <tr>
                <? foreach((array)$priceSelect as $k=>$v) {?>
                <td style="width:10%;"><a href="<?=$php_self?>hotcarList&pv=<?=$k?>"><?=$v?></a></td>
                <?}?>
                <td></td>
                </tr>
            </table>
            <? $j = 0 ?>
            <? foreach((array)$data as $k=>$v) {?>
            <table cellpadding="0" cellspacing="0" border="0" class="table2" style="border-collapse: collapse; float: left; margin: 0 5px; width: 80px;">
                <? foreach((array)$v as $kk=>$vv) {?>
                <tr>                     
                    <td height="20" style="height: 25px;line-height: 25px;text-align: center;padding: 0px 0px"><? echo ++$j ?>.<?=$vv['alias']?></td>
                </tr>                    
                <?}?>
            </table>             
            <?}?>
        </div>
        <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
    </div>
</div>
    </body>
</html> 