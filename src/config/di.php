<?php

return[

    \App\Application::class => DI\create(\App\Application::class),
    \Aura\Router\RouterContainer::class => DI\create(\Aura\Router\RouterContainer::class),

    \Psr\Http\Message\RequestInterface::class => DI\factory(function(){
        return Zend\Diactoros\ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );
    }),

    \Psr\Http\Message\ResponseInterface::class => DI\create(\Zend\Diactoros\Response::class)

];