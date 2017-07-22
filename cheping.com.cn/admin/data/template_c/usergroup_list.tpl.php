<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
        <div class="user">
            <div class="navs">
                <ul class="nav">
                    <? if ($type) { ?>
                    <li ><a  href="?action=usergroup-list" class="song">修改、删除用户组</a></li>
                    <li><a href="?action=usergroup-add">添加用户组</a></li>
                    <? } else { ?>
                    <li ><a href="?action=usergroup-list" class="song">修改、删除用户组</a></li>
                    <li><a href="?action=usergroup-add">添加用户组</a></li>
                    <? } ?> 

                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-con">
                <div class="user-table">
                    <table border="0" cellspacing="0" cellpadding="0">

                        <tr>
                            <td style=" padding-top:20px;">ID</td>
                            <td style=" padding-top:20px;">组名称</td>
                            <td style=" padding-top:20px;">备注</td>
                            <td style=" padding-top:20px;">操作</td>
                        </tr>



                        <tbody>
                            <? foreach((array)$allusergroup as $k=>$group) {?>
                            <tr>
                                <td><?=$group['group_id']?></td>
                                <td><?=$group['group_name']?></td>
                                <td>&nbsp;<?=$group['memo']?>&nbsp;</td>
                                <td>
                                    <span><i style=" padding-top:2px;"><img src="images/shanchu.png" /></i><a href="#here" class="click_pop_dialog" mt='1' icon='warnning' tourl='?action=usergroup-del&gid=<?=$group['group_id']?>'>删除</a></span>
                                    <span><i style=" padding-top:2px;"><img src="images/luck.png" /></i><a href="?action=usergroup-edit&gid=<?=$group['group_id']?>">修改权限</a></span>

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
        <script language="javascript">
            $(document).ready(function () {
                $('.click_pop_dialog').live('click', function () {
                    pop_window($(this), {message: '您确定要删除该用户组吗？', pos: [200, 150]});
                });
            });
        </script>
    </body>
</html>
