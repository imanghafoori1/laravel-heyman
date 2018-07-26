<?php

namespace Imanghafoori\HeyMan;

class ResponderFactory
{
    private $chain;

    /**
     * ResponderFactory constructor.
     *
     * @param \Imanghafoori\HeyMan\Chain $chain
     */
    public function __construct(Chain $chain)
    {
        $this->chain = $chain;
    }

    public function make()
    {
        if ($this->chain->abort) {
            return $this->abortCallback($this->chain->abort);
        } elseif ($this->chain->exception) {
            return $this->exceptionCallback($this->chain->exception);
        } elseif ($this->chain->response) {
            return $this->responseCallback($this->chain->response);
        } elseif ($this->chain->redirect) {
            return $this->redirectCallback($this->chain->redirect);
        }
    }

    public function abortCallback($abort)
    {
        $responder = function () use ($abort) {
            abort(...$abort);
        };

        return $responder;
    }

    /**
     * @param $e
     * @param $cb
     *
     * @return \Closure
     */
    public function exceptionCallback($e): \Closure
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
    public function responseCallback($resp): \Closure
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

    public function redirectCallback($resp): \Closure
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
}
