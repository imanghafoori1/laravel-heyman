<?php

namespace Imanghafoori\HeyMan\Hooks;

trait ViewHooks
{
    /**
     * @param array|string $views
     * @return \Imanghafoori\HeyMan\YouShouldHave
     */
    public function whenYouSeeViewFile(...$views)
    {
        $views = $this->normalizeView($views);
        return $this->authorize($views);
    }

    /**
     * @param array|string $views
     * @return \Imanghafoori\HeyMan\YouShouldHave
     */
    public function whenYouViewBlade(...$views)
    {
        return $this->whenYouSeeViewFile(...$views);
    }

    /**
     * @param $views
     * @return array
     */
    private function normalizeView(array $views): array
    {
        $views = $this->normalizeInput($views);
        $mapper = function ($view) {
            return 'creating: '.$view;
        };

        return array_map($mapper, $views);
    }
}