<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\Chain;
use Imanghafoori\HeyMan\ResponderFactory;

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
        $responder = app(ResponderFactory::class)->make();

        return $this->makeReaction($responder);
    }

    /**
     * @param $responder
     *
     * @return \Closure
     */
    private function makeReaction(callable $responder): \Closure
    {
        $beforeResponse = $this->methodsToCall();

        $cb = $this->chain->predicate;
        $this->chain->reset();

        return function (...$f) use ($responder, $cb, $beforeResponse) {
            if ($cb($f)) {
                return true;
            }

            $beforeResponse();
            $responder();
        };
    }

    private function methodsToCall(): \Closure
    {
        $calls = $this->chain->beforeResponse;

        if (!$calls) {
            return function () {
            };
        }

        return function () use ($calls) {
            foreach ($calls as $call) {
                $call();
            }
        };
    }
}
