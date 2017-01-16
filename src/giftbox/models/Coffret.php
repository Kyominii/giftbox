<?php

namespace giftbox\models;


class Coffret extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'coffret';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function prestations(){
        return $this->hasMany('\giftbox\models\Contient', 'id_coffret');
    }

    public function client(){
        return $this->belongsTo('\giftbox\models\Client', 'id_cli');
    }
}