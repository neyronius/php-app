<?php
/**
 * Created by PhpStorm.
 * User: vladislav
 * Date: 13.03.2018
 * Time: 15:52
 */

namespace Neyronius\Base\Http;


use http\Env\Response;
use Neyronius\Base\Events\EventsManager;
use Neyronius\Base\Http\Events\SendResponseAndShutDown;
use Neyronius\Base\Http\Events\ShutDown;
use Psr\Http\Message\ResponseInterface;

abstract class App
{
    /**
     * @var EventsManager
     */
    protected $eventsManager = null;

    /**
     * The main function to be implemented
     *
     * @return mixed
     */
    abstract function run();

    /**
     * App constructor.
     * @param EventsManager $em
     */
    public function __construct(EventsManager $em)
    {
        $this->eventsManager = $em;
        $this->eventsManager->subscribe(SendResponseAndShutDown::class, function (SendResponseAndShutDown $event) {
            $this->sendResponse($event->getResponse());
            $this->shutDown();
        });
    }

    /**
     * Send the response to the client
     *
     * @param ResponseInterface $response
     */
    protected function sendResponse(ResponseInterface $response)
    {
        /** @var Response $response */

        ob_start();

        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                //\Kint::dump($name, $value);
                header(sprintf('%s: %s', $name, $value), false);
            }
        }
        http_response_code($response->getStatusCode());
        echo $response->getBody();

        echo ob_get_clean();
    }

    /**
     * A way for another components to do anything if the app has stopped
     */
    protected function shutDown()
    {
        $this->eventsManager->publish(new ShutDown());
        exit();
    }
}