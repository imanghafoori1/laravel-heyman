<?php

namespace Imanghafoori\HeyMan;

class Chain
{
    /**
     * @var \Imanghafoori\HeyMan\ListenerApplier
     */
    public $eventManager;

    public $predicate;

    public $events = [];

    public $afterCalls;

    public $methodName = 'nothing';

    public $nothing = null;

    public $data = [];

    public function reset()
    {
        $this->events = [];
        $this->data = [];
        $this->predicate = null;
        $this->methodName = 'nothing';
    }

    public function addRedirect($method, $params)
    {
        $this->data[] = [$method, $params];
        $this->methodName = 'redirect';
    }

    public function addResponse($method, $params)
    {
        $this->data[] = [$method, $params];
        $this->methodName = 'response';
    }

    public function addException(string $className, string $message)
    {
        $this->data[] = ['class' => $className, 'message' => $message];
        $this->methodName = 'exception';
    }

    public function addAbort($code, string $message, array $headers)
    {
        $this->data[] = [$code, $message, $headers];
        $this->methodName = 'abort';
    }

    public function addAfterCall($callback, $parameters)
    {
        $this->afterCalls[] = [$callback, $parameters];
    }

    public function eventFire($event, array $payload, bool $halt)
    {
        $this->events[] = [$event, $payload, $halt];
    }

    public function addRespondFrom($callback, array $parameters)
    {
        $this->data[] = [$callback, $parameters];
        $this->methodName = 'respondFrom';
    }

    public function submitChainConfig()
    {
        $callbackListener = app(ReactionFactory::class)->make();
        $this->eventManager->startGuarding($callbackListener);
    }
}
