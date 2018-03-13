<?php

namespace App;

use Aura\Router\RouterContainer;
use Dotenv\Dotenv;
use Neyronius\Base\Http\App;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class Application extends App
{
    const ENV_LIVE = 'live';
    const ENV_DEV = 'dev';
    const ENV_STAGE = 'stage';
    const ENV_TEST = 'test';

    public function run()
    {
        $this->loadConfiguration();

        if (APP_ENV !== self::ENV_LIVE) {
            $this->registerPrettyErrorHandler();
        }

        DI()->call([$this, 'loadRoutes']);
        DI()->call([$this, 'dispatch']);
    }

    public function dispatch(RouterContainer $routerContainer, ServerRequestInterface $request)
    {
        $matcher = $routerContainer->getMatcher();
        $route = $matcher->match($request);

        if ($route) {
            $answer = DI()->call($route->handler);

            if ($answer instanceof ResponseInterface) {
                $response = $answer;
            } elseif (is_scalar($answer)) {
                $response = new Response('php://memory', 200);
                $response->getBody()->write($answer);
            } else {
                throw new \RuntimeException("Invalid controller answer");
            }

        } else {

            // get the first of the best-available non-matched routes
            $failedRoute = $matcher->getFailedRoute();

            // which matching rule failed?
            switch ($failedRoute->failedRule) {
                case 'Aura\Router\Rule\Allows':
                    // 405 METHOD NOT ALLOWED
                    // Send the $failedRoute->allows as 'Allow:'
                    throw new \Exception("To be implemented");
                    break;
                case 'Aura\Router\Rule\Accepts':
                    // 406 NOT ACCEPTABLE
                    throw new \Exception("To be implemented");
                    break;
                default:
                    // 404 NOT FOUND
                    $response = DI()->get('NotFoundResponse');
                    break;
            }
        }

        $this->sendResponse($response);
        $this->shutDown();
    }


    public function registerPrettyErrorHandler()
    {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }

    /**
     * Load all configuration resources
     */
    public function loadConfiguration()
    {
        \Env::init();

        if (file_exists(SRC_ROOT . '/.env')) {
            $dotenv = new Dotenv(SRC_ROOT);
            $dotenv->load();
            $dotenv->required([
                'DB_NAME',
                'DB_USER',
                'DB_PASSWORD',
                'DB_HOST'
            ]);
        }

        define('APP_ENV', env('APP_ENV') ?: self::ENV_LIVE);

        if (!in_array(APP_ENV, $this->getAllowedEnvironments(), true)) {
            die('Invalid environment');
        }

        $configFileName = SRC_ROOT . '/config/env/' . APP_ENV . '.php';

        if (file_exists($configFileName)) {
            require $configFileName;
        }
    }

    /**
     * Get all allowed environments in this app
     *
     * @return array
     */
    public function getAllowedEnvironments()
    {
        return [self::ENV_LIVE, self::ENV_DEV, self::ENV_STAGE, self::ENV_TEST];
    }

    /**
     * Load routes configuration
     *
     *
     *
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Exception
     */
    public function loadRoutes(RouterContainer $routerContainer)
    {
        $map = $routerContainer->getMap();
        require SRC_ROOT . '/config/routes.php';
    }

}