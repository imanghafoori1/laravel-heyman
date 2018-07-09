<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;

class HeyMan
{
    private $urls = [];

    private $target;

    private $value = [];

    private $routeNames = [];

    private $actions = [];

    private $views = [];

    private $events = [];

    public function whenVisitingUrl(...$url)
    {
        $this->setValue($url);

        $this->target = 'urls';

        return $this;
    }

    public function whenVisitingRoute(...$routeName)
    {
        $this->setValue($routeName);

        $this->target = 'routeNames';

        return $this;
    }

    public function getUrls()
    {
        return $this->urls;
    }

    public function youShouldHaveRole($role)
    {
        $predicate = function () use ($role) {
            return ! auth()->user()->hasRole($role);
        };

        if (! is_array($this->value)) {
            $this->value = [$this->value];
        }

        foreach ($this->value as $value) {
            $this->{$this->target}[$value]['role'] = $role;
        }

        $this->addListenersForEloquent($predicate);

        $this->addListenerForViews($predicate);

        $this->addListenersForEvents($predicate);

        $this->value = [];

        return $this;
    }

    public function beCareful()
    {

    }

    private function denyAccess()
    {
        throw new AuthorizationException();
    }

    public function getRouteNames()
    {
        return $this->routeNames;
    }

    public function whenCallingAction(...$action)
    {
        $this->setValue($action);

        $this->target = 'actions';

        return $this;
    }

    public function getActions()
    {
        return $this->actions;
    }

    public function whenCreatingModel(...$model)
    {
        $this->setValue($model);

        $this->target = 'creating';

        return $this;
    }

    public function whenUpdatingModel(...$model)
    {
        $this->setValue($model);

        $this->target = 'updating';

        return $this;
    }

    public function whenSavingModel(...$model)
    {
        $this->setValue($model);

        $this->target = 'saving';

        return $this;
    }

    public function whenDeletingModel(...$model)
    {
        $this->setValue($model);

        $this->target = 'deleting';

        return $this;
    }

    public function whenYouSeeViewFile(...$view)
    {
        $this->setValue($view);

        $this->target = 'views';

        return $this;
    }

    public function whenEventHappens(...$event)
    {
        $this->setValue($event);

        $this->target = 'events';

        return $this;
    }

    public function getEvents()
    {
        return $this->events;
    }

    public function youShouldPassGate($gate, ...$args)
    {
        $predicate = function () use ($gate, $args) {
            return Gate::denies($gate, $args);
        };

        if (! is_array($this->value)) {
            $this->value = [$this->value];
        }
        foreach ($this->value as $value) {
            $this->{$this->target}[$value]['role'] = $gate;
        }

        $this->addListenersForEvents($predicate);

        $this->addListenerForViews($predicate);

        $this->addListenersForEloquent($predicate);

        $this->value = [];

        return $this;
    }

    /**
     * @param $predicate
     */
    private function addListenersForEloquent($predicate)
    {
        foreach (['creating', 'updating', 'saving', 'deleting'] as $action) {
            if ($this->target !== $action) {
                continue;
            }
            foreach ($this->{$action} as $model => $props) {
                $model::{$action}(function () use ($predicate) {
                    if ($predicate()) {
                        $this->denyAccess();
                    }
                });
            }
        }
    }

    /**
     * @param $predicate
     */
    private function addListenerForViews($predicate)
    {
        if ($this->target !== 'views') {
            return ;
        }
        foreach ($this->views as $view => $props) {
            Event::listen('creating: '.$view, function () use ($predicate) {
                if ($predicate()) {
                    $this->denyAccess();
                };
            });
        }
    }

    /**
     * @param $predicate
     */
    private function addListenersForEvents($predicate)
    {
        if ($this->target !== 'events') {
            return ;
        }
        foreach ($this->events as $event => $props) {
            Event::listen($event, function () use ($predicate) {
                if ($predicate()) {
                    $this->denyAccess();
                };
            });
        }
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