<?php

namespace giftbox\models;

class Prestation extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'prestation';
    protected $primaryKey = 'id';
    public $timestamps = false;

    //Déclaration de relation avec le modèle Categorie
    public function categorie(){
        return $this->belongsTo('\giftbox\models\Categorie', "cat_id");
    }
}