<?php

namespace Quinen\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{
    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->setLayout('Quinen.default');
    }
}
