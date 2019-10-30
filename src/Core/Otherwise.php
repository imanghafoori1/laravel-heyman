<?php

namespace Imanghafoori\HeyMan\Core;

final class Otherwise
{
    /**
     * @return \Imanghafoori\HeyMan\Reactions\Reactions
     */
    public function otherwise()
    {
        return resolve(Reaction::class);
    }
}
