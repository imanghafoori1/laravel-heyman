<?php

namespace Imanghafoori\HeyMan;

class Chain
{
    /**
     * @var \Imanghafoori\HeyMan\ListenerApplier
     */
    public $eventManager;

    public $predicate;

    public $response = [];

    public $redirect = [];

    public $exception = [];

    public $events = [];

    public $abort;

    public $calls;

    public function reset()
    {
        $this->redirect = [];
        $this->exception = [];
        $this->response = [];
        $this->predicate = null;
        $this->abort = null;
        //$this->eventManager = null;
    }

    public function addRedirect($method, $params)
    {
        $this->redirect[] = [$method, $params];
    }

    public function addResponse($method, $params)
    {
        $this->response[] = [$method, $params];
    }

    public function addException($className, $message)
    {
        $this->exception = ['class' => $className, 'message' => $message];
    }

    public function addAbort($code, $message, $headers)
    {
        $this->abort = [$code, $message, $headers];
    }

    public function addAfterCall($callback, $parameters)
    {
        $this->calls[] = [$callback, $parameters];
    }

    public function eventFire($event, $payload, $halt)
    {
        $this->events[] = [$event, $payload, $halt];
    }

    public function submitChainConfig()
    {
        $callbackListener = app(ListenerFactory::class)->make();
        $this->eventManager->startGuarding($callbackListener);
    }
}
