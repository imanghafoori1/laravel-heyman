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
        return $this->authorizer->init('urls', $this->normalizeInput($url));
    }

    public function whenVisitingRoute(...$routeName)
    {
        return ($this->authorizer->init('routeNames', $this->normalizeInput($routeName)));
    }

    public function whenCallingAction(...$action)
    {
        return $this->authorizer->init('actions', $this->normalizeInput($action));
    }

    public function whenCreatingModel(...$model)
    {
        return $this->authorizer->init('creating', $this->normalizeInput($model));
    }

    public function whenUpdatingModel(...$model)
    {
        return $this->authorizer->init('updating', $this->normalizeInput($model));
    }

    public function whenSavingModel(...$model)
    {
        return $this->authorizer->init('saving', $this->normalizeInput($model));
    }

    public function whenDeletingModel(...$model)
    {
        return $this->authorizer->init('deleting', $this->normalizeInput($model));
    }

    public function whenYouSeeViewFile(...$view)
    {
        return $this->authorizer->init('views', $this->normalizeInput($view));
    }

    public function whenEventHappens(...$event)
    {
        return $this->authorizer->init('events', $this->normalizeInput($event));
    }

    /**
     * @param $url
     * @return array
     */
    private function normalizeInput($url): array
    {
        return is_array($url[0]) ? $url[0] : $url;
    }
}