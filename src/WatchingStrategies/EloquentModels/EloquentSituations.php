<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\EloquentModels;

final class EloquentSituations
{
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

    /**
     * @param $method
     * @param $model
     *
     * @return array
     */
    public function normalize($method, $model): array
    {
        return [$model, $this->methods[$method]];
    }
}
