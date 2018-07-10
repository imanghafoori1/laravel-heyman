<?php

namespace Imanghafoori\HeyMan;

class HeyMan
{
    private $target;

    private $value = [];

    private $events = [];

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
        $this->setValue($url);

        $this->target = 'urls';
        $t = $this->value;
        $this->value = [];
        return $this->authorizer->init('urls', $t);
    }

    public function whenVisitingRoute(...$routeName)
    {
        $this->setValue($routeName);

        $this->target = 'routeNames';
        $t = $this->value;
        $this->value = [];
        return ($this->authorizer->init('routeNames', $t));
    }

    public function whenCallingAction(...$action)
    {
        $this->setValue($action);

        $this->target = 'actions';
        $t = $this->value;
        $this->value = [];
        return $this->authorizer->init('actions', $t);
    }

    public function whenCreatingModel(...$model)
    {
        $this->setValue($model);

        $this->target = 'creating';

        return $this->authorizer->init('creating', $this->value);
    }

    public function whenUpdatingModel(...$model)
    {
        $this->setValue($model);

        $this->target = 'updating';

        return $this->authorizer->init('updating', $this->value);
    }

    public function whenSavingModel(...$model)
    {
        $this->setValue($model);

        $this->target = 'saving';

        return $this->authorizer->init('saving', $this->value);
    }

    public function whenDeletingModel(...$model)
    {
        $this->setValue($model);

        $this->target = 'deleting';

        return $this->authorizer->init('deleting', $this->value);
    }

    public function whenYouSeeViewFile(...$view)
    {
        $this->setValue($view);

        $this->target = 'views';

        return $this->authorizer->init('views', $this->value);
    }

    public function whenEventHappens(...$event)
    {
        $this->setValue($event);

        $this->target = 'events';

        return $this->authorizer->init('events', $this->value);
    }

    public function getEvents()
    {
        return $this->events;
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
     * @param $model
     */
    private function setValue($model)
    {
        $model = $this->normalizeInput($model);
        $this->value = array_merge($this->value, $model);
    }
}