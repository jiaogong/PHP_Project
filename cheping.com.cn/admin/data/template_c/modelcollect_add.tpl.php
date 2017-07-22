<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
    <div class="nav">
        <ul id="nav">
              <li><a href="<?=$php_self?>modelpiccollect"  class="song">添加车款图片采集</a></li>
              <li ><a href="<?=$php_self?>modelpiccollectlist">车款图片采集列表</a></li>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
                <form action="<?=$php_self?>modelpiccollect" method="post" name="form2">
                <table class="table2" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td>
                            输入车款id:
                            <input type="text" name="modelid"  class="" value="<? if ($modelid) { ?><?=$modelid?><? } ?>" size="10"  />
                            <input type="submit" name="search" value=" 搜 索 ">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
            <table class="table2" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th width="5%">车款id</th>
                    <th width="20%">车款名称</th>
                    <th width="10%">状态</th>
                    <th width="10%">操作人</th>
                    <th width="10%">修改日期</th>
                </tr>    

                <? foreach((array)$list as $key=>$value) {?>

                <tr>
                    <td><?=$value['id']?></td>
                    <td><?=$value['model_name']?></td>
                    <td><?=$value['series_name']?></td>  
                    <td><?=$value['brand_name']?></td>
                    <td><? echo date("Y-m-d H:i:s", $value['update_time']) ?></td>
                    <td><?=$value['author']?></td>
                    <td><? if ($value['state']==1) { ?>新增车款<? } elseif($value['state']==2) { ?>已抓图<? } elseif($value['state']==3) { ?>待停售<? } elseif($value['state']==5) { ?>新增车款已修改<? } else { ?>已停售<? } ?><? if ($value['state']==2) { ?>&nbsp;<a href="<?=$php_self?>seriesloglist_update&id=<?=$value['id']?>&state=2">修改状态</a><? } ?></td>
                </tr>
                <?}?>
            </table>
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

</script>
<? include $this->gettpl('footer');?>
