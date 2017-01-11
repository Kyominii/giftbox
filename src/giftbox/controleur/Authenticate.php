<?php

namespace giftbox\controleur;

use Illuminate\Database\Capsule\Manager as DB;
use giftbox\models as models;
use giftbox\vue as vue;

class Authenticate {


    //Constructeur du controleur du catalogue
    function __construct(){
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


    public static function authenticate($username,$pass){
        $user = models\Utilisateur::where('pseudo','like',$username)
                                    ->first();
        if($user != null){
            if(password_verify($pass, $user->mdp)){
                Authenticate::loadProfile($user);
            }
        }
    }

    public static function loadProfile($user){
        if(isset($_SESSION['profil'])){
            unset($_SESSION['profil']);
        }
        $tab = array('pseudo' => $user->pseudo,
            'id' => $user->id,
        'grade' => $user->grade);

        $_SESSION['profil'] = $tab;
    }

    public static function checkAcessRights($required){
            if(isset($_SESSION['profil'])){
                if($required != $_SESSION['profil']->grade){
                    echo "b";
                    throw new \Exception();
                }
            }else{
                echo "a";
                throw new \Exception();
            }

    }




}