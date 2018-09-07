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

    private $beforeReaction = [];

    public function addAfterCall($callback, $parameters)
    {
        $this->beforeReaction[] = function () use ($callback, $parameters) {
            app()->call($callback, $parameters);
        };
    }

    public function eventFire($event, array $payload, bool $halt)
    {
        $this->beforeReaction[] = function () use ($event, $payload, $halt) {
            resolve('events')->dispatch($event, $payload, $halt);
        };
    }

    public function submitChainConfig()
    {
        $callbackListener = resolve(ReactionFactory::class)->make();
        $this->eventManager->commitChain($callbackListener);
    }

    public function beforeReaction(): \Closure
    {
        $calls = $this->beforeReaction;
        $this->beforeReaction = [];

        return function () use ($calls) {
            foreach ($calls as $call) {
                $call();
            }
        };
    }

    public function commitCalledMethod($args, $methodName)
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
