<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
       // $this->show('欢迎来到mcake前台：<a href="http://localhost">前台台</a>');
        $this->display('Webconfig:detail');
    }
}