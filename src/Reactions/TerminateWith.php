<?php

namespace Imanghafoori\HeyMan\Reactions;

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
        resolve('heyman.chain')->set('termination', $callback);
    }
}
