<?php

namespace Imanghafoori\HeyMan;

class ListenerFactory
{
    /**
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
     * @return \Closure
     */
    private function exceptionCallback($e, $cb): \Closure
    {
        return function () use ($e, $cb) {
            if (! $cb()) {
                throw $e;
            }
        };
    }

    /**
     * @param $resp
     * @param $cb
     * @return \Closure
     */
    private function responseCallback($resp, $cb): \Closure
    {
        return function () use ($resp, $cb) {
            if (! $cb()) {
                list($method, $args) = $resp;
                respondWith(response()->{$method}(...$args));
            }
        };
    }
}