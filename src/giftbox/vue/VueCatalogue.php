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
                                        <div class=\"ui star rating\" data-rating=\"" . $prestation->moyenne() . "\" data-max-rating=\"5\"></div>
                                    </div>
                                </div>
                            </div>";
        }

        $html = $html . "</div>
                         <script>$('.ui.rating').rating('disable');</script>";

        return $html;
    }

    private function htmlPrestationById(){


        $html = "<div>";
        $html = $html . "<p>" . $this->pbc->nom . " : " . $this->pbc->prix . "€, " . $this->pbc->categorie->nom . ", " . $this->pbc->descr . ".</p>";
        $html = $html . "<img src=\"/assets/img/" . $this->pbc->img . "\" border=\"0\" />";
        $html = $html . "<h2>Noter Moi !</h2>";
        $html = $html . "<div id=\"prestaNote\" class=\"ui star rating\" data-rating=\"" . $this->pbc->moyenne() . "\" data-max-rating=\"5\"></div>";
        $html = $html . "</div>
                         <script>
                         $('#prestaNote').rating({
                            onRate: function(value){
                                var form = $('<form></form>');
    
                                form.attr(\"method\", \"post\");
                                form.attr(\"action\", \"/post/" . $this->pbc->id . "\");
                            
                                var field = $('<input></input>');

                                field.attr(\"type\", \"hidden\");
                                field.attr(\"name\", \"note\");
                                field.attr(\"value\", value);

                                form.append(field);

                                $(document.body).append(form);
                                form.submit();
                            }
                        });
                         </script>";

        return $html;
    }

    private function htmlPrestationByCatID(){

        $html = "<div><ul>";

        foreach($this->pbc as $prestation){

            $html = $html . "<li>" . $this->pbc->nom . " : " . $this->pbc->prix . "€, " . $this->pbc->categorie->nom . ", " . $this->pbc->descr . "</li>";
        }

        $html = $html . "</ul></div>";
        return $html;

    }

    private function htmlAllCategorie(){

        $html = "<div><ul>";

        foreach($this->pbc as $categorie){

            $html = $html . "<li>" . $this->pbc->nom . "</li>";
        }

        $html = $html . "</ul></div>";
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
            case "PRESTATION_BY_CATEGORIE" :
                $content = $this->htmlPrestationByCatId();
                break;
            case "ALL_CATEGORIE" :
                $content = $this->htmlAllCategorie();
                break;
        }

        $html = Header::getHeader("Catalogue | Giftbox") . $content . Footer::getFooter();


        return $html;
    }
}