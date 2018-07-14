<?php

namespace Imanghafoori\HeyMan\Hooks;

trait EloquentHooks
{
    public function whenFetching(...$model)
    {
        $model = $this->normalizeModel('retrieved', $model);
        return $this->authorize($model);
    }

    public function whenCreating(...$model)
    {
        $model = $this->normalizeModel('creating', $model);
        return $this->authorize($model);
    }

    public function whenUpdating(...$model)
    {
        $model = $this->normalizeModel('updating', $model);
        return $this->authorize($model);
    }

    public function whenSaving(...$model)
    {
        $model = $this->normalizeModel('saving', $model);
        return $this->authorize($model);
    }

    public function whenDeleting(...$model)
    {
        $model = $this->normalizeModel('deleting', $model);
        return $this->authorize($model);
    }
    /**
     * @param $target
     * @param $model
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