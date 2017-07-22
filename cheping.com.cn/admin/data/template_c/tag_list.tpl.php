<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
        <div class="user">
            <div class="nav">
                <ul>
                    <li ><a href="<?=$php_self?>" class="song">标签列表</a></li>
                    <li><a href="<?=$php_self?>add">新增标签</a></li>
                    <li><a href="<?=$php_self?>tagtag">导出/导入标签</a></li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-con">
                <div class="user-table">
                    <form id="search_form" name="search_form" method="post" action="index.php?action=tag-list">
                        <table class="table2" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left">
                                    <select id="article_type" name="state">
                                        <option value="2" selected>请选择</option>
                                        <option value="0">不通过</option>
                                        <option value="1">通过</option>
                                    </select>
                                    标签名称:<input type="text" name="tag_name" id="keyword" size="40"/>
                                    标签名字母:<input type="text" name="letter" id="keyword" size="40" style="width:30px;"/>
                                    <input id="search_btn" name="search_btn" type="submit" value="搜索" />
                                </td>
                            </tr>
                        </table>
                    </form>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <form id="form1" name="del_form" action="<?=$php_self?>ds" method="post"> 
                            <tr>
                                <td style=" padding-top:20px;">ID</td>
                                <td style=" padding-top:20px;">标签名称</td>
                                <td style=" padding-top:20px;">标签名全拼</td>
                                <td style=" padding-top:20px;">标签首字母</td>
                                <td style=" padding-top:20px;">添加人</td>
                                <td style=" padding-top:20px;">添加日期</td>
                                <td style=" padding-top:20px;">状态</td>
                                <td style=" padding-top:20px;">操作</td>
                            </tr>

                            <tbody>
                                <? foreach((array)$list as $k=>$v) {?>
                                <tr>
                                    <td><input type="checkbox" name="id[]" value="<?=$v[id]?>"/> <?=$v[id]?></td>
                                    <td width="200"><?=$v[tag_name]?></td>
                                    <td><?=$v[pinyin]?></td>
                                    <td><?=$v[letter]?></td>
                                    <td><?=$v[username]?></td>
                                    <td><? echo date('Y/m/d', $v[created]); ?></td>
                                    <td>
                                        <? if ($v[state] ==0) { ?>
                                        不通过
                                        <? } else { ?>
                                        通过
                                        <? } ?>
                                    </td>
                                    <td>
                                        <span><i style=" padding-top:3px;"><img src="images/bi.png" /></i>
                                            <a href="<?=$php_self?>edit&id=<?=$v[id]?>">修改</a>
                                            <a href="<?=$php_self?>shen&id=<?=$v[id]?>"><? if ($v[state] ==1) { ?>隐藏<? } else { ?>审核<? } ?></a>
                                        </span>
                                    </td>
                                </tr>
                                <?}?>
                                <tr>
                                    <td colspan="1">
                                        <input type="checkbox"  id="allselect"  onclick="SelectAllCheckboxes(allselect)" />全选
                                    </td>
                                    <td colspan="1">
                                        <!--<input type="submit" class="sbt" name= 'submit1' value="批量删除"/>-->　　<input type="submit" class="sbt" name= 'submit2' value="批量审核/隐藏"/>
                                    </td>
                                    <td colspan="6"></td>
                                </tr>
                            </tbody>
                        </form> 
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
            $().ready(function () {
                $('.click_pop_dialog').live('click', function () {
                    pop_window($(this), {message: '您确定要删除该标签吗？', pos: [200, 150]});
                });
            });
        </script>  

        <script language="javascript" type="text/javascript">
            //全选
            function SelectAllCheckboxes(spanChk)
            {
                var xState = spanChk.checked;
                //alert(xState);

                elm = spanChk.form.elements;
                //alert(elm.length);
                for (i = 0; i < elm.length - 1; i++)
                {
                    if (elm[i].type == "checkbox" && elm[i].id != spanChk.id)
                    {

                        if (elm[i].checked != xState)
                            elm[i].click();
                    }

                }
            }
        </script>
    </body>
</html>
