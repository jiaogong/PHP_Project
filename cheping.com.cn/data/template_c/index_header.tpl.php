<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><? if ($title) { ?><?=$title?><? } else { ?>车评网<? } ?></title>
    <meta name="keywords" content="<? if ($keyword) { ?><?=$keyword?><? } else { ?>车评网<? } ?>" />
    <meta name="description" content="<? if ($description) { ?><?=$description?><? } else { ?>车评网<? } ?>" />
    <meta name="applicable-device" content="pc">
    <meta name="mobile-agent" content="format=html5;url=<? if ($_SERVER['REQUEST_URI']=='www.cheping.com.cn/') { ?>http://m.cheping.com.cn/<? } elseif($_SERVER['REQUEST_URI']=='v.cheping.com.cn/') { ?>http://m.cheping.com.cn/v/<? } elseif($_SERVER['REQUEST_URI']=='pingce.cheping.com.cn/') { ?>http://m.cheping.com.cn/pingce/<? } elseif($_SERVER['REQUEST_URI']=='news.cheping.com.cn/') { ?>http://m.cheping.com.cn/news/<? } elseif($_SERVER['REQUEST_URI']=='pingce.cheping.com.cn/') { ?>http://m.cheping.com.cn/pingce/<? } elseif($_SERVER['REQUEST_URI']=='wenhua.cheping.com.cn/') { ?>http://m.cheping.com.cn/wenhua/<? } ?>">
    <link rel="alternate" media="only screen and (max-width: 640px)" href="http://m.cheping.com.cn/" >
    <? if ($garage !== 'garage' && !in_array('index', $css)) { ?>
    <link href="<?=$static_domain?><?=$relative_dir?>css/index.css" rel="stylesheet" type="text/css" />
    <? } ?>
    <? if ($css) { ?>
    <? foreach((array)$css as $k=>$v) {?>
    <link rel="stylesheet" href="<?=$static_domain?><?=$relative_dir?>css/<?=$v?>.css?v=0.3" />
    <?}?>
    <script type="text/javascript" src="<?=$static_domain?><?=$relative_dir?>js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="<?=$static_domain?><?=$relative_dir?>js/jquery_lazyload.js"></script>
    <script type="text/javascript" src="<?=$static_domain?><?=$relative_dir?>js/searchSuggest.js"></script>
    <? } ?>

    <? if ($js) { ?>
    <? foreach((array)$js as $k=>$v) {?>
    <script src="<?=$static_domain?><?=$relative_dir?>js/<?=$v?>.js" type="text/javascript"></script>
    <?}?>
    <? } ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#but_login').click(function () {
            $('.theme-popover-mask').fadeIn(100);
            $('.theme-popover').slideDown(200);
        })
        $('.theme-poptit .close').click(function () {
            $('.theme-popover-mask').fadeOut(100);
            $('.theme-popover').slideUp(200);
        });
    });
    //allow_mobile
    <? if ($allow_mobile !== 1) { ?>
    if ((navigator.userAgent.match(/(iPhone|iPod|Android|ios|iOS|Symbian|Phone|BlackBerry)/i))) {
        location.replace("http://m.cheping.com.cn")
    }
    <? } ?>
</script>
</head>
<body id="tou">
    <? if ($garage !== 'garage') { ?>
    <div class="header">
        <div class="nav_xf">
            <div class="navmain">
                <div class="nav">  
                    <ul>
                        <li><a href="/">首页</a></li>
                        <li class="jv"><a href="video.php?action=Video&id=9">视频</a></li>
                        <li class="jv"><a href="article.php?action=CarReview&id=8">评测</a></li>
                        <li class="jv"><a href="article.php?action=CarReview&id=7">资讯</a></li>
                        <li class="jv"><a href="article.php?action=CarReview&id=10">文化</a></li>
                        <li class="jv"><a href="/search.php?action=index">选车</a></li>
                    </ul>
                </div>
                <div class="denglu_zhuce">
                    <ul id="header_login">
                        <li class="zcdl"><a class="btn btn-primary btn-large"  href="/login.php">登录</a></li>  
                        <li class="zcdl"><a href="/register.php">注册</a></li>
                    </ul>
                    <ul id='header_content' style="display: none">
                        <li class="zcdl"><a href="/user.php" id='header_username'></a></li> 
                        <li class="zcdl"><a href="javascript:void(0)" onclick='logout(0)'>退出</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="logoo">
        <div class="logo">
            <div class="logo_top"></div>
            <div class="logo_foot"></div>
        </div>
        <div class="logo_main">
            <div class="logo_con">
                <div class="logo_img fl"><a href="/"><img src="/images/logo.png" alt="ams车评网" /></a></div>
                <!--//车型大全-->
                <? if ($carall) { ?>
                <div class="cp_head_03_left">
                    <div class="cp_head_03_left_cont">

                        <p class="sy_ss">
                            <input type="button" value="车型大全" style="font-size:20px; color:#fff; cursor: pointer;" />
                            <img class="red_sanjiao" src="images/red_daosanjiao.png" />
                        </p>
                        <div class="spzc_content">
                            <div class="spzc_content2">

                            </div>
                            <div class="series_content">

                            </div>
                        </div>
                    </div>
                </div>
                <? } ?>
                <!--//车型大全 end-->
                <div id="searchSuggest">
                    <form action="http://www.cheping.com.cn/search.php" method="get" id="suggest_form">
                        <input type="text" name="keywords" id="suggest_input" autocomplete="off" <? if (!$keywords) { ?>placeholder="请输入您想要查找的文章标题或关键词"<? } else { ?>value="<?=$keywords?>"<? } ?> />
                               <input type="submit" value="" id="suggest_submit" />
                    </form>
                    <ul id="suggest_ul">
                    </ul>
                </div>
            </div>  
        </div>
    </div>   
    <? } else { ?>
    <div class="header">
        <div class="nav_xf">
            <div class="navmain">
                <div class="nav">  
                    <ul>
                        <li><a href="/">首页</a></li>
                        <li class="jv"><a href="video.php?action=Video&id=9">视频</a></li>
                        <li class="jv"><a href="article.php?action=CarReview&id=8">评测</a></li>
                        <li class="jv"><a href="article.php?action=CarReview&id=7">资讯</a></li>
                        <li class="jv"><a href="article.php?action=CarReview&id=10">文化</a></li>
                        <li class="jv"><a href="/search.php?action=index">选车</a></li>
                    </ul>
                </div>
                <div class="denglu_zhuce">
                    <ul id="header_login">
                        <li class="zcdl"><a class="btn btn-primary btn-large"  href="/login.php">登录</a></li>  
                        <li class="zcdl"><a href="/register.php">注册</a></li>
                    </ul>
                    <ul id='header_content' style="display: none">
                        <li class="zcdl"><a href="/user.php" id='header_username'></a></li> 
                        <li class="zcdl"><a href="javascript:void(0)" onclick='logout(0)'>退出</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <? if (!$sousuo_nav) { ?>
        <div class="LOGO_sousuo">
            <div class="logo">
                <a href="/search.php?action=index"><img src="images/garagelogo.png" style="margin-top:0px; float:left;"></a>
                <div class="logonav">
                    <ul>
                        <li <? if ($lujing[b] == 'search') { ?>class="beijng"<? } ?>><a href="/search.php?action=index">选车</a></li>
                        <li <? if ($lujing[b] == 'pic') { ?>class="beijng"<? } ?>><a href="/pic.html" target="_blank">图片</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="kongxi">
            <div style="width:1180px; margin:0 auto; line-height:25px;"></div>
        </div>
        <div class="mianbaoxian">
            <a href="/">ams车评网首页</a> > 
            <? if ($lujing['title']) { ?><?=$lujing['title']?><? } ?>
            <? if ($model['brand_name']) { ?>
            <a href="/search.php?action=index&br=<?=$model['brand_id']?>"><?=$model['brand_name']?></a> > 
            <? if (!$model['default_model']) { ?>
            <?=$model['series_name']?>
            <? } else { ?>
            <a href="modelinfo_<?=$model['default_model']?>.html"><?=$model['series_name']?></a> >
            <? } ?>
             <?=$model['model_name']?>
            <? if ($type_model == 'model') { ?><?=$model['model_name']?><? } ?>
            <? } ?>
            <? if ($seriesinfo['brand_name']) { ?>
            <a href="pic.php">图库</a> > 
            <a href="image_searchbrandlist_brand_id_<?=$seriesinfo['brand_id']?>.html"><?=$seriesinfo['brand_name']?></a> > <?=$seriesinfo['factory_name']?>>
            <a href="image_searchlist_series_id_<?=$seriesinfo['series_id']?>.html"><?=$seriesinfo['series_name']?></a> > <?=$seriesinfo['model_name']?>
            <? } ?>
            <? if ($model_info['brand_id']) { ?>
            <a href="/search.php?action=index&br=<?=$model_info['brand_id']?>" target="_blank">
                <?=$model_info['brand_name']?></a> > 
            <a href="modelinfo_<?=$model_info['model_id']?>.html" target="_blank">
                <?=$model_info['model_name']?></a> > 
            商情页
            <? } ?>
        </div>
        <div class="sousuo">
            <div id="searchSuggest">
                <form action="http://www.cheping.com.cn/search.php" method="get" id="suggest_form">
                    <input type="text" name="keywords" id="suggest_input" autocomplete="off" <? if (!$keywords) { ?>placeholder="请输入您想要查找的文章标题或关键词"<? } else { ?>value="<?=$keywords?>"<? } ?> />
                           <input type="submit" value="" id="suggest_submit" />
                </form>
                <ul id="suggest_ul"></ul>
            </div>
        </div>
        <? } else { ?>
        <div class="LOGO_sousuo">
            <div class="logo_box">
                <a href="/search.php?action=index"><img src="images/garagelogo.png" style="margin-top:0px; float:left;"></a> 
            </div>
        </div>
        <div class="sousuo">
            <div id="searchSuggest">
                <form action="http://www.cheping.com.cn/search.php" method="get" id="suggest_form">
                    <input type="text" name="keywords" id="suggest_input" autocomplete="off" <? if (!$keywords) { ?>placeholder="请输入您想要查找的文章标题或关键词"<? } else { ?>value="<?=$keywords?>"<? } ?> />
                    <input type="submit" value="" id="suggest_submit" />
                </form>
                <ul id="suggest_ul"></ul>
            </div>
        </div>
        <div class="clear"></div>
        <? } ?>
        
    </div>
    <? } ?>