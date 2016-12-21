<?php

namespace giftbox\vue;


class Footer
{
    public static function getFooter(){
        $html = <<<END
                </div>
                <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
                <script src="https://cdn.jsdelivr.net/semantic-ui/2.2.6/semantic.min.js"></script>
            </body>
        <html>
END;

        return $html;
    }
}