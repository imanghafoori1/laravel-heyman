<?php

namespace Imanghafoori\HeyMan;

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
}