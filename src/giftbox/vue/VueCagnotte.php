<?php

namespace giftbox\vue;

class VueCagnotte
{

    private $pbc;

    function __construct($fromController)
    {
        $this->pbc = $fromController;
    }

    function htmlShowPool(){

        $html = "<h1>Cagnotte</h1>
                 <div class=\"ui middle aligned divided list\">";

        $totalPrix = 0;

        foreach($this->pbc['prestations'] as $prestation){

            $sousTotal = $prestation[0]->prix * $prestation[1];
            $totalPrix = $totalPrix + $sousTotal;

            $html = $html . "<div class=\"item\">
                                <div class=\"right floated content\">
                                  Sous-Total : " . $sousTotal . "€
                                </div>
                                <img class=\"ui avatar image\" src=\"/assets/img/" . $prestation[0]->img . "\">
                                <div class=\"content\">
                                  <a href=\"/catalogue/" . $prestation[0]->id . "\">$prestation[1] " . $prestation[0]->nom . " à " . $prestation[0]->prix . "€ l'unité</a>
                                </div>
                             </div>";
        }

        $html = $html . "</div>
                         <h2>Objectif de la cagnotte : $totalPrix €</h2><hr>";

        $html = $html . "<h2>Liste des contributeurs :</h2>";

        $totalContribution = 0;
        foreach($this->pbc['contributions'] as $contribution){
            $html = $html . $contribution->prenom . " " . $contribution->nom . " : " . $contribution->montant . "€<br />";
            $totalContribution = $totalContribution + $contribution->montant;
        }

        $html = $html . "<h2> Total récolté : " . $totalContribution . "€</h2><hr />
        <h2>Participer à la cagnotte :</h2>
        <form class=\"ui form\" method='post' action='/cagnotte/" . $this->pbc['slug'] . "/add '>
          <div class=\"field\">
            <label>Prénom</label>
            <input type=\"text\" name=\"prenom\" placeholder=\"Jean\">
          </div>
          <div class=\"field\">
            <label>Nom</label>
            <input type=\"text\" name=\"nom\" placeholder=\"Dujardin\">
          </div>
          <div class=\"two wide field\">
            <label>Montant</label>
            <input type=\"text\" name=\"montant\" placeholder=\"5\">
          </div>
          <button class=\"ui button\" type=\"submit\">Envoyer la contribution</button>
        </form>
        <hr />";

        if($this->pbc['isConnected']){

            $html = $html . "<h2>Finaliser la commande</h2>";
            if($totalContribution < $totalPrix){

                $html = $html . "<button class=\"ui negative basic button\" data-content=\"Pour continuer, vous devez avoir au moins atteint l'objectif de la cagnotte.\" data-variation=\"wide\" data-position=\"bottom center\">Continuer</button>
                             <script>$('.ui.button').popup();</script>";
            } else {

                $html = $html . "<a href='/cagnotte/" . $this->pbc['slug'] . "/confirm'><button id=\"submitButton\" class=\"ui positive basic button\">Continuer</button></a>";
            }
        } else {

            $html = $html . "<h2>Connexion à la gestion</h2>
            <form class=\"ui form\" method='post' action='/cagnotte/" . $this->pbc['slug'] . "/connect'>
              <div class=\"three wide field\">
                <label>Mot de passe de gestion</label>
                <input type=\"password\" name=\"pass\" placeholder=\"Mot de passe\">
              </div>
              <button class=\"ui button\" type=\"submit\">Se connecter</button>
            </form>";
        }




        return $html;
    }

    public function render($selecteur)
    {

        switch($selecteur) {
            case "SHOW_POOL" :
                $content = $this->htmlShowPool();
                break;
            default :
                $content = "";
        }

        $html = Header::getHeader("Cagnotte | Giftbox") . $content . Footer::getFooter();


        return $html;
    }

}