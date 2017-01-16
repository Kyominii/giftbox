<?php

namespace giftbox\vue;


class VueCoffret
{
    private $pbc;

    public function __construct($fromController){
        $this->pbc = $fromController;
    }

    public function htmlDisplayCoffret(){
        return $this->pbc;
    }

    public function render(){

        $html = Header::getHeader("Coffret | Giftbox");
        $html = $html . $this->htmlDisplayCoffret();
        $html = $html . Footer::getFooter();
        return $html;
    }
}