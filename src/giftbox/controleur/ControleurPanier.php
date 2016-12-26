<?php

namespace giftbox\controleur;

use Illuminate\Database\Capsule\Manager as DB;
use giftbox\models as models;
use giftbox\vue\VuePanier;

class ControleurPanier
{

    //On initialise la connexion à la BDD
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

    //Ajout de l'article n°ID dans le panier
    public function addBasket($id){

        //On test si un apnier est déjà créé
        if(!isset($_SESSION['basket'])){

            $_SESSION['basket'] = array($id => 1);
        } else {

            //S'il existe déjà, on incrémente le nombre d'article de 1 sinon on met ce nombre à 1
            if(array_key_exists($id, $_SESSION['basket'])){

                $_SESSION['basket'][$id] = $_SESSION['basket'][$id] + 1;
            } else {

                $_SESSION['basket'][$id] = 1;
            }
        }
    }

    //Retraite de l'article du panier
    public function removeBasket($id){

        //Si le panier existe
        if(isset($_SESSION['basket'])){

            //Si l'article est déjà présent dans le panier
            if(array_key_exists($id, $_SESSION['basket'])){

                //On supprime l'entrée du tableau
                unset($_SESSION['basket'][$id]);
            }
        }

    }

    //Retourne le nombre d'article actuellement dans le panier
    public static function getAmountInBasket(){

        //Si le panier n'existe pas, on retourne 0
        if(!isset($_SESSION['basket'])){

            return 0;
        } else {

            //Sinon on retourne la taille du tableau
            return count($_SESSION['basket']);
        }
    }

    //Retourne le code HTML
    public function renderBasket()
    {

        $data = [];

        if (isset($_SESSION['basket'])) {

            //Pour chaque entrée dans le panier
            foreach ($_SESSION['basket'] as $id => $amount) {

                //On récupère la prestation associé à l'id de l'article dans le panier
                $prestation = models\Prestation::select('id','nom','descr','cat_id','img','prix')
                    ->where('id','=',$id)
                    ->first();

                //On ajoute dans le tableau de données pour la vue le nombre de prestation et la prestation elle même
                $data[$prestation->id] = [$prestation, $amount];
            }
        }

        $vue = new VuePanier($data);

        //On retourne le code HTML généré par la vue
        return $vue->render();
    }

}