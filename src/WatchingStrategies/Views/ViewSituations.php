<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Views;

final class ViewSituations
{
    /**
     * @param $params
     *
     * @return mixed
     */
    public function normalize($method, $params)
    {
        return resolve(ViewNormalizer::class)->normalizeView($params);
    }
}
