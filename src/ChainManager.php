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
        $this->chain = new Chain();
        $this->chain->chainInfo = [
            'beforeReaction' => [],
            'debugInfo'      => ['file' => '', 'line' => '', 'args' => ''],
            'responseType'   => 'nothing',
            'data'           => [],
        ];
    }

    public function addEventBeforeReaction($event, array $payload, bool $halt)
    {
        $this->chain->chainInfo['beforeReaction'][] = function () use ($event, $payload, $halt) {
            resolve('events')->dispatch($event, $payload, $halt);
        };
    }

    public function submitChainConfig()
    {
        $callbackListener = resolve(ReactionFactory::class)->make();
        $this->get('eventManager')->commitChain($callbackListener);
    }

    public function beforeReaction(): \Closure
    {
        $tasks = $this->get('beforeReaction');

        return function () use ($tasks) {
            foreach ($tasks as $task) {
                $task();
            }
        };
    }

    public function commitCalledMethod($args, $methodName)
    {
        $this->chain->chainInfo['data'][] = $args;
        $this->set('responseType', $methodName);
    }

    public function getCalledResponse()
    {
        return [$this->get('data'), $this->get('responseType')];
    }

    public function get($key)
    {
        return $this->chain->chainInfo[$key] ?? null;
    }

    public function set($key, $value)
    {
        $this->chain->chainInfo[$key] = $value;
    }
}
