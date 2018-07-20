<?php

namespace Imanghafoori\HeyMan\Hooks;

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
        $model = $this->normalizeModel('retrieved', $model);

        return $this->authorize($model);
    }

    /**
     * @param mixed ...$model
     *
     * @return YouShouldHave
     */
    public function whenYouCreate(...$model)
    {
        $model = $this->normalizeModel('creating', $model);

        return $this->authorize($model);
    }

    /**
     * @param mixed ...$model
     *
     * @return YouShouldHave
     */
    public function whenYouUpdate(...$model)
    {
        $model = $this->normalizeModel('updating', $model);

        return $this->authorize($model);
    }

    /**
     * @param mixed ...$model
     *
     * @return YouShouldHave
     */
    public function whenYouSave(...$model)
    {
        $model = $this->normalizeModel('saving', $model);

        return $this->authorize($model);
    }

    /**
     * @param mixed ...$model
     *
     * @return YouShouldHave
     */
    public function whenYouDelete(...$model)
    {
        $model = $this->normalizeModel('deleting', $model);

        return $this->authorize($model);
    }

    /**
     * @param $target
     * @param $model
     *
     * @return array
     */
    private function normalizeModel($target, array $model): array
    {
        $model = $this->normalizeInput($model);
        $mapper = function ($model) use ($target) {
            return "eloquent.{$target}: {$model}";
        };

        return array_map($mapper, $model);
    }
}
