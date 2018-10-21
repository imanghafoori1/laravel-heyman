<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\ChainManager;

trait BeforeReaction
{
    public function afterCalling($callback, array $parameters = []): self
    {
        resolve(ChainManager::class)->push('beforeReaction', [[$callback, $parameters], 'cb']);

        return $this;
    }

    public function afterFiringEvent($event, $payload = [], $halt = false): self
    {
        resolve(ChainManager::class)->push('beforeReaction', [[$event, $payload, $halt], 'event']);

        return $this;
    }
}
