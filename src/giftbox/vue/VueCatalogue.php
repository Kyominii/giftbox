<?php


namespace giftbox\vue;
use giftbox\vue as vue;


class VueCatalogue
{
    $tabPrestation;
    $tabCategorie;

    function __construct($tabPrestation, $tabCategorie)
    {
        $this->$tabPrestation = prestation;
        $this->$tabCategorie = categorie;

    }


    private function genererAffichage($tabPrestation){
        $afficher = '<section>'.'<br>';
        foreach ($this->$tabPrestation as $i){
            $afficher  = $afficher . '<p>'.$i.'</p>';
        }
            $afficher = '</section>';
            return $afficher;

    }


    private function render()
    {

        switch($this->selecteur) {

            case list_View :
                $content = $this->genererAffichage(prestation);
                break;
            case Presta_View :
                $content = $this->genererAffichage(prestation);
                break;

        }


            $html = <<<END
             <!DOCTYPE html>
              <html>
              <head> … </head>
              <body>
                   …
               <div class="content">
                  $content
              </div>
              </body><html>
 
 
END;

        return $html;


}


    private function genere_prestParticuliere()
    {
        $liste = \giftbox\models\Prestation::get();
        $v = new PrestaView($liste, List_View);
        $v->render();


    }




    public function choisirAffichage(){

        $html  = <<<END
                



END;




    }

















}