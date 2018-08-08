<?php

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Facades\HeyMan;

class MethodShouldAllowTest extends TestCase
{
    public function test_Method_Should_Allow()
    {
        \Facades\SomeClass::shouldReceive('someMethod')->once()->andReturn(false);
        HeyMan::whenYouMakeView('welcome')->thisMethodShouldAllow('SomeClass@someMethod')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function test_Closure_Should_Allow()
    {
        $cb = function () {
            return false;
        };

        HeyMan::whenYouMakeView('welcome')->thisClosureShouldAllow($cb)->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function test_Value_Should_Allow()
    {
        HeyMan::whenYouMakeView('welcome')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        $this->expectException(AuthorizationException::class);

        view('welcome');
    }
}
