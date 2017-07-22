<?php

/**
 * 预览页面(独立页面及SSI页面)效果的方法，请放此action中实现
 * previewAction code
 * $Id: previewaction.php 1434 2015-11-25 10:12:30Z david $
 * @author Daivd.Shaw <tudibao@163.com>
 */
class previewAction extends action {

    function __construct() {
        parent::__construct();
    }

    function doDefault() {
        //TODO;;
    }

    function doArticle($id_arr = array()) {
        global $local_host;
        $id = $this->getValue('id')->Int();
        if ($id) {
            $id_arr = array($id);
        }

        #实际处理的文章数量
        $actual_cnt = 0;
        #要处理的文章数量
        $need_cnt = count($id_arr);
        $this->tpl_file = "article_page";
        $make_flag = $this->getValue('make_flag')->Int();

        #单文章支持预览及生成，多文章时，只支持生成不能预览
        if (empty($id_arr) || ($need_cnt > 1 && !$make_flag)) {
            return false;
        }

        #初始化文章需要的model
        $article_obj = new article();
        $articlepic_obj = new articlepic();
        $articlelogs_obj = new articlelogs();
        $articleseries_obj = new articleseries();
        $brand_obj = new brand();
        $series_obj = new series();
        $models_obj = new cardbModel();
        $tags_obj = new tags();
        $category_obj = new category();

        #如果预览，替换SSI头部文件中的相对路径为绝对路径
        $this->replace = array(
            'href="css/' => 'href="' . $local_host . RELAT_DIR . 'css/',
            'src="js/' => 'src="' . $local_host . RELAT_DIR . 'js/',
            'src="images/' => 'src="' . $local_host . RELAT_DIR . 'images/',
            'src="attach/' => 'src="' . $local_host . RELAT_DIR . 'attach/',
            'href="/css/' => 'href="' . $local_host . RELAT_DIR . 'css/',
            'src="/js/' => 'src="' . $local_host . RELAT_DIR . 'js/',
            'src="/images/' => 'src="' . $local_host . RELAT_DIR . 'images/',
            'src="/attach/' => 'src="' . $local_host . RELAT_DIR . 'attach/',
        );

        foreach ($id_arr as $k => $article_id) {
            $html = '';
            $article = $article_obj->getArticle($article_id);

            #如果文章不存在，跳转
            if (empty($article)) {
                continue;
            }

            $articlelog = $articlelogs_obj->getArticleFields("*", "article_id='{$article_id}' order by created desc", 1);
            $taglist = $tags_obj->getTagFields("id,tag_name", "type_id=1 and state=1 and id in($article[tag_list])", 2);

            $serieslist = $series_obj->getSeriesdata("series_id,sereis_name,series_pic", "series_id in ($article[series_list])", 2);
            $dir = date("Ym/d", $article['uptime']);
            $this->vars("h", $this->timestamp);

            /**
             * return first series_id in series_list
             * compatible PHP 5.2
             */
            if (false !== ($pos = strpos($article['series_list'], ','))) {
                $series_id = substr($article['series_list'], 0, $pos);
            } else {
                $series_id = $article['series_list'];
            }

            $series = $series_obj->getSeriesdata("*", "series_id =$series_id", 1);
            $logo = $brand_obj->getBrandlist("brand_logo", "brand_id=$series[brand_id]", 3);
            $this->vars("brand_logo", $logo);
            //频道
            $category = $category_obj->getlist("*", "id=$article[category_id]", 1);
            $p_category = $category_obj->getlist("*", "id=$category[parentid]", 1);

            $models = $models_obj->getSimp("MAX(model_price) AS max_price,MIN(model_price) AS min_price", "series_id=$series_id and state in(3,8)", 1);
            //相关文章
            $articleseries = $articleseries_obj->getCountSeries('ca.title,ca.pic,ca.id,ca.category_id,ca.uptime,ca.created', "cas.series_id=$series_id and ca.id=cas.article_id and type_id=1 and ca.state=3", 2);

            if ($articleseries) {
                $ii = 0;
                foreach ($articleseries as $key => $value) {
                    if ($value[id] == $article[id]) {
                        unset($articleseries[$key]);
                        continue;
                    }
                    $ii++;
                    if ($ii > 4) {
                        break;
                    }
                    $categoryarr = $category_obj->getParentCategoryName("pca.category_name p_category_name,ca.*", "ca.id=$article[category_id] and pca.id=ca.parentid", 1);
                    $articleseries[$key]['category_name'] = $categoryarr['category_name'];
                    $articleseries[$key]['p_category_name'] = $categoryarr['p_category_name'];
                    $articleseries[$key]['p_category_id'] = $categoryarr['parentid'];
                    $articleseries[$key]['url'] = $article_obj->getRewriteUrl($articleseries[$key]);
                }
            }

            //相关视频
            $videoseries = $articleseries_obj->getCountSeries('ca.title,ca.pic,ca.id,ca.category_id', "cas.series_id=$series_id and ca.id=cas.article_id and type_id=2 and ca.state=3", 2);
            if ($videoseries) {
                foreach ($videoseries as $key => $value) {
                    if ($key > 4) {
                        break;
                    }
                    $categoryarr = $category_obj->getParentCategoryName("pca.category_name p_category_name,ca.*", "ca.id=$article[category_id] and pca.id=ca.parentid", 1);
                    $videoseries[$key]['category_name'] = $categoryarr['category_name'];
                    $videoseries[$key]['p_category_name'] = $categoryarr['p_category_name'];
                    $videoseries[$key]['p_category_id'] = $categoryarr['parentid'];
                    $videoseries[$key]['url'] = $article_obj->getRewriteUrl($videoseries[$key]);
                }
            }

            //文章读图
            $pic_num = $articlepic_obj->getlist("count(id)", "type_id=$article[pic_org_id]", 3);
            $this->vars('pic_num', $pic_num);
            $this->vars('model_price', $models);
            $this->vars('seriercount', count($articleseries));
            $this->vars('articleseries', $articleseries);
            $this->vars('videocount', count($videoseries));
            $this->vars('videoseries', $videoseries);
            $this->vars('category', $category);
            $this->vars('p_category', $p_category);
            $this->vars('series', $series);
            $this->vars('taglist', $taglist);
            $this->vars('serieslist', $serieslist);
            $this->vars('make_flag', $make_flag);

            $page_title = $article[title] . '-' . SITE_NAME;
            $page_keywords = $article[title];
            $page_description = $article[title] . '。' . dstring::substring($article['chief'], 0, 75);
            #去除空段
            $article['content'] = preg_replace('%(<p[^>]*>\s*</p>)%', '', $article['content']);
            $page_keywords = str_replace(array('"', "'"), array('', ''), $page_keywords);
            $article['content'] = preg_replace('/<img([^>]+)>/im', '<img alt="' . $page_keywords . '" \1>', $article['content']);
            $article['pic'] = $article_obj->getArticlePic($article['pic'], '820x550');
            $this->vars('page_title', $page_title);
            $this->vars('keywords', $page_keywords);
            $this->vars('description', $page_description);
            $this->vars('article', $article);
            $this->vars('articlelog', $articlelog);
            $this->vars('id', $article_id);

            $html = $this->fetch($this->tpl_file);
            $html = replaceNewsChannel($html);

            #$make_flag=0预览， $make_flag=1生成
            if (!$make_flag) {
                $html = $this->getSSIfile($html);
            } else {
                $actual_cnt++;
            }
            $html = $this->replaceTpl($html);
        }
        if ($need_cnt == 1) {
            echo $html;
        } else {
            echo 1;
        }
    }

}
