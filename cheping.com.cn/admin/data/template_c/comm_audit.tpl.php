<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#isall").click(function(){
            $("#content input:checkbox").attr("checked", $(this).attr("checked"));
        });
        $("#content select").change(function(){
            var id=$(this).parents("tr").children("td").eq(1).html();
            var name=$(this).parents("tr").children("td").eq(2).children('span').html();
            var statetxt=$(this).children("option:selected").html();
            if(confirm("你确定要将 “"+$.trim(name)+"” 修改为 “"+$.trim(statetxt)+"” 状态!!")){
                if(id&&$(this).val()){
                    $.ajax({
                        type:"POST",
                        url:"<?=$php_self?>updtestate",
                        data:{id:id, state:$(this).val(),t:"<?=$t?>"},
                        error:function(){
                            alert("网络异常，请求失败！！");
                        },
                        success:function(date){
                           var color=eval("("+date+")"); 
                            if(color){
                                $("#"+id).attr("color", color);
                            }else{
                                alert("修改失败!!请联系管理员");
                            }
                        }
                    })
                }else{
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
        <ul id="nav">
        <? foreach((array)$type as $key=>$value) {?>
        <li><a href="<?=$php_self?>&t=<?=$key?>" class="<? if ($key==$t&&$t=='brand') { ?>li1<? } elseif($key==$t) { ?>song<? } ?>"><?=$value?></a></li>
        <?}?>
    </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
            <form id="brand" action="<?=$php_self?>&t=<?=$t?>" method="post">
                <table class="table2" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <th><h2 style="color:blue;"><? echo $type[$t]  ?></h2></th>
                    </tr>
                    <tr>
                        <td>
                            <select style="width:120px;" id="state" name="state" onchange="javascript:document.getElementById('brand').submit();">
                                <option value="">请选择状态</option>
                                <? foreach((array)$state as $k=>$v) {?>
                                <option <? if ($k==$s&&isset($s)) { ?>selected="true"<? } ?> value="<?=$k?>"><?=$v?></option>
                                <?}?>
                            </select>
                            <!--<input type="hidden" id="state" name="state" value="">-->
                            编号(ID)搜索:
                            <input size="12" name="<?=$t?>_id" id="<?=$t?>_id" value="<? if ($id) { ?><?=$id?><? } ?>" />
                            名称
                            <input size="12" name="keyword" id="keyword" value="<?=$keyword?>">
                            <input type="submit" name="search" value=" 搜 索 ">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
            <form id="form_all" action="<?=$php_self?>updteallstate&t=<?=$t?>&page=<?=$page?>" method="post">
            <table id="content" class="table2" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th width="5%"></th>
                    <th width="15%">编号(ID)</th>
                    <th width="40%">名称</th>
                    <th width="20%">添加日期</th>
                    <th width="20%">操作</th>
                </tr>
                <? foreach((array)$list as $key=>$value) {?>
                <tr>
                    <td><input type="checkbox" name="id[]" value="<?=$value['id']?>" /></td>
                    <td><?=$value["id"]?>
                    </td>
                    <td><span><?=$value["name"]?></span>
                    <? if ($t=='series') { ?>
                        <a href="index.php?action=series-edit&series_id=<?=$value['id']?>&fatherId=">修改</a>
                    <? } ?>
                    
                    <? if ($t == 'model') { ?>
                      <? if ($value['id'] == $value['last_picid']) { ?>
                      <font color="green"><b>√</b></font>
                      <? } ?>
                    <? } ?>
                    </td>
                    <td><?=$value["date"]?></td>
                    <td>
                        <select style="width:80px;">
                            <? foreach((array)$state as $k=>$v) {?>
                            <option <? if ($k==$value["state"]) { ?>selected="true"<? } ?> value="<?=$k?>"><?=$v?></option>
                            <?}?>
                        </select>
                        <font id="<?=$value['id']?>" color="<? echo $color[$value['state']] ?>">■</font>
                    </td>
                </tr>
                <?}?>    
            </table>
            <table class="table2" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th width="10%"><input type="checkbox" id="isall"/>&nbsp;全选</th>
                    <th width="30%">
                        <select style="width:120px;"  name="state">
                            <option value="">请选择</option>
                            <? foreach((array)$state as $k=>$v) {?>
                            <option value="<?=$k?>"><?=$v?></option>
                            <?}?>
                        </select>
                        <input type="hidden" name="oldstate" value="<? if (isset($s)) { ?><?=$s?><? } else { ?><? } ?>" />
                        <input type="hidden" name="keyword" value="<?=$keyword?>" />
                        <input type="submit" id="updatebtn" name="update" value=" 修 改 ">
                    </th>
                    <th width="60%"  class="page_bar_css">
                    </th>
                </tr>
            </table>
            <? if ($page_bar) { ?>
            <div class="ep-pages">
            <?=$page_bar?>
            </div>
            <? } ?>
         </form>
        </div>
    </div>
</div>
</body>
</html>
