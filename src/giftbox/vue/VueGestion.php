<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 29/12/2016
 * Time: 13:35
 */

namespace giftbox\vue;

class VueGestion{

    private $selecteur;

    function __construct( $sel)
    {
        $this->selecteur = $sel;
    }

    public function htmlGestion()
    {
        $html = "
                    
                    <h2 class=\"ui dividing header\">Ajout de prestation</h2>
                        
                    <form class=\"ui form\" method=\"post\" action=\"/gestion/ajout\">
                        <p>
                            <br>
                            <label class=textform  for=\"nom\">Nom de la prestation</label>
                            <br>
                            <input type=\"text\" name=\"nom\" id=\"nom\" />
                            <br><br>
                            <label class=textform for=\"description\">Description</label>
                            <br>
                            <input type=\"text\" name=\"description\" id=\"description\" />
                            <br><br>
                            <label class=textform for=\"categorie\">Catégorie (WIP)</label>
                            <br>
                            <input type=\"text\" name=\"categorie\" id=\"categorie\" />
                            <br><br>
                            <label class=\"textform\" for=\"image\">Image (WIP)</label>
                            <br>
                            <input type=\"text\" name=\"image\" id=\"image\" />
                            <br><br>
                            <label class=\"textform\" for=\"prix\">Prix</label>
                            <br>
                            <input type=\"text\" name=\"prix\" id=\"prix\" />
                            <br><br>
                            <input class=\"ui large button\" type=\"submit\" name=\"Valider\" value=\"Valider\">
                            <br><br>                            
                        </p>
                    </form>

                    <h2 class=\"ui dividing header\">Suppression de prestation</h2>
                    
                    <form class=\"ui form\" method=\"post\" action=\"/gestion/suppression\">
                        <p>
                            <br>
                            <label class=\"textform\"  for=\"id\">Prestation à supprimer (WIP)</label>
                            <br>
                            <input type=\"text\" name=\"id\" id=\"id\" />
                            <br><br>
                            <input class=\"ui large button\" type=\"submit\" name=\"Supprimer\" value=\"Supprimer\">
                            <br><br>
                        </p>
                    </form>

                    <h2 class=\"ui dividing header\">Désactivation/Activation de prestation</h2>  
                                          
                    <form class=\"ui form\" method=\"post\" action=\"/gestion/suspenssion\">
                        <p>
                            <br>
                            <label class=textform  for=\"id\">Prestation à suspendre (WIP)</label>
                            <br>
                            <input type=\"text\" name=\"id\" id=\"id\" />
                            <br><br>
                            <input class=\"ui large button\" type=\"submit\" name=\"Valider\" value=\"Valider\">
                        </p>
                    </form>";
        return $html;
    }

    public function htmlConfirmation()
    {
        $html = "<h2>Votre commandde c'est bien effectué</h2>
                 <a class=\"ui huge button\" href=\"/gestion\">Retour<i class=\"right arrow icon\"></i></a>";
        return $html;
    }

    public function htmlEchec()
    {
        $html = "<h2>Erreur votre commande ne c'est pas effectué correctement</h2>
                 <a class=\"ui huge button\" href=\"/gestion\">Retour<i class=\"right arrow icon\"></i></a>";
        return $html;
    }

    function render(){
        switch ($this->selecteur){
            case "gestion" :
                $html = Header::getHeader("Gestion | Giftbox");
                $html = $html . $this->htmlGestion();
                break;
            case "confirmation" :
                $html = Header::getHeader("Gestion (réussie) | Giftbox");
                $html = $html . $this->htmlConfirmation();
                break;
            case "echec" :
                $html = Header::getHeader("Gestion (échouée) | Giftbox");
                $html = $html . $this->htmlEchec();
                break;
        }

        $html = $html . Footer::getFooter();

        return $html;
    }


}
