<?php

namespace giftbox\models;

class Cagnotte extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'cagnotte';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function coffret(){
        return $this->belongsTo('\giftbox\models\Coffret', 'id_coffret');
    }

    public function contributions(){
        return $this->hasMany('\giftbox\models\Contribution', 'id_cagnotte');
    }
}