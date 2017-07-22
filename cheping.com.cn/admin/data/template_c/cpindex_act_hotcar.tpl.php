<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
        <div class="user">
            <div class="nav">
                <ul id="nav">
                    <li><a href="<?=$php_self?>hotcarList">信息预览</a></li>
                    <li><a href="javascript:void(0);"  class="song">操作</a></li>
                    <li><a href="<?=$php_self?>hotcarNotice&act=hotcar">逻辑说明</a></li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user_con">
                <div class="user_con1">            
                    <form method="post" action="<?=$php_self?>hotcarAct">
                        <table cellpadding="0" cellspacing="0" class="table2" border="0">
                            <tr> 
                                <td colspan="5">
                                    选择价格区间：
                                    <select name="pv" id="pv" onchange="javascript:location.href='<?=$php_self?>hotcarAct&pv=' + this.value">
                                        <? foreach((array)$priceSelect as $k=>$ps) {?>
                                        <option value="<?=$k?>" <? if ($k == $priceValue) { ?>selected="selected"<? } ?>><?=$ps?></option>
                                        <?}?>
                                    </select>
                                </td>
                            </tr>
                            <tr> 
                                <td height="20" width="10%">位置</td>
                                <td height="20" width="20%">车系简称</td>
                                <td height="20" width="20%">品牌</td>
                                <td height="20" width="20%">厂商</td>
                                <td height="20" width="30%">车系</td>
                            </tr>                    
                            <? for($i=1; $i< 31; $i++) { ?>
                            <? $datai = $data[$i] ?>
                            <tr <? if ($i % 2 == 0) { ?>class="deep"<? } ?>> 
                                <td height="20"><?=$i?></td>
                                <td height="20"><input type="text" size="10" maxlength="10" name="alias<?=$i?>" id="alias<?=$i?>" value="<?=$datai['alias']?>"/></td>
                                <td height="20">
                                    <select name="brand_id<?=$i?>" id="brand_id<?=$i?>" onchange="factory_selected($('#factory_id<?=$i?>'), this.value);">
                                        <option value="0">选择品牌</option>
                                        <? foreach((array)$carSelect['brandSelect'] as $bid=>$bv) {?>
                                        <option value="<?=$bid?>" <? if ($bid == $datai['brand_id']) { ?>selected="selected"<? } ?>><?=$bv['letter']?> <?=$bv['brand_name']?></option>
                                        <?}?>
                                    </select>
                                </td>
                                <td height="20">
                                    <select name="factory_id<?=$i?>" id="factory_id<?=$i?>" style="width:120px;" onchange="series_selected($('#series_id<?=$i?>'), this.value);">
                                        <option value="0">选择厂商</option>                                
                                    </select>                            
                                    <script>factory_selected($('#factory_id<?=$i?>'), <?=$datai['brand_id']?>, <?=$datai['factory_id']?>);</script>
                                </td>
                                <td height="20">
                                    <select name="series_id<?=$i?>" id="series_id<?=$i?>" style="width: 150px;" onchange="getSeriesAlias(<?=$i?>, this.value);">
                                        <option value="0">选择车系</option>                                
                                    </select>                            
                                    <script>series_selected($('#series_id<?=$i?>'), <?=$datai['factory_id']?>, <?=$datai['series_id']?>);</script>
                                </td>
                            </tr>
                            <? } ?>
                            <tr>
                                <td colspan="5" style="line-height: 60px;">
                                    <input type="submit" value="确认提交">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="取消操作">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
            </div>
        </div>
        <script>
            function getSeriesAlias(i, sid) {
                $.get('index.php?action=cpindex-GetSeriesAlias', {sid:sid}, function(ret) {
                    $('#alias' + i).val(ret);
                });        
            }
        </script>
    </body>
</html>