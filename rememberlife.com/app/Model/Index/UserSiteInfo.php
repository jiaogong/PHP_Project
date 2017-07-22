<?php

namespace App\Model\Index;

use Illuminate\Database\Eloquent\Model;
use DB;


/**
 * 用户网站信息表
 *
 */
class UserSiteInfo extends Model
{
    protected $table = 'user_site_info';
    public $timestamps = false;


    public static function findvv($id){

        // return DB::table('user')->get();


        // return $id;
    }

    protected static function add($data){
        return DB::table('user')-> insert($data);

    }

    protected static function login($name, $password){
        return DB::table('user')
        ->where('name', $name)
        ->where('password', $password)
        ->value('id');


    }


}
