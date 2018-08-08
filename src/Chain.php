<?php

namespace Imanghafoori\HeyMan;

class Chain
{
    /**
     * @var \Imanghafoori\HeyMan\ListenerApplier
     */
    public $eventManager;

    public $predicate;

    public $methodName = 'nothing';

    public $nothing = null;

    public $data = [];

    public $beforeResponse = [];

    public function reset()
    {
        $this->data = [];
        $this->predicate = null;
        $this->methodName = 'nothing';
        $this->beforeResponse = [];
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
        $this->beforeResponse[] = function () use ($callback, $parameters) {
            app()->call($callback, $parameters);
        };
    }

    public function eventFire($event, array $payload, bool $halt)
    {
        $this->beforeResponse[] = function () use ($event, $payload, $halt) {
            app('events')->dispatch($event, $payload, $halt);
        };
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
