<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
<div class="user">
    <div class="nav">
        <ul>
            <li><a href="<?=$php_self?>SearchList" class="song">热门关键词</a></li> 
        </ul>
    </div>
    <div class="clear"></div>
    <div class="user-con">
        <div class="user-table">
            <form action="" method="post" enctype="multipart/form-data">
                <table border="0" cellspacing="0" cellpadding="0">

                    <tr>
                        <td style=" padding-top:20px;">ID</td>
                        <td style=" padding-top:20px;">标题</td>
                        <td style=" padding-top:20px;">排序</td>
                        <td style=" padding-top:20px;">操作</td>
                    </tr>



                    <tbody id="tobdy">
                        <? foreach((array)$list as $k=>$v) {?>
                        <tr><td style="width:30px;"><input type="text" name="id[]" value="<?=$v[id]?>"></td>
                            <td style="width:150px;"><input type="text" name="title[]" value="<?=$v[title]?>"></td>
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
                    <span style="float: left;"><input type="button" class="sbt" onclick='add()'style=" padding:0px 4px;  color:#333;font-family:'微软雅黑';  " value="添加"/></span>

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
        $(".but_del").live('click', function(){
            $(this).parent().parent().parent("tr").remove();
        })
        
    });
    function add(){
        var html = '<tr><td style="width:150px;" class="content1"><input type="text" name="id[]" value=""></td><td style="width:150px;" class="content1"><input type="text" name="title[]" value=""></td><td><input type="text" name="orderby[]" size="4" value=""></td><td><span><input type="submit" class="sbt" name="submit" value="确定"/><a href="javascript:void(0)" class="but_del">移除</a></span></td></tr>';
        $("#tobdy").append(html);
    }
          
</script>  
</body>
</html>
