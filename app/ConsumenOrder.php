<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsumenOrder extends Model
{
    public $timestamps = false;
    protected $table  = 'consumen_order';
    protected $fillable = ['order_qty', 'hooks_id', 'order_left', 'price', 'order_parent_id'];

    // public function Hook()
    // {
    //     $arrDefault = [];
    //     return $this->hasOne('App\Hooks', 'id')->withDefault(['hook_params' => $arrDefault]);
    // }

    public function Hook(){
        return $this->hasOne(Hooks::class, 'id')
            ->withDefault(function () {
            return new Hooks();
        });
    }
}
