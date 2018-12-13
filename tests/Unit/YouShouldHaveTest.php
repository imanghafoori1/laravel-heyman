<?php

use Illuminate\Support\Facades\Auth;
use Imanghafoori\HeyMan\Facades\HeyMan;

class YouShouldHaveTest extends TestCase
{
    public function testImmediately()
    {
        $keepAlive = HeyMan::whenYouVisitUrl('sdf')->always();

        $condition = app(\Imanghafoori\HeyMan\Chain::class)->get('condition');

        $this->assertFalse($condition());
        $keepAlive;
    }

    public function testYouShouldBeLoggedIn()
    {
        HeyMan::whenYouVisitUrl('sdf')->youShouldBeLoggedIn();
        Auth::shouldReceive('check')->once()->andReturn('I do not know');

        $condition = app(\Imanghafoori\HeyMan\Chain::class)->get('condition');

        $this->assertEquals($condition(), 'I do not know');
    }

    public function testYouShouldBeGuest()
    {
        HeyMan::whenYouVisitUrl('sdf')->youShouldBeGuest();
        Auth::shouldReceive('guest')->once()->andReturn('I do not know');

        $condition = app(\Imanghafoori\HeyMan\Chain::class)->get('condition');

        $this->assertEquals($condition(), 'I do not know');
    }

    public function testThisValueShouldAllow()
    {
        HeyMan::whenYouVisitUrl('sdf')->thisValueShouldAllow('');

        $condition = app(\Imanghafoori\HeyMan\Chain::class)->get('condition');
        $this->assertTrue($condition() === false);
    }

    public function testThisValueShouldAllow2()
    {
        HeyMan::whenYouVisitUrl('sdf')->thisValueShouldAllow('sss');

        $condition = app(\Imanghafoori\HeyMan\Chain::class)->get('condition');
        $this->assertTrue($condition() === true);
    }

    public function testThisClosureShouldAllow()
    {
        $cb = function ($r) {
            return $r;
        };

        HeyMan::whenYouVisitUrl('sdf')->thisClosureShouldAllow($cb, ['ggg']);

        $condition = app(\Imanghafoori\HeyMan\Chain::class)->get('condition');

        $this->assertTrue($condition() === true);
    }

    public function testThisClosureShouldAllow2()
    {
        $cb = function ($r) {
            return $r;
        };

        HeyMan::whenYouVisitUrl('sdf')->thisClosureShouldAllow($cb, ['']);

        $condition = app(\Imanghafoori\HeyMan\Chain::class)->get('condition');

        $this->assertTrue($condition() === false);
    }

    public function testThisMethodShouldAllow()
    {
        HeyMan::whenYouVisitUrl('sdf')->thisMethodShouldAllow('SomeClass@someMethod', ['aaa']);

        \Facades\SomeClass::shouldReceive('someMethod')->once()->with('aaa')->andReturn(false);
        $condition = app(\Imanghafoori\HeyMan\Chain::class)->get('condition');

        $this->assertTrue($condition() === false);
    }

    public function testSessionShouldHave()
    {
        HeyMan::whenYouVisitUrl('sdf')->sessionShouldHave('some_key');
        $val = str_random(2);
        \Illuminate\Support\Facades\Session::shouldReceive('has')->once()->with('some_key')->andReturn($val);
        $condition = app(\Imanghafoori\HeyMan\Chain::class)->get('condition');

        $this->assertTrue($condition() === $val);
    }

    public function testCustomConditions()
    {
        HeyMan::condition('youShouldBeNice', function () {
            return function ($mood) {
                return $mood == 'nice';
            };
        });

        HeyMan::whenYouVisitUrl('sdf')->youShouldBeNice();

        $condition = app(\Imanghafoori\HeyMan\Chain::class)->get('condition');
        $this->assertTrue($condition('nice') === true);

        $condition = app(\Imanghafoori\HeyMan\Chain::class)->get('condition');
        $this->assertTrue($condition('evil') === false);
    }
}
