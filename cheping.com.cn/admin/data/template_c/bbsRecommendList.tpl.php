<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
        <div class="user">
            <div class="nav">
                <ul>
                    <li><a href="<?=$php_self?>RecommendList" class="song">精选推荐帖列表</a></li>
                    <li><a href="<?=$php_self?>addRecommend">添加精选推荐帖</a></li>
                    <li><a href="<?=$php_self?>addPopularize">添加推广帖</a></li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-con">
                <div class="user-table">
                    <form action="" method="post" enctype="multipart/form-data">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td  style=" padding-top:20px;">ID</td>
                            <td style=" padding-top:20px;">标题</td>
                            <td style=" padding-top:20px;">类型</td>
                            <td style=" padding-top:20px;">推荐人</td>
                            <td style=" padding-top:20px;">推荐时间</td>
                            <td style=" padding-top:20px;">排序</td>
                            <td style=" padding-top:20px;">操作</td>
                        </tr>
                        <tbody id="tobdy">
                            <? if ($list) { ?>
                            <? foreach((array)$list as $k=>$v) {?>
                            <tr>
                                <td><?=$v[pid]?></td>
                                <td style="width:200px;"><?=$v[firsttitle]?></td>
                                <td ><? if ($v[popularize]) { ?>推广<? } else { ?>帖子<? } ?></td>
                                <td><?=$v[firstauthor]?></td>
                                <td><? if ($v[firstdate]) { ?><? echo date('Y-m-d',$v[firstdate]) ?><? } ?></td>
                                <td><? if ($v[firstsort]>=100) { ?>默认<? } else { ?><?=$v[firstsort]?><? } ?></td>
                                <td>
                                    <? if ($v[popularize]==1) { ?>
                                        <span>
                                            <a href="<?=$php_self?>addPopularize&pid=<?=$v[pid]?>" class="but_del">编辑</a>
                                        </span> /
                                    <? } else { ?>
                                        <span>
                                            <a href="<?=$php_self?>addRecommend&pid=<?=$v[pid]?>" class="but_del">编辑</a>
                                        </span> /
                                    <? } ?>
                                    <span>
                                        <a href="<?=$php_self?>RecommendList&pid=<?=$v[pid]?>&event=cancel" class="but_del">取消</a>
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
                    </form>
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
