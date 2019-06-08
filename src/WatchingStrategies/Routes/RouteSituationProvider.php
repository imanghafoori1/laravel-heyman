<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Routes;

class RouteSituationProvider
{
    public function getListener()
    {
        return RouteEventListener::class;
    }

    public function getSituationProvider()
    {
        return RouteSituations::class;
    }

    public function getForgetKey()
    {
        return 'routeChecks';
    }

    /**
     * @return array
     */
    public function getMethods(): array
    {
        return [
            'whenYouVisitUrl',
            'whenYouSendPost',
            'whenYouSendPatch',
            'whenYouSendPut',
            'whenYouSendDelete',
            'whenYouCallAction',
            'whenYouHitRouteName',
        ];
    }
}
