<?php

namespace giftbox\controleur;

use giftbox\vue\VueCoffret;
use Illuminate\Database\Capsule\Manager as DB;
use giftbox\models as models;

class ControleurCoffret
{

    public function __construct(){

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
    }

    public function getIdBySlug($slug){

        $coffret = models\Coffret::select('id', 'slug')->where('slug', '=', $slug)->first();

        if($coffret){
            return $coffret->id;
        }

        return -1;
    }

    public function displayGift($slug){

        $vue = new VueCoffret($this->getIdBySlug($slug));
        return $vue->render();
    }
}