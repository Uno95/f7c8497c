<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WasteProgress extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'id';
    protected $table = 'waste_progress';
    protected $fillable = ['spk_id', 'potong_1', 'grinding', 'potong_2', 'auto', 'forged', 'bakar', 'tempering', 'finishing'];
}
