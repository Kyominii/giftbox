<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 27/12/2016
 * Time: 13:29
 */

namespace giftbox\vue;

class VueConnexion
{

    private $selecteur;

    function __construct( $sel)
    {
        $this->selecteur = $sel;
    }

    public function htmlConnexion(){
        $html = "<form class=\"ui form\" method=\"post\" action=\"/connexion/confirmation\">
                        <p>
                            <label class=\"textform\"  for=\"pseudo\">Pseudonyme</label>
                            <br>
                            <input type=\"text\" name=\"pseudo\" id=\"pseudo\" />
                            <br><br>
                            <label class=textform for=\"pass\">Mot de passe</label>
                            <br>
                            <input type=\"text\" name=\"pass\" id=\"pass\" />
                            <br><br>
                            <input class=\"ui large button\" type=\"submit\" name=\"connexion\" value=\"connexion\">
                        </p>
                    </form>";
        return $html;
    }

    public function htmlConnexionF(){
        $html = "<h2>Une erreur s'est produite (mauvais pseudo ou mauvais mot de passe) !</h2>
                 <a class=\"ui huge button\" href=\"/connexion\">Retour<i class=\"right arrow icon\"></i></a>";

        return $html;
    }

    public function htmlConnexionT(){
        $html = "<h2>Connexion réussie !</h2>
                 <a class=\"ui huge button\" href=\"/\">Accueil<i class=\"right arrow icon\"></i></a>";

        return $html;
    }

    public function htmlDeconnexion(){

        $html = "<h2>Déconnexion réussie !</h2>
                 <a class=\"ui huge button\" href=\"/\">Accueil<i class=\"right arrow icon\"></i></a>";


        return $html;
    }


    public function render()
    {
        switch ($this->selecteur) {
            case "Connexion" :
                $html = Header::getHeader("Connexion | Giftbox");
                $html = $html . $this->htmlConnexion();
                break;
            case "ConnexionF" :
                $html = Header::getHeader("Connexion échouée | Giftbox");
                $html = $html . $this->htmlConnexionF();
                break;
            case "ConnexionT" :
                $html = Header::getHeader("Connexion réussie | Giftbox");
                $html = $html . $this->htmlConnexionT();
                break;
            case "Deconnexion":
                $html = Header::getHeader("Deconnexion | Giftbox");
                $html = $html . $this->htmlDeconnexion();
                break;
        }

        $html = $html . Footer::getFooter();
        return $html;


    }
}