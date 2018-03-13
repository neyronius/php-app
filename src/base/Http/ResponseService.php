<?php

namespace Neyronius\Base\Http;


use Neyronius\Base\Events\EventsManager;
use Neyronius\Base\Http\Events\SendResponseAndShutDown;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;

class ResponseService
{

    /**
     * @var ResponseInterface
     */
    protected $response = null;

    /**
     * @var EventsManager
     */
    protected $eventsManager = null;

    /**
     * ResponseService constructor.
     *
     * @param ResponseInterface $response
     * @param EventsManager $eventsManager
     */
    public function __construct(ResponseInterface $response, EventsManager $eventsManager)
    {
        $this->response = $response;
        $this->eventsManager = $eventsManager;
    }

    /**
     * Get redirect response
     *
     * @param $url
     * @return Response
     */
    public function redirect($url)
    {
        $this->response = $this->response->withHeader('Location', $url)->withStatus(302);

        $event = new SendResponseAndShutDown();
        $event->setResponse($this->response);

        $this->eventsManager->publish($event);
    }

}