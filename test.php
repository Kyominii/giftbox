<?php
require_once ("vendor/autoload.php");

use Illuminate\Database\Capsule\Manager as DB;
use giftbox\models as models;

$db = new DB();

$config=parse_ini_file('src/conf/db.ini');

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

$q1 = models\Prestation::select('id', 'descr')->get();
$q2 = models\Categorie::select('id','nom')->get();
foreach ($q1 as $prestation){
    echo "$prestation->id : $prestation->descr , $prestation->cat_id <br />";
}
foreach ($q2 as $categorie){
    echo "$categorie->id : $categorie->nom <br />";
}
if(isset($_GET['id'])){
    $q3 = models\Prestation::select('*')->where('id','=',$_GET['id'])->first();
    echo "$q3->id : $q3->descr";
}

//$p = new models\Prestation();
//$p->nom = 'test';
//$p->descr = 'tortle tust';
//$p->cat_id = 2;
//$p->img = 'tortole.png';
//$p->prix = 666.66;

//$p->save();