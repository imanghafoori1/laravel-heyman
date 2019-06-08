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
