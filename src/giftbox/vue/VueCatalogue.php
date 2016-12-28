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

        $htmlCatDropdown = "";
        foreach ($this->pbc[1] as $categorie){
            $htmlCatDropdown = $htmlCatDropdown . "<div class=\"item\" data-value=\"$categorie->id\" onclick=\"location.href='/catalogue/cat/$categorie->id'\">$categorie->nom</div>";
        }

        $html = "<div class=\"tri ui floating dropdown labeled icon button\" style=\"margin-bottom: 10px\">
                  <i class=\"filter icon\"></i>
                  <span class=\"text\">Trier</span>
                  <div class=\"menu\">
                      <div class=\"header\">
                        <i class=\"euro icon\"></i>
                        Prix
                      </div>
                      <div class=\"divider\"></div>
                      <div class=\"item\" onclick=\"location.href='?sort=1';\" data-value='croissant'>
                        <i class=\"sort numeric ascending icon\"></i>
                        Croissant
                      </div>
                      <div class=\"item\" onclick=\"location.href='?sort=2';\" data-value='decroissant'>
                        <i class=\"sort numeric descending icon\"></i>
                        Décroissant
                      </div>
                  </div>
                </div>
                <div class=\"categorie ui selection dropdown\">
                  <input name=\"gender\" type=\"hidden\">
                  <i class=\"dropdown icon\"></i>
                  <div class=\"default text\">Catégorie</div>
                  <div class=\"menu\">"
                    . $htmlCatDropdown .
                 "</div>
                </div>";

        $html = $html . "<div class=\"ui link cards\">";

        foreach ($this->pbc[0] as $prestation){

            $html = $html . "<div class=\"card\">
                                <div class=\"image\">
                                    <a class=\"image\" href=\"/catalogue/$prestation->id\"><img class=\"ui medium image\" src=\"/assets/img/$prestation->img\" /></a>
                                </div>
                                <div class=\"content\">
                                    <div class=\"header\" onclick=\"location.href='/catalogue/$prestation->id'\">$prestation->nom</div>
                                    <div class=\"meta\">
                                        <a href=\"/catalogue/cat/" . $prestation->categorie->id . "\">" . $prestation->categorie->nom . "</a>
                                    </div>
                                    <div class=\"extra content\">
                                        <span>
                                            $prestation->prix €
                                        </span>
                                        <br>
                                        <div class=\"ui star rating\" data-rating=\"" . $prestation->moyenne() . "\" data-max-rating=\"5\"></div><br /><br />
                                        <button class=\"positive ui button\" onclick=\"window.open('/addBasket/" . $prestation->id . "', '_blank');sleep(500);window.location.reload();\">Ajouter au panier</button>
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
        $html = $html . "<img src=\"/assets/img/" . $this->pbc->img . "\" border=\"0\" /><br />
                         <button class=\"positive ui button\" onclick=\"window.open('/addBasket/" . $this->pbc->id . "', '_blank');sleep(500);window.location.reload();\">Ajouter au panier</button></div><br /><br />";
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

        $htmlCatDropdown = "";
        foreach ($this->pbc[1] as $categorie){
            $htmlCatDropdown = $htmlCatDropdown . "<div class=\"item\" data-value=\"$categorie->id\" onclick=\"location.href='/catalogue/cat/$categorie->id'\">$categorie->nom</div>";
        }

        $html = "<div class=\"tri ui floating dropdown labeled icon button\" style=\"margin-bottom: 10px\">
                  <i class=\"filter icon\"></i>
                  <span class=\"text\">Trier</span>
                  <div class=\"menu\">
                      <div class=\"header\">
                        <i class=\"euro icon\"></i>
                        Prix
                      </div>
                      <div class=\"divider\"></div>
                      <div class=\"item\" onclick=\"location.href='?sort=1';\" data-value='croissant'>
                        <i class=\"sort numeric ascending icon\"></i>
                        Croissant
                      </div>
                      <div class=\"item\" onclick=\"location.href='?sort=2';\" data-value='decroissant'>
                        <i class=\"sort numeric descending icon\"></i>
                        Décroissant
                      </div>
                  </div>
                </div>
                <div class=\"categorie ui selection dropdown\">
                  <input name=\"gender\" type=\"hidden\">
                  <i class=\"dropdown icon\"></i>
                  <div class=\"default text\">Catégorie</div>
                  <div class=\"menu\">"
                    . $htmlCatDropdown .
                 "</div>
                </div>";

        $html = $html . "<div class=\"ui link cards\">";

        foreach ($this->pbc[0] as $prestation){

            $html = $html . "<div class=\"card\">
                                <div class=\"image\">
                                    <a class=\"image\" href=\"/catalogue/$prestation->id\"><img class=\"ui medium image\" src=\"/assets/img/$prestation->img\" /></a>
                                </div>
                                <div class=\"content\">
                                    <div class=\"header\" onclick=\"location.href='/catalogue/$prestation->id'\">$prestation->nom</div>
                                    <div class=\"meta\">
                                        <a>" . $prestation->categorie->nom . "</a>
                                    </div>
                                    <div class=\"extra content\">
                                        <span>
                                            $prestation->prix €
                                        </span>
                                        <br>
                                        <div class=\"ui star rating\" data-rating=\"" . $prestation->moyenne() . "\" data-max-rating=\"5\"></div><br /><br />
                                        <button class=\"positive ui button\" onclick=\"window.open('/addBasket/" . $prestation->id . "', '_blank');sleep(500);window.location.reload();\">Ajouter au panier</button>
                                    </div>
                                </div>
                            </div>";
        }

        $html = $html . "</div>
                         <script>$('.ui.rating').rating('disable');</script>";

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
            default :
                $content = "";
        }

        $html = Header::getHeader("Catalogue | Giftbox") . $content . Footer::getFooter();


        return $html;
    }
}