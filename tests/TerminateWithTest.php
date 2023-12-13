<?php

namespace Imanghafoori\HeyManTests;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;

class TerminateWithTest extends TestCase
{
    public function testPutUrls()
    {
        Route::put('/put', function () {
        });

        HeyMan::whenYouSendPut('put')->always()->response()->json(['hello' => 'bye'], 301)
            ->then()
            ->terminateWith(function () {
                event('terminated_well');
            });

        Event::fake();
        app(StartGuarding::class)->start();
        $this->put('put')->assertExactJson(['hello' => 'bye'])->assertStatus(301);
        Event::assertDispatched('terminated_well');
    }
}
