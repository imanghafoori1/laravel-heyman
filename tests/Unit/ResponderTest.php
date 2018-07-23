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
            \Imanghafoori\HeyMan\Facades\HeyMan::shouldReceive('startListening')->once()->with([[$method, [$param]]], null);

            $responder->{$method}($param);
        }
    }

    public function testRedirectToIntended222()
    {
        $methods = [
            'redirectToIntended',

        ];
        foreach ($methods as $method) {
            $param = str_random(3);
            $responder = new \Imanghafoori\HeyMan\Responder();
            \Imanghafoori\HeyMan\Facades\HeyMan::shouldReceive('startListening')->once()->with([[$method, [$param]]], null);

            $responder->{$method}($param);
        }
    }

    public function testRedirectWith()
    {
        $methods2 = [
            'with',
            'withCookies',
            'withInput',
            'onlyInput',
            'exceptInput',
            'withErrors',
        ];

        $methods = [
            'redirectToIntended',
            'redirectToAction',
            'redirectToRoute',
            'redirectGuest',
        ];

        foreach ($methods2 as $method2) {
            foreach ($methods as $method) {
                $param = str_random(3);
                $responder = new \Imanghafoori\HeyMan\Responder();
                \Imanghafoori\HeyMan\Facades\HeyMan::shouldReceive('startListening')->once()->with([
                    [$method, [$param]],
                    [$method2, [['key', 'value']]],
                    ['with', [['a', 'b']]],
                ], null);

                $responder->{$method}($param)->{$method2}(['key', 'value'])->with(['a', 'b']);
            }
        }
    }

}
