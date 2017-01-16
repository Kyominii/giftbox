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

        $html = "
            <!DOCTYPE html>
            <html>
                <head>
                    <title>$title</title>
                    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/semantic-ui/2.2.6/semantic.min.css\">
                </head>
                <script src=\"https://code.jquery.com/jquery-3.1.1.min.js\"></script>
                <script src=\"https://cdn.jsdelivr.net/semantic-ui/2.2.6/semantic.min.js\"></script>
                <script>
                    function sleep(milliseconds) {
                      var start = new Date().getTime();
                      for (var i = 0; i < 1e7; i++) {
                        if ((new Date().getTime() - start) > milliseconds){
                          break;
                        }
                      }
                    }
                </script>
                <body>
                
                <div class=\"ui inverted vertical center aligned segment\">
                    <div class=\"ui container\">
                      <div class=\"ui large secondary inverted pointing menu\">"
            . $menu .
            "<div class=\"right item\">";

        if($_SESSION['connecte'] != 1){

            $html = $html . "
                          <a class=\"ui inverted button\" href=\"/panier/charger\" style=\"margin-right: 7px\">Gérer un coffret</a>
                          <a class=\"ui inverted button\" href=\"/panier\" style=\"margin-right: 7px\">
                            <i class=\"icon gift\"></i>Panier
                            <div class=\"floating ui red circular label\">$nbPrestation</div>
                          </a>
                          <a class=\"ui inverted button\" href=\"/connexion\">Connexion</a>";
        } else {
            $html = $html . "
                          <a class=\"ui inverted button\" style=\"margin-right: 7px\">Gérer un coffret</a>
                          <a class=\"ui inverted button\" href=\"/panier\" style=\"margin-right: 7px\">
                            <i class=\"icon gift\"></i>Panier
                            <div class=\"floating ui red circular label\">$nbPrestation</div>
                          </a>
                          <a class=\"ui inverted button\" href=\"/deconnexion\" style=\"margin-right: 7px\">Déconnexion</a>
                          <a class=\"ui inverted button\" href=\"/gestion\">Gestion</a>";
        }

        $html = $html . "</div>
                      </div>
                    </div>
                </div>
  
                <div class=\"ui container\" style=\"width: 80%; padding-top: 30px\">";

        if(isset($_SESSION['message'])){
            $html = $html . "<div class=\"ui " . $_SESSION['message']['type'] . " message\">
                              <i class=\"close icon\"></i>
                              <div class=\"header\">
                                " . $_SESSION['message']['header'] . "
                              </div>
                              " . $_SESSION['message']['content'] . "
                            </div>
                            <script>
                            
                            $('.message .close')
                              .on('click', function() {
                                $(this)
                                  .closest('.message')
                                  .transition('fade')
                                ;
                              })
                            ;
                            </script>";

            unset($_SESSION['message']);
        }

        return $html;
    }
}