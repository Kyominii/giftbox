<?php

namespace giftbox\vue;

class Header
{
    public static function getHeader($title){
        $html = <<<END
        <!DOCTYPE html>
        <html>
            <head>
                <title>$title</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/semantic-ui/2.2.6/semantic.min.css">
            </head>
            <body>
                
                <div class="ui fixed inverted menu">
                    <div class="ui container">
                      <a href="/" class="header item">
                        <img class="logo" src="/assets/img/connaissance.jpg">
                        <span style="padding-left: 10px">Giftbox</span>
                      </a>
                      <a href="/" class="item">Accueil</a>
                      <a href="/catalogue" class="item">Catalogue</a>
                    </div>
                </div>
  
                <div class="ui container" style="width: 80%; padding-top: 100px">


END;

        return $html;
    }
}