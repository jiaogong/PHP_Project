<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?=$page_title?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <? if ($pageindex=='loginleft') { ?>
        <link rel="stylesheet" href="css/add.css" />
        <? } elseif($pageindex=='login') { ?>
        <link rel="stylesheet" type="text/css" href="css/login.css"/>
        <link rel="stylesheet"  href="css/publick.css" />
        <? } else { ?>
        <link rel="stylesheet" href="css/issue.css" />
        <? } ?>
        <link rel="stylesheet" type="text/css" href="<?=$admin_path?>css/jquery.ui.theme.css"/>
        <link rel="stylesheet" type="text/css" href="<?=$admin_path?>css/jquery.ui.datepicker.css"/>
        <link rel="stylesheet" type="text/css" href="<?=$admin_path?>css/jquery.tooltip.css"/>
        <link rel="stylesheet" type="text/css" href="<?=$admin_path?>css/style.css"/>
        <? if ($carSelect['factorySelect']) { ?>
        <script>var factory_js = <? echo json_encode($carSelect['factorySelect']) ?></script>
        <script>var series_js = <? echo json_encode($carSelect['seriesSelect']) ?></script>
        <? } ?>
        <script src="<?=$admin_path?>js/jquery-1.6.2.min.js"></script>
        <script src="<?=$admin_path?>js/jquery-ui.min.js" type="text/javascript"></script> 
        <!--script src="<?=$admin_path?>js/jquery-ui-1.9.2.custom.min.js" type="text/javascript"></script--> 
        <script src="<?=$admin_path?>js/jquery.ui.datepicker.js" type="text/javascript"></script>
        <script src="<?=$admin_path?>js/jquery.blockUI.js" type="text/javascript"></script> 
        <script src="<?=$admin_path?>js/jquery-form.js" type="text/javascript"></script>
        <script src="<?=$admin_path?>js/common.js" type="text/javascript"></script> 
        <script src="<?=$admin_path?>js/global.func.js" type="text/javascript"></script> 
        <script src="<?=$admin_path?>js/jquery.ui.datepicker-zh-CN.js" type="text/javascript"></script> 
        <script src="<?=$admin_path?>js/jtip.js" type="text/javascript"></script>
    </head>
    
    <body>
        <script type="text/javascript">
            $(".nav ul li a").click(function () {
                if ($(this).has(".song")) {
                    $(this).addClass("song").parent("li").siblings("li").find("a").removeClass("song");
                }
            })
        </script>