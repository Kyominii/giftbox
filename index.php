<?php
session_start();
require_once ("vendor/autoload.php");
use giftbox\controleur as controleur;

if(!isset($_SESSION["connecte"])){
    $_SESSION["connecte"] = -1;
}

//Création de l'objet du micro-framework
$app = new \Slim\Slim;

//Cas où nous sommes à la racine du site
$app->get('/', function(){
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
$app->get('/catalogue/:id', function($id) use ($app){
    $controlCatalogue = new controleur\ControleurCatalogue();
    $result = $controlCatalogue->getPrestationById($id);

    if($result != false){
        echo $result;
    } else {
        $app->redirect('/catalogue');
    }
});

//Cas où on veut afficher une liste de prestation en fonction d'une categorie
$app->get('/catalogue/cat/:id', function($id) use ($app){

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
$app->get('/panier', function() use($app){
    $controlBaskel = new controleur\ControleurPanier();
    $res = $controlBaskel->renderBasket();

    if($res == "empty"){
        $app->redirect("/catalogue");
    } else {
        echo $res;
    }
});

$app->get('/panier/charger', function(){
    $controlBaskel = new controleur\ControleurPanier();
    echo $controlBaskel->askPassSlug();
});

$app->post('/panier/charger', function() use ($app){
    if(isset($_POST['slug']) && isset($_POST['motdepasse'])){
        $controlBaskel = new controleur\ControleurPanier();
        $res = $controlBaskel->loadBasket($_POST['slug'], $_POST['motdepasse']);
        if($res == "success"){
            $app->redirect('/panier');
        } else {
            echo $res;
        }
    }
});

$app->get('/panier/charger/:slug', function($slug){
    $controlBaskel = new controleur\ControleurPanier();
    echo $controlBaskel->askPassSlug($slug);
});

$app->post('/panier/charger/:slug', function($slug) use ($app){
    if(isset($_POST['motdepasse'])){
        $controlBaskel = new controleur\ControleurPanier();
        $res = $controlBaskel->loadBasket($slug, $_POST['motdepasse']);
        if($res == "success"){
            $app->redirect('/panier');
        } else {
            echo $res;
        }
    }
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
    if(isset($_SESSION['profil'])){
        unset($_SESSION['profil']);
    }
    $vueConnexion = new \giftbox\vue\VueConnexion("Deconnexion");
    echo $vueConnexion->render();
});

$app->post('/post/checkout/step1', function(){
    if(!isset($_SESSION['basketLoaded'])){
        if(isset($_POST['client_nom']) && isset($_POST['client_prenom']) && isset($_POST['client_numero_rue']) && isset($_POST['client_rue']) && isset($_POST['client_ville']) && isset($_POST['client_codePostal']) && isset($_POST['client_email']) && isset($_POST['client_pays']) && isset($_POST['coffret_msg']) && isset($_POST['coffret_moyen_paiement'])){
            if($_POST['client_nom'] != "" && $_POST['client_prenom'] != "" && $_POST['client_numero_rue'] != "" && $_POST['client_rue'] != "" && $_POST['client_ville'] != "" && $_POST['client_codePostal'] != "" && $_POST['client_email'] != "" && $_POST['client_pays'] != "" && $_POST['coffret_msg'] != "" && $_POST['coffret_moyen_paiement'] != ""){

                $controlBaskel = new controleur\ControleurPanier();
                echo $controlBaskel->renderSummaryBasket($_POST['client_nom'], $_POST['client_prenom'], $_POST['client_numero_rue'], $_POST['client_rue'], $_POST['client_ville'], $_POST['client_codePostal'], $_POST['client_email'], $_POST['client_pays'], $_POST['coffret_msg'], $_POST['coffret_moyen_paiement']);
            }
        }
    } else {
        $controlBaskel = new controleur\ControleurPanier();
        echo $controlBaskel->renderSummaryLoadedBasket();
    }

});

$app->post('/post/checkout/step2', function(){
    if(isset($_POST['nom_cli']) && isset($_POST['prenom_cli']) && isset($_POST['num_rue_cli']) && isset($_POST['nom_rue_cli']) && isset($_POST['ville_cli']) && isset($_POST['cp_cli']) && isset($_POST['email_cli']) && isset($_POST['pays_cli']) && isset($_POST['msg_coffret']) && isset($_POST['paiement_coffret']) && isset($_POST['sauvegarder_coffret']) && isset($_POST['mdp_coffret'])) {
        if ($_POST['nom_cli'] != "" && $_POST['prenom_cli'] != "" && $_POST['num_rue_cli'] != "" && $_POST['nom_rue_cli'] != "" && $_POST['ville_cli'] != "" && $_POST['cp_cli'] != "" && $_POST['email_cli'] != "" && $_POST['pays_cli'] != "" && $_POST['msg_coffret'] != "" && $_POST['paiement_coffret'] != "" && $_POST['sauvegarder_coffret'] != "") {

            $controlBaskel = new controleur\ControleurPanier();
            echo $controlBaskel->confirmBasket($_POST['nom_cli'], $_POST['prenom_cli'], $_POST['num_rue_cli'], $_POST['nom_rue_cli'], $_POST['ville_cli'], $_POST['cp_cli'], $_POST['email_cli'], $_POST['pays_cli'], $_POST['msg_coffret'], $_POST['paiement_coffret'], $_POST['sauvegarder_coffret'], $_POST['mdp_coffret']);
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
    try {
        controleur\Authenticate::checkAcessRights("admin");
        $vueGestion = new \giftbox\vue\VueGestion("gestion");
        echo $vueGestion->render();
    }catch(Exception $e){
        echo "Permission refusée";
    }

});


//On affiche la confirmation de l'ajout
$app->post('/gestion/ajout', function(){
    if($_SESSION['connecte'] == 1) {
        $controlGestion = new controleur\ControleurGestionnaire();
        $success = false;

        if (($_POST["nom"] != NULL) && ($_POST["description"] != NULL) && ($_POST["categorie"] != NULL) && ($_POST["image"] != NULL) && ($_POST["prix"] != NULL)) {
            $success = $controlGestion->ajoutPrestation($_POST["nom"], $_POST["description"], $_POST["categorie"], $_POST["image"], $_POST["prix"]);
        }

        if ($success == true) {
            $vueGestion = new \giftbox\vue\VueGestion("confirmation");
            echo $vueGestion->render();
        } else {
            $vueGestion = new \giftbox\vue\VueGestion("echec");
            echo $vueGestion->render();
        }
    }
});

//On affiche la confirmation de la suppression
$app->post('/gestion/suppression', function(){
    if($_SESSION['connecte'] == 1) {
        $controlGestion = new controleur\ControleurGestionnaire();
        $success = false;

        if ($_POST["id"] != NULL) {
            $success = $controlGestion->supressionPrestation($_POST["id"]);
        }

        if ($success == true) {
            $vueGestion = new \giftbox\vue\VueGestion("confirmation");
            echo $vueGestion->render();
        } else {
            $vueGestion = new \giftbox\vue\VueGestion("echec");
            echo $vueGestion->render();
        }
    }
});

//On affiche la confirmation de l'activation/désactivation d'une prestation
$app->post('/gestion/suspenssion', function(){
    if($_SESSION['connecte'] == 1) {
        $controlGestion = new controleur\ControleurGestionnaire();
        $success = false;

        if ((isset($_POST["id"]))) {
            $success = $controlGestion->suspenssionPrestation($_POST["id"]);
        }

        if ($success == true) {
            $vueGestion = new \giftbox\vue\VueGestion("confirmation");
            echo $vueGestion->render();
        } else {
            $vueGestion = new \giftbox\vue\VueGestion("echec");
            echo $vueGestion->render();
        }
    }
});

$app->get('/panier/delier', function() use ($app){
    unset($_SESSION['basketLoaded']);
    $_SESSION['message']['type'] = "positive";
    $_SESSION['message']['content'] = "Votre coffret a été déchargé de votre session avec succès !";
    $_SESSION['message']['header'] = "Succès !";
    $app->redirect('/panier');
});

$app->get('/cagnotte/:slug', function($slug) use ($app){
    $controller = new controleur\ControleurCagnotte();
    $result = $controller->showPool($slug);

    if($result != false){
        echo $result;
    } else {
        $app->redirect('/catalogue');
    }
});

$app->post('/cagnotte/:slug/add', function($slug) use ($app){
    if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['montant'])){
        if($_POST['nom'] != "" && $_POST['prenom'] != "" && $_POST['montant'] != "" && floatval($_POST['montant']) > 0) {
            $controller = new controleur\ControleurCagnotte();
            $result = $controller->addPool($slug, $_POST['nom'], $_POST['prenom'], floatval($_POST['montant']));

            if ($result != false) {
                $app->redirect('/cagnotte/' . $slug);
            } else {
                $app->redirect('/cagnotte/' . $slug);
            }
        } else {
            $_SESSION['message']['type'] = "negative";
            $_SESSION['message']['content'] = "Les informations ne sont pas valides !";
            $_SESSION['message']['header'] = "Erreur !";
            $app->redirect('/cagnotte/' . $slug);
        }
    } else {
        $_SESSION['message']['type'] = "negative";
        $_SESSION['message']['content'] = "Les informations ne sont pas valides !";
        $_SESSION['message']['header'] = "Erreur !";
        $app->redirect('/cagnotte/' . $slug);
    }

});

$app->post('/cagnotte/:slug/connect', function($slug) use ($app){
    if(isset($_POST['pass'])) {
        $controller = new controleur\ControleurCagnotte();
        $result = $controller->connectPool($slug, $_POST['pass']);

        if($result){
            $_SESSION['message']['type'] = "positive";
            $_SESSION['message']['content'] = "Vous êtes identifiés !";
            $_SESSION['message']['header'] = "Succès !";
            $app->redirect('/cagnotte/' . $slug);
        } else {
            $_SESSION['message']['type'] = "negative";
            $_SESSION['message']['content'] = "Le mot de passe n'est pas correspondant !";
            $_SESSION['message']['header'] = "Erreur !";
            $app->redirect('/cagnotte/' . $slug);
        }
    }
});

$app->get('/cagnotte/:slug/confirm', function($slug) use ($app){

    $controller = new controleur\ControleurCagnotte();
    $result = $controller->validPool($slug);

    if($result != false){
        echo $result;
    } else {

        $_SESSION['message']['type'] = "negative";
        $_SESSION['message']['content'] = "Veuillez vérifier que vous soyez connecté sur la cagnotte et que le total recolté soit supérieur à l'objectif de la cagnotte !";
        $_SESSION['message']['header'] = "Erreur !";
        $app->redirect('/cagnotte/' . $slug);
    }
});

$app->get('/cadeau/:url', function($url) use ($app){
   $controler = new controleur\ControleurCadeau();
   $result = $controler->showGift($url);

   if($result != false){
       echo $result;
   } else {
       $app->redirect('/catalogue');
   }
});

$app->post('/cadeau/:url/retirer', function($url) use ($app) {

    if(isset($_POST['email']) && $_POST['email'] != ""){
        $controler = new controleur\ControleurCadeau();
        $controler->deleteGift($url, $_POST['email']);
        $app->redirect('/catalogue');
    } else {
        $_SESSION['message']['type'] = "negative";
        $_SESSION['message']['content'] = "Vous devez renseignez un email !";
        $_SESSION['message']['header'] = "Erreur !";
        $app->redirect('/cadeau/' . $url);
    }

});

$app->get('/hash/:mdp', function($mdp){
    $hash=password_hash($mdp, PASSWORD_BCRYPT);
    echo password_verify(123,$hash)."<br>";;
    echo $hash;
});

//Lancement du micro-framework
$app->run();

