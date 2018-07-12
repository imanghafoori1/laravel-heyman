<?php

namespace Imanghafoori\HeyMan;

class Responder
{
    public function redirectTo($url)
    {
        $predicate = app('hey_man_you_should_have')->predicate;

        $callbackListener = function () use ($predicate, $url) {
            if ($predicate()) {
                respondWith(redirect()->to($url));
            }
        };
        app('hey_man')->authorizer->startGuarding($callbackListener);
    }
}