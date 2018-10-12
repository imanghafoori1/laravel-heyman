<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Routes;

use Imanghafoori\HeyMan\Situations\BaseSituation;

final class RouteSituations extends BaseSituation
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
        $args = $this->getNormalizedArgs($method, $args);
        $this->setManager(RouterEventManager::class, $args);
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
        $method = str_replace('whenYou', '', $method);
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
