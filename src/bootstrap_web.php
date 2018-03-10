<?php

require 'vendor/autoload.php';

define('SRC_ROOT', __DIR__);

call_user_func(function(){

    $container = require 'config/container.php';
    /** @var \DI\Container $container */

    $app = $container->get(\App\Application::class);

    $app->run();

});