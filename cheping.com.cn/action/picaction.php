<?php
/*
 * $Id$
 */
class picAction extends action {
    var $cardbfile;
    var $pagedata;
    var $filecount;
    var $factory;
    var $brand;
    var $series;
    function __construct() {
        parent::__construct();
        $this->models = new models();
        $this->factory = new factory();
        $this->series = new series();
        $this->brand = new brand();
        $this->cardbfile = new cardbfile();
        $this->pagedata = new pagedata();
        $this->filecount = new fileCount();
        $this->doSeriesHot();
        $this->vars('garage', 'garage');
    }

    function doSeriesHot() {
        $result = $this->pagedata->getSeriesHot();
        $this->vars('serieshot', $result);
    }

    function doDefault() {
        global $attach_server;
        $leftTree = $this->filecount->getBrandCountList();
        $page_title = "【汽车图片库_高清图片】汽车图片大全-ams车评网";
        $keywords = "汽车图片大全,高清汽车图片";
        $description = "ams车评网图片库为您提供最全汽车车型图片,车款图片,高清汽车内部空间、外观、内饰等精美图片供您观赏,更多精彩汽车图片尽在ams车评网";
        $this->vars('page_title', $page_title);
        $this->vars('keyword', $keywords);
        $this->vars('description', $description);
        #
        $picCarousel = $this->pagedata->getSomePagedata('*', "name='picindex'", 1);//这里是车款首页的轮播图
        if (!$picCarousel) {
            $picCarousel = array(array('file_pic' => '../../../images/440x251.jpg'));
        } else {
            #$picCarousel = $this->pagedata->mb_unserialize($picCarousel['value']);//反序列化
            $picCarousel = unserialize($picCarousel['value']);//反序列化
        }
        #
        $newColorPic = $this->filecount->getLastestList();
        #
        $hotColorPic = $this->cardbfile->getHotColorPic();
        if($attach_server[0]){
            $this->replace = array(
                'src="/attach/images/carouselpic' => 'src="' . $attach_server[0] . '/carouselpic'
            );
        }
        
        $this->vars('allbrand', $leftTree);
        $this->vars('newcolorpic', $newColorPic);
        $this->vars('hotcolorpic', $hotColorPic);
        $this->vars('piccarousel', $picCarousel);
        $this->tpl->assign('title', $page_title);
        $this->tpl->assign('keyword', $keywords);
        $this->tpl->assign('description', $description);
        $this->vars('js', array('global', 'jquery.touchSwipe.min', 'tppd_index', 'tppd_index_pd'));
        $this->vars('css', array('base', 'tppd_index','comm','jquery.autocomplete','newbase','common'));
        $this->vars('pageindex', 'pic');
        $lujing = array(
            'title' => '汽车图片',
            'b' => 'pic'
        );
        $this->vars('lujing',$lujing);
        $this->template('pic', '', 'replaceNewsChannel');
    }
    
    function doGetFactory(){
        $brand_id = intval($_GET['bid']);
        $this->factory->fields = "factory_id,factory_name";
        $this->factory->where = "brand_id='{$brand_id}' and state=3";
        $this->factory->order = array('factory_id' => 'asc');
        $factory = $this->factory->getResult(4);
        $this->brand->fields = "letter";
        $this->brand->where = "brand_id='{$brand_id}'";
        $brand_letter = $this->brand->getResult(3);
        $factory_pic_count = $this->filecount->getChildrenCountList('factory', $brand_id);
        foreach($factory as $k => $v){
            if($factory_pic_count[$k]){
                echo '<li class="first_tree">';
                echo "<p class='second_bg' onclick='factoryjia(this)' fid={$k}><i>{$v}</i><span class='mum'>(<font style='color:#ea1a14;'>{$factory_pic_count[$k]}</font>)</span></p>";
                echo "<ul id=serieslist_{$k}>";
                echo "</ul>";
                echo "</li>";
            }
        }
    }

    function doGetSeries(){
        $factory_id = intval($_GET['fid']);
        $this->series->fields = "series_id, series_name";
        $this->series->where = "factory_id='{$factory_id}' and state=3";
        $this->series->order = array('series_id' => 'asc');
        $series = $this->series->getResult(4);
        $series_pic_count = $this->filecount->getChildrenCountList('series', $factory_id);
        foreach($series as $k => $v){
            if($series_pic_count[$k]){
                echo "<li class=second_tree><a href='/image_searchlist_series_id_{$k}.html'><i>{$v}</i><span>(<font style='color:#ea1a14;'>{$series_pic_count[$k]}</font>)</span></a></li>";
            }
        }
    }
}

?>
