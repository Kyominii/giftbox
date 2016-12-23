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

        $html = "<div class=\"ui floating dropdown labeled icon button\" style=\"margin-bottom: 10px\">
                  <i class=\"filter icon\"></i>
                  <span class=\"text\">Trier</span>
                  <div class=\"menu\">
                      <div class=\"header\">
                        <i class=\"euro icon\"></i>
                        Prix
                      </div>
                      <div class=\"divider\"></div>
                      <div class=\"item\" onclick=\"location.href='/catalogue?sort=1';\" data-value='croissant'>
                        <i class=\"sort numeric ascending icon\"></i>
                        Croissant
                      </div>
                      <div class=\"item\" onclick=\"location.href='/catalogue?sort=2';\" data-value='decroissant'>
                        <i class=\"sort numeric descending icon\"></i>
                        Décroissant
                      </div>
                  </div>
                </div>";

        $html = $html . "<div class=\"ui link cards\">";

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
                                    <div class=\"extra content\">
                                        <span>
                                            $prestation->prix €
                                        </span>
                                        <br>
                                        <div class=\"ui rating\" data-rating=\"" . $prestation->moyenne() . "\" data-max-rating=\"5\"></div>
                                    </div>
                                </div>
                            </div>";
        }

        $html = $html . "</div>";

        return $html;
    }

    private function htmlPrestationById(){


        $html = "<div>";
        $html = $html . "<p>" . $this->pbc->nom . " : " . $this->pbc->prix . "€, " . $this->pbc->categorie->nom . ", " . $this->pbc->descr . ".</p>";
        $html = $html . "<img src=\"/assets/img/" . $this->pbc->img . "\" border=\"0\" />";
        $html = $html . "<h2>Noter Moi !</h2>";
        $html = $html . "<form method=\"post\" action=\"/post/".$this->pbc->id."\"> <input type=\"number\" min=\"0\" max=\"5\" name=\"note\" /> ";
        $html = $html . "<input type=\"submit\" value=\"Envoyer\" /> </form>";
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