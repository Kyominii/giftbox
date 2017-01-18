<?php

namespace giftbox\vue;


class VueCadeau
{
    private $pbc;

    function __construct($fromController)
    {
        $this->pbc = $fromController;
    }

    function htmlShowGift(){

        $html = "<h1>Ce coffret vous a été offert par <span style='color: gray'>" . $this->pbc['coffret']->client->prenom . " " . $this->pbc['coffret']->client->nom . "</span></h1>";

        if(isset($this->pbc['contributions'])) {

            $html .= "<h2>Aidé par ";

            $nContrib = count($this->pbc['contributions']);
            $i = 0;
            foreach ($this->pbc['contributions'] as $contribution) {

                if (++$i === $nContrib) {

                    $html .= $contribution->prenom . " " . $contribution->nom;
                } else {

                    $html .= $contribution->prenom . " " . $contribution->nom . ", ";
                }
            }

            $html .= "</h2>";
        }
            if(isset($this->pbc['finish'])) {
                $html .= "<div class=\"ui link cards\" style='margin-left: auto; margin-right: auto'>";
            } else {
                $html .= "<div class=\"ui link cards\" style='margin-left: auto; margin-right: auto; display: none'>";
            }


            foreach ($this->pbc['prestation'] as $prestation){

                $html .= "<div class=\"ui centered card\">
                                <div class=\"image\">
                                    <a class=\"image\" href=\"/catalogue/" . $prestation[0]->id . "\"><img class=\"ui medium image\" src=\"/assets/img/" . $prestation[0]->img . "\" /></a>
                                </div>
                                <div class=\"content\">
                                    <div class=\"header\" onclick=\"location.href='/catalogue/" . $prestation[0]->id . "'\">" . $prestation[0]->nom . "</div>
                                    <div class=\"meta\">
                                        <a href=\"/catalogue/cat/" . $prestation[0]->categorie->id . "\">" . $prestation[0]->categorie->nom . "</a>
                                    </div>
                                    <div class=\"extra content\">
                                        <span>
                                            Nombre d'article offert: $prestation[1]
                                        </span>
                                        <br>
                                        <div class=\"ui star rating\" data-rating=\"" . $prestation[0]->moyenne() . "\" data-max-rating=\"5\"></div>
                                    </div>
                                </div>
                            </div>";
            }

            if(!isset($this->pbc['finish'])) {
                $html .= "</div>
    
                          <div style='text-align: center'>
                            <button id='showAndNext' class=\"positive ui button\" style='margin-top: 20px'>Dévoiler l'article</button>
                          </div>
                          
                          <script>$('.ui.rating').rating('disable');
                          
                          $(document).ready(function(){
                              
                              var clicked = false;
                              
                              $('#showAndNext').click(function(){
                                  
                                  if(!clicked){
                                      $('.ui.link.cards').transition('horizontal flip');
                                      document.getElementById('showAndNext').textContent = 'Suivant';
                                      clicked = true;
                                  } else {
                                      location.reload();
                                  }
                                  
                              });
                           
                          });
                          
                          </script>";
            } else {
                $html .= "</div><h2>L'auteur vous a laisser un message :</h2><p>" .
                        $this->pbc['coffret']->message
                       . "</p><div class=\"ui modal\">
                              <i class=\"close icon\"></i>
                              <div class=\"header\">
                                Renseignez vos informations
                              </div>
                              <div class=\"content\">
                                <div class=\"description\">
                                  <div class=\"ui header\">Vous devez renseignez votre adresse mail pour vous envoyer le résumé de votre coffret.</div>
                                  <form class=\"ui form\" method='post' action='/cadeau/" . $this->pbc['url'] . "/retirer'>
                                    <div class=\"field\">
                                        <label>Adresse e-mail :</label>
                                        <input type=\"text\" name=\"email\" placeholder=\"derp@9gag.lol\" /><br />
                                    </div>
                                  </form>
                                </div>
                              </div>
                              <div class=\"actions\">
                                <div class=\"ui black deny button\">
                                  Annuler
                                </div>
                                <div id=\"confirmMail\" class=\"ui positive right labeled icon button\">
                                  Confirmer
                                  <i class=\"checkmark icon\"></i>
                                </div>
                              </div>
                          </div>
    
                          <div style='text-align: center'>
                            <button id='showAndNext' class=\"positive ui button\" style='margin-top: 20px'>Retirer le coffret</button>
                          </div>
                          
                          <script>$('.ui.rating').rating('disable');
                          
                          $(document).ready(function(){
                         
                             $('#showAndNext').click(function(){
                                  
                                  $('.ui.modal').modal('show');
                                  
                              });
                             
                              $('#confirmMail').click(function(){
                                  
                                  $('.ui.form').form('submit');
                                  
                              });
                             
                          });
                          
                          </script>";

        }

        return $html;
    }

    public function render($selecteur){

        switch($selecteur) {
            case "SHOW_GIFT" :
                $content = $this->htmlShowGift();
                break;
            default :
                $content = "";
        }

        $html = Header::getHeader("Cadeau | Giftbox") . $content . Footer::getFooter();

        return $html;
    }
}