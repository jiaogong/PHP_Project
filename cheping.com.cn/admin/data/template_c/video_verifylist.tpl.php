<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
        <div class="user">
            <div class="nav">
                <ul>
                    <li><a href="<?=$php_self?>">视频列表</a></li>
                    <li><a href="<?=$php_self?>verifylist" class="song">待审核视频列表</a></li>
                    <li ><a href="<?=$php_self?>typelist">审核意见待处理视频列表</a></li>
                    <li><a href="<?=$php_self?>add">添加视频</a></li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-con">
                <div>
                    <form id="search_form" name="search_form" method="post" action="index.php?action=video-verifylist">
                        <table class="table2" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" style="padding:10px 0px 10px 0px;">
                                    标题:<input type="text" name="keyword" id="keyword" size="40" value="<?=$keyword?>"/>

                                    作者:<input type="text" name="author" id="author" value="<?=$author?>" />
                                    ID:<input type="text" name="article_id" id="article_id" size="4"/>
                                    <input id="search_btn" name="search_btn" type="submit" value="搜索" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="user-table">
                    <table border="0" cellspacing="0" cellpadding="0">

                        <tr>                                                   
                            <td>ID</td>
                            <td>标题</td>
                            <td>作者</td>
                            <td>上线时间</td>
                            <td>时间</td>
                            <td>是否审核过</td>
                            <td>操作</td>
                        </tr>



                        <tbody>
                            <? foreach((array)$list as $k=>$v) {?>
                            <tr>
                                <td><?=$v[id]?></td>
                                <td width="200"><?=$v[title]?></td>
                                <td><?=$v[author]?></td>
                                <td><? echo date('Y/m/d', $v[uptime]); ?></td>
                                <td><? echo date('Y/m/d', $v[created]); ?></td>
                                <td><? if ($v[comment]) { ?>是<? } else { ?>否<? } ?></td>
                                <td>
                                    <span><i style=" padding-top:2px;"><img src="images/shanchu.png" /></i><a  href="<?=$php_self?>del&id=<?=$v['id']?>" onclick="return confirmDel('确定要删除吗')" >删除</a></span>
                                    <span><i style=" padding-top:3px;"><img src="images/bi.png" /></i><a href="<?=$php_self?>edit&id=<?=$v[id]?>">修改信息</a></span>
                                    <span><i style=" padding-top:2px;"><img src="images/luck.png" /></i>
                                        <a href="<?=$php_self?>preview&id=<?=$v[id]?>&s=2" target="_blank">预览</a>
                                    </span>
                                </td>
                            </tr>
                            <?}?>
                        </tbody>
                    </table>
                </div>
                <div>
                    <div class="ep-pages">
                        <?=$page_bar?>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function confirmDel(str) {
                return confirm(str);
            }
            $().ready(function () {
                $('.click_pop_dialog').live('click', function () {
                    pop_window($(this), {message: '您确定要删除该文章吗？', pos: [200, 150]});
                });

                $('.article_make_page').click(function () {
                    $.get($(this).attr('tourl'), function (ret) {
                        if ($.trim(ret) > 0) {
                            alert('文章生成成功！');
                        } else {
                            alert('文章生成失败！' + ret);
                        }
                    });
                });
                        $('#brand_id').val(<?=$brand_id?>);
                        $('#factory_id').val(<?=$factory_id?>);
                        $('#series_id').val(<?=$series_id?>);
                        $('#article_type').val(<?=$article_type?>);
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

            });
        </script>  
    </body>
</html>
