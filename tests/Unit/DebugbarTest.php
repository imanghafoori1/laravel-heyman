<?php

namespace Imanghafoori\HeyManTests\Unit;

use Illuminate\Support\Facades\Route;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;
use Imanghafoori\HeyManTests\Stubs\HomeController;
use Imanghafoori\HeyManTests\TestCase;

class DebugbarTest extends TestCase
{
    public function testMessages()
    {
        app()->singleton('debugbar', function () {
        });

        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome')->always()->redirect()->to('home')->with('hi', 'jpp');
        app(StartGuarding::class)->start();
        $this->get('welcome')->assertRedirect('home')->assertSessionHas('hi');
    }
}
