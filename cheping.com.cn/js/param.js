
//浮动窗体
//<![CDATA[
        var tips;var theTop = 40/*这是默认高度,越大越往下*/;var old = theTop;
        function initFloatTips(objid) {
            tips = document.getElementById(objid);
            tips.style.left = 230+"px";
            moveTips();
        };
        function moveTips() {
            var tt=50;
            if (window.innerHeight) {
                pos = window.pageYOffset
            }
            else if (document.documentElement && document.documentElement.scrollTop) {
                pos = document.documentElement.scrollTop
            }
            else if (document.body) {
                pos = document.body.scrollTop;
            }
            pos=pos-tips.offsetTop+theTop;
            pos=tips.offsetTop+pos/10;

            if (pos < theTop) pos = theTop;
            if (pos != old) {
                tips.style.top = pos+"px";
                tt=10;
            }
            old = pos;
            setTimeout("moveTips()",tt);
        }
        //!]]>
        function add_index(){
            if(a_index>=$("#show .switch_point a").size()-1){
                a_index=0;
            }else{
                a_index++;
            }
            $('#show .switch_point a').removeClass('selected');
            $('#show .switch_point a').eq(a_index).addClass('selected');
        }
        function min_index(){
            if(a_index<=0){
                a_index=$("#show .switch_point a").size()-1;
            }else{
                a_index--;
            }
            $('#show .switch_point a').removeClass('selected');
            $('#show .switch_point a').eq(a_index).addClass('selected');
        }

        function hover_click(name){
            $('input.'+name).hover(function(){
                $(this).addClass(name+'_hover');
            },function(){
                $(this).removeClass(name+'_hover');
            }).mousedown(function(){
                $(this).addClass(name+'_click');
            }).mouseout(function(){
                $(this).removeClass(name+'_click');
            }).focus(function(){
                $(this).blur();
            });
        }

        function setFrameBgColor(color)
        {
          try{
            window.mask.document.body.bgColor=color;
          }catch(e){}
            
        }

        /*滚动条滚动*/
        function windowScroll(){
            var scrollPos;
            if (typeof window.pageYOffset != 'undefined') {
                scrollPos = window.pageYOffset;
            }
            else if (typeof document.compatMode != 'undefined' &&
                document.compatMode != 'BackCompat') {
                scrollPos = document.documentElement.scrollTop;
            }
            else if (typeof document.body != 'undefined') {
                scrollPos = document.body.scrollTop;
            }

            if(scrollPos>=240){
                $('.float').css({
                    'position':'fixed',
                    'height':'215px'
                });

            }else{
                $('.float').css({
                    'position':'static',
                    'height':'230px'
                });

            }

        };
