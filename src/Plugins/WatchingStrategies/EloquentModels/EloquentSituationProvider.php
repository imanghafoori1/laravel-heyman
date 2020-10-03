<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\EloquentModels;

use Imanghafoori\HeyMan\Contracts\ForgettableSituation;

class EloquentSituationProvider implements ForgettableSituation
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

    public function getMethods()
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
