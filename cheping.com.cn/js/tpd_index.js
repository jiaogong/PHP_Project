$(document).ready(function () {
    //点击左侧导航树的加号触发的事件
    $('body').on('click', '.jiajie', function () {
        var bid = $(this).attr('bid');
        var arrow = $(this).find("em.arrow");
        if (arrow.css('display') == 'block') {
            $(this).find(".down").css({display: 'none'});
            $(this).find(".up").css({display: 'block'});
            $('ul#list' + bid).css({display: 'none'});
        } else {
            $(this).find(".down").css({display: 'block'});
            $(this).find(".up").css({display: 'none'});
            $.get('/image.php?action=getfactory&bid=' + bid, function (data) {
                $('ul#list' + bid).html(data);
                $('ul#list' + bid).css({display: 'block'});
            });
        }
    });
    //点击左侧导航树的减号触发的事件
    $('body').on('click', '.jiajie1', function () {
        var bid = $(this).attr('bid');
        var arrow = $(this).find("em.arrow");
        if (arrow.css('display') == 'block') {
            $(this).find(".down").css({display: 'none'});
            $(this).find(".up").css({display: 'block'});
            $('ul#list' + bid).css({display: 'none'});
            $(this).attr('class', 'jiajie');
        }
    });
    //左侧导航树子分类
    $('body').on('click', '.second_bg', function () {
        var fid = $(this).attr('fid');
        $.get('/image.php?action=getseries&fid=' + fid, function (data) {
            $('ul#serieslist_' + fid).html(data);
        });
    });
    //点击左侧导航树的链接时触发的事件
    var jiajie1 = $('.frame_tree .jiajie1').attr('bid');
    if (jiajie1) {
        $.get('/image.php?action=getfactory&bid=' + jiajie1, function (data) {
            $('ul#list' + jiajie1).html(data);
        });
    }

});


