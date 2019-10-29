<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Routes;

use Illuminate\Support\Str;

final class RouteActionNormalizer
{
    public function normalize($method, $args): array
    {
        return [$this->normalizeAction($args)];
    }

    /**
     * @param $actions
     *
     * @return array
     */
    public function normalizeAction($actions): array
    {
        $addNamespace = function ($action) {
            if (Str::startsWith($action, '\\')) {
                return $action;
            }

            return app()->getNamespace().'Http\\Controllers\\'.$action;
        };

        return array_map($addNamespace, $actions);
    }
}
