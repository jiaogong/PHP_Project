<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<script>
    function submit_form(){
        if($.trim($("#silian").val())==""){
            alert("请选择上传文件后，再提交!");
            return false;
        }
    }
</script>
<div class="navs">
    <ul class="nav">
        <li><a class="song" href="<?=$php_self?>">百度死链接文件生成</a></li>
    </ul>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user-table">
            <form method="post" action="<?=$php_self?>makesilianxml" onsubmit="return submit_form();" enctype="multipart/form-data">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="150" align="right" height="50">死链接文件：</td>
                        <td align="left">
                            <input type="file" id="silian" name="silian" value="" size="60"  style="margin-bottom:5px;"/>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" align="right" height="50">文件处理方式：</td>
                        <td align="left">
                            <input type="radio" name='writemode' id="writemode" value="0">覆盖原文件
                            <input type="radio" name='writemode' id="writemode" value="1" checked="checked">添加到原文件尾
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value="提交" name="add_edit_btn">
                        </td>
                    </tr>
                    <tr>
                        <td align="right">死链接文件说明：</td>
                        <td align="left">
                            文件编码：GBK（Windows系统下为ANSI）<br>
                            文件类型：TXT文本文件<br>
                            文件内容格式：每行一条链接，多链接以多行形式书写<br>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<? include $this->gettpl('footer');?> 