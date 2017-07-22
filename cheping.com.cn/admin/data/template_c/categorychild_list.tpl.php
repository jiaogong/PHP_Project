<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
        <div class="user">
            <div class="nav">
                <ul>
                    <li><a href="<?=$php_self?>"  class="song"><?=$categoryparent['category_name']?>子频道列表</a></li>
                    <li><a href="javascript:history.go(-1);">返回上一级</a></li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-con">
                <div class="user-table">
                    <table border="0" cellspacing="0" cellpadding="0">

                        <tr>
                            <td  style=" padding-top:20px;">ID</td>
                            <td style=" padding-top:20px;">标签名称</td>
                            <td style=" padding-top:20px;">状态</td>
                            <td style=" padding-top:20px;">操作</td>
                        </tr>



                        <tbody>
                            <? foreach((array)$list as $k=>$v) {?>
                            <tr>
                                <td><?=$v[id]?></td>
                                <td width="200"><?=$v[category_name]?></td>

                                <td>
                                    <? if ($v[state] ==0) { ?>
                                    不正常
                                    <? } else { ?>
                                    正常
                                    <? } ?>
                                </td>
                                <td>
                                    <span>
                                        <i style=" padding-top:2px;"><img src="images/luck.png" /></i>
                                        <a href="<?=$php_self?>edit&id=<?=$v[id]?>&parentid=<?=$categoryparent['id']?>">修改</a>
                                        <a href="<?=$php_self?>shen&id=<?=$v[id]?>&state=<?=$v[state]?>&parentid=<?=$categoryparent['id']?>">审核状态</a>&nbsp;
                                        <a href="<?=$php_self?>del&id=<?=$v[id]?>&pid=<?=$categoryparent['id']?>">删除</a>
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
