function sendMsg(msg) {
    $('.xzdsj_tk').css('display','block');
    $("#popMask").show();
    //刷新验证码
    $('#update_code').live('click', function() {
        var img_code=document.getElementById("img_code");
        img_code.src = "code.php?m=" + Math.random();             
    });   
    $('#content').text(msg);
}
$(document).ready(function() {
    
      $(".apply_close").click(function(){
	   $("#wx-popup").css("display","none");
           $(".wrapGrayBg").css("display","none");
	})
        
        $(".wx").click(function(){
	   $("#wx-popup").css("display","block");
           $(".wrapGrayBg").css("display","block");
	})
    
    $(".xczx a").hover( function () {	
       // $("#span4").toggle();	
        $(this).parent().find("span").toggle();
     });
     
     $(".sq_huodong img").hover( function () {	
            //$("#span03").toggle();
            $(this).parent().find("a > span").toggle();
	});	
     
    $('.fssj').click(function() {
        var mobile = $('#mobile').val();
        var code = $('#code').val();
        var content = $('#content').text();
        $.post('offers.php?action=sendaddress', {mobile:mobile, code:code, content:content}, function(ret){
            if(ret == 1) {
                alert('短信发送成功！');                
            }
            else if(ret == 2) {
                alert('短信发送失败，请联系客服!');
            }
            else if(ret == 3){
                alert('验证码错误,请重新填写!');
            }
        });
    });
    $('#offers_button').click(function() {
        var model_id = $('#model_id').val();
        if(model_id == 0) {
            alert('请选择车款');
        }
        else {
            location.href = "offers_" + model_id + ".html";
        }
    });
    //    $('.tan_chuang').click(function(){
    //        $("#popMask").show();
    //        $(".open_window").show();
    //    })    
    $('.fwpj a, .dkzc1 a, .libao a').hover(function() {
        $(this).next('span').toggle();
    });
    //向上滚	
    var _wrap=$('.hd_con');//定义滚动区域
    var _interval=3000;//定义滚动间隙时间
    var _moving;//需要清除的动画
    var li=$('.hd_con>li').size();
    if(li>7){
        _wrap.hover(function(){
            clearInterval(_moving);//当鼠标在滚动区域中时,停止滚动
        },function(){
            _moving=setInterval(function(){
                var _field=_wrap.find('li:first');//此变量不可放置于函数起始处,li:first取值是变化的
                var _h=_field.height();//取得每次滚动高度
                _field.animate({
                    marginTop:-_h+'px'
                    },600,function(){//通过取负margin值,隐藏第一行
                    _field.css('marginTop',0).appendTo(_wrap);//隐藏后,将该行的margin值置零,并插入到最后,实现无缝滚动
                })
            },_interval)//滚动间隔时间取决于_interval
        }).trigger('mouseleave');//函数载入时,模拟执行mouseleave,即自动滚动
    }else{
        clearInterval(_moving);
    }

	$(".ckxx2,.ckxx3,.ckxx4").hover(function(){
		$(this).find("span").toggle();
	});

	$(".biaoge > a").hover(function(){
		$(this).find("div").toggle();
	});
	$(".span_img").hover(function(){
		$(this).next("div").toggle();
	});
});