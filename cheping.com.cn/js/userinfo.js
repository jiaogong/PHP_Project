function listinfo() {
    $("#list_info").hide();
    $("#sumbit_info").show();
}
function sumbitinfo() {
    $('#info_form').submit();
}
function province_se() {
    var id = $("#country").val();
    if (id == 1) {
        $("#province").hide();
        $("#city").hide();
    } else {
         $("#province").show();
        $("#city").show();
        $.get("ajax.php?action=province", {id: id}, function (msg) {
            if (msg) {
                $("#province").html(msg);
                return false;
            }
        })
    }
    return false;
}
function city_se() {
    var id = $("#province").val();
    $.get("ajax.php?action=city", {id: id}, function (msg) {
        if (msg) {
            $("#city").html(msg);
            return false;
        }
    })
    return false;
}

function uploadimg() {
    var name = $("#upload_f").val();
    $.ajaxFileUpload({
        url: 'user.php?action=upload&name=' + name + '&t=' + Math.random() * 10000,
        secureuri: false,
        fileElementId: name,
        dataType: 'json',
        success: function (ret) {
            if (ret) {
                if (ret == 1) {
                    alert('上传文件超过最大限制，请重新上传！');
                }
                else if (ret == 2) {
                    alert('上传文件格式不正确，请重新上传！');
                }
                else {
                    alert('上传成功！');
                    $("#avatar").attr("src", "attach/" + ret);
                    document.getElementById("avatar1").value = ret;
                }
            }
            else
                alert('上传失败，请联系客服！');
        }
    })
}

function sendcode1() {
    var mobile = $('#mobile_o').val();
    var mobile_reg = /^(13|18|15|17)\d{9}$/;
    if (!mobile_reg.test(mobile)) {
        $('#mobile_o').val('');
        $('#mobile_o').focus;
        return false;
    }
    $.get('user.php?action=sendcode', {mobile: mobile}, function (ret) {
        var count = 60;
        var countdown = setInterval(CountDown, 800);
        function CountDown() {
            $("#btnSendCode1").attr("disabled", true).addClass('yanBtn11').removeClass('yanBtn1');
            $("#btnSendCode1").val(count + " 秒后再获取!");
            if (count == 0) {
                $("#btnSendCode1").val("重新获取验证码").removeAttr("disabled").removeClass('yanBtn11').addClass('yanBtn1');
                clearInterval(countdown);
            }
            count--;
        }
    });
}

function showorhide(){
    $("#d2").show();
    $("#d1").hide();
    $("#d3").hide();
    $("#d4").hide();
}
