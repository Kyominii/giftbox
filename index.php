<?php
session_start();
require_once ("vendor/autoload.php");
use giftbox\controleur as controleur;

//Création de l'objet du micro-framework
$app = new \Slim\Slim;

//Cas où nous sommes à la racine du site
$app->get('/', function(){
    if(!isset($_SESSION["connecte"])){
        $_SESSION["connecte"] = -1;
    }
    $controlCatalogue = new controleur\ControleurCatalogue();
    $listePrest = $controlCatalogue->getBestPrestation();
    $vueAccueil = new \giftbox\vue\VueAccueil($_SESSION["connecte"]);
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

//Connexion
$app->get('/connexion', function(){
    $vueConnexion = new \giftbox\vue\VueConnexion("Connexion");
    echo $vueConnexion->render();
});

//URL pour connexion validé
$app->post('/connexion/confirmation', function(){

    $controlGestion = new controleur\ControleurGestionnaire();
    $success = false;

    //Si l'utilisateur est en train de se connecter
    if(isset($_POST["pseudo"])) {

        //On récupère l'état de la connexion
        $success = $controlGestion->connexion($_POST["pseudo"],$_POST["pass"]);
    }

    echo $controlGestion->affValidationConnextion($success);
});

//affiche la confirmation de la déconnexion
$app->get('/deconnexion', function() {
    $_SESSION["connecte"] = -1;
    $vueConnexion = new \giftbox\vue\VueConnexion("Deconnexion");
    echo $vueConnexion->render();
});

$app->post('/post/checkout/step1', function(){
    if(isset($_POST['client_nom']) && isset($_POST['client_prenom']) && isset($_POST['client_numero_rue']) && isset($_POST['client_rue']) && isset($_POST['client_ville']) && isset($_POST['client_codePostal']) && isset($_POST['client_email']) && isset($_POST['client_pays']) && isset($_POST['coffret_msg']) && isset($_POST['coffret_moyen_paiement'])){
        if($_POST['client_nom'] != "" && $_POST['client_prenom'] != "" && $_POST['client_numero_rue'] != "" && $_POST['client_rue'] != "" && $_POST['client_ville'] != "" && $_POST['client_codePostal'] != "" && $_POST['client_email'] != "" && $_POST['client_pays'] != "" && $_POST['coffret_msg'] != "" && $_POST['coffret_moyen_paiement'] != ""){

            $controlBaskel = new controleur\ControleurPanier();
            echo $controlBaskel->renderSummaryBasket($_POST['client_nom'], $_POST['client_prenom'], $_POST['client_numero_rue'], $_POST['client_rue'], $_POST['client_ville'], $_POST['client_codePostal'], $_POST['client_email'], $_POST['client_pays'], $_POST['coffret_msg'], $_POST['coffret_moyen_paiement']);
        }
    }
});

$app->post('/post/checkout/step2', function(){
    if(isset($_POST['nom_cli']) && isset($_POST['prenom_cli']) && isset($_POST['num_rue_cli']) && isset($_POST['nom_rue_cli']) && isset($_POST['ville_cli']) && isset($_POST['cp_cli']) && isset($_POST['email_cli']) && isset($_POST['pays_cli']) && isset($_POST['msg_coffret']) && isset($_POST['paiement_coffret'])){
        if($_POST['nom_cli'] != "" && $_POST['prenom_cli'] != "" && $_POST['num_rue_cli'] != "" && $_POST['nom_rue_cli'] != "" && $_POST['ville_cli'] != "" && $_POST['cp_cli'] != "" && $_POST['email_cli'] != "" && $_POST['pays_cli'] != "" && $_POST['msg_coffret'] != "" && $_POST['paiement_coffret'] != ""){

            $controlBaskel = new controleur\ControleurPanier();
            echo $controlBaskel->confirmBasket($_POST['nom_cli'], $_POST['prenom_cli'], $_POST['num_rue_cli'], $_POST['nom_rue_cli'], $_POST['ville_cli'], $_POST['cp_cli'], $_POST['email_cli'], $_POST['pays_cli'], $_POST['msg_coffret'], $_POST['paiement_coffret']);
        }
    }
});

$app->post('/post/checkout/step3', function(){
    if(isset($_SESSION['purchaseInProgress'])){
        if($_SESSION['purchaseInProgress'] != ""){
            $controlBaskel = new controleur\ControleurPanier();
            echo $controlBaskel->paymentDone();
        }
    }
});

$app->get('/coffret/:slug', function($slug){
    $controler = new controleur\ControleurCoffret();
    echo $controler->displayGift($slug);

});

//On affiche le menu de gestion
$app->get('/gestion', function(){
    $vueGestion = new \giftbox\vue\VueGestion("gestion");
    echo $vueGestion->render();
});


//On affiche la confirmation de l'ajout
$app->post('/gestion/ajout', function(){
    $controlGestion = new controleur\ControleurGestionnaire();
    $success = false;

    if(($_POST["nom"] != NULL)&&($_POST["description"] != NULL)&&($_POST["categorie"]!= NULL)&&($_POST["image"] != NULL)&&($_POST["prix"] != NULL)){
        $success = $controlGestion->ajoutPrestation($_POST["nom"],$_POST["description"],$_POST["categorie"],$_POST["image"],$_POST["prix"]);
    }

    if($success == true) {
        $vueGestion = new \giftbox\vue\VueGestion("confirmation");
        echo $vueGestion->render();
    }else{
        $vueGestion = new \giftbox\vue\VueGestion("echec");
        echo $vueGestion->render();
    }
});

//On affiche la confirmation de la suppression
$app->post('/gestion/suppression', function(){
    $controlGestion = new controleur\ControleurGestionnaire();
    $success = false;

    if($_POST["id"]!=NULL){
        $success = $controlGestion->supressionPrestation($_POST["id"]);
    }

    if($success == true) {
        $vueGestion = new \giftbox\vue\VueGestion("confirmation");
        echo $vueGestion->render();
    }else{
        $vueGestion = new \giftbox\vue\VueGestion("echec");
        echo $vueGestion->render();
    }
});

//On affiche la confirmation de l'activation/désactivation d'une prestation
$app->post('/gestion/suspenssion', function(){
    $controlGestion = new controleur\ControleurGestionnaire();
    $success = false;

    if((isset($_POST["id"]))){
        $success = $controlGestion->suspenssionPrestation($_POST["id"]);
    }

    if($success == true) {
        $vueGestion = new \giftbox\vue\VueGestion("confirmation");
        echo $vueGestion->render();
    }else{
        $vueGestion = new \giftbox\vue\VueGestion("echec");
        echo $vueGestion->render();
    }
});

//Lancement du micro-framework
$app->run();

