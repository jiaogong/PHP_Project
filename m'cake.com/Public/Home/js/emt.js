(function() {

    function e_track() {

        var info = E.getCookie('__etrack'),
            guid,
            userid = G.args.userid,
            switch_id = E.getCookie('__etrack_switch'),
            referrer = E.getReferrer(),
            referrer_obj = E.parseURL(referrer),
            current_url_obj = E.parseURL(E.getUrl()),
            key1 = current_url_obj.params.key1 ? current_url_obj.params.key1 : '',
            key2 = current_url_obj.params.key2 ? current_url_obj.params.key2 : '',
            key3 = current_url_obj.params.key3 ? current_url_obj.params.key3 : '',
            is_register = G.args.page_name == 'register_success' ? 1 : 0,
            source_type = 1,
            city_id = E.getCookie('EBSIG_CITY_ID');

        var tracker_code = '';
        if (current_url_obj.params.tracker_code) {
            tracker_code = current_url_obj.params.tracker_code;
        } else if (current_url_obj.params.tracker_u) {
            tracker_code = current_url_obj.params.tracker_u;
        } else if (current_url_obj.params.t) {
            tracker_code = current_url_obj.params.t;
        }

        if (info) {
            var arr = info.split('|');
            guid = arr[0];
            if ( (!arr[1] && userid != '') || (arr[1] && userid != '' && arr[1] != userid) ) {
                E.setCookie('__etrack', guid + '|' + userid , 63072000, G.args.cookie_domain);
            }
        } else {
            guid = E.createGuid();
            if (userid == null)
                userid = '';
            E.setCookie('__etrack', guid + '|' + userid, 63072000, G.args.cookie_domain);
        }

        var is_change_referrer = 0;
        if (referrer_obj.host && referrer_obj.host.indexOf('mcake.com') == -1 && referrer_obj.protocol + '://' + referrer_obj.host != G.args.domain) {
            is_change_referrer = 1;
        }

        if (tracker_code) {

            if (tracker_code != E.getCookie('__etrack_tracker_code')) {
                E.setCookie('__etrack_key1', '', 2592000, G.args.cookie_domain);
                E.setCookie('__etrack_key2', '', 2592000, G.args.cookie_domain);
                E.setCookie('__etrack_key3', '', 2592000, G.args.cookie_domain);
                switch_id = '';
            }

            E.setCookie('__etrack_tracker_code', tracker_code, 2592000, G.args.cookie_domain);

        } else {

            if (key1 || key2 || key3 || is_change_referrer) {
                E.setCookie('__etrack_tracker_code', '', 2592000, G.args.cookie_domain);
            } else {
                tracker_code = E.getCookie('__etrack_tracker_code');
            }

        }

        if (key1 || is_change_referrer == 1) {
            E.setCookie('__etrack_key1', key1, 2592000, G.args.cookie_domain);
        } else {
            key1 = E.getCookie('__etrack_key1');
        }

        if (key2 || is_change_referrer == 1) {
            E.setCookie('__etrack_key2', key2, 2592000, G.args.cookie_domain);
        } else {
            key2 = E.getCookie('__etrack_key2');
        }

        if (key3 || is_change_referrer == 1) {
            E.setCookie('__etrack_key3', key3, 2592000, G.args.cookie_domain);
        } else {
            key3 = E.getCookie('__etrack_key3');
        }

        if (!switch_id || is_change_referrer) {
            switch_id = E.createGuid();
            if (key1 == 'cps' || key1 == 'dsp') {
                E.setCookie('__etrack_switch', switch_id, 1296000, G.args.cookie_domain);
            } else {
                E.setCookie('__etrack_switch', switch_id, 86400, G.args.cookie_domain);
            }
        }

        if (is_change_referrer) {
            E.setCookie('__etrack_referrer', referrer, 2592000, G.args.cookie_domain);
            E.setCookie('__etrack_referrer_time', E.currentDatetime(), 2592000, G.args.cookie_domain);
        }


        if (userid) {
            if (G.cust.cust_id) {
                var logintype = 1; //有密码登录
            } else {
                var logintype = 2; //无密码登录
            }
        } else {
            var logintype = 0;
        }

        var requestString = 'referer_url=' + encodeURIComponent(referrer) +
            '&access_url=' + encodeURIComponent(E.getUrl()) +
            '&userAgent=' + E.browser() +
            '&user_name=' + userid +
            '&session_id=' + guid +
            '&source_type=' + source_type +
            '&screen_resolution=' + E.getScreen() +
            '&page_name1=' + G.args.page_name +
            '&page_name2=' + G.args.sub_page_name +
            '&switch_id=' + switch_id +
            '&is_register=' + is_register +
            '&device=' + E.getDevice() +
            '&browser=' + E.browser() +
            '&tracker_code=' + tracker_code +
            '&key1=' + key1 +
            '&key2=' + key2 +
            '&key3=' + key3 +
            '&logintype=' + logintype +
            '&city_id=' + city_id;
        var url = G.args.domain + '/external/track.php?' + requestString;

        var f = document.createElement('iframe');
        f.height = 0;
        f.width = 0;
        f.style.visibility = 'hidden';
        f.style.display = 'none';
        f.frameborder = 0;
        f.src = url;
        document.body.appendChild(f);

    }

    e_track();

})();