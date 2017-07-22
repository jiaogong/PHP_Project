<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
<div class="user">
    <div class="nav">
        <ul id="nav">
            <li><a href="<?=$php_self?>focuslist">信息预览</a></li>
            <li><a href="javascript:void(0);" class="song">历史信息</a></li>
            <li><a href="<?=$php_self?>hotcarNotice&act=focusfive">逻辑说明</a></li>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
            <form method="post" action="<?=$php_self?>focussortact" enctype="multipart/form-data">
                <table cellpadding="0" cellspacing="0" class="table2" border="0">
                    <tr>
                        <td>上一次排序</td>
                        <td>上一次数据</td>
                        <td>重新排序(最大不能超过5)</td>
                    </tr>
                    <? foreach((array)$focussort as $key=>$val) {?>
                    <tr>
                        <td><?=$key?></td>
                        <td><?=$val['title']?></td>
                        <td><input type="text" name="sort[]" /></td>
                    </tr>
                    <?}?>
                    <tr><td></td><td><input type="hidden" value="<?=$id?>" name="id" /><input type="hidden" value="<?=$start_time?>" name="start_time" /><input type="submit" /></td><td></td></tr>
                </table>
            </form>
        </div>
        <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
    </div>
</div>
</body>
</html>