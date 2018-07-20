<?php

use Illuminate\Support\Facades\Auth;
use Imanghafoori\HeyMan\Facades\HeyMan;

class YouShouldHaveTest
{
    public function testImmediately()
    {
        HeyMan::whenYouVisitUrl('sdf')->immediately();

        $predicate = app(\Imanghafoori\HeyMan\YouShouldHave::class)->predicate;

        $this->assertFalse($predicate());
    }

    public function testYouShouldBeLoggedIn()
    {
        HeyMan::whenYouVisitUrl('sdf')->youShouldBeLoggedIn();
        Auth::shouldReceive('check')->once()->andReturn('I do not know');

        $predicate = app(\Imanghafoori\HeyMan\YouShouldHave::class)->predicate;

        $this->assertEquals($predicate(), 'I do not know');
    }

    public function testYouShouldBeGuest()
    {
        HeyMan::whenYouVisitUrl('sdf')->youShouldBeGuest();
        Auth::shouldReceive('guest')->once()->andReturn('I do not know');

        $predicate = app(\Imanghafoori\HeyMan\YouShouldHave::class)->predicate;

        $this->assertEquals($predicate(), 'I do not know');
    }

    public function testThisValueShouldAllow()
    {
        HeyMan::whenYouVisitUrl('sdf')->thisValueShouldAllow('');

        $predicate = app(\Imanghafoori\HeyMan\YouShouldHave::class)->predicate;
        $this->assertTrue($predicate() === false);
    }

    public function testThisValueShouldAllow2()
    {
        HeyMan::whenYouVisitUrl('sdf')->thisValueShouldAllow('sss');

        $predicate = app(\Imanghafoori\HeyMan\YouShouldHave::class)->predicate;
        $this->assertTrue($predicate() === true);
    }

    public function testThisClosureShouldAllow()
    {
        $cb = function ($r) {
            return $r;
        };

        HeyMan::whenYouVisitUrl('sdf')->thisClosureShouldAllow($cb, ['ggg']);

        $predicate = app(\Imanghafoori\HeyMan\YouShouldHave::class)->predicate;

        $this->assertTrue($predicate() === true);
    }

    public function testThisClosureShouldAllow2()
    {
        $cb = function ($r) {
            return $r;
        };

        HeyMan::whenYouVisitUrl('sdf')->thisClosureShouldAllow($cb, ['']);

        $predicate = app(\Imanghafoori\HeyMan\YouShouldHave::class)->predicate;

        $this->assertTrue($predicate() === false);
    }

    public function testThisMethodShouldAllow()
    {
        HeyMan::whenYouVisitUrl('sdf')->thisMethodShouldAllow('SomeClass@someMethod', ['aaa']);

        \Facades\SomeClass::shouldReceive('someMethod')->once()->with('aaa')->andReturn(false);
        $predicate = app(\Imanghafoori\HeyMan\YouShouldHave::class)->predicate;

        $this->assertTrue($predicate() === false);
    }

    public function testSessionShouldHave()
    {
        HeyMan::whenYouVisitUrl('sdf')->sessionShouldHave('some_key');
        $val = str_random(2);
        \Illuminate\Support\Facades\Session::shouldReceive('has')->once()->with('some_key')->andReturn($val);
        $predicate = app(\Imanghafoori\HeyMan\YouShouldHave::class)->predicate;

        $this->assertTrue($predicate() === $val);
    }
}
