<?php

namespace Imanghafoori\HeyMan\Situations;

use Imanghafoori\HeyMan\WatchingStrategies\EloquentEventsManager;
use Imanghafoori\HeyMan\YouShouldHave;

class EloquentSituations extends BaseSituation
{
    /**
     * @param mixed ...$model
     *
     * @return YouShouldHave
     */
    public function whenYouFetch(...$model)
    {
        return $this->watchModel('retrieved', $this->normalizeInput($model));
    }

    /**
     * @param mixed ...$model
     *
     * @return YouShouldHave
     */
    public function whenYouCreate(...$model)
    {
        return $this->watchModel('creating', $this->normalizeInput($model));
    }

    /**
     * @param mixed ...$model
     *
     * @return YouShouldHave
     */
    public function whenYouUpdate(...$model)
    {
        return $this->watchModel('updating', $this->normalizeInput($model));
    }

    /**
     * @param mixed ...$model
     *
     * @return YouShouldHave
     */
    public function whenYouSave(...$model)
    {
        return $this->watchModel('saving', $this->normalizeInput($model));
    }

    /**
     * @param mixed ...$model
     *
     * @return YouShouldHave
     */
    public function whenYouDelete(...$model)
    {
        return $this->watchModel('deleting', $this->normalizeInput($model));
    }

    private function watchModel($event, $modelClass)
    {
        $this->chain->eventManager = app(EloquentEventsManager::class)->init($modelClass, $event);

        return app(YouShouldHave::class);
    }
}
