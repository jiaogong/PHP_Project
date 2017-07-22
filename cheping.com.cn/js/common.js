/**
* common js lib
* @author David.Shaw
*/
/**
* global function js
* @copyright by tobingo.com
* @author David.Shaw
* $Id: common.js 1005 2015-10-23 04:54:04Z caolin $
*/

$().ready(function(){
  /**
  * 车系及车款列表关联图片功能
  */
  $('.unionpic').live('click', function(){
    $.blockUI({
      overlayCSS: {
        backgroundColor: '#888' 
      },
      css: { 
            border: 'none', 
            padding: '15px', 
            width: '350px',
            /*backgroundColor: '#000', */
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px',
            /*opacity: .8, */
            color: '#000'  
        }, 
      /*theme:     true, 
      title:    '图片关联中', */
      message:  '<h2><p><img src="images/loading.gif" style="vertical-align:middle"/> 正在关联图片，请稍等...</p></h2>'
    });
    $.get($(this).attr('tourl'), function(ret){
      if($.trim(ret) == "1"){
        $('.blockMsg h2 p').html('图片关联成功！');
        //alert('图片关联成功！');
      }else{
        $('.blockMsg h2 p').html('图片关联失败！');
        //alert('图片关联失败！');
      }
      setTimeout($.unblockUI, 2000); 
      //$.unblockUI();
    });
    
  });
  
  $('.convtxt').live('click', function(){
    $.blockUI({
      overlayCSS: {
        backgroundColor: '#888' 
      },
      css: { 
            border: 'none', 
            padding: '15px', 
            width: '350px',
            /*backgroundColor: '#000', */
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px',
            /*opacity: .8, */
            color: '#000'  
        }, 
      /*theme:     true, 
      title:    '图片关联中', */
      message:  '<h2><p><img src="images/loading.gif" style="vertical-align:middle"/> 正在导入文本参数，请稍等...</p></h2>'
    });
    var obj = $(this);
    $.get(obj.attr('tourl'), function(ret){
      if($.trim(ret) == 1){
        $('.blockMsg h2 p').html('文本参数导入成功！');
        obj.html('<font color="red">已导文本参数</a>').attr({href:'javascript:void(0);','tourl':''}).removeClass('convtxt');
        //alert('图片关联成功！');
      }else{
        $('.blockMsg h2 p').html('文本参数导入失败！');
        //alert('图片关联失败！');
      }
      setTimeout($.unblockUI, 2000); 
      //$.unblockUI();
    });
    
  });
  
})