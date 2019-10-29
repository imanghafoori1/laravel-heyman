<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Routes;

class RouteNameSituation
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

    /**
     * @return array
     */
    public function getMethods(): array
    {
        return [
            'whenYouHitRouteName',
        ];
    }
}
