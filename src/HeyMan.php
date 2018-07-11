<?php

namespace Imanghafoori\HeyMan;

class HeyMan
{
    /**
     * @var \Imanghafoori\HeyMan\ConditionApplier
     */
    private $authorizer;
    /**
     * @var \Imanghafoori\HeyMan\RouteConditionApplier
     */
    private $routeAuthorizer;

    /**
     * HeyMan constructor.
     */
    public function __construct()
    {
        $this->authorizer = app('hey_man_authorizer');
        $this->routeAuthorizer = app('hey_man_route_authorizer');
    }

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
        return $this->authorize('creating', $model);
    }

    public function whenUpdatingModel(...$model)
    {
        $model = $this->normalizeModel('updating', $model);
        return $this->authorize('updating', $model);
    }

    public function whenSavingModel(...$model)
    {
        $model = $this->normalizeModel('saving', $model);
        return $this->authorize('saving', $model);
    }

    public function whenDeletingModel(...$model)
    {
        $model = $this->normalizeModel('deleting', $model);
        return $this->authorize('deleting', $model);
    }

    public function whenYouSeeViewFile(...$view)
    {
        $view = $this->normalizeView($view);
        return $this->authorize('views', $view);
    }

    public function whenEventHappens(...$event)
    {
        return $this->authorize('events', $this->normalizeInput($event));
    }

    /**
     * @param $url
     * @return array
     */
    private function normalizeInput($url): array
    {
        return is_array($url[0]) ? $url[0] : $url;
    }

    /**
     * @param $value
     * @return $this
     */
    private function authorize($target, $value): YouShouldHave
    {
        $authorizer = $this->authorizer->init($target, $value);
        return new YouShouldHave($authorizer);
    }

    private function authorizeRoute($target, $value)
    {
        $routeAuthorizer = $this->routeAuthorizer->init($target, $this->normalizeInput($value));
        return new YouShouldHave($routeAuthorizer);
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