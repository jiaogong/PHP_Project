<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
        <div class="user">
            <div class="nav">
                <ul>
                    <li><a href="<?=$php_self?>bannerindex">首页轮播图</a></li> 
                    <li><a href="<?=$php_self?>bannernews">新闻轮播图</a></li> 
                    <li><a href="<?=$php_self?>bannerpingce">评测轮播图</a></li> 
                    <li><a href="<?=$php_self?>bannervideo">视频轮播图</a></li> 
                    <li><a href="<?=$php_self?>bannerwenhua" class="song">文化轮播图</a></li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-con">
                <div class="user-table">
                    <form action="" method="post" enctype="multipart/form-data">
                         <div style="padding:6px 0px; width:98%; border-bottom: 1px solid #ccc; margin:0 auto;">
                            <span style="float: left;margin-left:200px"><input type="button" class="sbt" onclick='add()'style=" padding:0px 4px;  color:#333;font-family:'微软雅黑';  " value="添加"/>添加文章和视频id，点击确认或直接添加内容</span>
                                    
                                    <input type="button" class="sbt"style=" padding:0px 4px; margin-left:100px; color:#333;font-family:'微软雅黑';  " onclick="make('banner_index')" value="生成"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="submit" class="sbt"style=" padding:0px 4px;  color:#333;font-family:'微软雅黑';  " name= 'submit2' value="提交数据"/>
                        </div>
                    <table border="0" cellspacing="0" cellpadding="0">

                        <tr>
                            <td  style=" padding-top:20px;">ID</td>
                            <td style=" padding-top:20px;">小标题</td>
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
                                <td><input type="text" name="title3[]" value="<?=$v[title3]?>"></td>
                                <td style="width:150px;"><input type="text" name="title[]" value="<?=$v[title]?>"></td>
                                <td ><? if ($v[cname]=='article') { ?>文章<? } elseif($v[cname]=='video') { ?>视频<? } else { ?>其他<? } ?></td>
                                <td>
                                    <? if ($v[uptime]) { ?><? echo date('Y-m-d',$v[uptime]) ?><? } ?>
                                </td>
                                <td><input style="width:100px;" type="file" value="" name="pic[]">
                                    <input type="hidden" id="old_pic[]" name="old_pic[]" value="<?=$v[pic]?>">
                                    <p><a class="jTip" id="jtip<?=$k?>" href="/admin/index.php?action=index-pic&picture=<?=$v[pic]?>">查看PC图片(1180*400)</a></p></td>
                                <td><input type="text" name="url[]" value="<?=$v[url]?>"></td>
                               <td><input type="text" name="orderby[]" class="sort_article"  placeholder="默认" style="width:50px;text-align:center;" size="4" value="<?=$v[orderby]?>"></td>
                                <td>
                                    <span>
                                        <a href="javascript:void(0)" class="but_del">移除</a>
                                    </span>
                                </td>
                            </tr>
                            <?}?>
                
                        </tbody>
                     
                    </table>
                        
                    </form>
                </div>
                <div>
                    <div class="ep-pages">
                        <?=$page_bar?>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?=$admin_path?>js/jquery.dragsort-0.4.min.js"></script>
        <script type="text/javascript">
               //拖拽排序
            var sortNumOld;
            $(document).ready(function(){
                  $("#tobdy").dragsort({ itemSelector: "tr", dragSelector: "tr", dragBetween: true,dragEnd: saveOrder1, placeHolderTemplate: "<tr></tr>" });
                  sortNumOld = $(".sort_article").map(function() { return $(this).val(); }).get();  
            })
            function saveOrder1() {    
                for(var i=0;i<sortNumOld.length;i++){
                    $(".sort_article").eq(i).val(i+1);
                }
            }; 
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
                var html ='<tr><td><input class="id_a" type="text" value=""  name="id[]" size="4" ></td> <td><input type="text" name="title3[]" value=""></td><td style="width:150px;" class="content1"><input type="text" name="title[]" value=""></td><td class="content2"></td><td class="content3"></td><td><input style="width:70px;" type="file" value="" name="pic[]"><input type="hidden" id="old_pic[]" name="old_pic[]" value=""><p><a class="jTip" id="jtip<?=$i?>" href="/admin/index.php?action=index-pic&picture=">查看PC图片(1180*400)</a></p></td><td><input type="text" name="url[]" value=""></td><td><input type="text" name="orderby[]" size="4" value=""></td><td><span><input type="button" value="确认" class="but_check"><a href="javascript:void(0)" class="but_del">移除</a></span></td></tr>';
                $("#tobdy").prepend(html);
            }
          
        </script>  
    </body>
</html>
