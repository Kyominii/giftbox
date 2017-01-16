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

        $best = models\BestPrestation::where('id_prest','=',$id)
            ->first();

        if($best != NULL){
            models\BestPrestation::where('id_prest','=',$id)
                ->delete();
            $cat = models\Categorie::where('id','=',$best->id_cat)
                ->first();
            $note = -1;
            $id = -1;
            $listePrest = models\Prestation::where('cat_id','=',$cat->id)
                ->where('display','like',1)
                ->get();
            foreach ($listePrest as $index => $p){
                if($p->moyenne() > $note){
                    $note = $p->moyenne();
                    $id = $index;
                }
            }

            $new = new models\BestPrestation();
            $new->id_cat = $best->id_cat;
            $new->id_prest = $listePrest[$id]->id;
            $new->save();
        }

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

                $best = models\BestPrestation::where('id_prest','=',$id)
                    ->first();

                if($best != NULL){
                    models\BestPrestation::where('id_prest','=',$id)
                        ->delete();
                    $cat = models\Categorie::where('id','=',$best->id_cat)
                        ->first();
                    $note = -1;
                    $id = -1;
                    $listePrest = models\Prestation::where('cat_id','=',$cat->id)
                        ->where('display','like',1)
                        ->get();
                    foreach ($listePrest as $index => $p){
                        if($p->moyenne() > $note){
                            $note = $p->moyenne();
                            $id = $index;
                        }
                    }

                    $new = new models\BestPrestation();
                    $new->id_cat = $best->id_cat;
                    $new->id_prest = $listePrest[$id]->id;
                    $new->save();
                }

            }else {
                $prestation->display = 1;
                $prestation->save();

                $prest = models\Prestation::where('id','=',$id)
                    ->first();

                $best = models\BestPrestation::where('id_cat','=',$prest->cat_id)
                    ->first();


                if($best != NULL){
                    $bestPrest = models\Prestation::where('id','=',$best->id_prest)
                        ->first();
                    if($prest->moyenne() > $bestPrest->moyenne()){
                        models\BestPrestation::where('id_cat','=',$prest->cat_id)
                            ->delete();
                        $new = new models\BestPrestation();
                        $new->id_cat = $prest->cat_id;
                        $new->id_prest = $prest->id;
                        $new->save();
                    }
                }else{
                    $new = new models\BestPrestation();
                    $new->id_cat = $prest->cat_id;
                    $new->id_prest = $prest->id;
                    $new->save();
                }
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
        return $vue->render();
    }

}