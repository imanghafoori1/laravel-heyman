<?php

namespace Imanghafoori\HeyMan\Reactions;

class Then
{
    private $reaction;

    /**
     * Termination constructor.
     *
     * @param \Imanghafoori\HeyMan\Reactions\Reactions $reactions
     */
    public function __construct(Reactions $reactions)
    {
        $this->reaction = $reactions;
    }

    public function then()
    {
        return new TerminateWith($this->reaction);
    }
}
