<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
        <div class="user">
            <div class="nav">
                <ul>
                    <li><a href="<?=$php_self?>guangzhoubanner">广州车展轮播图</a></li>
                    <li><a href="<?=$php_self?>guangzhouheadline"  class="song">车展头条+热门文章</a></li>
                    <!--<li><a href="<?=$php_self?>guangzhouhotarticle">车展热门文章</a></li>--> 
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-con">
                <div class="user-table">
                    <form action="" method="post">
                         <div style="padding:6px 0px; width:98%; border-bottom: 1px solid #ccc; margin:0 auto;">
                            <span style="float: left;margin-left:200px"><input type="button" class="sbt" onclick='add()'style=" padding:0px 8px;padding-right:20px;  color:#333;font-family:'微软雅黑';  " value="添加"/>添加新的内容</span>
                                    
                                    <!--<input type="button" class="sbt"style=" padding:0px 4px; margin-left:100px; color:#333;font-family:'微软雅黑';  " onclick="make('banner_index')" value="生成"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                                    <span style="margin-left:120px;"></span>
                                    <input type="submit" class="sbt"style=" padding:0px 4px;  color:#333;font-family:'微软雅黑';  " name= 'submit2' value="提交数据"/>
                        </div>
                    <table border="0" cellspacing="0" cellpadding="0">

                        <tr>
                            <td style=" padding-top:20px;">标题</td>
                            <td style=" padding-top:20px;">路径</td>
                            <!--<td style=" padding-top:20px;">修改时间</td>-->
                            <td style=" padding-top:20px;display:none;">排序</td>
                            <td style=" padding-top:20px;">设置</td>
                            <td style=" padding-top:20px;">操作</td>
                        </tr>



                        <tbody id="tobdy">
                            <? foreach((array)$list as $k=>$v) {?>
                            <tr>
                                <td style="display:none"><input type='text' class="id_a" value="<?=$v[id]?>" id="<?=$v[id]?>" name="id[]" size="4" ></td>
                                <td style="width:35%;"><input style="width:250px;" type="text" class="title" name="title[]" value="<?=$v[title]?>" ></td>
                                <td style="width:30%;"><input style="width:180px;" type="text" class="url" name="url[]" value="<?=$v[url]?>"></td>
                                <!--<td><? if ($v[uptime_old]) { ?><? echo date('Y-m-d',$v[uptime]) ?><? } ?></td>-->
                                <td style="display:none;"><input type="text" name="orderby[]" class="sort_article"  placeholder="默认" style="width:50px;text-align:center;" size="4" value="<?=$v[orderby]?>"></td>
                               <td><? if ($v[state]==0) { ?><input type="button" class="but_headline_in" value="设为头条"/><input class="headline_state" type="hidden" name="state[]" value="0"/><? } else { ?><div class="but_headline_out" style="padding:3px 10px;border:1px solid #ddd;width:50px;border-radius:8px;margin:0px auto;">取消头条</div><input  class="headline_state" type="hidden" name="state[]" value="1"/><? } ?></td>
                               <td style="width:10%;">
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
            var state_headline_num=1;
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
                 $('.headline_state').each(function(){
                       if($(this).val()==1){
                           state_headline_num++;
                           
                       }
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
                var html ='<tr><td style="display:none"><input class="id_a" type="text" value=""  name="id[]" size="4" ></td><td style="width:35%;"><input style="width:250px;"  type="text" name="title[]" value=""></td><td style="width:30%;"><input style="width:180px;" type="text" name="url[]" value=""></td><td style="display:none;"><input type="text"  style="width:50px;text-align:center;" name="orderby[]" size="4" value=""></td><td class="headline_add_td"><input class="headline_add" onclick="headline_add()" type="button" value="设为头条"/><input type="hidden" name="state[]" value="0"/></td><td style="width:10%;"><span><a href="javascript:void(0)" class="but_del">移除</a></span></td></tr>';
                $("#tobdy").prepend(html);
            }
            
          $('.but_headline_in').click(function(){
            if(state_headline_num>1){
                alert('你只能设置一条“头条”\n');
            }else{
                state_headline_num++;
                $(this).parents('td').empty().html('<div class="but_headline_out" style="padding:3px 10px;border:1px solid #ddd;width:50px;border-radius:8px;margin:0px auto;cursor:pointer;">取消头条</div><input type="hidden" name="state[]" value="1"/>');
            }
        })
          $('.but_headline_out').click(function(){
            if(state_headline_num<1){
                alert('你至少设置一条“头条”\n');
            }else{
                state_headline_num--;
                $(this).parents('td').empty().html('<input type="button" onclick="headline_add2()" class="but_headline_in" value="设为头条"/><input type="hidden" name="state[]" value="0"/>');
            }
             
          })
          function headline_add(){
              num=0;
              $('.headline_add_td').each(function(){
                  num++;
              })
              if(num>1){
                  return false;
              }
              if(state_headline_num<=1){
                $('.headline_add_td').empty().html('<div class="but_headline_out" style="padding:3px 10px;border:1px solid #ddd;width:50px;border-radius:8px;margin:0px auto;cursor:pointer;">取消头条</div><input type="hidden" name="state[]" value="1"/>')
                state_headline_num++;
              }else{
                  alert('你只能设置一条“头条”\n');
              }
        }
        function headline_add2(){
            alert('请先提交上一次操作的数据\n');
        }
        </script>  
    </body>
</html>
