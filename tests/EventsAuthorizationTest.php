<?php

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\WatchingStrategies\EventManager;

class EventsAuthorizationTest extends TestCase
{
    public function testEventIsAuthorized1()
    {
        HeyMan::whenEventHappens(['myEvent', 'myEvent1'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenEventHappens('myEvent4')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        app(EventManager::class)->start();
        $this->expectException(AuthorizationException::class);

        event('myEvent1');
    }

    public function testEventIsAuthorized2()
    {
        HeyMan::whenEventHappens(['myEvent', 'myEvent1'])->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        HeyMan::whenEventHappens('myEvent4')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        app(EventManager::class)->start();
        $this->expectException(AuthorizationException::class);

        event('myEvent1');
    }

    public function testAlways()
    {
        Route::get('/event/{event}', function ($event) {
            event($event);
        });

        HeyMan::whenEventHappens(['my-event', 'myEvent1'])->youShouldAlways()->abort(402);
        app(EventManager::class)->start();
        $this->get('event/my-event')->assertStatus(402);
    }

    public function testAlways1()
    {
        Route::get('/event/{event}', function ($event) {
            event($event);
        });

        HeyMan::whenEventHappens(['my-event', 'myEvent1'])->youShouldAlways()->redirect()->to('welcome');
        app(EventManager::class)->start();
        $this->get('event/my-event')->assertStatus(302)->assertRedirect('welcome');
    }
}
