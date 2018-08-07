<?php

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Facades\HeyMan;

class MethodShouldAllowTest extends TestCase
{
    public function testMethodShouldAllow()
    {
        HeyMan::whenYouMakeView('welcome')->thisMethodShouldAllow('SomeClass@someMethod')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testClosureShouldAllow()
    {
        $cb = function () {
            return false;
        };

        HeyMan::whenYouMakeView('welcome')->thisClosureShouldAllow($cb)->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testValueShouldAllow()
    {
        HeyMan::whenYouMakeView('welcome')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        $this->expectException(AuthorizationException::class);

        view('welcome');
    }
}
