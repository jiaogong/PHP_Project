<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
        <div class="user">
            <div class="nav">
                <ul>
                    <li><a href="?action=module-"  class="song">权限模块列表</a></li>
                    <li><a href="?action=module-add">添加权限模块</a></li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-con">
                <div class="user-table">
                    <table border="0" cellspacing="0" cellpadding="0">

                        <tr>
                            <td style=" padding-top:20px;">&nbsp;代码&nbsp;</td>
                            <td style=" padding-top:20px;">&nbsp;名称&nbsp;</td>
                            <td style=" padding-top:20px;">&nbsp;链接&nbsp;</td>
                            <td style=" padding-top:20px;">&nbsp;备注&nbsp;</td>
                            <td style=" padding-top:20px;">&nbsp;操作&nbsp;</td>
                        </tr>



                        <tbody>
                            <? foreach((array)$allmodule as $k=>$module) {?>
                            <tr>
                                <td>&nbsp;<?=$module['module_code']?></td>
                                <td>&nbsp;<?=$module['module_name']?></td>
                                <td>&nbsp;<?=$module['module_link']?></td>
                                <td>&nbsp;<?=$module['module_memo']?></td>
                                <td>
                                    <span><i style=" padding-top:2px;"><img src="images/shanchu.png" /></i>
                                        <a href="#here" class="click_pop_dialog" mt='1' icon='warnning' tourl="?action=module-del&id=<?=$module['module_id']?>">删除</a>
                                    </span>
                                    <span><i style=" padding-top:2px;"><img src="images/luck.png" /></i>
                                        <a href="?action=module-edit&id=<?=$module['module_id']?>">修改</a>
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
        <script language="javascript">
            $(document).ready(function () {
                $('.click_pop_dialog').live('click', function () {
                    pop_window($(this), {message: '您确认要删除该权限模块吗？', pos: [200, 150]});
                });
            });
        </script>
    </body>
</html>
