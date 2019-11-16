<?php

namespace Imanghafoori\HeyMan\Core;

use Imanghafoori\HeyMan\Reactions\ResponderFactory;

final class ReactionFactory
{
    public function make()
    {
        $reaction = $this->makeReaction();
        $condition = resolve('heyman.chain')->get('condition');

        return function (...$f) use ($condition, $reaction) {
            if (! $condition($f)) {
                $conditionMeta = resolve('heyman.chain')->get('condition_meta') ?: null;
                $reaction($conditionMeta);
            }
        };
    }

    private function makeReaction()
    {
        $chain = resolve('heyman.chain');

        $beforeReaction = $this->makePreResponseActions($chain);

        $debug = $chain->get('debugInfo') ?? ['file' => '', 'line' => '', 'args' => ''];
        $termination = $chain->get('termination');

        $responder = resolve(ResponderFactory::class)->make();

        return function ($param = null) use ($beforeReaction, $responder, $debug, $termination) {
            if ($termination) {
                app()->terminating($termination);
            }
            event('heyman_reaction_is_happening', $debug);
            $beforeReaction();
            $responder($param);
        };
    }

    private function makePreResponseActions($chain)
    {
        $tasks = $chain->get('beforeReaction') ?? [];
        $tasks = $this->convertToClosures($tasks);
        $beforeReaction = function () use ($tasks) {
            foreach ($tasks as $task) {
                $task();
            }
        };

        return $beforeReaction;
    }

    private function convertToClosures($tasks)
    {
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
