<?php

namespace Imanghafoori\HeyMan;

class HeyMan
{
    /**
     * @var \Imanghafoori\HeyMan\ConditionApplier
     */
    private $authorizer;

    /**
     * HeyMan constructor.
     */
    public function __construct()
    {
        $this->authorizer = app('hey_man_authorizer');
    }

    public function whenVisitingUrl(...$url)
    {
        return $this->authorize('urls', $url);
    }

    public function whenVisitingRoute(...$routeName)
    {
        return $this->authorize('routeNames', $routeName);
    }

    public function whenCallingAction(...$action)
    {
        return $this->authorize('actions', $action);
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
     * @param $url
     * @return $this
     */
    private function authorize($target, $url): ConditionApplier
    {
        return $this->authorizer->init($target, $this->normalizeInput($url));
    }
}