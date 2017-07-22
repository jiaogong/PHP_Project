<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = array('id', 'name', 'email', 'password', 'phone', 'age', 'sex', 'address');
    public $timestamps = true;

}