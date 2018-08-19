<?php

namespace Imanghafoori\HeyMan\Situations;

use Imanghafoori\HeyMan\Normilizers\InputNormalizer;
use Imanghafoori\HeyMan\WatchingStrategies\ViewEventManager;
use Imanghafoori\HeyMan\YouShouldHave;

class ViewSituations
{
    use InputNormalizer;
    /**
     * @param array|string $views
     *
     * @return YouShouldHave
     */
    public function whenYouMakeView(...$views): YouShouldHave
    {
        return $this->watchView($this->normalizeView($views));
    }

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

    private function watchView($view): YouShouldHave
    {
        $this->chain->eventManager = app(ViewEventManager::class)->init($view);

        return app(YouShouldHave::class);
    }
}