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

    public function addCallbackBeforeReaction($callback, $parameters)
    {
        $this->beforeReaction[] = function () use ($callback, $parameters) {
            app()->call($callback, $parameters);
        };
    }

    public function addEventBeforeReaction($event, array $payload, bool $halt)
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
        $tasks = $this->beforeReaction;
        $this->beforeReaction = [];

        return function () use ($tasks) {
            foreach ($tasks as $task) {
                $task();
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
