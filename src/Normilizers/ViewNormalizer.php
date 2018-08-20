<?php

namespace Imanghafoori\HeyMan\Normilizers;

trait ViewNormalizer
{
    use InputNormalizer;

    /**
     * @param $views
     *
     * @return array
     */
    private function normalizeView(array $views): array
    {
        $views = $this->normalizeInput($views);

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
