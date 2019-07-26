<?php

namespace Imanghafoori\HeyMan\Boot;

class DebugbarIntergrator
{
    public static function register()
    {
        if (! app()->offsetExists('debugbar')) {
            return;
        }

        app()->singleton('heyman.debugger', function () {
            return new \DebugBar\DataCollector\MessagesCollector('HeyMan');
        });

        app()->make('debugbar')->addCollector(app('heyman.debugger'));

        \Event::listen('heyman_reaction_is_happening', function (...$debug) {
            app()['heyman_reaction_is_happened_in_debug'] = $debug;
        });
    }
}
