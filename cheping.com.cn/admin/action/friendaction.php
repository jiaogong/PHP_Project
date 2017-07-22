<?php

class friendAction extends action {

    public $friend;
    public $category;

    function __construct() {
        parent::__construct();
        $this->friend = new friend();
        $this->category = new category();
    }

    function doDefault() {
        $this->doList();
    }

    function doList() {
        $this->doFriends();
    }

    //首页表格展示
    function doFriends() {
        global $local_host;
        $template_name = "friend_index";
        $a = $this->getValue('a')->Int();
        switch ($a) {
            case 0:
                $list = $this->friend->getAllFriendLink("category_id='$a' order by id desc", "*", 2);
                block;
            default:
                $list = $this->friend->getAllFriendLink("category_id='$a' order by id desc", "*", 2);
        }
        $where = "state=1 and parentid=0";
        $fields = "id,category_name";
        $category_id = $this->category->getlist($fields, $where, 2);
        $this->vars('category_id', $category_id);
        $this->vars('a', $a);
        $this->vars('friend', $list);
        $this->template($template_name);
    }

    function doAdd() {
        $template_name = "friend_add";
        if ($this->postValue('url')->Exist()) {
            if (0 !== ($category_id = $this->postValue('category_id')->Int()) ){
                $where = "id='{$category_id}' and state=1 and parentid=0";
                $fields = "category_name";
                $category_name = $this->category->getlist($fields, $where, 3);
            } else {
                $category_name = "首页";
            }
            $u = $this->postValue('url')->Url();
            if ($u) {
                $this->friend->ufields = array(
                    'title ' => $this->postValue('title')->String(),
                    'url' => $u,
                    'category_id' => $this->postValue('category_id')->Int(),
                    'mypage' => $this->addValue($category_name)->String(),
                    'seq' => $this->postValue('seq')->String(),
                    'url_type' => $this->postValue('url_type')->String(),
                    'nofollow' => $this->postValue('nofollow')->Int(),
                    'memo' => $this->postValue('memo')->String(),
                    'linkman' => $this->postValue('linkman')->String(),
                    'linkmemo' => $this->postValue('linkmemo')->String(),
                );
                $msg = "修改"; //判断url是否为空
                $id = $this->postValue('id')->Int();
                if ($id) {
                    $this->friend->where = "id='{$id}'";
                    $ret = $this->friend->update();
                    $msg = "修改";
                } else {
                    if ($this->postValue('title')->Val()) {
                        $ret = $this->friend->insert();
                        $msg = "添加";
                    } else {
                        $msg = "请完善信息,添加";
                    }
                }
                if ($ret) {
                    $msg .= "成功！";
                } else {
                    $msg .= "失败！";
                }
            } else {
                $msg = "地址不正确!";
            }//判断url是否为空
            $message = array(
                'type' => 'js',
                'act' => 3,
                'message' => $msg,
                'url' => $_ENV['PHP_SELF']
            );
            $this->alert($message);
        } else {
            $id = $this->getValue('id')->Int();
            $where = "state=1 and parentid=0";
            $fields = "*";
            $category = $this->category->getlist($fields, $where, 2);
            $this->vars('category', $category);
            $ret = $this->friend->getfriend("*", "id={$id}", 1);
            $this->vars('list', $ret);
            $this->template($template_name);
        }
    }

    function doEdit() {
        $this->doAdd();
    }

    function doDelFriend() {
        global $doDelid;
        $id = $this->getValue('id')->Int();
        $this->friend->where = "id='$id'";
        $ret = $this->friend->del();
        if ($ret) {
            $message = "删除成功！";
        } else {
            $message = "删除失败！";
        }
        $this->alert($message, 'js', 3, $_ENV['PHP_SELF']);
    }

    function doajaxfriend() {
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
   /**
     * 生成首页页脚SSI文件
     * $tplName:要生成文件的模板文件名
     * $fileName:生成后存放位置和文件
     * $linklist:生成文件时的变量数据
     * 
     * @global type $local_host 站点的url，带http://
     */
    function domake() {
        global $local_host;
        $linklist = $this->friend->getAllFriendLink("category_id='`0`' order by seq asc", "*", 2);
        $tplName = 'index_footer';
        $fileName = WWW_ROOT . 'ssi/index_footer.shtml';
        $this->vars('linklist', $linklist);
        $html = $this->fetch($tplName);

        //生成文件
        $length = file_put_contents($fileName, $html);
        if (empty($length)) {
            echo 0;
        } else {
            echo 1;
        }
    }

}
