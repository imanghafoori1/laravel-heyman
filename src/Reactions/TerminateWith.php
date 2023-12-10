<?php

namespace Imanghafoori\HeyMan\Reactions;

class TerminateWith
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

    public function terminateWith($callback)
    {
        resolve('heyman.chain')->set('termination', $callback);
    }
}
