<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\Routes;

class RouteActionProvider
{
    public function getListener()
    {
        return RouteEventListener::class;
    }

    public function getSituationProvider()
    {
        return RouteActionNormalizer::class;
    }

    public function getForgetKey()
    {
        return 'routeChecks';
    }

    public function getMethods()
    {
        return [
            'whenYouCallAction',
        ];
    }

    public static function getForgetMethods()
    {
        return ['aboutAction'];
    }

    public static function getForgetArgs($method, $args)
    {
        return  $args = [RouteEventListener::class, resolve(RouteActionNormalizer::class)->normalize('get', $args)];
    }
}
