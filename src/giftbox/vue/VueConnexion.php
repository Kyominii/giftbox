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

    private $selecteur;

    function __construct( $sel)
    {
        $this->selecteur = $sel;
    }

    public function htmlConnexion(){
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
            .form{
                display:block;
                margin:auto;
                width:500px;
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
                    <form class=form method="post" action="/connexion/confirmation">
                        <p>
                            <label class=textform  for="pseudo">pseudo</label>
                            <br>
                            <input type="text" name="pseudo" id="pseudo" />
                            <br><br>
                            <label class=textform for="pass">mot de passe</label>
                            <br>
                            <input type="text" name="pass" id="pass" />
                            <br><br>
                            <input class="ui large button" type="submit" name="connexion" value="connexion">
                        </p>
                    </form>
                </div>
            </body>
        </html>



END;
        return $html;
    }

    public function htmlConnexionF(){
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
            .form{
                display:block;
                margin:auto;
                width:500px;
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
                   <h2>Une erreur s'est produite (mauvais pseudo ou mauvais mot de passe)</h2>
                   <a class="ui huge button" href=/connexion>Retour<i class="right arrow icon"></i></a>
                </div>
            </body>
        </html>



END;
        return $html;
    }

    public function htmlConnexionT(){
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
            .form{
                display:block;
                margin:auto;
                width:500px;
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
                   <h2>Connexion réussi</h2>
                   <a class="ui huge button" href="/">Accueil<i class="right arrow icon"></i></a>
                </div>
            </body>
        </html>



END;
        return $html;
    }

    public function htmlDeconnexion(){
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
            .form{
                display:block;
                margin:auto;
                width:500px;
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
                   <h2>Déconnexion réussie</h2>
                   <a class="ui huge button" href="/">Accueil<i class="right arrow icon"></i></a>
                </div>
            </body>
        </html>

END;
        return $html;
    }


    public function render()
    {
        switch ($this->selecteur) {
            case "Connexion" :
                $html = $this->htmlConnexion();
                break;
            case "ConnexionF" :
                $html = $this->htmlConnexionF();
                break;
            case "ConnexionT" :
                $html = $this->htmlConnexionT();
                break;
            case "Deconnexion":
                $html = $this->htmlDeconnexion();
                break;
        }
        return $html;


    }
}