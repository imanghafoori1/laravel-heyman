<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\Routes;

class RouteNameSituationProvider
{
    public function getListener()
    {
        return RouteEventListener::class;
    }

    public function getSituationProvider()
    {
        return RouteNameNormalizer::class;
    }

    public function getForgetKey()
    {
        return 'routeChecks';
    }

    public function getMethods()
    {
        return [
            'whenYouHitRouteName',
        ];
    }

    public static function getForgetMethods()
    {
        return ['aboutRoute'];
    }

    public static function getForgetArgs($method, $args)
    {
        return  $args = [RouteEventListener::class, resolve(RouteNameNormalizer::class)->normalize('get', $args)];
    }
}
