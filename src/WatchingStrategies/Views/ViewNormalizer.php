<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Views;

final class ViewNormalizer
{
    /**
     * @param $views
     *
     * @return array
     */
    public function normalizeView(array $views): array
    {
        array_walk($views, function ($view) {
            $this->checkViewExists($view);
        });

        return $views;
    }

    private function checkViewExists($view)
    {
        if (strpos($view, '*') === false) {
            view()->getFinder()->find($view);
        }
    }
}
