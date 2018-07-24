<?php

namespace Imanghafoori\HeyMan;

class ListenerFactory
{
    /**
     * @param $resp
     * @param $e
     * @param $redirect
     *
     * @return \Closure
     */
    public function make($resp, $e, $redirect): \Closure
    {
        $cb = app(YouShouldHave::class)->predicate;

        if ($e) {
            return $this->exceptionCallback($e, $cb);
        }

        if ($resp) {
            return $this->responseCallback($resp, $cb);
        }

        if ($redirect) {
            return $this->redirectCallback($redirect, $cb);
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
        return function (...$f) use ($e, $cb) {
            if (!$cb($f)) {
                throw $e;
            }
        };
    }

    /**
     * @param $resp
     * @param $cb
     *
     * @return \Closure
     */
    private function responseCallback($resp, $cb): \Closure
    {
        return function (...$f) use ($resp, $cb) {
            if (!$cb($f)) {
                $respObj = response();
                foreach ($resp as $call) {
                    list($method, $args) = $call;
                    $respObj = $respObj->{$method}(...$args);
                }

                respondWith($respObj);
            }
        };
    }

    private function redirectCallback($resp, $cb): \Closure
    {
        return function (...$f) use ($resp, $cb) {
            if (!$cb($f)) {
                $respObj = redirect();
                foreach ($resp as $call) {
                    list($method, $args) = $call;
                    $respObj = $respObj->{$method}(...$args);
                }

                respondWith($respObj);
            }
        };
    }
}
