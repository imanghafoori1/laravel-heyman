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

    private $creating = [];

    private $updating = [];

    private $views = [];

    private $events = [];

    public function whenVisitingUrl($url)
    {
        if (func_num_args() > 1) {
            $url = func_get_args();
        } else {
            if (! is_array($url)) {
                $url = [$url];
            }
        }

        $this->value = array_merge($this->value, $url);

        $this->target = 'urls';

        return $this;
    }

    public function whenVisitingRoute($routeName)
    {
        $this->value = $routeName;
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

        if ($this->target == 'events') {
            foreach ($this->events as $event => $props) {
                Event::listen($event, function () use ($predicate) {
                    if ($predicate()) {
                        $this->denyAccess();
                    };
                });
            }
        }

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

    public function whenCallingAction($action)
    {
        $this->value = $action;

        $this->target = 'actions';

        return $this;
    }

    public function getActions()
    {
        return $this->actions;
    }

    public function whenCreatingModel($model)
    {
        if (func_num_args() > 1) {
            $model = func_get_args();
        } else {
            if (! is_array($model)) {
                $model = [$model];
            }
        }

        $this->value = array_merge($this->value, $model);

        $this->target = 'creating';

        return $this;
    }

    public function whenUpdatingModel($model)
    {
        if (func_num_args() > 1) {
            $model = func_get_args();
        } else {
            if (! is_array($model)) {
                $model = [$model];
            }
        }

        $this->value = array_merge($this->value, $model);

        $this->target = 'updating';

        return $this;
    }

    public function whenSavingModel($model)
    {
        if (func_num_args() > 1) {
            $model = func_get_args();
        } else {
            if (! is_array($model)) {
                $model = [$model];
            }
        }

        $this->value = array_merge($this->value, $model);

        $this->target = 'saving';

        return $this;
    }

    public function whenDeletingModel($model)
    {
        if (func_num_args() > 1) {
            $model = func_get_args();
        } else {
            if (! is_array($model)) {
                $model = [$model];
            }
        }

        $this->value = array_merge($this->value, $model);

        $this->target = 'deleting';

        return $this;
    }

    public function whenYouSeeViewFile($view)
    {
        if (func_num_args() > 1) {
            $view = func_get_args();
        } else {
            if (! is_array($view)) {
                $view = [$view];
            }
        }

        $this->value = array_merge($this->value, $view);

        $this->target = 'views';

        return $this;
    }

    public function whenEventHappens($event)
    {
        if (func_num_args() > 1) {
            $event = func_get_args();
        } else {
            if (! is_array($event)) {
                $event = [$event];
            }
        }

        $this->value = array_merge($this->value, $event);

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

        if ($this->target == 'events') {
            foreach ($this->events as $event => $props) {
                Event::listen($event, function () use ($predicate) {
                    if ($predicate()) {
                        $this->denyAccess();
                    };
                });
            }
        }

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
        if ($this->target == 'views') {
            foreach ($this->views as $view => $props) {
                Event::listen('creating: '.$view, function () use ($predicate) {
                    if ($predicate()) {
                        $this->denyAccess();
                    };
                });
            }
        }
    }
}