<?php

namespace Imanghafoori\HeyMan;

class HeyMan
{
    /**
     * @var \Imanghafoori\HeyMan\ConditionApplier
     */
    public $authorizer;

    public function whenVisitingUrl(...$url)
    {
        return $this->authorizeRoute('urls', $url);
    }

    public function whenVisitingRoute(...$routeName)
    {
        return $this->authorizeRoute('routeNames', $routeName);
    }

    public function whenCallingAction(...$action)
    {
        return $this->authorizeRoute('actions', $action);
    }

    public function whenCreatingModel(...$model)
    {
        $model = $this->normalizeModel('creating', $model);
        return $this->authorize($model);
    }

    public function whenUpdatingModel(...$model)
    {
        $model = $this->normalizeModel('updating', $model);
        return $this->authorize($model);
    }

    public function whenSavingModel(...$model)
    {
        $model = $this->normalizeModel('saving', $model);
        return $this->authorize($model);
    }

    public function whenDeletingModel(...$model)
    {
        $model = $this->normalizeModel('deleting', $model);
        return $this->authorize($model);
    }

    public function whenYouSeeViewFile(...$view)
    {
        $view = $this->normalizeView($view);
        return $this->authorize($view);
    }

    public function whenEventHappens(...$event)
    {
        return $this->authorize($this->normalizeInput($event));
    }

    /**
     * @param $url
     * @return array
     */
    private function normalizeInput(array $url): array
    {
        return is_array($url[0]) ? $url[0] : $url;
    }

    /**
     * @param $value
     */
    private function authorize($value): YouShouldHave
    {
        $this->authorizer = app('hey_man_authorizer')->init($value);
        return app('hey_man_you_should_have');
    }

    private function authorizeRoute($target, $value)
    {
        $this->authorizer = app('hey_man_route_authorizer')->init($target, $this->normalizeInput($value));
        return app('hey_man_you_should_have');
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

    /**
     * @param $views
     * @return array
     */
    private function normalizeView(array $views): array
    {
        $views = $this->normalizeInput($views);
        $mapper = function ($view) {
            return 'creating: '.$view;
        };

        return array_map($mapper, $views);
    }
}