<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Views;

final class ViewSituations
{
    public function hasMethod()
    {
    }

    /**
     * @param array|string $views
     */
    public function whenYouMakeView(...$views)
    {
        $view = resolve(ViewNormalizer::class)->normalizeView($views);
        resolve('heyman.chains')->init(ViewEventListener::class, $view);
    }
}
