<?php

namespace giftbox\vue;

class Header
{
    public static function getHeader($title){

        $menu = "";
        if(strpos($title, "Catalogue") !== false){
            $menu = "<a class=\"item\" href=\"/\">Accueil</a>
                     <a class=\"item active\" href=\"/catalogue\">Catalogue</a>";
        } else {
            $menu = "<a class=\"item\" href=\"/\">Accueil</a>
                     <a class=\"item\" href=\"/catalogue\">Catalogue</a>";
        }

        $nbPrestation = \giftbox\controleur\ControleurPanier::getAmountInBasket();

        $html = <<<END
        <!DOCTYPE html>
        <html>
            <head>
                <title>$title</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/semantic-ui/2.2.6/semantic.min.css">
            </head>
            <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/semantic-ui/2.2.6/semantic.min.js"></script>
            <body>
                
                <div class="ui inverted vertical center aligned segment">
                    <div class="ui container">
                      <div class="ui large secondary inverted pointing menu">
                        $menu
                        <div class="right item">
                          <a class="ui inverted button" style="margin-right: 7px">Gérer un coffret</a>
                          <a class="ui inverted button">
                            <i class="icon gift"></i>Panier
                            <div class="floating ui red circular label">$nbPrestation</div>
                          </a>
                        </div>
                      </div>
                    </div>
                </div>
  
                <div class="ui container" style="width: 80%; padding-top: 30px">


END;

        return $html;
    }
}