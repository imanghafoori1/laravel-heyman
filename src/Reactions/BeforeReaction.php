<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\Chain;

trait BeforeReaction
{
    public function afterCalling($callback, array $parameters = []): self
    {
        resolve(Chain::class)->addCallbackBeforeReaction($callback, $parameters);

        return $this;
    }

    public function afterFiringEvent($event, $payload = [], $halt = false): self
    {
        resolve(Chain::class)->addEventBeforeReaction($event, $payload, $halt);

        return $this;
    }
}