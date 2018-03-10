<?php

namespace App;


use Aura\Router\RouterContainer;
use Dotenv\Dotenv;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response;

class Application
{
    const ENV_LIVE = 'live';
    const ENV_DEV = 'dev';
    const ENV_STAGE = 'stage';
    const ENV_TEST = 'test';


    public function __construct()
    {

    }

    public function run()
    {
        $this->loadConfiguration();

        if(APP_ENV !== self::ENV_LIVE){
            $this->registerPrettyErrorHandler();
        }

        $this->loadRoutes();

        $this->dispatch();
    }

    public function dispatch()
    {
        $matcher = DI()->get(RouterContainer::class)->getMatcher();
        $route = $matcher->match(DI()->get(RequestInterface::class));

        if (! $route) {
            // get the first of the best-available non-matched routes
            $failedRoute = $matcher->getFailedRoute();

            // which matching rule failed?
            switch ($failedRoute->failedRule) {
                case 'Aura\Router\Rule\Allows':
                    // 405 METHOD NOT ALLOWED
                    // Send the $failedRoute->allows as 'Allow:'
                    break;
                case 'Aura\Router\Rule\Accepts':
                    // 406 NOT ACCEPTABLE
                    break;
                default:
                    // 404 NOT FOUND
                    break;
            }
        }

        DI()->call($route->handler);

        //$response = call_user_func($route->handler, DI()->get(RequestInterface::class));

        /** @var Response $response */

        ob_start();

        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header(sprintf('%s: %s', $name, $value), false);
            }
        }
        http_response_code($response->getStatusCode());
        echo $response->getBody();

        echo ob_get_clean();
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

        if(!in_array(APP_ENV, $this->getAllowedEnvironments(), true)){
            die('Invalid environment');
        }

        $configFileName = SRC_ROOT . '/config/env/' . APP_ENV . '.php';

        if(file_exists($configFileName)){
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
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Exception
     */
    public function loadRoutes()
    {
        $routerContainer = DI()->get(RouterContainer::class);
        $map = $routerContainer->getMap();
        require SRC_ROOT . '/config/routes.php';
    }

}