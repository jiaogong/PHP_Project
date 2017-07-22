<?php

namespace App\Model\Index;

use Illuminate\Database\Eloquent\Model;
use DB;

class Blog extends Model
{
    protected $table = 'blog';
    public $timestamps = false;


    public static function getBlogList($id){

        return DB::table('blog')

        ->get();
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
