<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
    <div class="nav">
        <ul id="nav">
            <li><a href="<?=$php_self?>" class="song">文本参数列表</a></li>
            <li><a href="<?=$php_self?>add" >添加文本参数</a></li>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
            <form action="<?=$php_self?>" method="post">
                <table class="table2" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <select name="state" id="state">
                                <option value="0">标配</option>
                                <option value="1">选配</option>
                            </select>
                            <select name="brand_id" id="brand_id">
                                <option value="">请选择品牌</option>
                                <? foreach((array)$brand as $k=>$v) {?>
                                <option value="<?=$v[brand_id]?>"><?=$v[brand_name]?></option>
                                <?}?>
                            </select>
                            <select name="factory_id" id="factory_id">
                                <option value="">请选择厂商</option>
                                <? foreach((array)$factory as $k=>$v) {?>
                                <option value="<?=$v[factory_id]?>"><?=$v[factory_name]?></option>
                                <?}?>
                            </select>
                            <select name="series_id" id="series_id">
                                <option value="">请选择车系</option>
                                <? foreach((array)$series as $k=>$v) {?>
                                <option value="<?=$v[series_id]?>"><?=$v[series_name]?></option>
                                <?}?>
                            </select>
                            <select name="model_id" id="model_id" style="width:160px">
                                <option value="">请选择车款</option>
                                <? foreach((array)$model as $k=>$v) {?>
                                <option value="<?=$v[model_id]?>"><?=$v[model_name]?></option>
                                <?}?>
                            </select>
                            <!--select name="pcategory" id="pcategory">
                              <option value="">请选择分类</option>
                              <? foreach((array)$paramtype as $ck=>$cv) {?>
                            <option value="<?=$cv['id']?>"><?=$cv['name']?></option>
                            <?}?>
                            </select-->
                            名称
                            <input size="12" name="keyword" id="keyword">
                            <input type="submit" name="search" value=" 搜 索 ">
                        </td>
                    </tr>
                </table>
            </form>

            <table class="table2" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <tr class="th">
                    <th>ID</th>
                    <th>参数分类</th>
                    <th>参数值</th>
                    <th>车款</th>
                    <th>操作</th>
                </tr>
                <? foreach((array)$list as $k=>$v) {?>
                <tr align="center">
                    <td><?=$v['id']?></td>
                    <td><?=$v['pname']?></td>
                    <td width="200"><? echo mb_substr($v['value'],0,50,'utf-8'); ?></td>
                    <td><?=$v['series_name']?>-<?=$v['model_name']?></td>
                    <td><a href="<?=$php_self?>edit&id=<?=$v['id']?>&extra=<?=$extra?>"><img
                            src="<?=$admin_path?>images/rewrite.gif" width="12" height="12"/>修改</a>
                        <a href="#here" mt='1' icon='warnning' tourl="<?=$php_self?>del&id=<?=$v['id']?>"
                           class="click_pop_dialog">
                            <img src="<?=$admin_path?>images/del1.gif" height="9" width="9">删除
                        </a>
                    </td>
                </tr>
                <?}?>
                </tbody>
            </table>
        </div>
        <? if ($page_bar) { ?>
        <div>
            <div class="ep-pages">
                <?=$page_bar?>
            </div>
        </div>
        <? } ?>
        <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif" height="16"></div>
    </div>
</div>
<script type="text/javascript">
    $().ready(function () {
        <? if ($model_r) { ?>
        $('#brand_id option[value="<?=$model_r['brand_id']?>"]').attr({selected: true});
        $('#factory_id option[value="<?=$model_r['factory_id']?>"]').attr({selected: true});
        $('#series_id option[value="<?=$model_r['series_id']?>"]').attr({selected: true});
        $('#model_id option[value="<?=$model_r['model_id']?>"]').attr({selected: true});
        <? } ?>

        $('#pcategory').change(function () {
            var cate = $('#category')[0];
            var pid = $(this).val();
            var cateurl = "?action=paramtype-json&pid=" + pid;
            if (!pid) {
                $('#category option[value!=""]').remove();
            } else {
                //alert(pid);
                $.getJSON(cateurl, function (ret) {
                    $('#category option[value!=""]').remove();
                    $.each(ret, function (i, v) {
                        cate.options.add(new Option(v['name'], v['id']));
                    });
                });
            }
        });

        $('#brand_id').change(function () {
            var brand_id = $(this).val();
            var fact = $('#factory_id')[0];
            var facturl = "?action=factory-json&brand_id=" + brand_id;
            var sel = $(this)[0];
            $('#brand_name').val(sel.options[sel.selectedIndex].text)

            $.getJSON(facturl, function (ret) {
                $('#factory_id option[value!=""]').remove();
                $('#series_id option[value!=""]').remove();
                $('#model_id option[value!=""]').remove();

                $.each(ret, function (i, v) {
                    fact.options.add(new Option(v['factory_name'], v['factory_id']));
                });
            });
        });

        $('#factory_id').change(function () {
            var fact_id = $(this).val();
            var ser = $('#series_id')[0];
            var serurl = "?action=series-json&factory_id=" + fact_id;
            var sel = $(this)[0];
            $('#factory_name').val(sel.options[sel.selectedIndex].text)

            $.getJSON(serurl, function (ret) {
                $('#series_id option[value!=""]').remove();
                $('#model_id option[value!=""]').remove();

                $.each(ret, function (i, v) {
                    ser.options.add(new Option(v['series_name'], v['series_id']));
                });
            });
        });

        $('#series_id').change(function () {
            var sel = $(this)[0];
            $('#series_name').val(sel.options[sel.selectedIndex].text)

            var sid = $(this).val();
            var mod = $('#model_id')[0];
            var modurl = "?action=model-json&sid=" + sid;
            $.getJSON(modurl, function (ret) {
                $('#model_id option[value!=""]').remove();
                $.each(ret, function (i, v) {
                    mod.options.add(new Option(v['model_name'], v['model_id']));
                });
            });
        });

        $('#model_id').change(function () {
            var mod = $(this)[0];
            $('#model_name').val(mod.options[mod.selectedIndex].text)
        });

        <? if ($pcategory) { ?>
        $('#pcategory option[value="<?=$pcategory?>"]').attr({selected: true});
        <? } ?>

        <? if ($keyword) { ?>
        $('#keyword').val('<?=$keyword?>');
        <? } ?>

        <? if ($state) { ?>
        $('#state option[value="<?=$state?>"]').attr({selected: true});
        <? } ?>

        $('.click_pop_dialog').live('click', function () {
            pop_window($(this), {message: '您确定要删除该文本参数吗？', pos: [200, 150]});
        });
    });

</script>
</body>
</html>
