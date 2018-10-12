<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Routes;

final class RouteNormalizer
{
    /**
     * @param $actions
     *
     * @return array
     */
    public function normalizeAction($actions): array
    {
        $addNamespace = function ($action) {
            if ($action = ltrim($action, '\\')) {
                return $action;
            }

            return app()->getNamespace().'\\Http\\Controllers\\'.$action;
        };

        return array_map($addNamespace, $actions);
    }

    /**
     * @param $urls
     * @param $verb
     *
     * @return array
     */
    public function normalizeUrl($urls, $verb = 'GET'): array
    {
        $removeSlash = function ($url) use ($verb) {
            return $verb.ltrim($url, '/');
        };

        return array_map($removeSlash, $urls);
    }

    public function normalizeRoute($r)
    {
        return $r;
    }
}
