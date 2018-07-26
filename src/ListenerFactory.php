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
        $this->dispatcher();
        $this->calls();

        if ($this->chain->abort) {
            $responder = $this->abortCallback($this->chain->abort);
        }

        if ($this->chain->exception) {
            $responder = $this->exceptionCallback($this->chain->exception);
        }

        if ($this->chain->response) {
            $responder = $this->responseCallback($this->chain->response);
        }

        if ($this->chain->redirect) {
            $responder = $this->redirectCallback($this->chain->redirect);
        }

        return $this->callBack($responder);
    }

    /**
     * @param $e
     * @param $cb
     *
     * @return \Closure
     */
    private function exceptionCallback($e): \Closure
    {
        $responder = function () use ($e) {
            $exClass = $e['class'];
            throw new $exClass($e['message']);
        };

      return $responder;
    }

    /**
     * @param $resp
     * @param $cb
     *
     * @return \Closure
     */
    private function responseCallback($resp): \Closure
    {
        $responder = function () use ($resp) {
            $respObj = response();
            foreach ($resp as $call) {
                list($method, $args) = $call;
                $respObj = $respObj->{$method}(...$args);
            }
            respondWith($respObj);
        };

      return $responder;
    }

    private function redirectCallback($resp): \Closure
    {
        $responder = function () use ($resp) {
            $respObj = redirect();
            foreach ($resp as $call) {
                list($method, $args) = $call;
                $respObj = $respObj->{$method}(...$args);
            }
            respondWith($respObj);
        };

      return $responder;
    }

    /**
     * @param $cb
     * @param $responder
     * @return \Closure
     */
    private function callBack($responder): \Closure
    {
        $dispatcher = $this->dispatcher;
        $calls = $this->caller;
        $cb = $this->chain->predicate;
        $this->chain->reset();

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

    private function abortCallback($abort)
    {
        $responder = function () use ($abort) {
            abort(...$abort);
        };

      return $responder;
    }
}
