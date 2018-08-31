<?php

namespace Imanghafoori\HeyMan\Situations;

use Imanghafoori\HeyMan\WatchingStrategies\EloquentEventsManager;

class EloquentSituations extends BaseSituation
{
    const methods = [
        'whenYouFetch'  => 'retrieved',
        'whenYouCreate' => 'creating',
        'whenYouUpdate' => 'updating',
        'whenYouSave'   => 'saving',
        'whenYouDelete' => 'deleting',
    ];

    public function hasMethod($method)
    {
        return array_key_exists($method, self::methods);
    }

    public function __call($method, $model)
    {
        $event = self::methods[$method];
        $this->chain->eventManager = resolve(EloquentEventsManager::class)->init($model, $event);
    }
}
