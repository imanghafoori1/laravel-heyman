<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\Routes;

final class RouteUrlsNormalizer
{
    public function normalize($method, $args)
    {
        $method = str_replace('VisitUrl', 'SendGet', $method);
        $method = str_replace('whenYouSend', '', $method);

        return [$this->normalizeUrl($args, strtoupper($method))];
    }

    private function normalizeUrl($urls, $verb = 'GET')
    {
        $removeSlash = function ($url) use ($verb) {
            return $verb.ltrim($url, '/');
        };

        return array_map($removeSlash, $urls);
    }
}
