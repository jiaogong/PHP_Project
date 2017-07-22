<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
        <div class="user-add">
            <div class="nav">
                <ul>
                    <li><a href="<?=$php_self?>">标签列表</a></li>
                    <li><a href="<?=$php_self?>add">新增标签</a></li>
                    <li ><a href="<?=$php_self?>tagtag" class="song">导出/导入标签</a></li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-add-con">
                <div style=" padding:0 10px;">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="right" align="center"><a href="index.php?action=tag-tagexce" onclick="return confirm('确定导出全部标签到表格')">导出全部标签库</a></td>
                                <td></td>
                            </tr>
                            <tr>
                                <form enctype="multipart/form-data" method="POST" action="index.php?action=tag-tagexport">
                                    <td class="right" style=" border:none;" >导入标签：</td>
                                    <td class="margin46" style="border:none;">
                                        <input type="file" name="csv"/>
                                        <button type=" submit" name="add">提交</button>
                                    </td>
                                </form>
                            </tr>
                        </table> 
                </div>  
            </div>
        </div>  
        <script type="text/javascript">

            $('#tag_btn').click(function () {
                if ($('#tag_name').val() == '') {
                    alert('标签名称为必填项!');
                    return false;
                }
                if ($('#pinyin').val() == '') {
                    alert('标签名全拼为必填项!');
                    return false;
                }
                $('#tag_btn').attr("disabled", "value");
                $('#tag_form').submit();
            });

            $().ready(function () {
                $('#btn_checktitle').click(function () {
                    if ($.trim($('#tag_name').val()) == '') {
                        alert('标签名称不能为空！');
                        $('#tag_name').focus();
                        return false;
                    }
                    $.blockUI({
                        message: "<h1><p>标签名称检查中，请稍等...</p></h1>"
                    });
                    $.post("<?=$php_self?>rtitle", {tag_name: $('#tag_name').val()}, function (ret) {
                        if ($.trim(ret) != 1) {
                            alert('标签名称可用，没有重复！')
                        } else {
                            alert('已经有相同标签存在！')
                        }
                        $.unblockUI();
                    });
                });
            })
        </script>
    </body>
</html>
