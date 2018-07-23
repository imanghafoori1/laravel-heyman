<?php

namespace Imanghafoori\HeyMan;

class ListenerFactory
{
    /**
     * @param $resp
     * @param $e
     *
     * @return \Closure
     */
    public function make($resp, $e): \Closure
    {
        $cb = app(YouShouldHave::class)->predicate;
        if ($e) {
            return $this->exceptionCallback($e, $cb);
        }

        return $this->responseCallback($resp, $cb);
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
}
