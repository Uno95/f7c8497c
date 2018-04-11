<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hooks extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'id';
    protected $table  = 'hooks';
    protected $fillable = ['hook_params'];

    // protected $fillable = ['hook_type', 'hook_size', 'price'];

    // public function hooks(){
    //     return $this->hasMany(ConsumenOrder::class, 'hooks_id')
    //         ->withDefault(function () {
    //         return new ConsumenOrder();
    //     });
    // }
}
