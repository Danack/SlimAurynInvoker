<?php

use Slim\App;

function setupRoutes(App $app)
{
    $routes = [
        ['/', 'GET', 'Danack\SlimAurynExample\HomePage::getHomePage'],
    ];

    foreach ($routes as $route) {
        list($path, $method, $callable) = $route;
        $app->{$method}($path, $callable);
    }
}