<?php

class ResponderTest extends TestCase
{
    public function testRedirectToIntended()
    {
        $methods = [
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
            $reaction = new \Imanghafoori\HeyMan\Actions();
            \Imanghafoori\HeyMan\Facades\HeyMan::shouldReceive('startListening')->once()->with([[$method, [$param]]], null, []);

            $reaction->response()->{$method}($param);
        }
    }

    public function _testRedirectToIntended222()
    {
        $methods = [
            'redirectToIntended',
        ];
        foreach ($methods as $method) {
            $param = str_random(3);
            $responder = new \Imanghafoori\HeyMan\Redirector();
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
            'intended',
            'action',
            'route',
            'guest',
            'to'
        ];

        foreach ($methods2 as $method2) {
            foreach ($methods as $method) {
                $param = str_random(3);
                $reaction = new \Imanghafoori\HeyMan\Actions();
                \Imanghafoori\HeyMan\Facades\HeyMan::shouldReceive('startListening')->once()->with([], null,[
                    [$method, [$param]],
                    [$method2, [['key', 'value']]],
                    ['with', [['a', 'b']]],
                ]);

                $reaction->redirect()->{$method}($param)->{$method2}(['key', 'value'])->with(['a', 'b'])
                ;
            }
        }
    }
}
