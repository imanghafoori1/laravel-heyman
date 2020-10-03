<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\Routes;

use Imanghafoori\HeyMan\Contracts\ForgettableSituation;

class RouteUrlSituationProvider implements ForgettableSituation
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

    public function getMethods()
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
