<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/** @var \Aura\Router\Map $map */

$map->get('home', '/', function(\League\Plates\Engine $tpl) {





    return $tpl->render('home');
});



$map->get('users.login.show', '/login', [\App\Users\Controllers\Login::class, 'show']);
$map->get('users.register.show', '/register', [\App\Users\Controllers\Register::class, 'show']);
$map->post('users.register.try', '/register', [\App\Users\Controllers\Register::class, 'tryToRegister']);
$map->get('users.logout', '/logout', [\App\Users\Controllers\Logout::class, 'do']);