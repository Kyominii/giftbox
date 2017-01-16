<?php

namespace giftbox\models;

class Contribution extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'contribution';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function cagnotte(){
        return $this->belongsTo('\giftbox\models\Cagnotte', 'id_cagnotte');
    }
}