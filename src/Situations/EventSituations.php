<?php

namespace Imanghafoori\HeyMan\Situations;

use Imanghafoori\HeyMan\WatchingStrategies\EventManager;
use Imanghafoori\HeyMan\YouShouldHave;

class EventSituations extends BaseSituation
{
    /**
     * @param mixed ...$event
     *
     * @return YouShouldHave
     */
    public function whenEventHappens(...$event): YouShouldHave
    {
        return $this->watchEvents($this->normalizeInput($event));
    }

    /**
     * @param $eventName
     *
     * @return YouShouldHave
     */
    private function watchEvents($eventName): YouShouldHave
    {
        $this->chain->eventManager = app(EventManager::class)->init($eventName);

        return app(YouShouldHave::class);
    }
}
