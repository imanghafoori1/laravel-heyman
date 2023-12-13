<?php

namespace Imanghafoori\HeyManTests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;
use Imanghafoori\HeyManTests\Stubs\HomeController;
use Imanghafoori\HeyManTests\Stubs\SomeClass;

class ReactionsTest extends TestCase
{
    public function test_redirect_with_flash_msg()
    {
        $this->withExceptionHandling();
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome')->always()->redirect()->to('home')->with('hi', 'jpp');
        app(StartGuarding::class)->start();

        $this->get('welcome')->assertRedirect('home')->assertSessionHas('hi');
    }

    public function test_redirect_with_flash_msg_and_event()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome')->always()->afterFiringEvent('explode')->redirect()->to('home')->with('key1', 'jpp');

        app(StartGuarding::class)->start();

        Event::fake();
        $this->get('welcome')->assertRedirect('home')->assertSessionHas('key1');
        Event::assertDispatched('explode');
    }

    public function test_redirect_with_errors()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');
        Auth::shouldReceive('guest')->andReturn(false);

        HeyMan::whenYouMakeView('welcome')->youShouldBeGuest()->otherwise()->redirect()->to('home')->withErrors('key_1', 'value_1');
        app(StartGuarding::class)->start();

        $this->get('welcome')->assertRedirect('home')->assertSessionHas('errors');
    }

    public function test_throwing_exceptions()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome')->always()->weThrowNew(\Illuminate\Auth\Access\AuthorizationException::class, 'abc');

        $this->withoutExceptionHandling();
        $this->expectException(\Illuminate\Auth\Access\AuthorizationException::class);
        $this->expectExceptionMessage('abc');
        app(StartGuarding::class)->start();

        $this->get('welcome');
    }

    public function test_json_response()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        Route::get('/welcome1', function () {
            return view('welcome');
        })->name('welcome1.name');

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])->always()->response()->json(['m'=> 'm'], 403);
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        app(StartGuarding::class)->start();

        $this->get('welcome')->assertJson(['m'=>'m'])->assertStatus(403);
        $this->get('welcome1')->assertStatus(200);
    }

    public function test_abort()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        Route::get('/welcome1', function () {
            return view('welcome');
        })->name('welcome1.name');
        HeyMan::aliasReaction('abort', 'willAbort');

        HeyMan::whenYouVisitUrl('welcome', 'asdfv')->always()->willAbort(405);
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        app(StartGuarding::class)->start();

        $this->get('welcome')->assertStatus(405);
        $this->get('welcome1')->assertStatus(200);
    }

    public function test_we_respond_from()
    {
        Route::get('/welcome', HomeController::class.'@index');

        HeyMan::whenYouVisitUrl('welcome')
            ->thisValueShouldAllow(false)
            ->otherwise()
            ->weRespondFrom(SomeClass::class.'@someMethod2', ['p1' => 20, 'p2' =>30]);
        app(StartGuarding::class)->start();

        $this->get('welcome')->assertStatus(566)->assertJson(['Wow'=> '50']);
    }

    public function test_we_respond_from_2()
    {
        Route::get('/welcome', HomeController::class.'@index');

        HeyMan::whenYouVisitUrl('welcome')
            ->thisValueShouldAllow(false)
            ->otherwise()
            ->weRespondFrom([SomeClass::class, 'someStaticMethod'], [20, 30]);

        app(StartGuarding::class)->start();

        $this->get('welcome')->assertStatus(201)->assertJson(['Wow'=> '50']);
    }

    public function test_we_respond_from_3()
    {
        Route::get('/welcome', HomeController::class.'@index');

        HeyMan::whenYouVisitUrl('welcome')
            ->thisValueShouldAllow(false)
            ->otherwise()
            ->weRespondFrom([SomeClass::class, 'someStaticMethod_2']);

        app(StartGuarding::class)->start();

        $this->get('welcome')->assertStatus(201)->assertJson(['Wow' => 'aaa']);
    }
}
