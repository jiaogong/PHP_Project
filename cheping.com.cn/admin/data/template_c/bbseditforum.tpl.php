<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
        <div class="user">
            <div class="nav">
                <ul>
                    <li><a href="<?=$php_self?>ForumsList">返回</a></li>
                    <li><a href="<?=$php_self?>EditForum<? if ($fid) { ?>&fid=<?=$fid?>&event=edit<? } ?>" class="song"><? if ($fid) { ?>编辑<? } else { ?>添加<? } ?>论坛版块</a></li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-con">
                <div class="user-table">
                    <form action="" method="post" enctype="multipart/form-data">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="td_right"  width="200px;" >
                                    <span>论坛版块名称 ：</span>
                                </td>
                                <td  class="td_left">
                                    <? if ($list['fid']) { ?><input type="hidden" name="fid" value="<?=$list['fid']?>" /><? } ?>
                                    <input type="text" style="border:1px solid #cdcdcd;  background:none;" name="name" id="name" size="20" value="<?=$list['name']?>" />
                                </td>
                            </tr>
                            <? if ($fid) { ?>
                            <tr <? if ($theme_list) { ?>height="<? echo count($theme_list) * 20; ?>px"<? } ?>>
                                <td class="td_right">主题 ：</td>
                                <td class="td_left">

                                    <div id="themes_div">
                                        <? if ($theme_list) { ?>
                                        <? foreach((array)$theme_list as $key=>$val) {?>
                                        <div class="theme_<?=$val['tid']?>" style="padding:5px 5px;">
                                            <?=$val['name']?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <span>
                                                <a href="<?=$php_self?>AddTheme&tid=<?=$val['tid']?>&event=edit" class="but_del">编辑</a>
                                            </span> /
                                            <span>
                                                <a href="javascript:deltheme(<?=$val['tid']?>,<?=$list['fid']?>);" class="but_del">删除</a>
                                            </span>
                                        </div>
                                        <?}?>
                                        <? } else { ?>
                                        暂无
                                        <? } ?>
                                    </div>
                                </td>
                            </tr>
                            <? } ?>
                            <tr>
                                <td class="td_right">类型 ：</td>
                                <td class="td_left">
                                    <select name="type" id="type" >
                                        <option <? if ($list['type']=="group") { ?>selected="selected"<? } ?> value="group">分类</option>
                                        <option <? if ($list['type']=="forum" || !$list['type']) { ?>selected="selected"<? } ?> value="forum">普通论坛</option>
                                        <option <? if ($list['type']=="sub") { ?>selected="selected"<? } ?> value="sub">子论坛</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right" width="150px;" >允许匿名 ：</td>
                                <td class="td_left">
                                    <!--<label><input name="allowanonymous" <? if ($lists['allowanonymous']==0 || !$lists['allowanonymous']) { ?>checked="checked"<? } ?> type="radio" value="0" />否 </label>-->
                                    <!--<label><input name="allowanonymous" <? if ($lists['allowanonymous']==1) { ?>checked="checked"<? } ?> type="radio" value="1" />是 </label>-->
                                    <select name="allowanonymous" id="allowanonymous" >
                                        <option <? if ($list['allowanonymous']==0 || !$list['allowanonymous']) { ?>selected="selected"<? } ?> value="0">否</option>
                                        <option <? if ($list['allowanonymous']==1) { ?>selected="selected"<? } ?> value="1">是</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right" width="150px;" >是否开启帖子补充 ：</td>
                                <td class="td_left">
                                    <select name="allowappend" id="allowappend" >
                                        <option <? if ($list['allowappend']==0 || !$list['allowappend']) { ?>selected="selected"<? } ?> value="0">否</option>
                                        <option <? if ($list['allowappend']==1) { ?>selected="selected"<? } ?> value="1">是</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right" width="150px;" >允许版主修改论坛规则 ：</td>
                                <td class="td_left">
                                    <select name="alloweditrules" id="alloweditrules" >
                                        <option <? if ($list['alloweditrules']==0 || !$list['alloweditrules']) { ?>selected="selected"<? } ?> value="0">否</option>
                                        <option <? if ($list['alloweditrules']==1) { ?>selected="selected"<? } ?> value="1">是</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right" width="150px;" > 是否启用回收站 ：</td>
                                <td class="td_left">
                                    <select name="recyclebin" id="recyclebin" >
                                        <option <? if ($list['recyclebin']==0 || !$list['recyclebin']) { ?>selected="selected"<? } ?> value="0">否</option>
                                        <option <? if ($list['recyclebin']==1) { ?>selected="selected"<? } ?> value="1">是</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right" width="150px;" > 是否审核发帖 ：</td>
                                <td class="td_left">
                                    <select name="modnewposts" id="modnewposts" >
                                        <option <? if ($list['modnewposts']==0 || !$list['modnewposts']) { ?>selected="selected"<? } ?> value="0">否</option>
                                        <option <? if ($list['modnewposts']==1) { ?>selected="selected"<? } ?> value="1">是</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right" width="150px;" > 是否图片附件增加水印 ：</td>
                                <td class="td_left">
                                    <select name="disablewatermark" id="disablewatermark" >
                                        <option <? if ($list['disablewatermark']==0 || !$list['disablewatermark']) { ?>selected="selected"<? } ?> value="0">否</option>
                                        <option <? if ($list['disablewatermark']==1) { ?>selected="selected"<? } ?> value="1">是</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right" width="150px;" > 自动关闭主题 ：</td>
                                <td class="td_left">
                                    <select name="autoclose" id="autoclose" >
                                        <option <? if ($list['autoclose']==0 || !$list['autoclose']) { ?>selected="selected"<? } ?> value="0">否</option>
                                        <option <? if ($list['autoclose']==1) { ?>selected="selected"<? } ?> value="1">是</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right" width="150px;" > 允许编辑帖子 ：</td>
                                <td class="td_left">
                                    <select name="alloweditpost" id="alloweditpost" >
                                        <option <? if ($list['alloweditpost']==0 ) { ?>selected="selected"<? } ?> value="0">否</option>
                                        <option <? if ($list['alloweditpost']==1 || !$list['alloweditpost']) { ?>selected="selected"<? } ?> value="1">是</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right" width="150px;" > 只显示子版块 ：</td>
                                <td class="td_left">
                                    <select name="simple" id="simple" >
                                        <option <? if ($list['simple']==0 || !$list['simple']) { ?>selected="selected"<? } ?> value="0">否</option>
                                        <option <? if ($list['simple']==1) { ?>selected="selected"<? } ?> value="1">是</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right" width="150px;" > 是否显示全局置顶 ：</td>
                                <td class="td_left">
                                    <select name="allowglobalstick" id="allowglobalstick" >
                                        <option <? if ($list['allowglobalstick']==0 ) { ?>selected="selected"<? } ?> value="0">否</option>
                                        <option <? if ($list['allowglobalstick']==1 || !$list['allowglobalstick']) { ?>selected="selected"<? } ?> value="1">是</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right" width="150px;" > 是否添加缩略图 ：</td>
                                <td class="td_left">
                                    <select name="disablethumb" id="disablethumb" >
                                        <option <? if ($list['disablethumb']==0 || !$list['disablethumb']) { ?>selected="selected"<? } ?> value="0">否</option>
                                        <option <? if ($list['disablethumb']==1) { ?>selected="selected"<? } ?> value="1">是</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right">
                                    <span>显示顺序 ：</span>
                                </td>
                                <td  class="td_left">
                                    <input type="text" style="border:1px solid #cdcdcd;  background:none; " name="displayorder" id="displayorder" size="10" onkeyup="this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="5" value="<? if ($list['displayorder']) { ?><? if ($list['displayorder']>=10) { ?>默认<? } else { ?><?=$list['displayorder']?><? } ?><? } else { ?>默认<? } ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right">状态 ：</td>
                                <td class="td_left">
                                    <select name="status" id="status" >
                                        <option <? if ($list['status']==0) { ?>selected="selected"<? } ?> value="0">关闭</option>
                                        <option <? if ($list['status']==1 || !$list['status']) { ?>selected="selected"<? } ?> value="1">正常</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right">
                                    <button class="tijiao" id="btn" name="btn">提 交</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
<script type="text/javascript">
    $(function() {
        $('#btn').click(function () {
            if (!$('#name').val()) {
                alert('论坛版块名称没有填写');
                return false;
            } else {
                $('#article_form').submit();
            }
        });
    });
    function deltheme(tid,fid){
        if(tid && fid){
            var con_del=confirm("确认删除这个主题吗？\n");
            if(con_del){
                $.get("<?=$php_self?>AddTheme&event=del",{tid:tid,fid:fid},function(res){
                    if(res==1){
                        alert("删除成功！\n");
                        $('.theme_'+tid).remove();
                    }else if(res==2){
                        alert("无法删除,此主题下存在帖子！\n");
                    }else{
                        alert("删除失败！\n");
                    }
                });
            }
        }
    }
</script>
</body>
</html>
