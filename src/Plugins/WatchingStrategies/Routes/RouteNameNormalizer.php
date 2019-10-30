<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\Routes;

final class RouteNameNormalizer
{
    public function normalize($method, $args)
    {
        return [$args];
    }
}
