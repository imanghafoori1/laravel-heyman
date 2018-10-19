<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\ChainManager;

trait BeforeReaction
{
    public function afterCalling($callback, array $parameters = []): self
    {
        resolve(ChainManager::class)->addCallbackBeforeReaction($callback, $parameters);

        return $this;
    }

    public function afterFiringEvent($event, $payload = [], $halt = false): self
    {
        resolve(ChainManager::class)->addEventBeforeReaction($event, $payload, $halt);

        return $this;
    }
}
