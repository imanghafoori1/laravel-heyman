<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\EloquentModels;

class EloquentSituationProvider
{
    public function getListener()
    {
        return EloquentEventsListener::class;
    }

    public function getSituationProvider()
    {
        return EloquentSituations::class;
    }

    public function getForgetKey()
    {
        return 'eloquentChecks';
    }

    public function getMethods(): array
    {
        return [
            'whenYouFetch',
            'whenYouCreate',
            'whenYouUpdate',
            'whenYouSave',
            'whenYouDelete',
        ];
    }
}
