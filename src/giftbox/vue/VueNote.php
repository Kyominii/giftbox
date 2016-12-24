<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 23/12/2016
 * Time: 16:24
 */

namespace giftbox\vue;

class VueNote
{

    //pbc pour Provided By Controller => Fournit par le controlleur
    private $pbc;

    function __construct($fromController)
    {
        $this->pbc = $fromController;
    }

    private function htmlSuccess(){

        $html = "<div>";
        $html = $html . "<h2> merci pour votre note </h2>";
        $html = $html . "<a class=\"ui huge button\" href=\"/catalogue/".$this->pbc."\">Retour<i class=\"right arrow icon\"></i></a>";
        $html = $html . "</div>";
        $html = Header::getHeader("Catalogue | Giftbox") . $html . Footer::getFooter();

        return $html;
    }

    private function htmlFailed(){

        $html = "<div>";
        $html = $html . "<h2>Une erreur s'est produite (peut déjà voté cette prestation ?)</h2>";
        $html = $html . "<a class=\"ui huge button\" href=\"/catalogue/".$this->pbc."\">Retour<i class=\"right arrow icon\"></i></a>";
        $html = $html . "</div>";
        $html = Header::getHeader("Catalogue | Giftbox") . $html . Footer::getFooter();

        return $html;
    }

    public function render($success)
    {

        $html = "";

        switch($success){
            case true:
                $html = $this->htmlSuccess();
                break;
            case false:
                $html = $this->htmlFailed();
                break;
        }

        return $html;
    }
}