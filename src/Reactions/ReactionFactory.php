<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\Chain;

class ReactionFactory
{
    /**
     * @var \Imanghafoori\HeyMan\Chain
     */
    private $chain;

    /**
     * ListenerFactory constructor.
     *
     * @param Chain $chain
     */
    public function __construct(Chain $chain)
    {
        $this->chain = $chain;
    }

    /**
     * @return \Closure
     */
    public function make(): \Closure
    {
        $reaction = $this->makeReaction();
        $condition = $this->chain->condition;

        return function (...$f) use ($condition, $reaction) {
            if (!$condition($f)) {
                $reaction();
            }
        };
    }

    private function makeReaction(): \Closure
    {
        $responder = app(ResponderFactory::class)->make();
        $beforeResponse = $this->chain->beforeResponse();
        $debug = app(Chain::class)->debugInfo;

        return function () use ($beforeResponse, $responder, $debug) {
            event('heyman_reaction_is_happening', $debug);
            $beforeResponse();
            $responder();
        };
    }
}
