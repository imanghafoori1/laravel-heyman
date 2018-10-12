<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\EloquentModels;

use Imanghafoori\HeyMan\Situations\BaseSituation;

final class EloquentSituations extends BaseSituation
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
        $this->setManager(EloquentEventsManager::class, $model, self::methods[$method]);
    }
}
