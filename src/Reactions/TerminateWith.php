<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\ChainManager;

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
        resolve(ChainManager::class)->set('termination', $callback);
    }
}
