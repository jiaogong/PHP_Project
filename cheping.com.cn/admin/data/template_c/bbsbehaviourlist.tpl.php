<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
        <div class="user">
            <div class="nav">
                <ul>
                    <li><a href="<?=$php_self?>BehaviourList&type=reply" <? if ($type=='reply') { ?>class="song"<? } ?>>用户回帖列表</a></li>
                    <li><a href="<?=$php_self?>BehaviourList&type=report" <? if ($type=='report') { ?>class="song"<? } ?> >用户举报帖子列表</a></li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-con">
                <div class="user-table">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr height="50px">
                            <form action="<?=$php_self?>PostsList&fid_type=<?=$fid_type?>" method="post" id="message_from">
                                <td width="90px">
                                    根据条件搜索
                                </td>
                                <td width="30px">
                                    帖子ID:
                                </td>
                                <td  width="50px">
                                    <input type="text" style="border:1px solid #cdcdcd;  background:none;" id ="comment_val" name="comment" size="12" onkeyup="this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="12" value="<?=$comment?>" />
                                </td>
                                <td  width="50px">
                                    回复人名子:
                                </td>
                                <td  width="50px">
                                    <input type="text" style="border:1px solid #cdcdcd;  background:none;" id="author_val" name="author" size="16" value="<?=$author?>" />
                                </td>
                                <td width="20px">
                                    <input id="author_but" type="button" value="搜索" />
                                </td>
                            </form>
                            <td width="35%">
                            </td>
                        </tr>
                    </table>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td  style=" padding-top:20px;">帖子ID</td>
                            <td  style=" padding-top:20px;"><?=$switch?>ID</td>
                            <td style=" padding-top:20px;"><?=$switch?>人</td>
                            <td style=" padding-top:20px;"><?=$switch?>人ID</td>
                            <td style=" padding-top:20px;"><?=$switch?>内容</td>
                            <td style=" padding-top:20px;"><?=$switch?>时间</td>
                            <td style=" padding-top:20px;">状态</td>
                            <td style=" padding-top:20px;">操作</td>
                        </tr>
                        <tbody id="tobdy">
                            <? if ($list) { ?>
                            <? foreach((array)$list as $k=>$v) {?>
                            <tr>
                                <td><?=$v[comment]?></td>
                                <td><?=$v[pid]?></td>
                                <td><?=$v[author]?></td>
                                <td><?=$v[authorid]?></td>
                                <td ><?=$v[message]?></td>
                                <td><?=$v[dateline]?></td>
                                <td><? if ($v[status]==0) { ?>未阅<? } else { ?>已阅<? } ?></td>
                                <td>
                                    <span>
                                        <a href="<?=$php_self?>ReadBehaviour&type=<?=$type?>&pid={<?=$v?>[pid}&page=<?=$page?>" class="but_del">查看</a>
                                    </span> /
                                    <? if ($type=='reply') { ?>
                                    <span>
                                        <a href="<?=$php_self?>BehaviourList&type=reply&pid={<?=$v?>[pid}&event=del" class="but_del">删除</a>
                                    </span>
                                    <? } ?>
                                </td>
                            </tr>
                            <?}?>
                            <? } ?>
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

        </script>  
    </body>
</html>
