(function() {

    var W = window,
        D = document,
        N = navigator,
        d = W.location.host,
        r = D.referrer,
        h = W.location.href,
        cookieDomain = d.substr(d.indexOf('.'));

    var E = {

        //ajax超时时间
        ajax_timeout: 15000,

        /**
         * 获得上一页
         * @returns {string}
         */
        getReferrer: function() {
            return r;
        },

        /**
         * 获得当前链接
         * @returns {string}
         */
        getUrl: function() {
            return h;
        },

        /**
         * 获得屏幕分辨率
         * @returns {string}
         */
        getScreen: function() {
            return W.screen.width + '*' + W.screen.height;
        },

        /**
         * 检查浏览器类型
         * @returns {string}
         */
        browser: function() {
            var browserName = N.userAgent.toLowerCase();
            if (/msie/i.test(browserName) && !/opera/.test(browserName)) {
                return "IE" + N.appVersion.substring(22, 23);
            } else if (/firefox/i.test(browserName)){
                return "Firefox";
            } else if (/chrome/i.test(browserName) && /webkit/i.test(browserName) && /mozilla/i.test(browserName)) {
                return "Chrome";
            } else if (/opera/i.test(browserName)) {
                return "Opera";
            } else if (/webkit/i.test(browserName) &&!(/chrome/i.test(browserName) && /webkit/i.test(browserName) && /mozilla/i.test(browserName))) {
                return "Safari";
            } else {
                return "unKnow";
            }
        },

        /**
         * 获得访问设备
         * @returns {string}
         */
        getDevice: function() {

            var sUserAgent = navigator.userAgent.toLowerCase();
            if (sUserAgent.match(/ipad/i) == "ipad") {
                return "ipad";
            } else if (sUserAgent.match(/iphone os/i) == "iphone os") {
                return "iphone";
            } else if (sUserAgent.match(/midp/i) == "midp") {
                return "midp";
            } else if (sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4") {
                return "rv:1.2.3.4";
            } else if (sUserAgent.match(/ucweb/i) == "ucweb") {
                return "ucweb";
            } else if (sUserAgent.match(/android/i) == "android") {
                return "android";
            } else if (sUserAgent.match(/windows ce/i) == "windows ce") {
                return "windows ce";
            } else if (sUserAgent.match(/windows mobile/i) == "windows mobile") {
                return "windows mobile";
            } else {
                return "pc";
            }

        },

        /**
         * 设置COOKIE
         * @param string cookieName cookie名
         * @param string cookieValue cookie值
         * @param int cookieTime 有效期，毫秒
         * @param string cookieDomain cookie域
         */
        setCookie: function(cookieName, cookieValue, cookieTime, cookieDomain) {
            var exp = new Date();
            exp.setTime(exp.getTime() + cookieTime * 1000);
            if (cookieTime == 0) {
                document.cookie = cookieName + "=" + encodeURIComponent(cookieValue) + ";path=/;domain=" + cookieDomain + ";";
            } else {
                document.cookie = cookieName + "=" + encodeURIComponent(cookieValue) + ";expires=" + exp.toGMTString() + ";path=/;domain=" + cookieDomain + ";";
            }
        },

        /**
         * 获得cookiez
         * @param string cookieName cookie名
         * @returns {*}
         */
        getCookie: function(cookieName) {
            var strCookie = D.cookie;
            var arrCookie = strCookie.split("; ");
            var arrCookieCount = arrCookie.length;
            var arr,identifyContent = null;
            for(var i = 0; i < arrCookie.length ; i++){
                arr = arrCookie[i].split("=");
                if(cookieName == arr[0]){
                    var arrStr = D.cookie.split("; ");
                    identifyContent = decodeURIComponent(decodeURIComponent(arr[1]));
                    break;
                }
            }
            arrCookie = null;
            if (identifyContent == null) {
                return null;
            } else {
                return identifyContent;
            }
        },

        /**
         * 生成一个全局唯一标识符
         * @returns {string}
         */
        createGuid: function() {
            var guid = "";
            for (var i = 1; i <= 32; i++){
                var n = Math.floor(Math.random()*16.0).toString(16);
                guid +=   n;
            }
            return guid;
        },

        /**
         * 合并两个对象数组
         * @param arr1
         * @param arr2
         * @returns {{}}
         */
        concat: function(arr1, arr2) {
            var newArr = arr1;
            for (var k2 in arr2){
                newArr[k2] = arr2[k2];
            }
            return newArr;
        },

        /**
         * 关闭浏览器窗口
         */
        closeWindows: function() {
            parent.window.opener = null;
            parent.window.open("", "_self");
            parent.window.close();
        },

        /**
         * 子窗口调用父窗口js函数
         * @param func
         */
        opener: function( func ) {
            W.opener.location = "javascript: " + func + "();";
        },

        /**
         * 打开新窗口
         * @param url
         * @param name
         * @param params
         */
        open: function( url, name, params ) {
            var arg_obj = {
                height: 500,
                width: 800,
                top: 50,
                left: 300,
                toolbar: "no",
                menubar: "no",
                scrollbars: "yes",
                resizable: "no",
                location: "no",
                status: "no",
                depended: "yes",
                resizable: "no"
            };
            if (!name)
                name = "";
            if (params) {
                arg_obj = this.concat(arg_obj, params);
            }
            var arg_string = "";
            for(var k in arg_obj) {
                if (arg_string == "")
                    arg_string += k + "=" + arg_obj[k];
                else
                    arg_string += "," + k + "=" + arg_obj[k];
            }
            W.open(url, name, arg_string);
        },

        /**
         *   判断在数组中是否含有给定的一个变量值
         *   参数：
         *   needle：需要查询的值
         *   haystack：被查询的数组
         *   在haystack中查询needle是否存在，如果找到返回true，否则返回false。
         *   此函数只能对字符和数字有效
         *
         */
        inArray: function(needle, haystack) {
            var t = false;
            $.each(haystack, function(k, v) {
                if (v == needle) {
                    t = true;
                    return false;
                }
            });
            return t;
        },

        /**
         * 检查参数是否为空
         * @param val
         * @returns {boolean}
         */
        empty: function( val ) {
            switch (typeof(val)){
                case "string":
                    return this.trim(val).length == 0 ? true : false;
                    break;
                case "number":
                    return val == 0;
                    break;
                case "object":
                    return val == null;
                    break;
                case "array":
                    return val.length == 0;
                    break;
                default:
                    return true;
            }
        },

        isEmpty: function( val ) {
            return this.empty( val );
        },
        /**
         * 检查日期获取日期+时间或时间格式
         * @param s
         * @returns {Array|{index: number, input: string}}
         */
        isDate: function(s) {
            var   reg=  /^\d{4}-\d{2}-\d{2}$|^\d{4}-\d{2}-\d{2} \d{1,2}:\d{1,2}:\d{1,2}$|\d{1,2}:\d{1,2}:\d{1,2}$/;
            return reg.exec(s);
        },

        /**
         * 匹配email
         * @param s
         * @returns {Array|{index: number, input: string}}
         */
        isEmail: function(s) {
            var   reg=  /^[a-z0-9]([a-z0-9_\-\.]*)@([a-z0-9_\-\.]*)(\.[a-z]{2,3}(\.[a-z]{2}){0,2})$/i;
            return reg.exec(s);
        },

        /**
         * 匹配数字（整数）
         * @param s
         * @returns {Array|{index: number, input: string}}
         */
        isDigital: function(s) {
            var reg = /^\d+$/;
            return reg.exec(s);
        },

        /**
         * 匹配数字（整数或小数）
         * @param s
         * @returns {Array|{index: number, input: string}}
         */
        isNum: function(s) {
            var reg = /^\d+$|^\d+\.\d+$/;
            return reg.exec(s);
        },

        /**
         * 匹配非负整数（正整数+0）
         * @param s
         * @returns {Array|{index: number, input: string}}
         */
        isInt: function(s) {
            var reg = /^[0-9]\d*$/;
            return reg.exec(s);
        },

        /**
         * 匹配小数
         * @param s
         * @returns {Array|{index: number, input: string}}
         */
        isFloat: function(s) {
            var reg = /^(\d+)(\.(\d{1,2}))$/;
            return reg.exec(s);
        },

        /**
         * 匹配金额
         * @param s
         * @returns {Array|{index: number, input: string}}
         */
        isMoney: function(s) {
            var reg = /^(([1-9]\d*(,\d{3})*)|([0-9]\d*))(\.(\d{1,2}))?$/;
            return reg.exec(s);
        },

        /**
         * 从字符串的两端删除空白字符和其他预定义字符
         * @param s
         * @returns {*}
         */
        trim: function(s) {
            return s.replace(/(^\s*)|(\s*$)/g, "");
        },

        /**
         * 匹配手机号码
         * @param s
         * @returns {Array|{index: number, input: string}}
         */
        isMobile: function(s) {
            var reg = /^1\d{10}$/;
            return reg.exec(s);
        },

        /**
         * 匹配电话号码
         * @param s
         * @returns {Array|{index: number, input: string}}
         */
        isPhone: function(s) {
            var reg = /^(0[0-9]{2,3}-)?([2-9][0-9]{6,7})+(-[0-9]{1,6})?$/;
            return reg.exec(s);
        },

        /**
         * 匹配汉字
         * @param s
         * @returns {Array|{index: number, input: string}}
         */
        isChinese: function( s ) {
            var reg = /^[\u4e00-\u9fa5]+$/;
            return reg.exec(s) ;
        },

        /**
         * 检查变量是否定义
         * @param variable
         * @returns {boolean}
         */
        isDefined: function( variable ) {
            if (typeof(variable) == 'undefined'){
                return false;
            } else {
                return true;
            }
        },

        /**
         *
         */
        isPwd: function( s ) {
            var reg = /^[A-Za-z0-9_-]{6,30}$/;
            return reg.exec(s) ;
        },
        /**
         add by allen.qiang 20140924 字母，数字，符号
         */
          isPwd_A: function( s ) {
            var reg = /^[^\x00-\xff]/;
             if(reg.exec(s))//如果包含全角
             {
                 return false;
             }
             if(s.length<6 || s.length>30)//判断长度
             {
                 return false;
             }

             return true;

        },

        /**
         * 是否生日牌格式（中文，英文，标点符号）
         * @param startDate     开始日期
         * @param endDate       结束日期
         * @returns {boolean}
         */
        isBirthday_card: function( s ) {
            var reg = /^[ A-Za-z0-9_\u4e00-\u9fa5\!\@\#\$\%\*\+\{\}\|\:\"\<\>\?\,\.\/\-\=\\\，\。\、\；\‘\！\￥\…\（\）]*$/;
            var flag = reg.exec(s) ;
            return flag;
        },
        /**
         * 比较日期先后
         * @param startDate     开始日期
         * @param endDate       结束日期
         * @returns {boolean}
         */
        dateCompare : function(sDate, eDate){
            s = sDate.replace(/-/g,"/");
            e = eDate.replace(/-/g,"/");
            if (Date.parse(s) - Date.parse(e) > 0){
                return false;
            }
            return true;
        },
        /**
         * 编码 URL 字符串
         * @param str
         * @returns {string}
         */
        urlencode: function( str ) {
            str = str.replace(/\r\n/g,"\n");
            var utftext = "";
            for (var n = 0; n < str.length; n++) {
                var c = str.charCodeAt(n);
                if (c < 128) {
                    utftext += String.fromCharCode(c);
                } else if((c > 127) && (c < 2048)) {
                    utftext += String.fromCharCode((c >> 6) | 192);
                    utftext += String.fromCharCode((c & 63) | 128);
                } else {
                    utftext += String.fromCharCode((c >> 12) | 224);
                    utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
            }
            return utftext;
        },

        /**
         * 解码已编码的 URL 字符串
         * @param utftext
         * @returns {string}
         */
        urldecode: function(utftext) {
            var str = "";
            var i = 0;
            var c = c1 = c2 = 0;
            while ( i < utftext.length ) {
                c = utftext.charCodeAt(i);
                if (c < 128) {
                    str += String.fromCharCode(c);
                    i++;
                } else if((c > 191) && (c < 224)) {
                    c2 = utftext.charCodeAt(i+1);
                    str += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                    i += 2;
                } else {
                    c2 = utftext.charCodeAt(i+1);
                    c3 = utftext.charCodeAt(i+2);
                    str += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                    i += 3;
                }
            }
            return str;
        },
        /**
         * 检查参数长度
         * @param val
         * @returns {number}
         */
        len: function( val ) {
            var l = 0;
            var a = val.split("");
            for (var i=0;i<a.length;i++) {
                if (a[i].charCodeAt(0)<299) {
                    l++;
                } else {
                    l+=2;
                }
            }
            return l;
        },

        /**
         * 检查字符串
         * @param str
         * @param startp
         * @param endp
         * @returns {*}
         */
        sb_substr: function(str, startp, endp) {
            var i=0; c = 0; unicode=0; rstr = '';
            var len = str.length;
            var sblen = this.len(str);
            if (startp < 0) {
                startp = sblen + startp;
            }
            if (endp < 1) {
                endp = sblen + endp;// - ((str.charCodeAt(len-1) < 127) ? 1 : 2);
            }
            for(i = 0; i < len; i++) {
                if (c >= startp) {
                    break;
                }
                var unicode = str.charCodeAt(i);
                if (unicode < 127) {
                    c += 1;
                } else {
                    c += 2;
                }
            }
            for(i = i; i < len; i++) {
                var unicode = str.charCodeAt(i);
                if (unicode < 127) {
                    c += 1;
                } else {
                    c += 2;
                }
                rstr += str.charAt(i);

                if (c >= endp) {
                    break;
                }
            }
            return rstr;
        },

        /**
         * 分割URL
         * @param string url
         * @returns {{source: *, protocol: string, host: (string|.parseUrl.hostname|*), port: (*|Function|string|.parseUrl.port), query: (mapArea.search|*|search|Function|string|.parseUrl.search), params: , file: *, hash: string, path: string, relative: *, segments: Array}}
         */
        parseURL: function(url) {
            var a = document.createElement('a');
            a.href = url;
            return {
                source: url,
                protocol: a.protocol.replace(':', ''),
                host: a.hostname,
                port: a.port,
                query: a.search,
                params: (function() {
                    var ret = {},
                        seg = a.search.replace(/^\?/, '').split('&'),
                        len = seg.length,
                        i = 0,
                        s;
                    for (; i < len; i++) {
                        if (!seg[i]) {
                            continue
                        }
                        s = seg[i].split('=');
                        ret[s[0]] = s[1]
                    }
                    return ret
                })(),
                file: (a.pathname.match(/\/([^\/?#]+)$/i) || [, ''])[1],
                hash: a.hash.replace('#', ''),
                path: a.pathname.replace(/^([^\/])/, '/$1'),
                relative: (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [, ''])[1],
                segments: a.pathname.replace(/^\//, '').split('/')
            }
        },

        /**
         * 生成新的URL，删除指定的参数
         * @param string url
         * @param object params
         * @returns {string}
         */
        replaceUrlParams: function(url, params) {
            var url_obj = this.parseURL(url);
            var new_url = url_obj.protocol + '://' + url_obj.host;
            if (url_obj.path) {
                new_url += url_obj.path
            }
            if (url_obj.params) {
                var i = 0;
                $.each(url_obj.params,
                    function(k, v) {
                        if (k == params) {
                            return true
                        }
                        if (i == 0) {
                            new_url += '?' + k + '=' + v
                        } else {
                            new_url += '&' + k + '=' + v
                        }
                        i++
                    })
            }
            return new_url
        },

        /**
         * 抓取表单数据
         * @param id
         * @returns {{}}
         */
        getFormValues: function(id) {
            var x = document.getElementById(id);
            var form_obj = {};
            var checkbox_name_array = {};
            for (var i = 0; i < x.length; i++) {
                var ele = x.elements[i];
                ele.name = this.trim(ele.name);
                ele.value = this.trim(ele.value);
                if (ele.name == "" || ele.name == undefined || ele.name == "undefined")
                    continue;
                if (ele.type == "radio" && ele.checked == false)
                    continue;
                if (ele.type == "checkbox") {
                    if (!checkbox_name_array[ele.name]) {
                        checkbox_name_array[ele.name] = 0;
                        form_obj[ele.name] = new Array();
                    }
                    if (ele.checked == false)
                        continue;
                    else {
                        var index = checkbox_name_array[ele.name];
                        form_obj[ele.name][index] = ele.value;
                        checkbox_name_array[ele.name] += 1;
                    }
                } else {
                    ele.name_array = ele.name.split('[');
                    if (ele.name_array[1] != undefined && ele.name_array[1] == ']') {
                        var ele_name = ele.name_array[0];
                        if (!checkbox_name_array[ele_name]) {
                            checkbox_name_array[ele_name] = 0;
                            form_obj[ele_name] = new Array();
                        }
                        var index = checkbox_name_array[ele_name];
                        form_obj[ele_name][index] = ele.value;
                        checkbox_name_array[ele_name] += 1;
                    } else {
                        form_obj[ele.name] = ele.value;
                    }

                }

            }
            return form_obj;
        },

        /**
         * 获得页面高度和宽度
         */
        scroll: function() {
            var width = document.body.scrollWidth;
            var height = document.body.scrollHeight;
            if (document.documentElement) {
                width = Math.max(width, document.documentElement.scrollWidth);
                height = Math.max(height, document.documentElement.scrollHeight);
            }
            return {height: height, width: width};
        },

        /**
         * 遮盖层
         */
        coverLayer: {

            //遮盖层是否打开
            layer_is_open: 0,

            open: function( id, zindex ) {

                var scroll_obj = E.scroll();
                if (zindex)
                    var e_cover_layer = "<div id=\"" + id + "\" class=\"e_cover_layer\" style=\"height: " + scroll_obj.height + "px;width: " + scroll_obj.width + "px;z-index: " + zindex + "\"></div>";
                else
                    var e_cover_layer = "<div id=\"" + id + "\" class=\"e_cover_layer\" style=\"height: " + scroll_obj.height + "px;width: " + scroll_obj.width + "px;\"></div>";
                this.layer_is_open = 1;
                $("body").append(e_cover_layer);

            },

            close: function( id ) {
                $("#" + id).remove();
            },

            change: function() {
                var scroll_obj = E.scroll();
                $(".e_cover_layer").css({"height": scroll_obj.height, "width": scroll_obj.width});
            }

        },

        /**
         * 提示弹出层
         * @param message 提示信息
         * @param action  1：错误信息 2：成功信息（自动关闭弹出层） 3: 成功信息（不会自动关闭弹出层）
         * @param call_func
         */
        alert: function(message, action, call_func) {

            if (!action) {
                action = 1;
            }

            var list_html = "<div id=\"e_layer\" class=\"e_layer\">";
            list_html += "<div class=\"e_layer_content\">";
            list_html += "<div class=\"e_layer_title\"><span>提示信息</span></div>";
            list_html += "<div class=\"e_layer_message\">";
            list_html += "<table width=\"100%\">";
            list_html += "<tbody>";
            list_html += "<tr>";
            if (action == 3 || action == 2) {
                list_html += "<td class=\"img-correct\"></td>";
            } else if (action == 1) {
                list_html += "<td class=\"img-error\"></td>";
            }
            list_html += "<td id=\"layer_message\">" + message + "</td>";
            list_html += "</tr>";
            list_html += "</tbody>";
            list_html += "</table>";
            list_html += "</div>";
            if (action == 1 || action == 3) {
                list_html += "<div class=\"layer_btn\"><input type=\"button\" class=\"btn btn-primary\" value=\"确定\" ontouchstart=\"E.alert_ok();\" onclick=\"E.alert_ok();\" /></div>";
            }
            if (action == 4) {
                list_html += "<div class=\"layer_btn\"><input type=\"button\" class=\"btn btn-primary\" value=\"确定\" ontouchstart=\"self.location = '"+call_func+"';\" onclick=\"self.location = '"+call_func+"';\" /></div>";
            }
            list_html += "</div></div>";

            if (call_func) {
                this.call_func = call_func;
            }

            E.coverLayer.open("e_cover_layer");
            $("body").append(list_html);
            if (action == 1 || action == 3) {
                $("#e_layer div.layer_btn input.btn").focus();
            }
            if (action == 2) {
                setTimeout("E.alert_ok()", 2000);
            }
            if ($.browser && $.browser.msie && ($.browser.version == "6.0") && !$.support.style) {
                var t = $(document).scrollTop();
                $("#e_layer").css("top", parseInt(t) + 100 + "px")
            }

        },

        /**
         * 关闭提示弹出层
         */
        alert_ok: function() {

            $("#e_layer").remove();

            E.coverLayer.close("e_cover_layer");

            if (this.call_func) {
                if (typeof(this.call_func) == 'string') {
                    eval(this.call_func + "()");
                } else {
                    this.call_func();
                }
                this.call_func = "";
            }

        },

        /**
         * 打开确认层
         * @param message 提示信息
         * @param confirmFunc 点击确认按钮执行的函数
         * @param cancalFunc 点击取消按钮执行的函数
         */
        confirm: function(message, confirmFunc, cancalFunc) {

            var list_html = "<div id=\"e_layer\" class=\"e_layer\">";
            list_html += "<div class=\"e_layer_content\">",
            list_html += "<div class=\"e_layer_title\"><span>提示信息</span>";
            list_html += "<a title=\"关闭\" class=\"e_layer_close\" href=\"javascript:void(0)\" onclick=\"E.confirm_cancel();\">关闭</a></div>";
            list_html += "<div class=\"e_layer_message\">";
            list_html += "<table width=\"100%\">";
            list_html += "<tbody>";
            list_html += "<tr>";
            list_html += "<td class=\"img-confirm\"></td>";
            list_html += "<td id=\"layer_message\" class=\"e_layer_message\">" + message + "</td>";
            list_html += "</tr>";
            list_html += "</tbody>";
            list_html += "</table>";
            list_html += "</div>";
            list_html += "<div class=\"layer_btn\"><input type=\"button\" class=\"btn btn-primary\" value=\"确定\" onclick=\"E.confirm_ok();\" />&nbsp;&nbsp;&nbsp;&nbsp;";
            list_html += "<input type=\"button\" class=\"btn btn-default\" value=\"取消\" onclick=\"E.confirm_cancel();\" /></div>";
            list_html += "</div></div>";

            if (confirmFunc) {
                this.confirmFunc = confirmFunc;
            }
            if (cancalFunc) {
                this.cancalFunc = cancalFunc;
            }

            E.coverLayer.open("e_cover_layer");
            $("body").append(list_html);

            if ($.browser && $.browser.msie && ($.browser.version == "6.0") && !$.support.style) {
                var t = $(document).scrollTop();
                $("#e_layer").css("top", parseInt(t) + 100 + "px");
            }

        },

        /**
         * 确认层点击确认
         */
        confirm_ok: function() {

            $("#e_layer").remove();

            E.coverLayer.close("e_cover_layer");

            if (this.confirmFunc) {

                if (typeof(this.confirmFunc) == 'string') {
                    eval(this.confirmFunc + "()");
                } else {
                    this.confirmFunc();
                }

                this.confirmFunc = "";

            }

        },

        /**
         * 确认层点击取消按钮
         */
        confirm_cancel: function() {

            $("#e_layer").remove();

            E.coverLayer.close("e_cover_layer");

            if (this.cancalFunc) {

                if (typeof(this.cancalFunc) == 'string') {
                    eval(this.cancalFunc + "()");
                } else {
                    this.cancalFunc();
                }

                this.cancalFunc = "";

            }

        },

        /**
         * 刷新页面
         */
        refresh: function() {
            window.location.reload()
        },

        /**
         * ajax的post请求
         * @param args
         */
        ajax_post: function( args ) {

            if (args.url) {
                var request_url = args.url;
            } else {
                var request_url = "/ajax-shop/default/" + args.action + ".ajax?operFlg=" + args.operFlg;
            }

            $.ajax({
                type: "POST",
                url: request_url,
                dataType: "JSON",
                data: args.data,
                timeout: this.ajax_timeout,
                success: function(o) {
                    if (typeof(args.call) == 'string') {
                        eval(args.call + "(o)");
                    } else {
                        args.call( o );
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    E.loadding.close();
                    switch (textStatus) {
                        case 'timeout':
                            E.alert('您的网络灰常不给力哦~请重新加载~~');
                            break;
                    }
                }
            });

        },

        /**
         * ajax的get请求
         * @param args
         */
        ajax_get: function(args) {

            if (args.url) {
                var request_url = args.url;
            } else {
                var request_url = "/ajax-shop/default/" + args.action + ".ajax?operFlg=" + args.operFlg;
            }

            if (args.data) {
                $.each(args.data, function(k, v) {
                    request_url += "&" + k + "=" + v
                });
            }

            $.ajax({
                type: "GET",
                url: request_url,
                dataType: "JSON",
                timeout: this.ajax_timeout,
                success: function(o) {
                    if (typeof(args.call) == 'string') {
                        eval(args.call + "(o)");
                    } else {
                        args.call( o );
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    E.loadding.close();
                    switch (textStatus) {
                        case 'timeout':
                            E.alert('哎呀，断网了，小M好烦呀！请君重新试下吧！');
                            break;
                    }
                }
            })
        },


        loadding: {

            p_id: "loadding",

            c_id: "loadding_cover_layer",

            l_flg: 0,

            open: function(message) {

                var html = "<div class=\"comm_loadding\" id=\"" + this.p_id + "\">";
                html += "<div><table><tbody><tr>";
                html += "<td class=\"loadding_img\"></td>";
                if (message) {
                    html += "<td class=\"loadding_str\">" + message + "</td>"
                } else {
                    html += "<td class=\"loadding_str\">请稍候...</td>"
                }
                html += "</tr></tbody></table></div></div>";

                E.coverLayer.open(this.c_id);
                $('#' + this.c_id).css('opacity', '0');
                $("body").append(html);

                this.l_flg = 1;

                if ($.browser && $.browser.msie && ($.browser.version == "6.0") && !$.support.style) {
                    var t = $(document).scrollTop();
                    $("#loadding").css("top", parseInt(t) + 100 + "px")
                }

            },

            close: function() {

                if (this.l_flg == 1) {
                    $("#" + this.p_id).remove();
                    E.coverLayer.close(this.c_id);
                    this.l_flg = 0
                }

            }
        },

        popup: {

            //公共弹出层ID
            p_id: 'e_popup',

            //公共弹出层的遮盖层ID
            c_id: 'popup_cover_layer',

            box_id: '',

            box_html: '',

            call_func: null,

            open: function( args, call_func ) {

                if (args.id) {
                    this.box_id = args.id;
                    this.box_html = $('#' + args.id).html();
                    args.content = this.box_html;
                    $('#' + args.id).html('')
                }

                if (!args.content)
                    args.content = '';

                if (!args.title)
                    args.title = '提示信息';

                if (!args.css)
                    args.css = 'width:1100px;';

                if (args.isCancelBtn == undefined)
                    args.isCancelBtn = 1;

                if (call_func != undefined) {
                    this.call_func = call_func;
                }

                if ($('#' + this.p_id).length > 0) {

                    $('#' + this.p_id).find('div.popup-content').html(args.content)

                } else {

                    var html = '<div class="e_popup" id="' + this.p_id + '">';
                    html += '<div class="popup-main" style="' + args.css + '">';
                    html += '<div class="popup-title">';
                    html += '<h3>' + args.title + '</h3>';
                    html += '<button title="关闭" onclick="E.popup.close();">';
                    html += '<span class="hide">╳</span>';
                    html += '</button>';
                    html += '</div>';
                    html += '<div class="popup-content">' + args.content + '</div>';
                    if (args.btnName || args.isCancelBtn) {
                        html += '<div class="popup-footer">';
                        if (args.btnName) {
                            html += '<button type="button" class="btn btn-success" onclick="' + args.btnCall + '" >' + args.btnName + '</button>&nbsp;&nbsp;'
                        }
                        if (args.isCancelBtn) {
                            html += '<button type="button" class="btn btn-default" onclick="E.popup.close();" >关闭</button>'
                        }
                        html += '</div>'
                    }
                    html += '</div>';
                    html += '</div>';
                    E.coverLayer.open(this.c_id, 900);
                    $('body').append(html);
                    if ($.browser && $.browser.msie && ($.browser.version == '6.0') && !$.support.style) {
                        var t = $(document).scrollTop();
                        $('#e_popup').css('', parseInt(t) + 100 + 'px')
                    }

                }
            },

            close: function( is_not_execute_func ) {

                if (!is_not_execute_func) {
                    is_not_execute_func = 0;
                }

                if (this.box_id != '') {
                    $('#' + this.box_id).html(this.box_html);
                    this.box_id = ''
                }

                if (is_not_execute_func == 0 && this.call_func) {
                    eval(this.call_func + '()');
                    this.call_func = null;
                }

                $('#' + this.p_id).remove();

                E.coverLayer.close(this.c_id);

            }

        },

        /**
         * 定位函数
         * @param id
         * @returns {{top: number, left: number}}
         */
        orientation: function(id) {

            var t_obj = l_obj = document.getElementById( id ),
                t = 0,
                l = 0;

            //顶部
            t += t_obj.offsetHeight;
            while(t_obj){
                if (t_obj.offsetTop == undefined){
                    break;
                }
                t += t_obj.offsetTop;
                t_obj = t_obj.offsetParent;
            }

            //左边
            while(l_obj){
                if (l_obj.offsetLeft == undefined){
                    break;
                }
                l += l_obj.offsetLeft;
                l_obj = l_obj.offsetParent;
            }

            return {top: t, left: l};

        },

        /**
         * 生成验证码
         * @param id img标签的id
         * @param len 验证码长度 2或4，默认为4
         */
        captcha: function(id, len) {
            if (!len)
                len = 4;
            var img = "/core/yzm.html?len=" + len + "&code=" + Math.ceil(Math.random() * 10000);
            $("#" + id).attr("src", img);
        },

        /**
         * 获得当前日期
         * @returns {string}
         */
        currentDate: function() {
            var dt = new Date(),
                y = dt.getFullYear(),
                m = parseInt(dt.getMonth()) + 1 > 9 ? parseInt(dt.getMonth()) + 1 : '0' + (parseInt(dt.getMonth()) + 1),
                d = dt.getDate() > 9 ? dt.getDate() : '0' + dt.getDate();
            return y + '-' + m + '-' + d;
        },

        /**
         * 获得当前日期+时间
         * @returns {string}
         */
        currentDatetime: function() {
            var dt = new Date(),
                y = dt.getFullYear(),
                m = parseInt(dt.getMonth()) + 1 > 9 ? parseInt(dt.getMonth()) + 1 : '0' + (parseInt(dt.getMonth()) + 1),
                d = dt.getDate() > 9 ? dt.getDate() : '0' + dt.getDate(),
                h = dt.getHours() > 9 ? dt.getHours() : '0' + dt.getHours(),
                i = dt.getMinutes() > 9 ? dt.getMinutes() : '0' + dt.getMinutes(),
                s = dt.getSeconds() > 9 ? dt.getSeconds() : '0' + dt.getSeconds();

            return y + '-' + m + '-' + d + ' ' + h + ':' + i + ':' + s;
        },

        /**
         * 全选列表
         */
        checkAllList: function() {

            $('#flex').find('tr').addClass('trSelected');

        },

        /**
         * 取消全选列表
         */
        cancelCheckAllList: function() {
            $('#flex').find('tr').removeClass('trSelected');
        },

        /**
         * 复制对象
         * @param obj
         * @returns {*}
         */
        clone: function( obj ) {

            var buf;
            if (obj instanceof Array) {
                buf = [];
                var i = obj.length;
                while (i--) {
                    buf[i] = E.clone(obj[i]);
                }
                return buf;
            } else if (obj instanceof Object) {
                buf = {};
                for ( var k in obj ) {
                    buf[k] = E.clone(obj[k]);
                }
                return buf;
            } else {
                return obj;
            }

        }

    };

    W.E = W.ebsig = E;

    window.onresize = function() {
        if (E.coverLayer.layer_is_open) {
            E.coverLayer.change()
        }
    };

    $(window).scroll(function() {
        var t = $(document).scrollTop();
        if ($.browser && $.browser.msie && ($.browser.version == "6.0") && !$.support.style) {
            $("#pannel_cart").css("top", parseInt(t) + 200 + "px");
            $("#e_layer").css("top", parseInt(t) + 100 + "px");
            $("#e_popup").css("top", parseInt(t) + 100 + "px")
        }
    });

})();

/**
 * 延迟加载
 */
(function() {
    var timer = null;
    var height = (window.innerHeight || document.documentElement.clientHeight) + 40;
    var images = [];
    function detect() {
        var scrollTop = (window.pageYOffset || document.documentElement.scrollTop) - 20;
        for (var i = 0,
                 l = images.length; i < l; i++) {
            var img = images[i];
            var offsetTop = img.el.offsetTop;
            if (!img.show && scrollTop < offsetTop + img.height && scrollTop + height > offsetTop) {
                img.el.setAttribute('src', img.src);
                img.show = true
            }
        }
    }
    function onScroll() {
        clearTimeout(timer);
        timer = setTimeout(detect, 100)
    }
    function onLoad() {
        var imageEls = document.getElementsByTagName('img');
        for (var i = 0,
                 l = imageEls.length; i < l; i++) {
            var img = imageEls.item(i);
            if (!img.getAttribute('data-src')) continue;
            images.push({
                el: img,
                src: img.getAttribute('data-src'),
                height: img.offsetHeight,
                show: false
            })
        }
        detect()
    }
    if (window.addEventListener) {
        window.addEventListener('scroll', onScroll, false);
        window.addEventListener('load', onLoad, false);
        document.addEventListener('touchmove', onScroll, false)
    } else {
        window.attachEvent('onscroll', onScroll);
        window.attachEvent('onload', onLoad)
    }
})();