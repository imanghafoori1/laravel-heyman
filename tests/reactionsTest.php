<?php

use Imanghafoori\HeyMan\Facades\HeyMan;

class reactionsTest extends TestCase
{
    public function test_redirect_with_flash_msg()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome')->thisValueShouldAllow(false)->otherwise()->redirect()->to('home')->with('hi', 'jpp');

        $this->get('welcome')->assertRedirect('home')->assertSessionHas('hi');
    }

    public function test_redirect_with_flash_msg_and_event()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome')->thisValueShouldAllow(false)->otherwise()->afterFiringEvent('explode')->redirect()->to('home')->with('key1', 'jpp');

        $this->expectsEvents('explode');
        $this->get('welcome')->assertRedirect('home')->assertSessionHas('key1');
    }

    public function test_redirect_with_errors()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');
        Auth::shouldReceive('guest')->andReturn(false);

        HeyMan::whenYouMakeView('welcome')->youShouldBeGuest()->otherwise()->redirect()->to('home')->withErrors('key_1', 'value_1');

        $this->get('welcome')->assertRedirect('home')->assertSessionHas('errors');
    }

    public function test_throwing_exceptions()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome')->thisValueShouldAllow(false)->otherwise()->weThrowNew(\Illuminate\Auth\Access\AuthorizationException::class, 'abc');

        $this->withoutExceptionHandling();
        $this->expectException(\Illuminate\Auth\Access\AuthorizationException::class);
        $this->expectExceptionMessage('abc');

        $this->get('welcome');
    }

    public function test_json_response()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        Route::get('/welcome1', function () {
            return view('welcome');
        })->name('welcome1.name');

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])->thisValueShouldAllow(false)->otherwise()->response()->json(['m'=> 'm'], 403);
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        $this->get('welcome')->assertJson(['m'=>'m'])->assertStatus(403);
        $this->get('welcome1')->assertStatus(200);
    }

    public function test_abort()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        Route::get('/welcome1', function () {
            return view('welcome');
        })->name('welcome1.name');

        HeyMan::whenYouVisitUrl('welcome', 'asdfv')->thisValueShouldAllow(false)->otherwise()->abort(405);
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(405);
        $this->get('welcome1')->assertStatus(200);
    }
}
