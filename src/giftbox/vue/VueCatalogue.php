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

        $html = "<ul>";

        foreach ($this->pbc as $prestation){

            $html = $html . "<li>$prestation->nom : $prestation->prix, " .  $prestation->categorie->nom;
            $html = $html . "<img src=\"/assets/img/$prestation->img\" border=\"0\" /> </li>";
        }

        $html = $html . "</ul>";

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

        $html = <<<END
        <!DOCTYPE html>
        <html>
            <head>
                <title>TITRE</title>
            </head>
            <body>
                <div class="content">
                    $content
                </div>
            </body>
        <html>
END;

        return $html;
    }
}