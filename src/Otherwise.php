<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Reactions\Reactions;

class Otherwise
{
    public function otherwise(): Reactions
    {
        $callSite = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1)[0];
        app(Chain::class)->debugInfo = array_only($callSite, ['line', 'file']);

        return app(Reactions::class);
    }
}
