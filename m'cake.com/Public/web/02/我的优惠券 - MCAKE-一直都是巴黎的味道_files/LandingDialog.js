// JavaScript Document
var city_array = {
    110: '上海',
    641: '杭州',
    665: '苏州',
    675: '北京'
};

var ip_city_name = '上海';
var ip_city_id = 110;
var citys = [];
$(function () {

    ip_city_name = remote_ip_info["city"];

    $.each(city_array,function(id,name){
        if(name == ip_city_name)
        {
            citys.unshift(name);
            ip_city_id = id;
            ip_city_name = name;
        }
        else
        {
            citys.push(name);
        }

    });


    if (!E.getCookie('cookie_city_id') && !E.getCookie("cookie_temp_city_id")) {
        LandingDialog_Fun();
    }else{
        if(E.getCookie('EBSIG_CITY_ID')!=ip_city_id && !E.getCookie("cookie_temp_city_id")){
            LandingDialog_Fun();
        }
    }

});

//第一次进网站弹出城市选择框
function LandingDialog_Fun() {

    $("body").fadeIn(function(){
        var html = "<div class='select_box_landing' >";
        html += "<input type='text' value='"+ citys[0] +"站' readonly>";
        html += "<ul class='select_ul'>";
        $.each(citys,function(id,name){
            html +=  "<li>"+name+"站</li>";
        });
        html += "</ul>";
        html += "</div>";

        var Content="<form action='#' method='POST'><ul class='list_c'>";
        Content=Content+"<li class='Ejectbox_hy'>欢迎来到Mcake</li>";
        Content=Content+"<li class='Ejectbox_zd'>目前，我们提供以下城市的配送服务，请根据您的收货地址选择站点</li>";
        Content=Content+"<li><div class='select_ul_box'><span>你的商品配送至：</span>";
        Content=Content+ html + "<div class='clear'></div></div><div class='clear'></div></li>";
        Content=Content+"<li class='Ex_btn_box'><input type='button' value='立即体验' class='Experience' id='buttonYes'><input type='button' value='随便逛逛' class='Experience' id='buttonNo'></li>";
        Content=Content+"</form>";
        Landing_dialog(Content);
    });
}

//弹出框
function Landing_dialog (msg) {
    try {
        $("div[class='tc-con1 tc-con400']").remove();
        $("div[class='tc-cover']").remove();
        $cover = $("<div class='tc-cover'id='myCover'>&nbsp;</div>");
        $main = $("<div class=\"tc-con1 tc-con400\" id='maximPanel'></div>");
        $close = $("<a href='javascript:void(0);' class='close_landing'>关闭</a>");
        $content = $("<div  class='tc-con12'></div>");
        $bottom = $("<div  class='tc-con13' ></div>");
        $content.html( msg );
        $main.append($close);
        $main.append($content);
        $main.append($bottom);
        $(document.body).append($cover);
        $(document.body).append($main);
        $cover.height($(document.body).height());
        $main.show(400);
        $main.focus();
        //下拉框美化

        $(".select_box_landing input").on("click",function(){

            var thisinput=$(this);
            var thisul=$(this).parent().find("ul");
            if(thisul.css("display")=="none"){
                if(thisul.height()>200){thisul.css({height:"200"+"px","overflow-y":"scroll" })};
                thisul.fadeIn("100");
                thisul.hover(function(){},function(){thisul.fadeOut("100");})
                thisul.find("li").click(function(){
                        thisinput.attr('bind_value',$(this).attr('value'));
                        thisinput.val($(this).text());thisul.fadeOut("100");
                    }
                ).hover(function(){$(this).addClass("hover");},function(){$(this).removeClass("hover");
                    });
            }
            else{
                thisul.fadeOut("fast");
            }
        });


        $cover.click(function () {
            LandingDialog_closeFun();
        });

        $close.click(function () {
            LandingDialog_closeFun();
        });

        //随便逛逛
        $("#buttonNo").click(function () {
            LandingDialog_closeFun();
        });

        //立即体验
        $("#buttonYes").click(function () {
            var cityid=110;
            var cityname=$(".select_box_landing input").val();

            $.each(city_array,function(id,name){
                if(name + "站" == cityname)
                {
                    cityid = id;
                }
            });


            E.setCookie("cookie_city_id", cityid, 8640000, G.args.cookie_domain);
            E.setCookie("EBSIG_CITY_ID", cityid, 8640000, G.args.cookie_domain);
            E.setCookie("cookie_temp_city_id", cityid, 0, G.args.cookie_domain);
            $main.hide(300);
            $main.remove();
            $cover.remove();
            document.location.reload();
        });

        return $(document.body);
    }

    catch (ex) { alert(ex); }

}

//关闭弹框的事件
function LandingDialog_closeFun () {

    E.setCookie("EBSIG_CITY_ID", ip_city_id, 8640000, G.args.cookie_domain);
    E.setCookie("cookie_temp_city_id", ip_city_id, 0, G.args.cookie_domain);
    document.location.reload();
    $main.hide(300);
    $main.remove();
    $cover.remove();
}
