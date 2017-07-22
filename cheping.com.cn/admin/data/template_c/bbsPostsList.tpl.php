<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
        <div class="user">
            <div class="nav">
                <ul>
                    <? if ($forum_list) { ?>
                    <? foreach((array)$forum_list as $k=>$v) {?>
                    <li><a href="<?=$php_self?>PostsList&fid_type=<?=$v[fid]?>" <? if ($fid_type==$v[fid]) { ?>class="song"<? } ?>><?=$v[name]?></a></li>
                    <?}?>
                    <? } ?>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-con">
                <div class="user-table">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr height="50px">
                                <form action="<?=$php_self?>PostsList&fid_type=<?=$fid_type?>" method="post" id="subject_from">
                                    <td width="70px">
                                        根据标题搜索:
                                    </td>
                                    <td  width="70px">
                                        <input type="text" style="border:1px solid #cdcdcd;  background:none;" id ="subject_val" name="subject" size="30" value="<?=$subject?>" />
                                    </td>
                                    <td width="20px">
                                       <input id="subject_but" type="button" value="搜索" />
                                    </td>
                                </form>
                                <td width="10%">
                                </td>
                                <form action="<?=$php_self?>PostsList&fid_type=<?=$fid_type?>" method="post" id="author_from" >
                                    <td  width="70px">
                                        根据作者搜索:
                                    </td>
                                    <td  width="30px">
                                        <input type="text" style="border:1px solid #cdcdcd;  background:none;" id="author_val" name="author" size="16" value="<?=$author?>" />
                                    </td>
                                    <td width="20px">
                                        <input id="author_but" type="button" value="搜索" />
                                    </td>
                                </form>
                                <td width="20%">
                                </td>
                            </tr>
                        </table>
                        <!--<table border="0" cellspacing="0" cellpadding="0">-->
                            <!--<tr height="50px">-->
                                <!--<td width="50px">筛选条件：</td>-->
                                <!--<td width="30px">-->
                                    <!--<select>-->
                                        <!--<option  value="">-帖子类型-</option>-->
                                        <!--<option  value="0">普通</option>-->
                                        <!--<option  value="1">官方</option>-->
                                    <!--</select>-->
                                <!--</td>-->
                                <!--<td  width="30px">-->
                                    <!--<select>-->
                                        <!--<option  value="">-精华-</option>-->
                                        <!--<option  value="0">否</option>-->
                                        <!--<option  value="1">是</option>-->
                                    <!--</select>-->
                                <!--</td>-->
                                <!--<td  width="30px">-->
                                    <!--<select>-->
                                        <!--<option  value="">-置顶-</option>-->
                                        <!--<option  value="0">否</option>-->
                                        <!--<option  value="1">是</option>-->
                                    <!--</select>-->
                                <!--</td>-->
                                <!--<td  width="30px">-->
                                    <!--<input type="button" value="搜索" />-->
                                <!--</td>-->
                                <!--<td width="50%">-->
                                <!--</td>-->
                            <!--</tr>-->
                        <!--</table>-->
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td  style=" padding-top:20px;">ID</td>
                            <td style=" padding-top:20px;">标题</td>
                            <td style=" padding-top:20px;">类型</td>
                            <td style=" padding-top:20px;">置顶</td>
                            <td style=" padding-top:20px;">精华</td>
                            <td style=" padding-top:20px;">审核</td>
                            <td style=" padding-top:20px;">发帖子人</td>
                            <td style=" padding-top:20px;"><a href="<?=$php_self?>PostsList&event=date&date=publish&fid_type=<?=$fid_type?>">发表时间</a></td>
                            <td style=" padding-top:20px;"><a href="<?=$php_self?>PostsList&event=date&date=modify&fid_type=<?=$fid_type?>">修改时间</a></td>
                            <td style=" padding-top:20px;">操作</td>
                        </tr>
                        <tbody id="tobdy">
                            <? if ($post_list) { ?>
                            <? foreach((array)$post_list as $k=>$v) {?>
                            <tr class="post_<?=$v[pid]?>">
                                <td><?=$v[pid]?></td>
                                <td width="120px" style="height:40px;overflow: hidden;text-overflow:ellipsis;"><?=$v[subject]?></td>
                                <td ><? if ($v[authority]) { ?>官方<? } else { ?>普通<? } ?></td>
                                <td ><? if ($v[toppost]) { ?>是<? } else { ?>否<? } ?></td>
                                <td ><? if ($v[digest]) { ?>是<? } else { ?>否<? } ?></td>
                                <td ><? if ($v[invisible]) { ?>通过<? } else { ?>未通过<? } ?></td>
                                <td><?=$v[author]?></td>
                                <td width="50px"><? if ($v[dateline]) { ?><? echo date('Y-m-d H:i:s',$v[dateline]) ?><? } ?></td>
                                <td width="50px"><? if ($v[update]) { ?><? echo date('Y-m-d H:i:s',$v[update]) ?><? } else { ?><? echo date('Y-m-d H:i:s',$v[dateline]) ?><? } ?></td>
                                <td>
                                    <span>
                                        <a href="<?=$php_self?>PublishPost&pid=<?=$v[pid]?>&event=edit" class="but_del">编辑</a>
                                    </span>
                                    /
                                    <span>
                                        <a href="javascript:delpost(<?=$v[pid]?>,<?=$fid_type?>);" class="but_del">删除</a>
                                    </span>
                                </td>
                            </tr>
                            <?}?>
                            <? } ?>
                        </tbody>
                    </table>
                        <!--<div style="padding:6px 0px; width:98%; border-bottom: 1px solid #ccc; margin:0 auto;">-->
                            <!--<span style="float: left;"><input type="button" class="sbt" onclick='add()'style=" padding:0px 4px;  color:#333;font-family:'微软雅黑';  " value="添加"/>添加文章和视频id，点击确认或直接添加内容</span>-->
                            <!--<input type="submit" class="sbt"style=" padding:0px 4px;  color:#333;font-family:'微软雅黑';  " name= 'submit2' value="提交数据"/>-->
                        <!--</div>-->

                </div>
                <div>
                    <div class="ep-pages">
                        <?=$page_bar?>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function () {
                $("#subject_but").click(function(){
                    if($("#subject_val").val()){
                        $("#subject_from").submit();
                    }
                });
                $("#author_but").click(function(){
                    if($("#author_val").val()){
                        $("#author_from").submit();
                    }
                });
            });
            //删除帖子
            function delpost(pid,fid){
                if(pid && fid){
                    var con_del=confirm("确认删除这个帖子吗？\n");
                    if(con_del){
                        $.get("<?=$php_self?>PublishPost&event=del",{pid:pid,fid:fid},function(res){
                            if(res==1){
                                alert("删除成功！\n");
                                $('.post_'+pid).remove();
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
