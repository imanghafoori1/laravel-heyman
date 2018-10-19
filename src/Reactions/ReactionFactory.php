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
        $condition = resolve(ChainManager::class)->getCondition();

        return function (...$f) use ($condition, $reaction) {
            if (!$condition($f)) {
                $reaction();
            }
        };
    }

    private function makeReaction(): \Closure
    {
        $chain = resolve(ChainManager::class);
        $beforeReaction = $chain->beforeReaction();
        $debug = $chain->debugInfo();
        $termination = $chain->getTermination();

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
}
