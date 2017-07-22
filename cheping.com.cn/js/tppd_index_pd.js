var n;
var coverwidth;
var nowOrder;
var nowLeft;
var covertime = 8000; //轮播图换图时间
var t = setInterval("coverChange()", covertime);

function coverAnimate(nowLeftTemp,nowOrderTemp){
    $("#cover ul").css("width",coverwidth * (n));
    $("#cover ul").animate({
        "left":nowLeftTemp
    },300);
    $("#idNum li a").attr({
        "class":"num_other"
    });
    $("#num" + nowOrderTemp).attr({
        "class":"num_now"
    });
    $("#count").val(nowOrderTemp);
    //轮播图
    $("#hot_ri" + nowOrderTemp).siblings().css('display','none');  
    $("#hot_ri" + nowOrderTemp).css({
        'display':'block'
    });
    $("#more_right" + nowOrderTemp).css({
        'display':'block'
    });
}

/**
 * 轮播图自动滑动
 */
function coverChange() {
    var order = parseInt($("#count").val());
    if (order < n){
        nowOrder = order+1;
        nowLeft = -order*coverwidth;
    }else{
        nowOrder = 1;
        nowLeft = 0;
    }
    coverAnimate(nowLeft,nowOrder)
}
/**
 * 鼠标经过小圆圈效果
 * @param {number} hovernum 当前的小圆圈id
 */
function coverHover(hovernum) {
    nowLeft = -(hovernum-1)*coverwidth; //根据index值计算ul元素的left值
    coverAnimate(nowLeft,hovernum)
};

$(function(){
    
    //首页轮播图鼠标经过图片暂停
    $(".hot").hover(function(){
        clearInterval(t);
    },function(){
        t = setInterval("coverChange()", covertime);
    });
    
    n = $("#cover ul li").length;
    coverwidth = $("#cover").width();
    /**
     * jquery touchwipe插件
     * wipeLeft:从右向左滑动
     * wiprRight:从左向右滑动
     */   
    $("#cover").swipe({
        wipeLeft: function() {
            clearInterval(t);
            var order = parseInt($("#count").val());
            if(order==n){
                nowLeft = 0;
                nowOrder = 1;
            }else{
                nowLeft = -order*coverwidth;
                nowOrder = ++order;
            }
            coverAnimate(nowLeft,nowOrder);
            t = setInterval("coverChange()", covertime);
        },
        wipeRight: function() {
            clearInterval(t);
            var order = parseInt($("#count").val());
            if(order==1){
                nowLeft = -(n-1)*coverwidth;
                nowOrder = n;
            }else{
                nowLeft = -(order-2)*coverwidth;
                nowOrder = --order;
            }
            coverAnimate(nowLeft,nowOrder);
            t = setInterval("coverChange()", covertime);
        }
    });
    $(".head_navi").find(".nav li:last-child").each(function() {
    $(this).children("ul li:last-child").css({
        background: "none"
    });
  })
})

