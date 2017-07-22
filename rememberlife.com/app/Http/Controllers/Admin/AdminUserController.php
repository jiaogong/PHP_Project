<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use App\Model\Admin\AdminUser as AdminUserModel;
use App\PublicFunc\Funcs; // 私有的公共方法

class AdminUserController extends Controller
{
	private $registerMethod = 'admin_user_register';
	private $loginMethod = 'admin_user_login';
    // 后台登录 验证用户
    public function login(Request $request){
        if ($request->method && $request->method === $this->loginMethod) { // 提交登录信息
            $statusResult = false;
            if($request->userName && $request->password){

                $statusResult = AdminUserModel::login($request->userName, $request->password);
            }
            $message = $statusResult ? '登录成功' : '登录失败 - {用户名或密码未填写成功}';
            $gotoUrlName = $statusResult ? '后台管理页' : '后台登录';
            $gotoUrl = $statusResult ? url('/admin') : url('/admin');
            return view('admin.user.result', [ // 显示登录结果
                    'htmlTitle' => '登录'
                    , 'message' => $message
                    , 'gotoUrlName' => $gotoUrlName
                    , 'gotoUrl' => $gotoUrl
                    , 'gotoTime' => 3
                    ]);
        } else {
            return view('admin.user.login', [
                'htmlTitle' => '后台登录'
                , 'method' => $this->loginMethod
                ]);
        }
        
    }

    // 后台登录 用户注册
    public function register(Request $request){
    	if ($request->method && $request->method === $this->registerMethod) { // 提交注册信息
            $statusResult = false;
    		if($request->userName && $request->password){
                $userModel = new AdminUserModel;
                $user_salt = Funcs::getPasswordSalt();// 生成盐
                $userModel->user_name = $request->userName;
                $userModel->password = md5(md5($request->password) . $user_salt); // 密码加盐
                $userModel->salt = $user_salt;
                $userModel->created_at = time();
                $userModel->updated_at = time();
                $userModel->save();
                $statusResult = AdminUserModel::login($request->userName, $request->password);
    		}

            $message = $statusResult ? '注册成功' : '注册失败 - {用户名或密码未填写成功}';
            $gotoUrlName = $statusResult ? '后台管理页' : '后台注册';
            $gotoUrl = $statusResult ? url('/admin') : url('/admin/register');
            return view('admin.user.result', [ // 显示登录结果
                    'htmlTitle' => '注册'
                    , 'message' => $message
                    , 'gotoUrlName' => $gotoUrlName
                    , 'gotoUrl' => $gotoUrl
                    , 'gotoTime' => 3
                    ]);
    	} else { // 进入注册页
	        return view('admin.user.register', [
	        	'htmlTitle' => '后台注册'
	        	, 'method' => $this->registerMethod
	        	]);
    	}
    }

    // 后台登录后 锁屏
    public function lockUser(Request $request){
        $lock_password = $request->lockPwd;
    }

    // 后台登录 注销
    public function logout(){
        if (Session::has('admin_user_id')){
            Session::forget('admin_user_id');
            Session::forget('admin_user_name');
        }

        return Redirect::route('admin_login'); // 跳转至登录首页
    }

    public function userList() {

    }
}