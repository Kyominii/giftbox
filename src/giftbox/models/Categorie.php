<?php

namespace giftbox\models;

class Categorie extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'categorie';
    protected $primaryKey = 'id';
    public $timestamps = false;

    //Déclaration de relation avec le modèle Prestation
    public function prestations(){
        return $this->hasMany('\giftbox\models\Prestation', "cat_id");
    }

    //Déclaration de relation avec le modèle BrestPrestation
    public function bestPrestations(){
        return $this->hasMany('\giftbox\models\BestPrestation', "id_cat");
    }
}