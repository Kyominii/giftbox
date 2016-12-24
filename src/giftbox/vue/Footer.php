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