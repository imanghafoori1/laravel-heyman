<?php

namespace Imanghafoori\HeyMan\Plugins\PreReaction;

use Imanghafoori\HeyMan\Core\Reaction;

final class PreReactions
{
    public function afterCalling($callback, array $parameters = [])
    {
        return $this->pushIt([[$callback, $parameters], 'cb']);
    }

    public function afterFiringEvent($event, $payload = [], $halt = false)
    {
        return $this->pushIt([[$event, $payload, $halt], 'event']);
    }

    private function pushIt($action)
    {
        resolve('heyman.chain')->push('beforeReaction', $action);

        return resolve(Reaction::class);
    }
}
