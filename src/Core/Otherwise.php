<?php

namespace Imanghafoori\HeyMan\Core;

use Imanghafoori\HeyMan\Reactions\Reactions;

final class Otherwise
{
    public function otherwise(): Reactions
    {
        return resolve(Reactions::class);
    }
}
