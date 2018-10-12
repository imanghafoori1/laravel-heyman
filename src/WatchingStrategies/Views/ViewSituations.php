<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Views;

use Imanghafoori\HeyMan\Situations\BaseSituation;

final class ViewSituations extends BaseSituation
{
    /**
     * @param array|string $views
     */
    public function whenYouMakeView(...$views)
    {
        $view = resolve(ViewNormalizer::class)->normalizeView($views);
        $this->setManager(ViewEventManager::class, $view);
    }
}
