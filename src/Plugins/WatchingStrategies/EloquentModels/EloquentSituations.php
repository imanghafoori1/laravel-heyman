<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\EloquentModels;

final class EloquentSituations
{
    protected $methods = [
        'whenYouFetch'  => 'retrieved',
        'whenYouCreate' => 'creating',
        'whenYouUpdate' => 'updating',
        'whenYouSave'   => 'saving',
        'whenYouDelete' => 'deleting',
    ];

    /**
     * @param $method
     * @param $model
     *
     * @return array
     */
    public function normalize($method, $model)
    {
        return [$model, $this->methods[$method]];
    }
}
