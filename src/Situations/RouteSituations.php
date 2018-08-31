<?php

namespace Imanghafoori\HeyMan\Situations;

use Imanghafoori\HeyMan\Normilizers\RouteNormalizer;
use Imanghafoori\HeyMan\WatchingStrategies\RouterEventManager;

class RouteSituations extends BaseSituation
{
    public function hasMethod($method)
    {
        return in_array($method, [
            'whenYouVisitUrl',
            'whenYouSendPost',
            'whenYouSendPatch',
            'whenYouSendPut',
            'whenYouSendDelete',
            'whenYouCallAction',
            'whenYouHitRouteName',
        ]);
    }

    public function __call($method, $args)
    {
        $method = str_replace('whenYou', '', $method);
        $args = $this->getNormalizedArgs($method, $args);
        $this->chain->eventManager = resolve(RouterEventManager::class)->init($args);
    }

    /**
     * @param $method
     * @param $args
     *
     * @return array
     */
    private function getNormalizedArgs($method, $args): array
    {
        $normalizer = resolve(RouteNormalizer::class);
        if ($method == 'CallAction') {
            return $normalizer->normalizeAction($args);
        }
        if ($method == 'HitRouteName') {
            return $args;
        }

        $method = str_replace('VisitUrl', 'SendGet', $method);
        $method = str_replace('Send', '', $method);

        return $normalizer->normalizeUrl($args, strtoupper($method));
    }
}
