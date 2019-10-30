<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\Views;

final class ViewSituations
{
    public function normalize($method, $params)
    {
        array_walk($params, function ($view) {
            $this->checkViewExists($view);
        });

        return [$params];
    }

    private function checkViewExists($view)
    {
        if (strpos($view, '*') === false) {
            view()->getFinder()->find($view);
        }
    }
}
