<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK extends Model
{
    protected $primaryKey = 'id';
    protected $table  = 'spk';
    protected $fillable = ['spk_num', 'hooks', 'qty', 'persentase_progress'];

    public function Hooks(){
        return $this->hasOne('App\Hooks', 'id', 'hooks');
    }
    
    public function WasteProgress(){
        return $this->hasOne(WasteProgress::class, 'spk_id')
            ->withDefault(function () {
            return new WasteProgress();
        });
    }
}
