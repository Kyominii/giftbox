<?php

namespace giftbox\controleur;

class ControleurPanier
{

    public function __construct(){
        //TO-DO
    }

    public function addBasket($id){
        if(!isset($_SESSION['basket'])){
            $_SESSION['basket'] = array($id => 1);
        } else {
            if(array_key_exists($id, $_SESSION['basket'])){
                $_SESSION['basket'][$id] = $_SESSION['basket'][$id] + 1;
            } else {
                $_SESSION['basket'][$id] = 1;
            }
        }
    }

}