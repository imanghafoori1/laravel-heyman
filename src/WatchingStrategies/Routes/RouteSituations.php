<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Routes;

final class RouteSituations
{
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
