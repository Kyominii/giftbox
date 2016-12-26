<?php
/**
 * Created by PhpStorm.
 * User: Teddy
 * Date: 26/12/2016
 * Time: 18:00
 */

namespace giftbox\vue;


use giftbox\controleur\ControleurPanier;

class VuePanier
{

    private $pbc;

    public function __construct($fromController){
        $this->pbc = $fromController;
    }

    private function htmlEmptyBasket(){

        $html = "<h1>Aucun article n'a été ajouté au panier, veuillez séléctionner des articles pour continuer !</h1>
                 <a class=\"ui huge button\" href=\"/catalogue\">Retour<i class=\"right arrow icon\"></i></a>";

        return $html;
    }

    private function htmlFilledBasket(){

        $totalPrix = 0;

        $html = "<div class=\"ui middle aligned divided list\">";
        foreach ($this->pbc as $id => $data){

            $sousTotal = $data[0]->prix * $data[1];
            $totalPrix = $totalPrix + $sousTotal;

            $html = $html . "<div class=\"item\">
                                <div class=\"right floated content\">
                                  <div class=\"ui button\" onclick=\"window.open('/addBasket/" . $id . "', '_blank');sleep(500);window.location.reload();\">+1</div>
                                  <div class=\"ui button\" onclick=\"window.open('/delBasket/" . $id . "', '_blank');sleep(500);window.location.reload();\">Supprimer</div>
                                  Sous-Total : " . $sousTotal . "€
                                </div>
                                <img class=\"ui avatar image\" src=\"/assets/img/" . $data[0]->img . "\">
                                <div class=\"content\">
                                  <a href=\"/catalogue/$id\">$data[1] " . $data[0]->nom . " à " . $data[0]->prix . "€ l'unité</a>
                                </div>
                             </div>";
        }
        $html = $html . "</div>
                         <h2>Total à payer (TTC) : $totalPrix €</h2>";

        return $html;
    }

    public function render()
    {

        $html = Header::getHeader("Panier | Giftbox");

        //Si le panier est vide ou non
        if(count($this->pbc) != 0){
            $html = $html . $this->htmlFilledBasket();
        } else {
            $html = $html . $this->htmlEmptyBasket();
        }

        $html = $html . Footer::getFooter();

        return $html;
    }
}