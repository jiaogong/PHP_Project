<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
        <div class="user">
            <div class="nav">
                <ul id="nav">
                    <li><a href="<?=$php_self?>" class="song">数据统计</a></li> 
                    <li><a href="<?=$php_self?>user" >抽奖用户</a></li> 
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-con">
                <div class="user-table">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tbody id="tobdy">
                            <tr>
                                <td>汽车音响:</td>
                            <? foreach((array)$_list['audio'] as $k=>$v) {?>
                                <td><?=$k?>(<?=$v?>)</td>
                            <?}?>
                            </tr>
                            <tr>
                                <td>车载导航:</td>
                            <? foreach((array)$_list['compass'] as $k=>$v) {?>
                                <td><?=$k?>(<?=$v?>)</td>
                            <?}?>
                            </tr>
                            <tr>
                                <td>轮胎:</td>
                            <? foreach((array)$_list['tyre'] as $k=>$v) {?>
                                <td><?=$k?>(<?=$v?>)</td>
                            <?}?>
                            </tr>
                            <tr>
                                <td>儿童安全座椅:</td>
                            <? foreach((array)$_list['seats'] as $k=>$v) {?>
                                <td><?=$k?>(<?=$v?>)</td>
                            <?}?>
                            </tr>
                            <tr>
                                <td>润滑油:</td>
                            <? foreach((array)$_list['lubricating'] as $k=>$v) {?>
                                <td><?=$k?>(<?=$v?>)</td>
                            <?}?>
                            </tr>
                            <tr>
                                <td>二手车交易服务平台:</td>
                            <? foreach((array)$_list['platform'] as $k=>$v) {?>
                                <td><?=$k?>(<?=$v?>)</td>
                            <?}?>
                            </tr>
                            <tr>
                                <td>二手车认证:</td>
                            <? foreach((array)$_list['certification'] as $k=>$v) {?>
                                <td><?=$k?>(<?=$v?>)</td>
                            <?}?>
                            </tr>
                            <tr>
                                <td>代步服务类:</td>
                            <? foreach((array)$_list['travel'] as $k=>$v) {?>
                                <td><?=$k?>(<?=$v?>)</td>
                            <?}?>
                            </tr>
                            <tr>
                                <td>租车服务类:</td>
                            <? foreach((array)$_list['rental'] as $k=>$v) {?>
                                <td><?=$k?>(<?=$v?>)</td>
                            <?}?>
                            </tr>
                            <tr>
                                <td>手机实用汽车工具:</td>
                            <? foreach((array)$_list['tools'] as $k=>$v) {?>
                                <td><?=$k?>(<?=$v?>)</td>
                            <?}?>
                            </tr>
                            <tr>
                                <td>汽车金融服务:</td>
                            <? foreach((array)$_list['fmcc'] as $k=>$v) {?>
                                <td><?=$k?>(<?=$v?>)</td>
                            <?}?>
                            </tr>
                            <tr>
                                <td>汽车保险公司:</td>
                            <? foreach((array)$_list['motors'] as $k=>$v) {?>
                                <td><?=$k?>(<?=$v?>)</td>
                            <?}?>
                            </tr>
                            <tr>
                                <td>您对上述品类感兴趣程度如何:</td>
                            <? foreach((array)$_list['interest'] as $k=>$v) {?>
                                <td><?=$k?>(<?=$v?>)</td>
                            <?}?>
                            </tr>
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
