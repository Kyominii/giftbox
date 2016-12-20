<?php

require_once ("vendor/autoload.php");
use giftbox\controleur as controleur;

//Création de l'objet du micro-framework
$app = new \Slim\Slim;

//Cas où nous sommes à la racine du site
$app->get('/', function(){

    echo "bonjour ça va bien ?";
});

//Cas où on veut afficher tout le catalogue
$app->get('/catalogue', function(){
    $controlCatalogue = new controleur\ControleurCatalogue();
    echo $controlCatalogue->getAllPrestations();
});

//Cas où on veut afficher seulement une prestation
$app->get('/catalogue/:id', function($id){
    $controlCatalogue = new controleur\ControleurCatalogue();
    echo $controlCatalogue->getPrestationById($id);
});

//Lancement du micro-framework
$app->run();

