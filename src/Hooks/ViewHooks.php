<?php

namespace Imanghafoori\HeyMan\Hooks;

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

        return $this->authorize($views);
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

            return 'creating: '.\Illuminate\View\ViewName::normalize($view);
        };

        return array_map($mapper, $views);
    }

    private function checkViewExists($view)
    {
        if (strpos($view, '*') === false) {
            view()->getFinder()->find($view);
        }
    }
}
