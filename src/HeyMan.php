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

    private $shouldHaveRole;

    /**
     * HeyMan constructor.
     */
    public function __construct()
    {
        $this->authorizer = app('hey_man_authorizer');
        $this->routeAuthorizer = app('hey_man_route_authorizer');
        $this->shouldHaveRole = app('hey_man_should_have_role');
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
        return $this->authorize('creating', $model);
    }

    public function whenUpdatingModel(...$model)
    {
        return $this->authorize('updating', $model);
    }

    public function whenSavingModel(...$model)
    {
        return $this->authorize('saving', $model);
    }

    public function whenDeletingModel(...$model)
    {
        return $this->authorize('deleting', $model);
    }

    public function whenYouSeeViewFile(...$view)
    {
        return $this->authorize('views', $view);
    }

    public function whenEventHappens(...$event)
    {
        return $this->authorize('events', $event);
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
    private function authorize($target, $value): ConditionApplier
    {
        return $this->authorizer->init($target, $this->normalizeInput($value));
    }

    private function authorizeRoute($target, $value)
    {
        $this->routeAuthorizer->init($target, $this->normalizeInput($value));
        return app('hey_man_should_have_role');
    }
}