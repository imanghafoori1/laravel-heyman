<?php

namespace Imanghafoori\HeyMan;

class ListenerFactory
{
    /**
     * @var \Imanghafoori\HeyMan\Chain
     */
    private $chain;

    /**
     * ListenerFactory constructor.
     *
     * @param \Imanghafoori\HeyMan\Chain $chain
     */
    public function __construct(Chain $chain)
    {
        $this->chain = $chain;
    }

    /**
     *
     * @return \Closure
     */
    public function make(): \Closure
    {
        $responder = app(ResponderFactory::class)->make();

        return $this->callBack($responder);
    }

    /**
     * @param $responder
     * @return \Closure
     */
    private function callBack($responder): \Closure
    {
        $dispatcher = $this->dispatcher();
        $calls = $this->calls();

        $cb = $this->chain->predicate;
        $this->chain->reset();

        return function (...$f) use ($responder, $cb, $dispatcher, $calls) {
            if ($cb($f)) {
                return true;
            }

            $calls();
            $dispatcher();
            $responder();
        };
    }

    private function dispatcher()
    {
        $events = $this->chain->events;

        if (! $events) {
            return function () {
            };
        }

        return function () use ($events) {
            foreach ($events as $event) {
                app('events')->dispatch(...$event);
            }
        };
    }

    private function calls()
    {
        $calls = $this->chain->calls;

        if (! $calls) {
            return function () {
            };
        }

        return function () use ($calls) {
            foreach ($calls as $call) {
                app()->call(...$call);
            }
        };
    }
}
