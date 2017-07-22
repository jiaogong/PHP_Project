<?php

class indexAction extends action {

    public $category;
    public $pagedate;
    public $article;
    public $tags;
    public $manual;
    public $ios;

    function __construct() {
        parent::__construct();

        $this->category = new category();
        $this->pagedate = new pageData();
        $this->article = new article();
        $this->tags = new tags();
        $this->ios = new ios();
    }

    function doDefault() {

        $this->doList();
    }

    function doshopping() {
        $this->checkAuth(202);
        $templateName = 'index_shopping_list';
        $arr = array();
        if ($_POST) {
            $arrid = $this->postValue('id')->Val();
            foreach ($arrid as $key => $value) {
                $arr[$key][c3] = $value;
                $article = $this->article->getArticleFields("id,title,uptime,pic,title2,type_id,category_id", "id=$value", 1);
                $pid = $this->category->getlist("parentid", "id=$article[category_id]", 3);
                $arr[$key][title] = $article[title];
                $arr[$key][uptime] = $article[uptime];
                $arr[$key][pic] = $article[pic];
                $arr[$key][c2] = $article[id];
                $arr[$key][c1] = $pid;
                if ($article['type_id'] == 1) {
                    $arr[$key][cname] = 'article';
                } else {
                    $arr[$key][cname] = 'video';
                }
            }
            $data['name'] = 'shopping';
            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='shopping'", 3);
            if ($pdid) {
                $date['updated'] = time();
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $this->pagedate->update();
            } else {
                $data['created'] = time();
                $data['notice'] = '精品导购统计';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='shopping'", 3);
        $list = unserialize($str);
        if ($list) {
            foreach ($list as $key => $value) {
                $article = $this->article->getArticleFields("id,title,uptime,pic,title2", "id=$value[c3]", 1);
                $list[$key][title] = $article[title];
                $list[$key][uptime] = $article[uptime];
                $list[$key][pic] = $article[pic];
                $list[$key][id] = $article[id];
            }
        }


        $this->vars("list", $list);
        $this->template($templateName);
    }

    function doarticle() {
        $this->checkAuth(204);
        $templateName = 'index_article_list';
        $arr = array();
        if ($_POST) {
            $arrid = $this->postValue('id')->Val();
            $orderby = $this->postValue('orderby')->Val();
            foreach ($arrid as $key => $value) {
                $arr[$key][c3] = $value;
                $article = $this->article->getArticleFields("id,title,uptime,pic,title2,type_id,category_id", "id=$value", 1);
                $pid = $this->category->getlist("parentid", "id=$article[category_id]", 3);
                $arr[$key][title] = $article[title];
                $arr[$key][uptime] = $article[uptime];
                $arr[$key][pic] = $article[pic];
                $arr[$key][orderby] = $orderby[$key];
                $arr[$key][c2] = $article[category_id];
                $arr[$key][c1] = $pid;


                if ($article['type_id'] == 1) {
                    $arr[$key][cname] = 'article';
                } else {
                    $arr[$key][cname] = 'video';
                }
                //二维数组排序
                $sort[$key] = $orderby[$key];
            }

            array_multisort($sort, SORT_ASC, $arr);
            $data['name'] = 'article';
            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='article'", 3);
            if ($pdid) {
                $date['updated'] = time();
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $this->pagedate->update();
            } else {
                $data['created'] = time();
                $data['notice'] = '文章 的浏览记录统计';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
            }
        }

        $str = $this->pagedate->getSomePagedata("value", "name='article'", 3);
        $list = unserialize($str);
        if ($list) {
            foreach ($list as $key => $value) {
                $article = $this->article->getArticleFields("id,title,uptime,pic,title2", "id=$value[c3]", 1);
                $list[$key][title] = $article[title];
                $list[$key][uptime] = $article[uptime];
                $list[$key][pic] = $article[pic];
                $list[$key][id] = $article[id];
            }
        }

        $this->vars("list", $list);
        $this->template($templateName);
    }

    function dovideo() {
        $this->checkAuth(203);
        $templateName = 'index_video_list';
        $arr = array();
        if ($_POST) {
           
            $arrid = $this->postValue('id')->Val();
            foreach ($arrid as $key => $value) {
                $arr[$key][c3] = $value;
                $orderby = $this->postValue('orderby')->Val();
                $article = $this->article->getArticleFields("id,title,uptime,pic,title2,type_id,category_id", "id=$value", 1);
                $pid = $this->category->getlist("parentid", "id=$article[category_id]", 3);
                $arr[$key][title] = $article[title];
                $arr[$key][uptime] = $article[uptime];
                $arr[$key][pic] = $article[pic];
                $arr[$key][orderby] = $orderby[$key];
                $arr[$key][c2] = $article[category_id];
                $arr[$key][c1] = $pid;
                if ($article['type_id'] == 1) {
                    $arr[$key][cname] = 'article';
                } else {
                    $arr[$key][cname] = 'video';
                }
                //二维数组排序
                $sort[$key] = $orderby[$key];
            }
            array_multisort($sort, SORT_ASC, $arr);
            $data['name'] = 'video';
            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='video'", 3);
            if ($pdid) {
                $date['updated'] = time();
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $this->pagedate->update();
            } else {
                $data['created'] = time();
                $data['notice'] = '视频 的浏览记录统计';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='video'", 3);
        $list = unserialize($str);
        if ($list) {
            foreach ($list as $key => $value) {
                $article = $this->article->getArticleFields("id,title,uptime,pic,title2", "id=$value[c3]", 1);
                $list[$key][title] = $article[title];
                $list[$key][uptime] = $article[uptime];
                $list[$key][pic] = $article[pic];
                $list[$key][id] = $article[id];
            }
        }

        $this->vars("list", $list);
        $this->template($templateName);
    }

    function doevalu() {
        $this->checkAuth(201);
        $templateName = 'index_evalu_list';
        $arr = array();
        if ($_POST) {
            $arrid = $this->postValue('id')->Val();
            $orderby = $this->postValue('orderby')->Val();
            foreach ($arrid as $key => $value) {
                $arr[$key][c3] = $value;
                $article = $this->article->getArticleFields("id,title,uptime,pic,title2,type_id,category_id", "id=$value", 1);
                $pid = $this->category->getlist("parentid", "id={$article['category_id']}", 3);
                $arr[$key]['title'] = $article['title'];
                $arr[$key]['orderby'] = $orderby[$key];
                $arr[$key]['uptime'] = $article['uptime'];
                $arr[$key]['pic'] = $article['pic'];
                $arr[$key]['c2'] = $article['id'];
                $arr[$key]['c1'] = $pid;
                if ($article['type_id'] == 1) {
                    $arr[$key]['cname'] = 'article';
                } else {
                    $arr[$key]['cname'] = 'video';
                }
                $sort[$key] = $orderby[$key];
            }
            array_multisort($sort, SORT_ASC, $arr);
            $data['name'] = 'evalu';
            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='evalu'", 3);
            if ($pdid) {
                $date['updated'] = time();
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $this->pagedate->update();
            } else {
                $data['created'] = time();
                $data['notice'] = '车评统计';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='evalu'", 3);
        $list = unserialize($str);
        if ($list) {
            foreach ($list as $key => $value) {
                $article = $this->article->getArticleFields("id,title,uptime,pic,title2", "id=$value[c3]", 1);
                $list[$key][title] = $article[title];
                $list[$key][uptime] = $article[uptime];
                $list[$key][pic] = $article[pic];
                $list[$key][id] = $article[id];
            }
        }
        $this->vars("list", $list);
        $this->template($templateName);
    }

    function dotag() {
        $this->checkAuth(205);
        $templateName = 'index_tag_list';
        $arr = array();
        if ($_POST) {
            $arrid = $this->postValue('id')->Val();
            foreach ($arrid as $key => $value) {
                $arr[$key][c2] = $value;
                $tag = $this->tags->getTagFields("id,tag_name,letter,type_id", "id=$value", 1);
                $arr[$key][tag_name] = $tag[tag_name];
                if ($tag['type_id'] == 1) {
                    $arr[$key][cname] = 'article';
                } else {
                    $arr[$key][cname] = 'video';
                }
            }
            $data['name'] = 'tag';
            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='tag'", 3);
            if ($pdid) {
                $date['updated'] = time();
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $this->pagedate->update();
            } else {
                $data['created'] = time();
                $data['notice'] = '标签浏览记录统计';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='tag'", 3);
        $list = unserialize($str);
        if ($list) {

            foreach ($list as $key => $value) {
                $tag = $this->tags->getTagFields("id,tag_name,letter,type_id", "id=$value[c2]", 1);
                $list[$key][tag_name] = $tag[tag_name];
                $list[$key][id] = $tag[id];
            }
        }

        $this->vars("list", $list);
        $this->template($templateName);
    }

    function domanual() {
        $this->checkAuth(208);
        $templateName = 'index_manual_list';
        $arr = array();
        if ($_POST) {
            $arrid = $this->postValue('id')->Val();
            $radio = $this->postValue('radio')->Val();
            $i = 0;
            foreach ($arrid as $key => $value) {
                $arr[$key]['id'] = $value;
                $arr[$key]['c3'] = $value;
                $article = $this->article->getArticleFields("id,title,title2,uptime,created,tag_list,pic,category_id,type_id,tagname_list,pic_org_id,source", "id='$value' and state=3", 1);
                $pid = $this->category->getFields("ca.id caid,pca.id pcaid,ca.category_name caname,pca.category_name pcaname", "ca.id=pca.parentid and ca.state=1 and pca.state=1 and pca.id='$article[category_id]'");
                $arr[$key]['title'] = $article['title'];
                $arr[$key]['uptime'] = $article['uptime'];
                $arr[$key]['created'] = $article['created'];
                $arr[$key]['state'] = $radio[$i++];
                $arr[$key]['pic_org_id'] = $article['pic_org_id'];
                $arr[$key]['p_category_id'] = $pid[0]['caid'];
                $arr[$key]['p_category_name'] = $pid[0]['caname'];
                $arr[$key]['source'] = $article['source'];
                $arr[$key]['url'] = $this->article->getRewriteUrl($arr[$key]);
                $tag_id = explode(",", $article['tag_list']);
                $tag_name = explode(",", $article['tagname_list']);
                $tag_list = array_combine($tag_id, $tag_name);
                foreach ($tag_list as $k => $v) {
                    $arr[$key]['tag_list'][] = array("tag_id" => $k, 'tag_name' => $v);
                }

                if ($article['type_id'] == 1) {
                    $arr[$key][cname] = 'article';
                    $arr[$key][pic] = $this->article->getArticlePic($article['pic'], '280x186');
                    $arr[$key][pic1] = $this->article->getArticlePic($article['pic'], '344x258');
                } else {
                    $arr[$key][cname] = 'video';
                    $arr[$key][pic] = $this->article->getArticlePic($article['pic'], '280x186');
                    $arr[$key][pic1] = $this->article->getArticlePic($article['pic'], '344x258');
                }
            }
            $rtA = array();
            $rtB = array();
            $str = $this->pagedate->getSomePagedata("value", "name='manual'", 3);
            $list = unserialize($str);
            $this->ios->foo($arr, $rtB);
            $this->ios->foo($list, $rtA);
            $result = array_diff($rtB, $rtA);
            if ($result) {
                $array['title'] = "有新内容更新";
                $array['count'] = count($result);
                $array['description'] = '首页推送数据';
                $res = $this->ios->_ios($array,true);
                if (is_array($res)) {
                    if ($res['code'] == 1) {
                        $data['name'] = 'manual';
                        $data['value'] = serialize($arr);
                        $pdid = $this->pagedate->getSomePagedata("id", "name='manual'", 3);
                        if ($pdid) {
                            $date['updated'] = time();
                            $this->pagedate->ufields = $data;
                            $this->pagedate->where = "id=$pdid";
                            $this->pagedate->update();
                        } else {
                            $data['created'] = time();
                            $data['notice'] = '手动信息统计';
                            $this->pagedate->ufields = $data;
                            $this->pagedate->insert();
                        }
                    } else {
                        $this->alert('状态码:' . $res['code'] . ' 消息:' . $res['message'], 'js', 3);
                    }
                }
            }else{
                $data['name'] = 'manual';
                        $data['value'] = serialize($arr);
                        $pdid = $this->pagedate->getSomePagedata("id", "name='manual'", 3);
                        if ($pdid) {
                            $date['updated'] = time();
                            $this->pagedate->ufields = $data;
                            $this->pagedate->where = "id=$pdid";
                            $this->pagedate->update();
                        } else {
                            $data['created'] = time();
                            $data['notice'] = '手动信息统计';
                            $this->pagedate->ufields = $data;
                            $this->pagedate->insert();
                        }
            }
        }

        $str = $this->pagedate->getSomePagedata("value", "name='manual'", 3);
        $list = unserialize($str);
        $this->vars("list", $list);
        $this->template($templateName);
    }

    function doajaxarticle() {
        $this->checkAuth(201);
        $id = $this->getValue('id')->Int();
        $article = $this->article->getArticleFields("id,title,uptime,pic,title2,type_id", "id=$id", 1);
        if ($article) {
            if ($article['type_id'] == 1) {
                $article['type'] = '文章';
            } else {
                $article['type'] = '视频';
            }
            $article['day'] = date("Y-m-d", $article['uptime']);
            echo json_encode($article);
        } else {
            echo -1;
        }
    }

    function doajaxtag() {
        $id = $this->getValue('id')->Int();
        $tag = $this->tags->getTagFields("id,tag_name,letter,type_id", "id=$id", 1);
        if ($tag) {
            if ($tag['type_id'] == 1) {
                $tag['type'] = '文章';
            } else {
                $tag['type'] = '视频';
            }

            echo json_encode($tag);
        } else {
            echo -1;
        }
    }

    //生成shmtl文件
    function domake() {
        $this->checkAuth(207);
        global $local_host;
        $name = $this->getValue('name')->String();
        if ($name == 'wap') {
            $str = $this->pagedate->getSomePagedata("value", "name='manual'", 3);
        } else {
            $str = $this->pagedate->getSomePagedata("value", "name='$name'", 3);
        }
        if ($str) {
            $value = unserialize($str);
        }

        if ($name == 'tag') {
            foreach ($value as $k => $vv) {
                $tag = $this->tags->getTagFields("id,tag_name,letter,type_id", "id={$vv['c2']}", 1);
                $value[$k]['tag_name'] = $tag['tag_name'];
                $value[$k]['alt'] = str_replace(array('"', "'"), array('', ''), $tag['tag_name']);
                $value[$k]['id'] = $tag['id'];
                $value[$k]['url'] = $local_host . 'article.php?action=ActiveList&id=' . $tag['id'];
            }
        } else if ($name == 'manual' && $name == 'wap') {
            $value = $value;
        } else {
            foreach ($value as $kk => $vv) {
                $article = $this->article->getArticleFields("id,title,uptime,created,pic,title2,category_id", "id=$vv[c3]", 1);

                $p_category_id = $this->category->getlist("parentid", "id=$article[category_id]", 3);
                $article['p_category_id'] = $p_category_id;
                $value[$kk]['title'] = $article['title'];
                $value[$kk]['alt'] = str_replace(array('"', "'"), array('', ''), $article['title']);
                $value[$kk]['uptime'] = $article['uptime'];
                $value[$kk]['pic'] = $article['pic'];
                $value[$kk]['id'] = $article['id'];
                $value[$kk]['url'] = $this->article->getRewriteUrl($article);
                if ($name == 'article' || $name == 'video') {
                    $value[$kk]['pic'] = $this->article->getArticlePic($article['pic'], '160x120');
                } else {
                    $value[$kk]['pic'] = $this->article->getArticlePic($article['pic'], '280x186');
                }
            }
        }
        $this->vars("value", $value);
        if ($name == 'manual') {
            $tplName = 'ssi_index_' . $name;
            $fileName = WWW_ROOT . 'ssi/ssi_index_' . $name . '.shtml';

            $html = $this->fetch($tplName);
            $html = replaceNewsChannel($html);
        } else if ($name == 'wap') {
            $tplName = 'ssi_index_wap_manual';
            $fileName = WWW_ROOT . 'ssi/ssi_index_wap_manual.shtml';

            $html = $this->fetch($tplName);
            $html = replaceNewsChannel($html);
        } 
        //生成文章页内容
        elseif ($name == 'article') {
            $tplName = 'ssi_page_' . $name;
            $fileName = WWW_ROOT . 'ssi/ssi_page_' . $name . '.shtml';
            $html = $this->fetch($tplName);
        }
        else {
            $tplName = 'ssi_index_' . $name;
            $fileName = WWW_ROOT . 'ssi/ssi_index_' . $name . '.shtml';

            $html = $this->fetch($tplName);
            $html = replaceNewsChannel($html);
        }
        $html = replaceImageUrl($html);
        $length = file_put_contents($fileName, $html);
        if (empty($length)) {
            echo 0;
        } else {
            echo 1;
        }
    }

    //每15天生成一次自动生成shmtl文件
    function doautomake() {
        global $local_host;
        $arr = array("article", "video", "evalu", "shopping", "tag", "manual");
        foreach ($arr as $key => $v) {

            $name = $v;
            $str = $this->pagedate->getSomePagedata("value", "name='$name'", 3);
            if ($str) {
                $value = unserialize($str);
            }
            if ($name == 'tag') {
                foreach ($value as $k => $vv) {
                    $tag = $this->tags->getTagFields("id,tag_name,letter,type_id", "id=$vv[c2]", 1);
                    $value[$k]['tag_name'] = $tag['tag_name'];
                    $value[$k]['alt'] = str_replace(array('"', "'"), array('', ''), $tag[tag_name]);
                    $value[$k]['id'] = $tag['id'];
                    $value[$k]['url'] = $local_host . 'article.php?action=ActiveList&id=' . $tag['id'];
                }
            } else {
                foreach ($value as $kk => $vv) {
                    $article = $this->article->getArticleFields("id,title,uptime,created,pic,title2,category_id", "id=$vv[c3]", 1);
                    $value[$kk]['title'] = $article['title'];
                    $value[$kk]['alt'] = str_replace(array('"', "'"), array('', ''), $article['title']);
                    $value[$kk]['uptime'] = $article['uptime'];
                    $value[$kk]['created'] = $article['created'];
                    $value[$kk]['pic'] = $article['pic'];
                    $value[$kk]['id'] = $article['id'];
                    $value[$kk]['p_category_id'] = $this->category->getParentId($article['category_id']);
                    $value[$kk]['url'] = $this->article->getRewriteUrl($value[$kk]);
                    if ($name == 'article' || $name == 'video') {
                        $value[$kk]['pic'] = $this->article->getArticlePic($article['pic'], '160x120');
                    } else {
                        $value[$kk]['pic'] = $this->article->getArticlePic($article['pic'], '280x186');
                    }
                }
                #var_dump($value);exit;
            }
            $tplName = 'ssi_index_' . $name;
            $this->vars("value", $value);
            $fileName = WWW_ROOT . 'ssi/ssi_index_' . $name . '.shtml';
            $html = $this->fetch($tplName);
            $html = replaceImageUrl($html);
            //生成文件
            $length = file_put_contents($fileName, $html);
            //生成文章页内容
            if ($name == 'article') {
                $tplName = 'ssi_page_' . $name;
                $fileName = WWW_ROOT . 'ssi/ssi_page_' . $name . '.shtml';
                $html = $this->fetch($tplName);
                $html = replaceImageUrl($html);
                //生成文件
                $length = file_put_contents($fileName, $html);
            }
        }

        echo 1;
    }

    function dobannerIndex() {
        global $local_host;
        $template_name = "banner_index";
        $arr = array();
        if ($_POST) {
            $arrid = $this->postValue('id')->Val();
            $oldpic = $this->postValue('old_pic')->Val();
            $url = $this->postValue('url')->Val();
            $title3 = $this->postValue('title3')->Val();
            $title = $this->postValue('title')->Val();
            $orderby = $this->postValue('orderby')->Val();
            $file = $_FILES['pic'];
            foreach ($arrid as $key => $value) {
                $arr[$key][id] = $value;
                $article = $this->article->getArticleFields("id,title,uptime,pic,title2,type_id,category_id", "id=$value", 1);
                $pid = $this->category->getlist("parentid", "id=$article[category_id]", 3);
                if ($file['error'][$key] === 0) {
                    $pic_name = $file['tmp_name'][$key];
                    $pic_path = $this->uploadPic($pic_name, 'articlehot');
                    $arr[$key][pic] = $pic_path;
                } else {
                    $arr[$key][pic] = $oldpic[$key];
                }


                $arr[$key][uptime] = $article[uptime];

                $arr[$key][url] = $url[$key];
//                if ($article) {
//                    $arr[$key][title] = $article[title];
//                } else {
                $arr[$key][title] = $title[$key];
//                }
                $arr[$key][title3] = $title3[$key];
                $arr[$key][orderby] = $orderby[$key];
                $arr[$key][p_category_id] = $pid;
                if ($article['type_id'] == 1) {
                    $arr[$key][cname] = 'article';
                } else if ($article['type_id'] == 2) {
                    $arr[$key][cname] = 'video';
                } else {
                    $arr[$key][cname] = '其他';
                }
                //二维数组排序
                $sort[$key] = $orderby[$key];
            }
            array_multisort($sort, SORT_ASC, $arr);
            $rtA = array();
            $rtB = array();
            $str = $this->pagedate->getSomePagedata("value", "name='banner_index'", 3);
            $list = unserialize($str);
            $this->ios->foo($arr, $rtB);
            $this->ios->foo($list, $rtA);
            $result = array_diff($rtB, $rtA);
            if ($result) {
                $array['title'] = "有新内容更新";
                $array['count'] = count($result);
                $array['description'] = '首页轮播推送数据';
//                $res = $this->ios->_ios($array,true);
//                if (is_array($res)) {
//                    if ($res['code'] == 1) {
                        $data['name'] = 'banner_index';
                        $data['value'] = serialize($arr);
                        $pdid = $this->pagedate->getSomePagedata("id", "name='banner_index'", 3);
//                        echo $this->pagedate->sql;
                        if ($pdid) {
                            $date['updated'] = time();
                            $this->pagedate->ufields = $data;
                            $this->pagedate->where = "id=$pdid";
                            $this->pagedate->update();
                        } else {
                            $data['created'] = time();
                            $data['notice'] = '首页轮播图';
                            $this->pagedate->ufields = $data;
                            $this->pagedate->insert();
                        }
//                    } else {
//                        $this->alert('状态码:' . $res['code'] . ' 消息:' . $res['message'], 'js', 3);
//                    }
//                }
            }else{
                $data['name'] = 'banner_index';
                        $data['value'] = serialize($arr);
                        $pdid = $this->pagedate->getSomePagedata("id", "name='banner_index'", 3);
                        if ($pdid) {
                            $date['updated'] = time();
                            $this->pagedate->ufields = $data;
                            $this->pagedate->where = "id=$pdid";
                            $this->pagedate->update();
                        } else {
                            $data['created'] = time();
                            $data['notice'] = '首页轮播图';
                            $this->pagedate->ufields = $data;
                            $this->pagedate->insert();
                        }
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='banner_index'", 3);
        $list = unserialize($str);

        $this->vars("list", $list);
        $this->template($template_name, '', 'replaceImageUrl');
    }

    function dobannerNews() {
        global $local_host;
        $template_name = "banner_news";
        $arr = array();
        if ($_POST) {
            $arrid = $this->postValue('id')->Val();
            $oldpic = $this->postValue('old_pic')->Val();
            $url = $this->postValue('url')->Val();
            $title3 = $this->postValue('title3')->Val();
            $title = $this->postValue('title')->Val();
            $orderby = $this->postValue('orderby')->Val();
            $file = $_FILES['pic'];
            foreach ($arrid as $key => $value) {
                $arr[$key][id] = $value;
                $article = $this->article->getArticleFields("id,title,uptime,pic,title2,type_id,category_id", "id=$value", 1);

                $pid = $this->category->getlist("parentid", "id=$article[category_id]", 3);

                if ($file['error'][$key] === 0) {
                    $pic_name = $file['tmp_name'][$key];
                    $pic_path = $this->uploadPic($pic_name, 'articlehot');
                    $arr[$key][pic] = $pic_path;
                } else {
                    $arr[$key][pic] = $oldpic[$key];
                }


                $arr[$key][uptime] = $article[uptime];

                $arr[$key][url] = $url[$key];
//                if ($article) {
//                    $arr[$key][title] = $article[title];
//                } else {
                $arr[$key][title] = $title[$key];
//                }
                $arr[$key][title3] = $title3[$key];
                $arr[$key][orderby] = $orderby[$key];
                $arr[$key][p_category_id] = $pid;
                if ($article['type_id'] == 1) {
                    $arr[$key][cname] = 'article';
                } else if ($article['type_id'] == 2) {
                    $arr[$key][cname] = 'video';
                } else {
                    $arr[$key][cname] = '其他';
                }
                //二维数组排序
                $sort[$key] = $orderby[$key];
            }
            array_multisort($sort, SORT_ASC, $arr);

            $data['name'] = 'banner_news';
            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='banner_news'", 3);
            if ($pdid) {
                $date['updated'] = time();
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $this->pagedate->update();
            } else {
                $data['created'] = time();
                $data['notice'] = '新闻轮播图';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='banner_news'", 3);
        $list = unserialize($str);

        $this->vars("list", $list);
        $this->template($template_name);
    }

    function dobannerPingce() {
        global $local_host;
        $template_name = "banner_pingce";
        $arr = array();
        if ($_POST) {
            $arrid = $this->postValue('id')->Val();
            $oldpic = $this->postValue('old_pic')->Val();
            $url = $this->postValue('url')->Val();
            $title3 = $this->postValue('title3')->Val();
            $title = $this->postValue('title')->Val();
            $orderby = $this->postValue('orderby')->Val();
            $file = $_FILES['pic'];
            foreach ($arrid as $key => $value) {
                $arr[$key][id] = $value;
                $article = $this->article->getArticleFields("id,title,uptime,pic,title2,type_id,category_id", "id=$value", 1);

                $pid = $this->category->getlist("parentid", "id=$article[category_id]", 3);

                if ($file['error'][$key] === 0) {
                    $pic_name = $file['tmp_name'][$key];
                    $pic_path = $this->uploadPic($pic_name, 'articlehot');
                    $arr[$key][pic] = $pic_path;
                } else {
                    $arr[$key][pic] = $oldpic[$key];
                }


                $arr[$key][uptime] = $article[uptime];

                $arr[$key][url] = $url[$key];
//                if ($article) {
//                    $arr[$key][title] = $article[title];
//                } else {
                $arr[$key][title] = $title[$key];
//                }
                $arr[$key][title3] = $title3[$key];
                $arr[$key][orderby] = $orderby[$key];
                $arr[$key][p_category_id] = $pid;
                if ($article['type_id'] == 1) {
                    $arr[$key][cname] = 'article';
                } else if ($article['type_id'] == 2) {
                    $arr[$key][cname] = 'video';
                } else {
                    $arr[$key][cname] = '其他';
                }
                //二维数组排序
                $sort[$key] = $orderby[$key];
            }
            array_multisort($sort, SORT_ASC, $arr);

            $data['name'] = 'banner_pingce';
            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='banner_pingce'", 3);
            if ($pdid) {
                $date['updated'] = time();
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $this->pagedate->update();
            } else {
                $data['created'] = time();
                $data['notice'] = '评测轮播图';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='banner_pingce'", 3);
        $list = unserialize($str);

        $this->vars("list", $list);
        $this->template($template_name);
    }

    function dobannerVideo() {
        global $local_host;
        $template_name = "banner_video";
        $arr = array();
        if ($_POST) {
            $arrid = $this->postValue('id')->Val();
            $oldpic = $this->postValue('old_pic')->Val();
            $url = $this->postValue('url')->Val();
            $title3 = $this->postValue('title3')->Val();
            $title = $this->postValue('title')->Val();
            $orderby = $this->postValue('orderby')->Val();
            $file = $_FILES['pic'];
            foreach ($arrid as $key => $value) {
                $arr[$key][id] = $value;
                $article = $this->article->getArticleFields("id,title,uptime,pic,title2,type_id,category_id", "id=$value", 1);

                $pid = $this->category->getlist("parentid", "id=$article[category_id]", 3);

                if ($file['error'][$key] === 0) {
                    $pic_name = $file['tmp_name'][$key];
                    $pic_path = $this->uploadPic($pic_name, 'articlehot');
                    $arr[$key][pic] = $pic_path;
                } else {
                    $arr[$key][pic] = $oldpic[$key];
                }


                $arr[$key][uptime] = $article[uptime];

                $arr[$key][url] = $url[$key];
//                if ($article) {
//                    $arr[$key][title] = $article[title];
//                } else {
                $arr[$key][title] = $title[$key];
//                }
                $arr[$key][title3] = $title3[$key];
                $arr[$key][orderby] = $orderby[$key];
                $arr[$key][p_category_id] = $pid;
                if ($article['type_id'] == 1) {
                    $arr[$key][cname] = 'article';
                } else if ($article['type_id'] == 2) {
                    $arr[$key][cname] = 'video';
                } else {
                    $arr[$key][cname] = '其他';
                }
                //二维数组排序
                $sort[$key] = $orderby[$key];
            }
            array_multisort($sort, SORT_ASC, $arr);
            $data['name'] = 'banner_video';
            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='banner_video'", 3);
            if ($pdid) {
                $date['updated'] = time();
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $this->pagedate->update();
            } else {
                $data['created'] = time();
                $data['notice'] = '视频轮播图';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='banner_video'", 3);
        $list = unserialize($str);
        $this->vars("list", $list);
        $this->template($template_name);
    }

    function dobannerWenhua() {
        global $local_host;
        $template_name = "banner_wenhua";
        $arr = array();
        if ($_POST) {
            $arrid = $this->postValue('id')->Val();
            $oldpic = $this->postValue('old_pic')->Val();
            $url = $this->postValue('url')->Val();
            $title3 = $this->postValue('title3')->Val();
            $title = $this->postValue('title')->Val();
            $orderby = $this->postValue('orderby')->Val();
            $file = $_FILES['pic'];
            foreach ($arrid as $key => $value) {
                $arr[$key][id] = $value;
                $article = $this->article->getArticleFields("id,title,uptime,pic,title2,type_id,category_id", "id=$value", 1);

                $pid = $this->category->getlist("parentid", "id=$article[category_id]", 3);

                if ($file['error'][$key] === 0) {
                    $pic_name = $file['tmp_name'][$key];
                    $pic_path = $this->uploadPic($pic_name, 'articlehot');
                    $arr[$key][pic] = $pic_path;
                } else {
                    $arr[$key][pic] = $oldpic[$key];
                }


                $arr[$key][uptime] = $article[uptime];

                $arr[$key][url] = $url[$key];
//                if ($article) {
//                    $arr[$key][title] = $article[title];
//                } else {
                $arr[$key][title] = $title[$key];
//                }
                $arr[$key][title3] = $title3[$key];
                $arr[$key][orderby] = $orderby[$key];
                $arr[$key][p_category_id] = $pid;
                if ($article['type_id'] == 1) {
                    $arr[$key][cname] = 'article';
                } else if ($article['type_id'] == 2) {
                    $arr[$key][cname] = 'video';
                } else {
                    $arr[$key][cname] = '其他';
                }
                //二维数组排序
                $sort[$key] = $orderby[$key];
            }
            array_multisort($sort, SORT_ASC, $arr);

            $data['name'] = 'banner_wenhua';
            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='banner_wenhua'", 3);
            if ($pdid) {
                $date['updated'] = time();
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $this->pagedate->update();
            } else {
                $data['created'] = time();
                $data['notice'] = '文化轮播图';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='banner_wenhua'", 3);
        $list = unserialize($str);

        $this->vars("list", $list);
        $this->template($template_name);
    }

    /**
     * 生成首页及频道页面的轮播SSI文件
     * type编号说明：1="banner_index",2="banner_news",3="banner_pingce",4="banner_video",5="banner_wenhua"
     * 
     * @global type $local_host 站点的url，带http://
     */
    function dobannermake() {
        global $local_host;
        $this->checkAuth(207);
        $name = $this->getValue('name')->String();
        #type编号说明：1="banner_index",2="banner_news",3="banner_pingce",4="banner_video",5="banner_wenhua"
        $type = $this->getValue('type')->Int();
        if (in_array($type, array(1, 2, 3, 4, 5)) !== false) {
            $str = $this->pagedate->getSomePagedata("value", "name='$name'", 3);
            if ($str) {
                $banner = unserialize($str);
            }
            if ($banner) {
                foreach ($banner as $key => $value) {
                    $banner[$key]['alt'] = str_replace(array('"', "'"), array('', ''), $value['title']);
                    $tag_list = $this->article->getArticleFields("tag_list", "id=$value[id]", 1);
                    //标签
                    $taglist = $this->tags->getTagFields("id,tag_name", "state=1 and id in($tag_list[tag_list])", 2);
                    $banner[$key]['url'] = $this->article->getRewriteUrlByUrl($banner[$key]['url']);
                    $banner[$key]['taglist'] = $taglist;
                }
            }

            $this->vars("banner", $banner);
            $tplName = 'ssi_banner_' . $name;
            $fileName = WWW_ROOT . 'ssi/ssi_banner_' . $name . '.shtml';
        }
        #下面代码无用，暂时屏蔽，不执行
        elseif (0) {
            $arr = array("banner_index", "banner_news", "banner_pingce", "banner_video", "banner_wenhua");
            foreach ($arr as $k => $v) {
                $str = $this->pagedate->getSomePagedata("value", "name='$v'", 3);
                if ($str) {
                    $banner = unserialize($str);
                }
                if ($banner) {
                    foreach ($banner as $key => $value) {
                        $banner[$key]['alt'] = str_replace(array('"', "'"), array('', ''), $value['title']);
                        $tag_list = $this->article->getArticleFields("tag_list", "id=$value[id]", 1);
                        //标签
                        $taglist = $this->tags->getTagFields("id,tag_name", "state=1 and id in($tag_list[tag_list])", 2);
                        $banner[$key]['url'] = $this->article->getRewriteUrlByUrl($banner[$key]['url']);
                        $banner[$key]['taglist'] = $taglist;
                    }
                }

                $this->vars("banner", $banner);
                $tplName = 'ssi_banner_' . $v;
                $fileName = WWW_ROOT . 'ssi/ssi_banner_' . $v . '.shtml';
            }
        }
        $html = $this->fetch($tplName);
        $html = str_replace($local_host, '', $html);
        $html = replaceArticleUrl($html);
        $html = replaceVideoUrl($html);
        $html = preg_replace('/href="(.+?)\.html([^\'">]+)/im', 'href="\1.html', $html);
        $html = replaceImageUrl($html);
        //生成文件
        $length = file_put_contents($fileName, $html);
        if (empty($length)) {
            echo 0;
        } else {
            echo 1;
        }
    }

    function doArticleHeader() {
        $template_name = "article_header";
        $html = $this->fetch($template_name);
        $html = replaceNewsChannel($html);
        echo $html;
    }

    function checkAuth($id, $module_type = 'sys_module', $type_value = "A") {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, $module_type, $id, 'A');
    }

    /**
     * 上传图片
     * @param type $file 上传的临时文件
     * @param type $dir 上传目录
     * @return type  $file_name. $fileName 图片地址名称
     */
    function uploadPic($file, $dir = 'articletitle') {
        global $watermark_opt;
        if($_FILES['pic']['size'][0] >122880){
            $this->alert('文件过大，请将其压缩到120K以下!', 'js', 3, '');
            }else{
                $uploadRootDir = ATTACH_DIR . "images/$dir/";
                file::forcemkdir($uploadRootDir);
                $uploadDir = $uploadRootDir . date("Y/m/d", time()) . '/';
                file::forcemkdir($uploadDir);
                $file_name = "images/$dir/" . date("Y/m/d", time()) . '/';
                $fileName = util::random(12);
                $fileName .= '.jpg';
                move_uploaded_file($file, $uploadDir . $fileName);
                if ($dir == 'articletitle') {
                    imagemark::resize($uploadDir . $fileName, "820x550", 820, 550, '', $watermark_opt);
                    imagemark::resize($uploadDir . $fileName, "280x186", 280, 186, '', $watermark_opt);
                    imagemark::resize($uploadDir . $fileName, "160x120", 160, 120, '', $watermark_opt);
                } else {
                    imagemark::resize($uploadDir . $fileName, "750x254", 750, 254, '', $watermark_opt);
                    imagemark::resize($uploadDir . $fileName, "1180x400", 1180, 400, '', $watermark_opt);
                }
                return $file_name . $fileName;
            }
    }

    //通过jtip查看图片
    function doPic() {
        $picture = $this->getValue('picture')->String();
        $path = ATTACH_DIR . $picture;
        if (is_file($path)) {
            echo "<img src='/attach/$picture' width='225' height='240'>";
        } else {
            echo iconv('gbk', 'utf-8', '没有图片');
        }
    }

}

?>