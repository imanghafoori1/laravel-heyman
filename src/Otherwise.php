<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Reactions\Reactions;

class Otherwise
{

    public function otherwise(): Reactions
    {
        return app(Reactions::class);
    }
}
