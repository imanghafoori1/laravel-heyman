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

    public static function getForgetMethods()
    {
        return ['aboutFetching', 'aboutSaving', 'aboutModel', 'aboutDeleting', 'aboutCreating', 'aboutUpdating'];
    }

    public static function getForgetArgs($method, $args)
    {
        $method = ltrim($method, 'about');
        $method = str_replace('Fetching', 'retrieved', $method);
        $method = strtolower($method);
        $method = $method == 'model' ? null : $method;

        return [EloquentEventsListener::class, $args, $method];
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
