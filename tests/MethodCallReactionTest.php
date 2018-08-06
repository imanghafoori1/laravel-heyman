<?php

use Illuminate\Support\Facades\Gate;
use Imanghafoori\HeyMan\Facades\HeyMan;

class MethodCallReactionTest extends TestCase
{
    public function testCallingMethodsOnClasses()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');
        Gate::shouldReceive('allows')->with('heyman.youShouldHaveRole', ['reader'])->andReturn(false);

        \Facades\Logger::shouldReceive('info')->once()->with('sss');

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])
            ->youShouldHaveRole('reader')
            ->otherwise()
            ->afterCalling('Logger@info', ['sss'])
            ->weDenyAccess();

        $this->get('welcome');
    }

    public function testCallingClosures()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');
        Gate::shouldReceive('allows')->with('heyman.youShouldHaveRole', ['reader'])->andReturn(false);

        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('You have Called me');

        $cb = function () {
            throw new \Exception('You have Called me');
        };

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])
            ->youShouldHaveRole('reader')
            ->otherwise()
            ->afterCalling($cb)
            ->weDenyAccess();

        $this->get('welcome');
    }
}
