<?php

namespace giftbox\vue;


class Footer
{
    public static function getFooter(){
        $html = <<<END
                </div>
                <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
                <script src="https://cdn.jsdelivr.net/semantic-ui/2.2.6/semantic.min.js"></script>
                <script>
                    var url = window.location.href;
                    if(url.indexOf("sort=1") !== -1){
                        $('.ui.dropdown').dropdown('set selected', "croissant");
                    } else if(url.indexOf("sort=2") !== -1) {
                        $('.ui.dropdown').dropdown('set selected', "decroissant");
                    }
                    $('.ui.dropdown').dropdown();
                </script>
            </body>
        <html>
END;

        return $html;
    }
}