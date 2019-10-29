<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Routes;

final class RouteNameNormalizer
{
    /**
     * @param $method
     * @param $args
     *
     * @return array
     */
    public function normalize($method, $args): array
    {
        return [$args];
    }
}
