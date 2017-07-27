// JavaScript Document
jQuery.divselect = function(divselectid,inputselectid) {
	var inputselect = $(inputselectid);
	$(divselectid+" cite").click(function(){
		var ul = $(divselectid+" ol");
		if(ul.css("display")=="none"){
			ul.slideDown("fast");
		}else{
			ul.slideUp("fast");
		}
	});
	$(divselectid+" ol li a").click(function(){
		var txt = $(this).text();
		$(divselectid+" cite").html(txt);
		var value = $(this).attr("selectid");
		inputselect.val(value);
		$(divselectid+" ol").hide();
		
	});
	$(document).click(function(){
		//$(divselectid+" ol").hide();
	});
};


$(function(){
	/*性别*/
	$(".sax div em").click(function(){
		
		$(this).parents("div").siblings().children("em").css("background-position","0 0px");
		$(this).css("background-position","0 -280px");
	})
	/*生日*/
	$(".select_box div em").click(function(){
		
		$(this).parents("div").siblings().children("em").css("background-position","0 0px");
		$(this).css("background-position","0 -280px");
	})
	
	/*爱好*/
	$(".hobby_list dl dd").click(function(){
		
		//$(this).children("i").toggle();
		
		if($(this).attr("class")=='checked'){
			$(this).removeClass("checked");
			
			}else{$(this).addClass("checked");};

		
	})
	
	
		/*模拟下拉菜单*/
	$.divselect(".divselect_1",".inputselect_1");
	$.divselect(".divselect_2",".inputselect_2");
	$.divselect(".divselect_3",".inputselect_3");	
	
	$(".select_memorial .tag_select").text("   ");	


})