<?php

namespace Imanghafoori\HeyManTests;

use Imanghafoori\HeyMan\Core\Chain;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Imanghafoori\HeyMan\StartGuarding;
use Imanghafoori\HeyMan\Facades\HeyMan;

class Logger
{
    public function info()
    {
    }

    public function error()
    {
    }
}
class MethodCallReactionTest extends TestCase
{
    public function testCallingMethodsOnClasses()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        \Facades\Imanghafoori\HeyManTests\Logger::shouldReceive('error')->once()->with('sss');
        \Facades\Imanghafoori\HeyManTests\Logger::shouldReceive('info')->times(0);

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])
            ->thisValueShouldAllow(true)
            ->otherwise()
            ->afterCalling(\Imanghafoori\HeyManTests\Logger::class.'@info', ['sss'])
            ->weDenyAccess();

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])
            ->always()
            ->afterCalling(\Imanghafoori\HeyManTests\Logger::class.'@error', ['sss'])
            ->weDenyAccess();

        app(StartGuarding::class)->start();

        $this->get('welcome');
    }

    public function testCallingClosures()
    {
        Route::get('/welcome/{id}/{foo}', 'HomeController@index')->name('welcome.name');
        Gate::shouldReceive('allows')->andReturn(false);

        $t = '';
        $cb = function () use (&$t) {
            $t = $t.'sss';
        };

        HeyMan::whenYouHitRouteName(['welcome', 'welcome.name'])
            ->youShouldHaveRole('reader')
            ->otherwise()
            ->afterCalling($cb)
            ->weDenyAccess();

        $chain = resolve(Chain::class);
        $chain->startChain();
        $this->assertEquals(null, $chain->get('data'));
        $this->assertEquals(null, $chain->get('responseType'));

        app(StartGuarding::class)->start();

        $this->get('welcome/a/b');
        $this->assertEquals($t, 'sss');
    }
}
