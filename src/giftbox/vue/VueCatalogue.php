<?php

namespace giftbox\vue;

class VueCatalogue
{

    //pbc pour Provided By Controller => Fournit par le controlleur
    private $pbc;
    private $selecteur;

    function __construct($fromController, $sel)
    {

        $this->pbc = $fromController;
        $this->selecteur = $sel;
    }

    private function htmlAllPrestation(){

        $html = "<div class=\"ui link cards\">";

        foreach ($this->pbc as $prestation){

            $html = $html . "<div class=\"card\">
                                <div class=\"image\">
                                    <a class=\"image\" href=\"/catalogue/$prestation->id\"><img class=\"ui medium image\" src=\"/assets/img/$prestation->img\" /></a>
                                </div>
                                <div class=\"content\">
                                    <div class=\"header\">$prestation->nom</div>
                                    <div class=\"meta\">
                                        <a>" . $prestation->categorie->nom . "</a>
                                    </div>
                                    <div class=\"description\">
                                        $prestation->descr
                                    </div>
                                    <div class=\"extra content\">
                                        <span>
                                            $prestation->prix €
                                        </span>
                                    </div>
                                </div>
                            </div>";
        }

        $html = $html . "</div>";

        return $html;
    }

    private function htmlPrestationById(){

        $html = "<div>";
        $html = $html . "<p>" . $this->pbc->nom . " : " . $this->pbc->prix . "€, " . $this->pbc->categorie->nom . ".</p>";
        $html = $html . "<img src=\"/assets/img/" . $this->pbc->img . "\" border=\"0\" />";
        $html = $html . "</div>";

        return $html;
    }

    public function render()
    {

        switch($this->selecteur) {
            case "ALL_PRESTATION" :
                $content = $this->htmlAllPrestation();
                break;
            case "PRESTATION_BY_ID" :
                $content = $this->htmlPrestationById();
                break;
        }

        $html = Header::getHeader("Catalogue | Giftbox") . $content . Footer::getFooter();


        return $html;
    }
}