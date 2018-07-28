<?php

namespace Imanghafoori\HeyMan\Hooks;

use Imanghafoori\HeyMan\WatchingStrategies\ViewEventManager;
use Imanghafoori\HeyMan\YouShouldHave;

trait ViewHooks
{
    /**
     * @param array|string $views
     *
     * @return \Imanghafoori\HeyMan\YouShouldHave
     */
    public function whenYouSeeViewFile(...$views)
    {
        $views = $this->normalizeView($views);

        return $this->watchView($views);
    }

    /**
     * @param array|string $views
     *
     * @return \Imanghafoori\HeyMan\YouShouldHave
     */
    public function whenYouMakeView(...$views)
    {
        return $this->whenYouSeeViewFile(...$views);
    }

    /**
     * @param $views
     *
     * @return array
     */
    private function normalizeView(array $views): array
    {
        $views = $this->normalizeInput($views);

        $mapper = function ($view) {
            $this->checkViewExists($view);
        };

        array_walk($views, $mapper);

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
