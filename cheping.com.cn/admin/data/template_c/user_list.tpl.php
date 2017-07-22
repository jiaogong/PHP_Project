<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
        <div class="user">
            <div class="navs">
                <ul class="nav">
                    <? if ($type) { ?>
                    <li><a href="?action=user-userlist">正式用户</a></li>
                    <li><a href="?action=user-userlist&type=sideline" class="song">兼职用户</a></li>
                    <li><a href="?action=user-add">添加用户</a></li>
                    <? } else { ?>
                    <li><a href="?action=user-userlist" class="song">正式用户</a></li>
                    <li><a href="?action=user-userlist&type=sideline">兼职用户</a></li>
                    <li><a href="?action=user-add">添加用户</a></li>
                    <? } ?>

                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-con">
                <div class="user-table">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td style=" padding-top:20px;">序号</td>
                            <td style=" padding-top:20px;">登录帐号</td>
                            <td style=" padding-top:20px;">真实用户名</td>
                            <td style=" padding-top:20px;">笔名</td>
                            <td style=" padding-top:20px;">电话</td>
                            <td style=" padding-top:20px;">用户类型</td>
                            <td style=" padding-top:20px;">用户状态</td>
                            <td style=" padding-top:20px;">操作</td>
                        </tr>
                        <tbody>
                            <? foreach((array)$alluser as $k=>$user) {?>
                            <tr>
                                <td><?=$user['uid']?></td>
                                <td><?=$user['username']?></td>
                                <td><?=$user['realname']?></td>
                                <td><?=$user['nickname']?></td>
                                <td><?=$user['mobile']?></td>
                                <td><?=$user['gid']?></td>
                                <td style=" "><?=$user['module_memo']?></td>
                                <td>
                                    <span><i style=" padding-top:2px; padding-left:4px;"><img src="images/shanchu.png" /></i><a href="#here" class="click_pop_dialog" mt='1' icon='warnning' tourl='?action=user-deluser&uid=<?=$user['uid']?>'>删除</a></span>
                                    <span><i style=" padding-top:3px;"><img src="images/bi.png" /></i><a href="?action=user-edit&uid=<?=$user['uid']?>">修改信息</a></span>&nbsp;&nbsp
                                    <span><i style=" padding-top:2px;"><img src="images/luck.png" /></i><a href="?action=auth-&uid=<?=$user['uid']?>">修改权限</a></span>

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
                    pop_window($(this), {message: '您确定要删除该用户吗？', pos: [200, 150]});
                });
            });
        </script>
    </body>
</html>
