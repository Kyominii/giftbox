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

    //méthode qui calcule la moyenne des note
    public static function moyenne($note){
        $moy = 0;
        $taille = 0;
        foreach ($note as $n){
            $taille++;
            $moy = $moy + $n->note;
        }
        if($taille != 0){
            return $moy/$taille."/5";
        }else{
            return "pas de note";
        }

    }
}