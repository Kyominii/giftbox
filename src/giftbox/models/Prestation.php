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

    //Déclaration de relation avec le modèle Notation
    public function notation(){
        return $this->hasMany('\giftbox\models\Notation', "pre_id");
    }

    //méthode qui calcule la moyenne des notes
    public function moyenne(){

        $somme = 0;
        $taille = 0;

        foreach ($this->notation as $rowNote){
            $taille++;
            $somme = $somme + $rowNote->note;
        }

        if($taille != 0){

            return round($somme/$taille);
        }else{

            return 0;
        }
    }
}