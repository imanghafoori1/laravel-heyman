<?php

namespace Imanghafoori\HeyMan\Hooks;

use Imanghafoori\HeyMan\EloquentConditionApplier;
use Imanghafoori\HeyMan\YouShouldHave;

trait EloquentHooks
{
    /**
     * @param mixed ...$model
     *
     * @return YouShouldHave
     */
    public function whenYouFetch(...$model)
    {
        $model = $this->normalizeInput($model);

        return $this->authorizeModel('retrieved', $model);
    }

    /**
     * @param mixed ...$model
     *
     * @return YouShouldHave
     */
    public function whenYouCreate(...$model)
    {
        $model = $this->normalizeInput($model);

        return $this->authorizeModel('creating', $model);
    }

    /**
     * @param mixed ...$model
     *
     * @return YouShouldHave
     */
    public function whenYouUpdate(...$model)
    {
        $model = $this->normalizeInput($model);

        return $this->authorizeModel('updating', $model);
    }

    /**
     * @param mixed ...$model
     *
     * @return YouShouldHave
     */
    public function whenYouSave(...$model)
    {
        $model = $this->normalizeInput($model);

        return $this->authorizeModel('saving', $model);
    }

    /**
     * @param mixed ...$model
     *
     * @return YouShouldHave
     */
    public function whenYouDelete(...$model)
    {
        $model = $this->normalizeInput($model);

        return $this->authorizeModel('deleting', $model);
    }

    private function authorizeModel($event, $modelClass)
    {
        $this->authorizer = app(EloquentConditionApplier::class)->init($event, $modelClass);

        return app(YouShouldHave::class);
    }
}
