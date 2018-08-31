<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Reactions\Reactions;

class Otherwise
{
    public function otherwise(): Reactions
    {
        return resolve(Reactions::class);
    }
}
