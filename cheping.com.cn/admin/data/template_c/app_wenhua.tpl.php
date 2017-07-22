<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
        <div class="user">
            <div class="nav">
                <ul>
                    <li><a href="<?=$php_self?>bannerindex">app首页轮播图</a></li> 
                    <li><a href="<?=$php_self?>bannernews">app新闻轮播图</a></li> 
                    <li><a href="<?=$php_self?>bannerpingce">app评测轮播图</a></li> 
                    <li><a href="<?=$php_self?>bannervideo">app视频轮播图</a></li> 
                    <li><a href="<?=$php_self?>bannerwenhua" class="song">app文化轮播图</a></li> 
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
                            <td style=" padding-top:20px;">发布时间</td>
                            <td style=" padding-top:20px;">图片</td>
                            <td style=" padding-top:20px;">路径</td>
                            <td style=" padding-top:20px;">排序</td>
                            <td style=" padding-top:20px;">操作</td>
                        </tr>



                        <tbody id="tobdy">
                            <? foreach((array)$list as $k=>$v) {?>
                            <tr>
                                <td><input type='text' value="<?=$v[id]?>" id="<?=$v[id]?>" name="id[]" size="4" readonly="readonly"></td>
                                <td style="width:150px;"><input type="text" name="title[]" value="<?=$v[title]?>"></td>
                                <td ><? if ($v[cname]=='article') { ?>文章<? } elseif($v[cname]=='video') { ?>视频<? } else { ?>其他<? } ?></td>
                                <td>
                                    <? if ($v[uptime]) { ?><? echo date('Y-m-d',$v[uptime]) ?><? } ?>
                                </td>
                                <td><input style="width:100px;" type="file" value="" name="pic[]">
                                    <input type="hidden" id="old_pic[]" name="old_pic[]" value="<?=$v[pic]?>">
                                    <p><a class="jTip" id="jtip<?=$k?>" href="/admin/index.php?action=index-pic&picture=<?=$v[pic]?>">查看PC图片(1180*400)</a></p></td>
                                <td><input type="text" name="url[]" value="<?=$v[url]?>"></td>
                                <td><input type="text" name="orderby[]" size="4" value="<?=$v[orderby]?>"></td>
                                <td>
                                    <span>
                                        <a href="javascript:void(0)" class="but_del">移除</a>
                                    </span>
                                </td>
                            </tr>
                            <?}?>
                
                        </tbody>
                     
                    </table>
                        <div style="padding:6px 0px; width:98%; border-bottom: 1px solid #ccc; margin:0 auto;">
                            <span style="float: left;"><input type="button" class="sbt" onclick='add()'style=" padding:0px 4px;  color:#333;font-family:'微软雅黑';  " value="添加"/>添加文章和视频id，点击确认或直接添加内容</span>
                                    
                                    <input type="submit" class="sbt"style=" padding:0px 4px;  color:#333;font-family:'微软雅黑';  " name= 'submit2' value="提交数据"/>
                        </div>
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

            function make(i) {
                 $.get("<?=$php_self?>bannermake",{"name":i,"type":5},function(msg){
                     if(msg==1){
                         alert("生成成功");
                     }else{
                         alert("生成失败");
                     }
                 })
            }
        
            function add(){
                var html ='<tr><td><input class="id_a" type="text" value=""  name="id[]" size="4" ></td><td style="width:150px;" class="content1"><input type="text" name="title[]" value=""></td><td class="content2"></td><td class="content3"></td><td><input style="width:70px;" type="file" value="" name="pic[]"><input type="hidden" id="old_pic[]" name="old_pic[]" value=""><p><a class="jTip" id="jtip<?=$i?>" href="/admin/index.php?action=index-pic&picture=">查看PC图片(1180*400)</a></p></td><td><input type="text" name="url[]" value=""></td><td><input type="text" name="orderby[]" size="4" value=""></td><td><span><input type="button" value="确认" class="but_check"><a href="javascript:void(0)" class="but_del">移除</a></span></td></tr>';
                $("#tobdy").append(html);
            }
          
        </script>  
    </body>
</html>
