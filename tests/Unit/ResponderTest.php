<?php

class ResponderTest extends TestCase
{
    public function testView()
    {
        $responder = new \Imanghafoori\HeyMan\Responder();
        \Imanghafoori\HeyMan\Facades\HeyMan::shouldReceive('startListening')->once()->with(["view", ["welcome"]], null);

        $responder->view('welcome');
    }

    public function testjsonp()
    {
        $responder = new \Imanghafoori\HeyMan\Responder();
        \Imanghafoori\HeyMan\Facades\HeyMan::shouldReceive('startListening')->once()->with(["jsonp", ["welcome"]], null);

        $responder->jsonp('welcome');
    }

    public function testdownload()
    {
        $responder = new \Imanghafoori\HeyMan\Responder();
        \Imanghafoori\HeyMan\Facades\HeyMan::shouldReceive('startListening')->once()->with(["download", ["welcome"]], null);

        $responder->download('welcome');
    }

    public function tesJson()
    {
        $responder = new \Imanghafoori\HeyMan\Responder();
        \Imanghafoori\HeyMan\Facades\HeyMan::shouldReceive('startListening')->once()->with(["json", ["welcome"]], null);

        $responder->json('welcome');
    }

    public function testStream()
    {
        $responder = new \Imanghafoori\HeyMan\Responder();
        \Imanghafoori\HeyMan\Facades\HeyMan::shouldReceive('startListening')->once()->with(["stream", ["welcome"]], null);

        $responder->stream('welcome');
    }

    public function testRedirectToIntended()
    {
        $methods = ['redirectToIntended', 'redirectToAction', 'redirectToRoute', 'redirectGuest'];
        foreach ($methods as $method) {
            $param = str_random(3);
            $responder = new \Imanghafoori\HeyMan\Responder();
            \Imanghafoori\HeyMan\Facades\HeyMan::shouldReceive('startListening')->once()->with([$method, [$param]], null);

            $responder->{$method}($param);
        }
    }
}