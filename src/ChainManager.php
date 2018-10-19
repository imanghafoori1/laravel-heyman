<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Reactions\ReactionFactory;

class ChainManager
{
    /**
     * @var \Imanghafoori\HeyMan\Chain
     */
    private $chain;

    public function addCallbackBeforeReaction($callback, $parameters)
    {
        $this->chain->chainInfo['beforeReaction'][] = function () use ($callback, $parameters) {
            app()->call($callback, $parameters);
        };
    }

    public function startChain()
    {
        $this->chain = resolve(Chain::class);
    }

    public function addEventBeforeReaction($event, array $payload, bool $halt)
    {
        $this->chain->chainInfo['beforeReaction'][] = function () use ($event, $payload, $halt) {
            resolve('events')->dispatch($event, $payload, $halt);
        };
    }

    public function addTerminationCallback($callback)
    {
        $this->chain->chainInfo['termination'] = $callback;
    }

    public function submitChainConfig()
    {
        $callbackListener = resolve(ReactionFactory::class)->make();
        $this->chain->chainInfo['eventManager']->commitChain($callbackListener);
    }

    public function beforeReaction(): \Closure
    {
        $tasks = $this->chain->chainInfo['beforeReaction'];

        return function () use ($tasks) {
            foreach ($tasks as $task) {
                $task();
            }
        };
    }

    public function commitCalledMethod($args, $methodName)
    {
        $this->chain->chainInfo['data'][] = $args;
        $this->chain->chainInfo['responseType'] = $methodName;
    }

    public function getCalledResponse()
    {
        return [$this->chain->chainInfo['data'], $this->chain->chainInfo['responseType']];
    }

    public function writeDebugInfo($d)
    {
        $this->chain->chainInfo['debugInfo'] = array_only($d[1], ['file', 'line', 'args']);
    }

    public function debugInfo()
    {
        return $this->chain->chainInfo['debugInfo'];
    }

    public function getTermination()
    {
        return $this->chain->chainInfo['termination'];
    }

    public function setEventManager($manager)
    {
        $this->chain->chainInfo['eventManager'] = $manager;
    }

    public function setCondition($condition)
    {
        $this->chain->chainInfo['condition'] = $condition;
    }

    public function getCondition()
    {
        return $this->chain->chainInfo['condition'];
    }
}
