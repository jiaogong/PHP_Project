<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<table>
    <tr>
        <td colspan=2 align=left style="font-size: 9pt">
            <a href="javascript:void(0);" onclick="javascript:reloadLeft();" id="reloadleft">刷新树</a> 
            <a href="javascript:void(0);" onclick="javascript:toggleLeft();" id="toggleleft">隐藏树</a>
            <!--<a href="javascript:void(0);" onclick="javascript:changeWH(100);" id="toggleleft">测试高度</a>-->
        </td>
    </tr>	
    <tr>
        <td width="100">
            <iframe id="frm_left" src="?action=tree-treeleft" height="500" width="260" frameborder="0" scrolling="auto"></iframe>	
        </td>
        <td valign="top">
            <iframe id="frm_right" src="?action=tree-blank" frameborder="0" scrolling="auto"></iframe>	
        </td>
    </tr>
</table> 
<script>
    $(document).ready(function(){
        $(window).resize(function(){
            changeWH(100);
        })
    });
    function reloadLeft() {
        $('#frm_left').attr('src', '?action=tree-treeleft');
    }

    function toggleLeft() {
        var w = $(document).width();
        var h = $(document.body).height();
        var left_w = $('#frm_left').width();
        if (left_w > 0) {
            $('#frm_left').width(0);
            $('#frm_right').height(w);
            $('#toggleleft').text('显示树');
        } else {
            $('#frm_left').width(260);
            $('#frm_left').height(w - 400);
            $('#frm_right').height(w - 400);
            $('#toggleleft').text('隐藏树');
        }
    }

    var _h = _w = 0;
    function changeWH(i) {
        var h = $(document).height();
        var w = $(document).width();
        var left_w = $('#frm_left').width();
        var right_w = $('#frm_right').width();
        if (!_h && !_w) {
            _h = h;
            _w = w;
        }
        if (typeof i == 'undefined') {
            i = 0;
        }
        _new = w - left_w - 20;
        if (_h != h || _w != w || i) {
            $('#frm_left').height(h-5);
            $('#frm_right').height(h-5);
            $('#frm_right').width(_new);
        } else {
            //alert(_new);
        }
    }

    function setWH() {
        setInterval('changeWH()', 10);
    }
    changeWH(100);
    //setWH();
</script>    
<? include $this->gettpl('footer');?>