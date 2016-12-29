<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 29/12/2016
 * Time: 13:35
 */

namespace giftbox\vue;

class VueGestion{

    private $selecteur;

    function __construct( $sel)
    {
        $this->selecteur = $sel;
    }

    public function htmlGestion()
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
            .form{
                display:block;
                margin:auto;
                width:150px;
                margin-top = 100px;
            }
            
            h2{
                text-align: center;
            }
            
            
            </style>
            
            
            <body>
                
                <div class="ui inverted vertical center aligned segment">
                    <div class="ui container">
                      <div class="ui large secondary inverted pointing menu">
                        <a class="item" href="/">Accueil</a>
                        <a class="item" href="/catalogue">Catalogue</a>
                        <div class="right item">
                          <a class="ui inverted button" href="/deconnexion">Déconnexion</a>
                        </div>
                      </div>
                    </div>
                </div>
  
                <div class="ui container" style="width: 80%; padding-top: 30px">
                    <div class="ui vertical stripe segment prest title">
                        <div class="ui text container">
                           <h2 class="ui header">Ajout de prestation</h2>
                        </div>
                    </div>
                    <form class=form method="post" action="/gestion/ajout">
                        <p>
                            <br>
                            <label class=textform  for="nom">nom prestation</label>
                            <br>
                            <input type="text" name="nom" id="nom" />
                            <br><br>
                            <label class=textform for="description">description</label>
                            <br>
                            <input type="text" name="description" id="description" />
                            <br><br>
                            <label class=textform for="categorie">id categorie</label>
                            <br>
                            <input type="text" name="categorie" id="categorie" />
                            <br><br>
                            <label class=textform for="image">nom image</label>
                            <br>
                            <input type="text" name="image" id="image" />
                            <br><br>
                            <label class=textform for="prix">prix prestation</label>
                            <br>
                            <input type="text" name="prix" id="prix" />
                            <br><br>
                            <input class="ui large button" type="submit" name="Valider" value="Valider">
                            <br><br>                            
                        </p>
                    </form>
                    <div class="ui vertical stripe segment prest title">
                        <div class="ui text container">
                           <h2 class="ui header">Suppression de prestation</h2>
                        </div>
                    </div>
                    <form class=form method="post" action="/gestion/suppression">
                        <p>
                            <br>
                            <label class=textform  for="id">id de la prestation</label>
                            <br>
                            <input type="text" name="id" id="id" />
                            <br><br>
                            <input class="ui large button" type="submit" name="Supprimer" value="Supprimer">
                            <br><br>
                        </p>
                    </form><div class="ui vertical stripe segment prest title">
                        <div class="ui text container">
                           <h2 class="ui header">Désactivation/Activation de prestation</h2>
                        </div>
                    </div>                  
                    <form class=form method="post" action="/gestion/suspenssion">
                        <p>
                            <br>
                            <label class=textform  for="id">id de la prestation</label>
                            <br>
                            <input type="text" name="id" id="id" />
                            <br><br>
                            <input class="ui large button" type="submit" name="Valider" value="Valider">
                        </p>
                    </form>                    
                </div>
            </body>
        </html>



END;
        return $html;
    }

    public function htmlConfirmation()
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
            .form{
                display:block;
                margin:auto;
                width:150px;
                margin-top = 100px;
            }
            
            
            </style>
            
            
            <body>
                
                <div class="ui inverted vertical center aligned segment">
                    <div class="ui container">
                      <div class="ui large secondary inverted pointing menu">
                        <a class="item" href="/">Accueil</a>
                        <a class="item" href="/catalogue">Catalogue</a>
                        <div class="right item">
                          <a class="ui inverted button" href="/deconnexion">Déconnexion</a>
                        </div>
                      </div>
                    </div>
                </div>
  
                <div class="ui container" style="width: 80%; padding-top: 30px">
                   <h2>Votre commandde c'est bien effectué</h2>
                   <a class="ui huge button" href=/gestion>Retour<i class="right arrow icon"></i></a>
                </div>
            </body>
        </html>



END;
        return $html;
    }

    public function htmlEchec()
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
            .form{
                display:block;
                margin:auto;
                width:150px;
                margin-top = 100px;
            }
            
            
            </style>
            
            
            <body>
                
                <div class="ui inverted vertical center aligned segment">
                    <div class="ui container">
                      <div class="ui large secondary inverted pointing menu">
                        <a class="item" href="/">Accueil</a>
                        <a class="item" href="/catalogue">Catalogue</a>
                        <div class="right item">
                          <a class="ui inverted button" href="/deconnexion">Déconnexion</a>
                        </div>
                      </div>
                    </div>
                </div>
  
                <div class="ui container" style="width: 80%; padding-top: 30px">
                   <h2>Erreur votre commande ne c'est pas effectué correctement</h2>
                   <a class="ui huge button" href=/gestion>Retour<i class="right arrow icon"></i></a>
                </div>
            </body>
        </html>



END;
        return $html;
    }

    function render(){
        switch ($this->selecteur){
            case "gestion" :
                $html = $this->htmlGestion();
                break;
            case "confirmation" :
                $html = $this->htmlConfirmation();
                break;
            case "echec" :
                $html = $this->htmlEchec();
                break;
        }
        return $html;
    }


}
