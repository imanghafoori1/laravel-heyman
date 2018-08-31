<?php

namespace Imanghafoori\HeyMan\Situations;

use Imanghafoori\HeyMan\Normilizers\ViewNormalizer;
use Imanghafoori\HeyMan\WatchingStrategies\ViewEventManager;

class ViewSituations extends BaseSituation
{
    /**
     * @param array|string $views
     */
    public function whenYouMakeView(...$views)
    {
        $view = resolve(ViewNormalizer::class)->normalizeView($views);
        $this->chain->eventManager = resolve(ViewEventManager::class)->init($view);
    }
}
