<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="left_top">
    <div class="left">
        <div class="nav" id="accordion">
            <a href="javascript:void(0);" onfocus="this.blur()">
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">权限管理</h2>
                </div>
            </a>
            <ul class="content1">
                <li><a href="index.php?action=user-userlist" target="pageFrame">用户及权限</a></li>
                <li><a href="index.php?action=usergroup-" target="pageFrame">用户组设置</a></li>
                <li><a href="index.php?action=module-" target="pageFrame">权限模块设置</a></li>
                <li><a href="index.php?action=user-changepassword" target="pageFrame">用户密码修改</a></li>
                <!--<li><a href="index.php?action=optlog-list" target="pageFrame">用户操作记录</a></li>-->
            </ul>
            <a href="javascript:void(0);" onfocus="this.blur()">
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">首页推送</h2>
                </div>
            </a>
            <ul class="content1">
                <li><a href="index.php?action=index-evalu" target='pageFrame'>ams专业测评</a></li>
                <li><a href="index.php?action=index-shopping" target='pageFrame'>精品导购</a></li>
                <li><a href="index.php?action=index-video" target='pageFrame'>精彩视频</a></li>
                <li><a href="index.php?action=index-article" target='pageFrame'>热门文章</a></li>
                <li><a href="index.php?action=index-tag" target='pageFrame'>精品分类</a></li>
                <li><a href="index.php?action=index-bannerIndex" target='pageFrame'>轮播图管理</a></li>
                <!--<li><a href="index.php?action=index-paramtype" target='pageFrame'>热门车型</a></li>-->
                <li><a href="index.php?action=remen-" target='pageFrame'>热门车型</a></li>
                <li><a href="index.php?action=index-manual" target='pageFrame'>手动添加信息</a></li>
                <li><a href="index.php?action=cpindex-modelpklist" target='pageFrame'>首页车型PK</a></li>
                <li><a href="index.php?action=cpindex-hotcarAct" target='pageFrame'>价格区间热门车</a></li>


            </ul>

            <a href="javascript:void(0);" onfocus="this.blur()">
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">频道管理</h2>
                </div>
            </a>
            <ul class="content1">
                <li><a href="index.php?action=category-list" target='pageFrame'>频道列表</a></li>
                <li><a href="index.php?action=category-add" target='pageFrame'>添加频道</a></li>
            </ul>
            <a href="javascript:void(0);" onfocus="this.blur()">
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">文章管理</h2>
                </div>
            </a>
            <ul class="content1">
                <li><a href="index.php?action=article-add" target='pageFrame'>文章发布</a></li>
                <li><a href="index.php?action=article-list" target='pageFrame'>文章管理</a></li>
                <li><a href="index.php?action=article-oldlist" target='pageFrame'>文章草稿箱</a></li>
            </ul>

            <a href="javascript:void(0);" onfocus="this.blur()">
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">视频管理</h2>
                </div>
            </a>
            <ul class="content1">
                <li><a href="index.php?action=video-list" target='pageFrame'>视频列表</a></li>
                <li><a href="index.php?action=video-add" target='pageFrame'>添加视频</a></li>
            </ul>

            <a href="javascript:void(0);" onfocus="this.blur()">
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">标签库</h2>
                </div>
            </a>
            <ul class="content1">
                <li><a href="index.php?action=tag-add" target='pageFrame'>新增标签</a></li>
                <li><a href="index.php?action=tag-list" target='pageFrame'>标签管理</a></li>
                <li><a href="index.php?action=tag-tagtag" target='pageFrame'>标签导出导入</a></li>
            </ul>

            <a href="javascript:void(0);" onfocus="this.blur()">
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">评论管理</h2>
                </div>
            </a>
            <ul class="content1">
                <li><a href="index.php?action=review-list&a=1" target='pageFrame'>评论管理</a></li>
                <li><a href="index.php?action=review-wordslist" target='pageFrame'>敏感词库</a></li>
                <li><a href="index.php?action=review-wordsadd" target='pageFrame'>敏感词新增</a></li>
            </ul>

            <a href="javascript:void(0);" onfocus="this.blur()">
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">产品管理</h2>
                </div>
            </a>
            <ul class="content1">
                <li><a href="index.php?action=tree-" target='pageFrame'>车辆数据管理</a></li>
                <li><a href="index.php?action=param-paramstat" target='pageFrame'>车款参数统计</a></li>
                <li><a href="index.php?action=paramtype-" target='pageFrame'>参数分类管理</a></li>
                <!--li><a href="index.php?action=paramtxt-" target='pageFrame'>文本参数管理</a></li-->
                <li><a href="index.php?action=param-" target='pageFrame'>标准参数管理</a></li>
                <!--li><a href="index.php?action=seriestype-Seriesimportant" target='pageFrame'>车系分类管理</a></li-->
                <li><a href="index.php?action=param-setting" target='pageFrame'>车系亮点配置管理</a></li>
                <li><a href="index.php?action=video-" target='pageFrame'>车辆视频管理</a></li>
                <li><a href="index.php?action=audit-" target='pageFrame'>数据审核管理</a></li>
                <li><a href="index.php?action=colorpic" target='pageFrame'>车身颜色管理</a></li>
                <li><a href="index.php?action=color&color_name=series" target='pageFrame'>车系颜色管理</a></li>
                <li><a href="index.php?action=color-colormodelindex&color_name=model" target='pageFrame'>车款颜色管理</a></li>
                <li><a href="index.php?action=realdata" target='pageFrame'>车型数据管理</a></li>
                <li><a href="index.php?action=seriesdata" target='pageFrame'>车型数据抓取管理</a></li>
                <li><a href="index.php?action=model-modelpiccollect" target='pageFrame'>车款数据采集管理</a></li>
                <li><a href="index.php?action=loan-" target='pageFrame'>车系贷款信息管理</a></li>
                <!--<li><a href="index.php?action=prefercar" target='pageFrame'>老旧车（6年以上）企补</a></li>-->
                <li><a href="index.php?action=procomment-" target='pageFrame'>专家评论管理</a></li>
                <li><a href="index.php?action=data-" target='pageFrame'>数据统计管理</a></li>
                <!--<li><a href="index.php?action=static-focus" target='pageFrame'>首页数据发布</a></li>-->
                <!--<li><a href="index.php?action=limitbuy" target='pageFrame'>抢购车款管理</a></li>-->
                <!--<li><a href="index.php?action=recommend" target='pageFrame'>推荐车型管理</a></li>-->
                <!--<li><a href="index.php?action=colorpic" target='pageFrame'>车身颜色管理</a></li>-->
                <!--<li><a href="index.php?action=color&color_name=series" target='pageFrame'>车系颜色管理</a></li>-->
                <!--<li><a href="index.php?action=color-colormodelindex&color_name=model" target='pageFrame'>车款颜色管理</a></li>-->
                <li><a href="index.php?action=series-serieshotlist" target='pageFrame'>热门车系图片搜索管理</a></li>
                <!--<li><a href="index.php?action=grabpic" target='pageFrame'>汽车图片抓取</a></li>-->
                <li><a href="index.php?action=showpic" target='pageFrame'>图片库轮播图生成</a></li>
                <li><a href="index.php?action=cpindex-hotartlist" target='pageFrame'>产品库-热点新闻</a></li>
                <li><a href="index.php?action=friendlink-" target='pageFrame'>产品库-友情链接管理</a></li>
                <li><a href="index.php?action=testdatacn-" target='pageFrame'>测试数据管理(中国区)</a></li>
            </ul>
            <!--<a href="javascript:void(0);" onfocus="this.blur()">-->
            <!--<div id="wrapper">-->
            <!--<div class="bj_img"></div>-->
            <!--<h2 class="navbar2 title1" id="btn1">价格管理</h2>-->
            <!--</div>-->
            <!--</a>-->
            <!--<ul class="content1">-->
            <!--&lt;!&ndash;<li><a href="index.php?action=dealer" target='pageFrame'>经销商管理</a></li>&ndash;&gt;-->
            <!--&lt;!&ndash;<li><a href="index.php?action=dealerprice&state=1" target='pageFrame'>车辆报价管理</a></li>&ndash;&gt;-->
            <!--&lt;!&ndash;<li><a href="index.php?action=bingoprice" target='pageFrame'>商情价管理</a></li>&ndash;&gt;-->
            <!--&lt;!&ndash;<li><a href="index.php?action=cardbpricelog" target='pageFrame'>商情价历史记录</a></li>&ndash;&gt;-->
            <!--&lt;!&ndash;<li><a href="index.php?action=priceerrorlog" target='pageFrame'>价格导入出错日志</a></li>&ndash;&gt;-->
            <!--&lt;!&ndash;<li><a href="index.php?action=dealeradvice" target='pageFrame'>经销商反馈</a></li>&ndash;&gt;-->
            <!--&lt;!&ndash;<li><a href="index.php?action=cardbprice-mediaprice" target='pageFrame'>媒体价管理</a></li>&ndash;&gt;-->
            <!--&lt;!&ndash;<li><a href="index.php?action=websaleinfo-nov11" target='pageFrame'>双11活动管理</a></li>&ndash;&gt;-->
            <!--&lt;!&ndash;<li><a href="index.php?action=promotion" target='pageFrame'>促销信息管理</a></li>&ndash;&gt;-->
            <!--&lt;!&ndash;<li><a href="index.php?action=yu" target='_blank'>于国洋价格后台</a></li>&ndash;&gt;-->
            <!--&lt;!&ndash;<li><a href="index.php?action=grabyiche" target='pageFrame'>易车商城数据</a></li>&ndash;&gt;-->
            <!--</ul>-->
            <!--            <a onfocus="this.blur()" href="javascript:void(0);">
                            <div id="wrapper">
                                <div class="bj_img"></div>
                                <h2 class="navbar2 title1" id="btn1">车系标签/外面</h2>
                            </div>
                        </a>      
                        <ul class="content1">
                            <li><a href="index.php?action=mark-list" target='pageFrame'>车系标签管理</a></li>
                            <li><a href="index.php?action=seriespic-" target='pageFrame'>车系外观图管理</a></li>
                            <li><a href="index.php?action=seriespic-SeriesList2" target='pageFrame'>车系白底图管理</a></li>
                           
                        </ul>         -->
            <a onfocus="this.blur()" href="javascript:void(0);">
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">短信管理</h2>
                </div>
            </a>      
            <ul class="content1">
                <li><a href="index.php?action=sms-" target='pageFrame'>短信模板管理</a></li>
                <li><a href="index.php?action=sms-add" target='pageFrame'>添加短信模板</a></li>
                <li><a href="?action=shortmsg" target='pageFrame'>短信记录管理</a></li>

            </ul> 
            <a onfocus="this.blur()" href="javascript:void(0);">
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">SEO管理</h2>
                </div>
            </a>      
            <ul class="content1">
                <li><a href="index.php?action=seo-silian" target='pageFrame'>百度死链接文件</a></li>
                <li><a href="index.php?action=friend-friends" target='pageFrame'>友情链接</a></li>
            </ul> 
            <a href="javascript:void(0);" onfocus="this.blur()">
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">辅助工具</h2>
                </div>
            </a>
            <ul class="content1">      
                <li><a href="index.php?action=rss-rsslist" target='pageFrame'>Rss订阅</a></li>
                <li><a href="index.php?action=static-" target='pageFrame'>数据生成管理</a></li>
                <li><a href="index.php?action=pic-" target='pageFrame'>水印管理</a></li>
                <li><a href="index.php?action=cachedata" target='pageFrame'>缓存数据管理</a></li>
            </ul>

            <a href="javascript:void(0);" onfocus="this.blur()"> 
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">注册用户管理</h2>
                </div>
            </a>
            <ul class="content1">
                <li><a  target='pageFrame' href="index.php?action=reguser-userlist">用户管理</a></li>
                <li><a  target='pageFrame' href="index.php?action=reguser-add">添加用户</a></li>
            </ul>
            <a href="javascript:void(0);" onfocus="this.blur()"> 
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">APP管理</h2>
                </div>
            </a>
            <ul class="content1">
                <li><a  target='pageFrame' href="index.php?action=app-applist">APP悦览</a></li>
                <li><a href="index.php?action=app-bannerIndex" target='pageFrame'>APP轮播图管理</a></li>
                <li><a href="index.php?action=app-SearchList" target='pageFrame'>APP搜索关键词</a></li>
                <li><a target='pageFrame' href="index.php?action=app-">APP评论管理</a></li>
                <li><a target='pageFrame' href="index.php?action=app-advice">APP用户反馈</a></li>
            </ul>
            <a href="javascript:void(0);" onfocus="this.blur()"> 
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">WAP管理</h2>
                </div>
            </a>
            <ul class="content1">
                <li><a href="index.php?action=wap-bannerIndex&a=0" target='pageFrame'>WAP轮播图管理</a></li>
            </ul>
            <a href="javascript:void(0);" onfocus="this.blur()">
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">专题管理</h2>
                </div>
            </a>
            <ul class="content1">
                <li><a href="index.php?action=theme-guangzhoubanner" target='pageFrame'>2015广州车展</a></li>
            </ul>
            <a href="javascript:void(0);" onfocus="this.blur()">
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">风云车投票统计</h2>
                </div>
            </a>
            <ul class="content1">
                <li><a href="index.php?action=vote" target='pageFrame'>统计数据</a></li>
            </ul>
            <a href="javascript:void(0);" onfocus="this.blur()">
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">统计查询</h2>
                </div>
            </a>
            <ul class="content1">
                <li><a  target='pageFrame' href="index.php?action=webstat-">网站流量</a></li>
                <!-- <li><a  target='pageFrame' href="index.php?action=webstat-allStatCount">统计昨天访问量</a></li>
                <li><a  target='pageFrame' href="index.php?action=webstat-allStat">统计所有访问量</a></li> -->
<!--                <li><a  target='pageFrame' href="index.php?action=webstat-statreguser">统计昨天用户量</a></li>
                <li><a  target='pageFrame' href="index.php?action=webstat-allregstat">统计所有用户量</a></li>-->
            </ul>
            <!--             <a href="javascript:void(0);" onfocus="this.blur()">
                            <div id="wrapper">
                                <div class="bj_img"></div>
                                <h2 class="navbar2 title1" id="btn1">产品-首页模块</h2>
                            </div>
                        </a>
                        <ul class="content1">
                            <li><a href="index.php?action=cpindex-allModelList" target='pageFrame'>首页更新预览</a></li>
                            <li><a href="index.php?action=cpindex-hotcarAct" target='pageFrame'>热门车</a></li>
                            <li><a href="index.php?action=cpindex-lookact" target='pageFrame'>大家都在看</a></li>
                            <li><a href="index.php?action=cpindex-searchAct" target='pageFrame'>大家都在搜</a></li>
                            <li><a href="index.php?action=cpindex-focuslist&num=5" target='pageFrame'>轮播图5</a></li>
                            <li><a href="index.php?action=cpindex-focuslist&num=2" target='pageFrame'>轮播图上下图</a></li>
                            <li><a href="index.php?action=cpindex-hotartlist" target='pageFrame'>热点新闻</a></li>
                            <li><a href="index.php?action=cpindex-newcarlist" target='pageFrame'>即将上市</a></li>
                            <li><a href="index.php?action=cpindex-rmdSeriesList" target='pageFrame'>新购推荐模块</a></li>
                            <li><a href="index.php?action=cpindex-discountlist" target='pageFrame'>汽车暗访报告</a></li>
                            <li><a href="index.php?action=cpindex-recommendlist" target='pageFrame'>猜你喜欢</a></li>
                            <li><a href="index.php?action=cpindex-modelpklist" target='pageFrame'>车型PK</a></li>
                            <li><a href="index.php?action=cpindex-loanreplacelist" target='pageFrame'>置换/贷款</a></li>
                            <li><a href="index.php?action=friendlink-" target='pageFrame'>友情链接管理</a></li>
                        </ul> -->
            <a href="javascript:void(0);" onfocus="this.blur()">
                <div id="wrapper">
                    <div class="bj_img"></div>
                    <h2 class="navbar2 title1" id="btn1">APP论坛管理</h2>
                </div>
            </a>
            <ul class="content1">
                <li><a href="index.php?action=bbs-recommendlist" target='pageFrame'>精选推荐帖管理</a></li>
                <li><a href="index.php?action=bbspost-publishpost" target='pageFrame'>发布帖子</a></li>
                <li><a href="index.php?action=bbspost-postslist" target='pageFrame'>用户帖子管理</a></li>
                <li><a href="index.php?action=bbs-forumslist" target='pageFrame'>论坛板块管理</a></li>
                <li><a href="index.php?action=bbspost-behaviourlist" target='pageFrame'>用户行为管理</a></li>
            </ul>
        </div>
    </div>
    <div class="left1_bottom"></div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#accordion ul').not(':first').hide();
        $('div.bj_img:first').addClass('bj_img2');
        $(".nav h2").click(function () {
            $(this).parents("a").next().slideDown();
            $('#accordion ul').not($(this).parents("a").next()).slideUp();
            $('div.bj_img').removeClass('bj_img2');
            $(this).prev("div").toggleClass("bj_img2");
        });

        $('a[target="pageFrame"]').click(function () {
            $('a[target="pageFrame"]').attr('class', '');
            $(this).attr('class', 'focus');
        })

    });

    function open_module(module_id, module_name, moduleURL, module_target)
    {
        parent.getElementById("module_id").value = module_id;
        alert(parent.getElementById("module_id").value);
    }
</script>
</body>
<!--end left menu-->

