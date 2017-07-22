<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? if ($title) { ?><?=$title?><? } else { ?>车评网<? } ?></title>
<meta name="keywords" content="<? if ($keyword) { ?><?=$keyword?><? } else { ?>车评网<? } ?>" />
<meta name="description" content="<? if ($description) { ?><?=$description?><? } else { ?>车评网<? } ?>" />
<link rel="alternate" media="only screen and (max-width: 640px)" href="http://m.cheping.com.cn/" >
<script src="js/function.js" language="javascript" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/searchSuggest.js"></script>
<? if ($css) { ?>
<? foreach((array)$css as $k=>$v) {?>
<link rel="stylesheet" href="css/<?=$v?>.css" />
<?}?>
<? } ?>
<? if ($js) { ?>
<? foreach((array)$js as $k=>$v) {?>
<script src="js/<?=$v?>.js" type="text/javascript"></script>
<?}?>
<? } ?>
</head>
<body>
<div class="header"><!--头部-->
   <div class="nav_xf">
   <div class="nav">
       <ul>
           <li><a href="/">首页</a></li>
           <li class="jv"><a href="video.php?action=Video&id=9">视频</a></li>
           <li class="jv"><a href="article.php?action=CarReview&id=8">评测</a></li>
           <li class="jv"><a href="article.php?action=CarReview&id=7">资讯</a></li>
           <li class="jv"><a href="article.php?action=CarReview&id=10">文化</a></li>
           <li class="jv"><a href="/search.php?action=index">选车</a></li>
       </ul>
      <div class="denglu_zhuce">
        <ul id="header_login">
         <li><a href="/register.php">注册</a></li>
         <li class="zcdl"><a class="btn btn-primary btn-large" href="/login.php">登陆</a></li>  
        </ul>
          <ul id='header_content' style="display: none">
              <li class="zcdl"><a href="javascript:void(0)" onclick='logout(1)'>退出</a></li>
              <li class="zcdl"><a href="/user.php" id='header_username'></a></li>  
        </ul>
      </div>
   </div>
   </div>
   <div class="LOGO_sousuo">
      <div class="logo">
	    <a href="/"><img src="images/gelogo.jpg" style="padding:18px 0" alt="ams车评网"></a>
	  </div>
   </div>
   <div class="kongxi"></div>
   <div class="sousuo">
	<div id="searchSuggest">
            <form action="http://www.cheping.com.cn/search.php" method="get" id="suggest_form">
                <input type="text" name="keywords" id="suggest_input" autocomplete="off" <? if (!$keywords) { ?>placeholder="请输入您想要查找的文章标题或关键词"<? } else { ?>value="<?=$keywords?>"<? } ?> />
                <input type="submit" value="" id="suggest_submit" />
            </form>
            <ul id="suggest_ul">
            </ul>
        </div>
   </div>
</div><!--头部结束-->