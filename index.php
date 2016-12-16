<?php
require_once ("vendor/autoload.php");



use Illuminate\Database\Capsule\Manager as DB;
use giftbox\models as models;
use giftbox\controleur as controleur;
use giftbox\vue as vue;


$app = new \Slim\Slim;

//$controle = new controleur\controleur1();
//$controle-> afficherPrestation();



$app->get('/', function(){

    echo "bonjour ça va bien ?";
});


$app->get('/Prestation', function(){


    if(isset($_GET['id'])){
        $controle = new controleur\controleur1();
        $controle -> affPrestId($_GET['id']);
    }else{
        $controle = new controleur\controleur1();
        $controle -> afficherPrestation();
    }
});






$app->run();

