<?php

namespace giftbox\vue;


class VueGestionnaire
{
    private $pbc;

    public function __construct($fromController){
        $this->pbc = $fromController;
    }

    public function render()
    {

        $html = Header::getHeader("Gestionnaire | Giftbox");

        $html = $html .
            "<form action =\"\">
                <div class=\"gest_group\">
                    <label for inputname>Nom</label>
                    <input type=\"text\" name=\"nom\" class=\"gest-control\" id=\"inputname\">
                    <label for inputdecr>Description</label>
                    <textarea name=\"description\" class=\"gest-control\" id=\"inputdescr\"></textarea>
                    <button type=\"submit\">Envoyer</button>
                </div>
            </form>";
        $html = $html . Footer::getFooter();

        return $html;
    }


}