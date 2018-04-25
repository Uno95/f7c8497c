<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemDelivery extends Model
{
    
    protected $table  = 'item_delivery';
    protected $fillable = ['delivery_number', 'delivery_date', 'status'];
    
    public function getStatusAttribute($value)
    {
        return json_decode($value, true);
    }

    public function ItemOrder()
    {
        return $this->hasOne('App\ConsumenOrder', 'id', 'item_order_id');
    }
}
