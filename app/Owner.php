<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'id';
    protected $table = 'owner';
    protected $fillable = ['name', 'password', 'address', 'email', 'phone'];

    
}
