<?php

namespace giftbox\controleur;

use Illuminate\Database\Capsule\Manager as DB;
use giftbox\models as models;	

class controleur1 {
	
private $db;
	
function __Construct(){
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
}	

	function afficherPrestation(){
		$q1 = models\Prestation::get();
		foreach ($q1 as $prestation){
			echo "$prestation->nom : $prestation->prix , $prestation->cat_id , $prestation->img ";
			echo "<img src=\"assets/img/$prestation->img\" border=\"0\" /></div> <br>";
		}
	}

	function affPrestId($id){
	    $prestation = models\Prestation::select('id','nom','descr','cat_id','img','prix')
                            ->where('id','=',$id)
                            ->first();
        echo "$prestation->nom : $prestation->prix , $prestation->cat_id , $prestation->img ";
        echo "<img src=\"assets/img/$prestation->img\" border=\"0\" /></div> <br>";
    }

    function affPrestCat(){

        $cat = models\Prestation::select('id','nom','descr','cat_id','img','prix')
                                ->where("")
                                ->get

    }




}