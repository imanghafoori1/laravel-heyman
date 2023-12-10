<?php

namespace Imanghafoori\HeyMan\Reactions;

class Then
{
    private $reaction;

    /**
     * Termination constructor.
     *
     * @param  \Imanghafoori\HeyMan\Plugins\PreReaction\PreReactions  $reactions
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
