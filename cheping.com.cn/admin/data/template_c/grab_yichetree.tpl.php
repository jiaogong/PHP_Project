<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
    <div class="nav">
        <ul id="nav">
            <li><a href="index.php?action=grabyiche">抓易车商城</a></li>
            <li><a href="index.php?action=grabyiche-yichetree" class="song">抓易车产品数据</a></li>
            <li><a href="index.php?action=grabyiche-brand">易车品牌管理</a></li>
            <li><a href="index.php?action=grabyiche-factory">易车厂商管理</a></li>
            <li><a href="index.php?action=grabyiche-series">易车车系管理</a></li>
            <li><a href="index.php?action=grabyiche-model">易车车款管理</a></li>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
            <table class="table2" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        易车品牌/车系链接
                        <input type="text" name="yiche_url" id="yiche_url" style="width: 500px" value="">
                        <input type="button" name="bn" id="bn" value="开始抓取">
                        <br><div style="text-align: left; padding-left: 124px;">例：http://car.bitauto.com/tree_chexing/</div>
                    </td>
                </tr>
            </table>
            <table class="table2" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;word-wrap: break-word;">
                <tr align="right"  class='th'>
                    <td>
                        <iframe frameborder="1" id="grab_result" width="700" height="350" src="" scrolling="yes" frameborder="0"></iframe>
                    </td>
                </tr>
<!--                <tr>
                    <td>
                        <a href='?action=yicheprice-export' target="_blank">表格下载</a>
                    </td>
                </tr>-->
            </table>
            <div style="height:40px;"></div>
        </div>
        <div class="user_con2">
            <img src="<?=$admin_path?>images/conbt.gif" height="16" >
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#bn').click(function() {
        var yiche_url = $('#yiche_url').val();
        if (yiche_url == '') {
            alert('商城链接不能为空！');
            return false;
        }
        $(this).attr({disabled:true});
        var grab_url = "?action=grabyiche-grabtree&url="+escape(yiche_url);
        $('#grab_result').attr({src: grab_url});
    })
</script>
<? include $this->gettpl('footer');?>
