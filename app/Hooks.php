<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hooks extends Model
{
    // protected $hookParams = json_encode($this->attributes['hook_params'], true);
    public $timestamps = false;

    protected $primaryKey = 'id';
    protected $table  = 'hooks';
    protected $fillable = ['hook_params'];

    public function getHookParamsAttribute($value)
    {
        return json_decode($value, true);
    }
}
