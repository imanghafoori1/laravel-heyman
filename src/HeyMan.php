<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Auth\Access\AuthorizationException;

class HeyMan
{
    private $urls = [];

    private $target;

    private $value = [];

    private $routeNames = [];

    private $actions = [];

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
        if (! is_array($this->value)) {
            $this->value = [$this->value];
        }

        foreach ($this->value as $value) {
            $this->{$this->target}[$value]['role'] = $role;
        }

        if($this->target == 'creating') {
            foreach ($this->creating as $model => $props) {
                $model::creating(function () use ($role) {
                    if (! auth()->user()->hasRole($role)) {
                        throw new AuthorizationException();
                    };
                });
            }
        }

        if ($this->target == 'updating') {
            foreach ($this->updating as $model => $props) {
                $model::updating(function () use ($role) {
                    if (! auth()->user()->hasRole($role)) {
                        throw new AuthorizationException();
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

}