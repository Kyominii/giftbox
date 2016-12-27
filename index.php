<?php
session_start();
require_once ("vendor/autoload.php");
use giftbox\controleur as controleur;

//Création de l'objet du micro-framework
$app = new \Slim\Slim;

//Cas où nous sommes à la racine du site
$app->get('/', function(){
    $controlCatalogue = new controleur\ControleurCatalogue();
    $listePrest = $controlCatalogue->getBestPrestation();
    $vueAccueil = new \giftbox\vue\VueAccueil();
    echo $vueAccueil->render($listePrest);
});

//Cas où on veut afficher tout le catalogue
$app->get('/catalogue', function(){

    //Le mode de tri : 0 => par défaut; 1 => croissant; 2 => décroissant
    $sortMode = 0;

    if(isset($_GET['sort'])){
        switch ($_GET['sort']){
            case "1":
                $sortMode = 1;
                break;
            case "2":
                $sortMode = 2;
                break;
            default:
                $sortMode = 0;
        }
    }

    $controlCatalogue = new controleur\ControleurCatalogue($sortMode);
    echo $controlCatalogue->getAllPrestations();
});

//Cas où on veut afficher seulement une prestation
$app->get('/catalogue/:id', function($id){
    $controlCatalogue = new controleur\ControleurCatalogue();
    echo $controlCatalogue->getPrestationById($id);
});

//Cas où on veut afficher une liste de prestation en fonction d'une categorie
$app->get('/catalogue/cat/:id', function($id){

    //Le mode de tri : 0 => par défaut; 1 => croissant; 2 => décroissant
    $sortMode = 0;

    if(isset($_GET['sort'])){
        switch ($_GET['sort']){
            case "1":
                $sortMode = 1;
                break;
            case "2":
                $sortMode = 2;
                break;
            default:
                $sortMode = 0;
        }
    }

    $controlCatalogue = new controleur\ControleurCatalogue($sortMode);
    echo $controlCatalogue->affPrestCat($id);
});

//URL pour voté une prestation
$app->post('/post/:id', function($id){

    $controlCatalogue = new controleur\ControleurCatalogue();
    $success = false;

    //Si l'utilisateur est en train de noter une prestation
    if(isset($_POST["note"])) {

        //On récupère l'état de la notation
        $success = $controlCatalogue->ajoutNote($id, $_POST["note"]);
        unset($_POST["note"]);
    }

    echo $controlCatalogue->affValidationNote($id, $success);
});

//On ajoute un article au panier
$app->get('/addBasket/:id', function($id) use ($app){

    $controlBaskel = new controleur\ControleurPanier();
    $controlBaskel->addBasket($id);

    echo "<script>window.close();</script>";

});

//On retire un article du panier
$app->get('/delBasket/:id', function($id) use ($app){

    $controlBaskel = new controleur\ControleurPanier();
    $controlBaskel->removeBasket($id);

    echo "<script>window.close();</script>";

});

//On affiche le panier
$app->get('/panier', function(){
    $controlBaskel = new controleur\ControleurPanier();
    echo $controlBaskel->renderBasket();
});

//Lancement du micro-framework
$app->run();

