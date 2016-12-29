<?php

namespace giftbox\controleur;

use Illuminate\Database\Capsule\Manager as DB;
use giftbox\models as models;
use giftbox\vue as vue;

class ControleurGestionnaire {

    //Constructeur du controleur du gestionnaire
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


    //ajoute une prestation à la base de données
    function ajoutPrestation($nom,$descr,$cat_id,$img,$prix){


        $prestation = new models\Prestation();
        $prestation->nom = $nom;
        $prestation->descr = $descr;
        $prestation->cat_id = $cat_id;
        $prestation->img = $img;
        $prestation->prix = $prix;

        $prestation->save();

        return true;

    }

    //supprime une prestation à la base de données
    function supressionPrestation($id){

        models\Prestation::where('id','=',$id)
            ->delete();

        return true;

    }

    //susppention et désusppention
    function suspenssionPrestation($id){
        $prestation = models\Prestation::where('id','=',$id)
                                            ->first();
        if($prestation != NULL){
            if($prestation->display == 1){
                $prestation->display = 0;
                $prestation->save();
            }else {
                $prestation->display = 1;
                $prestation->save();
            }
            return true;
        }else{
            return false;
        }
    }

    //gère la connexion
    function connexion($pseudo, $mdp){
        $res = models\Utilisateur::where('pseudo','like',$pseudo)->first();

        if(crypt($mdp, "giftboxSalt_betterSecurity") == $res->mdp){
            if($res != NULL){
                if($res->grade == 'admin'){
                    $_SESSION["connecte"]=1;
                    return true;
                }else{
                    $_SESSION["connecte"]=0;
                    return true;
                }
            }else{
                return false;
            }
        }

    }

    //affiche si une connexion c'est bien effectué ou on
    function affValidationConnextion($success){
        if($success == true){
            $vue = new vue\VueConnexion("ConnexionT");
        }else{
            $vue = new vue\VueConnexion("ConnexionF");
        }
        echo $vue->render();
    }

}