<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Routes;

class RouteUrlSituationProvider
{
    public function getListener()
    {
        return RouteEventListener::class;
    }

    public function getSituationProvider()
    {
        return RouteUrlsNormalizer::class;
    }

    public function getForgetKey()
    {
        return 'routeChecks';
    }

    public function getMethods(): array
    {
        return [
            'whenYouVisitUrl',
            'whenYouSendGet',
            'whenYouSendPost',
            'whenYouSendPatch',
            'whenYouSendPut',
            'whenYouSendDelete',
        ];
    }

    public static function getForgetMethods()
    {
        return ['aboutUrl'];
    }

    public static function getForgetArgs($method, $args)
    {
        return  $args = [RouteEventListener::class, resolve(RouteUrlsNormalizer::class)->normalize('get', $args)];
    }
}
