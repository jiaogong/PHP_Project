<?php

namespace App\Model\Index;

use Illuminate\Database\Eloquent\Model;
use DB;


/**
 * 用户留言表
 *
 */
class UserComment extends Model
{
    protected $table = 'user_comment';
    public $timestamps = false;



    public static function findvv($id){

        // return DB::table('user')->get();


        // return $id;
    }

    protected static function add($data){
        return DB::table('user_contact')-> insert($data);

    }

    protected static function login($name, $password){
        return DB::table('user_contact')
        ->where('name', $name)
        ->where('password', $password)
        ->value('id');


    }


}
