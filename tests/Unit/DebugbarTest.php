<?php

namespace Imanghafoori\HeyManTests\Unit;

use Illuminate\Support\Facades\Route;
use Imanghafoori\HeyMan\StartGuarding;
use Imanghafoori\HeyManTests\TestCase;
use Imanghafoori\HeyMan\Facades\HeyMan;

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
