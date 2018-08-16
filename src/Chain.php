<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Reactions\ReactionFactory;

class Chain
{
    /**
     * @var \Imanghafoori\HeyMan\ListenerApplier
     */
    public $eventManager;

    public $predicate;

    public $responseType = 'nothing';

    public $data = [];

    private $beforeResponse = [];

    public function addRedirect($method, $params)
    {
        $this->data[] = [$method, $params];
        $this->responseType = 'redirect';
    }

    public function addResponse($method, $params)
    {
        $this->data[] = [$method, $params];
        $this->responseType = 'response';
    }

    public function addException(string $className, string $message)
    {
        $this->data[] = ['class' => $className, 'message' => $message];
        $this->responseType = 'exception';
    }

    public function addAbort($code, string $message, array $headers)
    {
        $this->data[] = [$code, $message, $headers];
        $this->responseType = 'abort';
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
        $this->responseType = 'respondFrom';
    }

    public function submitChainConfig()
    {
        $callbackListener = app(ReactionFactory::class)->make();
        $this->eventManager->commitChain($callbackListener);
    }

    public function beforeResponse(): \Closure
    {
        $calls = $this->beforeResponse;
        $this->beforeResponse = [];
        return function () use ($calls) {
            foreach ($calls as $call) {
                $call();
            }
        };
    }

}
