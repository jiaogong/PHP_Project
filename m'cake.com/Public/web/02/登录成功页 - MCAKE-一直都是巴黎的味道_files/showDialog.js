// JavaScript Document
$(function () {


	$.Alert = function (msg) {
        try {
            $("div[class='tc-con']").remove();
            $("div[class='tc-cover']").remove();
            $cover = $("<div class='tc-cover'id='myCover'>&nbsp;</div>");
            $main = $("<div class=\"tc-con\" id='maximPanel'></div>");
            $close = $("<a href='javascript:void(0);' class='close close_2'>关闭</a>");
            $content = $("<div  class='tc-con-1'></div>");
            $content.html(msg);
            $main.append($close);
            $main.append($content);
            $(document.body).append($cover);
            $(document.body).append($main);
            $cover.height($(document.body).height());
            $main.show(400);
            $main.focus();
 
 
            /*选择磅数*/
            $("ul.change_p li").click(function(){
			    $("ul.change_p li").css({backgroundPositionY:'0'});
				$(this).css({backgroundPositionY:'-280px'});
				$(this).addClass("");
			
			});
 
			/*加入购物车，立即购买按钮经过效果*/
			$(".add_cart").hover(
			    function(){
				    $(this).val("加入购物车");
			    },
				function(){
				    $(this).val("Add to cart");
				});
			$(".buy_now").hover(
			    function(){
				    $(this).val("立即购买");
			    },
				function(){
				    $(this).val("buy now!");
				});	
 
			 //加减按钮
			$(".n_right").click(function(){  
			  var num=$(this).parent().find(".num_1");
			  var oldValue=parseInt(num.val()); //取出现在的值，并使用parseInt转为int类型数据  
			  oldValue++   //自加1  
			  num.val(oldValue)  //将增加后的值付给控件  
			  $(".n_left").removeClass("nopoint")
			  });  
			$(".n_left").click(function(){  
			   var num=$(this).parent().find(".num_1");
				  var oldValue=parseInt(num.val()); //取出现在的值，并使用parseInt转为int类型数据  
				  oldValue--   //自减1  
				 num.val(oldValue)  //将增加后的值付给控件
				 if(num.val()<2){
					 $(this).addClass("nopoint")
					 num.val(1) 
				 }
			}); 

            $close.click(function () {
                $main.hide(300);
                $main.remove();
                $cover.remove();
            });
        }
        catch (ex) { alert(ex); }

    }
	
	
	
	$.Alert_Address = function (msg) {
        try {
            $("div[class='tc-con tc-con-b-1']").remove();
            $("div[class='tc-cover']").remove();
            $cover = $("<div class='tc-cover'id='myCover'>&nbsp;</div>");
            $main = $("<div class=\"tc-con tc-con-b-1\" id='maximPanel'></div>");
            $close = $("<a href='javascript:void(0);' class='close close_2'>关闭</a>");
            $content = $("<div  class='tc-con-1'></div>");
            $content.html(msg);
            $main.append($close);
            $main.append($content);
            $(document.body).append($cover);
            $(document.body).append($main);
            $cover.height($(document.body).height());
            $main.show(400);
            $main.focus();

            $("select").selectCss(); 
		   //注册登录用户中心文本框聚焦
		   $(".input_t").each(function(){
			 var thisVal=$(this).val();
			 //判断文本框的值是否为空，有值的情况就隐藏提示语，没有值就显示
			 if(thisVal!=""){
			   $(this).siblings("label").find("font").hide();
			  }else{
			   $(this).siblings("label").find("font").show();
			  }
			 //聚焦型输入框验证 
			 $(this).focus(function(){
			   $(this).siblings("label").find("font").hide();
			  }).blur(function(){
				var val=$(this).val();
				if(val!=""){
				 $(this).siblings("label").find("font").hide();
				}else{
				 $(this).siblings("label").find("font").show();
				} 
			  });
			})
			
			$(".newAddress").click(function(){
			    $main.hide(300);
                $main.remove();
                $cover.remove();
			   var row
				row="<ul class='Remote_payment Cash_coupon'>"
				row=row+"<li><span style='display:block;text-align:center'>您己更换收货地址<br>请重新确认订单信息用</span></li>"
				row=row+"<li class='coupon_btn'><input type='button' value='确认'  class='login_btn confirm'/> </li>"
				row=row+"</ul>" 
				$.Alert_small(row)	
			});
			
            $(".close_btn").click(function () {
                $main.hide(300);
                $main.remove();
                $cover.remove();
            });

            $close.click(function () {
                $main.hide(300);
                $main.remove();
                $cover.remove();
            });
        }
        catch (ex) { alert(ex); }

    }
	
	
	$.Alert_small = function (msg) {
        try {
            $("div[class='tc-con tc-con-b-5']").remove();
            $("div[class='tc-cover']").remove();
            $cover = $("<div class='tc-cover'id='myCover'>&nbsp;</div>");
            $main = $("<div class=\"tc-con tc-con-b-5\" id='maximPanel'></div>");
            $close = $("<a href='javascript:void(0);' class='close close_2'>关闭</a>");
            $content = $("<div  class='tc-con-1'></div>");
            $content.html(msg);
            $main.append($close);
            $main.append($content);
            $(document.body).append($cover);
            $(document.body).append($main);
            $cover.height($(document.body).height());
            $main.show(400);
            $main.focus();

            $(".close_btn,.confirm_btn").click(function () {
                $main.hide(300);
                $main.remove();
                $cover.remove();
            });
			
            $close.click(function () {
                $main.hide(300);
                $main.remove();
                $cover.remove();
            });
        }
        catch (ex) { alert(ex); }

    }

	
	

	$.Alert_pickedup = function (msg) {
        try {
            $("div[class='tc-con tc-con-b-2']").remove();
            $("div[class='tc-cover']").remove();
            $cover = $("<div class='tc-cover'id='myCover'>&nbsp;</div>");
            $main = $("<div class=\"tc-con tc-con-b-2\" id='maximPanel'></div>");
            $close = $("<a href='javascript:void(0);' class='close close_2'>关闭</a>");
            $content = $("<div  class='tc-con-1'></div>");
            $content.html(msg);
            $main.append($close);
            $main.append($content);
            $(document.body).append($cover);
            $(document.body).append($main);
            $cover.height($(document.body).height());
            $main.show(400);
            $main.focus();
		   //注册登录用户中心文本框聚焦
		   $(".input_t").each(function(){
			 var thisVal=$(this).val();
			 //判断文本框的值是否为空，有值的情况就隐藏提示语，没有值就显示
			 if(thisVal!=""){
			   $(this).siblings("label").find("font").hide();
			  }else{
			   $(this).siblings("label").find("font").show();
			  }
			 //聚焦型输入框验证 
			 $(this).focus(function(){
			   $(this).siblings("label").find("font").hide();
			  }).blur(function(){
				var val=$(this).val();
				if(val!=""){
				 $(this).siblings("label").find("font").hide();
				}else{
				 $(this).siblings("label").find("font").show();
				} 
			  });
			})

		$("li.picke em").click(function(){
			  $("li.picke em").animate({backgroundPositionY:'0px'},1)  
			  $("li.picke input[type='checkbox']").attr("checked",false);
			  for(i=0;i<8;i++){  
			  $(this).animate({backgroundPositionY:'-=35px'},1);
			  }
			  $(this).siblings("input[type='checkbox']").attr("checked",true) ;
		});

            $(".close_btn").click(function () {
                $main.hide(300);
                $main.remove();
                $cover.remove();
            });
            $close.click(function () {
                $main.hide(300);
                $main.remove();
                $cover.remove();
            });
        }
        catch (ex) { alert(ex); }

    }


	$.Alert_coupon = function (msg) {
        try {
            $("div[class='tc-con tc-con-b-3']").remove();
            $("div[class='tc-cover']").remove();
            $cover = $("<div class='tc-cover'id='myCover'>&nbsp;</div>");
            $main = $("<div class=\"tc-con tc-con-b-3\" id='maximPanel'></div>");
            $close = $("<a href='javascript:void(0);' class='close close_2'>关闭</a>");
            $content = $("<div  class='tc-con-1'></div>");
            $content.html(msg);
            $main.append($close);
            $main.append($content);
            $(document.body).append($cover);
            $(document.body).append($main);
            $cover.height($(document.body).height());
            $main.show(400);
            $main.focus();
            
			 $("select").selectCss(); 
		   //注册登录用户中心文本框聚焦
		   $(".coupon_txt").each(function(){
			 var thisVal=$(this).val();
			 //判断文本框的值是否为空，有值的情况就隐藏提示语，没有值就显示
			 if(thisVal!=""){
			   $(this).siblings("label").hide();
			  }else{
			   $(this).siblings("label").show();
			  }
			 //聚焦型输入框验证 
			 $(this).focus(function(){
			   $(this).siblings("label").hide();
			  }).blur(function(){
				var val=$(this).val();
				if(val!=""){
				 $(this).siblings("label").hide();
				}else{
				 $(this).siblings("label").show();
				} 
			  });
			})
			
			$("li.picke em").click(function(){
				  $("li.picke em").animate({backgroundPositionY:'0px'},1)  
				  $("li.picke input[type='checkbox']").attr("checked",false);
				  for(i=0;i<8;i++){  
				  $(this).animate({backgroundPositionY:'-=35px'},1);
				  }
				  $(this).siblings("input[type='checkbox']").attr("checked",true) ;
			});
           
		  var li_width=$(".datelist li").length*54;
          $(".datelist ul").css({"width":li_width});
          $(".delivery_time_ul .left_btn").click(function(){
			  
			  if($(".datelist ul").css("left").replace(/[^-^0-9]/ig, "")<-li_width+7*54){
			    $(this).addClass("uncur");
			  }else{
				 $(".right_btn").removeClass("uncur"); 
				 $(".datelist ul").css({left:"-="+378})  
		      }
		  });

          $(".delivery_time_ul .right_btn").click(function(){
			  
			  if($(".datelist ul").css("left").replace(/[^-^0-9]/ig, "")>=0){
			   $(this).addClass("uncur");
			  }else{
			   $(".left_btn").removeClass("uncur"); 
			   $(".datelist ul").css({"left":"+="+378})
			  }
			  
		  });

		   $("ul.datelist li").click(function(){
			   $("ul.datelist li").removeClass("cur");
			   $(this).addClass("cur");
		   });
			   
			$("#selected_time").click(function(){
			
			    $("#delivery_time").val($("ul.datelist li.cur").attr("data")+' '+$("#select_t_2").val()+'~'+$("#select_t_3").val());
			});

            $(".login_btn").click(function () {
                $main.hide(300);
                $main.remove();
                $cover.remove();
            });
			
			
            $close.click(function () {
                $main.hide(300);
                $main.remove();
                $cover.remove();
            });
        }
        catch (ex) { alert(ex); }

    }


	$.Alert_use_coupon = function (msg) {
        try {
            $("div[class='tc-con tc-con-b-4']").remove();
            $("div[class='tc-cover']").remove();
            $cover = $("<div class='tc-cover'id='myCover'>&nbsp;</div>");
            $main = $("<div class=\"tc-con tc-con-b-4\" id='maximPanel'></div>");
            $close = $("<a href='javascript:void(0);' class='close close_2'>关闭</a>");
            $content = $("<div  class='tc-con-1'></div>");
            $content.html(msg);
            $main.append($close);
            $main.append($content);
            $(document.body).append($cover);
            $(document.body).append($main);
            $cover.height($(document.body).height());
            $main.show(400);
            $main.focus();
            
		   //注册登录用户中心文本框聚焦
		   $(".coupon_txt").each(function(){
			 var thisVal=$(this).val();
			 //判断文本框的值是否为空，有值的情况就隐藏提示语，没有值就显示
			 if(thisVal!=""){
			   $(this).siblings("label").hide();
			  }else{
			   $(this).siblings("label").show();
			  }
			 //聚焦型输入框验证 
			 $(this).focus(function(){
			   $(this).siblings("label").hide();
			  }).blur(function(){
				var val=$(this).val();
				if(val!=""){
				 $(this).siblings("label").hide();
				}else{
				 $(this).siblings("label").show();
				} 
			  });
			})
		
            $(".Cash_card").click(function () {
			   var row
				row="<ul class='Remote_payment Cash_coupon'>"
				row=row+"<li><label for='coupon_pass'>输入现金券密码</label><input type='text' value=''  class='input_t use_coupon_txt' id='coupon_pass'/><p>现金券号码有误或己被使用</p></li>"
				row=row+"<li class='coupon_btn'><input type='button' value='使用'  class='login_btn Use_Cash_btn'/> </li>"
				row=row+"</ul>" 
				$.Alert_use_coupon(row)
            });  

            $(".Exclusive_card").click(function () {
			   var row
				row="<ul class='Remote_payment Cash_coupon'>"
				row=row+"<li><label for='coupon_pass'>输入专享卡密码</label><input type='text' value=''  class='input_t use_coupon_txt' id='coupon_pass'/><p>专享卡号码有误或己被使用</p></li>"
				row=row+"<li class='coupon_btn'><input type='button' value='使用'  class='login_btn Use_Exclusive_btn'/> </li>"
				row=row+"</ul>" 
				$.Alert_use_coupon(row)
            }); 
			
            $(".Pay_for").click(function () {
			   var row
				row="<ul class='Remote_payment Cash_coupon'>"
				row=row+"<li><label for='coupon_pass'>输入专享卡密码</label><input type='text' value=''  class='input_t use_coupon_txt' id='coupon_pass'/><p>专享卡号码有误或己被使用</p></li>"
				row=row+"<li class='coupon_btn'><input type='button' value='使用'  class='login_btn Pay_for_btn'/> </li>"
				row=row+"</ul>" 
				$.Alert_use_coupon(row)
            }); 


            /*付清货款*/
            $(".Pay_for_btn").click(function () {
				$.Alert_use_coupon("<ul class='Remote_payment Cash_coupon'><li><p class='pay_for'>您己付清货款，请提交订单</p></li><li class='coupon_btn'><input type='button' value='确认'  class='login_btn'/> </li></ul>")
            });


            /*使用现金卡超额度*/
            $(".Use_Cash_btn").click(function () {
				$.Alert_use_coupon("<ul class='Remote_payment Cash_coupon'><li><p style='padding:30px 0 20px 0; color:#767676;'>您使用的现金券己超出应付款额度，超出部分将无法退还，是否继续使用</p></li><li class='coupon_btn'><input type='button' value='使用'  class='login_btn'/> </li></ul>")
            });
			
			/*使用专享卡超额度*/
		   $(".Use_Exclusive_btn").click(function () {
				$.Alert_use_coupon("<ul class='Remote_payment Cash_coupon'><li><p class='no_use'><b>您不能使用专享卡</b><br>订单商品中没有包含专享卡可订购的蛋糕</p></li><li class='coupon_btn'><input type='button' value='使用'  class='login_btn'/> </li></ul>")
            });
			
			
			
			
            $close.click(function () {
                $main.hide(300);
                $main.remove();
                $cover.remove();
            });
        }
        catch (ex) { alert(ex); }

    }




//我的订单 

	$.My_order = function (msg) {
        try {
            $("div[class='tc-con-order']").remove();
            $("div[class='tc-cover']").remove();
            $cover = $("<div class='tc-cover'id='myCover'>&nbsp;</div>");
            $main = $("<div class=\"tc-con-order\" id='maximPanel'></div>");
            $close = $("<a href='javascript:void(0);' class='close close_2'>关闭</a>");
            $content = $("<div  class='tc-con-1'></div>");
            $content.html(msg);
            $main.append($close);
            $main.append($content);
            $(document.body).append($cover);
            $(document.body).append($main);
            $cover.height($(document.body).height());
            $main.show(400);
            $main.focus();
			
		   //注册登录用户中心文本框聚焦
		   $(".input_txt,#Reply,.brand_txt").each(function(){
			 var thisVal=$(this).val();
			 //判断文本框的值是否为空，有值的情况就隐藏提示语，没有值就显示
			 if(thisVal!=""){
			   $(this).siblings("label").hide();
			  }else{
			   $(this).siblings("label").show();
			  }
			 //聚焦型输入框验证 
			 $(this).focus(function(){
			   $(this).siblings("label").hide();
			  }).blur(function(){
				var val=$(this).val();
				if(val!=""){
				 $(this).siblings("label").hide();
				}else{
				 $(this).siblings("label").show();
				} 
			  });
			})


            var tw=$(".tc-con-order").width(),
			    th=$(".tc-con-order").height(),
				ul_h=$("ul.Review_box").height();
			
			$(".tc-con-order").css({"margin-left":-(tw/2),"margin-top":-(th/2)});
			if(ul_h>340){
				$("div.Review_box").css({"overflow":"scroll","overflow-X":"hidden","height":"340px"})
				}
				
				
			$(".right_Review samp").on("click",function(){
				   
				   if($(this).attr("class")=="cur"){
					  $(this).removeClass("cur"); 
					}else{
					$(this).addClass("cur");	
					}
				});
            
			$(".Complaint_box ul li").not(".Complaint_box ul li.add_img").hover(function(){
				 $(this).append("<div class='del'>删除</div>");
				},function(){
				 $(this).find(".del").remove();  	
			    });

			
            $close.click(function () {
                $main.hide(300);
                $main.remove();
                $cover.remove();
            });
        }
        catch (ex) { alert(ex); }

    }
	
	
	
	//我的红包 

	$.My_red = function (msg) {
        try {
            $("div[class='tc-con-order']").remove();
            $("div[class='tc-cover']").remove();
            $cover = $("<div class='tc-cover'id='myCover'>&nbsp;</div>");
            $main = $("<div class=\"tc-con-order\" id='maximPanel'></div>");
            $close = $("<a href='javascript:void(0);' class='close close_2'>关闭</a>");
            $content = $("<div  class='tc-con-1'></div>");
            $content.html(msg);
            $main.append($close);
            $main.append($content);
            $(document.body).append($cover);
            $(document.body).append($main);
            $cover.height($(document.body).height());
            $main.show(400);
            $main.focus();

            var tw=$(".tc-con-order").width(),
			    th=$(".tc-con-order").height(),
				ul_h=$(".red_list").height();
			$(".tc-con-order").css({"margin-left":-(tw/2),"margin-top":-(th/2)});
			if(ul_h>330){
				$(".reb_box_l").css({"overflow":"scroll","overflow-X":"hidden","height":"340px"})
			}
				
		    $(".red_list tr + tr").on("click",function(){
			   $(".red_list tr + tr").removeClass("cur");
			   $(this).addClass("cur");
			});


			
            $close.click(function () {
                $main.hide(300);
                $main.remove();
                $cover.remove();
            });
        }
        catch (ex) { alert(ex); }

    }

	/*注册成功*/
$.registered = function (msg) {
        try {
            $("div[class='tc-con-order1']").remove();
            $("div[class='tc-cover']").remove();
            $cover = $("<div class='tc-cover'id='myCover'>&nbsp;</div>");
            $main = $("<div class=\"tc-con-order1\" id='maximPanel' ></div>");
            $close = $("<a href='javascript:void(0);' class='close close_2'>关闭</a>");
            $content = $("<div  class='tc-con-2'></div>");
            $content.html(msg);
            $main.append($close);
            $main.append($content);
            $(document.body).append($cover);
            $(document.body).append($main);
            $cover.height($(document.body).height());
            $main.show(400);
            $main.focus();

            var tw=$(".tc-con-order1").width(),
			    th=$(".tc-con-order1").height(),
				ul_h=$(".red_list").height();
			$(".tc-con-order1").css({"margin-left":-(tw/2),"margin-top":-(th/2)});
			if(ul_h>330){
				$(".reb_box_l").css({"overflow":"scroll","overflow-X":"hidden","height":"340px"})
			}
				
		    $(".red_list tr + tr").on("click",function(){
			   $(".red_list tr + tr").removeClass("cur");
			   $(this).addClass("cur");
			});


			
            $close.click(function () {
                $main.hide(300);
                $main.remove();
                $cover.remove();
            });
        }
        catch (ex) { alert(ex); }

    }
	
	
	/*双十一*/
	$.Alert_111 = function (msg) {
        try {
            $("div[class='tc-con-111']").remove();
            $("div[class='tc-cover']").remove();
            $cover = $("<div class='tc-cover'id='myCover'>&nbsp;</div>");
            $main = $("<div class=\"tc-con-111\" id='maximPanel'></div>");
            $close = $("<a href='javascript:void(0);' class='close'>关闭</a>");
            $content = $("<div  class='tc-con-1'></div>");
            $content.html(msg);
            $main.append($close);
            $main.append($content);
            $(document.body).append($cover);
            $(document.body).append($main);
            $cover.height($(document.body).height());
            $main.show(400);
            $main.focus();

			
            $close.click(function () {
                $main.hide(300);
                $main.remove();
                $cover.remove();
            });
        }
        catch (ex) { alert(ex); }

    }
	
});


