<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Model\User;

class UserController extends Controller
{
	// 前台 - 用户登录
	public function signIn(Request $request)
	{
		if($request->isMethod('get')){
			return view('signin', 
				[
				'noViewLogin' => true, 
				'title' => '登录'
				]);
		}elseif($request->isMethod('post')){
			$id = User::select('id')->where($request->only('name','password'))->get();
			var_dump($id);
			var_dump($request->only('name','password'));
			exit;
			return redirect()->route('index');
		}
	}

	// 前台 - 注册用户
	public function signUp(Request $request)
	{
		if($request->isMethod('get')){

			return view('signup', [
				'noViewLogin' => true, 
				'title' => '注册'
				]);
		}elseif($request->isMethod('post')){

			$this->validate($request, [
				'name' => 'required|max:1000|min:2',
				'email' => 'required|email|unique:user,email',
				'password' => 'required',
				'age' => 'integer|max:200|min:10',
				'sex' => 'nullable',
				'address' => 'nullable'
				]);
				//var_dump($request->all());exit;
			$id = User::create($request->all());
			//$id = $user->save($request->all());
			echo $id->id;

			//return redirect()->route('index');
		}
	}

	public function add ()
	{
		$user = new User;
		$userDatas = $user->all();
		return view('user_add', ['user'=>$userDatas]);
	}

	public function addData(Request $request)
	{
		$user = new User;
		if ($request->isMethod('post')) {
			$this->validate($request, [
				'name' => 'required|max:1000|min:2',
				'email' => 'required',
				'password' => 'required'
			]);
			$user->email = $request->email;
			$user->name = $request->name;
			$user->password = $request->password;
			$ok = $user->save();
			if($ok) echo '添加成功';
			return redirect()->to('Home/user/add')->withErrors('成功');
		} else {
			return redirect('Home/user/add')->withInput();
		}

	}

}
