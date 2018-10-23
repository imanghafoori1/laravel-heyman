<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\ChainManager;

trait BeforeReaction
{
    public function afterCalling($callback, array $parameters = []): self
    {
        return $this->pushIt([[$callback, $parameters], 'cb']);
    }

    public function afterFiringEvent($event, $payload = [], $halt = false): self
    {
        return $this->pushIt([[$event, $payload, $halt], 'event']);
    }

    private function pushIt($arr)
    {
        resolve(ChainManager::class)->push('beforeReaction', $arr);
        return $this;
    }
}
