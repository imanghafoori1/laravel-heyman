<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Routes;

final class RouteUrlsNormalizer
{
    public function normalize($method, $args): array
    {
        $method = str_replace('VisitUrl', 'SendGet', $method);
        $method = str_replace('whenYouSend', '', $method);

        return [$this->normalizeUrl($args, strtoupper($method))];
    }

    /**
     * @param $urls
     * @param $verb
     *
     * @return array
     */
    private function normalizeUrl($urls, $verb = 'GET'): array
    {
        $removeSlash = function ($url) use ($verb) {
            return $verb.ltrim($url, '/');
        };

        return array_map($removeSlash, $urls);
    }

}
