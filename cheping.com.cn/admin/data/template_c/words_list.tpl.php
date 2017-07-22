<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
        <div class="user-add">
            <div class="nav">
                <ul>
                    <li ><a href="<?=$php_self?>wordslist" class="song">敏感词列表</a></li>
                    <li><a href="<?=$php_self?>wordsadd">新增敏感词</a></li>
                    <li><a href="<?=$php_self?>wordstxt">导出/导入敏感词库</a></li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-add-con">
                <div style=" padding:0 10px;">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td colspan="2" align="center"><h1>敏感词库</h1></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><textarea rows="20" cols="100%" disabled><?=$array['badwords']?></textarea></td>
                        </tr>
                    </table> 
                </div>  
            </div>
        </div>  
        <script type="text/javascript">
            $().ready(function () {
                $('.click_pop_dialog').live('click', function () {
                    pop_window($(this), {message: '您确定要删除该标签吗？', pos: [200, 150]});
                });
            });
        </script>  

        <script language="javascript" type="text/javascript">
        //全选
            function SelectAllCheckboxes(spanChk)
            {
                var xState = spanChk.checked;
                //alert(xState);

                elm = spanChk.form.elements;
                //alert(elm.length);
                for (i = 0; i < elm.length - 1; i++)
                {
                    if (elm[i].type == "checkbox" && elm[i].id != spanChk.id)
                    {

                        if (elm[i].checked != xState)
                            elm[i].click();
                    }

                }
            }
        </script>
    </body>
</html>
