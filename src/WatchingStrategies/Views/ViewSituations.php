<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Views;

final class ViewSituations
{
    public function hasMethod($method)
    {
        return in_array($method, [
            'whenYouMakeView'
        ]);
    }

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
