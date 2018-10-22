<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\ChainManager;

final class ReactionFactory
{
    /**
     * @return \Closure
     */
    public function make(): \Closure
    {
        $reaction = $this->makeReaction();
        $condition = resolve(ChainManager::class)->get('condition');

        return function (...$f) use ($condition, $reaction) {
            if (!$condition($f)) {
                $reaction();
            }
        };
    }

    private function makeReaction(): \Closure
    {
        $chain = resolve(ChainManager::class);

        $beforeReaction = $this->makePreResponseActions($chain);

        $debug = $chain->get('debugInfo') ?? ['file' => '', 'line' => '', 'args' => ''];
        $termination = $chain->get('termination');

        $responder = resolve(ResponderFactory::class)->make();

        return function () use ($beforeReaction, $responder, $debug, $termination) {
            if ($termination) {
                app()->terminating($termination);
            }
            event('heyman_reaction_is_happening', $debug);
            $beforeReaction();
            $responder();
        };
    }

    /**
     * @param $chain
     *
     * @return \Closure
     */
    private function makePreResponseActions($chain): \Closure
    {
        $tasks = $this->convertToClosures($chain);
        $beforeReaction = function () use ($tasks) {
            foreach ($tasks as $task) {
                $task();
            }
        };

        return $beforeReaction;
    }

    /**
     * @param $chain
     *
     * @return array
     */
    private function convertToClosures($chain): array
    {
        $tasks = $chain->get('beforeReaction') ?? [];

        $map = function ($task) {
            $params = $task[0];

            if ($task[1] == 'event') {
                return function () use ($params) {
                    resolve('events')->dispatch(...$params);
                };
            }

            return function () use ($params) {
                app()->call(...$params);
            };
        };

        return array_map($map, $tasks);
    }
}
