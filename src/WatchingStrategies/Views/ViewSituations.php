<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Views;

final class ViewSituations
{
    public function hasMethod($method)
    {
        return false;
    }

    /**
     * @param array|string $views
     */
    public function whenYouMakeView(...$views)
    {
        $view = resolve(ViewNormalizer::class)->normalizeView($views);
        resolve('heyman.chain')->init(ViewEventManager::class, $view);
    }
}
