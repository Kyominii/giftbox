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

    public function isValid(){
        if(isset($_SESSION['basket'])) {

            if (ControleurPanier::getAmountInBasket() >= 2) {

                $categorie = array();

                //Pour chaque entrée dans le panier
                foreach ($_SESSION['basket'] as $id => $amount) {

                    //On récupère la prestation associé à l'id de l'article dans le panier
                    $prestation = models\Prestation::select('id','nom','descr','cat_id','img','prix')
                        ->where('id','=',$id)
                        ->first();

                    $alreadyExists = false;
                    foreach ($categorie as $value){
                        if($value == $prestation->cat_id){
                            $alreadyExists = true;
                        }
                    }

                    if(!$alreadyExists){
                        array_push($categorie, $prestation->cat_id);
                    }
                }

                if(count($categorie) >= 2){
                    return true;
                }
            }
        }

        return false;

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

        if(isset($_SESSION['basketLoaded'])){

            $coffret = models\Coffret::where('id', '=', $_SESSION['basketLoaded'])->first();

            if(!empty($coffret)){

                $isBasketLoaded = $coffret->slug;
            } else {

                $isBasketLoaded = -1;
            }
        } else {

            $isBasketLoaded = -1;
        }

        if(count($data) == 0){

            $_SESSION['message']['type'] = "warning";
            $_SESSION['message']['content'] = "Aucun article n'a été ajouté au panier.";
            $_SESSION['message']['header'] = "Attention !";
            return "empty";
        }

        $vue = new VuePanier([$data, $this->isValid(), $isBasketLoaded]);

        //On retourne le code HTML généré par la vue
        return $vue->render("PREVIEW");
    }

    public function renderSummaryBasket($nom, $prenom, $numRue, $nomRue, $ville, $cp, $email, $pays, $msg, $paiement){

        $data['nom'] = $nom;
        $data['prenom'] = $prenom;
        $data['numRue'] = $numRue;
        $data['nomRue'] = $nomRue;
        $data['ville'] = $ville;
        $data['cp'] = $cp;
        $data['email'] = $email;
        $data['pays'] = $pays;
        $data['msg'] = $msg;
        $data['paiement'] = $paiement;
        $data['panier'] = array();

        foreach ($_SESSION['basket'] as $id => $amount) {

            $prestation = models\Prestation::select('id','nom','descr','cat_id','img','prix')
                ->where('id','=',$id)
                ->first();

            array_push($data['panier'], [$prestation, $amount]);
        }

        $vue = new VuePanier($data);
        return $vue->render("RECAPITULATIF");
    }

    public function renderSummaryLoadedBasket(){

        $coffret = models\Coffret::where('id', '=', $_SESSION['basketLoaded'])->first();

        $data['nom'] = $coffret->client->nom;
        $data['prenom'] = $coffret->client->prenom;
        $data['numRue'] = $coffret->client->numAdresse;
        $data['nomRue'] = $coffret->client->nomAdresse;
        $data['ville'] = $coffret->client->ville;
        $data['cp'] = $coffret->client->codePostal;
        $data['email'] = $coffret->client->email;
        $data['pays'] = $coffret->client->pays;
        $data['msg'] = $coffret->message;
        $data['paiement'] = $coffret->paiement;
        $data['panier'] = array();

        foreach ($_SESSION['basket'] as $id => $amount) {

            $prestation = models\Prestation::select('id','nom','descr','cat_id','img','prix')
                ->where('id','=',$id)
                ->first();

            array_push($data['panier'], [$prestation, $amount]);
        }

        $vue = new VuePanier($data);
        return $vue->render("RECAPITULATIF");
    }

    public function confirmBasket($nom, $prenom, $numRue, $nomRue, $ville, $cp, $email, $pays, $msg, $paiement, $sauvegarde, $password){

        if(!isset($_SESSION['basketLoaded'])) {

            $client = models\Client::where('nom', '=', $nom)
                ->where('prenom', '=', $prenom)
                ->first();

            if (!$client) {
                $client = new models\Client();
                $client->nom = $nom;
                $client->prenom = $prenom;
                $client->numAdresse = $numRue;
                $client->nomAdresse = $nomRue;
                $client->ville = $ville;
                $client->codePostal = $cp;
                $client->email = $email;
                $client->pays = $pays;
                $client->save();
            }

            $coffret = new models\Coffret();
            $coffret->date_creation = date('Y-m-d');
            $coffret->paiement = $paiement;
            $coffret->id_cli = $client->id;
            $coffret->message = $msg;
            $coffret->save();

        } else {
            models\Contient::where('id_coffret', '=', $_SESSION['basketLoaded'])->delete();
            $coffret = models\Coffret::where('id', '=', $_SESSION['basketLoaded'])->first();
        }

        foreach ($_SESSION['basket'] as $id => $amount) {

            $contient = new models\Contient();
            $contient->id_coffret = $coffret->id;
            $contient->id_prestation = $id;
            $contient->nb_prestation = $amount;
            $contient->save();
        }

        if ($sauvegarde != "true") {

            if ($paiement == "Classique") {

                $_SESSION['purchaseInProgress'] = $coffret->id;
                $vue = new VuePanier(null);
                $html = $vue->render("PAY_CLASSIC");
            } else {

                $coffret->slug = "";
                $cagnotte = new models\Cagnotte();
                $cagnotte->id_coffret = $coffret->id;
                $cagnotte->slug = sha1(uniqid("cag", true));
                $cagnotte->motdepasse = password_hash($password, PASSWORD_BCRYPT);
                $cagnotte->save();
                $vue = new VuePanier($cagnotte);
                $_SESSION['message']['type'] = "positive";
                $_SESSION['message']['content'] = "Vous pouvez transmettre <a href='/cagnotte/" . $cagnotte->slug . "'>cette URL a vos amis</a> pour participer à la cagnotte.";
                $_SESSION['message']['header'] = "Succès !";
                return $vue->render("ASK_PASS_BASKET");
            }
        } else {

            if($password != ""){
                $coffret->motdepasse = password_hash($password, PASSWORD_BCRYPT);
                $coffret->save();
            }

            if(!isset($_SESSION['basketLoaded'])) {

                $coffret->slug = sha1(uniqid("ges", true));
                $coffret->save();
                $_SESSION['basketLoaded'] = $coffret->id;
            }

            $_SESSION['message']['type'] = "positive";
            $_SESSION['message']['content'] = "Vous pouvez chargé votre panier avec cet ID : " . $coffret->slug . " dans le menu \"Gérer un coffret\" ou bien <a href='/panier/charger/" . $coffret->slug . "'>utiliser cette adresse</a>";
            $_SESSION['message']['header'] = "Succès !";

            $vue = new VuePanier(null);
            $html = $vue->render("ASK_PASS_BASKET");
        }


        return $html;
    }

    public function paymentDone(){

        $idCoffret = $_SESSION['purchaseInProgress'];
        unset($_SESSION['purchaseInProgress']);
        unset($_SESSION['basket']);
        if(isset($_SESSION['basketLoaded']))
            unset($_SESSION['basketLoaded']);

        $coffret = models\Coffret::where('id', '=', $idCoffret)->first();
        $coffret->date_paiement = date('Y-m-d');
        $coffret->slug = "";
        $coffret->urlCadeau = sha1(uniqid("cad", true));
        $coffret->save();

        $vue = new VuePanier($coffret);
        return $vue->render("FINISH");
    }

    public function askPassSlug($slug = ""){
        $vue = new VuePanier($slug);
        $html = $vue->render("ASK_PASS_BASKET");
        return $html;
    }

    public function loadBasket($slug, $password){

        $coffret = models\Coffret::where('slug', '=', $slug)->first();

        if(!is_null($coffret) && (password_verify($password, $coffret->motdepasse) || is_null($coffret->motdepasse))){

            if(!empty($coffret)){

                unset($_SESSION['basket']);

                foreach ($coffret->prestations as $prestation){
                    for($i=0; $i < $prestation->nb_prestation; $i++){
                        $this->addBasket(models\Prestation::where('id', '=', $prestation->id_prestation)->first()->id);
                    }
                }
                $_SESSION['basketLoaded'] = $coffret->id;
            }

            $data['slug'] = $slug;

            $_SESSION['message']['type'] = "positive";
            $_SESSION['message']['content'] = "Votre coffret a été chargé avec succès !";
            $_SESSION['message']['header'] = "Succès !";

            return "success";

        } else {

            $_SESSION['message']['type'] = "negative";
            $_SESSION['message']['content'] = "Veuillez vérifier votre ID coffret ainsi que votre mot de passe associé. <br /><i class='warning sign icon'></i>Un coffret payé n'est plus disponible à la gestion   <i class='warning sign icon'></i>";
            $_SESSION['message']['header'] = "Erreur !";

            $vue = new VuePanier(null);
            $html = $vue->render("ASK_PASS_BASKET");
            return $html;
        }


    }
}