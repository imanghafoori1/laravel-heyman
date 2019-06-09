<?php

namespace Imanghafoori\HeyManTests;

use Imanghafoori\HeyMan\StartGuarding;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyManTests\Stubs\SomeClass;
use Illuminate\Auth\Access\AuthorizationException;

class ConditionsAliasingTest extends TestCase
{
    public function test_Method_Should_Allow()
    {
        \Facades\Imanghafoori\HeyManTests\Stubs\SomeClass::shouldReceive('someMethod')->once()->andReturn(false);
        HeyMan::aliasCondition('thisMethodShouldAllow', 'method');
        HeyMan::whenYouMakeView('welcome')->method(SomeClass::class.'@someMethod')->otherwise()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function test_Closure_Should_Allow()
    {
        $cb = function () {
            return false;
        };
        HeyMan::aliasCondition('thisClosureShouldAllow', 'method');
        HeyMan::whenYouMakeView('welcome')->method($cb)->otherwise()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        view('welcome');
    }
}
