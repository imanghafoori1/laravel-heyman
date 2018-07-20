<?php

class ResponderTest extends TestCase
{
    public function testView()
    {
        $responder = new \Imanghafoori\HeyMan\Responder();
        \Imanghafoori\HeyMan\Facades\HeyMan::shouldReceive('startListening')->once()->with(["view", ["welcome"]], null);

        $responder->view('welcome');
    }
}