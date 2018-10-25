<?php

use Illuminate\Support\Facades\Gate;
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

        \Facades\Logger::shouldReceive('error')->once()->with('sss');
        \Facades\Logger::shouldReceive('info')->times(0);

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])
            ->thisValueShouldAllow(true)
            ->otherwise()
            ->afterCalling('Logger@info', ['sss'])
            ->weDenyAccess();

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])
            ->always()
            ->afterCalling('Logger@error', ['sss'])
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

        $chain = resolve(\Imanghafoori\HeyMan\Chain::class);
        $chain->startChain();
        $this->assertEquals(null, $chain->get('data'));
        $this->assertEquals(null, $chain->get('responseType'));

        $this->get('welcome');
    }
}
