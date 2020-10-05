<?php

namespace Imanghafoori\HeyManTests;

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;
use Imanghafoori\HeyManTests\Stubs\SomeClass;

class MethodShouldAllowTest extends TestCase
{
    public function test_Method_Should_Allow()
    {
        \Facades\Imanghafoori\HeyManTests\Stubs\SomeClass::shouldReceive('someMethod')->once()->andReturn(false);
        HeyMan::whenYouMakeView('welcome')->thisMethodShouldAllow(SomeClass::class.'@someMethod')->otherwise()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function test_Closure_Should_Allow()
    {
        $cb = function () {
            return false;
        };

        HeyMan::whenYouMakeView('welcome')->thisClosureShouldAllow($cb)->otherwise()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function test_Value_Should_Allow()
    {
        $value = false;

        HeyMan::whenYouMakeView('welcome')->thisValueShouldAllow($value)->otherwise()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        view('welcome');
    }
}
