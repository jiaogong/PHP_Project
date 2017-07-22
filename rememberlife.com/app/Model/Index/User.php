<?php

namespace App\Model\Index;

use Illuminate\Database\Eloquent\Model;
use DB;


/**
 * 用户表
 *
 */

class User extends Model
{
    protected $table = 'user';
    public $timestamps = false;
    public $primaryKey = 'user_id';


    public static function findUserName($user_id){
        return DB::table('user')
        ->where('user_id', $id)
        ->value('user_name');
    }

    protected static function add($data){
        return DB::table('user')-> insert($data);

    }

    protected static function login($user_name, $password){
        return DB::table('user')
        ->where('user_name', $user_name)
        ->where('password', $password)
        ->value('user_id');
    }

    protected static function has($user_name){
        return DB::table('user')
        ->where('user_name', $user_name)
        ->select('password', 'salt')
        ->get();
    }


}
