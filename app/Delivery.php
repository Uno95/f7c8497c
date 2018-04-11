<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table    = 'consumen_delivery';
    protected $fillable = ['delivery_number', 'consumen', 'delivery_qty', 'hooks_id', 'delivery_date',
                          'delivery_left', 'status'];

    public function hooks(){
        return $this->belongsTo(Hooks::class, 'hooks_id')
            ->withDefault(function () {
            return new Hooks();
        });
    }
}
