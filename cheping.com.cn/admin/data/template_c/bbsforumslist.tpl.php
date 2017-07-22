<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
        <div class="user">
            <div class="nav">
                <ul>
                    <li><a href="<?=$php_self?>ForumsList" class="song">论坛版块列表</a></li>
                    <li><a href="<?=$php_self?>EditForum<? if ($fid) { ?>&fid=<?=$fid?>&event=edit<? } ?>" ><? if ($fid) { ?>编辑<? } else { ?>添加<? } ?>论坛版块</a></li>
                    <li><a href="<?=$php_self?>AddTheme">添加论坛主题</a></li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-con">
                <div class="user-table">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td  style=" padding-top:20px;">ID</td>
                            <td style=" padding-top:20px;">类型</td>
                            <td style=" padding-top:20px;">版块名称</td>
                            <td style=" padding-top:20px;">主题</td>
                            <td style=" padding-top:20px;">帖子</td>
                            <td style=" padding-top:20px;">排序</td>
                            <td style=" padding-top:20px;">操作</td>
                        </tr>
                        <tbody id="tobdy">
                            <? if ($list) { ?>
                            <? foreach((array)$list as $k=>$v) {?>
                            <tr>
                                <td><?=$v[fid]?></td>
                                <td style="width:200px;">
                                    <? if ($v[type]=='group') { ?>分类
                                    <? } elseif($v[type]=='forum') { ?>普通论坛
                                    <? } elseif($v[type]=='sub') { ?>子论坛
                                    <? } ?>
                                </td>
                                <td ><?=$v[name]?></td>
                                <td><?=$v[threads]?></td>
                                <td><?=$v[posts]?></td>
                                <td><? if ($v[displayorder]>=10) { ?>默认<? } else { ?><?=$v[displayorder]?><? } ?></td>
                                <td>
                                    <span>
                                        <a href="<?=$php_self?>EditForum&fid=<?=$v[fid]?>&event=edit" class="but_del">编辑</a>
                                    </span> /
                                    <span>
                                        <? if ($v[status]==0) { ?>
                                        <a href="<?=$php_self?>ForumsList&fid=<?=$v[fid]?>&event=switch" class="but_del">开启</a>
                                        <? } elseif($v[status]==1) { ?>
                                        <a href="<?=$php_self?>ForumsList&fid=<?=$v[fid]?>&event=switch" class="but_del">关闭</a>
                                        <? } ?>
                                    </span> /
                                    <span>
                                        <a href="<?=$php_self?>ForumsList&fid=<?=$v[fid]?>&event=del" class="but_del">删除</a>
                                    </span>

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
            $().ready(function () {
                $(".but_del").live('click',function(){
                    $(this).parent().parent().parent("tr").remove();
                })
                
                $(".but_check").live('click',function(){
                   var tr= $(this).parent().parent().parent("tr")
                   var id= tr.find(".id_a").val();
                   $.get("<?=$php_self?>ajaxarticle",{"id":id},function(msg){
                       if(msg==-1){
                           alert("该文章不存在");
                       }else{
                           arr =eval('(' + msg + ')');
                           tr.find(".content1").html(arr['title']);
                           tr.find(".content2").html(arr['type']);
                           tr.find(".content3").html(arr['day']);
                         
                       }
                   })
                   
                })
            });
        
            function add(){
                var html ='<tr><td><input class="id_a" type="text" value=""  name="id[]" size="4" ></td><td style="width:150px;" class="content1"><input type="text" name="title[]" value=""></td><td class="content2"></td><td class="content3"></td><td><input style="width:70px;" type="file" value="" name="pic[]"><input type="hidden" id="old_pic[]" name="old_pic[]" value=""><p><a class="jTip" id="jtip<?=$i?>" href="/admin/index.php?action=index-pic&picture=">查看PC图片(1180*400)</a></p></td><td><input type="text" name="url[]" value=""></td><td><input type="text" name="orderby[]" size="4" value=""></td><td><span><input type="button" value="确认" class="but_check"><a href="javascript:void(0)" class="but_del">移除</a></span></td></tr>';
                $("#tobdy").append(html);
            }
          
        </script>  
    </body>
</html>
