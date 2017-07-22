/**
 * Created by sunqiang on 14-8-29.
 */

/*title是标题，rLink链接，summary内容，site分享来源，pic分享图片路径,分享到新浪微博*/
function shareTQQWB() {
    var top = window.screen.height / 2 - 250;
    var left = window.screen.width / 2 - 300;
    var picurl="http://www.mcake.com/postsystem/docroot/images/goods/net/qq/qq.jpg";
    title = "MCAKE蛋糕，传承百年的巴黎味道，一起来分享~";
    // pic = $(".p-img img").attr("src");
    rLink = "http://www.mcake.com";

    window.open("http://share.v.t.qq.com/index.php?c=share&a=index&url=" + encodeURIComponent(rLink) + "&appkey=801536367&title=" +
        encodeURIComponent(title) + "&pic=http%3A%2F%2Fwww.mcake.com%2Fpostsystem%2Fdocroot%2Fimages%2Fgoods%2Fnet%2Fqq%2Fqq.jpg&line1=",
        "分享至腾讯微博",
        "height=500,width=600,top=" + top + ",left=" + left + ",toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no");

}

/*title是标题，rLink链接，summary内容，site分享来源，pic分享图片路径,分享到新浪微博*/
function shareTSina() {
    var top = window.screen.height / 2 - 250;
    var left = window.screen.width / 2 - 300;
    var picurl="http://www.mcake.com/postsystem/docroot/images/goods/net/weibo/weibo.jpg";
    title = " MCAKE蛋糕，传承百年的巴黎味道，一起来分享~";
    // pic = $(".p-img img").attr("src");
    rLink = "http://www.mcake.com";

    window.open("http://service.weibo.com/share/share.php?searchPic=false&pic=" + encodeURIComponent(picurl) + "&title=" +
        encodeURIComponent(title.replace(/&nbsp;/g, " ").replace(/<br \/>/g, " ")) + "&url=" + encodeURIComponent(rLink),
        "分享至新浪微博",
        "height=500,width=600,top=" + top + ",left=" + left + ",toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no");

}

function shareTQQ()
{
    var top = window.screen.height / 2-300;
    var left = window.screen.width / 2 - 400;
    var p = {
        url: 'http://www.mcake.com',
        /*获取URL，可加上来自分享到QQ标识，方便统计*/
        desc: '',
        /*分享理由(风格应模拟用户对话),支持多分享语随机展现（使用|分隔）*/
        title: 'MCAKE蛋糕，传承百年的巴黎味道，一起来分享~',
        /*分享标题(可选)*/
        summary: '',
        /*分享摘要(可选)*/
        pics: 'http://www.mcake.com/postsystem/docroot/images/goods/net/qq/qq.jpg',
        /*分享图片(可选)*/
        flash: '',
        /*视频地址(可选)*/
        site: '',
        /*分享来源(可选) 如：QQ分享*/
        style: '201',
        width: 32,
        height: 32
    };
    var s = [];
    for (var i in p) {
        s.push(i + '=' + encodeURIComponent(p[i] || ''));
    }
    window.open("http://connect.qq.com/widget/shareqq/index.html?"+s.join('&'),
        "分享到QQ",
        "height=600,width=800,top=" + top + ",left=" + left + ",toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no");

}


$(function(){
    $("#footer .Share .Twx").hover(function(){
        $("#footer div.wxqr").show();
    },function(){
        $("#footer div.wxqr").hide();
    });
});




//(function() {
//    var p = {
//    url: location.href,
//    /*获取URL，可加上来自分享到QQ标识，方便统计*/
//    desc: '',
//    /*分享理由(风格应模拟用户对话),支持多分享语随机展现（使用|分隔）*/
//    title: '',
//    /*分享标题(可选)*/
//    summary: '',
//    /*分享摘要(可选)*/
//    pics: '',
//    /*分享图片(可选)*/
//    flash: '',
//    /*视频地址(可选)*/
//    site: '',
//    /*分享来源(可选) 如：QQ分享*/
//    style: '201',
//    width: 32,
//    height: 32
//    };
//var s = [];
//for (var i in p) {
//    s.push(i + '=' + encodeURIComponent(p[i] || ''));
//}
//document.write(['<a class="qcShareQQDiv" href="http://connect.qq.com/widget/shareqq/index.html?', s.join('&'), '" target="_blank">分享到QQ</a>'].join(''));
//})();

