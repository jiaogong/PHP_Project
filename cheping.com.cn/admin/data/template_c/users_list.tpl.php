<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
        <script type="text/javascript">
                            $(document).ready(function(){
                    $("#isall").click(function(){
                    $("#content input:checkbox").attr("checked", $(this).attr("checked"));
                    });
                            $("#cont e nt select").change(function(){
                    var id = $(this).parents("tr").children("td").eq(1).html();
                            var name = $(this).parents("tr").children("td").eq(2).html();
                            var statetxt = $(this).children("option:se l ecte d ").html ();
                            if (confirm("你确定要将 " + name + " 修改为 " + statetxt + " 状态!!")){
                    if (id && $(this).val()){
                    $.ajax({
                    type:"POST",
                            url:"<?=$php_self?>updtestate",
                            data:{id:id, state:$(this).val()},
                            error:function(){
                            alert("网络异常，请求失败！！");
                            },
                            success:function(date){
                            var color = eval("(" + date + ")");
                                    if (color){
                            $("#" + id).attr("color", color);
                            } else{
                            alert("修改失败!!请联系管理员");
                            }
                            }
                    })
                    } else{
                    alert("非法操作!!");
                           return false;
                            }
                        }else{
                            return false;
                        }
                    });

                $("#updatebtn").click(function(){
                    var length=$("#content input:checkbox:checked").size();
                    var state=$(this).siblings("select").val();
                    if(length<1){
                        alert("请选择你要修改数据!");
                        return false;
                    }
                    if(state==""){
                        alert("请选择你要修改的状态!");
                        return false;
                    }
                    $("#form_all").submit();
                    //return false;
                });

                })
        </script>
        <div class="user">
            <div class="nav">
                <ul>
                    <li ><a href="<?=$php_self?>" class="song">注册用户列表</a></li>
                    <li><a href="<?=$php_self?>add">添加用户</a></li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-con">
                <div class="user-table">
                    <form id="brand" action="<?=$php_self?>" method="post">
                        <table class="table2" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <select style="width:120px;" id="state" name="state">
                                            <option value="">请选择状态</option>
                                            <? foreach((array)$state as $k=>$v) {?>
                                            <option <? if ($k==$s&&isset($s)) { ?>selected="true"<? } ?> value="<?=$k?>"><?=$v?></option>
                                            <?}?>
                                        </select>
                                        手机号<input size="10" name="mobile" id="ex7" value="<? if ($mobile) { ?><?=$mobile?><? } ?>" />
                                        编号(ID)<input size="5" name="id" id="id" value="<? if ($id) { ?><?=$id?><? } ?>" />
                                        登录账号<input size="8" name="username" id="keyword" value="<?=$username?>"/>
                                        <input type="submit" name="search" value=" 搜 索 "/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                    <form id="form_all" action="<?=$php_self?>updteallstate&page=<?=$page?>" method="post">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td style=" padding-top:20px;">编号(ID)</td>
                                <td style=" padding-top:20px;">登录账号</td>
                                <td style=" padding-top:20px;">邮箱</td>
                                <td style=" padding-top:20px;">手机号</td>
                                <td style=" padding-top:20px;">注册日期</td>
                                <td style=" padding-top:20px;">操作</td>
                            </tr>

                            <tbody>
                                <? foreach((array)$users as $key=>$value) {?>
                                <tr>
                                    <td><input type="checkbox" name="id[]" value="<?=$value['id']?>" /> <?=$value['id']?></td>
                                    <td><?=$value["username"]?></td>
                                    <td><?=$value["email"]?></td>
                                    <td><?=$value["mobile"]?></td>
                                    <td><? if ($value["created"]) { ?><? echo date("Y-m-d H:i",$value["created"]); ?><? } ?></td>
                                    <td>
                                        <select style="width:80px;">
                                            <? foreach((array)$state as $k=>$v) {?>
                                            <option <? if ($k==$value["state"]) { ?>selected="true"<? } ?> value="<?=$k?>"><?=$v?></option>
                                            <?}?>
                                        </select>
                                        <font id="<?=$value['id']?>" color="<? echo $color[$value['state']] ?>">■</font>
                                        <span><i style=" padding-top:3px;"><img src="images/bi.png" /></i>
                                            <a href="<?=$php_self?>add&id=<?=$value['id']?>">修改信息</a>&nbsp;&nbsp;
                                            <a href="<?=$php_self?>del&id=<?=$value['id']?>">删除信息</a>
                                        </span>
                                    </td>
                                </tr>
                                <?}?>
                                <tr>
                                    <td colspan="1">
                                        <input type="checkbox" id="isall" style="vertical-align: middle"/> 全选
                                    </td>
                                    <td colspan="1">
                                        <select style="width:80px;"  name="state">
                                            <option value="">请选择</option>
                                            <? foreach((array)$state as $k=>$v) {?>
                                            <option value="<?=$k?>"><?=$v?></option>
                                            <?}?>
                                        </select>
                                        <input type="submit" id="updatebtn" name="update" value=" 修 改 "> <input type="submit" id="updatebtn" name="dels" value="批量删除"/>
                                    </td>
                                    <td colspan="4"></td>
                                </tr>
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
    </body>
</html>
