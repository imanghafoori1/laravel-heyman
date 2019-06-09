<?php

namespace Imanghafoori\HeyManTests;

use Illuminate\Support\Facades\Route;
use Imanghafoori\HeyMan\StartGuarding;
use Imanghafoori\HeyMan\Facades\HeyMan;

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
        $this->expectsEvents('terminated_well');

        app(StartGuarding::class)->start();
        $this->put('put')->assertExactJson(['hello' => 'bye'])->assertStatus(301);
    }
}
