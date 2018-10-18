<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Reactions\Reactions;

final class Otherwise
{
    /**
     * @return \Imanghafoori\HeyMan\Reactions\Reactions
     */
    public function otherwise(): Reactions
    {
        return resolve(Reactions::class);
    }
}
