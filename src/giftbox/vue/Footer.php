<?php

namespace giftbox\vue;


class Footer
{
    public static function getFooter(){
        $html = <<<END
                </div>
                <script>
                    var url = window.location.href;
                    if(url.indexOf("sort=1") !== -1){
                        $('.tri.ui.dropdown').dropdown('set selected', "croissant");
                    } else if(url.indexOf("sort=2") !== -1) {
                        $('.tri.ui.dropdown').dropdown('set selected', "decroissant");
                    }
                    
                    url = window.location.pathname;
                    if(url.indexOf("/catalogue/cat/") !== -1){
                        $('.categorie.ui.dropdown').dropdown('set selected', url.substring(url.indexOf("/catalogue/cat/") + 15));
                    }
                    $('.ui.dropdown').dropdown();
                </script>
            </body>
        <html>
END;

        return $html;
    }
}