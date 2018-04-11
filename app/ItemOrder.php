<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemOrder extends Model
{
    
    protected $table  = 'item_order';
    protected $fillable = ['order_number', 'consumen', 'order_date', 'status'];

    public function ConsumenOrder()
    {
        return $this->hasMany('App\ConsumenOrder', 'order_parent_id');
    }
}
