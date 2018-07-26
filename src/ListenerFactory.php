<?php

namespace Imanghafoori\HeyMan;

class ListenerFactory
{
    /**
     * @var \Imanghafoori\HeyMan\Chain
     */
    private $chain;

    private $dispatcher;

    private $caller;

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
        $predicate = $this->chain->predicate;
        $this->dispatcher();
        $this->calls();

        if ($this->chain->abort) {
            return $this->abortCallback($this->chain->abort, $predicate);
        }

        if ($this->chain->exception) {
            return $this->exceptionCallback($this->chain->exception, $predicate);
        }

        if ($this->chain->response) {
            return $this->responseCallback($this->chain->response, $predicate);
        }

        if ($this->chain->redirect) {
            return $this->redirectCallback($this->chain->redirect, $predicate);
        }
    }

    /**
     * @param $e
     * @param $cb
     *
     * @return \Closure
     */
    private function exceptionCallback($e, $cb): \Closure
    {
        $this->chain->reset();

        $responder = function () use ($e) {
            $exClass = $e['class'];
            throw new $exClass($e['message']);
        };

        return $this->callBack($cb, $responder);
    }

    /**
     * @param $resp
     * @param $cb
     *
     * @return \Closure
     */
    private function responseCallback($resp, $cb): \Closure
    {
        $this->chain->reset();

        $responder = function () use ($resp) {
            $respObj = response();
            foreach ($resp as $call) {
                list($method, $args) = $call;
                $respObj = $respObj->{$method}(...$args);
            }
            respondWith($respObj);
        };

        return $this->callBack($cb, $responder);
    }

    private function redirectCallback($resp, $cb): \Closure
    {
        $this->chain->reset();

        $responder = function () use ($resp) {
            $respObj = redirect();
            foreach ($resp as $call) {
                list($method, $args) = $call;
                $respObj = $respObj->{$method}(...$args);
            }
            respondWith($respObj);
        };

        return $this->callBack($cb, $responder);
    }

    /**
     * @param $cb
     * @param $responder
     * @return \Closure
     */
    private function callBack($cb, $responder): \Closure
    {
        $dispatcher = $this->dispatcher;
        $calls = $this->caller;


        $this->caller = $this->dispatcher = function () {
        };
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
            return $this->dispatcher = function () {
            };
        }

        return $this->dispatcher = function () use ($events) {
            foreach ($events as $event) {
                app('events')->dispatch(...$event);
            }
        };
    }

    private function calls()
    {
        $calls = $this->chain->calls;

        if (! $calls) {
            return $this->caller = function () {
            };
        }

        return $this->caller = function () use ($calls) {
            foreach ($calls as $call) {
                app()->call(...$call);
            }
        };
    }

    private function abortCallback($abort, $cb)
    {
        $this->chain->reset();
        $responder = function () use ($abort) {
            abort(...$abort);
        };

        return $this->callBack($cb, $responder);
    }
}
