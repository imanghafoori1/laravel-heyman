<?php

use Imanghafoori\HeyMan\Facades\HeyMan;

class OtherwiseTest extends TestCase
{
    public function testOtherwise()
    {
        setUp::run();
        HeyMan::whenYouVisitUrl('welcome')->youShouldHaveRole('reader')->otherwise()->redirect()->to('home')->with(['hi', 'jpp']);

        $this->get('welcome')->assertRedirect('home');
    }

    public function testAfterFiring()
    {
        setUp::run();
        HeyMan::whenYouVisitUrl('welcome')->youShouldHaveRole('reader')->otherwise()->afterFiringEvent('explode')->redirect()->to('home')->with(['hi', 'jpp']);

        $this->expectsEvents('explode');
        $this->get('welcome')->assertRedirect('home');
    }

    public function testOtherwise1()
    {
        setUp::run();
        HeyMan::whenYouMakeView('welcome')->youShouldBeGuest()->otherwise()->redirect()->to('home')->with(['sdf']);

        $this->get('welcome')->assertRedirect('home');
    }

    public function testOtherwise4()
    {
        setUp::run();
        HeyMan::whenYouVisitUrl('welcome')->youShouldHaveRole('writer')->otherwise()->weThrowNew(\Illuminate\Auth\Access\AuthorizationException::class);

        $this->get('welcome')->assertStatus(200);
    }

    public function testAbort()
    {
        setUp::run();

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])->youShouldHaveRole('reader')->otherwise()->response()->json(['m'=> 'm'], 403);
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertJson(['m'=>'m'])->assertStatus(403);
        $this->get('welcome1')->assertStatus(200);
    }

    public function testAbort1()
    {
        setUp::run();

        HeyMan::whenYouVisitUrl('welcome', 'asdfv')->youShouldHaveRole('reader')->otherwise()->abort(405);
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(405);
        $this->get('welcome1')->assertStatus(200);
    }
}
