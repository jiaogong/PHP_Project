
/**
 * require JQuery & UI 1.3+
 * pop alert window
 * sample code:
 * $().ready(function(){
 *   $('.click_pop_dialog').live('click', function(){
 *      pop_window($(this));
 *    });
 *  });
 * <a href="#" class="click_pop_dialog" mt='1' bart='中国' ts='发明' icon='ok' tourl='http://www.baidu.com'>link</a>
 */
function makeIndexMod(pdName, date) {
    $.get('index.php?action=cpindex-makeModel', {pd_name: pdName, date: date}, function (ret) {
        if (ret == 1)
            alert('生成成功！');
        else
            alert('生成失败！');
    });
}
function pop_window(obj, opt) {
    var text = '';
    var title = obj.attr('bart');
    var is_modal = obj.attr('mt') == '1' ? true : false;
    var tourl = obj.attr('tourl');
    var icon = '';
    if (obj.attr('icon')) {
        icon = 'images/icon_' + obj.attr('icon') + '.gif';
    }/*else{
     icon='images/icon_warnning.gif';
     }*/

    if (typeof (opt.message) != 'undefined' && opt.message) {
        text = opt.message;
    } else {
        text = obj.attr('ts');
    }

    if (typeof (title) == 'undefined') {
        title = '提示';
    }

    var dialog = '';
    dialog += '<div id="dialog" title="' + title + '">';
    dialog += '  <div class="alert_con">';
    if (icon && typeof icon !== 'undefined') {
        dialog += '    <div class="img"><img src="' + icon + '" width="32" height="32" /></div>';
    }
    dialog += text;
    dialog += '  </div>';
    dialog += '  <div class="alert_confirm">';
    dialog += '  <input type="button" class="ok" /><input type="button" class="cancel" />';
    dialog += '  </div>';
    dialog += '</div>';
    $('body').append(dialog);

    // Dialog      
    $('#dialog').dialog({
        autoOpen: true,
        width: 371,
        modal: is_modal,
        offSet: '0 100'
    });

    if (typeof (opt.pos) != 'undefined' && opt.pos) {
        $('#dialog').dialog({
            position: opt.pos
        });
    }

    $('.ui-dialog-titlebar-close').click(function () {
        $('#dialog').remove();
    });

    $('.cancel').click(function () {
        $('#dialog').remove();
    });

    $('.ok').click(function () {
        if (opt.func && typeof opt.func != 'undefined') {
            if (opt.funcvar) {
                eval(opt.func + '(' + opt.funcvar + ');');
                return false;
            } else {
                eval(opt.func + '()');
            }

        } else {
            location.href = tourl;
            $('.ok').attr('disabled', 'disabled');
        }
    });

    $('.ui-widget-header').css({
        'background': 'url("images/alter_title.gif")',
        'border': "none"
    });

    $('.ui-dialog').css(
            'border', '1px solid #ccc'
            );
}

function block(opt) {


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
        message: '<h2><p><img src="images/loading.gif" style="vertical-align:middle"/>' + opt.message + '</p></h2>'
    });
    $.get(opt.url, function (ret) {
        if ($.trim(ret) == 1) {
            $('.blockMsg h2 p').html(opt.okmsg);
            //alert('图片关联成功！');
        } else {
            $('.blockMsg h2 p').html(opt.errmsg);
            //alert('图片关联失败！');
        }
        setTimeout($.unblockUI, 2000);
        //$.unblockUI();
    });
}

/**
 * require "js/series.js"
 */
function setSeries(id, val) {
    var series = $('#' + id);
    var brand_series = series_arr[val];
    var first = '<option value=0>选择车型</option>';
    var str = '', tmp = '';
    //清空selseries中的option
    series.empty();
    if (val > 0) {
        series.attr({
            disabled: false
        });
    } else {
        series.attr({
            disabled: 'disabled'
        });
    }

    if ($.isPlainObject(brand_series))
        $.each(brand_series, function (i, v) {
            str += '<optgroup label="' + i + '">';
            $.each(v, function (kk, vv) {
                str += '<option value="' + vv[0] + '">' + vv[1] + '</option>';
            });
            str += '</optgroup>';

            //fix firefox & safari rsort,,
            if (!$.browser.mozilla && !$.browser.safari) {
                tmp = str + tmp;
                str = '';
            }
        });
    if (tmp)
        str = tmp;
    str = first + str;
    series.append(str);
}

function setSeriesByFctory(fid, sobj) {
    var serurl = "?action=series-json&factory_id=" + fid;
    var ser = $('#' + sobj)[0];
    var ov, on, ot;
    $.getJSON(serurl, function (ret) {
        $('#' + sobj + ' option[value!=""]').remove();

        $.each(ret, function (i, v) {
            on = v['series_name'];
            ov = v['series_id'];
            ser.options.add(new Option(on, ov));
        });
    });

    //unuse
    if (0) {
        var serurl = "?action=series-yjson&factory_id=" + fid;
        var ser = $('#' + sobj)[0];
        var ov, on, ot;
        $.getJSON(serurl, function (ret) {
            $('#' + sobj + ' option[value!=""]').remove();

            $.each(ret, function (v) {
                //alert(v)
                ot = ret[v];
                $.each(ot, function (i, r) {
                    on = r['date_id'] + '款 ' + r['series_name'];
                    ov = r['series_id'] + '_' + r['date_id'];
                    ser.options.add(new Option(on, ov));
                });
            });
        });
    }
}

function setModelBySeries(sid, obj) {
    var modelurl = "?action=model-json&sid=" + sid;
    var model = $('#' + obj)[0];
    $.getJSON(modelurl, function (ret) {
        $('#' + obj + ' option[value!=""]').remove();
        $.each(ret, function (i, v) {
            on = v['model_name'];
            ov = v['model_id'];
            //      alert(v['dealer_price_low']);return false;
            var opt = new Option(on, ov);
            opt.setAttribute("price", v['dealer_price_low']);
            model.options.add(opt);
        });
    });
}

function brand_select() {
    $.each(brand_js, function (i, v) {
        document.write("<option value='" + v['brand_id'] + "'>" + v['letter'] + ' ' + v['brand_name'] + "</option>\n");
    });
}

function factory_selected(obj, brand_id, factory_id) {
    var factory_id = arguments[2] ? arguments[2] : 0;
    var js = "<option value = '0'>选择厂商</option>\n";
    if ($.isPlainObject(factory_js) && brand_id > 0) {
        obj.empty();
        $.each(factory_js[brand_id], function (i, v) {
            if (factory_id == v['factory_id'])
                js += '<option value = "' + v['factory_id'] + '" selected="selected">' + v['factory_name'] + "</option>\n";
            else
                js += '<option value = "' + v['factory_id'] + '">' + v['factory_name'] + "</option>\n";
        });
        obj.append(js);
    }
}
function series_selected(obj, factory_id, series_id) {
    var series_id = arguments[2] ? arguments[2] : 0;
    var js = "<option value = '0'>选择车系</option>\n";
    if ($.isPlainObject(series_js) && factory_id > 0) {
        obj.empty();
        $.each(series_js[factory_id], function (i, v) {
            if (series_id == v['series_id'])
                js += "<option value='" + v['series_id'] + "' selected=\"selected\">" + v['series_name'] + "</option>\n";
            else
                js += "<option value='" + v['series_id'] + "'>" + v['series_name'] + "</option>\n";
        });
        obj.append(js);
    }
}
function series_select(obj, brand_id) {
    var js = "<option value = '0'>选择车系</option>\n";
    if ($.isPlainObject(series_js) && brand_id > 0) {
        obj.empty();
        $.each(series_js[brand_id], function (i, v) {
            js += "<option value='" + v['series_id'] + "'>" + v['series_name'] + "</option>\n";
        });
        obj.append(js);
    }
}

function model_select(obj, series_id) {
    if (series_id > 0) {
        $.ajax({
            type: "POST",
            url: "../ajax.php?action=models",
            data: {
                series_id: series_id
            },
            error: function () {
                alert("网络异常，请求失败！！");
            },
            success: function (data) {
                if (data == -4) {
                    alert("系统错误，请联系管理员!!");
                    return false;
                } else {
                    var models = eval("(" + data + ")");
                    if (models) {
                        obj.empty();
                        var js;
                        js = "<option value='0'>选择配置</option>";
                        $.each(models, function (i, n) {
                            js += "<option value='" + n.model_id + "'>" + n.model_name + "</option>\n";
                        });
                        obj.append(js);
                    }
                }
            }
        });
    }
}
function chk_model_select(obj, series_id, k, v) {
    if (series_id > 0) {
        $.ajax({
            type: "POST",
            url: "../ajax.php?action=models",
            data: {
                series_id: series_id
            },
            error: function () {
                alert("网络异常，请求失败！！");
            },
            success: function (data) {
                if (data == -4) {
                    alert("系统错误，请联系管理员!!");
                    return false;
                } else {
                    var models = eval("(" + data + ")");
                    if (models) {
                        obj.empty();
                        var js;
                        js = "<option value='0'>选择配置</option>";
                        $.each(models, function (i, n) {
                            js += "<option value='" + n.model_id + "'>" + n.model_name + "</option>\n";
                        });
                        obj.append(js);
                        $('#model_id' + k + ' option[value="' + v + '"]').attr("selected", true);
                    }
                }
            }
        });
    }
}
//新首页生成用
function newMakefile(pd_name, date) {
    if (date == undefined)
        date = '';
    if (confirm('确定生成信息?')) {
        var url = "index.php?action=cpindex-makemodel&pd_name=" + pd_name + "&date=" + date + "";
        $.getJSON(url, function (msg) {
            if (msg == '1') {
                alert('生成成功');
            } else {
                alert('生成失败');
            }
        });
    }
}

$(function () {
    $("input.datepicker").datepicker();
});
