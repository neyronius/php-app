<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/** @var \Aura\Router\Map $map */

$map->get('home', '/', function(ServerRequestInterface $request) {

    $response = DI()->get(ResponseInterface::class);
    /** @var \Zend\Diactoros\Response $response */

    $response->getBody()->write("Home");


    return $response;
});

$map->get('login.show', '/login', [\App\Users\Controllers\Login::class, 'show']);