<?php

namespace Imanghafoori\HeyMan\Core;

final class Otherwise
{
    /**
     * @return \Imanghafoori\HeyMan\Plugins\PreReaction\PreReactions
     */
    public function otherwise()
    {
        return resolve(Reaction::class);
    }
}
