<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Acticle extends Model
{
    protected $table='user';
    protected $fillable = array('id', 'name', 'email', 'password', 'create_at', 'update_at');
    public $timestamps = true;

}