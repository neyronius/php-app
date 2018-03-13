<?php

namespace Neyronius\Base\Http\Events;


use Neyronius\Base\Events\Event;
use Psr\Http\Message\ResponseInterface;

class SendResponseAndShutDown extends Event
{
    /**
     * @var ResponseInterface
     */
    protected $response = null;

    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}