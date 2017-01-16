<?php
namespace giftbox\controleur;

use giftbox\vue\VueCagnotte;
use giftbox\vue\VuePanier;
use Illuminate\Database\Capsule\Manager as DB;
use giftbox\models as models;

class ControleurCagnotte
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

    public function showPool($slug){

        $cagnotte = models\Cagnotte::where('slug', '=', $slug)->first();

        if($cagnotte != null){

            $data = array();
            $data['contributions'] = $cagnotte->contributions;
            $data['slug'] = $slug;

            if(isset($_SESSION['connectedPool'][$slug]) && $_SESSION['connectedPool'][$slug]){

                $data['isConnected'] = true;
            } else {

                $data['isConnected'] = false;
            }

            foreach ($cagnotte->coffret->prestations as $prestation){
                $data['prestations'][] = [models\Prestation::where('id', '=', $prestation['id_prestation'])->first(), $prestation['nb_prestation']];
            }

            $vue = new VueCagnotte($data);
            return $vue->render("SHOW_POOL");

        } else {

            $_SESSION['message']['type'] = "negative";
            $_SESSION['message']['content'] = "L'URL renseignée ne correspond à aucune cagnotte !";
            $_SESSION['message']['header'] = "Erreur !";
            return false;
        }
    }

    public function addPool($slug, $nom, $prenom, $montant){
        $cagnotte = models\Cagnotte::where('slug', '=', $slug)->first();

        if($cagnotte != null){

            $contribution = new models\Contribution();
            $contribution->id_cagnotte = $cagnotte->id;
            $contribution->prenom = $prenom;
            $contribution->nom = $nom;
            $contribution->montant = $montant;
            $contribution->save();

            $_SESSION['message']['type'] = "positive";
            $_SESSION['message']['content'] = "Votre contribution a été ajouté !";
            $_SESSION['message']['header'] = "Succès !";

            return true;

        } else {
            $_SESSION['message']['type'] = "negative";
            $_SESSION['message']['content'] = "L'URL renseignée ne correspond à aucune cagnotte !";
            $_SESSION['message']['header'] = "Erreur !";
            return false;
        }
    }

    public function connectPool($slug, $pass){
        $cagnotte = models\Cagnotte::where('slug', '=', $slug)->first();

        if($cagnotte != null && password_verify($pass, $cagnotte->motdepasse)){

            $_SESSION['connectedPool'][$slug] = true;
            return true;
        } else {

            return false;
        }
    }

    public function validPool($slug){
        $cagnotte = models\Cagnotte::where('slug', '=', $slug)->first();

        if($cagnotte != null && $_SESSION['connectedPool'][$slug]){

            $prixTotal = 0;
            $prixContribution = 0;

            foreach ($cagnotte->coffret->prestations as $prestation){

                $prestation = models\Prestation::where('id', '=', $prestation['id_prestation'])->first();
                $nb = $prestation['nb_prestation'];

                $prixTotal = $prixTotal + ($prestation->prix * $nb);
            }

            foreach ($cagnotte->contributions as $contribution){

                $prixContribution = $prixContribution + $contribution->montant;
            }

            if($prixContribution < $prixTotal){

                return false;
            } else {

                $cagnotte->slug = "";
                $cagnotte->save();

                $coffret = models\Coffret::where('id', '=', $cagnotte->coffret->id)->first();
                $coffret->date_paiement = date('Y-m-d');
                $coffret->slug = "";
                $coffret->save();

                $vue = new VuePanier(null);
                return $vue->render("FINISH");
            }
        }
    }
}