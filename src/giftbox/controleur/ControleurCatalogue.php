<?php

namespace giftbox\controleur;

use Illuminate\Database\Capsule\Manager as DB;
use giftbox\models as models;
use giftbox\vue as vue;

class ControleurCatalogue {

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
                $listePrestations = models\Prestation::orderBy('prix')
                                                        ->where('display','like',1)
                                                        ->get();
                break;
            case 2:
                $listePrestations = models\Prestation::orderBy('prix', 'DESC')
                                                        ->where('display','like',1)
                                                        ->get();
                break;
            default:
                $listePrestations = models\Prestation::where('display','like',1)
                                                        ->get();
        }

        $data = [$listePrestations, $this->getAllCategorie()];

        $vue = new vue\VueCatalogue($data, "ALL_PRESTATION");
        return $vue->render();
    }

    //Retourne le code HTML correspondant à l'affichage de la prestation que l'on souhaite (il faut donner son id)
    function getPrestationById($id){

        $prestation = models\Prestation::where('id','=',$id)
                            ->first();

        if($prestation != null){
            $vue = new vue\VueCatalogue($prestation, "PRESTATION_BY_ID");
            return $vue->render();
        } else {
            $_SESSION['message']['type'] = "negative";
            $_SESSION['message']['content'] = "Aucun article n'a été trouvé.";
            $_SESSION['message']['header'] = "Erreur !";
            return false;
        }

    }

    function affPrestCat($catid){

        switch ($this->sortMode){
            case 1:
                $listePrestCat = models\Prestation::where('cat_id','=',$catid)
                    ->orderBy('prix')
                    ->where('display','like',1)
                    ->get();
                break;
            case 2:
                $listePrestCat = models\Prestation::where('cat_id','=',$catid)
                    ->orderBy('prix', 'DESC')
                    ->where('display','like',1)
                    ->get();
                break;
            default:
                $listePrestCat = models\Prestation::where('cat_id','=',$catid)
                    ->where('display','like',1)
                    ->get();
        }

        $data = [$listePrestCat, $this->getAllCategorie()];

        $vue = new vue\VueCatalogue($data, "PRESTATION_BY_CATEGORIE");
        return $vue->render();
    }

    function getAllCategorie(){

        return models\Categorie::get();
    }

    function getBestPrestation(){
        $listeBest = models\BestPrestation::get();
        $listeBestPrest = array();
        foreach ($listeBest as $prest){
            $add = models\Prestation::where('id','=',$prest->id_prest)
            ->first();
            $listeBestPrest[] = $add;
        }
        return $listeBestPrest;
    }

    function affValidationNote($id, $success){

        $vue = new vue\VueNote($id);
        return $vue->render($success);
    }

    //ajoute une note à la base de données
    function ajoutNote($id_pre,$note){

        $checked = true;

        //On vérifie si la notation n'a pas déjà été noté dans la session courante
        if(isset($_SESSION['alreadyNoted'])) {

            foreach ($_SESSION['alreadyNoted'] as $idNoted) {

              if ($idNoted == $id_pre) {
                  $checked = false;
              }
            }
        }

         if($checked) {

            if($note >= 1 && $note <= 5) {

                $notation = new models\Notation();
                $notation->note = $note;
                $notation->pre_id = $id_pre;
                $notation->save();

                $prest = models\Prestation::where('id','=',$notation->pre_id)
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

                if (!isset($_SESSION['alreadyNoted'])) {

                     $arrayIdNoted = array($id_pre);
                     $_SESSION['alreadyNoted'] = $arrayIdNoted;
                } else {
                    array_push($_SESSION['alreadyNoted'], $id_pre);
                }
            } else {
            $checked = false;
            }
         }

         return $checked;
    }

    //ajoute une prestation à la base de données
    function ajoutPrestation($nom,$descr,$cat_id,$img){


        $prestation = new models\Prestation();
        $prestation ->nom = $nom;
        $prestation ->descr = $descr;
        $prestation ->cat_id = $cat_id;
        $prestation ->img = $img;
        $prestation ->categorie();

        $prestation->save();

        if (!isset($_SESSION['alreadyNoted'])) {

            $arrayIdNoted = array($id_pre);
            $_SESSION['alreadyNoted'] = $arrayIdNoted;
        } else {
            array_push($_SESSION['alreadyNoted'], $id_pre);
        }
    }

}