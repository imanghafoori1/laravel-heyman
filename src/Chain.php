<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Reactions\ReactionFactory;

class Chain
{
    /**
     * @var \Imanghafoori\HeyMan\ListenerApplier
     */
    public $eventManager;

    public $debugInfo;

    public $condition;

    public $responseType = 'nothing';

    public $data = [];

    private $beforeResponse = [];

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

    public function submitChainConfig()
    {
        $callbackListener = resolve(ReactionFactory::class)->make();
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

    public function commit($args, $methodName)
    {
        $this->data = $args;
        $this->responseType = $methodName;
    }

    public function commitArray($args, $methodName)
    {
        $this->data[] = $args;
        $this->responseType = $methodName;
    }

    /**
     * @param $d
     */
    public function writeDebugInfo($d)
    {
        $this->debugInfo = array_only($d[1], ['file', 'line', 'args']);
    }
}
