<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemWaste extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'id';
    protected $table  = 'item_waste';
    protected $fillable = ['proses', 'no_mesin', 'masuk', 'keluar', 'rusak','sisa', 'tanggal', 'spk_id' ];

    public function Spk()
    {
        return $this->belongsTo('App\SPK', 'spk_id');
    }
    

}
