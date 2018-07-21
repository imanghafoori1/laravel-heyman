<?php

class ResponderTest extends TestCase
{
    public function testRedirectToIntended()
    {
        $methods = [
            'redirectToIntended',
            'redirectToAction',
            'redirectToRoute',
            'redirectGuest',
            'stream',
            'streamDownload',
            'view',
            'make',
            'json',
            'jsonp',
            'download',
        ];
        foreach ($methods as $method) {
            $param = str_random(3);
            $responder = new \Imanghafoori\HeyMan\Responder();
            \Imanghafoori\HeyMan\Facades\HeyMan::shouldReceive('startListening')->once()->with([$method, [$param]], null);

            $responder->{$method}($param);
        }
    }
}
