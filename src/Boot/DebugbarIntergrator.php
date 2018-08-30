<?php

namespace Imanghafoori\HeyMan\Boot;

class DebugbarIntergrator
{
    public static function register($app)
    {
        if (!$app->offsetExists('debugbar')) {
            return;
        }

        $app->singleton('heyman.debugger', function () {
            return new \DebugBar\DataCollector\MessagesCollector('HeyMan');
        });

        $app->make('debugbar')->addCollector(app('heyman.debugger'));

        \Event::listen('heyman_reaction_is_happening', function (...$debug) {
            app('heyman.debugger')->addMessage('HeyMan Rule Matched in file: '.$debug[0]);
            app('heyman.debugger')->addMessage('on line: '.$debug[1]);
            app('heyman.debugger')->addMessage($debug[2]);
        });
    }
}
