<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\EloquentModels;

final class EloquentSituations
{
    protected static $methods = [
        'whenYouFetch'  => 'retrieved',
        'whenYouCreate' => 'creating',
        'whenYouUpdate' => 'updating',
        'whenYouSave'   => 'saving',
        'whenYouDelete' => 'deleting',
    ];

    public function hasMethod($method)
    {
        return array_key_exists($method, self::$methods);
    }

    public function __call($method, $model)
    {
        resolve('heyman.chains')->init(EloquentEventsListener::class, $model, self::$methods[$method]);
    }
}
