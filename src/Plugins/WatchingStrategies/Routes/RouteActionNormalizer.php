<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\Routes;

use Illuminate\Support\Str;

final class RouteActionNormalizer
{
    public function normalize($method, $args)
    {
        return [$this->normalizeAction($args)];
    }

    public function normalizeAction($actions)
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
