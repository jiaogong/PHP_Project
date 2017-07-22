<?php

namespace App\Http\Controllers\Index;

use App\User;
use App\Http\Controllers\Controller;

use App\Model\Index\User as UserModel;
use App\Model\Index\UserSiteInfo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\PublicFunc\Funcs; // 私有的公共方法
use Illuminate\Contracts\Validation\Validator; //验证表单信息

class UserController extends Controller
{
    /**
    * 为指定用户显示详情
    *
    * @param int $id
    * @return Response
    */

    public static function account()
    {
        return view('index.user.account',
        [
            // 'userId' => userModel::findvv($id)
            'htmlTitle' => '用户个人中心页'
        ]);
    }

    // 注册用户
    public static function register(){
        // var_dump($table);
        // return DB::table('user')->get();

        return view('index.user.register',
        [
            'htmlTitle' => '用户注册页'
        ]);
    }

    // 添加用户信息到数据库
    public static function add(Request $request)
    {
        // $result = [
        //     'id' => 0,
        //     'name' => $request->name,
        //     'password' => md5($request->password),
        //     'mail' => $request->mail,
        //     'phone' => $request->phone,
        //     'sex' => $request->sex ? 'secret' : 'secret',
        //     'age' => $request->age ? 12 : 12,
        //     'address' => $request->address
        // ];
        $userModel =  new UserModel;
        // $userSiteInfoModel = new UserSiteInfo;
        // $result = $request->input();
        // if(array_key_exists('_token', $result)){
        //     unset($result['_token']);
        // }
        // var_dump($result);

        // 上传图片
        // $avatarImagePath = ''; // 如果上传头像返回头像的完整存储路径
        // if ($fileExtension = $request->avatarFile){
        //     // $fileExtension = $request->avatarFile;
        //     $fileExtensionString = $fileExtension->getMimetype();
        //     $fileExtensionName = Funcs::getLoadFileTOExtension($fileExtensionString);
        //     $file = $request->filefield->move(
        //         Config('Index_Update_Img_Paht') . 'user_avatar/' . date('Ym', time()),
        //         time().rand(111, 999) . $fileExtensionName
        //     );
        //     $avatarImagePath = '/'. $file->getPathName();
        // }


        // input 验证
        // $validator = Validator::make($request::all(), [
        //         'name' => 'string|max:3'
        //
        // ]);
        //

        // 将数据保存数据库
        // $this->validate($request, [
        //     'title' => 'required|unique:posts|max:255',
        //     'body' => 'required',
        //     ]);
        // if($validator->fails()){ // 通过验证
            
            $user_salt = Funcs::getPasswordSalt();
            $userModel->user_name = $request->name;
            $userModel->password = md5(md5($request->password) . $user_salt);
            $userModel->email = $request->mail;
            $userModel->phone = $request->phone ?  '139'. rand(10000000,99999999) : '139'. rand(10000000,99999999);
            $userModel->salt = $user_salt;
            $userModel->created_at = time();
            $userModel->updated_at = time();
            $userModel->save();
            $user_id = userModel::login($userModel->user_name, $userModel->password);
            if($user_id){
                Session::put('user_id', $user_id);
                Session::put('user_name', $userModel->user_name);
                return view('index.user.userResult', [
                    'htmlTitle' => '登录结果页'
                    , 'message' => '登录成功'
                    , 'gotoUrl' => route('home')
                    , 'gotoTime' => ''
                ]);
            } else {
                return view('index.user.userResult', [
                    'htmlTitle' => '登录结果页'
                    , 'message' => '登录失败'
                    , 'gotoUrl' => route('login')
                    , 'gotoTime' => ''
                ]);
            }
    }
    // 用户登录页
    public static function login(Request $request){
        // $errors = 'ooo';
        // return response()->json($errors, 404);
        if(!Session::has('user_id') && $request && $request->isMethod('post')){ # 提交登录信息
            $name = $request->name;
            // $password = md5(md5($request->password, $user_salt));
            $user_info = userModel::has($name);
            var_dump($user_info);exit;
            if($user_id){
                Session::put('user_id', $user_id);
                Session::put('user_name', $name);
                return view('index.user.userResult', [
                    'htmlTitle' => '登录结果页'
                    , 'message' => '登录成功'
                    , 'gotoUrl' => route('home')
                    , 'gotoTime' => ''
                ]);
            } else {
                return view('index.user.userResult', [
                    'htmlTitle' => '登录结果页'
                    , 'message' => '登录失败'
                    , 'gotoUrl' => route('login')
                    , 'gotoTime' => ''
                ]);
            }
        } elseif (!Session::has('user_id')) { # 登录请求表页
            return view('index.user.login', [
                'htmlTitle' => '用户登录页'
            ]);
        } elseif (Session::has('user_id') && !Session::has('user_name')){
            $user_name = userModel::findUserName(Session::get('user_id'));
            Session::put('user_name', $user_name);
            return view('index.user.userResult', [
                'htmlTitle' => '登录结果页'
                , 'message' => '登录成功'
                , 'gotoUrl' => route('home')
                , 'gotoTime' => ''
            ]);
        } elseif (Session::has('user_id') && Session::has('user_name')){
            return view('index.user.userResult', [
                'htmlTitle' => '登录结果页'
                , 'message' => '登录成功'
                , 'gotoUrl' => route('home')
                , 'gotoTime' => ''
            ]);
        }
    }

    // 用户退出登录页
    public static function logout(){
        if(Session::has('user_id')) Session::forget('user_id');
        if(Session::has('user_name')) Session::forget('user_name');
        return view('index.user.userResult', [
            'htmlTitle' => '用户退出页'
            , 'message' => '退出成功'
            , 'gotoUrl' => route('home')
            , 'gotoTime' => ''
        ]);
    }

    /**
     * [userResult 用户结果页]
     * @param  string  $title    [结果页：标题]
     * @param  string  $message  [结果页：信息]
     * @param  string  $gotoUrl  [结果页：跳转的url]
     * @param  integer $gotoTime [结果页：跳转url的时间 默认为3秒]
     * @return [type]            [结果页]
     */
    public static function userResult($title, $message, $gotoUrl='', $gotoTime=3){
        return view('index.user.userResult', [
            'htmlTitle' => $title
            , 'message' => $message
            , 'gotoUrl' => $gotoUrl
            , 'gotoTime' => $gotoTime
        ]);
    }
}
