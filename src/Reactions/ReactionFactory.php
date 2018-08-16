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
        $cb = $this->chain->predicate;

        return function (...$f) use ($cb, $reaction) {
            if (!$cb($f)) {
                $reaction();
            }
        };
    }

    private function makeReaction(): \Closure
    {
        $responder = app(ResponderFactory::class)->make();
        $beforeResponse = $this->chain->beforeResponse();

        return function () use ($beforeResponse, $responder) {
            $beforeResponse();
            $responder();
        };
    }
}
