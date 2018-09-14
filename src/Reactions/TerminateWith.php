<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\Chain;

class TerminateWith
{
    private $reaction;

    /**
     * Termination constructor.
     *
     * @param \Imanghafoori\HeyMan\Reactions\Reactions $reactions
     */
    public function __construct($reactions)
    {
        $this->reaction = $reactions;
    }

    public function terminateWith($callback)
    {
        resolve(Chain::class)->addTerminationCallback($callback);
    }
}
