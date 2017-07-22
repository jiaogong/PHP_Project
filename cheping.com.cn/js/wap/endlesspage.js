var p = 2;// 初始化页面，点击事件从第二页开始
var flag = false;
$(window).scroll(function () {
    var scrollTop = $(this).scrollTop();
    var scrollHeight = $(document).height();
    var windowHeight = $(this).height();
    if (scrollTop + windowHeight == scrollHeight) {
        if ($(".mainDiv li").size() <= 0) {
            return false;
        } else {
            send();
        }
    }
});

$(window).scroll(function () {
    var scrollTop = $(this).scrollTop();
    var scrollHeight = $(document).height();
    var windowHeight = $(this).height();
    if (scrollTop + windowHeight == scrollHeight) {
        if ($(".mainVideo li").size() <= 0) {
            return false;
        } else {
            sendvideo();
        }
    }
});

$(window).scroll(function () {
    var scrollTop = $(this).scrollTop();
    var scrollHeight = $(document).height();
    var windowHeight = $(this).height();
    if (scrollTop + windowHeight == scrollHeight) {
        if ($(".mainPingce li").size() <= 0) {
            return false;
        } else {
            sendpingce();
        }
    }
});

$(window).scroll(function () {
    var scrollTop = $(this).scrollTop();
    var scrollHeight = $(document).height();
    var windowHeight = $(this).height();
    if (scrollTop + windowHeight == scrollHeight) {
        if ($(".mainNew li").size() <= 0) {
            return false;
        } else {
            sendnew();
        }
    }
});

$(window).scroll(function () {
    var scrollTop = $(this).scrollTop();
    var scrollHeight = $(document).height();
    var windowHeight = $(this).height();
    if (scrollTop + windowHeight == scrollHeight) {
        if ($(".mainWenhua li").size() <= 0) {
            return false;
        } else {
            sendwenhua();
        }
    }
});

function send() {
    if (flag) {
        return false;
    }
//===============用ajax方法处理数据加载=================
    $.ajax({
        type: 'post',
        url: "/ajax.php?action=AjaxWap",
        data: {k: p},
        beforeSend: function () {
            $(".mainDiv").append("<div id='load' ><img src='images/load.gif' /></div>");
        },
        success: function (data) {
            if (data != null) {
                $(".mainDiv").append(data);
            } else {
                $("input[name=btn]").val('加载完毕');
                flag = true;
            }
        },
        complete: function () {
            $("#load").remove();
        },
        dataType: 'json'});
    p++;
}

function sendvideo() {
    if (flag) {
        return false;
    }
//===============用ajax方法处理数据加载=================
    $.ajax({
        type: 'post',
        url: "/ajax.php?action=AjaxWapVideo",
        data: {k: p,id:$('#id').val(),type:$('#type').val(),url:$('#url').val()},
        beforeSend: function () {
            $(".mainVideo").append("<div id='load'><img src='images/load.gif' /></div>");
        },
        success: function (data) {
            if (data != null) {
                $(".mainVideo").append(data);
            } else {
                $("input[name=btn]").val('加载完毕');
                flag = true;
            }
        },
        complete: function () {
            $("#load").remove();
        },
        dataType: 'json'});
    p++;
}

function sendpingce() {
    if (flag) {
        return false;
    }
//===============用ajax方法处理数据加载=================
    $.ajax({
        type: 'post',
        url: "/ajax.php?action=AjaxWapPing",
        data: {k: p,id:$('#id').val(),type:$('#type').val(),url:$('#url').val()},
        beforeSend: function () {
            $(".mainPingce").append("<div id='load'>加载中……</div>");
        },
        success: function (data) {
            if (data != null) {
                $(".mainPingce").append(data);
            } else {
                $("input[name=btn]").val('加载完毕');
                flag = true;
            }
        },
        complete: function () {
            $("#load").remove();
        },
        dataType: 'json'});
    p++;
}

function sendnew() {
    if (flag) {
        return false;
    }
//===============用ajax方法处理数据加载=================
    $.ajax({
        type: 'post',
        url: "/ajax.php?action=AjaxWapNew",
        data: {k: p,id:$('#id').val(),type:$('#type').val(),url:$('#url').val()},
        beforeSend: function () {
            $(".mainNew").append("<div id='load'>加载中……</div>");
        },
        success: function (data) {
            if (data != null) {
                $(".mainNew").append(data);
            } else {
                $("input[name=btn]").val('加载完毕');
                flag = true;
            }
        },
        complete: function () {
            $("#load").remove();
        },
        dataType: 'json'});
    p++;
}
function sendwenhua() {
    if (flag) {
        return false;
    }
//===============用ajax方法处理数据加载=================
    $.ajax({
        type: 'post',
        url: "/ajax.php?action=AjaxWapWenhua",
        data: {k: p,id:$('#id').val(),type:$('#type').val(),url:$('#url').val()},
        beforeSend: function () {
            $(".mainWenhua").append("<div id='load'>加载中……</div>");
        },
        success: function (data) {
            if (data != null) {
                $(".mainWenhua").append(data);
            } else {
                $("input[name=btn]").val('加载完毕');
                flag = true;
            }
        },
        complete: function () {
            $("#load").remove();
        },
        dataType: 'json'});
    p++;
}
