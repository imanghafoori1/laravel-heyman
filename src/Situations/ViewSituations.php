<?php

namespace Imanghafoori\HeyMan\Situations;

use Imanghafoori\HeyMan\Normilizers\ViewNormalizer;
use Imanghafoori\HeyMan\WatchingStrategies\ViewEventManager;
use Imanghafoori\HeyMan\YouShouldHave;

class ViewSituations extends BaseSituation
{
    use ViewNormalizer;

    /**
     * @param array|string $views
     *
     * @return YouShouldHave
     */
    public function whenYouMakeView(...$views): YouShouldHave
    {
        return $this->watchView($this->normalizeView($views));
    }

    private function watchView($view): YouShouldHave
    {
        $this->chain->eventManager = app(ViewEventManager::class)->init($view);

        return app(YouShouldHave::class);
    }
}
