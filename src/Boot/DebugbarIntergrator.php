<?php

namespace Imanghafoori\HeyMan\Boot;

use Illuminate\Support\Facades\Event;
use DebugBar\DataCollector\MessagesCollector;

class DebugbarIntergrator
{
    public static function register()
    {
        if (! app()->offsetExists('debugbar')) {
            return;
        }

        app()->singleton('heyman.debugger', function () {
            return new MessagesCollector('HeyMan');
        });

        app()->make('debugbar')->addCollector(app('heyman.debugger'));

        Event::listen('heyman_reaction_is_happening', function (...$debug) {
            app()['heyman_reaction_is_happened_in_debug'] = $debug;
            resolve('heyman.debugger')->addMessage('HeyMan Rule Matched in file: ');
            resolve('heyman.debugger')->addMessage($debug[0].' on line: '.$debug[1]);
            resolve('heyman.debugger')->addMessage($debug[2]);
        });
    }
}
