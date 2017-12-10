<?php

namespace Quinen\View\Traits;

trait QuinenViewTrait
{
    public function initializeHelpers(){
        $this->loadHelper('Html',['className'=>"Quinen.Html"]);
    }
}
