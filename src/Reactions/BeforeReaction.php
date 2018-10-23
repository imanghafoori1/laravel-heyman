<?php

namespace Imanghafoori\HeyMan\Reactions;

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
        resolve('heyman.chain')->push('beforeReaction', $arr);

        return $this;
    }
}
