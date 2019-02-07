<?php

use Imanghafoori\HeyMan\StartGuarding;

class DebugbarTest extends TestCase
{
    public function testMessages()
    {
        app()->singleton('debugbar', function () {
        });

        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome')->always()->redirect()->to('home')->with('hi', 'jpp');
        app(StartGuarding::class)->start();
        $this->get('welcome')->assertRedirect('home')->assertSessionHas('hi');
    }
}
