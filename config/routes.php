<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Quinen',
    ['path' => '/quinen'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
        $routes->connect('/', ['controller' => 'Index', 'action' => 'index','plugin'=>"Quinen"]);
        $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display','index']);        
    }
);