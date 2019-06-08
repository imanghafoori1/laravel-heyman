<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\EloquentModels;

final class EloquentSituations
{
    public $listener = EloquentEventsListener::class;

    protected $methods = [
        'whenYouFetch'  => 'retrieved',
        'whenYouCreate' => 'creating',
        'whenYouUpdate' => 'updating',
        'whenYouSave'   => 'saving',
        'whenYouDelete' => 'deleting',
    ];

    public function hasMethod($method)
    {
        return array_key_exists($method, $this->methods);
    }

    public function __call($method, $model)
    {
        resolve('heyman.chains')->init($this->listener, $model, $this->methods[$method]);
    }
}
