<?php

namespace Quinen\View;

use Cake\View\View;
use Quinen\View\Traits\QuinenViewTrait;

class AppView extends View
{
    use QuinenViewTrait;

    public function initialize()
    {
        parent::initialize();
        $this->initializeHelpers();
        
    }
}
