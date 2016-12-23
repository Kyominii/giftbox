<?php

namespace giftbox\controleur;

use Illuminate\Database\Capsule\Manager as DB;
use giftbox\models as models;
use giftbox\vue as vue;

class ControleurCatalogue {

    private $db;
    private $sortMode;

    //Constructeur du controleur du catalogue
    function __construct($sort = 0){
        $db = new DB();

        //Chargement du fichier de configuration
        $config=parse_ini_file('src/conf/db.ini');

        //Création de la connexion à la base de données
        $db->addConnection( [
            'driver' => $config['driver'],
            'host' => $config['host'],
            'database' => $config['database'],
            'username' => $config['username'],
            'password' => $config['password'],
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
        ] );
        $db->setAsGlobal();
        $db->bootEloquent();

        $this->sortMode = $sort;
    }

    //Fonction qui retourne la lsite de toute les prestations
    function getAllPrestations(){

        switch ($this->sortMode){
            case 1:
                $listePrestations = models\Prestation::orderBy('prix')->get();
                break;
            case 2:
                $listePrestations = models\Prestation::orderBy('prix', 'DESC')->get();
                break;
            default:
                $listePrestations = models\Prestation::get();
        }

        $vue = new vue\VueCatalogue($listePrestations, "ALL_PRESTATION");
        return $vue->render();
    }

    //Retourne le code HTML correspondant à l'affichage de la prestation que l'on souhaite (il faut donner son id)
    function getPrestationById($id){

        $prestation = models\Prestation::select('id','nom','descr','cat_id','img','prix')
                            ->where('id','=',$id)
                            ->first();

        $vue = new vue\VueCatalogue($prestation, "PRESTATION_BY_ID");
        return $vue->render();
    }

    //Je ne vois pas à quoi sert cette fonction pour le moment (il faut continuer à la dev)
    function affPrestCat(){

        $cat = models\Prestation::select('id','nom','descr','cat_id','img','prix')->get();
    }

    function affValidationNote($id){
        $vue = new vue\VueNote($id);
        return $vue->render();
    }

    //ajoute une note à la base de donnée
    function ajoutNote($id_pre,$note){
        $notation = new models\Notation();
        $notation->note = $note;
        $notation->pre_id = $id_pre;
        $notation->save();
    }
}