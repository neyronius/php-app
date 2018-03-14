<?php

return[

    \App\Application::class => DI\create(\App\Application::class)
        ->constructor(DI\get(\Neyronius\Base\Events\EventsManager::class)),

    \Aura\Router\RouterContainer::class => DI\create(\Aura\Router\RouterContainer::class),

    \Psr\Http\Message\ServerRequestInterface::class => DI\factory(function(){
        return Zend\Diactoros\ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );
    }),

    \Psr\Http\Message\ResponseInterface::class => DI\create(\Zend\Diactoros\Response::class),

    'NotFoundResponse' => \DI\create(\Zend\Diactoros\Response::class)
                            ->constructor('php://memory', 404),

    \League\Plates\Engine::class => function(){

        $engine = new \League\Plates\Engine(SRC_ROOT . '/app/Common/Templates');

        $engine->addFolder('users', SRC_ROOT . '/app/Users/Templates', true);



        return $engine;
    },

    \Neyronius\Base\DB\PDO::class => function(){

        $pdo = new \Neyronius\Base\DB\PDO(
            'mysql:host=' . \env('DB_HOST') . ";charset=utf8mb4;dbname=" . \env('DB_NAME'),
            \env('DB_USER'),
            \env('DB_PASSWORD'),
            [
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
            ]

        );

        return $pdo;
    },

    \Delight\Auth\Auth::class => \DI\create(\Delight\Auth\Auth::class)
                                        ->constructor(\DI\get(\Neyronius\Base\DB\PDO::class)),


    \Neyronius\Base\Events\EventsManager::class => DI\create(\Neyronius\Base\Events\EventsManager::class)
];