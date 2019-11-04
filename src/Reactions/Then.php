<?php

namespace Imanghafoori\HeyMan\Reactions;

class Then
{
    private $reaction;

    /**
     * Termination constructor.
     *
     * @param \Imanghafoori\HeyMan\Reactions\PreReactions $reactions
     */
    public function __construct($reactions)
    {
        $this->reaction = $reactions;
    }

    public function then()
    {
        return new TerminateWith($this->reaction);
    }
}
