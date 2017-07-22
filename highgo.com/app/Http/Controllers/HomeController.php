<?php

namespace App\Http\Controllers;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HomeController extends Controller
{
    public function index ()
    {
        $user = new  User;
        $users = $user::paginate(1);
        return view('home', ['users'=>$users]);
    }
    
    public function add (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users|max:255',
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = new User;
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = $request->get('password');

        if($user->save()){
            return redirect('home');
        }else{
            return redirect()->back()->withInput();
        }
    }

}
