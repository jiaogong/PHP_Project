<?php

namespace APP\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * 登录页 登录数据提交方法
     * @var string
     */
    private $loginMethod = 'admin_user_login';

    /**
     * 后台入口
     * 
     * 根据后台用户session判断用户是否登录
     * 后台用户session存在，进入后台管理页
     * 否则进入后台登录页
     * @return 对应的页面
     */
    public function __invoke(){
        if (Session::has('admin_user_id')) {
            return view('admin.index');
        } else {
            return view('admin.user.login', [
                'htmlTitle' => '后台登录'
                , 'method' => $this->loginMethod
                ]);
        }
    }
}
