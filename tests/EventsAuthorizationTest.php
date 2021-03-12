<?php

namespace Imanghafoori\HeyManTests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Route;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\Plugins\WatchingStrategies\Events\EventSituationProvider;
use Imanghafoori\HeyMan\StartGuarding;
use Imanghafoori\MakeSure\Facades\MakeSure;

class EventsAuthorizationTest extends TestCase
{
    public function testEventIsAuthorized1()
    {
        HeyMan::whenEventHappens('myEvent1')->thisValueShouldAllow(true)->otherwise()->redirect()->to('/11');
        HeyMan::whenEventHappens(['myEvent', 'myEvent1'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        app(StartGuarding::class)->start();

        MakeSure::about($this)->whenEventHappens('myEvent1')->exceptionIsThrown(AuthorizationException::class);
    }

    public function testEventIsAuthorized2()
    {
        HeyMan::whenEventHappens(['myEvent', 'myEvent1'])->always()->weDenyAccess();
        HeyMan::whenEventHappens('myEvent4')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        event('myEvent1');
    }

    public function test_Event_Is_forgotten()
    {
        HeyMan::whenEventHappens(['myEvent', 'myEvent1'])->always()->weDenyAccess();
        HeyMan::whenEventHappens('myEvent4')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenEventHappens('myEvent4')->thisValueShouldAllow(true)->otherwise()->weThrowNew(\Illuminate\Validation\UnauthorizedException::class);

        $this->assertEquals(3, count(resolve('heyman.chains')->data[resolve(EventSituationProvider::class)->getListener()]));

        HeyMan::forget()->aboutEvent(['myEvent', 'myEvent1', 'myEvent4']);

        $this->assertEmpty(resolve('heyman.chains')->data[resolve(EventSituationProvider::class)->getListener()]);

        app(StartGuarding::class)->start();

        event('myEvent');
        event('myEvent1');
        event('myEvent4');
        $this->assertTrue(true);
    }

    public function test_Event_Is_forgotten2()
    {
        HeyMan::whenEventHappens(['myEvent', 'myEvent1'])->always()->weDenyAccess();
        HeyMan::whenEventHappens('myEvent4')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenEventHappens('myEvent4')->thisValueShouldAllow(true)->otherwise()
            ->weThrowNew(\Illuminate\Validation\UnauthorizedException::class);

        $this->assertEquals(3, count(resolve('heyman.chains')->data[resolve(EventSituationProvider::class)->getListener()]));

        HeyMan::forget()->aboutEvent('myEvent4');

        $this->assertEquals(2, count(resolve('heyman.chains')->data[resolve(EventSituationProvider::class)->getListener()]));

        app(StartGuarding::class)->start();

        event('myEvent4');
        app()->terminate();

        $this->assertTrue(true);
    }

    public function testAlways()
    {
        Route::get('/event/{event}', function ($event) {
            event($event);
        });

        HeyMan::whenEventHappens(['my-event', 'myEvent1'])->always()->abort(402);
        app(StartGuarding::class)->start();

        MakeSure::about($this)
            ->sendingGetRequest('event/my-event')
            ->isRespondedWith()
            ->statusCode(402);
    }

    public function testAlways1()
    {
        Route::get('/event/{event}', function ($event) {
            event($event);
        });

        HeyMan::whenEventHappens(['my-event', 'myEvent1'])->always()->redirect()->to('welcome');
        app(StartGuarding::class)->start();

        MakeSure::about($this)
            ->sendingGetRequest('event/my-event')
            ->isRespondedWith()
            ->redirect('/welcome', 302);
    }

    public function testCheckPoints()
    {
        Heyman::whenYouReachCheckPoint('*AreYou')->always()->redirect()->to('welcome');
        app(StartGuarding::class)->start();

        \Route::get('oh', function () {
            Heyman::checkPoint('whoAreYou');
        });

        MakeSure::about($this)
            ->sendingGetRequest('oh')
            ->isRespondedWith()
            ->redirect('/welcome', 302);
    }

    public function test_checkPoint()
    {
        $this->expectsEvents('heyman_checkpoint_wow');
        Heyman::checkPoint('wow');
    }
}
