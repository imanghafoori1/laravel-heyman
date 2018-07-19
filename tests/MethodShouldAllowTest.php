<?php

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Facades\HeyMan;

class MethodShouldAllowTest extends TestCase
{
    public function testMethodShouldAllow()
    {
        setUp::run($this);

        HeyMan::whenYouViewBlade('welcome')->thisMethodShouldAllow('SomeClass@someMethod')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testClosureShouldAllow()
    {
        setUp::run($this);

        $cb = function () {
            return false;
        };

        HeyMan::whenYouViewBlade('welcome')->thisClosureShouldAllow($cb)->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testValueShouldAllow()
    {
        setUp::run($this);
        HeyMan::whenYouViewBlade('welcome')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        $this->expectException(AuthorizationException::class);

        view('welcome');
    }
}