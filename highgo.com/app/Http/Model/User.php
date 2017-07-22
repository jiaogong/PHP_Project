<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	protected $table="user";
	protected $fillable = array(
		'id',
		'email', 
		'name',
		'password',
        'phone',
        'age',
        'sex',
        'address',
		'created_at',
		'updated_at'
	);
	public $timestamps= true;

}

