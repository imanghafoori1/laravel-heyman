<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Routes;

final class RouteSituations
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

    /**
     * @param $method
     * @param $args
     *
     * @return array
     */
    public function normalize($method, $args): array
    {
        $normalizer = resolve(RouteNormalizer::class);
        $method = str_replace('whenYou', '', $method);
        if ($method == 'CallAction') {
            return [$normalizer->normalizeAction($args)];
        }
        if ($method == 'HitRouteName') {
            return [$args];
        }

        $method = str_replace('VisitUrl', 'SendGet', $method);
        $method = str_replace('Send', '', $method);

        return [$normalizer->normalizeUrl($args, strtoupper($method))];
    }
}
