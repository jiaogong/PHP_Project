<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
        <div class="user-add">
            <div class="nav">
                <ul>
                    <li><a href="<?=$php_self?>wordslist">敏感词列表</a></li>
                    <li><a href="<?=$php_self?>wordsadd" class="song">新增敏感词</a></li>
                    <li><a href="<?=$php_self?>wordstxt">导出/导入敏感词库</a></li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-add-con">
                <div style=" padding:0 10px;">
                   <form name="tag_form" id="tag_form" action="index.php?action=review-wordsadd" method="post" enctype="multipart/form-data">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="right" >敏感词：</td>
                                <td class="margin46">
                                    <input type="text" name="minganci" id="minganci" size="40" value="<?=$val?>"/>
                                    <input type="button" name="btn_checktitle" id="btn_checktitle" value="检查敏感词是否重复">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center" >
                                    <button type=" submit" name="add">提交</button> 
                                    <button type=" reset" name="add">重填</button> 
                                </td>
                            </tr>
                        </table> 
                    </form>
                </div>  
            </div>
        </div>  
        <script type="text/javascript">

            $('#tag_btn').click(function () {
                if ($('#minganci').val() == '') {
                    alert('敏感词为必填项!');
                    return false;
                }
                $('#tag_btn').attr("disabled", "value");
                $('#tag_form').submit();
            });

            $().ready(function () {
                $('#btn_checktitle').click(function () {
                    if ($.trim($('#minganci').val()) == '') {
                        alert('敏感词不能为空！');
                        $('#minganci').focus();
                        return false;
                    }
                    $.blockUI({
                        message: "<h1><p>敏感词检查中，请稍等...</p></h1>"
                    });
                    $.post("<?=$php_self?>rtitle", {minganci: $('#minganci').val()}, function (ret) {
                        if ($.trim(ret) != 1) {
                            alert('敏感词可用，没有重复！')
                        } else {
                            alert('已经有相同敏感词存在！')
                        }
                        $.unblockUI();
                    });
                });
            })
        </script>
    </body>
</html>
