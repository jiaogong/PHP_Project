<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
        <div class="user">
            <div class="nav">
                <ul id="nav">
                    <li><a href="<?=$php_self?>" >数据统计</a></li> 
                    <li><a href="<?=$php_self?>user" class="song">抽奖用户</a></li> 
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-con">
                <div class="user-table">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>真实姓名</td>
                            <td>邮箱</td>
                            <td>手机号</td>
                            <td>性别</td>
                            <td>出生日期</td>
                            <td>地址</td>
                            <td>邮编</td>
                            <td>身份证</td>
                            <td>操作</td>
                        </tr>
                        <tbody id="tobdy">
                            <? foreach((array)$_list as $k=>$v) {?>
                            <tr>
                                <td><?=$v[realname]?></td>
                                <td><?=$v[email]?></td>
                                <td><? if ($v[shouji]) { ?><?=$v[shouji]?><? } ?></td>
                                <td><? if ($v[gender]==1) { ?>男<? } else { ?>女<? } ?></td>
                                <td><?=$v[birthday]?></td>
                                <td><?=$v[address]?></td>
                                <td><?=$v[zipcode]?></td>
                                <td><?=$v[number]?></td>
                                <td><a href="<?=$php_self?>xiangqing&id=<?=$v[id]?>">详情</a></td>
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
                 $.get("<?=$php_self?>bannermake",{"name":i,"type":<?=$b?>},function(msg){
                     if(msg==1){
                         alert("生成成功");
                     }else{
                         alert("生成失败");
                     }
                 })
            }
        
            function add(){
                var html ='<tr><td><input class="id_a" type="text" value=""  name="id[]" size="4" ></td> <td style="width:150px;" class="content1"><input type="text" name="title[]" value=""></td><td class="content2"></td><td class="content3"></td><td><input style="width:70px;" type="file" value="" name="pic[]"><input type="hidden" id="old_pic[]" name="old_pic[]" value=""><p><a class="jTip" id="jtip<?=$i?>" href="/admin/index.php?action=index-pic&picture=">查看PC图片(1180*400)</a></p></td><td><input type="text" name="url[]" value=""></td><td><input type="text" name="orderby[]" size="4" value=""></td><td><span><input type="button" value="确认" class="but_check"><a href="javascript:void(0)" class="but_del">移除</a></span></td></tr>';
                $("#tobdy").append(html);
            }
          
        </script>  
    </body>
</html>
