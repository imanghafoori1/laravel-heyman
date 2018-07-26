<?php

use Imanghafoori\HeyMan\Facades\HeyMan;

class MethodCallTest extends TestCase
{
    public function testCallingMethodsOnClasses()
    {
        setUp::run();

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
        setUp::run();

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
