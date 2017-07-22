<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Session;

/**
 * 用户表
 *
 */

class AdminUser extends Model
{
    protected $table = 'admin_user';
    public $timestamps = false;
    public $primaryKey = 'user_id';


    public static function findUserName($user_id){
        return DB::table('admin_user')
        ->where('user_id', $id)
        ->value('user_name');
    }

    protected static function add($data){
        return DB::table('admin_user')-> insert($data);

    }

    protected static function login($user_name, $password){
        $user_info = self::exists($user_name);
        if ( $user_info && $user_info->password && $user_info->salt ) {
            if (md5(md5($password).$user_info->salt) === $user_info->password) {
                if ( !Session::has('admin_user_id') ) {
                    Session::put('admin_user_id', $user_info->user_id);
                    Session::put('admin_user_name', $user_info->user_name);
                }
                return true;
            }
        } 
        return false;
    }

    protected static function exists($user_name){
        return DB::table('admin_user')
        ->where('user_name', $user_name)
        ->first();
    }


}
