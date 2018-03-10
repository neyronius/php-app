<?php

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/** @var \Aura\Router\Map $map */

$map->get('home', '/', function(RequestInterface $request) {

    $response = DI()->get(ResponseInterface::class);
    /** @var \Zend\Diactoros\Response $response */

    $response->getBody()->write("Home");


    return $response;
});